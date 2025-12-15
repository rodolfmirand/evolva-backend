#!/bin/sh
set -e

# Inicia o PHP-FPM
echo "Iniciando PHP-FPM..."
exec php-fpm
