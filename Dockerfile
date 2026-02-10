# Utiliser PHP 8.4 avec Apache
FROM php:8.4-apache

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP pour Laravel
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier composer files
COPY composer.json composer.lock ./

# Installer dépendances PHP
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copier package.json
COPY package*.json ./

# Installer dépendances Node
RUN npm install

# Copier le reste du projet
COPY . .

# Générer autoloader
RUN composer dump-autoload --optimize --no-dev

# Build assets
RUN npm run build

# Nettoyer node_modules
RUN rm -rf node_modules

# Créer dossiers et permissions
RUN mkdir -p storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier config Apache
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Exposer port 80
EXPOSE 80

# Script de démarrage
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["/usr/local/bin/start.sh"]
