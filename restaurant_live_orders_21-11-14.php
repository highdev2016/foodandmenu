<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
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
 
if($_REQUEST['export'] == "Export to Excel")
{
	header("location:export_live_orders_excel.php?&customer_name=".$_REQUEST['customer_name']."&customer_phone=".$_REQUEST['customer_phone']."&customer_address=".$_REQUEST['customer_address']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']);
}

 
 
//rest_chk_authentication();
//print_r($_SESSION);

if($_REQUEST['submit'] == 'SUBMIT' && $_REQUEST['change_status'] == 'Confirmed'){
	$order_id = $_REQUEST['order_id'];
	$sql_cust = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));
	$sql_update = mysql_query("UPDATE restaurant_menu_order SET status = 'Confirmed' WHERE order_id = '".$_REQUEST['order_id']."'");
	$sql_cust_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$sql_cust['customer_id']."'"));
	$sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_owner WHERE id = '".$sql_cust['restaurant_id']."'"));
		
	/* ----------------------------------------------------- Customer Mail ---------------------------------------------------- */
	$date_ordered = date("d-m-Y", strtotime($sql_cust['order_date']));
	$email = $sql_cust_info['email']; //"priya@infosolz.com"
	$name = $sql_cust_info['firstname']." ".$sql_cust_info['lastname'];
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 19"));	
			
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
	$cms_rep=str_replace('%%$date_ordered%%',$date_ordered,$cms_rep);			
				
	$from = 'support@foodandmenu.com';
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	$message=$cms_rep;
	//$subject="Order Status changed";
	$subject = stripslashes($sql_cms['subject']);
	mail($email,$subject,$message,$headers);
	
	/* ----------------------------------------------------- End of Customer Mail ---------------------------------------------------- */
	
	/* ----------------------------------------------------- Restaurant Owner Mail ---------------------------------------------------- */
	$email = $sql_rest_owner['email'];//"priya@infosolz.com"
	
	$res_email = (explode(",",$email));
	
	$name = $sql_rest_owner['name'];
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 20"));	
			
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);				
				
	$from = 'support@foodandmenu.com';
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	$inc = 1;
	foreach($res_email as $val_email){
		if($inc!=1){
			$headers.= "Bcc:".$val_email."\n";
		}
		$inc++;
	}
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	$message=$cms_rep;
	//$subject="Order Status changed";
	$subject = stripslashes($sql_cms['subject']);
	mail($res_email[0],$subject,$message,$headers);
	
	/* ----------------------------------------------------- End of Restaurant Owner Mail ---------------------------------------------------- */
	
	header("location:restaurant_live_orders.php?msg=success");
}
?>
<script type="text/javascript">

function sort_function(sort_by,order_id,customer_name,customer_address,customer_phone,status){
	location.href = 'restaurant_live_orders.php?sort_order='+sort_by+"&order_id="+order_id+"&customer_name="+customer_name+"&customer_address="+customer_address+"&customer_phone="+customer_phone+"&status="+status;
}
</script>
<body>

<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
var $j = jQuery.noConflict();

$j(function() {
  var pickerOpts = {
	changeMonth: true,
	changeYear: true,
    dateFormat:"mm-dd-yy"
}; 
$j( "#start_date" ).datepicker(pickerOpts);
});

$j(function() {
  var pickerOpts = {
	changeMonth: true,
	changeYear: true,
    dateFormat:"mm-dd-yy"
}; 
$j( "#end_date" ).datepicker(pickerOpts);
});

function open_cust_date(val)
{
	if(val == 'Custom Date')
	{
		/*$j("#start_dt1").show(500);
		$j("#start_dt2").show(500);
		$j("#end_dt1").show(500);
		$j("#end_dt2").show(500);*/
		$j("#start_dt1").css('visibility', 'visible');
		$j("#start_dt2").css('visibility', 'visible');
		$j("#end_dt1").css('visibility', 'visible');
		$j("#end_dt2").css('visibility', 'visible');
	}
	else
	{
		/*$j("#start_dt1").hide(500);
		$j("#start_dt2").hide(500);
		$j("#end_dt1").hide(500);
		$j("#end_dt2").hide(500);*/
		$j("#start_dt1").css('visibility', 'hidden');
		$j("#start_dt2").css('visibility', 'hidden');
		$j("#end_dt1").css('visibility', 'hidden');
		$j("#end_dt2").css('visibility', 'hidden');
	}
}

function submit_form()
{
	//alert(123);
	//document.frm.submit();
	//document.getElementById("frm").submit();
	//document.forms["frm"].submit();
	 $j( "#frm" ).submit();
}

</script>

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">

<?php if($_REQUEST['msg'] == 'success'){?>
<p style="text-align:center;">Order status changed successfully.</p>
<?php } ?>

<p style="color:#454EA8; font-size:21px;">Search Panel</p><br>
<form name="frm" id="frm" method="post" action="restaurant_live_orders.php">
<table class="sec-pnl-top">
	<tr>
		<?php /*?><td width="150">Order Id : </td>
		<td width="184"><input type="text" name="order_id" value="<?php echo $_REQUEST['order_id'];?>" style="height:23px;" class="restaurant"></td><?php */?>
		<td width="150">Customer Name : </td>
		<td width="184"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" style="height:23px;" class="restaurant"></td>
		<td width="150">Customer Phone : </td>
		<td width="184"><input type="text" name="customer_phone" value="<?php echo $_REQUEST['customer_phone'];?>" style="height:23px;" class="restaurant"></td>
        <td width="150">Customer Address : </td>
		<td width="184"><input type="text" name="customer_address" value="<?php echo $_REQUEST['customer_address'];?>" style="height:23px;" class="restaurant"></td>
	</tr>
	<tr>
		
		<?php /*?><td  width="150">Status : </td>
		<td  width="184">
			<select name="status" class="restaurant_list">
			<option value="">Select</option>
			<option value="Pending">Pending</option>
			<option value="Confirmed">Confirmed</option>
			</select>
		</td><?php */?>
		<td width="150">Date : </td>
	    <td width="184">
	    	<select class="restaurant" name="mod_date" id="mod_date" onChange="open_cust_date(this.value);">
		        <option value="">---SELECT---</option>
		        <option value="This Week"<?php if($_REQUEST['mod_date'] == 'This Week') { ?> selected <?php } ?>>This Week</option>
                <option value="Last Week"<?php if($_REQUEST['mod_date'] == 'Last Week') { ?> selected <?php } ?>>Last Week</option>
		        <option value="Last Month"<?php if($_REQUEST['mod_date'] == 'Last Month') { ?> selected <?php } ?>>Last Month</option>
                <option value="Last 3 Month"<?php if($_REQUEST['mod_date'] == 'Last 3 Month') { ?> selected <?php } ?>>Last 3 Month</option>
                <option value="Last 6 Month"<?php if($_REQUEST['mod_date'] == 'Last 6 Month') { ?> selected <?php } ?>>Last 6 Month</option>
                <option value="Last Year"<?php if($_REQUEST['mod_date'] == 'Last Year') { ?> selected <?php } ?>>Last Year</option>
		        
		        <option value="Custom Date"<?php if($_REQUEST['mod_date'] == 'Custom Date') { ?> selected <?php } ?>>Custom Date</option>
	        </select>
	    </td>
	</tr>
	<tr>
		<?php
        if($_REQUEST['mod_date'] == 'Custom Date')
        {
            $display = 'visible';
        }
        else
        {
            $display = 'hidden';
        }
        ?>
        
        <td  width="184"><div id="start_dt1" style="visibility:<?php echo $display; ?>;"> Start Date : </div></td>	
		<td  width="184" id="start_dt2" style="visibility:<?php echo $display; ?>">
			<input type="text" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date']; ?>" readonly>
		</td>
        <td  width="184"><div id="end_dt1" style="visibility:<?php echo $display; ?>;">End Date : </div></td>	
		<td  width="184" id="end_dt2" style="visibility:<?php echo $display; ?>">
			<input type="text" name="end_date" id="end_date" value="<?php echo $_REQUEST['end_date']; ?>" readonly>
		</td>
        		
	    <td colspan="2">
	    	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">&nbsp;&nbsp;
            <a href="restaurant_live_orders.php" class="button4" style="margin:0px; text-decoration:none; padding:5px 12px;">Show All</a>&nbsp;&nbsp;
            <input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0 0 0 3px;">
	    </td>
        
	</tr>
</table>


</form>

<form name="frm1" id="frm1" method="post" action="restaurant_live_orders.php">
<div align="right" class="sort">
Items Per Page : 
<select  name="item_per_page" id="item_per_page" onChange="frm1.submit();">
<option value="25"<?php if($_REQUEST['item_per_page'] == 25) { ?> selected <?php } ?>>25</option>
<option value="50"<?php if($_REQUEST['item_per_page'] == 50) { ?> selected <?php } ?>>50</option>
<option value="75"<?php if($_REQUEST['item_per_page'] == 75) { ?> selected <?php } ?>>75</option>
<option value="100"<?php if($_REQUEST['item_per_page'] == 100) { ?> selected <?php } ?>>100</option>
</select>
</div>

</form>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="4%" class="all_restaurant">Sl No.</td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_date','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Date</a></td>
    <td width="14%" class="all_restaurant">Order Type</td>
    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_id','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Order Id</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Name</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_address','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Address</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_phone','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Phone</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('price_with_del_charge','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Amount</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('status','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Status</a></td>
    <td width="14%" class="all_restaurant"></td>
  </tr>
  <?php 
  $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant_admin_panel_id']."'"));
  $_SESSION['restaurant'] = $sql_restaurant['id'];
  $today = date('Y-m-d');


///////////////////////////////////////// Creation of Array (3 Tables) /////////////////////////////////////////////

$rest_live_orders = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$_SESSION['restaurant']."'");

if($_REQUEST['customer_name']!=''){
	$rest_live_orders.= " AND customer_name LIKE '%".$_REQUEST['customer_name']."%'";
}
if($_REQUEST['customer_address']!=''){
	$rest_live_orders.= " AND customer_address LIKE '%".$_REQUEST['customer_address']."%'";
}
if($_REQUEST['customer_phone']!=''){
  	$rest_live_orders.= " AND customer_phone = '".$_REQUEST['customer_phone']."'";
}
if($_REQUEST['mod_date']!='')
{
  if($_REQUEST['mod_date'] == 'This Week')
  {
	  $rest_live_orders.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
  }
  if($_REQUEST['mod_date'] == 'Last Week')
  {
	  $rest_live_orders.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
  }
  if($_REQUEST['mod_date'] == 'Last Month')
  {
	$rest_live_orders.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
  }
  if($_REQUEST['mod_date'] == 'Last 3 Month')
  {
	$rest_live_orders.=" AND order_date >= now()-interval 3 month ";
  }
  if($_REQUEST['mod_date'] == 'Last 6 Month')
  {
	$rest_live_orders.=" AND order_date >= now()-interval 6 month ";
  }
  if($_REQUEST['mod_date'] == 'Last Year')
  {
	$rest_live_orders.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
  }
  
   if($_REQUEST['mod_date'] == 'Custom Date')
  {
	  //$custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
	  //$query_res.=" AND date_format(order_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
	  $start_date = change_dateformat_reverse_db($_REQUEST['start_date']);
	  $end_date = change_dateformat_reverse_db($_REQUEST['end_date']);
	  $rest_live_orders.=" AND order_date >= '".$start_date." 00:00:00' AND order_date <= '".$end_date." 59:59:59'";
  }
}

$query_res = mysql_query($rest_live_orders);
while($res = mysql_fetch_assoc($query_res)) {
	
	$live_orders[] = $res;
}


$gift_cer = ("SELECT t1.*,t2.* FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 WHERE t1.restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."' AND t1.id = t2.giftcard_id AND t2.restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."'");

if($_REQUEST['customer_name']!=''){
	$gift_cer.= " AND t1.user_name LIKE '%".$_REQUEST['customer_name']."%'";
}
if($_REQUEST['customer_address']!=''){
   $res_filter_address = mysql_query("SELECT id FROM restaurant_customer WHERE address LIKE '%".$_REQUEST['customer_address']."%' OR city LIKE '%".$_REQUEST['customer_address']."%' OR state LIKE '%".$_REQUEST['customer_address']."%' OR zip LIKE '%".$_REQUEST['customer_address']."%'");
   
   $res_address = '';
   $sep = '';
   while($res_array_address = mysql_fetch_array($res_filter_address)){
    $res_address = $res_address.$sep.$res_array_address['id'];
    $sep = ',';
   }
   
   $gift_cer.=" AND t1.customer_id IN (".$res_address.") ";   
}
if($_REQUEST['customer_phone']!=''){
   $res_filter_phone = mysql_query("SELECT id FROM restaurant_customer WHERE phone = '".$_REQUEST['customer_phone']."' ");
   
   $res_phone = '';
   $sep = '';
   while($res_array_phone = mysql_fetch_array($res_filter_phone)){
    $res_phone = $res_phone.$sep.$res_array_phone['id'];
    $sep = ',';
   }
   
   $gift_cer.=" AND t1.customer_id IN (".$res_phone.") ";   
}
if($_REQUEST['mod_date']!='')
{
  if($_REQUEST['mod_date'] == 'This Week')
  {
	  $gift_cer.=" AND YEARWEEK(t1.purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
  }
  if($_REQUEST['mod_date'] == 'Last Week')
  {
	  $gift_cer.=" AND YEARWEEK(t1.purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
  }
  if($_REQUEST['mod_date'] == 'Last Month')
  {
	$gift_cer.=" AND date_format(t1.purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
  }
  if($_REQUEST['mod_date'] == 'Last 3 Month')
  {
	$gift_cer.=" AND t1.purchase_date >= now()-interval 3 month ";
  }
  if($_REQUEST['mod_date'] == 'Last 6 Month')
  {
	$gift_cer.=" AND t1.purchase_date >= now()-interval 6 month ";
  }
  if($_REQUEST['mod_date'] == 'Last Year')
  {
	$gift_cer.=" AND date_format(t1.purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
  }
  
   if($_REQUEST['mod_date'] == 'Custom Date')
  {
	  //$custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
	  //$query_res.=" AND date_format(order_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
	  $start_date = change_dateformat_reverse_db($_REQUEST['start_date']);
	  $end_date = change_dateformat_reverse_db($_REQUEST['end_date']);
	  $gift_cer.=" AND t1.purchase_date >= '".$start_date." 00:00:00' AND t1.purchase_date <= '".$end_date." 59:59:59'";
  }
}




$query_res1 = mysql_query($gift_cer);
while($res1 = mysql_fetch_assoc($query_res1)) {
    $gift_certificate[] = $res1;
	$arr1 = changekeyname($gift_certificate, 'order_date', 'purchase_date');
}


$reservation = ("SELECT * from restaurant_reservations WHERE restaurant_id = '".$_SESSION['restaurant']."' ");

if($_REQUEST['customer_name']!=''){
	$reservation.= " AND customer_name LIKE '%".$_REQUEST['customer_name']."%'";
}
if($_REQUEST['customer_address']!=''){
   $res_filter_address = mysql_query("SELECT id FROM restaurant_customer WHERE address LIKE '%".$_REQUEST['customer_address']."%' OR city LIKE '%".$_REQUEST['customer_address']."%' OR state LIKE '%".$_REQUEST['customer_address']."%' OR zip LIKE '%".$_REQUEST['customer_address']."%'");
   
   $res_address = '';
   $sep = '';
   while($res_array_address = mysql_fetch_array($res_filter_address)){
    $res_address = $res_address.$sep.$res_array_address['id'];
    $sep = ',';
   }
   
   $reservation.=" AND customer_id IN (".$res_address.") ";   
  }
if($_REQUEST['customer_phone']!=''){
  	$reservation.= " AND customer_phone = '".$_REQUEST['customer_phone']."'";
}
if($_REQUEST['mod_date']!='')
{
  if($_REQUEST['mod_date'] == 'This Week')
  {
	  $reservation.=" AND YEARWEEK(t1.date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
  }
  if($_REQUEST['mod_date'] == 'Last Week')
  {
	  $reservation.=" AND YEARWEEK(t1.date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
  }
  if($_REQUEST['mod_date'] == 'Last Month')
  {
	$reservation.=" AND date_format(t1.date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
  }
  if($_REQUEST['mod_date'] == 'Last 3 Month')
  {
	$reservation.=" AND t1.date >= now()-interval 3 month ";
  }
  if($_REQUEST['mod_date'] == 'Last 6 Month')
  {
	$reservation.=" AND t1.date >= now()-interval 6 month ";
  }
  if($_REQUEST['mod_date'] == 'Last Year')
  {
	$reservation.=" AND date_format(t1.date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
  }
  
   if($_REQUEST['mod_date'] == 'Custom Date')
  {
	  //$custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
	  //$query_res.=" AND date_format(order_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
	  $start_date = change_dateformat_reverse_db($_REQUEST['start_date']);
	  $end_date = change_dateformat_reverse_db($_REQUEST['end_date']);
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

  $query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$_SESSION['restaurant']."' ");
  //$query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '1194'");
  $order_id = substr($_REQUEST['order_id'],5);
  if($_REQUEST['order_id']!=''){
	  $query_res.=" AND order_id = '".$order_id."'";
  }
  if($_REQUEST['customer_name']!=''){
	  $query_res.=" AND customer_name LIKE '%".$_REQUEST['customer_name']."%'";
  }
  if($_REQUEST['customer_address']!=''){
	  $query_res.=" AND customer_address LIKE '%".$_REQUEST['customer_address']."%'";
  }
  if($_REQUEST['customer_phone']!=''){
	  $query_res.=" AND customer_phone = '".$_REQUEST['customer_phone']."'";
  }
  if($_REQUEST['status']!=''){
	  $query_res.=" AND status = '".$_REQUEST['status']."'";
  }
  if($_REQUEST['mod_date']!='')
  {
	  if($_REQUEST['mod_date'] == 'This Week')
	  {
		  $query_res.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
	  }
	  if($_REQUEST['mod_date'] == 'Last Week')
	  {
		  $query_res.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
	  }
	  if($_REQUEST['mod_date'] == 'Last Month')
	  {
	  	$query_res.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
	  }
	  if($_REQUEST['mod_date'] == 'Last 3 Month')
	  {
	  	$query_res.=" AND order_date >= now()-interval 3 month ";
	  }
	  if($_REQUEST['mod_date'] == 'Last 6 Month')
	  {
	  	$query_res.=" AND order_date >= now()-interval 6 month ";
	  }
	  if($_REQUEST['mod_date'] == 'Last Year')
	  {
	  	$query_res.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
	  }
	  
	   if($_REQUEST['mod_date'] == 'Custom Date')
	  {
		  //$custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
		  //$query_res.=" AND date_format(order_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
		  $start_date = change_dateformat_reverse_db($_REQUEST['start_date']);
		  $end_date = change_dateformat_reverse_db($_REQUEST['end_date']);
		  $query_res.=" AND order_date >= '".$start_date." 00:00:00' AND order_date <= '".$end_date." 59:59:59'";
	  }
  }

  if($_REQUEST['sort_order']){
	  $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
  }else{
	  $query_res.=" ORDER BY order_id DESC ";
  }
  
  //echo $query_res;
  
  $sql_order = mysql_query($query_res);
  if(mysql_num_rows($sql_order)>0){
	  
		//////////////////////start pagination/////////////////////////
		if($_REQUEST['search']!="")
		{
			$page=1;
		}
		else
		{
			$page=$_REQUEST['page'];
			
			if($_REQUEST['page']=="") 
			{ 
			$page = 1; 
			} 
		}
		if($_REQUEST['item_per_page'] == "")
		{
			$max_results = 25; 
		}
		else
		{
			$max_results = $_REQUEST['item_per_page'];
		} 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sql_order); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = '';
		$page_num = 1;
		
		if(isset($_GET['page'])){$page_num = $_GET['page'];}
		
		$offset = $page_num; 
		
		if($page_num == 0) {$page_num = 1;} 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$prev&mod_date=".$_REQUEST['mod_date']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_phone=".$_REQUEST['customer_phone']."&customer_address=".$_REQUEST['customer_address']."&status=".$_REQUEST['status']."&cust_date=".$_REQUEST['cust_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		for($i = 1; $i <=$total_pages; $i++) 
		{ 
		if(($page) == $i) 
		{ 
		$pagination .= $i; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		else 
		{ 
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$i&mod_date=".$_REQUEST['mod_date']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_phone=".$_REQUEST['customer_phone']."&customer_address=".$_REQUEST['customer_address']."&status=".$_REQUEST['status']."&cust_date=".$_REQUEST['cust_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$next&mod_date=".$_REQUEST['mod_date']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_phone=".$_REQUEST['customer_phone']."&customer_address=".$_REQUEST['customer_address']."&status=".$_REQUEST['status']."&cust_date=".$_REQUEST['cust_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
		if($_REQUEST['page']!="")
		{
			$j=($_REQUEST['page']-1)*$max_results;
		}
		if($_REQUEST['search']!="")
		{
		$j=0;	
		}
	  ?>	
  
  <?php $inc = 1;
  foreach($final_array as $array_order){
  $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$array_order['customer_id']."'"));
  ?>
  <tr>
  	<td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_order['order_date']));?></td>
    <td class="all_restaurant2"><?php 
	
	if($array_order['type_order'] == 'live')
	{
		echo "Live Order";
	}
	elseif($array_order['type_order'] == 'gift')
	{
		echo "Gift Certificate";
	}
	elseif($array_order['type_order'] == 'reservation')
	{
		echo "Online reservation";
	}
	?></td>
    <td class="all_restaurant2"><?php 
	if($array_order['type_order'] == 'live')
	{
		echo "OR-00".$array_order['order_id'];
	}
	elseif($array_order['type_order'] == 'gift')
	{
		echo "N/A";
	}
	elseif($array_order['type_order'] == 'reservation')
	{
		echo "N/A";
	}
	?></td>
    <td class="all_restaurant2"><?php echo $sql_customer['firstname']." ".$sql_customer['lastname'];?></td>
    <td class="all_restaurant2"><?php echo $sql_customer['address']."<br>";
	echo $sql_customer['city'];?>&nbsp;&nbsp;<?php echo $sql_customer['state'];?>&nbsp;&nbsp;<?php echo $sql_customer['zip']; ?></td>
    <td class="all_restaurant2"><?php echo $sql_customer['phone'];?></td>
    <td class="all_restaurant2"><?php 
	if($array_order['type_order'] == 'live')
	{
		echo "$ ".($array_order['price_with_del_charge']);
	}
	elseif($array_order['type_order'] == 'gift')
	{
		echo "$ ".($array_order['price']);
	}
	elseif($array_order['type_order'] == 'reservation')
	{
		echo "N/A";
	}
	
	
	?></td>
    <td class="all_restaurant2"><?php if($array_order['type_order'] == 'reservation') { echo "N/A"; } else { echo $array_order['status']; };?>
    <?php if($array_order['status'] == 'Pending' && $array_order['type_order'] == 'live'){ ?>
	<span style="float:right;"><a class="various1" href="#inline<?php echo $array_order['order_id'];?>" title="Edit" style="color:#686868;">EDIT</a></span>
	<?php }?>
    </td>
    
    <td class="all_restaurant2"><a class="various1" href="#inline_<?php echo $inc;?>" title="View" style="color:#686868;">View</a></td>
    
  </tr>
  
<div style="display: none;">
    <div id="inline<?php echo $array_order['order_id'];?>" style="width:500px;height:250px;overflow:auto;">
        <div class="profle_wrapper">
            <div style="width:450px;">
            <h1 style="color:#2B4494;">Change Order Status</h1>
            <form name="frm_change_status" method="post" action="">
            <input type="hidden" name="order_id" id="order_id" value="<?php echo $array_order['order_id'];?>">
            <p><b>Status : </b><select name="change_status" id="change_status" class="restaurant_list">
            <option value="Pending" <?php if($array_order['status'] == 'Pending'){?> selected = "selected" <?php } ?>>Pending</option>
            <option value="Confirmed" <?php if($array_order['status'] == 'Confirmed'){?> selected = "selected" <?php } ?>>Confirmed</option>
            </select></p>
            <input type="submit" name="submit" value="SUBMIT" class="button4">
            </form>
            </div>
        </div>
    </div>
</div>

<?php $sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$array_order['order_id']."'"));?>  
<div style="display: none;">
    <div id="inline_<?php echo $inc;?>" style="width:500px;height:300px;overflow:auto;">
        <div class="profle_wrapper">
            <div style="width:450px;">
            <?php
			if($array_order['type_order'] == 'live')
			{
			?>
                <h1 style="color:#2B4494;">Order Details</h1>
               	<p style="padding-bottom:5px;"><b>Order No. : </b><?php echo "OR-00".$array_order['order_id'];?></p>
                <p style="padding-bottom:5px;"><b>Order Amount : </b><?php echo "$ ".($array_order['price_with_del_charge']); ?></p>
                <p style="padding-bottom:5px;"><b>Customer Name : </b><?php echo $sql_customer['firstname']." ".$sql_customer['lastname']; ?></p>
                <p style="padding-bottom:5px;"><b>Contact Details : </b><?php echo $sql_contact_details['address']."<br>";
				echo $sql_contact_details['city']." ".$sql_contact_details['state']." ".$sql_contact_details['zipcode']; ?></p>
                <p style="padding-bottom:5px;"><b>Phone No. : </b><?php echo $sql_contact_details['phone']; ?></p>
                <p style="padding-bottom:5px;"><b>Menu Items ----- </b><br>
				<?php $sql_items_ordered = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$array_order['order_id']."'");
				$i=1;
				while($array_items_ordered = mysql_fetch_array($sql_items_ordered)){
					$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_items_ordered['menu_id']."'"));
					echo $i.") ".$sql_menu['menu_name']."<br>";
					$i++;
					} ?></p>
                <p style="padding-bottom:5px;"><b>Order Type : </b><?php if($array_order['type'] == 'pickup'){ echo "Pick up"; }
				else { echo "Delivery"; } ?></p>
                
                 <p style="padding-bottom:5px;"><b>Payment Mode : </b><?php if($array_order['payment_mode'] == 'cash'){ echo "Cash"; }
				else { echo "Credit Card"; } ?></p>
                
                <?php if($sql_contact_details['special_ins']!=''){?>
                <p style="padding-bottom:5px;"><b>Special Instructions : </b><?php echo $sql_contact_details['special_ins']; ?></p>
                <?php
				 } 
			}
			elseif($array_order['type_order'] == 'gift')
			{
			?>
                <h1 style="color:#2B4494;">Gift Certificate</h1>
                <p style="padding-bottom:5px;"><b>Certificate No. : </b><?php echo $array_order['certificate_no'];?></p>
                <p style="padding-bottom:5px;"><b>Username : </b><?php echo $array_order['user_name']; ?></p>
                <p style="padding-bottom:5px;"><b>Deal : </b><?php echo $array_order['deal']; ?></p>
                <p style="padding-bottom:5px;"><b>Expiry Date : </b><?php echo date('m-d-Y', strtotime($array_order['expiry_date'])); ?></p>
                 <p style="padding-bottom:5px;"><b>Customer Email : </b><?php echo $array_order['email']; ?></p>
                 <p style="padding-bottom:5px;"><b>Used Status : </b><?php if($array_order['used'] == 0) { echo "Not Used"; } else { echo "Used"; } ?></p>
                 <p style="padding-bottom:5px;"><b>Confirm Status : </b><?php echo $array_order['confirm_status']; ?></p>
                
            <?php
			}
            elseif($array_order['type_order'] == 'reservation')
			{
			?>
                <h1 style="color:#2B4494;">Online Reservation Details</h1>
                <p style="padding-bottom:5px;"><b>Restaurant Name : </b><?php echo $array_order['restaurant_name'];?></p>
                <p style="padding-bottom:5px;"><b>Customer Name : </b><?php echo $array_order['customer_name']; ?></p>
                <p style="padding-bottom:5px;"><b>Contact Email : </b><?php echo $array_order['contact_email']; ?></p>
                <p style="padding-bottom:5px;"><b>No. of People : </b><?php echo $array_order['people']; ?></p>
                 <p style="padding-bottom:5px;"><b>Comments : </b><?php echo htmlspecialchars_decode($array_order['comments']); ?></p>
                 <p style="padding-bottom:5px;"><b>Special Occasions : </b><?php if($array_order['special_occassion'] != '') {echo $array_order['special_occassion']; } else { echo "N/A"; }?></p>
                 <p style="padding-bottom:5px;"><b>Date : </b><?php echo date('m-d-Y', strtotime($array_order['order_date'])); ?></p>
                 <p style="padding-bottom:5px;"><b>Time : </b><?php echo $array_order['time']; ?></p>
                
            <?php
			}
			?>
            </div>
        </div>
    </div>
</div>
  <?php $inc++; } } else { ?>
  <tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No Live orders</td>
  </tr>
  <?php } ?>
</table>

<?php if ($total_pages > '1' ) {

            $range =5; //set this to what ever range you want to show in the pagination link
            $range_min = ($range % 2 == 0) ? ($range / 2) - 1 : ($range - 1) / 2;
            $range_max = ($range % 2 == 0) ? $range_min + 1 : $range_min;
            $page_min = $page_num- $range_min;
            $page_max = $page_num+ $range_max;

            $page_min = ($page_min < 1) ? 1 : $page_min;
            $page_max = ($page_max < ($page_min + $range - 1)) ? $page_min + $range - 1 : $page_max;
            if ($page_max > $total_pages) {
                $page_min = ($page_min > 1) ? $total_pages - $range + 1 : 1;
                $page_max = $total_pages;
            }

            $page_min = ($page_min < 1) ? 1 : $page_min;

            //$page_content .= '<p class="menuPage">';

            

            if ($page_num != 1) {
                $page_pagination .= "<a href=\"restaurant_live_orders.php?page=$prev&mod_date=".$_REQUEST['mod_date']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_phone=".$_REQUEST['customer_phone']."&customer_address=".$_REQUEST['customer_address']."&status=".$_REQUEST['status']."&cust_date=".$_REQUEST['cust_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Previous</a>";
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
            }

            for ($i = $page_min;$i <= $page_max;$i++) {
                if ($i == $page_num){
                $page_pagination .= $i; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
                else{
                $page_pagination.= "<a href=\"restaurant_live_orders.php?page=$i&mod_date=".$_REQUEST['mod_date']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_phone=".$_REQUEST['customer_phone']."&customer_address=".$_REQUEST['customer_address']."&status=".$_REQUEST['status']."&cust_date=".$_REQUEST['cust_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination\">$i</a>";
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
            }

            if ($page_num < $total_pages) {
                $page_pagination.= "<a href=\"restaurant_live_orders.php?page=$next&mod_date=".$_REQUEST['mod_date']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_phone=".$_REQUEST['customer_phone']."&customer_address=".$_REQUEST['customer_address']."&status=".$_REQUEST['status']."&cust_date=".$_REQUEST['cust_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Next</a>";
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
            }

        ?>
<div style="text-align:center; margin-top:10px;"><?php echo $page_pagination; ?></div><?php } ?>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

