<?php
session_start();
session_destroy();
$_SESSION['admin_id']="" ;
print '<script language="Javascript" type="text/javascript">window.location="index.php";</script>';
?>