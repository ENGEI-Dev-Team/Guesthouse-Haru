FROM php:8.1-fpm

# 必要な拡張モジュールのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql

# Composer のインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www/html

# アプリケーションの依存関係をインストール
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# アプリケーションコードのコピー
COPY . .

# パーミッションの設定
RUN chmod -R 775 storage bootstrap/cache

# Laravel のキャッシュクリアと再生成
RUN php artisan config:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# 起動コマンド
CMD ["php-fpm"]