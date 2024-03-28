FROM php:8.0-apache
COPY ./ .

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

EXPOSE 80
