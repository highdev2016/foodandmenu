<?php 
ob_start();
session_start();
include("admin/lib/conn.php");?>

<?php 
if(isset($_REQUEST['submit'])){	

$sql_forgot_pass = "SELECT * FROM  restaurant_customer where email='".$_REQUEST['email']."'";

$query_pass=mysql_query($sql_forgot_pass);

$array_forgot_pass=mysql_fetch_array($query_pass);

$no_check=mysql_num_rows($query_pass);

$member_id=$array_forgot_pass['id'];

$name=$array_forgot_pass['firstname'];

    if($no_check>0)
		{
			$name = $array_forgot_pass['firstname'].' '.$array_forgot_pass['lastname'];

			$email = $_REQUEST['email']; //"priya@infosolz.com"

			$site_url="http://". $_SERVER['HTTP_HOST'] ."";

		    $url="<a href='$site_url/new_password.php?id=".$member_id."' target='_blank'>$site_url/NewPassword" ."</a>";

			/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #000000;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; padding:0 0px; ">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px; " />
                         <div style="height:15px; background-color:#3F4CA0;"></div>
       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; list-style-type:none; margin:0 0 4px 15px;">Hey '.$name.'</p>

            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; list-style-type:none; margin:0 0 4px 15px;">Please click on the link below to change your password.</p>

             			<div style="clear:both;"></div>

						<h2 style="color:#fff; font:bold 15px/30px Arial, Helvetica, sans-serif; background-color:#3F4CA0; padding:0 0 0 14px; text-transform:uppercase;">Change Password Link :</h2>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; list-style-type:none; margin:0 0 4px 15px;">'.$url.'</p>

						<div style="clear:both;"></div>

 						<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #000000;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>

						<div style="clear:both;"></div>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>

						<div style="clear:both;"></div>

						</div>

						<div style="clear:both;"></div>

						<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >

						<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">

Sent to you from Food and menu</h4>

					</div>

				</div>

				<div style="clear:both;"></div>

				</div>';*/
				
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 11"));	
			
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
	if(document.frm.confirm_email.value == ''){
		alert("Please enter confirmed email");
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
	alert("Email address is not matching");
	}
	return true;
}
</script>

<body class="login_bg">

<div class="body_section">
<div class="login_wrapper">

<div class="container">
<div class="login_body">

<div class="login_body_cont">

<div class="registration_logo_section">
<a href="index.php"><img src="images/logo1.png" /></a>
<h1>Eat Smart…Order Online !</h1>
<div class="clear"></div>
</div>

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
<input name="email" type="text" class="regifield" />

<div class="clear"></div>

<p>Confirm Email * :</p>
<input name="confirm_email" type="text" class="regifield" />

<div class="clear"></div>

</div>

<div class="regi_login">

<input class="regibutton" type="submit" value="submit" name="submit">

<div class="clear"></div>

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
