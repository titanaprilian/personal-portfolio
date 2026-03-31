#!/bin/bash

if [ ! -f /var/www/.env ]; then
    cp /var/www/.env.example /var/www/.env
fi

sed -i "s/DB_HOST=.*/DB_HOST=${DB_HOST:-db}/" /var/www/.env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_DATABASE:-laravel_portfolio}/" /var/www/.env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=${DB_USERNAME:-root}/" /var/www/.env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD:-root}/" /var/www/.env

php /var/www/artisan key:generate
php /var/www/artisan config:clear
php /var/www/artisan migrate --no-interaction
php /var/www/artisan storage:link

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
