FROM php:7.1.12-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libfreetype6-dev libjpeg62-turbo-dev

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/;
RUN docker-php-ext-install pdo_mysql zip gd
