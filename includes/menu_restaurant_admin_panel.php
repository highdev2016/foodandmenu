<div class="header_section">

<div class="header_top">

<div class="header_container">

<div class="logo_left"><img src="images/logo.png" /></div>

<div class="clear"></div>
</div>

</div>
</div>
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
<ul>
<li><a href="admin/index.php" >Dashboard</a></li>
</ul>
</div>


<?php if(isset($_SESSION['admin_id'])){ ?>
<div class="right_menu" style="width:auto;">
<div class="login_section" style="width:auto;">

<ul style="padding-left:15px; padding-right:15px;">
<li>Welcome , Admin</li>  
<li>|</li>  
<li><a href="admin/logout.php">Logout</a></li>

</ul>
</div>
<?php } ?>
</div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>