<?php
session_start();
include ("admin/lib/conn.php");
// Some html code omitted

$html.='<div id="printdiv"><table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="4%" class="all_restaurant">Sl No.</td>
    <td width="20%" class="all_restaurant">Menu Name</td>
    <td width="11%" class="all_restaurant">Quantity</td>
    <td width="9%" class="all_restaurant">Price</td>
    <td width="12%" class="all_restaurant">Sum</td>
    </tr>';
  $query_res = ("SELECT  *  FROM restaurant_food_order_details WHERE restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."' GROUP BY menu_name");
  $sql_order = mysql_query($query_res);
  if(mysql_num_rows($sql_order)>0){
  $inc = 1;
  while($array_order = mysql_fetch_array($sql_order)){
  $sql_date_ordered = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$array_order['order_id']."'")); 
  $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$array_order['customer_id']."'"));
  $sql_quantity = mysql_fetch_array(mysql_query("SELECT SUM(quantity) as qty , SUM(unit_price) as sum_sum FROM  restaurant_food_order_details WHERE menu_id = '".$array_order['menu_id']."'"));
  $html.='<tr><td class="all_restaurant2">'.$a=($j+$inc).'</td>
    <td class="all_restaurant2">'.$array_order['menu_name'].'</td>
    <td class="all_restaurant2">'.$sql_quantity['qty'].'</td>
    <td class="all_restaurant2">$'.$array_order['unit_price'].'</td>
    <td class="all_restaurant2">$'.$sql_quantity['sum_sum'].'</td>
  </tr>';
  $inc++; } } else {
  $html.='<tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No orders yet</td>
  </tr>';
  }
$html.='</table></div>';

// here we go
include("mpdf/mpdf.php");
// see the constructor method in mpdf.php file, there is a complete explanation, or you can see its documentation.
// A4 means we use A4 Paper
$mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 5, 1, 1, 1, '');
$mpdf->WriteHTML($html);
$mpdf->Output();
?>