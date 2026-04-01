# Local development

See **[docs/LOCAL_SETUP.md](docs/LOCAL_SETUP.md)** for Oracle, Docker, Composer 2, and PHP 7.4 setup.

## Run app locally (Docker Compose)

### Prerequisites

- Docker Desktop (or Docker Engine) installed

### 1) Configure environment

Update `.env` with your Oracle connection info (example):

```dotenv
DB_CONNECTION=oracle
DB_HOST=192.168.0.140
DB_PORT=11521
DB_DATABASE=orcl
DB_USERNAME=vrs
DB_PASSWORD="oracle12c!vrs#"
DB_SERVICE_NAME=orcl
```

If you access the app through port 8000, set:

```dotenv
APP_URL=http://localhost:8000
```

### 2) Start

From the project root:

```bash
docker compose up -d
```

The container installs Composer v1 (required for this legacy Laravel 5.5 lock/plugins) and then starts Laravel:

- URL: `http://localhost:8000`

### 3) Logs / troubleshooting

```bash
docker logs --tail=200 laravel-vrs
```

If you need an interactive shell:

```bash
docker exec -it laravel-vrs bash
```

Useful checks:

```bash
docker exec laravel-vrs php -v
docker exec laravel-vrs php -m | grep -i oci
docker exec laravel-vrs php artisan --version
```

### 4) Stop

```bash
docker compose down
```

Quick checks:

```bash
composer install --ignore-platform-reqs   # if host PHP is 8.x
docker build --platform linux/amd64 -f docker/Dockerfile.php74-oci8 -t vrs-php74-oci8 .
docker run --rm --platform linux/amd64 -v "$PWD":/var/www/html -w /var/www/html vrs-php74-oci8 php artisan --version
```
