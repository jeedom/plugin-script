
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

$(function() {
  $('#md_browseScriptFile').removeClass('hidden')
})

$("#md_browseScriptFile").dialog({
  autoOpen: false,
  modal: true,
  height: (jQuery(window).height() - 250),
  width: (jQuery(window).width() - 450),
  closeText: ''
})

$("#table_cmd tbody").delegate(".cmdAttr[data-l1key=configuration][data-l2key=requestType]", 'change', function(event) {
  $(this).closest('tr').find('.requestTypeConfig').hide()
  $(this).closest('tr').find('.requestTypeConfig[data-type=' + $(this).value() + ']').show()
  if ($(this).value() == 'script') {
    $(this).closest('tr').find('.browseScriptFile').show()
    $(this).closest('tr').find('.editScriptFile').show()

    $(this).closest('tr').find('.tdRequest').attr('colspan', '2')
    $(this).closest('tr').find('.tdOptions').hide()
  } else {
    $(this).closest('tr').find('.browseScriptFile').hide()
    $(this).closest('tr').find('.editScriptFile').hide()

    $(this).closest('tr').find('.tdRequest').attr('colspan', '1')
    $(this).closest('tr').find('.tdOptions').show()
  }
})

$("#table_cmd tbody").delegate(".browseScriptFile", 'click', function(event) {
  var tr = $(this).closest('tr')
  $("#md_browseScriptFile").dialog('open')
  $('#div_browseScriptFileTree').fileTree({
    root: '/',
    script: 'plugins/script/core/php/jqueryFileTree.php?root=' + encodeURIComponent(userScriptDir),
    folderEvent: 'click'
  }, function(file) {
    $("#md_browseScriptFile").dialog('close')
    if (userScriptDir.slice(-1) == '/' && file.slice(0, 1) == '/') {
      file = file.slice(1)
    }
    tr.find('.cmdAttr[data-l1key=configuration][data-l2key=request]').value(userScriptDir + file)
  })
})

$("#table_cmd tbody").delegate(".editScriptFile", 'click', function(event) {
  window.open('index.php?v=d&p=editor&root=' + userScriptDir.replace(rootPath + '/', ''), '_blank').focus()
})

$("#table_cmd").sortable({ axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true })

function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = {}
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {}
  }
  if (init(_cmd.logicalId) == 'refresh') {
    return
  }

  var selRequestType = '<select style="width : 90px;" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="requestType">'
  selRequestType += '<option value="script">{{Script}}</option>'
  selRequestType += '<option value="http">{{HTTP}}</option>'
  selRequestType += '<option value="html">{{HTML}}</option>'
  selRequestType += '<option value="xml">{{XML}}</option>'
  selRequestType += '<option value="json">{{JSON}}</option>'
  selRequestType += '</select>'

  var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">'

  tr += '<td>'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="id"  style="display : none;">'
  tr += '<div class="input-group">'
  tr += '<input class="cmdAttr form-control input-sm roundedLeft" data-l1key="name" placeholder="{{Nom de la commande}}">'
  tr += '<span class="input-group-btn"><a class="cmdAction btn btn-sm btn-default" data-l1key="chooseIcon" title="{{Choisir une icône}}"><i class="fas fa-icons"></i></a></span>'
  tr += '<span class="cmdAttr input-group-addon roundedRight" data-l1key="display" data-l2key="icon" style="font-size:19px;padding:0 5px 0 0!important;"></span>'
  tr += '</div>'
  tr += '<select class="cmdAttr form-control input-sm" data-l1key="value" style="display:none;margin-top:5px;" title="{{Commande info liée}}">'
  tr += '<option value="">{{Aucune}}</option>'
  tr += '</select>'
  tr += '</td>'
  tr += '<td class="requestType" type="' + init(_cmd.configuration.requestType) + '" >' + selRequestType
  tr += '</td>'
  tr += '<td>'
  tr += '<span class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>'
  tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>'
  tr += '</td>'

  tr += '<td class="tdRequest">'
  tr += '<div class="btn-group" role="group">'
  tr += '<span class="input-group" style="margin-top : 5px;">'
  tr += '<a style="width:30px" class="btn btn-default browseScriptFile btn-xs roundedLeft" title="{{Parcourir}}"><i class="far fa-folder-open"></i></a>'
  tr += '<a style="width:30px" class="btn btn-default editScriptFile btn-xs" title="{{Editer}}"><i class="far fa-edit"></i></a>'
  tr += '</span>'
  tr += '</div>'
  tr += '<textarea style="height : 95px;margin-top:5px;" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="request"></textarea>'
  tr += '</td>'

  tr += '<td class="tdOptions">'
  tr += '<div class="requestTypeConfig" data-type="http">'
  tr += '<center>'
  tr += '<input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="noSslCheck" />{{Vérifier SSL}} '
  tr += '<input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="allowEmptyResponse" style="margin-left : 20px;"/>{{Retour vide}} '
  tr += '<input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="doNotReportHttpError" style="margin-left : 20px;"/>{{Pas d\'erreurs}} '
  tr += '</center>'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="reponseMustContain" placeholder="{{La réponse doit contenir}}" title="Vide pour ne mettre aucun contrainte" style="margin-top:3px;"/>'
  tr += '<div class="row">'
  tr += '<div class="col-sm-6">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="timeout" placeholder="{{Timeout (s)}}" title="Par défaut 2 secondes" style="margin-top : 3px;" autocomplete="off"/>'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="http_username" placeholder="{{Utilisateur}}" style="margin-top : 3px;" autocomplete="off"/>'
  tr += '</div>'
  tr += '<div class="col-sm-6">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxHttpRetry" placeholder="{{Maximum d\'essai}}" title="Par défaut 4" style="margin-top : 3px;" autocomplete="off"/>'
  tr += '<input type="password" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="http_password" placeholder="{{Mot de passe}}" style="margin-top : 3px;" autocomplete="off"/>'
  tr += '</div>'
  tr += '</div>'
  tr += '</div>'

  tr += '<div class="requestTypeConfig" data-type="xml" style="display : none;">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="urlXml" placeholder="URL du fichier XML"/>'
  tr += '<center class="btn-sm">'
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="xmlNoSslCheck"/>{{Vérifier SSL}}</label></span> '
  tr += '</center>'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="xmlTimeout" placeholder="{{Timeout (s)}}" title="Par défaut 2 secondes" autocomplete="new-password"/>'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxXmlRetry" placeholder="{{Essais au maximum}}" title="Par défaut 4" style="margin-top : 5px;" autocomplete="new-password" />'
  tr += '<div class="row" style="margin-top : 5px;">'
  tr += '<div class="col-sm-6">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="xml_username" placeholder="{{Utilisateur}}" autocomplete="new-password"/>'
  tr += '</div>'
  tr += '<div class="col-sm-6">'
  tr += '<input type="password" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="xml_password" placeholder="{{Mot de passe}}" autocomplete="new-password"/>'
  tr += '</div>'
  tr += '</div>'
  tr += '</div>'

  tr += '<div class="requestTypeConfig" data-type="html" style="display : none;">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="urlHtml" placeholder="URL du HTML"/>'
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="htmlNoSslCheck"/>{{Vérifier SSL}}</label></span> '
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="htmlTimeout" placeholder="{{Timeout (s)}}" title="Par défaut 2 secondes" autocomplete="new-password"/>'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxHtmlRetry" placeholder="{{Essais au maximum}}" title="Par défaut 4" style="margin-top : 3px;" autocomplete="new-password" />'
  tr += '<div class="row" >'
  tr += '<div class="col-sm-6">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="html_username" placeholder="{{Utilisateur}}" style="margin-top : 3px;" autocomplete="new-password"/>'
  tr += '</div>'
  tr += '<div class="col-sm-6">'
  tr += '<input type="password" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="html_password" placeholder="{{Mot de passe}}" style="margin-top : 3px;" autocomplete="new-password"/>'
  tr += '</div>'
  tr += '</div>'
  tr += '</div>'

  tr += '<div class="requestTypeConfig" data-type="json" style="display : none;">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="urlJson" placeholder="URL du fichier JSON"/>'
  tr += '<center class="btn-sm">'
  tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="jsonNoSslCheck"/>{{Vérifier SSL}}</label></span> '
  tr += '</center>'
  tr += '<div class="row">'
  tr += '<div class="col-sm-6">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="jsonTimeout" placeholder="{{Timeout (s)}}" title="Par défaut 2 secondes" style="margin-top : 3px;" autocomplete="new-password"/>'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="json_username" placeholder="{{Utilisateur}}" style="margin-top : 3px;" autocomplete="new-password"/>'
  tr += '</div>'
  tr += '<div class="col-sm-6">'
  tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxJsonRetry" placeholder="{{Essais au maximum}}" title="Par défaut 4" style="margin-top : 3px;" autocomplete="new-password" />'
  tr += '<input type="password" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="json_password" placeholder="{{Mot de passe}}" style="margin-top : 3px;" autocomplete="new-password"  />'
  tr += '</div>'
  tr += '</div>'
  tr += '</div>'
  tr += '</td>'

  tr += '<td>'
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label> '
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" checked/>{{Historiser}}</label> '
  tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label> '
  tr += '<div style="margin-top:7px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="unite" placeholder="Unité" title="{{Unité}}" style="width:30%;max-width:80px;display:inline-block;margin-right:2px;">'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="listValue" placeholder="{{Liste de valeur|texte séparé par ;}}" title="{{Liste}}" style="margin-top : 5px;">'
  tr += '</div>'

  tr += '<select class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="updateCmdId" style="display : none;margin-top : 5px;" title="{{Commande d\'information à mettre à jour}}">'
  tr += '<option value="">{{Aucune}}</option>'
  tr += '</select>'
  tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="updateCmdToValue" placeholder="{{Valeur de l\'information}}" style="display : none;margin-top : 3px;">'
  tr += '</td>'

  tr += '<td>'
  tr += '<span class="cmdAttr" data-l1key="htmlstate"></span>'
  tr += '</td>'
  tr += '<td>'
  if (is_numeric(_cmd.id)) {
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> '
    tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> {{Tester}}</a>'
  }
  tr += ' <a class="btn btn-default btn-xs cmdAction" data-action="copy" title="Dupliquer"><i class="far fa-clone"></i></a> '
  tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>'
  tr += '</tr>'

  $('#table_cmd tbody').append(tr)
  $('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr')

  if (isset(_cmd.configuration.requestType)) {
    $('#table_cmd tbody tr:last .cmdAttr[data-l1key=configuration][data-l2key=requestType]').value(init(_cmd.configuration.requestType))
    $('#table_cmd tbody tr:last .cmdAttr[data-l1key=configuration][data-l2key=requestType]').trigger('change')
  }

  if (isset(_cmd.type)) {
    $('#table_cmd tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type))
  }
  var tr = $('#table_cmd tbody tr:last')
  jeedom.eqLogic.buildSelectCmd({
    id: $('.eqLogicAttr[data-l1key=id]').value(),
    filter: { type: 'info' },
    error: function(error) {
      $('#div_alert').showAlert({ message: error.message, level: 'danger' })
    },
    success: function(result) {
      tr.find('.cmdAttr[data-l1key=value]').append(result)
      tr.find('.cmdAttr[data-l1key=configuration][data-l2key=updateCmdId]').append(result)
      tr.setValues(_cmd, '.cmdAttr')
      jeedom.cmd.changeType(tr, init(_cmd.subType))
    }
  })
}
