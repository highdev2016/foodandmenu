<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<!--    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>-->
    <script>
function initialize() {

  var myLatlng = new google.maps.LatLng(-25.363882,131.044922);
  var mapOptions = {
    zoom: 4,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });
}

//google.maps.event.addDomListener(window, 'load', initialize);

/*function initialize() {
  var mapOptions = {
    zoom: 4,
    center: new google.maps.LatLng(-25.363882,131.044922)
  };
  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });
  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
}*/

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp' +
      '&signed_in=true&callback=initialize';
  document.body.appendChild(script);
}
$j=jQuery.noConflict();
$j(document).ready(function(){
    loadScript();
})

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>