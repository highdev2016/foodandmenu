<?php
ob_start();
session_start();
 include("includes/header_vendor.php");?>
<?php include("admin/lib/conn.php");?>
<?php include("image_file.php");?>

<?php //echo $_SESSION['restaurant_id']; ?>
<body>
<?php include ("includes/menu_adminaddres.php");?>

<?php
$restaurant_id = $_SESSION['restid'];
if($_REQUEST['sub_button'] == "Copy Menu")
{
	$res_id_menu_update = $restaurant_id;
	
	$sel_res_id = $_REQUEST['check_box'];
	
	foreach($sel_res_id as $sel_id)
	{
		$sql_sel_menu_item_get = mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$sel_id."'");
		
		while($sql_sel_menu_item = mysql_fetch_array($sql_sel_menu_item_get))
		{
			$sql_ins_menu_item = mysql_query("INSERT INTO restaurant_menu_item SET restaurant_id = '".$restaurant_id."' , category_id = '".$sql_sel_menu_item['category_id']."' , sub_category_id = '".$sql_sel_menu_item['sub_category_id']."' , menu_name = '".$sql_sel_menu_item['menu_name']."' , price = '".$sql_sel_menu_item['price']."' , description = '".$sql_sel_menu_item['description']."' , menu_pic = '".$sql_sel_menu_item['menu_pic']."' , status = '".$sql_sel_menu_item['status']."' , last_updated = NOW() , category_name = '".$sql_sel_menu_item['category_name']."' , sub_category_name = '".$sql_sel_menu_item['sub_category_name']."' , sub_category_description = '".$sql_sel_menu_item['sub_category_description']."'");
			$last_id_menu_item = mysql_insert_id();
		
		$sql_sel_restaurant_menu_special_instruction_get = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$sql_sel_menu_item['id']."'");
		
		while($sql_sel_restaurant_menu_special_instruction = mysql_fetch_array($sql_sel_restaurant_menu_special_instruction_get))
		{
			$sql_ins_restaurant_menu_special_instruction = mysql_query("INSERT INTO restaurant_menu_special_instruction SET restaurant_id = '".$restaurant_id."' , menu_id = '".$last_id_menu_item."' , special_instruction = '".$sql_sel_restaurant_menu_special_instruction['special_instruction']."'");
			$last_id_restaurant_menu_special_instruction = mysql_insert_id();
			
			$sql_sel_restaurant_menu_item_special_instruction_get = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$sql_sel_restaurant_menu_special_instruction['id']."'");
		
			while($sql_sel_restaurant_menu_item_special_instruction = mysql_fetch_array($sql_sel_restaurant_menu_item_special_instruction_get))
			{
				$sql_ins_restaurant_menu_item_special_instruction = mysql_query("INSERT INTO restaurant_menu_item_special_instruction SET restaurant_id = '".$restaurant_id."' , menu_id = '".$last_id_menu_item."' , special_ins_id = '".$last_id_restaurant_menu_special_instruction."' , title = '".$sql_ins_restaurant_menu_item_special_instruction['title']."' , price = '".$sql_ins_restaurant_menu_item_special_instruction['price']."'");
			}
		}
		
	  }	
	}
	header("location:edit_restaurant_menu.php?restaurant_edit_id=".$res_id_menu_update."&success=3");
}

?>

<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
//print_r($_POST['countdiv']);
//print_r($_POST['main_category1']);
//print_r($_POST['sub_category1']);
	
	foreach($_POST['countdiv'] as $countDiv){
		
		$category_id = $_POST['main_category'.$countDiv];
		$sub_category_id = $_POST['sub_category'.$countDiv];
		$sub_desc = $_POST['sub_desc'.$countDiv];
		$menu_name = $_POST['menu_items'.$countDiv];
		$description = $_POST['menu_description'.$countDiv];
		$price = $_POST['menu_price'.$countDiv];
		$sub_category_description = $_POST['sub_category_description'.$countDiv];
	/*	$category_name = $_POST['category_name'.$countDiv];
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
		
		$category_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_category WHERE id = '".$category_id."'"));
		$sub_category_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE id = '".$sub_category_id."'"));
		if($category_id!="")
		{
			
			$sql = "insert into restaurant_menu_item set restaurant_id='".$restaurant_id."', category_id='".$category_id."', sub_category_id='".$sub_category_id."',menu_name='".htmlspecialchars(stripslashes($menu_name),ENT_QUOTES)."', price='".$price."', description='".htmlspecialchars(stripslashes($description),ENT_QUOTES)."', menu_pic='".$menu_pic."', last_updated = '".date('Y-m-d H:i:s')."',category_name = '".htmlspecialchars(stripslashes($category_name['category_name']),ENT_QUOTES)."',sub_category_name = '".htmlspecialchars(stripslashes($sub_category_name['subcategory_name']),ENT_QUOTES)."',status = 1,sub_category_description = '".htmlspecialchars(stripslashes($sub_category_description),ENT_QUOTES)."'";
			mysql_query($sql);
			$id =  mysql_insert_id();
		
			foreach($_POST['countdiv_spl_ins'] as $countdiv_spl_ins){
				$special_instruction = $_POST['special_instruction_'.$countDiv.'_'.$countdiv_spl_ins];
				if($special_instruction!=''){
					$sql_special_instructions = mysql_query("INSERT INTO restaurant_menu_special_instruction SET restaurant_id = '".$restaurant_id."', menu_id = '".$id."',special_instruction = '".htmlspecialchars(stripslashes($special_instruction),ENT_QUOTES)."'");
					$special_instructions_id = mysql_insert_id();
				}
				
				foreach($_POST['countdiv_spl_ins_title'] as $countdiv_spl_ins_title){
					$title = $_POST['spl_title_'.$countDiv.'_'.$countdiv_spl_ins.'_'.$countdiv_spl_ins_title];
					$price = $_POST['spl_price_'.$countDiv.'_'.$countdiv_spl_ins.'_'.$countdiv_spl_ins_title];
					if($title!='' || $price!=''){
						$sql_sel_spl_ins  = mysql_num_rows(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE restaurant_id = '".$restaurant_id."' AND menu_id = '".$id."' AND special_ins_id = '".$special_instructions_id."' AND title = '".htmlspecialchars(stripslashes($title),ENT_QUOTES)."' "));
						if($sql_sel_spl_ins == 0){
							$sql_sub_special_instructions = mysql_query("INSERT INTO restaurant_menu_item_special_instruction SET restaurant_id = '".$restaurant_id."' , menu_id = '".$id."',special_ins_id = '".$special_instructions_id."',title = '".htmlspecialchars(stripslashes($title),ENT_QUOTES)."',price = '".$price."'");
						}
					}
				}
			}
			
		
		
		}
	}
	header("location:multimedia_admin.php");
}
?>

<script type="text/javascript">
function open_res_sel_div()
{
	$("#res_sel_div").show();
	$("#fade1").show();
}

function close_res_sel_div()
{
	$("#res_sel_div").hide();
	$("#fade1").hide();
}

function sel_res_id_func(id)
{
	$("#loader_div").show();
	$.ajax({
		url : 'sel_res_menu_by_res.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			$("#ajax_menu_div").html(data);
			$("#loader_div").hide();
			$("#res_sel_div").hide();
			$("#fade1").hide();
			$("#menu_sel_div").show();
			$("#fade1").show();
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
	
}

function close_menu_sel_div()
{
	$("#menu_sel_div").hide();
	$("#fade1").hide();
}

</script>

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
	document.getElementById('item_focus').focus();
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
			document.getElementById('splallmenu_'+spl_ins).appendChild(menuDiv);
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
	/*alert(id);
	alert(special_ins_id);*/
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

function get_sub_desc(id, inc){
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
			$('#sub_cat_desc_div'+inc).html(data);
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
        <li><a href="add_restaurant_admin.php">Basic Info</a></li>
        <li><a href="additional_admin.php">Additional Info</a></li>
        <li><a href="restaurant_menu_admin.php" class="active7">Menu</a></li>
        <li><a href="multimedia_admin.php">Multimedia</a></li>
        <li><a href="special_offer_admin.php">Special Offer</a></li>
        <li><a href="confirmation_admin.php">Confirmation</a></li>
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

<?php /*?><input name="category_name1" id="category_name1" type="text" class="restaurant" /><?php */?>

<div class="clear"></div>

<p>Sub Category :</p>

<select name="sub_category1" id="sub_category1" class="restaurant_list" onChange="get_sub_desc(this.value, 1);">
<option value="">--Select Category --</option>
</select>

<?php /*?><input name="sub_category_name1" id="sub_category_name1" type="text" class="restaurant" /><?php */?>

<div class="clear"></div>

<p>Sub Category Description :</p>
<div id="sub_cat_desc_div1">
<textarea name="sub_category_description1" id="sub_category_description1" rows="3" cols="25" style="border:1px solid #B5ABC6; margin-top:10px;"></textarea></div>

<div class="clear"></div>

<p>Menu Items Name :</p>

<input name="menu_items1" id="menu_items1" type="text" class="restaurant" />

<div class="clear"></div>

<p>Menu Price :</p>
<input name="menu_price1" id="menu_price1" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<p>Menu Description :</p>

<textarea name="menu_description1" id="menu_description1" rows="3" cols="25" style="border:1px solid #B5ABC6; margin-top:10px;"></textarea>

<div class="clear"></div>

<p>Menu Picture :</p>

<input name="menu_picture1" id="menu_picture1" type="file" class="restaurant_browse" />

<div class="clear"></div>

</div>

<div class="restaurant_form_field">

<p style="width:100%;"><a href="javascript:void(0);" onClick="open_res_sel_div();" style="color:#F07200; font-size:16px;">Copy Menu from Other Restaurant</a></p>
<br>

<div id="res_sel_div" style="display:none;" class="assign_item white_content"  >

<div class="close close-new" onClick="close_res_sel_div();"><a href = "javascript:void(0);"> </a> </div>
<h2 class="up_nw_load_nw restudnt">Select Restaurant
    <div id="loader_div" class="center-loder" style="display:none;"><img src="images/ajax-loader-review.gif" /></div>
</h2>

<div class="l-contnt up-contnt"> 
<form name="submit_quote" id="submit_quote" action="#" method="post" class="form-horizontal">
<ul class="restu_list">
<?php
    
    $get_all_res = mysql_query("SELECT * FROM restaurant_basic_info WHERE id != '".$restaurant_id."' ORDER BY restaurant_name ASC");
    
     $res_cnt = 1;
     while($all_res_name = mysql_fetch_array($get_all_res))
     {
         ?><li><span><?php echo $res_cnt."."; ?></span><a href="javascript:void(0);" onClick="sel_res_id_func(<?php echo $all_res_name['id'] ?>);"><?php echo stripslashes($all_res_name['restaurant_name']); ?></a></li><?php
         $res_cnt++;
     }

?>
</ul>
</form>
</div>
</div>
<div id="fade1" class="black_overlay"> </div>

<div id="menu_sel_div" style="display:none;" class="assign_item white_content"  >

<div class="close close-new" onClick="close_menu_sel_div();"><a href = "javascript:void(0);"> </a> </div>

<h2 class="up_nw_load_nw restudnt">Select Menu</h2>
<div class="l-contnt l-contnt-new up-contnt"> 
<form name="submit_menu" id="submit_menu" action="" method="post" class="form-horizontal" onSubmit="return check_empty();">


<ul class="restu_list" id="ajax_menu_div">      </ul>

</form>
</div>
</div>

<input type="hidden" id="spl_ins_item_id" name="spl_ins_item_id" value="1">
<p><a href="javascript:void(0);" onClick="add_special_ins(document.getElementById('spl_ins_item_id').value,'1')" style="color:#F07200; font-size:16px;">Add Special Instruction</a></p>

<div class="clear"></div>

<div id="splallmenu_1">
</div>







</div>
<div class="clear"></div>
</div>
</div>

<div class="clear"></div>


<div class="clear"></div>
<!--<div style="text-align:right;">

<input class="button4" type="submit" value="Save & Continue" name="submit" >
</div>-->
<div >
<div class="add_item" style="float:left;"><a href="javascript:void(0);" onClick="add_cell(document.getElementById('item_id').value)" id="item_focus"><img src="images/add_item.png"  style="margin-left:0;"/></a></div>
<div  style="float:right;">
<input class="button4" type="submit" value="Save & Continue" name="submit"  style="margin-top:0;"></div>

<div class="clear"></div>
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