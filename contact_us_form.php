<?php
session_start();
include ("admin/lib/conn.php");

$captcha_code 		= $_REQUEST['captcha_code'];
$name				= $_POST['name'];
$email				= $_POST['email'];
$phone				= $_POST['phone'];
$subject 			= $_POST['subject'];
$message_act		= $_POST['message'];
$restaurant_id 		= $_POST['rest_id'];


$sql_res_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$restaurant_id."'"));

$restaurant_name = $sql_res_name['restaurant_name'];
$restaurant_id = $sql_res_name['id'];


if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['captcha_code']) != 0){
	echo 'Error';
	
}else{
	
		
					
			/***************************************** Restaurant Owner **********************************/
			
			
			$res_email = (explode(",",$sql_res_name['email']));//'priya@infosolz.com';
				
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 45"));	
			
			$cms_rep2 = htmlspecialchars_decode(stripslashes($sql_cms['description']));
			
			$cms_rep2=str_replace('%%$res_name%%',$restaurant_name,$cms_rep2);
			$cms_rep2=str_replace('%%$name%%',$name,$cms_rep2);
			$cms_rep2=str_replace('%%$email%%',$email,$cms_rep2);
			$cms_rep2=str_replace('%%$phone%%',$phone,$cms_rep2);
			$cms_rep2=str_replace('%%$subject%%',$subject,$cms_rep2);
			$cms_rep2=str_replace('%%$message%%',$message_act,$cms_rep2);
			$cms_rep2=str_replace('%%$res_name%%',$restaurant_name,$cms_rep2);

			$from2 = "support@foodandmenu.com";

			$headers2 = "From:".$from2."\nReply-To: ".$from2."\nReturn-Path: ".$from2."\nX-Mailer: PHP\n";
			
			$inc = 1;
			foreach($res_email as $val_email){
				if($inc!=1){
					$headers2.= "Bcc:".$val_email."\n";
				}
				$inc++;
			}

			$headers2 .= 'MIME-Version: 1.0' . "\r\n";

			$headers2 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message2=$cms_rep2;

			/*$subject2="Reservation Confirmation mail";*/
			
			$subject2 = stripslashes($sql_cms['subject']);
			
			//mail($res_email,$subject2,$message2,$headers2);
			
			mail($res_email[0],$subject2,$message2,$headers2);
			
			//mail("priya@infosolz.com",$subject2,$message2,$headers2);
			
			
			/******************************************** Customer **************************************/
			
			
			$sql_cms2 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 44"));	
			
			$cms_rep1 = htmlspecialchars_decode(stripslashes($sql_cms2['description']));
			
			$contact_email = $email;
			
			$cms_rep1=str_replace('%%$name%%',$name,$cms_rep1);
			$cms_rep1=str_replace('%%$res_name%%',$restaurant_name,$cms_rep1);
			
			$from1 = "support@foodandmenu.com";

			$headers1 = "From:".$from1."\nReply-To: ".$from1."\nReturn-Path: ".$from1."\nX-Mailer: PHP\n";

			$headers1 .= 'MIME-Version: 1.0' . "\r\n";

			$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message1=$cms_rep1;

			//$subject1="Reservation Confirmation mail";
			
			//$subject1 = stripslashes($sql_cms['subject']);
			
			$subject1 = str_replace('%%$res_name%%',$restaurant_name,$sql_cms2['subject']);

			mail($contact_email,$subject1,$message1,$headers1);
			
			
			echo 'Success';
	
	
	
}
	
		
	
?>