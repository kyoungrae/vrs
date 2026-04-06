<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvince;
use App\Http\Controllers\BaseController;
use App\MainService;
use App\Owner;
use App\EpayTransaction;
use App\OwnerShip;
use App\OwnerType;
use App\RegLimited;
use App\Series;
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
//use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class VehicleController extends BaseController
{
    public function certifcate()
    {
        return "CERT".Str::substr(Carbon::now()->format("YmdHis"),2);
    }
    public function indexVehicle(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/vehicle", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try {
            if (self::isRealUiWithoutDb()) {
                $userPkId = session()->get("auth")->id;
                $limit_count = 0;
                $limits = collect([]);
                $services = collect([]);
                $provinces = collect([]);
                $countries = collect([]);
                $types = collect([]);
                $Printers = collect([]);
                $Diagnostic = null;
                $isMobile = $this->isMobileDevice();
                $message = $this->message('info', '[로컬] DB 없이 차량 화면만 표시합니다. Oracle 연결 후 실제 데이터를 사용하세요.');

                return view('System.vehicle', compact(
                    'limits',
                    'services',
                    'limit_count',
                    'provinces',
                    'countries',
                    'types',
                    'Printers',
                    'Diagnostic',
                    'isMobile',
                    'userPkId',
                    'message'
                ));
            }

            $userPkId = session()->get("auth")->id;

            $limit_count = 0;
            try {
                $limits = DB::table("REG_LIMIT_TYPE")->get();
            } catch (\Exception $e) {
                $limits = collect([]);
                $this->writeLog("Vehicle boot REG_LIMIT_TYPE 조회 오류: ".$e->getMessage());
            }
            try {
                $services = MainService::where("IS_SHOW", 1)->orderBy("VIEW_ORDER", "ASC")->get();
            } catch (\Exception $e) {
                $services = collect([]);
                $this->writeLog("Vehicle boot SYSTEM_SERVICE 조회 오류: ".$e->getMessage());
            }
            try {
                $provinces = DB::table("ADDRESS_PROVINCE")->orderBy("name", "ASC")->get();
            } catch (\Exception $e) {
                $provinces = collect([]);
                $this->writeLog("Vehicle boot ADDRESS_PROVINCE 조회 오류: ".$e->getMessage());
            }
            try {
                $countries = DB::table("REF_COUNTRY")->get();
            } catch (\Exception $e) {
                $countries = collect([]);
                $this->writeLog("Vehicle boot REF_COUNTRY 조회 오류: ".$e->getMessage());
            }
            try {
                $types = OwnerType::all();
            } catch (\Exception $e) {
                $types = collect([]);
                $this->writeLog("Vehicle boot OWNER_TYPE 조회 오류: ".$e->getMessage());
            }
            try {
                $Printers = SystemPrinter::all();
            } catch (\Exception $e) {
                $Printers = collect([]);
                $this->writeLog("Vehicle boot SYSTEM_PRINTER 조회 오류: ".$e->getMessage());
            }
            $Diagnostic = null;
            
            //모바일 접속 여부
            $isMobile=false;
            $isMobile=$this->isMobileDevice();

            if($request->isMethod("POST")){
               // $plateColor = $request->get("plateColor");
                $plate_no = trim($request->get("number"));
              //return $plateColor;
            

            //  dd( $systemPlateFactory->platecolor);
                if ($request->has('numberTop')) {
                    $plate_no = trim($request->get("numberTop"));
                    
                }
                $cabin_no = trim($request->get("cabin_no"));
               
                $vehicle_status = "old";
                if($plate_no != ""){
                    $hasVehicle = DB::table("REG_VEHICLE")->select("PLATE_NO")->where("PLATE_NO", $plate_no)->count();
                   
                    if($hasVehicle > 0){
                        return redirect(url('/vehicle/'.$this->enc($plate_no)));
                    } else {
                        return view('System.vehicle', compact('vehicle_status','userPkId','Diagnostic'));
                    }
                }

                if($plate_no == "" && $cabin_no != ""){
                    $vehicle_status = "new";
                    $hasVehicle = DB::table("REG_VEHICLE")->select("PLATE_NO")->where("CABIN_NO", $cabin_no)->count();
                    
                    if($hasVehicle > 0) {
                        return redirect(url('/vehicle/'.$this->enc($cabin_no).'/new'));
                    } else {
                        
                        return view('System.vehicle', compact('vehicle_status','userPkId','Diagnostic'));
                    }
                } elseif($plate_no == "" && $cabin_no == "") {
                    return view('System.vehicle', compact('limits', 'services', 'limit_count', 'provinces', 'countries', 'types','Printers','Diagnostic','isMobile','userPkId'));
                } else {
                    $vehicle_status = "new";
                    return view('System.vehicle', compact('vehicle_status','userPkId','Diagnostic'));
                }
            } else {
                $vehicle_status = "old";
                $plate_no = $request->route("plate_no");
                
                $cabin_no = $request->route("cabin_no");
                //return  $cabin_no;
                $vehicle_id_url = $request->route("vehicle_id");
               
                if($plate_no !== null || $cabin_no !== null){
                    if($plate_no !== null){
                        $plate_no = $this->dec($plate_no);
                        if($vehicle_id_url != null){
                           
                            $vehicle = DB::table("REG_VEHICLE_VIEW")->where("ID", $vehicle_id_url)->get();
                          
                           
                        } else {
                         
                            $vehicle = DB::table("REG_VEHICLE_VIEW")->where("PLATE_NO", $plate_no)->get();
                        
                        }
                        if($vehicle->count() > 0){
                            $vehicle = $vehicle->first();
                          
                            $vid = $vehicle->id;
                            $systemPlateFactory = SystemPlateFactory::where("plate_no", $plate_no)->orderBy('create_date','desc')->first();
   
                          //  $systemPlateFactory = SystemPlateFactory::where("plate_no", $plate_no)->first();
                      //  return $systemPlateFactory;
                            $owners = DB::table("REG_VEHICLE_OWNERSHIP_VIEW")
                                ->where("VEHICLE_ID", $vid)
                                ->orderBy("START_DATE", "DESC")
                                ->orderBy("SHIP_ID", "DESC")
                                ->get();
                           
                            
                            $histories = DB::table("ARCHIVE_VIEW")
                                ->select("PLATE_NO")
                                ->where("VEHICLE_ID", $vid)
                                ->whereNotNull("PLATE_NO")
                                ->distinct("PLATE_NO")
                                ->get();
                              
                            $oldNumbers = [];
                            foreach($histories as $history){
                                array_push($oldNumbers, $history->plate_no);
                            }

                            $oldNumbers = implode(",", $oldNumbers);
                        
                            session()->forget(["vehicle", "owners"]);
                            session(["vehicle" => $vehicle, "owners" => $owners]); 


                            $limit_count = RegLimited::where("VEHICLE_ID", $vid)->where("IS_RESTORED", null)->get()->count();
                            
                            try {
                                $Diagnostic = DB::table("MVIS.INS_INSPRESULT_SHORT_VIEW")
                                    ->where("SERVICE_TYPE_ID", "1")
                                    ->where("STATUS", "1")
                                    ->where("vehicle_id", $vehicle->id)
                                    ->orderBy("DATEINSPAPPR", "DESC")
                                    ->get()
                                    ->first();
                            } catch (\Exception $e) {
                                $Diagnostic = null;
                            }

                            if($limit_count > 0){
                                $message = $this->message("info", "차량은 ".$limit_count." 종류의 제한이 있어 서비스를 이용할 수 없습니다.");
                                return view('System.vehicle', compact('oldNumbers', 'vehicle','systemPlateFactory', 'limits', 'services', 'provinces', 'owners', 'countries', 'types', 'plate_no', 'limit_count', 'message','Printers','Diagnostic','isMobile','userPkId'));
                            } if($vehicle->is_stolen == 1) {
                                $message = $this->message("danger", "도난당한 차량입니다.");
                                return view('System.vehicle', compact('oldNumbers', 'vehicle','systemPlateFactory', 'limits', 'services', 'provinces', 'owners', 'countries', 'types',  'limit_count', 'vehicle_status', 'message','Printers','Diagnostic','isMobile','userPkId'));
                            } if($vehicle->is_warning == 1){
                                $message = $this->message("info", "위반 차량입니다.");
                                return view('System.vehicle', compact('oldNumbers', 'vehicle','systemPlateFactory', 'limits', 'services', 'provinces', 'owners', 'countries', 'types',  'limit_count', 'vehicle_status', 'message','Printers','Diagnostic','isMobile','userPkId'));
                            }
                            else {

                                // if (session()->get('vehicle')->register_no ) {
                                //     # code...
                                // }
                                   // return session()->get('vehicleElectron')['ntrBookdate'];

                                   // dd(session()->get('vehicleElectron'));
                                  if (session()->has('vehicleElectron')) {
                                   // session()->forget('vehicleElectron');
                                    if (session()->get('vehicleElectron')['eForm'] == 1) {
                                        $vehicle1=session()->get('vehicle');
                                        $finger = session()->get('vehicleElectron');
                                       
                                        $owners = session()->get('owners');
                                   // dd($finger);
                                     // $this->electronForm($vehicle1, $owners,$finger);
                                   
                                    }
                                   

                                 
                                }
                                //
                            //  dd($finger);
                         
                                return view('System.vehicle', compact('oldNumbers', 'vehicle','systemPlateFactory', 'limits', 'services', 'provinces', 'owners', 'countries', 'types', 'plate_no', 'limit_count','Printers','Diagnostic','isMobile','userPkId'));

                                
                              
                               // return view('System.vehicle', compact('oldNumbers', 'vehicle', 'limits', 'services', 'provinces', 'owners', 'countries', 'types', 'plate_no', 'limit_count','Printers','Diagnostic','isMobile','userPkId'));
                            }
                        }
                    } elseif($cabin_no != ""){
                        $cabin_no = $this->dec($cabin_no);
                        $vehicle = DB::table("REG_VEHICLE_VIEW")->where("CABIN_NO", $cabin_no)->get();
                       
                        if($vehicle->count() > 0) {
                            $vehicle_status = "new";
                            $vehicle = $vehicle->first();
                            $vid = $vehicle->id;
                           
                            try {
                                $Diagnostic = DB::table("MVIS.INS_INSPRESULT_SHORT_VIEW")
                                    ->where("SERVICE_TYPE_ID", "1")
                                    ->where("STATUS", "1")
                                    ->where("vehicle_id", $vehicle->id)
                                    ->orderBy("DATEINSPAPPR", "DESC")
                                    ->get()
                                    ->first();
                            } catch (\Exception $e) {
                                $Diagnostic = null;
                            }
                              
                            $histories = DB::table("ARCHIVE_VIEW")
                                ->select("PLATE_NO")
                                ->where("VEHICLE_ID", $vid)
                                ->whereNotNull("PLATE_NO")
                                ->distinct("PLATE_NO")
                                ->get();
                              
                            $oldNumbers = []; 
                            foreach($histories as $history){
                                array_push($oldNumbers, $history->plate_no);
                            }

                            $oldNumbers = implode(",", $oldNumbers);

                            $limit_count = RegLimited::where("VEHICLE_ID", $vid)->where("IS_RESTORED", 0)->get()->count();
                            if($limit_count > 0){
                                $message = $this->message("info", "차량은 ".$limit_count." 종류의 제한이 있어 서비스를 이용할 수 없습니다.");
                                return view('System.vehicle', compact( 'oldNumbers', 'vehicle', 'limits', 'services', 'provinces', 'countries', 'types',  'limit_count', 'vehicle_status', 'message','Printers', 'Diagnostic', 'isMobile','userPkId'));
                            } if($vehicle->is_stolen == 1) {
                                $message = $this->message("danger", "도난당한 차량입니다.");
                                return view('System.vehicle', compact('oldNumbers','vehicle', 'limits', 'services', 'provinces', 'countries', 'types',  'limit_count', 'vehicle_status', 'message','Printers', 'Diagnostic', 'isMobile','userPkId'));
                            } if($vehicle->is_warning == 1){
                                $message = $this->message("info", "위반 차량입니다.");
                                return view('System.vehicle', compact('oldNumbers','vehicle', 'limits', 'services', 'provinces', 'countries', 'types',  'limit_count', 'vehicle_status', 'message','Printers', 'Diagnostic', 'isMobile','userPkId'));
                            }
                            else { 
                             //  dd($Diagnostic);
                                return view('System.vehicle', compact('oldNumbers','vehicle', 'limits', 'services', 'provinces', 'countries', 'types',  'limit_count', 'vehicle_status','Printers', 'Diagnostic', 'isMobile','userPkId'));
                            }
                        }
                    }
                }
            
                return view('System.vehicle', compact('limits', 'services', 'limit_count', 'provinces', 'countries', 'types','Printers','Diagnostic','isMobile','userPkId'));
            }

         } catch (\Exception $ex){
            $this->writeLog("차량 화면 호출 오류: ".$ex->getMessage());
            $message = $this->message("danger", "차량 화면 호출 중 오류가 발생했습니다.");
            return view('System.vehicle', [
                'message' => $message,
                'userPkId' => isset($userPkId) ? $userPkId : null,
            ]);
        }
    }
    public function vehiclePlateRecovery(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        if(!$this->checkAccess("/recovery/vehiclePlateRecovery", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        if($request->isMethod("POST")){
        try{
        //  return $request;
            $register = $request->get("customerRegister");
            $cabin = $request->get("customerOrderCabin");
            $plateNo = $request->get("plateNo");
            $userPkId = session()->get("auth")->id;
            $checkSeirTurjuram = DB::select(DB::raw("SELECT
            vrs.reg_vehicle_archive.plate_no,
            vrs.owner.last_name,
            vrs.owner.first_name,
            vrs.owner.register_no,
            vrs.reg_vehicle_archive.insert_plate_no,
            vrs.reg_vehicle.owner_id,
            vrs.owner.type_id
        FROM
            vrs.reg_vehicle
            INNER JOIN vrs.reg_vehicle_archive ON vrs.reg_vehicle.plate_no = vrs.reg_vehicle_archive.insert_plate_no
            INNER JOIN vrs.owner ON vrs.owner.id = vrs.reg_vehicle.owner_id
        WHERE
            vrs.reg_vehicle_archive.plate_no = '".$plateNo."'
            and (vrs.reg_vehicle_archive.insert_plate_no like n'%ТЖ%' or vrs.reg_vehicle_archive.insert_plate_no like n'%БХ%') ")); 
          
            if (count($checkSeirTurjuram)>0) {
                $checkSeirTurjuramdd = SeriesNumber::where("name",$plateNo)->first();
               // return $checkSeirTurjuramdd;
                $plateOrder= SeriesNumber::where("ID", $checkSeirTurjuramdd->id)->update([
                    'order_user' => $register,
                    'is_hidden' => 0,
                    'is_given' => 0,
                    'is_order'=>1,
                    'is_opened'=>1,
                    'order_cabin' => $cabin,
                    'order_date' => Carbon::now()->format("Y-m-d H:i:s"),
                    'Created_By_Id' => $userPkId,
                    'Updated_By_Id' => $userPkId
                ]);
                //return $checkSeirTurjuramdd;
                if ($plateOrder) {
                    # code...
                
              $message = $this->message("success", "번호가 성공적으로 주문되었습니다.");
              return view('System.vehicleRemoveRecovery',compact("message"));
                 
                }else{
                    $message = $this->message("danger", "해당 번호가 발급되었습니다.");
                    return view('System.vehicleRemoveRecovery',compact("message"));
                 }
            } 
        } catch(\Exception $ex){
            $this->writeLog("New vehicle transaction error: ".$ex);
        }
    }else{
        return view('System.vehicleRemoveRecovery');
    }
    }
    public  function buildCheck($owner,$isBuild)
    {

        $user = session()->get("auth")->iscity;
       // return $user;
        $ownerProv = Owner::where('id', $owner)->first();
        if ($ownerProv->province_id != 11 && ($isBuild == 0 || $isBuild == 1)) {
           return true;
        } else if ($ownerProv->province_id == 11 && $isBuild == 0) {
            return false;
        } else if ($ownerProv->province_id == 11 && $isBuild == 1 && $user == 1) {
            return true;
        }else if ($ownerProv->province_id == 11 && $isBuild == 1 && $user == 0) {
            return false;
        }
     
    }
    public function newVehicle(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $cabin_no = trim($request->get("cabin_no"));
        try{
           
            $certificate = trim($request->get("certificate"));
            if ($certificate == null || $certificate == "" ) {
                $message = $this->message("danger", "증명서 번호를 입력해 주세요.");
                                        return redirect(url('/vehicle/'.$this->enc($cabin_no).'/new'))->with("message", $message);
            } 
            $userPkId = session()->get("auth")->id;
            $plate_no = trim($request->get("number"));
            $plateColor = trim($request->get("plateColor"));
           //$certificateVal = trim($request->get("certificate"));
          //  if ($certificateVal  != null) {
          //  $certificate = trim($request->get("certificate"));
            // } else {
            //     $certificate =$this->certifcate();
            // }
            $page_count = trim($request->get("page_count"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $finger1 = trim($request->get("fingerDescription"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));

            $payDescription=trim($request->get("payDescription"));
            $payDescriptionName=trim($request->get("payDescriptionName"));
            $transactionId=trim($request->get("transactionId"));
            $payAmount=trim($request->get("payAmount"));
            $serviceTypeName=trim($request->get("serviceTypeName")); 
            $serviceTypeId=1;
            $requestCode = trim($request->get("approveCode"));
            $signed_data = trim($request->get("signed_data"));
       // return $request;
            $owner = trim($request->get("new_owner"));
            $isBuild = trim($request->get("is_build"));
           // return $isBuild;
            
           $buildCheck = $this->buildCheck($owner,$isBuild);

            $seriesCheck = SeriesNumber::where("NAME", $plate_no)->first();
            if ($buildCheck || ($seriesCheck && ($seriesCheck->series_id == 35 || $seriesCheck->series_id == 144 || $seriesCheck->series_id == 735))) {
       
            if(!$this->isDuplicate($plate_no)){
                if($this->giveNumber($plate_no, $userPkId)){
                    $vehicle = Vehicle::where("Id", $vvcabinid)->get();
                    if($vehicle->count() > 0){
                        if($this->isDuplicateCert($certificate) == 0) {
                            $vehicle = $vehicle->first();
                            $result = $this->checkAddressPlate($plate_no, $owner);
                            if (!is_array($result) && $result == true) {
                               
                                if ($this->isOrderUser($plate_no, $vehicle->id, $owner)) {
                                    if ($this->isMehanizmOrderCheck($plate_no, $vehicle->id, $owner)) {
                                        # code...
                                 
                                   //return $this->isMehanizmOrderCheck($plate_no, $vehicle->id, $owner);
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
                                              //  'ORDER_USER' => null,
                                                'IS_GIVEN' => 1,
                                                'IS_LOCAL' => 0,
                                                'LOCAL_USER_ID' => null,
                                                'VEHICLE_ID' => $vehicle->id,
                                                'UPDATED_BY_ID' => $userPkId
                                            ]);
                                            $this->epayTransaction($vehicle->id,$archive_no,$payDescription,
                                            $payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                                           // return $test;
                                            $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);

                                            $finger=$fingerDescription;
                                           
                                             if ($finger1==5) {
                                                
                                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger1,'signed_data'=>$signed_data]);
                                                $this->eRequestApprove($requestCode);
                                               }else{
                                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                                               
                                               }
                                            
                                            DB::commit();
                                            $message = $this->message("success", $cabin_no . " 차대번호 차량이 성공적으로 등록되었습니다.");
                                            return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                        } else {
                                            $message = $this->message("info", $plate_no . "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                                            return redirect(url('/vehicle/' . $this->enc($cabin_no) . '/new'))->with("message", $message);
                                        }
                                    } catch (\Exception $ex){
                                        DB::rollBack();
                                        $this->writeLog("New vehicle transaction error: ".$ex);
                                        $message = $this->message("danger", "신규 차량 등록 중 오류가 발생했습니다.");
                                        return redirect(url('/vehicle/'.$this->enc($cabin_no).'/new'))->with("message", $message);
                                    }
                                }else{
                                    $message = $this->message("info", "해당 차량은 MMA 유형 번호를 받을 수 있습니다.");
                                    return redirect(url('/vehicle/' . $this->enc($cabin_no) . '/new'))->with("message", $message);
                                }
                                } else {
                                    $message = $this->message("info", $plate_no . " 번호판 주문이 이루어지지 않았습니다.");
                                    return redirect(url('/vehicle/' . $this->enc($cabin_no) . '/new'))->with("message", $message);
                                }
                            } else {
                                if (!is_array($result) && $result == false) {
                                    $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                } else {
                                    $message = $result[1];
                                }
                                return redirect(url('/vehicle/' . $this->enc($cabin_no) . '/new'))->with("message", $message);
                            }
                        } else {
                            $message = $this->message("info", "증명서 번호가 중복됩니다.");
                            return redirect(url('/vehicle/'.$this->enc($cabin_no)."/new"))->with("message", $message);
                        }
                    } else {
                        $message = $this->message("info", $cabin_no." 차대번호 차량이 등록되지 않았습니다.");
                        return redirect(url('/vehicle'))->with("message", $message);
                    }
                } else {
                    $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                    return redirect(url('/vehicle/'.$this->enc($cabin_no)."/new"))->with("message", $message);
                }
            } else {
                $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                return redirect(url('/vehicle/'.$this->enc($cabin_no)."/new"))->with("message", $message);
            }
        }else{
            $message = $this->message("info","연식이 10년 이상이라 울란바토르시 번호판을 발급할 수 없습니다.");
            return redirect(url('/vehicle/'.$this->enc($cabin_no)."/new"))->with("message", $message);
        }
        } catch (\Exception $ex){
            $this->writeLog("New vehicle error: ".$ex);
            $message = $this->message("danger", "신규 차량 등록 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($cabin_no).'/new'))->with("message", $message);
        }
    }

    public function changeCert(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $plate_no = trim($request->get("number"));
            $certificateVal = trim($request->get("certificate"));
            if ($certificateVal  != null) {
                $certificate = trim($request->get("certificate"));
            } else {
                $certificate =$this->certifcate();
            }
            $page_count = trim($request->get("page_count"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $vehicle = Vehicle::where("Id", $vvcabinid)->get();
            $plateColor = trim($request->get("plateColor"));
            $payDescription=trim($request->get("payDescription"));
            $payDescriptionName=trim($request->get("payDescriptionName"));
            $transactionId=trim($request->get("transactionId"));
            $payAmount=trim($request->get("payAmount"));
            $serviceTypeName=trim($request->get("serviceTypeName"));
            $serviceTypeId=13;

            $ntrBookdate = trim($request->get("ntrBookdate"));
            $ntrBooknumber = trim($request->get("ntrBooknumber"));
            $ntrLastname = trim($request->get("ntrLastname"));
            $ntrFirstname = trim($request->get("ntrFirstname"));
            $ntrStateregnumber = trim($request->get("ntrStateregnumber")); 
            $ntrServiceFile = trim($request->get("ntrServiceFile"));
            $checkTorguuli = $request->checkTorguuli;
            //return $request;
            if($vehicle->count() > 0){
                if($this->isDuplicateCert($certificate) == 0){
                    $vehicle = $vehicle->first();
                    $service = $this->getActionPrefix(13);
                    $archive_number = $this->archiveNumberGenerate($service);
                    DB::beginTransaction();
                    try{
                        if($archive_number != "ERROR"){
                            $this->createArchive($vehicle->id, $service->id, $certificate, $archive_number, $plate_no, $vehicle->owner_id, $page_count, $description, $finger, $fingerDescription);

                        //    $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);
                            Vehicle::where("PLATE_NO", $plate_no)->update([
                                'CERTIFICATE_NO' => $certificate,
                                'PAGE_COUNT' => $page_count,
                                'ARCHIVE_NO' => $archive_number,
                                'IS_PENDING' => 0,
                                'STATUS' => 13,
                                'UPDATED_BY' => $userPkId
                            ]);
                            DB::commit();
                           
                            $this->epayTransaction($vehicle->id,$archive_number,$payDescription,
                            $payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                           // session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);

                            if ($ntrBookdate !="") {
                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'ntrBookdate'=>$ntrBookdate,'ntrServiceFile'=>$ntrServiceFile,
                                'ntrBooknumber'=>$ntrBooknumber, 'ntrLastname'=>$ntrLastname,'ntrFirstname'=>$ntrFirstname,'ntrStateregnumber'=>$ntrStateregnumber]);
                            }else{
                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli]);
                            }
                            $message = $this->message("success", "증명서 교체가 성공적으로 처리되었습니다.");
                        } else {
                            $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                        }
                    } catch (\Exception $ex){
                        DB::rollBack();
                        $this->writeLog("Change cert transaction error: ".$ex->getMessage());
                        $message = $this->message("danger", "증명서 교체 중 오류가 발생했습니다.");
                        return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                    }
                } else {
                    $message = $this->message("info", "증명서 번호가 중복됩니다.");
                }
            } else {
                $message = $this->message("info", "증명서 교체할 차량을 찾을 수 없습니다.");
            }
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Change cert error: ".$ex->getMessage());
            $message = $this->message("danger", "증명서 교체 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function againCert(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $plate_no = trim($request->get("number"));
            $certificateVal = trim($request->get("certificate"));
            if ($certificateVal  != null) {
                $certificate = trim($request->get("certificate"));
            } else {
                $certificate =$this->certifcate();
            }
            $page_count = trim($request->get("page_count"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $vehicle = Vehicle::where("ID", $vvcabinid)->get();
            $checkTorguuli = $request->checkTorguuli;
            $payDescription=trim($request->get("payDescription"));
            $payDescriptionName=trim($request->get("payDescriptionName"));
            $transactionId=trim($request->get("transactionId"));
            $payAmount=trim($request->get("payAmount"));
            $serviceTypeName=trim($request->get("serviceTypeName"));
            $serviceTypeId=2;

            $ntrBookdate = trim($request->get("ntrBookdate"));
            $ntrBooknumber = trim($request->get("ntrBooknumber"));
            $ntrLastname = trim($request->get("ntrLastname"));
            $ntrFirstname = trim($request->get("ntrFirstname"));
            $ntrStateregnumber = trim($request->get("ntrStateregnumber")); 
            $ntrServiceFile = trim($request->get("ntrServiceFile"));
            if($vehicle->count() > 0){
                if($this->isDuplicateCert($certificate) == 0) {
                    $vehicle = $vehicle->first();
                    $service = $this->getActionPrefix(2);
                    $archive_number = $this->archiveNumberGenerate($service);
                    DB::beginTransaction();
                    try{
                        if($archive_number != "ERROR"){
                            $this->createArchive($vehicle->id, $service->id, $certificate, $archive_number, $plate_no, $vehicle->owner_id, $page_count, $description, $finger, $fingerDescription);
                            Vehicle::where("ID", $vehicle->id)->update([
                                'CERTIFICATE_NO' => $certificate,
                                'PAGE_COUNT' => $page_count,
                                'ARCHIVE_NO' => $archive_number,
                                'IS_PENDING' => 0,
                                'STATUS' => 2,
                                'UPDATED_BY' => $userPkId
                            ]);
                            $this->epayTransaction($vehicle->id,$archive_number,$payDescription,
                            $payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                            //session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                            if ($ntrBookdate !="") {
                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'ntrBookdate'=>$ntrBookdate,'ntrServiceFile'=>$ntrServiceFile,
                                'ntrBooknumber'=>$ntrBooknumber, 'ntrLastname'=>$ntrLastname,'ntrFirstname'=>$ntrFirstname,'ntrStateregnumber'=>$ntrStateregnumber]);
                            }else{
                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli]);
                            }
                            $message = $this->message("success", "증명서 재발급이 성공적으로 처리되었습니다.");
                            DB::commit();
                        } else {
                            $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                        }
                    } catch (\Exception $ex){
                        DB::rollBack();
                        $this->writeLog("Again cert transaction error: ".$ex->getMessage());
                        $message = $this->message("danger", "증명서 재발급 중 오류가 발생했습니다.");
                        return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                    }
                }else {
                    $message = $this->message("info", "증명서 번호가 중복됩니다.");
                }
            } else {
                $message = $this->message("info", "증명서 재발급할 차량을 찾을 수 없습니다.");
            }
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Again cert error: ".$ex->getMessage());
            $message = $this->message("danger", "증명서 재발급 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }
public  function changePlateBuildCheck($isBuild,$prov)
{
    if ($isBuild == 1 && $prov == 11) {
        return true;
    } else if($isBuild == 0 && $prov == 11){
       return false;
    }else if($prov != 11 && ($isBuild == 0 || $isBuild == 1)){
        return true;
     }
}
    public function changePlate(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $plate_no = trim($request->get("number"));
            $plate_old_no = $this->dec(trim($request->get("current_plate")));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $certificateVal = trim($request->get("certificate"));
            if ($certificateVal  != null) {
                $certificate = trim($request->get("certificate"));
            } else {
                $certificate =$this->certifcate();
            }
            $plateColor = trim($request->get("plateColor"));
            $page_count = trim($request->get("page_count"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $checkTorguuli = $request->checkTorguuli;
            $payDescription=trim($request->get("payDescription"));
            $payDescriptionName=trim($request->get("payDescriptionName"));
            $transactionId=trim($request->get("transactionId"));
            $payAmount=trim($request->get("payAmount"));
            $serviceTypeName=trim($request->get("serviceTypeName"));
            $serviceTypeId=15;
            $ntrBookdate = trim($request->get("ntrBookdate"));
            $ntrBooknumber = trim($request->get("ntrBooknumber"));
            $ntrLastname = trim($request->get("ntrLastname"));
            $ntrFirstname = trim($request->get("ntrFirstname"));
            $ntrStateregnumber = trim($request->get("ntrStateregnumber")); 
            $ntrServiceFile = trim($request->get("ntrServiceFile"));

            $isBuild  = trim($request->get("is_build"));

            $getOwner = Vehicle::where('Id',$vvcabinid)->first();
            $owner = Owner::where('id',$getOwner->owner_id)->first();
           // return $owner->province_id;
            //  return $request;
           $buildCheck = $this->changePlateBuildCheck($isBuild,$owner->province_id );
          //  return $this->changePlateBuildCheck($isBuild,$owner->province_id );
           // if ($buildCheck) {
            if($plate_no != $plate_old_no) {
                if(!$this->isDuplicate($plate_no)){
                    if($this->giveNumber($plate_no, $userPkId)){
                        $vehicle = Vehicle::where("Id", $vvcabinid)->get();
                        if ($vehicle->count() > 0) {
                            if($this->isDuplicateCert($certificate) == 0){
                                $vehicle = $vehicle->first();
                                $result = $this->checkAddressPlate($plate_no, $vehicle->owner_id);
                                if(!is_array($result) && $result == true) {
                                  // dd( $this->isOrderUser($plate_no, $vehicle->id, $vehicle->owner_id));
                                    if($this->isOrderUser($plate_no, $vehicle->id, $vehicle->owner_id)){
                                    // dd( $this->isMehanizmOrderCheck($plate_no, $vehicle->id,"owner"));
                                        if ($this->isMehanizmOrderCheck($plate_no, $vehicle->id,"owner")) {
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
                                                   // 'IS_ORDER' => 0,
                                                   // 'ORDER_USER' => null,
                                                    'IS_GIVEN' => 0,
                                                    'IS_LOCAL' => 0,
                                                    'LOCAL_USER_ID' => null,
                                                    'VEHICLE_ID' => null,
                                                    'SHOW_DATE' => $show_date,
                                                    'UPDATED_BY_ID' => $userPkId
                                                ]);
                                                $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);
                                                $this->epayTransaction($vehicle->id,$archive_number,$payDescription,
                                                $payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                                               // session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                                               if ($ntrBookdate !="") {
                                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'ntrBookdate'=>$ntrBookdate,'ntrServiceFile'=>$ntrServiceFile,
                                                'ntrBooknumber'=>$ntrBooknumber, 'ntrLastname'=>$ntrLastname,'ntrFirstname'=>$ntrFirstname,'ntrStateregnumber'=>$ntrStateregnumber]);
                                            }else{
                                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli]);
                                            }
                                                $message = $this->message("success", "번호판이 성공적으로 교체되었습니다.");
                                                DB::commit();
                                            } else {
                                                $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                                            }
                                        } catch (\Exception $ex){
                                            DB::rollBack();
                                            $this->writeLog("Change plate transaction error: ".$ex->getMessage());
                                            $message = $this->message("danger", "번호판 교체 처리 중 오류가 발생했습니다.");
                                            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                        }
                                    }else{
                                        $message = $this->message("info", "해당 차량은 MMA 유형 번호를 받을 수 있습니다.");
                                        return redirect(url('/vehicle/'.$this->enc($plate_old_no)))->with("message", $message);
                                    }
                                    } else {
                                        $message = $this->message("info", $plate_no." 번호판 주문이 이루어지지 않았습니다.");
                                        $plate_no = $plate_old_no;
                                    }
                                } else {
                                    if(!is_array($result) && $result == false){
                                        $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                    } else {
                                        $message = $result[1];
                                    }
                                    $plate_no = $plate_old_no;
                                }
                            } else {
                                $message = $this->message("info", "증명서 번호가 중복됩니다.");
                            }
                        } else {
                            $message = $this->message("info", "번호판 교체할 차량을 찾을 수 없습니다.");
                        }
                    } else {
                        $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                        $plate_no = $plate_old_no;
                    }
                } else {
                    $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                    $plate_no = $plate_old_no;
                }
            } else {
                $message = $this->message("info", "교체할 번호판을 이미 차량이 사용 중입니다.");
            }
        // }else{
        //     $message = $this->message("info", "연식이 10년 이상이라 울란바토르 번호판 교체가 불가능합니다.");
        // }
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Change plate error: ".$ex->getMessage());
            $message = $this->message("danger", "번호판 교체 처리 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function restorePlate(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $plate_no = trim($request->get("number"));
            $plate_old_no = $this->dec(trim($request->get("current_plate")));
            $certificateVal = trim($request->get("certificate"));
            if ($certificateVal  != null) {
                $certificate = trim($request->get("certificate"));
            } else {
                $certificate =$this->certifcate();
            }
            $page_count = trim($request->get("page_count"));
            $plateColor = trim($request->get("plateColor"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $owner = trim($request->get("new_owner"));
            $restoreStatusCheck = trim($request->get("restoreStatusCheck"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $vehicleCheck = Vehicle::where("plate_no", $plate_no)->first();
         //dd($restoreStatusCheck);
            if ($restoreStatusCheck === "" && $vehicleCheck['status'] === "10") {
                $message = $this->message("info", "아카이브ын 유형 선택하지 않은 입니다.");
                                                return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
            }
            if ($vehicleCheck['status'] === "10" ) {
              //  if(!$this->isDuplicate($plate_no)){
                  //  if($this->giveNumber($plate_no, $userPkId)){
if ($restoreStatusCheck === "1") {
    $vehicle = Vehicle::where("Id", $vvcabinid)->get();
                        if($vehicle->count() > 0){
                            if($this->isDuplicateCert($certificate) == 0) {
                                $vehicle = $vehicle->first();
                                $service = $this->getActionPrefix(19);
                                $old_owner_id = $vehicle->owner_id;
                                $province = $this->getUserProvincePkId($owner);
                                $result = $this->checkAddressPlate($plate_no, $owner);
                                if (!is_array($result) && $result == true) {
                                  //  if ($this->isOrderUser($plate_no, $vehicle->id, $owner)) {
                                        $archive_no = $this->archiveNumberGenerate($service);
                                        DB::beginTransaction();
                                        try{
                                            if($archive_no != "ERROR"){
                                                $this->createArchive($vehicle->id, $service->id, $certificate, $archive_no, $plate_no, $owner, $page_count, $description, $finger, $fingerDescription);
                                                $this->createOwnerShip($owner, $old_owner_id, $vehicle->id, 14);
                                               
                                                Vehicle::where("Id", $vehicle->id)->update([
                                                    'PLATE_NO' => $plate_no,
                                                    'CERTIFICATE_NO' => $certificate,
                                                    'PAGE_COUNT' => $page_count,
                                                    'OWNER_ID' => $owner,
                                                    'PROVINCE_ID' => $province,
                                                    'ARCHIVE_NO' => $archive_no,
                                                    'IS_PENDING' => 0,
                                                    'STATUS' => 19, 
                                                    'UPDATED_BY' => $userPkId
                                                ]);
                                               
                                                $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);
                                                $message = $this->message("success", "말소된 차량이 성공적으로 복구되었습니다.");
                                                DB::commit();
                                                return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                            } else {
                                                $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                                                return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                            }
                                        } catch (\Exception $ex){
                                            DB::rollBack();
                                           // return $ex;
                                            $this->writeLog("Restore plate transaction error: ".$ex);
                                            $message = $this->message("danger", "말소 차량 복구 중 오류가 발생했습니다.");
                                            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                        }
                                    // } else {
                                    //     $message = $this->message("info", $plate_no . " 번호판 주문이 이루어지지 않았습니다.");
                                    //     $plate_no = $plate_old_no;
                                    //     return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                    // }
                                } else {
                                    if (!is_array($result) && $result == false) {
                                        $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                    } else {
                                        $message = $result[1];
                                    }
                                    $plate_no = $plate_old_no;
                                    return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                }
                            } else {
                                $message = $this->message("info", "증명서 번호가 중복됩니다.");
                                $plate_no = $plate_old_no;
                            }
                        } else {
                            $message = $this->message("info", "복구할 차량을 찾을 수 없습니다.");
                            $plate_no = $plate_old_no;
                            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                        }
                    // } else {
                    //     $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                    //     $plate_no = $plate_old_no;
                    // }
              
                return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
               // return $vehicleCheck->status;

} else {
    $vehicle = Vehicle::where("Id", $vvcabinid)->get();
                        if($vehicle->count() > 0){
                          //  if($this->isDuplicateCert($certificate) == 0) {
                                $vehicle = $vehicle->first();
                                $service = $this->getActionPrefix(19);
                                $old_owner_id = $vehicle->owner_id;
                                $province = $this->getUserProvincePkId($owner);
                                $result = $this->checkAddressPlate($plate_no, $owner);
                                if (!is_array($result) && $result == true) {
                                  //  if ($this->isOrderUser($plate_no, $vehicle->id, $owner)) {
                                       // $archive_no = $this->archiveNumberGenerate($service);
                                        DB::beginTransaction();
                                        try{
                                          //  if($archive_no != "ERROR"){
                                             //   $this->createArchive($vehicle->id, $service->id, $certificate, $archive_no, $plate_no, $owner, $page_count, $description, $finger, $fingerDescription);
                                                $this->createOwnerShip($owner, $old_owner_id, $vehicle->id, 14);
                                               
                                                Vehicle::where("Id", $vehicle->id)->update([
                                                    'PLATE_NO' => $plate_no,
                                                 //   'CERTIFICATE_NO' => $certificate,
                                                    'PAGE_COUNT' => $page_count,
                                                    'OWNER_ID' => $owner,
                                                    'PROVINCE_ID' => $province,
                                                   // 'ARCHIVE_NO' => $archive_no,
                                                    'IS_PENDING' => 0,
                                                    'STATUS' => 19, 
                                                    'UPDATED_BY' => $userPkId
                                                ]);
                                               
                                                $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);
                                                $message = $this->message("success", "말소된 차량이 성공적으로 복구되었습니다.");
                                                DB::commit();
                                                return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                            // } else {
                                            //     $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                                            //     return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                            // }
                                        } catch (\Exception $ex){
                                            DB::rollBack();
                                           // return $ex;
                                            $this->writeLog("Restore plate transaction error: ".$ex);
                                            $message = $this->message("danger", "말소 차량 복구 중 오류가 발생했습니다.");
                                            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                        }
                                    // } else {
                                    //     $message = $this->message("info", $plate_no . " 번호판 주문이 이루어지지 않았습니다.");
                                    //     $plate_no = $plate_old_no;
                                    //     return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                    // }
                                } else {
                                    if (!is_array($result) && $result == false) {
                                        $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                    } else {
                                        $message = $result[1];
                                    }
                                    $plate_no = $plate_old_no;
                                    return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                }
                            // } else {
                            //     $message = $this->message("info", "증명서 번호가 중복됩니다.");
                            //     $plate_no = $plate_old_no;
                            // }
                        } else {
                            $message = $this->message("info", "복구할 차량을 찾을 수 없습니다.");
                            $plate_no = $plate_old_no;
                            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                        }
                    // } else {
                    //     $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                    //     $plate_no = $plate_old_no;
                    // }
              
               // return $vehicleCheck->status;

}

                       
            }else{
              
                if($plate_no != $plate_old_no ){
                    
                    if(!$this->isDuplicate($plate_no)){
                        if($this->giveNumber($plate_no, $userPkId)){
                            $vehicle = Vehicle::where("Id", $vvcabinid)->get();
                            if($vehicle->count() > 0){
                                if($this->isDuplicateCert($certificate) == 0) {
                                    $vehicle = $vehicle->first();
                                    $service = $this->getActionPrefix(19);
                                    $old_owner_id = $vehicle->owner_id;
                                    $province = $this->getUserProvincePkId($owner);
                                    $result = $this->checkAddressPlate($plate_no, $owner);
                                   
                                    if (!is_array($result) && $result == true) {
                                        if ($this->isOrderUser($plate_no, $vehicle->id, $owner)) {
                                            $archive_no = $this->archiveNumberGenerate($service);
                                            DB::beginTransaction();
                                          
                                            try{
                                               
                                                if($archive_no != "ERROR"){
                                                    $this->createArchive($vehicle->id, $service->id, $certificate, $archive_no, $plate_no, $owner, $page_count, $description, $finger, $fingerDescription);
                                                    $this->createOwnerShip($owner, $old_owner_id, $vehicle->id, 14);
                                                    Vehicle::where("Id", $vehicle->id)->update([
                                                        'PLATE_NO' => $plate_no,
                                                        'CERTIFICATE_NO' => $certificate,
                                                        'PAGE_COUNT' => $page_count,
                                                        'OWNER_ID' => $owner,
                                                        'PROVINCE_ID' => $province,
                                                        'ARCHIVE_NO' => $archive_no,
                                                        'IS_PENDING' => 0,
                                                        'STATUS' => 19,
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
    
                                                    SeriesNumber::where("NAME", $plate_old_no)->update([
                                                        'IS_ORDER' => 0,
                                                      //  'ORDER_USER' => null,
                                                        'IS_GIVEN' => 0,
                                                        'IS_LOCAL' => 0,
                                                        'LOCAL_USER_ID' => null,
                                                        'VEHICLE_ID' => null,
                                                        'UPDATED_BY_ID' => $userPkId
                                                    ]);
                                                    $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);
                                                    $message = $this->message("success", "말소된 차량이 성공적으로 복구되었습니다.");
                                                    DB::commit();
                                                    return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                                } else {
                                                    $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                                                    return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                                }
                                            } catch (\Exception $ex){
                                                DB::rollBack();
                                                $this->writeLog("Restore plate transaction error: ".$ex);
                                                $message = $this->message("danger", "말소 차량 복구 중 오류가 발생했습니다.");
                                                return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                            }
                                        } else {
                                            $message = $this->message("info", $plate_no . " 번호판 주문이 이루어지지 않았습니다.");
                                            $plate_no = $plate_old_no;
                                            return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                        }
                                    } else {
                                        if (!is_array($result) && $result == false) {
                                            $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                        } else {
                                            $message = $result[1];
                                        }
                                        $plate_no = $plate_old_no;
                                        return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                    }
                                } else {
                                    $message = $this->message("info", "증명서 번호가 중복됩니다.");
                                    $plate_no = $plate_old_no;
                                }
                            } else {
                                $message = $this->message("info", "복구할 차량을 찾을 수 없습니다.");
                                $plate_no = $plate_old_no;
                                return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                            }
                        } else {
                            $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                            $plate_no = $plate_old_no;
                        }
                    } else {
                        $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                        $plate_no = $plate_old_no;
                    }
                    return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                } else {
                    $message = $this->message("info", "번호판이 교체되지 않았습니다.");
                    return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                }
            }

           
        } catch (\Exception $ex){
            $this->writeLog("Restore plate error: ".$ex);
            $message = $this->message("danger", "말소 차량 복구 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    // public function checkPlateTwo($plate_one,$plate_two){

    //     $vehicle_one = DB::table("REG_VEHICLE")->where("plate_no", $plate_one)->get()->first();
    //     $vehicle_two = DB::table("REG_VEHICLE")->where("plate_no", $plate_two)->get()->first();
    //    // return $vehicle_one->province_id;
    //     if ($vehicle_one->province_id == $vehicle_two->province_id) {
    //        return true;
    //     } else {
    //        return false;
    //     }
        
    //    // return $vehicle->province_id;

    // }
    public function checkPlateTwo($plate_one,$plate_two){

        $vehicle_one = DB::table("REG_VEHICLE_VIEW")->where("plate_no", $plate_one)->get()->first();
        $vehicle_two = DB::table("REG_VEHICLE_VIEW")->where("plate_no", $plate_two)->get()->first();
       // return $vehicle_one->province_id;
       if (session()->get('auth')->iscity == 1) {
        if ($vehicle_one->owner_province_id == $vehicle_two->owner_province_id) {
            return true;
         } else {
            return false;
         }
       }elseif(session()->get('auth')->isatvt == 1){
            if($vehicle_one->owner_province_id != 11 && $vehicle_two->owner_province_id !=11){
                return true;
            }else{
                return false;
            }
      
       }
     
        
       // return $vehicle->province_id;

    }
    public function changePlateTwo(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        DB::beginTransaction();
        try{
           // return $request;
            $userPkId = session()->get("auth")->id;
            $plate_one = trim($request->get("change_plate1_number"));
            $plate_two = trim($request->get("change_plate2_number"));
           $check= $this->checkPlateTwo($plate_one,$plate_two);
          // return $check;
           if ($check) {
            if($plate_one != $plate_two) {
                $vehicle_one = Vehicle::where("PLATE_NO", $plate_one)->get();
                $vehicle_two = Vehicle::where("PLATE_NO", $plate_two)->get();
                if ($vehicle_one->count() > 0 && $vehicle_two->count() > 0) {
                    $vehicle_one = $vehicle_one->first();
                    $vehicle_two = $vehicle_two->first();

                  // return  $result_one;
                    $result_one = $this->checkAddressPlate($plate_one, $vehicle_one->owner_id);
                    $result_two = $this->checkAddressPlate($plate_two, $vehicle_two->owner_id);
                   // return  $result_one;
                    if(!is_array($result_one) && $result_one == true && !is_array($result_two) && $result_two == true) {
                        $limit_count_one = RegLimited::where("VEHICLE_ID", $vehicle_one->id)->where("IS_RESTORED", 0)->get()->count();
                        $limit_count_two = RegLimited::where("VEHICLE_ID", $vehicle_two->id)->where("IS_RESTORED", 0)->get()->count();

                       
                        if(($limit_count_one + $limit_count_two) == 0){
                            $service = $this->getActionPrefix(16);
                           
                           // $archive_no = $this->archiveNumberGenerate($service);
                           
                           // $vehicle_two->archive_no
                           //$vehicle_one->archive_no
                          //  return $archive_no2;
                            $this->createArchive($vehicle_one->id, $service->id, $vehicle_one->cetificate_no,$vehicle_one->archive_no, $plate_two, $vehicle_one->owner_id, 0, "", 0, "");
                            $this->createArchive($vehicle_two->id, $service->id, $vehicle_two->cetificate_no,$vehicle_two->archive_no, $plate_one, $vehicle_two->owner_id, 0, "", 0, "");

                            Vehicle::where("Id", $vehicle_one->id)->update([
                                'PLATE_NO' => $plate_two,
                                'STATUS' => 16,
                               
                                'UPDATED_BY' => $userPkId
                            ]);

                            Vehicle::where("Id", $vehicle_two->id)->update([
                                'PLATE_NO' => $plate_one,
                             
                                'STATUS' => 16,
                                'UPDATED_BY' => $userPkId
                            ]);

                            SeriesNumber::where("NAME", $plate_one)->update([
                                'VEHICLE_ID' => $vehicle_two->id,
                                'UPDATED_BY_ID' => $userPkId
                            ]);

                            SeriesNumber::where("NAME", $plate_two)->update([
                                'VEHICLE_ID' => $vehicle_one->id,
                                'UPDATED_BY_ID' => $userPkId
                            ]);
                            DB::commit();
                            $message = $this->message("success", "번호판이 성공적으로 교체되었습니다.");
                        } else {
                            $message = $this->message("info", "차량 중 하나에 제한이 있습니다.");
                        }
                    } else {
                        if(!is_array($result_one) && $result_one == false){
                            $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                        } else {
                            $message = $result_one[1];
                        }
                    }
                } else {
                    $message = $this->message("info", "번호판 교체할 차량을 찾을 수 없습니다.");
                }
            } else {
                $message = $this->message("info", "교체할 번호판들이 동일합니다.");
            }
        }else{
             $message = $this->message("danger", "차량들의 소속이 일치하지 않습니다.");
           }
            return redirect(url('/vehicle'))->with("message", $message);
        } catch (\Exception $ex){
            DB::rollBack();
            $this->writeLog("Change plate two error: ".$ex->getMessage());
            $message = $this->message("danger", "번호판 교체 중 오류가 발생했습니다.");
            return redirect(url('/vehicle'))->with("message", $message);
        }
    }

    public function editVehicle(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        DB::beginTransaction();
        try{
            $userPkId = session()->get("auth")->id;
            $plate_no = trim($request->get("number"));
            $plate_old_no = $this->dec(trim($request->get("current_plate")));
            $certificateVal = trim($request->get("certificate"));
            if ($certificateVal  != null) {
                $certificate = trim($request->get("certificate"));
            } else {
                $certificate =$this->certifcate();
            }
            $importdate = trim($request->get("importdate"));
            $build_year = trim($request->get("build_year"));
            $build_month = trim($request->get("build_month"));
            $page_count = trim($request->get("page_count"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            if($plate_no == $plate_old_no){
                $vehicle = Vehicle::where("ID", $vvcabinid)->get();
                if($vehicle->count() > 0){
                    $vehicle = $vehicle->first();
                    $service = $this->getActionPrefix(8);
                    $this->createArchive($vehicle->id, $service->id, $certificate, $vehicle->archive_no, $plate_old_no, $vehicle->owner_id, $page_count, $description, $finger, $fingerDescription);
                    Vehicle::where("Id", $vehicle->id)->update([
                        'CERTIFICATE_NO' => $certificate,
                        'PAGE_COUNT' => $page_count,
                        'BUILD_YEAR' => $build_year,
                        'BUILD_MONTH' => $build_month,
                        'IMPORT_DATE' => $importdate,
                        'IS_PENDING' => 0,
                        'STATUS' => 8,
                        'UPDATED_BY' => $userPkId
                    ]);
                    DB::commit();
                    $message = $this->message("success", "차량 정보가 성공적으로 수정되었습니다.");
                } else {
                    $message = $this->message("info", "수정лах 차량 찾을 수 없습니다.");
                }
                return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
            } else {
                if(!$this->isDuplicate($plate_no)){
                    if($this->giveNumber($plate_no, $userPkId)){
                        $vehicle = Vehicle::where("PLATE_NO", $plate_old_no)->get();
                        if($vehicle->count() > 0){
                            $vehicle = $vehicle->first();
                            $result = $this->checkAddressPlate($plate_no, $vehicle->owner_id);
                            if (!is_array($result) && $result == true) {
                                if ($this->isOrderUser($plate_no, $vehicle->id, $vehicle->owner_id)) {
                                    $service = $this->getActionPrefix(8);
                                    $this->createArchive($vehicle->id, $service->id, $certificate, $vehicle->archive_no, $plate_old_no, $vehicle->owner_id, $page_count, $description, $finger, $fingerDescription);
                                    Vehicle::where("Id", $vehicle->id)->update([
                                        'PLATE_NO' => $plate_no,
                                        'CERTIFICATE_NO' => $certificate,
                                        'PAGE_COUNT' => $page_count,
                                        'BUILD_YEAR' => $build_year,
                                        'BUILD_MONTH' => $build_month,
                                        'IMPORT_DATE' => $importdate,
                                        'IS_PENDING' => 0,
                                        'STATUS' => 8,
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

                                    $show_date = $this->checkLuckyPlate($plate_old_no, 2);
                                    SeriesNumber::where("NAME", $plate_old_no)->update([
                                        'IS_ORDER' => 0,
                                     //   'ORDER_USER' => null,
                                        'IS_GIVEN' => 0,
                                        'IS_LOCAL' => 0,
                                        'LOCAL_USER_ID' => null,
                                        'VEHICLE_ID' => null,
                                        'SHOW_DATE' => $show_date,
                                        'UPDATED_BY_ID' => $userPkId
                                    ]);
                                    DB::commit();
                                    $message = $this->message("success", "차량 정보가 성공적으로 수정되었습니다.");
                                } else {
                                    $message = $this->message("info", $plate_no . " 번호판 주문이 이루어지지 않았습니다.");
                                    $plate_no = $plate_old_no;
                                }
                            } else {
                                if (!is_array($result) && $result == false) {
                                    $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                } else {
                                    $message = $result[1];
                                }
                                $plate_no = $plate_old_no;
                            }
                        } else {
                            $message = $this->message("info", "수정лах 차량 찾을 수 없습니다.");
                        }

                    } else {
                        $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                        $plate_no = $plate_old_no;
                    }
                } else {
                    $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                    $plate_no = $plate_old_no;
                }
                return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
            }
        } catch (\Exception $ex){
            DB::rollBack();
            $this->writeLog("Vehicle edit error: ".$ex->getMessage());
            $message = $this->message("danger", "차량 정보 수정 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function moveOwnerVehiclePlate(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
     
            $userPkId = session()->get("auth")->id;
            $plate_no = trim($request->get("number"));
            $plate_old_no = $this->dec(trim($request->get("current_plate")));
            $certificateVal = trim($request->get("certificate"));
            if ($certificateVal  != null) {
                $certificate = trim($request->get("certificate"));
            } else {
                $certificate =$this->certifcate();
            }
            $page_count = trim($request->get("page_count"));
            $plateColor = trim($request->get("plateColor"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription")); 
            $finger = trim($request->get("fingerDescription"));
           
            $owner = trim($request->get("new_owner"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $checkTorguuli = $request->checkTorguuli;
            $payDescription=trim($request->get("payDescription"));
            $payDescriptionName=trim($request->get("payDescriptionName"));
            $transactionId=trim($request->get("transactionId"));
            $payAmount=trim($request->get("payAmount"));
            $serviceTypeName=trim($request->get("serviceTypeName"));
            $serviceTypeId=14;
            $ntrBookdate = trim($request->get("ntrBookdate"));
            $ntrBooknumber = trim($request->get("ntrBooknumber"));
            $ntrLastname = trim($request->get("ntrLastname"));
            $ntrFirstname = trim($request->get("ntrFirstname"));
            $ntrStateregnumber = trim($request->get("ntrStateregnumber")); 
            $ntrServiceFile = trim($request->get("ntrServiceFile"));
            $requestCode = trim($request->get("approveCode"));
            $signed_data = trim($request->get("signed_data"));
            $isBuild  = trim($request->get("is_build"));
           // return $isBuild;
           if ($this->buildCheck($owner,$isBuild)) {
           
           
           
            //buildCheck
            if($plate_no != $plate_old_no ){
                if(!$this->isDuplicate($plate_no)){
                    if($this->giveNumber($plate_no, $userPkId)){
                        $vehicle = Vehicle::where("Id", $vvcabinid)->get();
                        $vehOwner_id=(int)$vehicle[0]->owner_id;
                        $vehOwner1_id=(int)$vehicle[0]->owner1_id;
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
                              // dd($this->getEsignReqCheck($vehicle->id, $owner));
                                if($this->getEsignReqCheck($vehicle->id, $owner)) {
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
                                                        //'ORDER_USER' => null,
                                                        'IS_GIVEN' => 1,
                                                        'IS_LOCAL' => 0,
                                                        'LOCAL_USER_ID' => null,
                                                        'VEHICLE_ID' => $vehicle->id,
                                                        'UPDATED_BY_ID' => $userPkId
                                                    ]);

                                                    $show_date = $this->checkLuckyPlate($plate_old_no, 2);
                                                    SeriesNumber::where("NAME", $plate_old_no)->update([
                                                    // 'IS_ORDER' => 0,
                                                       // 'ORDER_USER' => null,
                                                        'IS_GIVEN' => 0,
                                                        'IS_LOCAL' => 0,
                                                        'LOCAL_USER_ID' => null,
                                                        'VEHICLE_ID' => null, 
                                                        'SHOW_DATE' => $show_date,
                                                        'UPDATED_BY_ID' => $userPkId
                                                    ]);

                                                    $this->createPrintPlate($plate_no, $service->id, $userPkId,$plateColor);
                                                    $this->epayTransaction($vehicle->id,$archive_no,$payDescription,
                                                    $payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);
                                                    $finger=$fingerDescription;
                                                    

                                                   // session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                                                   if ($ntrBookdate !="") {
                                                    session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'ntrBookdate'=>$ntrBookdate,'ntrServiceFile'=>$ntrServiceFile,
                                                    'ntrBooknumber'=>$ntrBooknumber, 'ntrLastname'=>$ntrLastname,'ntrFirstname'=>$ntrFirstname,'ntrStateregnumber'=>$ntrStateregnumber]);
                                                }else{
                                                    if ($finger==5) {
                                                        $this->eRequestApprove($requestCode);
                                                        session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'signed_data'=>$signed_data]);
                                                           # code...
                                                       }else{
                                                        session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli]);
                                                       }
                                                   
                                                }
                                                   $message = $this->message("success", "번호판 교체 및 명의이전이 완료되었습니다.");
                                                    DB::commit();
                                                    return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                                } else {
                                                    $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                                                    return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                                }
                                            } catch (\Exception $ex){
                                                DB::rollBack();
                                                $this->writeLog("Change plate transaction error: ".$ex);
                                                $message = $this->message("danger", "번호판 교체 이전 처리 중 오류가 발생했습니다.");
                                                $plate_no = $plate_old_no;
                                                return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                            }
                                        } else {
                                            $message = $this->message("info", $plate_no . " 번호판 주문이 이루어지지 않았습니다.");
                                            $plate_no = $plate_old_no;
                                            return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                        }
                                    } else {
                                        if (!is_array($result) && $result == false) {
                                            $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                                        } else {
                                            $message = $result[1];
                                        }
                                        $plate_no = $plate_old_no;
                                        return redirect(url('/vehicle/' . $this->enc($plate_no)))->with("message", $message);
                                    }
                                } else {
                                    $message = $this->message("info", "차량의 현재 및 새 소유자 소속이 동일합니다.");
                                    $plate_no = $plate_old_no;
                                }



                            } else {
                                $message = $this->message("info",  "소유자가 전자명으로 다른 소유자에게 이전을 요청했습니다.");
                                $plate_no = $plate_old_no;
                            }

                            } else {
                                $message = $this->message("info", "증명서 번호가 중복됩니다.");
                                $plate_no = $plate_old_no;
                            }
                        } else {
                            $message = $this->message("info", "번호판 교체 및 명의이전할 차량을 찾을 수 없습니다.");
                            $plate_no = $plate_old_no;
                            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                        }
                    } else {
                        $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                        $plate_no = $plate_old_no;
                    }
                } else {
                    $message = $this->message("info", $plate_no." 번호판이 다른 차량에서 사용 중입니다.");
                    $plate_no = $plate_old_no;
                }
                return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message); 
            } else {
                $message = $this->message("info", "번호판이 교체되지 않았습니다.");
                return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
            }
        }else{
            $message = $this->message("info", "연식이 10년 이상이라 울란바토르시 번호판을 발급할 수 없습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
           }
        } catch (\Exception $ex){
            $this->writeLog("Change plate error: ".$ex);
            $message = $this->message("danger", "번호판 교체 이전 처리 중 오류가 발생했습니다.");
            $plate_no = $plate_old_no;
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function moveOwnerVehicle(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $plate_no = trim($request->get("number"));
        try{

             $checkTorguuli = $request->checkTorguuli;
            // return $checkTorguuli;
        // return $request;
            $userPkId = session()->get("auth")->id;

         
         
            $certificateVal = trim($request->get("certificate"));
            if ($certificateVal  != null) {
                $certificate = trim($request->get("certificate"));
            } else {
                $certificate =$this->certifcate();
            }
            $page_count = trim($request->get("page_count"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $owner = trim($request->get("new_owner"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $vehicle = Vehicle::where("ID", $vvcabinid)->get();
            

            $payDescription=trim($request->get("payDescription"));
            $payDescriptionName=trim($request->get("payDescriptionName"));
            $transactionId=trim($request->get("transactionId"));
            $payAmount=trim($request->get("payAmount"));
            $serviceTypeName=trim($request->get("serviceTypeName"));
            $serviceTypeId=3;
            $ntrBookdate = trim($request->get("ntrBookdate"));
            $ntrBooknumber = trim($request->get("ntrBooknumber"));
            $ntrLastname = trim($request->get("ntrLastname"));
            $ntrFirstname = trim($request->get("ntrFirstname"));
            $ntrAddress = trim($request->get("ntraddress"));
            $ntrPhone = trim($request->get("ntrPhone"));
            $ntrStateregnumber = trim($request->get("ntrStateregnumber"));
             $ntrServiceFile = trim($request->get("ntrServiceFile"));
             $requestCode = trim($request->get("approveCode"));
             $signed_data = trim($request->get("signed_data"));
           
        
            $vehOwner_id=(int)$vehicle[0]->owner_id;
            $vehOwner1_id=(int)$vehicle[0]->owner1_id;
            if ($vehOwner1_id) {
                # code...
           // return $vehOwner1_id;   
           
                Vehicle::where("ID", $vehicle[0]->id)->update([
                  
                    'OWNER1_ID' => null,
                   
                    'UPDATED_BY' => $userPkId
                ]);
           
        }
           

      

            if($owner != ""){
                if($vehicle->count() > 0){
                    if($this->isDuplicateCert($certificate) == 0) {
                        $vehicle = $vehicle->first();
                      
                        $result = $this->checkAddressPlate($plate_no, $owner);
//return $this->getEsignReqCheck($vehicle->id, $owner);
                      //  $vehId=
                     
                        if($this->getEsignReqCheck($vehicle->id, $owner)) {
                            # code...
                          //  return $request;
                        if (!is_array($result) && $result == true) {
                            $service = $this->getActionPrefix(3);
                            $old_owner_id = $vehicle->owner_id;
                            if ($owner != $old_owner_id) {
                        
                                $archive_no = $this->archiveNumberGenerate($service);
                                if($archive_no != "ERROR"){
                                    DB::beginTransaction();
                                    try{
                                        $vehicleId = intval($vehicle->id);
                                        settype($vehicleId, 'integer');
                                        $serviceId = $service->id;
                                        $this->createArchive($vehicle->id, $service->id, $certificate, $archive_no, $plate_no, $owner, $page_count, $description, $finger, $fingerDescription);
                                        $this->createOwnerShip($owner, $old_owner_id, $vehicle->id, 3);
                                        $this->epayTransaction($vehicle->id,$archive_no,$payDescription,$payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);

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
                                       // return $epayTransaction;
                                       // session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                                    //    if ($finger==5) {

                                    //      $this->eRequestApprove($requestCode);
                                    //        # code...
                                    //    }
                                        if ($ntrBookdate !="") {
                                            session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'ntrBookdate'=>$ntrBookdate,'ntrServiceFile'=>$ntrServiceFile,
                                            'ntrBooknumber'=>$ntrBooknumber, 'ntrLastname'=>$ntrLastname,'ntrFirstname'=>$ntrFirstname,'ntrStateregnumber'=>$ntrStateregnumber,'ntrAddress'=>$ntrAddress,'ntrPhone'=>$ntrPhone]);
                                        }else{
                                            if ($finger==5) {
                                               $this->eRequestApprove($requestCode);
                                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli,'signed_data'=>$signed_data]);
                                                   # code...
                                               }else{
                                                session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli]);
                                               }
                                          
                                        }
                                        DB::commit();
                                      
                                        $message = $this->message("success", "소유자 간 명의이전이 성공적으로 처리되었습니다.");
                                    } catch (\Exception $ex){
                                        DB::rollBack();
                                        $this->writeLog("Move owner transaction error: ".$ex->getMessage());
                                        $message = $this->message("danger", "소유자 간 이전 처리 중 오류가 발생했습니다.");
                                        return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                                    }
                                } else {
                                    $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                                }
                            } else {
                                $message = $this->message("info", "Шилжүүлэх 소유자 одоогийн 소유자 입니다.");
                            }
                        } else {
                            if (!is_array($result) && $result == false) {
                                $message = $this->message("info", "소유자 주소가 번호판 주소와 일치하지 않습니다.");
                            } else {
                                $message = $result[1];
                            }
                        }
                   
                    }else{
                        $message = $this->message("info", "소유자가 전자명으로 다른 소유자에게 이전을 요청했습니다.");
                    }


                    } else {
                        $message = $this->message("info", "증명서 번호가 중복됩니다.");
                    }
                } else {
                    $message = $this->message("info", "이전 хийх 차량 찾을 수 없습니다.");
                }
            } else {
                $message = $this->message("info", "Шилжүүлэх 소유자 찾을 수 없습니다.");
            }
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Move owner error: ".$ex->getMessage());
            $message = $this->message("danger", "소유자 간 이전 처리 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function electronForm($vehicle1, $owners,$finger)
    {
     // dd($finger['checkTorguuli'][0]);
   //  return $owners;
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
     
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
       
    if(Storage::disk('ftp')->has("/test".$action)){
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
     
    if(!Storage::disk('ftp')->has("/test".$action."/".$branch."/".$year."/".$month."/".$number."#.pdf")){
    
        if (!Storage::disk('ftp')->exists("/test".$action."/".$branch."/".$year."/".$month)) {
            Storage::disk('ftp')->makeDirectory("/test".$action."/".$branch."/".$year."/".$month);
            Storage::disk('ftp')->put("/test".$action."/".$branch."/".$year."/".$month."/".$number."#.pdf", $content);
            if ($pdfFile['ntrServiceFile']!="") {
                $link = file_get_contents($pdfFile['ntrServiceFile']);
            Storage::disk('ftp')->put("/test".$action."/".$branch."/".$year."/".$month."/".$number."#ntr.pdf", $link);
            }
            session()->forget(['vehicleElectron']);
             }else{
                Storage::disk('ftp')->put("/test".$action."/".$branch."/".$year."/".$month."/".$number."#.pdf", $content);
                if ($pdfFile['ntrServiceFile']!="") {
                    $link = file_get_contents($pdfFile['ntrServiceFile']);
                    Storage::disk('ftp')->put("/test".$action."/".$branch."/".$year."/".$month."/".$number."#ntr.pdf", $link);
                    }
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

    public function restrict(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $userPkId = session()->get("auth")->id;
        $plate_no = $this->dec(trim($request->get("form_plate")));
        $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
        DB::beginTransaction();
        try {
            $vehicle = DB::table("REG_VEHICLE")->where("ID", $vvcabinid)->get()->first();
            $type = $request->get("type");
            $date = $request->get("date");
            $number = $request->get("number");
            $phone = $request->get("phone");
            RegLimited::create([
                'Dec_date' => $date,
                'Dec_No' => $number,
                'Phone_No' => $phone,
                'Type_Id' => $type,
                'Vehicle_Id' => $vehicle->id,
                'CreatedBy' => $userPkId,
                'ModifiedBy' => $userPkId
            ]);
            Vehicle::where("Id", $vehicle->id)->update([
                'STATUS' => 12,
                'UPDATED_BY' => $userPkId
            ]);
            DB::commit();
            $message = $this->message("success", "차량 -ийн 제한 성공적으로 처리되었습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            DB::rollBack();
            $this->writeLog("Vehicle limit error: ".$ex->getMessage());
            $message = $this->message("danger", "차량 -ийн 제한 할 때 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function activeVehicle(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $userPkId = session()->get("auth")->id;
        $plate_no = $this->dec(trim($request->get("form_plate")));
        $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
        DB::beginTransaction();
        try {
            $vehicle = DB::table("REG_VEHICLE")->where("ID", $vvcabinid)->get()->first();
            $description = $request->get("description");
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $service = $this->getActionPrefix(18);
            $this->createArchive($vehicle->id, $service->id, $vehicle->certificate_no, $vehicle->archive_no, $plate_no, $vehicle->owner_id, 0, $description, $finger, $fingerDescription);
            Vehicle::where("Id", $vehicle->id)->update([
                'IS_ENABLED' => 1,
                'IS_PENDING' => 0,
                'DESCRIPTION' => $vehicle->description."***".Carbon::now()->format("Y-m-d H:i:s")." ".$description." ".session()->get("auth")->firstname.";",
                'STATUS' => 18,
                'UPDATED_BY' => $userPkId
            ]);

            $message = $this->message("success", "차량 성공적으로 활성화되었습니다.");
            DB::commit();
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            DB::rollBack();
            $this->writeLog("Vehicle enable error: ".$ex->getMessage());
            $message = $this->message("danger", "차량 활성화эд 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function restoreRestrict(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $plate_no = $this->dec(trim($request->get("form_plate_no")));
        $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
        DB::beginTransaction();
        try {
            $userPkId = session()->get("auth")->id;
            $type = $request->get("type");
            $date = $request->get("date");
            $number = $request->get("number");
            $phone = $request->get("phone");
            $id = trim($request->get("form_plate"));
            $vid = Vehicle::where("ID", $vvcabinid)->get()->first()->id;
            RegLimited::where("Id", $id)->update([
                'Restore_User_Id' => $userPkId,
                'Is_Restored' => 1,
                'Phone_No' => $phone,
                'End_Date' => $date,
                'Restore_Dec_no' => $number,
                'Restore_Type_Id' => $type,
                'ModifiedBy' => $userPkId
            ]);

            $is_restore = RegLimited::where("VEHICLE_ID", $vid)->where("IS_RESTORED", 0)->get()->count();
            if($is_restore == 0){
                Vehicle::where("Id", $vid)->update([
                    'STATUS' => 8,
                    'IS_PENDING' => 0,
                    'UPDATED_BY' => $userPkId
                ]);
            }
            DB::commit();
            $message = $this->message("success", "차량 -ийн 제한 성공적으로 복구되었습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            DB::rollBack();
            $this->writeLog("Vehicle limit restore error: ".$ex->getMessage());
            $message = $this->message("danger", "차량 -ийн 제한 복구 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function removeVehicle(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $plate_old_no = $this->dec(trim($request->get("current_plate")));
            $page_count = trim($request->get("page_count"));
            $description = trim($request->get("description"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $vehicle = Vehicle::where("ID", $vvcabinid)->get();
            $checkTorguuli = $request->checkTorguuli;

            $payDescription=trim($request->get("payDescription"));
            $payDescriptionName=trim($request->get("payDescriptionName"));
            $transactionId=trim($request->get("transactionId"));
            $payAmount=trim($request->get("payAmount"));
            $serviceTypeName=trim($request->get("serviceTypeName"));
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
                               // 'IS_ORDER' => 0,
                                'IS_GIVEN' => 0,
                                'IS_LOCAL' => 0,
                                'LOCAL_USER_ID' => null,
                                'VEHICLE_ID' => null,
                                'SHOW_DATE' => $show_date,
                                'UPDATED_BY_ID' => $userPkId
                            ]);
                            DB::commit();
                            $this->epayTransaction($vehicle->id,$archive_no,$payDescription,$payDescriptionName,$transactionId,$payAmount,$serviceTypeName,$serviceTypeId);

                            session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger,'checkTorguuli'=>$checkTorguuli]);
                            
                            $message = $this->message("success", "차량 -ийн 정보 성공적으로 삭제/말소되었습니다.");
                        } else {
                            $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                        }
                    } catch (\Exception $ex){
                        DB::rollBack();
                        $this->writeLog("Remove vehicle transaction error: ".$ex->getMessage());
                        $message = $this->message("danger", "차량 말소 처리 중 오류가 발생했습니다.");
                        return redirect(url('/vehicle/'.$this->enc($plate_old_no)))->with("message", $message);
                    }
                } else {
                    $message = $this->message("info", "ХХ сери үүсээгүй эсвэл ХХ серитэй сул 번호 байхгүй 입니다.");
                    $plate_no = $plate_old_no;
                }
            } else {
                $message = $this->message("info", $plate_old_no." 번호판 차량을 찾을 수 없습니다.");
                $plate_no = $plate_old_no;
            }
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Remove vehicle error: ".$ex->getMessage());
            $message = $this->message("danger", "차량 말소 처리 중 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_old_no)))->with("message", $message);
        }
    }

    public function deletePlate(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        try{
            $userPkId = session()->get("auth")->id;
            $plate_no = $this->dec(trim($request->get("current_plate")));
            $description = trim($request->get("description"));
            $plateColor = trim($request->get("plateColor"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $page_count = trim($request->get("page_count"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $vehicle = Vehicle::where("ID", $vvcabinid)->get();
            if ($vehicle->count() > 0) {
                $vehicle = $vehicle->first();
                $service = $this->getActionPrefix(5);
                $archive_no = $this->archiveNumberGenerate($service);
                DB::beginTransaction();
                try{
                    if($archive_no != "ERROR"){
                        $this->createArchive($vehicle->id, $service->id, $vehicle->certificate_no, $archive_no, $plate_no, $vehicle->owner_id, $page_count, $description, $finger, $fingerDescription);
                        Vehicle::where("Id", $vehicle->id)->update([
                            'ARCHIVE_NO' => $archive_no,
                            'PAGE_COUNT' => $page_count,
                            'IS_PENDING' => 0,
                            'STATUS' => 5,
                            'UPDATED_BY' => $userPkId
                        ]);
                        $this->createPrintPlate($vehicle->plate_no, $service->id, $userPkId,$plateColor);
                        session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                        DB::commit();
                        $message = $this->message("success", "차량 -ийн 표식/문자 분실 성공적으로 등록되었습니다.");
                    } else {
                        $message = $this->message("info", "아카이브 번호 생성 중 오류가 발생했습니다 다시 작업/처리 해주세요.");
                    }
                } catch (\Exception $ex){
                    DB::rollBack();
                    $this->writeLog("Remove vehicle plate transaction error: ".$ex->getMessage());
                    $message = $this->message("danger", "차량 표식/문자 분실 등록하기эд 오류가 발생했습니다.");
                    return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                }
            } else {
                $message = $this->message("info", $plate_no." 번호판 차량을 찾을 수 없습니다.");
            }
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Remove vehicle plate error: ".$ex->getMessage());
            $message = $this->message("danger", "차량 표식/문자 분실 등록하기эд 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }
    public function changePlateColor(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        try{
            $userPkId = session()->get("auth")->id;
            $plate_no = $this->dec(trim($request->get("current_plate")));
            $description = trim($request->get("description"));
            $plateColor = trim($request->get("plateColor"));
            $fingerDescription = trim($request->get("fingerTotalDescription"));
            $finger = trim($request->get("fingerDescription"));
            $page_count = trim($request->get("page_count"));
            $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
            $vehicle = Vehicle::where("ID", $vvcabinid)->get();
            if ($vehicle->count() > 0) {
                $vehicle = $vehicle->first();
                $service = $this->getActionPrefix(5);
                
         //       DB::beginTransaction();
                try{
                
                 // dd($request);
                        $this->createPrintPlate($vehicle->plate_no, $service->id, $userPkId,$plateColor);
                     //   session()->put('vehicleElectron',['eForm'=>'1','finger'=> $finger]);
                    //    DB::commit();
                        $message = $this->message("success", "차량 -ийн 번호판ын өнгө 성공적으로 교체되었습니다.");
                  
                } catch (\Exception $ex){
                    DB::rollBack();
                    $this->writeLog("Remove vehicle plate transaction error: ".$ex->getMessage());
                    $message = $this->message("danger", "차량 표식/문자 분실 등록하기эд 오류가 발생했습니다.");
                    return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
                }
            } else {
                $message = $this->message("info", $plate_no." 번호판 차량을 찾을 수 없습니다.");
            }
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Remove vehicle plate error: ".$ex->getMessage());
            $message = $this->message("danger", "차량 표식/문자 분실 등록하기эд 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function referenceVehicle(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        return view('Reports.reference');
    }

    public function writeDescription(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $userPkId = session()->get("auth")->id;
        $plate_no = $this->dec(trim($request->get("form_plate")));
        $vvcabinid = $this->dec(trim($request->get("vvcabinid")));
        try {
            $vehicle = DB::table("REG_VEHICLE")->where("ID", $vvcabinid)->get()->first();
            $description = $request->get("description");
            Vehicle::where("Id", $vehicle->id)->update([
                'DESCRIPTION' => $vehicle->description."***".Carbon::now()->format("Y-m-d H:i:s")." ".$description." ".session()->get("auth")->firstname.";",
                'UPDATED_BY' => $userPkId
            ]);
            $message = $this->message("success", "특이사항 성공적으로 추가되었습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        } catch (\Exception $ex){
            $this->writeLog("Vehicle description error: ".$ex->getMessage());
            $message = $this->message("danger", "특이사항 нэмхэд 오류가 발생했습니다.");
            return redirect(url('/vehicle/'.$this->enc($plate_no)))->with("message", $message);
        }
    }

    public function referenceCustomVehicle(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $title =$request->get("title");
        $ehelsenognoo = $request->get("ehelsenognoo");
        $ulsiindugaar = $request->get("ulsiindugaar");
        $arliindugaar = $request->get("arliindugaar");
        $vin = $request->get("vin");
        $factory = $request->get("factory");
        $mark = $request->get("mark");
        $model = $request->get("model");
        $modificacename = $request->get("modificacename");
        $vinmodel = $request->get("vinmodel");
        $uurchilsunognoo = $request->get("uurchilsunognoo");
        $bagtaamj = $request->get("bagtaamj");
        $zoriulalt = $request->get("zoriulalt");
        $turul = $request->get("turul");
        $angilal = $request->get("angilal");
        $hurd = $request->get("hurd");
        $hairtsag = $request->get("hairtsag");
        $uildverlesenognoo = $request->get("uildverlesenognoo");
        $motor = $request->get("motor");
        $gasoline = $request->get("gasoline");
        $urt = $request->get("urt");
        $urgun = $request->get("urgun");
        $undur = $request->get("undur");
        $buhjin = $request->get("buhjin");
        $uuriinjin = $request->get("uuriinjin");
        $color = $request->get("color");
        $gerchilgee = $request->get("gerchilgee");
        $oruuljirsen = $request->get("oruuljirsen");
        $archivedugaar = $request->get("archivedugaar");
        $anhniiarchive = $request->get("anhniiarchive");
        $meduulgiindugaar = $request->get("meduulgiindugaar");
        $teevriinheregselturul = $request->get("teevriinheregselturul");
        $uls = $request->get("uls");
        $registernumber = $request->get("registernumber");
        $urgiinovog = $request->get("urgiinovog");
        $etsegekh = $request->get("estegekh");
        $uuriinner = $request->get("uuriinner");
        $aimag = $request->get("aimag");
        $duureg = $request->get("duureg");
        $baghoroo = $request->get("baghoroo");
        $horoolol = $request->get("horoolol");
        $gudamj = $request->get("gudamj");
        $bair = $request->get("bair");
        $haalga = $request->get("haalga");
        $geriinutas = $request->get("geriinutas");
        $ajiliinutas = $request->get("ajiliinutas");

        return view('Reports.referencecustom',compact('title','ehelsenognoo','ulsiindugaar','arliindugaar','vin'
            ,'factory','mark','model','modificacename','vinmodel','uurchilsunognoo','bagtaamj','zoriulalt','turul','angilal','hurd','hairtsag','uildverlesenognoo'
            ,'motor','gasoline','urt','urgun','undur','buhjin','uuriinjin','color','gerchilgee','oruuljirsen','archivedugaar','anhniiarchive'
            ,'meduulgiindugaar','teevriinheregselturul','uls','registernumber','urgiinovog','etsegekh','uuriinner','aimag','duureg','baghoroo','horoolol','gudamj'
            ,'bair', 'geriinutas','ajiliinutas','haalga'));
    }

    public function getProvinceAbbr($province){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $province = AddressProvince::where("Id", $province)->get()->first();
        return $province;
    }
    public function getEsignReqCheck($vehicleId,$owner){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
       // $province = AddressProvince::where("Id", $province)->get()->first();

      // $data = DB::table("ESIGN_VIEW")->where('vehicle_id',$vehicleId )->get();


      $query = DB::table('vrs.esign as es')
          ->join('vrs.reg_vehicle_view as vv', 'vv.id', '=', 'es.vehicle_id')
      
          // Owner (o)
          ->leftJoin('vrs.owner as o', function ($join) {
              // dummy ON, then push complex predicate via whereRaw (Oracle LENGTH, || concat)
              $join->on(DB::raw('1'), '=', DB::raw('1'))
                   ->whereRaw("( (LENGTH(es.owner_regnum) = 7 AND o.register_no = es.owner_regnum || '0001') OR o.register_no = es.owner_regnum )");
          })
      
          // New owner (n)
          ->leftJoin('vrs.owner as n', function ($join) {
              $join->on(DB::raw('1'), '=', DB::raw('1'))
                   ->whereRaw("( (LENGTH(es.new_owner_regnum) = 7 AND n.register_no = es.new_owner_regnum || '0001') OR n.register_no = es.new_owner_regnum )");
          })
      
          // Borrower (b) — only if is_borrowing = 1
          ->leftJoin('vrs.owner as b', function ($join) {
              $join->on(DB::raw('1'), '=', DB::raw('1'))
                   ->whereRaw("es.is_borrowing = 1 AND ( (LENGTH(es.borrower_regnum) = 7 AND b.register_no = es.borrower_regnum || '0001') OR b.register_no = es.borrower_regnum )");
          })
      
          ->select([
              'es.id',
              DB::raw('MAX(es.vehicle_id) AS vehicle_id'),
              DB::raw('MAX(es.service_code) AS service_code'),
              DB::raw('MAX(es.request_code) AS request_code'),
              DB::raw('MAX(vv.plate_no) AS plate_no'),
              DB::raw('MAX(vv.cabin_no) AS cabin_no'),
              DB::raw('MAX(vv.mark_name) AS mark_name'),
              DB::raw('MAX(vv.model_name) AS model_name'),
              DB::raw('MAX(vv.modificace_name) AS modificace_name'),
              DB::raw('MAX(vv.vehicle_type_name) AS vehicle_type_name'),
              DB::raw('MAX(vv.color_name) AS color_name'),
      
              DB::raw('MAX(o.id) AS owner_id'),
              DB::raw('MAX(o.last_name) AS owner_lastname'),
              DB::raw('MAX(o.first_name) AS owner_firstname'),
              DB::raw('MAX(o.address_detail) AS owner_address'),
              DB::raw('MAX(es.owner_regnum) AS owner_regnum'),
      
              DB::raw('MAX(n.id) AS new_owner_id'),
              DB::raw('MAX(n.last_name) AS new_owner_lastname'),
              DB::raw('MAX(n.first_name) AS new_owner_firstname'),
              DB::raw('MAX(n.address_detail) AS new_owner_address'),
              DB::raw('MAX(es.new_owner_regnum) AS new_owner_regnum'),
      
              DB::raw('MAX(es.is_borrowing) AS is_borrowing'),
      
              DB::raw('MAX(b.id) AS borrower_id'),
              DB::raw('MAX(b.last_name) AS borrower_lastname'),
              DB::raw('MAX(b.first_name) AS borrower_firstname'),
              DB::raw('MAX(b.address_detail) AS borrower_address'),
              DB::raw('MAX(es.borrower_regnum) AS borrower_regnum'),
      
              DB::raw('MAX(es.note) AS note'),
              DB::raw('MAX(es.is_paid) AS is_paid'),
              DB::raw('MAX(es.is_approved) AS is_approved'),
              DB::raw('MAX(es.created_date) AS created_date'),
              DB::raw('MAX(es.is_deleted) AS is_deleted'),
          ])
          ->where('es.vehicle_id',$vehicleId)
          ->groupBy('es.id')
          ->orderBy('es.id', 'desc');
      
      // If you want the results:
      $data = $query->get();
     // dd($data);
       $owner_regnum = Owner::where("ID", $owner)->get()->first()->register_no;
       if (count($data) > 0) {

        $data =$data->first();
       // return $data;
       // dd($owner_regnum);
       // $check = DB::table("ESIGN_VIEW")->where('vehicle_id',$vehicleId )->where('is_approved',0)->where('new_owner_regnum', $owner)->get();
        if ($data->is_approved == 0 && $data->new_owner_regnum == $owner_regnum ) {
           return true;
        } else if($data->is_approved == 1) {
         return true;
        } else if($data->is_deleted == 1) {
            return true;
           }
        else{
          return  false;
        }
        
      //return true;
       } else { 
       return true;
       }
       
       // return $data;
    }

    public function getActionPrefix($service){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $service = MainService::where("Id", $service)->get()->first();
        return $service;
    }
 
    public function getUserProvincePkId($ownerPkId){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
        //    $owner= Owner::where("Id", $ownerPkId)->get()->first();
            $owner = DB::table("REG_OWNER_VIEW")->where("id", $ownerPkId)->first();
            $owner_prov = $owner->province_id;
           
            return $owner_prov;
        } catch (\Exception $ex){
            $this->writeLog("Get owner province id error: ". $ex->getMessage());
            return null;
        }
    }

    public function archiveNumberGenerate($service){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
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

    public function checkAddressPlate($plate_no, $owner){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try{
            $series_id = SeriesNumber::where("NAME", $plate_no)->get()->first()->series_id;
            $series = Series::where("ID", $series_id)->get();
            $series_province = $series->first()->province_id;
            $series_is_check_address = $series->first()->is_check_address;
            if($series_is_check_address == 1){
                $owners = DB::table("REG_OWNER_VIEW")->where("id", $owner)->first();

            
                if($series_province ==  $owners->province_id){
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } catch (\Exception $ex){
            $this->writeLog("주소ийн 정보 확인할 때 오류가 발생했습니다. ".$ex);
            $message = $this->message("info", "Серийн 정보 입력되지 않은 эсвэл 소유권자ийн хаягийн 정보 누락된 입니다.");
            return array(true, $message);
        }
    }

    public function createArchive($vehicle_id, $service_id, $certificate, $archive_number, $plate_no, $owner_id, $page_count, $description, $finger, $finger_description){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $request = Vehicle::where("Id", $vehicle_id)->get()->first();
        $userPkId = session()->get("auth")->id;
        $service = $this->getActionPrefix($request->status);

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

    public function createOwnerShip($new_owner, $old_owner_id, $vehicle_id, $status){
        if(!session()->has("auth")){ 
            return redirect(route($this->redirectURL));
        }
        $userPkId = session()->get("auth")->id;
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

    public function giveNumber($plate_no, $userPkId){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
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
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $vehicle = DB::table("REG_VEHICLE")->where("PLATE_NO", $plate_no)->get();
        if($vehicle->count() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function generateRemovePlate(){
        try{
            $remove_series = \App\Series::where("NAME", "LIKE", "ХХ%")->orderBy("NAME", "ASC")->get();
            $number = null;
            foreach ($remove_series as $ser){
                $numbers = \App\SeriesNumber::where("IS_GIVEN", 0)->where("IS_HIDDEN", 0)->where("SERIES_ID", $ser->id)->select("NAME")->get();
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

    public function isDuplicateCert($certificate_no){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $duplicate = DB::table("ARCHIVE_VIEW")
            ->where("CERTIFICATE_NO", trim($certificate_no))
            ->get()
            ->count();
        return $duplicate;
    }

    public function isMehanizmOrderCheck($plate_no, $vehicle, $owner){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try {
         
            $vehicles = DB::table("REG_VEHICLE_VIEW")->where("id", $vehicle)->get();
            $vehicles = json_decode($vehicles->toJson(), true)[0];
           // return $vehicles;
            $Diagnostic = DB::table("MVIS.INS_INSPRESULT_SHORT_VIEW")
                ->where("SERVICE_TYPE_ID", "1")
                ->where("STATUS", "1")
                ->where("vehicle_id", $vehicle)
                ->orderBy("DATEINSPAPPR", "DESC")
                ->get()
                ->first();
             // dd($Diagnostic);
             //   return $vehicles['vehicle_type_id'];
                if ( $Diagnostic == null || $Diagnostic =="") {
                if ($vehicles['purpose_id'] == 2 || $vehicles['purpose_id'] ==4 || $vehicles['purpose_id'] ==5 || $vehicles['purpose_id'] ==7  || $vehicles['purpose_id'] ==8){
                 //   return $plate_no;
                    $check = Str::substr($plate_no,-3);
                    if (in_array($check, ['MMA', 'ММА'], true)) {
                      return true;
                    } else {
                      return false;
                    }
                    

                    // if ($plate_no ) {
                    //     $s = Str::before($plate_no, 'MMA');
                    // }

                }else{
                    return true;
                }
            }else{
                if (\Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") <= \Carbon\Carbon::now()->format("Y-m-d")) {
                    if ($vehicles['purpose_id'] == 2 || $vehicles['purpose_id'] ==4 || $vehicles['purpose_id'] ==5 || $vehicles['purpose_id'] ==7  || $vehicles['purpose_id'] ==8){
                        //   return $plate_no;
                           $check = Str::substr($plate_no,-3);
                           if (in_array($check, ['MMA', 'ММА'], true)) {
                             return true;
                           } else {
                             return false;
                           }
                           
       
                           // if ($plate_no ) {
                           //     $s = Str::before($plate_no, 'MMA');
                           // }
       
                       }else{
                           return true;
                       }
                }else{
                    return true;
                }
            
            }
            //code...
        } catch (\Exception $ex){
            $this->writeLog("Is Order Error: ".$ex->getMessage());
        
            //throw $th;
        }
    }
    public function isMehanizmOrderCheck2($plate_no, $vehicle, $owner){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try {
         
            $vehicles = DB::table("REG_VEHICLE_VIEW")->where("id", $vehicle)->get();
            $vehicles = json_decode($vehicles->toJson(), true)[0];
         
            $Diagnostic = DB::table("MVIS.INS_INSPRESULT_SHORT_VIEW")
                ->where("SERVICE_TYPE_ID", "1")
                ->where("STATUS", "1")
                ->where("vehicle_id", $vehicle)
                ->orderBy("DATEINSPAPPR", "DESC")
                ->get()
                ->first();
                $insp = (int)$Diagnostic->passed;
          if($Diagnostic->dateagain != null && \Carbon\Carbon::parse($Diagnostic->dateagain)->format("Y-m-d") <= \Carbon\Carbon::now()->format("Y-m-d")){
       
                 //  return $Diagnostic->passed;
                if ($vehicles['purpose_id'] == 2 || $vehicles['purpose_id'] ==4 || $vehicles['purpose_id'] ==5 || $vehicles['purpose_id'] ==7 || $vehicles['purpose_id'] ==8){
                 //   return $plate_no;
                    $check = Str::substr($plate_no,-3);
                  //  return  $check;
                    if (in_array($check, ['MMA', 'ММА'], true)) {
                      return true;
                    } else {
                      return false;
                    }
                    

                    // if ($plate_no ) {
                    //     $s = Str::before($plate_no, 'MMA');
                    // }

                }else{
                    return true;
                }
            }else{
                return true;
            }
            //code...
        } catch (\Exception $ex){
            $this->writeLog("Is Order Error: ".$ex->getMessage());
        
            //throw $th;
        }
    }
    public function isOrderUser($plate_no, $vehicle, $ownerPkId){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        try {
          
            $owner = Owner::where("ID", $ownerPkId)->get()->first();
            $ownerRegister = $owner->register_no;
            $ownerType = $owner->type_id;
           
            $check = SeriesNumber::where("NAME", $plate_no)
                ->where("IS_OPENED", 1)
                ->where("IS_HIDDEN", 0)
                ->where("IS_GIVEN", 0)
                ->get();
               // return $check;
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

    public function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
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
}
