<?php
include ("admin/lib/conn.php");

$sql = mysql_query("SELECT id FROM restaurant_menu_subcategory WHERE category_id = '25' AND restaurant_id = '105058'");
$i = 1;
while($row = mysql_fetch_assoc($sql))
{
	$upd = mysql_query("UPDATE restaurant_menu_subcategory SET show_order = '".$i."' WHERE id = '".$row['id']."'");
	$i++;
}