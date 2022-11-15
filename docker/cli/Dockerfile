FROM php:8.1.7-cli-bullseye

ENV DEBIAN_FRONTEND noninteractive
ENV APT_KEY_DONT_WARN_ON_DANGEROUS_USAGE=1

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        wget \
        git \
        unzip \
        libfreetype6-dev \
        libxml2-dev \
        mariadb-client \
        libc-client-dev \
        libkrb5-dev \
        libwebp-dev \
        libpng-dev \
        libzip-dev \
        libjpeg-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure \
            gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
            intl \
            pdo_mysql \
            exif \
            gd \
            zip \
    && pecl install redis \
    && docker-php-ext-enable redis

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY config/cli.ini $PHP_INI_DIR/conf.d/m6.ini
