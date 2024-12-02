# 🌸 Guesthouse Haru.

## 環境構築

### 1. .envファイルの作成

```
`.env.example` をコピーして、`.env` ファイルを作成してください。
```

### 2.  Dockerコンテナの起動

```
cd docker/haru
docker-compose up -d

```

### 3. ライブラリのインストール

```bash
//コンテナの中に入る
docker-compose exec php-apache bash

//ライブラリのインストール
composer install
```

### 4. APP_KEYの設定

```
//APP_KEYの設定
php artisan key:generate
```

<br>

### Dockerコンテナの停止

```
docker-compose down
```

<br>

# コンテナの停止
docker-compose down

# コンテナ内でのコマンド実行
docker-compose exec app [command]

<br>

## ページ紹介

- ユーザー画面: [localhost:8000](http://localhost:8000)
- 管理者画面: [localhost:8000/admin/login](http://localhost:8000/login)

### ログイン情報

- メールアドレス: `admin@example.com`
- パスワード: `password123`

### PHPMyAdmin

- [localhost:3306](http://localhost:3000)
