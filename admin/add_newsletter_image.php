<?php
function main()
{
	include_once("image_file.php");
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
		if($_FILES['image']['name']!="")
	    {
		$image1=$_FILES['image']['name'];
		$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
	    //$image=time().$image;
		$image_tmp=$_FILES['image']['tmp_name'];
		list($width, $height) = getimagesize("$image_tmp");
		//echo $width,$height;exit;
			
		if ((($_FILES["image"]["type"] == "image/gif")
		  || ($_FILES["image"]["type"] == "image/png")
		  || ($_FILES["image"]["type"] == "image/bmp")
		  || ($_FILES["image"]["type"] == "image/jpg")
		  || ($_FILES["image"]["type"] == "image/jpeg")
		  || ($_FILES["image"]["type"] == "image/pjpeg")))
		  
		{
			 $picture_url="../uploaded_images/".$image;
			LIB_StoreUploadImg($post_file_name="image"
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="$width"
								,$file_to_copy_height="$height"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
		}
			mysql_query("insert into  restaurant_newsletter_images set image='".$image."',image_path = 'img src = https://foodandmenu.com/uploaded_images/".$image."'"); 	
			header("location:manage_newsletter_image.php?success=1");
		}
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('image').value=='')
	{
		alert ('Please upload image');
		document.getElementById('image').focus();
		return false;
	}
    return true;
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Newsletter image</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
            	<table width="75%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Image <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="image" id="image" type="file" class="login_ipboxin" style="height:25px;"  value="">&nbsp;</td>
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