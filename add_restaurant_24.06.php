<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
rest_chk_authentication();
?>
<body>

<?php include ("includes/top_search.php");?>
<?php include ("includes/menu_section.php");?>
<?php include ("image_file.php");?>

<?php //print_r($_SESSION);?>
<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	if($_FILES['restaurant_image']['name']!="")
	    {
		$image=$_FILES['restaurant_image']['name'];
	    $image=time().$image;
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
								
		$picture_url_deal="deal_images/".$image;
			LIB_StoreUploadImg($post_file_name="restaurant_image"
								,$file_to_copy_path="$picture_url_deal"
								,$file_to_copy_width="179"
								,$file_to_copy_height="109"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
}
	}
	
	$res_basic_info=mysql_query("SELECT * FROM restaurant_basic_info where user_id='".$_SESSION['restaurant_id']."'");
	$row_basic_info=mysql_num_rows($res_basic_info);
	if($row_basic_info>0)
	{
		$res_basic_info=mysql_fetch_array($res_basic_info);
		$restaurant_id=$res_basic_info['id'];
		mysql_query("update restaurant_basic_info set name='".mysql_real_escape_string($_REQUEST['name'])."',phone='".mysql_real_escape_string($_REQUEST['phone'])."',fax='".mysql_real_escape_string($_REQUEST['fax'])."',email='".mysql_real_escape_string($_REQUEST['email'])."',website='".mysql_real_escape_string($_REQUEST['website'])."',restaurant_name='".mysql_real_escape_string($_REQUEST['restaurant_name'])."',restaurant_address='".mysql_real_escape_string($_REQUEST['restaurant_address'])."',restaurant_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."',restaurant_state='".mysql_real_escape_string($_REQUEST['restaurant_state'])."',restaurant_zipcode='".mysql_real_escape_string($_REQUEST['restaurant_zip'])."',restaurant_country='".mysql_real_escape_string($_REQUEST['restaurant_country'])."',restaurant_category='".mysql_real_escape_string($_REQUEST['category_id'])."' where id='".$restaurant_id."'");
		if($image!="")
		{
		mysql_query("update restaurant_basic_info set restaurant_image='".mysql_real_escape_string($image)."' where id='".$restaurant_id."'");
		}
		mysql_query("insert into restaurant_featured_city set featured_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."'");
	}
	else{
	mysql_query("insert into restaurant_basic_info set name='".mysql_real_escape_string($_REQUEST['name'])."',user_id='".mysql_real_escape_string($_SESSION['restaurant_id'])."',phone='".mysql_real_escape_string($_REQUEST['phone'])."',fax='".mysql_real_escape_string($_REQUEST['fax'])."',email='".mysql_real_escape_string($_REQUEST['email'])."',website='".mysql_real_escape_string($_REQUEST['website'])."',restaurant_name='".mysql_real_escape_string($_REQUEST['restaurant_name'])."',restaurant_address='".mysql_real_escape_string($_REQUEST['restaurant_address'])."',restaurant_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."',restaurant_state='".mysql_real_escape_string($_REQUEST['restaurant_state'])."',restaurant_zipcode='".mysql_real_escape_string($_REQUEST['restaurant_zip'])."',restaurant_country='".mysql_real_escape_string($_REQUEST['restaurant_country'])."',restaurant_category='".mysql_real_escape_string($_REQUEST['category_id'])."',restaurant_image='".mysql_real_escape_string($image)."'");
	
	mysql_query("insert into restaurant_featured_city set featured_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."'");
	
	$resturant_id=mysql_insert_id();
	$_SESSION['rest_id']=$resturant_id;
	}
	header("location:additional.php");
}
?>
<script type="text/javascript">
function validate()
{
	if(document.getElementById('name').value=="")
	{
		alert("Please enter your name");
		document.getElementById('name').focus();
		return false;
	}
	if(document.getElementById('phone').value=="")
	{
		alert("Please enter phone number");
		document.getElementById('phone').focus();
		return false;
	}
	if(document.getElementById('email').value=="")
	{
		alert("Please enter email address");
		document.getElementById('email').focus();
		return false;
	}
	if(document.getElementById('restaurant_name').value=="")
	{
		alert("Please enter restaurant number");
		document.getElementById('restaurant_name').focus();
		return false;
	}
	if(document.getElementById('restaurant_address').value=="")
	{
		alert("Please enter address");
		document.getElementById('restaurant_address').focus();
		return false;
	}
	if(document.getElementById('restaurant_city').value=="")
	{
		alert("Please enter city");
		document.getElementById('restaurant_city').focus();
		return false;
	}
	if(document.getElementById('restaurant_state').value=="")
	{
		alert("Please enter state");
		document.getElementById('restaurant_state').focus();
		return false;
	}
	if(document.getElementById('restaurant_zip').value=="")
	{
		alert("Please enter zipcode");
		document.getElementById('restaurant_zip').focus();
		return false;
	}
	if(document.getElementById('restaurant_country').value=="")
	{
		alert("Please enter country");
		document.getElementById('restaurant_country').focus();
		return false;
	}
	if(document.getElementById('category_id').value=="")
	{
		alert("Please select category");
		document.getElementById('category_id').focus();
		return false;
	}
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
                    
                    
                    <ul>
                    <li><a href="add_restaurant.php" class="active7">Basic Info</a></li>
                    <li><a href="additional.php">Additional Info</a></li>
                    <li><a href="restaurant_menu.php">Menu</a></li>
                    <li><a href="multimedia.php">Multimedia</a></li>
                    <li><a href="confirmation.php">Confirmation</a></li>
                    <li><a href="special_offer.php">Special Offer</a></li>
                    
                    
                    </ul>
                    
                    </div>
                    
     <?
	 
     $res_basic_info_detail=mysql_query("SELECT * FROM restaurant_basic_info where user_id='".$_SESSION['restaurant_id']."'");
	$row_basic_info_detail=mysql_num_rows($res_basic_info_detail);
	if($row_basic_info_detail>0)
	{
		$basic_info_detail=mysql_fetch_array($res_basic_info_detail);
	}
	?>

<div class="restaurant_cont_field">
<form name="myfrm" method="post" action="" enctype="multipart/form-data" onSubmit="validate();">
<div class="restaurant_form_field">

<p>Name* :</p>

<input name="name" id="name" type="text" class="restaurant" value="<?php echo $_SESSION[restaurant_user_user_nicename]; ?>" readonly />

<div class="clear"></div>


<p>Phone No* :</p>

<input name="phone" id="phone" type="text" class="restaurant" value="<?php echo $basic_info_detail['phone']?>" />

<div class="clear"></div>

<p>Fax No :</p>

<input name="fax" id="fax" type="text" class="restaurant" value="<?php echo $basic_info_detail['fax']?>" />

<div class="clear"></div>

<p>Email Address* :</p>

<input name="email" id="email" type="text" class="restaurant" value="<?php echo $_SESSION[restaurant_user_email]; ?>" readonly />

<div class="clear"></div>

<p>Website :</p>

<input name="website" id="website" type="text" class="restaurant" value="<?php echo $basic_info_detail['website']?>" />

<div class="clear"></div>

</div>

<div class="restaurant_form_field">

<p>Restaurant Name* :</p>

<input name="restaurant_name" id="restaurant_name" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_name']?>" />

<div class="clear"></div>

<p>Address* :</p>

<input name="restaurant_address" id="restaurant_address" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_address']?>" />

<div class="clear"></div>

<p>City* :</p>

<input name="restaurant_city" id="restaurant_city" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_city']?>" />

<div class="clear"></div>

<p>State* :</p>

<input name="restaurant_state" id="restaurant_state" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_state']?>" />

<div class="clear"></div>

<p>Zip Code* :</p>

<input name="restaurant_zip" id="restaurant_zip" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_zipcode']?>" />

<div class="clear"></div>

<p>Country* :</p>

<input name="restaurant_country" id="restaurant_country" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_country']?>" />

<div class="clear"></div>

<p>Restaurent Categories* :</p>
<select name="category_id" id="category_id" class="restaurant_list">
<option value="">--Select--</option>
<?php $res_category=mysql_query("select * from restaurant_category where 1");
      while($row_category=mysql_fetch_array($res_category)){ ?>
<option value="<?php echo $row_category['id']?>" <?php if($basic_info_detail['restaurant_category']==$row_category['id']){?> selected <?php }?>><?php echo $row_category['category_name']?></option>
<?php
	  }
	  ?>
</select>

<div class="clear"></div>

<p>Picture* :</p>

<input name="restaurant_image" id="restaurant_image" type="file" class="restaurant_browse" />&nbsp;
<?php
if($basic_info_detail['restaurant_image']!="")
{
?><img src="uploaded_images/<?php echo $basic_info_detail['restaurant_image']?>" height="40" width="40">
<?php
}
?>

<div class="clear"></div>

<input class="button4" name="submit" type="submit" value="Save & Continue" >

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

