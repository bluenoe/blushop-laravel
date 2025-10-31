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

# Generate APP_KEY if empty
APP_KEY_VAL=$(grep '^APP_KEY=' .env | cut -d= -f2-)
if [ -z "$APP_KEY_VAL" ]; then
  php artisan key:generate --ansi || true
fi

# Wait for database if configured
if [ -n "$DB_HOST" ]; then
  echo "Waiting for database at $DB_HOST:${DB_PORT:-3306}..."
  for i in $(seq 1 30); do
    if mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1; then
      break
    fi
    echo "DB not ready yet... ($i/30)"
    sleep 2
  done
fi

# Run migrations
php artisan migrate --force --ansi || true

# Storage symlink
php artisan storage:link || true

# Permissions
chown -R www-data:www-data storage bootstrap/cache

exec "$@"