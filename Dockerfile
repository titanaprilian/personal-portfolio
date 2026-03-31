FROM php:8.3.6-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor \
    libmariadb-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -m -u 1000 -s /bin/bash appuser

COPY . /var/www

COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chown -R appuser:appuser /var/www

RUN composer install --no-dev --no-interaction --optimize-autoloader

EXPOSE 9000 8000

ENTRYPOINT ["/entrypoint.sh"]
