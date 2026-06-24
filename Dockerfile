FROM php:8.2-apache
RUN apt-get update && apt-get install -y libicu-dev && docker-php-ext-install intl pdo pdo_mysql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader
EXPOSE 80
