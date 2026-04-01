<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Frontend\Str;
use App\AddressMicroDistrict;
use App\AddressProvince;
use App\AddressSubDev;
use App\AddressSubDevUnit;
use App\Http\Controllers\BaseController;
use App\MainService;
use App\MainUserPosition;
use App\MainUserPositionMenu;
use App\Owner;
use App\VehicleArchive;
use App\Owner1Ship;
use App\OwnerType;
use App\PositionLog;
use App\RefReferenceOrg;
use App\Series;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReferenceController extends BaseController
{
    public function indexService(Request $request) 
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/service", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if (self::isRealUiWithoutDb()) {
            $services = collect([]);
            $message = $this->message(
                'info',
                '[로컬] Oracle 미연결: 서비스 기준정보는 빈 목록으로 표시됩니다.'
            );

            return view('System.service', compact('services', 'message'));
        }
        try{
            $userPkId = session()->get("auth")->id;
            if($request->isMethod("POST")){
                $code = $request->get("code");
                $name = $request->get("name");
                $archive = $request->get("archive");
                $fee = $request->get("fee");
                $env = $request->get("env");
                if($env != ""){
                    MainService::where("Id", $this->dec($env))->update([
                        'Code' => $code,
                        'ServicePrefix' => $archive,
                        'Name' => $name,
                        'Fee' => $fee,
                        'ModifiedBy' => $userPkId
                    ]);
                    $message = $this->message("success", "서비스가 성공적으로 수정되었습니다.");
                } else {
                    MainService::create([
                        'Code' => $code,
                        'ServicePrefix' => $archive,
                        'Name' => $name,
                        'Fee' => $fee,
                        'CreatedBy' => $userPkId,
                        'ModifiedBy' => $userPkId
                    ]);
                    $message = $this->message("success", "서비스가 성공적으로 등록되었습니다.");
                }
                $services = MainService::orderBy("CREATEDDATE", "DESC")->get();
                return view('System.service', compact('services', 'message'));
            } else {
                $key = $request->route("code");
                if($key != null){
                    $key = $this->dec($key);
                    $service = MainService::where("Id", $key)->get()->first();
                }
                $services = MainService::whereNull("DELETED_AT")->orderBy("CREATEDDATE", "DESC")->get();
                return view('System.service', compact('services', 'service'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Service error: ". $ex->getMessage());
            $message = $this->message("danger", "오류가 발생하여 작업을 다시 하세요.");
            // 같은 URL로 리다이렉트하면 DB 오류 시 무한 리다이렉트가 됨
            return redirect(route("dashboard"))->with("message", $message);
        }
    }

    public function deleteService(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $key = $request->route("code");
            if($key != null){
                $key = $this->dec($key);
                MainService::where("Id", $key)->update([
                    "DELETED_AT" => Carbon::now()->format("Y-m-d")
                ]);
            }
            $message = $this->message("success", "서비스가 성공적으로 삭제되었습니다.");
        } catch (\Exception $ex){
            $this->writeLog("Service delete error: ".$ex->getMessage());
            $message = $this->message("danger", "서비스 삭제 중 오류가 발생했습니다.");
        }
        return redirect(route('refservice'))->with("message", $message);
    }

    public function indexPosition(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/position", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $services = DB::table("SYSTEM_SERVICE")->where("IS_SHOW", 1)->whereNull("DELETED_AT")->orderBy("VIEW_ORDER", "ASC")->get();
            $userMenus = DB::table("SYSTEM_MENU");
            if($request->isMethod("POST")){
                $menus = $request->get("menus");
                $services_action = $request->get("services");
                $name = $request->get("name");
                $env = $request->get("env");
                if($env != ""){
                    $position = $this->dec($env);
                    $code = Carbon::now()->format("Y-m-d H:i:s");
                    $oldMainUserPositions = MainUserPositionMenu::where("POSITION_ID", $position)->get();
                    $position_name = MainUserPosition::where("ID", $position)->get()->first()->name;
                    foreach ($oldMainUserPositions as $old){
                        try {
                            PositionLog::create([
                                'Name' => $position_name,
                                'Action_Id' => $old->ACTION_ID ?? $old->Action_Id ?? $old->action_id,
                                'Position_Id' => $old->POSITION_ID ?? $old->Position_Id ?? $old->position_id,
                                'Type_Id' => $old->TYPE_ID ?? $old->Type_Id ?? $old->type_id,
                                'CreatedDate' => $code, // Changed from CREATEDDATE to match fillable
                                'CreatedBy' => $old->CREATEDBY ?? $old->CreatedBy ?? $old->createdby,
                                'UpdatedBy' => $userPkId
                            ]);
                        } catch (\Exception $e) {
                            \Illuminate\Support\Facades\Log::error("PositionLog save failed: " . $e->getMessage());
                        }
                    }
                    $this->menu($menus, $position, $userPkId, 1);
                    $this->menu($services_action, $position, $userPkId, 2);
                }
                if($env != ""){
                    MainUserPosition::where("Id", $this->dec($env))->update([
                        'Name' => $name,
                        'ModifiedBy' => $userPkId
                    ]);
                    $message = $this->message("success", "직위(공무)가 성공적으로 수정되었습니다.");
                } else {
                    MainUserPosition::create([
                        'Name' => $name,
                        'CreatedBy' => $userPkId,
                        'ModifiedBy' => $userPkId
                    ]);
                    $message = $this->message("success", "직위(공무)가 성공적으로 등록되었습니다.");
                }
                $userMenus = $userMenus->orderBy("ORDR", "ASC")->get();
                if(session()->get("auth")->userpositionid == 1 || session()->get("auth")->userpositionid == 103){
                    $positions = DB::table('SYSTEM_POSITION')->whereNull("DELETED_AT")->orderBy("ID", "DESC")->get();
                } else {
                    $positions = DB::table('SYSTEM_POSITION')->whereNull("DELETED_AT")->where("ID", "!=", 1)->where("ID", "!=", 103)->orderBy("ID", "DESC")->get();
                }
                if ($env != "") {
                    $position = MainUserPosition::where("Id", $this->dec($env))->get()->first();
                }
                return view('System.position', compact('positions', 'message', 'userMenus', 'services', 'position'));
            } else {
                $key = $request->route("code");
                $position = null;
                if($key != null){
                    $key = $this->dec($key);
                    $position = MainUserPosition::where("Id", $key)->get()->first();
                    $userMenus = $userMenus->orderBy("ORDR", "ASC")->get();
                }
                if(session()->get("auth")->userpositionid == 1 || session()->get("auth")->userpositionid == 103){
                    $positions = MainUserPosition::whereNull("DELETED_AT")->orderBy("CREATEDDATE", "DESC")->get();
                } else {
                    $positions = MainUserPosition::whereNull("DELETED_AT")->where("ID", "!=", 1)->where("ID", "!=", 103)->orderBy("CREATEDDATE", "DESC")->get();
                }
                return view('System.position', compact('positions', 'position', 'userMenus', 'services'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Position error: ". $ex->getLine()." - ".$ex->getMessage());
            $message = $this->message("danger", "오류가 발생하여 작업을 다시 하세요.");
            return redirect(route("refposition"))->with("message", $message);
        }
    }

    public function deletePosition(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $key = $request->route("code");
            if($key != null){
                $key = $this->dec($key);
                if($key != 103 && $key != 1){
                    MainUserPosition::where("Id", $key)->update([
                        'DELETED_AT' => Carbon::now()->format("Y-m-d")
                    ]);
                }
            }
            $message = $this->message("success", "직위(공무)가 삭제되었습니다.");
        } catch (\Exception $ex){
            $this->writeLog("Position delete error: ".$ex->getMessage());
            $message = $this->message("danger", "직위(공무) 삭제 중 오류가 발생했습니다.");
        }
        return redirect(route('refposition'))->with("message", $message);
    }

    public function menu($datas, $position, $userPkId, $type){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            MainUserPositionMenu::where("POSITION_ID", $position)->where("TYPE_ID", $type)->delete();
            if($datas != null){
                foreach ($datas as $data){
                    MainUserPositionMenu::create([
                        'Action_Id' => $data,
                        'Position_Id' => $position,
                        'Type_Id' => $type,
                        'CreatedBy' => $userPkId,
                        'UpdatedBy' => $userPkId
                    ]);
                }
            }
        } catch (\Exception $ex){
            $this->writeLog("Menu permission error: ".$ex->getMessage());
            $message = $this->message("danger", "직위 권한 설정 중 오류가 발생했습니다.");
            return redirect(route("refposition"))->with("message", $message);
        }
    }

    public function indexVehicle(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        return view('System.vehiclereference');
    }

    public function indexAddress(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $countries = DB::table("REF_COUNTRY")->get();
        return view('System.addressreference', compact('countries'));
    }

    public function indexProvince(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/address/province", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $provinces = DB::table("ADDRESS_PROVINCE")->get();
        return view('System.addressreferenceprovince', compact('provinces'));
    }

    public function indexDestrict(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/address/destrict", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $districts = DB::table("ADDRESS_SUBDEV")
            ->leftJoin('ADDRESS_PROVINCE', function($join) {
                $join->on('ADDRESS_SUBDEV.PROVINCE_ID', '=' , 'ADDRESS_PROVINCE.ID');
            })
            ->select(["ADDRESS_PROVINCE.NAME AS ProvinceName", "ADDRESS_SUBDEV.NAME AS DistrictName"])
            ->get();
        return view('System.addressreferencedestrict', compact('districts'));
    }

    public function indexCommission(Request $request)
    {
        if(!session()->has("auth")){ 
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/address/commission", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $commissions = DB::table("ADDRESS_SUBDEV_UNIT")
            ->leftJoin('ADDRESS_SUBDEV', function($join) {
                $join->on('ADDRESS_SUBDEV_UNIT.DEVISION_ID', '=' , 'ADDRESS_SUBDEV.ID');
            })
            ->leftJoin('ADDRESS_PROVINCE', function($join) {
                $join->on('ADDRESS_SUBDEV.PROVINCE_ID', '=' , 'ADDRESS_PROVINCE.ID');
            })
            ->select(["ADDRESS_SUBDEV_UNIT.ID AS ID", "ADDRESS_PROVINCE.NAME AS ProvinceName", "ADDRESS_SUBDEV.NAME AS DistrictName", "ADDRESS_SUBDEV_UNIT.NAME AS DistrictUnitName"])
            ->get();
        return view('System.addressreferencecommission', compact('commissions'));
    }

    public function createCommission(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $provinces = DB::table("ADDRESS_PROVINCE")->orderBy("name", "ASC")->get();

            if($request->isMethod("POST")){
                $district = $request->get("district");
                $name = $request->get("khoroo");
                $userPkId = $this->dec(trim($request->get("env")));
                $code = trim($request->get("env1"));
                if($code != null){
                    AddressSubDevUnit::where("Id", $this->dec($code))->update([
                        'DEVISION_ID' => $district,
                        'Name' => $name,
                        'Updated_By_Id' => $userPkId
                    ]);
                    $message = $this->message("success", "바그/동이 성공적으로 수정되었습니다.");
                    return redirect(route("adrefcomm"))->with("message", $message);
                } else {
                    AddressSubDevUnit::create([
                        'DEVISION_ID' => $district,
                        'Name' => $name,
                        'Created_By_Id' => $userPkId,
                        'Updated_By_Id' => $userPkId
                    ]);
                    $message = $this->message("success", "바그/동이 성공적으로 등록되었습니다.");
                    return view('System.addressreferencecreatecommission', compact('provinces', 'message'));
                }
            } else {
                $code = $request->route("code");
                if($code != null){
                    $address = AddressSubDevUnit::where("Id", $this->dec($code))->get()->first();
                    $name = $address->name;
                    $district_id = $address->devision_id;

                    $province_id = AddressSubDev::where("Id", $district_id)->get();
                    if($province_id->count() > 0){
                        $province_id = $province_id->first()->province_id;
                    } else {
                        $province_id = 0;
                    }
                    $province_id = $province_id == null ? $province_id = 0 : $province_id;
                    return view('System.addressreferencecreatecommission', compact('provinces', 'devision_unit_id', 'district_id', 'province_id', 'name', 'code'));
                } else {
                    return view('System.addressreferencecreatecommission', compact('provinces'));
                }
            }
        } catch (\Exception $ex){
            $this->writeLog("Khoroo create error: ".$ex);
            $message = $this->message("danger", "동 추가 중 오류가 발생했습니다.");
            return redirect(route("adrefcomm"))->with("message", $message);
        }
    }

    public function deleteCommssion(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $key = $request->route("code");
            if($key != null){
                $key = $this->dec($key);
                DB::table("ADDRESS_SUBDEV_UNIT")->where("Id", $key)->delete();
            }
            $message = $this->message("success", "바그/동이 성공적으로 삭제되었습니다.");
        } catch (\Exception $ex){
            $this->writeLog("Баг хороо delete error: ".$ex->getMessage());
            $message = $this->message("danger", "바그/동 삭제 중 오류가 발생했습니다.");
        }
        return redirect(route('adrefcomm'))->with("message", $message);
    }

    public function indexTown(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/address/town", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $towns = DB::table("ADDRESS_MICRODISTRICT")
            ->leftJoin('ADDRESS_SUBDEV_UNIT', function($join) {
                $join->on('ADDRESS_MICRODISTRICT.DEVISION_UNIT_ID', '=' , 'ADDRESS_SUBDEV_UNIT.ID');
            })
            ->leftJoin('ADDRESS_SUBDEV', function($join) {
                $join->on('ADDRESS_SUBDEV_UNIT.DEVISION_ID', '=' , 'ADDRESS_SUBDEV.ID');
            })
            ->leftJoin('ADDRESS_PROVINCE', function($join) {
                $join->on('ADDRESS_SUBDEV.PROVINCE_ID', '=' , 'ADDRESS_PROVINCE.ID');
            })
            ->select(["ADDRESS_MICRODISTRICT.ID AS ID", "ADDRESS_PROVINCE.NAME AS ProvinceName", "ADDRESS_SUBDEV.NAME AS DistrictName", "ADDRESS_SUBDEV_UNIT.NAME AS DistrictUnitName", "ADDRESS_MICRODISTRICT.NAME AS TownName"])
            ->get();
        return view('System.addressreferencetown', compact('towns'));
    }

    public function deleteTown(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $key = $request->route("code");
            if($key != null){
                $key = $this->dec($key);
                DB::table("ADDRESS_MICRODISTRICT")->where("Id", $key)->delete();
            }
            $message = $this->message("success", "구역이 성공적으로 삭제되었습니다.");
        } catch (\Exception $ex){
            $this->writeLog("Position delete error: ".$ex->getMessage());
            $message = $this->message("danger", "구역 삭제 중 오류가 발생했습니다.");
        }
        return redirect(route('refaddresstown'))->with("message", $message);
    }

    public function createTown(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $provinces = DB::table("ADDRESS_PROVINCE")->orderBy("name", "ASC")->get();

            if($request->isMethod("POST")){
                $commission = $request->get("commission");
                $name = $request->get("khoroolol");
                $shorten = $request->get("shorten");
                $userPkId = $this->dec(trim($request->get("env")));
                $code = trim($request->get("env1"));
                if($code != null){
                    AddressMicroDistrict::where("Id", $this->dec($code))->update([
                        'DEVISION_UNIT_ID' => $commission,
                        'Code' => $shorten,
                        'Name' => $name,
                        'Updated_By_Id' => $userPkId
                    ]);
                    $message = $this->message("success", "구역이 성공적으로 수정되었습니다.");
                    return redirect(route("refaddresstown"))->with("message", $message);
                } else {
                    AddressMicroDistrict::create([
                        'DEVISION_UNIT_ID' => $commission,
                        'Code' => $shorten,
                        'Name' => $name,
                        'Created_By_Id' => $userPkId,
                        'Updated_By_Id' => $userPkId
                    ]);
                    $message = $this->message("success", "구역이 성공적으로 등록되었습니다.");
                    return view('System.addressreferencecreatetown', compact('provinces', 'message'));
                }
            } else {
                $code = $request->route("code");
                if($code != null){
                    $address = AddressMicroDistrict::where("Id", $this->dec($code))->get()->first();
                    $name = $address->name;
                    $abbr = $address->code;
                    $micro_id = $this->dec($code);
                    $devision_unit_id = $address->devision_unit_id;
                    $district_id = AddressSubDevUnit::where("Id", $devision_unit_id)->get();
                    if($district_id->count() > 0){
                        $district_id = $district_id->first()->devision_id;
                    } else {
                        $district_id = 0;
                    }

                    $district_id = $district_id == null ? $district_id = 0 : $district_id;
                    $province_id = AddressSubDev::where("Id", $district_id)->get();
                    if($province_id->count() > 0){
                        $province_id = $province_id->first()->province_id;
                    } else {
                        $province_id = 0;
                    }
                    $province_id = $province_id == null ? $province_id = 0 : $province_id;
                    return view('System.addressreferencecreatetown', compact('provinces', 'micro_id', 'devision_unit_id', 'district_id', 'province_id', 'name', 'abbr', 'code'));
                }
                return view('System.addressreferencecreatetown', compact('provinces'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Khoroolol create error: ".$ex);
            $message = $this->message("danger", "구역 추가 중 오류가 발생했습니다.");
            return redirect(route("createtown"))->with("message", $message);
        }
    }

    public function indexFactoryCountry(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/factorycountry", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $countries = DB::table("REF_COUNTRY")->get();
        return view('System.factorycountry', compact('countries'));
    }

    public function indexOwner(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/owner", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if($request->isMethod("POST")){
            $register = $request->get("register");
            $phone = $request->get("phone");
            $name = $request->get("name");
            $owners = DB::table("REG_OWNER_VIEW");
            $is_search = false;
            if($register != "" || $register != null){
                //$register = str_replace("*", "%", $register);
                $owners = $owners->where("REGISTER_NO", "LIKE", "%".$register."%");
                //$register = str_replace("%", "*", $register);
                $is_search = true;
            }
            if($phone != "" || $phone != null){
                $phone = str_replace("*", "%", $phone);
                $owners = $owners->where("PHONE_NO", "LIKE", $phone);
                $phone = str_replace("%", "*", $phone);
                $is_search = true;
            }
            if($name != "" || $name != null){
                $name = str_replace("*", "%", $name);
                $owners = $owners->where("FIRST_NAME", "LIKE", $name);
                $name = str_replace("%", "*", $name);
                $is_search = true;
            }
            if($is_search){
                $owners = $owners->get();
                return view('System.owner', compact('owners', 'register', 'phone', 'name'));
            } else {
                return view('System.owner', compact('register', 'phone', 'name'));
            }
        } else {
            return view('System.owner');
        }
    }

    public function createOwner(Request $request)
    {
        if(!session()->has("auth")){ 
            return redirect(route($this->redirectURL));
        }
        try{
           // return $request;
            $userPkId = session()->get("auth")->id;
            $countries = DB::table("REF_COUNTRY")->get();
            $types = OwnerType::all();
            $provinces = DB::table("ADDRESS_PROVINCE")->orderBy("name", "ASC")->get();

           
            if($request->isMethod("POST")){
          
                $country = $request->get("location");
                $type = $request->get("type");
                $register = $request->get("register");
                $familyname = $request->get("familyname");
                $parent = $request->get("parent");
                $surname = $request->get("surname"); 
                $gender = $request->get("gender");
                $province = $request->get("province");
                $district = $request->get("district");
                $commission = $request->get("commission");
                $town = $request->get("town");
                $street = $request->get("street");
                $apartment = $request->get("apartment");
                $door = $request->get("door");
                $homephone = $request->get("homephone");
                $cellphone = $request->get("cellphone");
                $workphone = $request->get("workphone");
                $zipcode = $request->get("zipcode");
                $specialnote = $request->get("specialnote");
                $order_qty = $request->get("orderQty");
                $env = $request->get("env");

                // if($type == 1){
                //     $order_qty > 3 ? $order_qty = 3 : $order_qty;
                // }

                $address_details = "";
                if($province != ""){
                    $province_add = AddressProvince::where("Id", $province)->get();
                    if($province_add->count() > 0){
                        $province_add = $province_add->first();
                        $address_details .= $province_add->name. " ";
                    }
                }
                if($district != ""){
                    $district_add = AddressSubDev::where("Id", $district)->get();
                    if($district_add->count() > 0){
                        $district_add = $district_add->first();
                        $address_details .= $district_add->name. " ";
                    }
                }
                if($commission != ""){
                    $commission_add = AddressSubDevUnit::where("Id", $commission)->get();
                    if($commission_add->count() > 0){
                        $commission_add = $commission_add->first();
                        $address_details .= $commission_add->name. " ";
                    }
                }
                // if($town != ""){
                //     $town_add = AddressMicroDistrict::where("Id", $town)->get();
                //     if($town_add->count() > 0){
                //         $town_add = $town_add->first();
                //         $address_details .= $town_add->name. " ";
                //     }
                // }

                $address_details .= $street." ".$apartment." ".$door."-".$town;
                if($env != ""){
             // return $address_details;
                  Owner::findOrFail($this->dec($env))->update([
                       // 'APARTMENT_NO' => $apartment,
                        'CELLPHONE' => $cellphone,
                       // 'ZIP' => $zipcode,
                       // 'PROVINCE_ID' => $province,
                      //  'DISTRICT_ID' => $district,
                       // 'DOOR_NO' => $door,
                        'FAMILY_NAME' => $familyname,
                        'FIRST_NAME' => $surname,
                        'GENDER' => $gender,
                        'HOMEPHONE' => $homephone,
                        'LAST_NAME' => $parent,
                        //'MORE_INFO' => $specialnote,
                        'ADDRESS_DETAIL' => $address_details,
                        'REGISTER_NO' => $register,
                       // 'STREET' => $street,
                        'WorkPhone' => $workphone,
                        'COUNTRY_ID' => $country,
                        'TYPE_ID' => $type,
                        'DEVISION_UNIT_ID' => $commission,
                        //'MICRO_DISTRICT_ID' => $town,
                        'ORDER_QTY' => $order_qty,
                        'Updated_By_Id' => $userPkId
                    ]);
                   
                  
                    $message = $this->message("success", "소유자 정보가 성공적으로 수정되었습니다.");
                    return redirect(url("/reference/createowner/edit/".$env))->with("message", $message);
                } else {
                    if($type == 1){
                        $is_create = Owner::where("REGISTER_NO", $register)->get()->count();
                    } else {
                        $is_create = 0;
                        $companies = Owner::where("REGISTER_NO", "LIKE", $register . "%")->orderBy("REGISTER_NO", "DESC")->get();
                        if($companies->count() > 0){
                            $company = $companies->first();
                            $count = (int)substr($company->register_no, -4);
                            $count += 1;
                            if(strlen($count) == 1){
                                $tmp_register = '000'.$count;
                            } elseif(strlen($count) == 2){
                                $tmp_register = '00'.$count;
                            } elseif(strlen($count) == 3){
                                $tmp_register = '0'.$count;
                            } elseif(strlen($count) == 4) {
                                $tmp_register = $count;
                            }
                            $register .= $tmp_register;
                        } else {
                            $register .= '0001';
                        }
                    }
                    if($is_create == 0){
                       // return $request;
                        Owner::create([
                         //   'APARTMENT_NO' => $apartment,
                            'CELLPHONE' => $cellphone,
                          //  'ZIP' => $zipcode,
                          //  'DISTRICT_ID' => $district,
                          //  'PROVINCE_ID' => $province,
                          //  'DOOR_NO' => $door,
                            'FAMILY_NAME' => $familyname,
                            'FIRST_NAME' => $surname,
                            'GENDER' => $gender,
                            'HOMEPHONE' => $homephone,
                            'LAST_NAME' => $parent,
                           // 'MORE_INFO' => $specialnote,
                            'ADDRESS_DETAIL' => $address_details,
                            'REGISTER_NO' => $register,
                           // 'STREET' => $street,
                            'WorkPhone' => $workphone,
                            'COUNTRY_ID' => $country,
                            'TYPE_ID' => $type,
                            'DEVISION_UNIT_ID' => $commission,
                           // 'MICRO_DISTRICT_ID' => $town,
                            //'ADDRESS_DETAIL' => $town,
                            'ORDER_QTY' => $order_qty,
                            'Created_By_Id' => $userPkId,
                            'Updated_By_Id' => $userPkId
                        ]);

                        $message = $this->message("success", "소유자 정보가 성공적으로 등록되었습니다.");
                    } else {
                        $message = $this->message("info", "소유자 정보가 이미 등록되어 있습니다.");
                    }
                    return view('System.ownercreate', compact( 'types', 'provinces', 'countries', 'message'));
                }
            } else {
                $code = $request->route("code");
               
                $province_id = "";
                if($code != null){
                    $owner_id = $this->dec($code);
                    $owners = DB::table("REG_OWNER_VIEW")->where("ID", $owner_id)->get()->first();
                   // return $owners->id;
                    $owner = Owner::where("Id", $owner_id)->first();
               //  return $owner;
                    $district_id = $owners->district_id;
                    $province_id = $owners->province_id;
                    $addressDet=$owners->address;
                   // $address=$owners->address;

              
               
                 
                    $address="";
                    if (str_contains($owner->address_detail, '   -')) {
                        $address =  explode("   -", $owner->address_detail , 2);
                        $address =$address[1];
                    }else{
                        $address= "";
                    }
                   //  return $address;
                    
                   
                   // dd($owners->address);
                    

                }
                //return $district_id;
                
                return view('System.ownercreate', compact( 'types', 'provinces', 'countries', 'owner', 'province_id','addressDet', 'address','district_id'));
            }
        } catch(\Exception $ex){
            $this->writeLog("Create owner error: ".$ex->getMessage());
            $message = $this->message("danger", "오류가 발생하여 작업을 다시 하세요.");
            return redirect(route("createowner"))->with("message", $message);
        }
    }

    public function deleteOwner(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $key = $request->route("code");
            if($key != null){
                $key = $this->dec($key);
                Owner::where("Id", $key)->delete();
            }
            $message = $this->message("success", "가등록 소유자가 성공적으로 삭제되었습니다.");
        } catch (\Exception $ex){
            $this->writeLog("Position delete error: ".$ex->getMessage());
            $message = $this->messesage("danger", "소유자 삭제 중 오류가 발생했습니다.");
        }
        return redirect(route('owner'))->with("message", $message);
    }

    public function ownerTwo(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
       
        try{ 
  //return $request;
            $userPkId = session()->get("auth")->id;
            $owner = trim($request->get("new_owner"));
            $arkhCheckNum = trim($request->get("arkhCheckNum"));
            $plate_no = $this->dec(trim($request->get("current_plate")));
            $certificate = trim($request->get("certificate"));
            $page_count = trim($request->get("page_count"));
            $finger = trim($request->get("fingerDescription"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $vehicle = Vehicle::where("PLATE_NO", $plate_no)->get();
            if($vehicle->count() > 0){
               // $vehicle1=$vehicle->first();  
                $this->createOwner1Ship($owner, $vehicle->first()->owner1_id, $vehicle->first()->id, 17);
          
                if ($arkhCheckNum == 1) {

                  //  return $request;
                    $service = $this->getActionPrefix(17);
                    $archive_no = $this->archiveNumberGenerate($service);
                    DB::beginTransaction();
                   
                 $this->createArchive($vehicle->first()->id, $service->id, $certificate, $archive_no, $plate_no, $owner, $page_count, "사용자 등록 완료", $finger, $fingerDescription);
                    
                    Vehicle::where("Id", $vehicle->first()->id)->update([
                        'OWNER1_ID' => $owner,
                    
                        'ARCHIVE_NO' => $archive_no,
                        //'FIRST_ARCHIVE_NO' => $archive_no,
                        'UPDATED_BY' => $userPkId
                    ]);

                }else{
                           
                Vehicle::where("Id", $vehicle->first()->id)->update([
                    'OWNER1_ID' => $owner,
                    'UPDATED_BY' => $userPkId,
                  //  'ARCHIVE_NO' => $archive_no,
                  //  'FIRST_ARCHIVE_NO' => $archive_no,
                  
                ]);
                }
            

                DB::commit();
                $message = $this->message("success", "소유자가 성공적으로 등록되었습니다.");
                return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
            
            } else {
                $message = $this->message("info", $plate_no . "소유자 등록할 차량을 찾을 수 없습니다.");
                return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
            }
        } catch (\Exception $ex){
            $this->writeLog("Register owner2 error: ".$ex->getMessage());
            $message = $this->message("danger",  "소유자 등록 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
        }
    }
    public function createArchive($vehicle_id, $service_id, $certificate, $archive_number, $plate_no, $owner_id, $page_count, $description, $finger, $finger_description){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $request = Vehicle::where("Id", $vehicle_id)->get()->first();
        $userPkId = session()->get("auth")->id;
        $service = $this->getActionPrefix($request->status);
//return $request;
        VehicleArchive::create([
            'PLATE_NO' => $request->plate_no,
            'CABIN_NO' => $request->cabin_no,
            'ENGINE_NO' => $request->engine_no,
            'COLOR_ID' => $request->color_id,
            'CERTIFICATE_NO' => $request->certificate_no,
            'IMPORT_DATE' => $request->import_date,
            'DECLARATION_NO' => $request->declaration_no,
            'MODEL_ID' => $request->model_id,
            'SPECIAL_ID' => $request->special_id,
            'BUILD_YEAR' => $request->build_year,
            'BUILD_MONTH' => $request->build_month,
            'PAR_TYPE_ID' => $request->par_type_id,
            'OWNER_ID' => $request->owner_id,
            'OWNER1_ID' => $request->owner1_id,
            'ARCHIVE_DEPARTMENT' => session()->get("archive")->departmentid,
            'ARCHIVE_ABBR' => session()->get("archive")->abbr,
            'ARCHIVE_NO' => $request->archive_no,
            'FIRST_ARCHIVE_NO' => $request->first_archive_no,
            'PAGE_COUNT' => $request->page_count,
            'IS_ENABLED' => $request->is_enabled,
            'IS_STOLEN' => $request->is_stolen,
            'IS_WARNING' => $request->is_stolen,
            'WHEEL_ID' => $request->wheel_id,
            'STEERING_TYPE_ID' => $request->steering_type_id,
            'ENGINE_MODEL_ID' => $request->engine_model_id,
            'PAR_MARKER_ID' => $request->par_marker_id,
            'STATUS' => $request->status,
            'IS_PENDING' => $request->is_pending,
            'OLD_PROVINCE_ID' => $request->old_province_id,
            'PROVINCE_ID' => $request->province_id,
            'VIN_NO' => $request->vin_no,
            'COLOR_NAME' => $request->color_name,
            'COUNTRY_ID' => $request->country_id,
            'MARK_ID' => $request->mark_id,
            'MARK_NAME' => $request->mark_name,
            'MODEL_NAME' => $request->model_name,
            'VEHICLE_ID' => $request->id,
            'SERVICE_ID' => $request->status,
            'SERVICE_NAME' => $service->name,
            'INSERT_CERTIFICATE_NO' => $certificate,
            'INSERT_ARCHIVE_NO' => $archive_number,
            'INSERT_PLATE_NO' => $plate_no,
            'INSERT_OWNER_ID' => $owner_id,
            'INSERT_SERVICE_ID' => $service_id,
            'INSERT_PAGE_COUNT' => $page_count,
            'INSERT_FINGER' => $finger,
            'INSERT_FINGER_DESCRIPTION' => $finger_description,
            'INSERT_DESCRIPTION' => $description,
            'UPDATED_DATE' => $request->updated_date,
            'CREATED_BY' => $request->updated_by,
            'UPDATED_BY' => $userPkId
        ]);
    }
    public function createOwner1Ship($new_owner1, $old_owner1_id, $vehicle_id, $status){
        if(!session()->has("auth")){ 
            return redirect(route($this->redirectURL));
        }
        $userPkId = session()->get("auth")->id;
        if($old_owner1_id != 0){
            Owner1Ship::where("VEHICLE_ID", $vehicle_id)
                ->where("OWNER1_ID", $old_owner1_id)
                ->whereNull("END_DATE")
                ->update([
                    'END_DATE' => Carbon::now()->format("Y-m-d H:i:s"),
                    'UPDATED_BY' => $userPkId
                ]);
        }

        Owner1Ship::create([
            'VEHICLE_ID' => $vehicle_id,
            'OWNER1_ID' => $new_owner1,
            'START_DATE' => Carbon::now()->format("Y-m-d H:i:s"),
            'STATUS' => $status,
            'CREATED_BY' => $userPkId,
            'UPDATED_BY' => $userPkId
        ]);
    }
    public function getActionPrefix($service){
     
        $service = MainService::where("Id", $service)->get()->first();
        return $service;
    }
    public function archiveNumberGenerate($service){
    
        $archive_prefix = "";
        $archive_department_abbr = "";
        try{
            $userPkId = session()->get("auth")->id;
            $current_year = Carbon::now()->format("Y");
            $current_month = Carbon::now()->format("m");
            $archive_department_id = session()->get("archive")->departmentid;
            $archive_department_abbr = session()->get("archive")->abbr;
            $archive_prefix = $service->serviceprefix;
            //return $current_month;
            if($archive_department_abbr == "ДК"){
                $archive_prefix = "ШЭ";
            }
            $archive = DB::select("SELECT * FROM ARCHIVE_NUMBER WHERE ABBR = '".$archive_department_abbr."' AND ARCHIVE_DEPARTMENT_ID = ".$archive_department_id." AND YEAR =".$current_year." AND MONTH = ".$current_month." FOR UPDATE");
            if($archive_prefix == "ШЭ"){
                DB::update("UPDATE ARCHIVE_NUMBER SET NEW_COUNT = NEW_COUNT+1, MODIFIEDBY = ".$userPkId." WHERE ABBR = '".$archive_department_abbr."' AND ARCHIVE_DEPARTMENT_ID = ".$archive_department_id." AND YEAR =".$current_year." AND MONTH = ".$current_month);
                $update_count = $archive[0]->new_count + 1;
            } elseif($archive_prefix == "ШХ") {
                DB::update("UPDATE ARCHIVE_NUMBER SET OTHER_COUNT = OTHER_COUNT+1, MODIFIEDBY = ".$userPkId." WHERE ABBR = '".$archive_department_abbr."' AND ARCHIVE_DEPARTMENT_ID = ".$archive_department_id." AND YEAR =".$current_year." AND MONTH = ".$current_month);
                $update_count = $archive[0]->other_count + 1;
            } elseif($archive_prefix == "ХАС"){
                DB::update("UPDATE ARCHIVE_NUMBER SET DELETE_COUNT = DELETE_COUNT+1, MODIFIEDBY = ".$userPkId." WHERE ABBR = '".$archive_department_abbr."' AND ARCHIVE_DEPARTMENT_ID = ".$archive_department_id." AND YEAR =".$current_year." AND MONTH = ".$current_month);
                $update_count = $archive[0]->delete_count + 1;
            }
            DB::commit();
            $generater = "";
            $len = strlen($update_count);
            if($len == 6){
                $generater = $update_count;
            } elseif ($len == 5){
                $generater .= "0".$update_count;
            } elseif ($len == 4){
                $generater .= "00".$update_count;
            } elseif ($len == 3){
                $generater .= "000".$update_count;
            } elseif ($len == 2){
                $generater .= "0000".$update_count;
            } elseif ($len == 1){
                $generater .= "00000".$update_count;
            }
            return $archive_prefix.$archive_department_abbr.Carbon::now()->format("y").$current_month.$generater;
        } catch (\Exception $ex){
            DB::commit();
            $this->writeLog("Archive number generate error: ".$archive_prefix." - ".$archive_department_abbr." => ". $ex);
            return "ERROR";
        }
    }
    public function indexSeries(Request $request)
    {
        //return "gjhjhg";
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
       // dd(session()->get("auth")->userpositionid);
        if(!$this->checkAccess("/reference/series", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $seriess = DB::table("SERIES_VIEW")->get();
        return view('System.series', compact('seriess'));
    }

    public function orderedNumbers(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try {
            if(BaseController::hasMenuShow("/reference/ordered_numbers", 1, BaseController::enc(session()->get("auth")->userpositionid))){
                $numbers = DB::table("SERIES_NUMBER")
                    ->where("IS_HIDDEN", 0)
                    ->where("IS_GIVEN", 0)
                    ->where("IS_OPENED", 1)
                    ->where("IS_ORDER", 1)
                    ->select("ORDER_USER", "ORDER_CABIN", "NAME", "ORDER_DATE")
                    ->orderby("NAME", "ASC")
                    ->get();
                return view('System.orderednumbers', compact('numbers', 'register'));
            } else {
                if($request->isMethod("POST")) {
                    $register = $request->get("register");

                    if($register != "%" && $register != "%%" && $register != "" && $register != null && strlen($register) > 1){
                        // if($register == "ДУГШАЛ"){
                        //     $numbers = DB::table("SERIES_NUMBER")
                        //         ->where("IS_HIDDEN", 0)
                        //         ->where("IS_GIVEN", 0)
                        //         ->where("IS_OPENED", 1)
                        //         ->where("IS_ORDER", 1)
                        //         ->where("ORDER_USER", "LIKE", "%%")
                        //         ->select("ORDER_USER", "ORDER_CABIN", "NAME", "ORDER_DATE")
                        //         ->orderby("NAME", "ASC")
                        //         ->get();
                        //     $register = "";
                        // } else {
                            $numbers = DB::table("SERIES_NUMBER")
                                ->where("IS_HIDDEN", 0)
                                ->where("IS_GIVEN", 0)
                                ->where("IS_OPENED", 1)
                                ->where("IS_ORDER", 1)
                                ->where("ORDER_USER", $register)
                                ->select("ORDER_USER", "ORDER_CABIN", "NAME", "ORDER_DATE")
                                ->orderby("NAME", "ASC")
                                ->get();
                       // }
                        return view('System.orderednumbers', compact('numbers', 'register'));
                    } else {
                        return view('System.orderednumbers');
                    }
                } else {
                    return view('System.orderednumbers');
                }
            }
        }catch (\Exception $ex){
            $this->writeLog("Ordered number search: ".$ex->getMessage());
            $message = $this->message("danger", "가입/등록정보 검색 중 오류가 발생했습니다.");
            return view('System.orderednumbers')->with("message", $message);
        }
    }

    public function referenceOrg(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/reference/org", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if($request->isMethod("POST")){
            $name = $request->get("name");
            $env = $request->get("env");
            $userPkId = session()->get("auth")->id;
            if($env != ""){
                RefReferenceOrg::where("ID", self::dec($env))->update([
                    "Name" => $name,
                    "UpdatedDate" => Carbon::now()->format("Y-m-d H:i:s")
                ]);
                $message = $this->message("success", "기관이 성공적으로 수정되었습니다.");
            } else {
                RefReferenceOrg::create([
                    "Name" => $name,
                    "CreatedBy" => $userPkId
                ]);
                $message = $this->message("success", "기관이 성공적으로 추가되었습니다.");
            }
            $archives = RefReferenceOrg::orderBy("CREATEDDATE", "DESC")->get();
            return view("System.archiveorg", compact('archives', 'message'));
        } else {
            $env = $request->route("code");
            $archives = RefReferenceOrg::orderBy("CREATEDDATE", "DESC")->get();
            if($env != ""){
                $archive = RefReferenceOrg::where("ID", self::dec($env))->get()->first();
                return view("System.archiveorg", compact('archives', 'archive'));
            } else {
                return view("System.archiveorg", compact('archives'));
            }
        }
    }
}
