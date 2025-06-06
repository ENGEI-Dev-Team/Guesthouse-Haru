FROM richarvey/nginx-php-fpm:1.7.2

# 作業ディレクトリの設定
WORKDIR /var/www/html

# 必要なファイルのみをコピー
COPY . .

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 依存関係のインストール
RUN composer install --no-dev --optimize-autoloader

# Laravelのキャッシュクリアと再生成
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# パーミッションの設定
RUN chmod -R 775 storage bootstrap/cache

# Laravel環境変数の設定
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

# 起動スクリプトの実行
CMD ["/start.sh"]