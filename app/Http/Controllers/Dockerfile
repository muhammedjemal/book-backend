# Use a pre-built image that has Nginx and PHP installed
FROM richarvey/nginx-php-fpm:latest

# Copy your code into the container
COPY . .

# Image settings
ENV SKIP_COMPOSER 0
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel Config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix permissions
RUN chmod -R 777 storage bootstrap/cache

# Start the server
CMD ["/start.sh"]