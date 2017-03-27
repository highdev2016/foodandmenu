<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
include ("image_file.php");
//rest_chk_authentication();
//print_r($_SESSION);
if(!isset($_SESSION['restaurant_admin_panel_id'])){
	header('location:restaurant_admin_login.php');
}

$max_order_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM  restaurant_basic_info"));
$show_no=$max_order_id['max_id']+1;

$max_feature_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM  restaurant_featured_city"));
$show_feature_no=$max_feature_id['max_id']+1;

if(count($_POST)>0 && $_REQUEST['submit']=="Save")
{
	if($_FILES['restaurant_image']['name']!="")
	    {
		$image1=$_FILES['restaurant_image']['name'];
		$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
	    //$image=time().$image;
		if ((($_FILES["restaurant_image"]["type"] == "image/gif")
		  || ($_FILES["restaurant_image"]["type"] == "image/png")
		  || ($_FILES["restaurant_image"]["type"] == "image/bmp")
		  || ($_FILES["restaurant_image"]["type"] == "image/jpg")
		  || ($_FILES["restaurant_image"]["type"] == "image/jpeg")
		  || ($_FILES["restaurant_image"]["type"] == "image/pjpeg")))
		  
		{
			 $picture_url="uploaded_images/".$image;
			LIB_StoreUploadImg($post_file_name="restaurant_image"
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="273"
								,$file_to_copy_height="215"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
		$picture_url_thumb="thumb_images/".$image;
			LIB_StoreUploadImg($post_file_name="restaurant_image"
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="216"
								,$file_to_copy_height="150"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
		}
	}
	
	$seprate="";
	foreach($_REQUEST['category_id'] as $single_category)
	{
		$all_category.=$separate.$single_category;
		$separate=",";
	}
	
	$res_basic_info=mysql_query("SELECT * FROM restaurant_basic_info where id='".$_SESSION['restaurant_admin_panel_id']."'");
	$row_basic_info=mysql_num_rows($res_basic_info);
	$res_basic_info=mysql_fetch_array($res_basic_info);
	$restaurant_id=$res_basic_info['id'];
	
	mysql_query("update restaurant_basic_info set name='".mysql_real_escape_string($_REQUEST['name'])."',phone='".mysql_real_escape_string($_REQUEST['phone'])."',fax='".mysql_real_escape_string($_REQUEST['fax'])."',email='".mysql_real_escape_string($_REQUEST['email'])."',website='".mysql_real_escape_string($_REQUEST['website'])."',restaurant_name='".mysql_real_escape_string($_REQUEST['restaurant_name'])."',restaurant_address='".mysql_real_escape_string($_REQUEST['restaurant_address'])."',restaurant_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."',restaurant_state='".mysql_real_escape_string($_REQUEST['restaurant_state'])."',restaurant_zipcode='".mysql_real_escape_string($_REQUEST['restaurant_zip'])."',restaurant_country='".mysql_real_escape_string($_REQUEST['restaurant_country'])."',restaurant_category='".mysql_real_escape_string($all_category)."' where id='".$restaurant_id."'");
	if($image!="")
	{
	mysql_query("update restaurant_basic_info set restaurant_image='".mysql_real_escape_string($image)."' where id='".$restaurant_id."'");
	}
	
	$sql_select_featured_city = mysql_num_rows("SELECT * FROM restaurant_featured_city WHERE featured_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."'");
	if($sql_select_featured_city == 0){
		mysql_query("insert into restaurant_featured_city set featured_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."'");
	}
	
	$address = $_REQUEST['restaurant_address'].",".$_REQUEST['restaurant_city'].",".$_REQUEST['restaurant_state'].",".$_REQUEST['restaurant_zip'].",".$_REQUEST['restaurant_country'];
	if($address!=''){
	$myaddress = urlencode($address);
	//here is the google api url
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
	//get the content from the api using file_get_contents
	$getmap = file_get_contents($url); 
	//the result is in json format. To decode it use json_decode
	$googlemap = json_decode($getmap);
	//get the latitute, longitude from the json result by doing a for loop
	foreach($googlemap->results as $res){
		$address = $res->geometry;
		$latlng = $address->location;
		$formattedaddress = $res->formatted_address;
	?>
	<?php //echo "Latitude: ". $latlng->lat ."<br />". "Longitude:". $latlng->lng;
	mysql_query("UPDATE restaurant_basic_info SET latitude = '".$latlng->lat."', longitude = '".$latlng->lng."' WHERE id = '".$restaurant_id."'");
	?>
	<?php
	}
	}
		
	header("location:my_settings_basic_info.php?success=1");
}
?>

<body>

<?php include ("includes/menu_rest_admin_panel.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont restu_live_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<!--<div class="restaurant_nav">
    <ul>
        <li><a href="my_settings_basic_info.php" class="active7">Basic Info</a></li>
        <li><a href="my_settings_additional_info.php">Additional Info</a></li>
        <li><a href="my_settings_multimedia.php">Multimedia</a></li>
        <li><a href="my_settings_special_offer.php">Special Offer</a></li>
    </ul>
</div>-->

<div class="restaurant_cont_field">
<?php if($_REQUEST['success'] == 1){?>
<p style="text-align:center;">Restaurant basic info updated successfully</p>
<?php } ?>
<?php
$res_basic_info_detail=mysql_query("SELECT * FROM restaurant_basic_info where id='".$_SESSION['restaurant_admin_panel_id']."'");
	$row_basic_info_detail=mysql_num_rows($res_basic_info_detail);
	if($row_basic_info_detail>0)
	{
		$basic_info_detail=mysql_fetch_array($res_basic_info_detail);
	}
    ?>
<form name="myfrm" method="post" action="" enctype="multipart/form-data">
<div class="restaurant_form_field">

<p>Name :</p>

<input name="name" id="name" type="text" class="restaurant" value="<?php echo $basic_info_detail['name']; ?>" />


<div class="clear"></div>


<p>Phone No :</p>

<input name="phone" id="phone" type="text" class="restaurant" value="<?php echo $basic_info_detail['phone']?>" />

<div class="clear"></div>

<p>Fax No :</p>

<input name="fax" id="fax" type="text" class="restaurant" value="<?php echo $basic_info_detail['fax']?>" />

<div class="clear"></div>

<p>Email Address :</p>

<input name="email" id="email" type="text" class="restaurant" value="<?php echo $basic_info_detail['email']; ?>" readonly />

<div class="clear"></div>

<p>Website :</p>

<input name="website" id="website" type="text" class="restaurant" value="<?php echo $basic_info_detail['website']?>" readonly />

<div class="clear"></div>

</div>

<div class="restaurant_form_field">

<p>Restaurant Name :</p>

<input name="restaurant_name" id="restaurant_name" type="text" class="restaurant" value="<?php echo stripslashes($basic_info_detail['restaurant_name'])?>" />

<div class="clear"></div>

<p>Address :</p>

<input name="restaurant_address" id="restaurant_address" type="text" class="restaurant" value="<?php echo stripslashes($basic_info_detail['restaurant_address'])?>" />

<div class="clear"></div>

<p>City :</p>

<input name="restaurant_city" id="restaurant_city" type="text" class="restaurant" value="<?php echo stripslashes($basic_info_detail['restaurant_city'])?>" />

<div class="clear"></div>

<p>State :</p>

<input name="restaurant_state" id="restaurant_state" type="text" class="restaurant" value="<?php echo stripslashes($basic_info_detail['restaurant_state'])?>" />

<div class="clear"></div>

<p>Zip Code :</p>

<input name="restaurant_zip" id="restaurant_zip" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_zipcode']?>" />

<div class="clear"></div>

<p>Country :</p>

<input name="restaurant_country" id="restaurant_country" type="text" class="restaurant" value="<?php echo stripslashes($basic_info_detail['restaurant_country'])?>" />

<div class="clear"></div>

<?php /*?><p>Restaurant Categories :</p>
<?php
$select_single_category=explode(",",$basic_info_detail['restaurant_category']);
?>
<select name="category_id[]" id="category_id" class="restaurant_list" multiple="multiple" style="height:auto">
<?php $res_category=mysql_query("select * from restaurant_category where 1 ORDER BY category_name");
      while($row_category=mysql_fetch_array($res_category)){ ?>
<option value="<?php echo $row_category['id']?>" <?php if(in_array($row_category['id'],$select_single_category)){?> selected <?php }?>><?php echo stripslashes($row_category['category_name'])?></option>
<?php
	  }
	  ?>
</select>

<div class="clear"></div><?php */?>

<p>Picture :</p>

<input name="restaurant_image" id="restaurant_image" type="file" class="restaurant_browse" />&nbsp;
<?php
if($basic_info_detail['restaurant_image']!="")
{
?><img src="uploaded_images/<?php echo $basic_info_detail['restaurant_image']?>" height="40" width="40">
<?php
}
?>

<div class="clear"></div>

<input class="button4" name="submit" type="submit" value="Save" >

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

