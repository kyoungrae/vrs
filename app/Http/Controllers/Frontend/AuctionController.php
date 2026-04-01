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
use App\VehicleArchive;
use App\SystemPrinter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Matrix\Exception;
use LaravelQRCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class AuctionController extends BaseController
{
    public function auction(Request $request){
 
                        if(!session()->has("auth")){
                            return redirect(route($this->redirectURL));
                        }
                        if(!$this->checkAccess("/auction", $this->enc(session()->get("auth")->userpositionid))){
                            return redirect(route($this->redirectAccess));
                       }
                       
                        try{
                    
     
       if($request->isMethod("POST")){
        $userPkId = session()->get("auth")->id;
         $plateNo = trim($request->get("plateNo"));
         $register = trim($request->get("register"));
         $cabin = trim($request->get("cabin"));
       // return $request;
         $checkSeir = SeriesNumber::where(["name"=>$plateNo,"order_user"=>"Auction", "is_given"=>0,"is_hidden"=>1,"is_order"=>1])->get();

        
if (count($checkSeir) > 0) {
    # code...
   // return $checkSeir[0];
        $auctioOrder= SeriesNumber::where("ID", $checkSeir[0]->id)->update([
            'order_user' => $register,
            'is_hidden' => 0,
            'order_cabin' => $cabin,
            'order_date' => Carbon::now()->format("Y-m-d H:i:s"),
            'Created_By_Id' => $userPkId,
            'Updated_By_Id' => $userPkId
        ]);
        if ($auctioOrder) { 
            # code...
        
      $message = $this->message("success", "번호가 성공적으로 주문되었습니다.");
      return view('System.auction',compact("message"));
         }
        }else{
            $message = $this->message("danger", "해당 번호가 발급되었습니다.");
            return view('System.auction',compact("message"));
         }  
        
     } else {
         $auction=[];
         return view('System.auction', compact('auction'));
     }
                        } catch (\Exception $ex){
                            $this->writeLog("차량 화면 호출 오류: ".$ex->getMessage());
                            $message = $this->message("danger", "화면을 불러오는 중 오류가 발생했습니다.");
                            return view('System.auction', compact("message"));
                        }
    }
}