<?php
include ("admin/lib/conn.php");
$subject = $_POST['subject'];
if($subject!=''){
	/*---menu sub category----*/
	$subcatID="";
	$subcatName="";
	$optionDetailssubcat="";
	$sql_subcat=sprintf("SELECT * FROM restaurant_contact_category WHERE subject_id = ".$subject."");
	$query_subcat=mysql_query($sql_subcat);
	$optionDetailssubcat = "<option value=\"\">-- Select Subject Category --</option>";
	while($array_subcat=mysql_fetch_array($query_subcat)){
		$subcatID = $array_subcat['id'];
		$subcatName = $array_subcat['contact_category'];
		$optionDetailssubcat .= "<option value=\"$subcatName\">$subcatName</option>";
	}
	/*----end----*/
	echo $optionDetailssubcat;
	echo "||";
	echo $id;
}
if($subject!=''){
	$optionDetailssubcat .= "<option value=\"\">-- Select Category --</option>";
	echo $optionDetailssubcat;
	echo "||";
	echo $id;
}
?>