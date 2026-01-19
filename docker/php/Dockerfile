FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    zip unzip git libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

WORKDIR /var/www/html
