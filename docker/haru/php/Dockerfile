FROM php:8.2.10-apache

RUN apt update \
        && apt install -y \
            g++ \
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev \
            npm \
            nodejs \
            vim \
        && docker-php-ext-install \
            intl \
            opcache \
            pdo \
            pdo_pgsql \
            pgsql

WORKDIR /var/www/haru/src

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer