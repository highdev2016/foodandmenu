<?php
  ob_start();
	session_start();
	include("admin/lib/conn.php");
	$parent= $_REQUEST['id'];
	$order= $_REQUEST['show_order'];
	$res_id = $_REQUEST['res_id'];
	$special_ins_id = $_REQUEST['special_ins_id'];
	$menu_id = $_REQUEST['menu_id'];
	$page_name = $_REQUEST['pg_name'];
	
	$sql_menu_item = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$menu_id."'"));
	
	/* $sql_feature_city=mysql_query("SELECT * FROM restaurant_featured_city where status=1");
				   $city_sep="";
				   $feature_city="";
				   while($res_feature_city=mysql_fetch_array($sql_feature_city))
				   {
					 $feature_city.=$city_sep."'".$res_feature_city['featured_city']."'";  
					 $city_sep=",";
				   }*/
	//$sql_team_order=sprintf("SELECT show_order,id FROM restaurant_basic_info WHERE restaurant_city IN (".$feature_city.") AND show_order<'%s' order by show_order desc limit 0,1",$order);
	
	$sql_team_order=sprintf("SELECT show_order,id FROM restaurant_menu_item_special_instruction WHERE show_order<'%s' AND menu_id = '".$menu_id."' AND restaurant_id = '".$res_id."' AND special_ins_id = '".$special_ins_id."' order by show_order desc limit 0,1",$order);
													 
	$qry_team_order=mysql_query($sql_team_order);
	$row_team_order=mysql_fetch_array($qry_team_order);

	//$Current_team_id=mysql_fetch_array(mysql_query(sprintf("SELECT id FROM restaurant_basic_info WHERE restaurant_city IN (".$feature_city.") AND show_order='%s'", $order)));
								 
	$Current_team_id=mysql_fetch_array(mysql_query(sprintf("SELECT id FROM restaurant_menu_item_special_instruction WHERE show_order='%s' AND menu_id = '".$menu_id."' AND restaurant_id = '".$res_id."' AND special_ins_id = '".$special_ins_id."'",  $order)));
	if($row_team_order['show_order']!="")
	{
		$next_order=$row_team_order['show_order'];
		$next_order_team_id=$row_team_order['id'];
		$Current_order_team_id=$Current_team_id['id'];

		$sql_update_team_order=mysql_query(sprintf("UPDATE restaurant_menu_item_special_instruction set show_order='%s' where id='%s'",
											$next_order,
											$Current_order_team_id));
		$sql_update_team_order_next=mysql_query(sprintf("UPDATE restaurant_menu_item_special_instruction set show_order='%s' where id='%s'",
											$order,
											$next_order_team_id));	
							
			//header("location:edit_restaurant_menu.php?restaurant_edit_id=".$res_id."&showinssuccess=1");
			
		if($page_name == 'edit_res'){
			header("location:edit_restaurant_menu.php?restaurant_edit_id=".$res_id."&showinssuccess=1&spl_ins_pop=1&menu_id=".$menu_id."&cat_id=".$sql_menu_item['category_id']."&sub_cat=".$sql_menu_item['sub_category_id']."");
		}else if($page_name == 'adm_res'){
			header("location:admin_restaurant_menu.php?showinssuccess=1&spl_ins_pop=1&menu_id=".$menu_id."&cat_id=".$sql_menu_item['category_id']."&sub_cat=".$sql_menu_item['sub_category_id']."");
		}else if($page_name == 'res_menu'){
			header("location:restaurant_menu.php?showinssuccess=1&spl_ins_pop=1&menu_id=".$menu_id."&cat_id=".$sql_menu_item['category_id']."&sub_cat=".$sql_menu_item['sub_category_id']."");
		}else if($page_name == 'res_admin'){
			header("location:restaurant_menu_admin.php?showinssuccess=1&spl_ins_pop=1&menu_id=".$menu_id."&cat_id=".$sql_menu_item['category_id']."&sub_cat=".$sql_menu_item['sub_category_id']."");
		}else if($page_name == 'spl_res'){
			header("location:spl_admin_restaurant_menu.php?showinssuccess=1&spl_ins_pop=1&menu_id=".$menu_id."&cat_id=".$sql_menu_item['category_id']."&sub_cat=".$sql_menu_item['sub_category_id']."");
		}

}
	
?>