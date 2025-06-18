#  Инструкция по установке приложения

1) выполните команду 
composer install

2) на основе файла .env.example создайте файл .env и подставьте свои данные

3) выполните команду 
./vendor/bin/sail up

4) выполните миграции:
./vendor/bin/sail artisan migrate

