<?php
session_start();
include ("admin/lib/conn.php");

$coupon_id = $_REQUEST['coupon_id'];
$restaurant_id = $_REQUEST['restaurant_id'];

$sql_use_coupon = mysql_query("UPDATE restaurant_coupon SET coupon_print = coupon_print-1 WHERE id = '" . $_REQUEST['coupon_id'] . "'");	

echo 'success';
		
	
?>