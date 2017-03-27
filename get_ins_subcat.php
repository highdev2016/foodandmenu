<?php
include ("admin/lib/conn.php");
$id = $_REQUEST['id'];
$res_id = $_REQUEST['res_id'];

$sql_get_sub_category = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE category_id = '".$id."' AND restaurant_id = '".$res_id."'");
$html= '<select name="subcat_ins" id="subcat_ins" class="restaurant_list" onChange="get_ins_menu(this.value);">
<option value="">---Select Subcategory---</option>';
while($array_get_sub_category = mysql_fetch_array($sql_get_sub_category)){
	$html.= '<option value="'.$array_get_sub_category['id'].'">'.$array_get_sub_category['subcategory_name'].'</option>';
}
$html.='</select>';

echo $html;

?>