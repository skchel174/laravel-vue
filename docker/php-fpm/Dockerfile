FROM php:8.4-fpm-alpine

RUN apk update && docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www
