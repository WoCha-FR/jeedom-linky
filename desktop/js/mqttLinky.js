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

var tag_historic = [
  {etiquette:"ADCO",name:"Adresse du compteur"},
  {etiquette:"OPTARIF",name:"Option tarifaire choisie"},
  {etiquette:"ISOUSC",name:"Intensité souscrite"},
  {etiquette:"BASE",name:"Index Base"},
  {etiquette:"HCHC",name:"Index Heures Creuses"},
  {etiquette:"HCHP",name:"Index Heures Pleines"},
  {etiquette:"EJPHN",name:"Index EJP Heures Normales"},
  {etiquette:"EJPHPM",name:"Index EJP Heures de Pointe Mobile"},
  {etiquette:"BBRHCJB",name:"Index Tempo Heures Creuses Bleus"},
  {etiquette:"BBRHPJB",name:"Index Tempo Heures Pleines Bleus"},
  {etiquette:"BBRHCJW",name:"Index Tempo Heures Creuses Blancs"},
  {etiquette:"BBRHPJW",name:"Index Tempo Heures Pleines Blancs"},
  {etiquette:"BBRHCJR",name:"Index Tempo Heures Creuses Rouges"},
  {etiquette:"BBRHPJR",name:"Index Tempo Heures Pleines Rouges"},
  {etiquette:"PEJP",name:"Préavis Début EJP (30 min)"},
  {etiquette:"PTEC",name:"Période Tarifaire en cours"},
  {etiquette:"DEMAIN",name:"Couleur du lendemain"},
  {etiquette:"IINST",name:"Intensité Instantanée"},
  {etiquette:"ADPS",name:"Avertissement de Dépassement De Puissance Souscrite"},
  {etiquette:"IMAX",name:"Intensité maximale appelée"},
  {etiquette:"PAPP",name:"Puissance apparente"},
  {etiquette:"HHPHC",name:"Horaire Heures Pleines Heures Creuses"},
  {etiquette:"MOTDETAT",name:"Mot d'état du compteur"}
];
var tag_historic_tri = [
  {etiquette:"IINST1",name:"Intensité Instantanée phases 1"},
  {etiquette:"IINST2",name:"Intensité Instantanée phases 2"},
  {etiquette:"IINST3",name:"Intensité Instantanée phases 3"},
  {etiquette:"ADIR1",name:"Avertissement de Dépassement phase 1"},
  {etiquette:"ADIR2",name:"Avertissement de Dépassement phase 2"},
  {etiquette:"ADIR3",name:"Avertissement de Dépassement phase 3"},
  {etiquette:"IMAX1",name:"Intensité maximale phase 1"},
  {etiquette:"IMAX2",name:"Intensité maximale phase 2"},
  {etiquette:"IMAX3",name:"Intensité maximale phase 3"},
  {etiquette:"PMAX",name:"Puissance maximale triphasée atteinte"},
  {etiquette:"PPOT1",name:"Présence potentiel phase 1"},
  {etiquette:"PPOT2",name:"Présence potentiel phase 2"},
  {etiquette:"PPOT3",name:"Présence potentiel phase 3"}
];
var tag_standard = [
  {etiquette:"ADSC",name:"Adresse du Compteur"},
  {etiquette:"VTIC",name:"Version de la TIC"},
  {etiquette:"NGTF",name:"Nom du calendrier tarifaire fournisseur"},
  {etiquette:"LTARF",name:"Libellé tarif fournisseur en cours"},
  {etiquette:"EAST",name:"Energie active soutirée totale"},
  {etiquette:"EASF01",name:"Energie active soutirée Fournisseur, index 01"},
  {etiquette:"EASF02",name:"Energie active soutirée Fournisseur, index 02"},
  {etiquette:"EASF03",name:"Energie active soutirée Fournisseur, index 03"},
  {etiquette:"EASF04",name:"Energie active soutirée Fournisseur, index 04"},
  {etiquette:"EASF05",name:"Energie active soutirée Fournisseur, index 05"},
  {etiquette:"EASF06",name:"Energie active soutirée Fournisseur, index 06"},
  {etiquette:"EASF07",name:"Energie active soutirée Fournisseur, index 07"},
  {etiquette:"EASF08",name:"Energie active soutirée Fournisseur, index 08"},
  {etiquette:"EASF09",name:"Energie active soutirée Fournisseur, index 09"},
  {etiquette:"EASF10",name:"Energie active soutirée Fournisseur, index 10"},
  {etiquette:"EASD01",name:"Energie active soutirée Distributeur, index 01"},
  {etiquette:"EASD02",name:"Energie active soutirée Distributeur, index 02"},
  {etiquette:"EASD03",name:"Energie active soutirée Distributeur, index 03"},
  {etiquette:"EASD04",name:"Energie active soutirée Distributeur, index 04"},
  {etiquette:"IRMS1",name:"Courant efficace, phase 1"},
  {etiquette:"URMS1",name:"Tension efficace, phase 1"},
  {etiquette:"PREF",name:"Puissance app. de référence"},
  {etiquette:"PCOUP",name:"Puissance app. de coupure"},
  {etiquette:"SINSTS",name:"Puissance app. Instantanée soutirée"},
  {etiquette:"SMAXSN",name:"Puissance app. max. soutirée n"},
  {etiquette:"SMAXSN-1",name:"Puissance app max. soutirée n-1"},
  {etiquette:"CCASN",name:"Point n de la courbe de charge active soutirée"},
  {etiquette:"CCASN-1",name:"Point n-1 de la courbe de charge active soutirée"},
  {etiquette:"UMOY1",name:"Tension moy. ph. 1"},
  {etiquette:"DPM1",name:"Début Pointe Mobile 1"},
  {etiquette:"FPM1",name:"Fin Pointe Mobile 1"},
  {etiquette:"DPM2",name:"Début Pointe Mobile 2"},
  {etiquette:"FPM2",name:"Fin Pointe Mobile 2"},
  {etiquette:"DPM3",name:"Début Pointe Mobile 3"},
  {etiquette:"FPM3",name:"Fin Pointe Mobile 3"},
  {etiquette:"MSG1",name:"Message court"},
  {etiquette:"MSG2",name:"Message Ultra court"},
  {etiquette:"PRM",name:"PRM"},
  {etiquette:"NTARF",name:"Numéro de l’index tarifaire en cours"},
  {etiquette:"NJOURF",name:"Numéro du jour en cours calendrier fournisseur"},
  {etiquette:"NJOURF+1",name:"Numéro du prochain jour calendrier fournisseur"},
  {etiquette:"PJOURF+1",name:"Profil du prochain jour calendrier fournisseur"},
  {etiquette:"PPOINTE",name:"Profil du prochain jour de pointe"},
  {etiquette:"PRMS",name:"Puissance active calculée"}
];
var tag_standard_tri = [
  {etiquette:"IRMS2",name:"Courant efficace, phase 2"},
  {etiquette:"IRMS3",name:"Courant efficace, phase 3"},
  {etiquette:"URMS2",name:"Tension efficace, phase 2"},
  {etiquette:"URMS3",name:"Tension efficace, phase 3"},
  {etiquette:"SINSTS1",name:"Puissance app. Instantanée soutirée phase 1"},
  {etiquette:"SINSTS2",name:"Puissance app. Instantanée soutirée phase 2"},
  {etiquette:"SINSTS3",name:"Puissance app. Instantanée soutirée phase 3"},
  {etiquette:"SMAXSN1",name:"Puissance app. max. soutirée n phase 1"},
  {etiquette:"SMAXSN2",name:"Puissance app. max. soutirée n phase 2"},
  {etiquette:"SMAXSN3",name:"Puissance app. max. soutirée n phase 3"},
  {etiquette:"SMAXSN1-1",name:"Puissance app max. soutirée n-1 phase 1"},
  {etiquette:"SMAXSN2-1",name:"Puissance app max. soutirée n-1 phase 2"},
  {etiquette:"SMAXSN3-1",name:"Puissance app max. soutirée n-1 phase 3"},
  {etiquette:"UMOY2",name:"Tension moy. ph. 2"},
  {etiquette:"UMOY3",name:"Tension moy. ph. 3"},
  {etiquette:"IRMS",name:"Courant efficace calculé, 3 phases"},
  {etiquette:"PRMS1",name:"Puissance active calculée, phase 1"},
  {etiquette:"PRMS2",name:"Puissance active calculée, phase 2"},
  {etiquette:"PRMS3",name:"Puissance active calculée, phase 3"}
];
var tag_standard_status = [
  {etiquette:"STGE01",name:"STGE01 - Contact sec"},
  {etiquette:"STGE02",name:"STGE02 - Organe de coupure"},
  {etiquette:"STGE03",name:"STGE03 - Etat du cache-bornes distributeur"},
  {etiquette:"STGE04",name:"STGE04 - Surtension sur une des phases"},
  {etiquette:"STGE05",name:"STGE05 - Depassement de la puissance de reference"},
  {etiquette:"STGE06",name:"STGE06 - Fonctionnement producteur/consommateur"},
  {etiquette:"STGE07",name:"STGE07 - Sens de l’energie active"},
  {etiquette:"STGE08",name:"STGE08 - Tarif en cours sur le contrat fourniture"},
  {etiquette:"STGE09",name:"STGE09 - Tarif en cours sur le contrat distributeur"},
  {etiquette:"STGE10",name:"STGE10 - Mode degrade de l’horloge"},
  {etiquette:"STGE11",name:"STGE11 - Etat de la sortie tele-information"},
  {etiquette:"STGE12",name:"STGE12 - Etat de la sortie communication Euridis"},
  {etiquette:"STGE13",name:"STGE13 - Statut du CPL"},
  {etiquette:"STGE14",name:"STGE14 - Synchronisation CPL"},
  {etiquette:"STGE15",name:"STGE15 - Couleur du jour pour le contrat historique Tempo"},
  {etiquette:"STGE16",name:"STGE16 - Couleur du lendemain pour le contrat historique Tempo"},
  {etiquette:"STGE17",name:"STGE17 - Preavis pointes mobiles"},
  {etiquette:"STGE18",name:"STGE18 - Pointe mobile (PM)"}  
];
var tag_standard_prod = [
  {etiquette:"EAIT",name:"Energie active injectée totale"},
  {etiquette:"ERQ1",name:"Energie réactive Q1 totale"},
  {etiquette:"ERQ2",name:"Energie réactive Q2 totale"},
  {etiquette:"ERQ3",name:"Energie réactive Q3 totale"},
  {etiquette:"ERQ4",name:"Energie réactive Q4 totale"},
  {etiquette:"SINSTI",name:"Puissance app. Instantanée injectée"},
  {etiquette:"SMAXIN",name:"Puissance app. max. injectée n"},
  {etiquette:"SMAXIN-1",name:"Puissance app max. injectée n-1"},
  {etiquette:"CCAIN",name:"Point n de la courbe de charge active injectée"},
  {etiquette:"CCAIN-1",name:"Point n-1 de la courbe de charge active injectée"}
];
var tag_standard_relais = [
  {etiquette:"RELAIS01",name:"RELAIS01 - Physique"},
  {etiquette:"RELAIS02",name:"RELAIS02 - Virtuel"},
  {etiquette:"RELAIS03",name:"RELAIS03 - Virtuel"},
  {etiquette:"RELAIS04",name:"RELAIS04 - Virtuel"},
  {etiquette:"RELAIS05",name:"RELAIS05 - Virtuel"},
  {etiquette:"RELAIS06",name:"RELAIS06 - Virtuel"},
  {etiquette:"RELAIS07",name:"RELAIS07 - Virtuel"},
  {etiquette:"RELAIS08",name:"RELAIS08 - Virtuel"}
];

$("#table_cmd").sortable({
  axis: "y",
  cursor: "move",
  items: ".cmd",
  placeholder: "ui-state-highlight",
  tolerance: "intersect",
  forcePlaceholderSize: true
})

/* Fonction permettant l'affichage des commandes dans l'équipement */
function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = {configuration: {}}
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {}
  }
  /* Select selon compteur */
  var selType = '';
  if( $('.eqLogicAttr[data-l2key=tictype]').value() == 'historic') {
    selType = '<select class="cmdAttr form-control input-sm" data-l1key="logicalId">'
    selType += '<optgroup label="{{Valeurs}}">'
    tag_historic.forEach(function(element) {
      selType += '<option value="' + element.etiquette + '">' + element.name + '</option>'
    });
    selType += '</optgroup>'
    selType += '<optgroup label="{{Triphasé}}">'
    tag_historic_tri.forEach(function(element) {
      selType += '<option value="' + element.etiquette + '">' + element.name + '</option>'
    });
    selType += '</optgroup>'
    selType += '</select>'
  } else {
    selType = '<select class="cmdAttr form-control input-sm" data-l1key="logicalId">'
    selType += '<optgroup label="{{Valeurs}}">'
    tag_standard.forEach(function(element) {
      selType += '<option value="' + element.etiquette + '">' + element.name + '</option>'
    });
    selType += '</optgroup>'
    selType += '<optgroup label="{{Triphasé}}">'
    tag_standard_tri.forEach(function(element) {
      selType += '<option value="' + element.etiquette + '">' + element.name + '</option>'
    });
    selType += '</optgroup>'
    selType += '<optgroup label="{{Producteur}}">';
    tag_standard_prod.forEach(function(element) {
      selType += '<option value="' + element.etiquette + '">' + element.name + '</option>'
    });
    selType += '</optgroup>'
    selType += '<optgroup label="{{Status}}">'
    tag_standard_status.forEach(function(element) {
      selType += '<option value="' + element.etiquette + '">' + element.name + '</option>'
    });
    selType += '</optgroup>'
    selType += '<optgroup label="{{Relais}}">'
    tag_standard_relais.forEach(function(element) {
      selType += '<option value="' + element.etiquette + '">' + element.name + '</option>'
    });
    selType += '</optgroup>'
    selType += '</select>'
  }
  var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">'
  tr += '<td class="hidden-xs">'
  tr += '<span class="cmdAttr" data-l1key="id"></span>'
  tr += '</td>'
  tr += '<td>'
  tr += '<div class="input-group">'
  tr += '<input class="cmdAttr form-control input-sm roundedLeft" data-l1key="name" placeholder="{{Nom de la commande}}">'
  tr += '<span class="input-group-btn"><a class="cmdAction btn btn-sm btn-default" data-l1key="chooseIcon" title="{{Choisir une icône}}"><i class="fas fa-icons"></i></a></span>'
  tr += '<span class="cmdAttr input-group-addon roundedRight" data-l1key="display" data-l2key="icon" style="font-size:19px;padding:0 5px 0 0!important;"></span>'
  tr += '</div>'
  tr += '</td>'
  tr += '<td>'
  tr += '<input class="cmdAttr form-control type input-sm" data-l1key="type" value="info" disabled style="margin-bottom:5px;">'
  tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>'
  tr += '</td>'
  tr += '<td>'
  tr += selType
  tr += '</td>'
  tr += '<td>'
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label> '
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" checked/>{{Historiser}}</label> '
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label> '
  tr += '<div style="margin-top:7px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="unite" placeholder="Unité" title="{{Unité}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '</div>'
  tr += '</td>'
  tr += '<td>'
  tr += '<span class="cmdAttr" data-l1key="htmlstate"></span>'
  tr += '</td>'
  tr += '<td>'
  if (is_numeric(_cmd.id)) {
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> '
  }
  tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove" title="{{Supprimer la commande}}"></i></td>'
  tr += '</tr>'
  $('#table_cmd tbody').append(tr)
  var tr = $('#table_cmd tbody tr').last()
  jeedom.eqLogic.buildSelectCmd({
    id:  $('.eqLogicAttr[data-l1key=id]').value(),
    filter: {type: 'info'},
    error: function (error) {
      $.fn.showAlert({message: error.message, level: 'danger'})
    },
    success: function (result) {
      tr.find('.cmdAttr[data-l1key=value]').append(result)
      tr.setValues(_cmd, '.cmdAttr')
      jeedom.cmd.changeType(tr, init(_cmd.subType))
    }
  })
}
