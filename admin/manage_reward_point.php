<?php
function main()
{
	$errors="";
	if($_REQUEST['Update']=="Update")
	{
		if($_REQUEST['minimum_reward_point']!=''){
			mysql_query("update  restaurant_admin set minimum_reward_point ='".$_REQUEST['minimum_reward_point']."' , online_pickup_delivery = '".$_REQUEST['online_pickup_delivery']."' , online_gift_certificate = '".$_REQUEST['online_gift_certificate']."' , online_reservation = '".$_REQUEST['online_reservation']."' , online_review_rating = '".$_REQUEST['online_review_rating']."' where id = 1");	
		}	
			$errors="Reward Points Data Updated Successfully ";
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
window.onload=function(){
	document.getElementById('pwd').focus();
	};

function check_pass()
{
	//var $j = jQuery.noConflict();
	
	if($("#minimum_reward_point").val() == '')
	{
		alert("Reward Point Field cannot be left blank!!");
		$("#minimum_reward_point").focus();
		return false;
	}
	
	if($("#online_pickup_delivery").val() == '')
	{
		alert("Online Pickup/Delivery Field cannot be left blank!!");
		$("#online_pickup_delivery").focus();
		return false;
	}
	
	if($("#online_gift_certificate").val() == '')
	{
		alert("Online Gift Certificate Field cannot be left blank!!");
		$("#online_gift_certificate").focus();
		return false;
	}
	
	if($("#online_reservation").val() == '')
	{
		alert("Online Reservation Field cannot be left blank!!");
		$("#online_reservation").focus();
		return false;
	}
	
	if($("#online_review_rating").val() == '')
	{
		alert("Online Review / Rating Field cannot be left blank!!");
		$("#online_review_rating").focus();
		return false;
	}
	
}

function getkey(e)
{
if (window.event)
return window.event.keyCode;
else if (e)
return e.which;
else
return null;
}
function goodchars(e, goods)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
if (goods.indexOf(keychar) != -1)
return true;
if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
return true;
return false;
}

</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="index.php";
}
</script>
<?php $sql_select = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_admin WHERE id = 1"));?>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Change Reward Point</h2>
<form name="frmchangpass" action="manage_reward_point.php" method="post" onsubmit="return check_pass()">
            	<table width="65%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <?php if($errors!='')
  {?>
  <tr>
    <td align="right"><img src="images/approve.jpg"></td>
    <td class="msg"><?=$errors?></td>
  </tr>
  <?
  }
  ?>
   <tr>
    <td class="text1" align="right">Minimum Reward Point For Redeem <font color="#FF0000">*</font> :</td>
    <td class="normaltext"><input name="minimum_reward_point" id="minimum_reward_point" type="text" class="login_ipboxin"  value="<?php echo $sql_select['minimum_reward_point'];?>" onKeyPress="return goodchars(event,'1234567890.');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Online Pickup/Delivery  <font color="#FF0000">*</font> :</td>
    <td class="normaltext"><input name="online_pickup_delivery" id="online_pickup_delivery" type="text" class="login_ipboxin"  value="<?php echo $sql_select['online_pickup_delivery'];?>" onKeyPress="return goodchars(event,'1234567890.');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Online Gift Certificate  <font color="#FF0000">*</font> :</td>
    <td class="normaltext"><input name="online_gift_certificate" id="online_gift_certificate" type="text" class="login_ipboxin"  value="<?php echo $sql_select['online_gift_certificate'];?>" onKeyPress="return goodchars(event,'1234567890.');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Online Reservation  <font color="#FF0000">*</font> :</td>
    <td class="normaltext"><input name="online_reservation" id="online_reservation" type="text" class="login_ipboxin"  value="<?php echo $sql_select['online_reservation'];?>" onKeyPress="return goodchars(event,'1234567890.');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Online Review / Rating  <font color="#FF0000">*</font> :</td>
    <td class="normaltext"><input name="online_review_rating" id="online_review_rating" type="text" class="login_ipboxin"  value="<?php echo $sql_select['online_review_rating'];?>" onKeyPress="return goodchars(event,'1234567890.');"></td>
  </tr>
  
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="Update" type="submit" value="Update" class="normalbutton" onClick="return checkpassword();">
    <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"template_admin.php";
?>