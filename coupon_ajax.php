<?php
session_start();
include ("admin/lib/conn.php");

$coupon_code 	= $_REQUEST['coupon_code'];
$reward_discount = $_REQUEST['reward_discount'];
$reward_discount_ajax = $_REQUEST['reward_discount_ajax'];
$amount		 = $_REQUEST['amount'];
$resturant_id   = $_REQUEST['res_id'];
$curr_date 	  = date('Y-m-d');

$ses_rest_id    = $_SESSION['cart_rest_id'];

	$sql = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$coupon_code."' AND restaurant_id = '".$resturant_id."' AND coupon_status = '1' AND apply_coupon > 0"));
	
	
	if(!empty($sql)){
		if($sql['end_date'] < $curr_date){
			$_SESSION['coupon_code'.$ses_rest_id] = '';
			$_SESSION['coupon_discount'.$ses_rest_id] = '';
			echo 'Expired';
		}else{
			if($sql['online_redeem'] == 0){
				echo 'Offline';				
			}elseif($sql['minimum_order_amount']>$amount){
				$_SESSION['coupon_code'.$ses_rest_id] = '';
				$_SESSION['coupon_discount'.$ses_rest_id] = '';
				echo 'Minimum';
			}else{
				
				if($sql['discount'] != '0.00')
				{
					$_SESSION['coupon_code'.$ses_rest_id] = $_REQUEST['coupon_code'];
					$pre_discounted_price = ($amount * $sql['discount'])/100;
				
					$discounted_price = ($amount - $pre_discounted_price - $reward_discount - $reward_discount_ajax);
					
					$_SESSION['coupon_discount'.$ses_rest_id] = number_format($pre_discounted_price,2);
				
					echo number_format($discounted_price,2).'^'.number_format($pre_discounted_price,2);
					
				}
				else
				{
					
					$_SESSION['coupon_code'.$ses_rest_id] = $_REQUEST['coupon_code'];
					$pre_discounted_price = $sql['coupon_price'];
				
					$discounted_price = ($amount - $sql['coupon_price'] - $reward_discount - $reward_discount_ajax);
					
					$_SESSION['coupon_discount'.$ses_rest_id] = number_format($pre_discounted_price,2);
				
					echo number_format($discounted_price,2).'^'.number_format($pre_discounted_price,2);
					
				}
				
			}	
			
		}
	}else{
		$_SESSION['coupon_code'.$ses_rest_id] = '';
		$_SESSION['coupon_discount'.$ses_rest_id] = '';
		echo "Invalid";
	}
	
	
		
	
?>