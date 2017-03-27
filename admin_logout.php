<?php
session_start();
session_destroy();
setcookie("admin_id", "", time()-3600);
print '<script language="Javascript" type="text/javascript">window.location="admin_login.php";</script>';
?>