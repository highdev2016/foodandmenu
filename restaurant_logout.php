<?php
session_start();
session_destroy();
$_SESSION['restaurant_id']="" ;
print '<script language="Javascript" type="text/javascript">window.location="restaurant-login.php";</script>';
?>