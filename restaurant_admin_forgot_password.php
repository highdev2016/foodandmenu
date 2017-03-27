<?php 
ob_start();
session_start();
include("admin/lib/conn.php");?>

<?php
if(isset($_REQUEST['submit'])){	

$sql_forgot_pass = "SELECT * FROM  restaurant_admin_panel where email_id = '".$_REQUEST['email']."'";

$query_pass=mysql_query($sql_forgot_pass);

$array_forgot_pass=mysql_fetch_array($query_pass);

$no_check=mysql_num_rows($query_pass);

$id = $array_forgot_pass['id'];

$name=$array_forgot_pass['firstname'];

    if($no_check>0)
		{
			$name = $array_forgot_pass['firstname'].' '.$array_forgot_pass['lastname'];

			$email = $_REQUEST['email'];//"priya@infosolz.com"

			$site_url="http://". $_SERVER['HTTP_HOST'] ."";

		    $url="<a href='$site_url/new_password_rest_admin.php?id=".$id."' target='_blank'>$site_url/NewPassword" ."</a>";
				
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 12"));	
			
			$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
			
			$cms_rep = str_replace('%%$name%%',$name,$cms_rep);
			$cms_rep = str_replace('%%$url%%',$url,$cms_rep);	

			$from = "support@foodandmenu.com";

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

			$message=$cms_rep;

			//$subject='Forgot Password Mail';
			
			$subject = stripslashes($sql_cms['subject']);

			mail($email,$subject,$message,$headers);

			$success = 1;
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
	window.alert('Invalid Email Address.');
	return false;
	}
	return true; 
}
function valid(){
	if(document.frm.email.value == ''){
		alert("Please enter email.");
		document.frm.email.focus();	
		return false;	
	}
	if ((document.frm.email.value!="") && (checkMessenger(document.frm.email.value)==false))
	{
	document.frm.email.value="";
	document.frm.email.focus();
	return false;
	}
	if(document.frm.confirm_email.value == ''){
		alert("Please enter confirmed email.");
		document.frm.confirm_email.focus();	
		return false;	
	}
	if ((document.frm.confirm_email.value!="") && (checkMessenger(document.frm.confirm_email.value)==false))
	{
	document.frm.confirm_email.value="";
	document.frm.confirm_email.focus();
	return false;
	}
	if(document.frm.confirm_email.value!=document.frm.email.value){
	alert("Email address is not matching.");
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

<div class="registration_logo_section"><a href="index.php"><img src="images/logo.png" /></a></div>

<div class="registration_section">

<div class="registration_left">

<div class="regi_sign_up">

<div class="regi_left_top">
<h1>Forgot Password</h1>
</div>

<form name="frm" method="post" action="" onSubmit="return valid();">
<div class="regi_field_section">
<?php if($success == 1){ ?>
<p style="color:#404C9B; margin-bottom:5px;">Check your mail for new password</p>
<?php } ?>
<p>Email * : </p>
<input name="email" type="text" class="regifield" autocomplete="off" />

<div class="clear"></div>

<p>Confirm Email * :</p>
<input name="confirm_email" type="text" class="regifield" autocomplete="off" />

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
