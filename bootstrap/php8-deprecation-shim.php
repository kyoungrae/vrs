<?php

/**
 * Include this before vendor/autoload.php on PHP 8+.
 *
 * Deprecations during Composer class loading happen before Laravel's
 * HandleExceptions runs; without a handler, php artisan serve logs every
 * notice to the terminal and Laravel may promote them to ErrorException.
 */
if (PHP_VERSION_ID < 80000) {
    return;
}

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

set_error_handler(static function ($errno, $errstr, $errfile, $errline) {
    if ($errno === E_DEPRECATED || $errno === E_USER_DEPRECATED) {
        return true;
    }

    return false;
}, E_ALL);
