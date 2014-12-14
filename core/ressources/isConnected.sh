#/bin/bash

# This file is part of Jeedom.
#
# Jeedom is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# Jeedom is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Jeedom. If not, see <http://www.gnu.org/licenses/>.

#Script shell permettant de savoir si une adresse mac ou ip est présente sur le réseau
# Nécessite arp-scan
# $1  : mac ou ip
# $2  : adresse
# Il faut ajouter les droits à apache (www-data) d'exécuter la commande arp-scan
# Dans un terminal :
# sudo apt-get install arp-scan fping #installation du paquet permettant de scanner le réseau et du paquet pour faire un ping rapide
# sudo visudo -s
# Ajouter la ligne :
# www-data ALL=NOPASSWD: /usr/bin/arp-scan
if [ "$1" = "mac" ]; then
        sudo /usr/bin/arp-scan -l -g --retry=5 -T $2 -t 800 | grep -i $2 | wc -l
elif [ "$1" = "ip" ]; then
        /usr/bin/fping -c1 -t50  $2 2>&1 | grep "min/avg/max" | wc -l
fi
