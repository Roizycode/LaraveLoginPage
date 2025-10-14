# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Create .env file for production
RUN echo "APP_NAME=Laravel" > /var/www/html/.env \
    && echo "APP_ENV=production" >> /var/www/html/.env \
    && echo "APP_KEY=base64:CL23lWmW5r/0ONuyDwN6fAaiLYDpiqWfKhYqQ6i1big=" >> /var/www/html/.env \
    && echo "APP_DEBUG=false" >> /var/www/html/.env \
    && echo "APP_URL=https://laravel-login-app.onrender.com" >> /var/www/html/.env \
    && echo "DB_CONNECTION=sqlite" >> /var/www/html/.env \
    && echo "DB_DATABASE=/var/www/html/database/database.sqlite" >> /var/www/html/.env \
    && echo "LOG_CHANNEL=stderr" >> /var/www/html/.env

# Create SQLite database file
RUN touch /var/www/html/database/database.sqlite \
    && chown www-data:www-data /var/www/html/database/database.sqlite

# Note: Laravel optimizations will be done in startup script

# Configure Apache
RUN a2enmod rewrite
COPY .docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy and make startup script executable
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Expose port
EXPOSE 80

# Start Apache with Laravel initialization
CMD ["/usr/local/bin/start.sh"]
