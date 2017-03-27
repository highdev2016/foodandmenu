<?php
ob_start();
session_start();
 include("includes/header_vendor.php");?>
<?php include("admin/lib/conn.php");?>
<?php include("image_file.php");?>

<?php $sql_category = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$_REQUEST['menu_id']."'"));?>
<body  onLoad="get_size('<?php echo $sql_category['size'];?>',1);">
<?php include ("includes/menu_admin_addedit_res.php");?>
<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
{
//print_r($_POST['countdiv']);
//print_r($_POST['main_category1']);
//print_r($_POST['sub_category1']);
	
		$restaurant_id = $sql_category['restaurant_id'];
		$category_id = $_POST['main_category1'];
		$sub_category_id = $_POST['sub_category1'];
		$menu_name = $_POST['menu_items1'];
		$description = $_POST['menu_description1'];
		$size = $_POST['size1'];
		$menu_price = $_POST['menu_price1'];
		$small_price = $_POST['small_price1'];
		$medium_price = $_POST['medium_price1'];
		$large_price = $_POST['large_price1'];
		
		/*----image-----*/
		if($_FILES['menu_picture1']['name']!="")
		{
			
			$image1=$_FILES['menu_picture1']['name'];
			$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
			//$image=time().$image;
			if ((($_FILES["menu_picture1"]["type"] == "image/gif")
			|| ($_FILES["menu_picture1"]["type"] == "image/png")
			|| ($_FILES["menu_picture1"]["type"] == "image/bmp")
			|| ($_FILES["menu_picture1"]["type"] == "image/jpg")
			|| ($_FILES["menu_picture1"]["type"] == "image/jpeg")
			|| ($_FILES["menu_picture1"]["type"] == "image/pjpeg")))
			{
				$picture_url="uploaded_images/".$image;
				LIB_StoreUploadImg($post_file_name="menu_picture1"
				,$file_to_copy_path="$picture_url"
				,$file_to_copy_width="800"
				,$file_to_copy_height="600"
				,$adjust = ''
				,$watermark_gif=''
				,$watermark_position='');
				
				$picture_url_thumb="thumb_images/".$image;
				LIB_StoreUploadImg($post_file_name="menu_picture1"
				,$file_to_copy_path="$picture_url_thumb"
				,$file_to_copy_width="35"
				,$file_to_copy_height="35"
				,$adjust = ''
				,$watermark_gif=''
				,$watermark_position='');
			}
		}
		/*----end-----*/
		$menu_pic = $image;
		
		$sub_category_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE id = '".$sub_category_id."'"));
		$sql = "UPDATE restaurant_menu_item set sub_category_id='".$sub_category_id."', menu_name='".$menu_name."', price='".$price."', description='".$description."', last_updated = '".date('Y-m-d H:i:s')."',sub_category_name = '".$sub_category_name['subcategory_name']."'";
		if($menu_pic!=''){
			$sql.=", menu_pic='".$image."'";
		}
		if($size == 'single'){
			$sql.=", size='".$size."', price = '".$menu_price."', price1 = '', price2 = ''";
		}
		if($size == 'multiple'){
			$sql.=", size='".$size."', price = '".$small_price."', price1 = '".$medium_price."', price2 = '".$large_price."'";
		}
		$sql.= " WHERE id = '".$_REQUEST['menu_id']."'";
		//echo $sql; exit;
		mysql_query($sql);
	header("location:spl_admin_restaurant_menu.php?success=1");
}
?>
<script type="text/javascript">
function getkey(e)
{
if (window.event)
return window.event.keyCode;
else if (e)
return e.which;
else
return null;
}
function goodchars(e, goods)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
if (goods.indexOf(keychar) != -1)
return true;
if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
return true;
return false;
}

function getSubcat(catid,id){
	$.ajax({
		url : 'getSubcat.php',
		type : 'POST',
		data : 'catid=' + catid + '&id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("||");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('sub_category'+subCatid).innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}
</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="spl_admin_restaurant_menu.php";
}
</script>
<script type="text/javascript">
function get_size(val,id){
	if(val == 'single'){
		document.getElementById('menu_price_div_single'+id).style.display = 'block';
		document.getElementById('menu_price_div_multiple'+id).style.display = 'none';
	}
	if(val == 'multiple'){
		document.getElementById('menu_price_div_single'+id).style.display = 'none';
		document.getElementById('menu_price_div_multiple'+id).style.display = 'block';
	}
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
    <li><a href="spl_admin_add_restaurant.php">Basic Info</a></li>
    <li><a href="spl_admin_additional.php">Additional Info</a></li>
    <li><a href="spl_admin_restaurant_menu.php" class="active7">Menu</a></li>
    <li><a href="spl_admin_multimedia.php">Multimedia</a></li>
    <li><a href="spl_admin_special_offer.php">Special Offer</a></li>
    <li><a href="spl_admin_confirmation.php">Confirmation</a></li>
</ul>

</div>
<form name="menuform" action="" method="post" enctype="multipart/form-data" >
<div class="restaurant_cont_field">

<div class="restaurant_cont_field_heading">

<h1>Menu Process -</h1>

</div>
<input type="hidden" id="item_id" name="item_id" value="2">
<div class="restaurant_cont_field_item">

<?php /*?><div class="delete_item"><a href="#"><img src="images/delete_item.png" /></a></div><?php */?>

<div class="clear"></div>

</div>

<div class="clear"></div>

<div id="allmenu">

<div id="menu_div1" class="mainmanu" style="padding: 0 5px;">
<input type="hidden" name="countdiv[]" value="1" class="webcampics">
<div class="restaurant_form_field" style="width:470px;">

<div class="clear"></div>

<p>Main Category :</p>
<?php
/*---menu category----*/
$catID="";
$catName="";
$optionDetailscat="";
$sql_cat=sprintf("select * from restaurant_menu_category where 1 order by category_name");
$query_cat=mysql_query($sql_cat);
while($array_cat=mysql_fetch_array($query_cat)){
	$catID = $array_cat['id'];
	if($sql_category['category_id']==$catID)
	{
		$select="selected=selected";
	}
	else{
		$select="";
	}
	$catName = $array_cat['category_name'];
	$optionDetailscat .= "<option value=\"$catID\"".$select.">$catName</option>";
}
/*----end----*/
?>
<select name="main_category1" id="main_category1" class="restaurant_list" onChange="getSubcat(this.value,1);" disabled>
<option value="">--Select Category --</option>
<?php echo $optionDetailscat; ?>
</option>
</select>

<div class="clear"></div>

<p>Sub Category :</p>

<select name="sub_category1" id="sub_category1" class="restaurant_list">

<?php $sql_select = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE category_id = '".$sql_category['category_id']."'");
while($array = mysql_fetch_array($sql_select)) {?>
<option value="<?php echo $array['id']; ?>" <?php if($array['id'] == $sql_category['sub_category_id']){ ?> selected="selected" <?php } ?>><?php echo $array['subcategory_name']; ?></option>
<?php } ?>
</select>

<div class="clear"></div>

<p>Menu Items Name :</p>

<input name="menu_items1" id="menu_items1" type="text" class="restaurant" value="<?php echo $sql_category['menu_name'];?>"/>

<div class="clear"></div>


</div>

<div class="restaurant_form_field">

<p>Choose a size : </p>
<div style="margin-top:10px;">
<input type="radio" name="size1" value="single" onClick="return get_size(this.value,1)" <?php if($sql_category['size'] == 'single'){ ?> checked = "checked" <?php } ?>><span  class="menu_price_class"> Single </span>
<input type="radio" name="size1" value="multiple" onClick="return get_size(this.value,1)" <?php if($sql_category['size'] == 'multiple'){ ?> checked = "checked" <?php } ?>> <span class="menu_price_class"> Multiple </span>
</div>

<div class="clear"></div>

<div style="display:none" id="menu_price_div_single1">
<?php 
if($sql_category['size'] == 'single'){
	$menu_price = $sql_category['price'];
	$small_price = '';
}
else if($sql_category['size'] == 'multiple'){
	$menu_price = '';
	$small_price = $sql_category['price'];
}
?>
<p>Menu Price :</p>
<input type="text" value="$" style="width:20px;" class="restaurant">&nbsp;
<input name="menu_price1" id="menu_price1" type="text" class="restaurant"  style="width:146px;" onKeyPress="return goodchars(event,'1234567890.');" value="<?php echo $menu_price;?>"/>
</div>

<div id="menu_price_div_multiple1" style="display:none;">
<p>Small :</p>
<input type="text" value="$" style="width:20px;" class="restaurant">&nbsp;
<input name="small_price1" id="small_price1" type="text" class="restaurant"  style="width:146px;" onKeyPress="return goodchars(event,'1234567890.');" value="<?php echo $small_price;?>"/>
<div class="clear"></div>

<p>Medium :</p>
<input type="text" value="$" style="width:20px;" class="restaurant">&nbsp;
<input name="medium_price1" id="medium_price1" type="text" class="restaurant"  style="width:146px;" onKeyPress="return goodchars(event,'1234567890.');" value="<?php echo $sql_category['price1'];?>"/>
<div class="clear"></div>

<p>Large :</p>
<input type="text" value="$" style="width:20px;" class="restaurant">&nbsp;
<input name="large_price1" id="large_price1" type="text" class="restaurant"  style="width:146px;" onKeyPress="return goodchars(event,'1234567890.');" value="<?php echo $sql_category['price2'];?>"/>
</div>

<div class="clear"></div>


<p>Menu Description :</p>

<textarea name="menu_description1" id="menu_description1"><?php echo $sql_category['description'];?></textarea>

<div class="clear"></div>

<p>Menu Picture :</p>

<input name="menu_picture1" id="menu_picture1" type="file" class="restaurant_browse" />
<?php if($sql_category['menu_pic']!=''){ ?>
<img src="thumb_images/<?php echo $sql_category['menu_pic']?>" width="60" height="60">
<?php } ?>


</div>
<div class="clear"></div>
</div>
</div>

<div class="clear"></div>


<div class="clear"></div>
<div style="text-align:right;">
<input class="button4" type="submit" value="Edit" name="submit" >
<input type="button" name="cancel" value="Cancel" onClick="cancel_it()" class="button4" style="margin-left:25px;"/>


</div>
</div>
</form>
</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>