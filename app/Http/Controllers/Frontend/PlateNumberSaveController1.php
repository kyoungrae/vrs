<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvince;
use App\ArchiveNumber;
use App\Http\Controllers\BaseController;
use App\MainService;
use App\MainUser;
use App\PlateNumberSave;
use App\PlateNumberSaveOrder;
use App\Owner;
use App\OwnerShip;
use App\OwnerType; 
use App\RegLimited;
use App\Series;
use App\SeriesNumber;
use App\Vehicle;
use App\VehicleArchive;
use App\SystemPrinter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Matrix\Exception;
use LaravelQRCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class PlateNumberSaveController extends BaseController
{

    public function indexSavePlate(Request $request) 
    {
        //return "gjhjhg";
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
       // dd(session()->get("auth")->userpositionid);
        if(!$this->checkAccess("/plateSave", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
      //  $plateNumberSaveList = DB::table("PLATESAVEVIEW")->get();
       try {
        if($request->isMethod("POST")){
            $plateNo = trim($request->get("plateNo"));
            $regNo = trim($request->get("regNo"));
            if ($regNo == "" && $plateNo =="") {
                $plateNumberSaveList =  DB::table('REG_PLATENUMBER_SAVE')
                ->join('SYSTEM_USER', 'REG_PLATENUMBER_SAVE.CREATED_BY', '=', 'SYSTEM_USER.ID')
                ->select('REG_PLATENUMBER_SAVE.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                ->where("REG_PLATENUMBER_SAVE.IS_ACTIVE",1)
               
                ->select('REG_PLATENUMBER_SAVE.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                ->orderBy('REG_PLATENUMBER_SAVE.id', 'desc')
                ->take(2000)
                ->get();
                
                
                        return view('System.plateNumberSave', compact('plateNumberSaveList'));
            } else {
                if ($plateNo !="") {
                $plateNumberSaveList =  DB::table('REG_PLATENUMBER_SAVE')
                      ->join('SYSTEM_USER', 'REG_PLATENUMBER_SAVE.CREATED_BY', '=', 'SYSTEM_USER.ID')
                      ->select('REG_PLATENUMBER_SAVE.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                      ->where("REG_PLATENUMBER_SAVE.IS_ACTIVE",1)
                      ->where('plate_no', $plateNo)
                      ->select('REG_PLATENUMBER_SAVE.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                      ->get();
                }else{
                    $plateNumberSaveList =  DB::table('REG_PLATENUMBER_SAVE')
                    ->join('SYSTEM_USER', 'REG_PLATENUMBER_SAVE.CREATED_BY', '=', 'SYSTEM_USER.ID')
                    ->select('REG_PLATENUMBER_SAVE.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                    ->where("REG_PLATENUMBER_SAVE.IS_ACTIVE",1)
                    ->where('REG_PLATENUMBER_SAVE.CUSTOMER_REGNUM',$regNo)
                    ->select('REG_PLATENUMBER_SAVE.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                    ->get();
            }
            return view('System.plateNumberSave', compact('plateNumberSaveList','plateNo','regNo'));
            }
            
            
        }else{
            $plateNumberSaveList =  DB::table('REG_PLATENUMBER_SAVE')
            ->join('SYSTEM_USER', 'REG_PLATENUMBER_SAVE.CREATED_BY', '=', 'SYSTEM_USER.ID')
            ->select('REG_PLATENUMBER_SAVE.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
            ->where("REG_PLATENUMBER_SAVE.IS_ACTIVE",1)
           
            ->select('REG_PLATENUMBER_SAVE.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
            ->orderBy('REG_PLATENUMBER_SAVE.id', 'desc')
            ->take(2000)
            ->get();
            
            
                    return view('System.plateNumberSave', compact('plateNumberSaveList'));
        }
       } catch (\Exception $ex) {
        DB::rollBack();
        $this->writeLog("error: ".$ex);
        $message = $this->message("danger", " 오류가 발생했습니다.");
      
       }
        
 
    }

    public function plateNumberOrderList(Request $request) 
    {
        //return "gjhjhg";
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
       // dd(session()->get("auth")->userpositionid);
        if(!$this->checkAccess("/plateSave/plateNumberOrderList", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        try {
            if($request->isMethod("POST")){

               // return $request;
                $plateNo = trim($request->get("plateNo"));
                $regNo = trim($request->get("regNo"));

                if ($regNo == "" && $plateNo =="") {
                    $plateNumberOrderList =  DB::table('REG_PLATENUMBER_SAVE_ORDER')
                    ->join('SYSTEM_USER', 'REG_PLATENUMBER_SAVE_ORDER.CREATED_BY', '=', 'SYSTEM_USER.ID')
        
                    ->select('REG_PLATENUMBER_SAVE_ORDER.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                    
                    ->orderBy('REG_PLATENUMBER_SAVE_ORDER.ID','DESC')
                    ->take(2000)
                    ->get();
                    return view('System.plateOrderList', compact('plateNumberOrderList'));
                } else {
                    if ($plateNo !="") {
                        $plateNumberOrderList =  DB::table('REG_PLATENUMBER_SAVE_ORDER')
                               ->join('SYSTEM_USER', 'REG_PLATENUMBER_SAVE_ORDER.CREATED_BY', '=', 'SYSTEM_USER.ID')
                   
                               ->select('REG_PLATENUMBER_SAVE_ORDER.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                               ->where('REG_PLATENUMBER_SAVE_ORDER.PLATE_NO', $plateNo)
                               ->orderBy('REG_PLATENUMBER_SAVE_ORDER.ID','DESC')
                               ->get();
                        }else{
                            $plateNumberOrderList =  DB::table('REG_PLATENUMBER_SAVE_ORDER')
                              ->join('SYSTEM_USER', 'REG_PLATENUMBER_SAVE_ORDER.CREATED_BY', '=', 'SYSTEM_USER.ID')
                  
                              ->select('REG_PLATENUMBER_SAVE_ORDER.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                              ->where('REG_PLATENUMBER_SAVE_ORDER.CUSTOMER_REGNUM', $regNo)
                              ->orderBy('REG_PLATENUMBER_SAVE_ORDER.ID','DESC')
                              ->get();
                    }
                    return view('System.plateOrderList', compact('plateNumberOrderList','plateNo','regNo'));
                }
                

            }else{
                $plateNumberOrderList =  DB::table('REG_PLATENUMBER_SAVE_ORDER')
                ->join('SYSTEM_USER', 'REG_PLATENUMBER_SAVE_ORDER.CREATED_BY', '=', 'SYSTEM_USER.ID')
    
                ->select('REG_PLATENUMBER_SAVE_ORDER.*', 'SYSTEM_USER.LASTNAME', 'SYSTEM_USER.FIRSTNAME')
                
                ->orderBy('REG_PLATENUMBER_SAVE_ORDER.ID','DESC')
                ->take(2000)
                ->get();
    
    //return $plateNumberOrderList;
          //  $plateNumberOrderList = PlateNumberSave::where("IS_ACTIVE", 0)->orderBy("create_date", "DESC")->get();
            return view('System.plateOrderList', compact('plateNumberOrderList'));

            }
            } catch (\Exception $ex) {
        DB::rollBack();
        $this->writeLog("error: ".$ex);
        $message = $this->message("danger", " 오류가 발생했습니다.");
      
       }

      
    }
    public function indexSavePlateStore(Request $request)
    {
        //return "gjhjhg";
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
       // dd(session()->get("auth")->userpositionid);
        if(!$this->checkAccess("/plateSave/indexSavePlateStore", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try {
            if($request->isMethod("POST")){
            }else{
                $auction=[];
            
                return view('System.plateNumberSaveStore', compact('auction'));
            }
        
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->writeLog("error: ".$ex);
            $message = $this->message("danger", " 오류가 발생했습니다.");
          
        }
     
    }
    public function plateOrderCancel(Request $request){
     
        if(!session()->has("auth")){ 
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/plateSave/plateNumberOrderList", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            //return $request;
            $plateNumberOrderList =  DB::table('REG_PLATENUMBER_SAVE_ORDER')
            ->select('*')
            ->where('id', $request->plateSaveId)
            ->get();
            $plateNumberSaveList =  DB::table('REG_PLATENUMBER_SAVE')
            ->select('*')
            ->where('plate_no', $plateNumberOrderList[0]->plate_no)
            ->where('is_active',0)
            ->orderBy('id','desc')
            ->get() ;
         //  return $plateNumberSaveList;
if (count($plateNumberOrderList) > 0) {
   // return $request->plateCabin;
    $orderCancel= SeriesNumber::where("NAME", $plateNumberOrderList[0]->plate_no)->where("ORDER_CABIN",$request->plateCabin)->update([

        'IS_ORDER' => 0,
        'ORDER_USER' => 'ДХ',
        'ORDER_DATE' => null, 
        'IS_OPENED' =>1,
        'IS_GIVEN' => 0,
        'IS_HIDDEN' => 1,
        'IS_AUTO' => 1,
        'IS_SAVE' => 1,
        'IS_LOCAL' => 0,
        'ORDER_CABIN'=> null,
     
       
    ]);
    if ($orderCancel) {
       // foreach ($plateNumberSaveList as $record) {
            plateNumberSave::where('id',$plateNumberSaveList[0]->id)->update([
            'IS_ACTIVE' => 1
           
        ]);
   // }
 
}
   $plateNumberSaveOrder= DB::table('reg_platenumber_save_order')->where('id', $plateNumberOrderList[0]->id)->delete();

   
 //return $plateNumberSaveOrder;
    if ($plateNumberSaveOrder) {
        $message = $this->message("success", "Захиалга ам년ттай цуцлагдлаа.");
        //   return $request;
           return redirect(url('/plateSave/plateNumberOrderList'))->with("message", $message);
       //  return redirect(url('/plateSave/plateNumberOrderList'))->with("message", $message);
        // return view('System.plateOrderList', compact('message'));
    }
}
          //return $plateNumberOrderList;
           
       }catch (\Exception $ex) {
        DB::rollBack();
        $this->writeLog("error: ".$ex);
        $message = $this->message("danger", " 오류가 발생했습니다.");
      
    }
    }
    public function plateSaveOrder(Request $request)
    {
        //return "gjhjhg";
        if(!session()->has("auth")){ 
            return redirect(route($this->redirectURL));
        }

       // dd(session()->get("auth")->userpositionid);
        if(!$this->checkAccess("/plateSave/plateNumberSaveOrder", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try {
        
            if($request->isMethod("POST")){
               
                $plate_no = trim($request->get("plateNo"));
                $customerRegNum = trim($request->get("customerRegnum"));
                $customerLastname = trim($request->get("customerLastname"));
                $customerFirstname = trim($request->get("customerFirstname"));
                $orderCabin = trim($request->get("customerOrderCabin"));
               // return $customerRegNum;
             
                $userPkId = session()->get("auth")->id;
              
         

                $plateNumberSave = PlateNumberSave::where("plate_no",$plate_no)->get();
                // $plateOrder = DB::table('reg_platenumber_save')
                // ->where('plate_no', $plate_no)
                // ->update([  'IS_ACTIVE' => 0,                              
                  
                   
                // 'UPDATED_BY' => $userPkId,
                // 'UPDATE_DATE' => Carbon::now(),]);
           
               
                        foreach ($plateNumberSave as $record) {
                            $updateOptions = plateNumberSave::where('id', $record->id)->update([
                                'IS_ACTIVE' => 0
                               
                            ]);
                        //     $record = plateNumberSave::find($record->id);

                        //    // return $record;
                        //     $record->is_active = 0;
                        //     $record->save();
                           // dd($record->id);
                        //    DB::table('reg_platenumber_save')
                        //     ->where('id', $record->id)
                        //     ->update([  'IS_ACTIVE' => 0,                              
                        //   ]);
                        }
            
        
            //  $test=   PlateNumberSave::where("PLATE_NO", $plate_no)->update([
            //         'IS_ACTIVE' => 0,                              
                    
                   
            //         'UPDATED_BY' => $userPkId,
            //         'UPDATE_DATE' => Carbon::now(),
            //     ]);
            //     return $test;
         //   if (  $plateOrder) {
           $order= SeriesNumber::where("NAME", $plate_no)->where("ORDER_USER","ДХ")->update([

                    'IS_ORDER' => 1,
                    'ORDER_USER' => $customerRegNum,
                    'ORDER_DATE' => Carbon::now(), 
                    'IS_OPENED' =>1,
                    'IS_GIVEN' => 0,
                    'IS_HIDDEN' => 0,
                    'IS_AUTO' => 1,
                    'IS_SAVE' => 0,
                    'IS_LOCAL' => 0,
                    'ORDER_CABIN'=>$orderCabin,
                    'VEHICLE_ID' => null,
                   
                ]);

           
                
             
        //    }
      //  return $order;
        if ($order) {
            PlateNumberSaveOrder::create([ 
                'PLATE_NO' => $plateNumberSave[0]->plate_no,                              
                'CABIN'=>$orderCabin,
                'CUSTOMER_REGNUM'=>$customerRegNum, 
                'CUSTOMER_LASTNAME'=>$customerLastname,
                'CUSTOMER_FIRSTNAME'=>$customerFirstname,
             
              
                'CREATED_BY' => $userPkId,
                'CREATE_DATE' => Carbon::now(),
                
            ]);
            $message = $this->message("success", "번호가 성공적으로 주문되었습니다.");
            //   return $request;
               return redirect(url('/plateSave'))->with("message", $message);
     
             } else {
                $message = $this->message("warning", "Дугаар захиалхад алдаа гарлаа өөр тх-дээр захиалсан байна.");
                //   return $request;
                   return redirect(url('/plateSave'))->with("message", $message);
             }
            
         
     
            }else{
                $auction=[];
            
                return view('System.plateNumberSaveOrder', compact('auction'));
            }
        
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->writeLog("error: ".$ex);
            $message = $this->message("danger", " 오류가 발생했습니다.");
          
        }
     
    }
    public function plateSaveEdit(Request $request)
    {
        //return "gjhjhg";
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
       // dd(session()->get("auth")->userpositionid);
        if(!$this->checkAccess("/plateSave/indexSavePlateStore", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try {
          //  return $request;
            if($request->isMethod("POST")){
                $plate_no = trim($request->get("plateNo"));
                $customerRegNum = trim($request->get("customerRegnum"));
                $customerLastName = trim($request->get("customerLastname"));
                $customerFirstName = trim($request->get("customerFirstname"));
                $customerPhoneNumber = trim($request->get("customerPhoneNumber"));
                $beginDate = trim($request->get("startDate"));
                $endDate = trim($request->get("endDate"));
               // return $this->dec($request->id);
               $userPkId = session()->get("auth")->id;
               $service = $this->getActionPrefix(27);
             //  $seriesNumber = SeriesNumber::where("name", $request->plateNo)->where("is_save", 1)->get();
            // $seriesNumber = SeriesNumber::where("name", $request->plateNo)->where("is_save", 0)->get();
             $plateNumberSave = PlateNumberSave::where("plate_no", $request->plateNo)->where("is_active", 1)->where("extend_count", 1)->orWhere("extend_count", null)->get();

           
             if (count($plateNumberSave) > 0 ) {
                $plateNumberSave = $plateNumberSave->first();
          
            $extend=    PlateNumberSave::where("ID", $plateNumberSave->id)->update([
                 
                    //'IS_ACTIVE'=>0,
                    'EXTEND_COUNT'=>0,
                    'UPDATED_BY' => $userPkId,
                    'UPDATE_DATE' => Carbon::now(),
                ]);
              
              //  return $extend;
                if ($extend) {
              //   return $request;
                    PlateNumberSave::create([ 
                        'PLATE_NO' => $plateNumberSave->plate_no,                              
                        'ARCHIVE_NUMBER' => $this->archiveNumberGenerate($service),
                        'CUSTOMER_REGNUM'=>$plateNumberSave->customer_regnum, 
                        'CUSTOMER_LASTNAME'=>$plateNumberSave->customer_lastname,
                        'CUSTOMER_FIRSTNAME'=>$plateNumberSave->customer_firstname,
                        'CUSTOMER_PHONE'=>$plateNumberSave->customer_phone,
                        'BEGIN_DATE'=>$beginDate,
                        'IS_ACTIVE'=>1,
                        'EXTEND_COUNT'=>0,
                        'END_DATE'=>$endDate,
                        'CREATED_BY' => $userPkId,
                        'CREATE_DATE' => Carbon::now(),
                        
                    ]);
                }
              
                 $message = $this->message("success", "Мэдээлэл ам년ттай засагдлаа.");
                 //   return $request;
                    return redirect(url('/plateSave'))->with("message", $message);
            }else{
                $message = $this->message("danger", "Сунгах эрх дууссан байна.");
                //   return $request;
                   return redirect(url('/plateSave'))->with("message", $message);
            }
              //  $series_number=$seriesNumber->first();
             //   DB::update("UPDATE SERIES_NUMBER SET IS_HIDDEN=1, IS_SAVE=1,ORDER_USER='ДХ'  WHERE ID= $series_number->id AND IS_HIDDEN=0 AND IS_SAVE=0 ");
       
            }else{
               // $auction=[];
                //$id = $request->route("id");
              
               // $curr_saved_data = PlateNumberSave::where("Id", $this->dec($id))->get()->first();

              // return $curr_saved_data;
                return view('System.plateNumberSaveEdit');
            }
        
        } catch (\Exception $ex) { 
            DB::rollBack();
            $this->writeLog("error: ".$ex);
            $message = $this->message("danger", " 오류가 발생했습니다.");
          
        }
     
    }
    public function plateEditCheck(Request $request)
    {
        //return "gjhjhg";
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
       // dd(session()->get("auth")->userpositionid);
        if(!$this->checkAccess("/plateSave/edit", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try {
            if($request->isMethod("POST")){
                $valid=$request->param2;
                if(self::dec($valid) == Carbon::now()->format("Y-m-d")){
                $plateNumberSave = PlateNumberSave::where("plate_no",$request->param1)->where("is_active",1)->get()->first();
                return $plateNumberSave;
                }
            }else{
               // $auction=[];
                //$id = $request->route("id");
              
               // $curr_saved_data = PlateNumberSave::where("Id", $this->dec($id))->get()->first();

              // return $curr_saved_data;
             //   return view('System.plateNumberSaveEdit');
            }
        
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->writeLog("error: ".$ex);
            $message = $this->message("danger", " 오류가 발생했습니다.");
          
        }
     
    }
    public function plateSaveStore(Request $request)
    {
        //return "gjhjhg";
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL)); 
        }
       // dd(session()->get("auth")->userpositionid);
        if(!$this->checkAccess("/plateSave/indexSavePlateStore", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try {
           // return $request;
            $userPkId = session()->get("auth")->id;
            if($request->isMethod("POST")){
              //  $env = $request->get("env");
             //   return $env;
                $plate_no = trim($request->get("plateNo"));
                $customerRegNum = trim($request->get("customerRegnum"));
                $customerLastName = trim($request->get("customerLastname"));
                $customerFirstName = trim($request->get("customerFirstname"));
                $customerPhoneNumber = trim($request->get("customerPhoneNumber"));
                $beginDate = trim($request->get("startDate"));
                $endDate = trim($request->get("endDate"));
               // return $request;
                $service = $this->getActionPrefix(27);
              //  return $request;
               // $archive=$this->archiveNumberGenerate($service);
            //   return $this->archiveNumberGenerate($service);
               // $vehicle = Vehicle::where("plate_no", $request->plateNo)->get();
                $seriesNumber = SeriesNumber::where("name", $request->plateNo)->where("is_save", 0)->get();
                $plateNumberSave = PlateNumberSave::where("plate_no", $request->plateNo)->where("is_active", 1)->get();

               
                    if (count($seriesNumber) > 0 && count($plateNumberSave) == 0) {

                        PlateNumberSave::create([ 
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
                    SeriesNumber::where("ID", $series_number->id)->update([

               
                        'ORDER_USER' => "ДХ",
                       
                       
                        'IS_HIDDEN' => 1,
                        'IS_SAVE' => 1,
                       
                       
                    ]);
                      //  DB::update("UPDATE SERIES_NUMBER SET IS_HIDDEN=1, IS_SAVE=1,ORDER_USER='ДХ'  WHERE ID= $series_number->id");
                        $message = $this->message("success", "번호판 ам년ттай хадаглагдлаа.");
                        return redirect(url('/plateSave'))->with("message", $message);
                    }else{
                        $message = $this->message("danger", "번호판 хадгалсан байна.");
                        return redirect(url('/plateSave'))->with("message", $message);
                    }
               
            }
        
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->writeLog("error: ".$ex);
            $message = $this->message("danger", " 오류가 발생했습니다.");
          
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
          
     //  return $archive_prefix;
            $archive = DB::select("SELECT * FROM ARCHIVE_NUMBER WHERE ABBR = '".$archive_department_abbr."' AND ARCHIVE_DEPARTMENT_ID = ".$archive_department_id." AND YEAR =".$current_year." AND MONTH = ".$current_month." FOR UPDATE");

//return $archive;
           
       
            if($archive_prefix == "ДХ"){
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
    public function getActionPrefix($service){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $service = MainService::where("Id", $service)->get()->first();
        return $service;
    }
//     public function auction(Request $request){
 
//                         if(!session()->has("auth")){
//                             return redirect(route($this->redirectURL));
//                         }
//                         if(!$this->checkAccess("/auction", $this->enc(session()->get("auth")->userpositionid))){
//                             return redirect(route($this->redirectAccess));
//                         }
                       
//                         try{
                    
     
//        if($request->isMethod("POST")){
//         $userPkId = session()->get("auth")->id;
//          $plateNo = trim($request->get("plateNo"));
//          $register = trim($request->get("register"));
//          $cabin = trim($request->get("cabin"));
//        // return $request;
//          $checkSeir = SeriesNumber::where(["name"=>$plateNo,"order_user"=>"Auction", "is_given"=>0,"is_hidden"=>1,"is_order"=>1])->get();

        
// if (count($checkSeir) > 0) {
//     # code...
//    // return $checkSeir[0];
//         $auctioOrder= SeriesNumber::where("ID", $checkSeir[0]->id)->update([
//             'order_user' => $register,
//             'is_hidden' => 0,
//             'order_cabin' => $cabin,
//             'order_date' => Carbon::now()->format("Y-m-d H:i:s"),
//             'Created_By_Id' => $userPkId,
//             'Updated_By_Id' => $userPkId
//         ]);
//         if ($auctioOrder) {
//             # code...
        
//       $message = $this->message("success", "번호가 성공적으로 주문되었습니다.");
//       return view('System.auction',compact("message"));
//          }
//         }else{
//             $message = $this->message("danger", "Уг дугаарыг олгосон байна.");
//             return view('System.auction',compact("message"));
//          }  
        
//      } else {
//          $auction=[];
//          return view('System.auction', compact('auction'));
//      }
//                         } catch (\Exception $ex){
//                             $this->writeLog("차량 화면 호출 오류: ".$ex->getMessage());
//                             $message = $this->message("danger", "화면을 불러오는 중 오류가 발생했습니다.");
//                             return view('System.auction', compact("message"));
//                         }
//     }
}