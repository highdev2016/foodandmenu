<?php
if($_SERVER['HTTP_HOST'] == "localhost"){
		$host = "localhost";
		$user = "foodandm_foodand";
		$pass = "!/\/F()Dm!@";
		$dbname = "foodandm_foodandmenu";
	}else{
		$host = "localhost";
		$user = "foodandm_foodand";
		$pass = "!/\/F()Dm!@";
		$dbname = "foodandm_foodandmenu";
	}
	$conn = mysql_connect($host, $user, $pass) or die ("Error Connection: ".mysql_error());
	mysql_select_db($dbname, $conn) or die ("Error DB: ".mysql_error());
	
?>