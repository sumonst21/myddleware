FROM php:7.4-apache

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

# COPY docker/apache/apache.conf /etc/apache2/sites-available/apache.conf
# RUN echo "Include /etc/apache2/sites-available/apache.conf" \
#     >> /etc/apache2/sites/available/apache2.conf
COPY docker/apache/apache.conf /etc/apache2/apache.conf
RUN echo "Include /etc/apache2/apache.conf" \
    >> /etc/apache2/apache2.conf
# Copy apache vhost file to proxy php requests to php-fpm container
#     COPY docker/apache/apache.conf /usr/local/apache2/conf/apache.conf
# RUN echo "Include /usr/local/apache2/conf/apache.conf" \
#     >> /usr/local/apache2/conf/httpd.conf
    

RUN apt-get update && apt-get install -y \
    wget git bash libicu-dev

# Get nodejs
RUN curl -sL https://deb.nodesource.com/setup_14.x  | bash -

RUN apt-get update && \
    apt-get install -y \
    nodejs yarn ca-certificates  \
    unzip libzip-dev zip \
    procps \
    && docker-php-ext-install pdo pdo_mysql zip intl

# Install & Configure php extensions
RUN docker-php-ext-configure intl && docker-php-ext-install intl pdo_mysql pdo opcache 

# Install Composer globally
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php && php -r "unlink('composer-setup.php');" && mv composer.phar /usr/local/bin/composer

# Install Symfony CLI globally
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && apt-get install -y yarn


# ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# CMD ["php", "-a"]

# Add user for symfony application
# RUN groupadd -g 1000 www-data
# RUN useradd -u 1000 -ms /bin/bash -g www-data www-data

# Copy existing application directory contents
COPY . /var/www/html

# # Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html
WORKDIR /var/www/html
# Change current user to www
USER www-data
RUN composer install
RUN composer update symfony/flex
# RUN php bin/console doctrine:database:create
# # install node_modules (javascript)
RUN yarn install
RUN yarn build
# RUN php bin/console doctrine:schema:update --force



# # Expose port 9000 and start php server
# EXPOSE 9000
# CMD ["php", "-a"]
CMD ["apache2-foreground"]