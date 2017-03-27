<?php
session_start();
include ("admin/lib/conn.php");

$restaurant_id = $_REQUEST['id'];
$reservation_id = $_REQUEST['res_id'];

function change_dateformat_reverse($date_form1)
{
	 if($date_form1!=''){
	  $date2=explode("-",$date_form1);
	  $dateformat1=$date2[1]."-".$date2[2]."-".$date2[0];
	  return $dateformat1;
	  }
	 else{
	  $dateformat1='';
	  return $dateformat1;
	  }
}

$reservation_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reservations WHERE id = '".$reservation_id."'"));
$customer_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$reservation_details['customer_id']."'"));
$restaurant_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$restaurant_id."'"));

$sql_update = mysql_query("UPDATE restaurant_reservations SET  reservation_status = 'confirm' WHERE id = '".$reservation_id."'");


$username = $customer_details['firstname']." ".$customer_details['lastname'];
$restaurant_name = $restaurant_details['restaurant_name'];
$post_date = change_dateformat_reverse($reservation_details['date']);
$time = $reservation_details['time'];
$how_many_people = $reservation_details['people'];
$special_occasions = $reservation_details['special_occassion'];
$contact_email = $reservation_details['contact_email'];
$comments = $reservation_details['comments'];

$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 34"));	
			
$cms_rep1 = htmlspecialchars_decode(stripslashes($sql_cms['description']));

$cms_rep1=str_replace('%%$username%%',$username,$cms_rep1);
$cms_rep1=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep1);
$cms_rep1=str_replace('%%$post_date%%',$post_date,$cms_rep1);
$cms_rep1=str_replace('%%$time%%',$time,$cms_rep1);
$cms_rep1=str_replace('%%$how_many_people%%',$how_many_people,$cms_rep1);
$cms_rep1=str_replace('%%$special_occasions%%',$special_occasions,$cms_rep1);
$cms_rep1=str_replace('%%$contact_email%%',$contact_email,$cms_rep1);
$cms_rep1=str_replace('%%$comments%%',$comments,$cms_rep1);	

$from1 = "support@foodandmenu.com";

$headers1 = "From:".$from1."\nReply-To: ".$from1."\nReturn-Path: ".$from1."\nX-Mailer: PHP\n";

$headers1 .= 'MIME-Version: 1.0' . "\r\n";

$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

$message1=$cms_rep1;

//$subject1="Reservation Confirmation mail";

$subject1 = stripslashes($sql_cms['subject']);

$mail = mail($contact_email,$subject1,$message1,$headers1);

header("location:restaurant.php?id=".$restaurant_id."&error_msg=9");







?>

