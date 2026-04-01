<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== 몽골어 데이터 스캔 시작 ===\n";

$sampleLimit = (int) (getenv('SCAN_SAMPLE_LIMIT') ?: 200);
$regex = "[А-Яа-яЁёӨөҮү]";

$pairsFile = __DIR__ . '/mn_ko_pairs.tsv';
$existingMn = [];
if (file_exists($pairsFile)) {
    $lines = file($pairsFile, FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        if ($line === '' || strpos($line, "\t") === false) {
            continue;
        }
        $mn = trim(explode("\t", $line, 2)[0]);
        if ($mn !== '') {
            $existingMn[$mn] = true;
        }
    }
}

// 주요 테이블 목록 (몽골어 데이터가 있을 만한 테이블)
$targetTables = [
    'SYSTEM_POSITION',
    'REF_COUNTRY', 
    'REF_COLOR',
    'REF_PURPOSE',
    'REF_ENGINE_MODEL',
    'REG_MARK',
    'REG_MODEL',
    'REG_VEHICLE_TYPE',
    'SYSTEM_SERVICE',
    'SYSTEM_MENU',
    'SYSTEM_DEPARTMENT',
    'ADDRESS_PROVINCE',
    'ADDRESS_SUBDEV',
    'ADDRESS_SUBDEV_UNIT',
    'ADDRESS_MICRODISTRICT',
    'OWNER_TYPE',
    'REG_STATUS',
    'REF_GENERAL',
    'REF_GENERAL_TYPE'
];

$foundTranslations = [];

foreach ($targetTables as $tableName) {
    echo "\n테이블: $tableName\n";
    
    try {
        // 테이블 컬럼 정보 가져오기
        $columns = DB::select("SELECT column_name FROM user_tab_columns WHERE table_name = :table_name", ['table_name' => $tableName]);
        
        foreach ($columns as $column) {
            $columnName = $column->column_name;
            
            // 문자열 타입 컬럼만 스캔
            $columnType = DB::select("SELECT data_type FROM user_tab_columns WHERE table_name = :table_name AND column_name = :column_name", [
                'table_name' => $tableName,
                'column_name' => $columnName
            ]);
            
            if (empty($columnType)) continue;
            
            $dataType = strtoupper($columnType[0]->data_type);
            
            if (in_array($dataType, ['VARCHAR2', 'NVARCHAR2', 'CHAR', 'NCHAR', 'CLOB', 'NCLOB'])) {
                // 몽골어 문자가 있는 데이터 샘플 가져오기 (Oracle 정규식 사용)
                $sampleData = DB::select(
                    "SELECT DISTINCT $columnName AS v FROM $tableName WHERE $columnName IS NOT NULL AND REGEXP_LIKE($columnName, ?, 'i') AND ROWNUM <= $sampleLimit",
                    [$regex]
                );
                
                foreach ($sampleData as $data) {
                    $props = get_object_vars($data);
                    $value = null;
                    if (array_key_exists('v', $props)) {
                        $value = $props['v'];
                    } elseif (!empty($props)) {
                        $value = reset($props);
                    }
                    if ($value && !empty(trim($value))) {
                        if (preg_match('/[А-Яа-яЁёӨөҮү]/u', $value)) {
                            $foundTranslations[$tableName][$columnName][] = trim($value);
                            echo "  - $columnName: " . trim($value) . "\n";
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo "  에러: " . $e->getMessage() . "\n";
    }
}

echo "\n=== 발견된 몽골어 데이터 ===\n";
foreach ($foundTranslations as $table => $columns) {
    echo "\n[$table]\n";
    foreach ($columns as $column => $values) {
        echo "  $column:\n";
        foreach (array_unique($values) as $value) {
            echo "    - '$value'\n";
        }
    }
}

// TSV 파일에 추가할 번역 데이터 생성
echo "\n=== TSV 파일에 추가할 번역 데이터 ===\n";
$tsvData = [];
foreach ($foundTranslations as $table => $columns) {
    foreach ($columns as $column => $values) {
        foreach (array_unique($values) as $value) {
            $value = trim($value);
            if ($value === '') {
                continue;
            }
            if (!isset($existingMn[$value]) && !isset($tsvData[$value])) {
                $tsvData[$value] = '';
                echo "$value\t\n";
            }
        }
    }
}

if (!empty($tsvData)) {
    $fh = fopen($pairsFile, 'a');
    if ($fh) {
        foreach (array_keys($tsvData) as $mn) {
            fwrite($fh, $mn . "\t" . "\n");
        }
        fclose($fh);
    }
}

echo "\n=== 완료 ===\n";
echo "총 " . count($tsvData) . "개의 몽골어 단어 발견\n";
echo "수동으로 번역 후 TSV 파일에 추가하세요.\n";
