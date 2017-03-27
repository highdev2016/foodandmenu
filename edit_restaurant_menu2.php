<?php

ob_start();

session_start();

 include("includes/header_vendor.php");?>

<?php include("admin/lib/conn.php");?>

<?php include("image_file.php");?>

<body>

<?php include ("includes/menu_admin_edit_res.php");?>

<?php 
if($_REQUEST['submit_category'] == 'Create'){
	$sql_sel_category = (mysql_query("SELECT * FROM restaurant_menu_category WHERE category_name = '".($_REQUEST['restaurant_category'])."'"));
	if(mysql_num_rows($sql_sel_category) == '0'){
		$sql_insert_category = mysql_query("INSERT INTO restaurant_menu_category SET restaurant_id = '".$_REQUEST['restaurant_edit_id']."', category_name = '".$_REQUEST['restaurant_category']."'");
		header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&catsuccess=1&popup=1");
	}else{
		$array_category = mysql_fetch_array($sql_sel_category);
		$restaurant_str = $array_category['restaurant_id'];
		$restaurant_arr = explode(",",$restaurant_str);
		
		if(in_array($_REQUEST['restaurant_edit_id'],$restaurant_arr)){
			header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&caterror=1&popup=1");
			
		}else{
			$sql_update_category = mysql_query("UPDATE restaurant_menu_category SET restaurant_id = '".$restaurant_str.",".$_REQUEST['restaurant_edit_id']."' WHERE category_name = '".($_REQUEST['restaurant_category'])."'");
			header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&catsuccess=1&popup=1");
		}
		
	}
}

if($_REQUEST['submit_subcategory'] == 'Add'){
	$sql_sel_subcategory = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND category_id = '".$_REQUEST['main_category']."' AND subcategory_name = '".$_REQUEST['sub_category']."' ");

	$sub_cat_num_rows = mysql_num_rows($sql_sel_subcategory);
	
	$sql_show_order = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND category_id = '".$_REQUEST['main_category']."' ORDER BY show_order DESC LIMIT 0 ,1 "));
	if($sub_cat_num_rows == '0'){
		$sql_insert_subcategory = mysql_query("INSERT INTO restaurant_menu_subcategory SET category_id = '".$_REQUEST['main_category']."' , restaurant_id = '".$_REQUEST['restaurant_edit_id']."' , subcategory_name = '".$_REQUEST['sub_category']."' , subcategory_desc = '".$_REQUEST['subcategory_description']."' , show_order = '".($sql_show_order['show_order']+1)."'");
		header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&subcatsuccess=1&popup=1");
	}else{
		header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&subcaterror=1&popup=1");
	}
	
}

if($_REQUEST['del_subcat'] == '1')
{
	$delete = mysql_query("DELETE FROM restaurant_menu_subcategory WHERE id = '".$_REQUEST['del_id']."'");
	header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&subcatdel=1&popup=1&dlt=".$_REQUEST['dlt']."");
}

if($_REQUEST['edit_subcat'] == '1')
{
	$select_subcat = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE id = '".$_REQUEST['edit_id']."'"));
}

if($_REQUEST['submit_subcategory_edit'] == 'Edit')
{
	$check_dup = mysql_num_rows(mysql_query("SELECT id FROM restaurant_menu_subcategory WHERE category_id = '".$_REQUEST['main_category']."' AND  subcategory_name = '".$_REQUEST['sub_category']."' AND id != '".$_REQUEST['edit_id']."'"));
	if($check_dup == 0)
	{
		$sql_insert_subcategory = mysql_query("UPDATE restaurant_menu_subcategory SET category_id = '".$_REQUEST['main_category']."' , restaurant_id = '".$_REQUEST['restaurant_edit_id']."' , subcategory_name = '".$_REQUEST['sub_category']."' , subcategory_desc = '".$_REQUEST['subcategory_description']."' WHERE id = '".$_REQUEST['edit_id']."'");
		header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&subedit_success=1&popup=1&edt=".$_REQUEST['edt']."");
	}
	else
	{
		header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&subedit_error=1&popup=1&edt=".$_REQUEST['edt']."");
	}
	
}

if($_REQUEST['del_item'] == '1')
{
	$delete = mysql_query("DELETE FROM restaurant_menu_special_instruction WHERE id = '".$_REQUEST['del_item_id']."'");
	header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&itemdel=1");
}


if($_REQUEST['sub_button'] == "Copy Menu")
{

	$res_id_menu_update = $_REQUEST['restaurant_edit_id'];

	

	$sel_res_id = $_REQUEST['check_box'];

	

	foreach($sel_res_id as $sel_id)

	{

		$sql_sel_menu_item_get = mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$sel_id."'");

		

		while($sql_sel_menu_item = mysql_fetch_array($sql_sel_menu_item_get))

		{

			$sql_ins_menu_item = mysql_query("INSERT INTO restaurant_menu_item SET restaurant_id = '".$_REQUEST['restaurant_edit_id']."' , category_id = '".$sql_sel_menu_item['category_id']."' , sub_category_id = '".$sql_sel_menu_item['sub_category_id']."' , menu_name = '".$sql_sel_menu_item['menu_name']."' , price = '".$sql_sel_menu_item['price']."' , description = '".$sql_sel_menu_item['description']."' , menu_pic = '".$sql_sel_menu_item['menu_pic']."' , status = '".$sql_sel_menu_item['status']."' , last_updated = NOW() , category_name = '".$sql_sel_menu_item['category_name']."' , sub_category_name = '".$sql_sel_menu_item['sub_category_name']."' , sub_category_description = '".$sql_sel_menu_item['sub_category_description']."'");

			$last_id_menu_item = mysql_insert_id();

		

		$sql_sel_restaurant_menu_special_instruction_get = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$sql_sel_menu_item['id']."'");

		

		while($sql_sel_restaurant_menu_special_instruction = mysql_fetch_array($sql_sel_restaurant_menu_special_instruction_get))

		{

			$sql_ins_restaurant_menu_special_instruction = mysql_query("INSERT INTO restaurant_menu_special_instruction SET restaurant_id = '".$_REQUEST['restaurant_edit_id']."' , menu_id = '".$last_id_menu_item."' , special_instruction = '".$sql_sel_restaurant_menu_special_instruction['special_instruction']."'");

			$last_id_restaurant_menu_special_instruction = mysql_insert_id();

			

			$sql_sel_restaurant_menu_item_special_instruction_get = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$sql_sel_restaurant_menu_special_instruction['id']."'");

		

			while($sql_sel_restaurant_menu_item_special_instruction = mysql_fetch_array($sql_sel_restaurant_menu_item_special_instruction_get))

			{

				$sql_ins_restaurant_menu_item_special_instruction = mysql_query("INSERT INTO restaurant_menu_item_special_instruction SET restaurant_id = '".$_REQUEST['restaurant_edit_id']."' , menu_id = '".$last_id_menu_item."' , special_ins_id = '".$last_id_restaurant_menu_special_instruction."' , title = '".$sql_ins_restaurant_menu_item_special_instruction['title']."' , price = '".$sql_ins_restaurant_menu_item_special_instruction['price']."'");

			}

		}

		

	  }	

	}

	header("location:edit_restaurant_menu.php?restaurant_edit_id=".$res_id_menu_update."&success=3");

}

if($_REQUEST['submit'] == 'Save & Continue'){
	$restaurant_id = $_REQUEST['restaurant_edit_id'];
	
	
	foreach($_POST['countmainmenudiv'] as $countDiv){
		$menu_main_category    = $_POST['menu_main_category'.$countDiv];
		$menu_sub_category     = $_POST['menu_sub_category'.$countDiv];
		
		foreach($_POST['countmenudiv'] as $countmenudiv){
			$menu_item_name    = $_POST['menu_item_name_'.$countDiv.'_'.$countmenudiv.''];
			$menu_item_price    = $_POST['menu_item_price_'.$countDiv.'_'.$countmenudiv.''];
			$menu_item_description    = $_POST['menu_item_description_'.$countDiv.'_'.$countmenudiv.''];
			
			if($_FILES['menu_item_picture_'.$countDiv.'_'.$countmenudiv.'']['name']!="")
			{
				$image1=$_FILES['menu_item_picture_'.$countDiv.'_'.$countmenudiv.'']['name'];
				$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
				//$image=time().$image;
				if ((($_FILES['menu_item_picture_'.$countDiv.'_'.$countmenudiv.'']["type"] == "image/gif")
				|| ($_FILES['menu_item_picture_'.$countDiv.'_'.$countmenudiv.'']["type"] == "image/png")
				|| ($_FILES['menu_item_picture_'.$countDiv.'_'.$countmenudiv.'']["type"] == "image/bmp")
				|| ($_FILES['menu_item_picture_'.$countDiv.'_'.$countmenudiv.'']["type"] == "image/jpg")
				|| ($_FILES['menu_item_picture_'.$countDiv.'_'.$countmenudiv.'']["type"] == "image/jpeg")
				|| ($_FILES['menu_item_picture_'.$countDiv.'_'.$countmenudiv.'']["type"] == "image/pjpeg")))
				{
	
					$picture_url="uploaded_images/".$image;
					LIB_StoreUploadImg($post_file_name="menu_item_picture_".$countDiv
					,$file_to_copy_path="$picture_url"
					,$file_to_copy_width="800"
					,$file_to_copy_height="600"
					,$adjust = ''
					,$watermark_gif=''
					,$watermark_position='');
					$picture_url_thumb="thumb_images/".$image;
	
					LIB_StoreUploadImg($post_file_name="menu_item_picture_".$countDiv
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
			
			$cat_id = mysql_fetch_array(mysql_query("SELECT category_name FROM restaurant_menu_category WHERE id = '".$menu_main_category."'"));
			
			$subcat_id = mysql_fetch_array(mysql_query("SELECT subcategory_name,subcategory_desc FROM restaurant_menu_subcategory WHERE id = '".$menu_sub_category."'"));
			
			$sql_show_order = mysql_fetch_array(mysql_query("SELECT show_order FROM restaurant_menu_item WHERE restaurant_id='".$restaurant_id."' AND category_id = '".$menu_main_category."' AND sub_category_id = '".$menu_sub_category."' ORDER BY id DESC LIMIT 0,1"));
			
			if($menu_main_category!='' && $menu_item_name){
				$sql = "insert into restaurant_menu_item set restaurant_id='".$restaurant_id."', menu_name='".htmlspecialchars(stripslashes($menu_item_name),ENT_QUOTES)."', price='".$menu_item_price."', description='".htmlspecialchars(stripslashes($menu_item_description),ENT_QUOTES)."', menu_pic='".$menu_pic."', last_updated = '".date('Y-m-d H:i:s')."',category_name = '".htmlspecialchars(stripslashes($cat_id['category_name']),ENT_QUOTES)."',sub_category_name = '".htmlspecialchars(stripslashes($subcat_id['subcategory_name']),ENT_QUOTES)."',status = 1,sub_category_description = '".htmlspecialchars(stripslashes($subcat_id['subcategory_desc']),ENT_QUOTES)."' , category_id = '".$menu_main_category."' ,sub_category_id = '".$menu_sub_category."' , show_order = '".($sql_show_order['show_order']+1)."'";
				mysql_query($sql);
				$id =  mysql_insert_id();
			}
			
			
			foreach($_POST['countsplinsdiv'.$countDiv.'_'.$countmenudiv.''] as $countsplinsdiv){
				$special_instruction = $_POST['special_instruction_'.$countDiv.'_'.$countmenudiv.'_'.$countsplinsdiv.''];
				
				if($special_instruction!=''){
					$sql_special_instructions = mysql_query("INSERT INTO restaurant_menu_special_instruction SET restaurant_id = '".$restaurant_id."', menu_id = '".$id."',special_instruction = '".htmlspecialchars(stripslashes($special_instruction),ENT_QUOTES)."'");
					$special_instructions_id = mysql_insert_id();
				}
				
				foreach($_POST['countsplinsoptiondiv'.$countDiv.'_'.$countmenudiv.'_'.$countsplinsdiv.''] as $countdiv_spl_ins_title){
					$title = $_POST['spl_title_'.$countDiv.'_'.$countmenudiv.'_'.$countsplinsdiv.'_'.$countdiv_spl_ins_title.''];
					$price = $_POST['spl_price_'.$countDiv.'_'.$countmenudiv.'_'.$countsplinsdiv.'_'.$countdiv_spl_ins_title.''];
					
					
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
	
	header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$restaurant_id."&item_add=1");

}


if($_REQUEST['submit_item'] == 'Save & Continue')
{
	$data['item_id'] = $_REQUEST['item_id'];
	$data['menu_item_name'] = $_REQUEST['menu_item_name'];
	$data['menu_item_price'] = $_REQUEST['menu_item_price'];
	$data['menu_item_description'] = $_REQUEST['menu_item_description'];
	$subcat = $_REQUEST['subcat'];
	$top_div = $_REQUEST['top_div'];
	$accor_div = $_REQUEST['accor_div'];
	
	$i = 0;
	foreach($data['item_id'] as $item_id)
	{
			if($_FILES['menu_itemwise_picture'.$item_id]['name']!="")
			{
				$image1=$_FILES['menu_itemwise_picture'.$item_id]['name'];
				$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
				//$image=time().$image;
				if ((($_FILES['menu_itemwise_picture'.$item_id]["type"] == "image/gif")
				|| ($_FILES['menu_itemwise_picture'.$item_id]["type"] == "image/png")
				|| ($_FILES['menu_itemwise_picture'.$item_id]["type"] == "image/bmp")
				|| ($_FILES['menu_itemwise_picture'.$item_id]["type"] == "image/jpg")
				|| ($_FILES['menu_itemwise_picture'.$item_id]["type"] == "image/jpeg")
				|| ($_FILES['menu_itemwise_picture'.$item_id]["type"] == "image/pjpeg")))
				{
	
					$picture_url="uploaded_images/".$image;
					LIB_StoreUploadImg($post_file_name="menu_itemwise_picture".$item_id
					,$file_to_copy_path="$picture_url"
					,$file_to_copy_width="800"
					,$file_to_copy_height="600"
					,$adjust = ''
					,$watermark_gif=''
					,$watermark_position='');
					$picture_url_thumb="thumb_images/".$image;
	
					LIB_StoreUploadImg($post_file_name="menu_itemwise_picture".$item_id
					,$file_to_copy_path="$picture_url_thumb"
					,$file_to_copy_width="35"
					,$file_to_copy_height="35"
					,$adjust = ''
					,$watermark_gif=''
					,$watermark_position='');
				}
	
			}
			
			$update = "UPDATE restaurant_menu_item SET menu_name = '".$data['menu_item_name'][$i]."' , price = '".$data['menu_item_price'][$i]."' , description = '".$data['menu_item_description'][$i]."' ";
			
			if($image!=""){
				$update.= " ,menu_pic = '".$image."' " ;
			}
			
			$update.="  WHERE id = '".$item_id."' ";
			
			mysql_query($update);
			
		$i++;
	}

	if($update)
	{
		header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&item_edit=1&sct=".$subcat."&top=".$top_div."&accor=".$accor_div."");
	}
}

if($_REQUEST['del_ins'] == '1')
{
	$delete = mysql_query("DELETE FROM restaurant_menu_item WHERE id = '".$_REQUEST['del_ins']."'");
	 mysql_query("DELETE FROM restaurant_menu_item_special_instruction WHERE menu_id = '".$_REQUEST['del_ins']."'");
	header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&insdel=1&inspop=1");
}

if($_REQUEST['del_ins_item'] == '1')
{
	$delete = mysql_query("DELETE FROM restaurant_menu_item_special_instruction WHERE menu_id = '".$_REQUEST['del_ins_opt']."'");

	header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&insdelitm=1&inspop=1");
}

if($_REQUEST['sub_ins_button'] = "Copy Special Instructions")
{
	$ins_id = $_REQUEST['ins_menu'];
	
	/*echo '<pre>';
	print_r($ins_id);exit;*/
	
	foreach($ins_id as $id)
	{ 
		$max_order_id = mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$id."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' "));
		
		$sel = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$id."'"));
		
		$update = mysql_query("INSERT INTO restaurant_menu_item_special_instruction SET restaurant_id = '".$_REQUEST['restaurant_edit_id']."' , menu_id = '".$sel['menu_id']."' , special_ins_id = '".$id."' , title = '".$sel['title']."' , price = '".$sel['price']."' , show_order = '".$max_order_id['max_id']."' + 1 ");
	}
	
	if($update)
	{
		header("location:edit_restaurant_menu2.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&copyins=1");
	}
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


function open_cat_pop_up(){
	$("#nw_pop").show();
	$("#fade1").show();
}

function close_cat_pop_up(){
	$("#nw_pop").hide();
	$("#fade1").hide();
}

function validate_category(){
	var category = $("#restaurant_category").val();
	if(category == ''){
		alert("Enter Restaurant Category.");
		$("#restaurant_category").focus();
		return false;
	}
}

function validate_subcategory(){
	var category = $("#main_category").val();
	var sub_category = $("#sub_category").val();
	var subcategory_description = $("#subcategory_description").val();
	if(category == ''){
		alert("Select Restaurant Category.");
		$("#main_category").focus();
		return false;
	}
	if(sub_category == ''){
		alert("Enter Restaurant Subcategory.");
		$("#sub_category").focus();
		return false;
	}
	if(subcategory_description == ''){
		alert("Enter Subcategory Description.");
		$("#subcategory_description").focus();
		return false;
	}
}

function getSubcat(id,div_id){
	var restaurant_id = $("#restaurant_edit_id").val();
	$.ajax({
		url : 'get_restaurant_subcat.php',
		type : 'POST',
		data : 'id=' + id+'&restaurant_id='+restaurant_id+'&div_id='+div_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			$("#menu_sub_category_div"+div_id).html(data);
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
}

function get_ins_Subcat(id){
	$.ajax({
		url : 'get_ins_subcat.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			$("#subcat_div").html(data);
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
}

function get_ins_menu(id){
	
	var cat_id = $("#cat_ins").val();
	
	$.ajax({
		url : 'get_ins_menu.php',
		type : 'POST',
		data : 'id=' + id + '&cat_id=' + cat_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			$("#menu_ins_div").html(data);
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
}

function add_menu_item(id ,menu_id){
	$.ajax({
		url : 'addmenuitem.php',
		type : 'POST',
		data : 'id=' + id+'&main_menu_id='+menu_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			  //alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'menu_item_div_' + id;
			menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('all_menu_item_'+menu_id).appendChild(menuDiv);
			document.getElementById('menu_id_'+menu_id).value=parseInt(id)+1;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
		}
	});
}

function remove_menu_div(id){
	cnfm = confirm('Are you sure?');
	if(cnfm == true)
	{
		$("#menu_item_div_"+id).remove();	
	}
	
}

function add_cell(id,res_id){
	$.ajax({
		url : 'addmainmenuitem.php',
		type : 'POST',
		data : 'id=' + id + '&res_id=' + res_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			  //alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'menu_div' + id;
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

function remove_main_menu_div(id){
	cnfm = confirm('Are you sure?');
	if(cnfm == true)
	{
		$("#menu_div"+id).remove();	
	}
	
}

function add_spl_ins(spl_ins_id,menu_id,id){
	$.ajax({
		url : 'addspl_ins.php',
		type : 'POST',
		data : 'spl_ins_id=' + spl_ins_id+'&menu_id='+menu_id+'&id='+id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'spl_div_'+spl_ins_id+'_'+menu_id+'_'+ id;
			menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('menu_item_div'+menu_id+'_'+id).appendChild(menuDiv);
			document.getElementById('add_ins_id_'+menu_id+'_'+id).value=parseInt(spl_ins_id)+1;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
		}
	});
}

function remove_spl_ins_div(spl_ins_id,menu_id,id){
	cnfm = confirm('Are you sure?');
	if(cnfm == true)
	{
		$("#spl_div_"+id+"_"+menu_id+"_"+spl_ins_id).remove();	
	}
}

function add_spl_ins_option(option_id,spl_ins_id,menu_id,id){
	$.ajax({
		url : 'addspl_ins_option.php',
		type : 'POST',
		data : 'spl_ins_id=' + spl_ins_id+'&menu_id='+menu_id+'&id='+id+'&option_id='+option_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'spl_div_'+spl_ins_id+'_'+menu_id+'_'+ id;
			menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('spl_div_'+spl_ins_id+'_'+menu_id+'_'+id).appendChild(menuDiv);
			document.getElementById('add_ins_option_id_'+menu_id+'_'+spl_ins_id).value=parseInt(option_id)+1;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
		}
	});
}

function remove_spl_title_div(menu_id,spl_ins_id,option_id){
	cnfm = confirm('Are you sure?');
	if(cnfm == true)
	{
		$("#spl_titlediv_"+menu_id+"_"+spl_ins_id+"_"+option_id).remove();	
	}
}

</script>



<div class="body_section">

<div class="body_container">

<div class="body_top"></div>

<div class="main_body">


<div class="restaurant_body_cont">



<div class="restaurant_cont_top">

<h1>Edit <?php echo stripslashes($sql_restaurant_name['restaurant_name'])?></h1>

</div>



<div class="restaurant_nav">



<ul>

    <li><a href="edit_restaurant.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Basic Info</a></li>

    <li><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Additional Info</a></li>

    <li><a href="edit_restaurant_menu.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="active7">Menu</a></li>

    <li><a href="edit_multimedia.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Multimedia</a></li>

    <li><a href="edit_special_offer.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Special Offer</a></li>

    <li><a href="edit_confirmation.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Confirmation</a></li>

</ul>



</div>

<form name="menuform" action="" method="post" enctype="multipart/form-data" >


<div class="restaurant_cont_field">



<div class="restaurant_cont_field_heading">



<h1>Menu Process - <a href="javascript:void(0);" class="button4 menu-btn" onClick="open_cat_pop_up();">Add & Manage Menu Category </a> </h1>



</div>

<!-- $$$$$$  Popup Start  $$$$$$$$ -->

<div id="nw_pop" class="white_content xslg">
	<a href="javascript:void(0);" class="close" onClick="close_cat_pop_up();"><img width="16" height="16" src="images/cross.png"> </a>
	<h3 class="poptite">Manage Menu Category</h3>
   <?php if($_REQUEST['caterror'] == '1'){ ?> 
   <p style="color:#F00; text-align:center;">Category Already Exists.</p>
   <?php } ?>
   
   <?php if($_REQUEST['catsuccess'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Category Added Successfully.</p>
   <?php } ?>
   
   <?php if($_REQUEST['subcatsuccess'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Subcategory Added Successfully.</p>
   <?php } ?>
   
   <?php if($_REQUEST['subcaterror'] == '1'){ ?> 
   <p style="color:#F00; text-align:center;">Subcategory Already Exists.</p>
   <?php } ?>
   
   <?php if($_REQUEST['subcatdel'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Subcategory Deleted Successfully.</p>
   <?php } ?>
   
   <?php if($_REQUEST['subedit_success'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Subcategory Edited Successfully.</p>
   <?php } ?>
   
   <?php if($_REQUEST['subedit_error'] == '1'){ ?> 
   <p style="color:#F00; text-align:center;">Subcategory Already Exsists.</p>
   <?php } ?>
   
   <?php if($_REQUEST['itemdel'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Menu Item Deleted Successfully.</p>
   <?php } ?>
   
    <form name="category_frm" id="category_frm" method="post" action="" >
    <input type="hidden" name="restaurant_edit_id" id="restaurant_edit_id" value="<?php echo $_REQUEST['restaurant_edit_id']; ?>">
        <div class="main-cat">
            <label>Create Main Category <em>*</em></label>
            <div class="fildrow">
                <input type="text" name="restaurant_category" id="restaurant_category" style="width:50%;" />
                <input type="submit" name="submit_category" id="submit_category" value="Create" class="btn"  onClick="return validate_category();"/>
            </div>
            <div class="clear"></div>
        </div>
    </form>
	
	<div class="clear"></div>
	<div class="full-width">
    <form name="sub_category_frm" id="sub_category_frm" method="post" action="" onSubmit="return validate_subcategory();">
		<div class="main-cat col-3">
			<label>Category Name <em>*</em></label>
			<div class="fildrow">
				<ul>
					<li>
                        <select name="main_category" id="main_category" class="restaurant_list" style="width:170px; margin:0px;">
                        	<option value="">Select</option>
                            <?php $sql_sel_category = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (".$_REQUEST['restaurant_edit_id'].") ORDER BY category_name ASC ");
							while($array_sel_category = mysql_fetch_array($sql_sel_category)){ ?>
                            <option value="<?php echo $array_sel_category['id']; ?>"
							<?php 
								if(!empty($select_subcat))
								{
									if($select_subcat['category_id'] == $array_sel_category['id'])
									{
										?> selected="selected" <?php
									}
								}
							?>>
							<?php echo $array_sel_category['category_name']; ?>
                            </option>
                            <?php } ?>
                        </select>
					</li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="main-cat col-3">
			<label>Subcategory Name <em>*</em></label>
			<div class="fildrow">
				<ul>
					<li>
						<input type="text" name="sub_category" id="sub_category" value="<?php if(!empty($select_subcat)) { echo $select_subcat['subcategory_name']; } ?>" />
					</li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="main-cat col-3">
			<label>Subcategory Description <em>*</em></label>
			<div class="fildrow">
				<ul>
					<li>
						<textarea name="subcategory_description" id="subcategory_description" rows="3" cols="25"><?php if(!empty($select_subcat)) { echo $select_subcat['subcategory_desc']; } ?></textarea>
					</li>
				</ul>
				
			</div>
			<div class="clear"></div>
		</div>
		<?php
		if($_REQUEST['edit_id'] == "")
		{
		?>	
			<input type="submit" name="submit_subcategory" id="submit_subcategory" value="Add" class="btn aadd" />
        <?php
		}
		else
		{
		?>
        	<input type="submit" name="submit_subcategory_edit" id="submit_subcategory_edit" value="Edit" class="btn aadd" />
        <?php
		}
		?>
		<div class="clear"></div>
    </form>
	</div> 
	
	<?php
	$sql_cat = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (".$_REQUEST['restaurant_edit_id'].") ORDER BY category_name ASC ");
	?>
    <?php if(mysql_num_rows($sql_cat) > 0){ ?>
	<div class="restaurant_nav ">
		<ul>
		<?php
		$j = 1;
		while($row_cat = mysql_fetch_assoc($sql_cat))
		{
		?>
		    <li><a href="javascript:void(0);" id="cat_anc<?php echo $j; ?>" onClick="open_cat_div('<?php echo $j; ?>');"><?php echo $row_cat['category_name']; ?></a></li>
        <?php
		$j++;
		}
		?>
        <input type="hidden" id="tot_div" value="<?php echo $j; ?>" />
		</ul>
		<div class="clear"></div>
	</div> 
    <?php } ?>
	
    <?php
	$sql_cat1 = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (".$_REQUEST['restaurant_edit_id'].") ORDER BY category_name ASC ");
	$jj = 1;
		while($row_cat1 = mysql_fetch_assoc($sql_cat1))
		{
	?>
	<div class="full-width pop-table" id="cat_desc<?php echo $jj; ?>" style="display:none;">
        <table cellpadding="0" cellspacing="0" class="blue-table"> 
            <tr>
                <th>No</th>
                <th>Category Name</th>
                <th>Subcategory Name</th>
                <th>Show Order</th>
                <th>Action</th>
            </tr>
            <?php
			$sql_subcat = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE category_id = '".$row_cat1['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' ORDER BY show_order ");
			$subcat_num_rows = mysql_num_rows($sql_subcat);
			if($subcat_num_rows > 0)
			{
				$min_order_id = mysql_fetch_array(mysql_query("SELECT MIN(show_order) as min_id FROM restaurant_menu_subcategory WHERE category_id = '".$row_cat1['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' "));
                $max_order_id = mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_menu_subcategory WHERE category_id = '".$row_cat1['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' "));
			$sl = 1;
			while($row_subcat = mysql_fetch_assoc($sql_subcat))
			{
			?>
				<tr>
					<td align="center"><?php echo $sl; ?></td>
					<td><?php echo $row_cat1['category_name']; ?></td>
					<td><?php echo $row_subcat['subcategory_name']; ?></td>
					<td align="center">
                    <?php if($min_order_id['min_id']!= $row_subcat['show_order']){ ?>
						<a href="order_change_up_res_sub_cat.php?cat_id=<?php echo $row_subcat['category_id']; ?>&res_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&show_order=<?php echo $row_subcat['show_order']; ?>&id=<?php echo $row_subcat['id']; ?>&sh_odr=<?php echo $jj; ?>"> <img src="images/icon-arrow-up-b-16.png" alt="Order Up" title="Order Up" align="absmiddle" /></a>
                    <?php } ?>
                    <?php if($max_order_id['max_id']!= $row_subcat['show_order']){ ?>
						<a href="order_change_down_res_sub_cat.php?cat_id=<?php echo $row_subcat['category_id']; ?>&res_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&show_order=<?php echo $row_subcat['show_order']; ?>&id=<?php echo $row_subcat['id']; ?>&sh_odr=<?php echo $jj; ?>"> <img src="images/icon-arrow-down-b-16.png" alt="Order Down" title="Order Down" align="absmiddle" /></a>
                    <?php } ?>
					</td>
					<td align="center">
						<a href="edit_restaurant_menu1.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&edit_id=<?php echo $row_subcat['id'];?>&edit_subcat=1&popup=1&edt=<?php echo $jj; ?>"> <img src="images/pen_edit_write_-16.png" alt="Edit" title="Edit" align="absmiddle" /></a>
						<a href="edit_restaurant_menu1.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&del_id=<?php echo $row_subcat['id'];?>&del_subcat=1&dlt=<?php echo $jj; ?>" onClick="return confirm('Are you sure to Delete this Sub Category?')"> <img src="images/DeleteRed.png" alt="Delete" title="Delete" align="absmiddle" /></a>
					</td>
				</tr>
			<?php
			$sl++;
			}
			}
			else
			{
			?>
				<tr>
				  <td colspan="5" align="center">No Records Found.</td>
				</tr>
			<?php
			}
			?>
        </table> 
    </div>
    <?php $jj++; } ?>
	
	
	<div class="clear"></div>
</div>
<div  class="black_overlay"></div>



<!-- $$$$$$  Popup end  $$$$$$$$ -->


<div class="restaurant_cont_field_item">
	<p style="text-align: right;"><a href="javascript:void(0);" onClick="open_state_city_div();" class="button4 menu-btn">Copy Menu from Other Restaurant</a></p>
	<div class="clear"></div>
</div>



<div class="clear"></div>
<?php if($_REQUEST['item_add'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Menu Item Added Successfully.</p>
<?php } ?>

<?php if($_REQUEST['item_edit'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Menu Item Edited Successfully.</p>
<?php } ?>

<?php if($_REQUEST['itemdel'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Menu Item Deleted Successfully.</p>
<?php } ?>

<?php if($_REQUEST['showitmsuccess'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Show Order Changed Successfully.</p>
<?php } ?>

<?php if($_REQUEST['insdel'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Special Instruction Deleted Successfully.</p>
<?php } ?>

<?php if($_REQUEST['insdelitm'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Special Instruction Option Deleted Successfully.</p>
<?php } ?>

<?php if($_REQUEST['copyins'] == '1'){ ?> 
   <p style="color:#090; text-align:center;">Special Instruction Copied Successfully.</p>
<?php } ?>
<form name="menu_item_frm" id="menu_item_frm" method="post" action="" enctype="multipart/form-data">
<div id="allmenu">

<div id="menu_div1" class="mainmanu" style="padding: 0 5px;">



<input type="hidden" name="restaurant_edit_id" id="restaurant_edit_id" value="<?php echo $_REQUEST['restaurant_edit_id']; ?>">
<input type="hidden" name="countmainmenudiv[]" value="1" class="webcampics">
<input type="hidden" id="menu_id_1" name="menu_id_1" value="2">
<input type="hidden" id="item_id" name="item_id" value="2">
<div class="new-res-fild">
	<div class="catsec">
		<label>Main Category : </label>
		<select name="menu_main_category1" id="menu_main_category1" class="restaurant_list" onChange="getSubcat(this.value,'1');">
		    <option value="">--Select Category --</option>
            <?php $sql_get_restaurant_category = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (".$_REQUEST['restaurant_edit_id'].") ORDER BY category_name ASC");
			while($array_restaurant_category = mysql_fetch_array($sql_get_restaurant_category)){ ?>
			<option value="<?php echo $array_restaurant_category['id']; ?>"><?php echo $array_restaurant_category['category_name']; ?></option>	
            <?php } ?>
		</select>
	</div>
	<div class="catsec">
		<label>Sub Category : </label>
        <div id="menu_sub_category_div1">
            <select name="menu_sub_category1" id="menu_sub_category1" class="restaurant_list">
                    <option value="">Select</option>
            </select>
        </div>
	</div>
	<div class="btnsec">
		<?php /*?><a href="javascript:void(0);" class="button4 menu-btn">Apply setting</a><?php */?>
		<a href="javascript:void(0);" class="button4 menu-btn" onClick="add_menu_item(document.getElementById('menu_id_1').value,'1')">Add Menu</a>
	</div>
</div>
<hr />

<div id="all_menu_item_1">
    <div id="menu_item_div1_1">
    
    <input type="hidden" name="countmenudiv[]" value="1" class="webcampics">
    <input type="hidden" name="add_ins_id_1_1" id="add_ins_id_1_1" value="1" >
    <?php /*?><input type="hidden" name="countsplinsdiv[]" value="1" class="webcampics"><?php */?>
        <div class="new-res-fild">
            <div class="addmenu-fild">
                <label>Menu Items Name :</label>
                <input name="menu_item_name_1_1" id="menu_item_name_1_1" type="text" class="restaurant" />
            </div>
            <div class="addmenu-fild">
                <label>Menu Price :</label>
                <input name="menu_item_price_1_1" id="menu_item_price_1_1" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"/>
            </div>
            <div class="addmenu-fild">
                <label>Menu Description  :</label>
                <textarea name="menu_item_description_1_1" id="menu_item_description_1_1" rows="3" cols="25" style="border:1px solid #B5ABC6; margin-top:10px;"></textarea>
            </div>
            <div class="addmenu-fild">
                <label>Menu Picture :</label>
                <input name="menu_item_picture_1_1" id="menu_item_picture_1_1" type="file" class="restaurant_browse" />
            </div>
            <div class="addmenu-fild btnsec">
                <a href="javascript:void(0);" style="font-size:16px;" class="button4 menu-btn" onClick="add_spl_ins(document.getElementById('add_ins_id_1_1').value,'1','1')">Add Special Instruction</a>
            </div>
        </div> 
        
        <div>
        
        
        </div>
        
    </div>
    <div class="clear"></div>
</div>


<div class="clear"></div>



</div>

</div>



<div class="clear"></div>

<div class="clear"></div>

<div >

<div class="add_item" style="float:left;"><a href="javascript:void(0);" onClick="add_cell(document.getElementById('item_id').value,'<?php echo $_REQUEST['restaurant_edit_id']; ?>')" id="item_focus"><img src="images/add_item.png"  style="margin-left:0;"/></a></div>

<div  style="float:right;">

<input class="button4" type="submit" value="Save & Continue" name="submit"  style="margin-top:0;"></div>



<div class="clear"></div>

</div>

</div>

</form>

<?php
	$sql_cat_new = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (".$_REQUEST['restaurant_edit_id'].") ORDER BY category_name ASC "); 
	if(mysql_num_rows($sql_cat_new) > 0){ 
	?>
	<div class="restaurant_nav ">
		<ul>
		<?php
		$k = 1;
		while($row_cat_new = mysql_fetch_assoc($sql_cat_new))
		{
		?>
		    <li><a href="javascript:void(0);" id="cat_anc_new<?php echo $k; ?>" onClick="open_cat_btm_div('<?php echo $k; ?>');"><?php echo $row_cat_new['category_name']; ?></a></li>
        <?php
		$k++;
		}
		?>
        <input type="hidden" id="tot_div_new" value="<?php echo $k; ?>" />
		</ul>
		<div class="clear"></div>
	</div> 
    <?php } ?>
    
    <?php
	$sql_cat_new_div = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (".$_REQUEST['restaurant_edit_id'].") ORDER BY category_name ASC ");
	$l = 1;
	while($row_cat_new_div = mysql_fetch_assoc($sql_cat_new_div))
	{ 
		$sql_subcat_new = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE category_id = '".$row_cat_new_div['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' ORDER BY show_order ");
		$subcat_num_rows_new = mysql_num_rows($sql_subcat_new);
		
	?>
    	<div id="cat_div_new<?php echo $l; ?>" class="mainmanu" style="display:none;">
        <?php
        if($subcat_num_rows_new > 0)
		{
			$z = 1;
			while($row_subcat_new = mysql_fetch_assoc($sql_subcat_new))
			{
				$sql_item = mysql_query("SELECT * FROM restaurant_menu_item WHERE category_id = '".$row_cat_new_div['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND sub_category_id = '".$row_subcat_new['id']."' ORDER BY show_order ");
			?>
            	<?php echo $row_subcat_new['subcategory_name']; ?> <?php if(mysql_num_rows($sql_item) > 0) { ?><a href="javascript:void(0);" id="item_a_<?php echo $row_subcat_new['id']; ?>_<?php echo $z; ?>" class="item_a_cls used_cls" onClick="open_item_div('<?php echo $row_subcat_new['id']; ?>','<?php echo $z; ?>');">+
                </a><?php } ?><br>
                
                <div id="item_div_<?php echo $row_subcat_new['id']; ?>_<?php echo $z; ?>" class="mainmanu item_cls" style="display:none;">
                <form name="item_frm" id="item_frm" method="post" action="" enctype="multipart/form-data">
                <table class="blue-table" width="100%">
                <tr>
                <th>Menu Item Name</th>
                <th>Menu Price</th>
                <th>Menu Description</th>
                <th>Menu Picture</th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
                <?php
				$min_order_id_itm = mysql_fetch_array(mysql_query("SELECT MIN(show_order) as min_id FROM restaurant_menu_item WHERE category_id = '".$row_cat_new_div['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND sub_category_id = '".$row_subcat_new['id']."' "));
                $max_order_id_itm = mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_menu_item WHERE category_id = '".$row_cat_new_div['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND sub_category_id = '".$row_subcat_new['id']."' ")); 
				while($row_item = mysql_fetch_assoc($sql_item))
				{
					$sql_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$row_item['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."'");
				?>
                <tr>
                <td>
                	<input type="hidden" name="item_id[]" id="item_id" value="<?php echo $row_item['id']; ?>" />
                    <input type="hidden" name="subcat" id="subcat" value="<?php echo $row_subcat_new['id']; ?>" />
                    <input type="hidden" name="top_div" id="top_div" value="<?php echo $l; ?>" />
                    <input type="hidden" name="accor_div" id="accor_div" value="<?php echo $z; ?>" />
					<input type="text" name="menu_item_name[]" id="menu_item_name" class="restaurant" value="<?php echo $row_item['menu_name']; ?>" >
                </td>
                <td>
					<input type="text" name="menu_item_price[]" id="menu_item_price" class="restaurant" value="<?php echo $row_item['price']; ?>" >
                </td>
                <td>
					<input type="text" name="menu_item_description[]" id="menu_item_description" class="restaurant" value="<?php echo $row_item['description']; ?>" >
                </td>
                <td align="center">
                	<?php if($row_item['menu_pic'] != '') { ?>
					<img src="uploaded_images/<?php echo $row_item['menu_pic']; ?>" width="50">
					<?php } ?>
					<input type="file" name="menu_itemwise_picture<?php echo $row_item['id']; ?>" id="menu_item_picture" class="restaurant_browse" >
                </td>
                <td><a class="button4 menu-btn" style="font-size:16px;" href="javascript:void(0);" onClick="open_spl_ins_div('<?php echo $row_item['id']; ?>');">Add Special Instruction</a>
                
                <div id="spl_ins_div<?php echo $row_item['id']; ?>" style="display:none;" class="white_content spl_ins"  >
                <div class="close close-new" onclick="close_spl_ins_div('<?php echo $row_item['id']; ?>');"><a href = "javascript:void(0);"> </a> </div>
                <div class="l-contnt up-contnt"> 
                <div>
                    <a href="javascript:void(0);" class="used_cls" style="float:left">Add Special Instruction</a>
                    <a href="javascript:void(0);" class="used_cls" style="float:right" onClick="open_copy_ins_div();">Copy Special Instruction</a>
                </div>
                    <div class="clear"></div>
                <form name="spl_ins" id="spl_ins" action="" method="post" enctype="multipart/form-data">
                <?php
				while($row_ins = mysql_fetch_array($sql_ins))
				{
					$sql_ins_item = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE menu_id = '".$row_item['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND special_ins_id = '".$row_ins['id']."' ORDER BY show_order");
				?>
                	
                    <div style="border-bottom::1px solid dashed #eee;">
                    Special Instruction : <input type="text" class="restaurant" name="spl_ins_txt" id="spl_ins_txt" value="<?php echo $row_ins['special_instruction']; ?>">
                    <a href="javascript:void(0);" style="margin-left:10px;" onClick="return confirm('Are you sure to delete this Entire Instruction?');"><img src="images/Close_Box_Red.png"></a>
                    <a href="edit_restaurant_menu1.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&del_ins=<?php echo $row_ins['id']; ?>&del_ins=1" style="float:right" class="used_cls">Add Option</a>
                    </div>
                    <?php
						$min_order_id_ins = mysql_fetch_array(mysql_query("SELECT MIN(show_order) as min_id FROM restaurant_menu_item_special_instruction WHERE menu_id = '".$row_item['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND special_ins_id = '".$row_ins['id']."' "));
                		$max_order_id_ins = mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_menu_item_special_instruction WHERE menu_id = '".$row_item['id']."' AND restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND special_ins_id = '".$row_ins['id']."' ")); 
					while($row_ins_item = mysql_fetch_array($sql_ins_item))
					{
					?>
                    <table>
                    <tr>
                     <td>
                      Title : <input type="text" class="restaurant" name="ins_title" id="ins_title" value="<?php echo $row_ins_item['title']; ?>" />
                     </td>
                      <td>
                     Price : <input type="text" class="restaurant" name="ins_price" id="ins_price" value="<?php echo $row_ins_item['price']; ?>" />
                      </td>
                     <td>
                     <?php if($min_order_id_ins['min_id']!= $row_ins_item['show_order']){ ?>
                     <a href="order_change_up_ins.php?special_ins_id=<?php echo $row_ins_item['special_ins_id']; ?>&menu_id=<?php echo $row_ins_item['menu_id']; ?>&res_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&show_order=<?php echo $row_ins_item['show_order']; ?>&id=<?php echo $row_ins_item['id']; ?>"> <img align="absmiddle" title="Order Up" alt="Order Up" src="images/icon-arrow-up-b-16.png"></a>
                     <?php } ?>
                     <?php if($max_order_id_ins['max_id']!= $row_ins_item['show_order']){ ?>
                     <a href="order_change_down_ins.php?special_ins_id=<?php echo $row_ins_item['special_ins_id']; ?>&menu_id=<?php echo $row_ins_item['menu_id']; ?>&res_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&show_order=<?php echo $row_ins_item['show_order']; ?>&id=<?php echo $row_ins_item['id']; ?>"> <img align="absmiddle" title="Order Down" alt="Order Down" src="images/icon-arrow-down-b-16.png"></a>
                     <?php } ?>
                     </td>
                     <td>
                     <a href="edit_restaurant_menu1.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&del_ins_opt=<?php echo $row_ins_item['id']; ?>&del_ins_item=1" onClick="return confirm('Are you sure to delete this Instruction option?');"><img src="images/Close_Box_Red.png"></a>
                     </td>
                    </tr>
                    </table>
                    <?php
					}
					?>
                <?php
				}
				?>
                </form>
                </div>
                </div>
                
                
                </td>
                <td>
                <?php if($min_order_id_itm['min_id']!= $row_item['show_order']){ ?>
                <a href="order_change_up_res_item.php?cat_id=<?php echo $row_item['category_id']; ?>&subcat_id=<?php echo $row_item['sub_category_id']; ?>&res_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&show_order=<?php echo $row_item['show_order']; ?>&id=<?php echo $row_item['id']; ?>&sh_div=<?php echo $l; ?>&sh_itm=<?php echo $z; ?>"> <img align="absmiddle" title="Order Up" alt="Order Up" src="images/icon-arrow-up-b-16.png"></a>
                <?php } ?>
                <?php if($max_order_id_itm['max_id']!= $row_item['show_order']){ ?>
                <a href="order_change_down_res_item.php?cat_id=<?php echo $row_item['category_id']; ?>&subcat_id=<?php echo $row_item['sub_category_id']; ?>&res_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&show_order=<?php echo $row_item['show_order']; ?>&id=<?php echo $row_item['id']; ?>&sh_div=<?php echo $l; ?>&sh_itm=<?php echo $z; ?>"> <img align="absmiddle" title="Order Down" alt="Order Down" src="images/icon-arrow-down-b-16.png"></a>
                <?php } ?>
                </td>
                <td><a href="edit_restaurant_menu1.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&del_item_id=<?php echo $row_item['id']; ?>&del_item=1" onClick="return confirm('Are you sure to delete this Item?');"><img src="images/Close_Box_Red.png"></a></td>
                </tr>

                <?php
				}
				?>
                </table>
                <input class="button4" type="submit" style="margin-top:0;" name="submit_item" value="Save & Continue">
                </form>
                </div>
            <?php
			$z++;
			}
        }
		else
		{
			echo "<div>No Records Found.</div>";
		}
		?>
        </div>
    <?php
	$l++;
	}
	?>
<div class="clear"></div>

<div style="width:970px; margin:0 auto;">

<table width="100%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">


</table></div>

</div>



</div>

<div class="body_footer_bg"></div>

<div class="clear"></div>

</div>



</div>

	<div id="state_city_div" style="display:none;" class="assign_item white_content"  >

						

						<div class="close close-new" onClick="close_state_city_div();"><a href = "javascript:void(0);"> </a> </div>

						 	<h2 class="up_nw_load_nw restudnt">Select State & City

                            	<div id="loader_div" class="center-loder" style="display:none;"><img src="images/ajax-loader-review.gif" /></div>

                            </h2>

                        	<?php

								$all_state = mysql_query("SELECT * FROM restaurant_basic_info GROUP BY restaurant_state");

							?>

                        	<div class="l-contnt up-contnt state_city-new"> 

							<form name="state_city" id="state_city" action="#" method="post" class="form-horizontal">

                           <ul class="restu_list">

							<li>

                           <span> State : </span>

                            <select name="state" id="state" onChange="get_city(this.value);">

                            <option value="">---Select State---</option>

                            <?php

							while($row_all_state = mysql_fetch_array($all_state))

							{

							?>

                            	<option value="<?php echo $row_all_state['restaurant_state'];?>"><?php echo $row_all_state['restaurant_state'];?></option>

                            <?php

							}

							?>

                            </select>

                            <div class="clear"></div>

                            </li>

                            <li>

                            <div id="city_div">

                           <span> City : </span>

                            <select name="city" id="city" onChange="get_city(this.value);" class="validate[required]">

                            <option value="">---Select City---</option>

                            </select>

                            <div class="clear"></div>

                            </div>

                            </li>

                            <li>

                            <input type="button" name="submit_state_city" id="submit_state_city" class="button4 center-btn" value="Submit" onClick="sub_state_city();"

                            </li>

							</ul>

                            <input type="hidden" name="hid_res_id" id="hid_res_id" value="<?php echo $_REQUEST['restaurant_edit_id'];?>" />

							</form>

							</div>

							</div>

                    



					<div id="res_sel_div" style="display:none;" class="assign_item white_content"  >

						

						<div class="close close-new" onClick="close_res_sel_div();"><a href = "javascript:void(0);"> </a> </div>

						 	<h2 class="up_nw_load_nw restudnt">Select Restaurant

                            <input type="text" id="search" class="restaurant" style="float: right; margin-top: 0px;" placeholder="Search Here" >

                            	<div id="loader_div" class="center-loder" style="display:none;"><img src="images/ajax-loader-review.gif" /></div>

                            </h2>

                        

                        	<div class="l-contnt up-contnt"> 

							<div id="all_restaurant_div"></div>

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
                            
<div id="copy_ins_div" style="display:none;" class="white_content"  >
<div class="close close-new" onclick="close_copy_ins_div();"><a href = "javascript:void(0);"> </a> </div>
								
<h2 class="up_nw_load_nw restudnt">Select Category & Subcategory & Menu

<div id="loader_div_ins" class="center-loder" style="display:none;"><img src="images/ajax-loader-review.gif" /></div>

</h2>

<?php

$all_cat = mysql_query("SELECT * FROM restaurant_menu_category WHERE 1");

?>
<div class="l-contnt up-contnt"> 
        <form name="cat_subcat" id="cat_subcat" action="#" method="post" class="form-horizontal">
        
                                   <ul class="restu_list">
        
                                    <li>
        
                                   <span> Category : </span>
        
                                    <select name="cat_ins" id="cat_ins" onChange="get_ins_Subcat(this.value);" class="restaurant_list">
        
                                    <option value="">---Select Category---</option>
        
                                    <?php
        
                                    while($row_all_cat = mysql_fetch_array($all_cat))
        
                                    {
        
                                    ?>
        
                                        <option value="<?php echo $row_all_cat['id'];?>"><?php echo $row_all_cat['category_name'];?></option>
        
                                    <?php
        
                                    }
        
                                    ?>
        
                                    </select>
        
                                    <div class="clear"></div>
        
                                    </li>
        
                                    <li>
        
                                    
        
                                   <span> Subcategory : </span>
                                   
        							<div id="subcat_div">
                                    
                                    <select name="subcat_ins" id="subcat_ins" class="restaurant_list">
        
                                    <option value="">---Select Subcategory---</option>
        
                                    </select>
                                    
        							</div>
                                    
                                    <div class="clear"></div>
        
                                    
        
                                    </li>
                                    
                                    <li>
        
                                    
        
                                   <span> Menu : </span>
                                   
        							<div id="menu_ins_div">
                                    
                                    <select name="menu_ins" id="menu_ins" class="restaurant_list">
        
                                    <option value="">---Select Menu---</option>
        
                                    </select>
                                    
        							</div>
                                    
                                    <div class="clear"></div>
        
                                    
        
                                    </li>
        
                                    <li>
        
                                    <input type="button" name="submit_ins" id="submit_ins" class="button4 center-btn" value="Submit" onClick="submit_cat_ins();"
        
                                    </li>
        
                                    </ul>
        
                                    <input type="hidden" name="hid_res_id_ins" id="hid_res_id_ins" value="<?php echo $_REQUEST['restaurant_edit_id'];?>" />
        
                                    </form>
</div>
</div>
<div id="fade1" class="black_overlay"> </div>  

<div id="copy_final_ins_div" style="display:none;" class="white_content"  >
<div class="close close-new" onclick="close_copy_final_ins_div();"><a href = "javascript:void(0);"> </a> </div>
<h2 class="up_nw_load_nw restudnt">Select Special Instructions</h2>

<div class="l-contnt up-contnt"> 
<form method="post" action="">
<ul class="restu_list" id="ins_menu_div">

</ul>
</form>
</div>
</div>
                            
    
<div class="clear"></div>

<script type="text/javascript">
function submit_cat_ins()
{
	$("#loader_div_ins").show();
	
	var menu_ins = $("#menu_ins").val();
	
	$.ajax({
		url : 'get_spl_ins.php',
		type : 'POST',
		data : 'menu_ins=' + menu_ins,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			$("#loader_div_ins").hide();
			$("#copy_ins_div").hide();
			$("#ins_menu_div").html(data);
			$("#copy_final_ins_div").show();
			
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
		
}

function close_copy_final_ins_div()
{
	$("#copy_final_ins_div").hide();
	$("#fade1").hide();
}

function open_copy_ins_div()
{
	$(".spl_ins").hide();
	$("#copy_ins_div").show();
	$("#fade1").show();
}

function close_copy_ins_div(id)
{
	$("#copy_ins_div").hide();
	$("#fade1").hide();
}

function open_spl_ins_div(id)
{
	$("#spl_ins_div"+id).show();
	$("#fade1").show();
}

function close_spl_ins_div(id)
{
	$("#spl_ins_div"+id).hide();
	$("#fade1").hide();
}

function open_cat_div(id)
{
	tot_row = $("#tot_div").val();

	for(i=1;i<tot_row;i++)
	{
		$("#cat_desc"+i).hide();
		$("#cat_anc"+i).removeClass('active7');
	}
	
	$("#cat_desc"+id).show();
	$("#cat_anc"+id).addClass('active7');
}

function open_cat_btm_div(id)
{
	tot_row = $("#tot_div_new").val();

	for(i=1;i<tot_row;i++)
	{
		$("#cat_div_new"+i).hide();
		$("#cat_anc_new"+i).removeClass('active7');
	}
	
	$("#cat_div_new"+id).show();
	$("#cat_anc_new"+id).addClass('active7');
}

function open_item_div(subcat_id,id)
{
	$(".item_cls").slideUp(1500);
	$(".item_a_cls").html('+');
	
	if($("#item_div_"+subcat_id+"_"+id).css('display') == "block")
	{
		$("#item_div_"+subcat_id+"_"+id).slideUp(1500).removeClass('item_cls');
		$("#item_a_"+subcat_id+"_"+id).html('+');
	}
	else
	{
		$("#item_div_"+subcat_id+"_"+id).slideDown(1500).addClass('item_cls');
		$("#item_a_"+subcat_id+"_"+id).html('-');
	}
	
}

function open_first_div()
{
	$("#cat_desc1").show();
	$("#cat_anc1").addClass('active7');
}
function open_first_new_div()
{
	$("#cat_div_new1").show();
	$("#cat_anc_new1").addClass('active7');
}
</script>

<script type="text/javascript">
function open_cat_desc(id)
{
	$("#cat_desc"+id).show();
	$("#cat_anc"+id).addClass('active7');
}

function first_new_div(div_id,item_div,subcat)
{
	$("#cat_anc_new"+div_id).addClass('active7');
	$("#item_a_"+subcat+"_"+item_div).html('-');
	$("#cat_div_new"+div_id).show();
	$("#item_div_"+subcat+"_"+item_div).show();
}

</script>

<?php if($_REQUEST['sh_div'] == '' && $_REQUEST['sh_itm'] == '' && $_REQUEST['sct'] == '' && $_REQUEST['top'] == '' && $_REQUEST['accor'] == '') { ?>
<script type="text/javascript">open_first_new_div();</script>
<?php } ?>
<script type="text/javascript">

function open_state_city_div()

{

	$("#state_city_div").show();

	$("#fade1").show();

}



function close_state_city_div()

{

	$("#state_city_div").hide();

	$("#fade1").hide();

}



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



function get_city(val)

{

	if(val != '')

	{

		$("#loader_div").show();

		$.ajax({

			url : 'get_city.php',

			type : 'POST',

			data : 'state=' + val,

			//dataType : 'json',

			beforeSend : function(jqXHR, settings ){

				//alert(url);

			},

			success : function(data, textStatus, jqXHR){

				//alert(data);

				$("#loader_div").hide();

				$('#city_div').html(data);

			},

			/*complete : function(jqXHR, textStatus){

				alert(3);

			},*/

			error : function(jqXHR, textStatus, errorThrown){

			}

		});

	}



}



function sub_state_city()

{

	var state = $("#state").val();

	var city = $("#city").val();

	var res_id = $("#hid_res_id").val();

	

	 if(state != '' && city != '')

	 {

	  	$("#loader_div").show();

			$.ajax({

				url : 'get_all_restaurants.php',

				type : 'POST',

				data : 'state=' + state + '&city=' + city + '&res_id=' + res_id,

				//dataType : 'json',

				beforeSend : function(jqXHR, settings ){

					//alert(url);

				},

				success : function(data, textStatus, jqXHR){

					//alert(data);

					$("#loader_div").hide();

					$("#state_city_div").hide();

					$('#all_restaurant_div').html(data);

					$("#res_sel_div").show();

					

				},

				/*complete : function(jqXHR, textStatus){

					alert(3);

				},*/

				error : function(jqXHR, textStatus, errorThrown){

				}

			});

	 }

	 else

	 {

		alert("Please Select State and City to Proceed.");

		return false;

	 }

}



$( function() {

    $( '#search' ).keyup( function() {

		var search_text = $( '#search' ).val();

        var matches = $( 'ul#all_res' ).find( 'li:contains('+ $( this ).val() +') ' );

        $( 'li', 'ul#all_res' ).not( matches ).slideUp();

        matches.slideDown();

		if(search_text == '')

		{

			$( 'li', 'ul#all_res' ).slideDown();

		}

    });

});

</script>
<?php if($_REQUEST['edt'] == '' && $_REQUEST['dlt'] == '' && $_REQUEST['sh_odr'] == ''){ ?>
<script type="text/javascript">open_first_div();</script>
<?php } ?>

<?php if($_REQUEST['popup'] == '1'){ ?>
<script>
open_cat_pop_up();
</script>	
<?php } ?>

<?php if($_REQUEST['edt'] != ''){ ?>
<script>
open_cat_desc('<?php echo $_REQUEST['edt']; ?>');
</script>	
<?php } ?>
<?php if($_REQUEST['dlt'] != ''){ ?>
<script>
open_cat_desc('<?php echo $_REQUEST['dlt']; ?>');
</script>	
<?php } ?>
<?php if($_REQUEST['sh_odr'] != ''){ ?>
<script>
open_cat_desc('<?php echo $_REQUEST['sh_odr']; ?>');
</script>	
<?php } ?>
<?php if($_REQUEST['sh_div'] != '' && $_REQUEST['sh_itm'] != '') { ?>
<script>
first_new_div('<?php echo $_REQUEST['sh_div']; ?>','<?php echo $_REQUEST['sh_itm']; ?>','<?php echo $_REQUEST['sct']; ?>');
</script>	
<?php } ?>
<?php if($_REQUEST['sct'] != '' && $_REQUEST['top'] != '' && $_REQUEST['accor'] != '') { ?>
<script>
first_new_div('<?php echo $_REQUEST['top']; ?>','<?php echo $_REQUEST['accor']; ?>','<?php echo $_REQUEST['sct']; ?>');
</script>	
<?php } ?>