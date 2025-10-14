#!/bin/bash

# Simple startup script for Laravel application

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

# Simple Laravel setup
echo "Setting up Laravel..."
php artisan key:generate --force
php artisan migrate --force

echo "Laravel setup complete. Starting Apache..."

# Start Apache
exec apache2-foreground
