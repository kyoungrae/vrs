<?php

namespace App\Http\Controllers;

use App\Audit;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MainService;
use App\MainUserMenu;
use App\MainUserPosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BaseController;
class AuditController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        if(!$this->checkAccess("/vehicle", $this->enc(session()->get("auth")->userpositionid))){
            return redirect(route($this->redirectAccess));
        }
        try {
        $services = MainService::where("IS_SHOW", 1)->orderBy("VIEW_ORDER", "ASC")->get();
        $mainUserMenu = MainUserMenu::orderBy("ID", "ASC")->get();
        $mainUserPosition = MainUserPosition::orderBy("ID", "ASC")->get();
       // $owners = Owner::orderBy("CREATE_DATE", "DESC")->get();





       
       $audits = \OwenIt\Auditing\Models\Audit::with('user')
       ->orderBy('created_at', 'desc')->limit(10)                
       ->get();

       // dd($audits);
       if($request->isMethod("POST")){
        // dd($request);
         $start = trim($request->get("start"));
         $end = trim($request->get("end"));
         $audits = \OwenIt\Auditing\Models\Audit::with('user')
         ->whereBetween("created_at", [$start, $end." 23:59:59"])
         ->orderBy('created_at', 'desc')                
         ->get();
      // return $mainUserPosition;
      return view('System.audits',compact('audits','start', 'end','services','mainUserMenu','mainUserPosition'));
        
     } else {
         return view('System.audits', compact('audits'));
     }

     
      // return view('System.audits', ['audits' => $audits]);   
    } catch (\Exception $ex){
        $this->writeLog("차량 화면 호출 오류: ".$ex->getMessage());
        $message = $this->message("danger", "화면을 불러오는 중 오류가 발생했습니다.");
        return view('System.audits', compact("message"));
    }
     
       //return view('admin.audits.index', ['audits' => $audits]);       

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function show(Audit $audit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function edit(Audit $audit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Audit $audit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Audit  $audit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Audit $audit)
    {
        //
    }
}
