<?php
include ("admin/lib/conn.php");

$sql_select = mysql_query("SELECT * FROM restaurant_basic_info WHERE latitude = '' AND longitude = ''");
while($array_select = mysql_fetch_array($sql_select)){
	
	echo $address = $array_select['restaurant_address'].",".$array_select['restaurant_city'].",".$array_select['restaurant_state'].",".$array_select['restaurant_zipcode'].",".$array_select['restaurant_country'];
	
	
	if($address!=''){
	$myaddress = urlencode($address);
	//here is the google api url
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
	//get the content from the api using file_get_contents
	$getmap = file_get_contents($url); 
	//the result is in json format. To decode it use json_decode
	$googlemap = json_decode($getmap);
	//get the latitute, longitude from the json result by doing a for loop
	foreach($googlemap->results as $res){
		$address = $res->geometry;
		$latlng = $address->location;
		$formattedaddress = $res->formatted_address;
	}
		//$sql.= " ,latitude = '".$latlng->lat."' , longitude = '".$latlng->lng."'";
		echo 'hhhhhhh'.$latlng->lat; exit;
		
		$sql_update = mysql_query("UPDATE restaurant_basic_info SET latitude = '".$latlng->lat."' , longitude = '".$latlng->lng."' WHERE id = '".$array_select['id']."' ");
	}
	
	
	
	
	
	
}

?>