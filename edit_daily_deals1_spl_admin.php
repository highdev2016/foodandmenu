<?php
ob_start();
session_start();
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
 include ("includes/header_vendor.php");?>
<?php include ("admin/lib/conn.php");?>
<?php include ("image_file.php");?>

<body>

<?php include ("includes/menu_admin_addedit_res.php");?>


<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	if($_FILES['daily_picture']['name']!="")
		{
		$video_image1=$_FILES['daily_picture']['name'];
		$video_image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $video_image1);
	    //$video_image=time().$video_image;
		if ((($_FILES["daily_picture".$j]["type"] == "image/gif")
		  || ($_FILES["daily_picture".$j]["type"] == "image/png")
		  || ($_FILES["daily_picture".$j]["type"] == "image/bmp")
		  || ($_FILES["daily_picture".$j]["type"] == "image/jpg")
		  || ($_FILES["daily_picture".$j]["type"] == "image/jpeg")
		  || ($_FILES["daily_picture".$j]["type"] == "image/pjpeg")))
		  
		{
			
		$picture_url_thumb="thumb_images/".$video_image;
			LIB_StoreUploadImg($post_file_name="daily_picture"
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="216"
								,$file_to_copy_height="150"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
								
		
}

		}
		
		if($_FILES['daily_picture']['name']!=""){	
		mysql_query("update restaurant_deals set deals_status='".htmlspecialchars(stripslashes($_REQUEST['daily_deals']),ENT_QUOTES)."',daily_name='".htmlspecialchars(stripslashes($_REQUEST['daily_name']),ENT_QUOTES)."',daily_price='".$_REQUEST['daily_price']."',daily_description='".htmlspecialchars(stripslashes($_REQUEST['daily_description']),ENT_QUOTES)."',expiry_date='".change_dateformat($_REQUEST['expiry_date'])."',daily_picture='".$video_image."',special_rules='".htmlspecialchars(stripslashes($_REQUEST['special_rules']),ENT_QUOTES)."',disclaimer_title='".htmlspecialchars(stripslashes($_REQUEST['disclaimer_title']),ENT_QUOTES)."',disclaimer='".htmlspecialchars(stripslashes($_REQUEST['disclaimer']),ENT_QUOTES)."' where id='".$_REQUEST['deals_hid']."'");
		
		}
		else{
		
			mysql_query("update restaurant_deals set deals_status='".htmlspecialchars(stripslashes($_REQUEST['daily_deals']),ENT_QUOTES)."',daily_name='".htmlspecialchars(stripslashes($_REQUEST['daily_name']),ENT_QUOTES)."',daily_price='".$_REQUEST['daily_price']."',daily_description='".htmlspecialchars(stripslashes($_REQUEST['daily_description']),ENT_QUOTES)."',expiry_date='".change_dateformat($_REQUEST['expiry_date'])."',special_rules='".htmlspecialchars(stripslashes($_REQUEST['special_rules']),ENT_QUOTES)."',disclaimer_title='".htmlspecialchars(stripslashes($_REQUEST['disclaimer_title']),ENT_QUOTES)."',disclaimer='".htmlspecialchars(stripslashes($_REQUEST['disclaimer']),ENT_QUOTES)."'  where id='".$_REQUEST['deals_hid']."'");
			
		}
		
		header("location:spl_admin_special_offer.php?success=4");
		

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

<link rel="stylesheet" href="calender/jquery-ui.css" />
<script src="calender/jquery-1.8.3.js"></script>
<script src="calender/jquery-ui.js"></script>
<script>
$(function() {
	$( "#expiry_date" ).datepicker({
		dateFormat:"mm-dd-yy"
	});
	
	//$( "#post_date" ).datepicker( "dd-mm-yy", "dateFormat" );
});
</script>
<?php
$select_deals=mysql_fetch_array(mysql_query("select * from restaurant_deals where id='".$_REQUEST['deals_id']."'"));
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
                    <li><a href="spl_admin_add_restaurant.php">Basic Info</a></li>
                    <li><a href="spl_admin_additional.php">Additional Info</a></li>
                    <li><a href="spl_admin_restaurant_menu.php">Menu</a></li>
                    <li><a href="spl_admin_multimedia.php">Multimedia</a></li>
                    <li><a href="spl_admin_special_offer.php" class="active7">Special Offer</a></li>
                    <li><a href="spl_admin_confirmation.php">Confirmation</a></li>
                    </ul>
                    
                    </div>

<div class="restaurant_cont_field">
<form name="myfrm" method="post" enctype="multipart/form-data">


<div class="restaurant_form_field" style="padding-left:250px;">

<h1 style="padding-left:150px;">Daily Deals </h1>

<div class="clear"></div>

<p>Daily Deals* :</p>

<input name="daily_deals" type="radio" value="1" class="radio_section" <?php if($select_deals['deals_status']==1){?> checked <?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals" type="radio" value="0" class="radio_section" <?php if($select_deals['deals_status']==0){?> checked <?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily Description* :</p>

<input name="daily_name" type="text" class="restaurant" value="<?php echo $select_deals['daily_name']?>" />

<div class="clear"></div>

<p>Price* :</p>

<input name="daily_description" type="text" class="restaurant" value="<?php echo $select_deals['daily_description']?>"/>

<div class="clear"></div>

<p>Your Price* :</p>

<input name="daily_price" type="text" class="restaurant" value="<?php echo $select_deals['daily_price']?>"/>

<div class="clear"></div>

<p>Picture :</p>

<input name="daily_picture" type="file" class="restaurant_browse" />
<input type="hidden" name="deals_hid" value="<?php echo $select_deals['id']?>">
<?php
if($select_deals['daily_picture']!="")
{
?>
<img src="thumb_images/<?php echo $select_deals['daily_picture']?>" height="40" width="40" >
<?php
}
?>

<div class="clear"></div>

<p>Expiry Date :</p>

<input name="expiry_date" id="expiry_date" type="text" class="restaurant_browse" value="<?php echo change_dateformat_reverse($select_deals['expiry_date'])?>" />

<div class="clear"></div>


<p>Special Rules :</p>

<input name="special_rules" id="special_rules" type="text" class="restaurant_browse" value="<?php echo $select_deals['special_rules'];?>" />

<div class="clear"></div>

<p>Disclaimer Title :</p>

<input name="disclaimer_title" id="disclaimer_title" type="text" class="restaurant_browse" value="<?php echo $select_deals['disclaimer_title'];?>" />

<div class="clear"></div>

<p>Disclaimer Description :</p>

<textarea name="disclaimer" id="disclaimer" rows="5" cols="25"><?php echo $select_deals['disclaimer'];?></textarea>

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
