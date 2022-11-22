FROM php:8.1.12-fpm-alpine

#RUN apk update && apk add --no-cache supervisor
#COPY supervisor/messenger-worker.conf /etc/supervisord.conf
# Install packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash supervisor nano

RUN pecl channel-update pecl.php.net
# Postgres
RUN apk add --no-cache libpq-dev && docker-php-ext-install pdo pgsql pdo_pgsql pdo_mysql mysqli

# Configure non-root user.
ARG PUID=1000
ARG PGID=1000
RUN apk --no-cache add shadow && \
    groupmod -o -g ${PGID} www-data && \
    usermod -o -u ${PUID} -g www-data www-data

# Source code
RUN chown www-data:www-data /etc
RUN chown www-data:www-data /var/www
COPY --chown=www-data:www-data ./ /var/www
WORKDIR /var/www/
# COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
USER www-data

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# RUN composer install --no-interaction



EXPOSE 9000

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
#CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
