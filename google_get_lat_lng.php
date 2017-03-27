<?php
$address = '10001 South IH 35 Austin  TX  78747'; // Google HQ
$prepAddr = str_replace(' ','+',$address);
 
$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
 
$output= json_decode($geocode);
 
$lat = $output->results[0]->geometry->location->lat;
$long = $output->results[0]->geometry->location->lng;
 
echo $address.'<br>Lat: '.$lat.'<br>Long: '.$long;


function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

//echo distance(30.145158,-97.85092,30.3637821,-97.6837399, "M") . " Miles<br>";
//echo distance(30.3637821,-97.6837399,30.145158,-97.85092, "K") . " Kilometers<br>";
//echo distance(30.3637821,-97.6837399,30.145158,-97.85092, "N") . " Nautical Miles<br>";

 
?>