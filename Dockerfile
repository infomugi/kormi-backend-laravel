# ==============================================================================
# Multi-stage Dockerfile for Laravel 11 + Livewire 3 + Vite Production Deployment
# Optimized for Coolify (Self-hosted PaaS) & Docker Standalone
# ==============================================================================

# ------------------------------------------------------------------------------
# Stage 1: Build Frontend Assets (Node.js & Vite)
# ------------------------------------------------------------------------------
FROM node:20-alpine AS frontend-builder
WORKDIR /app

# Copy dependency definition files
COPY package.json package-lock.json ./
RUN npm ci

# Copy full application code for Vite asset bundling & Tailwind CSS scanning
COPY . .
RUN npm run build

# ------------------------------------------------------------------------------
# Stage 2: Install PHP Composer Dependencies
# ------------------------------------------------------------------------------
FROM composer:2.7 AS composer-builder
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts \
    --ignore-platform-reqs

# ------------------------------------------------------------------------------
# Stage 3: Production Application Image (PHP 8.2 FPM + Nginx + Supervisor)
# ------------------------------------------------------------------------------
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies & libraries
RUN apk update && apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    bash

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Configure OPcache for maximum performance
RUN { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=10000'; \
        echo 'opcache.revalidate_freq=2'; \
        echo 'opcache.fast_shutdown=1'; \
        echo 'opcache.enable=1'; \
        echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Configure PHP upload limits & memory
RUN { \
        echo 'upload_max_filesize = 100M'; \
        echo 'post_max_size = 100M'; \
        echo 'memory_limit = 256M'; \
        echo 'max_execution_time = 300'; \
    } > /usr/local/etc/php/conf.d/custom.ini

# Copy application source code
COPY . /var/www/html

# Copy vendor dependencies from composer-builder stage
COPY --from=composer-builder /app/vendor /var/www/html/vendor

# Copy built frontend assets from frontend-builder stage
COPY --from=frontend-builder /app/public/build /var/www/html/public/build

# Copy Nginx, Supervisor, and Entrypoint configurations
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Ensure executable permission for entrypoint
RUN chmod +x /usr/local/bin/entrypoint.sh

# Create necessary runtime directories and set ownership & permissions
RUN mkdir -p /var/log/supervisor /var/run/nginx /run/nginx /var/lib/nginx/tmp /var/log/nginx \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/lib/nginx /var/log/nginx /run/nginx \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Coolify exposes port 80 by default for web applications
EXPOSE 80

# Healthcheck for Coolify & Traefik
HEALTHCHECK --interval=10s --timeout=5s --start-period=15s --retries=3 \
    CMD curl -f http://127.0.0.1/up || curl -f http://127.0.0.1/ || exit 1

# Define entrypoint and default execution command
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
