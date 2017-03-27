<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Update")
	{
			mysql_query("UPDATE  restaurant_social_media set facebook_link='".mysql_real_escape_string($_REQUEST['facebook'])."', twitter_link='".mysql_real_escape_string($_REQUEST['twitter'])."',rss_feed='".mysql_real_escape_string($_REQUEST['rss'])."',linkedin_link='".mysql_real_escape_string($_REQUEST['linked'])."',google_plus_link='".mysql_real_escape_string($_REQUEST['google_plus'])."' where id=1");		
			$errors="Details updated successfully ";
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
<script type="text/javascript">
function cancel_it()
{
	window.location.href="index.php";
}
</script>
<?php
$social_media_link=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_social_media WHERE id=1"));
?>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Social Media</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()">
            	<table width="65%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <?php if($errors!='')
  {?>
  <tr>
    <td width="46%" align="right"><img src="images/approve.jpg"></td>
    <td width="54%" class="msg"><?=$errors?></td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td class="text1" align="right">Facebook <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="facebook" id="facebook" type="text" class="login_ipboxin"  value="<?php echo $social_media_link['facebook_link']?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Twitter <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="twitter" id="twitter" type="text" class="login_ipboxin"  value="<?php echo $social_media_link['twitter_link']?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Rss Feed <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="rss" id="rss" type="text" class="login_ipboxin"  value="<?php echo $social_media_link['rss_feed']?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Linked in <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="linked" id="linked" type="text" class="login_ipboxin"  value="<?php echo $social_media_link['linkedin_link']?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Google Plus<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="google_plus" id="google_plus" type="text" class="login_ipboxin"  value="<?php echo $social_media_link['google_plus_link']?>"></td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Update" class="normalbutton" onClick="return checkpassword();">
    <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"template_admin.php";
?>