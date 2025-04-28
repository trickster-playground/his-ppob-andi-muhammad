FROM php:8.0-fpm

WORKDIR /var/www

COPY . /var/www

RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd && \
    docker-php-ext-install pdo pdo_mysql

RUN composer install --no-dev --optimize-autoloader

CMD ["php", "-S", "0.0.0.0:8080", "public/index.php"]
