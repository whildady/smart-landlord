FROM php:8.2-apache

# 1. Install dependencies za mfumo (libzip-dev na unzip)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql

# 2. Copy composer kutoka kwenye official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Setup application
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
WORKDIR /var/www/html

# 4. Sasa Composer itafanya kazi vizuri
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
