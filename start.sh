#!/bin/bash

# Start script for Laravel application

echo "Starting Laravel application..."

# Set proper permissions
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# Create SQLite database if it doesn't exist
if [ ! -f /var/www/html/database/database.sqlite ]; then
    echo "Creating SQLite database..."
    touch /var/www/html/database/database.sqlite
    chown www-data:www-data /var/www/html/database/database.sqlite
fi

# Change to Laravel directory
cd /var/www/html

# Clear all caches first
echo "Clearing Laravel caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Generate application key if not set
echo "Checking application key..."
php artisan key:generate --force || true

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force || true

# Cache for production
echo "Caching for production..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Laravel initialization complete. Starting Apache..."

# Start Apache
exec apache2-foreground
