<?php
ob_start();
session_start();

//include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
//include ("includes/functions.php");
if(!isset($_SESSION['restaurant_admin_panel_id'])){
	header('location:restaurant_admin_login.php');
}

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

$query_res = mysql_query("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$_SESSION['restaurant']."'");

while($res = mysql_fetch_assoc($query_res)) {
	
	$live_orders[] = $res;
}


$query_res1 = mysql_query("SELECT t1.*,t2.* FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 WHERE t1.restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."' AND t1.id = t2.giftcard_id AND t2.restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."'");

while($res1 = mysql_fetch_assoc($query_res1)) {
    $gift_certificate[] = $res1;
	$arr1 = changekeyname($gift_certificate, 'order_date', 'purchase_date');
}


$query_res2 = mysql_query("SELECT * from restaurant_reservations WHERE restaurant_id = '".$_SESSION['restaurant']."' ");


while($res2 = mysql_fetch_assoc($query_res2)) {
    $online_reservation[] = $res2;
	$arr2 = changekeyname($online_reservation, 'order_date', 'date');
}


$all_array = array_merge($live_orders,$arr1);

$all_array_final = array_merge($all_array,$arr2);



usort($all_array_final, date_compare);

$final_array = array_reverse($all_array_final);

echo '<pre>';
print_r($final_array);

?>