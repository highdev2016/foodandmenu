<?php 
//include ("../admin/lib/conn.php");

$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$page= $parts[count($parts) - 1]; 
//print_r($_SESSION);

$sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant_admin_panel_id']."'"));
?>

<div class="restaurant_cont_top">
<h1>Administration Panel<!-- <span style="float:right"><a href="restowner_onlinechat.php">Chat</a></span>--></h1>
</div>
<!--<div><a href="restowner_onlinechat.php"><img class="chat_header_new" src="images/chat.png" alt="#" height="97"  width="104" /></a></div>-->
<?php /*?><div class="restaurant_nav" style="height:100px;">
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
</div><?php */?>

<div class="restaurant_nav">
<ul>
<li><a href="admin_home.php" <?php if($page == 'admin_home.php'){?> class="active7" <?php } ?>>Live Orders</a></li>
<li><a href="admin_gift_certificate.php" <?php if($page == 'admin_gift_certificate.php'){?> class="active7" <?php } ?>>Gift certificates</a></li>
<li><a href="admin_online_reservation.php" <?php if($page == 'admin_online_reservation.php'){?> class="active7" <?php } ?>>Online Reservation</a></li>

</ul>
</div>