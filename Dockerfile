FROM php:8.2.4RC1-apache

# Install PHP PDO extension
RUN docker-php-ext-install pdo pdo_mysql

# Install composer and its requirements
RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install zip unzip -y
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . /var/www/html

# Set root directory and permissions
RUN sed -ri -e 's!/var/www/html!/var/www/html/public_html!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN chown -R www-data:www-data /var/www/html

# Set Notiffy cron job
RUN echo "0 22 * * * root php /var/www/html/execute.php" > /etc/cron.d/notiffy

# Install packages and anable rewrite apache module
RUN composer update
RUN composer install
RUN a2enmod rewrite

# Populate reCaptcha credentials file
CMD echo $RECAPTCHA_CREDENTIALS > /var/www/html/auth_recaptcha.json && apache2-foreground
