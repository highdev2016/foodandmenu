<?php 
session_start();
include ("admin/lib/conn.php");
include("includes/functions.php");
function getTimezone($location)
{
	$location = urlencode($location);
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address={$location}&sensor=false";
	$data = file_get_contents($url);
	
	// Get the lat/lng out of the data
	$data = json_decode($data);
	if(!$data) return false;
	if(!is_array($data->results)) return false;
	if(!isset($data->results[0])) return false;
	if(!is_object($data->results[0])) return false;
	if(!is_object($data->results[0]->geometry)) return false;
	if(!is_object($data->results[0]->geometry->location)) return false;
	if(!is_numeric($data->results[0]->geometry->location->lat)) return false;
	if(!is_numeric($data->results[0]->geometry->location->lng)) return false;
	$lat = $data->results[0]->geometry->location->lat;
	$lng = $data->results[0]->geometry->location->lng;
	
	// get the API response for the timezone
	$timestamp = time();
	$timezoneAPI = "https://maps.googleapis.com/maps/api/timezone/json?location={$lat},{$lng}&sensor=false&timestamp={$timestamp}";
	$response = file_get_contents($timezoneAPI);
	if(!$response) return false;
	$response = json_decode($response);
	if(!$response) return false;
	if(!is_object($response)) return false;
	if(!is_string($response->timeZoneId)) return false;
	
	return $response->timeZoneId;
}
?>
<!doctype html>
<html><head>
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
		  slideWidth: 150,
		  startSlide: 0,
		  moveSlides: 1,
		  slideMargin: 26,
		  speed:3000,
		  auto: false,
  		  autoControls: true,
		  infiniteLoop: false
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

<script type="text/javascript">
function open_cuisine_div()
{
	$("#cuisine_div").show();
	$("#fade1").show();
}

function close_cuisine_div()
{
	$("#cuisine_div").hide();
	$("#fade1").hide();
}

function place_hid_val(val)
{
	if(val == "default")
	{
		$("#hid_default").val(val);
		$("#hid_top_rated").val('');
		$("#hid_distance").val('');
		$("#hid_min_order").val('');
		$("#hid_newest").val('');
	}
	if(val == "top_rated")
	{
		$("#hid_top_rated").val(val);
		$("#hid_default").val('');
		$("#hid_distance").val('');
		$("#hid_min_order").val('');
		$("#hid_newest").val('');
	}
	if(val == "distance")
	{
		$("#hid_distance").val(val);
		$("#hid_default").val('');
		$("#hid_top_rated").val('');
		$("#hid_min_order").val('');
		$("#hid_newest").val('');
	}
	if(val == "min_order")
	{
		$("#hid_min_order").val(val);
		$("#hid_default").val('');
		$("#hid_top_rated").val('');
		$("#hid_distance").val('');
		$("#hid_newest").val('');
	}
	if(val == "newest")
	{
		$("#hid_newest").val(val);
		$("#hid_default").val('');
		$("#hid_top_rated").val('');
		$("#hid_distance").val('');
		$("#min_order").val('');
	}
}

function open_gift_div(id)
{
	$("#navigation").hide();
	$(".listing_arrow").hide();
	$(".search_panel_pop_div").hide();
	$("#arrow"+id).show();
	$("#gift_pop_div"+id).show();
}
function close_gift_div(id)
{
	$("#navigation").show();
	$("#arrow"+id).hide();
	$("#gift_pop_div"+id).hide();
}
function open_coupon_div(id)
{
	$("#navigation").hide();
	$(".listing_arrow").hide();
	$(".search_panel_pop_div").hide();
	$("#arrow"+id).show();
	$("#coupon_pop_div"+id).show();
}
function close_coupon_div(id)
{
	$("#navigation").show();
	$("#arrow"+id).hide();
	$("#coupon_pop_div"+id).hide();
}
function open_reservation_div(id)
{
	$("#navigation").hide();
	$(".listing_arrow").hide();
	$(".search_panel_pop_div").hide();
	$("#arrow"+id).show();
	$("#reservation_pop_div"+id).show();
}
function close_reservation_div(id)
{
	$("#navigation").show();
	$("#arrow"+id).hide();
	$("#reservation_pop_div"+id).hide();
}
function open_review_div(id)
{
	$("#navigation").hide();
	$(".listing_arrow").hide();
	$(".search_panel_pop_div").hide();
	$("#arrow"+id).show();
	$("#review_pop_div"+id).show();
}
function close_review_div(id)
{
	$("#navigation").show();
	$("#arrow"+id).hide();
	$("#review_pop_div"+id).hide();
}

function open_sunday_div(id)
{
	$(".row_box").hide();
	$("#active_day"+id).css({'left': '0','transition': '1s'})
	$("#day1_hours"+id).fadeIn(1000);
}

function open_monday_div(id)
{
	$(".row_box").hide();
	$("#active_day"+id).css({'left': '37px','transition': '1s'});
	$("#day2_hours"+id).fadeIn(1000);
}

function open_tuesday_div(id)
{
	$(".row_box").hide();
	$("#active_day"+id).css({'left': '73px','transition': '1s'});
	$("#day3_hours"+id).fadeIn(1000);
}

function open_wednesday_div(id)
{
	$(".row_box").hide();
	$("#active_day"+id).css({'left': '109px','transition': '1s'});
	$("#day4_hours"+id).fadeIn(1000);
}

function open_thursday_div(id)
{
	$(".row_box").hide();
	$("#active_day"+id).css({'left': '145px','transition': '1s'});
	$("#day5_hours"+id).fadeIn(1000);
}

function open_friday_div(id)
{
	$(".row_box").hide();
	$("#active_day"+id).css({'left': '181px','transition': '1s'});
	$("#day6_hours"+id).fadeIn(1000);
}

function open_saturday_div(id)
{
	$(".row_box").hide();
	$("#active_day"+id).css({'left': '217px','transition': '1s'});
	$("#day7_hours"+id).fadeIn(1000);
}

function un_chk(cuisine_id){
	if($('#cuisine_pop_'+cuisine_id).prop('checked') == false){
		$('#cuisine_'+cuisine_id).prop('checked', false); 
	}
}

function un_chk1(cuisine_id){
	if($('#cuisine_'+cuisine_id).prop('checked') == false){
		$('#cuisine_pop_'+cuisine_id).prop('checked', false); 
	}
}

</script>

<script src="jquery/main.js"></script>

<script src="jquery/animations.js"></script>
    
<script src="https://maps.google.com/maps/api/js?sensor=false"></script>

<style>
.sticky {
    position: fixed;
    top:0;
}
</style>

</head>

<?php

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
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

//if($_REQUEST['search'] == "Find Restaurants")
//{
	$search_distance = getNameTable("restaurant_admin","search_mile","id","1");
	$address_post = $_REQUEST['address'];
	if($address_post != "")
	{
		$_SESSION['address'] = $address_post;
	}
	$del_pickup = $_REQUEST['set_value'];
	
	$prepAddr = str_replace(' ','+',$_SESSION['address']);
	 
	$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
	 
	$output= json_decode($geocode);
	 
	$lat = $output->results[0]->geometry->location->lat;
	$long = $output->results[0]->geometry->location->lng;
	
	
	
	$sql_search = "SELECT t1.*,t2.minimum_ammount FROM restaurant_basic_info as t1 , restaurant_business_delivery_takeout_info as t2 , restaurant_services_dress_payment as t3 WHERE t1.id = t2.restaurant_id AND t1.id = t3.restaurant_id";
	
	if($del_pickup == "del_pickup")
	{
		$sql_search.= " AND t2.delivery = 1 AND t2.pickup = 1 ";
	}
	
	if($del_pickup == "del")
	{
		$sql_search.= " AND t2.delivery = 1";
	}
	
	if($del_pickup == "pickup")
	{
		$sql_search.= " AND t2.pickup = 1";
	}
	
	if($_REQUEST['pickup'] == "pickup")
	{
		$sql_search.= " AND t2.pickup = 1";
	}
	
	if($_REQUEST['delivery'] == "delivery")
	{
		$sql_search.= " AND t2.delivery = 1";
	}
	
	if($_REQUEST['free_delivery'] == "free_delivery")
	{
		$sql_search.= " AND t2.free_delivery = 1";
	}
	
	if($_REQUEST['coupons'] == "coupons")
	{
		$sel_coup_res = mysql_query("SELECT DISTINCT(restaurant_id) as res_id FROM restaurant_coupon WHERE coupon_status = 1 AND end_date >= '".date('Y-m-d')."'");
		$res_id_str = '';
		$sep = '';
		while($row_coup_res = mysql_fetch_array($sel_coup_res))
		{
			$res_id_str = $res_id_str.$sep.$row_coup_res['res_id'];
			$sep = ',';
		}
		$sql_search.= " AND t1.id IN (".$res_id_str.")";
	}
	
	if($_REQUEST['hot_deals'] == "hot_deals")
	{
		$sel_deal_res = mysql_query("SELECT DISTINCT(restaurant_id) as res_id FROM restaurant_deals WHERE deals_status = 1 AND (expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00')");
		$res_id_deal = '';
		$sep1 = '';
		while($row_deal_res = mysql_fetch_array($sel_deal_res))
		{
			$res_id_deal = $res_id_deal.$sep1.$row_deal_res['res_id'];
			$sep1 = ',';
		}
		$sql_search.= " AND t1.id IN (".$res_id_deal.")";
	}
	
	if($_REQUEST['reservations'] == "reservations")
	{
		$sql_search.= " AND t3.reservation = 1";
	}
	
	if($_REQUEST['search_text'] != "")
	{
		$sql_search.= " AND (t1.restaurant_name LIKE '%".$_REQUEST['search_text']."%' OR t1.restaurant_keyword LIKE '%".$_REQUEST['search_text']."%' OR t1.restaurant_category_name LIKE '%".$_REQUEST['search_text']."%')";
	}
	
	if($_REQUEST['sort_radio'] != "")
	{
		$search_distance = $_REQUEST['sort_radio'];
	}
	
	if($_REQUEST['cuisine'] != "")
	{
		$cuisine_str = '';
		$sep2 = '';
		foreach($_REQUEST['cuisine'] as $cuisine)
		{
			$cuisine_str = $cuisine_str.$sep2.$cuisine;
			$sep2 = ',';
		}
		
		$sql_search.= " AND t1.restaurant_category IN (".$cuisine_str.")";
	}
	//echo $cuisine_str;
	
	/*if($_REQUEST['cuisine_pop'] != "")
	{
		$cuisine_str1 = '';
		$sep2 = '';
		foreach($_REQUEST['cuisine_pop'] as $cuisine1)
		{
			$cuisine_str1 = $cuisine_str1.$sep2.$cuisine1;
			$sep2 = ',';
		}
		
		$sql_search.= " AND t1.restaurant_category IN (".$cuisine_str1.")";
	}*/
	
	
	
	if($_REQUEST['hid_top_rated'] != "")
	{
		$sql_search.= " ORDER BY t1.rated DESC";
	}
	
	if($_REQUEST['hid_distance'] != "")
	{
		$sql_search.= " AND t1.id IN (".$_REQUEST['hid_dis_arr'].") ORDER BY FIELD(t1.id, ".$_REQUEST['hid_dis_arr'].")";
	}
	
	if($_REQUEST['hid_min_order'] != "")
	{
		$sql_search.= " ORDER BY t2.minimum_ammount ASC";
	}
	
	if($_REQUEST['hid_newest'] != "")
	{
		$sql_search.= " ORDER BY t1.id DESC";
	}
	
	//echo $sql_search;
	
	//echo mysql_num_rows(mysql_query($sql_search));/
	
	$res_search = mysql_query($sql_search);
	
	$res_search1 = mysql_query($sql_search);
	
	$res_search2 = mysql_query($sql_search);
	
	$res_search3 = mysql_query($sql_search);
	
	$res_search4 = mysql_query($sql_search);
	
	$res_search5 = mysql_query($sql_search);
	
	$res_arr = array();
	while($res_array = mysql_fetch_array($res_search2))
	{
		$distance2 = distance($lat, $long, $res_array['latitude'], $res_array['longitude'], "");
		//if($distance2 <= $search_distance)
		{
			array_push($res_arr,$res_array['id']);
		}
	}

	$res_str = '';
	$sep = '';
	foreach($res_arr as $arr)
	{
		$res_str = $res_str.$sep.$arr;
		$sep = ',';
	}
	
	

//}
?>

<body>

<!-- Wrapper section start here -->

	<div id="wrapper">
	<?php
    $currentFile = $_SERVER["PHP_SELF"];
    $parts = Explode('/', $currentFile);
    $page= $parts[count($parts) - 1]; 
	?>
    	<!-- header section start here -->
    
            <header class="stick_header banner-serve">
            
                <div class="container">
            
                	<div class="logo_section slideDown">
                    
                    	<a href="index.php"><img src="images/logo1.png"></a>
                    	
                    </div>
                    
                    <div class="nav_section">
                    
                    	<nav>
                        
                        	<ul id="menu">
                               
                                <li><a href="index.php" <?php if($page=="index.php"){?> class="active_menu" <?php }?>>Home</a></li>
                                
                                <li><a href="vendor.php" <?php if($page=="vendor.php"){ $class = "active_menu"; } ?> class="mid_menu">Vendors</a></li>
                                
                                <li><a href="https://foodandmenu.com/blog">Blog</a></li>
                                
                                <li><a href="contact.php" <?php if($page=="contact.php"){?> class="active_menu" <?php }?>>Contact Us</a></li>
                               
                            </ul>
                        
                        </nav>
                    
                    </div>
                    
                    <div class="login-sec">
                    
                    <?php if(isset($_COOKIE['customer_id'])){	
                        $sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
                        $row_name = mysql_fetch_array($sql_customer_name); ?>
                        
                        <a href="javascript:void(0);">Welcome , <?php echo $row_name['firstname']; ?></a>
                        <a href="user_profile.php">User profile</a>
                        <a href="logout.php" >Logout</a>
                        <?php }
                        elseif(isset($_SESSION['customer_id'])){
                        $sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
                        $row_name = mysql_fetch_array($sql_customer_name); ?>
                        <a href="javascript:void(0);">Welcome , <?php echo $row_name['firstname']; ?></a>
                        <a href="user_profile.php">User profile</a>
                        <a href="logout.php" >Logout</a>
                        <?php } else{ ?>
                    
                    	<a href="login.php" class="login_icon"><span><img src="images/login-icon.png"></span> <span>Login</span></a>
                        
                        <a href="signup.php" class="regi_icon"><span><img src="images/regi-icon.png"></span> <span>Register</span></a>
                        
                        <?php } ?>
                        
                        <div class="clear"></div>
                    
                    </div>
                    
                    <div class="clear"></div>
            
              </div>
            
            </header>
        
        <!-- header section end here -->
        
        
        <!-- address section start here  -->
        
        	<section class="search_address_section">
            
            	<div class="container">
                
                	<h1>Your Address: <?php echo $_SESSION['address']; ?></h1>
                    
                    <h2><a href="index.php"><span>CLICK HERE</span> TO CHANGE ADDRESS</a></h2>
                
                </div>
            
            </section>
        
        <!-- address section end here  -->
        
        
        <!-- search section start here -->
        
        	 <section class="search_result_sec">
             <?php 
			 $hot_deals = mysql_query("SELECT * FROM restaurant_deals WHERE restaurant_id IN (".$res_str.") AND deals_status = 1 AND (expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00') ");
			 $hot_deals_count = mysql_num_rows($hot_deals);
			 ?>
            	 <?php if($hot_deals_count > 0) { ?>
             		<div class="hot_deal_sec">
                    
                    	<div class="heading_update_section">
                        
                        	  <p><img src="images/star-bar-orange.png" width="410" height="17"></p>
                            
                              <p>Hot Deals</p>
                                
                              <p><img src="images/star-bar-orange.png" width="410" height="17"></p>
                          
                        </div>
                        
                        <div class="hot_deal_main_sec">
                        
                        <div class="team">
                        <?php while($row_hot_deals = mysql_fetch_array($hot_deals)) {?>
                        <div class="slide">
                          	<div class="slide_inner">
                                <img src="thumb_images/<?php echo $row_hot_deals['daily_picture']; ?>" width="257" height="128">
                                <h3><?php echo stripslashes($row_hot_deals['daily_name']); ?></h3>                                
                                <p><?php /*?>$<?php echo $row_hot_deals['daily_description']; ?> / Your Price : $<?php echo $row_hot_deals['daily_price']; ?><?php */?><br>                                
                                <?php /*?>Expiry Date : <?php echo date('m-d-Y', strtotime($row_hot_deals['expiry_date'])); ?><?php */?></p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4><?php echo stripslashes($row_hot_deals['daily_name']); ?></h4>
                                <p>$<?php echo $row_hot_deals['daily_description']; ?> / Your Price : $<?php echo $row_hot_deals['daily_price']; ?><br>                                
                                Expiry Date : <?php echo date('m-d-Y', strtotime($row_hot_deals['expiry_date'])); ?></p>                              
                                <span class="read-more"><a href="restaurant.php?id=<?php echo $row_hot_deals['restaurant_id']; ?>&deal_id=<?php echo $row_hot_deals['id']; ?>">More..</a></span>
                            </div>
                          </div>
                          <?php /*?><div class="slide">
                          	<div class="slide_inner">
                                <img src="uploaded_images/<?php echo $row_hot_deals['daily_picture']; ?>" width="257" height="128">
                                <h3><?php echo stripslashes($row_hot_deals['daily_name']); ?></h3>                                
                                <p>$25.00 / Your Price : $15.00<br>                                
                                Expiry Date : <?php echo date('m-d-Y', strtotime($row_hot_deals['expiry_date'])); ?></p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4><?php echo stripslashes($row_hot_deals['daily_name']); ?></h4>
                                <p>$25.00 / Your Price : $15.00<br>                                
                                Expiry Date : <?php echo date('m-d-Y', strtotime($row_hot_deals['expiry_date'])); ?></p>                              
                                <span class="read-more"><a href="#">More..</a></span>
                            </div>
                          </div><?php */?>
                          <?php } ?>
                          <?php /*?><div class="slide">
                          	<div class="slide_inner">
                                <img src="images/hot-deal-pic-2.png" width="257" height="128">
                                <h3>45% OFF @ Thai Passion</h3>                                
                                <p>$20.00 / Your Price : $11.00<br>                                
                                Expiry Date : 02-22-2016</p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4>45% OFF @ Thai Passion</h4>
                                <p>$20.00 / Your Price : $11.00<br>                                
                                Expiry Date : 02-22-2016</p>                              
                                <span class="read-more"><a href="#">More..</a></span>
                            </div>
                          </div>
                          
                          <div class="slide">
                          	<div class="slide_inner">
                                <img src="images/hot-deal-pic-3.png" width="257" height="128">
                                <h3>40% OFF ENTIRE MEAL</h3>                                
                                <p>$25.00 / Your Price : $15.00<br>                                
                                Expiry Date : 12-31-2015</p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4>40% OFF ENTIRE MEAL</h4>
                                <p>$25.00 / Your Price : $15.00<br>                                
                                Expiry Date : 12-31-2015</p>                              
                                <span class="read-more"><a href="#">More..</a></span>
                            </div>
                          </div>
                          
                          <div class="slide">
                          	<div class="slide_inner">
                                <img src="images/hot-deal-pic-4.png" width="257" height="128">
                                <h3>45% OFF @ Thai Passion</h3>                                
                                <p>$20.00 / Your Price : $11.00<br>                                
                                Expiry Date : 02-22-2016</p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4>45% OFF @ Thai Passion</h4>
                                <p>$20.00 / Your Price : $11.00<br>                                
                                Expiry Date : 02-22-2016</p>                              
                                <span class="read-more"><a href="#">More..</a></span>
                            </div>
                          </div>
                          
                          <div class="slide">
                          	<div class="slide_inner">
                                <img src="images/hot-deal-pic-1.png" width="257" height="128">
                                <h3>40% OFF ENTIRE MEAL</h3>                                
                                <p>$25.00 / Your Price : $15.00<br>                                
                                Expiry Date : 12-31-2015</p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4>40% OFF ENTIRE MEAL</h4>
                                <p>$25.00 / Your Price : $15.00<br>                                
                                Expiry Date : 12-31-2015</p>                              
                                <span class="read-more"><a href="#">More..</a></span>
                            </div>
                          </div>
                          
                          <div class="slide">
                          	<div class="slide_inner">
                                <img src="images/hot-deal-pic-2.png" width="257" height="128">
                                <h3>45% OFF @ Thai Passion</h3>                                
                                <p>$20.00 / Your Price : $11.00<br>                                
                                Expiry Date : 02-22-2016</p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4>45% OFF @ Thai Passion</h4>
                                <p>$20.00 / Your Price : $11.00<br>                                
                                Expiry Date : 02-22-2016</p>                              
                                <span class="read-more"><a href="#">More..</a></span>
                            </div>
                          </div>
                          
                          <div class="slide">
                          	<div class="slide_inner">
                                <img src="images/hot-deal-pic-3.png" width="257" height="128">
                                <h3>40% OFF ENTIRE MEAL</h3>                                
                                <p>$25.00 / Your Price : $15.00<br>                                
                                Expiry Date : 12-31-2015</p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4>40% OFF ENTIRE MEAL</h4>
                                <p>$25.00 / Your Price : $15.00<br>                                
                                Expiry Date : 12-31-2015</p>                              
                                <span class="read-more"><a href="#">More..</a></span>
                            </div>
                          </div>
                          
                          <div class="slide">
                          	<div class="slide_inner">
                                <img src="images/hot-deal-pic-4.png" width="257" height="128">
                                <h3>45% OFF @ Thai Passion</h3>                                
                                <p>$20.00 / Your Price : $11.00<br>                                
                                Expiry Date : 02-22-2016</p>
                            </div>
                            <!--popup hover-->            
                            <div class="popup-hover">
                                <h4>45% OFF @ Thai Passion</h4>
                                <p>$20.00 / Your Price : $11.00<br>                                
                                Expiry Date : 02-22-2016</p>                              
                                <span class="read-more"><a href="#">More..</a></span>
                            </div>
                          </div> <?php */?>                
                        </div>
                        
                        </div>
                    
                    </div>
                 <?php } ?>
                    <div class="delivery-app-sec app_sec_2">
                
                		<div class="container">
                        
                        	<div class="search_main_sec">
                            
                            	<div class="search_main_sec_inner">
                                <form name="search_form" id="search_form" enctype="multipart/form-data" method="post" action="">
                                
                                	<div class="col-xs-5">
                                    
                                    	<div class="left_search">
                                    
                                    		<h1>What are you looking for?</h1>
                                            
                                            <div class="search_sec_div">
                                            
                                            	<input name="search_text" type="text" class="search_field_two" placeholder="Search" value="<?php if(isset($_REQUEST['search_text'])) echo $_REQUEST['search_text']; ?>">
                                                
                                                <input name="search" type="button" class="search_button_two" value="Search" onClick="sub_form();">
                                                
                                                <div class="clear"></div>
                                            
                                            </div>
                                            <?php
											$del_pick = explode("_",$del_pickup);
											?>
                                            <div class="pick_section">
                                            
                                            	<div class="pick_sec_div">
                                                
                                                	<input name="pickup" id="pickup" type="checkbox" value="pickup" class="pick_check"<?php if($del_pick[0] == "pickup" || $del_pick[1] == "pickup" || $_REQUEST['pickup'] == "pickup") {?> checked <?php } ?> onClick="sub_form();">
                                                    
                                                    <p>Pickup</p>
                                                
                                                	<div class="clear"></div>
                                                
                                                </div>
                                                
                                                <div class="pick_sec_div">
                                                
                                                	<input name="delivery" id="delivery" type="checkbox" value="delivery" class="pick_check"<?php if($del_pick[0] == "del" || $_REQUEST['delivery'] == "delivery") {?> checked <?php } ?> onClick="sub_form();">
                                                    
                                                    <p>Delivery</p>
                                                
                                                	<div class="clear"></div>
                                                
                                                </div>
                                                
                                                <div class="pick_sec_div">
                                                
                                                	<input name="free_delivery" id="free_delivery" type="checkbox" value="free_delivery" class="pick_check"<?php if($_REQUEST['free_delivery'] == "free_delivery") { ?> checked <?php } ?> onClick="sub_form();">
                                                    
                                                    <p>Free Delivery</p>
                                                
                                                	<div class="clear"></div>
                                                
                                                </div>
                                                
                                                <div class="pick_sec_div">
                                                
                                                	<input name="coupons" id="coupons" type="checkbox" value="coupons" class="pick_check" <?php if($_REQUEST['coupons'] == "coupons") { ?> checked <?php } ?> onClick="sub_form();">
                                                    
                                                    <p>Coupons</p>
                                                
                                                	<div class="clear"></div>
                                                
                                                </div>
                                                
                                                <div class="pick_sec_div">
                                                
                                                	<input name="hot_deals" id="hot_deals" type="checkbox" value="hot_deals" class="pick_check" <?php if($_REQUEST['hot_deals'] == "hot_deals") { ?> checked <?php } ?> onClick="sub_form();">
                                                    
                                                    <p>Hot Deals</p>
                                                
                                                	<div class="clear"></div>
                                                
                                                </div>
                                                
                                                <div class="pick_sec_div">
                                                
                                                	<input name="reservations" id="reservations" type="checkbox" value="reservations" class="pick_check" <?php if($_REQUEST['reservations'] == "reservations") { ?> checked <?php } ?> onClick="sub_form();">
                                                    
                                                    <p>Reservation</p>
                                                
                                                	<div class="clear"></div>
                                                
                                                </div>
                                                
                                                <div class="clear"></div>
                                            
                                            </div>
                                        
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="col-xs-7">
                                    
                                    	<div class="right_search">
                                        
                                        	<div class="sort_sec">
                                            
                                            <?php
											$dis_arr = array();
											$dis = array();
											while($row_search3 = mysql_fetch_array($res_search3))
											{
												$distance3 = distance($lat, $long, $row_search3['latitude'], $row_search3['longitude'], "");
												
												if($distance3 <= $search_distance)
												{
													array_push($dis_arr,$row_search3['id']);
													array_push($dis,number_format($distance3,2));
												}
											}
											
											$distance_arr = array_combine($dis_arr,$dis);
											asort($distance_arr);

											$dis_keys = array_keys($distance_arr);
											
											$dis_str = '';
											$sep5 = '';
											foreach($dis_keys as $value){
												$dis_str = $dis_str.$sep5.$value;
												$sep5 = ',';
											}
											
											?>
                                            
                                                <h1>Sort By</h1>     
                                                                                         
                                                <ul>
                                                    <li class="<?php if($_REQUEST['hid_default'] == "default"){?>active_sort<?php } ?>">                                                            
                                                        <label><a href="javascript:void(0);" onClick="place_hid_val('default');sub_form();">Default</a></label>
                                                        <input type="hidden" name="hid_default" id="hid_default" value="<?php echo $_REQUEST['hid_default']; ?>" />
                                                        
                                                    </li>
                                                    
                                                    <li class="<?php if($_REQUEST['hid_top_rated'] == "top_rated"){?>active_sort<?php } ?>">                                                            
                                                        <label><a href="javascript:void(0);" onClick="place_hid_val('top_rated');sub_form();">Top Rated</a></label>
                                                        <input type="hidden" name="hid_top_rated" id="hid_top_rated" value="<?php echo $_REQUEST['hid_top_rated']; ?>" />
                                                    </li>
                                                    
                                                    <li class="<?php if($_REQUEST['hid_distance'] == "distance"){?>active_sort<?php } ?>">                                                            
                                                        <label><a href="javascript:void(0);" onClick="place_hid_val('distance');sub_form();">Distance</a></label>
                                                        <input type="hidden" name="hid_distance" id="hid_distance" value="<?php echo $_REQUEST['hid_distance']; ?>" />
                                                         <input type="hidden" name="hid_dis_arr" value="<?php echo $dis_str; ?>" />
                                                        
                                                    </li>
                                                    
                                                    <li class="<?php if($_REQUEST['hid_min_order'] == "min_order"){?>active_sort<?php } ?>">                                                            
                                                        <label><a href="javascript:void(0);" onClick="place_hid_val('min_order');sub_form();">Min Order</a></label>
                                                        <input type="hidden" name="hid_min_order" id="hid_min_order" value="<?php echo $_REQUEST['hid_min_order']; ?>" />
                                                    </li>
                                                    
                                                    <li class="<?php if($_REQUEST['hid_newest'] == "newest"){?>active_sort<?php } ?>">                                                            
                                                        <label><a href="javascript:void(0);" onClick="place_hid_val('newest');sub_form();">Newest</a></label>
                                                        <input type="hidden" name="hid_newest" id="hid_newest" value="<?php echo $_REQUEST['hid_newest']; ?>" />
                                                    </li>
                                                </ul>  
                                                                                                  
                                            </div>
                                            <?php
											$five_cuisine = mysql_query("SELECT * FROM restaurant_category ORDER BY category_name LIMIT 0,5");
											$all_cuisine = mysql_query("SELECT * FROM restaurant_category ORDER BY category_name");
											?>
                                            <div class="sort_sec cuisines_nw">
                                            
                                                <h1>Cuisines</h1>     
                                                                                         
                                                <ul>
                                                <?php 
												while($row_cuisine = mysql_fetch_array($five_cuisine))
												{
												?>
                                                    <li>  
                                                    	<input name="cuisine[]" type="checkbox" id="cuisine_<?php echo $row_cuisine['id']; ?>" value="<?php echo $row_cuisine['id']; ?>" class="sort_check" onClick="un_chk1('<?php echo $row_cuisine['id']; ?>');sub_form();" <?php if(in_array($row_cuisine['id'],$_REQUEST['cuisine'])) { ?> checked <?php } ?> >                                      
                                                        <label><?php echo $row_cuisine['category_name']; ?></label>
                                                    </li>
                                                    <div class="clear"></div>
                                                <?php
												}
												?>
                                                    
                                                </ul>  
                                                
                                                <div class="clear"></div>
                                                     
                                                <a href="javascript:void(0);" onClick="open_cuisine_div();">More Cuisines</a>
                                                                                                  
                                            </div>
                                            
                                            <div id="cuisine_div" style="display:none;" class="white_content">
                                            <div class="close close-new" onclick="close_cuisine_div();"><a href = "javascript:void(0);"> </a> </div>
                                            <div class="l-contnt up-contnt"> 
                                            
                                            <div class="sort_sec cuisines_nw">
                                            
                                                <h1>Cuisines</h1>     
                                                                                         
                                                <ul>
                                            	<?php 
												while($row_all_cuisine = mysql_fetch_array($all_cuisine))
												{
												?>
                                                    <li>  
                                                    	<?php /*?><input name="cuisine_pop[]" type="checkbox" value="<?php echo $row_all_cuisine['id']; ?>" class="sort_check" onClick="sub_form();" <?php if(in_array($row_all_cuisine['id'],$_REQUEST['cuisine_pop']) || in_array($row_all_cuisine['id'],$_REQUEST['cuisine'])) { ?> checked <?php } ?> >  <?php */?> 
                                                        <input name="cuisine[]" type="checkbox" id="cuisine_pop_<?php echo $row_all_cuisine['id']; ?>" value="<?php echo $row_all_cuisine['id']; ?>" class="sort_check" onClick="un_chk('<?php echo $row_all_cuisine['id']; ?>');sub_form();" <?php if(in_array($row_all_cuisine['id'],$_REQUEST['cuisine'])) { ?> checked <?php } ?> >                                   
                                                        <label><?php echo $row_all_cuisine['category_name']; ?></label>
                                                    </li>
                                                    <div class="clear"></div>
                                                <?php
												}
												?>
                                                </ul>  
                                                
                                                <div class="clear"></div>
                                            </div>
                                            
                                            </div>
                                            </div>
                                            <div id="fade1" class="black_overlay"> </div>
                                            
                                            <div class="sort_sec cuisines_nw">
                                            
                                                <h1>Distance</h1>     
                                                                                         
                                                <ul>
                                                   <?php /*?> <li>  
                                                    	<input name="sort_radio" type="radio" value="" class="sort_radio">                                      
                                                        <label>5 Blocks</label>
                                                    </li><?php */?>
                                                    <div class="clear"></div>
                                                    <li>   
                                                    	<input name="sort_radio" id="sort_radio1" type="radio" value="1" class="sort_radio" onClick="sub_form();" <?php if($_REQUEST['sort_radio'] == "1"){ ?> checked <?php } ?>>                                     
                                                        <label>1 Mile</label>
                                                    </li>
                                                    <div class="clear"></div>
                                                    <li>  
                                                    	<input name="sort_radio" id="sort_radio2" type="radio" value="2" class="sort_radio" onClick="sub_form();" <?php if($_REQUEST['sort_radio'] == "2"){ ?> checked <?php } ?>>                                       
                                                        <label>2 Miles</label>
                                                    </li>
                                                    <div class="clear"></div>
                                                    <li> 
                                                    	<input name="sort_radio" id="sort_radio3" type="radio" value="3" class="sort_radio" onClick="sub_form();" <?php if($_REQUEST['sort_radio'] == "3"){ ?> checked <?php } ?>>                                         
                                                        <label>3 Miles</label>
                                                    </li>
                                                    <div class="clear"></div>
                                                    <li> 
                                                    	<input name="sort_radio" id="sort_radio4" type="radio" value="5" class="sort_radio" onClick="sub_form();" <?php if($_REQUEST['sort_radio'] == "5"){ ?> checked <?php } ?>>                                            
                                                        <label>5 Miles</label>
                                                    </li>
                                                    <div class="clear"></div>
                                                    <li> 
                                                    	<input name="sort_radio" id="sort_radio5" type="radio" value="10" class="sort_radio" onClick="sub_form();" <?php if($_REQUEST['sort_radio'] == "10"){ ?> checked <?php } ?>>                                            
                                                        <label>10 Miles</label>
                                                    </li>
                                                    
                                                </ul> 
                                                
                                                <div class="clear"></div>
                                                
                                                <?php /*?><a href="#">More Distances</a> <?php */?>
                                                                                                  
                                            </div>
                                            
                                            <?php /*?><div class="sort_sec cuisines_nw">
                                            
                                                <h1>Price</h1>     
                                                                                         
                                                <ul>
                                                    <li>  
                                                    	<input name="" type="checkbox" value="" class="sort_check">                                      
                                                        <label>$$$$</label>
                                                    </li>
                                                    <div class="clear"></div>
                                                    <li>   
                                                    	<input name="" type="checkbox" value="" class="sort_check">                                   
                                                        <label>$$$</label>
                                                    </li>
                                                    <div class="clear"></div>
                                                    <li>  
                                                    	<input name="" type="checkbox" value="" class="sort_check">                                 
                                                        <label>$$</label>
                                                    </li>
                                                    <div class="clear"></div>
                                                    <li> 
                                                    	<input name="" type="checkbox" value="" class="sort_check">                                      
                                                        <label>$</label>
                                                    </li>
                                                    <div class="clear"></div>
                                                    <li> 
                                                    	<input name="" type="checkbox" value="" class="sort_check">                                      
                                                        <label>Has Coupon</label>
                                                    </li>
                                                </ul>  
                                                                                                  
                                            </div><?php */?>
                                            
                                            
                                        
                                        </div>
                                    
                                    </div>
                                    
                                    <div class="clear"></div>
                                </form>
                                </div>
                            
                            </div>
                        
                        </div>
                    
                    </div>
                    
                    <div class="search_listing_sec">
                    
                    	<div class="container">
                        
                        	<div class="col-xs-9 padd-left">
                            <?php
							$i = 0;
							while($row_search5 = mysql_fetch_array($res_search5))
							{
								$distance5 = distance($lat, $long, $row_search5['latitude'], $row_search5['longitude'], "");
								
								if($distance5 <= $search_distance)
								{
									$i++;
								}
							}
							
							echo "<span style='font-weight:bold'>".$i."</span> Restaurants serving: <span style='font-weight:bold'>".$_SESSION['address']."</span>";
                            while($row_search = mysql_fetch_array($res_search))
							{
								$distance = distance($lat, $long, $row_search['latitude'], $row_search['longitude'], "");
								
								//if($distance <= $search_distance)
								{
									$sql_select_add = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$row_search['id']."'"));
									$address = $sql_select_add['restaurant_address']." ".$sql_select_add['restaurant_city']." ".$sql_select_add['restaurant_state']." ".$sql_select_add['restaurant_zipcode'];
									
									$timezone = getTimezone($address);
							
									if($timezone!=''){
										date_default_timezone_set($timezone);
									}else{
										date_default_timezone_set('America/Chicago');
									}
									
									$current_time = date('h:i A');
									$today = date('l');
									
									$current_time1 =  DateTime::createFromFormat('H:i A', $current_time);
									$day = strtolower(substr($today,0,3));

									$sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '".$row_search['id']."' AND holiday_date = '".date('Y-m-d')."'");
									$restaurant_holiday = '';
									while($array_holidays = mysql_fetch_array($sql_holidays)){
										$holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
										$holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);
										
										if($current_time1 > $holiday_from && $current_time1 < $holiday_to){
											$restaurant_holiday = 'close';
										}
									}
									
									if($restaurant_holiday!='close'){
										$sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '".strtolower($today)."'"));
										$sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '".$sql_days['id']."' AND restaurant_id = '".$row_search['id']."'");
										$restaurant_status = '';
										while($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)){
											$new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
											$new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);
											
											if($current_time1 > $new_from_tm && $current_time1 < $new_to_tm){
												$restaurant_status = 'open';
											}
										}
									}else{
										$restaurant_status = '';
									}
									
								?>
									<div class="listing_sec_box">
                                
                                	<div class="listing_sec_box_inner">
                                    <div class="listing_arrow" id="arrow<?php echo $row_search['id']; ?>" style="display:none;">
                                		<i class="fa fa-caret-right"></i>
                                    </div>
                                    	<div class="listing_image">
                                    
                                    		<a href="restaurant.php?id=<?php echo $row_search['id']; ?>"><img src="uploaded_images/<?php echo $row_search['restaurant_image']; ?>" width="167"></a>
                                        
                                        </div>
                                        
                                      <div class="listing_details">
                                        
                                       	<h1><a href="restaurant.php?id=<?php echo $row_search['id']; ?>"><?php echo stripslashes($row_search['restaurant_name']); ?></a>
                                        <?php if($restaurant_status == 'open'){?>
                                        <span style="color:#9AA930;">( OPEN )</span>
                                        <?php }else{ ?>
                                        <span style="color:#ff0000;">( CLOSE RIGHT NOW )</span>
                                        <?php } ?>
                                        </h1>
                                        
                                        <?php $sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$row_search['id']."' AND status = 1");
								$no_reviews = mysql_num_rows($sql_reviews);
								$rating = number_format(getRestaurantRating($row_search['id']), 1); ?>
                                            
                                          <ul>
                                <?php            
                                $one_decimal_place = number_format($rating, 1);
			                    $rat_pt = (explode(".",$rating));
			                    $rat_pt[0];
			                    $rat_pt[1];
			                    
			                    $rem = 5 - $rat_pt[0];
								
			                    
			                    if($rating == 0)
			                    {
			                    for($i=0; $i<5;$i++){
			                    ?>
			                    <img width="16" height="15" src="images/star-3.png">
			                    <?php	
			                    }
			                    }
			                    else
			                    {
			                    if($rat_pt[1]<3 && $rat_pt[1]!=0){
			                    for($i=1; $i<=$rating;$i++){
			                    ?>
			                    <img width="16" height="16" src="images/star-1.png">
			                    <?php
			                    }
			                    }
			                    else if($rat_pt[1]>7){
			                    for($i=1; $i<=$rating+1;$i++){
			                    ?>
			                    <img width="16" height="16" src="images/star-1.png">
			                    <?php
			                    }
			                    }
			                    else {
			                    for($i=1; $i<=$rating;$i++){
			                    ?>
			                    <img width="16" height="16" src="images/star-1.png">
			                    <?php
			                    }
			                    }
			                    if($rat_pt[1]!= '' && $rat_pt[1]>2 && $rat_pt[1]<8){
			                    ?>
			                    <img width="16" height="15" src="images/star-2.png">
			                    <?php
			                    }
			                    if($rat_pt[1]!= '' && $rat_pt[1]>2 && $rat_pt[1]<=9){
			                    for($j=1;$j<=$rem-1;$j++){
			                    ?>
			                    <img width="16" height="15" src="images/star-3.png">
			                    <?php
			                    }
			                    }
			                    else {
			                    for($j=1;$j<=$rem;$j++){
			                    ?>
			                    <img width="16" height="15" src="images/star-3.png">
			                    <?php
			                    }
			                    }
			                    }
                                                
                                             ?>
                                            
                                          </ul>
                                          
                                          <p><?php if($no_reviews == 0){?>
			                    <?php echo $no_reviews; ?> Reviews 
			                    <?php }else { ?>
			                    <?php echo $no_reviews; ?> Reviews
			                    <?php } ?></p>
                                          
                                          <p><?php echo $row_search['restaurant_address']; ?><br>

											<?php echo $row_search['restaurant_city']." ".$row_search['restaurant_state']." ".$row_search['restaurant_zipcode']; ?></p>
                                            <?php
													$sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '".$row_search['id']."' ORDER BY delivery_range");
													$del_fee = 0.00;
											  while($array_del_charge = mysql_fetch_array($sql_del_crge)){
											   if($distance <= $array_del_charge['delivery_range']){
												   $del_fee = $array_del_charge['delivery_charge'];
												break;
											   }
											  }
											?>
                                            <ul class="delivery_order">
                                        
                                                <li>Delivery Min: $<?php if($row_search['minimum_ammount'] != "") echo number_format($row_search['minimum_ammount'],2); else echo "0.00"; ?></li>
                                                
                                                <li>Delivery Fee: <?php if($del_fee != 0.00) echo "$".$del_fee; else echo "Free"; ?></li>
                                                
                                                <li>Distance: <?php echo number_format($distance,2); ?> miles</li>
                                            
                                            </ul>
                                        
                                        </div>
                                         <?php
											$all_hot_deals1 = mysql_query("SELECT * FROM restaurant_deals WHERE deals_status = 1 AND (expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00') AND restaurant_id = '".$row_search['id']."'");
											
											$all_coupons1 = mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_status = 1 AND end_date >= '".date('Y-m-d')."' AND restaurant_id = '".$row_search['id']."'");
										 ?>
                                        <div class="listing_buttons">
                                        
                                        	<a href="javascript:void(0);" onClick="open_gift_div('<?php echo $row_search['id']; ?>');">Hot Deals (<?php echo mysql_num_rows($all_hot_deals1); ?>)</a>
                                            
                                            <a href="javascript:void(0);" onClick="open_coupon_div('<?php echo $row_search['id']; ?>');">Online Coupons (<?php echo mysql_num_rows($all_coupons1); ?>)</a>
                                            
                                            <a href="javascript:void(0);" onClick="open_reservation_div('<?php echo $row_search['id']; ?>');open_<?php echo strtolower(date('l')); ?>_div('<?php echo $row_search['id']; ?>');">Online Reservation</a>
                                            
                                            <a href="javascript:void(0);" onClick="open_review_div('<?php echo $row_search['id']; ?>');">Reviews</a>
                                                                                                                                
                                        </div>
                                        
                                        <div class="clear"></div>
                                    
                                    </div>
                                
                              </div>
                              
                              
                              
                              <?php
								}
							}
                          ?>
                            
                            </div>
                            
                            <div class="col-xs-3 padd-right">
                            
                            	<div class="search_map_sec">
                                    
                                    <div class="search_main_map" id="navigation" style="margin-top:19px;">
                                    	<div class="search_main_map_inner">
                                        
                                        	<div id="map" style="width: 261px; height: 400px;"></div>
                                        <script>
										// Define your locations: HTML content for the info window, latitude, longitude
										var locations = [
										<?php while($row_search1 = mysql_fetch_array($res_search1)){ 
										$distance1 = distance($lat, $long, $row_search1['latitude'], $row_search1['longitude'], "");
										if($distance1 <= $search_distance)
										{
										?>
										  ['<h4><?php echo str_replace("'","",$row_search1['restaurant_name']); ?></h4>', <?php echo $row_search1['latitude']; ?>, <?php echo $row_search1['longitude']; ?>],
										<?php } } ?>
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
										  center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>),
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
                                        
                                        	
                                            
                                        </div>
                                    
                                    </div>
                                    
                                    <?php
									while($row_search4 = mysql_fetch_array($res_search4))
									{
										$distance4 = distance($lat, $long, $row_search4['latitude'], $row_search4['longitude'], "");
										
										//if($distance4 <= $search_distance)
										{
									?>
                                    
                                     <?php
											$all_hot_deals = mysql_query("SELECT * FROM restaurant_deals WHERE deals_status = 1 AND (expiry_date > '".date('Y-m-d')."' OR expiry_date = '0000-00-00') AND restaurant_id = '".$row_search4['id']."'");
											
											$all_coupons = mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_status = 1 AND end_date >= '".date('Y-m-d')."' AND restaurant_id = '".$row_search4['id']."'");
										 ?>
                                   
                                    <div class="search_panel_pop_div" id="gift_pop_div<?php echo $row_search4['id']; ?>" style="display:none;">
                                    
                                        <h1>Hot Deals <a href="javascript:void(0);" onClick="close_gift_div('<?php echo $row_search4['id']; ?>');"><i class="fa fa-times"></i></a></h1>
                                                                                                                        
                                        <div class="coupon">
                                          <div class="coupon_right"> 
                                          <?php 
										  if(mysql_num_rows($all_hot_deals) > 0) {
										  while($row_hot_deals = mysql_fetch_array($all_hot_deals)) { 
										  ?>
                                             <p><?php echo $row_hot_deals['daily_description']."/ Your Price ".$row_hot_deals['daily_price']."/ Expiry Date : ".date('m-d-Y', strtotime($row_hot_deals['expiry_date'])); ?></p>
                                          <?php } } else { ?>
                                          	 <p class="red_text">No Hot Deals Available.</p>
                                          <?php } ?>
                                          </div>
                                          <div class="clear"></div>
                                        </div>
                                       <?php if(mysql_num_rows($all_hot_deals) > 0) { ?>
                                       <a ua-label="More Info" ua-action="Info" title="More Info about Hot Deals" href="reservation.php?id=<?php echo $row_search4['id']; ?>" class="btn5 btn_big5 grad_yellow5 more_butt">More Info<span class="arrow5"></span></a>
                                       <?php } ?>
                                    
                                    </div>
                                    
                                    <div class="search_panel_pop_div" id="coupon_pop_div<?php echo $row_search4['id']; ?>" style="display:none;">
                                            
                                        <h1>Online Coupons<a href="javascript:void(0);" onClick="close_coupon_div('<?php echo $row_search4['id']; ?>');"><i class="fa fa-times"></i></a></h1>
                                                                                                                        
                                        <div class="coupon">
                                          <div class="coupon_right"> 
                                          <?php 
										  if(mysql_num_rows($all_coupons) > 0) {
										  while($row_coupons = mysql_fetch_array($all_coupons)) { 
										  ?>
                                             <p><?php echo $row_coupons['coupon_name']; ?></p>
                                          <?php } } else { ?>
                                          	 <p class="red_text">No Coupons Available.</p>
                                          <?php } ?>
                                          </div>
                                          <div class="clear"></div>
                                        </div>
                                       <?php if(mysql_num_rows($all_coupons) > 0) { ?>
                                       <a ua-label="More Info" ua-action="Info" title="More Info about Coupons" href="reservation.php?id=<?php echo $row_search4['id']; ?>" class="btn5 btn_big5 grad_yellow5 more_butt">More Info<span class="arrow5"></span></a>
                                       <?php } ?>
                                    
                                    </div>
                                    
                                    <div class="search_panel_pop_div" id="reservation_pop_div<?php echo $row_search4['id']; ?>" style="display:none;">
                                            
                                        <h1>Online Reservations <a href="javascript:void(0);" onClick="close_reservation_div('<?php echo $row_search4['id']; ?>');"><i class="fa fa-times"></i></a></h1>
                                        
                                        <?php
										$reservation_hours = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$row_search4['id']."'"));
										?>
                                        
                                        <!--Reservation Slider-->                                                                              
                                        <div class="box rest_times">
                                            <ul class="row rest_days f_clear">
                                                <li class=" " order="1" ua-action="Restaurant Hours" ua-label="Sun" onClick="open_sunday_div('<?php echo $row_search4['id']; ?>');">S</li>
                                                <li class=" extra" order="2" ua-action="Restaurant Hours" ua-label="Mon" onClick="open_monday_div('<?php echo $row_search4['id']; ?>');">M</li>
                                                <li class=" extra" order="3" ua-action="Restaurant Hours" ua-label="Tue" onClick="open_tuesday_div('<?php echo $row_search4['id']; ?>');">T</li>
                                                <li class=" extra" order="4" ua-action="Restaurant Hours" ua-label="Wed" onClick="open_wednesday_div('<?php echo $row_search4['id']; ?>');">W</li>
                                                <li class="current extra" order="5" ua-action="Restaurant Hours" ua-label="Thu" onClick="open_thursday_div('<?php echo $row_search4['id']; ?>');">T</li>
                                                <li class=" extra" order="6" ua-action="Restaurant Hours" ua-label="Fri" onClick="open_friday_div('<?php echo $row_search4['id']; ?>');">F</li>
                                                <li class=" extra" order="7" ua-action="Restaurant Hours" ua-label="Sat" onClick="open_saturday_div('<?php echo $row_search4['id']; ?>');">S</li>
                                            </ul>
                                            <div id="active_day<?php echo $row_search4['id']; ?>" class="active_day" style="left: 0px;"></div>
                                            <div id="rest_hours" style="height: 93px;">
                                            
                                                <div id="day1_hours<?php echo $row_search4['id']; ?>" class="row_box hours_box">
                                                    <div class="row">
                                                        <h5>Sunday Hours</h5>
                                                    </div>
                                                    <table class="row extra">
                                                            <tbody><tr>
                                                                <td colspan="2"><p class="<?php if($reservation_hours['reservation_open_Sunday'] == ""){?>rest_closed<?php } ?>"><?php if($reservation_hours['reservation_open_Sunday'] != "") echo date('h:i A' , strtotime($reservation_hours['reservation_open_Sunday']))." to ".date('h:i A' , strtotime($reservation_hours['reservation_close_Sunday'])); else echo "Closed"; ?></p></td>
                                                            </tr>
                                                    </tbody></table>
                                                </div>
                                                <div id="day2_hours<?php echo $row_search4['id']; ?>" class="row_box hours_box" style="display:none;">
                                                    <div class="row">
                                                        <h5>Monday Hours</h5>
                                                    </div>
                                                    <table class="row extra">
                                                            <tbody><tr>
                                                                <td colspan="2"><p class="<?php if($reservation_hours['reservation_open_Monday'] == ""){?>rest_closed<?php } ?>"><?php if($reservation_hours['reservation_open_Monday'] != "") echo date('h:i A' , strtotime($reservation_hours['reservation_open_Monday']))." to ".date('h:i A' , strtotime($reservation_hours['reservation_close_Monday'])); else echo "Closed"; ?></p></td>
                                                            </tr>
                                                    </tbody></table>
                                                </div>
                                                <div id="day3_hours<?php echo $row_search4['id']; ?>" class="row_box hours_box" style="display:none;">
                                                    <div class="row">
                                                        <h5>Tuesday Hours</h5>
                                                    </div>
                                                    <table class="row extra">
                                                            <tbody><tr>
                                                                <td colspan="2"><p class="<?php if($reservation_hours['reservation_open_Tuesday'] == ""){?>rest_closed<?php } ?>"><?php if($reservation_hours['reservation_open_Tuesday'] != "") echo date('h:i A' , strtotime($reservation_hours['reservation_open_Tuesday']))." to ".date('h:i A' , strtotime($reservation_hours['reservation_close_Tuesday'])); else echo "Closed"; ?></p></td>
                                                            </tr>
                                                    </tbody></table>
                                                </div>
                                                <div id="day4_hours<?php echo $row_search4['id']; ?>" class="row_box hours_box" style="display:none;">
                                                    <div class="row">
                                                        <h5>Wednesday Hours</h5>
                                                    </div>
                                                    <table class="row extra">
                                                            <tbody><tr>
                                                                <td colspan="2"><p class="<?php if($reservation_hours['reservation_open_Wednesday'] == ""){?>rest_closed<?php } ?>"><?php if($reservation_hours['reservation_open_Wednesday'] != "") echo date('h:i A' , strtotime($reservation_hours['reservation_open_Wednesday']))." to ".date('h:i A' , strtotime($reservation_hours['reservation_close_Wednesday'])); else echo "Closed"; ?></p></td>
                                                            </tr>
                                                    </tbody></table>
                                                </div>
                                                <div id="day5_hours<?php echo $row_search4['id']; ?>" class="row_box hours_box" style="display:none;">
                                                    <div class="row">
                                                        <h5>Thursday Hours</h5>
                                                    </div>
                                                    <table class="row extra">
                                                            <tbody><tr>
                                                                <td colspan="2"><p class="<?php if($reservation_hours['reservation_open_Thursday'] == ""){?>rest_closed<?php } ?>"><?php if($reservation_hours['reservation_open_Thursday'] != "") echo date('h:i A' , strtotime($reservation_hours['reservation_open_Thursday']))." to ".date('h:i A' , strtotime($reservation_hours['reservation_close_Thursday'])); else echo "Closed"; ?></p></td>
                                                            </tr>
                                                    </tbody></table>
                                                </div>
                                                <div id="day6_hours<?php echo $row_search4['id']; ?>" class="row_box hours_box" style="display:none;">
                                                    <div class="row">
                                                        <h5>Friday Hours</h5>
                                                    </div>
                                                    <table class="row extra">
                                                            <tbody><tr>
                                                                <td colspan="2"><p class="<?php if($reservation_hours['reservation_open_Friday'] == ""){?>rest_closed<?php } ?>"><?php if($reservation_hours['reservation_open_Friday'] != "") echo date('h:i A' , strtotime($reservation_hours['reservation_open_Friday']))." to ".date('h:i A' , strtotime($reservation_hours['reservation_close_Friday'])); else echo "Closed"; ?></p></td>
                                                            </tr>
                                                    </tbody></table>
                                                </div>
                                                <div id="day7_hours<?php echo $row_search4['id']; ?>" class="row_box hours_box" style="display:none;">
                                                    <div class="row">
                                                        <h5>Saturday Hours</h5>
                                                    </div>
                                                    <table class="row extra">
                                                            <tbody><tr>
                                                                <td colspan="2"><p class="<?php if($reservation_hours['reservation_open_Saturday'] == ""){?>rest_closed<?php } ?>"><?php if($reservation_hours['reservation_open_Saturday'] != "") echo date('h:i A' , strtotime($reservation_hours['reservation_open_Saturday']))." to ".date('h:i A' , strtotime($reservation_hours['reservation_close_Saturday'])); else echo "Closed"; ?></p></td>
                                                            </tr>
                                                    </tbody></table>
                                                </div>
                                            </div>
                                            <div class="pad_box row extra more_info">
                                                <a class="btn5 btn_big5 grad_yellow5" href="reservation.php?id=<?php echo $row_search4['id']; ?>#tab" title="Make a Reservation" ua-action="Info" ua-label="More Info">Make a Reservation<span class="arrow5"></span></a>
                                            </div>
                                        </div>
                                        
                                    	 <!--Reservation Slider--> 
                                    </div>
                                    <?php
									$sql_review = mysql_query("SELECT rr.id,rr.post_date,rr.customer_name,rr.customer_email,rr.customer_picture, rr.customer_review,rr.restaurant_id, rr.customer_id , rr.restaurant_name , rr.like , rr.dislike ,  rrat.rating_id ,  rrat.rating_id FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$row_search4['id']."' AND rrat.restaurant_id='".$row_search4['id']."' AND rr.status=1 AND rr.review_status = 0 ORDER BY rr.post_date DESC LIMIT 0,3");
									?>
                                    <div class="search_panel_pop_div" id="review_pop_div<?php echo $row_search4['id']; ?>" style="display:none;">
                                            
                                        <h1>Reviews <a href="javascript:void(0);" onClick="close_review_div('<?php echo $row_search4['id']; ?>');"><i class="fa fa-times"></i></a></h1>
                                        
                                        <div class="coupon">
                                          <div class="coupon_right"> 
                                        <?php
										if(mysql_num_rows($sql_review) > 0) {
										while($res_review=mysql_fetch_array($sql_review))
										{
											$rev_count = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$row_search4['id']."' AND rrat.restaurant_id='".$row_search4['id']."' AND rr.status=1 AND rr.customer_id = '".$res_review['customer_id']."' ORDER BY rr.id DESC"));
										
										$rating = getSingleReviewRating($row_search4['id'],$res_review['id']);
										
										$customerInfo = customerInfo($res_review['customer_id']);
										
										$sql_updated_review = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$row_search4['id']."' AND rrat.restaurant_id='".$row_search4['id']."' AND rr.status=1 AND rr.review_status = 1 AND parent_id = '".$res_review['id']."' ORDER BY rr.id DESC");	
										
								   $iinc = 1;
								   while($row_updated_review = mysql_fetch_array($sql_updated_review))
								   { 
									  $rating_updated = getSingleReviewRating($row_updated_review['restaurant_id'],$row_updated_review['id']);

									   $sql_prev_check = mysql_num_rows(mysql_query("SELECT id FROM restaurant_reviews WHERE parent_id = '".$res_review['id']."'"));
									   if($iinc == 2){
											  $prev_rev_stat = 'Previous Review';
									   }else{
										      $prev_rev_stat = '';
									   }
									   
									   ?>
                                       <div id="updated_reviews" class="separetor" style="margin-bottom:50px;">

                                       <div class="rating_content rviw">
                                       
                                       <ul>	<?php

												$rem = 5 - $rating_updated;

												if($rating_updated > 0)

												{

													for($i=0; $i<$rating_updated;$i++){

												?>

		                                        <li><img width="16" height="16" src="images/star-1.png"></li>

		                                        <?php

													}

													for($j=0;$j<$rem;$j++){

												?>

		                                        <li><img width="16" height="15" src="images/star-3.png"></li>

		                                        <?php

													}

												}

												else{

										?>

		                                 		<li><div style="width:165px;">&nbsp;</div></li>

		

		                                        <?php

												}

												if($rating_updated > 0)

												{

												?>

		                                        <li> <span>Posted by <?php echo $customerInfo['firstname']." ".$customerInfo['lastname'] ." on ".date("m-d-Y",strtotime($row_updated_review['post_date']));?></span></li>

		                                        <?php

												}else{

												?>

		                                         <li>&nbsp;</li>

		                                        <?php

												}

												?>	

		                                	</ul>
                                            <?php
                                            $sql_upd_rev = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_reviews WHERE parent_id = '".$res_review['id']."' ORDER BY id DESC"));
									if($row_updated_review['id'] == $sql_upd_rev['id'])
									{
										$upd_status = "Updated Review";
									}
									else
									{
										$upd_status = "";
									}
									
									?>
                                    <span class="status-review"><!-- <a href=""> --> <?php if($upd_status != '') { ?><img src="../images/refesh-org.png" align="absmiddle"  width="14px" /> <?php } ?><!-- </a> --><?php echo $prev_rev_stat; ?> <?php echo $upd_status; ?> </span>
                                    
                                    
                                       </div>
                                        <div class="clear"></div>
                                        
                                        <p class="review-con"><?php echo $row_updated_review['customer_review']?></p>
                                        
                                       <?php  $sql_owners_comment = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row_updated_review['id']."'"));
									   if(!empty($sql_owners_comment)){
										   $sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment['restaurant_owner_id']."'"));
										   ?>
                                          <div class="next-review">

                                       <div class="next-review-head">

                                       <p><strong>Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row_updated_review['restaurant_id']);?></strong></p>

                                       </div>

                                       <label><?php echo date("m-d-Y", strtotime($sql_owners_comment['post_date']));?>  -  <?php echo "Hi ".$row_updated_review['customer_name']; ?>,</label>

                                       <div class="next-review-cont"><?php echo $sql_owners_comment['comment']; ?></div>

                                       <div class="clear"></div>

                                      </div> 
                                           
                                           <?php
										   
									   }
									   
									   ?>
                                        
                                       </div>
                                       
                                       
                                       
                                       <?php
									   $iinc++;
								   }
											
										?>                                                                                
                                       		
                                          <ul style="float: left; margin: 0 11px 0 0;">
										  <?php
								
										$rating1 = getSingleReviewRating($res_review['restaurant_id'],$res_review['id']);

										//echo $rating1;

										$rem = 5 - $rating1;

										if($rating1 > 0)

										{

											for($i=0; $i<$rating1;$i++){

										?>

                                        <li><img width="16" height="16" src="images/star-1.png"></li>

                                        <?php

											}

											for($j=0;$j<$rem;$j++){

										?>

                                        <li><img width="16" height="15" src="images/star-3.png"></li>

                                        <?php

											}

										}

										else{

								        ?>

                                        <?php

										}


										?>
											<p><?php echo stripslashes($res_review['customer_review'])."<br> <span>Posted by ".$customerInfo['firstname']." ".$customerInfo['lastname']." on ".date('m-d-Y', strtotime($res_review['post_date'])).".</span>"; ?></p>
                                        </ul>
                                        
                                        <?php
                                        
                                        $sql_owners_comment1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$res_review['id']."'"));

							   if(!empty($sql_owners_comment1)){
								   $sql_rest_owner1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment1['restaurant_owner_id']."'"));
								   ?>
                                   <div class="next-review">

							    <div class="next-review-head">

								   <p><strong>Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$res_review['restaurant_id']);?></strong></p>

								 </div>  

							   <label><?php echo date("m-d-Y", strtotime($sql_owners_comment1['post_date']));?>  -  <?php echo "Hi ".$res_review['customer_name']; ?></label>

							   <div class="next-review-cont"><?php echo $sql_owners_comment1['comment']; ?></div>

							   </div>
                                   
                                   <?php
								   
							   }
								   
								   ?>
                                        
                                        <?php
										}
										}
										else
										{
										?>
                                        	<p class="red_text">No Reviews Yet.</p>
                                        <?php
										}
										?>
                                        </div>
                                          <div class="clear"></div>
                                        </div>
                                        <?php if(mysql_num_rows($sql_review) > 0) { ?>
                                        <a ua-label="More Info" ua-action="Info" title="More Reviews" href="review.php?id=<?php echo $row_search4['id']; ?>&deal_id=#tab" class="btn5 btn_big5 grad_yellow5 more_butt">More Info<span class="arrow5"></span></a>
                                        <?php } ?>
                                    
                                    </div>
                            
                            <?php
								}
							}
							?>
                                    
                                </div>
                            
                            </div>
                            
                            <div class="clear"></div>
                        
                        </div>
                    <div id="stopHere"></div>
                    </div>
             
             </section>
        
        <!-- search section end here -->
        
       
        <!-- footer section start here -->
        
        	<footer>
            
            	<div class="footer_top"><a href="#0" class="cd-top">Top</a></div>
                
                <div class="footer_mid">
                
                	<div class="container">
                
                        <div class="footer_mid_box">
                        
                        	<a href="index.html"><img src="images/footer-logo.png"></a>
                        
                        </div>
                        
                        <div class="footer_mid_box">
                        
                        	<h1>Help Links</h1>
                            
                            <ul>
                            	
                                <li><a href="#">About us</a></li>
                                
                                <li><a href="#">FAQ</a></li>
                                
                                <li><a href="#">Add a restaurant</a></li>
                                
                                <li><a href="#">contact us</a></li>
                            
                            </ul>
                        
                        </div>
                        
                        <div class="footer_mid_box">
                        
                        	<h1>Other Links</h1>
                            
                            <ul>
                            	
                                <li><a href="#">Terms and Condition</a></li>
                                
                                <li><a href="#">Privacy Policy</a></li>
                                
                                <li><a href="#">Advertisement</a></li>
                                
                                <li><a href="#">Career</a></li>
                            
                            </ul>
                        
                        </div>
                        
                        <div class="footer_mid_box">
                        
                        	<h1>Contact us</h1>
                            
                            <ul>
                            	
                                <li><a href="#">PO BOX 494</a></li>
                                
                                <li><a href="#">Manchanca, TX. 78652</a></li>
                                
                                <li><a href="#">Telephone: 877-333-7221</a></li>
                                
                                <li><a href="#">Email: contact@foodandmenu.com</a></li>
                            
                            </ul>
                        
                        </div>
                        
                        <div class="footer_mid_box last_mid_box">
                        
                        	<a href="#">Restaurant Owners Login</a>
                            
                          <div class="social_sec">
                            
                           	<p>Follow us:</p>
                                
                              <ul>
                                
                               	  <li><a href="#" title="facebook"><img src="images/fb-icon.png"></a></li>
                                    
                                  <li><a href="#" title="twitter"><img src="images/tweet-icon.png"></a></li>
                                    
                                  <li><a href="#" title="google plus"><img src="images/gplus-icon.png"></a></li>
                                    
                                  <li><a href="#" title="linked-in"><img src="images/linked-in-icon.png"></a></li>
                                
                              </ul>
                            
                            </div>
                        
                        </div>
                        
                        <div class="clear"></div>
                    
                    </div>
                
                </div>
                
                <div class="footer_bottom">
                
                	<p>© 2015 Restaurant website, All right reserved</p>
                
                </div>
            
            </footer>
        
        <!-- footer section end here -->
        
        	    
</div>

<!-- Wrapper section end here -->



</body>
</html>
<script type="text/javascript">
	/*var elementPosition = $('#navigation').offset();

	$(window).scroll(function(){
			if($(window).scrollTop() > elementPosition.top){
				$('#navigation').css({'position':'fixed','top':'0'});
			} else if($(window).scrollTop() < 321){
				$('#navigation').css({'position':'static'});
			}    
	});*/
	
	var navWrap = $('#navigation'),
       // nav = $('nav'),
        startPosition = navWrap.offset().top,
        stopPosition = $('#stopHere').offset().top - navWrap.outerHeight();
    
    $(document).scroll(function () {
        //stick nav to top of page
        var y = $(this).scrollTop()
        
        if (y > startPosition) {
            navWrap.addClass('sticky');
            if (y > stopPosition) {
                navWrap.css('top', stopPosition - y);
            } else {
                navWrap.css('top', 0);
            }
        } else {
            navWrap.removeClass('sticky');
        } 
    });
</script>

<script type="text/javascript">
function sub_form()
{
	document.getElementById("search_form").submit();
}
</script>