FROM php:8.1-fpm

# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# Composer のインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www/html

# composer.json と composer.lock をコピー
COPY composer.json composer.lock ./

# 環境変数の設定
ENV COMPOSER_ALLOW_SUPERUSER=1

# 依存関係のインストール
RUN composer install --no-dev --optimize-autoloader

# アプリケーションコードをコピー
COPY . .

# Laravel のキャッシュクリアと再生成
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# パーミッションの設定
RUN chmod -R 775 storage bootstrap/cache

# 起動コマンド
CMD ["php-fpm"]