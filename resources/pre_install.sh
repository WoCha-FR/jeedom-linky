#!/bin/bash

set -x  # make sure each command is printed in the terminal
echo "Pre installation de l'installation/mise à jour des dépendances mqttLinky"

PROGRESS_FILE=/tmp/jeedom_install_in_progress_mqttLinky
echo 5 > ${PROGRESS_FILE}

BASEDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
source ../core/config/mqttLinky.config.ini &> /dev/null
echo "Version requise : ${mqttLinkyRequire}"

cd ${BASEDIR}
if [ -d "${BASEDIR}/mqtt4teleinfo" ]; then
  rm -R ${BASEDIR}/mqtt4teleinfo
fi

echo 5 > ${PROGRESS_FILE}
curl -L -s https://github.com/WoCha-FR/mqtt4teleinfo/archive/refs/tags/${mqttLinkyRequire}.tar.gz | tar zxf -
mv mqtt4teleinfo-${mqttLinkyRequire} mqtt4teleinfo

echo 15 > ${PROGRESS_FILE}
echo "Pre install finished"
