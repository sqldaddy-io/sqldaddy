FROM nginx:1.21-alpine
WORKDIR /var/www
COPY nginx.conf /etc/nginx/
COPY default.conf /etc/nginx/conf.d/
COPY default-ssl.conf /etc/nginx/conf.d/

RUN apk update && apk upgrade && apk add --no-cache bash

RUN set -x ; \
    addgroup -g 82 -S www-data ; \
    adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

# Set upstream conf and remove the default conf
ARG PHP_UPSTREAM_CONTAINER=backend
ARG PHP_UPSTREAM_PORT=9000
RUN echo "upstream backend { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80

CMD ["nginx"]
