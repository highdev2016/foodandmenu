<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$id = $_REQUEST['id'];
$val = $_REQUEST['val'];
$follow_id = $_REQUEST['follow_id'];

$sql_follow = mysql_fetch_array(mysql_query("SELECT * FROM user_follow WHERE id = '".$id."' "));

if($val == "1")
{
	$sql_accept = mysql_query("UPDATE user_follow SET status = 1 WHERE id = '".$id."'");
}
elseif($val == "2")
{
	$sql_reject = mysql_query("DELETE FROM user_follow WHERE id = '".$id."'");
}	

if($sql_accept || $sql_reject)
{
	$follower_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$follow_id."' AND status = '1' "));
	$following_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE following_id = '".$follow_id."' AND status = '1' "));
	
	$sql_insert_notification = mysql_query("INSERT INTO restaurant_notification SET user_id = '".$sql_follow['follower_id']."' , action = 'follow' , post_date = NOW() , notification = '".getNameTable('restaurant_customer','firstname','id',$sql_follow['following_id'])." followed by ".getNameTable('restaurant_customer','firstname','id',$sql_follow['follower_id'])."' , rel_id = '".$id."'");
	
	echo "Success"."^".$follower_count."^".$following_count;
}

?>