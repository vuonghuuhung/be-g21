# Sử dụng PHP 8.1 trên base image
FROM php:8.1-fpm

ARG DB_HOST
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ARG VNP_TMNCODE
ARG VNP_HASHSECRET
ARG VNP_URL
ARG VNP_RETURN_URL
ARG FE_PAYMENT_RESULT_URL
ARG PUSHER_APP_ID
ARG PUSHER_APP_KEY
ARG PUSHER_APP_SECRET

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

COPY .env.example /var/www/html/.env

# Cập nhật biến môi trường trong file .env
RUN sed -i 's/DB_HOST=127.0.0.1/DB_HOST='"${DB_HOST}"'/g' /var/www/html/.env \
    && sed -i 's/DB_DATABASE=laravel/DB_DATABASE='"${DB_DATABASE}"'/g' /var/www/html/.env \
    && sed -i 's/DB_USERNAME=root/DB_USERNAME='"${DB_USERNAME}"'/g' /var/www/html/.env \
    && sed -i 's/DB_PASSWORD=/DB_PASSWORD='"${DB_PASSWORD}"'/g' /var/www/html/.env \
    && sed -i 's/VNP_TMNCODE=/VNP_TMNCODE='"${VNP_TMNCODE}"'/g' /var/www/html/.env \
    && sed -i 's/VNP_HASHSECRET=/VNP_HASHSECRET='"${VNP_HASHSECRET}"'/g' /var/www/html/.env \
    && sed -i 's%VNP_URL=%VNP_URL='"${VNP_URL}"'%g' /var/www/html/.env \
    && sed -i 's%VNP_RETURN_URL=%VNP_RETURN_URL='"${VNP_RETURN_URL}"'%g' /var/www/html/.env \
    && sed -i 's%FE_PAYMENT_RESULT_URL=%FE_PAYMENT_RESULT_URL='"${FE_PAYMENT_RESULT_URL}"'%g' /var/www/html/.env \
    && sed -i 's%PUSHER_APP_ID=%PUSHER_APP_ID='"${PUSHER_APP_ID}"'%g' /var/www/html/.env \
    && sed -i 's%PUSHER_APP_KEY=%PUSHER_APP_KEY='"${PUSHER_APP_KEY}"'%g' /var/www/html/.env \
    && sed -i 's%PUSHER_APP_SECRET=%PUSHER_APP_SECRET='"${PUSHER_APP_SECRET}"'%g' /var/www/html/.env 


# Cài đặt các gói Composer
RUN composer install --optimize-autoloader --no-dev

# Tạo key mới cho ứng dụng Laravel
RUN php artisan key:generate 
RUN php artisan config:cache
RUN php artisan config:clear 

# Chạy ứng dụng Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
EXPOSE 9000 80
