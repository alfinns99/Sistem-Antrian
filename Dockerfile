FROM php:8.2-fpm-alpine

# Pasang sistem dependensi & ekstensi PHP yang dibutuhkan
RUN apk update && apk add --no-cache \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    curl-dev \
    sqlite-dev \
    mysql-client \
    postgresql-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_sqlite \
        gd \
        zip \
        opcache \
        mbstring \
        pcntl

# Ambil Composer dari image resmi
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Salin seluruh berkas proyek
COPY . .

# Pasang dependensi PHP Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Atur hak akses direktori storage dan cache untuk php-fpm (www-data)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
