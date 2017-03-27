<?php
include ("admin/lib/conn.php");

$sql_res = mysql_query("SELECT id FROM restaurant_basic_info WHERE 1");
while($row_res = mysql_fetch_assoc($sql_res))
{
	$sql_cat = mysql_query("SELECT id FROM restaurant_menu_category WHERE restaurant_id IN (".$row_res['id'].")");
	while($row_cat = mysql_fetch_assoc($sql_cat))
	{
		$sql_subcat = mysql_query("SELECT id FROM restaurant_menu_subcategory WHERE category_id = '".$row_cat['id']."'");
		
		while($row_subcat = mysql_fetch_assoc($sql_subcat))
		{
			$sql_sel = mysql_query("SELECT * FROM restaurant_menu_item WHERE category_id = '".$row_cat['id']."' AND sub_category_id = '".$row_subcat['id']."' AND restaurant_id = '".$row_res['id']."'");
			
			while($arr_item = mysql_fetch_array($sql_sel)){
					
				$sql_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$arr_item['id']."' AND restaurant_id = '".$row_res['id']."'");
				
				while($row_ins = mysql_fetch_assoc($sql_ins))
				{
					$sql_ins_opt = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$row_ins['id']."' AND restaurant_id = '".$row_res['id']."'");
					$i = 1;
					while($row_ins_opt = mysql_fetch_assoc($sql_ins_opt))
					{
						echo "UPDATE restaurant_menu_item_special_instruction SET show_order = '".$i."' WHERE  special_ins_id = '".$row_ins['id']."' AND restaurant_id = '".$row_res['id']."' AND id = '".$row_ins_opt['id']."' "."<br>";
						$update = mysql_query("UPDATE restaurant_menu_item_special_instruction SET show_order = '".$i."' WHERE  special_ins_id = '".$row_ins['id']."' AND restaurant_id = '".$row_res['id']."' AND id = '".$row_ins_opt['id']."' ");
						
						$i++;
					}
				}
			}
			
			
		}
	}
}