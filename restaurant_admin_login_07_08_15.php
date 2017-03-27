<?php 
ob_start();
session_start();
include("admin/lib/conn.php");
include("includes/functions.php");?>

<?php 
if(isset($_REQUEST['submit'])){
	$password = md5(trim($_REQUEST['password']));
	$email 	= trim($_REQUEST['email']);
	
	$sql_login = mysql_query("SELECT * FROM restaurant_admin_panel WHERE email_id = '".$_REQUEST['email']."' AND password = '".md5($_REQUEST['password'])."' AND status = 'Active'");
	$num_rows = mysql_num_rows($sql_login);
	
	$array_login = mysql_fetch_array($sql_login);
	if($num_rows > 0){
		if($_REQUEST['checkbox'] == 1){
		$expire=time()+60*60*24*30;
		setcookie("restaurant_admin_panel_id", $array_login['restaurant_id'] , $expire); }
		$_SESSION['restaurant_admin_panel_id'] = $array_login['restaurant_id'];
		header("location:restaurant_live_orders.php");
	}
	else{
		$error = 1;
	}
}
?>

<?php include ("includes/reg_header.php"); ?>

<script type="text/javascript">
function checkMessenger(themail)
{
	var tomatch  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!tomatch.test(themail))
	{ 
	window.alert('Invalid Email Address');
	return false;
	}
	return true; 
}
function valid(){
	if(document.frm.email.value == ''){
		alert("Please enter email address.");
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
		alert("Please enter password.");
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

<div class="registration_logo_section"><a href="#"><img src="images/logo.png" /></a></div>

<div class="registration_section">

<div class="registration_left">

<div class="regi_sign_up">

<div class="regi_left_top" style="width:350px;">
<h2>You must sign in to manage your restaurant</h2>
<h1>Log in</h1>
</div>

<form name="frm" method="post" action="" onSubmit="return valid();">
<div class="regi_field_section">
<?php if($error == 1){ ?>
<p style="color:red; margin-bottom:5px;">The email address or password entered is not valid.</p>
<?php } ?>

<?php if($_REQUEST['success'] == 1){ ?>
<p style="color:green; margin-bottom:5px;">Password Changed Successfully.</p>
<?php } ?>


<p>Email Address * : </p>
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

<ul>
<li><a href="restaurant_admin_forgot_password.php">Forgot Password?</a></li>
</ul>

</div>
</form>
</div>

</div>

    <div class="registration_right">
    <div class="regi_sign_up_two">
    <ul>
  <!--  <li>We won't automatically post to your wall</li>
    <li>One less password to remember</li>-->
    </ul>
    </div>
    </div>
    
    <div class="clear"></div>


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
