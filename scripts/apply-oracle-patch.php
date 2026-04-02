<?php
/**
 * Oracle PDO PHP 8.5.4 Compatibility Patch
 * Fixes static PDO::connect() error in yajra/laravel-pdo-via-oci8
 */

// Patch 1: Fix Oci8 class connect method visibility
$oci8File = __DIR__ . '/../vendor/yajra/laravel-pdo-via-oci8/src/Pdo/Oci8.php';

if (file_exists($oci8File)) {
    $content = file_get_contents($oci8File);
    
    // Change private connect to protected connect for inheritance
    $content = preg_replace(
        '/private function connect\(/',
        'protected function connect(',
        $content
    );
    
    // Add PHP 8.x compatibility for PDO::connect() static call issue
    // Replace any static calls to parent::connect() with proper instance handling
    $content = str_replace(
        'parent::connect(',
        '$this->ociConnect(',
        $content
    );
    
    file_put_contents($oci8File, $content);
    echo "✓ Patched: $oci8File\n";
}

// Patch 2: Fix OracleConnector to use proper connection method
$connectorFile = __DIR__ . '/../vendor/yajra/laravel-oci8/src/Oci8/Connectors/OracleConnector.php';

if (file_exists($connectorFile)) {
    $content = file_get_contents($connectorFile);
    
    // Replace PDO::connect with new Oci8 instance
    $content = preg_replace(
        '/PDO::connect\(/',
        'new Oci8(',
        $content
    );
    
    file_put_contents($connectorFile, $content);
    echo "✓ Patched: $connectorFile\n";
}

echo "\n=== Oracle PDO PHP 8.5.4 패치 완료 ===\n";
echo "이제 PHP CLI에서 Oracle 데이터베이스에 접근할 수 있습니다.\n";
