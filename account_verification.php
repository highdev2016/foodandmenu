<?php include ("admin/lib/conn.php");?>
<?php include ("includes/reg_header.php");
$sql_update = mysql_query("UPDATE  restaurant_customer SET status = 1 WHERE id = '".$_REQUEST['id']."'");
?>

<body class="login_bg">

<div class="body_section">
<div class="login_wrapper">

<div class="login_container">
<div class="login_body">

<div class="login_body_cont">

<div class="registration_logo_section"><a href="index.php"><img src="images/logo.png" width="216" height="99" /></a></div>

<div class="registration_section" style="height:210px;">


<div class="regi_sign_up" style="width:100%;">

<div class="regi_left_top">

<h1>Account Activation</h1>
</div>
<p style="margin-left:20px; font-family:Arial,Helvetica,sans-serif; color:#4960A8; font-weight:bold; width:800px;">Your registration process is completed successfully.Now your account is activated. If you want to access please <a href="login.php" style="color:#F0832B; font-weight:bold;">Log in</a></p>

</div>












<div class="clear"></div>

</div>

</div>

</div>

<div class="body_footer_bg"></div>

<div class="clear"></div>
</div>
</div>

</div>

</body>
</html>
