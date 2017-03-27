<?php include ("admin/lib/conn.php"); 

$sql_select = mysql_query("SELECT * FROM restaurant_take_out_master WHERE id!=''");
while($array_select = mysql_fetch_array($sql_select)){
	$sql_insert = mysql_query("INSERT INTO restaurant_pickup_hrs SET days_id = '7' , restaurant_id = '".$array_select['restaurant_id']."' , time_from = '".$array_select['from_time_sunday']."' , time_to = '".$array_select['to_time_sunday']."'");
}


?>