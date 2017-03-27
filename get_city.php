<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/header_profile.php");
include ("includes/functions.php");

$state = $_REQUEST['state'];

if($state != "")
{
	$sql = mysql_query("SELECT * FROM  `restaurant_basic_info` WHERE restaurant_state =  '".$state."' GROUP BY restaurant_city");
	
	$html = '<span>City : </span><select name="city" id="city">
	<option value="">---Select City---</option>
	';
	while($row_all_city = mysql_fetch_array($sql))
	{
		$html.= '<option value="'.$row_all_city['restaurant_city'].'">'.$row_all_city['restaurant_city'].'</option>';
	}
	$html.= '</select>';
}

echo $html;

?>
