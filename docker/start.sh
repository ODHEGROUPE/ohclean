#!/bin/bash

echo "Preparing Laravel..."

php artisan config:clear
php artisan cache:clear

echo "Waiting for database..."

until php artisan migrate --force; do
  echo "Database not ready... retrying"
  sleep 3
done

echo "Running seeders..."
php artisan db:seed --force

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache..."
apache2-foreground
