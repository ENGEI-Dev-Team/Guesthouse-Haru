FROM richarvey/nginx-php-fpm:1.7.2

# 作業ディレクトリの設定
WORKDIR /var/www/html

# composer.jsonとcomposer.lockをコピー
COPY composer.json composer.lock ./

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 環境変数の設定
ENV COMPOSER_ALLOW_SUPERUSER=1

# 依存関係のインストール
RUN composer install --no-dev --optimize-autoloader

# アプリケーションコードをコピー
COPY . .

# Laravelのキャッシュクリアと再生成
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# パーミッションの設定
RUN chmod -R 775 storage bootstrap/cache

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

CMD ["/start.sh"]