<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Local-only session bootstrap (no Oracle). Enable with APP_ENV=local and DEV_BYPASS_LOGIN=true.
 */
class DevLocalAuthController extends BaseController
{
    public function login(Request $request)
    {
        if (! BaseController::isDevBypassLogin()) {
            $hint = '.env에 DEV_BYPASS_LOGIN=true 한 줄 추가(또는 false→true) 후 저장 → 터미널에서 php artisan config:clear → 다시 /dev/local-login 접속. '
                . '[현재 APP_ENV=' . config('app.env') . ', DEV_BYPASS_LOGIN=' . var_export(config('app.dev_bypass_login'), true) . ']';

            return redirect('/')->with('message', $this->message('warning', $hint));
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $auth = (object) [
            'id' => (int) env('DEV_BYPASS_USER_ID', 1),
            'lastname' => env('DEV_BYPASS_LASTNAME', 'DEV'),
            'firstname' => env('DEV_BYPASS_FIRSTNAME', 'Local'),
            'position' => env('DEV_BYPASS_POSITION', '담당자'),
            'provinceid' => (int) env('DEV_BYPASS_PROVINCE_ID', 22),
            'userpositionid' => (int) env('DEV_BYPASS_POSITION_ID', 1),
            'isatvt' => (int) env('DEV_BYPASS_IS_ATVT', 0),
            'iscity' => (int) env('DEV_BYPASS_IS_CITY', 1),
        ];

        $archive = (object) [
            'id' => (int) env('DEV_BYPASS_ARCHIVE_ID', 1),
            'archive' => env('DEV_BYPASS_ARCHIVE_LABEL', 'LOCAL-DEV'),
            'abbr' => env('DEV_BYPASS_ARCHIVE_ABBR', 'DEV'),
        ];

        session(['auth' => $auth]);
        session(['archive' => $archive]);

        return redirect()->route('dashboard')->with(
            'message',
            $this->message('info', '로컬 개발 모드: DB 없이 세션만 설정되었습니다. 실제 데이터/권한은 Oracle 연결 후 확인하세요.')
        );
    }
}
