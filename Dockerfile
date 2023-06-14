# Sử dụng PHP 8.1 trên base image
FROM php:8.1-fpm

# Cài đặt các gói phụ thuộc
RUN apt-get update && apt-get install -y \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath opcache zip

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Đặt thư mục làm việc
WORKDIR /var/www/html

# Copy mã nguồn Laravel vào container
COPY . .

# # Copy file .env vào container
# COPY .env /var/www/html/.env

# Cài đặt các gói Composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

# # Tạo key mới cho ứng dụng Laravel
# RUN php artisan key:generate --force

# Chạy ứng dụng Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
