<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
	{
			mysql_query("UPDATE restaurant_occassions SET occassions='".mysql_real_escape_string($_REQUEST['occassions'])."' , status = '".mysql_real_escape_string($_REQUEST['status'])."' , modified_date = NOW() WHERE id='".$_REQUEST['id']."'");		
			$errors="Occassion Updated Successfully.";
	}
	
	if($_REQUEST['id']!="")
	{
		$occassion_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_occassions WHERE id='".$_REQUEST['id']."'"));
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
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_occassions.php?page=<?php echo $_REQUEST['page']?>";
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Edit Occassions</h2>
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
    <td class="normaltext"><input name="occassions" id="occassions" type="text" class="login_ipboxin"  value="<?php echo $occassion_details['occassions']; ?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Status <font color="#FF0000">*</font>:</td>
    <td class="normaltext">
    <select name="status" id="status" class="login_ipboxin" style="padding:0; height:25px; width:290px;" >
        <option value="">Select</option>
        <option value="Active" <?php if($occassion_details['status'] == 'Active'){?> selected="selected" <?php } ?>>Active</option>
        <option value="Inactive" <?php if($occassion_details['status'] == 'Inactive'){?> selected="selected" <?php } ?>>Inactive</option>
    </select></td>
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