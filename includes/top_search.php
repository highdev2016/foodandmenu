<?php 
include('admin/lib/conn.php');
if($_REQUEST['submit'] == 'Continue'){
$expire=time()+60*60*24*30;
$city = explode(",", $_REQUEST['city_address']);
$sql_getcity = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE restaurant_zipcode = '".$city[0]."'"));
if(!empty($sql_getcity['restaurant_city'])){
	setcookie("resCity", $sql_getcity['restaurant_city'], $expire);	
	setcookie("resState", $city[1], $expire);	
	setcookie("reszip", $city[0], $expire);	
}else{
	setcookie("resCity", $city[0], $expire);
	setcookie("resState", $city[1], $expire);
	setcookie("reszip", '', $expire);	
}
header("location:home.php?city=".$city[0]);
}
?>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery(".slidingDiv").hide();
    jQuery(".show_hide").show();
    jQuery('.show_hide').click(function(){
        jQuery(".slidingDiv").slideToggle();
    });
});
</script>

<script type="text/javascript">
function close_city_div()
{
	document.getElementById('slidingDiv').style.display="none";
}
</script>

<style type="text/css">

.slidingDiv{
	display:none;
}
</style>
<?php
$sep="";
$sql_basic_info_city=mysql_query("SELECT DISTINCT(restaurant_city), restaurant_state FROM restaurant_basic_info where status=1");
while($res_basc_info_city=mysql_fetch_array($sql_basic_info_city))
{
	//$all_city.=$sep.'"'.strtolower($res_basc_info_city['restaurant_city']).'"/"'.strtolower($res_basc_info_city['restaurant_state']).'"';
	$all_city.=$sep.'"'.strtolower($res_basc_info_city['restaurant_city']).",".strtolower($res_basc_info_city['restaurant_state']).'"';
	$sep=",";
}

$sql_basic_info_zipcode=mysql_query("SELECT DISTINCT(restaurant_zipcode) FROM restaurant_basic_info where status=1");
$all_zipcode="";
$sep1 = '';
while($res_basc_info_zipcode=mysql_fetch_array($sql_basic_info_zipcode))
{
	$all_zipcode.=$sep1.'"'.strtolower($res_basc_info_zipcode['restaurant_zipcode']).'"';
	$sep1=",";
}

$full_address = $all_city.",".$all_zipcode;

$zipcode = $all_zipcode;

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<!--<script src="//code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<script>
  jQuery(function() {
    var availableTags = [<?php echo $full_address;?>];
    jQuery( ".city_add" ).autocomplete({
      source: availableTags
    });
  });
  
  jQuery(function() {
    var availableTags = [<?php echo $zipcode;?>];
    jQuery( ".zipcode" ).autocomplete({
      source: availableTags
    });
  });
</script>

<script type="text/javascript">
function validate(){
	if(document.getElementById('city_address').value == ''){
		alert('Please enter city.');
		document.getElementById('city_address').focus();
		return false;
	}
	return true;
}
</script>

<div class="slidingDiv" id="slidingDiv">
<div id="fadenw"></div>
<div id="level_div">
<div class="popup_main">
<div class="popup_form_container">
<div class="close_butt"><a href="#" onClick="close_city_div();"><img src="images/close-butt.png" width="30" height="29" /></a></div>
<div class="popup_bg">
<form name="myfrm_city" method="post" action="" onSubmit="return validate();">
<div class="popup_inner_bg">

<div class="free_membership"><a href="signup.php"><img src="images/free_membership.png" width="125" height="124" /></a></div>

<div class="inner_bg_top" style="padding-top:15px;">
<h1>your city for less</h1>
<p>Get up to 80% off great deals on restaurant in your local city !!!</p>
</div>

<div class="clear"></div>

<div class="popup_divider"><img src="images/popup_divider.png" width="507" height="21" /></div>


<div class="inner_bg_middle">

<p>What city would you like?</p>
<input name="city_address" id="city_address" type="text" class="popup_textfield city_add" autocomplete="off" value="" />


<div class="clear"></div>

<?php /*?>
<p>Zipcode</p>
<input name="zipcode" id="zipcode" type="text" class="popup_textfield zipcode" autocomplete="off" />
<div class="clear"></div><?php */?>

</div>

<div class="continue_button">
<input name="submit" type="submit" value="Continue" class="button_pop" /> 
<div class="clear"></div>
</div>

<div class="button_text">
<!--<p>By subscribing, I agree to the terms service and privacy and policy</p>-->
</div>

<div class="inner_bg_bottom">
	<a href="login.php"><img src="images/member_sign_button.png" width="141" height="48" /> </a>
</div>

</div>
</form>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>

</div>

</div>

</div>

<?php include ("search_compete_area.php"); ?>
<div class="header_section">

<div class="header_top">

<div class="header_container">
<?php $currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$page= $parts[count($parts) - 1]; 
//echo $page;?>
<?php if($_SERVER['PHP_SELF']=='/restaurant/add_restaurant.php' || $_SERVER['PHP_SELF']=='/restaurant/additional.php' || $_SERVER['PHP_SELF']=='/restaurant/restaurant_menu.php' || $_SERVER['PHP_SELF']=='/restaurant/multimedia.php' || $_SERVER['PHP_SELF']=='/restaurant/confirmation.php' || $_SERVER['PHP_SELF']=='/restaurant/special_offer.php'){?>
<div class="logo_left"><img src="images/logo.png" width="173" height="99" /></div>
<?php
}
else{
?>
<div class="logo_left">
<?php if($_SESSION['city'])
{
?>
<a href="home.php?city=<?php echo $_SESSION['city']?>"><img src="images/logo.png" width="173" height="99" /></a>
<?php
}
else{
?>
<a href="home.php"><img src="images/logo.png" width="173" height="99" /></a>
<?php
}
?></div>
<?php
}
?>

<div class="search_right">
<?php if($_SERVER['PHP_SELF']=='/restaurant/add_restaurant.php' || $_SERVER['PHP_SELF']=='/restaurant/additional.php' || $_SERVER['PHP_SELF']=='/restaurant/restaurant_menu.php' || $_SERVER['PHP_SELF']=='/restaurant/multimedia.php' || $_SERVER['PHP_SELF']=='/restaurant/confirmation.php' || $_SERVER['PHP_SELF']=='/restaurant/special_offer.php'){?>
<?php
}else{
?>

<form name="frm_search" id="frm_search" action="search_area.php" method="get">
<div class="search_box">

<div class="left_search">
    <p class="left_search">What are you looking for?<span class="left_search_two">( Restaurant, Cuisine )</span></p>
    <input name="rest_item" id="rest_item" type="text" class="search_textfield" value="<?php //echo $_REQUEST['rest_item']; ?>" />
</div>

<?php /*?><div class="search_two">
<p class="left_search"> Where?<span class="left_search_two">( City,State or Zip code )</span></p>
<input type="text" name="full_address" id="full_address" class="search_textfield city_add" style="width:230px;" value="<?php //echo $_REQUEST['city']; ?>"  onfocus="if (this.value!='') this.value = ''" autocomplete="off" />
<div class="shadow" id="shadow">

<div class="output" id="output" >
</div>
</div>
</div><?php */?>

<?php /*?><div class="output" id="output" <?php if($page=='restaurant.php' || $page=='profile.php' || $page=='review.php' || $page=='cart.php' || $page=='paymentdetails.php'){ ?> style="border: none;" <?php } else { ?> style="border: 1px solid #c9c9c9;" <?php } ?>><?php */?>
<div class="search_button"><input name="btn_search" id="btn_search" type="submit" value="search" class="button2"/></div>
<p class="city_top">Your City : <?php echo $_COOKIE['resCity'].",".$_COOKIE['resState']; ?></p>
<div class="change_city">
	<h1>Change City</h1>
    
    <p><a href="#" class="show_hide">Click Here</a></p>

</div>

<div class="clear"></div>

</div>
</form>

<?php
}
?>
</div>

<div class="clear"></div>
</div>

</div>
</div>
<div class="clear"></div>