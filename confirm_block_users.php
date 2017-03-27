<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$id = $_REQUEST['id'];
$blk_status = $_REQUEST['blk_status'];

if($blk_status == 'yes'){
	$block_users = mysql_query("UPDATE user_follow SET block_status = 1 WHERE id = '".$id."' ");
	
}else{
	$delete_user = mysql_query("DELETE FROM user_follow WHERE id = '".$id."' ");
	echo $id;
}

?>