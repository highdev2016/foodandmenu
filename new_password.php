<?php 
ob_start();
session_start();
include("admin/lib/conn.php");

?>

<?php 
if(isset($_REQUEST['submit'])){	

$password=md5($_REQUEST['password']);
	$sql_new_password=mysql_query("UPDATE  restaurant_customer SET password='".$password."' WHERE id='".$_REQUEST['id']."'");
	if($sql_new_password){
		$success = 1;
	}	
	header("location:login.php?changestatus=1");
 }
?>

<?php include ("includes/reg_header.php"); ?>

<script type="text/javascript">
function valid(){
	if(document.frm.password.value == ''){
		alert("Please enter password");
		document.frm.password.focus();	
		return false;	
	}
	if(document.frm.password.value.length<6){
		alert("Password should be atleast 6 characters");
		document.frm.password.focus();	
		return false;	
	}
	if(document.frm.confirm_password.value == ''){
		alert("Please enter confirmed password");
		document.frm.confirm_password.focus();	
		return false;	
	}
	return true;
}
</script>

<body class="login_bg">

<div class="body_section">
<div class="login_wrapper">

<div class="login_container">
<div class="login_body">

<div class="login_body_cont">

<div class="registration_logo_section"><a href="index.php"><img src="images/logo.png" width="216" height="99" /></a></div>

<div class="registration_section">

<div class="registration_left">

<div class="regi_sign_up">

<div class="regi_left_top">
<h1>New Password</h1>
</div>

<form name="frm" method="post" action="" onSubmit="return valid();">
<div class="regi_field_section">
<?php if($success == 1){ ?>
<p style="color:#788D23; margin-bottom:5px;">Your password is changed successfully</p>
<?php } ?>
<p>New Password * : </p>
<input name="password" type="password" class="regifield" />

<div class="clear"></div>

<p>Confirm New Password * :</p>
<input name="confirm_password" type="password" class="regifield" />

<div class="clear"></div>

</div>

<div class="regi_login">

<input class="regibutton" type="submit" value="submit" name="submit">

</div>
</form>
</div>

</div>

<?php include ("includes/sign_up_right.php");?>

</div>

</div>

</div>

<div class="body_footer_bg"></div>

<div class="clear"></div>
</div>
</div>

</div>

</body>
</html>
