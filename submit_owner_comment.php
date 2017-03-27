<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$review_id = $_REQUEST['id'];
$comment = $_REQUEST['comment'];
$res_id = $_REQUEST['res_id'];

$res_owner_id = getNameTable("restaurant_basic_info","user_id","id",$res_id);
$restaurant_name = getNameTable("restaurant_basic_info","restaurant_name","id",$res_id);

$check_duplicate = mysql_num_rows(mysql_query("SELECT id FROM restaurant_rev_owners_comment WHERE review_id = '".$review_id."'"));

if($check_duplicate == 0)
{
	$Insert_comment = mysql_query("INSERT INTO restaurant_rev_owners_comment SET review_id = '".$review_id."' , restaurant_owner_id = '".$res_owner_id."' , comment = '".$comment."' , post_date = NOW()");
}
else
{
	$Update_comment = mysql_query("UPDATE restaurant_rev_owners_comment SET review_id = '".$review_id."' , restaurant_owner_id = '".$res_owner_id."' , comment = '".$comment."' , post_date = NOW() WHERE review_id = '".$review_id."'");
}

if($Insert_comment || $Update_comment)
{
	echo "Success"; 
	
	$sql_review=mysql_fetch_array(mysql_query("SELECT * from restaurant_reviews where id='".$review_id."'"));
	
	$email = $sql_review['customer_email'];
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 37"));  
	  
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	$cms_rep = str_replace('%%$customer_name%%',$sql_review['customer_name'],$cms_rep);
	$cms_rep = str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
	$cms_rep = str_replace('%%$comment%%',$comment,$cms_rep);
	
	$from = 'support@foodandmenu.com';

	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

	$headers .= 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

	$message=$cms_rep;
	
	$subject = stripslashes($sql_cms['subject']);
	
	mail($email,$subject,$message,$headers);
	
}
?>