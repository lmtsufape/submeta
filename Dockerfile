FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    libpq-dev \
    libcurl4-openssl-dev \
    zip \
    unzip

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    intl \
    zip \
    xml \
    gd \
    bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www