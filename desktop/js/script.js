
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


editor = null;

$("#md_browseScriptFile").dialog({
    autoOpen: false,
    modal: true,
    height: (jQuery(window).height() - 150),
});

$("#table_cmd tbody").delegate(".cmdAttr[data-l1key=configuration][data-l2key=requestType]", 'change', function (event) {
    $(this).closest('tr').find('.requestTypeConfig').hide();
    $(this).closest('tr').find('.requestTypeConfig[data-type=' + $(this).value() + ']').show();
});

$("#table_cmd tbody").delegate(".browseScriptFile", 'click', function (event) {
    var tr = $(this).closest('tr');
    $("#md_browseScriptFile").dialog('open');
    $('#div_browseScriptFileTree').fileTree({
        root: '/',
        script: '3rdparty/jquery.fileTree/jqueryFileTree.php?dir=' + encodeURIComponent(userScriptDir),
        folderEvent: 'click'
    }, function (file) {
        $("#md_browseScriptFile").dialog('close');
        tr.find('.cmdAttr[data-l1key=configuration][data-l2key=request]').value(file);
    });
});

$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

$("#md_editScriptFile").dialog({
    autoOpen: false,
    modal: true,
    height: (jQuery(window).height() - 150),
    width: (jQuery(window).width() - 150)
});

$("#table_cmd tbody").delegate(".editScriptFile", 'click', function (event) {
    var tr = $(this).closest('tr');
    var path = tr.find('.cmdAttr[data-l1key=configuration][data-l2key=request]').val();
    if (path.indexOf(' ') > 0) {
        path = path.substr(0, path.indexOf(' '));
    }
    var data = loadScriptFile(path);
    if (data === false) {
        return;
    }

    if (editor != null) {
        editor.getDoc().setValue(data.content);
        editor.setOption("mode", data.mode);
        setTimeout(function () {
            editor.refresh();
        }, 1);
    } else {
        $('#ta_editScriptFile').val(data.content);
        setTimeout(function () {
            editor = CodeMirror.fromTextArea(document.getElementById("ta_editScriptFile"), {
                lineNumbers: true,
                mode: data.mode,
                matchBrackets: true
            });
            editor.getWrapperElement().style.height = ($('#md_editScriptFile').height()) + 'px';
            editor.refresh();
        }, 1);
    }

    $("#md_editScriptFile").dialog('option', 'buttons', {
        "Annuler": function () {
            $(this).dialog("close");
        },
        "Enregistrer": function () {
            if (saveScriptFile(path, editor.getValue())) {
                $(this).dialog("close");
            }
        }
    });
    $("#md_editScriptFile").dialog('open');
});


$("#table_cmd tbody").delegate(".newScriptFile", 'click', function (event) {
    var tr = $(this).closest('tr');
    bootbox.prompt("Nom du script ?", function (result) {
        if (result !== null) {
            var path = addUserScript(result);
            if (path !== false) {
                tr.find('.cmdAttr[data-l1key=configuration][data-l2key=request]').val(path);
                $('#md_newUserScript').modal('hide');
                tr.find('.editScriptFile').click();
            }
        }
    });
});

$("#table_cmd tbody").delegate(".removeScriptFile", 'click', function (event) {
    var tr = $(this).closest('tr');
    var path = tr.find('.cmdAttr[data-l1key=configuration][data-l2key=request]').val();
    if (path.indexOf(' ') > 0) {
        path = path.substr(0, path.indexOf(' '));
    }
    $.hideAlert();
    bootbox.confirm('{{Etes-vous sûr de vouloir supprimer le script :}} <span style="font-weight: bold ;">' + path + '</span> ?', function (result) {
        if (result) {
            tr.find('.cmdAttr[data-l1key=configuration][data-l2key=request]').val('');
        }
    });
});

$("#table_cmd tbody").delegate('.bt_shareOnMarket', 'click', function () {
    var tr = $(this).closest('tr');
    var path = tr.find('.cmdAttr[data-l1key=configuration][data-l2key=request]').val();
    var logicalId = getLogicalIdFromPath(path);
    if (logicalId == '') {
        $('#div_alert').showAlert({message: '{{Vous devez d\'abord séléctioner un script}}', level: 'danger'});
        return;
    }
    $('#md_modal').dialog({title: "{{Partager sur le market}}"});
    $('#md_modal').load('index.php?v=d&modal=market.send&type=script&logicalId=' + encodeURI(logicalId) + '&name=' + encodeURI(logicalId) + "&hidden=" + encodeURI(path)).dialog('open');
});

$('#bt_getFromMarket').on('click', function () {
    $('#md_modal').dialog({title: "{{Partager sur le market}}"});
    $('#md_modal').load('index.php?v=d&modal=market.list&type=script').dialog('open');
});

$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});


function addCmdToTable(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {};
    }
    if (!isset(_cmd.configuration)) {
        _cmd.configuration = {};
    }

    var selRequestType = '<select style="width : 90px;" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="requestType">';
    selRequestType += '<option value="http">{{Http}}</option>';
    selRequestType += '<option value="script">{{Script}}</option>';
    selRequestType += '<option value="xml">{{XML}}</option>';
    selRequestType += '<option value="json">{{JSON}}</option>';
    selRequestType += '</select>';

    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';

    tr += '<td>';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="id"  style="display : none;">';
    tr += '<div class="row">';
    tr += '<div class="col-sm-6">';
    tr += '<a class="cmdAction btn btn-default btn-sm" data-l1key="chooseIcon"><i class="fa fa-flag"></i> Icone</a>';
    tr += '<span class="cmdAttr" data-l1key="display" data-l2key="icon" style="margin-left : 10px;"></span>';
    tr += '</div>';
    tr += '<div class="col-sm-6">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="name">';
    tr += '</div>';
    tr += '</div>';
    tr += '<td class="requestType" type="' + init(_cmd.configuration.requestType) + '" >' + selRequestType;
    tr += '</td>';
    tr += '<td>';
    tr += '<span class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>';
    tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
    tr += '</td>';
    tr += '<td><textarea style="height : 95px;" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="request"></textarea>';
    tr += '<a class="btn btn-default browseScriptFile cursor input-sm" style="margin-top : 5px;"><i class="fa fa-folder-open"></i> {{Parcourir}}</a> ';
    tr += '<a class="btn btn-default editScriptFile cursor input-sm" style="margin-top : 5px;"><i class="fa fa-edit"></i> {{Editer}}</a> ';
    tr += '<a class="btn btn-success newScriptFile cursor input-sm" style="margin-top : 5px;"><i class="fa fa-file-o"></i> {{Nouveau}}</a> ';
    tr += '<a class="btn btn-danger removeScriptFile cursor input-sm" style="margin-top : 5px;"><i class="fa fa-trash-o"></i> {{Supprimer}}</a> ';
    tr += '<a class="btn btn-warning bt_shareOnMarket cursor input-sm" style="margin-top : 5px;"><i class="fa fa-cloud-upload"></i> {{Partager}}</a> ';
    tr += '</div>';
    tr += '</td>';
    tr += '<td>';


    tr += '<div class="requestTypeConfig" data-type="http">';
    tr += '<input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="noSslCheck" />{{Ne pas vérifier SSL}}<br/>';
    tr += '<input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="allowEmptyResponse" />{{Autoriser reponse vide}}';
    tr += '<input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="doNotReportHttpError" />{{Ne jamais remonter les erreurs}}';
    tr += '<input class="cmdAttr form-control input-sm tooltips" data-l1key="configuration" data-l2key="timeout" placeholder="{{Timeout}}" title="Par défaut 2 secondes"/>';
    tr += '<input class="cmdAttr form-control input-sm tooltips" data-l1key="configuration" data-l2key="maxHttpRetry" placeholder="{{Essai maximum}}" title="Par défaut 4" style="margin-top : 5px;" />';
    tr += '<div class="row" style="margin-top : 5px;">';
    tr += '<div class="col-sm-6">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="http_username" placeholder="{{Utilisateur}}"/>';
    tr += '</div>';
    tr += '<div class="col-sm-6">';
    tr += '<input type="password" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="http_password" placeholder="{{Password}}"/>';
    tr += '</div>';
    tr += '</div>';
    tr += '</div>';

    tr += '<div class="requestTypeConfig" data-type="xml" style="display : none;">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="urlXml" placeholder="URL du fichier XML"/>';
    tr += '<input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="xmlNoSslCheck" />{{Ne pas vérifier SSL}}<br/>';
    tr += '<input class="cmdAttr form-control input-sm tooltips" data-l1key="configuration" data-l2key="xmlTimeout" placeholder="{{Timeout}}" title="Par défaut 2 secondes"/>';
    tr += '<input class="cmdAttr form-control input-sm tooltips" data-l1key="configuration" data-l2key="maxXmlRetry" placeholder="{{Essai maximum}}" title="Par défaut 4" style="margin-top : 5px;" />';
    tr += '<div class="row" style="margin-top : 5px;">';
    tr += '<div class="col-sm-6">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="xml_username" placeholder="{{Utilisateur}}"/>';
    tr += '</div>';
    tr += '<div class="col-sm-6">';
    tr += '<input type="password" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="xml_password" placeholder="{{Password}}"/>';
    tr += '</div>';
    tr += '</div>';
    tr += '</div>';

    tr += '<div class="requestTypeConfig" data-type="json" style="display : none;">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="urlJson" placeholder="URL du fichier JSON"/>';
    tr += '<input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="jsonNoSslCheck" />{{Ne pas vérifier SSL}}<br/>';
    tr += '<input class="cmdAttr form-control input-sm tooltips" data-l1key="configuration" data-l2key="jsonTimeout" placeholder="{{Timeout}}" title="Par défaut 2 secondes"/>';
    tr += '<input class="cmdAttr form-control input-sm tooltips" data-l1key="configuration" data-l2key="maxJsonRetry" placeholder="{{Essai maximum}}" title="Par défaut 4" style="margin-top : 5px;" />';
    tr += '<div class="row" style="margin-top : 5px;">';
    tr += '<div class="col-sm-6">';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="json_username" placeholder="{{Utilisateur}}"/>';
    tr += '</div>';
    tr += '<div class="col-sm-6">';
    tr += '<input type="password" class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="json_password" placeholder="{{Password}}"/>';
    tr += '</div>';
    tr += '</div>';
    tr += '</div>';

    tr += '</td>';
    tr += '<td>';
    tr += '<input class="cmdAttr form-control tooltips input-sm" data-l1key="unite"  style="width : 100px;" placeholder="{{Unité}}" title="{{Unité}}">';
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}"> ';
    tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}">';
    tr += '</td>';
    tr += '<td>';
    tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" /> {{Historiser}}<br/></span>';
    tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/> {{Afficher}}<br/></span>';
    tr += '<span class="expertModeVisible"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary" /> {{Inverser}}<br/></span>';
    tr += '<span><input type="checkbox" class="cmdAttr expertModeVisible" data-l1key="eventOnly" /> Evénement<br/></span>';
    tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="cache" data-l2key="enable" checked /> {{Autoriser memcache}}</span>';
    tr += '<input style="width : 100px;" class="tooltips cmdAttr form-control input-sm" data-l1key="cache" data-l2key="lifetime" placeholder="{{Lifetime cache}}" title="Lifetime cache">';
    tr += '</td>';
    tr += '<td>';
    if (is_numeric(_cmd.id)) {
        tr += '<a class="btn btn-default btn-xs cmdAction expertModeVisible" data-action="configure"><i class="fa fa-cogs"></i></a> ';
        tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
    }
    tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
    tr += '</tr>';

    $('#table_cmd tbody').append(tr);
    $('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');

    if (isset(_cmd.configuration.requestType)) {
        $('#table_cmd tbody tr:last .cmdAttr[data-l1key=configuration][data-l2key=requestType]').value(init(_cmd.configuration.requestType));
        $('#table_cmd tbody tr:last .cmdAttr[data-l1key=configuration][data-l2key=requestType]').trigger('change');
    }

    if (isset(_cmd.type)) {
        $('#table_cmd tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
    }
    jeedom.cmd.changeType($('#table_cmd tbody tr:last'), init(_cmd.subType));
    initTooltips();
}

function getLogicalIdFromPath(_path) {
    if (_path.indexOf(' ') > 0) {
        _path = _path.substr(0, _path.indexOf(' '));
    }
    var res = _path.split("/");
    if (res.length > 0) {
        return res[res.length - 1];
    } else {
        return _path;
    }
}


function loadScriptFile(_path) {
    $.hideAlert();
    var result = false;
    $.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/script/core/ajax/script.ajax.php", // url du fichier php
        data: {
            action: "getScriptContent",
            path: _path,
        },
        dataType: 'json',
        async: false,
        error: function (request, status, error) {
            handleAjaxError(request, status, error, $('#div_alert'));
        },
        success: function (data) { // si l'appel a bien fonctionné
            if (data.state != 'ok') {
                $('#div_alert').showAlert({message: data.result, level: 'danger'});
                return false;
            }
            result = data.result;
            switch (result.extension) {
                case 'php' :
                    result.mode = 'text/x-php';
                    break;
                case 'sh' :
                    result.mode = 'shell';
                    break;
                case 'pl' :
                    result.mode = 'text/x-php';
                    break;
                case 'py' :
                    result.mode = 'text/x-python';
                    break;
                case 'rb' :
                    result.mode = 'text/x-ruby';
                    break;
                default :
                    result.mode = 'text/x-php';
                    break;
            }
        }
    });
    return result;
}

function saveScriptFile(_path, _content) {
    $.hideAlert();
    var success = false;
    $.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/script/core/ajax/script.ajax.php", // url du fichier php
        data: {
            action: "saveScriptContent",
            path: _path,
            content: _content,
        },
        dataType: 'json',
        async: false,
        error: function (request, status, error) {
            handleAjaxError(request, status, error, $('#div_editScriptFileAlert'));
        },
        success: function (data) { // si l'appel a bien fonctionné
            if (data.state != 'ok') {
                $('#div_editScriptFileAlert').showAlert({message: data.result, level: 'danger'});
                return;
            }
            success = true;
            $('#div_alert').showAlert({message: 'Script sauvegardé', level: 'success'});
        }
    });
    return success;
}

function addUserScript(_name) {
    $.hideAlert();
    var success = false;
    $.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/script/core/ajax/script.ajax.php", // url du fichier php
        data: {
            action: "addUserScript",
            name: _name,
        },
        dataType: 'json',
        async: false,
        error: function (request, status, error) {
            handleAjaxError(request, status, error, $('#div_newUserScriptAlert'));
        },
        success: function (data) { // si l'appel a bien fonctionné
            if (data.state != 'ok') {
                $('#div_newUserScriptAlert').showAlert({message: data.result, level: 'danger'});
                return;
            }
            success = data.result;
        }
    });
    return success;
}

function removeScript(_path) {
    $.hideAlert();
    var success = false;
    $.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/script/core/ajax/script.ajax.php", // url du fichier php
        data: {
            action: "removeScript",
            path: _path,
        },
        dataType: 'json',
        async: false,
        error: function (request, status, error) {
            handleAjaxError(request, status, error, $('#div_newUserScriptAlert'));
        },
        success: function (data) { // si l'appel a bien fonctionné
            if (data.state != 'ok') {
                $('#div_newUserScriptAlert').showAlert({message: data.result, level: 'danger'});
                return;
            }
            $('#div_alert').showAlert({message: 'Script supprimé', level: 'success'});
            success = true;
        }
    });
    return success;
}


