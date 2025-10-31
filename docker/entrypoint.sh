#!/usr/bin/env sh
set -e

cd /var/www/html

# Ensure .env exists
if [ ! -f ".env" ]; then
  cp .env.example .env
fi

# Install composer dependencies if vendor missing
if [ ! -d "vendor" ]; then
  composer install --no-interaction --prefer-dist
fi

# Generate app key (force to ensure set)
php artisan key:generate --force --ansi || true

# Short wait to allow MySQL to start
sleep 5

# Run migrations
php artisan migrate --force --ansi || true

# Storage symlink
php artisan storage:link || true

# Cache configuration for performance
php artisan config:cache --ansi || true

# Permissions
chown -R www-data:www-data storage bootstrap/cache

exec "$@"