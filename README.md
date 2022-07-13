# Laravel 9.0（PHP-8,phpmyadmin,Mariadb,Nginx）Dockerコンテナにインストール

## 1. Dockerアプリケーションをにインストールします
``` https://www.docker.com/get-started/ ```

### Docker Content Trust（DCT）を有効にする
#### ~/.bashrc や ~/.zshrc に追記する。
``` export DOCKER_CONTENT_TRUST=1 ```

## コンテナ構成
```
├── app
├── web
└── db  
```
### コマンドでLaravelプルゼクトPullする
```
[mac] $ git clone git@github.com:ucan-lab/docker-laravel.git
[mac] $ cd docker-laravel
[mac] $ make create-project
```

``` http://localhost/ ```

```

# コンテナを作成する
[mac] $ make up
[mac] $ docker compose up -d

# コンテナを破棄する
[mac] $ make down
[mac] $ docker compose down

# コンテナを再作成する
[mac] $ make restart
[mac] $ docker compose down && docker compose up -d

# コンテナ、イメージ、ボリュームを破棄する
[mac] $ make destroy
[mac] $ docker compose down --rmi all --volumes

# コンテナ、ボリュームを破棄する
[mac] $ make destroy-volumes
[mac] $ docker compose down --volumes

# コンテナ、イメージ、ボリュームを破棄して再構築
[mac] $ make remake
[mac] $ docker compose down --rmi all --volumes && \
    docker compose up -d --build && \
    docker compose exec app composer install && \
    docker compose exec app cp .env.example .env && \
    docker compose exec app php artisan key:generate && \
    docker compose exec app php artisan storage:link && \
    docker compose exec app php artisan migrate:fresh --seed

```

## 推奨開発パッケージのインストール (必要あれば)

```
[mac] $ make install-recommend-packages
```

## Laravelのマイグレーションを実行する

```
# migrate
[mac] $ make migrate
[mac] $ docker compose exec app php artisan migrate

# migrate:fresh
[mac] $ make fresh
[mac] $ docker compose exec app php artisan migrate:fresh --seed

# db:seed
[mac] $ make seed
[mac] $ docker compose exec app php artisan db:seed
```

### PhpMyAdmin 追加するとき
```
phpmyadmin:
    depends_on:
        - db
    image: phpmyadmin/phpmyadmin
    environment:
        - PMA_HOST=db
        - PMA_PORT=3306
    ports:
        - 8001:80

```
### MariaDB 追加するとき
```
db:
    # build:
    #   context: .
    # dockerfile: ./infra/docker/mysql/Dockerfile
    image: 'mariadb:latest'
    ports:
      - target: 3306
        published: ${DB_PUBLISHED_PORT:-3306}
        protocol: tcp
        mode: host
    volumes:
      - type: volume
        source: db-store
        target: /var/lib/mysql
        volume:
          nocopy: true
    environment:
      - MYSQL_DATABASE=${DB_DATABASE:-laravel}
      - MYSQL_USER=${DB_USERNAME:-phper}
      - MYSQL_PASSWORD=${DB_PASSWORD:-secret}
      - MYSQL_ROOT_PASSWORD=${DB_PASSWORD:-secret}

```

### ~infra/docker/mysql/Dockerfile ファイルの変更必要があります
#### Dockerfile

```
FROM mariadb:latest 
#mysql/mysql-server:8.0

ENV TZ=UTC

COPY ./infra/docker/mysql/my.cnf /etc/my.cnf

```
# docker.compose.yml ファイル
```
version: "3.9"
volumes:
  db-store:
  psysh-store:
services:
  app:
    build:
      context: .
      dockerfile: ./infra/docker/php/Dockerfile
      target: ${APP_BUILD_TARGET:-development}
    volumes:
      - type: bind
        source: ./src
        target: /data
      - type: volume
        source: psysh-store
        target: /root/.config/psysh
        volume:
          nocopy: true
    environment:
      - APP_DEBUG=${APP_DEBUG:-true}
      - APP_KEY=${APP_KEY:-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX}
      - APP_ENV=${APP_ENV:-local}
      - APP_URL=${APP_URL:-http://localhost}
      - LOG_CHANNEL=${LOG_CHANNEL:-stderr}
      - LOG_STDERR_FORMATTER=${LOG_STDERR_FORMATTER:-Monolog\Formatter\JsonFormatter}
      - DB_CONNECTION=${DB_CONNECTION:-mysql}
      - DB_HOST=${DB_HOST:-db}
      - DB_PORT=${DB_PORT:-3306}
      - DB_DATABASE=${DB_DATABASE:-laravel}
      - DB_USERNAME=${DB_USERNAME:-phper}
      - DB_PASSWORD=${DB_PASSWORD:-secret}

  web:
    build:
      context: .
      dockerfile: ./infra/docker/nginx/Dockerfile
    ports:
      - target: 80
        published: ${WEB_PUBLISHED_PORT:-80}
        protocol: tcp
        mode: host
    volumes:
      - type: bind
        source: ./src
        target: /data

  db:
    # build:
    #   context: .
    # dockerfile: ./infra/docker/mysql/Dockerfile
    image: 'mariadb:latest'
    ports:
      - target: 3306
        published: ${DB_PUBLISHED_PORT:-3306}
        protocol: tcp
        mode: host
    volumes:
      - type: volume
        source: db-store
        target: /var/lib/mysql
        volume:
          nocopy: true
    environment:
      - MYSQL_DATABASE=${DB_DATABASE:-laravel}
      - MYSQL_USER=${DB_USERNAME:-phper}
      - MYSQL_PASSWORD=${DB_PASSWORD:-secret}
      - MYSQL_ROOT_PASSWORD=${DB_PASSWORD:-secret}

  phpmyadmin:
    depends_on:
        - db
    image: phpmyadmin/phpmyadmin
    environment:
        - PMA_HOST=db
        - PMA_PORT=3306
    ports:
        - 8001:80
  ```

  ##### Note: エラーが出たらDockerコンテナとヴォリューム削除しても一度やり直し

