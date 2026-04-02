<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\MainUser;
use App\SystemArchive;
use Carbon\Carbon;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{
    public function index(Request $request)
    {
        try{
            if(!session()->has("auth")){
                return redirect(route($this->redirectURL));
            }
            if($request->isMethod("POST")){
                try {
                    $branch = $this->dec(trim($request->get("branch")));
                    $archives = SystemArchive::where("Id", $branch)->get();
                    if($archives->count() > 0){
                        session(["archive" => $archives->first()]);
                    }
                } catch (\Exception $branchEx) {
                    if (! BaseController::isDevBypassLogin()) {
                        throw $branchEx;
                    }
                }
                $dayDiff = BaseController::checkChangePassword(session()->get("auth")->id);
                if($dayDiff > 30){
                    return redirect(route("password"));
                } else {
                    return redirect(route("dashboard"));
                }
            } else {
                $archives = collect();
                $auth = session()->get('auth');
                if ($auth && ! BaseController::isDevBypassLogin()) {
                    $provinceId = $auth->provinceid ?? $auth->ProvinceId ?? null;
                    if ($provinceId !== null) {
                        $archives = SystemArchive::where('PROVINCEID', $provinceId)
                            ->whereNull('deleted_at')
                            ->orderBy('archive', 'ASC')
                            ->get();
                    }
                }

                if (BaseController::isDevBypassLogin()) {
                    // DB 없는 로컬 데모 모드: Oracle 연결 시도 자체를 생략해 대기/타임아웃 방지.
                    $totalVehicle = $totalOwners = $totalNumbers = '0';
                } else {
                    $database = config('database.default') ?: 'oracle';
                    $totalVehicle = DB::connection($database)->select("SELECT COUNT(*) TOTAL FROM REG_VEHICLE");
                    $totalOwners = DB::connection($database)->select("SELECT COUNT(*) TOTAL FROM OWNER");
                    $totalNumbers = DB::connection($database)->select("SELECT COUNT(*) TOTAL FROM SERIES_NUMBER WHERE IS_ORDER=0 AND IS_GIVEN=0");

                    $totalVehicle = $totalVehicle[0]->TOTAL ?? $totalVehicle[0]->total;
                    $totalOwners = $totalOwners[0]->TOTAL ?? $totalOwners[0]->total;
                    $totalNumbers = $totalNumbers[0]->TOTAL ?? $totalNumbers[0]->total;

                    $totalVehicle = number_format($totalVehicle);
                    $totalOwners = number_format($totalOwners);
                    $totalNumbers = number_format($totalNumbers);
                }

                return view('System.dashboard', compact('totalVehicle', 'totalNumbers', 'totalOwners', 'archives'));
            }
        } catch (\Exception $ex){
            $this->writeLog("Dashboard \ub4dc\uc6b0\ub4f0 \uc624\ub958\uac00 \ubc1c\uc0dd\ud588\uc2b5\ub2c8\ub2e4. ".$ex);
            throw $ex;
        }
    }
}
