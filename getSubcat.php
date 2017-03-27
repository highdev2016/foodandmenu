<?php
include ("admin/lib/conn.php");
$catid = $_POST['catid'];
$id = $_POST['id'];
if($catid!='' && $id!=''){
	/*---menu sub category----*/
	$subcatID="";
	$subcatName="";
	$optionDetailssubcat="";
	$sql_subcat=sprintf("select * from restaurant_menu_subcategory where category_id='".$catid."' order by subcategory_name");
	$query_subcat=mysql_query($sql_subcat);
	$optionDetailssubcat = "<option value=\"\">-- Select Sub Category --</option>";
	while($array_subcat=mysql_fetch_array($query_subcat)){
		$subcatID = $array_subcat['id'];
		$subcatName = $array_subcat['subcategory_name'];
		$optionDetailssubcat .= "<option value=\"$subcatID\">$subcatName</option>";
	}
	/*----end----*/
	echo $optionDetailssubcat;
	echo "||";
	echo $id;
}
if($catid=='' && $id!=''){
	$optionDetailssubcat .= "<option value=\"\">-- Select Category --</option>";
	echo $optionDetailssubcat;
	echo "||";
	echo $id;
}
?>