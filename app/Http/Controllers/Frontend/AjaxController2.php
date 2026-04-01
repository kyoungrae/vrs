<?php

namespace App\Http\Controllers\Frontend;

use App\AddressMicroDistrict;
use App\AddressProvince;
use App\AddressSubDev;
use App\AddressSubDevUnit;
use App\Http\Controllers\BaseController;
use App\MainService;
use App\MainUser;
use App\MainUserDepartment;
use App\Owner;
use App\RegLimited;
use App\RegReferenceLog;
use App\Series; 
use App\RegCertificate;
use App\SeriesInterval;
use App\SeriesNumber;
use App\SystemPrinter;
use App\Vehicle;
use App\VehicleArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Illuminate\Support\Facades\Session;
class AjaxController extends BaseController
{
   
    public function createOwner(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        try{
          //   return $request;
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
            $order_qty = $request->get("orderqty");
            $userPkId = $this->dec($request->get("env"));
            $is_owner = $request->get("owner");
            $arkhCheck = $request->get("arkhCheck");

            if($type == 1){
                $order_qty > 3 ? $order_qty = 3 : $order_qty;
            }

            $address_details = "";
            if($province != ""){
                $province_add = AddressProvince::where("Id", $province)->get();
                if($province_add->count() > 0){
                    $province_add = $province_add->first();
                    $address_details .= $province_add->name. " ";
                }
            }
            if($province != ""){
                $district_add = AddressSubDev::where("Id", $district)->get();
                if($district_add->count() > 0){
                    $district_add = $district_add->first();
                    $address_details .= $district_add->name. " ";
                }
            }
            if($province != ""){
                $commission_add = AddressSubDevUnit::where("Id", $commission)->get();
                if($commission_add->count() > 0){
                    $commission_add = $commission_add->first();
                    $address_details .= $commission_add->name. " ";
                }
            }
            if($province != ""){
                $town_add = AddressMicroDistrict::where("Id", $town)->get();
                if($town_add->count() > 0){
                    $town_add = $town_add->first();
                    $address_details .= $town_add->name. " ";
                }
            }

            $address_details .= $street." ".$apartment." ".$door;

            if($is_owner != ""){
               if ($province == 22) {
                Owner::findOrFail( $is_owner)->update([
                    'APARTMENT_NO' => $apartment,
                    'CELLPHONE' => $cellphone,
                    'ZIP' => $zipcode,
                    'PROVINCE_ID' => $province,
                    'DISTRICT_ID' => $district,
                    'DOOR_NO' => $door,
                    'FAMILY_NAME' => $familyname,
                    'FIRST_NAME' => $surname,
                    'GENDER' => $gender,
                    'HOMEPHONE' => $homephone,
                    'LAST_NAME' => $parent,
                    'MORE_INFO' => $specialnote,
                    'ADDRESS_DETAIL' => $address_details,
                   // 'REGISTER_NO' => $register,
                    'STREET' => $street,
                    'WorkPhone' => $workphone,
                    'COUNTRY_ID' => $country,
                    'TYPE_ID' => $type, 
                    'DEVISION_UNIT_ID' => $commission,
                    'MICRO_DISTRICT_ID' => $town,
                    'ORDER_QTY' => $order_qty,
                    'Updated_By_Id' => $userPkId
                ]);
                return "updated";
                     }else{
                        Owner::findOrFail( $is_owner)->update([
                            'APARTMENT_NO' => $apartment,
                            'CELLPHONE' => $cellphone,
                            'ZIP' => $zipcode,
                            'PROVINCE_ID' => $province,
                            'DISTRICT_ID' => $district,
                            'DOOR_NO' => $door,
                            'FAMILY_NAME' => $familyname,
                            'FIRST_NAME' => $surname,
                            'GENDER' => $gender,
                            'HOMEPHONE' => $homephone,
                            'LAST_NAME' => $parent,
                            'MORE_INFO' => $specialnote,
                            'ADDRESS_DETAIL' => $address_details,
                           // 'REGISTER_NO' => $register,
                            'STREET' => $street,
                            'WorkPhone' => $workphone,
                            'COUNTRY_ID' => $country,
                            'TYPE_ID' => $type, 
                            'DEVISION_UNIT_ID' => $commission,
                            'MICRO_DISTRICT_ID' => $town,
                            'ORDER_QTY' => $order_qty,
                            'Updated_By_Id' => $userPkId
                        ]);
                        return "updated";
                     }
        
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
                    $owner = Owner::insertGetId([
                        'APARTMENT_NO' => $apartment,
                        'CELLPHONE' => $cellphone,
                        'ZIP' => $zipcode,
                        'DISTRICT_ID' => $district,
                        'PROVINCE_ID' => $province,
                        'DOOR_NO' => $door,
                        'FAMILY_NAME' => $familyname,
                        'FIRST_NAME' => $surname,
                        'GENDER' => $gender,
                        'HOMEPHONE' => $homephone,
                        'LAST_NAME' => $parent,
                        'MORE_INFO' => $specialnote,
                        'ADDRESS_DETAIL' => $address_details,
                        'REGISTER_NO' => $register,
                        'STREET' => $street,
                        'WorkPhone' => $workphone,
                        'COUNTRY_ID' => $country,
                        'TYPE_ID' => $type,
                        'DEVISION_UNIT_ID' => $commission,
                        'MICRO_DISTRICT_ID' => $town,
                        'ORDER_QTY' => $order_qty,
                        'Created_By_Id' => $userPkId,
                        'Updated_By_Id' => $userPkId
                    ]);
                    return $owner;
                } else {
                    return "duplicated";
                }
            }

        } catch(\Exception $ex){
            $this->writeLog("Create owner from modal error: ".$ex->getMessage());
        }
    }

    public function owner(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $register = $request->get("register");
        $type = $request->get("type");
        try{
            if($type == "company"){
                $owner_count = 0;
                $owner = null;
            } else {
                $owner = Owner::where("REGISTER_NO", $register)->get();
                $owner_count = $owner->count();
            }
            if($owner_count > 0){
                return $owner->first();
            } else {
                $owners = Owner::where("REGISTER_NO", "LIKE", $register."%")->where("TYPE_ID", "!=", 1)->get();
                if($owners->count() > 0){
                    return "true";
                } else {
                    return "false";
                }
            }
        } catch (\Exception $ex){
            return "false";
        }
    }

    public function owner_deps(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $register = $request->get("register");
        try{
            $owners = Owner::where("REGISTER_NO", "LIKE", $register."%")->get();
            $html = '<option value="0">지점 선택</option>';
            if($owners->count() > 0){
                $owner_count = 0;
                foreach ($owners as $owner){
                    if($owner->type_id != 1){
                        $owner_count++;
                        $html .= '<option id="ownerdep'.$owner->id.'" reg="'.$owner->register_no.'" value="'.$owner->id.'">'.$owner->first_name.' ХАЯГ: '.$owner->address_detail.'</option>';
                    }
                }
                if($owner_count != 0){
                    return $html;
                } else {
                    return "false";
                }
            } else {
                return "false";
            }
        } catch (\Exception $ex){
            return "false";
        }
    }

    public function departmentUsers(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $department = $request->get("department");
        $select = $request->get("selected");

        $html = '<option label="선택"></option>';
        $users = MainUser::whereNull("deleted_at")->where("USERDEPARTMENTID", $department)->where("IsActive", 1)->orderBy("firstname")->get();
        foreach ($users as $user){
            $selectText = "";
            if($user->id == $select){
                $selectText = "selected";
            }
            //$html .= '<option value="'.$user->id.'" '.$selectText.'>'.ucfirst($user ->lastname)." ".strtoupper($user ->firstname).'</option>';
            $html .= '<option value="'.$user->id.'" '.$selectText.'>'.strtoupper($user ->firstname)." ".$user ->lastname.'</option>';
        }

        return $html;
    }

    public function departmentSeries(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $department = $request->get("department");
        $select = $request->get("selected");

        $html = '<option label="선택"></option>';
        $departments = MainUserDepartment::where("ID", $department)->get();

        if($departments->count() > 0){
            $departments = $departments->first();

            if($departments->province_id == 22 &&  $department != 543 ){
                $serieses = Series::where("NAME", "LIKE", "ДК%")->orderBy("NAME")->get();
            } else {
                $serieses = Series::where("PROVINCE_ID", $departments->province_id)->orderBy("NAME")->get();
            }

            foreach ($serieses as $seriese){
                $selectText = "";
                if($seriese->id == $select){
                    $selectText = "selected";
                }
                $html .= '<option value="'.$seriese->id.'" '.$selectText.'>'.$seriese->name.'</option>';
            }
        }

        return $html;
    }

    public function district(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $location = $request->get("location");
        $type = $request->get("type");
        $select = $request->get("selected");

        $html = '<option label="선택"></option>';
        if($type == "district"){
            $districts = DB::table("ADDRESS_SUBDEV")->where("PROVINCE_ID", $location)->orderBy("NAME", "ASC")->get();
            foreach ($districts as $district){
                $selectText = "";
                if($district->id == $select){
                    $selectText = "selected";
                }
                $html .= '<option value="'.$district->id.'" '.$selectText.'>'.$district->name.'</option>';
            }
        } elseif ($type == "commission"){
            $commissions = DB::table("ADDRESS_SUBDEV_UNIT")->where("DEVISION_ID", $location)->orderBy("NAME", "ASC")->get();
            foreach ($commissions as $commission){
                $selectText = "";
                if($commission->id == $select){
                    $selectText = "selected";
                }
                $html .= '<option value="'.$commission->id.'" '.$selectText.'>'.$commission->name.'</option>';
            }
        } elseif ($type == "town") {
            $towns = DB::table("ADDRESS_MICRODISTRICT")->where("DEVISION_UNIT_ID", $location)->orderBy("NAME", "ASC")->get();
            foreach ($towns as $town) {
                $selectText = "";
                if ($town->id == $select) {
                    $selectText = "selected";
                }
                $html .= '<option value="' . $town->id . '" ' . $selectText . '>' . $town->name . '</option>';
            }
        }
        return $html;
    }

    public function model(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $type = $request->get("type");
        $select = $request->get("selected");

        $html = '<option label="선택"></option>';
        $models = DB::table("REG_MODEL")->where("MARK_ID", $type)->orderBy("NAME", "ASC")->get();
        foreach ($models as $model){
            $selectText = "";
            if($model->id == $select){
                $selectText = "selected";
            }
            $html .= '<option value="'.$model->id.'" '.$selectText.'>'.$model->name.'</option>';
        }
        return $html;
    }

    public function mark(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $country = $request->get("country");
        $select = $request->get("selected");

        $html = '<option label="선택"></option>';
        $marks = DB::table("REG_MARK")->where("COUNTRY_ID", $country)->orderBy("NAME", "ASC")->get();
        foreach ($marks as $mark){
            $selectText = "";
            if($mark->id == $select){
                $selectText = "selected";
            }
            $html .= '<option value="'.$mark->id.'" '.$selectText.'>'.$mark->name.'</option>';
        }
        return $html;
    }

    public function numberList(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $interval = $this->dec(trim($request->get("interval")));
        $data = SeriesInterval::where("Id", $interval)->where("IS_LOCAL", 1)->get()->first();
        $local_user_id = $data->local_user_id;
        $series_id = $data->series_id;
        $from_number = $data->from_number;
        $to_number = $data->to_number;

        $numbers = SeriesNumber::where("LOCAL_USER_ID", $local_user_id)
            ->where("SERIES_ID", $series_id)
            ->where("NO", ">=", $from_number)
            ->where("NO", "<=", $to_number)
            ->orderBy("NAME", "ASC")
            ->get();
        $html = "";
        $i = 1;
        foreach ($numbers as $number){
            $html .= "<tr>";
            $html .= "<td>".$i."</td>";
            $html .= "<td>".$number->name."</td>";
            $html .= "<td>".$number->create_date."</td>";
            $html .= "</tr>";
            $i++;
        }
        return $html;
    }

    public function printerList(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $printerID=$request->get("printerID");
        $printer=SystemPrinter::find($printerID);
        return $printer;
    }

    public function printerSave(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $id=$request->get("id");
        $x=$request->get("x");
        $y=$request->get("y");
        $line=$request->get("line");
        $text=$request->get("text");

        try {
            SystemPrinter::where("id", $id)->update([
                'X' => $x,
                'Y' => $y,
                'LINE' => $line,
                'TEXT' => $text,
            ]);
            return 1;
        }catch (Exception $ex)
        {
            return $ex;
        }
    }

    public function getSeriesList(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $id=$request->get("id");

        $series = DB::table("SERIES")
            ->where("PROVINCE_ID","=",$id)
            ->orderby("NAME","ASC")
            ->get();

        $series = DB::table("SERIES")
            ->Join('SERIES_INTERVAL', function($join) {
                $join->on('SERIES_INTERVAL.SERIES_ID', '=' , 'SERIES.ID');
            })
            ->where("SERIES_INTERVAL.IS_ORDER","=",1)
            ->where("SERIES_INTERVAL.IS_HIDDEN","=",0)
            ->where("SERIES_INTERVAL.IS_OPENED","=",1   )
            ->where("SERIES.PROVINCE_ID","=",$id)
            ->orderby("SERIES.NAME","ASC")
            ->distinct()
            ->select(["SERIES.ID", "SERIES.NAME"])
            ->get();


        $htmlDiv='';

        $html = '<option label="선택"></option>';

        if($series->count() > 0){
            foreach ($series as $seriese){
                $html .= '<option value="'.$seriese->id.'" >'.$seriese ->name.'</option>';
                $htmlDiv.='<div class="col-lg-6 col-md-6 col-sm-12 series-list-top"><button class="btn btn-outline-primary btn-block"  onclick="getNumbers('.$seriese->id.');">'.$seriese ->name.'</button></div>';
            }
        }

        return $htmlDiv;
    }

    public function getVehicleInfo(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $plate_no = $request->get("plate");
        $vehicle = DB::table("REG_VEHICLE_VIEW")->where("PLATE_NO", $plate_no)->get();
        if($vehicle->count() > 0){
            $limit_count = RegLimited::where("VEHICLE_ID", $vehicle->first()->id)->where("Is_Restored", 0)->get()->count();
            if($limit_count > 0){
                return "limited";
            } else {
                $vehicle = $vehicle->first();
                return json_decode(json_encode($vehicle), true);
            }
        } else {
            return "false";
        }
    }

    public function ownerTwo(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $owner1_id = $request->get("owner1");
        $owner1_id = self::dec($owner1_id);
        if($owner1_id != ""){
            $html = "";
            $owners = DB::table("REG_OWNER_VIEW")
                ->where("ID", $owner1_id)
                ->get();
            foreach ($owners as $owner){
                $html .= '<tr>' .
                    '<td>' . $owner->country . '</td>' .
                    '<td>' . $owner->register_no . '</td>' .
                    '<td>' . $owner->name . '</td>' .
                    '<td>' . $owner->last_name . '</td>' .
                    '<td>' . $owner->first_name . '</td>' .
                    '<td>' . $owner->address . '</td>' .
                    '<td>' . $owner->homephone . '</td>' .
                    '<td>' . $owner->phone_no . '</td>' .
                    '<td>' . $owner->workphone . '</td>' .
                    '</tr>';
            }
            return $html;
        } else {
            return "false";
        }
    }

    public function vehicleLimit(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $vid = $request->get("vid");
        $vid = self::dec($vid);
        if($vid != ""){
            $limitedHistories = DB::table("REG_LIMITED_VIEW")
                ->where("VEHICLE_ID", $vid)
                ->orderBy("CREATEDDATE", "DESC")
                ->get();

            $html = "";
            foreach ($limitedHistories as $limit){
                $action = "";
                if($limit->is_restored == 0){
                    $action = "'".trim($limit->id)."'";
                    $action = '<a style="cursor:pointer;" onclick="restoreLimit('.$action.');">복구</a>';
                }
                $html .= '<tr>' .
                    '<td>' . $limit->typename . '</td>' .
                    '<td>' . $limit->dec_no . '</td>' .
                    '<td>' . $limit->phone_no . '</td>' .
                    '<td>' . $limit->createddate . '</td>' .
                    '<td>' . $limit->createduser . '</td>' .
                    '<td>' . $limit->restoretypename . '</td>' .
                    '<td>' . $limit->restore_dec_no . '</td>' .
                    '<td>' . $limit->end_date . '</td>' .
                    '<td>' . $limit->restoreuser . '</td>' .
                    '<td>' . $action . ' </td>' .
                    '</tr>';
            }
            return $html;
        } else {
            return "false";
        }
    }

    public function vehicleAnothers(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $vid = $request->get("vid");
        $vid = self::dec($vid);
        $html = "";
        if($vid != ""){
            $vehicle = Vehicle::where("ID", $vid)->get()->first();
            if($vehicle->owner_id != null){
                if($vehicle->owner_id != 0 && $vehicle->owner_id != null && $vehicle->owner_id != ""){
                    $anothers = DB::table("OWNER_ANOTHER_VEHICLE_VIEW")
                        ->where("OWNER_ID", $vehicle->owner_id)
                        ->where("ID", "!=", $vehicle->id)
                        ->get();
                }

                foreach ($anothers as $another){
                    $html .= '<tr>' .
                        '<td>' . Carbon::parse($another->start_date)->format("Y-m-d") . '</td>' .
                        '<td>' . $another->plate_no . '</td>' .
                        '<td>' . $another->cabin_no . '</td>' .
                        '<td>' . $another->engine_no . '</td>' .
                        '<td>' . $another->mark_name . '</td>' .
                        '<td>' . $another->model_name . '</td>' .
                        '<td>' . $another->build_year . '</td>' .
                        '<td>' . $another->color_name . '</td>' .
                        '</tr>';
                }
            }
            return $html;
        } else {
            return "false";
        }
    }

    public function vehicleActionHistory(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $vid = $request->get("vid");
        $vid = self::dec($vid);
        if($vid != ""){
            $histories = DB::table("ARCHIVE_VIEW")
                ->where("VEHICLE_ID", $vid)
                ->orderBy("ARCHIVE_DATE", "DESC")
                ->orderBy("ID", "DESC")
                ->get();

            $html = "";
            foreach ($histories as $history){
                $date = $history->import_date == null ? "" : Carbon::parse($history->import_date)->format("Y-m-d");
                $history_text = "";
                if($history->insert_finger == 0){
                    $history_text = ""; 
                } else if($history->insert_finger == 1){
                    $history_text = "Хурууны хээ уншуулсан:";
                } else if($history->insert_finger == 2){ 
                    $history_text = "Хурууны хээ уншуулаагүй:";
                } else if($history->insert_finger == 3){
                    $history_text = "Нотриатын баримтаар:";
                } else if($history->insert_finger == 4){
                    $history_text = "공문 번호:";
                }
                
                $html .= '<tr>' .
                    // '<td><a href="'.url('/archive/document/'.$history->archive_no).'" target="_blank">' . $history->archive_no . '</a></td>' .
                   // "<td><a href='".url('/archive/document/'.$history->archive_no)."' target='_blank' onclick=\"window.open('".url('/archive/documentAr/'.$history->archive_no)."', 'target=_blank' ); window.open('".url('/archive/documentArNtr/'.$history->archive_no)."', 'target=_blank' );\">" . $history->archive_no . "</a></td>" .
                   '<td><a href="'.url('/archive/document/'.$history->archive_no).'" target="_blank" onclick="window.open(&quot;'.url('/archive/documentAr/'.$history->archive_no).'/&quot); window.open(&quot;'.url('/archive/documentArNtr/'.$history->archive_no).'/&quot;);">'.$history->archive_no.'</a></td>'.
                  //  '<td>' . '<a href='".url('/archive/document/'.$history->archive_no)" target="_blank" onclick="window.open(&quot;&quot;YOUR_2nd_URL&quot;&quot;); window.open(&quot;&quot;YOUR_3rd_URL&quot;&quot;);">'Link text'</a>' . '</td>' .
                    '<td>' . Carbon::parse($history->updated_date)->format("Y-m-d") . '</td>' .
                    '<td>' . $history->plate_no . '</td>' .
                    '<td>' . $history->cabin_no . '</td>' .
                    '<td>' . $history->engine_no . '</td>' .
                    '<td>' . $history->build_year . '</td>' .
                    '<td>' . $date . '</td>' .
                    '<td>' . $history->certificate_no . '</td>' .
                    '<td>' . $history->last_name . ' ' . $history->first_name . '</td>' .
                    '<td>' . $history->firstname . '</td>' .
                    '<td>' . $history->insert_description . ' ' . $history_text . ' ' . $history->insert_finger_description .'</td>' .
                    '<td>' . $history->service_name . '</td>' .
                    '</tr>';
                 
            }
            return $html;
        } else {
            return "false";
        }
    }

    public function vehicleOwners(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $vid = $request->get("vid");
        $vid = self::dec($vid);
        if($vid != ""){
            $owners = DB::table("REG_VEHICLE_OWNERSHIP_VIEW")
                ->where("VEHICLE_ID", $vid)
                ->orderBy("START_DATE", "DESC")
                ->get();

            $html = "";
            $html1 = "";
            foreach ($owners as $owner){
                $result = "";
                if($owner->end_date != null){
                    $result = \Carbon\Carbon::parse($owner->end_date)->format("Y-m-d");
                }
                if($owner->end_date != null){
                    $html .= '<tr>' .
                        '<td>' . Carbon::parse($owner->start_date)->format("Y-m-d") . '</td>' .
                        '<td>' . $result . '</td>' .
                        '<td>' . $owner->register_no . '</td>' .
                        '<td>' . $owner->last_name .' '. $owner->first_name . '</td>' .
                        '<td>' . $owner->address_detail . '</td>' .
                        '<td>' . $owner->phone_no . '</td>' .
                        '</tr>';
                }
            }
            return array($html);
        } else {
            return "false";
        }
    }
    public function vehicleOwners1(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $vid = $request->get("vid");
        $vid = self::dec($vid);
        if($vid != ""){
            $owners = DB::table("REG_VEHICLE_OWNERSHIP1_VIEW")
                ->where("VEHICLE_ID", $vid)
                ->orderBy("START_DATE", "DESC")
                ->get();

            $html = "";
            $html1 = "";
            foreach ($owners as $owner){
                $result = "";
                if($owner->end_date != null){
                    $result = \Carbon\Carbon::parse($owner->end_date)->format("Y-m-d");
                }
                if($owner->end_date != null){
                    $html .= '<tr>' .
                        '<td>' . Carbon::parse($owner->start_date)->format("Y-m-d") . '</td>' .
                        '<td>' . $result . '</td>' .
                        '<td>' . $owner->register_no . '</td>' .
                        '<td>' . $owner->last_name .' '. $owner->first_name . '</td>' .
                        '<td>' . $owner->address_detail . '</td>' .
                        '<td>' . $owner->phone_no . '</td>' .
                        '</tr>';
                }
            }
            return array($html);
        } else {
            return "false";
        }
    }

    public function createPrintCertificate(Request $request)
    {
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        $userId = $request->get("id");
        $certificateNo = $request->get("no");
        $vehicleId = $request->get("vehicle");
        $plate = $request->get("plate");

        $vehicle = Vehicle::where("ID", $vehicleId)->get()->first();
        DB::beginTransaction();
        try {
            if($vehicleId != "" && $userId != ""){
                RegCertificate::create([
                    'USER_ID' => (int)$userId,
                    'CERTIFICATE_NO' => $certificateNo,
                    'CREATED_DATE' => date("Y-m-d H:i:s"),
                    'VEHICLE_ID' => $vehicleId,
                    'SERVICE_ID' => $vehicle->status,
                    'FEE' => DB::table("SYSTEM_SERVICE")->where("ID", $vehicle->status)->get()->first()->fee,
                    'VEHICLE_PLATE' => $plate
                ]);

                $request = Vehicle::where("Id", $vehicleId)->get()->first();
                $service = MainService::where("Id", $request->status)->get()->first();
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
                    'ARCHIVE_DEPARTMENT' => session()->get("archive")->departmentid,
                    'ARCHIVE_ABBR' => session()->get("archive")->abbr,
                    'BUILD_YEAR' => $request->build_year,
                    'BUILD_MONTH' => $request->build_month,
                    'PAR_TYPE_ID' => $request->par_type_id,
                    'OWNER_ID' => $request->owner_id,
                    'OWNER1_ID' => $request->owner1_id,
                    'ARCHIVE_NO' => $request->archive_no,
                    'FIRST_ARCHIVE_NO' => $request->first_archive_no,
                    'PAGE_COUNT' => $request->page_count,
                    'DESCRIPTION' => $request->description,
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
                    'INSERT_CERTIFICATE_NO' => $request->certificate_no,
                    'INSERT_ARCHIVE_NO' => $request->archive_no,
                    'INSERT_PLATE_NO' => $request->plate_no,
                    'INSERT_OWNER_ID' => $request->owner_id,
                    'INSERT_SERVICE_ID' => 6,
                    'INSERT_PAGE_COUNT' => $request->page_count,
                    'INSERT_FINGER' => 0,
                    'INSERT_FINGER_DESCRIPTION' => "",
                    'INSERT_DESCRIPTION' => "",
                    'UPDATED_DATE' => $request->updated_date,
                    'CREATED_BY' => $request->updated_by,
                    'UPDATED_BY' => $userId
                ]);

                Vehicle::where("Id", $vehicleId)->update([
                    'STATUS' => 6,
                    'UPDATED_DATE' => Carbon::now(),
                    'UPDATED_BY' => $userId
                ]);
                DB::commit();
                return "success";
            }
        }catch (\Exception $ex){
            DB::rollBack();
            $this->writeLog("Гэрчилгээ хэвлэлт 등록 алдаатай 입니다: ".$ex);
            return "error";
        }
    }
              
    public function referenceLog(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        try{
            $owner = Owner::where("REGISTER_NO", "LIKE", $request->get("Register")."%")->get();
            if($owner->count() > 0){
                RegReferenceLog::create([
                    'Ref_Type' => $request->get("RefType"), //보고서 유형: 1 경우 одоогийн өмчилж буй, 2 경우 өмнөх өмчилж байсан
                    'Type_Id' => $request->get("TypeId"), //1 경우 албан тоотоор буюу хурууны хээ ашиглаагүй, 2 хурууны хээгээр
                    'User_Type_Id' => $owner->first()->type_id, //조회гаар илэрсэн 차량 -ийн 소유자ийн 비율/개인 хүн 경우он албан 기관/단체 유형 Ө.Х 소유자ийн 유형
                    'User_Id' => $owner->first()->id, //비율 хүн 경우он албан 기관/단체 소유자ийн ID
                    'DocNumber' => $request->get("DocNumber"), //공문 번호
                    'Vehicle_Count' => $request->get("VehicleCount"), //Нэг 확인서/조회гаар авсан 차량 -ийн тоо
                    'Request_Type' => $request->get("RequestType"), //Хүсэлт гаргасан 기관/단체 ID
                    'Request_Name' => $request->get("RequestText"), //Хүсэлт гаргасан 기관/단체 нэр
                    'Description' => $request->get("Description"), //Хурууны хээ 경우он 번호 тайлбар
                    'CreatedBy' => $request->get("CreatedBy"), //조회 гаргасан
                    'CreatedDate' => $request->get("CreatedDate")
                ]);
                return "1";
            } else {
                return "0";
            }
        } catch (\Exception $ex){
            $this->writeLog("Reference log create error: ".$ex);
            return "0";
        }
    }
}
