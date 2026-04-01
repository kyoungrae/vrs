<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseController;
use Closure;

class DemoBypassRoutePreview
{
    /**
     * In local DEV_BYPASS mode, avoid DB-heavy pages and show a route preview page
     * so users can navigate each menu path without Oracle.
     */
    public function handle($request, Closure $next)
    {
        if (! BaseController::isDevBypassLogin()) {
            return $next($request);
        }

        if (! $request->session()->has('auth')) {
            return $next($request);
        }

        // 실제 Blade UI를 DB 없이(컨트롤러 스텁) 쓰는 모드면 데모 가로채기 생략
        if (BaseController::isRealUiWithoutDb()) {
            return $next($request);
        }

        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        // Allow direct access with ?demo=off for one-off deep checks.
        if ($request->query('demo') === 'off') {
            return $next($request);
        }

        $allowPatterns = [
            '/',
            'dashboard',
            'dev/local-login',
            'login',
            'logout',
            'captcha*',
            'api/*',
            'js/*',
            'css/*',
            'lib/*',
            'img/*',
            'fonts/*',
            'favicon.ico',
            'test',
        ];

        foreach ($allowPatterns as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        $path = ltrim($request->path(), '/');

        return response()->view('System.demo-route-preview', [
            'requestedPath' => '/' . $path,
            'requestedUrl' => $request->fullUrl(),
            'requestedMethod' => $request->method(),
            'demoAsideId' => $this->resolveDemoAsideId($path),
        ]);
    }

    /**
     * 사이드 메뉴(아이콘 옆 패널)를 현재 경로에 맞게 자동으로 연다.
     */
    protected function resolveDemoAsideId($path)
    {
        if ($path === '' || $path === 'dashboard') {
            return null;
        }
        if (strpos($path, 'report/') === 0 || $path === 'report') {
            return 'asideReports';
        }
        if (strpos($path, 'settings/') === 0 || $path === 'settings') {
            return 'asideSettings';
        }
        if (strpos($path, 'user') === 0) {
            return 'asideUser';
        }
        if (strpos($path, 'vehicle') === 0) {
            return 'asideVehicle';
        }
        if (strpos($path, 'search') === 0 || strpos($path, 'mehanizm/') === 0) {
            return 'asideFilter';
        }

        return 'asideReference';
    }
}
