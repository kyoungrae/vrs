<?php
/**
 * Extract Mongolian text from database tables and add to translation file
 * Run via browser at /dev/extract-db-text
 */

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== DB 몽골어 추출 및 번역 추가 ===\n\n";

// Load existing translations
$pairsFile = __DIR__ . '/mn_ko_pairs.tsv';
$existingMn = [];
if (file_exists($pairsFile)) {
    $lines = file($pairsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0 || strpos($line, "\t") === false) continue;
        $parts = explode("\t", $line, 2);
        $mn = trim($parts[0]);
        if ($mn) $existingMn[$mn] = true;
    }
}

echo "현재 번역 파일 항목 수: " . count($existingMn) . "\n\n";

$regex = '/[А-Яа-яЁёӨөҮү]/u';
$newTranslations = [];
$tablesChecked = [];

// 1. SYSTEM_USER - LASTNAME
echo "[1] SYSTEM_USER.LASTNAME 조회...\n";
try {
    $result = DB::select("SELECT DISTINCT LASTNAME as v FROM SYSTEM_USER WHERE LASTNAME IS NOT NULL AND ROWNUM <= 100");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '성';
            echo "  + $val\n";
        }
    }
    $tablesChecked[] = 'SYSTEM_USER.LASTNAME';
} catch (Exception $e) {
    echo "  오류: " . $e->getMessage() . "\n";
}

// 2. SYSTEM_USER - FIRSTNAME
echo "\n[2] SYSTEM_USER.FIRSTNAME 조회...\n";
try {
    $result = DB::select("SELECT DISTINCT FIRSTNAME as v FROM SYSTEM_USER WHERE FIRSTNAME IS NOT NULL AND ROWNUM <= 100");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '이름';
            echo "  + $val\n";
        }
    }
    $tablesChecked[] = 'SYSTEM_USER.FIRSTNAME';
} catch (Exception $e) {
    echo "  오류: " . $e->getMessage() . "\n";
}

// 3. SYSTEM_POSITION - NAME
echo "\n[3] SYSTEM_POSITION.NAME 조회...\n";
try {
    $result = DB::select("SELECT DISTINCT NAME as v FROM SYSTEM_POSITION WHERE NAME IS NOT NULL");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '직위';
            echo "  + $val\n";
        }
    }
    $tablesChecked[] = 'SYSTEM_POSITION.NAME';
} catch (Exception $e) {
    echo "  오류: " . $e->getMessage() . "\n";
}

// 4. SYSTEM_DEPARTMENT - NAME
echo "\n[4] SYSTEM_DEPARTMENT.NAME 조회...\n";
try {
    $result = DB::select("SELECT DISTINCT NAME as v FROM SYSTEM_DEPARTMENT WHERE NAME IS NOT NULL");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '부서';
            echo "  + $val\n";
        }
    }
    $tablesChecked[] = 'SYSTEM_DEPARTMENT.NAME';
} catch (Exception $e) {
    echo "  오류: " . $e->getMessage() . "\n";
}

// 5. ADDRESS_PROVINCE - NAME
echo "\n[5] ADDRESS_PROVINCE.NAME 조회...\n";
try {
    $result = DB::select("SELECT DISTINCT NAME as v FROM ADDRESS_PROVINCE WHERE NAME IS NOT NULL");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '지역';
            echo "  + $val\n";
        }
    }
    $tablesChecked[] = 'ADDRESS_PROVINCE.NAME';
} catch (Exception $e) {
    echo "  오류: " . $e->getMessage() . "\n";
}

// 6. SYSTEM_ARCHIVE - ARCHIVE (지점명)
echo "\n[6] SYSTEM_ARCHIVE.ARCHIVE 조회...\n";
try {
    $result = DB::select("SELECT DISTINCT ARCHIVE as v FROM SYSTEM_ARCHIVE WHERE ARCHIVE IS NOT NULL AND DELETED_AT IS NULL");
    foreach ($result as $row) {
        $val = trim($row->v ?? '');
        if ($val && preg_match($regex, $val) && !isset($existingMn[$val]) && !isset($newTranslations[$val])) {
            $newTranslations[$val] = '지점';
            echo "  + $val\n";
        }
    }
    $tablesChecked[] = 'SYSTEM_ARCHIVE.ARCHIVE';
} catch (Exception $e) {
    echo "  오류: " . $e->getMessage() . "\n";
}

// TSV 파일에 추가
echo "\n=== 번역 파일에 추가 중... ===\n";
$added = 0;
if (!empty($newTranslations)) {
    $fh = fopen($pairsFile, 'a');
    if ($fh) {
        foreach ($newTranslations as $mn => $ko) {
            fwrite($fh, $mn . "\t" . $ko . "\n");
            $added++;
        }
        fclose($fh);
    }
}

echo "\n=== 완료 ===\n";
echo "조회한 테이블: " . implode(', ', $tablesChecked) . "\n";
echo "새로 추가된 번역: $added 개\n";
echo "총 번역 항목: " . (count($existingMn) + $added) . " 개\n";
echo "\n새로 추가된 항목:\n";
foreach ($newTranslations as $mn => $ko) {
    echo "  $mn => $ko\n";
}

return "추출 완료! $added 개 추가됨";
