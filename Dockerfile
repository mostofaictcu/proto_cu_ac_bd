FROM alpine:3.19

# Install Nginx and PHP 8.2 FPM
RUN apk add --no-cache \
    nginx \
    php82 \
    php82-fpm \
    php82-opcache \
    php82-json \
    php82-mbstring \
    && ln -sf /usr/bin/php82 /usr/bin/php

# Configure Nginx server block
COPY default.conf /etc/nginx/http.d/default.conf

# Pass container environment variables to PHP-FPM workers
COPY php-fpm-env.conf /etc/php82/php-fpm.d/zz-php-fpm-env.conf

# Copy application code
COPY index.php /var/www/html/index.php

# Copy entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
