<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
?>

<?php $sql_get_description = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE sub_category_id = '".$id."' AND sub_category_description!='' ORDER BY id DESC"));

$sub_cat_desc = '<textarea name="sub_category_description1" id="sub_category_description1" rows="3" cols="25" style="border:1px solid #B5ABC6; margin-top:10px;">'.$sql_get_description['sub_category_description'].'</textarea>';

echo $sub_cat_desc; ?>