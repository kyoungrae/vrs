<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Session;

class AuthService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request_url = request()->headers->get('referer');
       // if($request_url != "" && $request_url != null && stripos($request_url, "https://vrs.transdep.mn") == 0){
    //   return $request_url;
     
        // if($request_url != "" && $request_url != null && stripos($request_url, "http://spark.transdep.mn:8080") == 0){
        //     if(!$request->session()->has("auth") ){
        //         return response()->json(["message" => "Not valid request."], 401);
        //     }
        // } else {
        //     return $next($request);
        //    // return response()->json(["message" => "Not valid request."], 401);
        // }
        return $next($request);
    }
}
