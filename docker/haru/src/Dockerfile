FROM php:8.1-fpm

# 必要なPHP拡張モジュールのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql

# Composerのインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www/html

# アプリケーションコードのコピー
COPY . .

# 依存関係のインストール
RUN composer install --no-dev --optimize-autoloader

# Laravelのキャッシュクリアと再生成
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# パーミッションの設定
RUN chmod -R 775 storage bootstrap/cache

# 環境変数の設定
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# ポートの公開
EXPOSE 8000

# アプリケーションの起動
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]