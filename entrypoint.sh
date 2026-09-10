#!/bin/sh
# Start PHP-FPM
php-fpm82 -D

# Start Nginx in foreground
exec nginx -g 'daemon off;'
