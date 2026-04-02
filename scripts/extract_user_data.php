<?php
/**
 * Extract Mongolian text from SYSTEM_USER and related tables
 * Run via browser at /dev/extract-user-data
 */

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Load existing translations
$pairsFile = __DIR__ . '/mn_ko_pairs.tsv';
$existingMn = [];
if (file_exists($pairsFile)) {
    $lines = file($pairsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0 || strpos($line, "\t") === false) continue;
        $mn = trim(explode("\t", $line, 2)[0]);
        if ($mn) $existingMn[$mn] = true;
    }
}

$regex = '/[А-Яа-яЁёӨөҮү]/u';
$newTranslations = [];

echo "=== SYSTEM_USER 테이블 몽골어 추출 ===\n\n";

// 1. SYSTEM_USER - LASTNAME
$result = DB::select("SELECT DISTINCT LASTNAME as v FROM SYSTEM_USER WHERE LASTNAME IS NOT NULL");
foreach ($result as $row) {
    $val = trim($row->v ?? '');
    if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
        $newTranslations[$val] = '성';
        echo "[LASTNAME] $val\n";
    }
}

// 2. SYSTEM_USER - FIRSTNAME  
$result = DB::select("SELECT DISTINCT FIRSTNAME as v FROM SYSTEM_USER WHERE FIRSTNAME IS NOT NULL");
foreach ($result as $row) {
    $val = trim($row->v ?? '');
    if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
        $newTranslations[$val] = '이름';
        echo "[FIRSTNAME] $val\n";
    }
}

// 3. SYSTEM_USER - STATUS/ISACTIVE 관련 상태값
$statusValues = [
    '1' => '활성',
    '0' => '비활성',
    'Идэвхтэй' => '활성',
    'Идэвхгүй' => '비활성'
];
foreach ($statusValues as $mn => $ko) {
    if (!isset($existingMn[$mn]) && !isset($newTranslations[$mn])) {
        $newTranslations[$mn] = $ko;
        echo "[STATUS] $mn\n";
    }
}

// 4. SYSTEM_POSITION - 직위 테이블
echo "\n=== SYSTEM_POSITION 테이블 ===\n";
try {
    $result = DB::select("SELECT DISTINCT NAME as v FROM SYSTEM_POSITION WHERE NAME IS NOT NULL");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '직위';
            echo "[POSITION] $val\n";
        }
    }
} catch (Exception $e) {
    echo "SYSTEM_POSITION 접근 실패: " . $e->getMessage() . "\n";
}

// 5. SYSTEM_DEPARTMENT - 부서 테이블
echo "\n=== SYSTEM_DEPARTMENT 테이블 ===\n";
try {
    $result = DB::select("SELECT DISTINCT NAME as v FROM SYSTEM_DEPARTMENT WHERE NAME IS NOT NULL");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '부서';
            echo "[DEPARTMENT] $val\n";
        }
    }
} catch (Exception $e) {
    echo "SYSTEM_DEPARTMENT 접근 실패: " . $e->getMessage() . "\n";
}

// 6. ADDRESS_PROVINCE - 지역 테이블
echo "\n=== ADDRESS_PROVINCE 테이블 ===\n";
try {
    $result = DB::select("SELECT DISTINCT NAME as v FROM ADDRESS_PROVINCE WHERE NAME IS NOT NULL");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '지역';
            echo "[PROVINCE] $val\n";
        }
    }
} catch (Exception $e) {
    echo "ADDRESS_PROVINCE 접근 실패: " . $e->getMessage() . "\n";
}

// TSV 파일에 추가
echo "\n=== 번역 파일에 추가 중... ===\n";
$added = 0;
$fh = fopen($pairsFile, 'a');
if ($fh) {
    foreach ($newTranslations as $mn => $ko) {
        fwrite($fh, $mn . "\t" . $ko . "\n");
        $added++;
    }
    fclose($fh);
}

echo "\n=== 완료 ===\n";
echo "총 $added 개의 새로운 번역 항목이 mn_ko_pairs.tsv에 추가되었습니다.\n";
echo "수동으로 한국어 번역을 수정해주세요.\n";

return '추출 완료! 총 ' . $added . '개 추가됨';
