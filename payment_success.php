<?php
session_start();
if($_SESSION['customer_id']==''){
	header("location:login.php");
}
include("includes/rest_header.php");
include("admin/lib/conn.php");
include("includes/functions.php");
?>

<body onLoad="init();">

<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php"); ?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body payment_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top" style="min-height:350px;">
<h1>Your Order Has Been Processed!</h1>

<p class="success_paymnt" id="first_scss_paymnt">Your order has been successfully processed!</p>
<p class="success_paymnt">To view your order history <a href="customer_order_history.php">Click here.</a></p>
<p class="success_paymnt">To view and print your current order <a href="current_order_details.php">Click here.</a></p>
<p class="success_paymnt"><b>Thank you for ordering  online!</b></p>
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

<?php include("includes/footer_new.php");?>