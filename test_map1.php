<?php
$address = '2409 Sturgis Ln, Austin TX 78748'; // Google HQ
$prepAddr = str_replace(' ','+',$address);
 
$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
 
$output= json_decode($geocode);
 
$lat = $output->results[0]->geometry->location->lat;
$long = $output->results[0]->geometry->location->lng;


$rest_address = "10001 South IH 35 Austin  TX  78747"; 
$prepAddr1 = str_replace(' ','+',$rest_address);
 
$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr1.'&sensor=false');
 
$output= json_decode($geocode);
 
$lat1 = $output->results[0]->geometry->location->lat;
$long1 = $output->results[0]->geometry->location->lng;

function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return array('distance' => $dist, 'time' => $time);
}



$dist = GetDrivingDistance($lat, $lat1, $long, $long1);
echo 'Distance: <b>'.$dist['distance']*0.621371.'</b><br>Travel time duration: <b>'.$dist['time'].'</b>';



?>