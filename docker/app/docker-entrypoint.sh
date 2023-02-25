#!/bin/bash

echo "########## COMPOSER INSTALL ##########"
composer install

# echo "########## NPM INSTALL ##########"
# npm install

echo "########## KEY GENERATE ##########"
php artisan key:generate

echo "########## RUNNING MIGRATIONS ##########"
php artisan migrate

# echo "########## RUNNING BUILD ##########"
# npm run build

php-fpm
