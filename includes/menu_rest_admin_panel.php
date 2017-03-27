<div class="header_section">

<div class="header_top">

<div class="container">

<div class="logo_left"><img src="images/logo1.png" /></div>

<?php if(isset($_SESSION['restaurant_admin_panel_id'])){
$sql = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin_panel WHERE restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."'"));
?>
<div class="right_menu admin_right_menu">
<div class="login_section admin_login_section" style="width:auto;">

<ul style="padding-left:15px; padding-right:15px;">
<li class="admin_welcome">Welcome , <?php echo $sql['email_id']; ?></li>  

<li><a href="restaurant_admin_panel_logout.php" class="admin_regi_icon admin_log_icon">
	<span><img src="images/logout.png"></span> <span>Logout</span>
</a></li>

<li><a href="change_res_admin_pasword.php" class="admin_login_icon admin_log_icon"><span><i class="fa fa-key"></i></span> Change Password</a></li>

</ul>
</div>
<?php } ?>
</div>
<div class="clear"></div>

<div class="clear"></div>
</div>

<section class="search_address_section address_admin_sec">

                    <div class="container">
					
                    </div>

                </section>

</div>
</div>
<div class="header_back"></div>
<div class="clear"></div>


<?php session_start();
include('admin/lib/conn.php');
//print_r($_SESSION);
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$page= $parts[count($parts) - 1]; 
?>   
<!--<div class="menu_section">

<div class="menu_container">

<div class="left_menu">

</div>



</div>

</div>-->

<div class="clear"></div>