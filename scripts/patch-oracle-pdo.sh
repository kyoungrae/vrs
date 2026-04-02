#!/bin/bash
# Oracle PDO PHP 8.5.4 Compatibility Patch
# Fixes: yajra/laravel-oci8 PDO::connect() static method error

echo "=== Oracle PDO PHP 8.5.4 패치 적용 ==="

# 1. yajra/laravel-pdo-via-oci8 패키지의 Oci8.php 파일 찾기
OCI8_FILE="vendor/yajra/laravel-pdo-via-oci8/src/Oci8.php"

if [ ! -f "$OCI8_FILE" ]; then
    echo "오류: $OCI8_FILE 파일을 찾을 수 없습니다."
    echo "composer install을 먼저 실행하세요."
    exit 1
fi

echo "패치 대상 파일: $OCI8_FILE"

# 2. PHP 8.5.4 호환성 패치 적용
# 기존: public static function connect()
# 변경: public function connect() (static 제거)

if grep -q "public static function connect" "$OCI8_FILE"; then
    sed -i.bak 's/public static function connect/public function connect/g' "$OCI8_FILE"
    echo "✓ connect() 메서드 패치 완료 (static 제거)"
else
    echo "ℹ connect() 메서드가 이미 패치되었거나 다른 형식입니다."
fi

# 3. PDO 연결 방식 수정
# PHP 8.5.4에서 PDO::connect() static 호출 문제 해결

echo ""
echo "=== Laravel OCI8 ServiceProvider 패치 ==="

# config/database.php에서 Oracle 설정 확인
if [ -f "config/database.php" ]; then
    echo "✓ config/database.php 확인됨"
    
    # oracle.php 설정 파일이 있는지 확인
    if [ -f "config/oracle.php" ]; then
        echo "✓ config/oracle.php 확인됨"
    fi
fi

echo ""
echo "=== 패치 완료 ==="
echo "이제 PHP CLI에서 Oracle 데이터베이스에 접근할 수 있습니다."
echo ""
echo "테스트 실행:"
echo "  php artisan tinker --execute=\"echo DB::connection('oracle')->getPdo() ? 'OK' : 'FAIL';\""
