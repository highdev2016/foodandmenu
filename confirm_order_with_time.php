<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$time = $_REQUEST['val'];
$order_id = $_REQUEST['order_id'];

$sql_confirm_order = mysql_query("UPDATE restaurant_menu_order SET status = 'Confirmed' , time = '".$time."' WHERE order_id = '".$order_id."' ");

if($sql_confirm_order)
{
	
	$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));

	$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$sql_menu['customer_id']."'"));
	$customer_name = $sql_customer['firstname']." ".$sql_customer['lastname'];
	
	$sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$sql_menu['restaurant_id']."'"));
	
	$sql_bus_del_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$sql_menu['restaurant_id']."'"));
	
	/*------------------------------ Customer ----------------------------------------*/
	
	
	
	
	
	$sql_total_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));
	$date = date('m-d-Y');
	
	$date_ordered = date("m-d-Y", strtotime($sql_menu['order_date']));
	
	$subtotal = $sql_total_price['total_price'];
	
	$tax = $sql_total_price['tax'];
	
	$service_fee = $sql_total_price['service_fee'];
	
	$price_with_del_charge = $sql_total_price['price_with_del_charge'];
	
	$delivery_charge = $sql_total_price['delivery_charge'];
	
	$confirmation_code = $sql_menu['confirmation_code'];
	
	$restaurant_name = $sql_restaurant['restaurant_name'];
	
	$restaurant_address = $sql_restaurant['restaurant_address']." ".$sql_restaurant['restaurant_city']." ".$sql_restaurant['restaurant_state']." ".$sql_restaurant['restaurant_zipcode'];
	
	if($sql_total_price['type'] == 'pickup'){ 
	$order_type = 'Pick up'; }else {
	$order_type = 'Delivery'; }
	
	$sql_select1 = mysql_query("SELECT * FROM restaurant_food_order_details WHERE  order_id = '".$order_id."'");
	$ii = 1;
	while($array_select1 = mysql_fetch_array($sql_select1)) {
	$sql_select_product = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select1['menu_id']."'"));
	$price = ($array_select1['quantity']*$array_select1['menu_price']);
				
	$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> ( Item '.$ii.' ) --- <br>' .$array_select1['quantity'].' X '.$sql_select_product['menu_name'].'------------- '.$array_select1['quantity'].' X $ '.$array_select1['menu_price'].' = $'.$price.'</p>';
	
	$menu_special_ins = $array_select1['additional_instructions'];
	$ins_arr = (explode(",",$menu_special_ins));
	if(!empty($menu_special_ins)){
		$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> Special Instructions ----- </p>';
	}
	foreach($ins_arr as $insarr){
		if(!empty($insarr)){
		$sql_sp_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$insarr."'"));
		$sql_ins_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE id = '".$sql_sp_name['special_ins_id']."'"));
		$pr1 = ($array_select1['quantity'] * $sql_sp_name['price']);
					
		$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$sql_ins_name['special_instruction'].' ----- '.$sql_sp_name['title'].' -- ' .$array_select1['quantity']. ' X  $ '.$sql_sp_name['price'].' = $'.$pr1.'</p>';
		}
	}
	
	if($array_select1['special_ins']!=''){
		$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Additional Instructions -- '.$array_select1['special_ins'].'</p>';
	}
		$menu_name.= '<hr>';
	$ii++;
	}
	
	
	if($order_type == 'Delivery'){
		$delivery= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Delivery Charge :'.number_format($delivery_charge,2).'</p>';
	}
	
	if($sql_total_price['special_delivery_info']!=''){
		$special_delivery_info= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Special Instructions : '.$sql_total_price['special_delivery_info'].'</p>';
	}
	if($sql_total_price['tip']!='' && $sql_total_price['tip']!=0.00){
		$tip= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Tip :$ '.$sql_total_price['tip'].'</p>';
	}
	
	$coupon_code = $sql_menu['coupon_code'];
	$coupon_discount = $sql_menu['coupon_discount'];
	
	/*if($coupon_code){
		$coupon_code = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Coupon Code : '.$sql_menu['coupon_code'].'</p><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Discount : $ '.$coupon_discount.'</p>';
	}*/
	
	$sql_get_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$sql_menu['coupon_code']."'"));
	
	
	if($coupon_code){
		$coupon_code = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Coupon : '.$sql_get_coupon['coupon_name'].'</p><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Discount : $ '.$coupon_discount.'</p>';
	}
	
	if($service_fee!=0){
		$servicefee = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Service Fee : '.$service_fee.'</p>';
	}else{
		$servicefee = '';
	}
	 
	
	
	
	
	
	/*----------------------------------- Customer -----------------------------------*/
	
	
	$email = $sql_customer['email']; //"priya@infosolz.com""sourav.de@infosolz.com"
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 29"));	
				
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$customer_name%%',$customer_name,$cms_rep);
	$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
	$cms_rep=str_replace('%%$date%%',$date,$cms_rep);
	$cms_rep=str_replace('%%$menu_name%%',$menu_name,$cms_rep);
	$cms_rep=str_replace('%%$delivery%%',$delivery,$cms_rep);
	$cms_rep=str_replace('%%$special_delivery_info%%',$special_delivery_info,$cms_rep);
	$cms_rep=str_replace('%%$subtotal%%',$subtotal,$cms_rep);
	$cms_rep=str_replace('%%$tax%%',$tax,$cms_rep);
	$cms_rep=str_replace('%%$service_fee%%',$servicefee,$cms_rep);
	$cms_rep=str_replace('%%$tip%%',$tip,$cms_rep);
	$cms_rep=str_replace('%%$price_with_del_charge%%',$price_with_del_charge,$cms_rep);
	$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
	$cms_rep=str_replace('%%$date_ordered%%',$date_ordered,$cms_rep);
	$cms_rep=str_replace('%%$confirmation_code%%',$confirmation_code,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_address,$cms_rep);
	$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
	$cms_rep=str_replace('%%$time%%',$time." Minutes",$cms_rep);
	$cms_rep=str_replace('%%$coupon_code%%',$coupon_code,$cms_rep);
	
	$from = 'support@foodandmenu.com';
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	//$subject = stripslashes($sql_cms['subject']);
	
	$subject = 'Online '.$order_type;
	
	mail($email,$subject,$message,$headers);
	
	
	
	
	/*------------------------------ Food And Menu Admin ----------------------------------------*/
	
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 30"));
	
	$admin_email_address = $sql_cms['email_address'];
	
	$arr_email_address = explode(",",$admin_email_address);
				
	$email = "support@foodandmenu.com"; //"priya@infosolz.com"
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$customer_name%%',$customer_name,$cms_rep);
	$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
	$cms_rep=str_replace('%%$date%%',$date,$cms_rep);
	$cms_rep=str_replace('%%$menu_name%%',$menu_name,$cms_rep);
	$cms_rep=str_replace('%%$delivery%%',$delivery,$cms_rep);
	$cms_rep=str_replace('%%$special_delivery_info%%',$special_delivery_info,$cms_rep);
	$cms_rep=str_replace('%%$subtotal%%',$subtotal,$cms_rep);
	$cms_rep=str_replace('%%$tax%%',$tax,$cms_rep);
	$cms_rep=str_replace('%%$service_fee%%',$servicefee,$cms_rep);
	$cms_rep=str_replace('%%$tip%%',$tip,$cms_rep);
	$cms_rep=str_replace('%%$price_with_del_charge%%',$price_with_del_charge,$cms_rep);
	$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
	$cms_rep=str_replace('%%$date_ordered%%',$date_ordered,$cms_rep);
	$cms_rep=str_replace('%%$confirmation_code%%',$confirmation_code,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_address,$cms_rep);
	$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
	$cms_rep=str_replace('%%$time%%',$time." Minutes",$cms_rep);
	$cms_rep=str_replace('%%$coupon_code%%',$coupon_code,$cms_rep);
	
	$from = $sql_customer['email'];
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	//$subject="Order Confirmation";
	
	//$subject = stripslashes($sql_cms['subject']);
	
	$subject = 'Online '.$order_type;
	
	//mail($email,$subject,$message,$headers);
	
	/*foreach($arr_email_address as $val_email){
		mail($val_email,$subject,$message,$headers);
	}*/
	
	mail($email,$subject,$message,$headers);

	
	echo "success";
	
}


?>