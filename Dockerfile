FROM php:8.1.0-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get -y update
RUN apt-get -y install git
RUN apt-get -y install zip
