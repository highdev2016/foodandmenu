<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
			mysql_query("INSERT INTO restaurant_occassions SET occassions='".mysql_real_escape_string($_REQUEST['occassions'])."' , status = '".mysql_real_escape_string($_REQUEST['status'])."' , date_added = NOW() , modified_date = NOW()");		
			$errors="Occassions Added Successfully.";
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('occassions').value=='')
	{
		alert ('Please Enter occassions');
		document.getElementById('occassions').focus();
		return false;
	}
	if(document.getElementById('status').value=='')
	{
		alert ('Please Enter status');
		document.getElementById('status').focus();
		return false;
	}
    return true;
}

</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Occassions</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()">
            	<table width="65%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <?phpif($errors!='')
  {?>
  <tr>
    <td align="right"><img src="images/approve.jpg"></td>
    <td class="msg"><?=$errors?></td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td class="text1" align="right">Occassions <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="occassions" id="occassions" type="text" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Status <font color="#FF0000">*</font>:</td>
    <td class="normaltext">
    <select name="status" id="status" class="login_ipboxin" style="padding:0; height:25px; width:290px;" >
        <option value="">Select</option>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select></td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Add" class="normalbutton" onClick="return checkpassword();"></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"template_admin.php";
?>