<?php
include ("admin/lib/conn.php");

$code 			= $_REQUEST['code'];
$resturant_id	= $_REQUEST['res_id'];

	$sql = mysql_num_rows(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$code."' AND restaurant_id = '".$resturant_id."'"));
	
	if($sql > 0){
		echo "Exists";
	}
	
	
	
		
	
?>