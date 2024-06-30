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

function script_install() {
	$cron = cron::byClassAndFunction('script', 'cronUpdate');
	if (!is_object($cron)) {
		$cron = new cron();
	}
	$cron->setClass('script');
	$cron->setFunction('cronUpdate');
	$cron->setSchedule('* * * * *');
	$cron->setEnable(1);
	$cron->setDeamon(0);
	$cron->save();
}

function script_update() {
	shell_exec('mv '.__DIR__.'/../core/ressources/* '.__DIR__.'/../data/');
	$cron = cron::byClassAndFunction('script', 'pull');
	if (is_object($cron)) {
		$cron->remove();
	}
	foreach (script::byType('script') as $script) {
		foreach ($script->getCmd() as $cmd) {
			$cmd->setConfiguration('request',str_replace('core/ressources','data',$cmd->getConfiguration('request')));
			$cmd->save(true);
		}
		$script->save();
	}

	$cron = cron::byClassAndFunction('script', 'cronUpdate');
	if (!is_object($cron)) {
		$cron = new cron();
	}
	$cron->setClass('script');
	$cron->setFunction('cronUpdate');
	$cron->setSchedule('* * * * *');
	$cron->setEnable(1);
	$cron->setDeamon(0);
	$cron->save();
}


function script_remove() {
	$cron = cron::byClassAndFunction('script', 'cronUpdate');
	if (is_object($cron)) {
		$cron->remove();
	}
}

?>
