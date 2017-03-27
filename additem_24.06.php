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
<p>Main Category* :</p>
<select name="main_category<?php echo $id; ?>" id="main_category<?php echo $id; ?>" class="restaurant_list" onChange="getSubcat(this.value,<?php echo $id; ?>);">
<option value="">-- Select Category --</option>
<?php echo $optionDetailscat; ?>
</select>
<div class="clear"></div>
<p>Sub Category* :</p>
<select name="sub_category<?php echo $id; ?>" id="sub_category<?php echo $id; ?>" class="restaurant_list">
<option value="">-- Select Category --</option>
</select>
<div class="clear"></div>
<p>Menu Items Name* :</p>
<input name="menu_items<?php echo $id; ?>" id="menu_items<?php echo $id; ?>" type="text" class="restaurant" />
<div class="clear"></div>
</div>

<div class="restaurant_form_field">
<p>Menu Price* :</p>
<input name="menu_price<?php echo $id; ?>" id="menu_price<?php echo $id; ?>" type="text" class="restaurant" onkeypress="return goodchars(event,'1234567890');" />
<div class="clear"></div>
<p>Menu Description* :</p>
<textarea name="menu_description<?php echo $id; ?>" id="menu_description<?php echo $id; ?>"></textarea>
<div class="clear"></div>
<p>Menu Picture* :</p>
<input name="menu_picture<?php echo $id; ?>" id="menu_picture<?php echo $id; ?>" type="file" class="restaurant_browse" />
<div class="clear"></div>
</div>

<div class="clear"></div>