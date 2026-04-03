# VRS 운영 서버 배포 가이드 (Blueprint-lab 방식)

## 목적
- VRS 시스템을 회사 운영 서버에 배포
- 기존 시스템(예: blueprint-lab)과 동일한 방식으로 배포
  - 로컬에서 컨테이너 이미지 빌드
  - `.tar`로 저장 후 운영 서버로 전송
  - 운영 서버에서 `podman load` 후 `podman run`으로 구동
  - `nginx_web`에서 경로(`/vrs/`)로 라우팅 분기

---

## 중요: `vrs-php74-oci8`는 앱이 아니라 “베이스 이미지”
- `vrs-php74-oci8`는 **PHP 7.4 + OCI8(Oracle)**만 포함된 이미지입니다.
- 운영 서버에서 `podman run ... composer install ...`을 실행하면 `composer: not found`가 발생할 수 있습니다.
- 운영 배포는 blueprint-lab처럼 **VRS 소스 + composer 의존성(vendor)까지 포함된 앱 이미지(`vrs-app`)**를 로컬에서 빌드하여 올리는 방식으로 진행합니다.

참고:
- `FROM --platform=linux/amd64 ...` 관련 메시지는 **경고(warn)**이며 보통 빌드 실패 원인은 아닙니다.
- `composer install` 단계에서 `ext-gd` 같은 PHP 확장 누락으로 실패할 수 있습니다. 이 경우 `Dockerfile.vrs-app`에서 해당 확장을 설치해야 합니다.

---

## 1) 운영 서버 접속 / 프로젝트 폴더 준비

### 1-1. 운영 서버 접속
```bash
ssh vims@192.168.0.141 -p222222
```

### 1-2. 프로젝트 폴더 생성
운영 서버 홈 디렉토리 기준 `~/projects/` 아래에 `vrs` 폴더 생성
```bash
mkdir -p ~/projects/vrs
```

---

## 2) 운영 서버 현재 상태(참고)

### 2-1. podman(docker 에뮬레이션) 컨테이너 상태 예시
```bash
docker ps
```

### 2-2. nginx_web에서 프로젝트 분기 처리
- `nginx_web` 컨테이너가 **외부 요청을 받아 host OS의 포트로 reverse proxy**
- 예:
  - `/erd/` → `host.containers.internal:8085`
  - `/erd-api/` → `host.containers.internal:3001`

---

## 3) VRS 컨테이너 구성(현재 레포 기준)

레포에 확인되는 구성:
- `docker-compose.yml`
  - `php artisan serve --host=0.0.0.0 --port=8000` 형태로 기동
  - `.env`를 `env_file`로 주입
- `docker/Dockerfile.php74-oci8`
  - PHP 7.4 + oci8(Oracle) 확장 설치를 포함하는 베이스 이미지 빌드용
  - Apple Silicon 환경에서 빌드 시 **`--platform linux/amd64`가 중요**

운영 배포용으로 추가한 구성:
- `docker/Dockerfile.vrs-app`
  - `vrs-php74-oci8`를 기반으로 **composer 설치 + 의존성 설치 + VRS 소스 포함**
  - 운영 서버에서 `podman run`만으로 바로 기동 가능

---

## 4) 로컬(Mac)에서 이미지 빌드 및 `.tar` 생성

> 운영 서버에 PHP가 없어도 됩니다. 컨테이너로 제공됩니다.

### 4-1. 1) oci8 포함 PHP 베이스 이미지 빌드
```bash
docker build --platform linux/amd64 -f docker/Dockerfile.php74-oci8 -t vrs-php74-oci8 .
```

### 4-2. 2) VRS 앱 이미지 빌드
```bash
docker build --platform linux/amd64 -f docker/Dockerfile.vrs-app -t vrs-app .
```

### 4-3. `.tar`로 저장
```bash
docker save vrs-app > vrs-app.tar
```

---

## 5) `.tar` 파일 운영 서버로 전송

```bash
scp -P 22222 vrs-app.tar vims@192.168.0.141:~/projects/vrs/
```

---

## 6) 운영 서버에서 이미지 로드 및 실행

### 6-1. 서버 접속 및 폴더 이동
```bash
ssh -p 22222 vims@192.168.0.141
cd ~/projects/vrs
```

### 6-2. 이미지 로드
```bash
podman load < vrs-app.tar
```

### 6-3. 전용 네트워크 생성(권장)
```bash
podman network create vrs-network
```

### 6-4. 컨테이너 실행(예시)
- host 포트는 nginx_web에서 프록시할 포트로 사용
- 예시로 `9086 -> 8000`을 사용(운영 포트 정책에 맞게 변경)

```bash
podman run -d \
  --name vrs-app \
  --network vrs-network \
  -p 9086:8000 \
  --restart unless-stopped \
  vrs-app
```

### 6-5. 로그 확인
```bash
podman logs -f vrs-app
```

---

## 7) nginx_web에 `/vrs/` 라우팅 추가

`nginx_web` 컨테이너 내부의 `/etc/nginx/conf.d/default.conf`에서 기존 프로젝트 분기 방식대로 `/vrs/` 추가

예시:
```nginx
location /vrs/ {
    proxy_pass http://host.containers.internal:9086/;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;
}
```

설정 반영:
```bash
nginx -t
nginx -s reload
```

---

## 8) 재배포(업데이트) 절차 (Patch & Update)

> 아래는 blueprint-lab에서 실제 사용하는 흐름(교체 배포)과 동일한 스타일입니다.

### 8-1. 로컬에서 이미지 재빌드 및 `.tar` 생성
```bash
# docker build --platform linux/amd64 -f docker/Dockerfile.php74-oci8 -t vrs-php74-oci8 .
docker build --platform linux/amd64 -f docker/Dockerfile.vrs-app -t vrs-app .
docker save vrs-app > vrs-app.tar
```

### 8-2. 운영 서버로 전송
```bash
scp -P 22222 vrs-app.tar vims@192.168.0.141:~/projects/vrs/
```

### 8-3. 운영 서버에서 기존 컨테이너 교체
```bash
ssh -p 22222 vims@192.168.0.141
cd ~/projects/vrs

podman rm -f vrs-app
podman load < vrs-app.tar

podman run -d --name vrs-app --network vrs-network -p 9086:8000 --restart unless-stopped vrs-app
```

---

## 0) (운영 서버) 잘못 띄운 컨테이너 정리

이미 `vrs-php74-oci8`로 `vrs-app` 컨테이너를 띄웠고 `composer: not found`가 발생했다면 아래로 정리 후, 위 절차대로 `vrs-app.tar`를 로드하여 재기동합니다.

```bash
podman rm -f vrs-app
```

---

## 9) 배포 확정을 위해 확인이 필요한 값
- 접속 경로를 `/vrs/`로 할지 여부
- VRS에 할당할 host 포트(예: 9086) 확정
- 운영 `.env`를 어떤 방식으로 주입할지
  - 이미지에 포함(비추천)
  - 운영 서버 파일로 관리 후 컨테이너에 마운트(추천)

