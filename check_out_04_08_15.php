<?php
ob_start();
session_start();
$session_id = session_id();
include("admin/lib/conn.php");
include("includes/rest_header.php");
include("includes/functions.php");
include("authnetfunction_helper.php");

$ses_rest_id = $_SESSION['cart_rest_id'];

//print_r($_SESSION);

$sql_customer_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));

if(($_REQUEST['reorder'] == 1) && ($_REQUEST['type']!='') && ($_REQUEST['order_id']!='')){
	$sql_select_order = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$_REQUEST['order_id']."' AND resubmit = 0");
	while($array_select_order = mysql_fetch_array($sql_select_order)){
		$_SESSION['cart_rest_id'] = $array_select_order['restaurant_id'];
		
		if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
			$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id'.$ses_rest_id]."' AND group_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."' ");
		}else{
			$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '0' AND group_order_details_id = '0' ");
		}
	
		if(mysql_num_rows($sql_select) > 0){
			if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
				$sql_update_cart = mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity + '".$array_select_order['quantity']."' WHERE menu_item_id = '".$array_select_order['menu_id']."' AND session_id = '".$session_id."' AND group_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."' ");
			}else{
				$sql_update_cart = mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity + '".$array_select_order['quantity']."' WHERE menu_item_id = '".$array_select_order['menu_id']."' AND session_id = '".$session_id."' AND group_id = '0' AND group_order_details_id = '0' ");
			}
			//$sql_update_cart = mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity + '".$array_select_order['quantity']."' WHERE menu_item_id = '".$array_select_order['menu_id']."' AND session_id = '".$session_id."'");
			
			$sql_resubmit = mysql_query("UPDATE restaurant_food_order_details SET  resubmit = 1 WHERE order_id = '".$array_select_order['order_id']."'");
			
		}else{
			if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
				mysql_query("INSERT INTO restaurant_menuitem_cart SET menu_item_id = '".$array_select_order['menu_id']."', session_id = '".session_id()."', restaurant_id = '".$array_select_order['restaurant_id']."', price = '".$array_select_order['unit_price']."', tax = '".$array_select_order['tax']."', quantity = '".$array_select_order['quantity']."', special_ins = '".htmlspecialchars(stripslashes(htmlspecialchars_decode(htmlspecialchars_decode($array_select_order['special_instructions']))),ENT_QUOTES)."', additional_instructions = '".htmlspecialchars(stripslashes(htmlspecialchars_decode(htmlspecialchars_decode($array_select_order['additional_instructions']))),ENT_QUOTES)."', menu_price = '".$array_select_order['menu_price']."' AND group_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."'");
			}else{
				mysql_query("INSERT INTO restaurant_menuitem_cart SET menu_item_id = '".$array_select_order['menu_id']."', session_id = '".session_id()."', restaurant_id = '".$array_select_order['restaurant_id']."', price = '".$array_select_order['unit_price']."', tax = '".$array_select_order['tax']."', quantity = '".$array_select_order['quantity']."', special_ins = '".htmlspecialchars(stripslashes(htmlspecialchars_decode(htmlspecialchars_decode($array_select_order['special_instructions']))),ENT_QUOTES)."', additional_instructions = '".htmlspecialchars(stripslashes(htmlspecialchars_decode(htmlspecialchars_decode($array_select_order['additional_instructions']))),ENT_QUOTES)."', menu_price = '".$array_select_order['menu_price']."'");
			}
			
			
			$sql_resubmit = mysql_query("UPDATE restaurant_food_order_details SET  resubmit = 1 WHERE order_id = '".$array_select_order['order_id']."'");			
			
		}
		
		//$sql_insert_into_cart = mysql_query("INSERT INTO restaurant_menuitem_cart SET menu_item_id = '".$array_select_order['menu_id']."', session_id = '".session_id()."', restaurant_id = '".$array_select_order['restaurant_id']."', price = '".$array_select_order['unit_price']."', tax = '".$array_select_order['tax']."', quantity = '".$array_select_order['quantity']."', special_ins = '".$array_select_order['special_instructions']."', additional_instructions = '".$array_select_order['additional_instructions']."', menu_price = '".$array_select_order['menu_price']."'");
	}	
	header("location:check_out.php?type=".$_REQUEST['type']."");
	
}

	if($_REQUEST['place_order']=="Place My Order")
	{
				
	if($_REQUEST['payment_mode'] == 'cash'){
		
	$unique_ref_length = 5;  
	
	// A true/false variable that lets us know if we've  
	// found a unique reference number or not  
	$unique_ref_found = false;  
	  
	// Define possible characters.  
	// Notice how characters that may be confused such  
	// as the letter 'O' and the number zero don't exist  
	$possible_chars = "123456789BCDFGHJKMNPQRSTVWXYZ";  
	
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
		
		$query = "SELECT `confirmation_code` FROM `restaurant_menu_order`  WHERE  `confirmation_code` = '".$unique_ref."'";
		$result = mysql_query($query) or die(mysql_error().' '.$query);  
		if (mysql_num_rows($result)==0) {  
		  
			// We've found a unique number. Lets set the $unique_ref_found  
			// variable to true and exit the while loop  
			$unique_ref_found = true; 
		}  
	}  
	  
	$unique_no = $unique_ref;  
	
	
	$sql_restaurant_basic = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['cart_rest_id']."'"));
	
	$sql_del_com_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_SESSION['cart_rest_id']."'")); 
	
	$sql_update_customer_data = mysql_query("UPDATE restaurant_customer SET address = '".htmlspecialchars(stripslashes($_REQUEST['address']),ENT_QUOTES)."' , city = '".htmlspecialchars(stripslashes($_REQUEST['city']),ENT_QUOTES)."' , state = '".htmlspecialchars(stripslashes($_REQUEST['state']),ENT_QUOTES)."' , zip = '".$_REQUEST['zipcode']."', phone = '".$_REQUEST['phone']."' , billing_address = '".htmlspecialchars(stripslashes($_REQUEST['billing_address']),ENT_QUOTES)."'  , billing_state = '".htmlspecialchars(stripslashes($_REQUEST['billing_state']),ENT_QUOTES)."' , billing_city = '".htmlspecialchars(stripslashes($_REQUEST['billing_city']),ENT_QUOTES)."', billing_zip = '".htmlspecialchars(stripslashes($_REQUEST['billing_zip']),ENT_QUOTES)."' WHERE id = '".$_SESSION['customer_id']."' ");
	
	$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
	
	$sql_delivery_charge = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_SESSION['cart_rest_id']."'"));
	$sql_insert_order = "INSERT INTO restaurant_menu_order SET customer_id = '".$_SESSION['customer_id']."',restaurant_id = '".$_SESSION['cart_rest_id']."', total_price = '".$_REQUEST['amount2']."', order_date = '".date('Y-m-d H:i:s')."', type = '".$_REQUEST['type']."',status = 'Pending',customer_name = '".htmlspecialchars(stripslashes($sql_customer['firstname']),ENT_QUOTES)."',customer_address = '".htmlspecialchars(stripslashes($sql_customer['address']),ENT_QUOTES)."', special_delivery_info = '".htmlspecialchars(stripslashes($_REQUEST['delivery_info']),ENT_QUOTES)."', customer_phone = '".$sql_customer['phone']."', tax = '".$_REQUEST['tax']."' , tip = '".$_REQUEST['tip']."' , confirmation_code = '".$unique_no."', payment_mode = '".$_REQUEST['payment_mode']."' , spare_napkins = '".$_REQUEST['save_earth']."'  , group_order_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' , group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."' ";
	
	if($_SESSION['group_order_id'.$ses_rest_id]!='' && $_SESSION['group_order_details_id'.$ses_rest_id]!=''){
		$sql_insert_order.=" , coupon_code = '".$_SESSION['coupon_code'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]."' , coupon_discount = '".$_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]."' , reward_points = '".$_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]."' ";
	}else{
		$sql_insert_order.=" , coupon_code = '".$_SESSION['coupon_code'.$ses_rest_id]."' , coupon_discount = '".$_SESSION['coupon_discount'.$ses_rest_id]."' , reward_points = '".$_SESSION['reward_point'.$ses_rest_id]."' ";
	}
	
	
	
	if($_REQUEST['type'] == 'del'){
	$service_fee = $sql_delivery_charge['service_fee'];
	
	if($_SESSION['group_order_id'.$ses_rest_id]!='' && $_SESSION['group_order_details_id'.$ses_rest_id]!=''){
		$sql_insert_order.=" ,delivery_charge = '".$_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]."', price_with_del_charge = '".($_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee) ."' , service_fee = '".$service_fee."'";
	$commission = (($_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)*$sql_del_com_info['commission'])/100;
	}else{
		$sql_insert_order.=" ,delivery_charge = '".$_SESSION['del_charge'.$ses_rest_id]."', price_with_del_charge = '".($_SESSION['del_charge'.$ses_rest_id]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee) ."' , service_fee = '".$service_fee."'";
	$commission = (($_SESSION['del_charge'.$ses_rest_id]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)*$sql_del_com_info['commission'])/100;
		}
	
	$sql_insert_order.=" , commission = '".$commission."' ";
	 }
	else {
	$service_fee = $sql_delivery_charge['service_fee'];	
	$sql_insert_order.=" , price_with_del_charge = '".($_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)."' , service_fee = '".$service_fee."'";
	$commission = (($_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)*$sql_del_com_info['commission'])/100;
	$sql_insert_order.=" , commission = '".$commission."' ";
	}
	
	mysql_query($sql_insert_order);
	
	$order_id = mysql_insert_id();
	
	$upd_done_status = mysql_query("UPDATE restaurant_group_order_details SET done_status = '1' WHERE group_order_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."'");
			
	$sql_total_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."' ");
	}else{
		$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '0' AND group_order_details_id = '0' ");
	}
	
	while($array_select = mysql_fetch_array($sql_select)) {
	$sql_menu_item = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select['menu_item_id']."'"));
	$sum = ($array_select['quantity']*$array_select['price'] + $array_select['tax']);
	
	$sql_insert_food_details = mysql_query("INSERT INTO restaurant_food_order_details SET  order_id = '".$order_id."' , customer_id = '".$_SESSION['customer_id']."',  menu_id  = '".$array_select['menu_item_id']."',restaurant_id = '".$array_select['restaurant_id']."',quantity = '".$array_select['quantity']."', unit_price = '".$array_select['price']."',special_instructions = '".htmlspecialchars(stripslashes($array_select['special_ins']),ENT_QUOTES)."', additional_instructions = '".htmlspecialchars(stripslashes($array_select['additional_instructions']),ENT_QUOTES)."' , order_date = '".$sql_total_price['order_date']."',customer_name='".htmlspecialchars(stripslashes($sql_customer['firstname']),ENT_QUOTES)."',customer_email='".$sql_customer['email']."',menu_name = '".trim(htmlspecialchars(stripslashes($sql_menu_item['menu_name']),ENT_QUOTES))."',sum = '".$sum."', menu_price = '".$array_select['menu_price']."', tax = '".$array_select['tax']."' , group_order_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' , group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."'");
	
	
	$sql_update = mysql_query("UPDATE restaurant_menu_item SET purchased = purchased + ".$array_select['quantity']." WHERE id = '".$array_select['menu_item_id']."'");
	
	}
	
	$sql_contact_details = mysql_query("INSERT INTO restaurant_order_contact_details SET firstname = '".htmlspecialchars(stripslashes($_REQUEST['first_name']),ENT_QUOTES)."',lastname = '".htmlspecialchars(stripslashes($_REQUEST['last_name']),ENT_QUOTES)."', email='".$_REQUEST['email']."', phone='".$_REQUEST['phone']."', address='".htmlspecialchars(stripslashes($_REQUEST['address']),ENT_QUOTES)."', city='".htmlspecialchars(stripslashes($_REQUEST['city']),ENT_QUOTES)."', state='".htmlspecialchars(stripslashes($_REQUEST['state']),ENT_QUOTES)."', zipcode='".$_REQUEST['zipcode']."', special_ins='".htmlspecialchars(stripslashes($_REQUEST['delivery_info']),ENT_QUOTES)."', save_earth='".$_REQUEST['save_earth']."', customer_id='".$_SESSION['customer_id']."', order_id = '".$order_id."'");
	
	if($sql_total_price['type'] == 'pickup'){ $order_type = 'Pick up'; }
	else { $order_type = 'Delivery'; }
	
	if($sql_total_price['delivery_charge'] == 0.00){
		$delivery_charge = 'Free';
	}
	else { 
	
		if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
			$delivery_charge = '$ '.$_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
		}else{
			$delivery_charge = '$ '.$_SESSION['del_charge'.$ses_rest_id];
		}
	}
	
	if($sql_total_price['payment_mode'] == 'cash'){
		$payment_mode = 'Cash';
	}else{
		$payment_mode = 'Credit Card';
	}
	
	$sql_get_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$order_id."'"));
	
	$name = $sql_customer_details['firstname']." ".$sql_customer_details['lastname'];
	
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
	 
	 //$sql_select1 = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."'");
	 
	 if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$sql_select1 = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."' ");
	}else{
		$sql_select1 = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '0' AND group_order_details_id = '0' ");
	}
	
	
	$ii = 1;
	while($array_select1 = mysql_fetch_array($sql_select1)) {
	$sql_select_product = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select1['menu_item_id']."'"));
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
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$coupon_code = $_SESSION['coupon_code'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
		$coupon_discount = $_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
	}else{
		$coupon_code = $_SESSION['coupon_code'.$ses_rest_id];
		$coupon_discount = $_SESSION['coupon_discount'.$ses_rest_id];
	}
	
	
	$sql_sel_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$coupon_code."'"));
	
	
	if($coupon_code!=''){
		$coup_cd = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Coupon :'.$sql_sel_coupon['coupon_name'].'&nbsp;</p><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Discount : $ '.$coupon_discount.'&nbsp;</p>';
		
		$sql_apply_count = mysql_query("UPDATE restaurant_coupon SET apply_coupon = apply_coupon-1 WHERE coupon_code = '".$coupon_code."' ");
	}
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$reward_point = $_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
	}else{
		$reward_point = $_SESSION['reward_point'.$ses_rest_id];
	}
	
	if($reward_point!=''){
		$rew_pt = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Reward Point Discount : $ '.$reward_point.'&nbsp;</p>';
	}
	
	if($service_fee!=0){
		$servicefee = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Service Fee : $ '.$service_fee.'&nbsp;</p>';
	}else{
		$servicefee = '';
	}
	
	/* -------------------------------------- Restaurant Owner ---------------------------------------- */
	$email = $sql_restaurant_basic['email'];//"priya@infosolz.com"; //"sourav.de@infosolz.com"
	
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
	mail($res_email[0],$subject,$message,$headers);
	
	/* ------------------------------------------------------------------------------------------------ */
	
	/*--------------------------------------- Customer ------------------------------------------------ */
	$email = $sql_customer_details['email'];//"priya@infosolz.com"; //"sourav.de@infosolz.com"
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
	
	mail($email,$subject,$message,$headers);
	
	/* ------------------------------------------------------------------------------------------------ */
	
	/* -------------------------------------- Admin --------------------------------------------------- */
	$customer_name = $sql_get_contact_details['firstname']." ".$sql_get_contact_details['lastname'];
	$sql_admin_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = 1"));
	$admin_email_address = $sql_admin_details['email_address'];
	
	$arr_email_address = explode(",",$admin_email_address);
	
	$email = "support@foodandmenu.com";//"priya@infosolz.com"; //"priya@infosolz.com""sourav.de@infosolz.com"
	
	$name = "Admin";
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 28"));	
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$customer_name%%',$customer_name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
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
	
	//$sql_empty_cart = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."'");
	if($_SESSION['group_order_id'.$ses_rest_id] == "" && $_SESSION['group_order_details_id'.$ses_rest_id] == "")
	{
		$sql_empty_cart = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."'");
	}
	
	$sql_resubmit = mysql_query("UPDATE restaurant_food_order_details SET  resubmit = 0 WHERE customer_id = '".$_SESSION['customer_id']."'");
	
	//$sql_get_reward_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));
	
	$curr_date = date('Y-m-d');
		
	$sql_mul_reward = mysql_query("SELECT * FROM restaurant_multiple_reward WHERE start_date <= '".$curr_date."' AND end_date >= '".$curr_date."'");
	
	while($row_mul_reward = mysql_fetch_array($sql_mul_reward))
	{
		 $type_id = explode(",",$row_mul_reward['reward_type']);
		 
		 if(in_array(1 , $type_id))
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
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$reward_point1 = $_SESSION['user_reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
	}else{
		$reward_point1 = $_SESSION['user_reward_point'.$ses_rest_id];
	}
	
	
	$sql_update_reward = mysql_query("UPDATE restaurant_customer SET reward_point = reward_point-".$reward_point1." WHERE id = '".$_SESSION['customer_id']."' ");
	
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
		
		////////////////Mail to Customer//////////////////
		
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
		
		$subject = stripslashes($sql_cms['subject']);
		
		mail($email_cust,$subject,$message,$headers);*/
		
	}
	
	
	
	$_SESSION['coupon_code'.$ses_rest_id] = '';
	$_SESSION['coupon_discount'.$ses_rest_id] = '';
	$_SESSION['reward_point'.$ses_rest_id] = '';
	$_SESSION['user_reward_point'.$ses_rest_id] = '';
	
	$_SESSION['group_order_id'.$ses_rest_id] = "";
	$_SESSION['group_order_details_id'.$ses_rest_id] = "";
	$_SESSION['coupon_code'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
	$_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
	$_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
	$_SESSION['user_reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
							
	header("location:payment_success.php");
	
	exit;
	
		
		
		}else{
			
		
		$loginname = '7wBx8D5R';
		$transactionkey = '674tq954ZKzchRSB';
		$host = 'https://secure.authorize.net/gateway/transact.dll';
		
		/*$loginname = '9U6b68Xafah';
		$transactionkey = '3T274U3nZv73ttRH';
		$host = 'https://test.authorize.net/gateway/transact.dll';*/
		
		$amount=$_REQUEST['amount'];
		
		$quant = 0;
		$name = $_REQUEST['first_name'];
		$length = $_REQUEST['length'];
		$unit = $_REQUEST['unit'];
		$unit_in_db=($unit=='months')?1:2;
		$startDate = $_REQUEST['startDate'];
		$totalOccurrences = $_REQUEST['totalOccurrences'];
		$trialOccurrences = $_REQUEST['trialOccurrences'];
		$trialAmount = $_REQUEST['trialAmount'];
		$cardNumber = $_REQUEST['card_no'];
		//$expirationDate = $_REQUEST['expiry_date'];
		$expirationDate = $_REQUEST['exp_month']."/".$_REQUEST['exp_year'];
		$expirationDt = explode('/',$expirationDate);	
		$expirationDate = "20".$expirationDt[1].'-'.$expirationDt[0];	
		$firstName = $_REQUEST['first_name'];
		$lastName = $_REQUEST['last_name'];
		$address = $_REQUEST['address'];
		$city = $_REQUEST['city'];
		$state = $_REQUEST['state'];
		$zipcode = $_REQUEST['zipcode'];
		$phone = $_REQUEST['phone'];
		$email = $_REQUEST['email'];
		$cvv = $_REQUEST['cvv_no'];
		
		
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
			
			require_once 'anet_php_sdk/AuthorizeNet.php'; 
			define("AUTHORIZENET_API_LOGIN_ID", $loginname); 
			define("AUTHORIZENET_TRANSACTION_KEY", $transactionkey); 
			define("AUTHORIZENET_SANDBOX", false); 
			$sale = new AuthorizeNetAIM; 
			$sale->amount = $amount; 
			$sale->card_num = $cardNumber; 
			$sale->exp_date = $expirationDate;
			$sale->description = "Menu Item Purchase";
			$sale->first_name = $firstName; 
			$sale->last_name = $lastName; 
			$sale->address = $address;
			$sale->city = $city;
			$sale->state = $state;
			$sale->zip = $zipcode;
			$sale->phone = $phone;
			$sale->email = $email;
			$response = $sale->authorizeAndCapture(); 
		
		
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
			
			$unique_ref_length = 5;  
	
	// A true/false variable that lets us know if we've  
	// found a unique reference number or not  
	$unique_ref_found = false;  
	  
	// Define possible characters.  
	// Notice how characters that may be confused such  
	// as the letter 'O' and the number zero don't exist  
	$possible_chars = "123456789BCDFGHJKMNPQRSTVWXYZ";  
	
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
		
		$query = "SELECT `confirmation_code` FROM `restaurant_menu_order`  WHERE  `confirmation_code` = '".$unique_ref."'";
		$result = mysql_query($query) or die(mysql_error().' '.$query);  
		if (mysql_num_rows($result)==0) {  
		  
			// We've found a unique number. Lets set the $unique_ref_found  
			// variable to true and exit the while loop  
			$unique_ref_found = true; 
		}  
	}  
	  
	$unique_no = $unique_ref;  
	
	
	$sql_restaurant_basic = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['cart_rest_id']."'"));
	
	$sql_del_com_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_SESSION['cart_rest_id']."'"));
	
	$sql_update_customer_data = mysql_query("UPDATE restaurant_customer SET address = '".htmlspecialchars(stripslashes($_REQUEST['address']),ENT_QUOTES)."' , city = '".htmlspecialchars(stripslashes($_REQUEST['city']),ENT_QUOTES)."' , state = '".htmlspecialchars(stripslashes($_REQUEST['state']),ENT_QUOTES)."' , zip = '".$_REQUEST['zipcode']."', phone = '".$_REQUEST['phone']."', billing_address = '".htmlspecialchars(stripslashes($_REQUEST['billing_address']),ENT_QUOTES)."'  , billing_state = '".htmlspecialchars(stripslashes($_REQUEST['billing_state']),ENT_QUOTES)."' , billing_city = '".htmlspecialchars(stripslashes($_REQUEST['billing_city']),ENT_QUOTES)."', billing_zip = '".htmlspecialchars(stripslashes($_REQUEST['billing_zip']),ENT_QUOTES)."' WHERE id = '".$_SESSION['customer_id']."' ");
	
	$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
	
	$sql_delivery_charge = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_SESSION['cart_rest_id']."'"));
	
	$sql_insert_order = "INSERT INTO restaurant_menu_order SET customer_id = '".$_SESSION['customer_id']."',restaurant_id = '".$_SESSION['cart_rest_id']."', total_price = '".$_REQUEST['amount2']."', order_date = '".date('Y-m-d H:i:s')."', type = '".$_REQUEST['type']."',status = 'Pending',customer_name = '".htmlspecialchars(stripslashes($sql_customer['firstname']),ENT_QUOTES)."',customer_address = '".htmlspecialchars(stripslashes($sql_customer['address']),ENT_QUOTES)."', special_delivery_info = '".htmlspecialchars(stripslashes($_REQUEST['delivery_info']),ENT_QUOTES)."', customer_phone = '".$sql_customer['phone']."', tax = '".$_REQUEST['tax']."' , tip = '".$_REQUEST['tip']."', confirmation_code = '".$unique_no."', payment_mode = '".$_REQUEST['payment_mode']."' , spare_napkins = '".$_REQUEST['save_earth']."' , group_order_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' , group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."' ";
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$sql_insert_order.= " , coupon_code = '".$_SESSION['coupon_code'.$ses_rest_id.'_'.$_SESSION['group_order_details_id']]."' , coupon_discount = '".$_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]."' , reward_points = '".$_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]."' ";
	}else{
		$sql_insert_order.= " , coupon_code = '".$_SESSION['coupon_code'.$ses_rest_id]."' , coupon_discount = '".$_SESSION['coupon_discount'.$ses_rest_id]."' , reward_points = '".$_SESSION['reward_point'.$ses_rest_id]."' ";
	}
	
	
	if($_REQUEST['type'] == 'del'){
		if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
			$total_card_amount = ($_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip']);
			$credit_card_fee = round((($sql_delivery_charge['credit_card_fee']*$total_card_amount)/100),2);
			$service_fee = $sql_delivery_charge['service_fee'];
			
			$sql_insert_order.=" ,delivery_charge = '".$_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]."', price_with_del_charge = '".($_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee) ."' , credit_card_fee = '".$credit_card_fee."' , service_fee = '".$service_fee."' ";
			
			$commission = (($_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)*$sql_del_com_info['commission'])/100;
		}else{
			$total_card_amount = ($_SESSION['del_charge'.$ses_rest_id]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip']);
			$credit_card_fee = round((($sql_delivery_charge['credit_card_fee']*$total_card_amount)/100),2);
			$service_fee = $sql_delivery_charge['service_fee'];
			
			$sql_insert_order.=" ,delivery_charge = '".$_SESSION['del_charge'.$ses_rest_id]."', price_with_del_charge = '".($_SESSION['del_charge'.$ses_rest_id]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee) ."' , credit_card_fee = '".$credit_card_fee."' , service_fee = '".$service_fee."' ";
			
			$commission = (($_SESSION['del_charge'.$ses_rest_id]+$_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)*$sql_del_com_info['commission'])/100;
		}
	
	$sql_insert_order.=" , commission = '".$commission."' ";
	 }
	else {
	$total_card_amount = ($_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip']);
	$credit_card_fee = round((($sql_delivery_charge['credit_card_fee']*$total_card_amount)/100),2);	
	$service_fee = $sql_delivery_charge['service_fee'];
	
	$sql_insert_order.=" , price_with_del_charge = '".($_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)."' , credit_card_fee = '".$credit_card_fee."' , service_fee = '".$service_fee."' ";
	
	$commission = (($_REQUEST['amount2'] + $_REQUEST['tax'] + $_REQUEST['tip'] + $service_fee)*$sql_del_com_info['commission'])/100;
	$sql_insert_order.=" , commission = '".$commission."' ";
	}
	
	//echo $sql_insert_order; exit;
	
	mysql_query($sql_insert_order);
	
	$order_id = mysql_insert_id();
	
	$upd_done_status = mysql_query("UPDATE restaurant_group_order_details SET done_status = '1' WHERE group_order_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."'");
	
	$insert_credit_card_details = mysql_query("INSERT INTO restaurant_menu_credit_details SET card_type = '".$_REQUEST['card_type']."' , card_no = '".$_REQUEST['card_no']."' , cvv_no = '".$_REQUEST['cvv_no']."' , expiry_date = '".$_REQUEST['exp_month']."-".$_REQUEST['exp_year']."' , order_id = '".$order_id."'");	
			
	$sql_total_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));
	
	//$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."'");
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."' ");
	}else{
		$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '0' AND group_order_details_id = '0' ");
	}
	
	while($array_select = mysql_fetch_array($sql_select)) {
	$sql_menu_item = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select['menu_item_id']."'"));
	$sum = ($array_select['quantity']*$array_select['price'] + $array_select['tax']);
	
	$sql_insert_food_details = mysql_query("INSERT INTO  restaurant_food_order_details SET  order_id = '".$order_id."' , customer_id = '".$_SESSION['customer_id']."',  menu_id  = '".$array_select['menu_item_id']."',restaurant_id = '".$array_select['restaurant_id']."',quantity = '".$array_select['quantity']."', unit_price = '".$array_select['price']."',special_instructions = '".htmlspecialchars(stripslashes($array_select['special_ins']),ENT_QUOTES)."', additional_instructions = '".htmlspecialchars(stripslashes($array_select['additional_instructions']),ENT_QUOTES)."' , order_date = '".$sql_total_price['order_date']."',customer_name='".htmlspecialchars(stripslashes($sql_customer['firstname']),ENT_QUOTES)."',customer_email='".$sql_customer['email']."',menu_name = '".htmlspecialchars(stripslashes($sql_menu_item['menu_name']),ENT_QUOTES)."',sum = '".$sum."', menu_price = '".$array_select['menu_price']."', tax = '".$array_select['tax']."' , group_order_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' , group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."'");
	
	
	$sql_update = mysql_query("UPDATE restaurant_menu_item SET purchased = purchased + ".$array_select['quantity']." WHERE id = '".$array_select['menu_item_id']."'");
	
	}
	
	$sql_contact_details = mysql_query("INSERT INTO restaurant_order_contact_details SET firstname = '".htmlspecialchars(stripslashes($_REQUEST['first_name']),ENT_QUOTES)."',lastname = '".htmlspecialchars(stripslashes($_REQUEST['last_name']),ENT_QUOTES)."', email='".$_REQUEST['email']."', phone='".$_REQUEST['phone']."', address='".htmlspecialchars(stripslashes($_REQUEST['address']),ENT_QUOTES)."', city='".htmlspecialchars(stripslashes($_REQUEST['city']),ENT_QUOTES)."', state='".htmlspecialchars(stripslashes($_REQUEST['state']),ENT_QUOTES)."', zipcode='".$_REQUEST['zipcode']."', special_ins='".htmlspecialchars(stripslashes($_REQUEST['delivery_info']),ENT_QUOTES)."', save_earth='".$_REQUEST['save_earth']."', customer_id='".$_SESSION['customer_id']."', order_id = '".$order_id."'");
	
	if($sql_total_price['type'] == 'pickup'){ $order_type = 'Pick up'; }
	else { $order_type = 'Delivery'; }
	
	if($sql_total_price['delivery_charge'] == 0.00){
		$delivery_charge = 'Free';
	}
	else {
		if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
			$delivery_charge = '$ '.$_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id']];
		}else{
			$delivery_charge = '$ '.$_SESSION['del_charge'.$ses_rest_id];
		}
	}
	
	if($sql_total_price['payment_mode'] == 'cash'){
		$payment_mode = 'Cash';
	}else{
		$payment_mode = 'Credit Card';
	}
	
	$sql_get_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$order_id."'"));
	
	$name = $sql_customer_details['firstname']." ".$sql_customer_details['lastname'];
	
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
	 
	 //$sql_select1 = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."'");
	 
	 if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		 $sql_select1 = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."' ");
	 }else{
		 $sql_select1 = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."' AND group_id = '0' AND group_order_details_id = '0' ");
	 }
	 
	$ii = 1;
	while($array_select1 = mysql_fetch_array($sql_select1)) {
	$sql_select_product = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select1['menu_item_id']."'"));
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
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$coupon_code = $_SESSION['coupon_code'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
		$coupon_discount = $_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
	}else{
		$coupon_code = $_SESSION['coupon_code'.$ses_rest_id];
		$coupon_discount = $_SESSION['coupon_discount'.$ses_rest_id];
	}
	
	
	$sql_sel_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$coupon_code."'"));
	
	if($coupon_code!=''){
		$coup_cd = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Coupon :'.$sql_sel_coupon['coupon_name'].'&nbsp;</p><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Discount : $ '.$coupon_discount.'&nbsp;</p>';
		$sql_apply_count = mysql_query("UPDATE restaurant_coupon SET apply_coupon = apply_coupon-1 WHERE coupon_code = '".$coupon_code."' ");
	}
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$reward_point = $_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
	}else{
		$reward_point = $_SESSION['reward_point'.$ses_rest_id];
	}
	
	if($reward_point!=''){
		$rew_pt = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Reward Point Discount : $ '.$reward_point.'&nbsp;</p>';
	}
	
	
	if($servicefee!=0){
		$servicefee = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Service Fee : $ '.$service_fee.'&nbsp;</p>';
	}else{
		$servicefee = '';
	}
	
	$credit_card_inf ='<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Credit Card No. : '.$_REQUEST['card_no'].'&nbsp;</p>
	<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">CVV : '.$_REQUEST['cvv_no'].'&nbsp;</p>
	<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Expiration Date : '.$_REQUEST['exp_month']."-".$_REQUEST['exp_year'].'&nbsp;</p>';
	
	/* -------------------------------------- Restaurant Owner ---------------------------------------- */
	$email = $sql_restaurant_basic['email']; //"priya@infosolz.com"
	
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
	mail($res_email[0],$subject,$message,$headers);
	
	/* ------------------------------------------------------------------------------------------------ */
	
	/*--------------------------------------- Customer ------------------------------------------------ */
	$email = $sql_customer_details['email']; //"priya@infosolz.com"
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
	
	mail($email,$subject,$message,$headers);
	
	/* ------------------------------------------------------------------------------------------------ */
	
	/* -------------------------------------- Admin --------------------------------------------------- */
	$customer_name = $sql_get_contact_details['firstname']." ".$sql_get_contact_details['lastname'];
	$sql_admin_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = 1"));
	$admin_email_address = $sql_admin_details['email_address'];
	
	$arr_email_address = explode(",",$admin_email_address);
	
	$email = "support@foodandmenu.com"; //"priya@infosolz.com"
	
	$name = "Admin";
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 28"));	
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$customer_name%%',$customer_name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
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
	$cms_rep=str_replace('%%$credit_card_inf%%',$credit_card_inf,$cms_rep);
	
	
	
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
	
	//$sql_empty_cart = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_SESSION['cart_rest_id']."'");
	if($_SESSION['group_order_id'.$ses_rest_id] == "" && $_SESSION['group_order_details_id'.$ses_rest_id] == "") 
	{
		$sql_empty_cart = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."'");
	}
	
	$sql_resubmit = mysql_query("UPDATE restaurant_food_order_details SET  resubmit = 0 WHERE customer_id = '".$_SESSION['customer_id']."'");
	
	//$sql_get_reward_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));
	
	$curr_date = date('Y-m-d');
		
	$sql_mul_reward = mysql_query("SELECT * FROM restaurant_multiple_reward WHERE start_date <= '".$curr_date."' AND end_date >= '".$curr_date."'");
	
	while($row_mul_reward = mysql_fetch_array($sql_mul_reward))
	{
		 $type_id = explode(",",$row_mul_reward['reward_type']);
		 
		 if(in_array(1 , $type_id))
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
	
	if($_SESSION['group_order_details_id'.$ses_rest_id]!='' && $_SESSION['group_order_id'.$ses_rest_id]!=''){
		$user_reward_point = $_SESSION['user_reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
	}else{
		$user_reward_point = $_SESSION['user_reward_point'.$ses_rest_id];
	}
	
	
	$sql_update_reward = mysql_query("UPDATE restaurant_customer SET reward_point = reward_point-".$user_reward_point." WHERE id = '".$_SESSION['customer_id']."' ");
	
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
			
			/////////////////Mail to Customer//////////////////////
			
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
			
			$subject = stripslashes($sql_cms['subject']);
			
			mail($email_cust,$subject,$message,$headers);*/
			
			
	}
	
	
	
	$_SESSION['coupon_code'.$ses_rest_id] = '';
	$_SESSION['coupon_discount'.$ses_rest_id] = '';
	$_SESSION['reward_point'.$ses_rest_id] = '';
	$_SESSION['user_reward_point'.$ses_rest_id] = '';
	
	$_SESSION['group_order_id'.$ses_rest_id] = "";
	$_SESSION['group_order_details_id'.$ses_rest_id] = "";
	$_SESSION['coupon_code'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
	$_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
	$_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
	$_SESSION['user_reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
							
	header("location:payment_success.php");
	
	exit;	
			
			
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
	
	
	}
	
	

?>

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
<script type="text/javascript">
function checkMessenger(themail)
{
	var tomatch  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!tomatch.test(themail))
	{ 
	window.alert('Invalid Email Address');
	return false;
	}
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

function submit_frm(){
	document.getElementById('fade11').style.display = 'block';
	document.getElementById('submit_div').style.display = 'block';
}

function check_auth()
{
	var expiry_date = document.frm.exp_month.value+"/"+document.frm.exp_year.value;
	document.frm.card_type.value=document.frm.card_type.value;
	document.frm.card_no.value=document.frm.card_no.value;
	
	if (document.frm.card_type.value=="select_card")
    {
        alert ( "Please select the card type." );
		document.frm.card_type.focus();
        return false;
    }
	
	 
	if ( document.frm.card_no.value == "" )
    {
        alert ( "Please enter the card number." );
		document.frm.card_no.focus();
        return false;
    }
	
	if ( document.frm.card_no.value == "" )
    {
        alert ( "Please enter the card number." );
		document.frm.card_no.focus();
        return false;
    }
	if (document.frm.card_no.value!="")
	{
	   var status=Mod10(document.frm.card_no.value);
	   if(!status)
	   {
		   document.frm.card_no.focus();
	       return false;
	   }
	}
	if(document.frm.card_type.value=='visa' && document.frm.card_no.value.charAt(0)!='4')
	{
		alert ( "The Credit Card Number does NOT seem to be of Visa!\n Please select proper card type." );
		document.frm.card_no.focus();
        return false;
	}
	if(document.frm.card_type.value=='master_card' && document.frm.card_no.value.charAt(0)!='5')
	{
		alert ( "The Credit Card Number does NOT seem to be of MasterCard!\n Please select proper card type." );
		document.frm.card_no.focus();
        return false;
	}
	if(document.frm.card_type.value=='disco' && document.frm.card_no.value.charAt(0)!='6')
	{
		alert ( "The Credit Card Number does NOT seem to be of Discover!\n Please select proper card type." );
		document.frm.card_no.focus();
        return false;
	}
	if(document.frm.card_type.value=='amex' && document.frm.card_no.value.charAt(0)!='3')
	{
		alert ( "The Credit Card Number does NOT seem to be of AmEx!\n Please select proper card type." );
		document.frm.card_no.focus();
        return false;
	}
	
    //var exp_date=document.frm.expirationDateM.value+'/'+document.frm.expirationDateY.value;
	var exp_date=expiry_date;
	var exp_date_arr=exp_date.split("/");
	var exp_year='20'+exp_date_arr[1];
	var exp_mon=exp_date_arr[0];
	var now = new Date();
	var curr_year=now.getFullYear();
	var curr_mon=now.getMonth();
	var exp_dt_frmt=/^((0[1-9])|(1[0-2]))\/(\d{4})$/;
	
	if (exp_date == "")
    {
        alert ("Please enter expiry date.");
        return false;
    }
	if (exp_date.indexOf('/') == -1 )
    {
        alert ( "The expiration date is NOT valid!" );
        return false;
    }
	if (exp_mon>12)
    {
        alert ( "The expiration date is NOT valid!" );
        return false;
    }
	if (exp_date.match(exp_dt_frmt)==null)
	{
        alert ( "The expiration date is NOT valid!" );
        return false;
    }
	if(exp_year<curr_year)
	{
		alert ( "The card has already expired!" );
        return false;
	}
	if(exp_year==curr_year && exp_mon<curr_mon)
	{
		alert ( "The card has already expired!" );
		return false;
	}
	document.frm.buttonclick.value="auth";
	return true;
	
}
function check_it()
{
	if ( document.frm.first_name.value == "" )
    {
        alert ( "Please enter firstname." );
		document.frm.first_name.focus();
        return false;
    }
	if ( document.frm.last_name.value == "" )
    {
        alert ( "Please enter lastname." );
		document.frm.last_name.focus();
        return false;
    }
	if(document.frm.email.value == ''){
		alert("Please enter email");
		document.frm.email.focus();	
		return false;	
	}
	if ((document.frm.email.value!="") && (checkMessenger(document.frm.email.value)==false))
	{
	document.frm.email.value="";
	document.frm.email.focus();
	return false;
	}
	if ( document.frm.phone.value == "" )
    {
        alert ( "Please enter phone number." );
		document.frm.phone.focus();
        return false;
    }
	if ( document.frm.address.value == "" )
    {
        alert ( "Please enter address." );
		document.frm.address.focus();
        return false;
    }
	if ( document.frm.city.value == "" )
    {
        alert ( "Please enter city." );
		document.frm.city.focus();
        return false;
    }
	if ( document.frm.state.value == "" )
    {
        alert ( "Please enter state." );
		document.frm.state.focus();
        return false;
    }
	if ( document.frm.zipcode.value == "" )
    {
        alert ( "Please enter zipcode." );
		document.frm.zipcode.focus();
        return false;
    }
	if(document.getElementById('credit_card').checked == true){
	
	if ( document.frm.card_type.value == "" )
    {
        alert ( "Please select card type." );
		document.frm.card_type.focus();
        return false;
    }
	if ( document.frm.card_no.value == "" )
    {
        alert ( "Please select card number." );
		document.frm.card_no.focus();
        return false;
    }
	if (document.frm.card_no.value!="")
	{
		var status=Mod10(document.frm.card_no.value);
		if(!status)
		{
		   document.frm.card_no.focus();
		   return false;
		}
	}
	if(document.frm.card_type.value=='visa' && document.frm.card_no.value.charAt(0)!='4')
	{
		alert ( "The Credit Card Number does NOT seem to be of Visa!\n Please select proper card type." );
		document.frm.card_no.focus();
        return false;
	}
	if(document.frm.card_type.value=='master_card' && document.frm.card_no.value.charAt(0)!='5')
	{
		alert ( "The Credit Card Number does NOT seem to be of MasterCard!\n Please select proper card type." );
		document.frm.card_no.focus();
        return false;
	}
	if(document.frm.card_type.value=='disco' && document.frm.card_no.value.charAt(0)!='6')
	{
		alert ( "The Credit Card Number does NOT seem to be of Discover!\n Please select proper card type." );
		document.frm.card_no.focus();
        return false;
	}
	if(document.frm.card_type.value=='amex' && document.frm.card_no.value.charAt(0)!='3')
	{
		alert ( "The Credit Card Number does NOT seem to be of AmEx!\n Please select proper card type." );
		document.frm.card_no.focus();
        return false;
	}
	if ( document.frm.cvv_no.value == "" )
    {
        alert ( "Please select cvv number." );
		document.frm.cvv_no.focus();
        return false;
    }
	if(document.getElementById('exp_month').value == ''){
		alert( 'Please select expiry date month.' );
		document.getElementById('exp_month').focus();
		return false;
	}
	if( document.getElementById('exp_year').value == ''){
		alert( 'Please select expiry date year.' );
		document.getElementById('exp_year').focus();
		return false;
	}
		
	var expiry_date = document.getElementById('exp_month').value+"/"+document.getElementById('exp_year').value;
	var str = expiry_date;
	var n=str.split("/");
	//alert(str);
	var exp_date = n[1]+n[0];
	var today1 = document.getElementById("today").value;
	//alert(today1);
	var m=today1.split("/");
	var today = m[1]+m[0];
	var d1 = parseInt(today);
	var d2 = parseInt(exp_date);
	//alert(d1);
	//alert(d2);
	if(d1 > d2) {
		alert('Enter valid expiry date.');
		return false;
	}
	
	//var exp_date=document.frm.expirationDateM.value+'/'+document.frm.expirationDateY.value;
	var exp_date=expiry_date;
	var exp_date_arr=exp_date.split("/");
	var exp_year='20'+exp_date_arr[1];
	var exp_mon=exp_date_arr[0];
	var exp_date = exp_mon + '/' + exp_year;
	var now = new Date();
	var curr_year=now.getFullYear();
	var curr_mon=now.getMonth();
	var exp_dt_frmt=/^((0[1-9])|(1[0-2]))\/(\d{4})$/;
	
	if (exp_date.indexOf('/') == -1 )
    {
        alert ( "The expiry date is NOT valid!" );
        return false;
    }
	if (exp_mon>12)
    {
        alert ( "The expiry date is NOT valid!" );
        return false;
    }
	if (exp_date.match(exp_dt_frmt)==null)
	{
        alert ( "The expiry date is NOT valid!" );
        return false;
    }
	if(exp_year<curr_year)
	{
		alert ( "The card has already expired!" );
        return false;
	}
	if(exp_year==curr_year && exp_mon<curr_mon)
	{
		alert ( "The card has already expired!" );
        return false;
	}
	
	}
	
	
	document.frm.buttonclick.value="sale";
	return true;
}

function cal_total(tip){	
	var total_amt = document.getElementById('total_amt').value;
	//alert(total_amt);
	if(tip == '' || tip == 0){
		var total = parseFloat(total_amt);	
		var total1 = total.toFixed(2);	
	}
	else{
		var total = (parseFloat(total_amt) + parseFloat(tip));
		var total1 = total.toFixed(2);
	}	
	document.getElementById('amount').value = total1;
}

function show_details(id){
	document.getElementById('splins_div'+id).style.display = 'block';
	document.getElementById('hide_det'+id).style.display = 'block';
	document.getElementById('show_det'+id).style.display = 'none';
}

function hide_details(id){
	document.getElementById('splins_div'+id).style.display = 'none';
	document.getElementById('show_det'+id).style.display = 'block';
	document.getElementById('hide_det'+id).style.display = 'none';
}

function pay_mode(val){
	if(document.getElementById('credit_card').checked == true){
		document.getElementById('credit_div').style.display = 'block';
		
	}else{
		document.getElementById('credit_div').style.display = 'none';	
	}
}

function check_shipping_billing(){
	var $j = jQuery.noConflict();
	if($j("#check1").prop("checked") == true){
		$j("#billing_address").val($j("#address").val());
		$j("#billing_city").val($j("#city").val());
		$j("#billing_state").val($j("#state").val());
		$j("#billing_zip").val($j("#zipcode").val());
	}else{
		$j("#billing_address").val('');
		$j("#billing_city").val('');
		$j("#billing_state").val('');
		$j("#billing_zip").val('');
	}
}
</script>

<div id="fade11" style="display:none;"></div>
<div style="width:400px; height:1px; margin:0 auto; display:none;" id="submit_div">
<div class="pop-box"  style="width:300px; position:absolute; z-index:9999999; background:#EFEFEF; padding:34px 24px; color:#000; font-family:Calibri; font-size:18px; -moz-box-shadow: 0 0 5px #888; -webkit-box-shadow: 0 0 5px#888; box-shadow: 0 0 5px #888; text-align:center; margin-top:650px; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border:#2C4598 2px solid;">
<img src="images/ajax-loader.gif" align="middle" style="margin-left:40px;"/> <br>
<p style="color:rgb(73, 96, 168);">Please wait until we process for payment.</p>               
</div></div>

<body onLoad="init();">

<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php"); ?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top check_out_head">
<div class="about_cont_top">
<h1>Check out process</h1>
<p><img width="410" height="17" src="images/star-bar-black.png"></p>
</div>
<div class="checkout_left_panel">
<div id="navigation_single_cart" class="navigation_single_cart_class">

<div class="rstrnt_right_panel" id="chck_cart">
                        
<div class="rstrnt2_mre_info">

<h2 class="restrnt2_order">Your Order</h2>
<?php $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['cart_rest_id']."'")); 
$sql_delivery_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_SESSION['cart_rest_id']."'")); ?>
<p style="color:#000000; font-size:18px;"><?php echo stripslashes($sql_restaurant['restaurant_name']); ?></p>
<p style="color:#000000; font-size:16px;"><?php echo stripslashes($sql_restaurant['restaurant_address']);?></p>
<p style="color:#000000; font-size:16px;">
<?php echo $sql_restaurant['restaurant_city'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_state'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_zipcode'];?></p>
                                  
<?php /*?><table width="100%" border="0" cellspacing="1" class="restro2_table">
  <tr>
    <td height="20" colspan="3" align="center" class="restro2_table_bg"><h2>Qty</h2></td>
    <td width="53%" height="20" align="center" class="restro2_table_bg"><h2>Item</h2></td>
    <td width="24%" height="20" align="center" class="restro2_table_bg"><h2>Price</h2></td>
  </tr>
  <?php 
  $sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE restaurant_id = '".$_SESSION['cart_rest_id']."' AND session_id = '".$session_id."'");
  $amount = 0;
  while($array_select = mysql_fetch_array($sql_select)){ ?>
  <tr>
    <td height="30" colspan="3" align="center"><?php echo $array_select['quantity']; ?></td>
    <td height="30" align="center"><?php $sql_item_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select['menu_item_id']."'"));
	echo $sql_item_name['menu_name']; ?></td>
    <td height="30" align="left" style="padding-left:10px;">$ <?php echo ($array_select['menu_price']*$array_select['quantity']); ?></td>
  </tr>
  
  <?php if(!empty($array_select['additional_instructions'])){
	  $arr = (explode(",",$array_select['additional_instructions']));
	  foreach($arr as $val){
	  $sql_add_instructions = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$val."'")); ?>
  <tr>
    <td height="30" colspan="3" align="left"> Spl Ins -- </td>
    <td height="30" align="center"><?php echo $sql_add_instructions['title'];?></td>
    <td height="30" align="left" style="padding-left:10px;">$ <?php echo ($sql_add_instructions['price'] * $array_select['quantity']); ?></td>
  </tr>
  <?php } } ?>
  
  <?php if(!empty($array_select['special_ins'])){?>
   <tr>
    <td height="30" colspan="3" align="left">Additional Ins -- </td>
    <td height="30" align="center"><?php echo $array_select['special_ins'];?></td>
    <td height="30" align="center"></td>
   </tr>
   <?php } ?>
   
   <?php $amount = $amount + ($array_select['price']*$array_select['quantity']); } ?>
   <tr>
    <td height="10" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
    <td height="10" align="right" style="padding-top:20px;">Subtotal</td>
    <td height="10" align="center" style="padding-top:20px; padding-left:10px;">$ <?php echo $amount; ?></td>
   </tr>
   <tr>
    <td height="10" colspan="3" align="center">&nbsp;</td>
    <td height="10" align="right">Tax</td>
    <td height="10" align="center">
	<?php $tax = ($sql_delivery_details['tax']/100 * $amount);
	echo "$ ".round($tax, 2); ?>
    </td>
   </tr>
   <?php if($_REQUEST['type'] == 'del'){?>
   <tr>
    <td height="10" colspan="3" align="center">&nbsp;</td>
    <td height="10" align="right">Delivery Charge</td>
    <td height="10" align="center" style="padding-left:10px;"><?php if($_SESSION['del_charge']!=''){ echo "$ ".$_SESSION['del_charge']; }
	else { echo "Free"; } ?></td>
   </tr>
   <?php  } ?>
   <tr>
    <td height="10" colspan="3" align="center">&nbsp;</td>
    <td height="10" align="right">Total</td>
    <td height="10" align="center" style="padding-left:10px;">
	<?php if($_REQUEST['type'] == 'del' && $sql_delivery_details['delivery_charge']!=''){
		$total = ($amount + $tax + $sql_delivery_details['delivery_charge']);
	}
	else {
		$total = ($amount + $tax);
	}
	?>
    <?php echo "$ ".round($total, 2); ?>
    </td>
   </tr>
    
</table><?php */?>
<?php if($_SESSION['group_order_details_id'.$ses_rest_id] == "") { ?>
    <table width="100%" border="0" cellspacing="1" class="restro2_table">
      <tr>
        <td height="20" colspan="3" align="center" class="restro2_table_bg"><h2>Qty</h2></td>
        <td width="53%" height="20" align="center" class="restro2_table_bg"><h2>Item</h2></td>
        <td width="24%" height="20" align="center" class="restro2_table_bg"><h2>Price</h2></td>
      </tr>
      <?php 
      //echo $_SESSION['cart_rest_id'];
      
      
      $sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE restaurant_id = '".$_SESSION['cart_rest_id']."' AND session_id = '".$session_id."' AND group_id = '0'  AND group_order_details_id = '0'");
       $amount1 = 0;
      while($array_select = mysql_fetch_array($sql_select)){ ?>
      <tr>
        <td height="30" colspan="3" align="center"><?php echo $array_select['quantity']; ?></td>
        <td height="30" align="center"><?php $sql_item_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select['menu_item_id']."'"));
        echo $sql_item_name['menu_name']; ?>
        
        <?php if(!empty($array_select['additional_instructions']) || !empty($array_select['special_ins'])){ ?>
        <div id="show_det<?php echo $array_select['id']; ?>" style="margin-top:-22px;">
        <br><a href="javascript:void(0);" onClick="return show_details('<?php echo $array_select['id']; ?>')" style="color:#928A95; text-decoration:underline;" >Show Details</a>
        </div>
        <?php }?>
        
        <div id="splins_div<?php echo $array_select['id']; ?>" style="display:none; color:#B89172; white-space: -moz-pre-wrap;  white-space: -hp-pre-wrap;
    white-space: -o-pre-wrap;  white-space: -pre-wrap; white-space: pre-wrap; white-space: pre-line; word-wrap: break-word; width:150px;">
        <?php  $arr = (explode(",",$array_select['additional_instructions']));
          $sep = ''; 
          foreach($arr as $val){
          $sql_add_instructions = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$val."'"));
          echo $sep.htmlspecialchars_decode(htmlspecialchars_decode($sql_add_instructions['title']));
          $sep = ',';
          }
          if($array_select['special_ins']!=''){
              if(!empty($array_select['additional_instructions'])){
               echo ","; }
               echo htmlspecialchars_decode(htmlspecialchars_decode($array_select['special_ins']));
          }
          ?>
        </div>
        
        <?php if(!empty($array_select['additional_instructions']) || !empty($array_select['special_ins'])){ ?>
        <div id="hide_det<?php echo $array_select['id']; ?>" style="display:none; margin-top:-20px;">
        <br><a href="javascript:void(0);" onClick="return hide_details('<?php echo $array_select['id']; ?>')" style="color:#928A95; text-decoration:underline;" >Hide Details</a>
        </div>
        <?php } ?>
        </td>
        <td height="30" align="center">$ <?php echo ($array_select['price']*$array_select['quantity']); ?></td>
      </tr>
      <?php
      $amount1 = $amount1 + ($array_select['price']*$array_select['quantity']); }
      
      $amount = ($amount1 - $_SESSION['coupon_discount'.$ses_rest_id] - $_SESSION['reward_point'.$ses_rest_id]);
      ?>
      <?php if($_SESSION['coupon_discount'.$ses_rest_id]!=''){?>
       <tr>
        <td height="10" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
        <td height="10" align="right" style="padding-top:20px;">Coupon Discount</td>
        <td height="10" align="center" style="padding-top:20px;">$ <?php echo $_SESSION['coupon_discount'.$ses_rest_id]; ?></td>
       </tr>
       <?php } ?>
       
       <?php if($_SESSION['reward_point'.$ses_rest_id]!=''){?>
       <tr>
        <td height="10" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
        <td height="10" align="right" style="padding-top:20px;">Reward Point Discount</td>
        <td height="10" align="center" style="padding-top:20px;">$ <?php echo $_SESSION['reward_point'.$ses_rest_id]; ?></td>
       </tr>
       <?php } ?>
       
       <tr>
        <td height="10" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
        <td height="10" align="right" style="padding-top:20px;">Subtotal</td>
        <td height="10" align="center" style="padding-top:20px;">$ <?php echo $amount; ?></td>
       </tr>
       <?php if($sql_delivery_details['service_fee']!='' && $sql_delivery_details['service_fee']!=0){ ?>
       <tr>
        <td height="10" colspan="3" align="center">&nbsp;</td>
        <td height="10" align="right">Service Fee</td>
        <td height="10" align="center">
        <?php 
        $service_fee =  $sql_delivery_details['service_fee'];
        echo $service_fee; ?>
        </td>
       </tr>
       <?php } ?>   
       <tr>
        <td height="10" colspan="3" align="center">&nbsp;</td>
        <td height="10" align="right">Tax</td>
        <td height="10" align="center">
        <?php $tax = ($sql_delivery_details['tax']/100 * $amount);
        echo "$ ".round($tax, 2); ?>
        </td>
       </tr>
       <?php if($_REQUEST['type'] == 'del'){?>
       <tr>
        <td height="10" colspan="3" align="center">&nbsp;</td>
        <td height="10" align="right">Delivery Charge</td>
        <td height="10" align="center">
        <?php echo "$ ".$_SESSION['del_charge'.$ses_rest_id]; ?>
        </td>
       </tr>
       <?php  } ?>
       <tr>
        <td height="10" colspan="3" align="center">&nbsp;</td>
        <td height="10" align="right">Total</td>
        <td height="10" align="center">
        <?php if($_REQUEST['type'] == 'del' && $_SESSION['del_charge'.$ses_rest_id]!=''){
            $total = ($amount + $tax + $_SESSION['del_charge'.$ses_rest_id] + $sql_delivery_details['service_fee']);
        }
        else {
            $total = ($amount + $tax + $sql_delivery_details['service_fee']);
        }
        ?>
        <?php echo "$ ".round($total, 2); ?>
        </td>
       </tr>
        
    </table>
<?php }else{ ?>
	<table width="100%" border="0" cellspacing="1" class="restro2_table">
  <tr>
    <td height="20" colspan="3" align="center" class="restro2_table_bg"><h2>Qty</h2></td>
    <td width="53%" height="20" align="center" class="restro2_table_bg"><h2>Item</h2></td>
    <td width="24%" height="20" align="center" class="restro2_table_bg"><h2>Price</h2></td>
  </tr>
  <?php 
  //echo $_SESSION['cart_rest_id'];
  
  $sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE restaurant_id = '".$ses_rest_id."' AND group_id = '".$_SESSION['group_order_id'.$ses_rest_id]."' AND group_order_details_id = '".$_SESSION['group_order_details_id'.$ses_rest_id]."'");
   $amount1 = 0;
  while($array_select = mysql_fetch_array($sql_select)){ ?>
  <tr>
    <td height="30" colspan="3" align="center"><?php echo $array_select['quantity']; ?></td>
    <td height="30" align="center"><?php $sql_item_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select['menu_item_id']."'"));
	echo $sql_item_name['menu_name']; ?>
    
    <?php if(!empty($array_select['additional_instructions']) || !empty($array_select['special_ins'])){ ?>
    <div id="show_det<?php echo $array_select['id']; ?>" style="margin-top:-22px;">
    <br><a href="javascript:void(0);" onClick="return show_details('<?php echo $array_select['id']; ?>')" style="color:#928A95; text-decoration:underline;" >Show Details</a>
    </div>
	<?php }?>
    
    <div id="splins_div<?php echo $array_select['id']; ?>" style="display:none; color:#B89172; white-space: -moz-pre-wrap;  white-space: -hp-pre-wrap;
white-space: -o-pre-wrap;  white-space: -pre-wrap; white-space: pre-wrap; white-space: pre-line; word-wrap: break-word; width:150px;">
    <?php  $arr = (explode(",",$array_select['additional_instructions']));
	  $sep = ''; 
	  foreach($arr as $val){
	  $sql_add_instructions = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$val."'"));
	  echo $sep.htmlspecialchars_decode(htmlspecialchars_decode($sql_add_instructions['title']));
	  $sep = ',';
	  }
	  if($array_select['special_ins']!=''){
		  if(!empty($array_select['additional_instructions'])){
		   echo ","; }
		   echo htmlspecialchars_decode(htmlspecialchars_decode($array_select['special_ins']));
	  }
	  ?>
    </div>
    
    <?php if(!empty($array_select['additional_instructions']) || !empty($array_select['special_ins'])){ ?>
    <div id="hide_det<?php echo $array_select['id']; ?>" style="display:none; margin-top:-20px;">
    <br><a href="javascript:void(0);" onClick="return hide_details('<?php echo $array_select['id']; ?>')" style="color:#928A95; text-decoration:underline;" >Hide Details</a>
    </div>
    <?php } ?>
    </td>
    <td height="30" align="center">$ <?php echo ($array_select['price']*$array_select['quantity']); ?></td>
  </tr>
  <?php
  $amount1 = $amount1 + ($array_select['price']*$array_select['quantity']); }
  
  $amount = ($amount1 - $_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] - $_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]);
  ?>
  <tr>
    <td height="10" colspan="3" align="center">&nbsp;</td>
    <td height="10" align="right">Tax</td>
    <td height="10" align="center">
	<?php $tax = ($sql_delivery_details['tax']/100 * $amount1);
	echo "$ ".round($tax, 2); ?>
    </td>
   </tr>
  <?php if($_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]!=''){?>
   <tr>
    <td height="10" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
    <td height="10" align="right" style="padding-top:20px;">Coupon Discount</td>
    <td height="10" align="center" style="padding-top:20px;">$ <?php echo $_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]; ?></td>
   </tr>
   <?php } ?>
   
   <?php if($_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]!=''){?>
   <tr>
    <td height="10" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
    <td height="10" align="right" style="padding-top:20px;">Reward Point Discount</td>
    <td height="10" align="center" style="padding-top:20px;">$ <?php echo $_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]; ?></td>
   </tr>
   <?php } ?>
   <?php if($_REQUEST['type'] == 'del'){?>
   <tr>
    <td height="10" colspan="3" align="center">&nbsp;</td>
    <td height="10" align="right">Delivery Charge</td>
    <td height="10" align="center">
    <?php echo "$ ".$_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]; ?>
    </td>
   </tr>
   <?php  } ?>
   
   <?php if($sql_delivery_details['service_fee']!='' && $sql_delivery_details['service_fee']!=0){ ?>
   <tr>
    <td height="10" colspan="3" align="center">&nbsp;</td>
    <td height="10" align="right">Service Fee</td>
    <td height="10" align="center">
	<?php 
	$service_fee =  $sql_delivery_details['service_fee'];
	echo $service_fee; ?>
    </td>
   </tr>
   <?php } ?>   
   <tr>
    <td height="10" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
    <td height="10" align="right" style="padding-top:20px;">Subtotal</td>
    <td height="10" align="center" style="padding-top:20px;">$ <?php echo $amount; ?></td>
   </tr>
   <tr>
    <td height="10" colspan="3" align="center">&nbsp;</td>
    <td height="10" align="right">Total</td>
    <td height="10" align="center">
	<?php if($_REQUEST['type'] == 'del' && $_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]]!=''){
		$total = ($amount + $tax + $_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] + $sql_delivery_details['service_fee']);
	}
	else {
		$total = ($amount + $tax + $sql_delivery_details['service_fee']);
	}
	?>
    <?php echo "$ ".round($total, 2); ?>
    </td>
   </tr>
    
</table>
<?php } ?>

<h3 style="text-align:center;">
<?php /*?><a href="restaurant.php?id=<?php echo $_SESSION['cart_rest_id']; ?>&order=cancel" class="check_order_button" style="text-decoration:none;"><?php */?>
<!--<a href="javascript:void(0);" class="check_order_button" style="text-decoration:none;" onClick="history.go(-1);">-->
<a href="restaurant.php?id=<?php echo $_SESSION['cart_rest_id']; ?>" class="check_order_button" style="text-decoration:none;">
Change my Order</a></h3><div>
<div class="clear"></div>
</div>

<div class="clear"></div>

<span id="follow_unfollow"><a href="javascript:void(0);" onClick="addClassfunc();">Cart, Follow Me</a></span>
</div>
</div>

</div>

</div>
<div class="checkout_right_panel">
	<div class="checkout_section">
    <?php if(!empty($err_msg) && $err_msg!=''){ ?>
    <div><p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#DC3646; font-weight:bold; text-align:center; border:1px solid; height:20px; padding-top:5px;"><?php echo $err_msg; ?></p></div>
    <?php } ?>
    	<h2>Contact Info</h2>
        <form id="frm" name="frm" method="post" action="" onSubmit="return submit_frm();">
        <input type="hidden" name="buttonclick" value="" id="buttonclick">
        <input type="hidden" name="today" id="today" value="<?php echo date('m/y'); ?>">
        <input type="hidden" name="length" maxlength='3' value='12' onKeyPress="return goodchars(event,'1234567890');"> 
        <input type="hidden" name="unit" value="months" />
        <input type="hidden" name="totalOccurrences" value='9999'>
        <input type="hidden" name="trialOccurrences" value='0'>
        <input type="hidden" name="subs_typ" value='new_subs'>
        <input type="hidden" name="trialAmount" value="0.00" />
        <input type="hidden" name="startDate"  value="<?php echo date('Y-m-d');?>" maxlength="10" onKeyPress="return goodchars(event,'1234567890-');">
        <div class="check_form_section">
        
        	<div class="check_form_box">
        
                <div class="check_form">
                    <p>First Name* </p>
                    <input name="first_name" type="text" id="first_name" value="<?php echo $sql_customer_details['firstname']; ?>" />
                </div>
                <div class="check_form">
                    <p>Last Name*</p>
                    <input name="last_name" type="text" id="last_name"  value="<?php echo $sql_customer_details['lastname']; ?>" />
                </div>
                <div class="check_form">
                    <p>Email*</p>
                    <input name="email" type="text" id="email"  value="<?php echo $sql_customer_details['email']; ?>" />
                </div>
                <div class="check_form">
                    <p>Phone*</p>
                    <input name="phone" type="text" id="phone"  onKeyPress="return goodchars(event,'1234567890-+');"  value="<?php echo $sql_customer_details['phone']; ?>" />
                </div>
                
                <div class="clear"></div>
            
            </div>
            
            <h2>Shipping Address</h2>
            
            <div class="check_form_box">
                            
                <div class="check_form">
                    <p>Address*</p>
                    <input name="address" type="text" id="address"  value="<?php echo $sql_customer_details['address']; ?>" />
                </div>
                <div class="check_form">
                    <p>City*</p>
                    <input name="city" type="text" id="city" value="<?php echo $sql_customer_details['city']; ?>" />
                </div>
                <div class="check_form">
                    <p>State*</p>
                    <input name="state" type="text" id="state" value="<?php echo $sql_customer_details['state']; ?>" />
                </div>
                <div class="check_form">
                    <p>Zipcode*</p>
                    <input name="zipcode" type="text" id="zipcode"  onKeyPress="return goodchars(event,'1234567890');" value="<?php echo $sql_customer_details['zip']; ?>" />
                </div>
                
                <div class="clear"></div>
            
            </div>
            
            <h2>Billing Address <input type="checkbox" name="check1" id="check1" value="" onClick="return check_shipping_billing();"></h2> (Click here if billing address is same as shipping address)
            
            <div class="check_form_box">
                            
                <div class="check_form">
                    <p>Address*</p>
                    <input name="billing_address" type="text" id="billing_address"  value="<?php echo $sql_customer_details['billing_address']; ?>" />
                </div>
                <div class="check_form">
                    <p>City*</p>
                    <input name="billing_city" type="text" id="billing_city" value="<?php echo $sql_customer_details['billing_city']; ?>" />
                </div>
                <div class="check_form">
                    <p>State*</p>
                    <input name="billing_state" type="text" id="billing_state" value="<?php echo $sql_customer_details['billing_state']; ?>" />
                </div>
                <div class="check_form">
                    <p>Zipcode*</p>
                    <input name="billing_zip" type="text" id="billing_zip"  onKeyPress="return goodchars(event,'1234567890');" value="<?php echo $sql_customer_details['billing_zip']; ?>" />
                </div>
                
                <div class="clear"></div>
            
            </div>
            
            <h2>Order Type</h2>
            
            <div class="check_form_box">
                            
                 <div style="float:left; margin:10px 10px 0 0; color:rgb(104, 104, 104); font:normal 12px "calibri";">
                 <?php if($_REQUEST['type'] == 'pickup'){
                     $or_typ = 'Pick Up';
                 }else{
                     $or_typ = 'Delivery';
                 }?>
                    <span><?php echo $or_typ; ?></span>
                </div>
                <div class="clear"></div>
            
            </div>
            
            <h2>Payment Mode</h2>
            
            <div class="check_form_box">
                            
                 <div style="float:left; margin:10px 10px 0 0; color:rgb(104, 104, 104); font:normal 12px "calibri";">
                    <input type="radio" name="payment_mode" id="credit_card" value="credit_card" style="width:15px;" onClick="return pay_mode(this.value);"><span>Credit Card</span>
                </div>
                
                 <div style="margin:10px 10px 0 0; color:rgb(104, 104, 104); font:normal 12px "calibri";">
                    <input type="radio" name="payment_mode" id="cash" value="cash" style="width:15px;" checked="checked" onClick="return pay_mode(this.value);"><span>Cash</span>
                </div>
                
                <div class="clear"></div>
            
            </div>
            
            <div id="credit_div" style="display:none;">
            <h2>Payment Details</h2>
            <div class="check_form">
            	<p>Card Type*</p>
                <select name="card_type" id="card_type">
                    <option value="visa">Visa</option>
                    <option value="master card">Master Card</option>
                    <option value="american express">American Express</option>
                    <option value="discover">Discover</option>
                </select>
            </div>
            <div class="check_form">
            	<p>Card No.*</p>
                <input name="card_no" type="text" id="card_no" maxlength="16" />
            </div>
            <div class="check_form">
            	<p>CVV No.*</p>
                <input name="cvv_no" type="text" id="cvv_no" maxlength="3" />
            </div>
            <div class="check_form">
            	<p>Expiry Date*</p>
                <!--<input name="expiry_date" type="text" id="expiry_date" />-->
                <?php $year = date('Y'); ?>
                <select name="exp_month" id="exp_month" style="width:137px;">
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
                <select name="exp_year" id="exp_year" style="width:137px;">
                	<option value="">Select</option>
                    <?php for($i=$year; $i<=($year+6); $i++){ 
					$yr = substr($i, -2); ?>
                    <option value="<?php echo $yr; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            
        <fieldset class="special_instructions">
        <?php /*?><legend>Tip</legend><?php */?>
        <div class="check_form">
        <p>Tip ($)</p>
        <input name="tip" type="text" id="tip"  onKeyPress="return goodchars(event,'1234567890.');" onKeyUp="return cal_total(this.value)" />
        <div class="clear"></div>
        </div>
        </fieldset>
        </div>
       </div>
           
        <fieldset class="special_instructions">
        <legend>Special Instructions</legend>
        <div><input name="save_earth" type="checkbox" value="1" id="save_earth" /><span>Spare me the napkins and plasticware . I'm trying to save the earth.</span>
        <div class="clear"></div>
        </div>
        <div class="special_delivery_info">
        <p>Delivery Instructions<span>e.g. Buzzer is broken, call 555-1234</span></p>
        <textarea name="delivery_info" cols="" rows="" id="delivery_info" ></textarea></div>
        </fieldset>
        
        <?php 
		if($_SESSION['group_order_details_id'.$ses_rest_id] != "") {
			$del_chrg = $_SESSION['del_charge'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]];
		}else{
			$del_chrg = $_SESSION['del_charge'.$ses_rest_id];
		}
		
		if($_REQUEST['type'] == 'del'){ $total_amount = ($amount + $del_chrg); } else { $total_amount = $amount; }
		$tax1 = ($sql_delivery_details['tax']/100 * $amount );
		$tax = round($tax1, 2);
		 ?>
        <fieldset class="special_instructions">
        <legend>Total $<input type="text" name="amount" id="amount" value="<?php echo ($total_amount + $tax + $service_fee); ?>" style="border:none; float:right; color:#FA8730; font: bold 23px calibri; margin: 0 407px 0 0;" readonly></legend>
        <input type="hidden" name="amount1" id="amount1" value="<?php echo $total_amount; ?>">
        <input type="hidden" name="tax" id="tax" value="<?php echo $tax; ?>">
        <input type="hidden" name="service_fee" id="service_fee" value="<?php echo $service_fee; ?>">
        <input type="hidden" name="total_amt" id="total_amt" value="<?php echo ($total_amount + $tax + $service_fee); ?>">
        <input type="hidden" name="amount2" id="amount2" value="<?php echo $amount; ?>" >
        <?php $commission1 = ($sql_delivery_details['commission']/100 * $amount );
		 $commission = round($commission1, 2);?>
        <input type="hidden" name="commission" id="commission" value="<?php echo $commission; ?>">
        <p>By ordering below, I acknowledge i am bound by the <a href="terms.php" style="color:#686868;">terms and conditions</a> and <a href="privacy.php" style="color:#686868;">privacy agreement</a> of Food and Menu</p>
        <input name="place_order" type="submit" value="Place My Order" id="place_order" class="check_order_button" onClick="return check_it();" />
        </fieldset>
        </form>
    </div>
</div>
<div class="clear"></div>
</div>

<div class="clear"></div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<script type="text/javascript">
function scroll_cart()
{
	var $j = jQuery.noConflict();
	var element = $j('.navigation_single_cart_class'),
			originalY = element.offset().top;
	// Space between element and top of screen (when scrolling)
	var topMargin = 180;
	// Should probably be set in CSS; but here just for emphasis
	element.css('position', 'relative');
	$j(window).on('scroll', function (event) {
		var scrollTop = $j(window).scrollTop();
		element.stop(false, false).animate({
			top: scrollTop < originalY
					? 0
					: scrollTop - originalY + topMargin
		}, 300);
	});
}
function addClassfunc()
{
	var $j = jQuery.noConflict();
	//$j(window).on('scroll');
	$j("#navigation_single_cart").addClass('navigation_single_cart_class');
	$j("#follow_unfollow").html('<a href="javascript:void(0);" onClick="removeClassfunc();" style="margin-left:-60px;">Unfollow Me</a>');
	scroll_cart();
}
function removeClassfunc()
{
	var $j = jQuery.noConflict();
	var offset1 = $j('.navigation_single_cart_class').offset();

	//var x_pos = offset1.left;
	var y_pos = offset1.top;
	
	$j("#navigation_single_cart").removeClass('navigation_single_cart_class');
	$j("#follow_unfollow").html('<a href="javascript:void(0);" onClick="addClassfunc();"  style="margin-left:-450px;">Cart, Follow Me</a>');
	$j("#navigation_single_cart").css({'position':'initial'});
	//$j("#navigation_single_cart").css({'top':'900px', 'position':'initial'});
	//$j("#navigation_single_cart").css({'left': x_pos, 'top': y_pos});
	//$j(document).unbind('scroll',scroll_cart);
	//$j(window).off('scroll');
}
</script>
            
<script type="text/javascript">
var $j = jQuery.noConflict();
$j(window).load(function () {
	addClassfunc();
});
</script>

<?php include("includes/footer_new.php");?>