<!DOCTYPE html>
<html> 
<head> 
  <meta https-equiv="content-type" content="text/html; charset=UTF-8"> 
  <title>Google Maps Multiple Markers</title> 
  <script src="https://maps.google.com/maps/api/js?sensor=false"></script>
</head> 
<body>
  <div id="map" style="width: 500px; height: 400px;"></div>
  
  <script>
										// Define your locations: HTML content for the info window, latitude, longitude
										var locations = [
														  ['<h4>Mimis Asian Fusion</h4>', 30.1565102, -97.7893495],
														  ['<h4>La Familia Restaurant</h4>', 30.2153878, -97.8332859],
														  ['<h4>China House</h4>', 30.3785973, -97.7246763],
														  ['<h4>China Emperor</h4>', 30.192528, -97.779874],
														  ['<h4>Wings-To-Go</h4>', 30.2197694, -97.8357154],
														  ['<h4>Wing Stop</h4>', 30.236987, -97.724017],
														  ['<h4>Wing Stop</h4>', 30.3659142, -97.6970816],
														  ['<h4>Wing Stop</h4>', 30.3659142, -97.6970816],
														  ['<h4>Austins Pizza</h4>', 30.2794077, -97.8058525],
														  ['<h4>Jason\s Deli</h4>', 30.2916454, -97.8271013],
														  ['<h4>Quizno\s</h4>', 30.2916454, -97.8271013],
														  ['<h4>Thai Kitchen</h4>', 30.2764703, -97.8041047],
														  ['<h4>Boomerang Pies</h4>', 30.2984584, -97.7412468],
														  ['<h4>Carving Board Deli</h4>', 30.3219638, -97.6834396],
														  ['<h4>Casa Chapala</h4>', 30.36136, -97.73946],
														  ['<h4>Casa Chapala Mexican Grill</h4>', 30.2626962, -97.7420831],
														  ['<h4>Cinnamons Bakery</h4>', 30.3252021, -97.7075415],
														  ['<h4>China Star</h4>', 30.2354922, -97.8571399],
														  ['<h4>China Kitchen</h4>', 30.3132904, -97.6637804],
														  ['<h4>China Hill Restaurant</h4>', 30.2083348, -97.8173237],
														  ['<h4>China Dynasty</h4>', 30.1750373, -97.8248529],
														  ['<h4>Cornucopia</h4>', 30.2826443, -97.7422473],
														  ['<h4>Craigos Pizza & Pastaria</h4>', 30.1376871, -97.795956],
														  ['<h4>Dish A Licious</h4>', 30.2259488, -97.7145152],
														  ['<h4>El Meson</h4>', 30.2489654, -97.7689554],
														  ['<h4>The Pizza Bistro</h4>', 30.2778986, -97.7729143],
														  ['<h4>Tuk Tuk Thai Café</h4>', 30.2159258, -97.7967428],
														  ['<h4>Bamboo Bistro - South Austin</h4>', 30.2076627, -97.8155489],
														  ['<h4>Tien Jin Restaurant</h4>', 30.2307429, -97.8026052],
																				];
										
										// Setup the different icons and shadows
										var iconURLPrefix = 'https://maps.google.com/mapfiles/ms/icons/';
										
										var icons = [
										  iconURLPrefix + 'red-dot.png',
										  /*iconURLPrefix + 'green-dot.png',
										  iconURLPrefix + 'blue-dot.png',
										  iconURLPrefix + 'orange-dot.png',
										  iconURLPrefix + 'purple-dot.png',
										  iconURLPrefix + 'pink-dot.png',      
										  iconURLPrefix + 'yellow-dot.png'*/
										]
										var iconsLength = icons.length;
									
										var map = new google.maps.Map(document.getElementById('map'), {
										  zoom: 10,
										  center: new google.maps.LatLng(30.267153, -97.7430608),
										  mapTypeId: google.maps.MapTypeId.ROADMAP,
										  mapTypeControl: false,
										  streetViewControl: false,
										  panControl: false,
										  zoomControlOptions: {
											 position: google.maps.ControlPosition.LEFT_BOTTOM
										  }
										});
									
										var infowindow = new google.maps.InfoWindow({
										  maxWidth: 160
										});
									
										var markers = new Array();
										
										var iconCounter = 0;
										
										// Add the markers and infowindows to the map
										for (var i = 0; i < locations.length; i++) {  
										  var marker = new google.maps.Marker({
											position: new google.maps.LatLng(locations[i][1], locations[i][2]),
											map: map,
											icon: icons[iconCounter]
										  });
									
										  markers.push(marker);
									
										  google.maps.event.addListener(marker, 'click', (function(marker, i) {
											return function() {
											  infowindow.setContent(locations[i][0]);
											  infowindow.open(map, marker);
											}
										  })(marker, i));
										  
										  iconCounter++;
										  // We only have a limited number of possible icon colors, so we may have to restart the counter
										  if(iconCounter >= iconsLength) {
											iconCounter = 0;
										  }
										}
									
										function autoCenter() {
										  //  Create a new viewpoint bound
										  var bounds = new google.maps.LatLngBounds();
										  //  Go through each...
										  for (var i = 0; i < markers.length; i++) {  
													bounds.extend(markers[i].position);
										  }
										  //  Fit these bounds to the map
										  map.fitBounds(bounds);
										}
										autoCenter();
									  </script> 
</body>
</html>