<?php echo '<div id="map-canvas"></div>'; ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry"></script>
    <script type="text/javascript">
var poly;
var geodesicPoly;
var marker1;
var marker2;

var iconURLPrefix = 'https://maps.google.com/mapfiles/ms/icons/';

var icons = [
	  /*iconURLPrefix + 'red-dot.png',*/
	  iconURLPrefix + 'green-dot.png',
	  /*iconURLPrefix + 'blue-dot.png',
	  iconURLPrefix + 'orange-dot.png',
	  iconURLPrefix + 'purple-dot.png',
	  iconURLPrefix + 'pink-dot.png',      
	  iconURLPrefix + 'yellow-dot.png'*/
	]

function initialize() {
  var mapOptions = {
    zoom: 4,
    center: new google.maps.LatLng(34, -40.605)
  };


  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
	  
  //setMarkers(map, beaches);
  
  setMarkers(map, beaches);

  map.controls[google.maps.ControlPosition.TOP_CENTER].push(
      document.getElementById('info'));
	  
	
  marker1 = new google.maps.Marker({
    map: map,
    draggable: true,
    position: new google.maps.LatLng(40.71435280, -74.0059731),
	icon : iconURLPrefix+'yellow-dot.png'
  });

  marker2 = new google.maps.Marker({
    map: map,
    draggable: true,
    position: new google.maps.LatLng(48.8566140, 2.35222190)
  });
  
  marker3 = new google.maps.Marker({
    map: map,
    draggable: true,
    position: new google.maps.LatLng(151.274856, -33.890542)
  });
  
  marker4 = new google.maps.Marker({
    map: map,
    draggable: true,
    position: new google.maps.LatLng(151.259052, -33.923036)
  });
  
  marker5 = new google.maps.Marker({
    map: map,
    draggable: true,
    position: new google.maps.LatLng(151.28747820854187, -33.80010128657071)
  });
  
  marker6 = new google.maps.Marker({
    map: map,
    draggable: true,
    position: new google.maps.LatLng(151.259302, -33.950198)
  });

  var bounds = new google.maps.LatLngBounds(marker1.getPosition(),
      marker2.getPosition());
  map.fitBounds(bounds);

  google.maps.event.addListener(marker1, 'position_changed', update);
  google.maps.event.addListener(marker2, 'position_changed', update);

  var polyOptions = {
    strokeColor: '#FF0000',
    strokeOpacity: 1.0,
    strokeWeight: 3,
    map: map,
  };
  poly = new google.maps.Polyline(polyOptions);

  var geodesicOptions = {
    strokeColor: '#CC0099',
    strokeOpacity: 1.0,
    strokeWeight: 3,
    geodesic: true,
    map: map
  };
  geodesicPoly = new google.maps.Polyline(geodesicOptions);

  update();
  
  
}

 var beaches = [
  ['Bondi Beach', -33.890542, 151.274856, 4],
  ['Coogee Beach', -33.923036, 151.259052, 5],
  ['Cronulla Beach', -34.028249, 151.157507, 3],
  ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
  ['Maroubra Beach', -33.950198, 151.259302, 1]
];

function setMarkers(map, locations) {
  var shape = {
      coords: [1, 1, 1, 20, 18, 20, 18 , 1],
      type: 'poly'
  };
  for (var i = 0; i < locations.length; i++) {
    var beach = locations[i];
    var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: iconURLPrefix+'yellow-dot.png',
        shape: shape,
        title: beach[0],
        zIndex: beach[3]
    });
  }
}

function update() {
  var path = [marker1.getPosition(), marker2.getPosition()];
  poly.setPath(path);
  geodesicPoly.setPath(path);
  /*var heading = google.maps.geometry.spherical.computeHeading(path[0],
      path[1]);
  document.getElementById('heading').value = heading;
  document.getElementById('origin').value = path[0].toString();
  document.getElementById('destination').value = path[1].toString();*/
}

google.maps.event.addDomListener(window, 'load', initialize);
//$(window).bind('gMapsLoaded', initialize);



    </script>
    