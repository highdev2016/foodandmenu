<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['Update']=="Update")
	{
		if($_REQUEST['pwd']!=''){
			$pwd=$_REQUEST['pwd'];
			mysql_query("update  restaurant_admin set password='".mysql_real_escape_string(md5($pwd))."' where id=1");	
		}
		if($_REQUEST['email']!=''){
			mysql_query("update  restaurant_admin set email_id ='".mysql_real_escape_string($_REQUEST['email'])."' where id=1");	
		}	
			$errors="Details Updated Successfully ";
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
window.onload=function(){
	document.getElementById('pwd').focus();
	};
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
function check_pass()
{
	if ((document.frm.email.value!="") && (checkMessenger(document.frm.email.value)==false))
	{
	document.frm.email.value="";
	document.frm.email.focus();
	return false;
	}
	var pass=document.getElementById('pwd').value;
	var con_pass=document.getElementById('conpwd').value;
	if(pass!=''){
	if(con_pass=='')
	{
		alert ('Please Retype The Password');
		document.getElementById('conpwd').focus();
		return false;
	}
	if(pass != con_pass)
	{
		alert('Password Mismatch');
		document.getElementById('conpwd').value = '';
		document.getElementById('conpwd').focus();
		return false;
	} }
    return true;
}

</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="index.php";
}
</script>
<?php $sql_select = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_admin WHERE id = 1"));?>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Change Admin details</h2>
<form name="frmchangpass" action="change_password.php" method="post" onsubmit="return check_pass()">
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
    <td class="text1" align="right">Email <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="email" id="email" type="text" class="login_ipboxin"  value="<?php echo $sql_select['email_id'];?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">New Password :</td>
    <td class="normaltext"><input name="pwd" id="pwd" type="password" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Confirm New Password :</td>
    <td class="normaltext"><input name="conpwd" id="conpwd" type="password" class="login_ipboxin"  value=""></td>
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