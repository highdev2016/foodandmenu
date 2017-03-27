<?php
ob_start();
session_start();
 include("includes/header_vendor.php");?>
<?php include("admin/lib/conn.php");?>
<?php include("image_file.php");?>


<body>
<?php include("includes/top_search.php");?>
<?php include("includes/menu_section.php");?>
<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
//print_r($_POST['countdiv']);
//print_r($_POST['main_category1']);
//print_r($_POST['sub_category1']);
	
	foreach($_POST['countdiv'] as $countDiv){
		$restaurant_id = $_SESSION['rest_id'];
		$category_id = $_POST['main_category'.$countDiv];
		$sub_category_id = $_POST['sub_category'.$countDiv];
		$menu_name = $_POST['menu_items'.$countDiv];
		$price = $_POST['menu_price'.$countDiv];
		$description = $_POST['menu_description'.$countDiv];
		
		/*----image-----*/
		if($_FILES['menu_picture'.$countDiv]['name']!="")
		{
			$image=$_FILES['menu_picture'.$countDiv]['name'];
			$image=time().$image;
			if ((($_FILES["menu_picture".$countDiv]["type"] == "image/gif")
			|| ($_FILES["menu_picture".$countDiv]["type"] == "image/png")
			|| ($_FILES["menu_picture".$countDiv]["type"] == "image/bmp")
			|| ($_FILES["menu_picture".$countDiv]["type"] == "image/jpg")
			|| ($_FILES["menu_picture".$countDiv]["type"] == "image/jpeg")
			|| ($_FILES["menu_picture".$countDiv]["type"] == "image/pjpeg")))
			{
				$picture_url="uploaded_images/".$image;
				LIB_StoreUploadImg($post_file_name="menu_picture".$countDiv
				,$file_to_copy_path="$picture_url"
				,$file_to_copy_width="800"
				,$file_to_copy_height="600"
				,$adjust = ''
				,$watermark_gif=''
				,$watermark_position='');
				
				$picture_url_thumb="thumb_images/".$image;
				LIB_StoreUploadImg($post_file_name="menu_picture".$countDiv
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
		
		$sql = "insert into restaurant_menu_item set restaurant_id='".$restaurant_id."', category_id='".$category_id."', sub_category_id='".$sub_category_id."', menu_name='".$menu_name."', price='".$price."', description='".$description."', menu_pic='".$menu_pic."'";
		mysql_query($sql);
	}
	header("location:multimedia.php");
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

function validate()
{
	var error = [];
	var items = [];
	
	$('.webcampics').each(function(){
		items.push($(this).attr('value'));
	});
	
	for(var i in items){
		if($('select[name=main_category' + items[i] + ']').val() == ''){
			error.push({
				'item_id' : 'main_category' + items[i],
				'message' : 'Main category is required field',
			});
		}
		if($('select[name=sub_category' + items[i] + ']').val() == ''){
			error.push({
				'item_id' : 'sub_category' + items[i],
				'message' : 'Sub category is required field',
			});
		}
		if($('input[name=menu_items' + items[i] + ']').val() == ''){
			error.push({
				'item_id' : 'menu_items' + items[i],
				'message' : 'Menu item is required field',
			});
		}
		if($('input[name=menu_price' + items[i] + ']').val() == ''){
			error.push({
				'item_id' : 'menu_price' + items[i],
				'message' : 'Menu price is required field',
			});
		}
		if($('textarea[name=menu_description' + items[i] + ']').val() == ''){
			error.push({
				'item_id' : 'menu_description' + items[i],
				'message' : 'Menu description is required field',
			});
		}
		if($('input[name=menu_picture' + items[i] + ']').val() == ''){
			error.push({
				'item_id' : 'menu_picture' + items[i],
				'message' : 'Menu picture is required field',
			});
		}
	}
	
	if(error.length > 0){
		/*for(var e = 0; e < error.length; e++){
			$('#' + error[e].item_id).focus();
		}*/
		var e = 0;
		alert(error[e].message);
		$('#' + error[e].item_id).focus();
		return false;
	}
	//return false;
}

function add_cell(id){
	$.ajax({
		url : 'additem.php',
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
			var menuDivid = menuDiv.id = 'menu_div_' + id;
			menuDiv.setAttribute("class","mainmanu");
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
}

function remove_div(delId)
{
	var div = document.getElementById("menu_div_" + delId);
	div.parentNode.removeChild(div);
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
                    <li><a href="add_restaurant.php">Basic Info</a></li>
                    <li><a href="additional.php">Additional Info</a></li>
                    <li><a href="restaurant_menu.php" class="active7">Menu</a></li>
                    <li><a href="multimedia.php">Multimedia</a></li>
                    <li><a href="confirmation.php">Confirmation</a></li>
                    <li><a href="specialoffer.php">Special Offer</a></li>
                    
                    
                    </ul>
                    
                    </div>
<form name="menuform" action="" method="post" enctype="multipart/form-data" >
<div class="restaurant_cont_field">

<div class="restaurant_cont_field_heading">

<h1>Menu Process -</h1>

</div>
<input type="hidden" id="item_id" name="item_id" value="2">
<div class="restaurant_cont_field_item">

<div class="add_item" style="float:right;"><a href="javascript:void(0);" onClick="add_cell(document.getElementById('item_id').value)"><img src="images/add_item.png" /></a></div>

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
	$catName = $array_cat['category_name'];
	$optionDetailscat .= "<option value=\"$catID\">$catName</option>";
}
/*----end----*/
?>
<select name="main_category1" id="main_category1" class="restaurant_list" onChange="getSubcat(this.value,1);">
<option value="">--Select Category --</option>
	<?php echo $optionDetailscat; ?>
</option>
</select>

<div class="clear"></div>

<p>Sub Category :</p>

<select name="sub_category1" id="sub_category1" class="restaurant_list">
<option value="">--Select Category --</option>
</select>

<div class="clear"></div>

<p>Menu Items Name :</p>

<input name="menu_items1" id="menu_items1" type="text" class="restaurant" />

<div class="clear"></div>


</div>

<div class="restaurant_form_field">

<p>Menu Price :</p>

<input name="menu_price1" id="menu_price1" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890');" />

<div class="clear"></div>


<p>Menu Description :</p>

<textarea name="menu_description1" id="menu_description1"></textarea>

<div class="clear"></div>

<p>Menu Picture :</p>

<input name="menu_picture1" id="menu_picture1" type="file" class="restaurant_browse" />


</div>
<div class="clear"></div>
</div>
</div>

<div class="clear"></div>


<div class="clear"></div>
<div style="text-align:right;">

<input class="button4" type="submit" value="Save & Continue" name="submit" >
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