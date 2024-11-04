# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    g++ \
    zlib1g-dev \
    libxml2-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl zip pdo pdo_mysql pdo_pgsql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www

# Copy Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application source
COPY . /var/www

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-scripts

# Expose port
EXPOSE 9000

# Start the PHP-FPM server
CMD ["php-fpm"]