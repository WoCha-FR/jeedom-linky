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
include_file('core', 'authentification', 'php');
if (!isConnect()) {
  include_file('desktop', '404', 'php');
  die();
}
?>
<form class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label class="col-md-4 control-label">{{Topic racine}}</label>
      <div class="col-md-3">
        <input class="configKey form-control" data-l1key="mqtt::topic" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">{{Mode}}</label>
      <div class="col-md-3">
        <select class="configKey form-control" data-l1key="mqttLinky::mode" id="sel_demonMode">
          <option value="distant">{{Distant}}</option>
          <option value="local">{{Local}}</option>
        </select>
      </div>
    </div>
    <div class="form-group demon_mode local">
		  <label class="col-md-4 control-label">{{Port du compteur}}
        <sup><i class="fas fa-question-circle tooltips" title="{{Renseigner le port utilisé pour se connecter au Linky}}"></i></sup>
      </label>
      <div class="col-md-3">
        <select class="configKey form-control" data-l1key="mqttLinky::port">
          <option value="none">{{Aucun}}</option>
          <?php
          foreach (jeedom::getUsbMapping('', true) as $name => $value) {
            echo '<option value="' . $name . '">' . $name . ' (' . $value . ')</option>';
          }
          foreach (ls('/dev/', 'tty*') as $value) {
            echo '<option value="/dev/' . $value . '">/dev/' . $value . '</option>';
          }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group demon_mode local">
      <label class="col-md-4 control-label">{{Type de téléinformation}}
        <sup><i class="fas fa-question-circle tooltips" title="{{Sélectionner le type de téléinformation du compteur}}"></i></sup>
      </label>
      <div class="col-md-3">
        <select class="configKey form-control" data-l1key="mqttLinky::type">
          <option value="historic">{{Historique}}</option>
          <option value="standard">{{Standard}}</option>
        </select>
      </div>
    </div>
  </fieldset>
</form>

<script>
  $('#sel_demonMode').off('change').on('change', function() {
    $('.demon_mode').hide();
    if ($(this).value() != '') {
      $('.demon_mode.' + $(this).value()).show();
    }
  })
</script>