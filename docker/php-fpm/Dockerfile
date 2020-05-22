# ./docker/php/Dockerfile
FROM php:7.2-fpm

RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu


RUN apt-get update && \
    apt-get upgrade && \
    apt-get install -y \
    zlib1g-dev \
    openssl \
    curl \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    redis \
    memcached \
    mcrypt


RUN apt-get autoremove -y

RUN docker-php-ext-install zip
RUN docker-php-ext-enable apcu
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install gd

RUN docker-php-ext-install mbstring

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

COPY apps/MaSuperAgence /var/www/html

RUN chmod -R 777 /var/www/html

WORKDIR /var/www/html

RUN php -d memory_limit=-1 /usr/local/bin/composer update

RUN PATH=$PATH:/var/www/html/vendor/bin:bin

CMD wait-for-it -t 0 db:3306 -- bin/console doctrine:schema:update --force --no-interaction; \
    wait-for-it -t 0 db:3306 -- bin/console doctrine:fixtures:load --no-interaction; \
    php-fpm





