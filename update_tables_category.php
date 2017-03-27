<?php
include ("admin/lib/conn.php");

/*--------------------------------For category master table-------------------------------------------------------*/

/*$sql = mysql_query("SELECT id FROM restaurant_menu_category WHERE 1");
while($row = mysql_fetch_assoc($sql))
{
	$sql_res_id = mysql_query("SELECT restaurant_id FROM restaurant_menu_item WHERE category_id = '".$row['id']."'");
	$all_res = '';
	$sep = '';
	while($row_res_id = mysql_fetch_assoc($sql_res_id))
	{
		$all_res = $all_res.$sep.$row_res_id['restaurant_id'];
		$sep = ',';
		$str = implode(',',array_unique(explode(',', $all_res)));
	}

	$upd = mysql_query("UPDATE restaurant_menu_category SET restaurant_id = '".$str."' WHERE id = '".$row['id']."'");
}*/

/*--------------------------------For category master table-------------------------------------------------------*/

/*--------------------------------For Sub category master table-------------------------------------------------------*/

$sql = mysql_query("SELECT id FROM restaurant_menu_subcategory WHERE 1");
while($row = mysql_fetch_assoc($sql))
{
	$sql_res_id = mysql_query("SELECT restaurant_id FROM restaurant_menu_item WHERE sub_category_id = '".$row['id']."'");
	$all_res = '';
	$sep = '';
	while($row_res_id = mysql_fetch_assoc($sql_res_id))
	{
		$all_res = $all_res.$sep.$row_res_id['restaurant_id'];
		$sep = ',';
		$str = implode(',',array_unique(explode(',', $all_res)));
	}

	$upd = mysql_query("UPDATE restaurant_menu_subcategory SET restaurant_id = '".$str."' WHERE id = '".$row['id']."'");
}

/*--------------------------------For Sub category master table-------------------------------------------------------*/