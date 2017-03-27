<?php
include ("admin/lib/conn.php");
$state = $_POST['state'];
$sel_state = $_POST['sel_state'];
if($state!=''){
	/*---state specific city----*/
	$optionDetailssubcat="";
	$sql_subcat=sprintf("SELECT DISTINCT(city) FROM restaurant_city_state WHERE city!='' AND state = '".$state."' ORDER BY city ");
	$query_subcat=mysql_query($sql_subcat);
	$optionDetailssubcat = "<option value=\"\">-- Select City --</option>";
	while($array_subcat=mysql_fetch_array($query_subcat)){
		$city = $array_subcat['city'];
		if($sel_state == $city){
			$selected = 'selected=selected';
		}else{
			$selected = '';
		}
		$optionDetailssubcat .= "<option value=\"$city\" ".$selected." >$city</option>";
	}
	$option_rest = "<option value=\"\">-- Select --</option>";
	/*----end----*/
	echo $optionDetailssubcat."^".$option_rest;
}
?>