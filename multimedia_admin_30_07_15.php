<?php
ob_start();
session_start();
 include("includes/header_vendor.php");?>
<?php include("admin/lib/conn.php");?>
<?php include("image_file.php");?>

<body>

<?php include ("includes/menu_adminaddres.php");?>


<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	$res_basic_info=mysql_query("SELECT * FROM restaurant_basic_info where id='".$_SESSION['restid']."'");
	$row_basic_info=mysql_num_rows($res_basic_info);
    if($row_basic_info>0)
	{
	for($i=1;$i<=6;$i++)
	{
	if($_FILES['photo'.$i]['name']!="")
	    {
		$image1=$_FILES['photo'.$i]['name'];
		$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
	    //$image=time().$image;
		if ((($_FILES["photo".$i]["type"] == "image/gif")
		  || ($_FILES["photo".$i]["type"] == "image/png")
		  || ($_FILES["photo".$i]["type"] == "image/bmp")
		  || ($_FILES["photo".$i]["type"] == "image/jpg")
		  || ($_FILES["photo".$i]["type"] == "image/jpeg")
		  || ($_FILES["photo".$i]["type"] == "image/pjpeg")))
		  
		{
			 $picture_url="uploaded_images/".$image;
			LIB_StoreUploadImg($post_file_name="photo".$i
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="800"
								,$file_to_copy_height="600"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
		$picture_url_thumb="thumb_images/".$image;
			LIB_StoreUploadImg($post_file_name="photo".$i
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="35"
								,$file_to_copy_height="35"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
								
		
}
mysql_query("insert into restaurant_photo set image_name='".$image."',restaurant_id='".$_SESSION['restid']."'");
	}
	
	
	}
		
	for($j=1;$j<=4;$j++)
	{
		if($_REQUEST['video'.$j]!="")
		{
		$video_image1=$_FILES['video_photo'.$j]['name'];
		$video_image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $video_image1);
	    //$video_image=time().$video_image;
		if ((($_FILES["video_photo".$j]["type"] == "image/gif")
		  || ($_FILES["video_photo".$j]["type"] == "image/png")
		  || ($_FILES["video_photo".$j]["type"] == "image/bmp")
		  || ($_FILES["video_photo".$j]["type"] == "image/jpg")
		  || ($_FILES["video_photo".$j]["type"] == "image/jpeg")
		  || ($_FILES["video_photo".$j]["type"] == "image/pjpeg")))
		  
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

mysql_query("insert into restaurant_video set video_link='".$_REQUEST['video'.$j]."',video_image='".$video_image."', restaurant_id='".$_SESSION['restid']."'");
		}
	
		
	}
   
   header("location:special_offer_admin.php");
	}
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
<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>Add New Restaurant</h1>
</div>

<div class="restaurant_nav">
                    
                    
                    <ul><li><a href="add_restaurant_admin.php">Basic Info</a></li>
                    <li><a href="additional_admin.php">Additional Info</a></li>
                    <li><a href="restaurant_menu_admin.php">Menu</a></li>
                    <li><a href="multimedia_admin.php" class="active7">Multimedia</a></li>
                    <li><a href="special_offer_admin.php">Special Offer</a></li>
                    <li><a href="confirmation_admin.php">Confirmation</a></li>
                    </ul>
                    
                    </div>
 <?php 
					if($_REUQEST['status']=="error")
					{
					?>
                    <div style="padding:10px 0; text-align:center; border:0px solid  #F00; width:960px; color:#F00; font-family:Arial, Helvetica, sans-serif">Please fill up the basic information first</div>
                    <?php
					}
					?>
<div class="restaurant_cont_field">
<form name="myfrm" method="post" enctype="multipart/form-data" action="" onSubmit="validate();">
<div class="restaurant_form_field">

<h1>Upload Photos</h1>

<div class="clear"></div>

<p>Photo 1 :</p>

<input name="photo1" id="photo1" type="file" class="multimedia_browse" />

<div class="clear"></div>

<p>Photo 2 :</p>

<input name="photo2" id="photo2" type="file" class="multimedia_browse" />

<div class="clear"></div>

<p>Photo 3 :</p>

<input name="photo3" id="photo3" type="file" class="multimedia_browse" />

<div class="clear"></div>

<p>Photo 4 :</p>

<input name="photo4" id="photo4" type="file" class="multimedia_browse" />

<div class="clear"></div>

<p>Photo 5 :</p>

<input name="photo5" id="photo5" type="file" class="multimedia_browse" />

<div class="clear"></div>


<p>Photo 6 :</p>

<input name="photo[]" id="photo6" type="file" class="multimedia_browse" />

<div class="clear"></div>

</div>

<div class="restaurant_form_field">

<h1>View Videos </h1>

<div class="clear"></div>

<p>Video 1 :</p>

<textarea name="video1" id="video1" cols="" rows="" class="multimedia_textarea"></textarea>
<input name="video_photo1" type="file" class="multimedia_browse2" />
<div class="clear"></div>

<p>Video 2 :</p>

<textarea name="video2" id="video2" cols="" rows="" class="multimedia_textarea"></textarea>
<input name="video_photo2" type="file" class="multimedia_browse2" />
<div class="clear"></div>

<p>Video 3 :</p>

<textarea name="video3" id="video3" cols="" rows="" class="multimedia_textarea"></textarea>
<input name="video_photo3" type="file" class="multimedia_browse2" />
<div class="clear"></div>

<p>Video 4 :</p>

<textarea name="video4" id="video4" cols="" rows="" class="multimedia_textarea"></textarea>
<input name="video_photo4" type="file" class="multimedia_browse2" />
<div class="clear"></div>

<input class="button4" type="submit" name="submit" value="Save & Continue">

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
