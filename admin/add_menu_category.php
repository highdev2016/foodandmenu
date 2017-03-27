<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
		$sql_cat = mysql_num_rows(mysql_query("SELECT * FROM restaurant_menu_category WHERE category_name = '".mysql_real_escape_string($_REQUEST['category_name'])."'"));
		if($sql_cat == 0){
			mysql_query("insert into  restaurant_menu_category set category_name='".mysql_real_escape_string($_REQUEST['category_name'])."'");		
			$errors="Category has been added successfully ";
		}else{
			$error1="Category already exists. ";
		}
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
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Menu Category</h2>
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
  <?phpif($error1!='')
  {?>
  <tr>
    <td width="46%" align="right"><img src="images/remove.png"></td>
    <td width="54%" class="msg"><?=$error1?></td>
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