<?php  ob_start();
	session_start();
	include("lib/conn.php");
	$parent=$_GET['id'];
	
	mysql_query("UPDATE restaurant_featured_city set show_order=1 WHERE id=".$parent."");
				   
	$sql_featured_city=mysql_query("SELECT show_order,id FROM restaurant_featured_city WHERE id NOT IN(".$parent.") ORDER BY show_order");
	while($res_featured_city=mysql_fetch_array($sql_featured_city))
	{
		$show_order=$res_featured_city['show_order']+1;
		mysql_query("UPDATE restaurant_featured_city SET show_order=".$show_order." WHERE id=".$res_featured_city['id']."");
	}
	
	if($_REQUEST['page']!=''){
		header("location:manage_featured_city.php?page=".$_REQUEST['page']."");
	}else{
		header("location:manage_featured_city.php");
	}
	
	
?>