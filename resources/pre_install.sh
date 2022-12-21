#!/bin/bash

set -x  # make sure each command is printed in the terminal
echo "Pre installation de l'installation/mise à jour des dépendances mqttLinky"

PROGRESS_FILE=/tmp/jeedom_install_in_progress_mqttLinky
echo 5 > ${PROGRESS_FILE}

BASEDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

cd ${BASEDIR}
if [ -d "${BASEDIR}/mqtt4teleinfo" ]; then
  rm -R ${BASEDIR}/mqtt4teleinfo
fi

echo 5 > ${PROGRESS_FILE}
git clone --depth 1 https://github.com/WoCha-FR/mqtt4teleinfo.git ${BASEDIR}/mqtt4teleinfo

echo 15 > ${PROGRESS_FILE}
echo "Pre install finished"
