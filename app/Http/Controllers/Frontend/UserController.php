<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvinceUser;
use App\Http\Controllers\BaseController;
use App\MainUser;
use App\MainUserDepartment;
use App\MainUserPosition;
use App\SeriesNumber;
use App\SystemDepType;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function createUser(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        if(!$this->checkAccess("/user", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        if (self::isRealUiWithoutDb() && $request->isMethod('GET') && $request->path() === 'user') {
            $positions = collect([]);
            $departments = collect([]);
            $provinces = collect([]);
            $systemDepType = collect([]);

            return view('System.user', compact('positions', 'departments', 'provinces', 'systemDepType'));
        }

        try { 
            $userPkId = session()->get("auth")->id;
            $positions = MainUserPosition::orderBy("NAME", "ASC")->get();
            $departments = MainUserDepartment::whereNull("deleted_at")->orderBy("Name", "ASC")->get();
            $provinces = AddressProvinceUser::orderBy("NAME", "ASC")->get(); 
            $systemDepType = SystemDepType::orderBy("NAME", "ASC")->get();
            //dd( $systemDepType);
            if($request->isMethod("POST")){ 
                $userName = $request->get("userName");
                $lastName = $request->get("lastName");
                $firstName = $request->get("firstName");
                $department = $request->get("department");
                $position = $request->get("position");
                $password = $request->get("password");
                $province = $request->get("province");
                $systemDepType1 = $request->get("systemDepType");
                $isActive = $request->get("status");
                $isAtvt = $request->get("atvt");
                $isCity = $request->get("iscity");
                $key = $request->get("env");


              


                $isActive = $isActive == "on" ? 1 : 0;
                $isAtvt = $isAtvt == "on" ? 1 : 0;
                $isCity = $isCity == "on" ? 1 : 0;

                //return $department;
                if($key != "") {
                    $id = $this->dec($key);
//                    $is_create = MainUser::withTrashed()->where("USERNAME", $userName)->get()->count();
//                    if($is_create > 1){
//                        $message = $this->message("danger", "Хэрэглэгчийн нэр давхцаж байна.");
//                    } else {
                    MainUser::where("Id", $id)->update([
                        'ProvinceId' => $province,
                        'UserPositionId' => $position,
                        'UserDepartmentId' => $department,
                        'UserName' => $userName,
                        'FirstName' => $firstName,
                        'LastName' => $lastName,
                        'IsActive' => $isActive,
                        'IsAtvt' => $isAtvt,
                        'ISCITY' => $isCity,
                        'ModifiedBy' => $userPkId,
                    ]);
                    if ($password != "" || $password != null) {
                        MainUser::where("Id", $id)->update([
                            'Password' => Hash::make($password),
                            'LAST_CHANGE_PASSWORD' => Carbon::now()->format("Y-m-d H:i:s")
                        ]);
                    }
                    $message = $this->message("success", "Хэрэглэгчийн мэдээлэл 성공적으로 수정되었습니다.");
//                    }
                    return redirect("/user/edit/".$key)->with("message", $message);
                } else {
                    $is_create = MainUser::withTrashed()->where("USERNAME", $userName)->get()->count();
                    
                    if($is_create > 0){
                        $message = $this->message("danger", "Хэрэглэгчийн нэр давхцаж байна.");
                       
                    } else {
                        MainUser::create([
                            'ProvinceId' => $province,
                            'UserPositionId' => $position,
                            'UserDepartmentId' => $department,
                            'UserName' => $userName,
                            'FirstName' => $firstName,
                            'Password' => Hash::make($password),
//                        'PasswordAnother' => $password,
                            'UserDepartmentId' => $department,
                            'LastName' => $lastName,
                            'IsActive' => $isActive,
                            'IsAtvt' => $isAtvt,
                            'CreatedBy' => $userPkId,
                            'ModifiedBy' => $userPkId,
                        ]);
                        $message = $this->message("success", "Хэрэглэгч 성공적으로 등록되었습니다.");
                    }
                    return view('System.user', compact('positions', 'departments', 'provinces','systemDepType', 'message'));
                }
            } else {
                $key = $request->route("code");
                if($key != null){
                    $id = $this->dec($key);
                    $user = MainUser::where("Id", $id)->get()->first();
                }
                return view('System.user', compact('user', 'key', 'positions', 'departments','systemDepType', 'provinces'));
            }
        } catch (\Exception $ex){
            $this->writeLog("User error: ".$ex->getMessage());
            $message = $this->message("danger", "오류가 발생하여 작업을 다시 하세요.");
            return view('System.user', compact('positions', 'departments', 'provinces','systemDepType', 'message'));
        }
    }

    public function fetch(Request $request){

       // $select= $request->get('id');
        //return $request;
        //$this->validate( $request, [ 'id' => 'required|exists:countries,id' ] );
      $states = MainUserDepartment::where('department_type', $request->get('id') )->get(); 
     
      $output = [];
      foreach( $states as $state )
      {
         $output[$state->id] = $state->name;
      }
      return $output;
    }
    public function userList(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/userlist", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        if (self::isRealUiWithoutDb()) {
            $users = collect([]);

            return view('System.userlist', compact('users'));
        }

        $users = DB::table("MAIN_USER_VIEW")->whereNull("deleted_at")->orderBy("ISACTIVE", "DESC")->get();
        return view('System.userlist', compact('users'));
    }

    public function deleteUser(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $key = $request->route("code");
            if($key != null){
                $key = $this->dec($key);
                MainUser::where("Id", $key)->delete();
            }
            $message = $this->message("success", "Хэрэглэгчийн мэдээлэл 성공적으로 устлаа.");
        } catch (\Exception $ex){
            $this->writeLog("User delete error: ".$ex->getMessage());
            $message = $this->message("success", "Хэрэглэгчийн мэдээлэл устгахад 오류가 발생했습니다.");
        }
        return redirect(route('userlist'))->with("message", $message);
    }

    public function changePassword(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            if($request->isMethod("POST")){
                $validator = Validator::make($request->all(),
                    [
                        'password'        => [
                            'required',
                            'min:6',
                            'regex:/[a-z]/',      // must contain at least one lowercase letter
                            'regex:/[A-Z]/',      // must contain at least one uppercase letter
                            'regex:/[0-9]/',      // must contain at least one digit
                            'regex:/[@$!%*#?&;]/'  // must contain a special character
                        ],
                        'passwordcomfirm' => 'required|same:password'
                    ]);

                if ($validator->fails()) {
                    $errors = json_decode($validator->messages(), true);
                    $message = "";
                    foreach ($errors as $key=>$value){
                        if($key == "password"){
                            $message = "Хамгийн багадаа 6 урттай мөн 1 жижиг, 1 том, 1 тоо, 1 тусгай тэмдэгт @$!%*#?&; орсон байх ёстой.";
                        }
                        if($key == "passwordcomfirm"){
                            $message .= "Баталгаажуулах нууц үг буруу байна.";
                        }
                    }
                    $message = $this->message("danger",  $message);
                    return view('System.userpassword', compact("message"));
                }
                $password = $request->get("password");
                $passwordcomfirm = $request->get("passwordcomfirm");
                $userId = session()->get("auth")->id;
                if($password == $passwordcomfirm){
                    MainUser::where("Id", $userId)->update([
                        "password" => Hash::make($password),
                        'LAST_CHANGE_PASSWORD' => Carbon::now()->format("Y-m-d H:i:s")
                    ]);
                    return redirect(route("logout"));
                } else {
                    $message = $this->message("warning", "Давтах нууц үг ялгаатай байна!");
                    return view('System.userpassword', compact("message"));
                }
            } else {
                return view('System.userpassword');
            }
        } catch (\Exception $ex){
            $this->writeLog("Change password error: ".$ex->getMessage());
            $message = $this->message("danger", "Нууц үг солиход 오류가 발생했습니다.");
            return view('System.userpassword')->with("message", $message);
        }
    }

    public function myNumbers(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try {
            $reset = SeriesNumber::where("IS_LOCAL", '=', (int)1)
                ->where("IS_ORDER", '=', (int)1)
                ->where("IS_GIVEN", '=', (int)0)
                ->where("LOCAL_USER_ID", '=', (int)session()->get("auth")->id)
                ->get();

            foreach($reset as $row) {
                $seriesNumberId = $row->id;
                $nowTime = Carbon::now()->format("Y-m-d H:i:s");
                $check_order = $row->order_date;
                $timediff = strtotime($nowTime) - strtotime($check_order);
                //24 Цаг хэтэрсэн эсэх
                if($timediff >= 86400 ){//86400
                    SeriesNumber::where("ID", $seriesNumberId)->update([
                        'IS_ORDER' => 0,
                        'ORDER_DATE' => null,
                        'SHOW_DATE' => $this->checkLuckyPlate($row->name, 2),
                        'ORDER_USER' => null,
                        'ORDER_CABIN' => null
                    ]);
                }
            }

            $message = null;
            if($request->isMethod("POST")  ) {
                $seriesNumberId = $request->get("seriesNumberId");
                if ($seriesNumberId != null) {
                    //Регистрийн номер угсаралт
                    $first = $request->get("first");
                    $second = $request->get("second");
                    $option = $request->get("registeroption");
                    $foreign = $request->get("foreign");
                    $r1 = $request->get("r1");
                    $r2 = $request->get("r2");
                    $r3 = $request->get("r3");
                    $r4 = $request->get("r4");
                    $r5 = $request->get("r5");
                    $r6 = $request->get("r6");
                    $r7 = $request->get("r7");
                    $r8 = $request->get("r8");
                    $register = $first . $second . $r1 . $r2 . $r3 . $r4 . $r5 . $r6 . $r7 . $r8;

                    $a1 = $request->get("a1");
                    $a2 = $request->get("a2");
                    $a3 = $request->get("a3");
                    $a4 = $request->get("a4");
                    $a5 = $request->get("a5");
                    $aral=$a1 . $a2 . $a3 . $a4 . $a5;

                    $register = $first . $second . $r1 . $r2 . $r3 . $r4 . $r5 . $r6 . $r7 . $r8;

                    if ($option == "company"){
                        $register = $r1 . $r2 . $r3 . $r4 . $r5 . $r6 . $r7;
                    }

                    if ($option == "foreign"){
                        $register = $foreign;
                    }

                    SeriesNumber::where("ID", $seriesNumberId)->where("IS_ORDER", (int)0)->update([
                        'IS_ORDER' => 1,
                        'ORDER_DATE' => Carbon::now()->format("Y-m-d H:i:s"),
                        'ORDER_USER' => $register,
                        'ORDER_CABIN' => $aral,
                        'IP_INFO' => $request->userAgent(),
                        'IP_ADDRESS' => $request->ip()."=99"
                    ]);
                    $numberText = SeriesNumber::where("ID", $seriesNumberId)->where("IS_ORDER", (int)1)->get();
                    if($numberText->count() > 0){
                        $numberText = $numberText->first()->name;
                    } else {
                        $numberText = "";
                    }
                    $order_date = Carbon::now()->format("Y-m-d H:i:s");
                    $message_info = '<table class="table table-bordered" style="font-size: 16px;"><tbody><tr><th><div>Захиалсан 번호</div></th><th><div>'.$numberText.'</div></th></tr><tr><th><div>등록번호</div></th><th><div>'.$register.'</div></th></tr><tr><th><div>차체번호</div></th><th><div>'.$aral.'</div></th></tr><tr><th><div>주문 일자</div></th><th><div>'.$order_date.'</div></th></tr><tr><th><div>Хүчинтэй огноо</div></th><th><div>'.Carbon::parse($order_date)->addDay(1).'</div></th></tr></tbody></table>';
                    $message = $this->message("success", '24 цагийн хугацаанд хүчинтэй.<br>'.$message_info.'<div style="color:red">Захиалгын мэдээллийг баталгаажуулах үүднээс дэлгэцийн зургийг дарж авна уу!</div>');
                }
            }

            $numbers = DB::table("SERIES_NUMBER")
                ->where("IS_HIDDEN", 0)
                ->where("IS_GIVEN", 0)
                ->where("IS_LOCAL", 1)
                ->where("IS_OPENED", 1)
                ->where("IS_ORDER", 0)
                ->where("LOCAL_USER_ID", (int)session()->get("auth")->id)
                ->select("ID","NAME", "UPDATE_DATE", "SHOW_DATE", "IS_ORDER")
                ->orderby("NAME", "ASC")
                ->get();

            $number_orders = DB::table("SERIES_NUMBER")
                ->where("IS_HIDDEN", 0)
                ->where("IS_GIVEN", 0)
                ->where("IS_LOCAL", 1)
                ->where("IS_OPENED", 1)
                ->where("IS_ORDER", 1)
                ->where("LOCAL_USER_ID", (int)session()->get("auth")->id)
                ->select("ID","NAME", "ORDER_USER", "ORDER_CABIN", "UPDATE_DATE", "SHOW_DATE", "IS_ORDER")
                ->orderby("NAME", "ASC")
                ->get();
            if($message != null){
                return view('System.usermynumbers', compact('numbers', 'number_orders', 'message'));
            } else {
                return view('System.usermynumbers', compact('numbers', 'number_orders'));
            }
        }catch (\Exception $ex){
            $this->writeLog("Local plate order error: ".$ex->getMessage());
            $message = $this->message("danger", "Дугаар захиалхад 오류가 발생했습니다.");
            return view('System.usermynumbers')->with("message", $message);
        }
    }
}