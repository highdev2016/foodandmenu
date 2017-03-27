<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<?php 
ob_start();
session_start();
//print_r($_SESSION);
include("includes/header_profile.php");
include("includes/functions.php");
include("admin/lib/conn.php");

?>

<style type="text/css">
#fade11{
	width: 100%;
	height: 800px;
	position: fixed;
	z-index: 50;
	background: rgb(223, 105, 0);
	opacity: 0.5;
}
.controls {
	margin-top: 16px;
	border: 1px solid transparent;
	border-radius: 2px 0 0 2px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	height: 32px;
	outline: none;
	box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#address {
	background-color: #fff;
	padding: 0 11px 0 13px;
	width: 400px;
	font-family: Roboto;
	font-size: 15px;
	font-weight: 300;
	text-overflow: ellipsis;
}

#address:focus {
	border-color: #4d90fe;
	margin-left: -1px;
	padding-left: 14px;  /* Regular padding-left + 1. */
	width: 401px;
}

.pac-container {
	font-family: Roboto;
	z-index:9999999999999999999999999999999999 !important;
	font-family: Calibri !important;
	font-size:14px !important;
}

#map-canvas{
  display:none;
}
</style>

<body onLoad="init();">

<?php if($_REQUEST['succ_msg']!=''){ $display = 'block'; } else { $display = 'none'; } ?> 

<div id="fade11" style="display:<?php echo $display; ?>"></div>

<div style="width:400px; height:1px; margin:0 auto; display:<?php echo $display;?>" id="light">
<div  style="width:300px; position:absolute; z-index:9999999; background:#fff; padding:50px 20px; color:#000; font-family:Calibri; font-size:18px; height:100px; -moz-box-shadow: 0 0 5px #888;-webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888; text-align:center; margin-top:200px; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border:#2C4598 2px solid;">
<?php 
if(($_REQUEST['succ_msg'] == 1)){
	$style = 'margin-left: 302px; position: absolute; margin-top: -60px; cursor:pointer;';
}
?>

<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade11').style.display='none';document.getElementById('fade').style.display='none'"><img src="images/fancy_closebox.png" style="<?php echo $style; ?>"/></a>
<?php if($_REQUEST['succ_msg'] == 1){ echo "Your Message has been sent Successfully"; }
?></div></div>

<?php //include ("includes/top_search.php");?>

<?php //include ("includes/menu_section.php");?>

<?php include ("includes/header_inner_new.php");?>

<?php $sql_catering_service = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_services_dress_payment WHERE restaurant_id = '".$_REQUEST['id']."'"));?>
<div class="body_section">
    <div class="body_container">
        <div class="body_top"></div>
        <div class="main_body">
            <div class="food_body_cont">
                <div class="food_content">
                
                    
                    <?php include("includes/restaurant_top.php");?>
                    
                    <div class="accr_menu" id="tab">
                        <?php include('includes/tab_menu.php');?>
                        </div>
                    <div class="clear"></div>
                    <?php
					$sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
					?>
					<div class="profile_details">
                    <?php 
					$sql_res_business = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['id']."'"));?>
                    <div class="profile_details_top social_details">
                    <h1>
                    <?php if($sql_restaurant['website']!=""){ ?>
                    <a href="<?php echo $sql_restaurant['website'];?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/website.png" alt="" style="margin-top:7px;"  /> Website
					</a>
                    <?php } ?>
                    <?php if($sql_restaurant['restaurant_facebook_url']!="" && $sql_restaurant['restaurant_facebook_url']!="#"){ ?>
                    <a href="<?php echo $sql_restaurant['restaurant_facebook_url'];?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/facebook.png" alt="" style="margin-top:7px;" width="18px"  /> Facebook
                    </a>
                    <?php } ?>
                    <?php if($sql_restaurant['restaurant_twitter_url']!="" && $sql_restaurant['restaurant_twitter_url']!="#"){ ?>
                    <a href="<?php echo $sql_restaurant['restaurant_twitter_url'];?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/twitter.png" alt="" style="margin-top:7px;" width="18px" /> Twitter
                    </a>
					<?php } ?>
                    <?php if($sql_restaurant['restaurant_google_plus_url']!="" && $sql_restaurant['restaurant_google_plus_url']!="#"){ ?>
                    <a href="<?php echo $sql_restaurant['restaurant_google_plus_url'];?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/google_plus.png" alt="" style="margin-top:7px;" width="18px" /> Google Plus
                    </a>
                    <?php } ?>
                    <?php if($sql_restaurant['restaurant_urbanspoon_url']!="" && $sql_restaurant['restaurant_urbanspoon_url']!="#"){ ?>
                    <a href="<?php echo $sql_restaurant['restaurant_urbanspoon_url'];?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/urbanspoon.png" alt="" style="margin-top:7px;" width="18px" /> Urbanspoon
                    </a>
                    <?php } ?>
                    </h1>
                    
                    <div class="clear"></div>
                    
                    </div>
                    
                    <?php if($sql_restaurant['restaurant_description'] != "") { ?>
                    <div class="profile_details_sec abt_detail" style="border-bottom:1px solid #FFB171; background:#F8F8F8;">
                    <h1>About Us:</h1>
                    <img src="images/separator.png">
                    <div class="clear"></div>                    
                    <span>
                    	<?php echo stripslashes(htmlspecialchars_decode($sql_restaurant['restaurant_description'])); ?>
                    </span>
                    </div>
                    <?php } ?>
                    <div class="profile_details_bottom">
                    
                    <div class="profile_left">
                    
                    <div class="profile_details_left new_pro_left">
                    <h2>Business Hours</h2>
                    <h3>Business Open hours</h3>
                     
                     <!------------------------------------ Monday Business Hours -------------------------->
                     <?php $sql_monday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['id']."' AND days_id = 1");
					 $id_mon = 1;
					 while($array_monday_hrs = mysql_fetch_array($sql_monday_buss_hrs)){
					 echo '<p class="timerow">';
						 if($id_mon == 1){
							 echo "<strong> Monday Business Hours </strong> ";
						 }
						echo '<span>: '.$array_monday_hrs['time_from']." to ".$array_monday_hrs['time_to'].'</span>';
						 $id_mon++;
						echo '</p>';
					 }?>
                     <!------------------------------------ Monday Business Hours -------------------------->
                     
                     <!------------------------------------ Tuesday Business Hours -------------------------->
                     <?php $sql_tuesday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['id']."' AND days_id = 2");
					 $id_tue = 1;
					 while($array_tuesday_hrs = mysql_fetch_array($sql_tuesday_buss_hrs)){
						 echo '<p class="timerow">';
						 if($id_tue == 1){
							 echo "<strong>Tuesday Business Hours  </strong>";
						 }
						 echo '<span>: '.$array_tuesday_hrs['time_from']." to ".$array_tuesday_hrs['time_to'].'</span>';
						 $id_tue++;
						 echo '</p>';
					 }?>
                     <!------------------------------------ Tuesday Business Hours -------------------------->
                     
                     <!------------------------------------ Wednesday Business Hours -------------------------->
                     <?php $sql_wednesday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['id']."' AND days_id = 3");
					 $id_wed = 1;
					 while($array_wednesday_hrs = mysql_fetch_array($sql_wednesday_buss_hrs)){
						  echo '<p class="timerow">';	
						 if($id_wed == 1){
							 echo "<strong>Wednesday Business Hours </strong>";
						 }
						 echo '<span>: '.$array_wednesday_hrs['time_from']." to ".$array_wednesday_hrs['time_to'].'</span>';
						 $id_wed++;
						  echo '</p>';
					 }?>
                     <!------------------------------------ Wednesday Business Hours -------------------------->
                     
                     
                     <!------------------------------------ Thursday Business Hours -------------------------->
                     <?php $sql_thursday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['id']."' AND days_id = 4");
					 $id_thu = 1;
					 while($array_thursday_hrs = mysql_fetch_array($sql_thursday_buss_hrs)){
						echo '<p class="timerow">';	
						 if($id_thu == 1){
							 echo "<strong>Thursday Business Hours </strong>";
						 }
						 echo '<span>: '.$array_thursday_hrs['time_from']." to ".$array_thursday_hrs['time_to'].'</span>';
						 $id_thu++;
						 echo '</p>';
					 }?>
                     <!------------------------------------ Thursday Business Hours -------------------------->
                     
                     
                     <!------------------------------------ Friday Business Hours -------------------------->
                     <?php $sql_friday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['id']."' AND days_id = 5");
					 $id_fri = 1;
					 while($array_friday_hrs = mysql_fetch_array($sql_friday_buss_hrs)){
						 echo '<p class="timerow">';
						 if($id_fri == 1){
							 echo "<strong>Friday Business Hours  </strong>";
						 }
						 echo '<span>: '.$array_friday_hrs['time_from']." to ".$array_friday_hrs['time_to'].'</span>';
						 $id_fri++;
						 echo '</p>';
					 }?>
                     <!------------------------------------ Friday Business Hours -------------------------->
                     
                     
                     
                     <!------------------------------------ Saturday Business Hours -------------------------->
                     <?php $sql_saturday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['id']."' AND days_id = 6");
					 $id_sat = 1;
					 while($array_saturday_hrs = mysql_fetch_array($sql_saturday_buss_hrs)){
						 echo '<p class="timerow">';	
						 if($id_sat == 1){
							 echo "<strong>Saturday Business Hours  </strong>";
						 }
						 echo '<span>: '.$array_saturday_hrs['time_from']." to ".$array_saturday_hrs['time_to'].'</span>';
						 $id_sat++;
						 echo '</p>';
					 }?>
                     <!------------------------------------ Saturday Business Hours -------------------------->
                     
                     
                     <!------------------------------------ Sunday Business Hours -------------------------->
                     <?php $sql_sunday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['id']."' AND days_id = 7");
					 $id_sun = 1;
					 while($array_sunday_hrs = mysql_fetch_array($sql_sunday_buss_hrs)){
						echo '<p class="timerow">';
						 if($id_sun == 1){
							 echo "<strong> Sunday Business Hours  </strong>";
						 }
						 echo '<span>: '.$array_sunday_hrs['time_from']." to ".$array_sunday_hrs['time_to'].'</span>';
						 $id_sun++;
						  echo '</p>';
					 }?>
                     <!------------------------------------ Sunday Business Hours -------------------------->
                     
                     
                      <?php /*?><?php 
					$sql_extra_business_hours = mysql_query("SELECT * FROM restaurant_extra_business_hours WHERE restaurant_id = '".$_REQUEST['id']."'");
					if(mysql_num_rows($sql_extra_business_hours)>0){?>
                     <h2>Business Extra hours</h2>
                     <?php while($array_extra_business_hours = mysql_fetch_array($sql_extra_business_hours)) {?>
                      <p><?php echo $array_extra_business_hours['title'];?> - <?php echo $array_extra_business_hours['hours'];?></p>
                      <?php } } ?><?php */?>
                    </div>
                    
                    
                    <div class="special_feature">
                        <h2>Special Features</h2>
                        <ul>
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['self_service']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Self-Serve</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['waiter_service']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Waiter-Service</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['kid_friendly']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Kid-Friendly</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['handicape']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Handicap</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['outdoor_seating']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Outdoor Seating</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['alchohol']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Alcohol</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['bar_seating']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Bar-Seating</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['wi_fi']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Wi-Fi</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['live_music']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Live-Music</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_res_business['pickup']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Take Out</li>
                        
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['catering_service']==1) { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Catering Services</li>
                        
                        </ul>
                        
                        <div class="clear"></div>                        
                                  
                        </div>
                    
                    </div>
                    
                    <div class="profile_right">
                    
           <?php 
		   $sql_select = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
		   $address = $sql_select['restaurant_address']." ".$sql_select['restaurant_city']." ".$sql_select['restaurant_state']." ".$sql_select['restaurant_zipcode'];
		   $address_map=str_replace(" ","%20",$address);
		   $address_map=str_replace("#","%23",$address_map);?>         
       <!--  <script type="text/javascript" src="http://maps.google.com.mx/maps/api/js?sensor=true&language=es"></script>-->

<!--<script type="text/javascript">

       var G = google.maps;

       var map;

       var geocoder = new G.Geocoder();

       var marker;

       var markersArray = [1];



        function initialize() {

          createMap();

          geocode('<?php echo $sql_select['restaurant_city'];?>');

        }



        function createMap() {

            var myOptions = {

                center: new G.LatLng(0,0),

                zoom: 16,

                mapTypeId: G.MapTypeId.ROADMAP

            }

            map = new G.Map(document.getElementById("map_canvas"), myOptions);

        }



function geocode(address){

            geocoder.geocode({ 'address': (address ? address : "<?php echo $address; ?>")}, function (results, status) {

                if (status == G.GeocoderStatus.OK) {

                    map.setCenter(results[0].geometry.location);



                        marker = new G.Marker({

                        map: map,

                        animation: google.maps.Animation.DROP,

                        position: results[0].geometry.location

                        });





                } else {

                    alert("Geocode was not successful for the following reason: " + status);

                }

            });



        }

        </script>-->


<?php $rest_nm = str_replace("&","and", $sql_select['restaurant_name']);

//echo  $address_map; ?>

        <?php /*?><div id="map_canvas" class="profile_details_map" style="width: 455px; height: 307px;"><div style="width: 455px"><iframe width="455" height="307" src="http://regiohelden.de/google-maps/map_en.php?width=455&amp;height=307&amp;hl=en&amp;q=<?php echo $address_map; ?>%20+(<?php echo stripslashes($rest_nm)?>)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=A&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div></div><?php */?>
        
        <?php
		$address11 = $address_map; // Google HQ
		$prepAddr = str_replace(' ','+',$address11);
		 
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
		 
		$output= json_decode($geocode);
		 
		$lat_map = $output->results[0]->geometry->location->lat;
		$long_map = $output->results[0]->geometry->location->lng;
		?>
        
        
        <script type="text/javascript" src="https://maps.google.com.mx/maps/api/js?sensor=true&language=es"></script>
       
        
        <script type="text/javascript">
		var $j = jQuery.noConflict();
		
		$j(document).ready(function () {
		// Define the latitude and longitude positions
		var latitude = parseFloat("<?php echo $lat_map; ?>"); // Latitude get from above variable
		var longitude = parseFloat("<?php echo $long_map; ?>"); // Longitude from same
		var latlngPos = new google.maps.LatLng(latitude, longitude);
		// Set up options for the Google map
		var myOptions = {
		zoom: 10,
		center: latlngPos,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		zoomControlOptions: true,
		zoomControlOptions: {
		style: google.maps.ZoomControlStyle.LARGE
		}
		};
		// Define the map
		map = new google.maps.Map(document.getElementById("map"), myOptions);
		// Add the marker
		var marker = new google.maps.Marker({
		position: latlngPos,
		map: map,
		title: "<?php echo $rest_nm; ?>"
		});
		});
		</script>
		<div id="map" class="mapcontaner"></div>


                    
                    <!--<div class="profile_details_map">
                    <img src="images/profile_map.jpg" width="455" height="187" /></div>  
                    </div>-->
                    
                    <div class="clear"></div>
                    
                    <div class="payment_sec">
                    
                    	<?php
                        $payment = explode(',',$sql_catering_service['payment_method']);
                        ?>
                        <h2>Payment Methods</h2>
                        <ul class="middle_border_bottom">
                        <li class="profile_li_class">
                        <?php
                        if(in_array("Cash",$payment)){ ?>
                            <img src="images/cash.png" title="Cash">
                        <?php } ?>
                        <?php
                        if(in_array("Visa Card",$payment)){ ?>
                            <img src="images/visa_card.png" title="Visa Card">
                        <?php } ?>
                        <?php
                        if(in_array("Master Card",$payment)){ ?>
                            <img src="images/master_card.png" title="Master Card">
                        <?php } ?>
                        <?php
                        if(in_array("Amex Card",$payment)){ ?>
                            <img src="images/amex_card.png" title="Amex Card">
                        <?php } ?>
                        <?php
                        if(in_array("Discovery Card",$payment)){ ?>
                            <img src="images/discovery_card.png" title="Discovery Card">
                        <?php } ?>
                        </li>
                        </ul>   
                    
                    </div>
                    
                    <div class="clear"></div>
                    
                    <div class="dresscode_sec">
                    
                    	<h2>Dresscode</h2>
                        <ul>
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['dress_code']=="Casual") { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Casual</li>
                        <li class="profile_li_class">
                        <?php if($sql_catering_service['dress_code']=="Dressy") { ?><img src="images/checked_checkbox.png" width="10" height="10"><?php } else { ?><img src="images/checkbox_unchecked.png" width="10" height="10"><?php } ?>
                        Dressy</li>
                       
                        </ul> 
                        
                        <div class="clear"></div> 
                        
                    </div>               
                    
                    </div>
                    
                    <div class="clear"></div>
                    
                    <div class="fusion_form">
                    <h2>Contact <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$_REQUEST['id']); ?></h2>
                    <form name="contact" id="contact" method="post" action="" enctype="multipart/form-data" onSubmit="return submit_contact_form();">
                    <div class="left_input_sec">
                    	<h1>Contact Form</h1>                    	
                        <input type="text" name="name" id="name" class="profilefield" placeholder="Name">
                        <input type="email" name="email" id="email" class="profilefield" placeholder="Email">
                        <input type="text" name="phone" id="phone" class="profilefield" placeholder="Phone">
                        <input type="text" name="subject" id="subject" class="profilefield" placeholder="Subject">
                        <div class="clear"></div>
                    </div>
                    
                    <div class="right_input_sec">
                        <textarea name="message" id="message" class="profilearea" placeholder="Type your Message here"></textarea>
                        
                        <div class="captcha_sec">
                        <img src="captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg' style="margin-left:15px;">                    
                        <input type="text" name="captcha_code" id="captcha_code" class="profilefield" placeholder="Enter Captcha Code">
                        <div class="clear"></div>
                        	<div id="cap_error_msg" style="display:none;">The Validation code does not match! </div>
                            <div class="refresh_sec">
                            <span style="color:#595959; font-family:Arial,Helvetica,sans-serif; font-size:13px;">Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</span>
                            <input type="button" name="send" id="send" value="Send" class="profilebutton" onClick="return submit_contact_form();" />
                            <div id="loader_div" style="float:right; display:none; padding-left:20px; padding-top:10px;" ><img src="images/ajax-loader-review.gif" /></div>                            
                            </div>
                        	
                            <div class="clear"></div>
                        
                        </div>
                        <div class="clear"></div>
                                                                        
                        <div style="clear:both;"></div>
                        <input type="hidden" name="hid_res_id" id="hid_res_id" value="<?php echo $_REQUEST['id']; ?>"  />
                        </div>
                        
                        <div class="clear"></div>
                    </form>
                    </div>
                    
                    <div class="">
                    
                    <div class="profile_middle_left middle_border_left">
                    
                    <?php /*?><h2>Delivery Details</h2>
                    <ul>
                    <li class="profile_li_class">Online Delivery - <?php if($sql_res_business['delivery']==1){ echo "Yes"; }else { echo "No";} ?></li>
                    <?php if($sql_res_business['delivery']==1){?>
                    <li class="profile_li_class">Delivery Minimum - <?php echo $sql_res_business['minimum_ammount'];?></li>
                    <li class="profile_li_class">Delivery Charge - <?php echo $sql_res_business['delivery_charge'];?></li></li>
                    <li class="profile_li_class">Delivery Range - <?php echo $sql_res_business['delivery_range'];?></li>
                    <li class="profile_li_class">Delivery Hours - <?php echo $sql_res_business['delivery_hours'];?></li>
                    <?php } ?>
                    </ul><?php */?>
                    
                   <?php /*?> <h2>Take Out Details</h2>
                    <ul>
                    <li class="profile_li_class">Do you offer pick up - <?php if($sql_res_business['pickup']==1){ echo "Yes"; }else { echo "No";} ?></li>
                    <li class="profile_li_class">Do you have drive-thru - <?php if($sql_res_business['drive_thru']==1){ echo "Yes"; }else { echo "No";} ?></li>
                    </ul><?php */?>
                    
                   <!-- <h1>Reservation</h1>
                    <ul>
                    <li>Do you offer Resevation (Yes / No)</li>
                    </ul>-->
                    
                    
                    <?php /*?><h2>Catering Services <span style="color:#686868; font:14px Calibri;"> - <?php if($sql_catering_service['catering_service']==1){ echo "Yes"; }else { echo "No";} ?></span></h2>
                   <?php if($sql_res_business['catering_service']==1) {?> 
                   <ul> 
                    <li class="profile_li_class">Please contact us for more information</li>
                    </ul>
                    <?php } ?><?php */?>

                    
                    </div>
                    
                    
                    
                    
                    <div class="clear"></div>
                    
                    
                    </div>
                       <div class="clear"></div> 
                    </div>
                </div>
            	<div class="clear"></div>
            	<div class="tab_body_cont"></div>
            </div>
            
                <div class="clear"></div>
                <div class="tab_body_cont"></div>
            <div class="body_footer_bg"></div>
        </div>
        
        <div class="clear"></div>
    </div>
</div>
</div>

<div class="clear"></div>

<script type="text/javascript">
function submit_contact_form()
{
	var $j = jQuery.noConflict();	
	
	if($j("#name").val() == '' || $j("#email").val() == "" ||  $j("#phone").val() == "" ||  $j("#subject").val() == "" || $j("#message").val() == "" || $j("#captcha_code").val() == ""){
		
		if($j("#name").val() == "")
		{
			alert("Please enter your Name");
			$j("#name").focus();
			return false;	
		}
		
		if($j("#email").val() == "")
		{
			alert("Please enter your Email");
			$j("#email").focus();
			return false;	
		}
		
		if($j("#phone").val() == "")
		{
			alert("Please enter your Phone Number");
			$j("#phone").focus();
			return false;
		}
		
		if($j("#subject").val() == "")
		{
			alert("Please enter your Phone Number");
			$j("#subject").focus();
			return false;
		}
		
		if($j("#message").val() == "")
		{
			alert("Please enter your Message");
			$j("#message").focus();
			return false;	
		}
		
		if($j("#captcha_code").val() == "")
		{
			alert("Please enter Captcha");
			$j("#captcha_code").focus();
			return false;	
		}
	
	}
	else
	{
		$j('#loader_div').show();
	
	
	var name 			= $j('#name').val();
	var email 			= $j('#email').val();
	var phone 			= $j('#phone').val();
	var subject 		= $j('#subject').val();
	var message 		= $j('#message').val();
	var captcha_code 	= $j('#captcha_code').val();
	var rest_id			= $j('#hid_res_id').val();
	
	$j.ajax({
		url : 'contact_us_form.php',
		type : 'POST',
		data : 'captcha_code=' + captcha_code  + '&name=' + name  + '&email=' + email  + '&phone=' + phone  + '&subject=' + subject +'&message=' + message + '&rest_id=' + rest_id ,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			
			if(data == 'Error'){
				$j('#loader_div').hide();
				$j('#cap_error_msg').slideDown(1000);
				$j('#cap_success_msg').slideUp(1000);
				//$j('html, body').animate({ scrollTop: $j('#cap_error_msg').offset().top - 1000 }, '100');
				return false;
			}else{
				//$j('#cap_success_msg').fadeIn(1000);
				//$j.fancybox.close();
				$j('#loader_div').hide();
				window.location="https://foodandmenu.com/profile.php?id="+rest_id+"&succ_msg=1";
			}
			
	
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
	}
}
</script>

<script type="text/javascript" src="javascript/prototype.js"></script>
	<script type="text/javascript" src="javascript/effects.js"></script>
	<script type="text/javascript" src="javascript/accordion.js"></script>
	<script type="text/javascript" src="javascript/code_highlighter.js"></script>
	<script type="text/javascript" src="javascript/javascript.js"></script>
	<script type="text/javascript" src="javascript/html.js"></script>
 <script type="text/javascript">
		jQuery(document).ready(function() {
			

			jQuery("#various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery("#various2").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			jQuery("#various2").fancybox();

			jQuery("#various3").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			jQuery("#various4").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery("#various5").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery(".various6").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery("#various7").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
	</script>
    
<script type="text/javascript" src="js/jquery-ui.js"></script>
<?php /*?><script type="text/javascript">
jQuery(function() {
	jQuery( "input[name=post_date_test]" ).datepicker({
		dateFormat:"mm-dd-yy"
	});
	
	
});
</script><?php */?>

<script type="text/javascript">
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}

</script>
	
  <link rel="stylesheet" href="calender/jquery-ui.css" />  

<?php include("includes/footer_new.php");?>