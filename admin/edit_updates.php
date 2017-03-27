<?php
function main()
{
	
	function change_dateformat($date_form)
	{
	 if($date_form!=''){
	  $date1=explode("-",$date_form);
	  $dateformat=$date1[2]."-".$date1[0]."-".$date1[1];
	  return $dateformat;
	}
	else{
	  $dateformat='';
	  return $dateformat;
	}
}
     
	function change_dateformat_reverse($date_form1)
	{
	 if($date_form1!=''){
	  $date2=explode("-",$date_form1);
	  $dateformat1=$date2[1]."-".$date2[2]."-".$date2[0];
	  return $dateformat1;
	  }
	 else{
	  $dateformat1='';
	  return $dateformat1;
	  }
	}
	include_once("image_file.php");
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
	{
		mysql_query("update restaurant_updates set date='".
change_dateformat($_REQUEST['date'])."',short_desc='".mysql_real_escape_string($_REQUEST['short_desc'])."',full_desc='".mysql_real_escape_string($_REQUEST['full_desc'])."' where id='".$_REQUEST['id']."'");	
	header("location:manage_updates.php?success=3");
	}
	
	$sql_banner=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_updates WHERE id='".$_REQUEST['id']."'"));
?>
<div class="dashboard_section_in">
<script>
  $(function() {
    $( "#datepicker" ).datepicker(
	{dateFormat: 'mm-dd-yy',

  changeDate: true,

  changeMonth: true,

  changeYear: true,
  
  yearRange: "-90:+0",

  showButtonPanel: true });
  });
  </script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('date').value=='')
	{
		alert ('Please select date');
		document.getElementById('date').focus();
		return false;
	}
	if(CKEDITOR.instances.short_desc.getData() == ''){

		alert('Please enter short description');

		CKEDITOR.instances.short_desc.setData("");

		return false;

	}
	if(CKEDITOR.instances.full_desc.getData() == ''){

		alert('Please enter full description');

		CKEDITOR.instances.full_desc.setData("");

		return false;

	}
    return true;
}
</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_updates.php?page=<?php echo $_REQUEST['page']?>";
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Edit Updates</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
            	<table width="75%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Date <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="date" id="datepicker" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo change_dateformat_reverse($sql_banner['date']);?>"></td>
  </tr>
   <tr>
    <td class="text1" align="right">Short Description <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea cols="63" id="short_desc" name="short_desc" rows="5" ><?php echo $sql_banner['short_desc'];?></textarea>
    <script type="text/javascript">

				CKEDITOR.replace( 'short_desc',

				{

					fullPage : false,

					extraPlugins : 'docprops'

				});

			</script>
</td>
  </tr>
  <tr>
    <td class="text1" align="right">Full Description <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea cols="63" id="full_desc" name="full_desc" rows="5" >
    <?php echo $sql_banner['full_desc'];?></textarea>
    <script type="text/javascript">

				CKEDITOR.replace( 'full_desc',

				{

					fullPage : false,

					extraPlugins : 'docprops'

				});

			</script></td>
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