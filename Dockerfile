FROM php:8.2-fpm

# Permitir composer como root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependências do sistema + drivers PHP
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libpq-dev \
    default-mysql-client \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        intl \
        fileinfo \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www/html

# Copiar aplicação Laravel
COPY backend/ ./

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Permissões
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Script de startup
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Expor PHP-FPM
EXPOSE 9000

# Subir app (migrations + cache + php-fpm)
CMD ["/usr/local/bin/start.sh"]
