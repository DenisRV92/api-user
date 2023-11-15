FROM php:8.1-fpm-alpine

RUN apk update && \
    apk add --no-cache libzip-dev libpq-dev nginx bash && \
    docker-php-ext-install zip pdo pdo_pgsql

ADD ./_docker/app/php/php.ini /usr/local/etc/php/conf.d

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY --chown=www-data:www-data . .

RUN composer install

EXPOSE 80

CMD php bin/console doctrine:migrations:migrate --no-interaction && \
    php bin/console doctrine:fixtures:load --no-interaction --purge-with-truncate && \
    php-fpm
