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
		$exact_width="940";
		$exact_height="317";
		if($width<"940" || $height<"317")
		{	
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
			$picture_url="../thumb_images/".$image;
			LIB_StoreUploadImg($post_file_name="image"
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="100"
								,$file_to_copy_height="75"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
		}
	
		}
		else {
		if ((($_FILES["image"]["type"] == "image/gif")
		  || ($_FILES["image"]["type"] == "image/png")
		  || ($_FILES["image"]["type"] == "image/bmp")
		  || ($_FILES["image"]["type"] == "image/jpg")
		  || ($_FILES["image"]["type"] == "image/jpeg")
		  || ($_FILES["image"]["type"] == "image/pjpeg")))
		  
		{
			if($width==$exact_width && $height==$exact_height) 
				{
					$picture_url="../uploaded_images/".$image;
					LIB_StoreUploadImg($post_file_name="image"
									,$file_to_copy_path="$picture_url"
									,$file_to_copy_width="$width"
									,$file_to_copy_height="$height"
									,$adjust = ''
									,$watermark_gif=''
									,$watermark_position='');
					$picture_url="../thumb_images/".$image;
					LIB_StoreUploadImg($post_file_name="image"
									,$file_to_copy_path="$picture_url"
									,$file_to_copy_width="100"
									,$file_to_copy_height="75"
									,$adjust = ''
									,$watermark_gif=''
									,$watermark_position='');
		
				}
				else if($width>=$height)
				{
					$picture_url="../uploaded_images/".$image;
					LIB_StoreUploadImg($post_file_name="image"
									,$file_to_copy_path="$picture_url"
									,$file_to_copy_width="940"
									,$file_to_copy_height="317"
									,$adjust = 'widthfit'
									,$watermark_gif=''
									,$watermark_position='');
					$picture_url="../thumb_images/".$image;
					LIB_StoreUploadImg($post_file_name="image"
									,$file_to_copy_path="$picture_url"
									,$file_to_copy_width="100"
									,$file_to_copy_height="75"
									,$adjust = ''
									,$watermark_gif=''
									,$watermark_position='');
				}
				else if($width<$height)
				{
					$picture_url="../uploaded_images/".$image;
					LIB_StoreUploadImg($post_file_name="image"
									,$file_to_copy_path="$picture_url"
									,$file_to_copy_width="940"
									,$file_to_copy_height="317"
									,$adjust = 'heightfit'
									,$watermark_gif=''
									,$watermark_position='');
					$picture_url="../thumb_images/".$image;
					LIB_StoreUploadImg($post_file_name="image"
									,$file_to_copy_path="$picture_url"
									,$file_to_copy_width="100"
									,$file_to_copy_height="75"
									,$adjust = ''
									,$watermark_gif=''
									,$watermark_position='');					
				}
			
}
	}
			mysql_query("insert into  restaurant_banner set text='".mysql_real_escape_string($_REQUEST['text'])."',link='".mysql_real_escape_string($_REQUEST['link'])."',image='".$image."',status='".mysql_real_escape_string($_REQUEST['status'])."'");	
			header("location:manage_banner.php?success=1");
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
	if(document.getElementById('text').value=='')
	{
		alert ('Please Enter text');
		document.getElementById('text').focus();
		return false;
	}
	if(document.getElementById('link').value=='')
	{
		alert ('Please Enter link');
		document.getElementById('link').focus();
		return false;
	}
    return true;
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Banner</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
            	<table width="75%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <?phpif($_REQUEST['error']==1)
  {?>
  <tr>
    <td width="54%" class="msg" colspan="2" style="text-align:center;">Please upload a high resolution image</td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td class="text1" align="right">Image <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="image" id="image" type="file" class="login_ipboxin" style="height:25px;"  value="">&nbsp;<span style="color:#ff0000; font-family:Arial, Helvetica, sans-serif; font-size:12px;">[Best Size:940 X 317] </span></td>
  </tr>
   <tr>
    <td class="text1" align="right">Text <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="text" id="text" type="text" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Link <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="link" id="link" type="text" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Status <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input type="checkbox" name="status" value="1" /></td>
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