<?php
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

class mqttLinky extends eqLogic {
  /* GLOBALES */
  
  /* Handle MQTT */
  public static function handleMqttMessage($_message) {
    $HISTORIC_KEYS = array('ADCO','OPTARIF','ISOUSC','BASE','HCHC','HCHP','EJPHN','EJPHPM','BBRHCJB','BBRHPJB','BBRHCJW','BBRHPJW','BBRHCJR','BBRHPJR',
      'IINST','IINST1','IINST2','IINST3','ADPS','ADIR1','ADIR2','ADIR3','IMAX','IMAX1','IMAX2','IMAX3','PAPP','HHPHC','PMAX','MOTDETAT','PPOT1','PPOT2','PPOT3');

    if (isset($_message[config::byKey('mqtt::topic', __CLASS__, 'linky')])) {
      $message = $_message[config::byKey('mqtt::topic', __CLASS__, 'linky')];
    } else {
      log::add(__CLASS__, 'debug', '[' . __FUNCTION__ . '] ' . __('Le message reçu n\'est pas un message mqttLinky', __FILE__));
      return;
    }
    // Parcours des messages
    foreach( $message as $_key => $_values) {
      // Key connected ignored
      if ( $_key == 'connected' ) {
        continue;
      }
      // Nouveau Compteur ?
      $eqLogic = self::byLogicalId($_key, __CLASS__);
      // Création si besoin
      if (!is_object($eqLogic)) {
        $eqLogic = new mqttLinky();
        $eqLogic->setEqType_name(__CLASS__);
        $eqLogic->setLogicalId($_key);
        $eqLogic->setName($_key);
        $eqLogic->setIsEnable(1);
        $eqLogic->setIsVisible(0);
        if (in_array(array_key_first($_values), $HISTORIC_KEYS)) {
          $eqLogic->setConfiguration('tictype', 'historic');
        } else {
          $eqLogic->setConfiguration('tictype', 'standard');
        }
        $eqLogic->save();
      }
      // Formattage TOPIC => VALUE
      $datas = implode_recursive($_values, '/');
      // On parcours
      foreach( $datas as $_topic => $_value) {
        log::add(__CLASS__, 'debug', '[' . __FUNCTION__ . '] ' . $_topic . ' : ' . $_value);
        // Commande Existante ?
        $cmd = $eqLogic->getCmd('info', $_topic);
        if (!is_object($cmd)) {
          log::add(__CLASS__, 'debug', __('Commande ', __FILE__) . $_topic . __(' inconnue dans l\'equipement ', __FILE__) . $_key);
          continue;
        }
        // Mise à jour
        $eqLogic->checkAndUpdateCmd($_topic, $_value);
      }
    }
  }

  /* Dependencies */
  public static function dependancy_info() {
    $return = array();
    $return['log'] = log::getPathToLog(__CLASS__ . '_update');
    $return['progress_file'] = jeedom::getTmpFolder(__CLASS__) . '/dependance';
    $return['state'] = 'ok';

    if (file_exists(jeedom::getTmpFolder(__CLASS__) . '/dependence')) {
      $return['state'] = 'in_progress';
    } else {
      if (config::byKey('lastDependancyInstallTime', __CLASS__) == '') {
        $return['state'] = 'nok';
      } else if (!file_exists(__DIR__ . '/../../resources/node_modules/')) {
        $return['state'] = 'nok';
      } else if (!file_exists(__DIR__ . '/../../resources/node_modules/mqtt4teleinfo/index.js')) {
        $return['state'] = 'nok';
      } else if (config::byKey('mqttLinkyRequire', __CLASS__) != config::byKey('mqttLinkyVersion', __CLASS__)) {
        $return['state'] = 'nok';
      }
    }
    return $return;
  }

  /* Deamon */
  public static function deamon_start() {
    self::deamon_stop();
    $deamon_info = self::deamon_info();
    if ($deamon_info['launchable'] != 'ok') {
      throw new Exception(__('Veuillez vérifier la configuration', __FILE__));
    }
    /* Nettoyage anciens Topic MQTT */
    mqtt2::removePluginTopicByPlugin(__CLASS__);
    /* On enregistre le topic actuel */
    mqtt2::addPluginTopic(__CLASS__, config::byKey('mqtt::topic', __CLASS__, 'linky'));
    $mqttInfos = mqtt2::getFormatedInfos();
    log::add(__CLASS__, 'debug', '[' . __FUNCTION__ . '] ' . __('Informations reçues de MQTT Manager', __FILE__) . ' : ' . json_encode($mqttInfos));
    $mqtt_url = ($mqttInfos['port'] === 1883) ? 'mqtts://' : 'mqtt://';
    $mqtt_url .= ($mqttInfos['password'] === null) ? '' : $mqttInfos['user'].':'.$mqttInfos['password'].'@';
    $mqtt_url .= $mqttInfos['ip'].':'.$mqttInfos['port'];

    $port = jeedom::getUsbMapping(config::byKey('mqttLinky::port', __CLASS__));
    $appjs_path = realpath(dirname(__FILE__) . '/../../resources/node_modules/mqtt4teleinfo');
    chdir($appjs_path);
    $cmd = ' /usr/bin/node ' . $appjs_path . '/index.js -z';
    $cmd .= ' -t '.config::byKey('mqtt::topic', __CLASS__, 'linky');
    $cmd .= ' -a '.$port;
    $cmd .= ' -b '.config::byKey('mqttLinky::type', __CLASS__, 'historic');
    $cmd .= ' -u '.$mqtt_url;
    $cmd .= ' -v '.log::convertLogLevel(log::getLogLevel(__CLASS__));
    log::add(__CLASS__, 'info', __('Démarrage du démon mqttLinky', __FILE__) . ' : ' . $cmd);
    exec(system::getCmdSudo() . $cmd . ' >> ' . log::getPathToLog('mqttLinkyd') . ' 2>&1 &');
    $i = 0;
    while ($i < 30) {
      $deamon_info = self::deamon_info();
      if ($deamon_info['state'] == 'ok') {
        break;
      }
      sleep(1);
      $i++;
    }
    if ($i >= 30) {
      mqtt2::removePluginTopic(config::byKey('mqtt::topic', __CLASS__, 'linky'));
      log::add(__CLASS__, 'error', __('Impossible de démarrer le démon mqttLinky, consultez les logs', __FILE__), 'unableStartDeamon');
      return false;
    }
    message::removeAll(__CLASS__, 'unableStartDeamon');
    return true;
  }

  public static function deamon_stop() {
    log::add(__CLASS__, 'info', __('Arrêt du démon mqttLinky', __FILE__));
    $find = 'mqtt4teleinfo/index.js';
    $cmd = "(ps ax || ps w) | grep -ie '" . $find . "' | grep -v grep | awk '{print $1}' | xargs " . system::getCmdSudo() . "kill -15 > /dev/null 2>&1";
    exec($cmd);
    $i = 0;
    while ($i < 5) {
      $deamon_info = self::deamon_info();
      if ($deamon_info['state'] == 'nok') {
        break;
      }
      sleep(1);
      $i++;
    }
    if ($i >= 5) {
      system::kill($find, true);
      $i = 0;
      while ($i < 5) {
        $deamon_info = self::deamon_info();
        if ($deamon_info['state'] == 'nok') {
          break;
        }
        sleep(1);
        $i++;
      }
    }
    mqtt2::removePluginTopic(config::byKey('mqtt::topic', __CLASS__, 'linky'));
    sleep(1);
  }

  public static function deamon_info() {
    $return = array();
    $return['log'] = __CLASS__;
    $return['launchable'] = 'ok';
    $return['state'] = 'nok';
    if (self::isRunning()) {
      $return['state'] = 'ok';
    }
    $port = jeedom::getUsbMapping(config::byKey('mqttLinky::port', __CLASS__));
    if (@!file_exists($port)) {
      $return['launchable'] = 'nok';
      $return['launchable_message'] = __('Le port n\'est pas configuré', __FILE__);
    }
    if (!class_exists('mqtt2')) {
      $return['launchable'] = 'nok';
      $return['launchable_message'] = __('Le plugin MQTT Manager n\'est pas installé', __FILE__);
    } else {
      if (mqtt2::deamon_info()['state'] != 'ok') {
        $return['launchable'] = 'nok';
        $return['launchable_message'] = __('Le démon MQTT Manager n\'est pas démarré', __FILE__);
      }
    }
    // Dépendances
    if (self::dependancy_info()['state'] == 'nok') {
      $return['launchable'] = 'nok';
      $return['launchable_message'] = __('Dépendances non installées.', __FILE__);
    }
    return $return;
  }

  public static function isRunning() {
    if (!empty(system::ps('mqtt4teleinfo/index.js'))) {
      return true;
    }
    return false;
  }

  /* PRE & POST evenements */
  public static function postConfig_mqttLinky_mode($_value) {
    log::add(__CLASS__, 'info', __('Changement de mode', __FILE__) . ' ' . $_value);
    $plugin = plugin::byId(__CLASS__);
    if ($_value == 'local') {
      $plugin->dependancy_changeAutoMode(1);
      $plugin->deamon_changeAutoMode(1);
      $plugin->deamon_info(1);
      mqtt2::removePluginTopic(config::byKey('mqtt::topic', __CLASS__, 'linky'));
    } else {
      $plugin->dependancy_changeAutoMode(0);
      $plugin->deamon_changeAutoMode(0);
      $plugin->deamon_info(0);
      mqtt2::addPluginTopic(__CLASS__, config::byKey('mqtt::topic', __CLASS__, 'linky'));
    }
  }

  public static function dependancy_end() {
    config::save('mqttLinkyVersion', config::byKey('mqttLinkyRequire', __CLASS__), __CLASS__);
  }
}

class mqttLinkyCmd extends cmd {

  public function preSave() {
    log::add('mqttLinky', 'info', __('Configuration d\'une commande', __FILE__));
    switch ($this->getLogicalId()) {
      /* INDEX */
      case "BASE":
      case "HCHP":
      case "HCHC":
      case "EJPHN":
      case "EJPHPM":
      case "BBRHCJB":
      case "BBRHPJB":
      case "BBRHCJW":
      case "BBRHPJW":
      case "BBRHCJR":
      case "BBRHPJR":
      case "EAST":
      case "EASF01":
      case "EASF02":
      case "EASF03":
      case "EASF04":
      case "EASF05":
      case "EASF06":
      case "EASF07":
      case "EASF08":
      case "EASF09":
      case "EASF10":
      case "EASD01":
      case "EASD02":
      case "EASD03":
      case "EASD04":
      case "EAIT":
        log::add('mqttLinky', 'debug', __('Champ d\'index', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('Wh');
        $this->setGeneric_type('CONSUMPTION');
        $this->setConfiguration('historizeRound', '0');
        $this->setConfiguration('historizeMode', 'none');
        break;
      /* Puissance Ampère */
      case "IINST":
      case "IINST1":
      case "IINST2":
      case "IINST3":
      case "IRMS":
      case "IRMS1":
      case "IRMS2":
      case "IRMS3":
        log::add('mqttLinky', 'debug', __('Champ de puissance en Ampère', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('A');
        $this->setGeneric_type('POWER');
        $this->setConfiguration('historizeMode', 'avg');
        break;
      /* Puissance Apparente VA */
      case "PAPP":
      case "SINSTS":
      case "SINSTS1":
      case "SINSTS2":
      case "SINSTS3":
      case "SINSTI":
        log::add('mqttLinky', 'debug', __('Champ de puissance apparente VA', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('VA');
        $this->setGeneric_type('POWER');
        $this->setConfiguration('historizeMode', 'avg');
        break;
      /* Puissance calculée WATT */
      case "PRMS":
        case "PRMS1":
        case "PRMS2":
        case "PRMS3":
          log::add('mqttLinky', 'debug', __('Champ de puissance calculée en W', __FILE__));
          $this->setSubType('numeric');
          $this->setUnite('W');
          $this->setGeneric_type('POWER');
          $this->setConfiguration('historizeMode', 'avg');
          break;
      /* Champs d'informations en VOLT */
      case "URMS1":
      case "UMOY1":
      case "URMS2":
      case "URMS3":
      case "UMOY2":
      case "UMOY3":
        log::add('mqttLinky', 'debug', __('Champ tension en Volt', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('V');
        $this->setGeneric_type('VOLTAGE');
        break;
      /* Champs d'informations en W */
      case "PMAX":
      case "CCASN":
      case "CCASN-1":
      case "CCAIN":
      case "CCAIN-1":
        log::add('mqttLinky', 'debug', __('Champ information en W', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('W');
        break;
      /* Champs d'informations en VArh */
      case "ERQ1":
      case "ERQ2":
      case "ERQ3":
      case "ERQ4":
        log::add('mqttLinky', 'debug', __('Champ information en VArh', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('VArh');
        break;
      /* Preavis EJP */
      case "PEJP":
        log::add('mqttLinky', 'debug', __('Champ minute', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('min');
        $this->setGeneric_type('GENERIC_INFO');
        break;
      /* Champs d'informations Binaires */
      case "RELAIS01":
      case "RELAIS02":
      case "RELAIS03":
      case "RELAIS04":
      case "RELAIS05":
      case "RELAIS06":
      case "RELAIS07":
      case "RELAIS08":
      case "STGE01":
      case "STGE03":
      case "STGE04":
      case "STGE05":
      case "STGE07":
      case "STGE10":
      case "STGE11":
      case "STGE14":
      case "PPOT1":
      case "PPOT2":
      case "PPOT3":
        log::add('mqttLinky', 'debug', __('Champ information binaire', __FILE__));
        $this->setSubType('binary');
        $this->setGeneric_type('GENERIC_INFO');
        break;
      /* Champs d'informations en Ampère */
      case "ISOUSC":
      case "IMAX":
      case "ADPS":
      case "ADIR1":
      case "ADIR2":
      case "ADIR3":
      case "IMAX1":
      case "IMAX2":
      case "IMAX3":
        log::add('mqttLinky', 'debug', __('Champ information en A', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('A');
        $this->setGeneric_type('GENERIC_INFO');
        break;
      /* Champs d'informations en kVA */
      case "PREF":
      case "PCOUP":
        log::add('mqttLinky', 'debug', __('Champ information en kVA', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('kVA');
        $this->setGeneric_type('GENERIC_INFO');
        break;
      /* Champs d'informations en VA */
      case "SMAXSN":
      case "SMAXSN-1":
      case "SMAXSN1":
      case "SMAXSN2":
      case "SMAXSN3":
      case "SMAXSN1-1":
      case "SMAXSN2-1":
      case "SMAXSN3-1":
      case "SMAXIN":
      case "SMAXIN-1":
        log::add('mqttLinky', 'debug', __('Champ information en VA', __FILE__));
        $this->setSubType('numeric');
        $this->setUnite('VA');
        $this->setGeneric_type('GENERIC_INFO');
        break;
      /* Autres champs - info numériques sans unités */
      case "ADCO":
      case "ADSC":
      case "NTARF":
      case "NJOURF":
      case "NJOURF+1":
      case "STGE17":
      case "STGE18":
        log::add('mqttLinky', 'debug', __('Champ information numérique', __FILE__));
        $this->setSubType('numeric');
        $this->setGeneric_type('GENERIC_INFO');
        break;
      /* Autres champs - info string */
      case "OPTARIF":
      case "PTEC":
      case "DEMAIN":
      case "HHPHC":
      case "MOTDETAT":
      case "NGTF":
      case "LTARF":
      case "VTIC":
      case "MSG1":
      case "MSG2":
      case "PRM":
      case "DPM1":
      case "FPM1":
      case "DPM2":
      case "FPM2":
      case "DPM3":
      case "FPM3":
      case "PJOURF+1":
      case "PPOINTE":
      case "STGE02":
      case "STGE06":
      case "STGE08":
      case "STGE09":
      case "STGE12":
      case "STGE13":
      case "STGE15":
      case "STGE16":
      default:
        log::add('mqttLinky', 'debug', __('Champ information texte', __FILE__));
        $this->setSubType('string');
        $this->setGeneric_type('GENERIC_INFO');
        break;
    }
  }
}
