<?php

namespace App\Foundation\Bootstrap;

use ErrorException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\HandleExceptions as LaravelHandleExceptions;

/**
 * Laravel 5.5's default bootstrap calls error_reporting(-1). On PHP 8+, vendor code
 * triggers E_DEPRECATED; Laravel converts it to ErrorException and artisan / requests die.
 * Prefer PHP 7.4 for this project; this class is a local-dev workaround on newer PHP.
 *
 * When deprecations are excluded from error_reporting, Laravel's handleError does not throw
 * but returns nothing — PHP then falls back to default handling and still echoes notices
 * if display_errors is on. We return true for deprecations on PHP 8+ to suppress output.
 */
class HandleExceptions extends LaravelHandleExceptions
{
    /**
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $this->app = $app;

        if (PHP_VERSION_ID >= 80000) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        } else {
            error_reporting(-1);
        }

        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);

        if (! $app->environment('testing')) {
            ini_set('display_errors', 'Off');
            ini_set('display_startup_errors', 'Off');
        }
    }

    /**
     * @param  int  $level
     * @param  string  $message
     * @param  string  $file
     * @param  int  $line
     * @param  array  $context
     * @return bool|void
     *
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (PHP_VERSION_ID >= 80000 && in_array($level, [E_DEPRECATED, E_USER_DEPRECATED], true)) {
            return true;
        }

        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }
}
