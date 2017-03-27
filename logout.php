<?php
session_start();
session_destroy();
setcookie("customer_id", "", time()-3600);

print '<script language="Javascript" type="text/javascript">window.location="index.php";</script>';
?>