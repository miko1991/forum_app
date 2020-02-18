FROM php:7.2.2-fpm

WORKDIR /app
COPY . /app

RUN docker-php-ext-install mysqli pdo pdo_mysql


RUN php artisan key:generate
RUN php artisan config:clear
RUN php artisan cache:clear

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
