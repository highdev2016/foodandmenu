<?php
$db_host = "localhost";
$db_username = "infosolz_foodmnu";
$db_password = "123!@#123";
$db_name = "infosolz_foodandmenu";
////////////////////////////////////////////////////////////

//////         do not edit below this line	///////

///////////////////////////////////////////////////////////
$dbh = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error());
//select database
mysql_select_db($db_name, $dbh) or die("could not find DB.");
///Common variable//////////////
$table_prefix ="restaurant_";
?>