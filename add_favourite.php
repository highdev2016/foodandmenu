<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$user_id = $_REQUEST['user_id'];
$res_id = $_REQUEST['res_id'];

$check_duplicate = mysql_num_rows(mysql_query("SELECT id FROM restaurant_favourite WHERE user_id = '".$user_id."' AND restaurant_id = '".$res_id."'"));


if($check_duplicate == 0)
{
	$sql = mysql_query("INSERT INTO restaurant_favourite SET user_id = '".$user_id."' , restaurant_id = '".$res_id."'");
	
	$last_id = mysql_insert_id();
	
	$sql_insert_notification = mysql_query("INSERT INTO restaurant_notification SET user_id = '".$_SESSION['customer_id']."' , action = 'add_favourite' , post_date = NOW() , notification = 'added ".getNameTable('restaurant_basic_info','restaurant_name','id',$res_id)." as favourite   ' , rel_id = '".$last_id."' , restaurant_id = '".$res_id."'");
	
	$favourite_html = "<a href='javascript:void(0);' class='right_list_button'  style='color:#ffffff; text-decoration:none; cursor:default;'>Added to Favourite</a>";
	
	if($sql)
	{
		echo $favourite_html;
		
		$follower_list = mysql_query("SELECT follower_id FROM user_follow WHERE following_id = '".$_SESSION['customer_id']."'");
	
	while($follower_list_all = mysql_fetch_array($follower_list))
	{
		$email_cust = getNameTable("restaurant_customer","email","id",$follower_list_all['follower_id']);
		
		$cust_name = getNameTable("restaurant_customer","firstname","id",$follower_list_all['follower_id'])." ".getNameTable("restaurant_customer","lastname","id",$follower_list_all['follower_id']);
		
		$name = getNameTable("restaurant_customer","firstname","id",$_SESSION['customer_id'])." ".getNameTable("restaurant_customer","lastname","id",$_SESSION['customer_id']);
		
		$notification = "added ".getNameTable('restaurant_basic_info','restaurant_name','id',$res_id)." as favourite".date('m-d-Y')." at ".date('h:i:s A');
		
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 42"));  
		  
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
		
		$cms_rep=str_replace('%%$customer_name%%',$cust_name,$cms_rep);
		$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
		$cms_rep=str_replace('%%$notification%%',$notification,$cms_rep);
		
		
		$from = 'support@foodandmenu.com';
	
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
		$headers .= 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
		$message=$cms_rep;
		
		$subject = str_replace('%%$action%%','Adding Restaurant as favourite',stripslashes($sql_cms['subject']));
		
		mail($email_cust,$subject,$message,$headers);
	}
	}
}
else
{
	echo "You have already added this Restaurant as Favourite!!";
}

?>