<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
	{
			mysql_query("update  restaurant_subject set subject='".mysql_real_escape_string($_REQUEST['subject'])."' where id='".$_REQUEST['hid']."'");		
			$errors="Subject has been updated successfully ";
	}
	
	if($_REQUEST['id']!="")
	{
		$category_name=mysql_fetch_array(mysql_query("select * from restaurant_subject where id='".$_REQUEST['id']."'"));
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('subject').value=='')
	{
		alert ('Please Enter subject');
		document.getElementById('subject').focus();
		return false;
	}
    return true;
}

</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_subject.php?page=<?php echo $_REQUEST['page']?>";
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Edit Contact Subject</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()">
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
    <td class="text1" align="right">Subject <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="subject" id="subject" type="text" class="login_ipboxin"  value="<?php echo $category_name['subject']?>"><input name="hid" type="hidden" class="login_ipboxin"  value="<?php echo $category_name['id']?>"></td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Edit" class="normalbutton" onClick="return checkpassword();">
    <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"template_admin.php";
?>