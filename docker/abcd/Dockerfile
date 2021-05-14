FROM php:7.2-apache

RUN apt-get update -y && apt-get install -y libpng-dev libyaz-dev libxml2-dev zlib1g-dev libtidy-dev libxslt1-dev libyaz-dev
RUN docker-php-ext-install pdo_mysql gd xmlrpc xsl
RUN pecl install yaz

#RUN sed -i '/^;php_flag\[display_errors\]/cphp_flag[display_errors] = off' /usr/local/etc/php-fpm.d/www.conf \
# && sed -i '/^;php_admin_flag\[log_errors\]/cphp_admin_flag[log_errors] = on' /usr/local/etc/php-fpm.d/www.conf \
# && sed -i '/^;clear_env = no/cclear_env = no' /usr/local/etc/php-fpm.d/www.conf

COPY ./www/cgi-bin_Linux /opt/ABCD/www/cgi-bin
COPY ./www/htdocs /opt/ABCD/www/htdocs
COPY ./docker/abcd/apache.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod proxy_http cgi

WORKDIR /opt/ABCD
