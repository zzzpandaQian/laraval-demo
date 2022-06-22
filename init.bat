cls

@echo off

@echo Make sure the database has been created

pause

echo init start...

echo 1. copy env file

copy .env.example .env

echo.

echo 2. install packages

call composer install

echo.

echo 3. generate project keys

php artisan key:generate

php artisan jwt:secret

echo.

echo 4. migrate database

php artisan migrate:fresh --seed

echo.

echo 5. create storage link

php artisan storage:link

echo.

echo done.
