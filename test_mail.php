<?php
include("admin/lib/conn.php");

		
	$unique_ref_length = 5;  
	
	// A true/false variable that lets us know if we've  
	// found a unique reference number or not  
	$unique_ref_found = false;  
	  
	// Define possible characters.  
	// Notice how characters that may be confused such  
	// as the letter 'O' and the number zero don't exist  
	$possible_chars = "123456789BCDFGHJKMNPQRSTVWXYZ";  
	
	// Until we find a unique reference, keep generating new ones  
		  
	$unique_no = $unique_ref;  
	
	
	$sql_restaurant_basic = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '1194'"));
	
	$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '648'"));
	
	
	$sql_delivery_charge = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '1194'"));
	
	//$sql_insert_order = "INSERT INTO restaurant_menu_order SET customer_id = '".$_SESSION['customer_id']."',restaurant_id = '".$_SESSION['cart_rest_id']."', total_price = '".$_REQUEST['amount2']."', order_date = '".date('Y-m-d H:i:s')."', type = '".$_REQUEST['type']."',status = 'Pending',customer_name = '".htmlspecialchars(stripslashes($sql_customer['firstname']),ENT_QUOTES)."',customer_address = '".htmlspecialchars(stripslashes($sql_customer['address']),ENT_QUOTES)."', special_delivery_info = '".htmlspecialchars(stripslashes($_REQUEST['delivery_info']),ENT_QUOTES)."', customer_phone = '".$sql_customer['phone']."', tax = '".$_REQUEST['tax']."' , tip = '".$_REQUEST['tip']."', commission = '".$_REQUEST['commission']."' , confirmation_code = '".$unique_no."', payment_mode = '".$_REQUEST['payment_mode']."' , spare_napkins = '".$_REQUEST['save_earth']."' , coupon_code = '".$_SESSION['coupon_code'.$ses_rest_id]."' , coupon_discount = '".$_SESSION['coupon_discount'.$ses_rest_id]."' , reward_points = '".$_SESSION['reward_point'.$ses_rest_id]."' ";
	
	
	/*if($_REQUEST['type'] == 'del'){
	$service_fee = $sql_delivery_charge['service_fee'];
	$sql_insert_order.=" ,delivery_charge = '".$_SESSION['del_charge'.$ses_rest_id]."', price_with_del_charge = '".($_SESSION['del_charge'.$ses_rest_id]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee) ."' , service_fee = '".$service_fee."'"; }
	else {
	$service_fee = $sql_delivery_charge['service_fee'];	
	$sql_insert_order.=" , price_with_del_charge = '".($_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)."' , service_fee = '".$service_fee."'";
	}
	*/
	//mysql_query($sql_insert_order);
	
	//$order_id = mysql_insert_id();
	
	$order_id = '664';
			
	$sql_total_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '664'"));
	
	/*$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."'");
	while($array_select = mysql_fetch_array($sql_select)) {
	$sql_menu_item = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select['menu_item_id']."'"));
	$sum = ($array_select['quantity']*$array_select['price'] + $array_select['tax']);
	
	$sql_insert_food_details = mysql_query("INSERT INTO restaurant_food_order_details SET  order_id = '".$order_id."' , customer_id = '".$_SESSION['customer_id']."',  menu_id  = '".$array_select['menu_item_id']."',restaurant_id = '".$array_select['restaurant_id']."',quantity = '".$array_select['quantity']."', unit_price = '".$array_select['price']."',special_instructions = '".htmlspecialchars(stripslashes($array_select['special_ins']),ENT_QUOTES)."', additional_instructions = '".htmlspecialchars(stripslashes($array_select['additional_instructions']),ENT_QUOTES)."' , order_date = '".$sql_total_price['order_date']."',customer_name='".htmlspecialchars(stripslashes($sql_customer['firstname']),ENT_QUOTES)."',customer_email='".$sql_customer['email']."',menu_name = '".trim(htmlspecialchars(stripslashes($sql_menu_item['menu_name']),ENT_QUOTES))."',sum = '".$sum."', menu_price = '".$array_select['menu_price']."', tax = '".$array_select['tax']."'");
	
	
	$sql_update = mysql_query("UPDATE restaurant_menu_item SET purchased = purchased + ".$array_select['quantity']." WHERE id = '".$array_select['menu_item_id']."'");
	
	}*/
	
	//$sql_contact_details = mysql_query("INSERT INTO restaurant_order_contact_details SET firstname = '".htmlspecialchars(stripslashes($_REQUEST['first_name']),ENT_QUOTES)."',lastname = '".htmlspecialchars(stripslashes($_REQUEST['last_name']),ENT_QUOTES)."', email='".$_REQUEST['email']."', phone='".$_REQUEST['phone']."', address='".htmlspecialchars(stripslashes($_REQUEST['address']),ENT_QUOTES)."', city='".htmlspecialchars(stripslashes($_REQUEST['city']),ENT_QUOTES)."', state='".htmlspecialchars(stripslashes($_REQUEST['state']),ENT_QUOTES)."', zipcode='".$_REQUEST['zipcode']."', special_ins='".htmlspecialchars(stripslashes($_REQUEST['delivery_info']),ENT_QUOTES)."', save_earth='".$_REQUEST['save_earth']."', customer_id='".$_SESSION['customer_id']."', order_id = '".$order_id."'");
	
	if($sql_total_price['type'] == 'pickup'){ $order_type = 'Pick up'; }
	else { $order_type = 'Delivery'; }
	
	if($sql_total_price['delivery_charge'] == 0.00){
		$delivery_charge = 'Free';
	}
	else { $delivery_charge = '$ '.$sql_total_price['delivery_charge']; }
	
	if($sql_total_price['payment_mode'] == 'cash'){
		$payment_mode = 'Cash';
	}else{
		$payment_mode = 'Credit Card';
	}
	
	$sql_get_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '664'"));
	
	$name = $sql_customer['firstname']." ".$sql_customer['lastname'];
	
	$date = date('m-d-Y'); 
	
	$total_price = $sql_total_price['total_price'];
	
	$tax = $sql_total_price['tax'];
	
	$service_fee = $sql_total_price['service_fee'];
	
	$price_del_crg = $sql_total_price['price_with_del_charge'];
	
	$confirmation_code = $sql_total_price['confirmation_code'];
	
	$restaurant_name = $sql_restaurant_basic['restaurant_name'];
	
	$restaurant_address = $sql_restaurant_basic['restaurant_address']." ".$sql_restaurant_basic['restaurant_city']." ".$sql_restaurant_basic['restaurant_state']." ".$sql_restaurant_basic['restaurant_zipcode'];
	
	if($sql_get_contact_details['phone']!=''){								
		  $phone_no ='<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Phone Number : '.$sql_get_contact_details['phone'].'</p>';
	 }
	 
	 if($sql_get_contact_details['address']!=''){								
		  $cnt_address='<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Address : '.$sql_get_contact_details['address'].'</p>';			
		  $cnt_address.='<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$sql_get_contact_details['city']." ".$sql_get_contact_details['state'].' '.$sql_get_contact_details['zipcode'].'</p>';
	 }
	 
	 $sql_select1 = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '664'");
	$ii = 1;
	while($array_select1 = mysql_fetch_array($sql_select1)) {
	$sql_select_product = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select1['menu_id']."'"));
	$price = ($array_select1['quantity']*$array_select1['menu_price']);
				
	$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> ( Item '.$ii.' ) --- <br>' .$array_select1['quantity'].' X '.$sql_select_product['menu_name'].'------------- '.$array_select1['quantity'].' X $ '.$array_select1['menu_price'].' = $'.$price.'</p>';
	
	$menu_special_ins = htmlspecialchars_decode(htmlspecialchars_decode($array_select1['additional_instructions']));
	$ins_arr = (explode(",",$menu_special_ins));
	/*if(!empty($menu_special_ins)){
		$cms_rep.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> Special Instructions ----- </p>';
	}*/
	foreach($ins_arr as $insarr){
		if(!empty($insarr)){
		$sql_sp_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$insarr."'"));
		$sql_ins_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE id = '".$sql_sp_name['special_ins_id']."'"));
		$pr1 = ($array_select1['quantity'] * $sql_sp_name['price']);
					
		$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$sql_ins_name['special_instruction'].' ----- '.$sql_sp_name['title'].' -- ' .$array_select1['quantity']. ' X  $ '.$sql_sp_name['price'].' = $'.$pr1.'</p>';
		}
	}
	
	if($array_select1['special_ins']!=''){
		$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Additional Instructions -- '.htmlspecialchars_decode(htmlspecialchars_decode($array_select1['special_ins'])).'</p>';
	}
		$menu_name.= '<hr>';
	$ii++;
	}
	
	
	if($sql_total_price['special_delivery_info']!=''){
	$special_delivery_info= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Special Instructions : '.htmlspecialchars_decode(htmlspecialchars_decode($sql_total_price['special_delivery_info'])).'</p>';
	}
	
	if($sql_total_price['spare_napkins']==1){
	$spare_napkins= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> Spare me the napkins and plasticware . I\'m trying to save the earth. </p>';
	}
	
	if($order_type == 'Delivery'){
		$delivery= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Delivery Charge : '.$delivery_charge.'</p>';
	}
	
	if($sql_total_price['tip']!='' && $sql_total_price['tip']!=0.00){
	$tip= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Tip : $ '.$sql_total_price['tip'].'</p>';
	}
	
	if($sql_get_contact_details['special_ins']!=''){				
	$special_ins= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Special Instructions : '.$sql_get_contact_details['special_ins'].'</p>';
	}
	
	$coupon_code = $_SESSION['coupon_code'.$ses_rest_id];
	$coupon_discount = $_SESSION['coupon_discount'.$ses_rest_id];
	
	$sql_sel_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$coupon_code."'"));
	
	if($_SESSION['coupon_code'.$ses_rest_id]!=''){
		$coup_cd = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Coupon :'.$sql_sel_coupon['coupon_name'].'&nbsp;</p><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Discount : $ '.$coupon_discount.'&nbsp;</p>';
	}
	
	$reward_point = $_SESSION['reward_point'.$ses_rest_id];
	
	if($_SESSION['reward_point'.$ses_rest_id]!=''){
		$rew_pt = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Reward Point Discount : $ '.$reward_point.'&nbsp;</p>';
	}
	
	if($service_fee!=0){
		$servicefee = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Service Fee : $ '.$service_fee.'&nbsp;</p>';
	}else{
		$servicefee = '';
	}
	
	/* -------------------------------------- Restaurant Owner ---------------------------------------- */
	/*$email = "priya@infosolz.com"; //$sql_restaurant_basic['email']"sourav.de@infosolz.com"
	
	$res_email = (explode(",",$email));
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 26"));	
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$phone_no%%',$phone_no,$cms_rep);
	$cms_rep=str_replace('%%$cnt_address%%',$cnt_address,$cms_rep);
	$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
	$cms_rep=str_replace('%%$date%%',$date,$cms_rep);
	$cms_rep=str_replace('%%$menu_name%%',$menu_name,$cms_rep);
	$cms_rep=str_replace('%%$special_delivery_info%%',$special_delivery_info,$cms_rep);
	$cms_rep=str_replace('%%$spare_napkins%%',$spare_napkins,$cms_rep);
	$cms_rep=str_replace('%%$total_price%%',$total_price,$cms_rep);
	$cms_rep=str_replace('%%$delivery%%',$delivery,$cms_rep);
	$cms_rep=str_replace('%%$tax%%',$tax,$cms_rep);
	$cms_rep=str_replace('%%$service_fee%%',$servicefee,$cms_rep);
	$cms_rep=str_replace('%%$tip%%',$tip,$cms_rep);
	$cms_rep=str_replace('%%$price_del_crg%%',$price_del_crg,$cms_rep);
	$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
	$cms_rep=str_replace('%%$payment_mode%%',$payment_mode,$cms_rep);
	$cms_rep=str_replace('%%$confirmation_code%%',$confirmation_code,$cms_rep);
	$cms_rep=str_replace('%%$coupon_code%%',$coup_cd,$cms_rep);
	$cms_rep=str_replace('%%$reward_point%%',$rew_pt,$cms_rep);
	
	
	$from = 'support@foodandmenu.com';
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	//$headers.= "Bcc:priya@infosolz.com\n";
	$inc = 1;
	foreach($res_email as $val_email){
		if($inc!=1){
			$headers.= "Bcc:".$val_email."\n";
		}
		$inc++;
	}
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	//$subject="Order No. OR-00".$order_id." Process test";
	
	$subject = stripslashes($sql_cms['subject']);
	$subject=str_replace('%%$order_id%%',$order_id,$subject);
	
	//mail($email,$subject,$message,$headers);
	mail($res_email[0],$subject,$message,$headers);*/
	
	/* ------------------------------------------------------------------------------------------------ */
	
	/*--------------------------------------- Customer ------------------------------------------------ */
	/*$email = "priya@infosolz.com"; //$sql_customer_details['email']"sourav.de@infosolz.com"
	$name = $sql_customer_details['firstname']." ".$sql_customer_details['lastname'];
		
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 27"));	
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
	$cms_rep=str_replace('%%$date%%',$date,$cms_rep);
	$cms_rep=str_replace('%%$menu_name%%',$menu_name,$cms_rep);
	$cms_rep=str_replace('%%$special_delivery_info%%',$special_delivery_info,$cms_rep);
	$cms_rep=str_replace('%%$spare_napkins%%',$spare_napkins,$cms_rep);
	$cms_rep=str_replace('%%$total_price%%',$total_price,$cms_rep);
	$cms_rep=str_replace('%%$delivery%%',$delivery,$cms_rep);
	$cms_rep=str_replace('%%$tax%%',$tax,$cms_rep);
	$cms_rep=str_replace('%%$service_fee%%',$servicefee,$cms_rep);
	$cms_rep=str_replace('%%$tip%%',$tip,$cms_rep);
	$cms_rep=str_replace('%%$price_del_crg%%',$price_del_crg,$cms_rep);
	$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
	$cms_rep=str_replace('%%$payment_mode%%',$payment_mode,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_address,$cms_rep);
	$cms_rep=str_replace('%%$coupon_code%%',$coup_cd,$cms_rep);
	$cms_rep=str_replace('%%$reward_point%%',$rew_pt,$cms_rep);
	
	
	$from = 'support@foodandmenu.com';
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	//$subject="Order No. OR-00".$order_id." Process";
	
	$subject = stripslashes($sql_cms['subject']);
	$subject=str_replace('%%$order_id%%',$order_id,$subject);
	
	mail($email,$subject,$message,$headers);*/
	
	/* ------------------------------------------------------------------------------------------------ */
	
	/* -------------------------------------- Admin --------------------------------------------------- */
	$customer_name = $sql_get_contact_details['firstname']." ".$sql_get_contact_details['lastname'];
	$sql_admin_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = 1"));
	$admin_email_address = $sql_admin_details['email_address'];
	
	$arr_email_address = explode(",",$admin_email_address);
	
	$email = "support@foodandmenu.com"; //"priya@infosolz.com""sourav.de@infosolz.com"
	
	$name = "Admin";
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 28"));	
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$customer_name%%',$customer_name,$cms_rep);
	$cms_rep=str_replace('%%$phone_no%%',$phone_no,$cms_rep);
	$cms_rep=str_replace('%%$cnt_address%%',$cnt_address,$cms_rep);
	$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
	$cms_rep=str_replace('%%$date%%',$date,$cms_rep);
	$cms_rep=str_replace('%%$menu_name%%',$menu_name,$cms_rep);
	$cms_rep=str_replace('%%$special_delivery_info%%',$special_delivery_info,$cms_rep);
	$cms_rep=str_replace('%%$spare_napkins%%',$spare_napkins,$cms_rep);
	$cms_rep=str_replace('%%$total_price%%',$total_price,$cms_rep);
	$cms_rep=str_replace('%%$delivery%%',$delivery,$cms_rep);
	$cms_rep=str_replace('%%$tax%%',$tax,$cms_rep);
	$cms_rep=str_replace('%%$service_fee%%',$servicefee,$cms_rep);
	$cms_rep=str_replace('%%$tip%%',$tip,$cms_rep);
	$cms_rep=str_replace('%%$price_del_crg%%',$price_del_crg,$cms_rep);
	$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
	$cms_rep=str_replace('%%$payment_mode%%',$payment_mode,$cms_rep);
	$cms_rep=str_replace('%%$special_ins%%',$special_ins,$cms_rep);
	$cms_rep=str_replace('%%$coupon_code%%',$coup_cd,$cms_rep);
	$cms_rep=str_replace('%%$reward_point%%',$rew_pt,$cms_rep);
	$cms_rep=str_replace('%%$credit_card_inf%%','',$cms_rep);
	
	
	$from = $sql_customer_details['email'];
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	//$subject="Order No. OR-00".$order_id." Process";
	
	$subject = stripslashes($sql_cms['subject']);
	$subject=str_replace('%%$order_id%%',$order_id,$subject);
	
	mail($email,$subject,$message,$headers);
	
	foreach($arr_email_address as $val_email){
		mail($val_email,$subject,$message,$headers);
	}
	
	/* ------------------------------------------------------------------------------------------------ */
	
	
	$_SESSION['coupon_code'.$ses_rest_id] = '';
	$_SESSION['coupon_discount'.$ses_rest_id] = '';
	$_SESSION['reward_point'.$ses_rest_id] = '';
	$_SESSION['user_reward_point'.$ses_rest_id] = '';
							
	header("location:payment_success.php");
	
	exit; 
	
		
		
		?>