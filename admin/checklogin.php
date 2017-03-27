<?php
session_start();
ob_start();
include('lib/conn.php');

$username = mysql_real_escape_string($_REQUEST['username']);
$password = mysql_real_escape_string(md5($_REQUEST['pwd']));
$captcha_code = mysql_real_escape_string(($_REQUEST['captcha_code']));


if(strcasecmp($_SESSION['6_letters_code'], $captcha_code) != 0){
	header('location:login.php?error=2');
	exit;
}
else{
	$sql = sprintf("select * from %sadmin where username = '%s' and password = '%s' and id=1",$table_prefix,$username,$password);
	
	$rs = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($rs);
	
	if(mysql_num_rows($rs)>0)
	{
		$_SESSION['admin_id'] = $row['id'];
		$_SESSION['restaurant_id'] = 1;
		header('location:index.php');
		exit;
	}
	else
	{
		header('location:login.php?error=1');
		exit;
	}
}
		
	
?>
