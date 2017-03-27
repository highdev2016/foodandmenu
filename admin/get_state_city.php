<?php
include ("lib/conn.php");
$state = $_POST['state'];
$id = $_POST['id'];
$sql_admin_panel = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin_panel WHERE id = '".$id."'"));
if($state!=''){
	/*---state specific city----*/
	$optionDetailssubcat="";
	$sql_subcat=sprintf("SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!='' AND restaurant_state = '".$state."' ORDER BY restaurant_city ");
	$query_subcat=mysql_query($sql_subcat);
	$optionDetailssubcat = "<option value=\"\">-- Select City --</option>";
	while($array_subcat=mysql_fetch_array($query_subcat)){
		$restaurant_city = $array_subcat['restaurant_city'];
		if($sql_admin_panel['city'] == $array_subcat['restaurant_city']){
			$selected = 'selected=selected';
		}else{
			$selected = '';
		}
		$optionDetailssubcat .= "<option value=\"$restaurant_city\" ".$selected." >$restaurant_city</option>";
	}
	$option_rest = "<option value=\"\">-- Select --</option>";
	/*----end----*/
	echo $optionDetailssubcat."^".$option_rest;
}
?>