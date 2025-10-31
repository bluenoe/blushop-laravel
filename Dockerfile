### Frontend build stage (production assets)
FROM node:20 AS frontend
WORKDIR /app

# Install dependencies first (leveraging Docker layer cache)
COPY package.json package-lock.json* yarn.lock* pnpm-lock.yaml* ./
RUN if [ -f package-lock.json ]; then npm ci; else npm install; fi

# Copy frontend source and Vite config
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
COPY public ./public

# Build assets for production
RUN npm run build

### PHP-FPM runtime stage
FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    default-mysql-client \
  && docker-php-ext-install pdo_mysql bcmath \
  && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application source
COPY . /var/www/html

# Copy built frontend assets from the frontend stage
COPY --from=frontend /app/public/build /var/www/html/public/build

# Ensure writable directories
RUN chown -R www-data:www-data storage bootstrap/cache

# Entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]