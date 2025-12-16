#!/bin/sh
# docker-entrypoint.sh

# Rodar migrations, se necessário
php artisan migrate --force

# Gerar a chave da aplicação, se não estiver configurada
php artisan key:generate

# Iniciar o servidor embutido do PHP na porta 10000
exec php -S 0.0.0.0:10000 -t public

