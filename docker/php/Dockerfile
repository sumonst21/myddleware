FROM php:apache

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN apt-get update && apt-get install -y \
    wget git bash libicu-dev

# Get nodejs
RUN curl -sL https://deb.nodesource.com/setup_14.x  | bash -

RUN apt-get update && \
    apt-get install -y \
    nodejs yarn ca-certificates  \
    # unzip libzip-dev zip \
    # && docker-php-ext-install pdo pdo_mysql zip
    && docker-php-ext-install pdo pdo_mysql

# Install & Configure php extensions
RUN docker-php-ext-configure intl && docker-php-ext-install intl pdo_mysql pdo opcache 

# Install Composer globally
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php && php -r "unlink('composer-setup.php');" && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

# Install Symfony CLI globally
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && apt-get install -y yarn

# install node_modules (javascript)
RUN yarn install

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
