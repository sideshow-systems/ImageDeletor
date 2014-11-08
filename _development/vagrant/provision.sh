#!/usr/bin/env bash

echo ">> provisioning is running..."
echo " "
echo " "

echo 'Acquire::http::Proxy "http://192.168.178.24:9999";' > /etc/apt/apt.conf.d/01proxy

echo "" > /etc/apt/sources.list
echo "deb http://ftp.de.debian.org/debian/ wheezy main" >> /etc/apt/sources.list
echo "deb-src http://ftp.de.debian.org/debian/ wheezy main" >> /etc/apt/sources.list
echo "deb http://security.debian.org wheezy/updates main" >> /etc/apt/sources.list

apt-get update
apt-get -y upgrade

apt-get -y purge vim-tiny
apt-get install -y vim git-core
apt-get -y purge nano

# install image magick
apt-get install -y build-essential checkinstall libx11-dev libxext-dev zlib1g-dev libpng12-dev libjpeg-dev libfreetype6-dev libxml2-dev
apt-get -y build-dep imagemagick

sudo apt-get install -y phpunit

apt-get install -y apache2 php5 libapache2-mod-php5 php5-gd php5-curl

VHOST=$(cat <<EOF
<VirtualHost *:80>
  DocumentRoot "/vagrant/public"
  ServerName localhost
  <Directory "/vagrant/public">
    AllowOverride All
  </Directory>
  CustomLog /vagrant/logs/apache_access_log.log common
  ErrorLog /vagrant/logs/apache_error_log.log
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-enabled/000-default
sudo a2enmod rewrite

echo 'alias ll="ls -la"' >> /home/vagrant/.profile

# bugfix for VirtualBox folder sync, otherwise use nfs foldersharing in vagrantfile
# http://docs.vagrantup.com/v2/synced-folders/virtualbox.html
sudo echo 'EnableSendfile Off' >> /etc/apache2/apache2.conf

# restart apache
sudo /etc/init.d/apache2 restart

# install composer and run it
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /bin/composer.phar
sudo mkdir /vagrant/vendor
chmod 777 /vagrant/vendor
cd /vagrant
sudo COMPOSER=/vagrant/config/composer.json /bin/composer.phar install

apt-get clean