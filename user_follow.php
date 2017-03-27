<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$user_id = $_REQUEST['user_id'];
$follow_id = $_REQUEST['follow_id'];

$check_duplicate = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$user_id."' AND following_id = '".$follow_id."'"));


if($check_duplicate == 0)
{

	$sql = mysql_query("INSERT INTO user_follow SET follower_id = '".$user_id."' , following_id = '".$follow_id."' , status = '0'");
	
	$following_html = "<a href='javascript:void(0);' class='follow-btn' style='cursor:default; margin: 5px -5px 0; width: 71px;' ><img src='images/follower.png' align='absmiddle'  /> Request Sent</a>";
	
	$follower_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$follow_id."' AND status = '1' "));
	
	$following_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE following_id = '".$follow_id."' AND status = '1' "));
	
	if($sql)
	{
		echo $following_html."^".$follower_count."^".$following_count; 
	}
}
else
{
	echo "You have already Followed this user!!";
}

?>
