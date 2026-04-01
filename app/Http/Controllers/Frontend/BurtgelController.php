<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use App\SeriesNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BurtgelController extends BaseController
{
    /**
     * Дугаар хайлтын хэсгийн нүүр хуудас
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexBurtgel(Request $request, $type = 0)
    {
        try{
          //  dd($request);
            $provinceID = 0;
            $user_position_id = session()->get("auth")->userpositionid;
       
            $province = DB::table("ADDRESS_PROVINCE")
                ->where("ABBR", '!=', null)
                ->where("NAME", '!=', "УБ")
                ->orderby("NAME", "ASC")
                ->get();

            //1 жагсаалтанд хэдээр гаргах тоо
            $limitPerDay = 50;
            $selectPerDay = 50;

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
                $seriesNumberId = $request->get("seriesNumberId");
                $provinceID = $request->get("provi");

                //Дугаар хайлтын оронгууд
                $d1 = ""; 
                $d2 = "";
                $d3 = "";
                $d4 = "";
                if ($seriesNumberId != null && $seriesNumberId != "") {
                    if (Session::token() != $request->get("_token")) {
                        $message = $this->message("warning", "Захиалга ам년тгүй боллоо.");
                        return view('Touch.burtgel', compact('limitPerDay', 'province', 'provinceID', 'type', 'message'));
                    }

                    $rules = ['captcha' => 'required|captcha'];
                    $validator = validator()->make(request()->all(), $rules);
                    if ($validator->fails()) {
                        $message = $this->message("info", "Баталгаажуулах код буруу байна.");
                        return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                    } else {
                        $seriesNumberId = self::dec($seriesNumberId);
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
                                $message = $this->message("warning", "등록번호를 올바르게 입력하세요.");
                                return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                            }
                            $postfix = "=01";
                        }

                        //Регистр бичсэн эсэх
                        if($option == "foreign"){
                            $check_foreign = SeriesNumber::where("IP_ADDRESS", $request->ip().$postfix)->where("IS_GIVEN", 0)->where("IS_ORDER", (int)1)->get();
                            if ($check_foreign->count() > 20000) {
                                $message = $this->message("warning", "Захиалга ам년тгүй боллоо.");
                                return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                            }
                        } else {
                            if ($r1 == 0 && $r2 == 0 && $r3 == 0 && $r4 == 0 && $r5 == 0 && $r6 == 0 && $r7 == 0 && $type == null) {
                                $message = $this->message("warning", "등록번호를 올바르게 입력하세요.");
                                return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
                            }
                        }

                        //섬 бичсэн эсэх
                        if ($aral == "00000" && $type == null) {
                            $message = $this->message("warning", "Та арлын дугаараа зөв оруулна уу.");
                            return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
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
                            $message = $this->message("warning", "Таны өнөөдрийн захиалга хийх эрх дууссан байна.");
                            return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
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
                            $message = $this->message("warning", "Дугаар захиалагдсан байна. Та өөр дугаар захиална уу.");
                            return view('Touch.burtgel', compact( 'limitPerDay', 'province', 'provinceID', 'type', 'message'));
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
                                'ORDER_DATE' => $order_date,
                                'ORDER_USER' => $register,
                                'IP_ADDRESS' => $request->ip().$postfix,
                                'IP_INFO' => $request->userAgent(),
                                'ORDER_CABIN' => $aral
                            ]);

                            $message_info = '<table class="table table-bordered" style="font-size: 16px;"><tbody><tr><th><div>Захиалсан дугаар</div></th><th><div>'.$numberText.'</div></th></tr><tr><th><div>등록번호</div></th><th><div>'.$register.'</div></th></tr><tr><th><div>차체번호</div></th><th><div>'.$aral.'</div></th></tr><tr><th><div>주문 일자</div></th><th><div>'.$order_date.'</div></th></tr><tr><th><div>Хүчинтэй огноо</div></th><th><div>'.Carbon::parse($order_date)->addDay(1).'</div></th></tr></tbody></table>';
                            $message = $this->message("success", '24 цагийн хугацаанд хүчинтэй.<br>'.$message_info.'<div style="color:red">Захиалгын мэдээллийг баталгаажуулах үүднээс дэлгэцийн зургийг дарж авна уу!</div>');
                            return view('Touch.burtgel', compact('limitPerDay', 'province', 'provinceID', 'type', 'message'));
                        }
                    }
                }

                $seriesId = $request->get("series");
                $seriesModal = $request->get("seriesModal");
                if (($seriesId != "" && $seriesId != null) || ($seriesModal != "" || $seriesModal != null)) {
                    $seriesId = self::seriesIdDec($seriesId);
                    $d1 = $request->get("d1");
                    $d2 = $request->get("d2");
                    $d3 = $request->get("d3");
                    $d4 = $request->get("d4");

                    $searchNumber = $d1 . $d2 . $d3 . $d4;
                    //Дугаар хайх товч дарсан эсэх
                    if($searchNumber == "0000") {
                        $all_numbers = $this->selectNumbers($seriesId, $user_position_id);
                        $numbers = $this->boardNumbers($all_numbers, $selectPerDay, "all");
                    }
                    else {
                        //Дугаар хайлт
                        $searchNumber = preg_replace("/[^0-9]/", "", $searchNumber);
                        $all_numbers = $this->selectSearchNnumber($seriesId, $searchNumber, $user_position_id);
                        $numbers = $this->boardNumbers($all_numbers, $selectPerDay, "search");
                    }
                    if($seriesId != "" && $seriesId != null){
                        $tmp_series_id = $seriesId;
                        $seriesId = self::seriesIdEnc($seriesId);
                    } else {
                        $tmp_series_id = 22;
                        $seriesId = self::seriesIdEnc(22);
                    }
                    return view('Touch.burtgel', compact('seriesId', 'tmp_series_id', 'numbers', 'limitPerDay', 'province', 'provinceID', 'd1', 'd2', 'd3', 'd4', 'searchNumber', 'type'));
                } else {
                    return view('Touch.burtgel',compact('limitPerDay','province', 'provinceID', 'type'));
                }
            } else {
                return view('Touch.burtgel',compact('limitPerDay','province', 'provinceID', 'type'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Дугаар захиалга алдаа гарлаа: ".$ex);
            return redirect(url("/"));
        }
    }

    public function dateCalc($row){
        if($row->show_date == null || strlen($row->show_date) < 10){
            $enc = \App\Http\Controllers\BaseController::enc("'".Carbon::now()->addDay(-1)."'");
        } else {
            $enc = $row->show_date;
        }
        $nowTime = Carbon::now()->format("Y-m-d H:i:s");
        $timediff = strtotime($nowTime) - strtotime(\App\Http\Controllers\BaseController::dec($enc));
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

    public function selectNumbers($seriesId, $position){
        if($position == 87 ){
            $all_numbers = DB::table("SERIES_NUMBER SN")
                ->selectRaw("SN.ID, SN.WEEKEND, SN.NAME, SN.ORDER_DATE, SN.IS_ORDER, SN.IS_GIVEN, SN.SHOW_DATE, S.PROVINCE_ID, SI.NAME INTERVAL_NAME")
                ->join("SERIES S", "SN.SERIES_ID", "S.ID")
                ->join("SERIES_INTERVAL SI", "S.ID", "SI.SERIES_ID")
                ->where("S.PROVINCE_ID", (int)$seriesId)
                ->whereNull("SN.VEHICLE_ID")
                ->where("SN.TYPE", "=", (int)1)
                ->where("S.TYPE", "=", (int)1)
                ->where("SI.NAME", "!=", "SEND") //ok
                ->where("SI.IS_HIDDEN", (int)0) //ok
                ->where("SN.IS_LOCAL", (int)0) //ok
                ->where("SN.NAME", "LIKE", "%ДК%")
                ->where("SN.IS_HIDDEN", (int)0) //ok
                ->where("SN.IS_GIVEN", (int)0) //ok
                ->where("SN.IS_ORDER", (int)0) //ok
                ->get();
        } else if($position == 2 ){
            $all_numbers = DB::table("SERIES_NUMBER SN")
                ->selectRaw("SN.ID, SN.WEEKEND, SN.NAME, SN.ORDER_DATE, SN.IS_ORDER, SN.IS_GIVEN, SN.SHOW_DATE, S.PROVINCE_ID, SI.NAME INTERVAL_NAME")
                ->join("SERIES S", "SN.SERIES_ID", "S.ID")
                ->join("SERIES_INTERVAL SI", "S.ID", "SI.SERIES_ID")
                ->where("S.PROVINCE_ID", (int)$seriesId)
                ->whereNull("SN.VEHICLE_ID")
                ->where("SN.TYPE", "=", (int)1)
                ->where("S.TYPE", "=", (int)1)
                ->where("SI.NAME", "!=", "SEND") //ok
                ->where("SI.IS_ORDER", (int)1)
                ->where("SI.IS_HIDDEN", (int)0) //ok
                ->where("SN.IS_LOCAL", (int)0) //ok
                ->where("SN.NAME", "LIKE", "%НАА%")
                ->where("SN.IS_HIDDEN", (int)0) //ok
                ->where("SN.IS_GIVEN", (int)0) //ok
                ->where("SN.IS_ORDER", (int)0) //ok
                ->where("SN.ISAUCTION", (int)0) //
                ->get();
        } else {
            $all_numbers = DB::table("SERIES_NUMBER SN")
                ->selectRaw("SN.ID, SN.WEEKEND, SN.NAME, SN.ORDER_DATE, SN.IS_ORDER, SN.IS_GIVEN, SN.SHOW_DATE, S.PROVINCE_ID, SI.NAME INTERVAL_NAME")
                ->join("SERIES S", "SN.SERIES_ID", "S.ID")
                ->join("SERIES_INTERVAL SI", "S.ID", "SI.SERIES_ID")
                ->where("S.PROVINCE_ID", (int)$seriesId)
                ->whereNull("SN.VEHICLE_ID")
                ->where("SN.TYPE", "=", (int)1)
                ->where("S.TYPE", "=", (int)1)
                ->where("S.TYPE", "=", (int)1)
                ->where("SN.SERIES_ID", "!=", (int)35)
                ->where("SI.IS_OPENED", (int)1)
                ->where("SI.IS_ORDER", (int)1)
                ->where("SI.IS_HIDDEN", (int)0)
                ->where("SN.IS_LOCAL", (int)0)
                ->where("SN.IS_HIDDEN", (int)0)
                ->where("SN.IS_OPENED", (int)1)
                ->where("SN.IS_GIVEN", (int)0)
                ->where("SN.IS_ORDER", (int)0)
                ->get();
        }

       // dd($all_numbers);
        return $all_numbers;
    }

    public function selectSearchNnumber($seriesId, $number, $position){
        if($position == 87){
            $number = $number."ДК%";
            $all_numbers = DB::table("SERIES_NUMBER SN")
                ->selectRaw("SN.ID, SN.WEEKEND, SN.NAME, SN.ORDER_DATE, SN.IS_ORDER, SN.IS_GIVEN, SN.SHOW_DATE, S.PROVINCE_ID, SI.NAME INTERVAL_NAME")
                ->join("SERIES S", "SN.SERIES_ID", "S.ID")
                ->join("SERIES_INTERVAL SI", "S.ID", "SI.SERIES_ID")
                ->where("S.PROVINCE_ID", (int)$seriesId)
                ->whereNull("SN.VEHICLE_ID")
                ->where("SN.TYPE", "=", (int)1)
                ->where("S.TYPE", "=", (int)1)
                ->where("SI.NAME", "!=", "SEND") //ok
                ->where("SI.IS_HIDDEN", (int)0) //ok
                ->where("SN.IS_LOCAL", (int)0) //ok
                ->where("SN.NAME", "LIKE", $number)
                ->where("SN.IS_HIDDEN", (int)0) //ok
                ->where("SN.IS_GIVEN", (int)0) //ok
                ->where("SN.IS_ORDER", (int)0) //ok
                ->get();
        } else if($position == 2 ){
            $all_numbers = DB::table("SERIES_NUMBER SN")
                ->selectRaw("SN.ID, SN.WEEKEND, SN.NAME, SN.ORDER_DATE, SN.IS_ORDER, SN.IS_GIVEN, SN.SHOW_DATE, S.PROVINCE_ID, SI.NAME INTERVAL_NAME")
                ->join("SERIES S", "SN.SERIES_ID", "S.ID")
                ->join("SERIES_INTERVAL SI", "S.ID", "SI.SERIES_ID")
                ->where("S.PROVINCE_ID", (int)$seriesId)
                ->whereNull("SN.VEHICLE_ID")
                ->where("SN.TYPE", "=", (int)1)
                ->where("S.TYPE", "=", (int)1)
                ->where("SI.NAME", "!=", "SEND") //ok
                ->where("SI.IS_ORDER", (int)1)
                ->where("SN.IS_HIDDEN", (int)0) //ok
                ->where("SN.IS_LOCAL", (int)0) //ok
                ->where("SN.NAME", "LIKE", "%НАА%")
                ->where("SN.IS_HIDDEN", (int)0) //ok
                ->where("SN.IS_GIVEN", (int)0) //ok
                ->where("SN.IS_ORDER", (int)0) //ok
                ->where("SN.ISAUCTION", (int)0) //
                ->get();
            }
             else {
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
                ->where("SN.SERIES_ID", "!=", (int)35)
                ->where("SI.NAME", "!=", "SEND")
                ->orWhere("SN.NAME", "LIKE", $number."ТТА")
                ->orderBy("SN.NAME", "ASC")
                ->get();
        }
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
        } else {
            $numbers1 = $all_numbers;
            $select = 0;
            foreach ($numbers1 as $key => $data) {
                if($data->weekend == 1){
                    $info = $this->showClass($data);
                    $data->difftime = $info["difftime"];
                    $data->class = $info["class"];
                    $data->row_id = $info["row_id"];
                    if($data->difftime > 0){
                        $numbers[$key] = $data;
                        $select++;
                    }
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
                    if($data->difftime > 0){
                        $numbers[$key] = $data;
                        $select++;
                    }
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
                    if($data->difftime > 0){
                        $numbers[$key] = $data;
                        $select++;
                    }
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
                    if($data->difftime > 0){
                        $numbers[$key] = $data;
                        $select++;
                    }
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
                    if($data->difftime > 0){
                        $numbers[$key] = $data;
                        $select++;
                    }
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
        if($difftime < 0){
            $class = " ordered_pending";
        }
        if($data->is_given == 1){
            $class = " given_number";
        }
        $row_id = "";
        if($data->is_order == 0 && $difftime > 0 && $data->is_given == 0 )
            $row_id = \App\Http\Controllers\BaseController::enc($data->id);
        return array("class" => $class, "difftime" => $difftime, "row_id" => $row_id);
    }
}
