<?php
// 로컬 개발 우회 로그인 테스트
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 하드코딩된 테스트 유저
$user = new stdClass();
$user->ID = 1;
$user->USERNAME = 'admin';
$user->ISACTIVE = 1;
$user->ProvinceId = 22;
$user->UserPositionId = 1;
$user->UserDepartmentId = 1;

echo "Test user created: ID={$user->ID}, USERNAME={$user->USERNAME}, ISACTIVE={$user->ISACTIVE}" . PHP_EOL;

// Auth 세션 테스트
try {
    \Illuminate\Support\Facades\Auth::loginUsingId($user->ID, true);
    echo "Auth::loginUsingId successful" . PHP_EOL;
    echo "Auth check: " . (\Illuminate\Support\Facades\Auth::check() ? 'true' : 'false') . PHP_EOL;
    echo "Auth user ID: " . (\Illuminate\Support\Facades\Auth::id() ?? 'null') . PHP_EOL;
} catch (Exception $e) {
    echo "Auth login error: " . $e->getMessage() . PHP_EOL;
}
