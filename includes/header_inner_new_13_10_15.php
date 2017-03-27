<?php
session_start();
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$page = $parts[count($parts) - 1];
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- header section start here -->
            
<!-- for nav section -->

        <link rel="stylesheet" href="css/slicknav.css">

		<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>-->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>



        <script src="jquery/jquery.slicknav.js"></script>
        <script type="text/javascript">
            var $j = jQuery.noConflict();
            $j(document).ready(function () {
                $j('#menu').slicknav();
            });
        </script>
        
        <!-- scroll to top -->

		<script src="jquery/main.js"></script>

            <header class="stick_header banner-serve">

                <div class="container">

                    <div class="logo_section slideDown">

                        <a href="index.php"><img src="images/logo1.png"></a>

                    </div>

                   

                    <div class="nav_section">
                    
                    	<nav>
                        
                        	<ul id="menu">
                               
                                <li><a href="index.php" <?php if($page=="index.php"){?> class="active_menu" <?php }?> >Home</a></li>
                                
                                <li><a href="vendor.php" <?php if($page=="vendor.php"){ $class = "active_menu"; } ?> class="mid_menu <?php echo $class; ?>" >Vendors</a></li>
                                
                                <li><a href="https://foodandmenu.com/blog">Blog</a></li>
                                
                                <li><a href="contact.php" <?php if($page=="contact.php"){?> class="active_menu" <?php }?> >Contact Us</a></li>
                                
                                <?php if(isset($_COOKIE['customer_id'])){	
								$sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
								$row_name = mysql_fetch_array($sql_customer_name); ?>
                                    <li><a href="user_profile.php">User profile</a></li>
                                    <li><a href="logout.php" >Logout</a></li>
								<?php }
								elseif(isset($_SESSION['customer_id'])){
								$sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
								$row_name = mysql_fetch_array($sql_customer_name); ?>
									<li><a href="user_profile.php" class="login_icon log-icon"><span><img src="images/user.png"></span> <span><?php echo $row_name['firstname']; ?></span></a></li>
                                    <!-- <li><a href="user_profile.php"><?php echo $row_name['firstname']; ?></a></li> -->
                                    <li><a href="logout.php" class="regi_icon log-icon"><span><img src="images/logout.png"></span> <span>Logout</span></a></li>
                                    <!-- <li><a href="logout.php" >Logout</a></li> -->
								<?php } else{ ?>
                                    <li><a href="login.php" class="login_icon log-icon"><span><img src="images/login-icon.png"></span> <span>Login</span></a></li>
                                    
                                    <li><a href="signup.php" class="regi_icon log-icon"><span><img src="images/regi-icon.png"></span> <span>Register</span></a></li>
                                <?php } ?>
                            </ul>
                        
                        </nav>
                    
                    </div>
                    
                    <?php /*?><p class="welcome_txt">
                    
                    <?php if(isset($_COOKIE['customer_id'])){	
	                        $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
	                        $row_name1 = mysql_fetch_array($sql_customer_name1); ?>
	                        
	                        <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
	                        <?php } elseif(isset($_SESSION['customer_id'])){
	                        $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
	                        $row_name1 = mysql_fetch_array($sql_customer_name1); ?>
	                        <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
	                        <?php } ?>
                            
                     </p><?php */?>



					<?php /* ?> <div class="wlcm">
                        <?php
                        if (isset($_COOKIE['customer_id'])) {
                            $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '" . $_COOKIE['customer_id'] . "'");
                            $row_name1 = mysql_fetch_array($sql_customer_name1);
                            ?>

                            <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
                            <?php
                        } elseif (isset($_SESSION['customer_id'])) {
                            $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '" . $_SESSION['customer_id'] . "'");
                            $row_name1 = mysql_fetch_array($sql_customer_name1);
                            ?>
                            <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
                        <?php } ?>
                    </div> <?php */ ?>
                    <?php /* ?><div class="login-sec">

                      <?php if(isset($_COOKIE['customer_id'])){
                      $sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
                      $row_name = mysql_fetch_array($sql_customer_name); ?>

                      <!-- <a href="javascript:void(0);">Welcome , <?php //echo $row_name['firstname']; ?></a> -->
                      <a href="user_profile.php">User profile</a>
                      <a href="logout.php" >Logout</a>
                      <?php }
                      elseif(isset($_SESSION['customer_id'])){
                      $sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
                      $row_name = mysql_fetch_array($sql_customer_name); ?>
                      <!-- <a href="javascript:void(0);">Welcome , <?php //echo $row_name['firstname']; ?></a> -->
                      <a href="user_profile.php">User profile</a>
                      <a href="logout.php" >Logout</a>
                      <?php } else{ ?>

                      <a href="login.php" class="login_icon"><span><img src="images/login-icon.png"></span> <span>Login</span></a>

                      <a href="signup.php" class="regi_icon"><span><img src="images/regi-icon.png"></span> <span>Register</span></a>

                      <?php } ?>

                      <div class="clear"></div>

                      </div><?php */ ?>

                    <div class="clear"></div>

                </div>

                <!-- address section start here  -->

                <section class="search_address_section">

                    <div class="container">
					
                    <?php if($page!='profile.php' && $page!='vendor.php' && $page!='contact.php' && $page!='reservation.php' && $page!='review.php' && $page!='write_review.php' && $page!='user_profile.php' && $page!='edit_profile.php' && $page!='order_history.php' && $page!='edit_shipping_billing.php' && $page!='gift_certificate_history.php' && $page!='customer_reviews.php' && $page!='onlinereservation.php' && $page!= 'about.php' && $page!= 'faq.php' && $page!= 'terms.php' && $page!= 'privacy.php' && $page!= 'advertisement.php' && $page!= 'career.php' && $page!= 'check_out.php' && $page!= 'login.php' && $page!= 'signup.php' && $page!= 'user.php' && $page!= 'restaurant_admin_login.php'){ ?>
                        <h1>Your Address: <?php echo $_SESSION['address']; ?></h1>

                        <?php /*?><h2><a href="index.php">CHANGE ADDRESS</a></h2><?php */?>
                        <!--<h2><a href="javascript:void(0);" onclick="open_adress_pop_up();">CHANGE ADDRESS</a></h2>-->
                    <?php } ?>
                    
                    <?php if($page == 'profile.php' || $page == 'vendor.php' || $page == 'contact.php' || $page == 'reservation.php' || $page == 'review.php' || $page == 'write_review.php' || $page == 'user_profile.php' || $page == 'edit_profile.php' || $page == 'order_history.php' || $page == 'edit_shipping_billing.php' || $page == 'gift_certificate_history.php' || $page == 'customer_reviews.php' || $page == 'onlinereservation.php' || $page == 'about.php' || $page == 'faq.php' || $page == 'terms.php' || $page == 'privacy.php' || $page == 'advertisement.php' || $page == 'career.php' || $page == 'check_out.php'  || $page == 'restaurant.php'  || $page == 'login.php' || $page == 'signup.php' || $page == 'user.php' || $page == 'restaurant_admin_login.php'){ ?>
                    	<h2><a href="search_result.php" class="back_restu_link_left">BACK TO RESTAURANT LIST</a>
                        </h2>
                    <?php } ?>
                    
                    <?php if($page!= 'login.php' && $page!= 'signup.php'){ ?>
                        <div class="cart_section">
                        <?php  $ad=get_qty_total() ; ?>
                        <?php if($ad!="")
						      {
						?>		  
						
                            <span class="cart_text"><?php echo $ad;?></span><?php
							  }
							?><a href="cart.php"><img src="images/cart.png" width="20" height="20" style="margin-top:14px; padding-right:5px;"/></a>
                            
                            
                        </div>
                    <?php } ?>
                    
                    <?php
					$ses_rest_id = $_SESSION['cart_rest_id'];
					$sql_res_name_fetch = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$ses_rest_id."'"));
					$restaurant_name = $sql_res_name_fetch['restaurant_name'];
					?>
                    
                    
                    <h2><a href="restaurant.php?id=<?php echo $ses_rest_id;?>" class="back_restu_link">BACK TO <?=$restaurant_name?></a></h2>
                    
                    </div>

                </section>

                <!-- address section end here  -->

            </header>
            
            <div class="header_back"></div>
            
            <div class="clearfix"></div>

<div id="change_address_div" style="display:none;" class="white_content">
<div class="close close-new" onclick="close_address_div();"><a href = "javascript:void(0);"> </a> </div>
<div class="l-contnt up-contnt"> 
<form name="change_address_frm" id="change_address_frm" method="post" action="search_result.php">
<input name="address" id="address" type="text" class="search_field" placeholder="Enter Address">
<div id="map-canvas"></div>
<select id="set_value" name="set_value">
  <option value="del_pickup">Delivery & Pickup</option>
  <option value="del">Delivery</option>
  <option value="pickup">Pickup</option>
</select>
<input name="hid_default" type="hidden" value="default">
<input name="search" type="submit" class="search_button" value="Find Restaurants">
</form>
</div>
</div>

<div id="fade_new" style="display:none;"></div>

<script type="text/javascript">
function open_adress_pop_up(){
	var $j = jQuery.noConflict();
	$j("#change_address_div").show();
	$j("#fade_new").show();
}
function close_address_div(){
	var $j = jQuery.noConflict();
	$j("#change_address_div").hide();
	$j("#fade_new").hide();
}
</script>
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
