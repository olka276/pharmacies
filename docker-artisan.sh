#!/bin/bash

docker-compose exec app /usr/bin/php artisan $@
