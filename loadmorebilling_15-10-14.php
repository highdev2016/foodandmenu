<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

function change_dateformat_reverse($date_form1)
 {
  if($date_form1!=''){
   $date2=explode("-",$date_form1);
   $dateformat1=$date2[2]."-".$date2[0]."-".$date2[1];
   return $dateformat1;
   }
  else{
   $dateformat1='';
   return $dateformat1;
   }
 }

$start_date = $_REQUEST['start_date_ajax'];
$end_date = $_REQUEST['end_date_ajax'];
$limit = $_REQUEST['limit'];

$sql = "SELECT * FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."' LIMIT ".$limit.",10";

$sql_search = mysql_query($sql);
$html='  <table class="tbl-two" cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse;">';
$sl_no = $limit+1;
while($fetch_array = mysql_fetch_array($sql_search)){
	if($fetch_array['payment_mode'] == "cash")
	{
		$payment_mode = "Cash";
	}
	else
	{
		$payment_mode = "Prepaid";
	}
	
	$html.='<tr style="text-align:center;">
    <td class="all_restaurant2">'.$sl_no.'</td>
    <td class="all_restaurant2">'.date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])).'</td>
    <td class="all_restaurant2">OR-00'.$fetch_array['order_id'].'</td>
    <td class="all_restaurant2">'.getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']).'</td>
    <td class="all_restaurant2">'.$payment_mode.'</td>
    <td class="all_restaurant2">$'.$fetch_array['tax'].'</td>
    <td class="all_restaurant2">$'.number_format($fetch_array['delivery_charge'],2).'</td>
    <td class="all_restaurant2">$'.$fetch_array['tip'].'</td>
    <td class="all_restaurant2">$'.$fetch_array['price_with_del_charge'].'</td>
    </tr>';
	$sl_no++;
}

$html.='</table>';

echo $html;

?>