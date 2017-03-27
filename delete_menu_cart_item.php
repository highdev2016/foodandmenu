<?php
session_start();
include("admin/lib/conn.php");
$session_id = session_id();
$ses_rest_id = $_SESSION['cart_rest_id'];

$sql_delete_menu_item_cart = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE id = '".$_REQUEST['del_id']."'");

if($sql_delete_menu_item_cart){
	$sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_REQUEST['id']."'");
		
	$num_rows = mysql_num_rows($sql_select_cart_items);
	
	$cart_amt = 0;
	while($array_cart_items = mysql_fetch_array($sql_select_cart_items)){
		$cart_amt = $cart_amt+($array_cart_items['price']*$array_cart_items['quantity']);
	}
				
	if($_SESSION['coupon_code'.$ses_rest_id]!=''){
		if($num_rows > 0)
		{
			$sql_sel_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$_SESSION['coupon_code'.$ses_rest_id]."' AND restaurant_id = '".$_REQUEST['id']."'"));
			if($sql_sel_coupon['minimum_order_amount'] < $cart_amt)
			{
				if($sql_sel_coupon['discount'] != 0.00)
				{
					$_SESSION['coupon_discount'.$ses_rest_id] = number_format(($sql_sel_coupon['discount']*$cart_amt)/100,2);
				}
				else
				{
					$_SESSION['coupon_discount'.$ses_rest_id] = number_format($sql_sel_coupon['coupon_price'],2);
				}
			}
			else
			{
				$_SESSION['coupon_discount'.$ses_rest_id] = '';
				$_SESSION['coupon_code'.$ses_rest_id] = '';
				$err_coupon_discard = 1;
				header("location:restaurant.php?id=".$_REQUEST['id']."&err_msg=".$err_coupon_discard."");
			}
		}
		else
		{
			$_SESSION['coupon_discount'.$ses_rest_id] = '';
			$_SESSION['coupon_code'.$ses_rest_id] = '';
		}
	}
	
	if($_SESSION['reward_point'.$ses_rest_id]!=''){
		if($num_rows > 0)
		{
			$_SESSION['reward_point'.$ses_rest_id] = ($cart_amt * $_SESSION['user_reward_point'.$ses_rest_id])/100;
		}
	}else{
		$_SESSION['reward_point'.$ses_rest_id] = '';
		$_SESSION['user_reward_point'.$ses_rest_id] = '';
	}
	
	header("location:restaurant.php?id=".$_REQUEST['id']."&error_msg=5");
}

?>