<?php
session_start();
include ("admin/lib/conn.php");
// Some html code omitted
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
function export() {
        // file name for download 
        $filename = "restaurant_excel_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false;
        $result = mysql_query("SELECT * from restaurant_basic_info  WHERE status = '1'");
        while(false !== ($row = mysql_fetch_assoc($result))){
	        if(!$flag) { 
		        // display field/column names as first row 
		    echo  "NAME"."\t"."PHONE"."\t"."FAX"."\t"."EMAIL"."\t"."WEBSITE"."\t"."RESTAURANT NAME"."\t"."RESTAURANT ADDRESS"."\t"."RESTAURANT CITY"."\t"."RESTAURANT STATE"."\t"."RESTAURANT ZIPCODE"."\t"."RESTAURANT COUNTRY"."\t"."RESTAURANT CATEGORY"."\t"."LATITUDE"."\t"."LONGITUDE". "\n"; $flag = true; 
	        }         
	        array_walk($row, 'cleanData'); 
	        //echo implode("\t", array_values($row)) . "\n"; 
			$str = stripslashes($row['name'])."\t".$row['phone']."\t".$row['fax']."\t".$row['email']."\t".$row['website']."\t".$row['restaurant_name']."\t"." ".$row['restaurant_address']."\t".$row['restaurant_city']."\t".$row['restaurant_state']."\t".$row['restaurant_zipcode']."\t".$row['restaurant_country']."\t".$row['restaurant_category_name']."\t".$row['latitude']."\t".$row['longitude']."\t"."\n";
			echo $str;
        } 
}
if(isset($_REQUEST['export'])) {
        export();
}
?>

