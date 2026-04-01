<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvince;
use App\ArchiveNumber;
use App\Http\Controllers\BaseController;
use App\MainService;
use App\MainUser;
use App\Owner;
use App\OwnerShip;
use App\OwnerType;
use App\RegLimited;
use App\Series;
use App\SeriesNumber;
use App\Vehicle;
use App\Transaction;
use App\VehicleArchive;
use App\SystemPrinter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Matrix\Exception;
use LaravelQRCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class PaymentController extends BaseController
{
    public function payment(Request $request){
 
                        if(!session()->has("auth")){
                            return redirect(route($this->redirectURL));
                        }
                        if(!$this->checkAccess("/payment", $this->enc(session()->get("auth")->userpositionid))){
                            return redirect(route($this->redirectAccess));
                        }
                       
                        try{
                    
     
       if($request->isMethod("POST")){
        $userPkId = session()->get("auth")->id;
         $description = trim($request->get("submitData"));
       
         $id = trim($request->get("transactionId"));
         Transaction::where("Id", $id)->update([
            'DESCRIPTION' => $description,
           
        ]);
        $message = $this->message("success"," ам년ттай засагдлаа.");
                                            return redirect(url('/payment/'))->with("message", $message);
        
        
     } else {
        // $payment=[];
         $payment = DB::select(DB::raw("select tr.id,epay.id, epay.vehicle_id, tr.account_number,tr.related_account,tr.description,tr.amount,tr.owner_name,tr.transaction_date,tr.arkhive_no,epay.arkhive_no,epay.created_at,
         epay.pay_type_name,service.name
          from transaction tr join epay_transaction epay on tr.id=epay.transaction_id join system_service service on service.id = epay.service_id where type=1"));
        //  return $payment;
      
         return view('System.payment', compact('payment'));
     }
                        } catch (\Exception $ex){
                            $this->writeLog("차량 화면 호출 오류: ".$ex->getMessage());
                            $message = $this->message("danger", "화면을 불러오는 중 오류가 발생했습니다.");
                            return view('System.payment', compact("message"));
                        }
    }
    public function plateSavePay(Request $request){
 
                        if(!session()->has("auth")){
                            return redirect(route($this->redirectURL));
                        }
                        if(!$this->checkAccess("/plateSavePay", $this->enc(session()->get("auth")->userpositionid))){
                            return redirect(route($this->redirectAccess));
                        }
                       
                        try{
                    
     
    
        // $payment=[];
         $payment = DB::select(DB::raw("select tr.id, tr.account_number,tr.related_account,tr.description,tr.amount,tr.owner_name,tr.transaction_date,tr.arkhive_no
         from transaction tr  where type=2"));
         // return $payment;
      
         return view('System.plateSavePay', compact('payment'));
    
                        } catch (\Exception $ex){
                            $this->writeLog("차량 화면 호출 오류: ".$ex->getMessage());
                            $message = $this->message("danger", "화면을 불러오는 중 오류가 발생했습니다.");
                            return view('System.plateSavePay', compact("message"));
                        }
    }
}