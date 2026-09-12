#!/bin/sh
set -e

# Cache configuration, routes, and views if in production
if [ "$APP_ENV" = "production" ]; then
    echo "Running production optimization..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
    php artisan event:cache || true
fi

# Run storage link if not already linked
php artisan storage:link || true

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
