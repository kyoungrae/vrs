<?php

namespace App\Http\Controllers;

use App\MainUser;
use App\MainUserMenu;
use App\MainUserPositionMenu;
use App\SeriesNumber;
use App\SystemPlateFactory;
use App\Vehicle;
use Carbon\Carbon;

class BaseController extends Controller
{
    protected $redirectURL = "logout";
    protected $redirectAccess = "error";

    /**
     * Local UI testing without Oracle: requires APP_ENV=local and DEV_BYPASS_LOGIN=true in .env
     */
    public static function isDevBypassLogin()
    {
        return app()->environment('local')
            && filter_var(config('app.dev_bypass_login'), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * 로컬 바이패스 시 실제 화면(Blade)을 DB 없이 빈 데이터로 렌더링.
     */
    public static function isRealUiWithoutDb()
    {
        return self::isDevBypassLogin()
            && filter_var(config('app.real_ui_without_db', true), FILTER_VALIDATE_BOOLEAN);
    }

    public static function enc($string){
        return encrypt($string."s&ts");
    }

    public static function dec($string){
        return substr(decrypt($string), 0,-4);
    }

    public static function seriesIdEnc($data){
        return self::enc((string)((int)$data+(int)\Carbon\Carbon::now()->format("d")).'pd;');
    }

    public static function seriesIdDec($data){
        $seriesId = self::dec($data);
        return (int)mb_substr($seriesId, 0, strlen($seriesId) - 3) - (int)Carbon::now()->format("d");
    }

    public function writeLog($log){
        app("log")->critical($log);
    }

    public static function getVehiclePlate($vehicle_id){
        try {
            return self::enc(Vehicle::where("ID", $vehicle_id)->get()->first()->plate_no);
        } catch (\Exception $ex){
            return 0;
        }
    }

    public function message($type, $text){
        //Type - > info, success, danger, warning
        $message["type"]=$type;
        $message["message"]=$text;
        return $message;
    }

    public static function hasMenu($menu_id, $type, $position_id){
        if (self::isDevBypassLogin()) {
            return "checked";
        }
        try {
            $hasAccess = MainUserPositionMenu::where("ACTION_ID", $menu_id)->where("TYPE_ID", $type)->where("POSITION_ID", self::dec($position_id))->get()->count();
            return $hasAccess > 0 ? "checked" : "";
        } catch (\Exception $e) {
            if (self::isDevBypassLogin()) {
                return "checked";
            }
            throw $e;
        }
    }

    public static function hasMenuShow($url, $type, $position_id){
        if (self::isDevBypassLogin()) {
            return true;
        }
        try {
            if($type == 1){
                $menu = MainUserMenu::where("URL", trim($url))->get();
                if($menu->count() > 0){
                    $menu_id = $menu->first()->id ?? $menu->first()->Id ?? $menu->first()->ID;
                    $hasAccess = MainUserPositionMenu::where("ACTION_ID", $menu_id)->where("TYPE_ID", $type)->where("POSITION_ID", self::dec($position_id))->get()->count();
                    return $hasAccess > 0 ? true : false;
                } else {
                    return false;
                }
            } else {
                $hasAccess = MainUserPositionMenu::where("ACTION_ID", $url)->where("TYPE_ID", $type)->where("POSITION_ID", self::dec($position_id))->get()->count();
                return $hasAccess > 0 ? true : false;
            }
        } catch (\Exception $e) {
            if (self::isDevBypassLogin()) {
                return true;
            }
            throw $e;
        }
    }

    public function checkAccess($url, $position_id){
        if (self::isDevBypassLogin()) {
            return true;
        }
        try {
            $menu = MainUserMenu::where("URL", trim($url))->get();
            if($menu->count() > 0){
                $menu_id = $menu->first()->id ?? $menu->first()->Id ?? $menu->first()->ID;
                $hasAccess = MainUserPositionMenu::where("ACTION_ID", $menu_id)->where("TYPE_ID", 1)->where("POSITION_ID", self::dec($position_id))->get()->count();
                return $hasAccess > 0 ? true : false;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            if (self::isDevBypassLogin()) {
                return true;
            }
            throw $e;
        }
    }

    public function checkLuckyPlate($plate, $type){
        $plate = (string)$plate;
        $isLucky = false;
        if($plate[0] == $plate[1] && $plate[0] == $plate[2] && $plate[0] == $plate[3]){
            $isLucky = true;
        } elseif ($plate[0] == $plate[1] && $plate[2] == $plate[3]){
            $isLucky = true;
        } elseif ($plate[0] == 0 && $plate[1] == 0 && $plate[2] == 0){
            $isLucky = true;
        } elseif ($plate[1] == 0 && $plate[2] == 0 && $plate[3] == 0){
            $isLucky = true;
        } elseif ($plate[0] == $plate[3] && $plate[1] == $plate[2]){
            $isLucky = true;
        } elseif ($plate[0] == $plate[2] && $plate[1] == $plate[3]){
            $isLucky = true;
        }
        if($type == 1){
            return $isLucky;
        } else {
            if($isLucky){
                return self::enc(Carbon::now()->addDay(rand(0, 13))->addHour(rand(1, 23))->addMinutes(rand(0, 60))->addSeconds(rand(0, 60))->format("Y-m-d H:i:s"));
            } else {
                return self::enc(Carbon::now()->addHour(rand(0, 23))->addMinutes(rand(0, 60))->addSeconds(rand(0, 60))->format("Y-m-d H:i:s"));
            }
        }
    }

    public function createPrintPlate($plate, $service, $user,$plateColor){
        $type = 1;
        $types = SeriesNumber::where("NAME", $plate)->get();
        if($types->count() > 0){
            $type = $types->first()->type;
        }
        SystemPlateFactory::create([
            'TYPE_ID' => $type,
            'PLATE_NO' => $plate,
            'SERVICE_ID' => $service,
            'USER_ID' => $user,
            'IS_PRINT' => 0,
            'PLATECOLOR'=>$plateColor,
            'CREATE_DATE' => Carbon::now(),
            'UPDATE_DATE' => null
        ]);
    }

    public static function checkChangePassword($id){
        if (self::isDevBypassLogin()) {
            return 0;
        }
        try {
            $user = MainUser::where("ID", $id)->first();
            if ($user === null) {
                return self::isDevBypassLogin() ? 0 : 31;
            }
            $is_change = $user->last_change_password;
            if($is_change == null){
                $dayDiff = 31;
            } else {
                $dayDiff = Carbon::parse(Carbon::now())->diffInDays($is_change);
            }
            return $dayDiff;
        } catch (\Exception $e) {
            if (self::isDevBypassLogin()) {
                return 0;
            }
            throw $e;
        }
    }
}
