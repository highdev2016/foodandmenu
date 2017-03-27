<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
			
			mysql_query("insert into  restaurant_users set  user_email='".mysql_real_escape_string($_REQUEST['email_id'])."',user_pass='".mysql_real_escape_string(md5($_REQUEST['pwd']))."',user_type='admin_restaurant',user_status=1");
			
			$site_url="https://". $_SERVER['HTTP_HOST'] ."";

			$email=$_POST['email_id'];
			
			$url="<a href='$site_url/restaurant-login.php'>$site_url/Restaurant Login" ."</a>";
			$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="https://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>


            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Your account has been created successfully</p>

                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Please click on the link below with your follwing credentials</p>

             			<div style="clear:both;"></div>
	 
	 <p style="font:bold 12px Arial, Helvetica, sans-serif; color:#04303d; margin:0 0 4px 15px;">Email: '.$email.'</p>
	 
	  <p style="font:bold 12px Arial, Helvetica, sans-serif; color:#04303d; margin:0 0 4px 15px;">Password: '.$_REQUEST['pwd'].'</p>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#04303d; margin:0 0 4px 15px;">'.$url.'</p>

						<div style="clear:both;"></div>

 						<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>

						<div style="clear:both;"></div>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>

						<div style="clear:both;"></div>

						</div>

						<div style="clear:both;"></div>

						<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >

						<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">

Sent to you from Food & menu</h4>

					</div>

				</div>

				<div style="clear:both;"></div>

				</div>';

			$from = "support@foodandmenu.com";

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message=$cms_rep;

			$subject="Food&Menu Account";

			mail($email,$subject,$message,$headers);
					
			$errors="Account Created Successfully ";
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
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

function valide()
{
	if(document.getElementById('email_id').value=="")
	{
		alert("Please enter email id");
		document.getElementById('email_id').focus();
		return false;
	}
	
	/*var x=document.forms["frmchangpass"]["email_id"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
	alert("Not a valid e-mail address");
	return false;
	}*/	
	
	if ((document.getElementById('email_id').value!="") && (checkMessenger(document.getElementById('email_id').value)==false))
	{
	document.getElementById('email_id').value="";
	document.getElementById('email_id').focus();
	return false;
	}
	if(document.getElementById('pwd').value=="")
	{
		alert("Please enter password");
		document.getElementById('pwd').focus();
		return false;
	}
	if(document.getElementById('conpwd').value=="")
	{
		alert("Please enter cnfirm password");
		document.getElementById('conpwd').focus();
		return false;
	}
	if(document.getElementById('pwd').value!=document.getElementById('conpwd').value)
	{
		alert("Password mismatch");
		document.getElementById('conpwd').focus();
		return false;
	}
	
    return true;
}

</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add restaurant admin</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return valide()">
            	<table width="65%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <?phpif($errors!='')
  {?>
  <tr>
    <td width="46%" align="right"><img src="images/approve.jpg"></td>
    <td width="54%" class="msg"><?=$errors?></td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td class="text1" align="right">Email-Id <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="email_id" id="email_id" type="text" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Password <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="pwd" id="pwd" type="password" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Confirm Password <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="conpwd" id="conpwd" type="password" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Add" class="normalbutton" style="background-color: #EB6F00; border:0; outline:0; padding:8px 12px; text-align:center; color:#fff; cursor:pointer; "></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"template_admin.php";
?>