<?php
include ("admin/lib/conn.php");
$id = $_REQUEST['id'];
$cat_id = $_REQUEST['cat_id'];
$res_id = $_REQUEST['res_id'];

$sql_get_menu = mysql_query("SELECT * FROM restaurant_menu_item WHERE category_id = '".$cat_id."' AND sub_category_id = '".$id."' AND restaurant_id = '".$res_id."'");
$html= '<select name="menu_ins" id="menu_ins" class="restaurant_list">
<option value="">---Select Menu---</option>';
while($array_get_menu = mysql_fetch_array($sql_get_menu)){
	$html.= '<option value="'.$array_get_menu['id'].'">'.$array_get_menu['menu_name'].'</option>';
}
$html.='</select>';

echo $html;

?>