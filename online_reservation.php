<?php
session_start();
include ("admin/lib/conn.php");

$captcha_code 			= $_REQUEST['captcha_code'];

$post_date				=$_REQUEST['post_date_test']; 
			
$month 					= substr($post_date,0,2);
$date  					= substr($post_date,3,2);
$year 					= substr($post_date,6,4);

$posted_date = $year."-".$month."-".$date;

$time			= $_POST['time'];
$how_many_people	= $_POST['how_many_people'];
$special_occasions	= $_POST['special_occasions'];
$customer_name = $_POST['customer_name'];
$contact_email = $_POST['contact_email'];//'priya@infosolz.com'
$customer_phone = $_POST['customer_phone'];
$comments	= $_POST['comments'];
$username = $_POST['customer_name'];
$restaurant_id = $_POST['rest_id'];

if($_POST['special_occasions'] == 'others'){
	$special_occasions = $_POST['others_occassions'];
}else{
	$sql_special_occasion_name = mysql_fetch_array(mysql_query("SELECT occassions FROM restaurant_occassions WHERE id = '".$_POST['special_occasions']."'"));
	$special_occasions = $sql_special_occasion_name['occassions'];
}

$sql_username = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
$sql_res_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$restaurant_id."'"));

$custo_name = $sql_username['firstname']." ".$sql_username['lastname'];

$restaurant_name = $sql_res_name['restaurant_name'];
$restaurant_id = $sql_res_name['id'];


if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['captcha_code']) != 0){
	echo 'Error';
	
}else{
	
	if($_REQUEST['others_occassions'] != '')
	{
		$sql_others_occassions = mysql_query("INSERT INTO restaurant_occassions SET occassions = '".$_REQUEST['others_occassions']."' , status= 'Active' , date_added = NOW()");
		
		$last_id_others_occassions = mysql_insert_id();
		
		$sql_reservation = mysql_query("INSERT INTO restaurant_reservations SET restaurant_id = '".$restaurant_id."', restaurant_name = '".$sql_res_name['restaurant_name']."' , date = '".$posted_date."',time = '".$time."' , people = '".$how_many_people."', special_occassion = '".$last_id_others_occassions."' , contact_email = '".$contact_email."', comments = '".$comments."', customer_id = '".$_SESSION['customer_id']."' , reservation_status = 'pending' , customer_name = '".$customer_name."' , customer_phone = '".$customer_phone."'");
		$res_id = mysql_insert_id();
		
		
	}
	else
	{
	$sql_reservation = mysql_query("INSERT INTO restaurant_reservations SET restaurant_id = '".$restaurant_id."', restaurant_name = '".$sql_res_name['restaurant_name']."' , date = '".$posted_date."',time = '".$time."' , people = '".$how_many_people."', special_occassion = '".$special_occasions."' , contact_email = '".$contact_email."', comments = '".$comments."', customer_id = '".$_SESSION['customer_id']."' , reservation_status = 'pending' , customer_name = '".$customer_name."' , customer_phone = '".$customer_phone."'");
		$res_id = mysql_insert_id();
		
		//$sql_add_point = mysql_query("UPDATE restaurant_customer SET reward_point = reward_point+'1' WHERE id = '".$_SESSION['customer_id']."' ");
		
	}
	
	$curr_date = date('Y-m-d');
		
		$sql_mul_reward = mysql_query("SELECT * FROM restaurant_multiple_reward WHERE start_date <= '".$curr_date."' AND end_date >= '".$curr_date."'");
		
		while($row_mul_reward = mysql_fetch_array($sql_mul_reward))
		{
			 $type_id = explode(",",$row_mul_reward['reward_type']);
			 
			 if(in_array(3 , $type_id))
			 {
				 $point_new = $row_mul_reward['point'];
			 }
			 
			 $sql_reward_point = mysql_query("SELECT * FROM restaurant_point_history WHERE user_id = '".$_SESSION['customer_id']."' AND reward_id = '".$row_mul_reward['id']."'");
			if(mysql_num_rows($sql_reward_point) > 0){
				$sql_add_point = mysql_query("UPDATE restaurant_point_history SET point_added = point_added+'".$point_new."' WHERE user_id = '".$_SESSION['customer_id']."' AND reward_id = '".$row_mul_reward['id']."'");
			}else{
				$sql_add_point = mysql_query("INSERT INTO restaurant_point_history SET point_added = point_added+'".$point_new."' , user_id = '".$_SESSION['customer_id']."' , reward_id = '".$row_mul_reward['id']."'");
			}
			
			 /*$sql_add_point = mysql_query("UPDATE restaurant_customer SET reward_point = reward_point+'".$point_new."' WHERE id = '".$_SESSION['customer_id']."' ");*/
				 
		}
		
		/*if($point_new == ''){
			$sql_get_reward_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));
			$point_new = $sql_get_reward_point['online_reservation'];
		}*/
		
		
		
		
	
	$sql_get_total_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
	
	$sql_min_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));
	
	if($sql_get_total_point['reward_point'] >= $sql_min_point['minimum_reward_point'])
	{
								
								//Mail to Admin //
								
								$name = 'Admin';
								$cust_name = $sql_get_total_point['firstname']." ".$sql_get_total_point['lastname'];
								if($sql_get_total_point['gender'] == 'male')
								{
									$sex = 'His';
								}
								elseif($sql_get_total_point['gender'] == 'female')
								{
									$sex = 'Her';
								}
								elseif($sql_get_total_point['gender'] == '')
								{
									$sex = 'His/Her';
								}
								
								$reward_point = $sql_get_total_point['reward_point'];
								
								$sql_restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$restaurant_id."'"));
								$res_email = (explode(",",$sql_restaurant_name['email']));
	
								$email = $res_email[0];//"priya@infosolz.com"
								$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 35"));  
								  
								$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
								$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
								$cms_rep=str_replace('%%$customer_name%%',$cust_name,$cms_rep);
								$cms_rep=str_replace('%%$sex%%',$sex,$cms_rep);
								$cms_rep=str_replace('%%$reward_point%%',$reward_point,$cms_rep);
								
								
								$from = 'support@foodandmenu.com';
					
								$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
					
								$headers .= 'MIME-Version: 1.0' . "\r\n";
					
								$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
					
								$message=$cms_rep;
					
								//$subject="Gift Certificate";
								
								$subject = stripslashes($sql_cms['subject']);
								
								$inc = 1;
								foreach($res_email as $val_email){
									if($inc!=1){
										$headers.= "Bcc:".$val_email."\n";
									}
									$inc++;
								}
								
								mail($email,$subject,$message,$headers);
								
								//Mail to Customer
								
								
								
								/*$sql_get_total_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
								$email_cust = $sql_get_total_point['email'];
								$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 36"));  
								  
								$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
								//$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
								$cms_rep=str_replace('%%$customer_name%%',$cust_name,$cms_rep);
								//$cms_rep=str_replace('%%$sex%%',$sex,$cms_rep);
								$cms_rep=str_replace('%%$reward_point%%',$reward_point,$cms_rep);
								
								
								$from = 'support@foodandmenu.com';
					
								$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
					
								$headers .= 'MIME-Version: 1.0' . "\r\n";
					
								$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
					
								$message=$cms_rep;
					
								//$subject="Gift Certificate";
								
								$subject = stripslashes($sql_cms['subject']);
								
								mail($email_cust,$subject,$message,$headers);*/
	}
	
		
			
			$reservation_id = $res_id;
			
			/************************************************** Admin ************************************/
				
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 16"));
			
			$admin_email_address = $sql_cms1['email_address'];//'priya@infosolz.com'
			
			$arr_email_address = explode(",",$admin_email_address);
				
			$email = 'support@foodandmenu.com';//"priya@infosolz.com"
			
			$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
			
			$cms_rep=str_replace('%%$username%%',$username,$cms_rep);
			$cms_rep=str_replace('%%$post_date%%',$post_date,$cms_rep);
			$cms_rep=str_replace('%%$time%%',$time,$cms_rep);
			$cms_rep=str_replace('%%$how_many_people%%',$how_many_people,$cms_rep);
			$cms_rep=str_replace('%%$special_occasions%%',$special_occasions,$cms_rep);
			$cms_rep=str_replace('%%$comments%%',$comments,$cms_rep);	
			$cms_rep=str_replace('%%$customer_phone%%',$customer_phone,$cms_rep);
			
			$from = $contact_email;

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message=$cms_rep;

			//$subject="Reservation Request";
			
			$subject = stripslashes($sql_cms['subject']);

			//mail($email,$subject,$message,$headers);
			
			foreach($arr_email_address as $val_email){
				mail($val_email,$subject,$message,$headers);
			}
			
			
			/***************************************** Restaurant Owner **********************************/
			
			
			$res_email = (explode(",",$sql_res_name['email']));//'priya@infosolz.com'
				
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 18"));	
			
			$cms_rep2 = htmlspecialchars_decode(stripslashes($sql_cms['description']));
			
			$cms_rep2=str_replace('%%$username%%',$username,$cms_rep2);
			$cms_rep2=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep2);
			$cms_rep2=str_replace('%%$post_date%%',$post_date,$cms_rep2);
			$cms_rep2=str_replace('%%$time%%',$time,$cms_rep2);
			$cms_rep2=str_replace('%%$how_many_people%%',$how_many_people,$cms_rep2);
			$cms_rep2=str_replace('%%$special_occasions%%',$special_occasions,$cms_rep2);
			//$cms_rep2=str_replace('%%$contact_email%%',$contact_email,$cms_rep2);
			$cms_rep2=str_replace('%%$comments%%',$comments,$cms_rep2);	
			$cms_rep2=str_replace('%%$restaurant_id%%',$restaurant_id,$cms_rep2);	
			$cms_rep2=str_replace('%%$reservation_id%%',$reservation_id,$cms_rep2);
			$cms_rep2=str_replace('%%$customer_phone%%',$customer_phone,$cms_rep2);

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
			
			
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 17"));	
			
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

			mail($contact_email,$subject1,$message1,$headers1);
			
			
			echo 'Success';
	
	
	
}
	
		
	
?>