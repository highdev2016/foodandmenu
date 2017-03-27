<?php
include ("admin/lib/conn.php");

$email = $_REQUEST['email'];
$res_id = $_REQUEST['res_id'];
$share_link = "https://foodandmenu.com/restaurant.php?id=".$res_id."&share=".$_REQUEST['share_link']."&is_admin=0&email_top=".$email;

$restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$res_id."'"));

$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 46"));  
								  
$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
$cms_rep=str_replace('%%$res_name%%',$restaurant_name['restaurant_name'],$cms_rep);
$cms_rep=str_replace('%%$share_link%%',$share_link,$cms_rep);


$from = 'support@foodandmenu.com';

$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

$headers .= 'MIME-Version: 1.0' . "\r\n";

$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

$message=$cms_rep;

$subject = stripslashes($sql_cms['subject']);

$send = mail($email,$subject,$message,$headers);

if($send)
{
	echo "success";
}