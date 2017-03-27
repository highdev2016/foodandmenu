<?php
session_start();
include ("admin/lib/conn.php");

$reward_point 	= $_REQUEST['reward_point'];
$coupon_discount = $_REQUEST['coupon_discount'];
$coupon_discount_ajax = $_REQUEST['coupon_discount_ajax'];
$amount		 = $_REQUEST['amount'];
$resturant_id   = $_REQUEST['res_id'];

$ses_rest_id    = $_SESSION['cart_rest_id'];

$_SESSION['user_reward_point'.$ses_rest_id] = $reward_point;

if($reward_point != '0.00')
{
	$pre_discounted_price = ($amount * $reward_point)/100;

	$discounted_price = ($amount - $pre_discounted_price - $coupon_discount -$coupon_discount_ajax);
	
	$_SESSION['reward_point'.$ses_rest_id] = number_format($pre_discounted_price,2);

	echo number_format($discounted_price,2).'^'.number_format($pre_discounted_price,2);
	
}
else
{
	$_SESSION['reward_point'.$ses_rest_id] = '';
	
}


		

	
	
		
	
?>