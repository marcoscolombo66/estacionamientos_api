FROM php:8.3.9-fpm-alpine

# Install dependencies
RUN apk update && apk add --no-cache \
    git \
    unzip \
    nano \
    curl \
    && docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Copy PHP configuration
COPY php/php.ini /usr/local/etc/php/php.ini

# Set working directory
WORKDIR /var/www

# Copy Laravel application code
# COPY ../laravel /var/www

# Create a basic composer.json file
RUN echo '{ \
  "name": "seekerapi/project", \
  "description": "API Rest", \
  "require": {} \
}' > /var/www/composer.json

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
