<?php

$tsvPath = __DIR__ . '/mn_ko_pairs.tsv';

if (!file_exists($tsvPath)) {
    fwrite(STDERR, "File not found: {$tsvPath}\n");
    exit(1);
}

$timestamp = date('Ymd_His');
$backupPath = __DIR__ . "/mn_ko_pairs.tsv.bak_{$timestamp}";

if (!copy($tsvPath, $backupPath)) {
    fwrite(STDERR, "Failed to create backup: {$backupPath}\n");
    exit(1);
}

$lines = file($tsvPath, FILE_IGNORE_NEW_LINES);

$indexByKey = [];
$out = [];

$kept = 0;
$skipped = 0;
$updated = 0;

foreach ($lines as $line) {
    if ($line === '') {
        $out[] = $line;
        $kept++;
        continue;
    }

    $parts = explode("\t", $line, 2);
    $keyRaw = $parts[0];
    $valRaw = $parts[1] ?? '';

    $key = trim($keyRaw);
    $val = $valRaw;

    if ($key === '') {
        $out[] = $line;
        $kept++;
        continue;
    }

    if (!array_key_exists($key, $indexByKey)) {
        $indexByKey[$key] = count($out);
        $out[] = $keyRaw . "\t" . $val;
        $kept++;
        continue;
    }

    $existingIndex = $indexByKey[$key];
    $existingLine = $out[$existingIndex];
    $existingParts = explode("\t", $existingLine, 2);
    $existingVal = $existingParts[1] ?? '';

    $existingHasVal = trim($existingVal) !== '';
    $newHasVal = trim($val) !== '';

    if (!$existingHasVal && $newHasVal) {
        $out[$existingIndex] = $existingParts[0] . "\t" . $val;
        $updated++;
    } else {
        $skipped++;
    }
}

file_put_contents($tsvPath, implode("\n", $out) . "\n");

echo "Backup: {$backupPath}\n";
echo "Lines kept: {$kept}\n";
echo "Duplicates skipped: {$skipped}\n";
echo "Empty->filled updates: {$updated}\n";
