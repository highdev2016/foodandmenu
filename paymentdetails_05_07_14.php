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
							 
							 $unique_ref_length = 2;  
			  
						// A true/false variable that lets us know if we've  
						// found a unique reference number or not  
						$unique_ref_found = false;  
						  
						// Define possible characters.  
						// Notice how characters that may be confused such  
						// as the letter 'O' and the number zero don't exist  
						$possible_chars = "1234567890";  
				  
						// Until we find a unique reference, keep generating new ones  
						while (!$unique_ref_found) {  
						  
							// Start with a blank reference number  
							$unique_ref = "";  
							  
							// Set up a counter to keep track of how many characters have   
							// currently been added  
							$i = 0;  
							  
							// Add random characters from $possible_chars to $unique_ref   
							// until $unique_ref_length is reached  
							while ($i < $unique_ref_length) {  
							  
								// Pick a random character from the $possible_chars list  
								$char = substr($possible_chars, mt_rand(0, strlen($possible_chars)-1), 1);  
								  
								$unique_ref .= $char;  
								  
								$i++;   
							}
							
							$query = "SELECT `certificate_no` FROM `restaurant_gift_certificate_no`  WHERE  `certificate_no` = '00110-".$unique_ref."'";
							$result = mysql_query($query) or die(mysql_error().' '.$query);  
							if (mysql_num_rows($result)==0) {  
							  
								// We've found a unique number. Lets set the $unique_ref_found  
								// variable to true and exit the while loop  
								$unique_ref_found = true; 
							}  
						}  
						  
						$unique_no = $unique_ref; 
						
						$certificate_no = '00110-'.$unique_no;
						
							 $sql_deal=mysql_fetch_array(mysql_query("select * from restaurant_deals where id='".$deal_id."'"));
							 
							 $basic_info_detail=mysql_fetch_array(mysql_query("select * from restaurant_basic_info where id='".$sql_deal['restaurant_id']."'"));
							 							 
							 $disclaimer_sq = mysql_query("SELECT * FROM restaurant_disclaimer WHERE restaurant_id = '".$sql_deal['restaurant_id']."'");
							 $disclaimer_rws = mysql_num_rows($disclaimer_sq);
							 $disclaimer_info = mysql_fetch_array($disclaimer_sq);
							 
							 $disclaimer = $sql_deal['disclaimer_title']."<br>".$sql_deal['disclaimer'];
							 
							 
							 $sql_insert_certificate_details = mysql_query("INSERT INTO restaurant_gift_certificate_no SET deal_id = '".$deal_id."' , restaurant_id = '".$sql_deal['restaurant_id']."' , certificate_no = '".$certificate_no."' , expiry_date = '".$sql_deal['expiry_date']."' , customer_id = '".$_SESSION['customer_id']."' ");
							 
							 $daily_description = $sql_deal['daily_description'];
							 $daily_price = $sql_deal['daily_price'];
							 $restaurant_name = stripslashes($basic_info_detail['restaurant_name']);
							 $date = change_dateformat_reverse(date('Y-m-d'));
							 $restaurant_address = $basic_info_detail['restaurant_address'];
							 $phone = $basic_info_detail['phone'];
							 $expiry_date = date("d-m-Y", strtotime($sql_deal['expiry_date']));
							 $special_rules = $sql_deal['special_rules'];
							 
							 
							 /********************************************* Gift Certificate To Customer **********************************************/
							 		 
							/*$cms_rep = '<div style="width:800px; border:#c3c6d4 1px solid;"><table width="700" border="0" bordercolor="c3c6d4" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin:0 auto;">
							  <tr style="border-bottom:#404CA1 1px solid;">
								<td width="349"><img src="http://www.foodandmenu.com/images/logo_certificate.png" width="216" height="99" style="margin:5px 0 5px 10px;" /></td>
								<td width="351" valign="top"><p style="font-family:Trebuchet MS, Arial, Helvetica, sans-serif; font-size:14px; color:#000; font-weight:bold; float:right; padding-right:20px;">Certificate #: '.$sql_deal['certificate_no'].'</p></td>
							  </tr>
							  
							  <tr>
								<td colspan="2" valign="top"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:22px; padding:5px 0 10px 10px;">$'.$sql_deal['daily_description']."/ Your Price : $ ".$sql_deal['daily_price'].' Food and Menu Gift Certificate</h1></td>
							  </tr>
							  
							  <tr>
							  
							  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Redeemable only at (Restaurant):</h1>
							  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.stripslashes($basic_info_detail['restaurant_name']).'</h2>
							  </td>
							  
							  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Date of Purchased:</h1>
							  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.change_dateformat_reverse(date('Y-m-d')).'</h2></td>
							  
							  </tr>
							  
							  <tr>
							  
							  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Address:</h1>
							  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$basic_info_detail['restaurant_address'].'</h2>
							  </td>
							  
							  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Expiration Date:</h1>
							  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$sql_deal['daily_description'].'</h2></td>
							  
							  </tr>
							  
							  <tr>
							  
							  <td ><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Phone:</h1>
								<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$basic_info_detail['phone'].'</h2>
								</td>
								
							  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Amount Redeem:</h1>
							  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.date("d-m-Y", strtotime($sql_deal['expiry_date'])).'</h2></td>
							  
							  </tr>
							  <tr>
							  
							  <td colspan="2"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Special Rules:</h1>
								<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 20px 10px;  border-bottom: 1px solid #C3C6D4;">'.$sql_deal['special_rules'].'</h2>
								</td>
							  </tr>';*/
							  
							$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 23"));	
							
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
							$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_address,$cms_rep);
							$cms_rep=str_replace('%%$phone%%',$phone,$cms_rep);
							$cms_rep=str_replace('%%$expiry_date%%',$expiry_date,$cms_rep);
							$cms_rep=str_replace('%%$special_rules%%',$special_rules,$cms_rep);
							$cms_rep=str_replace('%%$disclaimer%%',$disclaimer,$cms_rep);
							
							$from = 'support@foodandmenu.com';
				
							$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
				
							$headers .= 'MIME-Version: 1.0' . "\r\n";
				
							$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
				
							$message=$cms_rep;
				
							//$subject="Gift Certificate";
							
							$subject = stripslashes($sql_cms['subject']);
				
							mail($email,$subject,$message,$headers);
			
			
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
							
							
							$email1= $_REQUEST['email'];//"priya@infosolz.com"
										
							$sql_customer_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
							
							mysql_query("INSERT INTO  restaurant_gift_card set restaurant_id=".$sql_deal['restaurant_id'].", restaurant_name = '".$basic_info_detail['restaurant_name']."' ,deal_id=".$deal_id.",price=".$sql_deal['daily_price'].",purchase_date='".date('Y-m-d')."',deal = '".$sql_deal['daily_name']."',email = '".$sql_customer_info['email']."',customer_id = '".$sql_customer_info['id']."',user_name = '".$sql_customer_info['firstname']."',city = '".$basic_info_detail['restaurant_city']."',state = '".$basic_info_detail['restaurant_state']."',status = 'Pending'");	
							}
							 
							/*$cms_rep1 = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
	
							<div style="margin:0 auto;width:700px;clear:both;">
	
							<div style="background-color:#3F4CA0; height:30px;"></div>
	
							<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">
	
							<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px;" /></div>
	
							<div style="width:100%; float:left;">
	
							<div style="clear:both;"></div>
	
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$_REQUEST['first_name'].',</p>
								
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Your Payment Information is an follows</p>
								
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">First Name :'.$_REQUEST['first_name'].'</p>
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Last Name :'.$_REQUEST['last_name'].'</p>
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Email :'.$_REQUEST['email'].'</p>
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Phone :'.$_REQUEST['phone'].'</p>
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Address :'.$_REQUEST['address'].'</p>
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">City :'.$_REQUEST['city'].'</p>
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">State :'.$_REQUEST['state'].'</p>
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Zip :'.$_REQUEST['zip'].'</p>
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Total Amount :$'.$_SESSION['ammount'].'</p>
	
							<div style="clear:both;"></div>
	
							<div style="clear:both;"></div>
	
							<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>
	
							<div style="clear:both;"></div>
	
								<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>
	
								<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>
	
							<div style="clear:both;"></div>
	
							</div>
	
							<div style="clear:both;"></div>
	
							<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >
	
							<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">
	
	Sent to you from Food & menu</h4>
	
						</div>
	
					</div>
	
					<div style="clear:both;"></div>
	
					</div>';*/
					
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
							
							$from = 'support@foodandmenu.com';
							
							$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
							
							$headers .= 'MIME-Version: 1.0' . "\r\n";
							
							$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
							
							$message1=$cms_rep1;
							
							//$subject1="Purchase Details";
							
							$subject1 = stripslashes($sql_cms['subject']);
							
							mail($email1,$subject1,$message1,$headers);
					
							//-------------For Admin---------------//
							$sql_admin_email=mysql_fetch_array(mysql_query("SELECT content FROM restaurant_payment_email where id=1"));
							
							$admin_email = 'support@foodandmenu.com';//"priya@infosolz.com";
							
							/*$cms_rep_admin = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
						
												<div style="margin:0 auto;width:700px;clear:both;">
						
												<div style="background-color:#3F4CA0; height:30px;"></div>
						
												<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">
						
												<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px;" /></div>
						
												<div style="width:100%; float:left;">
						
												<div style="clear:both;"></div>
						
													
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">New Customer Payment Information is an follows</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$sql_admin_email['content'].'</p>
													
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">First Name :'.$_REQUEST['first_name'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Last Name :'.$_REQUEST['last_name'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Email :'.$_REQUEST['email'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Phone :'.$_REQUEST['phone'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Address :'.$_REQUEST['address'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">City :'.$_REQUEST['city'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">State :'.$_REQUEST['state'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Zip :'.$_REQUEST['zip'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant Name :'.$basic_info_detail['restaurant_name'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Certificate No. :'.$sql_deal['certificate_no'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Price :$'.$sql_deal['daily_description']."/ Your Price : $".$_SESSION['ammount'].'</p>
						
												<div style="clear:both;"></div>
						
						
												<div style="clear:both;"></div>
						
												<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>
						
												<div style="clear:both;"></div>
						
													<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>
						
													<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>
						
												<div style="clear:both;"></div>
						
												</div>
						
												<div style="clear:both;"></div>
						
												<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >
						
												<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">
						
						Sent to you from Food & menu</h4>
						
											</div>
						
										</div>
						
										<div style="clear:both;"></div>
						
										</div>';*/
										
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
									
							
							$from = 'support@foodandmenu.com';
							
							$headers1 = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
							
							$headers1 .= 'MIME-Version: 1.0' . "\r\n";
							
							$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
							
							$message2=$cms_rep_admin;
							
							//$subject2="Customer Purchase Details";
							
							$subject2 = stripslashes($sql_cms['subject']);
							
							mail($admin_email,$subject2,$message2,$headers1);
							//------------------------------------//
							
							//-------------For Restaurant Owner---------------//
							$sql_admin_email=mysql_fetch_array(mysql_query("SELECT content FROM restaurant_payment_email where id=1"));
							
							$ret_own_email = $basic_info_detail['email'];//"priya@infosolz.com";
							
							/*$cms_rep_admin = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
						
												<div style="margin:0 auto;width:700px;clear:both;">
						
												<div style="background-color:#3F4CA0; height:30px;"></div>
						
												<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">
						
												<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px;" /></div>
						
												<div style="width:100%; float:left;">
						
												<div style="clear:both;"></div>
						
													
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">New Customer Payment Information is an follows</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$sql_admin_email['content'].'</p>
													
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">First Name :'.$_REQUEST['first_name'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Last Name :'.$_REQUEST['last_name'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Email :'.$_REQUEST['email'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Phone :'.$_REQUEST['phone'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Address :'.$_REQUEST['address'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">City :'.$_REQUEST['city'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">State :'.$_REQUEST['state'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Zip :'.$_REQUEST['zip'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant Name :'.$basic_info_detail['restaurant_name'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Certificate No. :'.$sql_deal['certificate_no'].'</p>
													<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Price :$'.$sql_deal['daily_description']."/ Your Price : $".$_SESSION['ammount'].'</p>
						
												<div style="clear:both;"></div>
						
						
												<div style="clear:both;"></div>
						
												<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>
						
												<div style="clear:both;"></div>
						
													<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>
						
													<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>
						
												<div style="clear:both;"></div>
						
												</div>
						
												<div style="clear:both;"></div>
						
												<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >
						
												<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">
						
						Sent to you from Food & menu</h4>
						
											</div>
						
										</div>
						
										<div style="clear:both;"></div>
						
										</div>';*/
										
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
									
							
							$from = 'support@foodandmenu.com';
							
							$headers1 = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
							
							$headers1 .= 'MIME-Version: 1.0' . "\r\n";
							
							$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
							
							$message2=$cms_rep_admin;
							
							$subject2 = stripslashes($sql_cms['subject']);
							
							mail($ret_own_email,$subject2,$message2,$headers1);
							//------------------------------------//
	
							$del_cart=mysql_query("delete from restaurant_cart where customer_id='".$_SESSION['customer_id']."'");
							unset($_SESSION['card_array']);
							unset($_SESSION['ammount']);
							header("location:paymentdetails.php?msg=success");
							
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
	
    //var exp_date=document.frm.expirationDateM.value+'/'+document.frm.expirationDateY.value;
	/*var exp_date=document.frm.expiry_date.value;
	var exp_date_arr=exp_date.split("/");
	var exp_year='20'+exp_date_arr[1];
	var exp_mon=exp_date_arr[0];
	var now = new Date();
	var curr_year=now.getFullYear();
	var curr_mon=now.getMonth();
	var exp_dt_frmt=/^((0[1-9])|(1[0-2]))\/(\d{4})$/;*/
	
	/*if (exp_date == "")
    {
        alert ("Please enter expiration date.");
		document.frm.expirationDate.focus();
        return false;
    }
	if (exp_date.indexOf('/') == -1 )
    {
        alert ( "The expiration date is NOT valid!" );
		document.frm.expirationDate.focus();
        return false;
    }
	if (exp_mon>12)
    {
        alert ( "The expiration date is NOT valid!" );
		document.frm.expirationDate.focus();
        return false;
    }
	if (exp_date.match(exp_dt_frmt)==null)
	{
        alert ( "The expiration date is NOT valid!" );
		document.frm.expirationDate.focus();
        return false;
    }
	if(exp_year<curr_year)
	{
		alert ( "The card has already expired!" );
		document.frm.expirationDate.focus();
        return false;
	}
	if(exp_year==curr_year && exp_mon<curr_mon)
	{
		alert ( "The card has already expired!" );
		document.frm.expirationDate.focus();
		return false;
	}*/
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
	
	/*var str = document.getElementById("expiry_date").value;
	var n=str.split("/");
	//alert(str);
	var exp_date = n[1]+n[0];
	var today1 = document.getElementById("today").value;
	//alert(today1);
	var m=today1.split("/");
	var today = m[1]+m[0];
	var d1 = parseInt(today);
	var d2 = parseInt(exp_date);*/
	//alert(d1);
	//alert(d2);
	/*if(d1 > d2) {
		alert('Enter valid expiration date.');
		document.getElementById("expiry_date").value='';
		document.getElementById("expiry_date").focus();
		return false;
	}*/
	
	
	//var exp_date=document.frm.expirationDateM.value+'/'+document.frm.expirationDateY.value;
	/*var exp_date=document.frm.expiry_date.value;
	var exp_date_arr=exp_date.split("/");
	var exp_year='20'+exp_date_arr[1];
	var exp_mon=exp_date_arr[0];
	var exp_date = exp_mon + '/' + exp_year;
	var now = new Date();
	var curr_year=now.getFullYear();
	var curr_mon=now.getMonth();
	var exp_dt_frmt=/^((0[1-9])|(1[0-2]))\/(\d{4})$/;*/
	
	/*if (exp_date == "")
    {
        alert ("Please enter expiration date.");
		document.frm.expirationDate.focus();
        return false;
    }
	if (exp_date.indexOf('/') == -1 )
    {
        alert ( "The expiration date is NOT valid!" );
		document.frm.expirationDate.focus();
        return false;
    }
	if (exp_mon>12)
    {
        alert ( "The expiration date is NOT valid!" );
		document.frm.expirationDate.focus();
        return false;
    }
	if (exp_date.match(exp_dt_frmt)==null)
	{
        alert ( "The expiration date is NOT valid!" );
		document.frm.expirationDate.focus();
        return false;
    }
	if(exp_year<curr_year)
	{
		alert ( "The card has already expired!" );
		document.frm.expirationDate.focus();
        return false;
	}
	if(exp_year==curr_year && exp_mon<curr_mon)
	{
		alert ( "The card has already expired!" );
		document.frm.expirationDate.focus();
        return false;
	}*/
	document.frm.buttonclick.value="sale";
	return true;
}
//function price_sum(type,no)
//{
//	if(document.getElementById('crse'+type).value=="")
//	{
//		document.getElementById('crse'+type).value=0;
//	}
//	amnt = (<?php //echo $crse_charge_1->course_charge; ?>*(document.getElementById('crse1').value))
//		 + (<?php //echo $crse_charge_2->course_charge; ?>*(document.getElementById('crse2').value))
//		 + (<?php //echo $crse_charge_3->course_charge; ?>*(document.getElementById('crse3').value))
//		 + (<?php //echo $crse_charge_4->course_charge; ?>*(document.getElementById('crse4').value))
//		 + (<?php //echo $crse_charge_5->course_charge; ?>*(document.getElementById('crse5').value))
//		 + (<?php //echo $crse_charge_6->course_charge; ?>*(document.getElementById('crse6').value))
//	studentNo = parseInt(document.getElementById('crse1').value)
//			  + parseInt(document.getElementById('crse2').value)
//			  + parseInt(document.getElementById('crse3').value)
//			  + parseInt(document.getElementById('crse4').value)
//			  + parseInt(document.getElementById('crse5').value)
//			  + parseInt(document.getElementById('crse6').value)
//	if(studentNo>20){
//		amnt = ((amnt*80)/100);
//	}else{
//		if(studentNo>10){
//			amnt = ((amnt*90)/100);
//		}else{
//			amnt = ((amnt*100)/100);
//		}	
//	}
//	amnt_tot = (Math.round((amnt)*100)/100);
//	if(amnt_tot==0) amnt_tot='0.00';
//	document.getElementById('amount').value = amnt_tot;
//	if(studentNo>20)
//	{	
//		amnt_tot_new = (parseFloat(document.getElementById('amount').value)+parseFloat(10.00*studentNo));
//	}
//	else
//	{
//		amnt_tot_new = (parseFloat(document.getElementById('amount').value)+parseFloat(14.95*studentNo));
//	}
//	amnt_tot_final = (Math.round((amnt_tot_new)*100)/100);
//	if(document.getElementById('feature').checked == true)
//	{
//		document.getElementById('amnt').innerHTML = '$'+amnt_tot_final;
//	}
//	else
//	{
//		document.getElementById('amnt').innerHTML = '$'+amnt_tot;
//	}
//}
//function check_tot_amnt()
//{
//	studentNo = parseInt(document.getElementById('crse1').value)
//			  + parseInt(document.getElementById('crse2').value)
//			  + parseInt(document.getElementById('crse3').value)
//			  + parseInt(document.getElementById('crse4').value)
//			  + parseInt(document.getElementById('crse5').value)
//			  + parseInt(document.getElementById('crse6').value)
//	if(studentNo=='') studentNo = 0;
//	if(studentNo>20)
//	{	
//		amnt_tot_new = (parseFloat(document.getElementById('amount').value)+parseFloat(10.00*studentNo));
//	}
//	else
//	{
//		amnt_tot_new = (parseFloat(document.getElementById('amount').value)+parseFloat(14.95*studentNo));
//	}
//	amnt_tot_final = (Math.round((amnt_tot_new)*100)/100);	
//	if(document.getElementById('feature').checked == true)
//	{
//		document.getElementById('amnt').innerHTML = '$'+amnt_tot_final;
//		document.getElementById('bill_detail_print').style.display='block';
//	}
//	if(document.getElementById('feature').checked == false)
//	{
//		document.getElementById('amnt').innerHTML = '$'+document.getElementById('amount').value;
//		document.getElementById('bill_detail_print').style.display='none';
//	}
//}
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
<div  style="width:300px; position:absolute; z-index:9999999; background:#fff; padding:50px 20px; color:#000; font-family:Calibri; font-size:18px; height:100px; -moz-box-shadow: 0 0 5px #888;
-webkit-box-shadow: 0 0 5px#888;
box-shadow: 0 0 5px #888; text-align:center; margin-top:200px;">

<a href = "home.php" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade11').style.display='none';document.getElementById('fade').style.display='none'"><img src="images/fancy_closebox.png" style="margin-left:304px; margin-top:-63px;"/></a>
<?php if($_REQUEST['msg'] == 'success'){ ?><p style="margin-top:10px;">Payment successfully done</p><?php } ?>               
</div></div>

<?php //print_r($_SESSION);?>
<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>

<div class="body_section">
<form name="frm" action="" method="post">
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
<input class="payment_details_button" type="submit" value="Submit" name="submit" onClick="return check_it();">
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

<?php include("includes/footer.php");?>