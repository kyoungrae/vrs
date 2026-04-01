<?php
/**
 * Laravel 5.5 artisan is not compatible with PHP 8+.
 * Skip package:discover on modern PHP; run inside PHP 7.4 (Docker) instead.
 */
if (PHP_VERSION_ID >= 80000) {
    fwrite(STDERR, "[composer] Skipping `artisan package:discover` (PHP " . PHP_VERSION . ").\n");
    fwrite(STDERR, "[composer] After install on PHP 7.4 or in Docker: php artisan package:discover\n");
    exit(0);
}

passthru('php artisan package:discover', $code);
exit((int) $code);
