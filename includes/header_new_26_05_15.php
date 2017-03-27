<?php 
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");
?>
<style>
.pac-container:after {
    background-image: none !important;
    height: 0px;
}
</style>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Food and Menu</title>
<!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1" user-scalable="no">
    
    <!-- Favicons -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-144x144.png">
   
    <!-- Web Fonts  -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Fascinate+Inline' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" id="theme" href="css/selectric.css">
    <link href="css/skdslider.css" rel="stylesheet">
    <link href="css/jquery.bxslider.css" rel="stylesheet">
    
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="http://js.cwhcode.com/html5/"></script>
    <![endif]-->
    <!--[if lte IE 7]>
    <script src="http://js.cwhcode.com/html5/"></script>
    <![endif]-->

	<!--[if lt IE 9]>
	<script src="jquery/respond.min.js"></script>
	<![endif]-->

	 <!-- CSS -->
    <link href="css/style_new.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/animation.css">
    
    <!-- for nav section -->
    
    <link rel="stylesheet" href="css/slicknav.css">
    
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

	<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>-->
    
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
	<script src="jquery/jquery.slicknav.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#menu').slicknav();
    });
    </script>
    
    <!-- select-box-jquery -->
    
      <script src="jquery/jquery.min.js"></script>
	  <script src="jquery/jquery.selectric.js"></script>
      <script src="jquery/demo.js"></script>
      <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
        ga('create', 'UA-42240250-1', 'lcdsantos.github.io');
        ga('require', 'displayfeatures');
        ga('send', 'pageview');
      </script>
      
 <!-- bx slider -->



<script src="jquery/jquery.bxslider.min.js"></script>
<script>
	$(document).ready(function(){
		$('.team').bxSlider({
		  minSlides:1,
		  maxSlides: 4,
		  slideWidth: 265,
		  startSlide: 0,
		  moveSlides: 1,
		  speed:2000,
		  slideMargin: 26
		});
		
		//for Comment Section
		$('.cmt').bxSlider({
		  minSlides:1,
		  maxSlides: 4,
		  slideWidth: 150,
		  startSlide: 0,
		  moveSlides: 1,
		  slideMargin: 26,
		  speed:3000,
		  auto: true,
  		  autoControls: true
		  
		});
	});

</script>
      
    <!-- nav slider -->
    
		<script src="jquery/skdslider.min.js"></script>        
        <script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});
                    jQuery('#demo2').skdslider({'delay':5000, 'animationSpeed': 1000,'showNextPrev':true,'showPlayButton':false,'autoSlide':true,'animationType':'sliding'});
                    jQuery('#demo3').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});
                    
                    jQuery('#responsive').change(function(){
                      $('#responsive_wrapper').width(jQuery(this).val());
                    });
                    
                });
        </script>
        
<!-- scroll to top -->

<script src="jquery/main.js"></script>

<script src="jquery/animations.js"></script>
    
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script>
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

function initialize() {

  var markers = [];
  var map = new google.maps.Map(document.getElementById('map-canvas'), {
   // mapTypeId: google.maps.MapTypeId.ROADMAP
  });

 /* var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(-33.8902, 151.1759),
      new google.maps.LatLng(-33.8474, 151.2631));
  map.fitBounds(defaultBounds);*/

  // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('address'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  // [START region_getplaces]
  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    /*for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }*/

    // For each place, get the icon, place name, and location.
    /*markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location
      });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }*/

    //map.fitBounds(bounds);
  });
  // [END region_getplaces]

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>