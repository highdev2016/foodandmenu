<?php include("admin/lib/conn.php")?>
<?php
$sql_select = mysql_query("SELECT * FROM restaurant_subscriber WHERE email = '".$_REQUEST['email']."'");
if(mysql_num_rows($sql_select) == 0){
mysql_query("insert into restaurant_subscriber set email='".$_REQUEST['email']."'");
}
/*---set email----*/
$expire=time()+60*60*24*30;
setcookie("resEmail", $_REQUEST['email'], $expire);
/*----end-----*/
?>
<div id="level_id_city">
<div class="popup_main">
<div class="popup_form_container">

<div class="popup_bg">
<form name="myfrm_city" method="post" action="">
<div class="popup_inner_bg">

<div class="free_membership"><img src="images/free_membership.png" width="125" height="124" /></div>

<div class="inner_bg_top">
<h1>your city for less</h1>
<p>Get up to 20% off great deals on restaurant, spas and expreriences<br />
in your city</p>
</div>

<div class="clear"></div>

<div class="popup_divider"><img src="images/popup_divider.png" width="507" height="21" /></div>


<div class="inner_bg_middle">

<p>What city would you like?</p>

<input name="city_address" id="city_address" type="text" class="popup_textfield" />
<div class="clear"></div>
</div>

<div class="continue_button">
<input name="submit" type="button" value="Continue" class="button_pop" onclick="getCity(document.getElementById('city_address').value)" /> 
<div class="clear"></div>
</div>

<div class="button_text">
<!--<p>By subscribing, I agree to the terms service and privacy and policy</p>-->
</div>

<div class="inner_bg_bottom">
  <a href="#"><img src="images/member_sign_button.png" width="141" height="48" /> </a>
  </div>

</div>
</form>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>

</div>
</div>