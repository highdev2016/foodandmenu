<?php
function main()
{
	include_once("image_file.php");
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
	{
		mysql_query("update restaurant_newsletter set title='".
mysql_real_escape_string($_REQUEST['title'])."',content='".mysql_real_escape_string(stripslashes($_REQUEST['content']))."' where newsletter_id='".$_REQUEST['id']."'");	
	header("location:manage_newsletter.php?success=3");
	}
	
	$sql_newsletter=mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_newsletter WHERE newsletter_id='".$_REQUEST['id']."'"));
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
	if(CKEDITOR.instances.content.getData() == ''){

		alert('Please enter content');

		CKEDITOR.instances.content.setData("");

		return false;

	}
    return true;
}
</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_newsletter.php?page=<?php echo $_REQUEST['page']?>";
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Edit Newsletter</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
            	<table width="85%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Newsletter Title <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="title" id="title" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo stripslashes($sql_newsletter['title']);?>"></td>
  </tr>
   <tr>
    <td class="text1" align="right" valign="top">Content <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea cols="63" id="content" name="content" rows="5" ><?php echo $sql_newsletter['content'];?></textarea>
    <script type="text/javascript">

				CKEDITOR.replace( 'content',
				{
					fullPage : true,
					toolbar:[['Source','-','Bold','Italic','Underline','-','Undo','Redo','-','Find','Replace','-','SelectAll','-','Scayt','-','About']],

					extraPlugins : 'docprops',
					
					 width: "600px",
					 height: "300px"
				});
				
			</script>
</td>
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