#!/bin/bash

# Navigate to project directory
cd /app/backend

# Install composer dependencies
composer install

# Start PHP built-in server
php -S 0.0.0.0:8000 -t public
