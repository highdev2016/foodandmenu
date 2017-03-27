<?php session_start();
include('admin/lib/conn.php');
//print_r($_SESSION);
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$page= $parts[count($parts) - 1]; 
?>   
<div class="menu_section">

<div class="menu_container">

<div class="left_menu">
<ul>

<li><a href="add_restaurant_admin.php" <?php if($page=="add_restaurant_admin.php"){?> class="active" <?php }?>>Add a restaurant</a></li>
</ul>

</div>
<div class="right_menu">
<div style="width:85px; float:right; text-align:center;" class="login_section">
<ul style="padding-left:25px;">
<li><a href="logout_restaurant.php">Logout</a></li>
 </ul>
</div>

</div>



<div class="clear"></div>
</div>

</div>

<div class="clear"></div>