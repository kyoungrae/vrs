<?php

namespace App\Providers;

use App\Http\Controllers\BaseController;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 로컬(APP_ENV=local) 웹 요청은 ForceLocalApplicationUrl 에서 request()->root() 로 맞춤.
        // 그 외(운영·스테이징)는 .env 의 APP_URL(서브경로 /vrs 포함)을 사용한다.
        $appUrl = config('app.url');
        if (! empty($appUrl) && ! $this->app->environment('local')) {
            \URL::forceRootUrl($appUrl);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configureOfflineUiDatabase();
    }

    /**
     * 로컬에서 DEV_BYPASS + (REAL_UI_WITHOUT_DB 또는 DB_OFFLINE_UI) 일 때
     * 기본 DB를 sqlite_offline 으로 바꿔 Oracle 접속 시도·타임아웃을 막는다.
     */
    protected function configureOfflineUiDatabase()
    {
        if (! $this->app->environment('local')) {
            return;
        }

        if (! filter_var(config('app.dev_bypass_login', false), FILTER_VALIDATE_BOOLEAN)) {
            return;
        }

        $raw = config('app.db_offline_ui');
        if ($raw === null || $raw === '') {
            $useOffline = BaseController::isRealUiWithoutDb();
        } else {
            $useOffline = filter_var($raw, FILTER_VALIDATE_BOOLEAN);
        }

        if (! $useOffline) {
            return;
        }

        $path = storage_path('framework/offline-ui.sqlite');
        $dir = dirname($path);
        if (! is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        if (! file_exists($path)) {
            touch($path);
        }

        $this->app['config']->set('database.default', 'sqlite_offline');
    }
}
