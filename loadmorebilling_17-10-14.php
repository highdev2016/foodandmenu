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
$html='<div>';
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
	
	$html.='
	<div>'.$sl_no.'</div>
    <div>'.date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])).'</div>
    <div>OR-00'.$fetch_array['order_id'].'</div>
    <div>'.getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']).'</div>
    <div>'.$payment_mode.'</div>
    <div>$'.$fetch_array['tax'].'</div>
    <div>$'.number_format($fetch_array['delivery_charge'],2).'</div>
    <div>$'.$fetch_array['tip'].'</div>
    <div>$'.$fetch_array['price_with_del_charge'].'</div>';

	$sl_no++;
}

$html.='</div>';

echo $html;

?>