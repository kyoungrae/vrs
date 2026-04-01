<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use nusoap_client;
use App\SeriesNumber;
use App\Transaction;
use App\Owner;
use App\PlateNumberSave;
use App\EpayTransaction;
use Illuminate\Support\Facades\Session;
class ServiceController extends BaseController
{
    /*
     * service1 => Иргэний мэдээлэл зурагтай
     * service2 => 세관
     * service3 => 과태료
     * service4 => 세금
     * service5 => Зам ашиглалт
     * */
    private $keyPath = null;
    private $accessToken = null;
    private $sign = null;
    private $signingInfo = null;
 
   
    public function __construct()
    {
        //  $this->keyPath = 'transdep.key';
     $this->keyPath = 'mrtd.key';
     $this->accessToken = "8c57ae35b9fff22a7cf3c63f773dba54";
     //  $this->accessToken = "ba967ace740b787ab40a80bbdf100629";
        $this->sign = new XypSignController($this->keyPath, $this->accessToken);
        $this->signingInfo = $this->sign->sign();
      
    }
public function transactionCheck(Request $request){
    
   // return $request;
   if(!session()->has("auth")){
    return response()->json(["message" => "Not valid request."], 401);
}
    if($request->isMethod("POST")){
     //  return $request;
        $date=$request->param3;
        if(self::dec($date) == Carbon::now()->format("Y-m-d")){
            $serviceType=json_decode($request->param2);
            $vehId=$request->param1;
           $amount= (int)$request->get('param4');
            // $check = Transaction::query()
            // ->where('description', 'LIKE', "%{$serviceType}-{$vehId}%")->whereNull('arkhive_no')->orderBy('id','desc') 
           
            // // ->first();
            // $checkTypeVeh = DB::select(" SELECT * FROM reg_vehicle_view  where id= '".$vehId."' and (purpose_id=9 or purpose_id=8 or purpose_id=7 ) ");
            
            // if ($checkTypeVeh) {
            
            //     $checkMotoMehMovePlate = Transaction::query()
            //     ->where('description', 'LIKE', "%VRS9-{$vehId}%")->where('amount' ,'>=', 13600)->whereNull('arkhive_no')->orderBy('id','desc') 
               
            //     ->first();
            //     $checktrailer = Transaction::query()
            //     ->where('description', 'LIKE', "%VRS6-{$vehId}%")->where('amount' ,'>=', 32500)->whereNull('arkhive_no')->orderBy('id','desc') 
               
            //     ->first();
            //     $checkMehTrailNew = Transaction::query()
            //     ->where('description', 'LIKE', "%VRS8-{$vehId}%")->where('amount' ,'>=', 14200)->whereNull('arkhive_no')->orderBy('id','desc') 
               
            //     ->first();
            //     $checkTrailerMehMotoMove = Transaction::query()
            //     ->where('description', 'LIKE', "%VRS10-{$vehId}%")->where('amount' ,'>=', 12500)->whereNull('arkhive_no')->orderBy('id','desc') 
               
            //     ->first();
            //     if ($checkMotoMehMovePlate) {
            //         return $checkMotoMehMovePlate;
        
            //     }elseif($checkMehTrailNew){
            //         return $checkMehTrailNew;
            //     }elseif($checktrailer ){
            //         return $checktrailer;
            //     } 
            //     elseif($checkTrailerMehMotoMove ){
            //         return $checkTrailerMehMotoMove;
            //     }
            //     else{
            //         return response()->json(['status'=>'error','msg'=>'Уг үйлчигээний төлбөр төлөгдөөгүй байна.']);
            //     }
            // }else{
                $check = Transaction::query()
                ->where('description', 'LIKE', "%-{$vehId}%")->where('amount' ,'>=', $amount)->whereNull('arkhive_no')->orderBy('id','desc') 
               
                ->get();
                // $check = DB::table('transaction')->where('description', 'LIKE', "%-{$vehId}%")->where(['amount' >= $amount])->get();
            
                if (count($check)>0 ) {
                    return $check;
        
                   }   else{
                        return response()->json(['status'=>'error','msg'=>'Уг үйлчигээний төлбөр төлөгдөөгүй байна.']);
                //    }
           // }
           
           

            // $checkMotoNew = Transaction::query()
            // ->where('description', 'LIKE', "%VRS-{$vehId}%")->where('amount',13600)->whereNull('arkhive_no')->orderBy('id','desc') 
           
            // ->first();
            // $checkMotoMovePlate = Transaction::query()
            // ->where('description', 'LIKE', "%{$plateMove}-{$vehId}%")->where('amount',13600)->whereNull('arkhive_no')->orderBy('id','desc') 
           
            // ->first();
            // $checkMotoMove = Transaction::query()
            // ->where('description', 'LIKE', "%VRS2-{$vehId}%")->where('amount',12500)->whereNull('arkhive_no')->orderBy('id','desc') 
           
            // ->first();
           
           
       
        // elseif($checkMotoMove)
        // {
        //      return $checkMotoMove;

        // }elseif ($checkMotoMovePlate) {
        //     return $checkMotoMovePlate;
        // }
        // elseif ($checkMotoNew) {
        //     return $checkMotoNew;
         }
       
           
   
        }
    }
} 
    public function auction(Request $request)
    {
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
       // return $request;
       if($request->isMethod("POST")){
        $valid=$request->param2;
        if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
        $plateNo = $request->param1;
        //$endtDate=$request->end_year;
        //return $startDate; 
        //return "fgfdgdfgd";
       
        
        $client = new nusoap_client("https://service.transdep.mn/api/WS000_AUCTION.php?wsdl", true);

        $params = array();
        $params["plate_no"]= $plateNo;
        //$params["end_year"] = $endtDate;
        $params["token"] = "7716266182106fcee00ca1b083f322184b6b785bdec54ca8a87c9582b5c96f2a80773fa24e06fb230d080dced41b0e3d52154aa7dffbd1d3994d54ed57732bb3";

        $result_json = $client->call('getWinnerInfo',  $params);
        //$result = json_encode($result_json);

        return $result_json;
        }
       }
    }
    public function removeVehicleSearch(Request $request)
    {
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
       // return $request;
       if($request->isMethod("POST")){
        $valid=$request->param2;
        if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
        $plateNo = $request->param1;

        // $checkSeirTurjuram = DB::select(DB::raw("SELECT * FROM SERIES_NUMBER WHERE name='".$plateNo."' AND IS_HIDDEN=1 AND (ORDER_USER ='Turjuram' or ORDER_USER='Burtgelhas') ")); 
        $checkSeirTurjuramd = DB::select(DB::raw("SELECT
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

       

        if ( count($checkSeirTurjuramd)>0) {
           // return $checkSeirTurjuram;
         //  $checkSeirTurjuramd = SeriesNumber::where(["name"=>$plateNo,"is_hidden"=>1])->first();
        //    return response()->json([
        //     'statusCode' =>200,
        //     'message' => "ok",
        //    'checkSeirTurjuramd'=> $checkSeirTurjuramd
           
          
        // ]);
           return $checkSeirTurjuramd;
        } else {
            return response()->json(["message" => "오류."], 400);
        }
        }
       }
    }
    public function plateSaveVehicleSearch(Request $request)
    {
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
       // return $request;
       if($request->isMethod("POST")){
        $valid=$request->param2;
        if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
        $plateNo = $request->param1;
        //$endtDate=$request->end_year;
       // return $plateNo; 
       $seriesNumberCheck = DB::table("series_number")->where("NAME", $plateNo)->first();
        $seriesCheck = DB::select(DB::raw("SELECT * FROM series where ((substr(name,1,2) like 'УЕ%' or substr(name,1,2) like 'УА%' or substr(name,1,2) like 'УБ%' or substr(name,1,2) like 'УН%')) and type='1' and id='".$seriesNumberCheck->series_id."' "));
                   //    return $seriesCheck;
        $auctionCheck = SeriesNumber::where("name",$plateNo)->where("is_hidden", 1)->where("isauction", 1)->where("is_given",0)->get();
        $vrsOrderCheck = SeriesNumber::where("name",$plateNo)->where("is_hidden", 0)->where("is_order",1)->whereNotNull("order_cabin")->whereNotNull("order_user")->whereNotNull("order_date")->where("isauction", 0)->get();
            
     //   return json_encode( $auctionCheck );
    //  if (count($seriesCheck) > 0) {
    //     return response()->json([
    //         'status' => 400,
    //         'message' => "Уг дугаарыг хадаглах боломжгүй байна."
            
    //     ]);
    //  } else {
        # code...
     
     
        if (count($auctionCheck) > 0 ) {

            // $client = new nusoap_client("https://service.transdep.mn/api/WS000_AUCTION.php?wsdl", true);

            // $params = array();
            // $params["plate_no"]= $plateNo;
            // //$params["end_year"] = $endtDate;
            // $params["token"] = "7716266182106fcee00ca1b083f322184b6b785bdec54ca8a87c9582b5c96f2a80773fa24e06fb230d080dced41b0e3d52154aa7dffbd1d3994d54ed57732bb3";
    
            // $result_json = $client->call('getWinnerInfo',  $params);
            // //$result = json_encode($result_json);
    
            // return $result_json;
            return response()->json([
                'status' => 400,
                'message' => "Уг дугаарыг хадаглах боломжгүй байна."
                
            ]);
        }else{

            if (count($vrsOrderCheck) > 0 ) {

            $orderVrs=$vrsOrderCheck->first(); 

            // return response()->json([
            //     'is_auction' => 0,
            //     'last_name' => "",
            //     'first_name' =>"",
            //     'register_no' => $orderVrs->order_user,
            //     'phone_no' => "",
            //     'order_date' => $orderVrs->order_date,
            //     'order_cabin' => $orderVrs->order_cabin,
            // ]);
            return response()->json([
                'status' => 400,
                'message' => "Уг дугаарыг хадаглах боломжгүй байна."
                
            ]);
              // return json_encode($orderVrs);
            } else {
                $vehicle = DB::table("REG_VEHICLE_VIEW")->where("PLATE_NO", $plateNo)->first();
                $seriesCheck = DB::table("series_number")->where("NAME", $plateNo)->where("ORDER_USER", "Turjuram")->where("IS_HIDDEN", 1)->get();


                //  return json_encode($vehicle);
               // return $vehicle;
    //   if ($vehicle->owner_type_id==2) {
    //     # code...
    //   }
                  $owners = DB::table("REG_VEHICLE_OWNERSHIP_VIEW")
                  ->where("VEHICLE_ID", $vehicle->id )
                  ->orderBy("START_DATE", "DESC")
                  ->orderBy("SHIP_ID", "DESC")
                  ->first();
                  $result = json_encode($owners);
               //  return  $result;
      if (count($seriesCheck) > 0) {
        return response()->json([
            'is_auction' => 0,
            'message' => "오류"
            
        ]);
      }else{
        return response()->json([
            'is_auction' => 0,
            'last_name' => $owners->last_name,
            'first_name' => $owners->first_name,
            'register_no' => $owners->register_no,
            'phone_no' => $owners->phone_no,
            'vehicle_id' => $vehicle->id,
        ]);
      }
               
            }
            
         
        }
    //}
        
    
        }
       }
    }
    public function plateSaveVehicleOrder(Request $request)
    {
      
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
     //   return json_encode( $request);
       if($request->isMethod("POST")){
        $valid=$request->param2;
        if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
        $plateNo = $request->param1;
        //$endtDate=$request->end_year;
       // return $plateNo; 
        //return "fgfdgdfgd";
        $vrsOrderCheck = SeriesNumber::where("name",$plateNo)->where("is_hidden", 1)->where("is_save", 1)->get();
        $plateSaveNumber = PlateNumberSave::where("plate_no", $plateNo)->where("is_delete",0)->where("is_active",1)->get();
       // return $vrsOrderCheck;
      //  return json_encode( $plateSaveNumber );
        if (count($vrsOrderCheck) > 0 && count($plateSaveNumber) > 0 ) {
            $plateSaveNumber=$plateSaveNumber->first();
            return response()->json([
                'archive_number' => $plateSaveNumber->archive_number,
                'begin_date' => $plateSaveNumber->begin_date,
                'end_date' => $plateSaveNumber->end_date,
                'customer_lastname' => $plateSaveNumber->customer_lastname,
                'customer_firstname' => $plateSaveNumber->customer_firstname,
                'customer_phone' => $plateSaveNumber->customer_phone,
                'customer_regnum' => $plateSaveNumber->customer_regnum,
               
            ]);
        //     SeriesNumber::where("NAME", $plate_no)->update([
        //         'IS_ORDER' => 1,
        //         'ORDER_USER' => null,
        //         'IS_GIVEN' => 1,
        //         'IS_LOCAL' => 0,
        //         'LOCAL_USER_ID' => null,
        //         'VEHICLE_ID' => $vehicle->id,
        //         'UPDATED_BY_ID' => $userPkId
        //     ]);
        // }else{
 
        }
        
    
        }
       }
    }
    public function payment(Request $request)
    {
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
       // return $request->param;
       if($request->isMethod("POST")){
        $valid=$request->param;
        if(self::dec($valid) == Carbon::now()->format("Y-m-d")){

            $data=array();
            $paymentData = DB::select(DB::raw("select tr.id,epay.id, epay.vehicle_id, tr.account_number,tr.related_account,tr.description,tr.amount,tr.owner_name,tr.transaction_date,tr.arkhive_no,epay.arkhive_no,epay.created_at,
            epay.pay_type_name,service.name,vehicle.plate_no
             from transaction tr join epay_transaction epay on tr.id=epay.transaction_id join system_service service on service.id = epay.service_id
             join reg_vehicle vehicle on epay.vehicle_id = vehicle.id where tr.related_account is not null"));
             $transaction = DB::select(DB::raw("SELECT * FROM transaction WHERE arkhive_no is null and related_account is not null"));
             array_push($data,['paymentData'=>$paymentData],['transaction'=>$transaction] );
            return $data;
        }
       }
    }
    public function vehCheck(Request $request)
    {
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
       // return $request->param;
       if($request->isMethod("POST")){
           
        $valid=$request->param2;
        if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
if ($request->param == 0) {
    $vehicle = DB::table("REG_VEHICLE_VIEW")->where("plate_no", $request->param1)->get();
    return $vehicle;
}else{
    $vehicle = DB::table("REG_VEHICLE_VIEW")->where("id", $request->param1)->get();
    return $vehicle;
}
          
        }
       }
    }
    
    public function serviceNTRLogin(){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        // if (!session()->has('sessionData')){
       $url = 'http://172.21.50.12:8080/erp-services/RestWS/runJson';
       $data = array("unitName"=>"","command" => "login",
        "parameters"=>["username"=>"auto_teever","password"=>"%Teever1","guid"=>"","token"=>"","isHash"=>0,"isLdap"=>0]);
 
       $postdata = json_encode($data);
                 //return $postdata;
       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
       $result = curl_exec($ch);
       curl_close($ch);
       $token_access = json_encode($result);
       
      // return $token_access;
         
       //session()->forget(["vehicle", "owners"]);
      // session(["sessionData" => [$result] ]); 
       session()->put('sessionData',$token_access);
      // $this->serviceNTRLogin2();
 
       //  }
         
     }
     public function serviceNTRLogin2(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        // session()->forget(["sessionId"]);
       //return "fgdgdgdf";
       if($request->isMethod("POST")){
        // session()->forget(["sessionData"]);
        
         $this->serviceNTRLogin();
         $valid = $request->get("param1");
         if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
           
         //return $request;
        if (session()->has('sessionData')){
 
         $vehicle1=session()->get('sessionData');
         $data=json_decode($vehicle1);
 
        
             return $data;
         
 
        }else{
         $this->serviceNTRLogin();
        }
       }
      }
           
     }
     public function ntrLogin3(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        // session()->forget(["sessionId"]);
       // session()->forget(["sessionId"]);
       if($request->isMethod("POST")){
       
         $valid = $request->get("param3");
         $sessionId = $request->get("param1");
         $userKey = $request->get("param2");
        // return $request->valid;
         if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
        // return $userKey;
        
         $url = 'http://172.21.50.12:8080/erp-services/RestWS/runJson';
       $data = array("sessionId"=>$sessionId,"sessionUpdated"=>false,"languagecode"=>"mn","isTest"=> "",
       "command"=> "connectClient",
       "parameters"=>["userKeyId"=>$userKey],
       "userinfo"=>["ipaddress"=>"172.16.164.109"]
       );
      
 
       $postdata = json_encode($data);
                // return $postdata;
       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
       $result = curl_exec($ch);
       curl_close($ch);
       return $result;
        
            // return $sessionId;
         
 
        
       }
      }
           
     }
     public function NtrRestWS(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
            //return $request;
            try{
                $sessionId = $request->get("param1");
                $userKeyId = $request->get("param2");
                $booknumber = $request->get("param3");
                $cabin = $request->get("param4");
                $valid = $request->get("param5");
               
                if($sessionId != "" && $valid != ""){
                 
                    $valid = $request->get("param5");
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                       
                        $url = 'http://172.21.50.12:8080/erp-services/RestWS/runJson';
      $data = array("unitname"=>"",
       "command"=>"NTR_WEB_SERVICE_VEHICLE_LIST_004",
       "parameters"=>["vinCode"=>$cabin,"bookNumber"=>$booknumber],
       "sessionid"=>$sessionId
      );
    

      $postdata = json_encode($data);
             //  return $postdata;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
                        
                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }
            }catch (\Exception $ex) {
                $this->writeLog(" 연결 시 오류: " . $ex->getMessage());
                echo "<div style='color:red'> 연결 시 오류가 발생했습니다.</div>";
            }
        } else {
            return redirect(route("error"));
        }
    }
     public function NtrRestWSList(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
            //return $request;
            try{
                $sessionId = $request->get("param1");
                $userKeyId = $request->get("param2");
                $booknumber = $request->get("param3");
                $cabin = $request->get("param4");
                $valid = $request->get("param5");
               
                if($sessionId != "" && $valid != ""){
                 
                    $valid = $request->get("param5");
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                       
                        $url = 'http://172.21.50.12:8080/erp-services/RestWS/runJson';
      $data = array("command"=>"PL_MDVIEW_004",
      "parameters"=>["systemmetagroupid"=>"16139958373771","ignorePermission"=>1,"showquery"=>0,"paging" =>["offset"=>1,"pagesize"=>50],
       "criteria"=>["vinCode"=>["0"=>["operator"=>"=","operand"=>$cabin]],"bookNumber"=>["0"=>["operator"=>"=","operand"=>$booknumber]]]],
       "sessionid"=>$sessionId,"sessionupdated"=>false,"languagecode"=>"mn","istest"=>0,"userinfo"=>["ipaddress"=>"172.16.164.109"]
      );
     

      $postdata = json_encode($data);
               // return $postdata;
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
                        
                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }
            }catch (\Exception $ex) {
                $this->writeLog(" 연결 시 오류: " . $ex->getMessage());
                echo "<div style='color:red'> 연결 시 오류가 발생했습니다.</div>";
            }
        } else {
            return redirect(route("error"));
        }
    }
    //  public function getRequestList(Request $request){
    //     if(!session()->has("auth")){
    //         return response()->json(["message" => "Not valid request."], 401);
    //     }
    //     if($request->isMethod("POST")){
    //       //  return $request;
    //         try{
               
    //             $valid = $request->get("param");
               
    //             if($valid != ""){
                 
    //                 $valid = $request->get("param");
    //                 if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                      
      
    //     //return $startDate; 
    //     //return "fgfdgdfgd";
    //     $client = new nusoap_client("https://service.transdep.mn//api/WS005_VEHICLE_REGISTRATION.php?wsdl", true);

    //     $params = array();
    //      $params["last_request_id"]=0;
    //     // $params["dl_number"] = $dl_number;
    //     $params["token"] = "fbf4cbca1055f1c831b0586fa481cb7ebcd2d5bbb7ac58b501686e2dbc4a1996b199984ad36de3eb6e3a33aa43a444ace05708bd95214c381c6b0ebf83b8f08e";

    //     $result_json = $client->call('getRequestList',  $params);
    //     //$result = json_decode($result_json,'UTF8');

    //     return $result_json;
       
    //     //$json = json_decode($result_json, true);
    //             //  return $json;
                        
    //                 } else {
    //                     return redirect(route("error"));
    //                 }
    //             } else {
    //                 return redirect(route("error"));
    //             }
    //         }catch (\Exception $ex) {
    //             $this->writeLog(" 연결 시 오류: " . $ex->getMessage());
    //             echo "<div style='color:red'> 연결 시 오류가 발생했습니다.</div>";
    //         }
    //     } else {
    //         return redirect(route("error"));
    //     }
    // }
    public function getRequestList(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
          //  return $request;
            try{
               
                $valid = $request->get("param");
               
                if($valid != ""){
                 
                    $valid = $request->get("param");
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
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
                        ->where('es.is_deleted',0)
                        ->take(1000)
                        ->groupBy('es.id')
                        ->orderBy('es.id', 'desc');
                    
                    // If you want the results:
                    $data = $query->get();
                       // $data = DB::table("ESIGN_VIEW")->where('is_deleted',0)->take(1000)->OrderBy('created_date','DESC')->get();
    
                        return [ "data" => $data];
    
                        
                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }
            }catch (\Exception $ex) {
                $this->writeLog(" 연결 시 오류: " . $ex->getMessage());
                echo "<div style='color:red'> 연결 시 오류가 발생했습니다.</div>";
            }
        } else {
            return redirect(route("error"));
        }
    }
    public function numberList(Request $request){
        $number = mb_strtoupper($request->get("q"));
        if(strlen($number) > 4){
            $data = DB::table("REG_VEHICLE_VIEW")->where("PLATE_NO", "LIKE", "%".$number."%")->take(20)->get();
            return $data;
        } else {
            return null;
        }
    }

    public function service1(Request $request){ 
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        try{
            if($request->isMethod("POST"))
            {
                $fingerprint = $request->get("param1");
                $regnum = $request->get("param2");
                $valid = $request->get("param3");

                if($fingerprint != "" && $regnum != "" && $valid != ""){
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                        $client = new \SoapClient(
                           // "https://xyp.gov.mn/citizen-1.3.0/ws?WSDL",
                           '/usr/share/nginx/html/system/public/citizen.xml',
                            [
                                'soapVersion' => SOAP_1_2,
                                'stream_context' => stream_context_create([
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'allow_self_signed' => true
                                    ],

                                    'http' => [
                                        'header' => "accessToken:".$this->signingInfo['accessToken']."\r\n".
                                            "timeStamp:".$this->signingInfo['timeStamp']."\r\n".
                                            "signature:".$this->signingInfo['signature']
                                    ]
                                ])
                            ]
                        );

                        $soapParam = [
                            "auth" => [
                                "citizen" => [
                                    "fingerprint" => base64_decode($fingerprint),
                                    "regnum" => $regnum
                                ],

                                "operator" => [
                                    "regnum" => $regnum,
                                    "fingerprint" => base64_decode($fingerprint)
                                ],
                            ],
                            "regnum" => $regnum
                        ];

                        $result = $client->WS100101_getCitizenIDCardInfo(['request' => $soapParam]);

                        if($result->return->resultCode == 0){
                            $imgData = base64_encode($result->return->response->image);
                            $img = '<img style="max-width:100px;" src= "data:image/jpeg;base64, '.$imgData .'"/>';
                            unset($result->return->response->image);
                            $data = $result->return->response;
                            $html = '<div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    '.$img.'
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">본관성</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" readonly value="'.$data->surname.'" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">성, нэр</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" readonly value="'.$data->lastname.' '.$data->firstname.'" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">Яс үндэс</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" readonly value="'.$data->nationality.'" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">ИҮ хугацаа</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" readonly value="'.$data->passportExpireDate.'" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0 required-input">Төрсөн газар</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input type="text" readonly value="'.$data->birthPlace.'" class="form-control">
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0">자택 주소</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <textarea type="text" rows="2" readonly class="form-control" style="height: 59px !important;">'.str_replace("@", " ", $data->passportAddress).'</textarea>
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0">Хүйс</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input type="text" readonly value="'.$data->gender.'" class="form-control">
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0">Төрсөн 일</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input type="text" readonly value="'.date("Y-m-d", strtotime($data->birthDateAsText)).'" class="form-control">
                            </div>
                        </div>';
                            echo $html;
                        }  else if($result->return->resultCode==302) {
                            echo "<div style='color:red'>지문 정보가 일치하지 않습니다</div>";
                        } else {
                            echo "<div style='color:red'>잘못된 정보가 전송되었습니다</div>";
                        }
                    } else {
                        echo "<div style='color:red'>잘못된 정보가 전송되었습니다</div>";
                    }
                } else {
                    return redirect(route("error"));
                }
            } else {
                return redirect(route("error"));
            }
        } catch (\Exception $ex) {
            $this->writeLog("HUR 연결 시 오류: " . $ex->getMessage());
            echo "<div style='color:red'>HUR 연결 시 오류가 발생했습니다.</div>";
        }
    }

    public function service2(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
            try{
                $declaration = $request->get("param1");
                $valid = $request->get("param2");
                if($declaration != "" && $valid != ""){
                    $declaration = self::dec($request->get("param1"));
                    $valid = $request->get("param2");
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                        $client = new \SoapClient(
                          // "https://xyp.gov.mn/transport-1.3.0/ws?WSDL",
                        "/usr/share/nginx/html/system/public/transport.xml",
                            [
                                'soapVersion' => SOAP_1_2,
                                'stream_context' => stream_context_create([
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'allow_self_signed' => true
                                    ],
                                    'http' => [
                                        'header' => "accessToken:".$this->signingInfo['accessToken']."\r\n".
                                            "timeStamp:".$this->signingInfo['timeStamp']."\r\n".
                                            "signature:".$this->signingInfo['signature']
                                    ]
                                ])
                            ]
                        );
                        $payload = ['impExpDclrNo' => $declaration];
                        $result = $client->WS100411_vehicleImportInfo(array("request"=>$payload));
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);

                      

                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }
            }catch (\Exception $ex) {
                $this->writeLog("HUR 연결 시 오류: " . $ex->getMessage());
                echo "<div style='color:red'>HUR 연결 시 오류가 발생했습니다.</div>";
            }
        } else {
            return redirect(route("error"));
        }
    }
    public function otpApprove(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
            try{
                $regnum = $request->get("param1");
                $valid = $request->get("param2");
                if($regnum != "" && $valid != ""){
                
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                        $client = new \SoapClient(
                          // "https://xyp.gov.mn/meta-1.5.0/ws?WSDL",
                         "/usr/share/nginx/html/system/public/transport.xml",
                            [
                                'soapVersion' => SOAP_1_2,
                                'stream_context' => stream_context_create([
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'allow_self_signed' => true
                                    ],
                                    'http' => [
                                        'header' => "accessToken:".$this->signingInfo['accessToken']."\r\n".
                                            "timeStamp:".$this->signingInfo['timeStamp']."\r\n".
                                            "signature:".$this->signingInfo['signature']
                                    ]
                                ])
                            ]
                        );
                       // $payload = ['impExpDclrNo' => $regnum];
                       $services = array(
                        array(
                          'ws' => 'WS100101_getCitizenIDCardInfo'
                        )
                      );
                        $payload = [
                            "regnum" => $regnum,
                            "jsonWSList" => json_encode($services),
                            "isSms" => 1, "isApp"=> 1, "isEmail"=> 1, "isKiosk"=> 0, "phoneNum"=> 0
                        ]; 
                        $result = $client->WS100008_registerOTPRequest(array("request"=>$payload));
                
                       echo json_encode($result,JSON_UNESCAPED_UNICODE);
           
                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }
            }catch (\Exception $ex) {
                $this->writeLog("HUR 연결 시 오류: " . $ex);
               return $ex;
            }
        } else {
            return redirect(route("error"));
        }
    }
    public function xypClientOTP(Request $request){
       // return $request;
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
             if($request->get("param2") == null)
            return response()->json(['error' => 'otp хоосон байна!'], 400);
     

            try{
                $regnum = $request->get("param1");
                $otp = $request->get("param2");
                $valid = $request->get("param3");
           
              
                if($regnum != "" && $valid != "" && $otp != ""){
                
           
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                        try {
                            $client = new \SoapClient(
                               // "https://xyp.gov.mn/meta-1.5.0/ws?WSDL",
                             "/usr/share/nginx/html/system/public/transport.xml",
                                [
                                    'soapVersion' => SOAP_1_2,
                                    'stream_context' => stream_context_create([
                                        'ssl' => [
                                            'verify_peer' => false,
                                            'allow_self_signed' => true
                                        ],
                                        'http' => [
                                            'header' => "accessToken:".$this->signingInfo['accessToken']."\r\n".
                                            "timeStamp:".$this->signingInfo['timeStamp']."\r\n".
                                            "signature:".$this->signingInfo['signature']
                                        ]
                                    ])
                                ]
                            );
                           // $payload = ['impExpDclrNo' => $regnum];
                    
                           $payload = [
                            "auth" => [
                                "citizen" => [
                                    "civilId" => "",
                                    "regnum" => $regnum,
                                    "fingerprint" => "",
                                    "otp"=>$otp,
                                    "authType"=> 1 // 1-OTP, 2-개수н гарын үсэг, 3-Хурууны хээ
                                ],
                                "operator" => [
                                    "fingerprint" => "",
                                    "regnum" => "",
                                    "otp"=>""
                                ]
                            ],
                            "regnum" => $regnum,
                        ];
    
                        $result = $client->WS100101_getCitizenIDCardInfo(["request"=>$payload]);
                       // dd($result->return->response);
                        if($result->return->resultCode == 0){
                            $imgData = base64_encode($result->return->response->image);
                            $img = '<img style="max-width:100px;" src= "data:image/jpeg;base64, '.$imgData .'"/>';
                            unset($result->return->response->image);
                            $data = $result->return->response;
                            $html = '<div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    '.$img.'
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-12">
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">본관성</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" readonly value="'.$data->surname.'" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0">성, нэр</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" readonly value="'.$data->lastname.' '.$data->firstname.'" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">Яс үндэс</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" readonly value="'.$data->nationality.'" class="form-control">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-5">
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <label class="form-label mg-b-0 required-input">ИҮ хугацаа</label>
                                    </div>
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <input type="text" readonly value="'.$data->passportExpireDate.'" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0 required-input">Төрсөн газар</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input type="text" readonly value="'.$data->birthPlace.'" class="form-control">
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0">자택 주소</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <textarea type="text" rows="2" readonly class="form-control" style="height: 59px !important;">'.str_replace("@", " ", $data->passportAddress).'</textarea>
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0">Хүйс</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input type="text" readonly value="'.$data->gender.'" class="form-control">
                            </div>
                        </div>
                        <div class="row row-xs align-items-center mg-b-5">
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <label class="form-label mg-b-0">Төрсөн 일</label>
                            </div>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input type="text" readonly value="'.date("Y-m-d", strtotime($data->birthDateAsText)).'" class="form-control">
                            </div>
                        </div>';
                            echo $html;
                        }
                        
                      //  dd( json_encode($result->return->response,JSON_UNESCAPED_UNICODE));
                        } catch (\Throwable $th) {
                          dd($th);
                        }
                      

                
                      

                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }
            }catch (\Exception $ex) {
                $this->writeLog("HUR 연결 시 오류: " . $ex);
               return $ex;
            }
        } else {
            return redirect(route("error"));
        }
    }

 
    public function service3(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
            try{
                $plateNumber = $request->get("param1");
                $valid = $request->get("param2");
                if($plateNumber != "" && $valid != ""){
                    $plateNumber = self::dec($request->get("param1"));
                    $valid = $request->get("param2");
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                        $client = new \SoapClient(
                           // "https://xyp.gov.mn/transport-1.3.0/ws?WSDL",
                            "/usr/share/nginx/html/system/public/transport.xml",
                            [
                                'soapVersion' => SOAP_1_2,
                                'stream_context' => stream_context_create([
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'allow_self_signed' => true
                                    ],
                                    'http' => [
                                        'header' => "accessToken:".$this->signingInfo['accessToken']."\r\n".
                                            "timeStamp:".$this->signingInfo['timeStamp']."\r\n".
                                            "signature:".$this->signingInfo['signature']
                                    ]
                                ])
                            ]
                        );
                        $payload = ['plateNumber' => $plateNumber];
                        $result = $client->WS100403_getVehiclePenaltyList(array("request"=>$payload));
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }

            } catch (\Exception $ex) {
                $this->writeLog("HUR 연결 시 오류: " . $ex->getMessage());
                echo "<div style='color:red'>HUR 연결 시 오류가 발생했습니다.</div>";
            }
        } else {
            return redirect(route("error"));
        }
    }

    public function service4(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
            try{
                $plateNumber = $request->get("param1");
                $valid = $request->get("param2");
                if($plateNumber != "" && $valid != ""){
                    $plateNumber = self::dec($request->get("param1"));
                    $valid = $request->get("param2");
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                        $client = new \SoapClient(
                           // "https://xyp.gov.mn/tax-1.3.0/ws?WSDL",
                     "/usr/share/nginx/html/system/public/tax.xml",
                            [
                                'soapVersion' => SOAP_1_2,
                                'stream_context' => stream_context_create([
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'allow_self_signed' => true
                                    ],
                                    'http' => [
                                        'header' => "accessToken:".$this->signingInfo['accessToken']."\r\n".
                                            "timeStamp:".$this->signingInfo['timeStamp']."\r\n".
                                            "signature:".$this->signingInfo['signature']
                                    ]
                                ])
                            ]
                        );
                        $payload = ['plateNumber' => $plateNumber];
                        $result = $client->WS100609_getVehiclePaidTaxHistory(array("request"=>$payload));
                        echo json_encode($result,JSON_UNESCAPED_UNICODE);
                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }
            }catch (\Exception $ex) {
                $this->writeLog("HUR 연결 시 오류: " . $ex->getMessage());
                echo "<div style='color:red'>HUR 연결 시 오류가 발생했습니다.</div>";
            }
        } else {
            return redirect(route("error"));
        }
    }
    public function wayPayLogin(){
        
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        // if (!session()->has('sessionData')){
       $url = 'https://roadpay.mn/apiv1/User/LoginDirect';
      
        $attr = [
            'userName' => "atut",
            'password' => "atutG@t#"
         ];
       $postdata = json_encode($attr);
                 //return $postdata;
            

       $ch = curl_init($url);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    //   curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
       $result = curl_exec($ch);
       curl_close($ch);
      // $token_access = json_encode($result);
       return response()->json(json_decode($result));
     //  return $token_access;
         
       //session()->forget(["vehicle", "owners"]);
      // session(["sessionData" => [$result] ]); 
    //   session()->put('wayToken',$token_access);
      // $this->serviceNTRLogin2();
 
       //  }
         
     }
    
    public function service5(Request $request){
        if(!session()->has("auth")){
            return response()->json(["message" => "Not valid request."], 401);
        }
        if($request->isMethod("POST")){
            try{

                $plateNo = $request->get("param1");
           
                $valid = $request->get("param2");
                $token = $request->get("param3");
                $ownerId = $request->get("param4");
                if($plateNo != "" && $valid != "" && $ownerId != ""){

                    $owner = Owner::where("Id", $ownerId)->get()->first();

                    $plateNo = self::dec($request->get("param1"));
                    $valid = $request->get("param2");
                    if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                     //   'Authorization: Bearer ' . $token
                    //    $token=$this->wayPayLogin();
                   // return json_encode($plateNo);
                    $url = 'https://roadpay.mn/apiv1/Toll/GetNotPaidInvoiceSumRegnoAndPlatenoParam';
                    $params = array('RegNo' => $owner->register_no,'PlateNo'=>$plateNo);
                    $url = $url . '?' . http_build_query($params);
                 
                   // $url = urldecode(utf8_decode($url));
                  //  return json_encode($url);
                          //   return $url;
                        
                          //   $page = utf8_decode($url);
                   $ch = curl_init($url);
                //   curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
                   curl_setopt($ch, CURLOPT_URL, $url);
                   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                   curl_setopt($ch, CURLOPT_POST, 0);
                 //  curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                //   curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
              // return json_encode($url);
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 
                   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','charset:UTF-8', 'Authorization: Bearer ' . $token));
                
                   $result = curl_exec($ch);
                   curl_close($ch);
                  // $token_access = json_encode($result);
                  return response()->json(json_decode($result));
               // return $result;
                      

                    } else {
                        return redirect(route("error"));
                    }
                } else {
                    return redirect(route("error"));
                }
            }catch (\Exception $ex) {
                $this->writeLog("Холбогдох үед гарсан алдаа: " . $ex->getMessage());
                echo "<div style='color:red'>HUR 연결 시 오류가 발생했습니다.</div>";
            }
        } else {
            return redirect(route("error"));
        }
    }
 
 
}