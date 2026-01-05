FROM php:8.2-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy Apache config

# Set working directory
WORKDIR /var/www/html
