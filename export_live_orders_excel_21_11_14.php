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
function export($order_id,$customer_name,$customer_phone,$customer_address,$status,$mod_date,$st_dt,$end_dt) { 

        // file name for download 
        $filename = "excel_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false;
        $query_export = "SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$_SESSION['restaurant']."'";
			  
		  $order_new_id = substr($order_id,5);
		  if($order_id!=''){
			  $query_export.=" AND order_id = '".$order_new_id."'";
		  }
		  
		  if($customer_name!=''){
			  $query_export.=" AND customer_name LIKE '%".$customer_name."%'";
		  }
		  
		  if($customer_phone!=''){
			  $query_export.=" AND customer_phone = '".$customer_phone."'";
		  }
		  
		  if($customer_address!=''){
			  $query_export.=" AND customer_address LIKE '%".$customer_address."%'";
		  }
		  
		  if($status!=''){
			  $query_export.=" AND status = '".$status."'";
		  }
		  
		  if($mod_date!='')
		  {
			  if($mod_date == 'This Week')
			  {
				  $query_export.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
			  }
			  if($mod_date == 'Last Week')
			  {
				  $query_export.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
			  }
			  if($mod_date == 'Last Month')
			  {
				$query_export.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
			  }
			  if($mod_date == 'Last 3 Month')
			  {
				$query_export.=" AND order_date >= now()-interval 3 month ";
			  }
			  if($mod_date == 'Last 6 Month')
			  {
				$query_export.=" AND order_date >= now()-interval 6 month ";
			  }
			  if($mod_date == 'Last Year')
			  {
				$query_export.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
			  }
			  
			   if($mod_date == 'Custom Date')
			  {
				  $start_date_new = change_dateformat_reverse_db($st_dt);
				  $end_date_new = change_dateformat_reverse_db($end_dt);
				  $query_export.=" AND order_date >= '".$start_date_new." 00:00:00' AND order_date <= '".$end_date_new." 59:59:59'";
			  }
		  }
		  
		  $query_export.=" ORDER BY order_id DESC";
		
		$result = mysql_query($query_export);
		
		while(false !== ($row = mysql_fetch_assoc($result))) { 
			
	        if(!$flag) { 
		        // display field/column names as first row 
		    echo  "DATE"."\t"."ORDER NO"."\t"."ORDER AMOUNT"."\t"."ORDER TYPE"."\t"."RESTAURANT NAME"."\t"."CUSTOMER NAME"."\t"."CUSTOMER ADDRESS"."\t"."CUSTOMER PHONE"."\t"."TAX AMOUNT"."\t"."CREDIT CARD AMOUNT"."\t"."CASH AMOUNT"."\t"."TIPS AMOUNT"."\t"."COMMISSION AMOUNT"."\t"."TOTAL AMOUNT"."\t"."CONFIRMATION CODE"."\t". "\n"; $flag = true; 
	        }         
	        array_walk($row, 'cleanData'); 
			
			if($row['type'] == 'pickup')
			{
				$del = "Pick Up";
			}
			else
			{
				$del = "Delivery";
			}
			
			if($row['payment_mode'] == 'cash')
			{
				$cash_amount = str_replace("'","",$row['price_with_del_charge']);
				$credit_card_amount = '0';
			}
			else
			{
				$credit_card_amount = str_replace("'","",$row['price_with_del_charge']);
				$cash_amount = '0';
			}
			
			$db_date = explode(" ",$row['order_date']);
			
			//$db_date = date("Y-m-d", strtotime($row['order_date']));
			
			$new_date = change_dateformat_reverse($db_date[0]);
			
			$new_new_date = str_replace("'"," ",$new_date);
			
			$date = str_replace("-","/",$new_new_date);
			
			
			$order_amount = str_replace("'","",$row['total_price']);
			$tax = str_replace("'","",$row['tax']);
			$tip = str_replace("'","",$row['tip']);
			$commission = str_replace("'","",$row['commission']);
			
			//echo $date;exit; 
			//$order_date = date("m-d-Y", strtotime($date));
	        //echo implode("\t", array_values($row)) . "\n"; 
			$str = $date."\t".stripslashes("OR-00".$row['order_id'])."\t"."$ ".$order_amount."\t".$del."\t".getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id'])."\t".getNameTable("restaurant_customer","firstname","id",$row['customer_id'])." ".getNameTable("restaurant_customer","lastname","id",$row['customer_id'])."\t".getNameTable("restaurant_customer","address","id",$row['customer_id'])."\t".getNameTable("restaurant_customer","phone","id",$row['customer_id'])."\t"."$ ".$tax."\t"."$ ".$credit_card_amount."\t"."$ ".$cash_amount."\t"."$ ".$tip ."\t"."$ ".$commission ."\t"."$ ".$row['price_with_del_charge']."\t".$row['confirmation_code'] ."\t"."\n";
			echo $str;
        } 
        
}

export($_REQUEST['order_id'],$_REQUEST['customer_name'],$_REQUEST['customer_phone'],$_REQUEST['customer_address'],$_REQUEST['status'],$_REQUEST['mod_date'],$_REQUEST['start_date'],$_REQUEST['end_date']);


?>