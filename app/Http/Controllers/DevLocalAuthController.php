<?php

namespace App\Http\Controllers;

use App\MainUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function createTestUser(Request $request)
    {
        if (! app()->environment('local')) {
            return redirect('/')->with('message', $this->message('danger', 'Not allowed'));
        }

        $username = 'TEST';
        $password = '1234';

        $existing = MainUser::withTrashed()->where('USERNAME', $username)->first();

        $payload = [
            'UserName' => $username,
            'Password' => Hash::make($password),
            'LastName' => 'TEST',
            'FirstName' => 'TEST',
            'IsActive' => 1,
            'IsAtvt' => 1,  // ATVT 관리자
            'IsCity' => 0,  // 시 관리자 아님
            'ProvinceId' => 22,
            'UserPositionId' => 1,
            'UserDepartmentId' => 1,
            'CreatedBy' => 0,
            'ModifiedBy' => 0,
            'LAST_CHANGE_PASSWORD' => Carbon::now()->format('Y-m-d H:i:s'),
        ];

        try {
            if ($existing) {
                MainUser::where('ID', $existing->ID)->update($payload);
                return redirect('/')->with('message', $this->message('success', 'TEST 계정이 업데이트되었습니다. (ID=' . $existing->ID . ')'));
            }

            // Oracle 시퀀스 대신 MAX(ID)+1로 ID 구하기
            $result = DB::selectOne('SELECT NVL(MAX(ID),0)+1 AS ID FROM SYSTEM_USER');
            $nextId = $result && isset($result->ID) ? $result->ID : 1;

            // Raw SQL로 직접 insert (Laravel의 returning ID 방식 피하기)
            $sql = 'INSERT INTO SYSTEM_USER (ID, USERNAME, PASSWORD, LASTNAME, FIRSTNAME, ISACTIVE, ISATVT, ISCITY, PROVINCEID, USERPOSITIONID, USERDEPARTMENTID, CREATEDBY, MODIFIEDBY, LAST_CHANGE_PASSWORD, MODIFIEDDATE, CREATEDDATE) 
                    VALUES (:id, :username, :password, :lastname, :firstname, :isactive, :isatvt, :iscity, :provinceid, :userpositionid, :userdepartmentid, :createdby, :modifiedby, :last_change_password, :modifieddate, :createddate)';
            
            DB::insert($sql, [
                ':id' => $nextId,
                ':username' => $username,
                ':password' => Hash::make($password),
                ':lastname' => 'TEST',
                ':firstname' => 'TEST',
                ':isactive' => 1,
                ':isatvt' => 1,  // ATVT 관리자
                ':iscity' => 0,  // 시 관리자 아님
                ':provinceid' => 22,
                ':userpositionid' => 1,
                ':userdepartmentid' => 1,
                ':createdby' => 0,
                ':modifiedby' => 0,
                ':last_change_password' => Carbon::now()->format('Y-m-d H:i:s'),
                ':modifieddate' => Carbon::now()->format('Y-m-d H:i:s'),
                ':createddate' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            // TEST 계정용 샘플 지점 추가 (PROVINCEID=22, is_type=1)
            $archiveExists = DB::selectOne('SELECT COUNT(*) AS CNT FROM SYSTEM_ARCHIVE WHERE PROVINCEID = 22 AND IS_TYPE = 1 AND ROWNUM = 1')->CNT;
            if ($archiveExists == 0) {
                $archiveId = DB::selectOne('SELECT NVL(MAX(ID),0)+1 AS ID FROM SYSTEM_ARCHIVE')->ID;
                DB::insert('INSERT INTO SYSTEM_ARCHIVE (ID, PROVINCEID, ARCHIVE, IS_TYPE, CREATEDBY, MODIFIEDBY, CREATEDDATE, MODIFIEDDATE) 
                            VALUES (:id, :provinceid, :archive, :is_type, :createdby, :modifiedby, :createddate, :modifieddate)', [
                    ':id' => $archiveId,
                    ':provinceid' => 22,
                    ':archive' => '테스트 지점',
                    ':is_type' => 1,
                    ':createdby' => 0,
                    ':modifiedby' => 0,
                    ':createddate' => Carbon::now()->format('Y-m-d H:i:s'),
                    ':modifieddate' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }

            return redirect('/')->with('message', $this->message('success', 'TEST 계정과 샘플 지점이 생성되었습니다. (ID=' . $nextId . ')'));
        } catch (\Exception $e) {
            $this->writeLog($e);
            return redirect('/')->with('message', $this->message('danger', 'TEST 계정 생성/업데이트 실패: ' . $e->getMessage()));
        }
    }

    public function debugArchives(Request $request)
    {
        if (! app()->environment('local')) {
            return redirect('/')->with('message', $this->message('danger', 'Not allowed'));
        }

        $auth = session('auth');
        $archives = DB::select('SELECT * FROM SYSTEM_ARCHIVE WHERE PROVINCEID = :provinceid AND DELETED_AT IS NULL ORDER BY ARCHIVE', ['provinceid' => 22]);

        return response()->view('debug_archives', [
            'auth' => $auth,
            'archives' => $archives,
        ]);
    }
}
