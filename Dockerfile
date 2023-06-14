# Sử dụng PHP FPM image làm base
FROM php:8.1-fpm

# Cài đặt các phần mềm cần thiết
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libxml2-dev

# Cài đặt extension PHP
RUN docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www

# Copy mã nguồn ứng dụng vào image
COPY . /var/www

ENV COMPOSER_ALLOW_SUPERUSER=1

# Cài đặt dependencies và build ứng dụng Laravel
RUN composer install --optimize-autoloader --no-dev
RUN php artisan config:cache
RUN php artisan route:cache

# Thiết lập quyền cho thư mục storage và bootstrap
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Mở cổng 9000 để PHP-FPM lắng nghe
EXPOSE 9000

# Chạy PHP-FPM
CMD ["php-fpm"]