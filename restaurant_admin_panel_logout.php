<?php
session_start();
session_destroy();
$_SESSION['restaurant_admin_panel_id']="" ;
print '<script language="Javascript" type="text/javascript">window.location="restaurant_admin_login.php";</script>';
?>