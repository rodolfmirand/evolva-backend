#!/bin/sh
# Ajusta permissões
chown -R www-data:www-data /var/www/html/taskup-backend/storage /var/www/html/taskup-backend/bootstrap/cache
chmod -R 775 /var/www/html/taskup-backend/storage /var/www/html/taskup-backend/bootstrap/cache

# Inicia o PHP-FPM
php-fpm
