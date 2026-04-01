<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\MainUser;
use App\SystemArchive;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard'; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        if($request->isMethod("POST")){
            if (Session::token() != $request->get("_token")) {
                $message = $this->message("danger", '잘못된 로그인 요청입니다.');
                return redirect('/')->with('message', $message);
            }

            $rules = ['captcha' => 'required|captcha'];
            $validator = validator()->make(request()->all(), $rules);
            if ($validator->fails()) {
                $message = $this->message("danger", '보안 코드가 올바르지 않습니다.');
                return redirect('/')->with('message', $message);
            }

            $validator = Validator::make($request->all(),
                [
                    'username' => 'required',
                    'password' => 'required'
                ]);
            if ($validator->fails()) {
                $message = $this->message("danger", '필수 항목을 모두 입력해 주세요.');
                return redirect('/')->with('message', $message);
            }
            $credentials = $request->only('username', 'password');
            if(Auth::attempt($credentials, true)){
                if(Auth::user()->IsActive == 1){
                    // Auth 세션 강제 재설정
                    Auth::login(Auth::user(), true);
                    
                    $archives = SystemArchive::where("PROVINCEID", Auth::user()->ProvinceId)->whereNull("deleted_at")->orderBy("archive", "ASC")->get();
                    $user = DB::table('SYSTEM_USER')->where("ID", Auth::user()->id)->first();

                    $previous_session = $user ? ($user->session_id ?? $user->SESSION_ID ?? null) : null;
                    if ($previous_session) {
                        \Session::getHandler()->destroy($previous_session);
                        //$message = $this->message("info", 'Системд таны эрхээр өөр хүн нэвтэрсэн байна!');
                        //return redirect('/')->with('message', $message);
                    }

                    MainUser::where("ID", Auth::user()->id)->update([ 
                        "SESSION_ID" => session()->getId()
                    ]);

                    $authUser = MainUser::find(Auth::user()->id);
                    session(["auth" => $authUser]);

                    // 강제로 Auth 재설정 (세션과 Auth 동기화)
                    Auth::login($authUser, true);

                    if($archives->count() == 1){
                        session(["archive" => $archives->first()]);
                        return redirect(route("dashboard"));
                    } elseif ($archives->count() > 1) {
                        session(["archive" => "many"]);
                        return view("System.dashboard", compact('archives'));
                    } elseif ($archives->count() == 0){
                        session(["archive" => "zero"]);
                        return redirect(route("dashboard"));
                    }
                } else {
                    Auth::logout();
                    $request->session()->flush();
                    $message = $this->message("info", '시스템 로그인 권한이 없습니다.');
                    return redirect('/')->with('message', $message);
                }
            }
            else{
                $message = $this->message("danger", '아이디 또는 비밀번호가 올바르지 않습니다.');
                return redirect('/')->with('message', $message);
            }
        } else {
            return redirect('/');
        }
    }

    public function logout(Request $request){
        try{
            if(\session()->has("auth")){
                MainUser::where("Id", session()->get("auth")->id)->update([
                    "SESSION_ID" => null,
                    "API_TOKEN" => null
                ]);
            }
        } catch (\Exception $ex){
            $this->writeLog($ex);
        }
        Auth::logout();
        $request->session()->flush();
        return redirect('/');
    }
}
