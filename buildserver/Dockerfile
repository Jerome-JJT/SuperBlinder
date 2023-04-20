FROM php:7-apache


RUN sed -i 's#;extension=mysqli#extension=mysqli#' /usr/local/etc/php/php.ini-development  /usr/local/etc/php/php.ini-production
RUN sed -i 's#;extension=pdo_mysql#extension=pdo_mysql#'  /usr/local/etc/php/php.ini-development  /usr/local/etc/php/php.ini-production

# RUN sed -i 's#;extension=mysqli#extension=mysqli#' /usr/local/etc/php/php.ini-production
# RUN sed -i 's#;extension=pdo_mysql#extension=pdo_mysql#' /usr/local/etc/php/php.ini-production



RUN docker-php-ext-install mysqli pdo pdo_mysql