FROM php:8.2-fpm-alpine

WORKDIR /var/www/app

RUN apk update && apk add --no-cache \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    libzip-dev \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    vim \
    unzip \
    git \
    curl \
    oniguruma-dev 

RUN docker-php-ext-install pdo pdo_mysql gd mbstring zip exif pcntl

RUN apk add --no-cache nodejs npm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Pastikan direktori storage dan bootstrap/cache ada
RUN mkdir -p /var/www/app/storage /var/www/app/bootstrap/cache

# Set ownership dan permissions untuk direktori yang diperlukan
RUN chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache
RUN chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache
RUN mkdir -p /var/www/app/storage/logs && chmod -R 777 /var/www/app/storage

USER root

RUN chmod 777 -R /var/www/app
