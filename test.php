<div id="map_canvas1" style="width: 261px; height: 400px;" ></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"
></script>
<script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
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
            center: new google.maps.LatLng(30.1565102, -97.7893495)
        };

        var map = new google.maps.Map(document.getElementById('map_canvas1'),
                mapOptions);

        //map.enableDragging();
        directionsDisplay.setMap(map);

        map.controls[google.maps.ControlPosition.TOP_CENTER].push(
                document.getElementById('info'));

                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.1565102, -97.7893495),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.2153878, -97.8332859),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.192528, -97.779874),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.2197694, -97.8357154),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.3659142, -97.6970816),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.2354922, -97.8571399),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.2083348, -97.8173237),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.1750373, -97.8248529),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.0830907, -97.8421118),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.1376871, -97.795956),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.2159258, -97.7967428),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.2076627, -97.8155489),
                    map: map
                            //title: 'Hello World!'
                });
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(30.2307429, -97.8026052),
                    map: map
                            //title: 'Hello World!'
                });
            /*var marker = new google.maps.Marker({
         position: new google.maps.LatLng(30.2794077, -97.8058525),
         map: map,
         title: 'Hello World!'
         });*/

        marker1 = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng('30.145158', '-97.85092'),
            icon: iconURLPrefix1 + 'man_icon.png'
        });

        /*marker2 = new google.maps.Marker({
         map: map,
         draggable: true,
         position: new google.maps.LatLng('30.1565102', '-97.7893495'),
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
            origin: '30.145158, -97.85092',
                        destination: '30.1565102, -97.7893495',
                                    optimizeWaypoints: true,
                                    travelMode: google.maps.TravelMode.DRIVING
                                };
                                directionsService.route(request, function (response, status) {
                                    if (status == google.maps.DirectionsStatus.OK) {
                                        directionsDisplay.setDirections(response);
                                        var route = response.routes[0];
                                        var summaryPanel = document.getElementById('directions_panel'
);
                                        summaryPanel.innerHTML = '';
                                        for (var i = 0; i < route.legs.length; i++) {
                                            var routeSegment = i + 1;
                                            summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment+ '</b><br>';
                                            summaryPanel.innerHTML += route.legs[i].start_address + 'to';
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