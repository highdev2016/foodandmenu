<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");
// set the text, including table or image to print as PDF

//$html = "This just for testing only, you can change it. <br /><img src=\"http://localhost/sedeercrm/business/public/img/logo.png\" style=\"float:left;\"/> The image on the side . <br /> ";

function change_dateformat_reverse($param)
{
	 $date=explode("-",$param);
	 $dateformat=$date[2]."-".$date[0]."-".$date[1];
	 return $dateformat;
}

if($_REQUEST['start_date'] != '')
{
	if($_REQUEST['end_date']=='')
	{
		$sr_end_dt = date('m-d-Y');
	}else{
		$sr_end_dt = $_REQUEST['end_date'];
	}
}

$start_date_summary = str_replace("-","/",$_REQUEST['start_date']);
$end_date_summary = str_replace("-","/",$_REQUEST['end_date']); 

$start_date = change_dateformat_reverse($_REQUEST['start_date']);
	
if($_REQUEST['end_date'] != "")
{
	$end_date = change_dateformat_reverse($_REQUEST['end_date']);
}
else
{
	$end_date = date('Y-m-d');
}
	
$sql_num_rows = mysql_num_rows(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));

$sql = "SELECT * FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."' ORDER BY order_id DESC";

$sql_search = mysql_query($sql);	

$num_rows = mysql_num_rows($sql_search);

$get_totals = mysql_fetch_array(mysql_query("SELECT SUM(tax) as tot_tax, SUM(tip) as tot_tip, SUM(commission) as tot_commission, SUM(coupon_discount) as tot_coupons, SUM(price_with_del_charge) as tot_sales , SUM(service_fee) as service_fee FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));

$get_cash_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cash FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND payment_mode = 'cash' AND restaurant_id = '".$_SESSION['restaurant']."'"));

$get_cc_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cc FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND payment_mode = 'credit_card' AND restaurant_id = '".$_SESSION['restaurant']."'"));

$sql_res_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant']."'"));
		
if($get_cc_total['tot_cc'] != ''){
	$cc_total = "$".$get_cc_total['tot_cc']; 
}else{
	$cc_total = "$0.00";
}

if($get_totals['service_fee'] != ''){
	$ser_fee = "$".$get_totals['service_fee']; 
}else{
	$ser_fee = "$0.00";
}

$html='<div id="printdiv">
    <span class="blnce-head" style="color: #666666;display: block;font-size: 17px;font-weight: bold;margin: 20px 0 0;padding: 26px 0 0;text-align: center;" >Summary for '.$start_date_summary.' - '.str_replace("-","/",$sr_end_dt).'</span>
    <table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse; margin-top:9px;">
    <tr style="text-align:center;">
     	<td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Count</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Sales</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Cash</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total CC</td>
		<td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Service Fee</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Tax</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Coupons</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Tip</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Commission</td>
    </tr>
    <tr style="text-align:center;">
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">'.$sql_num_rows.'</td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">$'.$get_totals['tot_sales'].'</td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">$'.$get_cash_total['tot_cash'].'</td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">'.$cc_total.'</td>
	<td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">'.$ser_fee.'</td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">$'.$get_totals['tot_tax'].'</td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">$'.$get_totals['tot_coupons'].'</td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">$'.$get_totals['tot_tip'].'</td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px ">$'.$get_totals['tot_commission'].'</td>
    </tr>
    </table>
	<div id="postswrapper" style="margin-bottom:22px;">
	<table  class="tbl-two" cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse; margin-top:20px;">
    <tr style="text-align:center;">
    <td class="all_restaurant" style="width:61px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Serial No.</td>
    <td class="all_restaurant" style="width:70px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Order #</td>
    <td class="all_restaurant" style="width:130px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Restaurant</td>
    <td class="all_restaurant" style="width:155px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Date</td>
    <td class="all_restaurant" style="width:65px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Type</td>
    <td class="all_restaurant" style="width:61px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Total</td>
	<td class="all_restaurant" style="width:61px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Service Fee</td>
    <td class="all_restaurant" style="width:75px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Commission</td>
    <td class="all_restaurant" style="width:65px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Coupons</td>
    <td class="all_restaurant" style="width:67px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Status</td>
    </tr>';
	$sl_no=1;
	while($fetch_array = mysql_fetch_array($sql_search))
	{
		
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
$html.='<tr style="text-align:center;"><td class="all_restaurant2" style="width:61px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;text-align: center;"><span style="width: 56px;display: block;margin: auto;">'.$sl_no.'</span></td>
    <td class="all_restaurant2" style="width:70px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 60px;display: block;margin: auto;">OR-00'.$fetch_array['order_id'].'</span></td>
    <td class="all_restaurant2" style="width:130px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 125px;display: block;margin: auto;">'.getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']).'</span></td>
    <td class="all_restaurant2" style="width:155px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 150px;display: block;margin: auto;">'.date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])).'</span></td>
    <td class="all_restaurant2" style="width:65px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 60px;display: block;margin: auto;">'.$payment_mode.'</span></td>
    <td class="all_restaurant2" style="width:61px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 56px;display: block;margin: auto;">$'.$fetch_array['price_with_del_charge'].'</span></td>
	<td class="all_restaurant2" style="width:61px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 56px;display: block;margin: auto;">$'.$fetch_array['service_fee'].'</span></td>
    <td class="all_restaurant2" style="width:75px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 70px;display: block;margin: auto;">$'.$fetch_array['commission'].'</span></td>
    <td class="all_restaurant2" style="width:65px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 60px;display: block;margin: auto;">$'.$fetch_array['coupon_discount'].'</span> </td>
    <td class="all_restaurant2" style="width:67px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 62px;display: block;margin: auto;">'.$status.'</span></td>
    </tr>';
	$sl_no++;
	}
    
    $html.='</table></div></div>';	

	

// here we go
include("mpdf/mpdf.php");
// see the constructor method in mpdf.php file, there is a complete explanation, or you can see its documentation.
// A4 means we use A4 Paper
$mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 5, 1, 1, 1, '');
$mpdf->WriteHTML($html);
$mpdf->Output();
?>