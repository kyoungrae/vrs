<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\SystemPlateFactory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlateFactoryController extends BaseController
{
    public function index(Request $request){
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/plate/print", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $userPkId = session()->get("auth")->id;
        $types = DB::table("VEHICLE_TYPE")->get();
        try{
            if($request->isMethod("POST")){ 
                $plate_no = $request->get("plate");
                $plate_type = $request->get("type");
                //$plateColor = $request->get("plateColor");
                $number = SystemPlateFactory::where("PLATE_NO", $plate_no)->where("TYPE_ID", $plate_type)->where("IS_PRINT", 0)->orderBy("create_date","desc")->first();
               // return $number;
               $plateId=$number->id;
               $plateNo=$number->plate_no;
               $plateType=$number->type_id;

                if($number->count() > 0){
                    SystemPlateFactory::where("Id", $plateId)->where("PLATE_NO", $plateNo)->where("TYPE_ID", $plateType)->where("IS_PRINT", 0)->update([
                        'PRINT_ID' => $userPkId,
                        'IS_PRINT' => 1,
                       // 'PLATECOLOR' =>$plateColor,
                        'UPDATE_DATE' => Carbon::now()
                    ]);
                    $message = $this->message("success", $plate_no." 번호판 성공적으로 хэвлэгдлээ.");
                } else {
                    $message = $this->message("info", $plate_no." 번호판 찾을 수 없습니다 다시 шалгана уу!");
                }
                $numbers = SystemPlateFactory::where("PRINT_ID", $userPkId)->where("IS_PRINT", 1)->orderBy("UPDATE_DATE")->get();
                return view("System.platefactory", compact('types', 'numbers', 'message'));
            } else {
                $numbers = SystemPlateFactory::where("PRINT_ID", $userPkId)->where("IS_PRINT", 1)->orderBy("UPDATE_DATE")->get();
                return view("System.platefactory", compact('types', 'numbers'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Print plate error: ".$ex->getMessage());
            $message = $this->message("danger", "번호판 출력эд 오류가 발생했습니다.");
            $numbers = SystemPlateFactory::where("PRINT_ID", $userPkId)->where("IS_PRINT", 1)->orderBy("UPDATE_DATE")->get();
            return view("System.platefactory", compact('types', 'numbers', 'message'));
        }
    }

    public function checkPrintPlate(Request $request){
        try{
            $plate_no = $request->get("plate");
            $plate_type = $request->get("type");
            $numbers = SystemPlateFactory::where("PLATE_NO", $plate_no)->where("TYPE_ID", $plate_type)->where("IS_PRINT", 0)->orderBy("create_date","desc")->first();
           // if($numbers->count() > 0){
                return $numbers;
           // } else {
           ///     return "false";
           // }
        } catch (\Exception $ex){
            $this->writeLog("Print plate check error: ".$ex->getMessage());
            return "false";
        }
    }
}
