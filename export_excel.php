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
        $filename = "excel_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false;
        $result = mysql_query("SELECT * from restaurant_food_order_details  WHERE restaurant_id = '".$_SESSION['restaurant']."' GROUP BY menu_name ");
        while(false !== ($row = mysql_fetch_assoc($result))) { 
			//$sum = "$ ".($row['quantity']*$row['unit_price']);
			$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$row['menu_id']."'"));
			$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$row['customer_id']."'"));
			$sql_order_date = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$row['order_id']."'"));
			
			$sql_quantity = mysql_fetch_array(mysql_query("SELECT SUM(quantity) as qty , SUM(unit_price) as sum_sum FROM  restaurant_food_order_details WHERE menu_id = '".$row['menu_id']."'"));
	        if(!$flag) { 
		        // display field/column names as first row 
		    echo  "MENU NAME"."\t"."QUANTITY"."\t"."PRICE"."\t"."SUM". "\n"; $flag = true; 
	        }         
	        array_walk($row, 'cleanData'); 
	        //echo implode("\t", array_values($row)) . "\n"; 
			
			//$menu_name = str_replace(" ","",$row['menu_name']);
			
			$menu_name = preg_replace("/\s+/", " ", $row['menu_name']);// ltrim($row['menu_name']);//trim($row['menu_name']);;
			
			$str = ltrim($menu_name)."\t".$sql_quantity['qty']."\t"."$ ".$row['unit_price']."\t"."$".$sql_quantity['sum_sum'] ."\t"."\n";
			echo $str;
        } 
}

//if(isset($_REQUEST['export'])) {
        export();
//}
?>

