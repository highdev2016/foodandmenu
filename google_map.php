<html>
<head><title>Google Map</title></head>
<body>
<h2>Google Map</h2>
<br />
	<form action="" method="post">
		Type Your Location : <input type="text" name="myaddress" /> (eg. Whitefield, Bangalore)
	</form>
<br />
<?php
//blog.theonlytutorials.com
//author: agurchand

if(isset($_POST['myaddress'])){
$myaddress = urlencode($_POST['myaddress']);
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

?>
<br />
<!-- Print the Latitude and Longitude -->
<?php echo "Latitude: ". $latlng->lat ."<br />". "Longitude:". $latlng->lng; ?>
<!--<h2>Dynamic Location on Google Map!</h2>
<iframe class="map" width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $myaddress;?>&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo urlencode($formattedaddress);?>&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>-->
<?php
}
}
?>

</body>
</html>

