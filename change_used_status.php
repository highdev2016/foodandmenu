<?php
session_start();

include("admin/lib/conn.php");

$validation_code = $_REQUEST['validation_code'];

$sql = mysql_query("UPDATE restaurant_gift_certificate_no SET used = '1' WHERE validation_code = '".$validation_code."'");

if($sql)
{
	echo "Successfully Marked as Used.";
}


?>