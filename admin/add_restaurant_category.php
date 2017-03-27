<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
			mysql_query("insert into  restaurant_category set category_name='".mysql_real_escape_string($_REQUEST['category_name'])."'");		
			$errors="Category has been added successfully ";
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('category_name').value=='')
	{
		alert ('Please Enter Category Name');
		document.getElementById('category_name').focus();
		return false;
	}
    return true;
}

</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Category</h2>
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
    <td class="text1" align="right">Category Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="category_name" id="category_name" type="text" class="login_ipboxin"  value=""></td>
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