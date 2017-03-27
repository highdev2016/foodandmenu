<?php
session_start();
include("admin/lib/conn.php");

$id = $_REQUEST['id'];
$email = $_REQUEST['email'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$gender = $_REQUEST['gender'];


$sql_select = mysql_query("SELECT * FROM restaurant_customer WHERE oauth_uid = '".$id."'");
$num_rows = mysql_num_rows($sql_select);
$row_select = mysql_fetch_array($sql_select);

if($num_rows == 0){
	$sql_insert_customer = mysql_query("INSERT INTO restaurant_customer SET firstname = '".$first_name."' , lastname = '".$last_name."', email = '".$email."' , gender = '".$gender."' , oauth_uid = '".$id."' , oauth_provider = 'Google Plus' , 	registration_time = NOW() , city = '".$city."' , status = '1' , last_logged_in = '".date('Y-m-d H:i:s')."'");
	$last_id = mysql_insert_id();
	$_SESSION['customer_id'] = $last_id;
}else{
	$sql_update_customer = mysql_query("UPDATE restaurant_customer SET firstname = '".$first_name."' , lastname = '".$last_name."', email = '".$email."' , gender = '".$gender."' , city = '".$city."' , status = '1' , last_logged_in = '".date('Y-m-d H:i:s')."' , oauth_provider = 'Google Plus' WHERE oauth_uid = '".$id."'");	
	$_SESSION['customer_id'] = $row_select['id'];
}

echo 'Success';

?>