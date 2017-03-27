<?php

$address = "10001 South IH 35 Austin TX 78747";

$rest_address = "7012 Sunderland trail Austin Texas 78747";

$start = str_replace(' ', '+', $rest_address);
$finish = str_replace(' ', '+', $address);


$url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $start . '&destinations=' . $finish . '&mode=driving&language=en&sensor=false';
$data = file_get_contents($url);
$data = utf8_decode($data);
$obj = json_decode($data);

echo $distance = 0.621371 * ($obj->rows[0]->elements[0]->distance->text);
?>