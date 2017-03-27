<?php
include ("admin/lib/conn.php");
$city = $_POST['city'];
$id = $_POST['id'];
$rest_name = $_POST['restaurant'];
$sql_admin_panel = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin_panel WHERE id = '".$id."'"));
if($city!=''){
	/*---city specific restaurant----*/
	$optionDetailssubcat="";
	$sql_subcat=sprintf(" SELECT * FROM restaurant_basic_info WHERE id!= '' AND restaurant_city = '".$city."' ORDER BY restaurant_name ");
	$query_subcat=mysql_query($sql_subcat);
	$optionDetailssubcat = "<option value=\"\">-- Select Restaurant --</option>";
	while($array_subcat=mysql_fetch_array($query_subcat)){
		$restaurant_name = stripslashes($array_subcat['restaurant_name']);
		$restaurant_id = $array_subcat['id'];
		if($rest_name == $array_subcat['id']){
			$selected = 'selected=selected';
		}else{
			$selected = '';
		}
		$optionDetailssubcat .= "<option value=\"$restaurant_id\" ".$selected.">$restaurant_name</option>";
	}
	/*----end----*/
	echo $optionDetailssubcat;
}
?>