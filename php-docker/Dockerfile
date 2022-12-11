FROM php:8.1-fpm
COPY ./php.ini /user/local/etc/php
RUN apt update
# Install Postgre PDO
RUN apt install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
# RUN docker-php-ext-install pdo_pgsql