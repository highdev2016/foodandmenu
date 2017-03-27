<div class="header_section">

<div class="header_top">

<div class="header_container">

<div class="logo_left"><img src="images/logo1.png" /></div>

<div class="clear"></div>
</div>

<section class="search_address_section address_admin_sec">

                    <div class="container">
					
                                        
                                        	<h2><a href="search_result.php">BACK TO RESTAURANT LIST</a></h2>
                    
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
<div class="menu_section">

<div class="menu_container">

<div class="left_menu">

</div>


<?php if(isset($_SESSION['restaurant_admin_panel_id'])){
$sql = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin_panel WHERE restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."'"));
?>
<div class="right_menu" style="width:auto;">
<div class="login_section" style="width:auto;">

<ul style="padding-left:15px; padding-right:15px;">
<li>Welcome , <?php echo $sql['email_id']; ?></li>  
<li>|</li> 
<li><a href="change_res_admin_pasword.php">Change Password</a></li>
<li>|</li>  
<li><a href="restaurant_admin_panel_logout.php">Logout</a></li>

</ul>
</div>
<?php } ?>
</div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>