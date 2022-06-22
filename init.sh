#!/bin/bash
set -e

echo "Make sure the database has been created"

read -s -n1 -p "Press any key to continue ... "

echo "init start..."


echo "1. copy env file"

cp .env.example .env

echo "2. install packages"

composer install

echo "3. generate project keys"

php artisan key:generate

php artisan jwt:secret

echo "4. migrate database"

php artisan migrate --seed

echo "5. create storage link"

php artisan storage:link

echo "done."
