<?php
session_start();
include ("lib/conn.php");
// Some html code omitted
function cleanData($str) {
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
        $filename = "users_excel_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false;
        $result = mysql_query("SELECT * from restaurant_customer");
        while(false !== ($row = mysql_fetch_assoc($result))){			
	        if(!$flag) { 
		        // display field/column names as first row 
		    echo  "FIRSTNAME"."\t"."LASTNAME"."\t"."EMAIL"."\t"."ADDRESS"."\t"."PHONE"."\t"."REGISTRATION TIME"."\t"."CITY"."\t"."STATE"."\t"."ZIPCODE"."\t"."DATE OF BIRTH"."\t"."GENDER"."\t"."NO. OF REVIEWS"."\t"."LAST LOGIN TIME"."\t"."STATUS"."\n"; $flag = true;
	        }         
	        array_walk($row, 'cleanData'); 
	        //echo implode("\t", array_values($row)) . "\n"; 
			
			if($row['relationship_status'] == 'single'){
				$relationship_status = 'Single';
			}else if($row['relationship_status'] == 'in_a_relation'){
				$relationship_status = 'In a Relationship';
			}else if($row['relationship_status'] == 'engaged'){
				$relationship_status = 'Engaged';
			}else if($row['relationship_status'] == 'married'){
				$relationship_status = 'Married';
			}else if($row['relationship_status'] == 'widowed'){
				$relationship_status = 'Widowed';
			}else if($row['relationship_status'] == 'separated'){
				$relationship_status = 'Separated';
			}else if($row['relationship_status'] == 'divorced'){
				$relationship_status = 'Divorced';
			}
			
			if($row['status'] == 1){
				$status = 'Active';
			}else{
				$status = 'Inactive';
			}
			
			$str = stripslashes($row['firstname'])."\t".stripslashes($row['lastname'])."\t".$row['email']."\t".$row['address']."\t".$row['phone']."\t".$row['registration_time']."\t".$row['city']."\t".$row['state']."\t".$row['zip']."\t".$row['date_of_birth']."\t".$row['gender']."\t".$row['no_reviews']."\t".$row['last_logged_in']."\t".$status."\t"."\n";
			
			echo $str;
        } 
}
if(isset($_REQUEST['export'])) {
        export();
}
?>

