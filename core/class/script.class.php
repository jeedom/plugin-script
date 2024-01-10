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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
require_once dirname(__FILE__) . '/../../vendor/autoload.php';

class script extends eqLogic {

	/*     * *************************Attributs****************************** */

	public static $_requet_cache = array();

	/*     * ***********************Méthodes statiques*************************** */

	public static function cron() {
		$dateRun = new DateTime();
		foreach (eqLogic::byType('script') as $eqLogic) {
			$autorefresh = $eqLogic->getConfiguration('autorefresh');
			if ($eqLogic->getIsEnable() == 1 && $autorefresh != '') {
				try {
					$c = new Cron\CronExpression($autorefresh, new Cron\FieldFactory);
					if ($c->isDue($dateRun)) {
						try {
							$eqLogic->refresh();
						} catch (Exception $exc) {
							log::add('script', 'error', __('Erreur pour ', __FILE__) . $eqLogic->getHumanName() . ' : ' . $exc->getMessage());
						}
					}
				} catch (Exception $exc) {
					log::add('script', 'error', __('Expression cron non valide pour ', __FILE__) . $eqLogic->getHumanName() . ' : ' . $autorefresh);
				}
			}
		}
	}

	/*     * *********************Méthodes d'instance************************* */

	public function postSave() {
		$refresh = $this->getCmd(null, 'refresh');
		if (!is_object($refresh)) {
			$refresh = new scriptCmd();
			$refresh->setLogicalId('refresh');
			$refresh->setIsVisible(1);
			$refresh->setName(__('Rafraichir', __FILE__));
		}
		$refresh->setType('action');
		$refresh->setSubType('other');
		$refresh->setEqLogic_id($this->getId());
		$refresh->save();
	}

	public function refresh() {
		foreach ($this->getCmd('info') as $cmd) {
			try {
				$cmd->refresh();
			} catch (Exception $exc) {
				log::add('script', 'error', __('Erreur pour ', __FILE__) . $cmd->getHumanName() . ' : ' . $exc->getMessage());
			}
		}
	}

	/*     * **********************Getteur Setteur*************************** */
}

class scriptCmd extends cmd {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Méthodes statiques*************************** */

	/*     * *********************Méthodes d'instance************************* */

	public function dontRemoveCmd() {
		if ($this->getLogicalId() == 'refresh') {
			return true;
		}
		return false;
	}

	public function refresh() {
		if ($this->getType() != 'info' || trim($this->getConfiguration('request')) == '') {
			return;
		}
		$this->getEqLogic()->checkAndUpdateCmd($this, $this->execute());
	}

	public function preSave() {
		if ($this->getLogicalId() == 'refresh') {
			return;
		}
		if ($this->getConfiguration('request') == '' && $this->getType() != 'info') {
			throw new Exception(__('Le champ requête ne peut pas être vide', __FILE__));
		}
		if ($this->getConfiguration('requestType') == '') {
			throw new Exception(__('Le champ requête type ne peut pas être vide', __FILE__));
		}
		if ($this->getConfiguration('requestType') == 'xml' && $this->getType() == 'action') {
			throw new Exception(__('Vous ne pouvez pas avoir un script de type XML et action', __FILE__));
		}
	}

	public function postSave() {
		if ($this->getLogicalId() == 'refresh' || $this->getEqlogic()->getIsEnable() != 1) {
			return;
		}
		$this->refresh();
	}

	private function replaceTags($request) {
		$request = scenarioExpression::setTags($request);
		$replace = array(
			'\'' => '',
			'#eqLogic_id#' => $this->getEqLogic_id(),
			'#cmd_id#' => $this->getId(),
		);
		return str_replace(array_keys($replace), $replace, $request);
	}

	public function execute($_options = null) {
		if ($this->getLogicalId() == 'refresh') {
			$this->getEqLogic()->refresh();
			return;
		}
		$result = false;
		$request = str_replace('#API#', config::byKey('api'), $this->getConfiguration('request'));
		if (trim($request) == '') {
			throw new Exception(__('La requête ne peut pas être vide : ', __FILE__) . print_r($this, true));
		}
		if ($_options != null) {
			switch ($this->getType()) {
				case 'action':
					switch ($this->getSubType()) {
						case 'slider':
							$request = str_replace('#slider#', $_options['slider'], $request);
							break;
						case 'color':
							if ($this->getConfiguration('requestType') != 'http') {
								$request = str_replace('#color#', $_options['color'], $request);
							} else {
								$request = str_replace('#color#', substr($_options['color'], 1), $request);
							}
							break;
						case 'select':
							$request = str_replace('#select#', $_options['select'], $request);
							break;
						case 'message':
							$replace = array('#title#', '#message#');
							if ($this->getConfiguration('requestType') == 'http') {
								$replaceBy = array(urlencode($_options['title']), urlencode($_options['message']));
							} elseif ($this->getConfiguration('requestType') == 'script') {
								$replaceBy = array($_options['title'], $_options['message']);
							} else {
								$replaceBy = array(escapeshellcmd($_options['title']), escapeshellcmd($_options['message']));
							}
							if ($_options['message'] == '' && $_options['title'] == '') {
								throw new Exception(__('Le message et le sujet ne peuvent pas être vide', __FILE__));
							}
							$request = str_replace($replace, $replaceBy, $request);
							break;
					}
					break;
			}
		}
		$request = $this->replaceTags($request);

		switch ($this->getConfiguration('requestType')) {
			case 'http':
				$request = str_replace('"', '%22', $request);
				$request = str_replace(' ', '%20', $request);
				$request = str_replace('json::', '', $request);
				if ($this->getType() == 'info' && isset(script::$_requet_cache[$request])) {
					return script::$_requet_cache[$request];
				}
				if ($this->getConfiguration('http_username') != '' && $this->getConfiguration('http_password') != '') {
					$request_http = new com_http($request, $this->getConfiguration('http_username'), $this->getConfiguration('http_password'));
				} else {
					$request_http = new com_http($request);
				}
				if ($this->getConfiguration('allowEmptyResponse') == 1) {
					$request_http->setAllowEmptyReponse(true);
				}
				if ($this->getConfiguration('noSslCheck') == 1) {
					$request_http->setNoSslCheck(true);
				}
				if ($this->getConfiguration('doNotReportHttpError') == 1) {
					$request_http->setNoReportError(true);
				}
				if ($this->getType() == 'action') {
					$request_http->setPost($request);
				}
				if (isset($_options['speedAndNoErrorReport']) && $_options['speedAndNoErrorReport'] == true) {
					$request_http->setNoReportError(true);
					$request_http->exec(0.1, 1);
				} else {
					$result = trim($request_http->exec($this->getConfiguration('timeout', 2), $this->getConfiguration('maxHttpRetry', 3)));
					if ($this->getType() == 'info') {
						script::$_requet_cache[$request] = $result;
					}
				}
				if ($this->getType() == 'action') {
					return;
				}
				if (trim($this->getConfiguration('reponseMustContain')) != '' && strpos($result, trim($this->getConfiguration('reponseMustContain'))) === false) {
					throw new Exception(__('La réponse ne contient pas "', __FILE__) . $this->getConfiguration('reponseMustContain') . '" : "' . $result . '"');
				}
				if ($this->getType() == 'info') {
					return $result;
				}
				break;
			case 'script':
				if ($this->getType() == 'info' && isset(script::$_requet_cache[$request])) {
					return script::$_requet_cache[$request];
				}
				$cmd = 'sudo chmod +x ' . explode(' ', $request)[0] . ' 2>/dev/null;';
				if (strpos($request, '.php') !== false) {
					$cmd .= 'php ' . $request;
				} elseif (strpos($request, '.rb') !== false) {
					$cmd .= 'ruby ' . $request;
				} elseif (strpos($request, '.py') !== false) {
					$cmd .= 'python ' . $request;
				} elseif (strpos($request, '.pl') !== false) {
					$cmd .= 'perl ' . $request;
				} else {
					$cmd .= $request;
				}
				$request_shell = new com_shell($cmd . ' 2>&1');
				if (isset($_options['speedAndNoErrorReport']) && $_options['speedAndNoErrorReport'] == true) {
					$request_shell->setBackground(true);
				}
				$result = trim($request_shell->exec());
				log::add('script', 'debug', 'Exécution de : ' . $cmd . ' => ' . $result);
				if ($this->getType() == 'info') {
					script::$_requet_cache[$request] = $result;
					return $result;
				}
				break;
			case 'xml':
				$request = str_replace('"', '', $request);
				$request = str_replace('json::', '', $request);
				$urlXml = $this->replaceTags($this->getConfiguration('urlXml'));
				if ($this->getType() == 'info' && isset(script::$_requet_cache[$urlXml])) {
					$xml = script::$_requet_cache[$urlXml];
				} else {
					if ($this->getConfiguration('xml_username') != '' && $this->getConfiguration('xml_password') != '') {
						$request_http = new com_http($urlXml, $this->getConfiguration('xml_username'), $this->getConfiguration('xml_password'));
					} else {
						$request_http = new com_http($urlXml);
					}
					if ($this->getConfiguration('xmlNoSslCheck') == 1) {
						$request_http->setNoSslCheck(true);
					}
					if ($this->getType() == 'action') {
						$request_http->setPost($request);
					}
					$xml = trim($request_http->exec($this->getConfiguration('xmlTimeout', 2), $this->getConfiguration('maxXmlRetry', 3)));
					if ($this->getType() == 'action') {
						return;
					}
					if ($this->getType() == 'info') {
						script::$_requet_cache[$urlXml] = $xml;
					}
				}
				$xml = new SimpleXMLElement($xml);
				$json = json_decode(json_encode($xml), TRUE);
				$tags = explode('>', $request);
				foreach ($tags as $tag) {
					$tag = trim($tag);
					if (isset($json[$tag])) {
						$json = $json[$tag];
					} elseif (is_numeric(intval($tag)) && isset($json[intval($tag)])) {
						$json = $json[intval($tag)];
					} elseif (is_numeric(intval($tag)) && intval($tag) < 0 && isset($json[count($json) + intval($tag)])) {
						$json = $json[count($json) + intval($tag)];
					} else {
						$json = '';
						break;
					}
				}
				if ($this->getType() == 'info') {
					return (is_array($json)) ? json_encode($json) : $json;
				}
				break;
			case 'json':
				$request = str_replace('"', '', $request);
				$request = str_replace('json::', '', $request);
				$urlJson = $this->replaceTags($this->getConfiguration('urlJson'));
				if ($this->getType() == 'info' && isset(script::$_requet_cache[$urlJson])) {
					$json_str = script::$_requet_cache[$urlJson];
				} else {
					if ($this->getConfiguration('json_username') != '' && $this->getConfiguration('json_password') != '') {
						$request_http = new com_http($urlJson, $this->getConfiguration('json_username'), $this->getConfiguration('json_password'));
					} else {
						$request_http = new com_http($urlJson);
					}
					if ($this->getConfiguration('jsonNoSslCheck') == 1) {
						$request_http->setNoSslCheck(true);
					}
					if ($this->getType() == 'action' && trim($request) != '') {
						$request_http->setPost($request);
					}
					$json_str = trim($request_http->exec($this->getConfiguration('jsonTimeout', 2), $this->getConfiguration('maxJsonRetry', 3)));
					if ($this->getType() == 'action') {
						return;
					}
					if ($this->getType() == 'info') {
						script::$_requet_cache[$urlJson] = $json_str;
					}
				}
				$json = json_decode($json_str, true);
				if ($json === null) {
					$json = json_decode($json_str, true, 512, JSON_INVALID_UTF8_IGNORE);
					if ($json === null) {
						throw new Exception(__('Json invalide ou non décodable : ', __FILE__) . $json_str);
					}
				}
				log::add('script', 'debug', 'tags : ' . $request);
				log::add('script', 'debug', 'json : ' . json_encode($json));
				$tags = explode('>', $request);
				foreach ($tags as $tag) {
					$tag = trim($tag);
					log::add('script', 'debug', 'tag : ' . $tag);
					if (isset($json[$tag])) {
						$json = $json[$tag];
					} elseif (strpos($tag, '@') !== false && strpos($tag, '=') !== false) {
						$tag = ltrim($tag, "@");
						$conditions = explode('&', $tag);
						foreach ($json as $json_element) {
							$found = true;
							foreach ($conditions as $condition) {
								$condition_kv = explode('=', $condition, 2);
								$condition_k = trim($condition_kv[0]);
								$condition_v = trim($condition_kv[1]);
								if ($json_element[$condition_k] == $condition_v) {
									$found = $found && true;
								} else {
									$found = false;
								}
							}
							if ($found) {
								$json = $json_element;
								break;
							}
						}
						if (!$found) {
							$json = '';
							log::add('script', 'debug', 'tag not found');
							break;
						}
					} elseif (is_numeric(intval($tag)) && isset($json[intval($tag)])) {
						$json = $json[intval($tag)];
					} elseif (is_numeric(intval($tag)) && intval($tag) < 0 && isset($json[count($json) + intval($tag)])) {
						$json = $json[count($json) + intval($tag)];
					} else {
						$json = '';
						log::add('script', 'debug', 'tag not found');
						break;
					}
					log::add('script', 'debug', 'json : ' . json_encode($json));
				}
				if ($this->getType() == 'info') {
					return (is_array($json)) ? json_encode($json) : $json;
				}
				break;
			case 'html':
				$request = str_replace('"', '', $request);
				$request = str_replace('json::', '', $request);
				$urlHtml = $this->replaceTags($this->getConfiguration('urlHtml'));
				if ($this->getType() == 'info' && isset(script::$_requet_cache[$urlHtml])) {
					$html = script::$_requet_cache[$urlHtml];
				} else {
					if ($this->getConfiguration('html_username') != '' && $this->getConfiguration('html_password') != '') {
						$request_http = new com_http($urlHtml, $this->getConfiguration('html_username'), $this->getConfiguration('html_password'));
					} else {
						$request_http = new com_http($urlHtml);
					}
					if ($this->getConfiguration('htmlNoSslCheck') == 1) {
						$request_http->setNoSslCheck(true);
					}
					if ($this->getType() == 'action') {
						$request_http->setPost($request);
					}
					$html = $request_http->exec($this->getConfiguration('htmlTimeout', 2), $this->getConfiguration('maxHtmlRetry', 3));
					if ($this->getType() == 'action') {
						return;
					}
					if ($this->getType() == 'info') {
						script::$_requet_cache[$urlHtml] = $html;
					}
				}
				phpQuery::newDocumentHTML($html);
				if ($this->getType() == 'info') {
					return pq(trim($request))->html();
				}
				break;
		}
		if ($this->getType() == 'action') {
			script::$_requet_cache = array();
			if ($this->getEqLogic()->getConfiguration('delayBeforeRefrehInfo') != '') {
				usleep($this->getEqLogic()->getConfiguration('delayBeforeRefrehInfo') * 1000000);
			}
			$this->getEqLogic()->refresh();
		}
	}

	/*     * **********************Getteur Setteur*************************** */
}
