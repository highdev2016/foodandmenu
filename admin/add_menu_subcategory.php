<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
		$sql_select_sub_cat = mysql_num_rows(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE category_id='".mysql_real_escape_string($_REQUEST['category_id'])."' AND subcategory_name='".mysql_real_escape_string($_REQUEST['subcategory_name'])."'"));
		if($sql_select_sub_cat == 0){
			$max_order_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_menu_subcategory"));
			$show_order = $max_order_id['max_id'] + 1;
			mysql_query("insert into  restaurant_menu_subcategory set subcategory_name='".mysql_real_escape_string($_REQUEST['subcategory_name'])."',category_id='".mysql_real_escape_string($_REQUEST['category_id'])."',show_order = '".$show_order."'");		
			$errors="Subcategory has been added successfully ";
		}else{
			$errors1="Subcategory already exists ";
		}
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
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Menu Subcategory</h2>
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
  <?phpif($errors1!='')
  {?>
  <tr>
    <td width="46%" align="right"><img src="images/remove.png"></td>
    <td width="54%" class="msg"><?=$errors1?></td>
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
 <option value="<?php echo $res_category['id']?>"><?php echo $res_category['category_name']?></option>
 <?php
 }
 ?>
    </select></td>
  </tr>
  <tr>
    <td class="text1" align="right">Subcategory Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="subcategory_name" id="subcategory_name" type="text" class="login_ipboxin"  value=""></td>
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