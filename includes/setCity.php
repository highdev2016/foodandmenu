<?php
$cityVal = $_POST['cityVal'];
/*---set email----*/
$expire=time()+60*60*24*30;
setcookie("resCity", $cityVal, $expire);
/*----end-----*/
echo $cityVal;
?>