<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$id = $_REQUEST['id'];

$sql = mysql_query("DELETE FROM user_follow WHERE id = '".$id."'");

if($sql)
{
	echo "Success";
}

?>
