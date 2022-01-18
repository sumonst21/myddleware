FROM php:apache

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN apt-get update && apt-get install -y \
    wget git bash 

# RUN apt-get update && apt-get install -y \ 
#     zlib1g-dev libicu-dev wget git zip vim libxml2-dev libpng-dev \
#     && docker-php-ext-configure intl \ 
#     && docker-php-ext-install pdo pdo_mysql intl \
#     && docker-php-ext-enable intl

# Get nodejs
RUN curl -sL https://deb.nodesource.com/setup_14.x  | bash -

# #zip
# RUN apt-get install -y \
#         libzip-dev \
#         zip \
#     && docker-php-ext-configure zip \
#     && docker-php-ext-install zip

# #imap
# RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*
# RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
#     && docker-php-ext-install imap

# #imagick
# RUN apt-get update && apt-get install -y \
#     libmagickwand-dev --no-install-recommends \
#     && pecl install imagick \
#     && docker-php-ext-enable imagick

# RUN git clone https://github.com/nikic/php-ast.git && \
#     cd php-ast && \
#     phpize && \
#     ./configure --enable-ast && \
#     make install && \
#     docker-php-ext-enable ast

RUN apt-get update && \
    apt-get install -y \
    nodejs 
#     libfreetype6-dev \
#     libwebp-dev \
#     libjpeg62-turbo-dev \
#     libpng-dev \
#     nano \
#     libgmp-dev \
#     libldap2-dev \
#     netcat \
#     sqlite3 \
#     libsqlite3-dev && \
# && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

# Install composer

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
