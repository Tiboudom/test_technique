FROM php:7.4-fpm
COPY wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it
RUN apt-get update
RUN apt-get install -y git
RUN docker-php-ext-install pdo_mysql
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD composer install ;  php-fpm 
EXPOSE 9000