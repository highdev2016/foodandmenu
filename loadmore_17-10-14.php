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
$html='<div>';
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
	<div>'.$sl_no.'</div>
    <div>OR-00'.$fetch_array['order_id'].'</div>
    <div>'.getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']).'</div>
    <div>'.date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])).'</div>
    <div>'.$payment_mode.'</div>
    <div>$'.$fetch_array['price_with_del_charge'].'</div>
    <div>$'.$fetch_array['commission'].'</div>
    <div>$'.$fetch_array['coupon_discount'].'</div>
    <div>'.$status.'</div>
    <div><a href="javascript:void(0);" title="View" onClick="open_view_div('.$fetch_array['order_id'].');" style="color:#686868;">View</a></div>';

	$sl_no++;
	
	$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$fetch_array['customer_id']."'"));
	
	$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$fetch_array['order_id']."'"));
	
	$html.='<div id="view_details'.$fetch_array['order_id'].'" style="display:none;" class="factor_details white_content nw_white_cont" >
    		<div class="close close-new" onclick="close_view_div('.$fetch_array['order_id'].');"><a href = "javascript:void(0);"></a> </div>
    		<div class="l-contnt nw-l-cont">
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
		<div id="fade1" class="black_overlay"> </div>
    ';
}

$html.='</div>';




echo $html;

?>