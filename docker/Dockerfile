FROM php:8.4-fpm-alpine

WORKDIR /var/www/laravel

RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libzip-dev \
    icu-dev \
    oniguruma-dev

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    intl \
    zip \
    bcmath \
    opcache

RUN pecl update-channels && pecl install redis && docker-php-ext-enable redis

RUN apk del .build-deps

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN adduser -D -u 1000 www

EXPOSE 9000

CMD ["php-fpm"]
