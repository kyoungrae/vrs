<?php
class XypSign{

private $KeyPath;
private $accessToken;

function __construct($KeyPath, $accessToken){
    $this->KeyPath = $KeyPath;
    $this->accessToken = $accessToken;
}

public function sign(){
    $pkey = file_get_contents($this->KeyPath);
    $timestamp = time();
    openssl_sign($this->accessToken . "." . $timestamp, $signature, $pkey, OPENSSL_ALGO_SHA256);
    return [
    'accessToken' => $this->accessToken,
    'timeStamp' => $timestamp,
    'signature' => base64_encode($signature),
    ];
}

}
?>