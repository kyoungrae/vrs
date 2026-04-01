# 로컬 전체 기능 실행 가이드

Laravel 5.5 + Oracle(OCI8) + VRS 스키마(`SYSTEM_USER` 등)가 필요합니다. **스키마/데이터는 팀·DBA에서 받은 덤프 또는 개발 DB 접속으로 확보**해야 로그인·차량 메뉴가 동작합니다.

## 1. 개발용 Oracle 확보 (`obtain-oracle`)

**A. 회사 개발 DB (권장)**  
- VPN/방화벽 허용 후 DBA에게 `DB_HOST`, `DB_PORT`, `DB_SERVICE_NAME`(또는 SID), `DB_USERNAME`, `DB_PASSWORD` 요청.  
- 스키마는 보통 `VRS` 사용자 소유.

**B. 로컬 Docker Oracle**  
프로젝트 루트에서:

```bash
docker compose up -d oracle
```

- 기본 비밀번호: `DevOraclePass123` (변경: 쉘에서 `LOCAL_ORACLE_PASSWORD=... docker compose up -d oracle` 또는 `.env`에 `LOCAL_ORACLE_PASSWORD` 설정)  
- 컨테이너 기동까지 2~5분 걸릴 수 있음 (`docker compose ps`로 healthy 확인)  
- **빈 인스턴스**이므로 `VRS` 사용자 생성 후 팀에서 받은 **Data Pump / SQL 덤프**로 스키마를 복원해야 앱이 의미 있게 동작합니다.

Oracle Free PDB 연결 예시(덤프 전 `system`만 있을 때):

| 항목 | 값 |
|------|-----|
| DB_HOST | `127.0.0.1` (호스트에서) / `oracle` (compose 네트워크 안의 app 컨테이너에서) |
| DB_PORT | `1521` |
| DB_USERNAME | `system` (또는 복원 후 `vrs`) |
| DB_PASSWORD | 위에서 설정한 ORACLE_PASSWORD |
| DB_DATABASE | `freepdb1` |
| DB_SERVICE_NAME | `FREEPDB1` |

## 2. PHP 7.x + oci8 (`php-oci8`)

### 옵션 A: Docker (PHP 포함)

Apple Silicon(M1/M2)에서는 Instant Client가 **linux/amd64** 이미지를 쓰도록 [`docker/Dockerfile.php74-oci8`](../docker/Dockerfile.php74-oci8)에 `FROM --platform=linux/amd64`가 설정되어 있습니다(빌드·실행이 다소 느릴 수 있음).

```bash
docker compose -f docker-compose.yml -f docker-compose.dev.yml --profile app up --build
```

- 소스는 볼륨 마운트, 컨테이너 안에서 `composer install` 후 `php artisan serve` (포트 `8000`).  
- `.env`의 `DB_HOST`를 Docker 네트워크 기준으로 `oracle`로 두는 것이 안전합니다.

PHP만 쓰려면(Oracle은 호스트 또는 다른 터미널에서 실행 중일 때):

```bash
docker build --platform linux/amd64 -f docker/Dockerfile.php74-oci8 -t vrs-php74-oci8 .
docker run --rm --platform linux/amd64 -v "$PWD":/var/www/html -w /var/www/html vrs-php74-oci8 php artisan serve --host=0.0.0.0 --port=8000
```

### 옵션 B: macOS에 직접 설치

1. PHP 7.4 권장 (예: `brew install php@7.4` 후 PATH 설정).  
2. [Oracle Instant Client](https://www.oracle.com/database/technologies/instant-client/downloads.html) Basic 또는 Basic Light 설치.  
3. `pecl install oci8` (프롬프트에서 Instant Client 경로 지정).  
4. `php -m | grep oci8` 로 확인.

PHP 8.x는 Laravel 5.5와 맞지 않을 수 있어 7.4 사용을 권장합니다.

**맥 기본 `php`가 8.x인 경우:** Laravel 부트스트랩이 `error_reporting(-1)`로 덮어써서, `App\Foundation\Bootstrap\HandleExceptions` + `artisan` / `public/index.php`에서 PHP 8+일 때 `E_DEPRECATED`를 제외합니다(로컬에서 `artisan serve`가 죽는 현상 완화). **운영·Oracle·완전 동작은 PHP 7.4**를 권장합니다.

## 3. 앱 설정·권한 (`env-app`)

```bash
cp .env.example .env
# .env 편집: DB_* 및 APP_KEY

php artisan key:generate

# 호스트가 PHP 8.x인 경우 (Laravel 5.5 / oci8 제약 무시 + 스크립트가 package:discover 생략)
composer install --ignore-platform-reqs

chmod -R ug+rwX storage bootstrap/cache
```

- **`bootstrap/cache/config.php`가 있으면 삭제**하거나 `php artisan config:clear`를 실행하세요. 운영 서버에서 생성된 캐시에는 `/usr/share/nginx/html/system` 같은 절대 경로가 들어 있어, 로컬에서 뷰 컴파일이 실패(HTTP 500)할 수 있습니다.
- 운영 `.env`를 복사해 쓰면 되지만, **저장소에 비밀번호를 커밋하지 마세요.**

### Composer 2.x + Laravel 5.5 (`Undefined index: name`)

`vendor/composer/installed.json` 형식이 Composer 2에서 바뀌어, 패치 없이는 `php artisan`이 실패할 수 있습니다. 이 저장소에는 다음이 포함됩니다.

- 이미 적용된 수정: `vendor/laravel/framework/.../PackageManifest.php`
- `composer update` 등으로 vendor가 덮어씌워지면:

```bash
sh scripts/apply-laravel-composer2-patch.sh
```

Docker(PHP 7.4) 안에서 `php artisan package:discover`를 한 번 실행해도 됩니다.

### Oracle 없이 대시보드 UI만 (`DEV_BYPASS_LOGIN`)

**`APP_ENV=local`** 이고 **`.env`에 `DEV_BYPASS_LOGIN=true`** 일 때만 동작합니다. 운영/스테이징에서는 사용하지 마세요.

1. 로그인 화면의 **「Local dev: нэвтрэлтгүй орох」** 버튼 또는  
2. 브라우저에서 **`/dev/local-login`** 접속  

가짜 `session('auth')` / `session('archive')`가 설정되고, DB가 없으면 통계는 `0`으로 표시됩니다. 상세 변수는 [.env.example](../.env.example) 참고.

## 4. 기동·검증 (`run-verify`)

```bash
php artisan serve --host=127.0.0.1 --port=8000
```

브라우저에서 `http://127.0.0.1:8000` → 로그인 화면.  
Oracle에 `SYSTEM_USER` 등이 없으면 로그인은 실패합니다. 덤프 복원 또는 개발 DB 연결이 선행되어야 합니다.

유용한 점검:

```bash
php artisan --version
php artisan route:list
```

## 문제 요약

| 증상 | 조치 |
|------|------|
| `could not find driver` / oci8 없음 | Docker 이미지 사용 또는 pecl oci8 + Instant Client |
| DB 연결 거부 | Oracle 컨테이너 healthy 여부, 포트 1521, 방화벽 |
| 로그인 실패·테이블 없음 | VRS 스키마 덤프 복원 또는 개발 DB 계정 사용 |
| 로그인 탭이 **무한 로딩** / "Waiting for localhost" | **원인 1:** 예전에는 `vrs.css`가 맨 위에서 Google Fonts `@import`로 렌더를 막음 → 로그인은 이제 `head-login` + `login-page.css`만 사용. **원인 2:** `http://localhost` 대신 **`http://127.0.0.1:8000`** 사용(IPv6/바인딩 이슈). **원인 3:** 이전 세션으로 Oracle에 사용자 조회가 걸리며 멈춤 → 시크릿 창·쿠키 삭제, `.env`에 `SESSION_DRIVER=file` 확인. |
| DB 없이 **실제 메뉴 화면** 보기 | `DEV_BYPASS_LOGIN=true`일 때 `REAL_UI_WITHOUT_DB=true`(config 기본값)면 데모 가로채기 없이 컨트롤러가 빈 목록으로 Blade를 렌더합니다. 일부 화면만 스텁 처리됨(`/vehicle`, `GET /search`, `GET /user`, `/userlist`). 다른 경로는 Oracle 필요. `REAL_UI_WITHOUT_DB=false`면 예전처럼 데모 안내 페이지. `php artisan config:clear` 후 확인. |
| **페이지가 한참 로딩** | **브라우저:** 예전 `vrs.css` 안의 Google Fonts `@import`가 렌더를 막음 → 제거됨. 추가로 `.env`에 `SKIP_EXTERNAL_FONTS=true` 권장. **서버:** 스텁 없는 화면은 Oracle 접속 대기(TCP 타임아웃)로 수십 초 걸릴 수 있음 → 해당 메뉴는 DB 연결 또는 스텁 추가. Docker `php artisan serve`는 요청 1개씩 처리해 느려질 수 있음. |
| Oracle **타임아웃 끊기** | `APP_ENV=local` + `DEV_BYPASS_LOGIN=true` 이고 `DB_OFFLINE_UI`를 비워 두면 `REAL_UI_WITHOUT_DB=true`일 때 기본 DB가 `sqlite_offline`(`storage/framework/offline-ui.sqlite`)로 바뀌어 **Oracle TCP를 시도하지 않음**. 로컬에서 Oracle 쓰려면 `DB_OFFLINE_UI=false`. `php artisan config:clear` 후 재기동. |

## 관련 파일

- [docker-compose.yml](../docker-compose.yml) — 로컬 Oracle만  
- [docker-compose.dev.yml](../docker-compose.dev.yml) — Oracle + PHP 앱 (profile `app`)  
- [docker/Dockerfile.php74-oci8](../docker/Dockerfile.php74-oci8) — PHP 7.4 + oci8  
- [.env.example](../.env.example) — 환경 변수 템플릿  
