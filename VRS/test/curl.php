<?php
/* $ctx = stream_context_create(['ssl' => [
    'capture_session_meta' => TRUE
]]);
 
$html = file_get_contents('https://xyp.gov.mn', FALSE, $ctx);
$meta = stream_context_get_options($ctx)['ssl']['session_meta'];
var_dump($html);
var_dump($meta); */


var_dump(openssl_get_cert_locations());
?>