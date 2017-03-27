<?php 
ob_start();
session_start();
//print_r($_SESSION);
function change_dateformat($date_form)
	{
	 if($date_form!=''){
	  $date1=explode("-",$date_form);
	  $dateformat=$date1[2]."-".$date1[0]."-".$date1[1];
	  return $dateformat;
	}
	else{
	  $dateformat='';
	  return $dateformat;
	}
}

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
include("includes/rest_header.php");
include("includes/functions.php");
include("admin/lib/conn.php");
//echo "select * from restaurant_customer where id='".$_SESSION['customer_id']."'";

include("authnetfunction_helper.php");
if($_REQUEST['submit']=="Submit")
{
	
	
				//echo 1;	
				/*$loginname = '9U6b68Xafah';
				$transactionkey = '3T274U3nZv73ttRH';
				$host = 'https://test.authorize.net/gateway/transact.dll';*/
				
				$loginname = '7wBx8D5R';
				$transactionkey = '674tq954ZKzchRSB';
				$host = 'https://secure.authorize.net/gateway/transact.dll';
				
				//$host = 'apitest.authorize.net';
				
				
				/*$loginname = '7wBx8D5R';
				$transactionkey = '6Qz69fSFdT23bj9B';
				$host = 'api.authorize.net';*/
				
				/*$loginname = '43uQjM4m7u3f';
				$transactionkey = '5Qmr8jq6WY4z87An';
				$host = 'apitest.authorize.net';*/
				
				$path = '/xml/v1/request.api';
				$amount=$_SESSION['ammount'];
				$quant = 0;
				$name = $_REQUEST['first_name'];
				$length = $_REQUEST['length'];
				$unit = $_REQUEST['unit'];
				$unit_in_db=($unit=='months')?1:2;
				$startDate = $_REQUEST['startDate'];
				$totalOccurrences = $_REQUEST['totalOccurrences'];
				$trialOccurrences = $_REQUEST['trialOccurrences'];
				$trialAmount = $_REQUEST['trialAmount'];
				$cardNumber = $_REQUEST['cardNumber'];
				$expirationDate = $_REQUEST['exp_month']."/".$_REQUEST['exp_year'];
				$expirationDt = explode('/',$expirationDate);	
				$expirationDate = "20".$expirationDt[1].'-'.$expirationDt[0];	
				$firstName = $_REQUEST['first_name'];
				$lastName = $_REQUEST['last_name'];
				$address = $_REQUEST['address'];
				$city = $_REQUEST['city'];
				$state = $_REQUEST['state'];
				$zip = $_REQUEST['zip'];
				$phone = $_REQUEST['phone'];
				$email = $_REQUEST['email'];
				
				
				/// *****************************************  validating data ******************************** 
				$exp_dt_flag=1; //setting expiration date flag as error-free by default
				
				$exp_dt_arr=explode('-',$expirationDate);
				$exp_year='20'.$exp_dt_arr[0];
				$exp_month=$exp_dt_arr[1];
				
				$current_month = date("m"); 
				$current_year = date("Y"); 
				if ($exp_year < $current_year) 
				{ 
					$exp_dt_flag=0; //flag is set to error 
				} 
				else 
				{ 
					// Check if the same year, 
					// if so, make sure month is current or later 
					if ($exp_year == $current_year) 
					{ 
						if ($exp_month < $current_month) 
						{ 
							$exp_dt_flag=0; //flag is set to error 
						} 
					} 
				}
		
				$cc_flag=1;// setting credit-card flag as error-free by default
				
				// The credit card number
				
				// Our starting checksum
				$checksum = 0;
				
				// Alternating value of 1 or 2
				$j = 1;
				
				// Process each digit one by one starting at the right
				for ($i = strlen($cardNumber) - 1; $i >= 0; $i--)
				{
					// Extract the next digit and multiply by 1 or 2 on alternative digits.
					$calc = substr($cardNumber, $i, 1) * $j;
					//
					// If the result is in two digits add 1 to the checksum total
					if ($calc > 9)
					{
						$checksum = $checksum + 1;
						$calc = $calc - 10;
					}
					
					// Add the units element to the checksum total
					$checksum += $calc;
					//
					// Switch the value of j
					if ($j == 1)
					{
						$j = 2;
					}
					else
					{
						$j = 1;
					}
				}
				
				// If checksum is divisible by 10 the credit card number is valid
				if ($checksum % 10 != 0)
				{
				   $cc_flag=0;
				}
				
				$first_number = substr($cardNumber, 0, 1);
				switch ($first_number) 
				{ 
					case 3: 
					if (preg_match('/^3\d{3}[ \-]?\d{6}[ \-]?\d{5}$/', $cardNumber)) 
					{ 
						// American Express number is correct. Process the credit card. 
					} 
					else 
					{ 
						$cc_flag=0; // error 
					} 
					break; 
					case 4: 
					if (preg_match('/^4\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $cardNumber)) 
					{ 
						// Visa number is correct. Process the credit card. 
					} 
					else 
					{ 
						$cc_flag=0; // error 
					} 
					break; 
					case 5: 
					if (preg_match('/^5\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $cardNumber)) 
					{ 
						// MasterCard number is correct. Process the credit card. 
					} 
					else 
					{ 
						$cc_flag=0; // error 
					}
					break; 
					case 6:
					if (preg_match('/^6011[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $cardNumber))
					{
						// Discover Card number is correct. Process the credit card. 
					} 
					else 
					{ 
						$cc_flag=0;// error 
					} 
					break; 
					default: 
					$cc_flag=0;// error 
				}
				// ********************************************** ********************************** 
				//$exp_dt_flag=1;
				//$cc_flag=1;
				if($exp_dt_flag && $cc_flag)
				{
		
					//build xml to post
					/*$content =
							"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
							"<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
							"<merchantAuthentication>".
							"<name>" . $loginname . "</name>".
							"<transactionKey>" . $transactionkey . "</transactionKey>".
							"</merchantAuthentication>".
							"<refId></refId>".
							"<subscription>".
							"<name>" . $name . "</name>".
							"<paymentSchedule>".
							"<interval>".
							"<length>". $length ."</length>".
							"<unit>". $unit ."</unit>".
							"</interval>".
							"<startDate>" . $startDate . "</startDate>".
							"<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
							"<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
							"</paymentSchedule>".
							"<amount>". $amount ."</amount>".
							"<trialAmount>" . $trialAmount . "</trialAmount>".
							"<payment>".
							"<creditCard>".
							"<cardNumber>" . $cardNumber . "</cardNumber>".
							"<expirationDate>" . $expirationDate . "</expirationDate>".
							"</creditCard>".
							"</payment>".
							"<billTo>".
							"<firstName>". $firstName . "</firstName>".
							"<lastName>" . $lastName . "</lastName>".
							"</billTo>".
							"</subscription>".
							"</ARBCreateSubscriptionRequest>";*/
							
					require_once 'anet_php_sdk/AuthorizeNet.php'; 
					define("AUTHORIZENET_API_LOGIN_ID", $loginname); 
					define("AUTHORIZENET_TRANSACTION_KEY", $transactionkey); 
					define("AUTHORIZENET_SANDBOX", false); 
					$sale = new AuthorizeNetAIM;
					$sale->amount = $amount; 
					$sale->card_num = $cardNumber; 
					$sale->exp_date = $expirationDate;
					$sale->description = "Deal Purchase";
					$sale->first_name = $firstName; 
					$sale->last_name = $lastName; 
					$sale->address = $address;
					$sale->city = $city;
					$sale->state = $state;
					$sale->zip = $zip;
					$sale->phone = $phone;
					$sale->email = $email;
					$response = $sale->authorizeAndCapture(); 
					/*echo '<pre>';
					print_r($response);
					echo '</pre>';
					exit;*/
					/*if ($response->approved) { 
						$transaction_id = $response->transaction_id; 
					}*/
					
					//send the xml via curl
					//$response = send_request_via_curl($host,$path,$content);
					//if curl is unavilable you can try using fsockopen
					/*
					$response = send_request_via_fsockopen($host,$path,$content);
					*/
					
					
					//if the connection and send worked $response holds the return from Authorize.net
					if ($response)
					{
						/*
						a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
						please explore using SimpleXML in php 5 or xml parsing functions using the expat library
						in php 4
						parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
						*/
						//list ($refId, $resultCode, $code, $text, $subscriptionId) =parse_return($response);
						$subscriptionId = $response->transaction_id;
						$refId = $response->authorization_code;
						$text = $response->response_reason_text;
							
						if($response->approved == 1)
						{
							 $email= $_REQUEST['email'];//"priya@infosolz.com";
							 $deal_card_id=explode(',',$_SESSION['card_array']);
							 
							 $sql_giftcard = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_cms WHERE page_id = 12"));
							 
							 foreach($deal_card_id as $deal_id)
							 {
								 
								  
							
							//$certificate_no = '00110-'.$unique_no;
							
							//$randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
							
								 $sql_deal=mysql_fetch_array(mysql_query("select * from restaurant_deals where id='".$deal_id."'"));
								 
								 $basic_info_detail=mysql_fetch_array(mysql_query("select * from restaurant_basic_info where id='".$sql_deal['restaurant_id']."'"));
															 
								 $disclaimer_sq = mysql_query("SELECT * FROM restaurant_disclaimer WHERE restaurant_id = '".$sql_deal['restaurant_id']."'");
								 $disclaimer_rws = mysql_num_rows($disclaimer_sq);
								 $disclaimer_info = mysql_fetch_array($disclaimer_sq);
								 
								 $disclaimer = $sql_deal['disclaimer_title']."<br>".$sql_deal['disclaimer'];
								 
								 
								 $sql_select_qty = mysql_fetch_array(mysql_query("SELECT qty FROM restaurant_cart WHERE deal_id = '".$deal_id."' AND customer_id = '".$_SESSION['customer_id']."'"));
								 
								 for($i=0;$i<$sql_select_qty['qty'];$i++)
								 {
									 
									
									$unique_no = mt_rand(1000,9999);
									
									$certificate_no = '00110-'.$unique_no;
							
									$randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
									 
									$sql_insert_certificate_details = mysql_query("INSERT INTO restaurant_gift_certificate_no SET deal_id = '".$deal_id."' , restaurant_id = '".$sql_deal['restaurant_id']."' , certificate_no = '".$certificate_no."' , validation_code = '".$randomString."' , expiry_date = '".$sql_deal['expiry_date']."' , customer_id = '".$_SESSION['customer_id']."' ");
								 
								 $sql_insert_certificate_details_last_id = mysql_insert_id();
								 
								 //$sql_get_reward_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));
								 
								$curr_date = date('Y-m-d');
		
								$sql_mul_reward = mysql_query("SELECT * FROM restaurant_multiple_reward WHERE start_date <= '".$curr_date."' AND end_date >= '".$curr_date."'");
								
								while($row_mul_reward = mysql_fetch_array($sql_mul_reward))
								{
									 $type_id = explode(",",$row_mul_reward['reward_type']);
									 
									 if(in_array(2 , $type_id))
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
								
								$sql_restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
								$res_email = (explode(",",$sql_restaurant_name['email']));
	
								$email = $res_email[0];
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
								 
								 
								 $daily_description = $sql_deal['daily_description'];
								 $daily_price = $sql_deal['daily_price'];
								 $restaurant_name = stripslashes($basic_info_detail['restaurant_name']);
								 $date = change_dateformat_reverse(date('Y-m-d'));
								 $restaurant_address = $basic_info_detail['restaurant_address'];
								 $restaurant_full_address = $basic_info_detail['restaurant_address']." ".$basic_info_detail['restaurant_state']." ".$basic_info_detail['restaurant_city']." ".$basic_info_detail['restaurant_zipcode'];
								 $phone = $basic_info_detail['phone'];
								 $expiry_date = date("d-m-Y", strtotime($sql_deal['expiry_date']));
								 $special_rules = $sql_deal['special_rules'];
								 $validation_code = $randomString;
								 
								 
								 /********************************************* Gift Certificate To Customer **********************************************/
										 
								
								  
								$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 23"));  
								  
								$giftcard_header = htmlspecialchars_decode(stripslashes($sql_cms['description']));
								
								if($disclaimer_info['description']!=''){
									  $giftcard_header.='<tr>
										<td colspan="2"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px; margin-top: 15px;">'.$disclaimer_info['disclaimer'].'</h1>
										<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$disclaimer_info['description'].'</h2>
										</td>
								  </tr>';
								  }
								$giftcard_header.='</table>';
								
								$giftcard_header=str_replace('%%$certificate_no%%',$certificate_no,$giftcard_header);
								$giftcard_header=str_replace('%%$daily_description%%',$daily_description,$giftcard_header);
								$giftcard_header=str_replace('%%$daily_price%%',$daily_price,$giftcard_header);
								$giftcard_header=str_replace('%%$restaurant_name%%',$restaurant_name,$giftcard_header);
								$giftcard_header=str_replace('%%$date%%',$date,$giftcard_header);
								$giftcard_header=str_replace('%%$restaurant_address%%',$restaurant_full_address,$giftcard_header);
								$giftcard_header=str_replace('%%$phone%%',$phone,$giftcard_header);
								$giftcard_header=str_replace('%%$expiry_date%%',$expiry_date,$giftcard_header);
								$giftcard_header=str_replace('%%$special_rules%%',$special_rules,$giftcard_header);
								$giftcard_header=str_replace('%%$disclaimer%%',$disclaimer,$giftcard_header);
								$giftcard_header=str_replace('%%$validation_code%%',$validation_code,$giftcard_header);
								  
								$giftcard_footer = htmlspecialchars_decode($sql_giftcard['description']);
								
								
								$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
								  
								  if($disclaimer_info['description']!=''){
									  $cms_rep.='<tr>
										<td colspan="2"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">'.$disclaimer_info['disclaimer'].'</h1>
										<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$disclaimer_info['description'].'</h2>
										</td>
								  </tr>';
								  }
								  
	
								$cms_rep.='</table></div>';
	  
								$cms_rep.= htmlspecialchars_decode($sql_giftcard['description']);
								
								$cms_rep=str_replace('%%$certificate_no%%',$certificate_no,$cms_rep);
								$cms_rep=str_replace('%%$daily_description%%',$daily_description,$cms_rep);
								$cms_rep=str_replace('%%$daily_price%%',$daily_price,$cms_rep);
								$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
								$cms_rep=str_replace('%%$date%%',$date,$cms_rep);
								$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_full_address,$cms_rep);
								$cms_rep=str_replace('%%$phone%%',$phone,$cms_rep);
								$cms_rep=str_replace('%%$expiry_date%%',$expiry_date,$cms_rep);
								$cms_rep=str_replace('%%$special_rules%%',$special_rules,$cms_rep);
								$cms_rep=str_replace('%%$disclaimer%%',$disclaimer,$cms_rep);
								$cms_rep=str_replace('%%$validation_code%%',$validation_code,$cms_rep);
								
								$email_cus = $_REQUEST['email'];
								
								$from = 'support@foodandmenu.com';
					
								$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
					
								$headers .= 'MIME-Version: 1.0' . "\r\n";
					
								$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
					
								$message=$cms_rep;
					
								//$subject="Gift Certificate";
								
								$subject = stripslashes($sql_cms['subject']);
								$subject = str_replace('%%$certificate_no%%',$certificate_no,$subject);
								
								mail($email_cus,$subject,$message,$headers);
				
								/********************************************** Purchase Details To Customer *********************************************/
								
								$name = $_REQUEST['first_name']." ".$_REQUEST['last_name'];
								$firstname = $_REQUEST['first_name'];
								$lastname = $_REQUEST['last_name'];
								$email_add = $_REQUEST['email'];
								$phone = $_REQUEST['phone'];
								$address = $_REQUEST['address'];
								$city = $_REQUEST['city'];
								$state = $_REQUEST['state'];
								$zip = $_REQUEST['zip'];
								$tot_amt = $_SESSION['ammount'];
								$content = $sql_admin_email['content'];
								
								
								$email1= $_REQUEST['email'];//"priya@infosolz.com";
											
								$sql_customer_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
								
								
									mysql_query("INSERT INTO  restaurant_gift_card set restaurant_id=".$sql_deal['restaurant_id'].", restaurant_name = '".$basic_info_detail['restaurant_name']."' ,deal_id=".$deal_id.",price=".$sql_deal['daily_price'].",purchase_date='".date('Y-m-d')."',deal = '".$sql_deal['daily_name']."',email = '".$sql_customer_info['email']."',customer_id = '".$sql_customer_info['id']."',user_name = '".$sql_customer_info['firstname']."',city = '".$basic_info_detail['restaurant_city']."',state = '".$basic_info_detail['restaurant_state']."',status = 'Pending'");	
									$sql_insert_giftcard_id = mysql_insert_id();
								 
								 
								 $sql_insert_credit_card_details = mysql_query("INSERT INTO giftcard_id = '".$sql_insert_giftcard_id."' , card_type = '".$_REQUEST['card_type']."' , card_no = '".$_REQUEST['card_no']."' , cvv_no = '".$_REQUEST['cvv_no']."' , expiry_date = '".$_REQUEST['exp_month']."-".$_REQUEST['exp_year']."' ");
								 
								$sql_giftcard_html = mysql_query("INSERT INTO restaurant_giftcard_html SET giftcard_id = '".$sql_insert_giftcard_id."' , giftcard_header = '".$giftcard_header."' , giftcard_footer = '".$giftcard_footer."'");
								
								$sql_update_gift_cer = mysql_query("UPDATE restaurant_gift_certificate_no SET giftcard_id = '".$sql_insert_giftcard_id."' WHERE id = '".$sql_insert_certificate_details_last_id."'");
								
								
								 
								
								$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 24"));	
								
								$cms_rep1 = htmlspecialchars_decode(stripslashes($sql_cms['description']));
								
								$cms_rep1=str_replace('%%$name%%',$name,$cms_rep1);
								$cms_rep1=str_replace('%%$firstname%%',$firstname,$cms_rep1);
								$cms_rep1=str_replace('%%$lastname%%',$lastname,$cms_rep1);
								$cms_rep1=str_replace('%%$email_add%%',$email_add,$cms_rep1);
								$cms_rep1=str_replace('%%$phone%%',$phone,$cms_rep1);
								$cms_rep1=str_replace('%%$address%%',$address,$cms_rep1);
								$cms_rep1=str_replace('%%$city%%',$city,$cms_rep1);
								$cms_rep1=str_replace('%%$state%%',$state,$cms_rep1);
								$cms_rep1=str_replace('%%$zip%%',$zip,$cms_rep1);
								$cms_rep1=str_replace('%%$tot_amt%%',$tot_amt,$cms_rep1);	
								$cms_rep1=str_replace('%%$disclaimer%%',$disclaimer,$cms_rep1);	
								$cms_rep1=str_replace('%%$validation_code%%',$validation_code,$cms_rep1);				
								
								$from = 'support@foodandmenu.com';
								
								$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
								
								$headers .= 'MIME-Version: 1.0' . "\r\n";
								
								$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
								
								$message1=$cms_rep1;
								
								
								$subject1 = stripslashes($sql_cms['subject']);
								$subject1 = str_replace('%%$certificate_no%%',$certificate_no,$subject1);
								
								mail($email1,$subject1,$message1,$headers);
						
								//-------------For Admin---------------//
								
								$sql_admin_email = mysql_fetch_array(mysql_query("SELECT content FROM restaurant_payment_email where id=1"));
								
								$admin_email_address = $sql_admin_email['email_address'];
				
								$arr_email_address = explode(",",$admin_email_address);
								
								$admin_email = 'support@foodandmenu.com';//"priya@infosolz.com";
								
								
											
								$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 25"));	
				
								$cms_rep_admin = htmlspecialchars_decode(stripslashes($sql_cms['description']));
								
								$cms_rep_admin=str_replace('%%$content%%',$content,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$firstname%%',$firstname,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$lastname%%',$lastname,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$email_add%%',$email_add,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$phone%%',$phone,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$address%%',$address,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$city%%',$city,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$state%%',$state,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$zip%%',$zip,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$certificate_no%%',$certificate_no,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$daily_description%%',$daily_description,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$tot_amt%%',$tot_amt,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$disclaimer%%',$disclaimer,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$validation_code%%',$validation_code,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$gift_certificate_id%%',$sql_insert_certificate_details_last_id,$cms_rep_admin);
										
								
								$from = 'support@foodandmenu.com';
								
								$headers1 = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
								
								$headers1 .= 'MIME-Version: 1.0' . "\r\n";
								
								$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
								
								$message2=$cms_rep_admin;
								
								//$subject2="Customer Purchase Details";
								
								$subject2 = stripslashes($sql_cms['subject']);
								$subject2 = str_replace('%%$certificate_no%%',$certificate_no,$subject2);
								
								mail($admin_email,$subject2,$message2,$headers1);
								
								foreach($arr_email_address as $val_email){
									mail($val_email,$subject2,$message2,$headers1);
								}
								
								//------------------------------------//
								
								//-------------For Restaurant Owner---------------//
								
								$sql_admin_email=mysql_fetch_array(mysql_query("SELECT content FROM restaurant_payment_email where id=1"));
								
								$res_email = (explode(",",$basic_info_detail['email']));
								
								$ret_own_email = $res_email[0];//"sourav.de@infosolz.com";
								
								
											
								$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 31"));	
				
								$cms_rep_admin = htmlspecialchars_decode(stripslashes($sql_cms['description']));
								
								$cms_rep_admin=str_replace('%%$content%%',$content,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$firstname%%',$firstname,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$lastname%%',$lastname,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$phone%%',$phone,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$address%%',$address,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$city%%',$city,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$state%%',$state,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$zip%%',$zip,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$certificate_no%%',$certificate_no,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$daily_description%%',$daily_description,$cms_rep_admin);	
								$cms_rep_admin=str_replace('%%$tot_amt%%',$tot_amt,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$disclaimer%%',$disclaimer,$cms_rep_admin);
								$cms_rep_admin=str_replace('%%$gift_certificate_id%%',$sql_insert_certificate_details_last_id,$cms_rep_admin);
										
								
								$from = 'support@foodandmenu.com';
								
								$headers1 = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
								
								$inc = 1;
								foreach($res_email as $val_email){
									if($inc!=1){
										$headers1.= "Bcc:".$val_email."\n";
									}
									$inc++;
								}
								
								$headers1 .= 'MIME-Version: 1.0' . "\r\n";
								
								$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
								
								$message2 = $cms_rep_admin;
								
								$subject2 = stripslashes($sql_cms['subject']);
								$subject2 = str_replace('%%$certificate_no%%',$certificate_no,$subject2);
								
								mail($ret_own_email,$subject2,$message2,$headers1);
								
								}
								
								//------------------------------------//
		
								$del_cart=mysql_query("delete from restaurant_cart where customer_id='".$_SESSION['customer_id']."'");
								unset($_SESSION['card_array']);
								unset($_SESSION['ammount']);
								header("location:paymentdetails.php?msg=success");
								
		
		}
							
						}
						else
						{
							$err_msg="<font color='red'>".$text."</font>";
						}
						$fp = fopen('data.log', "a");
						fwrite($fp, "<HR>\r\n");
						fwrite($fp, date('h-i A, Y-m-d')."\r\n");
						fwrite($fp, "$refId\r\n");
						fwrite($fp, "$subscriptionId\r\n");
						fwrite($fp, "$amount\r\n");
						fclose($fp);
					}
					else
					{
						$err_msg="<font color='red'>Transaction Failed.</font>";
					}
				}
				else
				{
					if($exp_dt_flag==0)
					{
						$err_msg="<font color='red'>The credit card has already expired!<font><br>";
					}
					if($cc_flag==0)
					{
						$err_msg.="<font color='red'>The credit card number is NOT valid!<font>";
					}
				}
}
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">

function submit_frm(){
	document.getElementById('fade11').style.display = 'block';
	document.getElementById('submit_div').style.display = 'block';
}


/*function disable_btn(){
$("#btn1").attr("disabled", true);
$("#btn1").val('Please wait Processing');
// Write your Code
document.getElementById("frm").submit();
return true;

}*/

</script>
<script language="javascript">
function Mod10(ccNumb){  // v2.0
var valid = "0123456789"  // Valid digits in a credit card number
var len = ccNumb.length;  // The length of the submitted cc number
var iCCN = parseInt(ccNumb);  // integer of ccNumb
var sCCN = ccNumb.toString();  // string of ccNumb
sCCN = sCCN.replace (/^\s+|\s+$/g,'');  // strip spaces
var iTotal = 0;  // integer total set at zero
var bNum = true;  // by default assume it is a number
var bResult = false;  // by default assume it is NOT a valid cc
var temp;  // temp variable for parsing string
var calc;  // used for calculation of each digit

// Determine if the ccNumb is in fact all numbers
for (var j=0; j<len; j++) {
  temp = "" + sCCN.substring(j, j+1);
  if (valid.indexOf(temp) == "-1"){bNum = false;}
}

// if it is NOT a number, you can either alert to the fact, or just pass a failure
if(!bNum){
  /*alert("Not a Number");*/bResult = false;
}

// Determine if it is the proper length 
if((len == 0)&&(bResult)){  // nothing, field is blank AND passed above # check
  bResult = false;
} else{  // ccNumb is a number and the proper length - let's see if it is a valid card number
  if(len >= 15){  // 15 or 16 for Amex or V/MC/
    for(var i=len;i>0;i--){  // LOOP throught the digits of the card
      calc = parseInt(iCCN) % 10;  // right most digit
      calc = parseInt(calc);  // assure it is an integer
      iTotal += calc;  // running total of the card number as we loop - Do Nothing to first digit
      i--;  // decrement the count - move to the next digit in the card
      iCCN = iCCN / 10;                               // subtracts right most digit from ccNumb
      calc = parseInt(iCCN) % 10 ;    // NEXT right most digit
      calc = calc *2;                                 // multiply the digit by two
      // Instead of some screwy method of converting 16 to a string and then parsing 1 and 6 and then adding them to make 7,
      // I use a simple switch statement to change the value of calc2 to 7 if 16 is the multiple.
      switch(calc){
        case 10: calc = 1; break;       //5*2=10 & 1+0 = 1
        case 12: calc = 3; break;       //6*2=12 & 1+2 = 3
        case 14: calc = 5; break;       //7*2=14 & 1+4 = 5
        case 16: calc = 7; break;       //8*2=16 & 1+6 = 7
        case 18: calc = 9; break;       //9*2=18 & 1+8 = 9
        default: calc = calc;           //4*2= 8 &   8 = 8  -same for all lower numbers
      }                                               
    iCCN = iCCN / 10;  // subtracts right most digit from ccNum
    iTotal += calc;  // running total of the card number as we loop
  }  // END OF LOOP
  if ((iTotal%10)==0){  // check to see if the sum Mod 10 is zero
    bResult = true;  // This IS (or could be) a valid credit card number.
  } else {
    bResult = false;  // This could NOT be a valid credit card number
    }
  }
}
// change alert to on-page display or other indication as needed.
if(bResult) {
  //alert("This IS a valid Credit Card Number!");
}
if(!bResult){
  alert("The entered Credit Card Number is NOT valid!");
}
  return bResult; // Return the results
}
function check_auth()
{
	document.frm.card_type.value=document.frm.card_type.value;
	document.frm.cardNumber.value=document.frm.cardNumber.value;
	document.frm.expirationDate.value=document.frm.expirationDate.value;
	
	if (document.frm.card_type.value=="select_card")
    {
        alert ( "Please select the card type." );
		document.frm.card_type.focus();
        return false;
    }
	
	 
	if ( document.frm.cardNumber.value == "" )
    {
        alert ( "Please enter the card number." );
		document.frm.cardNumber.focus();
        return false;
    }
	
	if ( document.frm.cardNumber.value == "" )
    {
        alert ( "Please enter the card number." );
		document.frm.cardNumber.focus();
        return false;
    }
	if (document.frm.cardNumber.value!="")
	{
	   var status=Mod10(document.frm.cardNumber.value);
	   if(!status)
	   {
		   document.frm.cardNumber.focus();
	       return false;
	   }
	}
	if(document.frm.card_type.value=='visa' && document.frm.cardNumber.value.charAt(0)!='4')
	{
		alert ( "The Credit Card Number does NOT seem to be of Visa!\n Please select proper card type." );
		document.frm.cardNumber.focus();
        return false;
	}
	if(document.frm.card_type.value=='master_card' && document.frm.cardNumber.value.charAt(0)!='5')
	{
		alert ( "The Credit Card Number does NOT seem to be of MasterCard!\n Please select proper card type." );
		document.frm.cardNumber.focus();
        return false;
	}
	if(document.frm.card_type.value=='disco' && document.frm.cardNumber.value.charAt(0)!='6')
	{
		alert ( "The Credit Card Number does NOT seem to be of Discover!\n Please select proper card type." );
		document.frm.cardNumber.focus();
        return false;
	}
	if(document.frm.card_type.value=='amex' && document.frm.cardNumber.value.charAt(0)!='3')
	{
		alert ( "The Credit Card Number does NOT seem to be of AmEx!\n Please select proper card type." );
		document.frm.cardNumber.focus();
        return false;
	}
	
	document.frm.buttonclick.value="auth";
	return true;
	
}
function getkey(e)
{
	if (window.event)
	return window.event.keyCode;
	else if (e)
	return e.which;
	else
	return null;
}
function goodchars(e, goods)
{
	var key, keychar;
	key = getkey(e);
	if (key == null) return true;
	keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	goods = goods.toLowerCase();
	if (goods.indexOf(keychar) != -1)
	return true;
	if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
	return true;
	return false;
}
function check_it()
{
	
	
	//if(document.getElementById('amount').value==0)
//	{
//		alert ( "Please choose atleast one course." );
//		return false;
//	}
	if ( document.frm.cardNumber.value == "" )
    {
        alert ( "Please enter the card number." );
		document.frm.cardNumber.focus();
        return false;
    }
	if (document.frm.cardNumber.value!="")
	{
		var status=Mod10(document.frm.cardNumber.value);
		if(!status)
		{
		   document.frm.cardNumber.focus();
		   return false;
		}
	}
	if(document.frm.card_type.value=='visa' && document.frm.cardNumber.value.charAt(0)!='4')
	{
		alert ( "The Credit Card Number does NOT seem to be of Visa!\n Please select proper card type." );
		document.frm.cardNumber.focus();
        return false;
	}
	if(document.frm.card_type.value=='master_card' && document.frm.cardNumber.value.charAt(0)!='5')
	{
		alert ( "The Credit Card Number does NOT seem to be of MasterCard!\n Please select proper card type." );
		document.frm.cardNumber.focus();
        return false;
	}
	if(document.frm.card_type.value=='disco' && document.frm.cardNumber.value.charAt(0)!='6')
	{
		alert ( "The Credit Card Number does NOT seem to be of Discover!\n Please select proper card type." );
		document.frm.cardNumber.focus();
        return false;
	}
	if(document.frm.card_type.value=='amex' && document.frm.cardNumber.value.charAt(0)!='3')
	{
		alert ( "The Credit Card Number does NOT seem to be of AmEx!\n Please select proper card type." );
		document.frm.cardNumber.focus();
        return false;
	}
	
	document.frm.buttonclick.value="sale";
	return true;
	
}

</script>

<link rel="stylesheet" href="calender/jquery-ui.css" />
<script src="calender/jquery-1.8.3.js"></script>
<script src="calender/jquery-ui.js"></script>

<script type="text/javascript">
$(function() {
	$( "#expiry_date" ).datepicker({
		dateFormat:"mm/y"
	});
	//$( "#expiry_date" ).datepicker( "mm/yy", "dateFormat" );
});
</script>


<style type="text/css">
#fade11{
	width: 100%;
	height: 800px;
	position: fixed;
	z-index: 50;
	background: rgb(223, 105, 0);
	opacity: 0.5;
}
</style>
<body>
<?php if($_REQUEST['msg'] == 'success'){ $display = 'block'; }else{ $display = 'none'; }?>
          
<div id="fade11" style="display:<?php echo $display; ?>;"></div>

<div style="width:400px; height:1px; margin:0 auto; display:<?php echo $display; ?>;" id="light">
<div class="pop-box"  style="position:absolute; z-index:9999999; background:#EFEFEF; padding:34px 24px; color:#000; font-family:Calibri; font-size:18px; -moz-box-shadow: 0 0 5px #888; -webkit-box-shadow: 0 0 5px#888; box-shadow: 0 0 5px #888; text-align:center; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border:#2C4598 2px solid;position: fixed; left: 0px; top: 0px; margin:200px 0 0 500px; z-index: 9999999;">

<a href = "index.php" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade11').style.display='none';document.getElementById('fade').style.display='none'"><img src="images/fancy_closebox.png" style="position:absolute; right:-13px; top:-13px;"/></a>
<img src="images/success-icon.png"/>
<?php if($_REQUEST['msg'] == 'success'){ ?><p>Payment successfully done</p><?php } ?>               
</div></div>

<div style="width:400px; height:1px; margin:0 auto; display:none;" id="submit_div">
<div class="pop-box"  style="width:300px; position:absolute; z-index:9999999; background:#EFEFEF; padding:34px 24px; color:#000; font-family:Calibri; font-size:18px; -moz-box-shadow: 0 0 5px #888; -webkit-box-shadow: 0 0 5px#888; box-shadow: 0 0 5px #888; text-align:center; margin-top:700px; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border:#2C4598 2px solid;">
<img src="images/ajax-loader.gif" align="middle" style="margin-left:40px;"/> <br>
<p style="color:rgb(73, 96, 168);">Please wait until we process for payment.</p>               
</div></div>

<?php //print_r($_SESSION);?>
<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php"); ?>

<div class="body_section">
<form name="frm" id="frm" action="" method="post" onSubmit="return submit_frm();">
<input type="hidden" name="today" id="today" value="<?php echo date('m/y'); ?>">
<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>Payment Details Page</h1>
</div>

<div class="payment_cont_field">

<?php if(!empty($err_msg)){ ?>
          <div><p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#DC3646; font-weight:bold; text-align:center; border:1px solid;"><?php echo $err_msg; ?></p></div>
          <?php } ?>
          <?php if($exp_dt_flag_msg!='' || $cc_flag_msg!='' || ($cc_flag!='' && $cc_flag!=1 && $cc_flag!=0)){ ?>
          <div><p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#DC3646; font-weight:bold; text-align:center; border:1px solid;"><?php echo $exp_dt_flag_msg."<br>".$cc_flag_msg."<br>".$cc_flag; ?></p></div>
          <?php }?>
<div align="center">

<input type="hidden" name="buttonclick" value="" id="buttonclick">
<input type="hidden" name="length" maxlength='3' value='12' onKeyPress="return goodchars(event,'1234567890');"> 
<input type="hidden" name="unit" value="months" />
<input type="hidden" name="totalOccurrences" value='9999'>
<input type="hidden" name="trialOccurrences" value='0'>
<input type="hidden" name="subs_typ" value='new_subs'>
<input type="hidden" name="trialAmount" value="0.00" />
<input type="hidden" name="startDate"  value="<?php echo date('Y-m-d');?>" maxlength="10" onKeyPress="return goodchars(event,'1234567890-');">
<?php $sql_customer=mysql_fetch_array(mysql_query("select * from restaurant_customer where id='".$_SESSION['customer_id']."'"));?>
<table width="590" border="0" cellspacing="0" bordercolor="d6d6d6" cellpadding="0" style="border-collapse:collapse;">
<tr>
    <td class="payment_text">First Name* :</td>
    <td><input name="first_name" id="first_name" type="text" class="payment_textfield" value="<?php echo $sql_customer['firstname']?>"   /></td>
  </tr>
  <tr>
    <td class="payment_text">Last Name* :</td>
    <td><input name="last_name" id="last_name" type="text" class="payment_textfield" value="<?php echo $sql_customer['lastname']?>" /></td>
  </tr>
  <tr>
    <td class="payment_text">Email* :</td>
    <td><input name="email" id="email" type="text" class="payment_textfield" value="<?php echo $sql_customer['email']?>"  /></td>
  </tr>
   <tr>
    <td class="payment_text">Phone* :</td>
    <td><input name="phone" id="phone" type="text" class="payment_textfield" value="<?php echo $sql_customer['phone']?>"  /></td>
  </tr>
  <tr>
    <td class="payment_text">Amount* :</td>
    <td><input name="amount" id="amount" type="text" class="payment_textfield" value="$<?php echo $_SESSION['ammount']?>" readonly  /></td>
  </tr>
  <tr>
  <tr>
    <td class="payment_text">Address* :</td>
    <td><input name="address" id="address" type="text" class="payment_textfield" value="<?php echo $sql_customer['address']?>"  /></td>
  </tr>
  <tr>
    <td class="payment_text">City* :</td>
    <td><input name="city" id="city" type="text" class="payment_textfield" value="<?php echo $sql_customer['city']?>"  /></td>
  </tr>
  <tr>
    <td class="payment_text">State* :</td>
    <td><input name="state" id="state" type="text" class="payment_textfield" value="<?php echo $sql_customer['state']?>"  /></td>
  </tr>
  <tr>
    <td class="payment_text">Zip* :</td>
    <td><input name="zip" id="zip" type="text" class="payment_textfield" value="<?php echo $sql_customer['zip']?>"  /></td>
  </tr>
  <tr>
    <td class="payment_text">Cart Type* :</td>
    <td><select name="card_type" id="card_type" class="payment_list">
            <option value="visa">Visa</option>
            <option value="master card">Master Card</option>
            <option value="american express">American Express</option>
            <option value="discover">Discover</option>
		</select></td>
  </tr>
  <tr>
    <td class="payment_text">Card No* :</td>
    <td><input name="cardNumber" id="card_no" type="text" class="payment_textfield" onKeyPress="return goodchars(event,'1234567890');" maxlength="16" /></td>
  </tr>
  <tr>
    <td class="payment_text">CVV No* :</td>
    <td><input name="cvv_no" id="cvv_no" type="text" class="payment_textfield" onKeyPress="return goodchars(event,'1234567890');" maxlength="3" /></td>
  </tr>
  <tr>
    <td class="payment_text">Expire Date* :</td>
    <td>
    <select name="exp_month" id="exp_month" style="width:150px;" class="payment_list">
        <option value="">Select</option>
        <option value="01">January</option>
        <option value="02">February</option>
        <option value="03">March</option>
        <option value="04">April</option>
        <option value="05">May</option>
        <option value="06">June</option>
        <option value="07">July</option>
        <option value="08">August</option>
        <option value="09">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
    <select name="exp_year" id="exp_year" style="width:150px; margin-left:10px;" class="payment_list">
        <option value="">Select</option>
        <option value="14">2014</option>
        <option value="15">2015</option>
        <option value="16">2016</option>
        <option value="17">2017</option>
        <option value="18">2018</option>
        <option value="19">2019</option>
        <option value="20">2020</option>
    </select>
    
	<?php /*?><input name="expiry_date" id="expiry_date" type="text" class="payment_textfield" onKeyPress="return goodchars(event,'1234567890/');"/>&nbsp;<span class="payment_text">(mm/yy)</span><?php */?>
    </td>
  </tr>
</table>

</div>


<div class="clear"></div>

<div class="payment_button">

<?php if($_REQUEST['msg']!= 'success'){?>
<input class="payment_details_button" type="submit" value="Submit" name="submit" id="btn1" onClick="return check_it();">
<?php } ?>

</div>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>
</form>
</div>

<div class="clear"></div>

<?php include("includes/footer_new.php");?>