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
	header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&subcatdel=1&popup=1");
}

if($_REQUEST['edit_subcat'] == '1')
{
	$select_subcat = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE id = '".$_REQUEST['edit_id']."'"));
}

if($_REQUEST['submit_subcategory_edit'] == 'Edit')
{
	$check_dup = mysql_num_rows(mysql_query("SELECT id FROM restaurant_menu_subcategory WHERE category_id = '".$_REQUEST['main_category']."' AND  subcategory_name = '".$_REQUEST['sub_category']."'"));
	if($check_dup == 0)
	{
		$sql_insert_subcategory = mysql_query("UPDATE restaurant_menu_subcategory SET category_id = '".$_REQUEST['main_category']."' , restaurant_id = '".$_REQUEST['restaurant_edit_id']."' , subcategory_name = '".$_REQUEST['sub_category']."' , subcategory_desc = '".$_REQUEST['subcategory_description']."' WHERE id = '".$_REQUEST['edit_id']."'");
		header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&subedit_success=1&popup=1");
	}
	else
	{
		header("location:edit_restaurant_menu1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&subedit_error=1&popup=1");
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

function getSubcat(id){
	var restaurant_id = $("#restaurant_edit_id").val();
	$.ajax({
		url : 'get_restaurant_subcat.php',
		type : 'POST',
		data : 'id=' + id+'&restaurant_id='+restaurant_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			$("#menu_sub_category_div").html(data);
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

function add_cell(id){
	$.ajax({
		url : 'addmainmenuitem.php',
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
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'spl_div_'+spl_ins_id+'_'+menu_id+'_'+ id;
			menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('menu_item_div'+id).appendChild(menuDiv);
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
						<a href="order_change_up_res_sub_cat.php?cat_id=<?php echo $row_subcat['category_id']; ?>&res_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&show_order=<?php echo $row_subcat['show_order']; ?>&id=<?php echo $row_subcat['id']; ?>"> <img src="images/icon-arrow-up-b-16.png" alt="Order Up" title="Order Up" align="absmiddle" /></a>
                    <?php } ?>
                    <?php if($max_order_id['max_id']!= $row_subcat['show_order']){ ?>
						<a href="order_change_down_res_sub_cat.php?cat_id=<?php echo $row_subcat['category_id']; ?>&res_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&show_order=<?php echo $row_subcat['show_order']; ?>&id=<?php echo $row_subcat['id']; ?>"> <img src="images/icon-arrow-down-b-16.png" alt="Order Down" title="Order Down" align="absmiddle" /></a>
                    <?php } ?>
					</td>
					<td align="center">
						<a href="edit_restaurant_menu2.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&edit_id=<?php echo $row_subcat['id'];?>&edit_subcat=1&&popup=1"> <img src="images/pen_edit_write_-16.png" alt="Edit" title="Edit" align="absmiddle" /></a>
						<a href="edit_restaurant_menu2.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']; ?>&del_id=<?php echo $row_subcat['id'];?>&del_subcat=1" onClick="return confirm('Are you sure to Delete this Sub Category?')"> <img src="images/DeleteRed.png" alt="Delete" title="Delete" align="absmiddle" /></a>
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
	<p style="text-align: right;"><a href="javascript:void(0);" onClick="open_state_city_div();"  class="button4 menu-btn">Copy Menu from Other Restaurant</a></p>
	<div class="clear"></div>
</div>



<div class="clear"></div>



<div id="allmenu">

<div id="menu_div1" class="mainmanu" style="padding: 0 5px;">


<form name="menu_item_frm" id="menu_item_frm" method="post" action="">
<input type="hidden" name="restaurant_edit_id" id="restaurant_edit_id" value="<?php echo $_REQUEST['restaurant_edit_id']; ?>">
<input type="hidden" name="countmainmenudiv[]" value="1" class="webcampics">
<input type="hidden" id="menu_id_1" name="menu_id_1" value="2">
<input type="hidden" id="item_id" name="item_id" value="2">
<div class="new-res-fild">
	<div class="catsec">
		<label>Main Category : </label>
		<select name="menu_main_category1" id="menu_main_category1" class="restaurant_list" onChange="getSubcat(this.value);">
		    <option value="">--Select Category --</option>
            <?php $sql_get_restaurant_category = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (".$_REQUEST['restaurant_edit_id'].") ORDER BY category_name ASC");
			while($array_restaurant_category = mysql_fetch_array($sql_get_restaurant_category)){ ?>
			<option value="<?php echo $array_restaurant_category['id']; ?>"><?php echo $array_restaurant_category['category_name']; ?></option>	
            <?php } ?>
		</select>
	</div>
	<div class="catsec">
		<label>Sub Category : </label>
        <div id="menu_sub_category_div">
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
    <div id="menu_item_div1">
    
    <input type="hidden" name="countmenudiv_1[]" value="1" class="webcampics">
    <input type="hidden" name="add_ins_id_1_1" id="add_ins_id_1_1" value="1" >
    <input type="hidden" name="countsplinsdiv_1_1[]" value="1" class="webcampics">
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

<div class="add_item" style="float:left;"><a href="javascript:void(0);" onClick="add_cell(document.getElementById('item_id').value)" id="item_focus"><img src="images/add_item.png"  style="margin-left:0;"/></a></div>

<div  style="float:right;">

<input class="button4" type="submit" value="Save & Continue" name="submit"  style="margin-top:0;"></div>



<div class="clear"></div>

</div>

</div>

</form>

<div style="width:970px; margin:0 auto;">

<table width="100%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">

  <tr>

    <td width="15%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('menu_name')" class="heading_link">Menu Item Name</a></td>

    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('category_name')" class="heading_link">Category</a></td>

    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('sub_category_name')" class="heading_link">Sub Category</a></td>

    <td width="15%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('price')" class="heading_link">Price ($)</a></td>

    <td width="16%" class="all_restaurant">Image</td>

    <td width="17%" class="all_restaurant">Action</td>

  </tr>

  <tr>

    <td class="all_restaurant2"></td>

    <td class="all_restaurant2">
    </td>

    <td class="all_restaurant2">
    </td>

    <td class="all_restaurant2"></td>

    <td class="all_restaurant2"></td>

    <td class="all_restaurant2"></td>

  </tr>

</table></div>

</div>



</div>

<div class="body_footer_bg"></div>

<div class="clear"></div>

</div>



</div>



<div class="clear"></div>

<script type="text/javascript">
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

function open_first_div()
{
	$("#cat_desc1").show();
	$("#cat_anc1").addClass('active7');
}
</script>

<script type="text/javascript">open_first_div();</script>

<?php if($_REQUEST['popup'] == '1'){ ?>
<script>
open_cat_pop_up();
</script>	
<?php } ?>