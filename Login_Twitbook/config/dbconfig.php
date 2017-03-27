<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'foodandm_foodand');
define('DB_PASSWORD', '!/\/F()Dm!@');
define('DB_DATABASE', 'foodandm_foodandmenu');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>
