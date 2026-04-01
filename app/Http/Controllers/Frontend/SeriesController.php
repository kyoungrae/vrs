<?php

namespace App\Http\Controllers\Frontend;

use App\AddressProvince;
use App\Http\Controllers\BaseController;
use App\MainUser;
use App\MainUserDepartment;
use App\MainUserPosition;
use App\Series;
use App\SeriesInterval;
use App\SeriesNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends BaseController
{
    /**
     * Сер үүсгэх
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSeries(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/series/create", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $provinces = AddressProvince::orderBy("NAME", "ASC")->get();
            $types = DB::table("VEHICLE_TYPE")->get();
            if($request->isMethod("POST")){
                $province = $request->get("province");
                $series = $request->get("series");
                $type = $request->get("type");
                $old = $request->get("old");
                $duplicate = $request->get("duplicate");
                $check = $request->get("check");

                $old = $old == "on" ? 1 : 0;
                $duplicate = $duplicate == "on" ? 1 : 0;
                $check = $check == "on" ? 1 : 0;

                $env = $request->get("env");

                if($env != ""){
                    Series::where("ID", $this->dec($env))->update([
                        'NAME' => $series,
                        'TYPE' => $type,
                        'PROVINCE_ID' => $province,
                        'IS_DUPLICATE' => $duplicate,
                        'IS_OLD' => $old,
                        'IS_CHECK_ADDRESS' => $check,
                        'Created_By_Id' => $userPkId,
                        'Updated_By_Id' => $userPkId
                    ]);
                    $message = $this->message("success", "Cерийн мэдээлэл ам년ттай засагдлаа.");
                } else {
                    $is_create = Series::where("NAME", $series)->get()->count();
                    if($is_create > 0){
                        $message = $this->message("info", "Үүсгэх сери давхцаж байна.");
                    } else {
                        Series::create([
                            'NAME' => $series,
                            'TYPE' => $type,
                            'PROVINCE_ID' => $province,
                            'IS_DUPLICATE' => $duplicate,
                            'IS_OLD' => $old,
                            'IS_CHECK_ADDRESS' => $check,
                            'Created_By_Id' => $userPkId,
                            'Updated_By_Id' => $userPkId
                        ]);
                        $message = $this->message("success", "Сери ам년ттай үүслээ.");
                    }
                }
                return redirect(route("createseries"))->with("message", $message);
            } else {
                $code = $request->route("code");
                if($code != ""){
                    $curr_series = Series::where("Id", $this->dec($code))->get()->first();
                    return view('System.seriescreate', compact('curr_series', 'provinces', 'types'));
                } else {
                    return view('System.seriescreate', compact('provinces', 'types'));
                }
            }
        } catch (\Exception $ex){
            $this->writeLog("Series create error: ".$ex->getMessage());
            $message = $this->message("danger", "Сери үүсгэхэд 오류가 발생했습니다.");
            return redirect(route("createseries"))->with("message", $message);
        }
    }

    /**
     * Сер нээх
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function openSeries(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/series/open", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $seriess = DB::table("SERIES_VIEW")->get();
            $provinces = AddressProvince::orderBy("NAME", "ASC")->get();

            if($request->isMethod("POST")){
                $id = trim($request->get("env"));

                $open = $request->get("open");
                $order = $request->get("order");
//                $auto = $request->get("auto");
                $auto = "on";
                $open = $open == "on" ? 1 : 0;
                $order = $order == "on" ? 1 : 0;
                $auto = $auto == "on" ? 1 : 0;

                if($id != "" || $id != null){
                    SeriesInterval::where("Id", $this->dec($id))->update([
                        'IS_ORDER' => $order,
                        'IS_OPENED' => $open,
                        'IS_AUTO' => $auto,
                        'Updated_By_Id' => $userPkId
                    ]);
                    $interval = SeriesInterval::where("Id", $this->dec($id))->get()->first();
                    SeriesNumber::where("SERIES_ID", $interval->series_id)
                        ->where("IS_GIVEN", "=", 0)
                        ->where("NO", ">=", $interval->from_number)
                        ->where("NO", "<=", $interval->to_number)
                        ->update([
                            'IS_OPENED' => $open,
                            'IS_AUTO' => $auto,
                            'Updated_By_Id' => $userPkId
                        ]);
                    $message = $this->message("success", "Серийн мэдээлэл ам년ттай засагдлаа.");
                    return redirect(url("/series/open/edit/".$id))->with("message", $message);
                } else {
                    $series = $request->get("series");
//                    $start = $request->get("start");
//                    $end = $request->get("end");
                    $start = 1;
                    $end = 9999;
                    $tmp_series = Series::where("Id", $series)->get()->first();
                    $series_name = $tmp_series->name;
                    $series_type = $tmp_series->type;
                    $duplicate_number = "";
                    $interval_create = SeriesInterval::where("SERIES_ID", $series)->where("FROM_NUMBER", 1)->where('TO_NUMBER', 9999)->get()->count();
                    $number_create = SeriesNumber::where("SERIES_ID", $series)->get()->count();
                    if($interval_create > 0 && $number_create == 9999){
                        $message = $this->message("success", $series_name." -ийн бүх дугаар үүссэн байна.");
                        return view('System.seriesopen', compact('seriess', 'provinces', 'message'));
                    } else {
                        if($interval_create == 0){
                            SeriesInterval::create([
                                'NAME' => "OPEN",
                                'FROM_NUMBER' => $start,
                                'TO_NUMBER' => $end,
                                'SERIES_ID' => $series,
                                'IS_LOCAL' => 0,
                                'IS_ORDER' => $order,
                                'IS_HIDDEN' => 0,
                                'IS_OPENED' => $open,
                                'IS_AUTO' => $auto,
                                'TYPE' => $series_type,
                                'Created_By_Id' => $userPkId,
                                'Updated_By_Id' => $userPkId
                            ]);
                        } else {
                            $start = $number_create == 0 ? 1 : $number_create;
                        }
                        for($number = $start; $number <= $end; $number++){
                            $plate_no = "";
                            $num_len = strlen($number);
                            if($num_len == 1){
                                $plate_no = "000";
                            } elseif ($num_len == 2){
                                $plate_no = "00";
                            } elseif ($num_len == 3) {
                                $plate_no = "0";
                            }
                            if ($series_type == 4){
                                $plate_no = $series_name.$plate_no.$number;
                            } else {
                                $plate_no .= $number.$series_name;
                            }
                            //$is_create = SeriesNumber::where("NAME", $plate_no)->get()->count();
                            $is_create = 0;
                            $duplicate_number_count = 0;
                            if($is_create > 0){
                                $duplicate_number .= $plate_no.", ";
                                $duplicate_number_count++;
                            } else {
                                $show_date = $this->checkLuckyPlate($plate_no, 2);
                                $lastDigit = $number % 10;
                                $weekend = 0;
                                switch ($lastDigit){
                                    case 1:
                                    case 6:
                                        $weekend = 1;
                                        break;
                                    case 2:
                                    case 7:
                                        $weekend = 2;
                                        break;
                                    case 3:
                                    case 8:
                                        $weekend = 3;
                                        break;
                                    case 4:
                                    case 9:
                                        $weekend = 4;
                                        break;
                                    case 5:
                                    case 0:
                                        $weekend = 5;
                                        break;
                                }
                                SeriesNumber::create([
                                    'NAME' => $plate_no,
                                    'IS_GIVEN' => 0,
                                    'IS_HIDDEN' => 0,
                                    'IS_LOCAL' => 0,
                                    'IS_OPENED' => $open,
                                    'NO' => $number,
                                    'TYPE' => $series_type,
                                    'SERIES_ID' => $series,
                                    'IS_ORDER' => 0,
                                    'IS_AUTO' => $auto,
                                    'WEEKEND' => $weekend,
                                    'ORDER_CABIN' => null,
                                    'SHOW_DATE' => $show_date,
                                    'Created_By_Id' => $userPkId,
                                    'Updated_By_Id' => $userPkId
                                ]);
                            }
                        }
                        $text = $series_name." серийн дугаар ам년ттай үүслээ.";
                        $message = $this->message("success", $text);
                        return view('System.seriesopen', compact('seriess', 'provinces', 'message'));
                    }
                }
            } else {
                $code = $request->route("code");
                if($code != ""){
                    $interval = SeriesInterval::where("Id", $this->dec($code))->get()->first();
                    return view('System.seriesopen', compact('seriess', 'provinces', 'interval'));
                }
                return view('System.seriesopen', compact('seriess', 'provinces'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Open series number error: ".$ex->getMessage());
            $message = $this->message("danger", "오류가 발생하여 작업을 다시 하세요.");
            return redirect(route("openseries"))->with("message", $message);
        }
    }

    /**
     * Сер нээсэн жагсаалт
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function openSeriesList(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/series/open/list", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        $intervals = DB::table("SERIES_INTERVAL_VIEW")->where("TYPE_NAME", "!=", "SEND")->get();
        return view('System.seriesopenlist', compact('intervals'));
    }

    /**
     * Сер илгээх
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendSeries(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/series/send", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            $userPkId = session()->get("auth")->id;
            $departments = MainUserDepartment::whereNull("deleted_at")->orderBy("Name", "ASC")->get();
            $seriess = Series::orderBy("NAME", "ASC")->get();

            if($request->isMethod("POST")){
                $user = $request->get("user");
                $series = $request->get("series");
                $start = $request->get("start");
                $end = $request->get("end");
                $env = $request->get("env");
                $tmp_series = Series::where("Id", $series)->get()->first();
                $series_name = $tmp_series->name;
                $series_type = $tmp_series->type;

                if($env != ""){
                    $edit_interval = SeriesInterval::where("ID", $this->dec($env))->get()->first();
                    $old_from_number = $edit_interval->from_number;
                    $old_to_number = $edit_interval->to_number;
                    $old_series_id = $edit_interval->series_id;
                    SeriesInterval::where("ID", $this->dec($env))->update([
                        'FROM_NUMBER' => $start,
                        'TO_NUMBER' =>$end,
                        'LOCAL_USER_ID' => $user,
                        'SERIES_ID' => $series,
                        'Updated_By_Id' => $userPkId
                    ]);

                    SeriesNumber::whereBetween("NO", [$old_from_number, $old_to_number])->where("SERIES_ID", $old_series_id)->update([
                        'IS_LOCAL' => 0,
                        'LOCAL_USER_ID' => null,
                        'Updated_By_Id' => $userPkId
                    ]);

                    SeriesNumber::whereBetween("NO", [$start, $end])->where("SERIES_ID", $series)->where("IS_GIVEN", 0)->where("IS_ORDER", 0)->update([
                        'IS_LOCAL' => 1,
                        'LOCAL_USER_ID' => $user,
                        'Updated_By_Id' => $userPkId
                    ]);
                    $text = $series_name." серийн ".$start." -с ".$end." дугаарыг ам년ттай заслаа.";
                    $message = $this->message("success", $text);
                } else {
                    SeriesInterval::create([
                        'NAME' => "SEND",
                        'FROM_NUMBER' => $start,
                        'TO_NUMBER' => $end,
                        'SERIES_ID' => $series,
                        'IS_LOCAL' => 1,
                        'IS_ORDER' => 0,
                        'IS_HIDDEN' => 0,
                        'IS_OPENED' => 1,
                        'IS_AUTO' => 0,
                        'LOCAL_USER_ID' => $user,
                        'TYPE' => $series_type,
                        'Created_By_Id' => $userPkId,
                        'Updated_By_Id' => $userPkId
                    ]);

                    SeriesNumber::whereBetween("NO", [$start, $end])->where("SERIES_ID", $series)->where("IS_GIVEN", 0)
                        ->where("IS_ORDER", 0)->where("ISAUCTION", 0)->where("IS_HIDDEN", 0)->where("IS_SAVE", 0)
                        ->update([
                            'IS_LOCAL' => 1,
                            'LOCAL_USER_ID' => $user,
                            'Updated_By_Id' => $userPkId
                        ]);
                    $text = $series_name." серийн ".$start." -с ".$end." дугаарыг ам년ттай илгээлээ.";
                    $message = $this->message("success", $text);
                }
                return view('System.seriessend', compact('departments',  'seriess', 'message'));
            } else {
                $code = $request->route("code");
                if($code != ""){
                    $interval = DB::table("SERIES_INTERVAL_VIEW")->where("ID", $this->dec($code))->get()->first();
                    return view('System.seriessend', compact('departments', 'seriess', 'interval'));
                } else {
                    return view('System.seriessend', compact('departments', 'seriess'));
                }
            }
        } catch (\Exception $ex){
            $this->writeLog("Send series number error: ".$ex->getMessage());
            $message = $this->message("danger", "Сери илгээхэд 오류가 발생했습니다.");
            return redirect(route("sendSeries"))->with("message", $message);
        }
    }

    /**
     * Илгээсэн серүүд
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seriesSent(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/series/sent", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try{
            $positions = MainUserPosition::get();
            $departments = MainUserDepartment::whereNull("deleted_at")->orderBy("Name", "ASC")->get();
            $series = DB::table("SERIES_INTERVAL_VIEW")->where("IS_LOCAL", 1)->orderBy("CREATE_DATE", "DESC");
            if($request->isMethod("POST")){
                $s_position = $request->get("position");
                $s_department = $request->get("department");
                if($s_position != ""){
                    $series = $series->where("POSITION_ID", $s_position);
                }
                if($s_department != ""){
                    $series = $series->where("DEPARTMENT_ID", $s_department);
                }
                $series = $series->get();
                return view('System.seriessentnew', compact('series', 'positions', 'departments', 's_position', 's_department'));
            } else {
                $series = $series->get();
                return view('System.seriessentnew', compact('series', 'positions', 'departments'));
            }
        } catch (\Exception $ex){

        }
    }

    /**
     * Сер хайх
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchSeries(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/series/search", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        try{
            $seriess = DB::table("SERIES_VIEW")->orderBy("Name", "ASC")->get();
            if($request->isMethod("POST")){
                $select_series = $request->get("series");
                $start = $request->get("start");
                $end = $request->get("end");
                $givens = SeriesNumber::where("SERIES_ID", $select_series)->where("IS_GIVEN", 1);
                $notgivens = SeriesNumber::where("SERIES_ID", $select_series)->where("IS_GIVEN", 0);
                if($start != ""){
                    $givens = $givens->where("NO", ">=", $start);
                    $notgivens = $notgivens->where("NO", ">=", $start);
                }
                if($start != ""){
                    $givens = $givens->where("NO", "<=", $end);
                    $notgivens = $notgivens->where("NO", "<=", $end);
                }
                $givens = $givens->get();
                $notgivens = $notgivens->get();
                return view('System.seriessearch', compact('seriess', 'givens', 'notgivens', 'start', 'end', 'select_series'));
            } else {
                return view('System.seriessearch', compact('seriess'));
            }
        } catch(\Exception $ex){}
    }

    public function searchMehanizm(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }

        if(!$this->checkAccess("/mehanizm/search", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }

        try{
            $seriess = DB::table("SERIES_VIEW")->where("TYPE_ID", "!=", 1)->orWhere("NAME", "LIKE", "ХХ%")->orderBy("Name", "ASC")->get();
            if($request->isMethod("POST")){
                $select_series = $request->get("series");
                $start = $request->get("start");
                $end = $request->get("end");
                $givens = SeriesNumber::where("SERIES_ID", $select_series)->where("IS_GIVEN", 1);
                $notgivens = SeriesNumber::where("SERIES_ID", $select_series)->where("IS_GIVEN", 0);
                if($start != ""){
                    $givens = $givens->where("NO", ">=", $start);
                    $notgivens = $notgivens->where("NO", ">=", $start);
                }
                if($start != ""){
                    $givens = $givens->where("NO", "<=", $end);
                    $notgivens = $notgivens->where("NO", "<=", $end);
                }
                $givens = $givens->get();
                $notgivens = $notgivens->get();
                return view('System.mehanizmsearch', compact('seriess', 'givens', 'notgivens', 'start', 'end', 'select_series'));
            } else {
                return view('System.mehanizmsearch', compact('seriess'));
            }
        } catch(\Exception $ex){}
    }
}
