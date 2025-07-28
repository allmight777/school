#!/bin/bash
set -e

echo "✅ Installation des dépendances Laravel"
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "✅ Création de la table notifications si nécessaire"
php artisan notifications:table

echo "✅ Lancement des migrations (fresh + seed)"
php artisan migrate:fresh --seed --force

echo "✅ Lancement du serveur nginx/php-fpm"
/start.sh
