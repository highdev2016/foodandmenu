<script type="text/javascript">
function validate(){
	if(document.getElementById('city').value == ''){
		alert('Please enter your address');
		document.getElementById('city').focus();
		return false;
	}
	if((document.getElementById('city').value == '') && (document.getElementById('rest_item').value!= '')){
		alert('Please enter your address');
		document.getElementById('city').focus
	}
	return true;
}
</script>
<?php include ("search_compete_area.php"); ?>
<div class="header_section">

<div class="header_top">

<div class="header_container">
<?php //echo $_SERVER['PHP_SELF']?>
<?php if($_SERVER['PHP_SELF']=='/restaurant/add_restaurant.php' || $_SERVER['PHP_SELF']=='/restaurant/additional.php' || $_SERVER['PHP_SELF']=='/restaurant/restaurant_menu.php' || $_SERVER['PHP_SELF']=='/restaurant/multimedia.php' || $_SERVER['PHP_SELF']=='/restaurant/confirmation.php' || $_SERVER['PHP_SELF']=='/restaurant/special_offer.php'){?>
<div class="logo_left"><img src="images/logo.png" width="216" height="99" /></div>
<?php
}
else{
?>
<div class="logo_left">
<?php if($_SESSION['city'])
{
?>
<a href="home.php?city=<?php echo $_SESSION['city']?>"><img src="images/logo.png" width="216" height="99" /></a>
<?php
}
else{
?>
<a href="home.php"><img src="images/logo.png" width="216" height="99" /></a>
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

<form name="frm_search" id="frm_search" action="search_area.php" method="get" onsubmit="return validate();">
<div class="search_box">

<div class="left_search">
    <p class="left_search">What are you looking for?<span class="left_search_two">( Restaurant, Cuisine )</span></p>
    <input name="rest_item" id="rest_item" type="text" class="search_textfield" value="<?php //echo $_REQUEST['rest_item']; ?>" />
</div>

<div class="search_two">
<p class="left_search"> Where?<span class="left_search_two">( Full address )</span></p>
<input type="text" name="full_address" id="full_address" class="search_textfield" style="width:230px;" value="<?php //echo $_REQUEST['city']; ?>"  onfocus="if (this.value!='') this.value = ''" autocomplete="off" />
<div class="shadow" id="shadow">
<div class="output" id="output">
</div>
</div>
</div>

<div class="search_button"><input name="btn_search" id="btn_search" type="submit" value="search" class="button2"/></div>

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