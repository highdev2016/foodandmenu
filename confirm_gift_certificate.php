<title>Food & Menu</title>
<?php
include ("admin/lib/conn.php");
$sql_sel_gift_cer = mysql_num_rows(mysql_query("SELECT confirm_status FROM restaurant_gift_certificate_no WHERE id = '".$_REQUEST['id']."' AND confirm_status = 'Not Confirmed'"));

$sql_sel = mysql_fetch_array(mysql_query("SELECT confirm_status FROM restaurant_gift_certificate_no WHERE id = '".$_REQUEST['id']."'"));

if($sql_sel['confirm_status'] == 'Not Confirmed')
{
	$sql = mysql_query("UPDATE restaurant_gift_certificate_no SET confirm_status = 'Confirmed' WHERE id = '".$_REQUEST['id']."'");
}
if($_REQUEST['user'] == "admin")
{
	$redirect_url = "admin/index.php";
}
elseif($_REQUEST['user'] == "rest_owner")
{
	$redirect_url = "restaurant_admin_login.php";
}
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
</style>
          
<div id="fade11" style="display:block;"></div>

<div style="width:400px; height:1px; margin:0 auto; display:block;" id="light">
<div class="pop-box"  style="position:absolute; z-index:9999999; background:#EFEFEF; padding:34px 24px; color:#000; font-family:Calibri; font-size:18px; -moz-box-shadow: 0 0 5px #888; -webkit-box-shadow: 0 0 5px#888; box-shadow: 0 0 5px #888; text-align:center; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border:#2C4598 2px solid;position: fixed; left: 0px; top: 0px; margin:200px 0 0 500px; z-index: 9999999;">

<a href = "<?php echo $redirect_url; ?>" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade11').style.display='none';document.getElementById('fade').style.display='none'"><img src="images/fancy_closebox.png" style="position:absolute; right:-13px; top:-13px;"/></a>
<?php if($sql_sel_gift_cer == 1){?>
<img src="images/success-icon.png" style="float:left;margin-right:5px;margin-top:18px; "/>
<?php
}
else
{
?>
<img src="images/error_icon.png" style="float:left;margin-right:5px;margin-top:18px; "/>
<?php
}
if($sql_sel_gift_cer == 1){?>
<p style="float:left;font-family:Calibri;font-size:19px;">Gift Certificate Confirmed Successfully</p>
<?php }else{ ?>
<p style="float:left;font-family:Calibri;font-size:19px;">Gift Certificate Already Confirmed</p>
<?php } ?>
               
</div></div>
