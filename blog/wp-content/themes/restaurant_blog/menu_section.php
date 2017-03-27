<?php //session_start();
include('admin/lib/conn.php');
//print_r($_SESSION);
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$page= $parts[count($parts) - 1]; 
?>   
<div class="menu_section">

<div class="menu_container">

<div class="left_menu">
<?php if($_SERVER['PHP_SELF']=='/add_restaurant.php' || $_SERVER['PHP_SELF']=='/additional.php' || $_SERVER['PHP_SELF']=='/restaurant_menu.php' || $_SERVER['PHP_SELF']=='/multimedia.php' || $_SERVER['PHP_SELF']=='/confirmation.php' || $_SERVER['PHP_SELF']=='/special_offer.php' || $_SERVER['PHP_SELF']=='/view_all_restaurant.php' || $_SERVER['PHP_SELF']=='/view_all_restaurant.php' || $_SERVER['PHP_SELF']=='/edit_restaurant.php' || $_SERVER['PHP_SELF']=='/edit_additional.php' || $_SERVER['PHP_SELF']=='/edit_restaurant_menu.php' || $_SERVER['PHP_SELF']=='/edit_multimedia.php' || $_SERVER['PHP_SELF']=='/edit_confirmation.php' || $_SERVER['PHP_SELF']=='/edit_special_offer.php' || $_SERVER['PHP_SELF']=='/edit_restaurant_menu_item.php' || $_SERVER['PHP_SELF']=='/edit_daily_deals.php' || $_SERVER['PHP_SELF']=='/add_admin_restaurant.php'){ ?>
<?php
if($_SERVER['PHP_SELF']=='/view_all_restaurant.php' || $_SERVER['PHP_SELF']=='/view_all_restaurant.php' || $_SERVER['PHP_SELF']=='/edit_restaurant.php' || $_SERVER['PHP_SELF']=='/edit_additional.php' || $_SERVER['PHP_SELF']=='/edit_restaurant_menu.php' || $_SERVER['PHP_SELF']=='/edit_multimedia.php' || $_SERVER['PHP_SELF']=='/edit_confirmation.php' || $_SERVER['PHP_SELF']=='/edit_special_offer.php' || $_SERVER['PHP_SELF']=='/edit_restaurant_menu_item.php' || $_SERVER['PHP_SELF']=='/edit_daily_deals.php')
{
	?>
   <ul>
   <?php
   if($_SESSION['admin_id']=="")
   {
   ?>
<li><a href="view_all_restaurant.php" <?php if($page=="view_all_restaurant.php"){?> class="active" <?php }?>>View All restaurants</a></li>
<?php
   }
   ?>
<?php
if($_SESSION['restaurant_user_type']=='admin_restaurant')
{
	
?>
<li><a href="add_admin_restaurant.php" <?php if($page=="add_admin_restaurant.php"){?> class="active" <?php }?>>add a restaurant</a></li>
<?php
}

else{
	 if($_SESSION['admin_id']=="")
   {
?>
<li><a href="add_restaurant.php" <?php if($page=="add_restaurant.php"){?> class="active" <?php }?>>add a restaurant</a></li>
<?php
   }
}
?>
</ul> 
    <?php
}
else{
	if($_SESSION['restaurant_user_type']=='admin_restaurant')
	{
		
	?><ul>	<li><a href="view_all_restaurant.php" <?php if($page=="view_all_restaurant.php"){?> class="active" <?php }?>>View All restaurants</a></li>
<li><a href="add_admin_restaurant.php" <?php if($page=="add_admin_restaurant.php"){?> class="active" <?php }?>>add a restaurant</a></li></ul>

<?	}
}
if($_SESSION['admin_id']!="")
{
	?>
	<ul>	<li><a href="view_all_restaurant.php" <?php if($page=="view_all_restaurant.php"){?> class="active" <?php }?>>View All restaurants</a></li>
<li><a href="add_admin_restaurant.php" <?php if($page=="add_admin_restaurant.php"){?> class="active" <?php }?>>add a restaurant</a></li>
<li><a href="admin/index.php" >Dashboard</a></li>
</ul>
<?
}
}
else{
?>
<ul>
<li><a href="home.php" <?php if($page=="home.php"){?> class="active" <?php }?>>Home</a></li>
<li><a href="contact.php" <?php if($page=="contact.php"){?> class="active" <?php }?>>Contact Us</a></li>
<li><a href="vendor.php" <?php if($page=="vendor.php"){?> class="active" <?php }?>>vendors</a></li>
</ul>
<?php
}
?>
</div>


<?php if(isset($_COOKIE['customer_id'])){	
$sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
$row_name = mysql_fetch_array($sql_customer_name);?>
<div class="right_menu" style="width:auto;">
<div class="login_section" style="width:auto;">
<ul style="padding-left:15px; padding-right:15px;">
<li><span style="cart_text"><?php echo get_qty_total() ; ?></span>
<a href="cart.php" style="float:left;"><img src="images/cart.png" width="20" height="20" style="margin-top:5px; padding-right:5px;"/></a>
</li>
<li>Welcome , <?php echo $row_name['firstname']; ?></li>   
<li>|</li> 
<li><a href="edit_profile.php">Edit profile</a></li>   
<li>|</li>    
<li><a href="logout.php">Logout</a></li>
<li><?php print_r($_SESSION['cart']); ?></li>
</ul>
</div>
<?php }
elseif(isset($_SESSION['customer_id'])){
$sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
$row_name = mysql_fetch_array($sql_customer_name);?>
<div class="right_menu" style="width:auto;">
<div class="login_section" style="width:auto;">

<ul style="padding-left:15px; padding-right:15px;">
<li><span style="cart_text"><?php echo get_qty_total() ; ?></span>
<a href="cart.php" style="float:left;"><img src="images/cart.png" width="20" height="20"  style="margin-top:5px; padding-right:5px;"/></a>
</li>
<li>Welcome , <?php echo $row_name['firstname']; ?></li>   
<li>|</li>  
<li><a href="edit_profile.php">Edit profile</a></li>   
<li>|</li>  
<li><a href="logout.php">Logout</a></li>

</ul>
</div>
<?php 
}
 else { ?>
<div class="right_menu">

<?php if($_SERVER['PHP_SELF']=='/add_restaurant.php' || $_SERVER['PHP_SELF']=='/additional.php' || $_SERVER['PHP_SELF']=='/restaurant_menu.php' || $_SERVER['PHP_SELF']=='/multimedia.php' || $_SERVER['PHP_SELF']=='/confirmation.php' || $_SERVER['PHP_SELF']=='/special_offer.php'|| $_SERVER['PHP_SELF']=='/view_all_restaurant.php' || $_SERVER['PHP_SELF']=='/edit_restaurant.php' || $_SERVER['PHP_SELF']=='/edit_additional.php' || $_SERVER['PHP_SELF']=='/edit_restaurant_menu.php' || $_SERVER['PHP_SELF']=='/edit_multimedia.php' || $_SERVER['PHP_SELF']=='/edit_confirmation.php' || $_SERVER['PHP_SELF']=='/edit_special_offer.php' || $_SERVER['PHP_SELF']=='/edit_daily_deals.php' || $_SERVER['PHP_SELF']=='/add_admin_restaurant.php'){?>
<?
if($_SESSION['restaurant_user_email']!="")
	{
		?>
<div class="login_section" style="width:290px; float:right; text-align:center;">
<?php
	}
	else{
	?>
 <div class="login_section" style="width:85px; float:right; text-align:center;">
    <?php
	}
	?>
<ul style="padding-left:25px;">
<?php if($_SESSION['admin_id']=="")
{
	if($_SESSION['restaurant_user_email']!="")
	{
?>
  <li>Welcome  <?php echo $_SESSION['restaurant_user_email']; ?></li>   
  <li>|</li>  
<?php
	}
	?>
<li><a href="logout_restaurant.php">Logout</a></li>
 <?php
}
?>
</ul>
</div>
<?php
}
else{
	?>
<div class="login_section">
<ul>
<li><a href="login.php">Login</a></li>   
<li>|</li> 
<li><a href="signup.php">Sign up</a></li>
</ul>
</div>
<?php
}
?>

<?php } ?>
</div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>