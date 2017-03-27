<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
	{
			mysql_query("update restaurant_menu_subcategory set subcategory_name='".mysql_real_escape_string($_REQUEST['subcategory_name'])."',category_id='".mysql_real_escape_string($_REQUEST['category_id'])."' where id='".$_REQUEST['hid']."'");		
			$errors="Subcategory has been updated successfully ";
	}
	if($_REQUEST['id']!="")
	{
		$subcategory_name=mysql_fetch_array(mysql_query("select * from restaurant_menu_subcategory where id='".$_REQUEST['id']."'"));
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('category_id').value=='')
	{
		alert ('Please Select Category');
		document.getElementById('category_id').focus();
		return false;
	}
	
	if(document.getElementById('subcategory_name').value=='')
	{
		alert ('Please Enter Subcategory');
		document.getElementById('subcategory_name').focus();
		return false;
	}
    return true;
}

</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_menu_subcategory.php?page=<?php echo $_REQUEST['page']?>";
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Edit Menu Category</h2>
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
    <td class="text1" align="right">Category <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><select name="category_id" id="category_id" class="select_box">
    <option value="">--Select--</option>
 <?php
 $sql_category=mysql_query("select * from restaurant_menu_category where 1");
 while($res_category=mysql_fetch_array($sql_category))
 {
 ?>
 <option value="<?php echo $res_category['id']?>" <?php if($subcategory_name['category_id']==$res_category['id']){?> selected="selected" <?php } ?>><?php echo $res_category['category_name']?></option>
 <?php
 }
 ?>
    </select></td>
  </tr>
  <tr>
    <td class="text1" align="right">Subcategory Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="subcategory_name" id="subcategory_name" type="text" class="login_ipboxin"  value="<?php echo $subcategory_name['subcategory_name']?>">
    <input name="hid" type="hidden" class="login_ipboxin"  value="<?php echo $subcategory_name['id']?>"></td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Edit" class="normalbutton">
    <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"template_admin.php";
?>