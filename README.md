
## To run application:

* composer install
* composer require laravel/sail --dev
* cp .env.example .env
* php artisan sail:install
* ./docker-artisan.sh key:generate
* ./vendor/bin/sail up
* ./docker-artisan.sh migrate:fresh

Application is running on localhost.

### To run tests:
* ./docker-artisan.sh test
