#!/bin/sh
set -e

mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs

if [ -z "$APP_KEY" ]; then
    KEY_FILE="storage/app/.app_key"
    if [ ! -f "$KEY_FILE" ]; then
        php -r "file_put_contents('$KEY_FILE', 'base64:'.base64_encode(random_bytes(32)));"
    fi
    export APP_KEY="$(cat "$KEY_FILE")"
fi

attempt=0
until php artisan migrate --force --no-interaction; do
    attempt=$((attempt + 1))
    if [ "$attempt" -ge 20 ]; then
        echo "Không thể kết nối cơ sở dữ liệu sau 20 lần thử."
        exit 1
    fi
    echo "Đang chờ cơ sở dữ liệu... ($attempt/20)"
    sleep 3
done

php artisan db:seed --force --no-interaction
php artisan config:cache
php artisan view:cache

exec "$@"
