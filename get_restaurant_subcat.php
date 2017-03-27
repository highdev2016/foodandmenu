<?php
include ("admin/lib/conn.php");
$id = $_REQUEST['id'];
$restaurant_id = $_REQUEST['restaurant_id'];
$div_id = $_REQUEST['div_id'];

$sql_get_sub_category = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE restaurant_id = '".$restaurant_id."' AND category_id = '".$id."'");
$html= '<select name="menu_sub_category'.$div_id.'" id="menu_sub_category'.$div_id.'" class="restaurant_list">
<option value="">--Select--</option>';
while($array_get_sub_category = mysql_fetch_array($sql_get_sub_category)){
	$html.= '<option value="'.$array_get_sub_category['id'].'">'.$array_get_sub_category['subcategory_name'].'</option>';
}
$html.='</select>';

echo $html;

?>