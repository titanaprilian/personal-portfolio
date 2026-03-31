#!/bin/bash

if [ ! -f /var/www/.env ]; then
    cp /var/www/.env.example /var/www/.env
fi

php /var/www/artisan key:generate
php /var/www/artisan config:clear
php /var/www/artisan migrate --no-interaction

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
