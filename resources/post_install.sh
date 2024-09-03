#!/bin/bash

set -x  # make sure each command is printed in the terminal
echo "Post installation de l'installation/mise à jour des dépendances mqttLinky"

PROGRESS_FILE=/tmp/jeedom_install_in_progress_mqttLinky
echo 50 > ${PROGRESS_FILE}

BASEDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
cd ${BASEDIR}
source ../core/config/mqttLinky.config.ini &> /dev/null
echo "Version requise : ${mqttLinkyRequire}"

npm i mqtt4teleinfo@${mqttLinkyRequire} --no-save

echo 90 > ${PROGRESS_FILE}
chown www-data:www-data -R ${BASEDIR}/node_modules