<?php
session_start();
session_destroy();
$_SESSION['6_letters_code']="" ;
$_SESSION['restaurant_id']="" ;
$_SESSION['restaurant_user_user_nicename']="" ;
$_SESSION['restaurant_user_email']="" ;
print '<script language="Javascript" type="text/javascript">window.location="restaurant-login.php";</script>';
?>