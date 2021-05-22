FROM php:7.2-apache

RUN apt-get update -y \
 && apt-get install -y libpng-dev libyaz-dev libxml2-dev zlib1g-dev libtidy-dev libxslt1-dev libyaz-dev \
 && rm -rf /var/lib/{apt,dpkg,cache,log}

RUN docker-php-ext-install pdo_mysql gd xmlrpc xsl \
 && pecl install yaz \
 && echo 'extension=yaz.so' > /usr/local/etc/php/conf.d/docker-php-ext-yaz.ini \
 && echo 'display_errors=off\nlog_errors=on' > /usr/local/etc/php/conf.d/docker-php-logging.ini

RUN a2enmod proxy_http cgi

COPY ./www/cgi-bin_Linux /opt/ABCD/www/cgi-bin
COPY ./www/htdocs /opt/ABCD/www/htdocs
COPY ./docker/abcd/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /opt/ABCD
