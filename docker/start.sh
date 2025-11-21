#!/bin/bash
set -e

echo "Starting Laravel application initialization..."

# Wait for services to be ready
sleep 2

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force || true
fi

# Only cache if .env exists and is configured
if [ -f .env ]; then
    echo "Caching Laravel configuration..."
    php artisan config:cache || echo "Config cache failed, continuing..."
    php artisan route:cache || echo "Route cache failed, continuing..."
    php artisan view:cache || echo "View cache failed, continuing..."
else
    echo "Warning: .env file not found. Skipping cache operations."
fi

# Run migrations (if needed, uncomment the line below)
# php artisan migrate --force || echo "Migration failed, continuing..."

echo "Laravel initialization complete!"

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

