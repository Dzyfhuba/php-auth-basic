# Use PHP 8.2 base image
FROM php:8.2

# Install required system dependencies
RUN apt-get update \
    && apt-get install -y libzip-dev \
    && docker-php-ext-install zip pdo_mysql mysqli

# Copy custom php.ini file
COPY php.ini /usr/local/etc/php/php.ini

# Copy apache-config.conf file
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Set the document root
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:80"]