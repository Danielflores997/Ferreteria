FROM php:8.2-apache

RUN docker-php-ext-install mysqli \
    && a2enmod rewrite headers

COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/ferreteria.ini

WORKDIR /var/www/html
COPY --chown=www-data:www-data app ./app
COPY --chown=www-data:www-data public ./public
COPY --chown=www-data:www-data scripts ./scripts

RUN sed -i 's|^RewriteBase /Ferreteria/public/|RewriteBase /|' /var/www/html/public/.htaccess \
    && mkdir -p /var/www/html/public/uploads/perfiles \
    && chown -R www-data:www-data /var/www/html/public/uploads

EXPOSE 80
