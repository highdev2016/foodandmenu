<?php
ob_start();
session_start();
 include("includes/header_vendor.php");?>
<?php include("admin/lib/conn.php");?>
<?php include("image_file.php");?>
<?php 
if($_REQUEST['action']=='del' && $_REQUEST['del_image_id']!=''){
	mysql_query("delete from restaurant_photo where id='".$_REQUEST['del_image_id']."'");
	header("location:edit_multimedia.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&success=2");
	exit();
}
if($_REQUEST['action']=='del' && $_REQUEST['del_video_id']!=''){
	mysql_query("delete from restaurant_video where id='".$_REQUEST['del_video_id']."'");
	header("location:edit_multimedia.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&success=4");
	exit();
}
?>
<body>

<?php include ("includes/menu_admin_edit_res.php");?>


<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	$res_basic_info=mysql_query("SELECT * FROM restaurant_basic_info where id='".$_REQUEST['restaurant_edit_id']."'");
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
mysql_query("insert into restaurant_photo set image_name='".$image."',restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
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

mysql_query("insert into restaurant_video set video_link='".$_REQUEST['video'.$j]."',video_image='".$video_image."', restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
		}
	
		
	}
   
   header("location:edit_special_offer.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."");
	}
	else{
		header("location:edit_multimedia.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&status=error");
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
<?php
$sql_restaurant_name=mysql_fetch_array(mysql_query("select restaurant_name from restaurant_basic_info where id='".$_REQUEST['restaurant_edit_id']."'"));
?>
<div class="restaurant_body_cont multi_body_cont">

<div class="restaurant_cont_top">
<h1>Edit <?php echo stripslashes($sql_restaurant_name['restaurant_name'])?></h1>
</div>

<div class="restaurant_nav">
                    
                    
                    <ul>
                    <li><a href="edit_restaurant.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Basic Info</a></li>
                    <li><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Additional Info</a></li>
                    <li><a href="edit_restaurant_menu.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Menu</a></li>
                    <li><a href="edit_multimedia.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="active7">Multimedia</a></li>
                    <li><a href="edit_special_offer.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Special Offer</a></li>
                    <li><a href="edit_confirmation.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Confirmation</a></li>
                    
                    
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
<form name="myfrm" method="post" enctype="multipart/form-data" action="" >
<?php if($_REQUEST['success'] == 1){?>
<p style="text-align:center;">Image updated successfully</p>
<?php } else if($_REQUEST['success'] == 2){ ?>
<p style="text-align:center;">Image deleted successfully</p>
<?php } else if($_REQUEST['success'] == 3){ ?>
<p style="text-align:center;">Video updated successfully</p>
<?php } else if($_REQUEST['success'] == 4){ ?>
<p style="text-align:center;">Video deleted successfully</p>
<?php } ?> 
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
<form name="del_all" action="edit_multimedia.php" method="post" >
<?php 
$sql_deals = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
if(mysql_num_rows($sql_deals)>0){?>
<div style="width:970px; margin:0 auto;">
<h3>Image List</h3>
<div style="float:right;margin-bottom:11px;">
<input type="submit" name="delete_all" id="delete_all" value="Delete All" class="all_edit" style="border-radius:3px; border: 1px solid rgb(53, 72, 154);">

<input type="hidden" name="edit_hid" id="edit_hid" value="<?php echo $_REQUEST['restaurant_edit_id']; ?>" >

<?php /*?><a href="edit_multimedia.php?action=del&del_video_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit" onClick="return confirm('Are you sure you want to delete the checked images?');" title="Delete All Checked">Delete All</a><?php */?>
</div>
<table width="98%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:10px;" align="center">
  <tr>
  	<th width="8%" align="center" class="all_restaurant" style="text-align:center;"><input type="checkbox"  name="checkAllAuto" id="checkAllAuto"  value="0"/></th>
    <th width="69%" class="all_restaurant">Image</th>
    <th width="23%" class="all_restaurant">Action</th>
  </tr>
  <?php
	while($array_deals = mysql_fetch_array($sql_deals)){
  ?>
  <tr>
  <td class="all_restaurant2" align="center"><input type="checkbox" name="check_box[]" value="<?php echo $array_deals['id']; ?>"  /></td>
    <td class="all_restaurant2"><img src="thumb_images/<?php echo $array_deals['image_name']?>" height="35" width="35"></td>
    <td class="all_restaurant2"><a href="edit_image.php?image_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit" onClick="return confirm('Are you sure you want to edit this image?');">Edit</a>&nbsp;<a href="edit_multimedia.php?action=del&del_image_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit" onClick="return confirm('Are you sure you want to delete this image?');">Delete</a></td>
  </tr>
<?php } ?>
</table></div>
<?php
}
?>

<?php 
$sql_deals = mysql_query("SELECT * FROM restaurant_video WHERE restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
if(mysql_num_rows($sql_deals)>0){?>
<div style="width:970px; margin:20px auto;">
<h3>Video List</h3>
<table width="100%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:10px;" align="center">
  <tr>
    <td width="22%" class="all_restaurant">Video Link</td>
    <td width="18%" class="all_restaurant">Video Image</td>
    <td width="21%" class="all_restaurant">Action</td>
  </tr>
  <?php
	while($array_deals = mysql_fetch_array($sql_deals)){
  ?>
  <tr>
    <td class="all_restaurant2"><?php echo $array_deals['video_link']?></td>
    <td class="all_restaurant2"><img src="thumb_images/<?php echo $array_deals['video_image']?>"></td>
    <td class="all_restaurant2"><a href="edit_video.php?video_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit" onClick="return confirm('Are you sure you want to edit this video?');">Edit</a>&nbsp;<a href="edit_multimedia.php?action=del&del_video_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit" onClick="return confirm('Are you sure you want to delete this video?');">Delete</a></td>
  </tr>
<?php } ?>
</table></div>
<?php
}
?>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>
</form>
<div class="clear"></div>

<?php
if($_REQUEST['delete_all'] == 'Delete All')
{
	$del_id = $_REQUEST['check_box'];
	$edit_id = $_REQUEST['edit_hid'];
	
	for($i=0;$i<count($del_id);$i++)
	{
		$sql_del_all = mysql_query("DELETE FROM restaurant_photo WHERE id = '".$del_id[$i]."'");
	}
	
	header("location:edit_multimedia.php?restaurant_edit_id=".$edit_id."");
}
?>


<script type="text/javascript">
var $j = jQuery.noConflict();
$j('#checkAllAuto').click(function(){
	$j("INPUT[name='check_box[]'][type='checkbox']").attr('checked', $j('#checkAllAuto').is(':checked'));
});
$j("INPUT[name='check_box[]'][type='checkbox']").click(function(){
	var all_checked = false;
	$j("INPUT[name='check_box[]'][type='checkbox']").each(function(){
		if($j(this).is(':checked')){
			all_checked = true;
		}else{
			all_checked = false;
			return all_checked;
		}
	});
	$j("#checkAllAuto").attr('checked', all_checked);
});

</script>