<?php require_once('lib/conn.php'); ?>
<?php 
$sql_select = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE 1");
$i = 1;
while($array_select = mysql_fetch_array($sql_select)){
	$sql_update = mysql_query("UPDATE restaurant_menu_subcategory SET show_order = '".$i."' WHERE id = '".$array_select['id']."'");
$i++;
}
?>


