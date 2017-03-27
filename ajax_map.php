<?php
include('admin/lib/conn.php');
include('includes/functions.php');
$lat = $_REQUEST['lat'];
$long = $_REQUEST['long'];
$lat_curr = $_REQUEST['lat_curr'];
$long_curr = $_REQUEST['long_curr'];
$del_pickup = $_REQUEST['set_val'];

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
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

$sql_search = "SELECT t1.*,t2.minimum_ammount FROM restaurant_basic_info as t1 , restaurant_business_delivery_takeout_info as t2 , restaurant_services_dress_payment as t3 WHERE t1.id = t2.restaurant_id AND t1.id = t3.restaurant_id";

if ($del_pickup == "del_pickup") {
    $sql_search.= " AND t2.delivery = 1 AND t2.pickup = 1 ";
}

if ($del_pickup == "del") {
    $sql_search.= " AND t2.delivery = 1";
}

if ($del_pickup == "pickup") {
    $sql_search.= " AND t2.pickup = 1";
}

$res_search = mysql_query($sql_search);

$search_distance = getNameTable("restaurant_admin", "search_mile", "id", "1");

/* while ($row_search = mysql_fetch_array($res_search)) {
  $distance1 = distance($lat_curr, $long_curr, $row_search['latitude'], $row_search['longitude'], "");
  if ($distance1 <= $search_distance) {
  echo $distance1."^".$row_search['latitude']."^".$row_search['longitude']."<br>";
  }
  }

  exit; */
?>
<div id="map_canvas1" style="width: 261px; height: 400px;" ></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    
    function initialize()
    {

        var directionsService = new google.maps.DirectionsService();

        var poly;
        var geodesicPoly;
        var marker1;
        //var marker2;
        var iconURLPrefix = 'https://maps.google.com/mapfiles/ms/icons/';
        var iconURLPrefix1 = 'https://foodandmenu.com/images/';

        var icons = [
            /*iconURLPrefix + 'red-dot.png',*/
            iconURLPrefix + 'green-dot.png',
            iconURLPrefix + 'blue-dot.png',
            iconURLPrefix + 'orange-dot.png',
            iconURLPrefix + 'purple-dot.png',
            iconURLPrefix + 'pink-dot.png',
            iconURLPrefix + 'yellow-dot.png'
        ]

        directionsDisplay = new google.maps.DirectionsRenderer();

        var mapOptions = {
            zoom: 10,
            draggable:true,
            center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>)
        };

        var map = new google.maps.Map(document.getElementById('map_canvas1'),
                mapOptions);

        //map.enableDragging();
        directionsDisplay.setMap(map);

        map.controls[google.maps.ControlPosition.TOP_CENTER].push(
                document.getElementById('info'));

<?php
while ($row_search = mysql_fetch_array($res_search)) {
    $distance1 = distance($lat_curr, $long_curr, $row_search['latitude'], $row_search['longitude'], "");
    if ($distance1 <= $search_distance) {
        ?>
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(<?php echo $row_search['latitude']; ?>, <?php echo $row_search['longitude']; ?>),
                    map: map
                            //title: 'Hello World!'
                });
    <?php }
}
?>
        /*var marker = new google.maps.Marker({
         position: new google.maps.LatLng(30.2794077, -97.8058525),
         map: map,
         title: 'Hello World!'
         });*/

        marker1 = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng('<?php echo $lat_curr; ?>', '<?php echo $long_curr; ?>'),
            icon: iconURLPrefix1 + 'man_icon.png'
        });

        /*marker2 = new google.maps.Marker({
         map: map,
         draggable: true,
         position: new google.maps.LatLng('<?php echo $lat; ?>', '<?php echo $long; ?>'),
         icon: iconURLPrefix + 'green-dot.png'
         });
         */
        /*var bounds = new google.maps.LatLngBounds(marker1.getPosition(),
         marker2.getPosition()
         );
         map.fitBounds(bounds);*/


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


        var request = {
            origin: '<?php echo $lat_curr; ?>, <?php echo $long_curr; ?>',
                        destination: '<?php echo $lat; ?>, <?php echo $long; ?>',
                                    optimizeWaypoints: true,
                                    travelMode: google.maps.TravelMode.DRIVING
                                };
                                directionsService.route(request, function (response, status) {
                                    if (status == google.maps.DirectionsStatus.OK) {
                                        directionsDisplay.setDirections(response);
                                        var route = response.routes[0];
                                        var summaryPanel = document.getElementById('directions_panel');
                                        summaryPanel.innerHTML = '';
                                        for (var i = 0; i < route.legs.length; i++) {
                                            var routeSegment = i + 1;
                                            summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment + '</b><br>';
                                            summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                                            summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                                            summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
                                        }
                                    }
                                });
                            }
                            function loadScript() {
                                var script = document.createElement('script');
                                script.type = 'text/javascript';
                                script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp' +
                                        '&signed_in=true&callback=initialize';
                                document.body.appendChild(script);
                            }
                            $j = jQuery.noConflict();
                            $j(document).ready(function () {
                                loadScript();
                            });



</script>