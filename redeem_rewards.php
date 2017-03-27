<?php
include ("admin/lib/conn.php");

$id = $_REQUEST['id'];
$cust_id = $_REQUEST['cust_id'];
$point = $_REQUEST['point'];

$sql = mysql_query("UPDATE restaurant_customer SET reward_point = reward_point+'".$point."' WHERE id = '".$cust_id."'");

if($sql)
{
	$upd = mysql_query("UPDATE restaurant_point_history SET point_added = point_added-'".$point."' WHERE id = '".$id."'");
}

if($upd)
{
	header("location:user_profile.php");
}

?>