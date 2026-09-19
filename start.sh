#!/bin/sh

touch database/database.sqlite

php artisan migrate --force

exec apache2-foreground
