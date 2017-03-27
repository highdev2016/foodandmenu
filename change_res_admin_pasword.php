<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
if(!isset($_SESSION['restaurant_admin_panel_id'])){
	header('location:restaurant_admin_login.php');
}
//rest_chk_authentication();
//print_r($_SESSION);


if($_REQUEST['submit'] == 'Submit'){
	$sql_select = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin_panel WHERE restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."' "));
	
	if($sql_select['password'] == md5($_REQUEST['old_password'])){
		$sql_update_password = mysql_query("UPDATE restaurant_admin_panel SET password = '".md5($_REQUEST['new_password'])."' WHERE restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."' ");
		$success = 1;
		header("location:change_res_admin_pasword.php?success=".$success);
	}
	else{
		$error = 1;
		header("location:change_res_admin_pasword.php?error=".$error);
	}
	
	
	
	
	
	
}

?>

<script type="text/javascript">
function validate(){
	if(document.getElementById('old_password').value == ''){
		alert("Please Enter Old Password.");
		document.getElementById('old_password').focus();
		return false;
	}
	if(document.getElementById('new_password').value == ''){
		alert("Please Enter New Password.");
		document.getElementById('new_password').focus();
		return false;
	}
	if(document.getElementById('confirm_new_password').value == ''){
		alert("Please Enter Confirmed Password.");
		document.getElementById('confirm_new_password').focus();
		return false;
	}
	if(document.getElementById('new_password').value!=document.getElementById('confirm_new_password').value){
		alert("Password and Confirm Password is not matching.");
		document.getElementById('confirm_new_password').value = '';
		document.getElementById('confirm_new_password').focus();
		return false;
	}
}
</script>

<body>

<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont restu_live_cont change_res_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">

<p style="color:#454EA8; font-size:21px;">Change Password</p>

<?php if($_REQUEST['error'] == 1){ ?>
<p style="text-align:center;">Old Password is Not Matching.</p>
<?php } ?>

<?php if($_REQUEST['success'] == 1){ ?>
<p style="text-align:center;">Password Changed Successfully.</p>
<?php } ?>

<form name="change_pass_frm" id="change_pass_frm" method="post" action="" onSubmit="return validate();">
<table align="center" width="700">
<tr>
<td width="114">Old Password : </td><td width="219"><input type="password" name="old_password" id="old_password" value="" class="restaurant"></td></tr>
<tr>
<td width="152">New Password : </td><td width="277"><input type="password" name="new_password" id="new_password" value="" class="restaurant"></td></tr>
<tr>
<td width="115">Confirm New Password : </td><td width="298"><input type="password" name="confirm_new_password" id="confirm_new_password" value="" class="restaurant"></td>
</tr>
<tr>
<td width="115" colspan="2"><input type="submit" name="submit" value="Submit" class="button4" style="margin-left:381px;"></td>
</tr>
</table>
</form>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

