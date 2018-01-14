<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
include_file('3rdparty', 'jquery.fileTree/jqueryFileTree', 'css', 'script');
include_file('3rdparty', 'codemirror/lib/codemirror', 'js');
include_file('3rdparty', 'codemirror/lib/codemirror', 'css');
include_file('3rdparty', 'codemirror/addon/edit/matchbrackets', 'js');
include_file('3rdparty', 'codemirror/mode/htmlmixed/htmlmixed', 'js');
include_file('3rdparty', 'codemirror/mode/clike/clike', 'js');
include_file('3rdparty', 'codemirror/mode/php/php', 'js');
include_file('3rdparty', 'codemirror/mode/shell/shell', 'js');
include_file('3rdparty', 'codemirror/mode/python/python', 'js');
include_file('3rdparty', 'codemirror/mode/ruby/ruby', 'js');
include_file('3rdparty', 'codemirror/mode/perl/perl', 'js');

sendVarToJS('eqType', 'script');
sendVarToJS('userScriptDir', getRootPath() . '/' . config::byKey('userScriptDir', 'script'));
$eqLogics = eqLogic::byType('script');
?>
<style>
    .CodeMirror-scroll {height: 100%; overflow-y: auto; overflow-x: auto;}
</style>
<div class="row row-overflow">
    <div class="col-lg-2">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default btn-sm tooltips" id="bt_getFromMarket" title="Récupérer du market" style="width : 100%"><i class="fa fa-shopping-cart"></i> {{Market}}</a>
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un dispositif}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
foreach ($eqLogics as $eqLogic) {
	echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
?>
           </ul>
       </div>
   </div>
   <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
     <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
     <div class="eqLogicThumbnailContainer">
        <div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
            <i class="fa fa-plus-circle" style="font-size : 5em;color:#94ca02;"></i>
        <br>
        <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;;color:#94ca02">{{Ajouter}}</span>
    </div>
    <div class="cursor" id="bt_getFromMarketicon" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
        <i class="fa fa-shopping-cart" style="font-size : 5em;color:#94ca02;"></i>
    <br>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;;color:#94ca02">{{Market}}</span>
</div>
<div class="cursor eqLogicAction" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
      <i class="fa fa-wrench" style="font-size : 5em;color:#767676;"></i>
  <br>
  <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}</span>
</div>
</div>
<legend><i class="fa fa-file"></i>  {{Mes Scripts}}
</legend>
<div class="eqLogicThumbnailContainer">
   <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
	echo '<img src="plugins/script/doc/images/script_icon.png" height="105" width="95" />';
	echo "<br>";
	echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
	echo '</div>';
}
?>
</div>
</div>
<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
 <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
 <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>

 <ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
  <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
</ul>

<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
  <div role="tabpanel" class="tab-pane active" id="eqlogictab">
    <form class="form-horizontal">
        <fieldset>
            <legend>
                <i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}
                <i class="fa fa-cogs eqLogicAction pull-right cursor" data-action="configure"></i>
                <a class="btn btn-xs btn-default pull-right eqLogicAction" data-action="copy"><i class="fa fa-files-o"></i> {{Dupliquer}}</a>
            </legend>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{Nom de l'équipement script}}</label>
                <div class="col-sm-3">
                    <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                    <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement script}}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" >{{Objet parent}}</label>
                <div class="col-sm-3">
                    <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                        <option value="">{{Aucun}}</option>
                        <?php
foreach (object::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?>
                   </select>
               </div>
           </div>
           <div class="form-group">
            <label class="col-sm-3 control-label">{{Catégorie}}</label>
            <div class="col-sm-8">
                <?php
foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
	echo '<label class="checkbox-inline">';
	echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
	echo '</label>';
}
?>

           </div>
       </div>
       <div class="form-group">
        <label class="col-sm-3 control-label"></label>
        <div class="col-sm-9">
            <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
            <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{{Auto-actualisation (cron)}}</label>
        <div class="col-sm-2">
            <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="autorefresh" placeholder="{{Auto-actualisation (cron)}}"/>
        </div>
        <div class="col-sm-1">
            <i class="fa fa-question-circle cursor floatright" id="bt_cronGenerator"></i>
        </div>
    </div>
</fieldset>
</form>

</div>
<div role="tabpanel" class="tab-pane" id="commandtab">
    <a class="btn btn-success btn-sm cmdAction" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter une commande script}}</a><br/><br/>
    <div class="alert alert-info">
        {{ Sous type : <br/>
        - Slider : mettre #slider# pour récupérer la valeur<br/>
        - Color : mettre #color# pour récupérer la valeur<br/>
        - Message : mettre #title# et #message#}}
    </div>
    <table id="table_cmd" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th style="width: 200px;">{{Nom}}</th>
                <th style="width: 100px;">{{Type script}}</th>
                <th style="width: 70px;">{{Type}}</th>
                <th>{{Requête}}</th>
                <th style="width: 400px;">{{Options}}</th>
                <th style="width: 110px;">{{Divers}}</th>
                <th style="width: 150px;">{{Paramètres}}</th>
                <th style="width: 150px;"></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
</div>
</div>
</div>

<div id="md_browseScriptFile" title="Parcourir...">
    <div style="display: none;" id="div_browseScriptFileAlert"></div>
    <div id="div_browseScriptFileTree"></div>
</div>

<div id="md_editScriptFile" title="Editer...">
    <div style="display: none;" id="div_editScriptFileAlert"></div>
    <textarea id="ta_editScriptFile" class="form-control" style="height: 100%;"></textarea>
</div>

<?php include_file('3rdparty', 'jquery.fileTree/jquery.easing.1.3', 'js', 'script');?>
<?php include_file('3rdparty', 'jquery.fileTree/jqueryFileTree', 'js', 'script');?>
<?php include_file('desktop', 'script', 'js', 'script');?>
<?php include_file('core', 'plugin.template', 'js');?>
