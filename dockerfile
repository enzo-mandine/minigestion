FROM php:8.4-apache

RUN apt-get update && apt-get install -y libicu-dev libzip-dev unzip \
    && docker-php-ext-install intl mysqli pdo_mysql zip \
    && a2enmod rewrite

# CodeIgniter sert le site depuis le dossier /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf