#!/bin/bash

echo "Starting Laravel application initialization..."
echo "PORT environment variable: ${PORT:-80}"

# Set default PORT if not provided (for local testing)
export PORT=${PORT:-80}

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# Generate nginx config from template with PORT variable
envsubst '$$PORT' < /etc/nginx/templates/default.conf.template > /etc/nginx/sites-available/default

# Enable the site
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Remove default nginx site if it exists
rm -f /etc/nginx/sites-enabled/default.bak

# Test nginx configuration
nginx -t || echo "Nginx config test failed, but continuing..."

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force || echo "Failed to generate key, continuing..."
fi

# Cache configuration if APP_KEY is set (even without .env file, env vars work)
if [ ! -z "$APP_KEY" ]; then
    echo "Caching Laravel configuration..."
    php artisan config:cache || echo "Config cache failed, continuing..."
    php artisan route:cache || echo "Route cache failed, continuing..."
    php artisan view:cache || echo "View cache failed, continuing..."
else
    echo "Warning: APP_KEY not set. Skipping cache operations."
fi

# Run migrations (if needed, uncomment the line below)
# php artisan migrate --force || echo "Migration failed, continuing..."

echo "Laravel initialization complete!"
echo "Starting services on port ${PORT}..."

# Start supervisor (don't use exec so we can see errors)
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

