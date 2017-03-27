<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");
// set the text, including table or image to print as PDF

//$html = "This just for testing only, you can change it. <br /><img src=\"http://localhost/sedeercrm/business/public/img/logo.png\" style=\"float:left;\"/> The image on the side . <br /> ";

$search_date = $_REQUEST['statement'];

$get_search_date = explode("^",$search_date);

$sql_num_rows = mysql_num_rows(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
$sql_res = "SELECT * FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND restaurant_id = '".$_SESSION['restaurant']."'";

$query_res = mysql_query($sql_res);
	
$num_rows = mysql_num_rows($query_res);

$get_totals = mysql_fetch_array(mysql_query("SELECT SUM(tax) as tot_tax, SUM(tip) as tot_tip, SUM(commission) as tot_commission, SUM(coupon_discount) as tot_coupons, SUM(price_with_del_charge) as tot_sales , SUM(service_fee) as service_fee  FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."'  AND restaurant_id = '".$_SESSION['restaurant']."'"));

$get_cash_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cash FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND payment_mode = 'cash'  AND restaurant_id = '".$_SESSION['restaurant']."'"));

$get_cc_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cc FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND payment_mode = 'credit_card' AND restaurant_id = '".$_SESSION['restaurant']."'"));

$sql_res_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant']."'"));

if($sql_res_details['phone'] != '')
{
	$phone = "Phone : ".$sql_res_details['phone']."<br>";
}else{
	$phone = '';
}

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
	
$html='<div id="printdiv" class="printdiv-class" style="padding: 2%;">
    	
    	<h4 class="ttl" style="color: #666666; font-size: 18px;font-weight: bold;text-align: center;text-transform: uppercase;margin: 0 0 44px;font-family: Calibri;">
    		Statement : '.date('m/d/Y', strtotime($get_search_date[1]))." - ".date('m/d/Y', strtotime($get_search_date[0]))."<br>".'</h4>
		<div class="restu-top" style=" border-bottom: 1px solid #DDDDDD;float: left;margin: 0 0 20px;position: relative;width: 100%;">
			<div class="restu-info" style="bottom: -1px;float: left;position: relative;width: 30%;font-family: Calibri;">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td style="border-left: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;margin: 0;padding: 1%;font-family: Calibri; color: #686868;">
							To : 
						</td>
						<td style="border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;margin: 0;padding: 1%;font-family: Calibri; color: #686868;"> 
							<span class="fr_to"> '.$sql_res_details['restaurant_name'].'
							</span>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;margin: 0;padding: 1%;font-family: Calibri; color: #686868;">
							<p style="margin:5px 0; border-bottom:1px dashed #dddddd">
							'.$sql_res_details['restaurant_address']." ".$sql_res_details['restaurant_city']." ".$sql_res_details['restaurant_state']." ".$sql_res_details['restaurant_zipcode']."<br>".'
                                </p>
                                <p>'.$phone.'
							</p>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="restu-date text-center" style="bottom: -1px;float: right;position: absolute;right: 0px;width: 25.5%; font-family: Calibri;text-align: center !important;">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td colspan="3" style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;margin: 0;padding: 1%;width: 94%;">
							Date
						</td>
						
					</tr>
					<tr>
						<td style="border-left: 1px solid #ddd; border-top: 1px solid #ddd; margin: 0px; padding: 1% 0px 1% 5%;font-family: Calibri; color: #686868;">
							<span class="fr-dt">'.date('m/d/Y').'</span>
						</td>
						<td style="border-top: 1px solid #DDDDDD;margin: 0;padding: 1% 0; font-family: Calibri; color: #686868;">
							<span class="fr-tm">'.date('h:i:s').'</span>
						</td>
						<td style="border-right: 1px solid #ddd; border-top: 1px solid #ddd; margin: 0px; padding: 1% 5% 1% 0%; font-family: Calibri; color: #686868;">
							<span class="fr-am">'.date('a').'
							</span> 
						</td>
					</tr>
				</table>
			</div>
    	</div>
    	<div class="clear"></div>
    <div class="clear"></div>
	<span style="font-weight:bold; color:#4A7AD5; font-size:19px;">Summary</span>
	<div class="clear"></div>
    <table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="100%" style="border-collapse:collapse; margin-top:20px;">
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
    <div id="postswrapper" style="margin-bottom:22px; width: 100%">
    <table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="100%" style="border-collapse:collapse; margin-top:20px;">
    <tr style="text-align:center;">
    <td style="width:61px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Serial No.</td>
    <td style="width:148px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Order Time</td>
    <td style="width:82px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Order #</td>
    <td style="width:157px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Restaurant</td>
    <td style="width:42px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Type</td>
    <td style="width:48px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Tax</td>
    <td style="width:80px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Delivery Fee</td>
    <td style="width:80px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Tip</td>
	<td style="width:80px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Service Fee</td>
    <td style="width:93px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Total</td>
    </tr>';
	$sl_no=1;
	while($fetch_array = mysql_fetch_array($query_res))
	{
		if($fetch_array['payment_mode'] == "cash")
		{
			$payment_mode = "Cash";
		}
		else
		{
			$payment_mode = "Prepaid";
		}
    $html.='<tr style="text-align:center;">
    <td style="width:61px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 54px;display: block;margin: auto;">'.$sl_no.'</span> </td>
    <td style="width:148px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"> <span style="width: 145px;display: block;margin: auto;">'.date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])).'</span> </td>
    <td style="width:82px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 80px;display: block;margin: auto;">OR-00'.$fetch_array['order_id'].'</span> </td>
    <td style="width:157px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 154px;display: block;margin: auto;">'.getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']).'</span> </td>
    <td style="width:42px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 40px;display: block;margin: auto;">'.$payment_mode.'</span> </td>
    <td style="width:48px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 40px;display: block;margin: auto;">$'.$fetch_array['tax'].'</span> </td>
    <td style="width:80px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 74px;display: block;margin: auto;">$'.number_format($fetch_array['delivery_charge'],2).'</span></td>
    <td style="width:80px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 50px;display: block;margin: auto;">$'.$fetch_array['tip'].'</span> </td>
	<td style="width:80px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 50px;display: block;margin: auto;">$'.$fetch_array['service_fee'].'</span> </td>
    <td style="width:93px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 60px;display: block;margin: auto;">$'.$fetch_array['price_with_del_charge'].'</span> </td>
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