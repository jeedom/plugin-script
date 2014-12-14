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


// Script qui renvoie 1 si la connexion à internet est détectée, 0 sinon

if (php_sapi_name() != 'cli' || isset($_SERVER['REQUEST_METHOD']) || !isset($_SERVER['argc'])) {
    header("Status: 404 Not Found");
    header('HTTP/1.0 404 Not Found');
    $_SERVER['REDIRECT_STATUS'] = 404;
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    exit();
}


$shellOutput = trim(shell_exec('ping -s 1 -c 1 192.168.1.1 > /dev/null; echo $?'));
if ($shellOutput != 0) {
    echo 0;
    exit();
}

$shellOutput1 = trim(shell_exec('ping -s 1 -c 1 www.google.fr > /dev/null; echo $?'));
$shellOutput2 = trim(shell_exec('ping -s 1 -c 1 8.8.8.8 > /dev/null; echo $?'));
if (($shellOutput1 != 0) && ($shellOutput2 != 0)) {
    echo 0;
    exit();
}

echo 1;
exit();
?>
