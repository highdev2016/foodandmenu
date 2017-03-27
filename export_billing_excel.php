<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

function change_dateformat_reverse_db($date_form1)
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

function change_dateformat_reverse($date_form1)
 {
  if($date_form1!=''){
   $date2=explode("-",$date_form1);
   $dateformat1=$date2[1]."-".$date2[2]."-".$date2[0];
   return $dateformat1;
   }
  else{
   $dateformat1='';
   return $dateformat1;
   }
 }
 
function cleanData(&$str) {
	// escape tab characters 
	$str = preg_replace("/\t/", "\\t", $str); 
	// escape new lines 
	$str = preg_replace("/\r?\n/", "\\n", $str); 
	// convert 't' and 'f' to boolean values 
	if($str == 't') $str = 'TRUE'; 
	if($str == 'f') $str = 'FALSE'; 
	// force certain number/date formats to be imported as strings 
	if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) 
		{ $str = "'$str"; } 
	// escape fields that include double quotes 
	if(strstr($str, '"')) 
		$str = '"' . str_replace('"', '""', $str) . '"'; 
} 
function export($statement) { 
        // file name for download 
        $filename = "excel_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false;
        $get_search_date = explode("^",$statement);

		$query_res = mysql_query("SELECT * FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND restaurant_id = '".$_SESSION['restaurant']."'");
		
		$num_rows = mysql_num_rows($query_res);
		
		
		
		$get_totals = mysql_fetch_array(mysql_query("SELECT SUM(tax) as tot_tax, SUM(tip) as tot_tip, SUM(commission) as tot_commission, SUM(coupon_discount) as tot_coupons, SUM(price_with_del_charge) as tot_sales , SUM(service_fee) as service_fee FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."'  AND restaurant_id = '".$_SESSION['restaurant']."'"));
		
		$get_cash_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cash FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND payment_mode = 'cash'  AND restaurant_id = '".$_SESSION['restaurant']."'"));
		
		$get_cc_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cc FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND payment_mode = 'credit_card' AND restaurant_id = '".$_SESSION['restaurant']."'"));
		
		$sql_res_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant']."'"));
		
		if($get_cash_total['tot_cash'] == '')
		{
			$get_cash_total['tot_cash'] = 0.00;
		}
		
		if($get_cc_total['tot_cc'] == '')
		{
			$get_cc_total['tot_cc'] = 0.00;
		}
		
		if($get_totals['service_fee'] == '')
		{
			$get_totals['service_fee'] = 0.00;
		}
		
		echo  "COUNT"."\t"."TOTAL SALES."."\t"."TOTAL CASH"."\t"."TOTAL CC"."\t"."TOTAL SERVICE FEE"."\t"."TOTAL TAX"."\t"."TOTAL COUPONS"."\t"."TOTAL TIP"."\t"."TOTAL COMMISSION". "\n";
		
		$str = $num_rows."\t"."$".$get_totals['tot_sales']."\t"."$".$get_cash_total['tot_cash']."\t"."$".$get_cc_total['tot_cc']."\t"."$".$get_totals['service_fee']."\t"."$".$get_totals['tot_tax']."\t"."$".$get_totals['tot_coupons']."\t"."$".$get_totals['tot_tip']."\t"."$".$get_totals['tot_commission']."\t"."\n";
			echo $str;
		
		
		while(false !== ($row = mysql_fetch_array($query_res))) { 
			
	        if(!$flag) { 
		        // display field/column names as first row 
		    echo  "ORDER TIME"."\t"."ORDER NO."."\t"."RESTAURANT NAME"."\t"."ORDER TYPE"."\t"."TAX"."\t"."DELIVERY FEE"."\t"."TIP"."\t"."SERVICE FEE"."\t"."TOTAL". "\n"; $flag = true; 
	        }         
	        array_walk($row, 'cleanData'); 
			
			if($row['payment_mode'] == 'cash')
			{
				$payment_mode = "Cash";
			}
			else
			{
				$payment_mode = "Prepaid";
			}
			
			
			
			$db_date = explode(" ",$row['order_date']);
			
			//$db_date = date("Y-m-d", strtotime($row['order_date']));
			
			$new_date = change_dateformat_reverse($db_date[0]);
			
			$new_new_date = str_replace("'"," ",$new_date);
			
			$date = str_replace("-","/",$new_new_date);
			
			$time = date("h:i:s a", strtotime($db_date[1]));
			
			
			$order_amount = str_replace("'","",$row['total_price']);
			$tax = str_replace("'","",$row['tax']);
			$tip = str_replace("'","",$row['tip']);
			$delivery_charge = str_replace("'","",$row['delivery_charge']);
			$service_fee = str_replace("'","",$row['service_fee']);
			
			//echo $date;exit; 
			//$order_date = date("m-d-Y", strtotime($date));
	        //echo implode("\t", array_values($row)) . "\n"; 
			$str = $date." ".$time."\t".stripslashes("OR-00".$row['order_id'])."\t".getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id'])."\t".$payment_mode."\t"."$".$tax."\t"."$".$delivery_charge."\t"."$".$tip."\t"."$".$service_fee."\t"."$ ".$row['price_with_del_charge']."\t"."\n";
			echo $str;
        } 
        
}


export($_REQUEST['statement']);


?>