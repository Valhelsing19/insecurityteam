# Stage 1 - Build Frontend (Vite)
FROM node:18-alpine AS frontend

WORKDIR /app

# Copy package files for dependency installation
COPY package*.json ./
RUN npm ci

# Copy files needed for Vite build
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

# Build frontend assets
RUN npm run build

# Stage 2 - Backend (Laravel + PHP + Composer)
FROM php:8.2-fpm AS backend

# Install system dependencies and Nginx
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    zip \
    nginx \
    supervisor \
    gettext-base \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files
COPY composer*.json ./

# Install PHP dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy application files
COPY . .

# Copy built frontend assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy nginx template, supervisor configurations, and startup script
COPY docker/nginx.conf.template /etc/nginx/templates/default.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /usr/local/bin/start.sh

# Make startup script executable
RUN chmod +x /usr/local/bin/start.sh

# Create supervisor log directory and nginx sites-enabled
RUN mkdir -p /var/log/supervisor \
    && mkdir -p /etc/nginx/sites-enabled \
    && rm -f /etc/nginx/sites-enabled/default

# Expose port (Render will provide PORT env var)
EXPOSE ${PORT:-80}

# Use startup script
CMD ["/usr/local/bin/start.sh"]

