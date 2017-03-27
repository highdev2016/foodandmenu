<?php
// connect to database
include ("admin/lib/conn.php");
include ("includes/functions.php");

if($_GET['do']=='rate'){
	// do rate
	rate();
}else if($_GET['do']=='getrate'){
	// get rating
	getRating();
}

?>
