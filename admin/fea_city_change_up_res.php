<?php  ob_start();
	session_start();
	include("lib/conn.php");
	$parent=$_GET['id'];
	$order=$_GET['show_order'];
	/*$sql_feature_city=mysql_query("SELECT * FROM restaurant_featured_city where status=1");
	$city_sep="";
	$feature_city="";
	while($res_feature_city=mysql_fetch_array($sql_feature_city))
	{
	 $feature_city.=$city_sep."'".$res_feature_city['featured_city']."'";  
	 $city_sep=",";
	}*/
	$sql_team_order=sprintf("SELECT show_order,id FROM restaurant_featured_city WHERE show_order<'%s' order by show_order desc limit 0,1",$order);
													 
	$qry_team_order=mysql_query($sql_team_order);
	$row_team_order=mysql_fetch_array($qry_team_order);
								 
	$Current_team_id=mysql_fetch_array(mysql_query(sprintf("SELECT id FROM restaurant_featured_city WHERE show_order='%s'",  $order)));
	if($row_team_order['show_order']!="")
	{
		$next_order=$row_team_order['show_order'];
		$next_order_team_id=$row_team_order['id'];
		$Current_order_team_id=$Current_team_id['id'];
		$sql_update_team_order=mysql_query(sprintf("UPDATE restaurant_featured_city set show_order='%s' where id='%s'",
											$next_order,
											$Current_order_team_id));
		$sql_update_team_order_next=mysql_query(sprintf("UPDATE restaurant_featured_city set show_order='%s' where id='%s'",
											$order,
											$next_order_team_id));	
		if($_REQUEST['page']!=''){							
			header("location:manage_featured_city.php?page=".$_REQUEST['page']."");
		}else {
			header("location:manage_featured_city.php");
		}
	}
	
?>