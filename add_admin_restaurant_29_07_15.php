<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
rest_chk_authentication();
//print_r($_SESSION);
//echo $_SESSION['admin_res_id'];
?>

<script type="text/javascript" src="admin/ckeditor/ckeditor.js"></script>

<script src="admin/ckeditor/_samples/sample.js" type="text/javascript"></script>

<body>

<?php include ("includes/menu_admin_add_res.php");?>
<?php include ("image_file.php");?>

<?php //print_r($_SESSION);?>
<?php

$max_order_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM  restaurant_basic_info"));
$show_no=$max_order_id['max_id']+1;

$max_feature_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM  restaurant_featured_city"));
$show_feature_no=$max_feature_id['max_id']+1;

if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
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
	
	$seprate="";
	foreach($_REQUEST['category_id'] as $single_category)
	{
		$all_category.=$separate.$single_category;
		$separate=",";
	}
	
	$res_basic_info=mysql_query("SELECT * FROM restaurant_basic_info where id='".$_SESSION['restid']."'");
	$row_basic_info=mysql_num_rows($res_basic_info);
	if($row_basic_info>0)
	{
		$res_basic_info=mysql_fetch_array($res_basic_info);
		$restaurant_id=$res_basic_info['id'];
		mysql_query("update restaurant_basic_info set name='".mysql_real_escape_string($_REQUEST['name'])."',phone='".mysql_real_escape_string($_REQUEST['phone'])."',fax='".mysql_real_escape_string($_REQUEST['fax'])."',email='".mysql_real_escape_string($_REQUEST['email'])."',  restaurant_description = '".addslashes(htmlspecialchars($_REQUEST['restaurant_description']))."',website='".mysql_real_escape_string($_REQUEST['website'])."',restaurant_facebook_url='".mysql_real_escape_string($_REQUEST['facebook'])."',restaurant_twitter_url='".mysql_real_escape_string($_REQUEST['twitter'])."',restaurant_google_plus_url='".mysql_real_escape_string($_REQUEST['google_plus'])."',restaurant_urbanspoon_url='".mysql_real_escape_string($_REQUEST['urbanspoon'])."',restaurant_name='".mysql_real_escape_string($_REQUEST['restaurant_name'])."',restaurant_address='".mysql_real_escape_string($_REQUEST['restaurant_address'])."',restaurant_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."',restaurant_state='".mysql_real_escape_string($_REQUEST['restaurant_state'])."',restaurant_zipcode='".mysql_real_escape_string($_REQUEST['restaurant_zip'])."',restaurant_country='".mysql_real_escape_string($_REQUEST['restaurant_country'])."',restaurant_category='".mysql_real_escape_string($all_category).", restaurant_keyword = '".htmlspecialchars(stripslashes($_REQUEST['restaurant_keyword']),ENT_QUOTES)."' where id='".$_SESSION['restid']."'");
		if($image!="")
		{
		mysql_query("update restaurant_basic_info set restaurant_image='".mysql_real_escape_string($image)."' where id='".$_SESSION['restid']."'");
		}
		
		$sep = '';
		foreach($_POST['countdiv'] as $countDiv_del){
			if($_POST['restaurant_keyword'.$countDiv_del]!=''){
				$restaurant_keyword = $restaurant_keyword.$sep.htmlspecialchars(stripslashes($_POST['restaurant_keyword'.$countDiv_del]),ENT_QUOTES);
				$sep = ',';
			}
		}
		
		$sql_del_charge = "UPDATE restaurant_basic_info set restaurant_keyword = '".$restaurant_keyword."' WHERE id = '".$_SESSION['restid']."' ";
		mysql_query($sql_del_charge);
		
		
		$sql_select_featured_city = mysql_num_rows("SELECT * FROM restaurant_featured_city WHERE featured_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."'");
		if($sql_select_featured_city == 0){
			mysql_query("insert into restaurant_featured_city set featured_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."'");
		}
		
		$address = $_REQUEST['restaurant_address'].",".$_REQUEST['restaurant_city'].",".$_REQUEST['restaurant_state'].",".$_REQUEST['restaurant_zip'].",".$_REQUEST['restaurant_country'];
		if($address!=''){
		$myaddress = urlencode($address);
		//here is the google api url
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
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
		mysql_query("UPDATE restaurant_basic_info SET latitude = '".$latlng->lat."', longitude = '".$latlng->lng."' WHERE id = '".$_SESSION['restid']."'");
		?>
		<?php
		}
		}
		
	}
	else{
	mysql_query("insert into restaurant_basic_info set name='".mysql_real_escape_string($_REQUEST['name'])."',user_id='".mysql_real_escape_string($_SESSION['restaurant_id'])."',phone='".mysql_real_escape_string($_REQUEST['phone'])."',fax='".mysql_real_escape_string($_REQUEST['fax'])."',email='".mysql_real_escape_string($_REQUEST['email'])."', restaurant_description = '".addslashes(htmlspecialchars($_REQUEST['restaurant_description']))."',website='".mysql_real_escape_string($_REQUEST['website'])."',restaurant_facebook_url='".mysql_real_escape_string($_REQUEST['facebook'])."',restaurant_twitter_url='".mysql_real_escape_string($_REQUEST['twitter'])."',restaurant_google_plus_url='".mysql_real_escape_string($_REQUEST['google_plus'])."',restaurant_urbanspoon_url='".mysql_real_escape_string($_REQUEST['urbanspoon'])."',restaurant_name='".mysql_real_escape_string($_REQUEST['restaurant_name'])."',restaurant_address='".mysql_real_escape_string($_REQUEST['restaurant_address'])."',restaurant_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."',restaurant_state='".mysql_real_escape_string($_REQUEST['restaurant_state'])."',restaurant_zipcode='".mysql_real_escape_string($_REQUEST['restaurant_zip'])."',restaurant_country='".mysql_real_escape_string($_REQUEST['restaurant_country'])."',restaurant_category='".mysql_real_escape_string($all_category)."',show_order='".mysql_real_escape_string($show_no)."',restaurant_image='".mysql_real_escape_string($image)."',featured_status =1, restaurant_keyword = '".htmlspecialchars(stripslashes($_REQUEST['restaurant_keyword']),ENT_QUOTES)."'");
	$resturant_id=mysql_insert_id();
	$_SESSION['restid'] = $resturant_id;
	
	$sql_select_featured_city = mysql_num_rows("SELECT * FROM restaurant_featured_city WHERE featured_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."'");
	if($sql_select_featured_city == 0){
		mysql_query("insert into restaurant_featured_city set featured_city='".mysql_real_escape_string($_REQUEST['restaurant_city'])."'");
	}
	$_SESSION['admin_res_id']=$resturant_id;
	
	$address1 = $_REQUEST['restaurant_address'].",".$_REQUEST['restaurant_city'].",".$_REQUEST['restaurant_state'].",".$_REQUEST['restaurant_zip'].",".$_REQUEST['restaurant_country'];
	if($address1!=''){
	$myaddress = urlencode($address1);
	//here is the google api url
	$url = "https://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
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
	mysql_query("UPDATE restaurant_basic_info SET latitude = '".$latlng->lat."', longitude = '".$latlng->lng."' WHERE id = '".$_SESSION['restid']."'");
	?>
	<?php
	}
	}
	}
	header("location:admin_additional.php");
}
?>

<script type="text/javascript">
function add_cell(id){
	//alert(id);
	$.ajax({
		url : 'addrest_keyword.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu').appendChild(menuDiv);
			document.getElementById('item_id').value=parseInt(id)+1;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus').focus();
}

function remove_div(delId)
{
	var div = document.getElementById("business_div_" + delId);
	div.parentNode.removeChild(div);
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
        <li><a href="add_admin_restaurant.php" class="active7">Basic Info</a></li>
        <li><a href="admin_additional.php">Additional Info</a></li>
        <li><a href="admin_restaurant_menu.php">Menu</a></li>
        <li><a href="admin_multimedia.php">Multimedia</a></li>
        <li><a href="admin_special_offer.php">Special Offer</a></li>
        <li><a href="admin_confirmation.php">Confirmation</a></li>
    </ul>
    
    </div>
                    
    <?
	$res_basic_info_detail=mysql_query("SELECT * FROM restaurant_basic_info where id='".$_SESSION['restid']."'");
	$row_basic_info_detail=mysql_num_rows($res_basic_info_detail);
	if($row_basic_info_detail>0)
	{
		$basic_info_detail=mysql_fetch_array($res_basic_info_detail);
	}

?>

<div class="restaurant_cont_field">
<form name="myfrm" method="post" action="" enctype="multipart/form-data">
<div class="restaurant_form_field">

<p>Name :</p>

<input name="name" id="name" type="text" class="restaurant" value="<?php echo $basic_info_detail['name']; ?>"  />


<div class="clear"></div>


<p>Phone No :</p>

<input name="phone" id="phone" type="text" class="restaurant" value="<?php echo $basic_info_detail['phone']?>" />

<div class="clear"></div>

<p>Fax No :</p>

<input name="fax" id="fax" type="text" class="restaurant" value="<?php echo $basic_info_detail['fax']?>" />

<div class="clear"></div>

<p>Email Address :</p>

<input name="email" id="email" type="text" class="restaurant" value="<?php echo $basic_info_detail['email']; ?>" />


<div class="clear"></div>



<p>Website :</p>

<input name="website" id="website" type="text" class="restaurant" value="<?php echo $basic_info_detail['website']?>" />

<div class="clear"></div>

<p>Facebook :</p>

<input name="facebook" id="facebook" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_facebook_url']?>" />

<div class="clear"></div>

<p>Twitter :</p>

<input name="twitter" id="twitter" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_twitter_url']?>" />

<div class="clear"></div>

<p>Google Plus :</p>

<input name="google_plus" id="google_plus" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_google_plus_url']?>" />

<div class="clear"></div>

<p>Urbanspoon :</p>

<input name="urbanspoon" id="urbanspoon" type="text" class="restaurant" value="<?php echo $basic_info_detail['restaurant_urbanspoon_url']?>" />

<div class="clear"></div>

<p>About Restaurant :</p>

<div class="clear"></div>
<textarea name="restaurant_description" id="restaurant_description" style="margin: 0px; width: 170px; height: 46px; border-radius: 3px; resize:none; visibility:visible; display:block;" rows="3" cols="15"><?php echo stripslashes(htmlspecialchars_decode($basic_info_detail['restaurant_description'])); ?></textarea>

<?php /*?><script type="text/javascript">
CKEDITOR.replace( 'restaurant_description', {
	toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
		'/',																					// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
	]
});</script><?php */?>

<script>
CKEDITOR.replace( 'restaurant_description', {
	toolbar : [
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
	{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	//{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
	'/',
	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	{ name: 'others', items: [ '-' ] },
	{ name: 'about', items: [ 'About' ] }
]
});
</script>

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
<?php
$select_single_category=explode(",",$basic_info_detail['restaurant_category']);
?>
<p>Restaurant Categories :</p>
<select name="category_id[]" id="category_id" class="restaurant_list" multiple="multiple" style="height:auto;">
<option value="">--Select--</option>
<?php $res_category=mysql_query("select * from restaurant_category where 1 ORDER BY category_name");
      while($row_category=mysql_fetch_array($res_category)){ ?>
<option value="<?php echo $row_category['id']?>" <?php if(in_array($row_category['id'],$select_single_category)){?> selected <?php }?>><?php echo stripslashes($row_category['category_name'])?></option>
<?php
	  }
	  ?>
</select>

<div class="clear"></div>

<p>Keywords :</p>
<?php  $rest_key = explode(",",$basic_info_detail['restaurant_keyword']);
$arr_count = count($rest_key)+1; 
if(!empty($rest_key)){
$incc = 1;
foreach($rest_key as $val_rest_key){ ?>

<input type="hidden" name="countdiv[]" value="<?php echo $incc; ?>" class="webcampics">
<?php if($incc!=1){ ?>
<p></p>
<?php } ?>

<input name="restaurant_keyword<?php echo $incc; ?>" id="restaurant_keyword<?php echo $incc; ?>" type="text" class="restaurant" value="<?php echo $val_rest_key; ?>" />

<?php if($incc == 1){?>
<a href="javascript:void(0);" onClick="add_cell(document.getElementById('item_id').value)" id="item_focus" ><img src="images/add_newicon.png" alt="Add New" width="70" height="22"></a>
<?php } ?>
<?php $incc++; } }else{?>

<input type="hidden" name="countdiv[]" value="1" class="webcampics">
<input name="restaurant_keyword1" id="restaurant_keyword1" type="text" class="restaurant" value="" /> &nbsp; 
<a href="javascript:void(0);" onClick="add_cell(document.getElementById('item_id').value)" id="item_focus" ><img src="images/add_newicon.png" alt="Add New" width="70" height="22"></a>


<?php } ?>

<div id="allmenu">
<?php if(!empty($rest_key)){
	$item_id = $arr_count;
}else{
	$item_id = 2;
}?>
<input type="hidden" id="item_id" name="item_id" value="<?php echo $item_id; ?>">

</div>

<div class="clear"></div>

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
