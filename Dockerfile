# Gunakan image PHP dengan Apache
FROM php:7.4-apache

# Copy semua file aplikasi ke direktori root web server Apache di dalam kontainer
COPY . /var/www/html/

# Install ekstensi MySQL untuk PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql
