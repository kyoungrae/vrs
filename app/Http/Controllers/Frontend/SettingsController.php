<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvince;
use App\Http\Controllers\BaseController;
use App\MainUserDepartment;
use App\SystemArchive;
use Carbon\Carbon;
use DemeterChain\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SystemDepType;
class SettingsController extends BaseController
{
    public function errorpage(Request $request)
    {
        return view('Errors.404');
    }

    public function indexDepartment(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/settings/department", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $provinces = AddressProvince::orderBy("NAME", "ASC")->get();
            $systemDepType1 = SystemDepType::orderBy("NAME", "ASC")->get();
           // dd($systemDepType1); 
            if($request->isMethod("POST")){
                $name = $request->get("name");
                $province = $request->get("province");

                $systemDepType = $request->get("systemDepType");
                $licenseNo = $request->get("license_no");
                $licenseStart = $request->get("license_start");
                $licenseEnd = $request->get("license_end");
                $compRegister = $request->get("comp_register");
                
                $compDirector = $request->get("comp_director");
                $compPhone = $request->get("comp_phone");
                $compAddress = $request->get("comp_address");
                $env = $request->get("env");
                //return $request;
                if($env != ""){
                    MainUserDepartment::where("Id", $this->dec($env))->update([
                        'Name' => $name,
                        'PROVINCE_ID' => $province,
                        'ModifiedBy' => $userPkId,
                        'department_type' => $systemDepType,
                        'dep_license_number' => $licenseNo,
                        'dep_license_start_date' => $licenseStart,
                        'dep_license_end_date' => $licenseEnd,
                        'dep_register' => $compRegister,
                        'dep_director' => $compDirector,
                        'dep_phone' => $compPhone,
                        'dep_address' => $compAddress
                    ]);
                    $message = $this->message("success", "Хэлтэс ам년ттай засагдлаа.");
                } else {
                  
                   // return $compRegister;
                    MainUserDepartment::create([
                        'Name' => $name,
                        'PROVINCE_ID' => $province,
                        'CreatedBy' => $userPkId,
                        'ModifiedBy' => $userPkId,
                        'department_type' => $systemDepType,
                        'dep_license_number' => $licenseNo,
                        'dep_license_start_date' => $licenseStart,
                        'dep_license_end_date' => $licenseEnd,
                        'dep_register' => $compRegister,
                        'dep_director' => $compDirector,
                        'dep_phone' => $compPhone,
                        'dep_address' => $compAddress
                        
                    ]);
                    $message = $this->message("success", "Хэлтэс ам년ттай нэмэгдлээ.");
                }
                $departments = DB::table("SYSTEM_DEPARTMENT")
                    ->leftJoin("ADDRESS_PROVINCE", "SYSTEM_DEPARTMENT.PROVINCE_ID", "ADDRESS_PROVINCE.ID")
                    ->select("SYSTEM_DEPARTMENT.ID AS ID", "SYSTEM_DEPARTMENT.NAME AS NAME", "ADDRESS_PROVINCE.ID AS PROVINCE_ID", "ADDRESS_PROVINCE.NAME AS PROVINCE_NAME")
                    ->whereNull("SYSTEM_DEPARTMENT.deleted_at")
                    ->orderBy("SYSTEM_DEPARTMENT.NAME", "ASC")
                    ->get();
                return view('System.department', compact('departments', 'provinces','systemDepType1', 'message'));
            } else {
                $key = $request->route("code");
                if($key != null){
                    $key = $this->dec($key);
                    $department = DB::table("SYSTEM_DEPARTMENT")
                        ->leftJoin("ADDRESS_PROVINCE", "SYSTEM_DEPARTMENT.PROVINCE_ID", "ADDRESS_PROVINCE.ID")
                        ->select("SYSTEM_DEPARTMENT.ID AS ID", "SYSTEM_DEPARTMENT.NAME AS NAME", "ADDRESS_PROVINCE.ID AS PROVINCE_ID", "ADDRESS_PROVINCE.NAME AS PROVINCE_NAME")
                        ->where("SYSTEM_DEPARTMENT.Id", $key)
                        ->get()
                        ->first();
                }
                $department = DB::table("SYSTEM_DEPARTMENT")
                        ->leftJoin("ADDRESS_PROVINCE", "SYSTEM_DEPARTMENT.PROVINCE_ID", "ADDRESS_PROVINCE.ID")
                        ->select("SYSTEM_DEPARTMENT.ID AS ID", "SYSTEM_DEPARTMENT.NAME AS NAME", "ADDRESS_PROVINCE.ID AS PROVINCE_ID", "ADDRESS_PROVINCE.NAME AS PROVINCE_NAME","DEPARTMENT_TYPE AS DEPTYPE_ID","DEP_LICENSE_NUMBER AS COMP_LICENSE_NUMBER",
                        "DEP_LICENSE_START_DATE AS COMP_LICENSE_START","DEP_LICENSE_END_DATE AS COMP_LICENSE_END","DEP_REGISTER AS COMP_REGISTER","DEP_DIRECTOR AS COMP_DIRECTOR","DEP_PHONE AS COMP_PHONE","DEP_ADDRESS AS COMP_ADDRESS")
                        ->where("SYSTEM_DEPARTMENT.Id", $key)
                        ->get()
                        ->first();
                $departments = DB::table("SYSTEM_DEPARTMENT")
                    ->leftJoin("ADDRESS_PROVINCE", "SYSTEM_DEPARTMENT.PROVINCE_ID", "ADDRESS_PROVINCE.ID")
                    ->select("SYSTEM_DEPARTMENT.ID AS ID", "SYSTEM_DEPARTMENT.NAME AS NAME", "ADDRESS_PROVINCE.ID AS PROVINCE_ID", "ADDRESS_PROVINCE.NAME AS PROVINCE_NAME")
                    ->whereNull("SYSTEM_DEPARTMENT.deleted_at")
                    ->orderBy("SYSTEM_DEPARTMENT.NAME", "ASC")
                    ->get();
                return view('System.department', compact('departments', 'provinces','systemDepType1','department'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Department error: ". $ex->getMessage());
            $message = $this->message("danger", "오류가 발생하여 작업을 다시 하세요.");
            return redirect(route("refdepartment"))->with('message', $message);
        }
    }

    public function deleteDepartment(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/settings/archive", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $key = $request->route("code");
            if($key != null){
                $key = $this->dec($key);
                MainUserDepartment::where("Id", $key)->update([
                    'deleted_at' => Carbon::now()->format("Y-m-d"),
                    'MODIFIEDBY' => $userPkId
                ]);
            }
            $message = $this->message("success", "Хэлтэс ам년ттай устлаа.");
        } catch (\Exception $ex){
            $this->writeLog("Department delete error: ".$ex->getMessage());
            $message = $this->message("danger", "Хэлтэс устгахад 오류가 발생했습니다.");
        }
        return redirect(route('refdepartment'))->with("message", $message);
    }

    public function indexArchive(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/settings/archive", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try {
            $provinces = DB::table("ADDRESS_PROVINCE")->orderBy("name", "ASC")->get();
            $departments = MainUserDepartment::whereNull("deleted_at")->orderBy("Name", "ASC")->get();
            $userPkId = session()->get("auth")->id;
           
            if($request->isMethod("POST")){
                $province = $request->get("province");
                $department = $request->get("department");
                $archive = $request->get("archive");
                $abr = $request->get("abr");
                $env = $request->get("env");
                if($env != ""){
                    SystemArchive::where("Id", $this->dec($env))->update([
                        'ProvinceId' => $province,
                        'DepartmentId' => $department,
                        'Archive' => $archive,
                        'Abbr' => $abr,
                        'ModifiedBy' => $userPkId
                    ]);
                    $message = $this->message("success", "아카이브ын салбар ам년ттай засагдлаа.");
                } else {
                    $is_create = SystemArchive::where("Abbr", $abr)->count();
                    if($is_create < 1){
                        SystemArchive::create([
                            'ProvinceId' => $province,
                            'DepartmentId' => $department,
                            'Archive' => $archive,
                            'Abbr' => $abr,
                            'CreatedBy' => $userPkId,
                            'ModifiedBy' => $userPkId
                        ]);
                        $message = $this->message("success", "아카이브ын салбар ам년ттай бүртгэгдлээ.");
                    } else {
                        $message = $this->message("info", "아카이브ын салбарын товч нэр давхцаж байна.");
                    }
                }
                return redirect(route("archive"))->with("message", $message);
            } else {
                $archives = DB::table("SYSTEM_DEPARTMENT_ARCHIVE")->whereNull('deleted_at')->get();
                $code = $request->route("code");
                if($code != ""){
                    $archive = SystemArchive::where("Id", $this->dec($code))->get()->first();
                }
               
               
                return view('System.archive', compact('provinces', 'departments', 'archives', 'archive'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Archive department error: ".$ex->getMessage());
            $message = $this->message("danger", "오류가 발생하여 작업을 다시 하세요.");
            return redirect(route("archive"))->with("message", $message);
        }
    }

    public function deleteArchive(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/settings/archive", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $key = $request->route("code");
            if($key != null){
                $key = $this->dec($key);
                SystemArchive::where("Id", $key)->update([
                    'deleted_at' => Carbon::now()->format("Y-m-d"),
                    'MODIFIEDBY' => $userPkId
                ]);
            }
            $message = $this->message("success", "아카이브ын салбар ам년ттай устлаа.");
        } catch (\Exception $ex){
            $this->writeLog("Archive department delete error: ".$ex->getMessage());
            $message = $this->message("success", "아카이브ын салбар устгахад 오류가 발생했습니다..");
        }
        return redirect(route('archive'))->with("message", $message);
    }
}
