<?php
session_start();
$ses_rest_id = $_SESSION['cart_rest_id'];

$_SESSION['coupon_code'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
$_SESSION['coupon_discount'.$ses_rest_id.'_'.$_SESSION['group_order_details_id'.$ses_rest_id]] = '';

header("location:restaurant.php?id=".$_REQUEST['id']."");
?>