FROM php:8.1-fpm

ARG ARG_COMPOSER_HOME=/var/composer
ARG ARG_SF_ENV

ENV SF_ENV=${ARG_SF_ENV}
ENV COMPOSER_HOME=${ARG_COMPOSER_HOME}
ENV APP_ENV=dev

# Install libs dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
        acl \
        libbz2-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        unzip \
        apt-utils \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev \
        libpq-dev \
        librabbitmq-dev \
    && docker-php-ext-install \
        zip \
        bz2 \
        intl \
        pgsql \
        pdo_pgsql \
        sockets \
        bcmath \
        soap

## Install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Multi-stage build, install COMPOSER from official COMPOSER image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# create COMPOSER home folder
RUN mkdir -p ${ARG_COMPOSER_HOME} \
    && chmod -R 777 ${ARG_COMPOSER_HOME}

COPY --chown=www-data:www-data docker/php/conf/php-fpm.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/app