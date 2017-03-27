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

$start_date = change_dateformat_reverse($_REQUEST['start_date_ajax']);
$end_date = change_dateformat_reverse($_REQUEST['end_date_ajax']);
$limit = $_REQUEST['limit'];

$sql = "SELECT * FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."' LIMIT ".$limit.",10";

$sql_search = mysql_query($sql);
$html='<table class="tbl-two" cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse;">';
$sl_no = $limit+1;
while($fetch_array = mysql_fetch_array($sql_search)){
	if($fetch_array['payment_mode'] == "cash")
	{
		$payment_mode = "Cash";
		$status = "Unpaid";
	}
	else
	{
		$payment_mode = "Prepaid";
		$status = "Paid";
	}
	
	$html.='
	<tr style="text-align:center;">
	<td class="all_restaurant2">'.$sl_no.'</td>
    <td class="all_restaurant2">OR-00'.$fetch_array['order_id'].'</td>
    <td class="all_restaurant2">'.getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']).'</td>
    <td class="all_restaurant2">'.date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])).'</td>
    <td class="all_restaurant2">'.$payment_mode.'</td>
    <td class="all_restaurant2">$'.$fetch_array['price_with_del_charge'].'</td>
    <td class="all_restaurant2">$'.$fetch_array['commission'].'</td>
    <td class="all_restaurant2">$'.$fetch_array['coupon_discount'].'</td>
    <td class="all_restaurant2">'.$status.'</td>
    <td class="all_restaurant2"><a class="various1" href="#inline_'.$fetch_array['order_id'].'" title="View" style="color:#686868;">View</a></td>
    </tr>';
	$sl_no++;
	
	$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$fetch_array['customer_id']."'"));
	
	$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$fetch_array['order_id']."'"));
	
	$html.='<div style="display: none;">
    	<div id="inline_'.$fetch_array['order_id'].'" style="width:500px;height:300px;overflow:auto;">
        <div class="profle_wrapper">
            <div style="width:450px;">
                <h1 style="color:#2B4494;">Order Details</h1>
               	<p style="padding-bottom:5px;"><b>Order No. : </b>OR-00'.$fetch_array['order_id'].'</p>
                <p style="padding-bottom:5px;"><b>Order Amount : </b>$'.$fetch_array['price_with_del_charge'].'</p>
                <p style="padding-bottom:5px;"><b>Customer Name : </b>'.$sql_customer['firstname']." ".$sql_customer['lastname'].'</p>
                <p style="padding-bottom:5px;"><b>Contact Details : </b>'.$sql_contact_details['address']."<br>" .$sql_contact_details['city']." ".$sql_contact_details['state']." ".$sql_contact_details['zipcode'].'</p>
                <p style="padding-bottom:5px;"><b>Phone No. : </b>'.$sql_contact_details['phone'].'</p>
                <p style="padding-bottom:5px;"><b>Menu Items ----- </b><br>';
				$sql_items_ordered = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$fetch_array['order_id']."'");
				$i=1;
				while($array_items_ordered = mysql_fetch_array($sql_items_ordered)){
					$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_items_ordered['menu_id']."'"));
					$html.=$i.") ".$sql_menu['menu_name']."<br>";
					$i++;
					}
				if($array_order['type'] == 'pickup'){
				$order_type = "Pick up"; }
				else {
				$order_type = "Delivery"; }
				
				if($array_order['payment_mode'] == 'cash'){
				$payment_mode = "Cash"; }
				else {
				$payment_mode = "Credit Card"; }
				
                $html.='</p>
                <p style="padding-bottom:5px;"><b>Order Type : '.$order_type.'</b>';
                $html.='</p>
                <p style="padding-bottom:5px;"><b>Payment Mode : '.$payment_mode.'</b>';
				$html.='</p>';
                if($sql_contact_details['special_ins']!=''){
                $html.='<p style="padding-bottom:5px;"><b>Special Instructions : </b>'.$sql_contact_details['special_ins'].'</p>';
                 }
           $html.='</div>
        </div>
    </div>
    </div>';
}

$html.='</table>';




echo $html;

?>