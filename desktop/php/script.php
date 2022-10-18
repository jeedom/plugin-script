<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('script');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
$foldOnStart = config::byKey('foldOnStart', 'script', '0');
sendVarToJS('foldOnStart', $foldOnStart);
sendVarToJS('userScriptDir', getRootPath() . '/' . config::byKey('userScriptDir', 'script'));
?>
<style>
	.CodeMirror-scroll {
		height: 100%;
		overflow-y: auto;
		overflow-x: auto;
	}
</style>

<div class="row row-overflow">
	<div class="col-xs-12 eqLogicThumbnailDisplay">
		<legend><i class="fas fa-cog"></i> {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction logoPrimary" data-action="add">
				<i class="fas fa-plus-circle"></i>
				<br />
				<span>{{Ajouter}}</span>
			</div>
			<div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
				<i class="fas fa-wrench"></i>
				<br />
				<span>{{Configuration}}</span>
			</div>
		</div>
		<legend><i class="fas fa-file"></i> {{Mes Scripts}}</legend>
		<?php
		if (count($eqLogics) == 0) {
			echo '<br><div class="text-center" style="font-size:1.2em;font-weight:bold;">{{Aucun équipement trouvé, cliquer sur "Ajouter" pour commencer}}</div>';
		} else {
			// Champ de recherche
			echo '<div class="input-group" style="margin:5px;">';
			echo '<input class="form-control roundedLeft" placeholder="{{Rechercher}}" id="in_searchEqlogic">';
			echo '<div class="input-group-btn">';
			echo '<a id="bt_resetSearch" class="btn" style="width:30px"><i class="fas fa-times"></i></a>';
			echo '<a class="btn roundedRight hidden" id="bt_pluginDisplayAsTable" data-coreSupport="1" data-state="0"><i class="fas fa-grip-lines"></i></a>';
			echo '</div>';
			echo '</div>';
			// Liste des équipements du plugin
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '">';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '<span class="hiddenAsCard displayTableRight hidden">';
				if ($eqLogic->getConfiguration('autorefresh', '') != '') {
					echo '<span class="label label-info">' . $eqLogic->getConfiguration('autorefresh') . '</span>';
				}
				echo ($eqLogic->getIsVisible() == 1) ? '<i class="fas fa-eye" title="{{Equipement visible}}"></i>' : '<i class="fas fa-eye-slash" title="{{Equipement non visible}}"></i>';
				echo '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		?>
	</div>

	<div class="col-xs-12 eqLogic" style="display: none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-default btn-sm eqLogicAction" data-action="configure"><i class="fas fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fas fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fas fa-list"></i> {{Commandes}}</a></li>
		</ul>
		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<form class="form-horizontal">
					<fieldset>
						<div class="col-lg-7">
							<legend><i class="fas fa-wrench"></i> {{Paramètres généraux}}</legend>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Nom de l'équipement}}</label>
								<div class="col-sm-6">
									<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display:none;">
									<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Objet parent}}</label>
								<div class="col-sm-6">
									<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
										<option value="">{{Aucun}}</option>
										<?php
										$options = '';
										foreach ((jeeObject::buildTree(null, false)) as $object) {
											$options .= '<option value="' . $object->getId() . '">' . str_repeat('&nbsp;&nbsp;', $object->getConfiguration('parentNumber')) . $object->getName() . '</option>';
										}
										echo $options;
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Catégorie}}</label>
								<div class="col-sm-6">
									<?php
									foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
										echo '<label class="checkbox-inline">';
										echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" >' . $value['name'];
										echo '</label>';
									}
									?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Options}}</label>
								<div class="col-sm-6">
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked>{{Activer}}</label>
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked>{{Visible}}</label>
								</div>
							</div>

							<legend><i class="fas fa-cogs"></i> {{Paramètres spécifiques}}</legend>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Auto-actualisation}}
									<sup><i class="fas fa-question-circle tooltips" title="{{Fréquence de rafraîchissement des commandes infos de l'équipement}}"></i></sup>
								</label>
								<div class="col-sm-6">
									<div class="input-group">
										<input type="text" class="eqLogicAttr form-control roundedLeft" data-l1key="configuration" data-l2key="autorefresh" placeholder="{{Cliquer sur ? pour afficher l'assistant cron}}">
										<span class="input-group-btn">
											<a class="btn btn-default cursor jeeHelper roundedRight" data-helper="cron" title="Assistant cron">
												<i class="fas fa-question-circle"></i>
											</a>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">{{Délai avant d'actualiser les infos suite à une action (en secondes)}}</label>
								<div class="col-sm-6">
									<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="delayBeforeRefrehInfo" />
								</div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane" id="commandtab">
				<a class="btn btn-default btn-sm cmdAction pull-right" style="margin-top:5px;" data-action="add"><i class="fas fa-plus-circle"></i> {{Ajouter une commande script}}</a>
				<br />
				<br />
				<div class="alert alert-info">
					{{ Sous type :}} <br />
					- {{Curseur : mettre #slider# pour récupérer la valeur}}<br />
					- {{Couleur : mettre #color# pour récupérer la valeur}}<br />
					- {{Message : mettre #title# et #message#}}<br />
					- {{Liste : value|display;}}
				</div>
				<br />
				<table id="table_cmd" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th style="min-width:150px;width:200px;">{{Nom}}</th>
							<th style="width: 100px;">{{Type script}}</th>
							<th style="width: 70px;">{{Type}}</th>
							<th style="width: 300px;">{{Requête}}</th>
							<th style="width: 360px;">{{Paramètres}}</th>
							<th style="min-width:260px;width:300px">{{Options}}</th>
							<th>{{Etat}}</th>
							<th style="min-width:80px;width:150px;">{{Actions}}</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div id="md_browseScriptFile" class="hidden" title="Parcourir...">
	<div style="display: none;" id="div_browseScriptFileAlert"></div>
	<div id="div_browseScriptFileTree"></div>
</div>

<div id="md_editScriptFile" class="hidden" title="Editer...">
	<div style="display: none;" id="div_editScriptFileAlert"></div>
	<textarea id="ta_editScriptFile" class="form-control" style="height: 100%;"></textarea>
</div>

<?php
include_file('3rdparty', 'jquery.fileTree/jqueryFileTree', 'css', 'script');
include_file('3rdparty', 'codemirror/lib/codemirror', 'js');
include_file('3rdparty', 'codemirror/lib/codemirror', 'css');

include_file('3rdparty', 'codemirror/mode/htmlmixed/htmlmixed', 'js');
include_file('3rdparty', 'codemirror/mode/clike/clike', 'js');
include_file('3rdparty', 'codemirror/mode/php/php', 'js');
include_file('3rdparty', 'codemirror/mode/shell/shell', 'js');
include_file('3rdparty', 'codemirror/mode/python/python', 'js');
include_file('3rdparty', 'codemirror/mode/ruby/ruby', 'js');
include_file('3rdparty', 'codemirror/mode/perl/perl', 'js');

//Core CodeMirror addons:
include_file('3rdparty', 'codemirror/addon/edit/matchbrackets', 'js');
include_file('3rdparty', 'codemirror/addon/selection/active-line', 'js');
include_file('3rdparty', 'codemirror/addon/search/search', 'js');
include_file('3rdparty', 'codemirror/addon/search/searchcursor', 'js');
include_file('3rdparty', 'codemirror/addon/dialog/dialog', 'js');
include_file('3rdparty', 'codemirror/addon/dialog/dialog', 'css');

include_file('3rdparty', 'codemirror/addon/fold/brace-fold', 'js');
include_file('3rdparty', 'codemirror/addon/fold/comment-fold', 'js');
include_file('3rdparty', 'codemirror/addon/fold/foldcode', 'js');
include_file('3rdparty', 'codemirror/addon/fold/indent-fold', 'js');
include_file('3rdparty', 'codemirror/addon/fold/markdown-fold', 'js');
include_file('3rdparty', 'codemirror/addon/fold/xml-fold', 'js');
include_file('3rdparty', 'codemirror/addon/fold/foldgutter', 'js');
include_file('3rdparty', 'codemirror/addon/fold/foldgutter', 'css');

include_file('3rdparty', 'jquery.fileTree/jquery.easing.1.3', 'js', 'script');
include_file('3rdparty', 'jquery.fileTree/jqueryFileTree', 'js', 'script');
include_file('desktop', 'script', 'js', 'script');
include_file('core', 'plugin.template', 'js');
?>