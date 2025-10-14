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

# Laravel setup with proper migration handling
echo "Setting up Laravel..."
php artisan key:generate --force

# Ensure database directory exists and is writable
mkdir -p /var/www/html/database
chown www-data:www-data /var/www/html/database
chmod 755 /var/www/html/database

# Clear any cached config that might interfere
echo "Clearing Laravel caches..."
php artisan config:clear || true
php artisan cache:clear || true

# Run migrations with proper error handling
echo "Running database migrations..."
php artisan migrate --force --no-interaction

# Verify sessions table exists
echo "Verifying sessions table..."
php artisan tinker --execute="use Illuminate\Support\Facades\Schema; echo 'Sessions table exists: ' . (Schema::hasTable('sessions') ? 'YES' : 'NO');" || true

echo "Laravel setup complete. Starting Apache..."

# Start Apache
exec apache2-foreground
