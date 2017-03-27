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
function export($restaurant_name,$customer_name,$contact_email,$mod_date,$st_dt,$end_dt) { 
        // file name for download 
        $filename = "excel_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false;
        $query_export = "SELECT * from restaurant_reservations where restaurant_id = '".$_SESSION['restaurant']."'";
		
	
		if($restaurant_name !=''){				  
			  $res_all_id = mysql_fetch_array(mysql_query("SELECT restaurant_name FROM restaurant_menu_order WHERE 1"));
			  $res_filter = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_name LIKE '".addslashes($restaurant_name)."%'"));
			  
			  if($res_filter['id'] == '')
			  {
				  $res_filter['id'] = 0;
			  }
		
			  $query_export.=" AND restaurant_id in (".$res_filter['id'].")";
		  }
		  
		  if($customer_name!=''){
			  $query_export.=" AND customer_name LIKE '%".$customer_name."%'";
		  }
		  
		  if($contact_email!=''){
			  $query_export.=" AND contact_email LIKE '%".$contact_email."%'";
		  }
		  
		  if($mod_date!='')
		  {
			  if($mod_date == 'This Week')
			   {
				$query_export.=" AND YEARWEEK(date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
			   }
			   if($mod_date == 'Last Week')
			   {
				$query_export.=" AND YEARWEEK(date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
			   }
			   if($mod_date == 'Last Month')
			   {
				$query_export.=" AND date_format(date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
			   }
			   if($mod_date == 'Last 3 Month')
			   {
				 $query_export.=" AND date >= now()-interval 3 month ";
			   }
			   if($mod_date == 'Last 6 Month')
			   {
				 $query_export.=" AND date >= now()-interval 6 month ";
			   }
			   if($mod_date == 'Last Year')
			   {
				$query_export.=" AND date_format(date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
			   }
			   if($mod_date == 'Custom Date')
			   {
				  $start_date_new = change_dateformat_reverse_db($st_dt);
				  $end_date_new = change_dateformat_reverse_db($end_dt);
				  $query_export.=" AND date >= '".$start_date_new." 00:00:00' AND date <= '".$end_date_new." 59:59:59'";
			   }
		  }
		  
		  $query_export.=" ORDER BY id DESC";

		$result = mysql_query($query_export);
		
		while(false !== ($row = mysql_fetch_assoc($result))) { 
			
	        if(!$flag) { 
		        // display field/column names as first row 
		    echo  "DATE"."\t"."RESTAURANT NAME"."\t"."CUSTOMER NAME"."\t"."CONTACT EMAIL"."\t"."NO OF PEOPLE"."\t"."COMMENTS". "\n"; $flag = true; 
	        }         
	        array_walk($row, 'cleanData'); 
			
			
			$db_date = explode(" ",$row['date']);
			
			//$db_date = date("Y-m-d", strtotime($row['order_date']));
			
			$new_date = change_dateformat_reverse($db_date[0]);
			
			$new_new_date = str_replace("'"," ",$new_date);
			
			$date = str_replace("-","/",$new_new_date);
			//echo $date;exit; 
			//$order_date = date("m-d-Y", strtotime($date));
	        //echo implode("\t", array_values($row)) . "\n"; 
			$str = $date."\t".stripslashes($row['restaurant_name'])."\t".$row['customer_name']."\t".$row['contact_email']."\t".$row['people']."\t".$row['comments']."\t"."\n";
			echo $str;
        } 
        
}


export($_REQUEST['restaurant_name'],$_REQUEST['customer_name'],$_REQUEST['contact_email'],$_REQUEST['mod_date'],$_REQUEST['start_date'],$_REQUEST['end_date']);


?>