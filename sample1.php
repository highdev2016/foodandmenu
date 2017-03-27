<?php

//$data = // we'll assume all of our transaction information is in this associative array, already processed
$login = '9U6b68Xafah';  // you'll get this value from authorize.net
$tran_key = '3T274U3nZv73ttRH';  // you'll get this value from authorize.net
$delimiter = '|';  // the delimiter we want the response to use
 
$authnet_values    = array(
    "x_login"            => $login,
    "x_version"            => "3.1",  // or whatever version you're using
    "x_delim_char"            => $delimiter,
    "x_delim_data"            => "TRUE",
    "x_type"            => "AUTH_CAPTURE",
    "x_method"            => "CC",
    "x_tran_key"            => $tran_key,
    "x_relay_response"        => "FALSE",
    "x_card_num"            => "4111111111111111",
    "x_exp_date"            => "0115",
    "x_description"            => "Sample Transaction",
    "x_amount"            => "1",
    "x_first_name"            => "Priya11",
    "x_last_name"            => "Singh",
    "x_address"            => "test",
    "x_city"            => "test",
    "x_state"            => "test",
    "x_zip"                => "00501"
);
 
require_once 'anet_php_sdk/AuthorizeNet.php'; 
define("AUTHORIZENET_API_LOGIN_ID", $login); 
define("AUTHORIZENET_TRANSACTION_KEY", $tran_key); 
define("AUTHORIZENET_SANDBOX", true); 
$sale = new AuthorizeNetAIM; 
$sale->amount = "1"; 
$sale->card_num = "4111111111111111"; 
$sale->exp_date = "0115"; 
$response = $sale->authorizeAndCapture(); 

echo '<pre>';
print_r($response);


?>