FROM php:8.1.7-fpm-bullseye

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        wget \
        libfreetype6-dev \
        libxml2-dev \
        mariadb-client \
        libc-client-dev \
        libwebp-dev \
        libkrb5-dev \
        libpng-dev \
        libjpeg-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure \
            gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
            intl \
            pdo_mysql \
            exif \
            gd \
    && pecl install redis \
    && docker-php-ext-enable redis

RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY config/app.ini $PHP_INI_DIR/conf.d/m6.ini
