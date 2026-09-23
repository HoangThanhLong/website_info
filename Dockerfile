FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader
COPY . .
RUN composer dump-autoload --no-dev --optimize --no-interaction

FROM php:8.4-fpm-alpine AS app
RUN apk add --no-cache icu-libs \
    && apk add --no-cache --virtual .build-deps icu-dev \
    && docker-php-ext-install pdo_mysql intl opcache \
    && apk del .build-deps
WORKDIR /var/www/html
COPY --from=vendor /app .
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/php/entrypoint.sh /usr/local/bin/portfolio-entrypoint
RUN chmod +x /usr/local/bin/portfolio-entrypoint \
    && mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache
USER www-data
ENTRYPOINT ["portfolio-entrypoint"]
CMD ["php-fpm", "-F"]

FROM nginx:1.27-alpine AS web
WORKDIR /var/www/html
COPY --from=vendor /app/public ./public
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
