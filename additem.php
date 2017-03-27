<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
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
<div class="cross_bt">
<a href="javascript:void(0);" onclick="remove_div(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>

<input type="hidden" name="countdiv[]" value="<?php echo $id; ?>" class="webcampics">

<div class="restaurant_form_field">
<div class="clear"></div>
<p>Main Category :</p>
<select name="main_category<?php echo $id; ?>" id="main_category<?php echo $id; ?>" class="restaurant_list" onChange="getSubcat(this.value,<?php echo $id; ?>);">
<option value="">-- Select Category --</option>
<?php echo $optionDetailscat; ?>
</select>
<div class="clear"></div>
<p>Sub Category :</p>
<select name="sub_category<?php echo $id; ?>" id="sub_category<?php echo $id; ?>" class="restaurant_list" onChange="get_sub_desc(this.value,<?php echo $id; ?>);">
<option value="">-- Select Category --</option>
</select>
<div class="clear"></div>

<p>Sub Category Description :</p>
<div id="sub_cat_desc_div<?php echo $id; ?>">
<textarea name="sub_category_description<?php echo $id; ?>" id="sub_category_description<?php echo $id; ?>" rows="3" cols="25" style="border:1px solid #B5ABC6;"></textarea>
</div>
<div class="clear"></div>

<p>Menu Items Name :</p>
<input name="menu_items<?php echo $id; ?>" id="menu_items<?php echo $id; ?>" type="text" class="restaurant" />
<div class="clear"></div>

<p>Menu Price :</p>
<input name="menu_price<?php echo $id; ?>" id="menu_price<?php echo $id; ?>" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<div class="clear"></div>
<p>Menu Description :</p>
<textarea name="menu_description<?php echo $id; ?>" id="menu_description<?php echo $id; ?>" rows="3" cols="25" style="border:1px solid #B5ABC6;"></textarea>
<div class="clear"></div>
<p>Menu Picture :</p>
<input name="menu_picture<?php echo $id; ?>" id="menu_picture<?php echo $id; ?>" type="file" class="restaurant_browse" />
<div class="clear"></div>
</div>

<div class="restaurant_form_field">
<p><a href="javascript:void(0);" onClick="add_special_ins(document.getElementById('spl_ins_item_id').value,'<?php echo $id; ?>')" style="color:#F07200; font-size:16px;">Add Special Instruction</a></p>

<div class="clear"></div>
<div id="splallmenu_<?php echo $id; ?>">
</div>

</div>

<div class="clear"></div>


