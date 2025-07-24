#!/bin/bash

set -m

if [ ! -f .env ]; then
  cp .env.example .env
  echo ".env has been created from .env.example"
else
  echo ".env already exist"
fi

composer install
php artisan key:generate
php artisan migrate

bash
