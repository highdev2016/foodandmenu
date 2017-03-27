<?php
$off_name1 = '500 Dallas St Houston , TX 77002';
$reg_office_address = urlencode('500 Dallas St Houston , TX 77002');
//here is the google api url
$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$reg_office_address&sensor=false";
//get the content from the api using file_get_contents
$getmap = file_get_contents($url);
//the result is in json format. To decode it use json_decode
$googlemap = json_decode($getmap);
//get the latitute, longitude from the json result by doing a for loop

foreach($googlemap->results as $res){
$address = $res->geometry;
$latlng = $address->location;
$formattedaddress = $res->formatted_address;

$lat_office = $latlng->lat;
$lng_office = $latlng->lng;
}

$off_name2 = '10001 Interstate 35 Frontage Rd Suite290 Austin , TX 78747';
$corporate_office_address = urlencode('10001 Interstate 35 Frontage Rd Suite290 Austin , TX 78747');
//here is the google api url
$url2 = "https://maps.googleapis.com/maps/api/geocode/json?address=$corporate_office_address&sensor=false";
//get the content from the api using file_get_contents
$getmap2 = file_get_contents($url2);
//the result is in json format. To decode it use json_decode
$googlemap2 = json_decode($getmap2);
//get the latitute, longitude from the json result by doing a for loop

foreach($googlemap2->results as $res2){
$address2 = $res2->geometry;
$latlng2 = $address2->location;
$formattedaddress2 = $res2->formatted_address;

$lat_corporate_office = $latlng2->lat ;
$lng_corporate_office = $latlng2->lng;
}

$off_name3 = '9112 Anderson Mill Rd Austin , TX 78729';
$head_office_address = urlencode('9112 Anderson Mill Rd Austin , TX 78729');
//here is the google api url
$url1 = "https://maps.googleapis.com/maps/api/geocode/json?address=$head_office_address&sensor=false";
//get the content from the api using file_get_contents
$getmap1 = file_get_contents($url1);
//the result is in json format. To decode it use json_decode
$googlemap1 = json_decode($getmap1);
//get the latitute, longitude from the json result by doing a for loop

foreach($googlemap1->results as $res1){
$address1 = $res1->geometry;
$latlng1 = $address1->location;
$formattedaddress1 = $res1->formatted_address;

$lat_head_office = $latlng1->lat;
$lng_head_office = $latlng1->lng;
}


$latitude = ($lat_office + $lat_head_office + $lat_corporate_office)/3;
$longitude = ($lng_office + $lng_head_office + $lng_corporate_office)/3;

$test1 = '<div><img src="http://localhost/test/images/img5_83_1404140621.jpg" height="150" width="250"><br>Test 1</div>';
$test2 = '<div><img src="http://localhost/test/images/186691398.jpg" height="150" width="250"><br>Test 1</div>';
$test3 = '<div><img src="http://localhost/test/images/179849479.jpg" height="150" width="250"><br>Test 1</div>';

?>
<script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<div id="content_contact_us">
       <div class="welcome_section" style="margin-bottom:5px;">
         
           <div class="contact_location">
		   <div id="map_canvas" style="width: 985px; height: 300px;"></div>
 <script type="text/javascript">

var locations = [
['<?php echo $test1; ?>',<?php echo $lat_office; ?>,<?php echo $lng_office; ?>,0,''],
['<?php echo $test2; ?>',<?php echo $lat_corporate_office; ?>,<?php echo $lng_corporate_office; ?>,0,''],
['<?php echo $test3; ?>',<?php echo $lat_head_office; ?>,<?php echo $lng_head_office; ?>,0,'']
];


var map = new google.maps.Map(document.getElementById('map_canvas'), {
panControl: false,
zoomControl: true,
zoomControlOptions: {
    style: google.maps.ZoomControlStyle.LARGE,
    position: google.maps.ControlPosition.LEFT_CENTER
},
scaleControl: true,
scaleControlOptions: {
    position: google.maps.ControlPosition.BOTTOM_LEFT
},
streetViewControl: false,
  zoom: 9,
  center: new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>),
  mapTypeId: google.maps.MapTypeId.ROADMAP
});




var infowindow = new google.maps.InfoWindow();

var marker, i;

for (i = 0; i < locations.length; i++) { 
  marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    map: map,
    animation: google.maps.Animation.DROP,
	club: 'Roanoke'
	
	//icon: 'http://google-maps-icons.googlecode.com/files/sailboat-tourism.png'
  });
  

  google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
      infowindow.setContent(locations[i][0]);
      infowindow.open(map, marker);
	  
    }
  })(marker, i));
}
</script>
