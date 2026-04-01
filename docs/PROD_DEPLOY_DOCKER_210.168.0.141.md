# VRS 운영 서버 배포 상세 가이드 (Local Docker Build 방식)

로컬 PC(Mac)에서 Docker 이미지를 직접 빌드하고 `.tar`로 운영 서버에 전송해 배포하는 방식입니다.
운영 서버에 PHP/Composer가 없어도 되고, 서버 인터넷 상태에 덜 의존적이라 안정적입니다.

---

## 시스템 목표

- 외부 접속 주소: `http://210.92.92.18:2000/vrs/`
- 내부(직접) 주소: `http://192.168.0.141:8080/vrs/`
- 운영 서버 SSH: `ssh -p 22222 vims@192.168.0.141`
- 앱 컨테이너: `laravel-vrs`

> 실제 운영망에서 외부 IP/포트가 다르면 Nginx `server_name`/포워딩 포트를 맞춰 주세요.

---

## 1) 로컬 Mac 준비 (Docker 설치)

### 방법 1: Homebrew

```bash
# OrbStack (가볍고 빠름)
brew install --cask orbstack

# 또는 Docker Desktop
brew install --cask docker
```

### 방법 2: 직접 다운로드

- OrbStack: <https://orbstack.dev/>
- Docker Desktop: <https://www.docker.com/products/docker-desktop/>

설치 후 확인:

```bash
docker ps
docker version
```

---

## 2) 운영 서버 1회 초기 설정

```bash
ssh -p 22222 vims@192.168.0.141

mkdir -p ~/projects/vrs
mkdir -p ~/projects/vrs/storage_logs
mkdir -p ~/projects/vrs/storage_sessions
mkdir -p ~/projects/vrs/storage_cache
mkdir -p ~/projects/vrs/storage_views

chmod -R 775 ~/projects/vrs
exit
```

---

## 3) 로컬에서 VRS 이미지 빌드 및 tar 생성

프로젝트 루트에서 실행:

```bash
cd ~/work/mongolia/system
```

운영 전용 Dockerfile 생성(로컬에서 1회 생성 후 git 관리 권장):

```dockerfile
# Dockerfile.prod
FROM adrianharabula/php7-with-oci8

WORKDIR /var/www/html
COPY . /var/www/html

# Laravel 5.5는 Composer v1이 안전
RUN curl -sS https://getcomposer.org/installer | php -- --1 --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
    && php artisan config:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

이미지 빌드 (Mac ARM -> 서버 AMD64 호환):

```bash
docker build --platform linux/amd64 -t vrs-app:prod -f Dockerfile.prod .
```

tar 추출:

```bash
docker save vrs-app:prod > vrs-app-prod.tar
```

---

## 4) 운영 서버로 이미지/설정 전송

```bash
cd ~/work/mongolia/system
scp -P 22222 vrs-app-prod.tar .env vims@192.168.0.141:~/projects/vrs/
```

> 운영용 `.env`를 따로 쓰면 파일명을 `.env.prod`로 전송 후 서버에서 `.env`로 복사하세요.

---

## 5) 운영 서버에서 컨테이너 기동 (수동 방식)

```bash
ssh -p 22222 vims@192.168.0.141
cd ~/projects/vrs
```

Docker 설치가 아직이라면:

```bash
sudo apt-get update
sudo apt-get install -y docker.io
sudo systemctl enable --now docker
sudo usermod -aG docker $USER
newgrp docker
```

이미지 로드:

```bash
docker load < vrs-app-prod.tar
```

기존 컨테이너 정리:

```bash
docker rm -f laravel-vrs 2>/dev/null || true
```

컨테이너 실행:

```bash
docker run -d \
  --name laravel-vrs \
  -p 8080:8000 \
  --env-file ~/projects/vrs/.env \
  -v ~/projects/vrs/storage_logs:/var/www/html/storage/logs \
  -v ~/projects/vrs/storage_sessions:/var/www/html/storage/framework/sessions \
  -v ~/projects/vrs/storage_cache:/var/www/html/storage/framework/cache \
  -v ~/projects/vrs/storage_views:/var/www/html/storage/framework/views \
  --restart unless-stopped \
  vrs-app:prod
```

상태 확인:

```bash
docker ps
docker logs --tail=200 laravel-vrs
curl -I http://127.0.0.1:8080/
```

---

## 6) Nginx Gateway 설정 (2000 포트 -> /vrs 경로)

운영 서버 Nginx에 아래를 추가합니다.

```nginx
server {
    listen 8080; # 외부 2000으로 매핑되는 내부 포트
    server_name 210.92.92.18 192.168.0.141;

    # VRS 프론트/백엔드 통합 경로
    location /vrs/ {
        proxy_pass http://127.0.0.1:8080/;
        proxy_http_version 1.1;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_set_header X-Forwarded-Prefix /vrs;
    }
}
```

적용:

```bash
sudo nginx -t
sudo nginx -s reload
```

---

## 7) 재배포/업데이트 절차 (Patch & Update)

### 1단계: 로컬 재빌드

```bash
cd ~/work/mongolia/system
docker build --platform linux/amd64 -t vrs-app:prod -f Dockerfile.prod .
docker save vrs-app:prod > vrs-app-prod.tar
```

### 2단계: 서버 전송

```bash
scp -P 22222 vrs-app-prod.tar vims@192.168.0.141:~/projects/vrs/
```

### 3단계: 서버 교체 배포

```bash
ssh -p 22222 vims@192.168.0.141
cd ~/projects/vrs

docker rm -f laravel-vrs
docker load < vrs-app-prod.tar

docker run -d \
  --name laravel-vrs \
  -p 8080:8000 \
  --env-file ~/projects/vrs/.env \
  -v ~/projects/vrs/storage_logs:/var/www/html/storage/logs \
  -v ~/projects/vrs/storage_sessions:/var/www/html/storage/framework/sessions \
  -v ~/projects/vrs/storage_cache:/var/www/html/storage/framework/cache \
  -v ~/projects/vrs/storage_views:/var/www/html/storage/framework/views \
  --restart unless-stopped \
  vrs-app:prod
```

---

## 8) 로그/점검 명령어

```bash
# 앱 로그
docker logs -f laravel-vrs

# 포트 점검
lsof -i :8080
sleep 1 && lsof -i :8080 2>/dev/null | grep LISTEN || echo "Port 8080 is now free"

# 헬스 체크
curl -I http://127.0.0.1:8080/
curl -I http://210.92.92.18:2000/vrs/
```

---

## 9) 장애 대응 팁

- 컨테이너가 바로 죽으면:
  - `docker logs --tail=300 laravel-vrs`
  - `.env`의 Oracle 접속 정보 확인
- 502/504면:
  - Nginx upstream이 `127.0.0.1:8080`인지 확인
  - `docker ps`로 컨테이너 실행 상태 확인
- 정적 리소스 경로가 깨지면:
  - `.env`의 `APP_URL`을 `http://210.92.92.18:2000/vrs`로 설정 후 재기동

---

## 10) 최종 체크리스트

1. `http://210.92.92.18:2000/vrs/` 접속 확인
2. 로그인/주요 메뉴(`/vehicle`, `/reference/service`) 동작 확인
3. 서버 재부팅 후 자동 기동(`--restart unless-stopped`) 확인

