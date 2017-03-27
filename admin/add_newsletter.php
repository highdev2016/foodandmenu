<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
			mysql_query("insert into  restaurant_newsletter set  title='".
mysql_real_escape_string($_REQUEST['title'])."',content='".mysql_real_escape_string(stripslashes($_REQUEST['content']))."',date_added='".date('Y-m-d')."',status=1");	
			header("location:manage_newsletter.php?success=1");
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
	if(CKEDITOR.instances.content.getData() == ''){

		alert('Please enter content');

		CKEDITOR.instances.content.setData("");

		return false;

	}
    return true;
}

</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Newsletter</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
            	<table width="85%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Newsletter Title <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="title" id="title" type="text" class="login_ipboxin" style="height:25px;"  value=""></td>
  </tr>
   <tr>
    <td class="text1" align="right" valign="top">Content <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea cols="63" id="content" name="content" rows="5" ></textarea>
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
    <td class="normaltext"><input name="submit" type="submit" value="Add" class="normalbutton"></td>
  </tr>
</table>
</form>
</div>
<?php

}
require_once"template_admin.php";
?>