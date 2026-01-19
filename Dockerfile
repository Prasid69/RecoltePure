# Use official PHP image with Apache
FROM php:8.2-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli


# Ensure only one MPM is enabled (mpm_event is default in php:apache)
RUN a2dismod mpm_prefork mpm_worker && a2enmod mpm_event
RUN a2enmod rewrite

# Copy project files to the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Set permissions (optional, for uploads)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
