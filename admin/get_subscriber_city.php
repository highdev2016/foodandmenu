<?php
include ("lib/conn.php");
$city = $_POST['city'];
$city_array = explode(",",$city);
	/*---menu sub category----*/
	$subcatID="";
	$subcatName="";
	$optionDetailssubcat="";
	$sql_subcat=sprintf("select * from restaurant_customer WHERE newsletter_subscription = 1 ORDER BY email");
	$query_subcat=mysql_query($sql_subcat);
	//$optionDetailssubcat = "<option value=\"\">-- Select Sub Category --</option>";
	while($array_subcat=mysql_fetch_array($query_subcat)){
		$subcatID = $array_subcat['id'];
		$subcatName = $array_subcat['email'];
		$subscriber_city = $array_subcat['city'];
		if($city!=''){
		if(in_array($subscriber_city, $city_array)){
		$selected="checked=checked"; } 
		else {
			$selected="";
		}
		}
		$optionDetailssubcat .= ' <input type="checkbox" name="send_to[]"  value="'.$subcatName.'"  '.$selected.'/><input type="hidden" name="send_id['.$subcatID.']"  value="'.$subcatName.'" />' . $subcatName.'<br />';
	}
	/*----end----*/
	echo $optionDetailssubcat;


?>