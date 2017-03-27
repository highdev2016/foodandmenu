<?php
ob_start();
session_start();
 include ("includes/header_vendor.php");?>
<?php include ("admin/lib/conn.php");?>
<?php include ("image_file.php");?>

<body>

<?php include ("includes/menu_admin_edit_res.php");?>


<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	if($_FILES['video_photo']!="")
		{
		$video_image1=$_FILES['video_photo']['name'];
		$video_image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $video_image1);
	    $video_image=time().$video_image;
		if ((($_FILES["video_photo"]["type"] == "image/gif")
		  || ($_FILES["video_photo"]["type"] == "image/png")
		  || ($_FILES["video_photo"]["type"] == "image/bmp")
		  || ($_FILES["video_photo"]["type"] == "image/jpg")
		  || ($_FILES["video_photo"]["type"] == "image/jpeg")
		  || ($_FILES["video_photo"]["type"] == "image/pjpeg")))
		  
		{
			
		$picture_url_thumb="thumb_images/".$video_image;
			LIB_StoreUploadImg($post_file_name="video_photo".$j
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="35"
								,$file_to_copy_height="35"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
}

		}
		
		if($_FILES['video_photo']['name']!=""){	
		mysql_query("update restaurant_video set video_image='".$video_image."',video_link='".$_REQUEST['video']."' where id='".$_REQUEST['video_hid']."'");
		
		}
		else{
			mysql_query("update restaurant_video set video_link='".$_REQUEST['video']."' where id='".$_REQUEST['video_hid']."'");
		}
		
		
		header("location:edit_multimedia.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&success=3");
		

}
?>
<script type="text/javascript">
function validate()
{
	if(document.getElementById('photo1').value=="" && document.getElementById('photo2').value=="" && document.getElementById('photo3').value=="" && document.getElementById('photo4').value=="" && document.getElementById('photo5').value=="" && document.getElementById('photo6').value=="")
	{
		alert("Please select atleast one image");
		document.getElementById('photo1').focus();
		return false;
	}
	
	//if(document.getElementById('video1').value=="" && document.getElementById('video2').value=="" && document.getElementById('video3').value=="" && document.getElementById('video4').value=="" && document.getElementById('video5').value=="")
//	{
//		alert("Please enter atleast one video");
//		document.getElementById('video1').focus();
//		return false;
//	}
	
	
	return true;
}
</script>
<?php
$select_video=mysql_fetch_array(mysql_query("select * from  restaurant_video where id='".$_REQUEST['video_id']."'"));
?>
<div class="body_section">
<?php

$basic_info=mysql_fetch_array(mysql_query("select restaurant_name from restaurant_basic_info where id='".$_REQUEST['restaurant_edit_id']."'"));
?>
<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>Edit <?php echo stripslashes($basic_info['restaurant_name'])?></h1>
</div>

<div class="restaurant_nav">

<ul>
    <li><a href="edit_restaurant.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Basic Info</a></li>
    <li><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Additional Info</a></li>
    <li><a href="edit_restaurant_menu.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Menu</a></li>
    <li><a href="edit_multimedia.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="active7">Multimedia</a></li>
    <li><a href="edit_special_offer.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Special Offer</a></li>
    <li><a href="edit_confirmation.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Confirmation</a></li>
</ul>

</div>

<div class="restaurant_cont_field">
<form name="myfrm" method="post" enctype="multipart/form-data">

<div class="restaurant_form_field" style="padding-left:250px;">

<h1 style="padding-left:150px;">Video</h1>

<div class="clear"></div>
<p>Video  :</p>

<textarea name="video" id="video" cols="" rows="" class="multimedia_textarea"><?php echo $select_video['video_link']?></textarea>
<input name="video_photo" type="file" class="multimedia_browse2" />
<input type="hidden" name="video_hid" value="<?php echo $select_video['id']?>">
<?php
if($select_video['video_image']!="")
{
?>
<img src="thumb_images/<?php echo $select_video['video_image']?>" height="40" width="40" >
<?php
}
?>
<div class="clear"></div>


<input class="button4" type="submit" value="Save & Continue" name="submit">

</div>

<div class="clear"></div>
</form>


</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>
