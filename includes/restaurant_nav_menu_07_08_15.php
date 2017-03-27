<?php 
//include ("../admin/lib/conn.php");

$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$page= $parts[count($parts) - 1]; 
//print_r($_SESSION);

$sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant_admin_panel_id']."'"));
?>

<div class="restaurant_cont_top">
<h1>Restaurant Admin Panel<!-- <span style="float:right"><a href="restowner_onlinechat.php">Chat</a></span>--></h1>
</div>
<!--<div><a href="restowner_onlinechat.php"><img class="chat_header_new" src="images/chat.png" alt="#" height="97"  width="104" /></a></div>-->
<div class="restaurant_nav" style="height:100px;">
<div style="width:120px; float:left;">
<?php if($sql_restaurant['restaurant_image']!=''){?>
<img src="<?php echo "uploaded_images/".$sql_restaurant['restaurant_image']; ?>" height="100" width="100" style="margin-left:10px;">
<?php }else { ?>
<img src="thumb_images/no_image.png" height="100" width="100" style="margin-left:10px;">
<?php } ?>
</div>

<div style="width:835px; float:right;">
<h2><?php echo stripslashes($sql_restaurant['restaurant_name']); ?></h2>
<p style="padding:0px; margin-right:5px;">Address : </p>
<p style="padding:0px; color:#000000;"><?php echo $sql_restaurant['restaurant_address']; ?></p><br>
<p style="padding:0px; color:#000000;"><?php echo $sql_restaurant['restaurant_city'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_state'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_zipcode'];?>
</div>
</div>

<div class="restaurant_nav">
<ul>
<li><a href="restaurant_live_orders.php" <?php if($page == 'restaurant_live_orders.php'){?> class="active7" <?php } ?>>Live Orders</a></li>
<!--<li><a href="menu_setup.php" <?php if($page == 'menu_setup.php' || $page == 'edit_restaurant_menu_setup.php'){?> class="active7" <?php } ?>>Menu Setup</a></li>-->
<li><a href="my_settings_basic_info.php" <?php if($page == 'my_settings_basic_info.php' || $page == 'my_settings_additional_info.php' || $page == 'my_settings_multimedia.php' || $page == 'my_settings_edit_image1.php' || $page == 'my_settings_edit_video1.php'  || $page == 'my_settings_special_offer.php' || $page == 'my_settings_edit_daily_coupon.php' || $page == 'my_settings_edit_daily_deals.php'){?> class="active7" <?php } ?>>My Settings</a></li>
<li><a href="my_reviews.php" <?php if($page == 'my_reviews.php' || $page == 'reply_reviews.php'){?> class="active7" <?php } ?>>My Reviews</a></li>
<li><a href="billing.php" <?php if($page == 'billing.php' || $page == 'balance.php'){?> class="active7" <?php } ?>>Billing</a></li>
<li><a href="my_reports.php" <?php if($page == 'my_reports.php'){?> class="active7" <?php } ?>>My Reports</a></li>
<li><a href="manage_gift_certificate.php" <?php if($page == 'manage_gift_certificate.php'){?> class="active7" <?php } ?>>Manage Gift Certificate</a></li>
<li><a href="manage_online_reservation.php" <?php if($page == 'manage_online_reservation.php'){?> class="active7" <?php } ?>>Online Reservation</a></li>
</ul>
</div>