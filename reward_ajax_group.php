<?php
session_start();
include ("admin/lib/conn.php");

$reward_point   = $_REQUEST['reward_point'];
$amount		 = $_REQUEST['amount'];
$resturant_id   = $_REQUEST['res_id'];

$ses_rest_id    = $_SESSION['cart_rest_id'];

$_SESSION['user_reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = $reward_point;

if($reward_point != '0.00')
{
	$pre_discounted_price = ($amount * $reward_point)/100;

	$discounted_price = ($amount - $pre_discounted_price);
	
	$_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = number_format($pre_discounted_price,2);

	echo number_format($discounted_price,2).'^'.number_format($pre_discounted_price,2);
	
}
else
{
	$_SESSION['reward_point'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
	
}


		

	
	
		
	
?>