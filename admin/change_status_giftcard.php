<?php
session_start();
include ("lib/conn.php");
include ("../includes/functions.php");

$id = $_REQUEST['id'];
$sql = mysql_query("UPDATE restaurant_gift_certificate_no SET used = if(used = '1','0','1') WHERE giftcard_id = '".$id."'");
if($sql)
{
	$sql_sel = mysql_fetch_array(mysql_query("SELECT used FROM restaurant_gift_certificate_no WHERE  giftcard_id = '".$id."'"));
	
	echo $sql_sel['used'];
}


?>