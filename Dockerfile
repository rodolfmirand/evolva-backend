FROM php:8.2-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependências essenciais para o Laravel
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath intl fileinfo \
    && rm -rf /var/lib/apt/lists/*

# Copiar o Composer do container oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

COPY backend/ ./

# Instalar dependências do Composer sem dependências de desenvolvimento (para produção)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Criar diretórios de armazenamento e cache com permissões adequadas
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Copiar o script de entrada e garantir permissões
COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000

# Definir o ponto de entrada para iniciar o PHP-FPM
ENTRYPOINT ["sh", "/usr/local/bin/docker-entrypoint.sh"]
