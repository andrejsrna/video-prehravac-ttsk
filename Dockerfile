FROM php:8.3-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

RUN mkdir -p /var/www/html/video \
    && chown -R www-data:www-data /var/www/html/video \
    && a2enmod headers

EXPOSE 80
