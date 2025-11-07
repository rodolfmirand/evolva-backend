#!/bin/sh
set -e

echo "Aguardando banco de dados MySQL ficar disponível..."

sleep 15

php artisan migrate --force

# Inicia o PHP-FPM
echo "Iniciando PHP-FPM..."
exec php-fpm
