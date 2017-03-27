<?php
	require_once('../lib/conn.php');
	$num_rows = 0;
	$useremail = trim($_REQUEST['email']);
	//echo 'aaaa'.$useremail;
	$sql = "SELECT `user_email` FROM `restaurant_users` WHERE `user_email` = '".$useremail."'";
	$qry = mysql_query($sql);
	$num_rows = mysql_num_rows($qry);
	if($num_rows>0){
		echo $num_rows;
	}else{ echo $num_rows; }
?>