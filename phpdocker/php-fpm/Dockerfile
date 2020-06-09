FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-mysql php7.2-gd php7.2-pdo \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# Composer install
ADD . /application
RUN cd /application && composer install --optimize-autoloader && \
    composer clear-cache && chown www-data:www-data ./web/assets