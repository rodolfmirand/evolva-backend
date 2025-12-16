#!/bin/sh
set -e

echo "🚀 Starting Laravel..."

php artisan key:generate --force || true
php artisan migrate --force || true

php artisan config:clear
php artisan config:cache
php artisan route:cache

exec php-fpm
