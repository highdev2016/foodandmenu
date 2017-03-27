<?php
ob_start();
session_start();
 include("includes/header_vendor.php");?>
<?php include("admin/lib/conn.php");?>
<?php include("image_file.php");?>

<?php $sql_category = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$_REQUEST['menu_id']."'"));?>

<?php if($_REQUEST['action'] == 'delete' && $_REQUEST['spl_id']!=''){
	$sql_delete_spl_instructions = mysql_query("DELETE FROM restaurant_menu_special_instruction WHERE id = '".$_REQUEST['spl_id']."'");
	$sql_delete_spl_sub_instructions = mysql_query("DELETE FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$_REQUEST['spl_id']."'");
	
	header("location:edit_restaurant_menu_item1.php?menu_id=".$_REQUEST['menu_id']."&restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_success=1");
}
?>

<?php if($_REQUEST['action'] == 'delete_option' && $_REQUEST['option_id']!=''){
	$sql_delete_spl_sub_instructions = mysql_query("DELETE FROM restaurant_menu_item_special_instruction WHERE id = '".$_REQUEST['option_id']."'");
	
	header("location:edit_restaurant_menu_item1.php?menu_id=".$_REQUEST['menu_id']."&restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_option_success=1");
}
?>

<body>
<?php include ("includes/menu_res_add_user.php");?>
<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
{
//print_r($_POST['countdiv']);
//print_r($_POST['main_category1']);
//print_r($_POST['sub_category1']);
	
	foreach($_POST['countdiv'] as $countDiv){
		$restaurant_id = $sql_category['restaurant_id'];
		$category_id = $_POST['main_category'.$countDiv];
		$sub_category_id = $_POST['sub_category'.$countDiv];
		$sub_desc = $_POST['sub_desc'.$countDiv];
		$menu_name = $_POST['menu_items'.$countDiv];
		$description = $_POST['menu_description'.$countDiv];
		$menu_price = $_POST['menu_price'.$countDiv];
		$sub_category_description = $_POST['sub_category_description'.$countDiv];
		/*$category_name = $_POST['category_name'.$countDiv];
		$sub_category_name = $_POST['sub_category_name'.$countDiv];*/
		
		/*----image-----*/
		if($_FILES['menu_picture'.$countDiv]['name']!="")
		{
			$image1=$_FILES['menu_picture'.$countDiv]['name'];
			$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
			//$image=time().$image;
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
		
		$sub_category_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE id = '".$sub_category_id."'"));
		$sql = "UPDATE restaurant_menu_item set sub_category_id='".$sub_category_id."' , menu_name='".htmlspecialchars(stripslashes($menu_name),ENT_QUOTES)."', description='".htmlspecialchars(stripslashes($description),ENT_QUOTES)."', last_updated = '".date('Y-m-d H:i:s')."',sub_category_name = '".htmlspecialchars(stripslashes($sub_category_name['subcategory_name']),ENT_QUOTES)."',price = '".$menu_price."', sub_category_description = '".htmlspecialchars(stripslashes($sub_category_description),ENT_QUOTES)."'";
		if($menu_pic!=''){
			$sql.=", menu_pic='".$image."'";
		}
		$sql.= " WHERE id = '".$_REQUEST['menu_id']."'";
		mysql_query($sql);
		
		$sql_select_spl_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$_REQUEST['menu_id']."'");
		$j = 1;
		while($array_select_spl_ins = mysql_fetch_array($sql_select_spl_ins)){
			$sql_update_spl_ins = mysql_query("UPDATE restaurant_menu_special_instruction SET special_instruction = '".$_POST['special_instruction_1_'.$j]."' WHERE id = '".$array_select_spl_ins['id']."'");
			
			$option_id = 1;
			$sql_select_spl_sub_ins = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$array_select_spl_ins['id']."'");
			while($array_spl_sub_ins = mysql_fetch_array($sql_select_spl_sub_ins)){
				$sql_update_spl_sub_ins = mysql_query("UPDATE restaurant_menu_item_special_instruction SET title = '".htmlspecialchars(stripslashes($_REQUEST['spl_title_1_'.$j.'_'.$option_id]),ENT_QUOTES)."' , price = '".$_REQUEST['spl_price_1_'.$j.'_'.$option_id]."' WHERE id = '".$array_spl_sub_ins['id']."'");
			$option_id++;
			}	
			
			foreach($_POST['countdiv_spl_ins_title'] as $countdiv_spl_ins_title){
					$title = $_POST['spl_title_1_'.$j.'_'.$countdiv_spl_ins_title];
					$price = $_POST['spl_price_1_'.$j.'_'.$countdiv_spl_ins_title];
					if($title!='' || $price!=''){
						//echo ("INSERT INTO restaurant_menu_item_special_instruction SET restaurant_id = '".$restaurant_id."' , menu_id = '".$_REQUEST['menu_id']."',special_ins_id = '".$array_select_spl_ins['id']."',title = '".$title."',price = '".$price."'"); exit;
						$sql_sel_spl_ins  = mysql_num_rows(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE restaurant_id = '".$restaurant_id."' AND menu_id = '".$_REQUEST['menu_id']."' AND special_ins_id = '".$array_select_spl_ins['id']."' AND title = '".htmlspecialchars(stripslashes($title),ENT_QUOTES)."' "));
						if($sql_sel_spl_ins == 0){
							$sql_sub_special_instructions = mysql_query("INSERT INTO restaurant_menu_item_special_instruction SET restaurant_id = '".$restaurant_id."' , menu_id = '".$_REQUEST['menu_id']."',special_ins_id = '".$array_select_spl_ins['id']."',title = '".htmlspecialchars(stripslashes($title),ENT_QUOTES)."',price = '".$price."'");
						}
					}
				}
				
			$j++;
		}
		
		foreach($_POST['countdiv_spl_ins'] as $countdiv_spl_ins){
			$special_instruction = $_POST['special_instruction_1_'.$countdiv_spl_ins];
			if($special_instruction!=''){
				$sql_splins = mysql_query("INSERT INTO restaurant_menu_special_instruction SET menu_id = '".$_REQUEST['menu_id']."', restaurant_id = '".$restaurant_id."', special_instruction = '".htmlspecialchars(stripslashes($special_instruction),ENT_QUOTES)."'");
				$special_instructions_id = mysql_insert_id();
			}
			
			foreach($_POST['countdiv_spl_ins_title'] as $countdiv_spl_ins_title){
					$title = $_POST['spl_title_1_'.$countdiv_spl_ins.'_'.$countdiv_spl_ins_title];
					$price = $_POST['spl_price_1_'.$countdiv_spl_ins.'_'.$countdiv_spl_ins_title];
					if($title!='' || $price!=''){
						$sql_sub_special_instructions = mysql_query("INSERT INTO restaurant_menu_item_special_instruction SET restaurant_id = '".$restaurant_id."' , menu_id = '".$_REQUEST['menu_id']."',special_ins_id = '".$special_instructions_id."',title = '".htmlspecialchars(stripslashes($title),ENT_QUOTES)."',price = '".$price."'");
					}
				}
		}
	}
	header("location:edit_restaurant_menu_item1.php?menu_id=".$_REQUEST['menu_id']."&restaurant_edit_id=".$restaurant_id."&success=1");
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

function add_special_ins(id,spl_ins){
	//alert(id);
	$.ajax({
		url : 'spl_ins_item_id.php',
		type : 'POST',
		data : 'id=' + id + '&menu_id=' + spl_ins,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'spl_div_' + id;
			menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('splallmenu_1').appendChild(menuDiv);
			document.getElementById('spl_ins_item_id').value=parseInt(id)+1;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus').focus();
}

function remove_spl_div(delId)
{
	var div = document.getElementById("spl_div_" + delId);
	div.parentNode.removeChild(div);
}

function add_special_ins_title(id,special_ins_id,menu_id){
	//alert(id);
	//alert(special_ins_id);
	$.ajax({
		url : 'add_special_ins_title.php',
		type : 'POST',
		data : 'id=' + id + '&special_ins_id=' + special_ins_id + '&menu_id=' + menu_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'spl_titlediv_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('spl_div_'+special_ins_id).appendChild(menuDiv);
			document.getElementById('spl_ins_title').value=parseInt(id)+1;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus').focus();
}

function remove_spl_title_div(delId)
{
	var div = document.getElementById("spl_titlediv_" + delId);
	div.parentNode.removeChild(div);
}

function get_sub_desc(id){
	$.ajax({
		url : 'get_sub_category_description.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			$('#sub_cat_desc_div').html(data);
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
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
        <li><a href="special_offer.php">Special Offer</a></li>
        <li><a href="confirmation.php">Confirmation</a></li>
    </ul>
</div>
<form name="menuform" action="" method="post" enctype="multipart/form-data" >

<div class="restaurant_cont_field">

<?php if($_REQUEST['success'] == 1){?>
<p style="text-align:center;">Menu item edited successfully. </p>
<?php } ?>

<?php if($_REQUEST['del_success'] == 1){?>
<p style="text-align:center;">Special instruction deleted successfully. </p>
<?php } ?>
<?php if($_REQUEST['del_option_success'] == 1){?>
<p style="text-align:center;">Option deleted successfully. </p>
<?php } ?>


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

<?php /*?><input name="category_name1" id="category_name1" type="text" class="restaurant" value="<?php echo $sql_category['category_name']; ?>" /><?php */?>

<div class="clear"></div>

<p>Sub Category :</p>

<?php /*?><input name="sub_category_name1" id="sub_category_name1" type="text" class="restaurant" value="<?php echo $sql_category['sub_category_name']; ?>" /><?php */?>

<select name="sub_category1" id="sub_category1" class="restaurant_list" onChange="get_sub_desc(this.value);">

<?php $sql_select = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE category_id = '".$sql_category['category_id']."'");
while($array = mysql_fetch_array($sql_select)) {?>
<option value="<?php echo $array['id']; ?>" <?php if($array['id'] == $sql_category['sub_category_id']){ ?> selected="selected" <?php } ?>><?php echo $array['subcategory_name']; ?></option>
<?php } ?>
</select>

<div class="clear"></div>

<p>Sub Category Description :</p>
<div id="sub_cat_desc_div">
<textarea name="sub_category_description1" id="sub_category_description1" rows="3" cols="25" style="border:1px solid #B5ABC6; margin-top:10px;"><?php echo $sql_category['sub_category_description'];?></textarea></div>

<div class="clear"></div>

<p>Menu Items Name :</p>

<input name="menu_items1" id="menu_items1" type="text" class="restaurant" value="<?php echo $sql_category['menu_name'];?>"/>

<div class="clear"></div>

<p>Menu Price :</p>
<input name="menu_price1" id="menu_price1" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" value="<?php echo $sql_category['price'];?>"/>

<div class="clear"></div>

<p>Menu Description :</p>

<textarea name="menu_description1" id="menu_description1" style="margin-top:10px; border:1px solid #B5ABC6; " rows="3" cols="25"><?php echo $sql_category['description'];?></textarea>

<div class="clear"></div>

<p>Menu Picture :</p>

<input name="menu_picture1" id="menu_picture1" type="file" class="restaurant_browse" />
<?php if($sql_category['menu_pic']!=''){?>
<img src="thumb_images/<?php echo $sql_category['menu_pic']?>" width="60" height="60">
<?php } else { ?>
<img src="images/no_image.png" width="60" height="60">
<?php } ?>

<div class="clear"></div>

</div>

<div class="restaurant_form_field">
<?php $sql_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$_REQUEST['menu_id']."'");
$num_rows = mysql_num_rows($sql_ins);

$sql_sub_ins = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE menu_id = '".$_REQUEST['menu_id']."'");
$subins_num_rows = mysql_num_rows($sql_sub_ins); ?>
<input type="hidden" id="spl_ins_item_id" name="spl_ins_item_id" value="<?php echo ($num_rows+1); ?>">
<input type="hidden" id="spl_ins_title" name="spl_ins_title" value="<?php echo ($subins_num_rows+1); ?>">
<p><a href="javascript:void(0);" onClick="add_special_ins(document.getElementById('spl_ins_item_id').value,'1')" style="color:#F07200; font-size:16px;">Add Special Instruction</a></p>
<div class="clear"></div>

<?php 
$id = 1;
$sql_special_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$_REQUEST['menu_id']."'");
while($array_special_ins = mysql_fetch_array($sql_special_ins)){?>
<div id="spl_div_<?php echo $id; ?>" class="mainmanu">
<div class="cross_bt" style="margin-left:440px;">
<a href="edit_restaurant_menu_item.php?menu_id=<?php echo $_REQUEST['menu_id']; ?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&spl_id=<?php echo $array_special_ins['id']; ?>&action=delete" >
<img  src="images/Close_Box_Red.png">
</a>
</div>
<p style="width:150px;">Special Instruction :</p>
<input name="special_instruction_1_<?php echo $id; ?>" id="special_instruction_1_<?php echo $id; ?>" type="text" class="restaurant" value="<?php echo $array_special_ins['special_instruction']; ?>" />
<span><a href="javascript:void(0);" onClick="add_special_ins_title(document.getElementById('spl_ins_title').value,'<?php echo $id; ?>','1')" style="color:#F07200">Add Option</a></span>
<div class="clear"></div>

<?php 
$sp_id = 1;
$sql_select_subins = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$array_special_ins['id']."'");
while($array_select_subins = mysql_fetch_array($sql_select_subins)){ ?>
<div style="border-bottom:1px dashed #787878; width:460px;"></div>

<div class="cross_bt" style="margin-left:440px;">
<a href="edit_restaurant_menu_item.php?menu_id=<?php echo $_REQUEST['menu_id']; ?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&option_id=<?php echo $array_select_subins['id']; ?>&action=delete_option">
<img  src="images/Close_Box_Red.png">
</a>
</div>

<p style="width:150px;">Title :</p>
<input name="spl_title_1_<?php echo $id; ?>_<?php echo $sp_id; ?>" id="spl_title_1_<?php echo $id; ?>_<?php echo $sp_id; ?>" type="text" class="restaurant" value="<?php echo $array_select_subins['title']; ?>" />
<div class="clear"></div>

<p style="width:150px;">Price :</p>
<input name="spl_price_1_<?php echo $id; ?>_<?php echo $sp_id; ?>" id="spl_price_1_<?php echo $id; ?>_<?php echo $sp_id; ?>" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" value="<?php echo $array_select_subins['price']; ?>" />
<div class="clear"></div>
<?php $sp_id++; } ?>

</div>

<?php $id++; } ?>

<div id="splallmenu_1">
</div>

</div>

<div class="clear"></div>
</div>
</div>

<div class="clear"></div>


<div class="clear"></div>
<div style="text-align:right;">

<input class="button4" type="submit" value="Edit" name="submit" >
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