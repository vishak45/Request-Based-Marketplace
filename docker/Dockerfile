FROM php:8.2-apache

# Enable Apache rewrite and other modules
RUN a2enmod rewrite && a2enmod headers

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 1. Update working directory to your new parent folder
WORKDIR /var/www/html/Request-Based-Marketplace

# 2. Configure Apache for .htaccess and update the Alias for /app

RUN echo '<Directory /var/www/html/Request-Based-Marketplace>\n    AllowOverride All\n    Require all granted\n</Directory>\n\nAlias /app /var/www/html/Request-Based-Marketplace/app\n<Directory /var/www/html/Request-Based-Marketplace/app>\n    Require all granted\n</Directory>' > /etc/apache2/conf-available/app.conf && a2enconf app

# 3. Update Apache DocumentRoot to the new public folder path

RUN sed -i 's|/var/www/html|/var/www/html/Request-Based-Marketplace/public|g' /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80
