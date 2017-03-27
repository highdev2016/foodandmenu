<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
			mysql_query("insert into   restaurant_contact_category set subject_id = '".$_REQUEST['subject']."',  contact_category='".mysql_real_escape_string($_REQUEST['category'])."'");		
			$errors="Contact category has been added successfully ";
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('subject').value=='')
	{
		alert ('Please select subject');
		document.getElementById('subject').focus();
		return false;
	}
	if(document.getElementById('category').value=='')
	{
		alert ('Please Enter category');
		document.getElementById('category').focus();
		return false;
	}
    return true;
}

</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Contact form category</h2>
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
    <td class="text1" align="right">Contact Subject <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><select class="login_ipboxin" name="subject" id="subject" style="height:28px; width:286px;">
    <option value="">Select</option>
    <?php $sql_select = mysql_query("SELECT * FROM restaurant_subject WHERE 1");
	while($array_select = mysql_fetch_array($sql_select)){
	?>
    <option value="<?php echo $array_select['id']; ?>"><?php echo $array_select['subject']; ?></option>
	<?php
	}?>
    </select></td>
  </tr>
  <tr>
    <td class="text1" align="right">Contact Category <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="category" id="category" type="text" class="login_ipboxin"  value=""></td>
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