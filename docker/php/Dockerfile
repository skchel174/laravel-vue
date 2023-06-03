FROM php:8.1-fpm-alpine

RUN docker-php-ext-install mysqli pdo pdo_mysql

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /var/www
