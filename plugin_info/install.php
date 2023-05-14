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
require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

function mqttLinky_install() {
  $plugin = plugin::byId('mqttLinky');
  $plugin->dependancy_changeAutoMode(0);
  $plugin->deamon_changeAutoMode(0);
  $plugin->deamon_info(0);
}

function mqttLinky_update() {
  $plugin = plugin::byId('mqttLinky');
  if (config::byKey('mqttLinky::mode', 'mqttLinky', 'distant') == 'local') {
    $plugin->dependancy_changeAutoMode(1);
    $plugin->deamon_changeAutoMode(1);
    $plugin->deamon_info(1);
  } else {
    $plugin->dependancy_changeAutoMode(0);
    $plugin->deamon_changeAutoMode(0);
    $plugin->deamon_info(0);
  }
  // Mise à jour des paramètres des commandes créées
  foreach (eqLogic::byType('mqttLinky') as $eqLogic) {
    foreach ($eqLogic->getCmd() as $cmd) {
      $cmd->save();
    }
  }
}

function mqttLinky_remove() {
}
