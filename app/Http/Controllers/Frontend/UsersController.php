<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvinceUser;
use App\Http\Controllers\BaseController;
use App\MainUser;
use App\MainUserDepartment;
use App\MainUserPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends BaseController
{
    public function createUser(Request $request)
    {
        try {
            $positions = MainUserPosition::all();
            $departments = MainUserDepartment::whereNull("deleted_at")->orderBy("Name", "ASC")->get();
            $provinces = AddressProvinceUser::orderBy("NAME", "ASC")->get();

            if($request->isMethod("POST")){
                $userName = $request->get("userName");
                $lastName = $request->get("lastName");
                $firstName = $request->get("firstName");
                $department = $request->get("department");
                $position = $request->get("position");
                $password = $request->get("password");
                $province = $request->get("province");
                $isActive = $request->get("status");
                $key = $request->get("env");

                $isActive = $isActive == "on" ? 1 : 0;

                    MainUser::create([
                        'ProvinceId' => $province,
                        'UserPositionId' => $position,
                        'UserDepartmentId' => $department,
                        'UserName' => $userName,
                        'FirstName' => $firstName,
                        'Password' => Hash::make($password),
                        'LastName' => $lastName,
                        'IsActive' => $isActive,
                        'CreatedBy' => 0,
                        'ModifiedBy' => 0,
                    ]);
                    $message = $this->message("success", "Хэрэглэгч 성공적으로 үүслээ.");
                    return view('System.users', compact('positions', 'departments', 'provinces', 'message'));

            } else {
                $key = $request->route("code");
                if($key != null){
                    $id = $this->dec($key);
                    $user = MainUser::where("Id", $id)->get()->first();
                }
                return view('System.users', compact('user', 'key', 'positions', 'departments', 'provinces'));
            }
        } catch (\Exception $ex){
            $this->writeLog("User error: ".$ex->getMessage());
            $message = $this->message("danger", "오류가 발생하여 작업을 다시 하세요.");
            return view('System.users', compact('positions', 'departments', 'provinces', 'message'));
        }
    }
}
