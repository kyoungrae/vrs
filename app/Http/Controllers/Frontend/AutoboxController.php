<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvince;
use App\AddressSubDev;
use App\AddressSubDevUnit;
use App\AddressMicroDistrict;
use App\Http\Controllers\BaseController;
use App\MainService;
use App\Owner;
use App\EpayTransaction;
use App\OwnerShip;
use App\OwnerType;
use App\RegLimited;
use App\Series;
use App\RegCertificate;
use App\SeriesNumber;
use App\SystemPlateFactory;
use App\Vehicle;
use App\VehicleArchive;
use App\SystemPrinter; 
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Matrix\Exception;
use LaravelQRCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use App\Transaction;
use nusoap_client;
use Illuminate\Support\Str;
class AutoboxController extends BaseController 
{
    public function tokenCheck($token)
    {
        if ($token && $token == "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwicm9sZSI6ImFkbWluIiwiZmlyc3RuYW1lIjoi06jQodOo0KXQkdCQ0K_QoCIsImxhc3RuYW1lIjoi0JTQsNC70YXQsNCw0YHSr9GA0Y3QvSIsInJlZ251bSI6ItGF0Lg4NzA4MjYxOCIsImNvbXBhbnlfaWQiOjAsImJyYW5jaF9pZCI6MCwiaWF0IjoxNjk0NTkzNTc4LCJleHAiOjE3MjYxNTExNzh9._FeP5WVmZCX2RlJ5qPQmZRXWnh8EjHLGPHS26WSUsvk") {
            return true;
        }
        return false;
    }
    public function certifcate()
    {
        return "CERT".Str::substr(Carbon::now()->format("YmdHis"),2);
    }
    public function createOwnerAutobox(Request $request){
      
        $token = $request->get("token");
        $tokenCheck = $this->tokenCheck($token);

        if ($tokenCheck) {

        try{
            $country = $request->get("country_id");
            $type = $request->get("type_id");
            $register = $request->get("register");
            $familyname = $request->get("familyname");
            $parent = $request->get("parent");
            $surname = $request->get("surname");
            $gender = $request->get("gender");
            $province = $request->get("province_id");
            $district = $request->get("district_id");
            $commission = $request->get("commission_id");
            $town = $request->get("town_id");
            $street = $request->get("street");
            $apartment = $request->get("apartment");
            $door = $request->get("door");
            $homephone = $request->get("homephone");
            $cellphone = $request->get("cellphone");
            $workphone = $request->get("workphone");
            $zipcode = $request->get("zipcode");
            $specialnote = $request->get("specialnote");
            $order_qty = 3;
            $userPkId = 7052;
            $is_owner = $request->get("owner");

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
              $ownerUpdated=  Owner::findOrFail( $is_owner)->update([
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
                    'REGISTER_NO' => $register,
                    'STREET' => $street,
                    'WorkPhone' => $workphone,
                    'COUNTRY_ID' => $country,
                    'TYPE_ID' => $type, 
                    'DEVISION_UNIT_ID' => $commission,
                    'MICRO_DISTRICT_ID' => $town,
                    'ORDER_QTY' => $order_qty,
                    'Updated_By_Id' => $userPkId
                ]);
                return response()->json([
                    'statusCode' =>200,
                    'message' => "Ам년ттай",
                    'newOwnerId' => $is_owner,
                  
                ]);
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
                 //   return $owner;

                    return response()->json([
                        'statusCode' =>200,
                        'message' => "Ам년ттай.",
                        'newOwnerId' => $owner,
                      
                    ]);
                } else {
                    return response()->json([
                        'statusCode' =>400,
                        'message' => "Уг өмчлөг бүртгэлтэй байна.",
                      
                    ]);
                }
            }

        } catch(\Exception $ex){
            $this->writeLog("Create owner from modal error: ".$ex->getMessage());
        }
        
        
    } else {
        $Result["success"] = false;
        $Result["message"] = "Token буруу байна !!!";
        return response()->json($Result, 200);

    }
    }
    public function getConflictData(Request $request)
    {
    
        $token = $request->get("token");
        $tokenCheck = $this->tokenCheck($token);
        $serviceCode = trim($request->get("service_code"));
        $requestCode = trim($request->get("request_code"));
        if ($tokenCheck) {

            try {
//return $request;
                if ($serviceCode == "VRS2") {
                 return   $this->moveOwnerVehicle($request);
                } elseif ($serviceCode == "VRS3") {
                    return $this->moveOwnerVehiclePlate($request);
                    # code...
                } elseif ($serviceCode == "VRS1") {
                    return $this->newVehicle($request);
                    # code...
                
                } elseif ($serviceCode == "VRS9") {
                    return $this->removeVehicle($request);
                    # code...
                } elseif ($serviceCode == "VRS4") {
                    return $this->changePlateAutoBox($request);
                  
                }
                else{
                    $Result["success"] = false;
                    $Result["message"] = "Хандалт буруу байна !!!";
                    return response()->json($Result, 200);
                }
     //return $this->certifcate();
          //  return $request;

            } catch (\Exception $ex) {
                $Result["success"] = false;
                $Result["message"] = "오류 гарлаа !!!";
            }

       //     return response()->json($Result, 200);

        } else {
            $Result["success"] = false;
            $Result["message"] = "Token буруу байна !!!";
            return response()->json($Result, 200);

        }

    }
    public function newVehicle($requestData){
        // if(!session()->has("auth")){
        //     return redirect(route($this->redirectURL));
        // }
      //  $cabin_no = trim($request->get("cabin_no"));
//return $requestData;
        try{
            $userPkId = 7052;
            $certificate = $this->certifcate();
            $page_count = 1;
            $description = null;
            $fingerDescription = "전자 요청으로";
            $finger =5;
            $owner = $requestData->new_owner;
            $vvcabinid = $requestData->cabin_no;
            $cabin_no = $vvcabinid;

            $payDescription=1;
            $payDescriptionName="QPay&SocialPay";
            $transactionId=0;
            $payAmount=14700;
            $serviceTypeName="VRS1";
        
             $requestCode =$requestData->approveCode;
             $signed_data = $requestData->signed_data;
   
            $plate_no = $requestData->plate_no;
            $plateColor = 1;
            $checkTorguuli ="";
            $finger = 5;
            $finger1 = $fingerDescription;
        
            $serviceTypeId=1;
        
            if(!$this->isDuplicate($plate_no)){
                if($this->giveNumber($plate_no, $userPkId)){
                    $vehicle = Vehicle::where("cabin_no", $vvcabinid)->get();
                    if($vehicle->count() > 0){
                        if($this->isDuplicateCert($certificate) == 0) {
                            $vehicle = $vehicle->first();
                            $result = $this->checkAddressPlate($plate_no, $owner);
                            if (!is_array($result) && $result == true) {
                                if ($this->isOrderUser($plate_no, $vehicle->id, $owner)) {
                                    $service = $this->getActionPrefix(1);
                                    $archive_no = $this->archiveNumberGenerate($service);
                                   

                                    DB::beginTransaction();
                                    try{
                                        if($archive_no != "ERROR"){
                                            $this->createOwnerShip($owner, 0, $vehicle->id, 1);
                                            Vehicle::where("Id", $vehicle->id)->update([ 
                                                'PLATE_NO' => $plate_no,
                                                'CERTIFICATE_NO' => $certificate,
                                                'PAGE_COUNT' => $page_count,
                                                'OWNER_ID' => $owner,
                                                'PROVINCE_ID' => $this->getUserProvincePkId($owner),
                                                'ARCHIVE_NO' => $archive_no,
                                                'FIRST_ARCHIVE_NO' => $archive_no,
                                                'IS_PENDING' => 0,
                                                'STATUS' => 1,
                                                'UPDATED_BY' => $userPkId
                                            ]);
                                            SeriesNumber::where("NAME", $plate_no)->update([
                                                'IS_ORDER' => 0,
                                               // 'ORDER_USER' => null,
                                                'IS_GIVEN' => 1,
                                                'IS_LOCAL' => 0,
                                                'LOCAL_USER_ID' => null,
                                                'VEHICLE_ID' => $vehicle->id,
                                                'UPDATED_BY_ID' => $userPkId
                                            ]);
                                            // $this->epayTransaction($vehicle->id,$archive_no,$payDescription,
                                            // $payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                                           // return $test;
                                            $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);

                                            $finger=$fingerDescription;
                                            $vid = $vehicle->id;
                                            $this->eRequestApprove($requestCode);
                                             session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'signed_data'=>$signed_data]);
                                                # code...

                                                $vehicle1 = Vehicle::where("CABIN_NO", $vvcabinid)->first();
                                                $owners = DB::table("REG_VEHICLE_OWNERSHIP_VIEW")
                                                ->where("VEHICLE_ID",$vid)
                                                ->orderBy("START_DATE", "DESC")
                                                ->orderBy("SHIP_ID", "DESC")
                                                ->get();
                                            
                                               if (session()->has('vehicleElectron')) {
                                                // session()->forget('vehicleElectron');
                                                 if (session()->get('vehicleElectron')['eForm'] == 1) {
                                                    $finger1 = session()->get('vehicleElectron');
                                                $this->electronForm($vehicle1, $owners,$finger1);
                                                
                                                 }
                                                }
                                            
                                            DB::commit();
                                            return response()->json([
                                                'statusCode' =>400,
                                                'message' =>   " ТХ ам년ттай бүртгэгдлээ"
                                               
                                              
                                            ]);
                                            // $message = $this->message("success", $cabin_no . " арлын дугаартай ТХ ам년ттай бүртгэгдлээ.");
                                            // return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                        } else {
                                            return response()->json([
                                                'statusCode' =>400,
                                                'message' => $plate_no . "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү."
                                               
                                              
                                            ]);
                                            // $message = $this->message("info", $plate_no . "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү.");
                                            // return redirect(url('/vehicle/' . $this->enc($cabin_no) . '/new'))->with("message", $message);
                                        }
                                    } catch (\Exception $ex){
                                        DB::rollBack();
                                        $this->writeLog("New vehicle transaction error: ".$ex);
                                        return response()->json([
                                            'statusCode' =>400,
                                            'message' => "신규 차량 등록 중 오류가 발생했습니다."
                                           
                                          
                                        ]);
                                        // $message = $this->message("danger", "신규 차량 등록 중 오류가 발생했습니다.");
                                        // return redirect(url('/vehicle/'.$this->enc($cabin_no).'/new'))->with("message", $message);
                                    }
                                } else {
                                    return response()->json([
                                        'statusCode' =>400,
                                        'message' =>$plate_no . " 번호판 주문이 이루어지지 않았습니다."
                                       
                                      
                                    ]);
                                    // $message = $this->message("info", $plate_no . " 번호판 주문이 이루어지지 않았습니다.");
                                    // return redirect(url('/vehicle/' . $this->enc($cabin_no) . '/new'))->with("message", $message);
                                }
                            } else {
                                if (!is_array($result) && $result == false) {
                                    return response()->json([
                                        'statusCode' =>400,
                                        'message' => " 소유자 주소가 번호판 주소와 일치하지 않습니다.."
                                       
                                      
                                    ]);
                                  //  $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                } else {
                                    $message = $result[1];
                                }
                                return redirect(url('/vehicle/' . $this->enc($cabin_no) . '/new'))->with("message", $message);
                            }
                        } else {
                            return response()->json([
                                'statusCode' =>400,
                                'message' => "증명서 번호가 중복됩니다."
                               
                              
                            ]);
                            // $message = $this->message("info", "증명서 번호가 중복됩니다.");
                            // return redirect(url('/vehicle/'.$this->enc($cabin_no)."/new"))->with("message", $message);
                        }
                    } else {
                        return response()->json([
                            'statusCode' =>400,
                            'message' => $cabin_no." аралын дугаартай ТХ бүртгэлгүй байна."
                           
                          
                        ]);
                        // $message = $this->message("info", $cabin_no." аралын дугаартай ТХ бүртгэлгүй байна.");
                        // return redirect(url('/vehicle'))->with("message", $message);
                    }
                } else {
                    return response()->json([
                        'statusCode' =>400,
                        'message' => $plate_no." 번호판이 다른 차량에서 사용 중입니다."
                       
                      
                    ]);
                    // $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                    // return redirect(url('/vehicle/'.$this->enc($cabin_no)."/new"))->with("message", $message);
                }
            } else {
                return response()->json([
                    'statusCode' =>400,
                    'message' => $plate_no." 번호판이 다른 차량에서 사용 중입니다."
                   
                  
                ]);
                // $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                // return redirect(url('/vehicle/'.$this->enc($cabin_no)."/new"))->with("message", $message);
            }
        } catch (\Exception $ex){
            $this->writeLog("New vehicle error: ".$ex);
            return response()->json([
                'statusCode' =>400,
                'message' =>  "신규 차량 등록 중 오류가 발생했습니다."
               
              
            ]);
            // $message = $this->message("danger", "신규 차량 등록 중 오류가 발생했습니다.");
            // return redirect(url('/vehicle/'.$this->enc($cabin_no).'/new'))->with("message", $message);
        }
    }
    public function moveOwnerVehicle($requestData){
        // if(!session()->has("auth")){
        //     return redirect(route($this->redirectURL));
        // }
       // return $requestData;
        $plate_no = $requestData->plate_no;
        try{

             $checkTorguuli ="";
            // return $checkTorguuli;
           // return $requestData;
            $userPkId = 7052;
            $certificate = $this->certifcate();
            $page_count = 1;
            $description = null;
            $fingerDescription = "전자 요청으로";
            $finger =5;
            $owner = $requestData->new_owner;
            $vvcabinid = $requestData->cabin_no;
          $borrower=$requestData->borrower;
            $vehicle = Vehicle::where("CABIN_NO", $vvcabinid)->get();
            

            $payDescription=1;
            $payDescriptionName="QPay&SocialPay";
            $transactionId=0;
            $payAmount=12500;
            $serviceTypeName="VRS2";
            $serviceTypeId=3;
      
       
         
             $requestCode =$requestData->approveCode;
             $signed_data = $requestData->signed_data;
           
        
            $vehOwner_id=(int)$vehicle[0]->owner_id;
            $vehOwner1_id=(int)$vehicle[0]->owner1_id;
            if ($vehOwner1_id) {
                # code...
           // return $vehOwner1_id;   
           
                Vehicle::where("ID", $vehicle[0]->id)->update([
                  
                    'OWNER1_ID' => $borrower,
                   
                    'UPDATED_BY' => $userPkId
                ]);
           
        }
           



            if($owner != ""){
                if($vehicle->count() > 0){
                    if($this->isDuplicateCert($certificate) == 0) {
                        $vehicle = $vehicle->first();
                    
                        $result = $this->checkAddressPlate($plate_no, $owner);
                       // return $result;
                       $limit_count = RegLimited::where("VEHICLE_ID", $vehicle->id)->where("IS_RESTORED", null)
                       ->get()->count();

                   //    return     $limit_count;
                       if ($limit_count > 0 ) {
                        return response()->json([
                            'statusCode' =>400,
                            'message' =>" 차량은 ".$limit_count." 종류의 제한이 있어 서비스를 이용할 수 없습니다."
                           
                          
                        ]);
                       }else{

              
                        if (!is_array($result) && $result == true) {
                            $service = $this->getActionPrefix(3);
                        //    return service;
                            $old_owner_id = $vehicle->owner_id;
                          
                            if ($owner != $old_owner_id) {
                                $archive_no = $this->archiveNumberGenerate($service);
                               // return $archive_no;
                                if($archive_no != "ERROR"){
                                    DB::beginTransaction();
                                    try{
                                  
                                        $vehicleId = intval($vehicle->id);
                                        settype($vehicleId, 'integer');
                                        $serviceId = $service->id;
                                     
                                        $this->createArchive($vehicle->id, $service->id, $certificate, $archive_no, $plate_no, $owner, $page_count, $description, $finger, $fingerDescription);
                                        $this->createOwnerShip($owner, $old_owner_id, $vehicle->id, 3);
                                      //  $this->epayTransaction($vehicle->id,$archive_no,$payDescription,$payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                                    
                                        Vehicle::where("ID", $vehicle->id)->update([
                                            'CERTIFICATE_NO' => $certificate,
                                            'PAGE_COUNT' => $page_count,
                                            'OWNER_ID' => $owner,
                                            'PROVINCE_ID' => $this->getUserProvincePkId($owner),
                                            'OLD_PROVINCE_ID' => $this->getUserProvincePkId($old_owner_id),
                                            'IS_PENDING' => 0,
                                            'ARCHIVE_NO' => $archive_no,
                                            'STATUS' => 3,
                                            'UPDATED_BY' => $userPkId
                                        ]);
                                   
                                        $vid = $vehicle->id;
                                               $this->eRequestApprove($requestCode);
                                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'signed_data'=>$signed_data]);
                                                   # code...

                                                   $vehicle1 = Vehicle::where("CABIN_NO", $vvcabinid)->first();
                                                   $owners = DB::table("REG_VEHICLE_OWNERSHIP_VIEW")
                                                   ->where("VEHICLE_ID",$vid)
                                                   ->orderBy("START_DATE", "DESC")
                                                   ->orderBy("SHIP_ID", "DESC")
                                                   ->get();
                                                 //  $owners= response()->json($owners);

                                              //   $owners = DB::select(DB::raw("SELECT * from REG_VEHICLE_OWNERSHIP_VIEW where vehicle_id=1921940 order by start_date desc"));
                                   //return json_encode($owners);
                                                   if (session()->has('vehicleElectron')) {
                                                    // session()->forget('vehicleElectron');
                                                     if (session()->get('vehicleElectron')['eForm'] == 1) {
                                                        $finger1 = session()->get('vehicleElectron');
                                                    $this->electronForm($vehicle1, $owners,$finger1);
                                                    
                                                     }
                                                    }
                                        
                                        DB::commit();
                                        return response()->json([
                                            'statusCode' =>200,
                                            'message' => "Өмчлөгч хооронд шил년т ам년ттай хийгдлээ."
                                           
                                          
                                        ]);
                                      //  $message = $this->message("success", "Өмчлөгч хооронд шил년т ам년ттай хийгдлээ.");
                                    } catch (\Exception $ex){
                                        DB::rollBack();
                                        $this->writeLog("Move owner transaction error: ".$ex->getMessage());
                                        return response()->json([
                                            'statusCode' =>400,
                                            'message' => "소유자 간 이전 처리 중 오류가 발생했습니다."
                                           
                                          
                                        ]);
                                       // $message = $this->message("danger", "소유자 간 이전 처리 중 오류가 발생했습니다.");
                                      //  return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                    }
                                } else {
                                    return response()->json([
                                        'statusCode' =>400,
                                        'message' => "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү."
                                       
                                      
                                    ]);
                                    //$message = $this->message("info", "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү.");
                                }
                            } else {
                                return response()->json([
                                    'statusCode' =>400,
                                    'message' => "Шилжүүлэх өмчлөгч одоогийн өмчлөгч байна."
                                   
                                  
                                ]);
                               // $message = $this->message("info", "Шилжүүлэх өмчлөгч одоогийн өмчлөгч байна.");
                            }
                        } else {
                            if (!is_array($result) && $result == false) {
                                return response()->json([
                                    'statusCode' =>400,
                                    'message' => "소유자 주소가 번호판 주소와 일치하지 않습니다."
                                   
                                  
                                ]);
                               // $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                            } else {

                             //   $message = $result[1];
                            }
                        } //////////ююююююю
                    }
                    } else {
                        return response()->json([
                            'statusCode' =>400,
                            'message' => "증명서 번호가 중복됩니다."
                           
                          
                        ]);
                      //  $message = $this->message("info", "증명서 번호가 중복됩니다.");
                    }
                } else {
                    return response()->json([
                        'statusCode' =>400,
                        'message' => "이전 хийх ТХ олдсонгүй."
                       
                      
                    ]);
                   // $message = $this->message("info", "이전 хийх ТХ олдсонгүй.");
                }
            } else {
                return response()->json([
                    'statusCode' =>400,
                    'message' => "Шилжүүлэх өмчлөгч олдсонгүй."
                   
                  
                ]);
               // $message = $this->message("info", "Шилжүүлэх өмчлөгч олдсонгүй.");
            }
          //  return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Move owner error: ".$ex->getMessage());
            return response()->json([
                'statusCode' =>400,
                'message' => "Өмчлөгч хооронд шил년т хийхэд алдаа гарлаа"
               
              
            ]);
          //  $message = $this->message("danger", "소유자 간 이전 처리 중 오류가 발생했습니다.");
          //  return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }
    public function moveOwnerVehiclePlate($requestData){
   // return $requestData;
        try{
            $userPkId = 7052;
            $certificate = $this->certifcate();
            $page_count = 1;
            $description = null;
            $fingerDescription = "전자 요청으로";
            $finger =5;
            $owner = $requestData->new_owner;
            $vvcabinid = $requestData->cabin_no;
          
          //  $vehicle = Vehicle::where("CABIN_NO", $vvcabinid)->get();
            

            $payDescription=1;
            $payDescriptionName="QPay&SocialPay";
            $transactionId=0;
            $payAmount=14700;
            $serviceTypeName="VRS3";
    
            $plate_no = $requestData->plate_no;
            $plate_old_no = $requestData->current_plate;
            $checkTorguuli ="";
            $serviceTypeId=14;
            $requestCode =$requestData->approveCode;
            $signed_data = $requestData->signed_data;

            if($plate_no != $plate_old_no ){
                if(!$this->isDuplicate($plate_no)){
                    if($this->giveNumber($plate_no, $userPkId)){
                        $vehicle = Vehicle::where("cabin_no", $vvcabinid)->get();
                        $vehOwner_id=(int)$vehicle[0]->owner_id;
                        $vehOwner1_id=(int)$vehicle[0]->owner1_id;
                        $limit_count = RegLimited::where("VEHICLE_ID", $vehicle->id)->where("IS_RESTORED", null)
                        ->get()->count();
 
                    //    return     $limit_count;
                        if ($limit_count > 0 ) {
                         return response()->json([
                             'statusCode' =>400,
                             'message' =>" 차량은 ".$limit_count." 종류의 제한이 있어 서비스를 이용할 수 없습니다."
                            
                           
                         ]);
                        }else{
 
                        if ($vehOwner1_id) {
                            # code...
                       // return $vehOwner1_id;   
                       
                            Vehicle::where("ID", $vehicle[0]->id)->update([
                              
                                'OWNER1_ID' => null,
                               
                                'UPDATED_BY' => $userPkId
                            ]);
                       
                    }
                        if($vehicle->count() > 0){
                            if($this->isDuplicateCert($certificate) == 0) {
                                $vehicle = $vehicle->first();
                                $service = $this->getActionPrefix(14);
                                $old_owner_id = $vehicle->owner_id;
                                $province_old = $this->getUserProvincePkId($old_owner_id);
                                $province = $this->getUserProvincePkId($owner);
                                if((mb_substr($plate_old_no, 0, 3) == "БРЗ") || (mb_substr($plate_old_no, 4) == "НАА") || (mb_substr($plate_old_no, 4) == "БРА") || ($province != $province_old) || ($old_owner_id == $owner)){
                                    $result = $this->checkAddressPlate($plate_no, $owner);
                                    if (!is_array($result) && $result == true) {
                                        if ($this->isOrderUser($plate_no, $vehicle->id, $owner)) {
                                            DB::beginTransaction();
                                            try{
                                                $archive_no = $this->archiveNumberGenerate($service);
                                                if($archive_no != "ERROR"){
                                                    $this->createArchive($vehicle->id, $service->id, $certificate, $archive_no, $plate_no, $owner, $page_count, $description, $finger, $fingerDescription);
                                                    $this->createOwnerShip($owner, $old_owner_id, $vehicle->id, 14);

                                                    Vehicle::where("Id", $vehicle->id)->update([
                                                        'PLATE_NO' => $plate_no,
                                                        'CERTIFICATE_NO' => $certificate,
                                                        'PAGE_COUNT' => $page_count,
                                                        'OWNER_ID' => $owner,
                                                        'PROVINCE_ID' => $province,
                                                        'OLD_PROVINCE_ID' => $province_old,
                                                        'ARCHIVE_NO' => $archive_no,
                                                        'IS_PENDING' => 0,
                                                        'STATUS' => 14,
                                                        'UPDATED_BY' => $userPkId
                                                    ]);
                                                    SeriesNumber::where("NAME", $plate_no)->update([
                                                        'IS_ORDER' => 0,
                                                      //  'ORDER_USER' => null,
                                                        'IS_GIVEN' => 1,
                                                        'IS_LOCAL' => 0,
                                                        'LOCAL_USER_ID' => null,
                                                        'VEHICLE_ID' => $vehicle->id,
                                                        'UPDATED_BY_ID' => $userPkId
                                                    ]);

                                                    $show_date = $this->checkLuckyPlate($plate_old_no, 2);
                                                    SeriesNumber::where("NAME", $plate_old_no)->update([
                                                        'IS_ORDER' => 0,
                                                      //  'ORDER_USER' => null,
                                                        'IS_GIVEN' => 0,
                                                        'IS_LOCAL' => 0,
                                                        'LOCAL_USER_ID' => null,
                                                        'VEHICLE_ID' => null,
                                                        'SHOW_DATE' => $show_date,
                                                        'UPDATED_BY_ID' => $userPkId
                                                    ]);

                                                    // $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);
                                                    // $this->epayTransaction($vehicle->id,$archive_no,$payDescription,
                                                    // $payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                                                    $finger1=$fingerDescription;
                                                    
                                                    $vid = $vehicle->id;
                                                    $this->eRequestApprove($requestCode);
                                                     session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'signed_data'=>$signed_data]);
                                                        # code...
     
                                                        $vehicle1 = Vehicle::where("CABIN_NO", $vvcabinid)->first();
                                                        $owners = DB::table("REG_VEHICLE_OWNERSHIP_VIEW")
                                                        ->where("VEHICLE_ID",$vid)
                                                        ->orderBy("START_DATE", "DESC")
                                                        ->orderBy("SHIP_ID", "DESC")
                                                        ->get();
                                                   // session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                                                  
                                                   if (session()->has('vehicleElectron')) {
                                                    // session()->forget('vehicleElectron');
                                                     if (session()->get('vehicleElectron')['eForm'] == 1) {
                                                        $finger1 = session()->get('vehicleElectron');
                                                    $this->electronForm($vehicle1, $owners,$finger1);
                                                    
                                                     }
                                                    }
                                                   
                                                  
                                                  // $message = $this->message("success", "번호판 солилттой шилжүүлэг ам년ттай хийгдлээ.");
                                                    DB::commit();
                                                    return response()->json([
                                                        'statusCode' =>400,
                                                        'message' =>  "번호판 солилттой шилжүүлэг ам년ттай хийгдлээ."
                                                       
                                                      
                                                    ]);
                                                  //  return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                                } else {
                                                    return response()->json([
                                                        'statusCode' =>400,
                                                        'message' =>  "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү."
                                                       
                                                      
                                                    ]);
                                                   // $message = $this->message("info", "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү.");
                                                   // return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                                }
                                            } catch (\Exception $ex){
                                                DB::rollBack();
                                                $this->writeLog("Change plate transaction error: ".$ex);
                                                return response()->json([
                                                    'statusCode' =>400,
                                                    'message' =>  " 번호판 교체 이전 처리 중 오류가 발생했습니다."
                                                   
                                                  
                                                ]);
                                                // $message = $this->message("danger", "번호판 교체 이전 처리 중 오류가 발생했습니다.");
                                                // $plate_no = $plate_old_no;
                                                // return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                            }
                                        } else {
                                            return response()->json([
                                                'statusCode' =>400,
                                                'message' => $plate_no . " 번호판 주문이 이루어지지 않았습니다."
                                               
                                              
                                            ]);
                                          //  $message = $this->message("info", $plate_no . " 번호판 주문이 이루어지지 않았습니다.");
                                        //    $plate_no = $plate_old_no;
                                         //   return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                        }
                                    } else {
                                        if (!is_array($result) && $result == false) {
                                            return response()->json([
                                                'statusCode' =>400,
                                                'message' => "소유자 주소가 번호판 주소와 일치하지 않습니다.."
                                               
                                              
                                            ]);
                                           // $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                        } else {
                                            $message = $result[1];
                                        }
                                        $plate_no = $plate_old_no;
                                        return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                    }
                                } else {
                                    return response()->json([
                                        'statusCode' =>400,
                                        'message' => "ТХ -ийн одоогийн болон шинэ өмчлөгчийн харьяалал и년 байна."
                                       
                                      
                                    ]);
                                    // $message = $this->message("info", "ТХ -ийн одоогийн болон шинэ өмчлөгчийн харьяалал и년 байна.");
                                    // $plate_no = $plate_old_no;
                                }
                            } else {
                                return response()->json([
                                    'statusCode' =>400,
                                    'message' => "증명서 번호가 중복됩니다."
                                   
                                  
                                ]);
                                // $message = $this->message("info", "증명서 번호가 중복됩니다.");
                                // $plate_no = $plate_old_no;
                            }
                        } else {
                            return response()->json([
                                'statusCode' =>400,
                                'message' => "번호판 солилттой шилжүүлэх ТХ олдсонгүй."
                               
                              
                            ]);
                            // $message = $this->message("info", "번호판 солилттой шилжүүлэх ТХ олдсонгүй.");
                            // $plate_no = $plate_old_no;
                            // return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                        }
                    }
                    } else {
                        return response()->json([
                            'statusCode' =>400,
                            'message' =>  $plate_no." 번호판이 다른 차량에서 사용 중입니다."
                           
                          
                        ]);
                        // $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                        // $plate_no = $plate_old_no;
                    }
                } else {
                    return response()->json([
                        'statusCode' =>400,
                        'message' => $plate_no." 번호판이 다른 차량에서 사용 중입니다.."
                       
                      
                    ]);
                  //  $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                   // $plate_no = $plate_old_no;
                }
               // return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
            } else {
                return response()->json([
                    'statusCode' =>400,
                    'message' => "번호판 солигдоогүй байна."
                   
                  
                ]);
               // $message = $this->message("info", "번호판 солигдоогүй байна.");
              //  return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
            }
        } catch (\Exception $ex){
            $this->writeLog("Change plate error: ".$ex);
            return response()->json([
                'statusCode' =>400,
                'message' => "번호판 교체 이전 처리 중 오류가 발생했습니다."
               
              
            ]);
           // $message = $this->message("danger", "번호판 교체 이전 처리 중 오류가 발생했습니다.");
          //  $plate_no = $plate_old_no;
         //   return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }
    public function changePlateAutoBox($requestData){
    
        try{
            $userPkId = 7052;
            $plate_no =$requestData->plate_no;
            $plate_old_no = $requestData->current_plate;
            $vvcabinid =  $requestData->cabin_no;
            $certificate = $this->certifcate();

          
            $page_count = 1;
            $description = null;
            $fingerDescription = "전자 요청으로";
            $finger = 5;
            $checkTorguuli ="";
            $payDescription=1;
            $payDescriptionName="QPay&SocialPay";
            $transactionId=0;
            $payAmount=12500;
            $serviceTypeName="VRS4";
            $serviceTypeId=15;
            $requestCode =$requestData->approveCode;
            $signed_data = $requestData->signed_data;
            if($plate_no != $plate_old_no) {
                if(!$this->isDuplicate($plate_no)){
                    if($this->giveNumber($plate_no, $userPkId)){
                        $vehicle = Vehicle::where("cabin_no", $vvcabinid)->get();
                        if ($vehicle->count() > 0) {
                            if($this->isDuplicateCert($certificate) == 0){
                                $vehicle = $vehicle->first();
                                $result = $this->checkAddressPlate($plate_no, $vehicle->owner_id);

                                $limit_count = RegLimited::where("VEHICLE_ID", $vehicle->id)->where("IS_RESTORED", null)
                                ->get()->count();
         
                            //    return     $limit_count;
                                if ($limit_count > 0 ) {
                                 return response()->json([
                                     'statusCode' =>400,
                                     'message' =>" 차량은 ".$limit_count." 종류의 제한이 있어 서비스를 이용할 수 없습니다."
                                    
                                   
                                 ]);
                                }else{
                                if(!is_array($result) && $result == true) {
                                    if($this->isOrderUser($plate_no, $vehicle->id, $vehicle->owner_id)){
                                        $service = $this->getActionPrefix(15);
                                        $archive_number = $this->archiveNumberGenerate($service);
                                        DB::beginTransaction();
                                        try{
                                            if($archive_number != "ERROR"){
                                                $this->createArchive($vehicle->id, $service->id, $certificate, $archive_number, $plate_no, $vehicle->owner_id, $page_count, $description, $finger, $fingerDescription);
                                                Vehicle::where("Id", $vehicle->id)->update([
                                                    'PLATE_NO' => $plate_no,
                                                    'CERTIFICATE_NO' => $certificate,
                                                    'PAGE_COUNT' => $page_count,
                                                    'ARCHIVE_NO' => $archive_number,
                                                    'IS_PENDING' => 0,
                                                    'STATUS' => 15,
                                                    'UPDATED_BY' => $userPkId
                                                ]);
                                                SeriesNumber::where("NAME", $plate_no)->update([
                                                    'IS_ORDER' => 0,
                                                  //  'ORDER_USER' => null,
                                                    'IS_GIVEN' => 1,
                                                    'IS_LOCAL' => 0,
                                                    'LOCAL_USER_ID' => null,
                                                    'VEHICLE_ID' => $vehicle->id,
                                                    'UPDATED_BY_ID' => $userPkId
                                                ]);

                                                $show_date = $this->checkLuckyPlate($plate_no, 2);
                                                SeriesNumber::where("NAME", $plate_old_no)->update([
                                                    'IS_ORDER' => 0,
                                                   // 'ORDER_USER' => null,
                                                    'IS_GIVEN' => 0,
                                                    'IS_LOCAL' => 0,
                                                    'LOCAL_USER_ID' => null,
                                                    'VEHICLE_ID' => null,
                                                    'SHOW_DATE' => $show_date,
                                                    'UPDATED_BY_ID' => $userPkId
                                                ]);
                                                $this->createPrintPlate($plate_no, $service->id, $userPkId,1);
                                                $this->eRequestApprove($requestCode);
                                               // session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                                             
                                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'signed_data'=>$signed_data]);
                                                DB::commit();
                                                return response()->json([
                                                    'statusCode' =>200,
                                                    'message' => "번호판 ам년ттай солигдлоо.."
                                                   
                                                  
                                                ]);
                                               // $message = $this->message("success", "번호판 ам년ттай солигдлоо.");
                                            } else {
                                                return response()->json([
                                                    'statusCode' =>400,
                                                    'message' => "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү."
                                                   
                                                  
                                                ]);
                                                // $message = $this->message("info", "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү.");
                                            }
                                        } catch (\Exception $ex){
                                            DB::rollBack();
                                            $this->writeLog("Change plate transaction error: ".$ex->getMessage());
                                            return response()->json([
                                                'statusCode' =>400,
                                                'message' => "번호판 교체 처리 중 오류가 발생했습니다."
                                               
                                              
                                            ]);
                                          //  $message = $this->message("danger", "번호판 교체 처리 중 오류가 발생했습니다.");
                                           // return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                        }
                                    } else {
                                       
                                      //  $message = $this->message("info", $plate_no." 번호판 주문이 이루어지지 않았습니다.");
                                        $plate_no = $plate_old_no;
                                        return response()->json([
                                            'statusCode' =>400,
                                            'message' => "오류 ".$plate_no." 번호판ын захиалга хийгдээгүй байна"
                                           
                                          
                                        ]);
                                    }
                                } else {
                                    if(!is_array($result) && $result == false){
                                        return response()->json([
                                            'statusCode' =>400,
                                            'message' => "소유자 주소가 번호판 주소와 일치하지 않습니다."
                                           
                                          
                                        ]);
                                    //   $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                    } else {
                                        $message = $result[1];
                                    }
                                    $plate_no = $plate_old_no;
                                }
                            }
                            } else {
                                return response()->json([
                                    'statusCode' =>400,
                                    'message' => "증명서 번호가 중복됩니다."
                                   
                                  
                                ]);
                               // $message = $this->message("info", "증명서 번호가 중복됩니다.");
                            }
                        } else {
                            return response()->json([
                                'statusCode' =>400,
                                'message' => "번호판 солих ТХ олдсонгүй."
                               
                              
                            ]);
                          //  $message = $this->message("info", "번호판 солих ТХ олдсонгүй.");
                        }
                    } else {
                     //   $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                        $plate_no = $plate_old_no;
                        return response()->json([
                            'statusCode' =>400,
                            'message' => "오류".$plate_no." 번호판이 다른 차량에서 사용 중입니다."
                           
                          
                        ]);
                    }
                } else {
                   
                    $plate_no = $plate_old_no;
                    return response()->json([
                        'statusCode' =>400,
                        'message' =>"오류  ".$plate_no." 번호판이 다른 차량에서 사용 중입니다.."
                       
                      
                    ]);
                }
            } else {
                return response()->json([
                    'statusCode' =>400,
                    'message' =>"Солих 번호판 тухайн ТХ ашиглаж байна"
                   
                  
                ]);
              //  $message = $this->message("info", "Солих 번호판 тухайн ТХ ашиглаж байна.");
            }
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Change plate error: ".$ex->getMessage());
            $message = $this->message("danger", "번호판 교체 처리 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }
    public function removeVehicle($requestData){
      
        try{
            $userPkId = 7052;
           // $certificate = $this->certifcate();
            $page_count = 1;
            $description = null;
            $fingerDescription = "전자 요청으로";
            $finger =5;
          //  $owner = $requestData->new_owner;
            $vvcabinid = $requestData->cabin_no;
          
          //  $vehicle = Vehicle::where("CABIN_NO", $vvcabinid)->get();
            

            $payDescription=1;
            $payDescriptionName="QPay&SocialPay";
            $transactionId=0;
            $payAmount=11000;
            $serviceTypeName="VRS9";
    
          //  $plate_no = $requestData->plate_no;
            $plate_old_no = $requestData->current_plate;
            $checkTorguuli ="";
            $serviceTypeId=9;
            $requestCode = "";
            $signed_data = "";


           // $userPkId = session()->get("auth")->id;
          //  $plate_old_no = $this->dec(trim($request->get("current_plate")));
       
            $vehicle = Vehicle::where("cabin_no", $vvcabinid)->get();
            $checkTorguuli = "";

        
            $serviceTypeId=9;
            //return $finger;
            if ($vehicle->count() > 0) {
                $vehicle = $vehicle->first();
                $plate_no = $this->generateRemovePlate();
                if($plate_no != "false"){
                    $service = $this->getActionPrefix(9);
                    $archive_no = $this->archiveNumberGenerate($service);
                    DB::beginTransaction();
                    try{
                        if($archive_no != "ERROR"){
                            $this->createArchive($vehicle->id, $service->id, $vehicle->certificate_no, $archive_no, $plate_no, $vehicle->owner_id, $page_count, $description, $finger, $fingerDescription);
                            Vehicle::where("Id", $vehicle->id)->update([
                                'PLATE_NO' => $plate_no,
                                'PAGE_COUNT' => $page_count,
                                'ARCHIVE_NO' => $archive_no,
                                'STATUS' => 9,
                                'UPDATED_BY' => $userPkId
                            ]);
                            SeriesNumber::where("NAME", $plate_no)->update([
                                'IS_ORDER' => 0,
                                'IS_GIVEN' => 1,
                                'IS_LOCAL' => 0,
                                'LOCAL_USER_ID' => null,
                                'VEHICLE_ID' => $vehicle->id,
                                'UPDATED_BY_ID' => $userPkId
                            ]);
                            $show_date = $this->checkLuckyPlate($plate_old_no, 2);
                            SeriesNumber::where("NAME", $plate_old_no)->update([
                                'IS_ORDER' => 0,
                                'IS_GIVEN' => 0,
                                'IS_LOCAL' => 0,
                                'LOCAL_USER_ID' => null,
                                'VEHICLE_ID' => null,
                                'SHOW_DATE' => $show_date,
                                'UPDATED_BY_ID' => $userPkId
                            ]);
                            DB::commit();
                            // $this->epayTransaction($vehicle->id,$archive_no,$payDescription,$payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                            $this->eRequestApprove($requestCode);
                            $vid = $vehicle->id;
                          //  $finger1=$fingerDescription;
                              session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'signed_data'=>$signed_data]);
                                # code...

                                $vehicle1 = Vehicle::where("CABIN_NO", $vvcabinid)->first();
                                $owners = DB::table("REG_VEHICLE_OWNERSHIP_VIEW")
                                ->where("VEHICLE_ID",$vid)
                                ->orderBy("START_DATE", "DESC")
                                ->orderBy("SHIP_ID", "DESC")
                                ->get();
                          //  session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli]);
                          if (session()->has('vehicleElectron')) {
                            // session()->forget('vehicleElectron');
                             if (session()->get('vehicleElectron')['eForm'] == 1) {
                                $finger1 = session()->get('vehicleElectron');
                            $this->electronForm($vehicle1, $owners,$finger1);
                            
                             }
                            }
                            return response()->json([
                                'statusCode' =>400,
                                'message' =>  "ТХ -ийн мэдээлэл ам년ттай хасагдлаа."
                               
                              
                            ]);
                          //  $message = $this->message("success", "ТХ -ийн мэдээлэл ам년ттай хасагдлаа.");
                        } else {
                            return response()->json([
                                'statusCode' =>400,
                                'message' =>  "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү."
                               
                              
                            ]);
                          //  $message = $this->message("info", "아카이브 번호 үүсгэхэд алдаа гарлаа дахин үйлдлээ хийнэ үү.");
                        }
                    } catch (\Exception $ex){
                        DB::rollBack();
                        $this->writeLog("Remove vehicle transaction error: ".$ex->getMessage());
                        return response()->json([
                            'statusCode' =>400,
                            'message' =>  "차량 말소 처리 중 오류가 발생했습니다."
                           
                          
                        ]);
                       // $message = $this->message("danger", "차량 말소 처리 중 오류가 발생했습니다.");
                      //  return redirect(url('/vehicle/'.$this->enc($plate_old_no)))->with("message", $message);
                    }
                } else {
                    return response()->json([
                        'statusCode' =>400,
                        'message' =>  "ХХ сери үүсээгүй эсвэл ХХ серитэй сул дугаар байхгүй байна."
                       
                      
                    ]);
                   // $message = $this->message("info", "ХХ сери үүсээгүй эсвэл ХХ серитэй сул дугаар байхгүй байна.");
                    //$plate_no = $plate_old_no;
                }
            } else {
                return response()->json([
                    'statusCode' =>400,
                    'message' =>  $plate_old_no." 번호판 차량을 찾을 수 없습니다."
                   
                  
                ]);
               // $message = $this->message("info", $plate_old_no." 번호판 차량을 찾을 수 없습니다.");
              //  $plate_no = $plate_old_no;
            }
            // return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Remove vehicle error: ".$ex->getMessage());
            return response()->json([
                'statusCode' =>400,
                'message' =>  "차량 말소 처리 중 오류가 발생했습니다."
               
              
            ]);

         //   $message = $this->message("danger", "차량 말소 처리 중 오류가 발생했습니다.");
           // return redirect(url('/vehicle/'.$this->enc($plate_old_no)))->with("message", $message);
        }
    }
    public function generateRemovePlate(){
        try{
            $remove_series = Series::where("NAME", "LIKE", "ХХ%")->orderBy("NAME", "ASC")->get();
            $number = null;
            foreach ($remove_series as $ser){
                $numbers = SeriesNumber::where("IS_GIVEN", 0)->where("IS_HIDDEN", 0)->where("SERIES_ID", $ser->id)->select("NAME")->get();
                if($numbers->count() > 0){
                    foreach ($numbers as $number){
                        if (!$this->isDuplicate($number->name)) {
                            $number = $number->name;
                            break;
                        }
                    }
                }
            }
            if($number == null){
                return "false";
            } else {
                return $number;
            }
        } catch (\Exception $ex){
            $this->writeLog("Generate remove plate error: ".$ex->getMessage());
        }
    }
public function electronForm($vehicle1, $owners,$finger)
    {
     // dd($finger['checkTorguuli'][0]);
     
        // if(!session()->has("auth")){
        //     return redirect(route($this->redirectURL));
        // }
    // return $vehicle1->archive_no;
    try {
    
        
        $archive=$vehicle1->archive_no;
        $service =$vehicle1->status;
        $vehicle=$vehicle1;
        
    
    
        $action = mb_substr($archive, 0, 2);
        $end = mb_substr($archive, 2, strlen($archive));
    
        $branch = "";
    
        for($i = 0; $i < strlen($end); $i++){
            $sub = mb_substr($end, $i, 1);
            if(is_numeric($sub)){
                break;
            } else {
                $branch = $branch.$sub;
            }
        }  
    
        $len = mb_strlen($branch);
        $year = mb_substr($end, $len, 2);
        $month = mb_substr($end, $len + 2, 2);
        $number = mb_substr($end, $len + 4, strlen($end));
       
    if(Storage::disk('ftp')->has("/test/".$action)){
       // return $action;
     $pdf=PDF::loadView('Reports.vehicleElectronForm',compact('owners','finger','vehicle','service'));
    
    // $pdf->setOptions(["dpi" => 120,"enable_javascript" => true,"enable_remote" => true,"enable_html5_parser" =>true, "enable_javascript" => true, "enable_php" => true,"font_height_ratio" => 1.1]);
     $pdf->setPaper('a4','portrait');
     $pdf->setWarnings(false);
     
     
    $content = $pdf->output();
    
    
    $pdfFile = session()->get('vehicleElectron');
    // if ($pdfFile['ntrServiceFile']!="") {
    //     return $pdfFile['ntrServiceFile'];
    // }
     
    if(!Storage::disk('ftp')->has("/test/".$action."/".$branch."/".$year."/".$month."/".$number."#.pdf")){
    
        if (!Storage::disk('ftp')->exists("/test/".$action."/".$branch."/".$year."/".$month)) {
            Storage::disk('ftp')->makeDirectory("/test/".$action."/".$branch."/".$year."/".$month);
            Storage::disk('ftp')->put("/test/".$action."/".$branch."/".$year."/".$month."/".$number."#.pdf", $content);
     
            session()->forget(['vehicleElectron']);
             }else{
                Storage::disk('ftp')->put("/test/".$action."/".$branch."/".$year."/".$month."/".$number."#.pdf", $content);
                // if ($pdfFile['ntrServiceFile']!="") {
                //     $link = file_get_contents($pdfFile['ntrServiceFile']);
                //     Storage::disk('ftp')->put("/test".$action."/".$branch."/".$year."/".$month."/".$number."#ntr.pdf", $link);
                //     }
                session()->forget(['vehicleElectron']);
             }
     
    
     //$filecontent = Storage::disk('ftp')->get("/".$action."/".$branch."/".$year."/".$month."/".$number.".pdf");
    
        }else{
            
            session()->forget(['vehicleElectron']);
        }



    
   
     }
    } catch (\Throwable $ex) {
        $this->writeLog("Move owner transaction error: ".$ex->getMessage());
    }
      
       
    
    }

    public function checkAddressPlate($plate_no, $owner){
     
        try{
            $series_id = SeriesNumber::where("NAME", $plate_no)->get()->first()->series_id;
            $series = Series::where("ID", $series_id)->get();
            $series_province = $series->first()->province_id;
            $series_is_check_address = $series->first()->is_check_address;
            if($series_is_check_address == 1){
                $owner_province = Owner::where("ID", $owner)->get()->first()->province_id;
                if($series_province == $owner_province){
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } catch (\Exception $ex){
            $this->writeLog("주소ийн мэдээлэл шалгахад 오류가 발생했습니다. ".$ex);
            $message = $this->message("info", "Серийн мэдээлэл шивэгдээгүй эсвэл эзэмшигчийн хаягийн мэдээлэл дутуу байна.");
            return array(true, $message);
        }
    }
    public function giveNumber($plate_no, $userPkId){
      
        $tmp_plate = SeriesNumber::where("NAME", $plate_no)->where("IS_OPENED", 1)->where("IS_HIDDEN", 0)->where("IS_GIVEN", 0)->get();

        if($tmp_plate->count() > 0){
            $tmp_plate = $tmp_plate->first();
            if($tmp_plate->is_local == 1){
                if($tmp_plate->local_user_id == null || $tmp_plate->local_user_id == ""){
                    return false;
                } else {
                    if($tmp_plate->local_user_id == $userPkId){
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    public function isDuplicate($plate_no){
      
        $vehicle = DB::table("REG_VEHICLE")->where("PLATE_NO", $plate_no)->get();
        if($vehicle->count() > 0){
            return true;
        } else {
            return false;
        }
    }
    public function isOrderUser($plate_no, $vehicle, $ownerPkId){
     
        try {
            $owner = Owner::where("ID", $ownerPkId)->get()->first();
            $ownerRegister = $owner->register_no;
            $ownerType = $owner->type_id;

            $check = SeriesNumber::where("NAME", $plate_no)
                ->where("IS_OPENED", 1)
                ->where("IS_HIDDEN", 0)
                ->where("IS_GIVEN", 0)
                ->get();

            if($check->count() > 0){
                $series = Series::where("ID", $check->first()->series_id)->get();
                $series_type = $series->first()->type;

                if($series_type != 1){
                    return true;
                } else {
                    $check_vehicle = Vehicle::where("ID", $vehicle)->get()->first();
                    $check_vehicle = substr($check_vehicle->cabin_no, -5);
                    if($ownerType != 1){
                        $ownerRegister = substr($ownerRegister, 0,-4);
                        $isOrder = SeriesNumber::where("NAME", $plate_no)
                            ->where("IS_ORDER", 1)
                            ->where("ORDER_USER", "LIKE", $ownerRegister."%")
                            ->where("ORDER_CABIN", $check_vehicle)
                            ->where("IS_OPENED", 1)
                            ->where("IS_HIDDEN", 0)
                            ->where("IS_GIVEN", 0)
                            ->get();
                    } else {
                        $isOrder = SeriesNumber::where("NAME", $plate_no)
                            ->where("IS_ORDER", 1)
                            ->where("ORDER_USER", $ownerRegister)
                            ->where("ORDER_CABIN", $check_vehicle)
                            ->where("IS_OPENED", 1)
                            ->where("IS_HIDDEN", 0)
                            ->where("IS_GIVEN", 0)
                            ->get();
                    }
                    if($isOrder->count() > 0){
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } catch (\Exception $ex){
            $this->writeLog("Is Order Error: ".$ex->getMessage());
        }
    }
    public function getProvinceAbbr($province){
      
        $province = AddressProvince::where("Id", $province)->get()->first();
        return $province;
    }

    public function getActionPrefix($service){
     
        $service = MainService::where("Id", $service)->get()->first();
        return $service;
    }
    public function archiveNumberGenerate($service){
    
        $archive_prefix = "";
        $archive_department_abbr = "";
        try{
            $userPkId = 7052;
            $current_year = Carbon::now()->format("Y");
            $current_month = Carbon::now()->format("m");
            $archive_department_id = 484;
            $archive_department_abbr = "ЦАХ";
            $archive_prefix = $service->serviceprefix;
            //return $archive_prefix;
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
            } elseif($archive_prefix == "ДХ"){
                DB::update("UPDATE ARCHIVE_NUMBER SET PLATE_SAVE_COUNT = PLATE_SAVE_COUNT+1, MODIFIEDBY = ".$userPkId." WHERE ABBR = '".$archive_department_abbr."' AND ARCHIVE_DEPARTMENT_ID = ".$archive_department_id." AND YEAR =".$current_year." AND MONTH = ".$current_month);
                $update_count = $archive[0]->plate_save_count + 1;
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
    
    public function epayTransaction($vehicle_id,$archive_no,$payDescription,$payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId){

        // $archive = VehicleArchive::where('INSERT_ARCHIVE_NO',$archive_no)->where('vehicle_id',$vehicle_id)->orderBy('id','desc')->first(); 
             
         
        // if ($archive) {
 # code...

            // $archive_id= $archive->id;
             if ($payDescription == 1) {
                 $transactionUpdate = Transaction::find($transactionId);


            $transactionUpdate->arkhive_no=$archive_no;
            
    
    
            $transactionUpdate->save();
             }
           
          
            $userPkId = session()->get("auth")->id;
            
                 $createEpayTransaction = new EpayTransaction;
                 $createEpayTransaction->transaction_id = $transactionId;
                 $createEpayTransaction->vehicle_id = $vehicle_id;
                 $createEpayTransaction->arkhive_no = $archive_no;
                 $createEpayTransaction->amount = $payAmount;
                 $createEpayTransaction->pay_type = $payDescription;
                 $createEpayTransaction->created_by = $userPkId;
                 $createEpayTransaction->created_at = now();
                 $createEpayTransaction->pay_type_name = $payDescriptionName;
                 $createEpayTransaction->service_type = $serviceTypeName;
                 $createEpayTransaction->service_id = $serviceTypeId;
                
                 $createEpayTransaction->save();
             


          //  }





 }
 
 public function isDuplicateCert($certificate_no){
 
    $duplicate = DB::table("ARCHIVE_VIEW")
        ->where("CERTIFICATE_NO", trim($certificate_no))
        ->get()
        ->count();
    return $duplicate;
}
public function createArchive($vehicle_id, $service_id, $certificate, $archive_number, $plate_no, $owner_id, $page_count, $description, $finger, $finger_description){
 
    $request = Vehicle::where("Id", $vehicle_id)->get()->first();
    $userPkId = 7052;
    $service = $this->getActionPrefix($request->status);
    RegCertificate::create([
        'USER_ID' => $userPkId,
        'CERTIFICATE_NO' => $certificate,
        'CREATED_DATE' => date("Y-m-d H:i:s"),
        'VEHICLE_ID' =>  $request->id,
        'SERVICE_ID' =>  $request->status,
        'FEE' => DB::table("SYSTEM_SERVICE")->where("ID", $request->status)->get()->first()->fee,
        'VEHICLE_PLATE' => $request->plate_no
    ]);
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
        'ARCHIVE_DEPARTMENT' => 484,
        'ARCHIVE_ABBR' => "ЦАХ",
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
    Vehicle::where("Id", $vehicle_id)->update([
        'STATUS' => 6,
        'UPDATED_DATE' => Carbon::now(),
        'UPDATED_BY' => 7052
    ]);
}

public function createOwnerShip($new_owner, $old_owner_id, $vehicle_id, $status){
  
    $userPkId = 7052;
    if($old_owner_id != 0){
        OwnerShip::where("VEHICLE_ID", $vehicle_id)
            ->where("OWNER_ID", $old_owner_id)
            ->whereNull("END_DATE")
            ->update([
                'END_DATE' => Carbon::now()->format("Y-m-d H:i:s"),
                'UPDATED_BY' => $userPkId
            ]);
    }

    OwnerShip::create([
        'VEHICLE_ID' => $vehicle_id,
        'OWNER_ID' => $new_owner,
        'START_DATE' => Carbon::now()->format("Y-m-d H:i:s"),
        'STATUS' => $status,
        'CREATED_BY' => $userPkId,
        'UPDATED_BY' => $userPkId
    ]);
}
public function getUserProvincePkId($ownerPkId){
 
    try{
        return Owner::where("Id", $ownerPkId)->get()->first()->province_id;
    } catch (\Exception $ex){
        $this->writeLog("Get owner province id error: ". $ex->getMessage());
        return null;
    }
}
public function eRequestApprove($requestCode)
{

    if ($requestCode !="") {
      $client = new nusoap_client("https://service.transdep.mn//api/WS005_VEHICLE_REGISTRATION.php?wsdl", true);

    $params = array();
    $params["request_code"]= $requestCode;
    //$params["end_year"] = $endtDate;
    $params["token"] = "fbf4cbca1055f1c831b0586fa481cb7ebcd2d5bbb7ac58b501686e2dbc4a1996b199984ad36de3eb6e3a33aa43a444ace05708bd95214c381c6b0ebf83b8f08e";

    $result_json = $client->call('approveRequest',  $params);

  //  dd($result_json);
    }
 

    // $client = new nusoap_client("https://service.transdep.mn//api/WS005_VEHICLE_REGISTRATION.php?wsdl", true);

    // $params = array();
    // $params["request_code"]= $requestCode;
    // //$params["end_year"] = $endtDate;
    // $params["token"] = "fbf4cbca1055f1c831b0586fa481cb7ebcd2d5bbb7ac58b501686e2dbc4a1996b199984ad36de3eb6e3a33aa43a444ace05708bd95214c381c6b0ebf83b8f08e";

    // $result_json = $client->call('approveRequest',  $params);
  //  $result = json_encode($result_json);

//     return $result_json;
//     }
//    }
}

// Dugaaaar zahialga------------------------------------------------------------
public function indexBurtgelAutoBox(Request $request, $type = 0)
{
    $token = $request->get("token");
    $tokenCheck = $this->tokenCheck($token);

   
            try{
               // return $request;
                $provinceID = 0;
        
                $province = DB::table("ADDRESS_PROVINCE")
                    ->where("ABBR", '!=', null)
                    //->where("NAME", '!=', "УБ")
                    ->orderby("NAME", "ASC")
                    ->get();
        
                //1 жагсаалтанд хэдээр гаргах тоо
                $limitPerDay = 50;
                $selectPerDay = 50;
        
                // $agent = new Agent();
                // if($agent->isRobot()){
                //     Log::emergency("Robot хандсан байна => ". $agent->robot());
                //     return view('Touch.burtgel',compact('limitPerDay','province', 'provinceID', 'type'));
                // }
        
                /*****ЭХЛЭЛ - Захиалга 24 цаг хэтэрсэн эсэх*****/
                $reset = DB::table("SERIES_NUMBER_VIEW")
                    ->where("IS_ORDER", '=', (int)1)
                    ->where("IS_GIVEN", '=', (int)0)
                    ->get();
        
                foreach($reset as $row) {
                    $seriesNumberId = $row->id;
                    $nowTime = Carbon::now()->format("Y-m-d H:i:s");
                    $check_order = $row->order_date;
                    $timediff = strtotime($nowTime) - strtotime($check_order);
                    //24 Цаг хэтэрсэн эсэх
                   // dd($timediff);
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
                /*****ТӨГСГӨЛ - Захиалга 24 цаг хэтэрсэн эсэх*****/
                if($request->isMethod("POST")) {
              //  return $request;
              if ($tokenCheck) {

                try {
                    $seriesNumberId = $request->get("seriesNumberId");
                    $provinceID = $request->get("provi");
        if ($provinceID == 11) {
            return response()->json([
                'statusCode' =>400,
                'message' => "오류.",
              
                ]);
        }
                    //Дугаар хайлтын оронгууд
                    $d1 = "";
                    $d2 = "";
                    $d3 = "";
                    $d4 = "";
                    if ($seriesNumberId != null && $seriesNumberId != "" && $provinceID !=null && $provinceID !="") {
                  
                            // $seriesNumberId = $seriesNumberId;
                          //  return  $seriesNumberId;
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
        
                            $a1 = $request->get("a1");
                            $a2 = $request->get("a2");
                            $a3 = $request->get("a3");
                            $a4 = $request->get("a4");
                            $a5 = $request->get("a5");
                            $aral = $a1 . $a2 . $a3 . $a4 . $a5;
        
                            $register = $first . $second . $r1 . $r2 . $r3 . $r4 . $r5 . $r6 . $r7 . $r8;
        
                            if ($option == "company"){
                                $register = $r1 . $r2 . $r3 . $r4 . $r5 . $r6 . $r7;
                                $postfix = "=02";
                            }
        
                            if ($option == "foreign"){
                                $register = $foreign;
                                $postfix = "=03";
                            }
        
                            //Регистр бичсэн эсэх
                            if ($option == "person") {
                                $is_register = $this->checkRegister($register, $option);
                                if($is_register == false){
                                    return response()->json([
                                        'statusCode' =>400,
                                        'message' => "등록번호를 올바르게 입력하세요.",
                                      
                                        ]);
                                    // $message = $this->message("warning", "등록번호를 올바르게 입력하세요.");
                                    // return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                                }
                                $postfix = "=01";
                            }
        
                            //Регистр бичсэн эсэх
                            if($option == "foreign"){
                                $check_foreign = SeriesNumber::where("IP_ADDRESS", $request->ip().$postfix)->where("IS_GIVEN", 0)->where("IS_ORDER", (int)1)->get();
                                if ($check_foreign->count() > 20000) {
                                    return response()->json([
                                        'statusCode' =>400,
                                        'message' => "Захиалга ам년тгүй боллоо..",
                                      
                                        ]);
                                    // $message = $this->message("warning", "Захиалга ам년тгүй боллоо.");
                                    // return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                                }
                            } else {
                                if ($r1 == 0 && $r2 == 0 && $r3 == 0 && $r4 == 0 && $r5 == 0 && $r6 == 0 && $r7 == 0 && $type == null) {
                                    return response()->json([
                                        'statusCode' =>400,
                                        'message' => "등록번호를 올바르게 입력하세요.",
                                      
                                        ]);
                                    // $message = $this->message("warning", "등록번호를 올바르게 입력하세요.");
                                    // return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                                }
                            }
        
                            //섬 бичсэн эсэх
                            if ($aral == "00000" && $type == null) {
                                return response()->json([
                                    'statusCode' =>400,
                                    'message' => "Та арлын дугаараа зөв оруулна уу.",
                                  
                                    ]);
                                // $message = $this->message("warning", "Та арлын дугаараа зөв оруулна уу.");
                                // return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                            }
        
                            /*****ЭХЛЭЛ - Өдрийн захиалга лимит хийгдсэн эсэх*****/
                            $ownerQty = 1;
                            $ownerList = DB::table("OWNER")
                                ->where("OWNER.REGISTER_NO", "LIKE", $register . "%")
                                ->select("OWNER.REGISTER_NO", "OWNER.ORDER_QTY")
                                ->distinct()
                                ->get();
        
                            if ($ownerList->count() > 0) {
                                $ownerList = $ownerList->first();
                                $ownerQty = (int)$ownerList->order_qty;
                            }
        
                            $checkOwnerList = DB::table("SERIES_NUMBER")
                                ->where("SERIES_NUMBER.ORDER_USER", "LIKE", $register . "%")
                                ->where("SERIES_NUMBER.IS_ORDER", "=", (int)1)
                                ->where("SERIES_NUMBER.IS_GIVEN", "=", (int)0)
                                ->select("SERIES_NUMBER.ORDER_USER", "SERIES_NUMBER.SHOW_DATE")
                                ->get()
                                ->count();
                            if ($checkOwnerList >= $ownerQty) {
                                return response()->json([
                                    'statusCode' =>400,
                                    'message' => "Таны өнөөдрийн захиалга хийх эрх дууссан байна.",
                                  
                                    ]);
                                // $message = $this->message("warning", "Таны өнөөдрийн захиалга хийх эрх дууссан байна.");
                                // return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                            }
        
                            /*****ТӨГСГӨЛ - Өдрийн захиалга лимит хийгдсэн эсэх*****/
        
                            $checkDuplicate = DB::table("SERIES_NUMBER")
                                ->where("SERIES_NUMBER.ID", "=", $seriesNumberId)
                                ->where("SERIES_NUMBER.IS_ORDER", "=", (int)1)
                                ->where("SERIES_NUMBER.IS_GIVEN", "=", (int)0)
                                ->select("SERIES_NUMBER.ORDER_USER", "SERIES_NUMBER.SHOW_DATE")
                                ->get()
                                ->count();
        
                            if ($checkDuplicate > 0) {
                                return response()->json([
                                    'statusCode' =>400,
                                    'message' => "Дугаар захиалагдсан байна. Та өөр дугаар захиална уу",
                                  
                                    ]);
                                // $message = $this->message("warning", "Дугаар захиалагдсан байна. Та өөр дугаар захиална уу.");
                                // return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                            } else {
                                $numberText = SeriesNumber::where("ID", $seriesNumberId)->where("IS_ORDER", (int)0)->get();
                                if($numberText->count() > 0){
                                    $numberText = $numberText->first()->name;
                                } else {
                                    $numberText = "";
                                }
        
                                $order_date = Carbon::now()->format("Y-m-d H:i:s");
                                SeriesNumber::where("ID", $seriesNumberId)->where("IS_ORDER", (int)0)->update([
                                    'IS_ORDER' => 1,
                                    'IS_OPENED' => 1,
                                    'ORDER_DATE' => $order_date,
                                    'ORDER_USER' => $register,
                                    'IP_ADDRESS' => $request->ip().$postfix,
                                    'IP_INFO' => $request->userAgent(),
                                    'ORDER_CABIN' => $aral
                                ]);
        
                                return response()->json([
                                    'statusCode' =>200,
                                    'message' => "Дугаар захиалга ам년ттай.",
                                    'data'=>[
                                        'order_plate'=>$numberText,
                                        'order_register'=>$register,
                                        'order_cabin'=>$aral,
                                        'order_date'=>$order_date,
                                        'valid_date'=>Carbon::parse($order_date)->addDay(1),
                                        'info'=>"24 цагийн хугацаанд хүчинтэй"
                                    ],
                                    ]);
                                // $message_info = '<table class="table table-bordered" style="font-size: 16px;"><tbody><tr><th><div>Захиалсан дугаар</div></th><th><div>'.$numberText.'</div></th></tr><tr><th><div>등록번호</div></th><th><div>'.$register.'</div></th></tr><tr><th><div>차체번호</div></th><th><div>'.$aral.'</div></th></tr><tr><th><div>주문 일자</div></th><th><div>'.$order_date.'</div></th></tr><tr><th><div>Хүчинтэй огноо</div></th><th><div>'.Carbon::parse($order_date)->addDay(1).'</div></th></tr></tbody></table>';
                                // $message = $this->message("success", '24 цагийн хугацаанд хүчинтэй.<br>'.$message_info.'<div style="color:red">Захиалгын мэдээллийг баталгаажуулах үүднээс дэлгэцийн зургийг дарж авна уу!</div>');
                                // return view('Touch.burtgel', compact('limitPerDay', 'province', 'provinceID', 'type', 'message'));
                            }
                        
                    }
        
                    $seriesId = $request->get("series");
                    $seriesModal = $request->get("seriesModal");
                    if (($seriesId != "" && $seriesId != null) || ($seriesModal != "" || $seriesModal != null)) {
                       // $seriesId = self::seriesIdDec($seriesId);
                       // $seriesId = self::seriesIdEnc($seriesId);
                        $d1 = $request->get("d1");
                        $d2 = $request->get("d2");
                        $d3 = $request->get("d3");
                        $d4 = $request->get("d4");
        
                        $searchNumber = $d1 . $d2 . $d3 . $d4;
                        //Дугаар хайх товч дарсан эсэх
                        if($searchNumber == "0000") { 
                           
                        
                            $all_numbers = $this->selectNumbers($seriesId);
                            //return $all_numbers;
                            $numbers = $this->boardNumbers($all_numbers, $selectPerDay, "all");
                          //  return $numbers;
                        }
                        else {
                            //Дугаар хайлт
                           
                        //     $rules = ['captcha1' => 'required|captcha'];
                        //     $validator = validator()->make(request()->all(), $rules);
                        // //    dd( $$validator->fails());
                        //     if ($validator->fails()) {
                        //         $message = $this->message("info", "Баталгаажуулах код буруу байна.");
                        //         return $message;
                        //     } else {
                                   
                            $searchNumber = preg_replace("/[^0-9]/", "", $searchNumber);
                            $all_numbers = $this->selectSearchNnumber($seriesId, $searchNumber);
                            $numbers = $this->boardNumbers($all_numbers, $selectPerDay, "search");
      
                          //  }
                        }
                        if($seriesId != "" && $seriesId != null){
                            $tmp_series_id = $seriesId;
                            $seriesId = self::seriesIdEnc($seriesId);
                        } else {
                            $tmp_series_id = 11;
                            $seriesId = 11;
                        }
                      //  return $seriesId;
                      return response()->json([
                        'statusCode' =>200,
                        'message' => "Дугаар захиалга дата.",
                        'data'=>[
                            'seriesId'=>$seriesId,
                            'tmp_series_id'=>$tmp_series_id,
                            'numbers'=>$numbers,
                            'limitPerDay'=>$limitPerDay,
                            'province'=>$province,
                            'provinceID'=>$provinceID,
                            'd1'=>$d1,
                            'd2'=>$d2,
                            'd3'=>$d3,
                            'd4'=>$d4,
                            'searchNumber'=>$searchNumber,

                            'type'=>$type,
                        ],
                        ]);
                      //  return view('Touch.burtgel', compact('seriesId', 'tmp_series_id', 'numbers', 'limitPerDay', 'province', 'provinceID', 'd1', 'd2', 'd3', 'd4', 'searchNumber', 'type'));
                    } else {
                        // Log::info("Yes");
                        return response()->json([
                            'statusCode' =>200,
                            'message' => "Дугаар захиалга дата.",
                            'data'=>[
                                'limitPerDay'=>$limitPerDay,
                                'province'=>$province,
                                'provinceID'=>$provinceID,
                                'type'=>$type,
                            ],
                            ]);
                       // return view('Touch.burtgel',compact('limitPerDay','province', 'provinceID', 'type'));
                    }
                } catch (\Exception $ex) {
                    $Result["success"] = false;
                    $Result["message"] = "오류 гарлаа !!!";
                }
            } else {
                $Result["success"] = false;
                $Result["message"] = "Token буруу байна !!!";
                return response()->json($Result, 200);
        
            }
                } else {
                    return response()->json([
                        'statusCode' =>200,
                        'message' => "Дугаар захиалга аймаг дата.",
                        'data'=>[
                            'limitPerDay'=>$limitPerDay,
                            'province'=>$province,
                            'provinceID'=>$provinceID,
                            'type'=>$type,
                    
                    ],
                       
                      
                    ]);
                  //  return $province;
                    // Log::info("Yes1");
                   // return view('Touch.burtgel',compact('limitPerDay','province', 'provinceID', 'type'));
                }
            } catch (\Exception $ex){
                $this->writeLog("Дугаар захиалга алдаа гарлаа: ".$ex);
                return redirect(url("/"));
            }
    
  
}

// public function dateCalc($row){
    
//     if($row->show_date == null || strlen($row->show_date) < 10){
//         $enc = \App\Http\Controllers\BaseController::enc("'".Carbon::now()->addDay(-1)."'");
//     } else {
//         $enc = $row->show_date;
//        // dd($enc);
//     }
//     $nowTime = Carbon::now()->format("Y-m-d H:i:s");
 
//     $timediff = strtotime($nowTime) - strtotime(\App\Http\Controllers\BaseController::dec($enc));
//    // dd($timediff);
//     return $timediff;
// }
public function dateCalc($row){
        
    // if($row->show_date == null ){
    //     $enc = \App\Http\Controllers\BaseController::enc("'".Carbon::now()->addDay(-1)."'");
    // } else {
    //     $enc = $row->show_date;
    //    // dd($enc);
    // }
    $nowTime = Carbon::now()->format("Y-m-d H:i:s");
 
  //  $timediff = strtotime($nowTime) - strtotime(\App\Http\Controllers\BaseController::dec($enc));
    $timediff = strtotime($nowTime) - strtotime(strtotime($row->order_date));
   // dd($timediff);
    return $timediff;
}
public function checkRegister($reqister, $option){
    if($option == "person"){
        $letter = mb_substr($reqister, 0, 2);
        $year = mb_substr($reqister, 2, 2);
        $month = mb_substr($reqister, 4, 2);
        $day = mb_substr($reqister, 6, 2);
        if($month > 0 && $month < 33 && $day > 0 && $day < 32){
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

public function selectNumbers($seriesId){
   
    $all_numbers = DB::table("SERIES_NUMBER SN")
        ->selectRaw("SN.ID, SN.WEEKEND, SN.NAME, SN.ORDER_DATE, SN.IS_ORDER, SN.IS_GIVEN, SN.SHOW_DATE, S.PROVINCE_ID, SI.NAME INTERVAL_NAME")
        ->join("SERIES S", "SN.SERIES_ID", "S.ID")
        ->join("SERIES_INTERVAL SI", "S.ID", "SI.SERIES_ID")
        ->where("S.PROVINCE_ID", (int)$seriesId)
        ->whereNull("SN.VEHICLE_ID")
        ->where("SN.TYPE", "=", (int)1)
        ->where("S.TYPE", "=", (int)1)
        ->where("SI.NAME", "!=", "SEND")
        ->where("SI.IS_OPENED", (int)1)
        ->where("SI.IS_ORDER", (int)1)
        ->where("SI.IS_HIDDEN", (int)0)
        ->where("SN.IS_LOCAL", (int)0)
        ->where("SN.IS_HIDDEN", (int)0)
        ->where("SN.IS_OPENED", (int)1)
        ->where("SN.IS_GIVEN", (int)0)
        ->where("SN.IS_ORDER", (int)0)
        ->where("SN.ISAUCTION", (int)0)
      ->where("SN.SERIES_ID", "!=", (int)35)
            //->limit(1000)
        ->get();
      
    return $all_numbers;
}

public function selectSearchNnumber($seriesId, $number){
    $all_numbers = DB::table("SERIES_NUMBER SN")
        ->selectRaw("SN.ID, SN.WEEKEND, SN.NAME, SN.ORDER_DATE, SN.IS_ORDER, SN.IS_GIVEN, SN.SHOW_DATE, S.PROVINCE_ID, SI.NAME INTERVAL_NAME")
        ->join("SERIES S", "SN.SERIES_ID", "S.ID")
        ->join("SERIES_INTERVAL SI", "S.ID", "SI.SERIES_ID")
        ->where("S.PROVINCE_ID", (int)$seriesId)
        ->where("SN.NO", $number)
        ->where("S.TYPE", (int)1)
        ->where("SN.TYPE", (int)1)
        ->where("SI.IS_OPENED", (int)1)
        ->where("SI.IS_ORDER", (int)1)
        ->where("SI.IS_HIDDEN", (int)0)
        ->where("SN.IS_LOCAL", (int)0)
        ->where("SN.IS_HIDDEN", (int)0)
        ->where("SN.IS_OPENED", (int)1)
    ->where("SN.ISAUCTION", (int)0)
        ->where("SI.NAME", "!=", "SEND")
    ->orderBy("SN.NAME", "ASC")
        ->limit(1000)
        ->get();
    return $all_numbers;
}

/**
 * Самбарт харуулах дугаарыг долоо хоногийн гариг тус бүрээр тэнцүү тараах үйлдэл
 * @param $all_numbers
 * @param $selectPerDay
 * @return array
 */
public function boardNumbers($all_numbers, $selectPerDay, $type){
    
    $numbers = array();
    if($type == "search"){
       
        foreach ($all_numbers as $key => $data) {
            $info = $this->showClass($data);
            $data->difftime = $info["difftime"];
            $data->class = $info["class"];
            $data->row_id = $info["row_id"];
            $numbers[$key] = $data;
        }
   
       // dd($numbers);
    } else {
      //  return $all_numbers;
        $numbers1 = $all_numbers;
        foreach ($all_numbers as $key => $data) {
            $info = $this->showClass($data);
            $data->difftime = $info["difftime"];
            $data->class = $info["class"];
            $data->row_id = $info["row_id"];
            $numbers[$key] = $data;
        }
      
        $select = 0;
        foreach ($numbers1 as $key => $data) {
            if($data->weekend == 1){
                $info = $this->showClass($data);
                $data->difftime = $info["difftime"];
                $data->class = $info["class"];
                $data->row_id = $info["row_id"];
              //  if($data->difftime > 0){
                    $numbers[$key] = $data;
                    $select++;
             //   }
                $all_numbers->forget($key);
            }
            if($select == $selectPerDay){
                break;
            }
        }
        $select = 0;
        $numbers2 = $all_numbers;
        foreach ($numbers2 as $key => $data) {
            if($data->weekend == 2){
                $info = $this->showClass($data);
                $data->difftime = $info["difftime"];
                $data->class = $info["class"];
                $data->row_id = $info["row_id"];
              //  if($data->difftime > 0){
                    $numbers[$key] = $data;
                    $select++;
             //  }
                $all_numbers->forget($key);
            }
            if($select == $selectPerDay){
                break;
            }
        }

        $select = 0;
        $numbers3 = $all_numbers;
        foreach ($numbers3 as $key => $data) {
            if($data->weekend == 3){
                $info = $this->showClass($data);
                $data->difftime = $info["difftime"];
                $data->class = $info["class"];
                $data->row_id = $info["row_id"];
             //   if($data->difftime > 0){
                    $numbers[$key] = $data;
                    $select++;
             //   }
                $all_numbers->forget($key);
            }
            if($select == $selectPerDay){
                break;
            }
        }

        $select = 0;
        $numbers4 = $all_numbers;
        foreach ($numbers4 as $key => $data) {
            if($data->weekend == 4){
                $info = $this->showClass($data);
                $data->difftime = $info["difftime"];
                $data->class = $info["class"];
                $data->row_id = $info["row_id"];
              //  if($data->difftime > 0){
                    $numbers[$key] = $data;
                    $select++;
               // }
                $all_numbers->forget($key);
            }
            if($select == $selectPerDay){
                break;
            }
        }

        $select = 0;
        $numbers5 = $all_numbers;
        foreach ($numbers5 as $key => $data) {
            if($data->weekend == 5){
                $info = $this->showClass($data);
                $data->difftime = $info["difftime"];
                $data->class = $info["class"];
                $data->row_id = $info["row_id"];
              // if($data->difftime > 0){
                    $numbers[$key] = $data;
                    $select++;
             //  }
                $all_numbers->forget($key);
            }
            if($select == $selectPerDay){
                break;
            }
        }
    }
    return $numbers;
}

public function showClass($data){
    $difftime = $this->dateCalc($data);
    $class = "";
    if($data->is_order == 1){
        $class = " ordered_number";
    }
   // dd($data);
    // if($difftime < 0){
    //     $class = " ordered_pending";
    // }
    if($data->is_given == 1){
        $class = " given_number";
    }
    $row_id = "";
    if ($data->is_order == 0 && $data->is_given == 0) {
        // $row_id = \App\Http\Controllers\BaseController::enc($data->id);
        $row_id = $data->id;
    }
    return array("class" => $class, "difftime" => $difftime, "row_id" => $row_id);
}
//----------------------------plateSave------------------------------------------------------------

public function plateSaveStore(Request $request)
{
       
        if($request->isMethod("POST")){
            $token = $request->get("token");
            $tokenCheck = $this->tokenCheck($token);
            $plate_no = trim($request->get("plateNo"));
            $vehicle_id = trim($request->get("vehId"));
            $customerRegNum = trim($request->get("customerRegnum"));
            $customerLastName = trim($request->get("customerLastname")); 
            $customerFirstName = trim($request->get("customerFirstname"));
            $customerPhoneNumber = trim($request->get("customerPhoneNumber"));
            $beginDate = trim($request->get("startDate"));
            $endDate = trim($request->get("endDate"));
            $userPkId = 0;
           // return $request;
            $service = $this->getActionPrefix(27);
          //  return $request;
           // $archive=$this->archiveNumberGenerate($service);
        //   return $this->archiveNumberGenerate($service);
           // $vehicle = Vehicle::where("plate_no", $request->plateNo)->get();
           if ($tokenCheck ) {
            # code...
         
            $seriesNumber = SeriesNumber::where("name", $request->plateNo)->where("is_save", 0)->get();
            $plateNumberSave = \App\PlateNumberSave::where("plate_no", $request->plateNo)->where("is_active", 1)->get();
            $vehCheck = Vehicle::where("plate_no", $request->plateNo)->where("id",$vehicle_id)->get();

            //return $vehCheck;
                if (count($seriesNumber) > 0 && count($plateNumberSave) == 0 && count($vehCheck) > 0) {

                  $save=  \App\PlateNumberSave::create([ 
                        'PLATE_NO' => $plate_no,                              
                        'ARCHIVE_NUMBER' => $this->archiveNumberGenerate($service),
                        'CUSTOMER_REGNUM'=>$customerRegNum, 
                        'CUSTOMER_LASTNAME'=>$customerLastName,
                        'CUSTOMER_FIRSTNAME'=>$customerFirstName,
                        'CUSTOMER_PHONE'=>$customerPhoneNumber,
                        'BEGIN_DATE'=>$beginDate,
                        'IS_ACTIVE'=>1,
                        'EXTEND_COUNT'=>1,
                        'END_DATE'=>$endDate,
                        'CREATED_BY' => $userPkId,
                        'CREATE_DATE' => Carbon::now(),
                        
                    ]);
                $series_number=$seriesNumber->first();
                    if ($save) {
                        SeriesNumber::where("ID", $series_number->id)->update([
                            'ORDER_USER' => "ДХ",
                            'IS_HIDDEN' => 1,
                            'IS_SAVE' => 1,
                           
                           
                        ]);
                        $message = $this->message("success", "번호판 ам년ттай хадаглагдлаа.");
                        return response()->json([
                            'statusCode' =>200,
                            'message' =>"번호판 ам년ттай хадаглагдлаа."
                           
                          
                        ]);
                    }
              
                  //  DB::update("UPDATE SERIES_NUMBER SET IS_HIDDEN=1, IS_SAVE=1,ORDER_USER='ДХ'  WHERE ID= $series_number->id");
                  
                }else{
                   // $message = $this->message("danger", "번호판 хадгалахад алдаа гарлаа тээврийн хэрэгслийн 번호판аа зөв оруулсан эсэхээ шалган уу!!!.");
                    return response()->json([
                        'statusCode' =>400,
                        'message' =>"번호판 хадгалахад алдаа гарлаа тээврийн хэрэгслийн 번호판аа зөв оруулсан эсэхээ шалган уу!!!.."
                       
                      
                    ]);
                }
           
        }else{
        return response()->json([
            'statusCode' =>400,
            'message' =>"Токен буруу байна."
           
          
        ]);
    }
}

 
}
public function plateSaveOrder(Request $request)
{
    try {
        if (! $request->isMethod('POST')) {
            return response()->json([
                'statusCode' => 400,
                'message' => 'Зөвхөн POST хүсэлт зөвшөөрөгдөнө.',
            ]);
        }

        $token = $request->get('token');
        $tokenCheck = $this->tokenCheck($token);
        $plate_no = trim($request->get('plateNo'));
        $customerRegNum = trim($request->get('customerRegnum'));
        $customerLastname = trim($request->get('customerLastname'));
        $customerFirstname = trim($request->get('customerFirstname'));
        $orderCabin = trim($request->get('customerOrderCabin'));
        $userPkId = session()->get('auth')->id;

        if (! $tokenCheck) {
            return response()->json([
                'statusCode' => 400,
                'message' => 'Токен буруу байна.',
            ]);
        }

        $plateNumberSave = \App\PlateNumberSave::where('plate_no', $plate_no)->get();

        foreach ($plateNumberSave as $record) {
            \App\PlateNumberSave::where('id', $record->id)->update([
                'IS_ACTIVE' => 0,
            ]);
        }

        $order = SeriesNumber::where('NAME', $plate_no)->where('ORDER_USER', 'ДХ')->update([
            'IS_ORDER' => 1,
            'ORDER_USER' => $customerRegNum,
            'ORDER_DATE' => Carbon::now(),
            'IS_OPENED' => 1,
            'IS_GIVEN' => 0,
            'IS_HIDDEN' => 0,
            'IS_AUTO' => 1,
            'IS_SAVE' => 0,
            'IS_LOCAL' => 0,
            'ORDER_CABIN' => $orderCabin,
            'VEHICLE_ID' => null,
        ]);

        if ($order) {
            \App\PlateNumberSaveOrder::create([
                'PLATE_NO' => $plateNumberSave[0]->plate_no,
                'CABIN' => $orderCabin,
                'CUSTOMER_REGNUM' => $customerRegNum,
                'CUSTOMER_LASTNAME' => $customerLastname,
                'CUSTOMER_FIRSTNAME' => $customerFirstname,
                'CREATED_BY' => $userPkId,
                'CREATE_DATE' => Carbon::now(),
            ]);

            return response()->json([
                'statusCode' => 200,
                'message' => '번호가 성공적으로 주문되었습니다.',
            ]);
        }

        return response()->json([
            'statusCode' => 400,
            'message' => 'Дугаар захиалхад алдаа гарлаа өөр тх-дээр захиалсан байна..',
        ]);
    } catch (\Exception $ex) {
        DB::rollBack();
        $this->writeLog('error: '.$ex);

        return response()->json([
            'statusCode' => 500,
            'message' => '오류 гарлаа.',
        ]);
    }
}





}
