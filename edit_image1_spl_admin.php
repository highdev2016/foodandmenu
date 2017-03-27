<?php
ob_start();
session_start();
 include ("includes/header_vendor.php");?>
<?php include ("admin/lib/conn.php");?>
<?php include ("image_file.php");?>

<body>

<?php include ("includes/menu_admin_addedit_res.php");?>


<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	if($_FILES['daily_picture']!="")
		{
		$video_image1=$_FILES['daily_picture']['name'];
		$video_image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $video_image1);
	    //$video_image=time().$video_image;
		if ((($_FILES["daily_picture"]["type"] == "image/gif")
		  || ($_FILES["daily_picture"]["type"] == "image/png")
		  || ($_FILES["daily_picture"]["type"] == "image/bmp")
		  || ($_FILES["daily_picture"]["type"] == "image/jpg")
		  || ($_FILES["daily_picture"]["type"] == "image/jpeg")
		  || ($_FILES["daily_picture"]["type"] == "image/pjpeg")))
		  
		{
			
		 $picture_url="uploaded_images/".$video_image;
			LIB_StoreUploadImg($post_file_name="daily_picture"
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="800"
								,$file_to_copy_height="600"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
		$picture_url_thumb="thumb_images/".$video_image;
			LIB_StoreUploadImg($post_file_name="daily_picture"
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="35"
								,$file_to_copy_height="35"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
								
}

		}
		
		if($_FILES['daily_picture']['name']!=""){	
		mysql_query("update restaurant_photo set image_name='".$video_image."' where id='".$_REQUEST['image_hid']."'");
		
		}
		
		
		header("location:spl_admin_multimedia.php?success=2");
		

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
$select_photo=mysql_fetch_array(mysql_query("select * from restaurant_photo where id='".$_REQUEST['image_id']."'"));
?>
<div class="body_section">
<?php

$basic_info=mysql_fetch_array(mysql_query("select restaurant_name from restaurant_basic_info where id='".$_SESSION['rest_id']."'"));
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
                    <li><a href="spl_admin_add_restaurant.php">Basic Info</a></li>
                    <li><a href="spl_admin_additional.php">Additional Info</a></li>
                    <li><a href="spl_admin_restaurant_menu.php">Menu</a></li>
                    <li><a href="spl_admin_multimedia.php" class="active7">Multimedia</a></li>
                    <li><a href="spl_admin_special_offer.php">Special Offer</a></li>
                    <li><a href="spl_admin_confirmation.php">Confirmation</a></li>
                    </ul>
                    
                    </div>

<div class="restaurant_cont_field">
<form name="myfrm" method="post" enctype="multipart/form-data">


<div class="restaurant_form_field" style="padding-left:250px;">

<h1 style="padding-left:150px;">Image</h1>

<div class="clear"></div>

<p>Picture :</p>

<input name="daily_picture" type="file" class="restaurant_browse" />
<input type="hidden" name="image_hid" value="<?php echo $select_photo['id']?>">
<?php
if($select_photo['image_name']!="")
{
?>
<img src="thumb_images/<?php echo $select_photo['image_name']?>" height="40" width="40" >
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
