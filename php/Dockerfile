FROM php:8.4-fpm-bullseye

# 1. Configuration de base
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV COMPOSER_MEMORY_LIMIT=-1

# 2. Installation des dépendances
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libfreetype6-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring intl gd bcmath zip

# 3. Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Création de l'utilisateur www-data avec le même UID que sur macOS
RUN usermod -u 1000 www-data

WORKDIR /var/www/symfony_docker