FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    icu-dev \
    curl \
    libpq \
    postgresql-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

WORKDIR /var/u-crud

COPY . .

RUN composer install

CMD ["php-fpm"]
