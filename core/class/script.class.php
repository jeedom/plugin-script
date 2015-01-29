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

class script extends eqLogic {

    public static function cron() {
        foreach (eqLogic::byType('script') as $eqLogic) {
            $autorefresh = $eqLogic->getConfiguration('autorefresh');
            if ($eqLogic->getIsEnable() == 1 && $autorefresh != '') {
                try {
                    $c = new Cron\CronExpression($autorefresh, new Cron\FieldFactory);
                    if ($c->isDue()) {
                        try {
                            foreach ($eqLogic->getCmd('info') as $cmd) {
                                $value = $cmd->formatValue($cmd->execute());
                                if ($cmd->execCmd() != $value) {
                                    log::add('script', 'debug', 'Rafraîchissement de : ' . $cmd->getHumanName() . ' => Debut');
                                    $cmd->setCollectDate('');
                                    $cmd->event($value);
                                    log::add('script', 'debug', 'Rafraîchissement de : ' . $cmd->getHumanName() . ' => Fin, value => ' . $value);
                                }
                            }
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

    public static function shareOnMarket(&$market) {
        $cibDir = calculPath(config::byKey('userScriptDir', 'script') . '/' . $market->getLogicalId());
        if (!file_exists($cibDir)) {
            throw new Exception(__('Impossible de trouver le script  :', __FILE__) . $cibDir);
        }
        $tmp = dirname(__FILE__) . '/../../../../tmp/' . $market->getLogicalId() . '.zip';
        if (file_exists($tmp)) {
            if (!unlink($tmp)) {
                throw new Exception(__('Impossible de supprimer : ', __FILE__) . $tmp . __('. Vérifiez les droits', __FILE__));
            }
        }
        if (!create_zip($cibDir, $tmp)) {
            throw new Exception(__('Echec de création du zip. Répertoire source : ', __FILE__) . $cibDir . __(' / Répertoire cible : ', __FILE__) . $tmp);
        }
        return $tmp;
    }

    public static function getFromMarket(&$market, $_path) {
        $cibDir = calculPath(config::byKey('userScriptDir', 'script'));
        if (!file_exists($cibDir)) {
            throw new Exception(__('Impossible d\'installer le script. Le dossier n\'existe pas : ', __FILE__) . $cibDir);
        }
        $zip = new ZipArchive;
        $res = $zip->open($_path);
        if ($res === TRUE) {
            $zip->extractTo($cibDir . '/');
            $zip->close();
        } else {
            switch ($res) {
                case ZipArchive::ER_EXISTS:
                $ErrMsg = "Le fichier existe déjà.";
                break;
                case ZipArchive::ER_INCONS:
                $ErrMsg = "L'archive est inconsistante.";
                break;
                case ZipArchive::ER_MEMORY:
                $ErrMsg = "Echec d'allocation mémoire (malloc).";
                break;
                case ZipArchive::ER_NOENT:
                $ErrMsg = "Le fichier n'existe pas.";
                break;
                case ZipArchive::ER_NOZIP:
                $ErrMsg = "Ce n'est pas une archive zip.";
                break;
                case ZipArchive::ER_OPEN:
                $ErrMsg = "Le fichier ne peut pas être ouvert.";
                break;
                case ZipArchive::ER_READ:
                $ErrMsg = "Erreur de lecture.";
                break;
                case ZipArchive::ER_SEEK:
                $ErrMsg = "Erreur de recherche.";
                break;
                default:
                $ErrMsg = "Unknow (Code $res)";
                break;
            }
            throw new Exception(__('Impossible de décompresser l\'archive zip : ', __FILE__) . $_path . 'Erreur : ' . $ErrMsg);
        }
        $scriptPath = realpath(dirname(__FILE__) . '/../../../../' . config::byKey('userScriptDir', 'script') . '/' . $market->getLogicalId());
        if (!file_exists($scriptPath)) {
            throw new Exception(__('Echec de l\'installation. Impossible de trouver le script ', __FILE__) . $scriptPath);
        }
        chmod($scriptPath, 0770);
    }

    public static function removeFromMarket(&$market) {
        $scriptPath = calculPath(config::byKey('userScriptDir', 'script') . '/' . $market->getLogicalId());
        if (!file_exists($scriptPath)) {
            return true;
        }
        unlink($scriptPath);
        if (!file_exists($scriptPath)) {
            throw new Exception(__('Echec de la désinstallation. Impossible de supprimer le script ', __FILE__) . $scriptPath);
        }
    }

    public static function listMarketObject() {
        $return = array();
        foreach (ls(calculPath(config::byKey('userScriptDir', 'script')), '*') as $logical_id) {
            $return[] = $logical_id;
        }
        return $return;
    }

}

class scriptCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Méthodes statiques*************************** */


    /*     * *********************Méthodes d'instance************************* */

    public function preSave() {
        if ($this->getConfiguration('request') == '') {
            throw new Exception(__('Le champ requête ne peut pas être vide', __FILE__));
        }
        if ($this->getConfiguration('requestType') == '') {
            throw new Exception(__('Le champ requête type ne peut pas être vide', __FILE__));
        }
        if ($this->getConfiguration('requestType') == 'xml' && $this->getType() == 'action') {
            throw new Exception(__('Vous ne pouvez pas avoir un script de type XML et action', __FILE__));
        }
    }

    public function execute($_options = null) {

        $result = false;
        $request = str_replace('#API#', config::byKey('api'), $this->getConfiguration('request'));
        if (trim($request) == '') {
            throw new Exception(__('La requête ne peut pas être vide : ', __FILE__) . print_r($this, true));
        }

        if ($_options != null) {
            switch ($this->getType()) {
                case 'action' :
                switch ($this->getSubType()) {
                    case 'slider':
                    $request = str_replace('#slider#', $_options['slider'], $request);
                    break;
                    case 'color':
                    $request = str_replace('#color#', $_options['color'], $request);
                    break;
                    case 'message':
                    $replace = array('#title#', '#message#');
                    $replaceBy = array(urlencode($_options['title']), urlencode($_options['message']));
                    if ($_options['message'] == '' || $_options['title'] == '') {
                        throw new Exception(__('Le message et le sujet ne peuvent pas être vide', __FILE__));
                    }
                    $request = str_replace($replace, $replaceBy, $request);
                    break;
                }
                break;
            }
        }
        $request = scenarioExpression::setTags($request);
        $request = str_replace('"','',$request);


        switch ($this->getConfiguration('requestType')) {
            case 'http' :
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
            $result = trim($request_http->exec($this->getConfiguration('timeout', 2), $this->getConfiguration('maxHttpRetry', 3)));
            if (trim($this->getConfiguration('reponseMustContain')) != '' && strpos($result, trim($this->getConfiguration('reponseMustContain'))) === false) {
                throw new Exception(__('La réponse ne contient pas "', __FILE__) . $this->getConfiguration('reponseMustContain') . '" : "' . $result.'"');
            }
            break;
            case 'script' :
            if (strpos($request, '.php') !== false) {
                $request_shell = new com_shell('php ' . $request . ' 2>&1');
            } else if (strpos($request, '.rb') !== false) {
                $request_shell = new com_shell('ruby ' . $request . ' 2>&1');
            } else if (strpos($request, '.py') !== false) {
                $request_shell = new com_shell('python ' . $request . ' 2>&1');
            } else if (strpos($request, '.pl') !== false) {
                $request_shell = new com_shell('perl ' . $request . ' 2>&1');
            } else {
                $request_shell = new com_shell($request . ' 2>&1');
            }
            $result = trim($request_shell->exec());
            break;
            case 'xml' :
            if ($this->getConfiguration('xml_username') != '' && $this->getConfiguration('xml_password') != '') {
                $request_http = new com_http($this->getConfiguration('urlXml'), $this->getConfiguration('xml_username'), $this->getConfiguration('xml_password'));
            } else {
                $request_http = new com_http($this->getConfiguration('urlXml'));
            }
            if ($this->getConfiguration('xmlNoSslCheck') == 1) {
                $request_http->setNoSslCheck(true);
            }
            $xml = trim($request_http->exec($this->getConfiguration('xmlTimeout', 2), $this->getConfiguration('maxXmlRetry', 3)));
            try {
                $xml = new SimpleXMLElement($xml);
            } catch (Exception $e) {
                if ($this->getConfiguration('xml_username') != '' && $this->getConfiguration('xml_password') != '') {
                    $request_http = new com_http($this->getConfiguration('urlXml'), $this->getConfiguration('xml_username'), $this->getConfiguration('xml_password'));
                } else {
                    $request_http = new com_http($this->getConfiguration('urlXml'));
                }
                if ($this->getConfiguration('xmlNoSslCheck') == 1) {
                    $request_http->setNoSslCheck(true);
                }
                $xml = trim($request_http->exec($this->getConfiguration('xmlTimeout', 2), $this->getConfiguration('maxXmlRetry', 3)));
                $xml = new SimpleXMLElement($xml);
            }
            $json = json_decode(json_encode($xml), TRUE);
            $tags = explode('>', $request);
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (isset($json[$tag])) {
                    $json = $json[$tag];
                } else if (is_numeric(intval($tag)) && isset($json[intval($tag)])) {
                    $json = $json[intval($tag)];
                } else {
                    $json = '';
                    break;
                }
            }
            if (is_array($json)) {
                $result = '';
            } else {
                $result = $json;
            }
            return $result;
            case 'json' :
            if ($this->getConfiguration('json_username') != '' && $this->getConfiguration('json_password') != '') {
                $request_http = new com_http($this->getConfiguration('urlJson'), $this->getConfiguration('json_username'), $this->getConfiguration('json_password'));
            } else {
                $request_http = new com_http($this->getConfiguration('urlJson'));
            }
            if ($this->getConfiguration('jsonNoSslCheck') == 1) {
                $request_http->setNoSslCheck(true);
            }
            $json = trim($request_http->exec($this->getConfiguration('jsonTimeout', 2), $this->getConfiguration('maxJsonRetry', 3)));
            try {
                $json = json_decode($json, true);
            } catch (Exception $e) {
                if ($this->getConfiguration('json_username') != '' && $this->getConfiguration('json_username') != '') {
                    $request_http = new com_http($this->getConfiguration('urlJson'), $this->getConfiguration('json_username'), $this->getConfiguration('json_username'));
                } else {
                    $request_http = new com_http($this->getConfiguration('urlJson'));
                }
                if ($this->getConfiguration('jsonNoSslCheck') == 1) {
                    $request_http->setNoSslCheck(true);
                }
                $json = trim($request_http->exec($this->getConfiguration('jsonTimeout', 2), $this->getConfiguration('maxJsonRetry', 3)));
                $json = json_decode($json, true);
            }
            $tags = explode('>', $request);
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (isset($json[$tag])) {
                    $json = $json[$tag];
                } else if (is_numeric(intval($tag)) && isset($json[intval($tag)])) {
                    $json = $json[intval($tag)];
                } else {
                    $json = '';
                    break;
                }
            }
            if (is_array($json)) {
                $result = '';
            } else {
                $result = $json;
            }
            return $result;
        }
        /*if ($this->getType() == 'action') {
            sleep(1);
            foreach ($this->getEqLogic()->getCmd('info') as $cmd) {
                $value = $cmd->formatValue($cmd->execute());
                if ($cmd->execCmd(null, 2) != $value) {
                    $cmd->event($value);
                }
            }
        }*/
        return $this->formatValue($result);
    }

    /*     * **********************Getteur Setteur*************************** */
}

?>
