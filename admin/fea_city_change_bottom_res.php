<?php
ob_start();
session_start();
include("lib/conn.php");
$parent=$_GET['id'];

	$sql_max_showorder = mysql_fetch_array(mysql_query("SELECT MAX(show_order) FROM restaurant_featured_city")); 
	$max_show_order = $sql_max_showorder['MAX(show_order)'];
	
	mysql_query("UPDATE restaurant_featured_city set show_order= ".$max_show_order." WHERE id=".$parent."");
	
	$sql_featured_city=mysql_query("SELECT show_order,id FROM restaurant_featured_city WHERE 1 AND id NOT IN(".$parent.") AND show_order > ".$_REQUEST['show_order']." ORDER BY show_order");
	while($res_featured_city=mysql_fetch_array($sql_featured_city))
	{
		$show_order=$res_featured_city['show_order']-1;
		mysql_query("UPDATE restaurant_featured_city SET show_order=".$show_order." WHERE id=".$res_featured_city['id']."");
	}
	
	if($_REQUEST['page']!=''){
		header("location:manage_featured_city.php?page=".$_REQUEST['page']."");
	}else{
		header("location:manage_featured_city.php");
	}
	
	
	
?>