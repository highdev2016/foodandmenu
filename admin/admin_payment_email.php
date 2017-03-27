<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Update")
	{
		mysql_query("update restaurant_payment_email set content='".$_REQUEST['content']."' where id=1");
		
			header("location:admin_payment_email.php?success=1");
	}
?>
<div class="dashboard_section_in">

<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('title').value=='')
	{
		alert ('Please enter title');
		document.getElementById('title').focus();
		return false;
	}
	if(document.getElementById('content').value=="")
	{
		alert('Please enter some content');
		document.getElementById('content').focus();
		return false;
	}
    return true;
}
</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="index.php";
}
</script>
<?php
$sql_email=mysql_fetch_array(mysql_query("select content from restaurant_payment_email where id=1"));
?>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Payment email for admin</h2>
<?php if($_REQUEST['success'] == 1){?>
<p style="text-align:center; margin-top:10px;">Content updated successfully</p><?php } ?>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
            	<table width="85%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  
   <tr>
    <td class="text1" align="right" valign="top">Content <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea cols="63" id="content" name="content" rows="5" ><?php echo $sql_email['content']?></textarea>
   
</td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Update" class="normalbutton">
    <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/></td>
  </tr>
</table>
</form>
</div>
<?php

}
require_once"template_admin.php";
?>