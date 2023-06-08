# syntax=docker/dockerfile:1
FROM --platform=linux/amd64 php:8.1.19-fpm-alpine3.16

# Docker image context
LABEL Maintainer="Alcides Ramos <info@alcidesramos.com>"
LABEL Description="Zenrows - Web scrapping with PHP"

# Install dependencies via <apt>

RUN apk update && apk add --no-cache \
        libzip-dev \
        zip \
        unzip \
        bash \
        fcgi \
    && docker-php-ext-install zip

# Install PCOV

RUN apk update && apk add --no-cache \
        g++ \
        autoconf \
        make \
        pcre2-dev \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && apk del --no-cache \
        g++ \
        autoconf \
        make \
        pcre2-dev

# Install Composer

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Define the working directory

WORKDIR /code
