#!/bin/sh
set -e

# Pastikan folder penyimpanan tersedia
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# Generate key jika APP_KEY belum diisi di environment
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is empty, generating one..."
    php artisan key:generate --force || true
fi

# Run storage link if not already linked
php artisan storage:link || true

# Cache configuration, routes, and views if in production & database/env ready
if [ "$APP_ENV" = "production" ]; then
    echo "Running production optimization..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Auto run migration if enabled in environment (optional)
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force || true
fi

# Set proper storage permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Execute supervisor to manage Nginx & PHP-FPM
exec "$@"
