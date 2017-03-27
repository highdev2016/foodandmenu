<?php 
ob_start();
session_start();
include("admin/lib/conn.php");?>

<?php 
if(isset($_REQUEST['submit'])){
	$password = md5($_REQUEST['password']);
	$email = $_REQUEST['email'];
	$sql_customer = mysql_query("SELECT * FROM  restaurant_customer WHERE email = '".$email."' AND password = '".$password."' AND status = 1");
	if(mysql_num_rows($sql_customer) > 0){
		$row = mysql_fetch_array($sql_customer);
		if($_REQUEST['checkbox'] == 1){
		$expire=time()+60*60*24*30;
		setcookie("customer_id", $row['id'], $expire); }
		$_SESSION['customer_id'] = $row['id'];
		if($_REQUEST['rev']==1){
		header("location:write_review.php?id=".$_SESSION['resttid']."");	
		}
		else if(isset($_SESSION['resttid'])){
		header("location:restaurant.php?id=".$_SESSION['resttid']."");	
		}
		else if($_REQUEST['vendor'] == 1){
		header("location:vendor.php");
		} 
		else{
		header("location:home.php");
		}
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

<div class="registration_logo_section"><a href="home.php"><img src="images/logo.png" width="216" height="99" /></a></div>

<div class="registration_section">

<div class="registration_left">

<div class="regi_sign_up">

<div class="regi_left_top">
<h2>You must sign in to add your review</h2>
<h1>Log in</h1>
</div>

<form name="frm" method="post" action="" onSubmit="return valid();">
<div class="regi_field_section">
<?php if($error == 1){ ?>
<p style="color:red; margin-bottom:5px;">The email address or password entered is not valid.</p>
<?php } ?>
<p>Email Address * : </p>
<input name="email" type="text" class="regifield" />

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
<li><a href="forgot_password.php">Forgot Password?</a></li>
<li>Not a member yet? <a href="signup.php">register for FREE.</a></li>
</ul>

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
