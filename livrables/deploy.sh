#!/bin/bash

echo "mise à jour du système"
apt-get upgrade
apt-get dist-upgrade


echo "installation de l'environnement"
apt-get install php5
apt-get install apache2
apt-get install mysql-server
apt-get install git
mkdir -p /usr/local/bin
curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
chmod a+x /usr/local/bin/symfony

cd /var/www/html
mkdir websiteAsptt
cd websiteAsptt

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

php composer-setup.php

php -r "unlink('composer-setup.php');"

echo "telechargement du repository"
git clone https://github.com/EquipeBravo/Projet-fil-rouge.git

echo "nettoyage du cache"
php bin/console cache:clear
php bin/console cache:clear --env=prod


chmod -R 766 var/logs
chmod -R 766 var/cache

echo "installation des dépendances et de la database"
php composer.phar install

php bin/console doctrine:database:create
php bin/console doctrine:schema:update –force


