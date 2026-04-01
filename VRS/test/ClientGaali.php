<?php

require_once('Sign.php');
$keyPath = 'mrtd.key';                       					
$accessToken = "8c57ae35b9fff22a7cf3c63f773dba54";                  
$sign = new XypSign($keyPath, $accessToken);
$signingInfo = $sign->sign();
try{
$client = new SoapClient(

    "transport.xml", 
    [
    'soapVersion' => SOAP_1_2,
    'stream_context' => stream_context_create([
        'ssl' => [
        'verify_peer' => false,
        'allow_self_signed' => true
        ],
			'http' => [
			'header' => "accessToken: $signingInfo[accessToken]\r\n".
			"timeStamp: $signingInfo[timeStamp]\r\n".
			"signature: $signingInfo[signature]"
        ]
    ])
    ]
);

echo "<pre>";
//$plateNumber = "02211100215I31823";
	$plateNumber = "02214101415I31692";
	$payload = ['impExpDclrNo' => $plateNumber];
	$result = $client->WS100411_vehicleImportInfo(array("request"=>$payload));
	var_dump($result);
}catch (Exception $ex) {
	var_dump("ХУР -тай холбогдох үед гарсан алдаа: " . $ex->getMessage());
}
?>