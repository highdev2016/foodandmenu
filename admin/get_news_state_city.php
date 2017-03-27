<?php
include ("lib/conn.php");
$state = $_POST['state'];

	/*---menu sub category----*/
	
	$sql_subcat=sprintf("select distinct(city) from restaurant_customer WHERE state = '".$state."' AND city!='' ORDER BY city");
	$query_subcat=mysql_query($sql_subcat);
	//$optionDetailssubcat = "<option value=\"\">-- Select Sub Category --</option>";
	while($array_subcat=mysql_fetch_array($query_subcat)){
		$city = $array_subcat['city'];
		$optionDetailssubcat .= '<input type="checkbox" name="checkbox1[]" value="'.$array_subcat['city'].'" style="margin-left:11px;" onclick="return check_email()" />'.$array_subcat['city']."<br>";
	}
	/*----end----*/
	echo $optionDetailssubcat;


?>