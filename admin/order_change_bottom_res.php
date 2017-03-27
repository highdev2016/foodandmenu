<?php
ob_start();
session_start();
include("lib/conn.php");
$parent=$_GET['id'];
	
	//echo "UPDATE restaurant_basic_info set show_order=1 WHERE id=".$parent."";
	$sql_max_showorder = mysql_fetch_array(mysql_query("SELECT MAX(show_order) FROM restaurant_basic_info")); 
	$max_show_order = $sql_max_showorder['MAX(show_order)'];
	
	mysql_query("UPDATE restaurant_basic_info set show_order= ".$max_show_order." WHERE id=".$parent."");
	
	$sql_feature_city=mysql_query("SELECT * FROM restaurant_featured_city where status=1");
				   $city_sep="";
				   $feature_city="";
				   while($res_feature_city=mysql_fetch_array($sql_feature_city))
				   {
					 $feature_city.=$city_sep."'".$res_feature_city['featured_city']."'";  
					 $city_sep=",";
				   }

	//$sql_featured_city=mysql_query("SELECT show_order,id FROM restaurant_basic_info WHERE restaurant_city IN (".$feature_city.") AND status=1 AND id NOT IN(".$parent.") ORDER BY show_order");
	
	$sql_featured_city=mysql_query("SELECT show_order,id FROM restaurant_basic_info WHERE status=1 AND id NOT IN(".$parent.") AND show_order > ".$_REQUEST['show_order']." ORDER BY show_order");
	while($res_featured_city=mysql_fetch_array($sql_featured_city))
	{
		$show_order=$res_featured_city['show_order']-1;
		mysql_query("UPDATE restaurant_basic_info SET show_order=".$show_order." WHERE id=".$res_featured_city['id']."");
	}
	
	if($_REQUEST['page']!=''){
		header("location:manage_featured_restaurant.php?page=".$_REQUEST['page']."");
	}else{
		header("location:manage_featured_restaurant.php");
	}
	
	
	
?>