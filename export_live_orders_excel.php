<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

function date_compare($a, $b)
{
    $t1 = strtotime($a['order_date']);
    $t2 = strtotime($b['order_date']);
    return $t1 - $t2;
}    

function changekeyname($array, $newkey, $oldkey)
{
   foreach ($array as $key => $value) 
   {
      if (is_array($value))
         $array[$key] = changekeyname($value,$newkey,$oldkey);
      else
        {
             $array[$newkey] =  $array[$oldkey];    
        }

   }
   unset($array[$oldkey]);          
   return $array;   
}


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
function export($customer_name,$customer_phone,$customer_address,$mod_date,$st_dt,$end_dt) { 

        // file name for download 
        $filename = "excel_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false;
        
		
		///////////////////////////////////////// Creation of Array (3 Tables) /////////////////////////////////////////////

		$rest_live_orders = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$_SESSION['restaurant']."'");
		
		if($customer_name!=''){
			$rest_live_orders.= " AND customer_name LIKE '%".$customer_name."%'";
		}
		if($customer_address!=''){
			$rest_live_orders.= " AND customer_address LIKE '%".$customer_address."%'";
		}
		if($customer_phone!=''){
			$rest_live_orders.= " AND customer_phone = '".$customer_phone."'";
		}
		if($mod_date!='')
		{
		  if($mod_date == 'This Week')
		  {
			  $rest_live_orders.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
		  }
		  if($mod_date == 'Last Week')
		  {
			  $rest_live_orders.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
		  }
		  if($mod_date == 'Last Month')
		  {
			$rest_live_orders.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
		  }
		  if($mod_date == 'Last 3 Month')
		  {
			$rest_live_orders.=" AND order_date >= now()-interval 3 month ";
		  }
		  if($mod_date == 'Last 6 Month')
		  {
			$rest_live_orders.=" AND order_date >= now()-interval 6 month ";
		  }
		  if($mod_date == 'Last Year')
		  {
			$rest_live_orders.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
		  }
		  
		   if($mod_date == 'Custom Date')
		  {
			  //$custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
			  //$query_res.=" AND date_format(order_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
			  $start_date = change_dateformat_reverse_db($st_dt);
			  $end_date = change_dateformat_reverse_db($end_dt);
			  $rest_live_orders.=" AND order_date >= '".$start_date." 00:00:00' AND order_date <= '".$end_date." 59:59:59'";
		  }
		}
		
		$query_res = mysql_query($rest_live_orders);
		while($res = mysql_fetch_assoc($query_res)) {
			
			$live_orders[] = $res;
		}
		
		
		$gift_cer = ("SELECT t1.*,t2.* FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 WHERE t1.restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."' AND t1.id = t2.giftcard_id AND t2.restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."'");
		
		if($customer_name!=''){
			$gift_cer.= " AND t1.user_name LIKE '%".$customer_name."%'";
		}
		if($customer_address!=''){
		   $res_filter_address = mysql_query("SELECT id FROM restaurant_customer WHERE address LIKE '%".$customer_address."%' OR city LIKE '%".$customer_address."%' OR state LIKE '%".$customer_address."%' OR zip LIKE '%".$customer_address."%'");
		   
		   $res_address = '';
		   $sep = '';
		   while($res_array_address = mysql_fetch_array($res_filter_address)){
			$res_address = $res_address.$sep.$res_array_address['id'];
			$sep = ',';
		   }
		   
		   $gift_cer.=" AND t1.customer_id IN (".$res_address.") ";   
		}
		if($customer_phone!=''){
		   $res_filter_phone = mysql_query("SELECT id FROM restaurant_customer WHERE phone = '".$customer_phone."' ");
		   
		   $res_phone = '';
		   $sep = '';
		   while($res_array_phone = mysql_fetch_array($res_filter_phone)){
			$res_phone = $res_phone.$sep.$res_array_phone['id'];
			$sep = ',';
		   }
		   
		   $gift_cer.=" AND t1.customer_id IN (".$res_phone.") ";   
		}
		if($mod_date!='')
		{
		  if($mod_date == 'This Week')
		  {
			  $gift_cer.=" AND YEARWEEK(t1.purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
		  }
		  if($mod_date == 'Last Week')
		  {
			  $gift_cer.=" AND YEARWEEK(t1.purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
		  }
		  if($mod_date == 'Last Month')
		  {
			$gift_cer.=" AND date_format(t1.purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
		  }
		  if($mod_date == 'Last 3 Month')
		  {
		
			$gift_cer.=" AND t1.purchase_date >= now()-interval 3 month ";
		  }
		  if($mod_date == 'Last 6 Month')
		  {
			$gift_cer.=" AND t1.purchase_date >= now()-interval 6 month ";
		  }
		  if($mod_date == 'Last Year')
		  {
			$gift_cer.=" AND date_format(t1.purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
		  }
		  
		   if($mod_date == 'Custom Date')
		  {
			  //$custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
			  //$query_res.=" AND date_format(order_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
			  $start_date = change_dateformat_reverse_db($st_dt);
			  $end_date = change_dateformat_reverse_db($end_dt);
			  $gift_cer.=" AND t1.purchase_date >= '".$start_date." 00:00:00' AND t1.purchase_date <= '".$end_date." 59:59:59'";
		  }
		}
		
		
		
		
		$query_res1 = mysql_query($gift_cer);
		while($res1 = mysql_fetch_assoc($query_res1)) {
			$gift_certificate[] = $res1;
			$arr1 = changekeyname($gift_certificate, 'order_date', 'purchase_date');
		}
		
		
		$reservation = ("SELECT * from restaurant_reservations WHERE restaurant_id = '".$_SESSION['restaurant']."' ");
		
		if($customer_name!=''){
			$reservation.= " AND customer_name LIKE '%".$customer_name."%'";
		}
		if($customer_address!=''){
		   $res_filter_address = mysql_query("SELECT id FROM restaurant_customer WHERE address LIKE '%".$customer_address."%' OR city LIKE '%".$customer_address."%' OR state LIKE '%".$customer_address."%' OR zip LIKE '%".$customer_address."%'");
		   
		   $res_address = '';
		   $sep = '';
		   while($res_array_address = mysql_fetch_array($res_filter_address)){
			$res_address = $res_address.$sep.$res_array_address['id'];
			$sep = ',';
		   }
		   
		   $reservation.=" AND customer_id IN (".$res_address.") ";   
		  }
		if($customer_phone!=''){
			$reservation.= " AND customer_phone = '".$_REQUEST['customer_phone']."'";
		}
		if($mod_date!='')
		{
		  if($mod_date == 'This Week')
		  {
			  $reservation.=" AND YEARWEEK(t1.date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
		  }
		  if($mod_date == 'Last Week')
		  {
			  $reservation.=" AND YEARWEEK(t1.date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
		  }
		  if($mod_date == 'Last Month')
		  {
			$reservation.=" AND date_format(t1.date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
		  }
		  if($mod_date == 'Last 3 Month')
		  {
			$reservation.=" AND t1.date >= now()-interval 3 month ";
		  }
		  if($mod_date == 'Last 6 Month')
		  {
			$reservation.=" AND t1.date >= now()-interval 6 month ";
		  }
		  if($mod_date == 'Last Year')
		  {
			$reservation.=" AND date_format(t1.date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
		  }
		  
		   if($mod_date == 'Custom Date')
		  {
			  //$custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
			  //$query_res.=" AND date_format(order_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
			  $start_date = change_dateformat_reverse_db($st_dt);
			  $end_date = change_dateformat_reverse_db($end_dt);
			  $reservation.=" AND t1.date >= '".$start_date." 00:00:00' AND t1.date <= '".$end_date." 59:59:59'";
		  }
		}
		
		$query_res2 = mysql_query($reservation);
		
		while($res2 = mysql_fetch_assoc($query_res2)) {
			$online_reservation[] = $res2;
			$arr2 = changekeyname($online_reservation, 'order_date', 'date');
		}
		
		if(!empty($live_orders) && !empty($arr1)){
			$all_array_final = array_merge($live_orders,$arr1);
		}else if(empty($live_orders)){
			$all_array_final = $arr1;
		}else if(empty($arr1)){
			$all_array_final = $live_orders;
		}
		if(!empty($arr2)){
			$all_array_final = array_merge($all_array_final,$arr2);
		}
		
		usort($all_array_final, date_compare);
		
		$final_array = array_reverse($all_array_final);
		
		/*echo '<pre>';
		print_r($final_array);
		exit;*/


///////////////////////////////////////// End of Creation of Array (3 Tables) /////////////////////////////////////////////

		
		foreach($final_array as $row){ 
			
	        if(!$flag) { 
		        // display field/column names as first row 
		    echo  "DATE"."\t"."ORDER NO"."\t"."ORDER AMOUNT"."\t"."ORDER TYPE"."\t"."RESTAURANT NAME"."\t"."CUSTOMER NAME"."\t"."CUSTOMER ADDRESS"."\t"."CUSTOMER PHONE"."\t"."CONFIRMATION CODE"."\t". "\n"; $flag = true; 
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
			
			//echo $date;exit; 
			//$order_date = date("m-d-Y", strtotime($date));
	        //echo implode("\t", array_values($row)) . "\n"; 
			
			if($row['type_order'] == 'live'){
				$order_id = "OR-00".$row['order_id'];
			}else{
				$order_id = 'N/A';
			}
			
			if($row['type_order'] == 'live'){
				$order_amt = "$ ".$order_amount;
			}else if($row['type_order'] == 'gift'){
				$order_amt = "$ ".$row['price'];
			}else{
				$order_amt = "N/A";
			}
			
			if($row['type_order'] == 'live'){
				//$order_ty = "LIVE ORDERS";
				if($row['type'] == 'pickup'){
					$order_ty = 'Pickup';
				}else{
					$order_ty = 'Delivery';
				}
			}else if($row['type_order'] == 'gift'){
				$order_ty = "GIFT CERTIFICATE";
			}else{
				$order_ty = "ONLINE RESERVATION";
			}
			
			if($row['type_order'] == 'live'){
				$confirmation_code = $row['confirmation_code'];
			}else{
				$confirmation_code = '';
			}
			
			
			$str = $date."\t".$order_id."\t".$order_amt."\t".$order_ty."\t".getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id'])."\t".getNameTable("restaurant_customer","firstname","id",$row['customer_id'])." ".getNameTable("restaurant_customer","lastname","id",$row['customer_id'])."\t".getNameTable("restaurant_customer","address","id",$row['customer_id'])."\t".getNameTable("restaurant_customer","phone","id",$row['customer_id'])."\t".$confirmation_code."\t"."\n";
			echo $str;
        } 
        
}

export($_REQUEST['customer_name'],$_REQUEST['customer_phone'],$_REQUEST['customer_address'],$_REQUEST['mod_date'],$_REQUEST['start_date'],$_REQUEST['end_date']);


?>