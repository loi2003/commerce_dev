FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libzip-dev \
    zip

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

WORKDIR /var/www/html

EXPOSE 8080
