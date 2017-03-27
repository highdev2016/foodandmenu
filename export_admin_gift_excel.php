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
function export($restaurant_name,$certificate_no,$validation_code,$mod_date,$strt_dt,$end_dt,$restaurant_state,$restaurant_city) { 
        // file name for download 
        $filename = "excel_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false;
        $query_export = "SELECT t1.*,t2.* FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 WHERE t1.id = t2.giftcard_id";
		
		
		
		if($restaurant_state!=''){
			$query_res.= " AND state = '".$restaurant_state."' ";
		}
		
		if($restaurant_city!=''){
			$query_res.= " AND city = '".$restaurant_city."' ";
		}
		
		if($_REQUEST['restaurant_name']!=''){
		    $query_res.= " AND restaurant_id = '".$_REQUEST['restaurant_name']."' ";  
		}
		  
		if($certificate_no!=''){
			$query_export.=  " AND certificate_no = '".$certificate_no."'";
		}
		if($validation_code!=''){
			$query_export.=  " AND validation_code = '".$validation_code."'";
		}
		  
		  if($mod_date!='')
		  {
			  if($mod_date == 'This Week')
			   {
				$query_export.=" AND YEARWEEK(purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
			   }
			   if($mod_date == 'Last Week')
			   {
				$query_export.=" AND YEARWEEK(purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
			   }
			   if($mod_date == 'Last Month')
			   {
				$query_export.=" AND date_format(purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
			   }
			   if($mod_date == 'Last 3 Month')
			   {
				 $query_export.=" AND purchase_date >= now()-interval 3 month ";
			   }
			   if($mod_date == 'Last 6 Month')
			   {
				 $query_export.=" AND purchase_date >= now()-interval 6 month ";
			   }
			   if($mod_date == 'Last Year')
			   {
				$query_export.=" AND date_format(purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
			   }
			   if($mod_date == 'Custom Date')
			   {
				  $start_date = change_dateformat_reverse_db($strt_dt);
		  		  $end_date = change_dateformat_reverse_db($end_dt);
		  		  $query_export.=" AND purchase_date >= '".$start_date." 00:00:00' AND purchase_date <= '".$end_date." 59:59:59'";
			   }
		  }
		  
		$query_export.=" ORDER BY t2.id DESC";
		
		$result = mysql_query($query_export);
		
		while(false !== ($row = mysql_fetch_assoc($result))) { 
			
	        if(!$flag) { 
		        // display field/column names as first row 
		    echo  "PURCHASE DATE"."\t"."CERTIFICATE NO"."\t"."USERNAME."."\t"."RESTAURANT NAME"."\t"."DEAL"."\t"."AMOUNT"."\t"."VALIDATION CODE"."\t"."EXPIRY DATE". "\n"; $flag = true; 
	        }         
	        array_walk($row, 'cleanData'); 
			
			
			
			$db_date = explode(" ",$row['purchase_date']);
			
			//$db_date = date("Y-m-d", strtotime($row['order_date']));
			
			$new_date = change_dateformat_reverse($db_date[0]);
			
			$new_new_date = str_replace("'"," ",$new_date);
			
			$date = str_replace("-","/",$new_new_date);
			
			
			$db_date1 = explode(" ",$row['expiry_date']);
			
			//$db_date = date("Y-m-d", strtotime($row['order_date']));
			
			$new_date1 = change_dateformat_reverse($db_date1[0]);
			
			$new_new_date1 = str_replace("'"," ",$new_date1);
			
			$date1 = str_replace("-","/",$new_new_date1);
			
			$amount = str_replace("'"," ",$row['price']);
			
			$certificate_no_excel = str_replace("'"," ",$row['certificate_no']);
			//echo $date;exit; 
			//$order_date = date("m-d-Y", strtotime($date));
	        //echo implode("\t", array_values($row)) . "\n"; 
			$str = $date."\t".$certificate_no_excel."\t".stripslashes($row['user_name'])."\t".$row['restaurant_name']."\t".$row['deal']."\t"."$ ".$amount."\t".$row['validation_code']."\t".$date1."\t"."\n";
			echo $str;
        } 
        
}


export($_REQUEST['restaurant_name'],$_REQUEST['certificate_no'],$_REQUEST['validation_code'],$_REQUEST['mod_date'],$_REQUEST['start_date'],$_REQUEST['end_date'],$_REQUEST['restaurant_state'],$_REQUEST['restaurant_city']);


?>