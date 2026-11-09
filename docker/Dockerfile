FROM php:8.4-fpm-alpine

WORKDIR /var/www/laravel

RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/


RUN install-php-extensions \
    pdo \
    pdo_mysql \
    mbstring \
    intl \
    zip \
    bcmath \
    opcache \
    redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN adduser -D -u 1000 -G www-data www

USER www

EXPOSE 9000

CMD ["php-fpm"]
