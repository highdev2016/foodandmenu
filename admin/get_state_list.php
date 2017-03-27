<?php
session_start();
include ("lib/conn.php");
include ("../includes/functions.php");

$value = $_REQUEST['val'];
$cond = $_REQUEST['cond'];

if($cond == "")
{
if($value == "state")
{
	$sql = mysql_query("SELECT * FROM restaurant_customer WHERE state != '' GROUP BY state");
	while($row = mysql_fetch_array($sql))
	{
		$state = "'".$row['state']."','1'";
		//echo "<label><input type='radio' name='state' id='state_list' value='".$row['state']."' onclick='get_desired_list(".$state.",'1');' > <span class='text1'>".$row['state']."</span></label>";
		
		echo '<label><input type="radio" name="state" id="state_list" value="'.$row['state'].'" onclick="get_desired_list('.$state.');" > <span class="text1">'.$row['state'].'</span></label>';
		
	}
}
elseif($value == "city")
{
	$sql = mysql_query("SELECT * FROM restaurant_customer WHERE city != '' GROUP BY city");
	while($row = mysql_fetch_array($sql))
	{
		echo "<label><input type='checkbox' name='city[]' id='city_list' value='".$row['city']."' > <span class='text1'>".$row['city']."</span></label>";
	}
}
elseif($value == "user")
{
	$sql = mysql_query("SELECT * FROM restaurant_customer WHERE email != '' GROUP BY email");
	while($row = mysql_fetch_array($sql))
	{
		echo "<label><input type='checkbox' name='user[]' id='user_list' value=".$row['id']." > <span class='text1'>".$row['firstname']." ".$row['lastname']."</span></label>";
	}
}
}
else
{
	$sql = mysql_query("SELECT * FROM restaurant_customer WHERE city != '' AND state = '".$value."' GROUP BY city");
	while($row = mysql_fetch_array($sql))
	{
		echo "<label><input type='checkbox' name='city[]' id='city_list' value='".$row['city']."' > <span class='text1'>".$row['city']."</span></label>";
	}
}
?>