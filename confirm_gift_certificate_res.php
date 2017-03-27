<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$validation_code = $_REQUEST['validation_code'];
$user_val_code = $_REQUEST['user_val_code'];
$certificate_no = $_REQUEST['certificate_no'];

if($validation_code == $user_val_code)
{
	$update = mysql_query("UPDATE restaurant_gift_certificate_no SET used = '1' WHERE validation_code = '".$validation_code."' AND certificate_no = '".$certificate_no."' ");

	if($update)
	{
		echo "Gift Certificate marked as used Successfully.";
		
		$sql_certificate=mysql_fetch_array(mysql_query("SELECT * from restaurant_gift_certificate_no where validation_code='".$validation_code."'"));
	
		//////////////////////////////////////Mail to Customer/////////////////////////////////////////////////
	
		$email_cust = getNameTable("restaurant_customer","email","id",$sql_certificate['customer_id']);
		$name_cust = getNameTable("restaurant_customer","firstname","id",$sql_certificate['customer_id'])." ".getNameTable("restaurant_customer","lastname","id",$sql_certificate['customer_id']);
		
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 40"));  
		  
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
		$cms_rep = str_replace('%%$name%%',$name_cust,$cms_rep);
		$cms_rep=str_replace('%%$gift_certificate_no%%',$sql_certificate['certificate_no'],$cms_rep);
		
		$from = 'support@foodandmenu.com';
	
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
		$headers .= 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
		$message=$cms_rep;
		
		$subject = str_replace('%%$gift_certificate_no%%',$sql_certificate['certificate_no'],stripslashes($sql_cms['subject']));
		
		mail($email_cust,$subject,$message,$headers);
		
		//////////////////////////////////////Mail to Customer/////////////////////////////////////////////////
		
		//////////////////////////////////////Mail to Admin////////////////////////////////////////////////////
		
		$sql_admin_email = mysql_fetch_array(mysql_query("SELECT content FROM restaurant_payment_email where id=1"));
								
		$admin_email_address = $sql_admin_email['email_address'];

		$arr_email_address = explode(",",$admin_email_address);
		
		$admin_email = "support@foodandmenu.com";//'priya@infosolz.com';
		
					
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 38"));	

		$cms_rep_admin = htmlspecialchars_decode(stripslashes($sql_cms['description']));
		
		$cms_rep_admin=str_replace('%%$name%%','Admin',$cms_rep_admin);
		$cms_rep_admin=str_replace('%%$gift_certificate_no%%',$sql_certificate['certificate_no'],$cms_rep_admin);
				
		
		$from = 'support@foodandmenu.com';
		
		$headers1 = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
		
		$headers1 .= 'MIME-Version: 1.0' . "\r\n";
		
		$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
		
		$message2=$cms_rep_admin;
		
		//$subject2="Customer Purchase Details";
		
		$subject2 = str_replace('%%$gift_certificate_no%%',$sql_certificate['certificate_no'],stripslashes($sql_cms['subject']));
		
		mail($admin_email,$subject2,$message2,$headers1);
		
		foreach($arr_email_address as $val_email){
			mail($val_email,$subject2,$message2,$headers1);
		}
		
		//////////////////////////////////////Mail to Admin////////////////////////////////////////////////////
		
		//////////////////////////////////////Mail to Restaurant Owner/////////////////////////////////////////
		
		$sql_restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$sql_certificate['restaurant_id']."'"));
		
		$res_owner_name = getNameTable("restaurant_users","user_nicename","ID",$sql_certificate['restaurant_id']);
		
		$res_email = (explode(",",$sql_restaurant_name['email']));
	
		$email = $res_email[0];//'priya@infosolz.com'
		
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 39"));  
		 
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));  
		
		$cms_rep=str_replace('%%$name%%',$res_owner_name,$cms_rep);
		$cms_rep=str_replace('%%$gift_certificate_no%%',$sql_certificate['certificate_no'],$cms_rep);
		
		
		$from = 'support@foodandmenu.com';
	
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
		$headers .= 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
		$message=$cms_rep;
	
		//$subject="Gift Certificate";
		
		$subject = str_replace('%%$gift_certificate_no%%',$sql_certificate['certificate_no'],stripslashes($sql_cms['subject']));
		
		$inc = 1;
		foreach($res_email as $val_email){
			if($inc!=1){
				$headers.= "Bcc:".$val_email."\n";
			}
			$inc++;
		}
				
		mail($email,$subject,$message,$headers);
		
		//////////////////////////////////////Mail to Restaurant Owner/////////////////////////////////////////
	}

}
else
{
	echo "Validation Code Mismatched.. Please Re-enter.";
}



?>