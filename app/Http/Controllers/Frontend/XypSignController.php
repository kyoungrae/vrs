<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class XypSignController extends Controller
{
    private $KeyPath;
    private $accessToken;

    function __construct($KeyPath, $accessToken){
        $this->KeyPath = $KeyPath;
        $this->accessToken = $accessToken;
    }

    public function sign(){
        $pkey = file_get_contents(public_path($this->KeyPath));
        $timestamp = time();
        openssl_sign($this->accessToken . "." . $timestamp, $signature, $pkey, OPENSSL_ALGO_SHA256);
        return [
            'accessToken' => $this->accessToken,
            'timeStamp' => $timestamp,
            'signature' => base64_encode($signature),
        ];
    }
}
