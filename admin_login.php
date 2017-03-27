<?php 
ob_start();
session_start();
include("admin/lib/conn.php");?>

<?php 
if(isset($_REQUEST['submit'])){
	$password = md5($_REQUEST['password']);
	$email = $_REQUEST['email'];
	$sql_admin = mysql_query("SELECT * FROM  restaurant_admin WHERE username = '".$email."' AND password = '".$password."' AND status = 1");
	$row = mysql_fetch_array($sql_admin);
	//echo "<pre>";print_r($row);exit;
	$_SESSION['admin_login_id'] = $row['id'];
	if(mysql_num_rows($sql_admin) > 0){
		if($_REQUEST['checkbox'] == 1){
		$expire=time()+60*60*24*30;
		setcookie("admin_login_id", $row['id'], $expire); }
		
		
		//$sql_update_login_time = mysql_query("UPDATE restaurant_customer SET last_logged_in = NOW() WHERE id = '".$_SESSION['customer_id']."'");
		
		header("location:admin_home.php");
		
	}
	else{
		$error = 1;
	}
}
?>

<?php include ("includes/reg_header.php"); ?>

<script type="text/javascript">
/*function checkMessenger(themail)
{
	var tomatch  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!tomatch.test(themail))
	{ 
	window.alert('Invalid Email Address');
	return false;
	}
	return true; 
}*/
function valid(){
	if(document.frm.email.value == ''){
		alert("Please enter email");
		document.frm.email.focus();	
		return false;	
	}
	if ((document.frm.email.value!="") && (checkMessenger(document.frm.email.value)==false))
	{
	document.frm.email.value="";
	document.frm.email.focus();
	return false;
	}
	if(document.frm.password.value == ''){
		alert("Please enter password");
		document.frm.password.focus();	
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

<div class="registration_logo_section">

<a href="index.php"><img src="images/logo.png" /></a></div>

<div class="registration_section">

<div class="registration_left">

<div class="regi_sign_up">

<div class="regi_left_top">

<h1>Log in</h1>
</div>

<form name="frm" method="post" action="" onSubmit="return valid();">
<div class="regi_field_section">
<?php if($error == 1){ ?>
<p style="color:red; margin-bottom:5px;">The Username or Password you entered is not valid.</p>
<?php } ?>
<p>Username * : </p>
<input name="email" type="text" class="regifield" autocomplete="off" />

<div class="clear"></div>

<p>Password * :</p>
<input name="password" type="password" class="regifield" />

<div class="clear"></div>

<input name="checkbox" type="checkbox" value="1" class="regicheckbox" />
<p>Keep me logged in </p>

</div>

<div class="regi_login">
<input class="regibutton" type="submit" value="log in" name="submit">


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
