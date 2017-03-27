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
	$sql_update = mysql_query("UPDATE restaurant_menu_order SET status = 'Confirmed' , time = '".$_REQUEST['time_del_pickup']."' WHERE order_id = '".$_REQUEST['order_id']."'");
	$sql_cust_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$sql_cust['customer_id']."'"));
	$sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_owner WHERE id = '".$sql_cust['restaurant_id']."'"));
		
	/* ----------------------------------------------------- Customer Mail ---------------------------------------------------- */
	if($sql_cust['order_date'] = "del")
	{
		$order_type_mail = "Delivery";
	}
	else
	{
		$order_type_mail = "Pickup";
	}
	$date_ordered = date("d-m-Y", strtotime($sql_cust['order_date']));
	$email = $sql_cust_info['email']; //"priya@infosolz.com"
	$name = $sql_cust_info['firstname']." ".$sql_cust_info['lastname'];
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 19"));	
			
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
	$cms_rep=str_replace('%%$date_ordered%%',$date_ordered,$cms_rep);
	$cms_rep=str_replace('%%$order_type%%',$order_type_mail,$cms_rep);
	$cms_rep=str_replace('%%$time%%',$_REQUEST['time_del_pickup'],$cms_rep);			
				
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
	$cms_rep=str_replace('%%$order_type%%',$order_type_mail,$cms_rep);
	$cms_rep=str_replace('%%$time%%',$_REQUEST['time_del_pickup'],$cms_rep);				
				
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

<style type="text/css">

#fancybox-title{
	width:100% !important;
	padding:0;
}

#fancybox-content div{
	width:100% !important;
	margin:0 !important;
}

#fancybox-content{
	width:100% !important;
}

#fancybox-content #printdiv div{
	width:100% !important;
}

#fancybox-content #printdiv div table{
	width:100%;
}

#fancybox-content div h1{
	margin:0 !important;
}

</style>

<body>

<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont restu_live_cont">
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

function get_sel_time(time_value,id,a_id)
{
	var $j = jQuery.noConflict();
	
	for(i=1;i<13;i++)
	{
		$j("#sel"+i+"_"+id).removeClass('selected_cls');
	}
	$j("#sel"+a_id+"_"+id).addClass('selected_cls');
	$j("#time_del_pickup"+id).val(time_value);
}

function open_time_div(val,id)
{
	var $j = jQuery.noConflict();
	
	if(val == "Confirmed")
	{
		$j("#time_div_del"+id).show(1000);
	}
	else
	{	
		$j("#time_div_del"+id).hide(1000);
	}
}

function check_validation(id)
{
	var time_val = $j("#time_del_pickup"+id).val();
	
	if(time_val == "")
	{
		alert("Please select a Time to Confirm Order.");
		return false;
	}
	
}

</script>

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">

<?php if($_REQUEST['msg'] == 'success'){?>
<p style="text-align:center;">Order status changed successfully.</p>
<?php } ?>

<p style="color:#454EA8; font-size:21px;">Search Panel</p><br>
<form name="frm" id="frm" method="post" action="restaurant_live_orders.php">
<table class="sec-pnl-top" width="100%">
	<tr>
		<?php /*?><td width="150">Order Id : </td>
		<td width="184"><input type="text" name="order_id" value="<?php echo $_REQUEST['order_id'];?>" style="height:23px;" class="restaurant"></td><?php */?>
		<td width="16%" class="all_restaurant">Customer Name : </td>
		<td width="18%"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" style="height:23px;" class="restaurant"></td>
		<td width="15%" class="all_restaurant">Customer Phone : </td>
		<td width="16%"><input type="text" name="customer_phone" value="<?php echo $_REQUEST['customer_phone'];?>" style="height:23px;" class="restaurant"></td>
        <td width="17%" class="all_restaurant">Customer Address : </td>
		<td width="18%"><input type="text" name="customer_address" value="<?php echo $_REQUEST['customer_address'];?>" style="height:23px;" class="restaurant"></td>
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
		<td class="all_restaurant">Date : </td>
	    <td>
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
        
        <td><div id="start_dt1" style="visibility:<?php echo $display; ?>;"> Start Date : </div></td>	
		<td id="start_dt2" style="visibility:<?php echo $display; ?>">
			<input type="text" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date']; ?>" readonly>
		</td>
        <td><div id="end_dt1" style="visibility:<?php echo $display; ?>;">End Date : </div></td>	
		<td id="end_dt2" style="visibility:<?php echo $display; ?>">
			<input type="text" name="end_date" id="end_date" value="<?php echo $_REQUEST['end_date']; ?>" readonly>
		</td>
    </tr>
	<tr>		
		 
	    <td colspan="6" class="live_submit_area">
        	<div class="live_submit_sec">
	    	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">&nbsp;&nbsp;
            <a href="restaurant_live_orders.php" class="button4" style="margin:0 7px 0 10px; text-decoration:none; padding:0 12px;">Show All</a>&nbsp;&nbsp;
            <input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0 0 0 3px;">
            </div>
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
  	<th width="4%" class="all_restaurant">Sl No.</th>
    <th width="14%" class="all_restaurant">Date</th>
    <th width="14%" class="all_restaurant">Order Type</th>
    <th width="14%" class="all_restaurant">Order Time</th>
    <th width="12%" class="all_restaurant">Order Id</th>
    <th width="14%" class="all_restaurant">Customer Name</th>
    <th width="14%" class="all_restaurant">Customer Address</th>
    <th width="14%" class="all_restaurant">Customer Phone</th>
    <th width="14%" class="all_restaurant">Amount</th>
    <th width="14%" class="all_restaurant">Status</th>
    <th width="14%" class="all_restaurant"></th>
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
  if(count($final_array)>0){
	  
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
		
		$total_results = count($final_array); 
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
		
		$final_new_array = array_slice($final_array,$from,$max_results);
		
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
  foreach($final_new_array as $array_order){
  $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$array_order['customer_id']."'"));
  ?>
  <tr>
  	<td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_order['order_date']));?></td>
    <td class="all_restaurant2"><?php 
	
	if($array_order['type_order'] == 'live')
	{
		//echo "Live Order";
		if($array_order['type'] == 'pickup'){
			echo 'Pickup';
		}else{
			echo 'Delivery';
		}
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
	if($array_order['time'] == "")
	{
		echo "N/A";
	}
	else
	{
		echo $array_order['time']." mins";
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
 
 <style>
 
 
 
 
 </style>
 
 
 
  
<div style="display: none;">
    <div class="fancy-sml-popup" id="inline<?php echo $array_order['order_id'];?>" style="width:500px;height:250px;overflow:auto;">
        <div class="profle_wrapper">
            <div style="width:450px;">
            <h1 style="color:#2B4494;">Change Order Status</h1>
            <form name="frm_change_status" method="post" action="" onSubmit="return check_validation(<?php echo $array_order['order_id'];?>)">
            <input type="hidden" name="order_id" id="order_id" value="<?php echo $array_order['order_id'];?>">
            <p><b style="display: inline-block; width: 101px; margin-right: 5px;">Status <span style="float:right;">:</span> </b><select name="change_status" id="change_status" class="restaurant_list" onChange="open_time_div(this.value,<?php echo $array_order['order_id'];?>);">
            <option value="Pending" <?php if($array_order['status'] == 'Pending'){?> selected = "selected" <?php } ?>>Pending</option>
            <option value="Confirmed" <?php if($array_order['status'] == 'Confirmed'){?> selected = "selected" <?php } ?>>Confirmed</option>
            </select></p>
            
            <?php
			$sql_bus_del_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_SESSION['restaurant']."'"));
			
			if($array_order['type'] == 'del')
			{
				$order_type = "Delivery";
			}
			else
			{
				$order_type = "Pick up";
			}

			if($array_order['type'] == 'del')
			{
				?>
                <div class="lista" id="time_div_del<?php echo $array_order['order_id'];?>" style="display:none;">
                <h1><b> <?php echo $order_type; ?> Time</b> <span>:</span></h1>
                <div class="center-div">
                <?php
				echo "<a href='javascript:void(0);' id='sel1_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot1'].",".$array_order['order_id'].",1);'>".$sql_bus_del_info['del_time_slot1']." mins</a> &nbsp;";
				echo "<a href='javascript:void(0);' id='sel2_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot2'].",".$array_order['order_id'].",2);'>".$sql_bus_del_info['del_time_slot2']." mins</a> &nbsp;";
				echo "<a href='javascript:void(0);' id='sel3_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot3'].",".$array_order['order_id'].",3);'>".$sql_bus_del_info['del_time_slot3']." mins</a> <br>";
				echo "<a href='javascript:void(0);' id='sel4_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot4'].",".$array_order['order_id'].",4);'>".$sql_bus_del_info['del_time_slot4']." mins</a> &nbsp;";
				echo "<a href='javascript:void(0);' id='sel5_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot5'].",".$array_order['order_id'].",5);'>".$sql_bus_del_info['del_time_slot5']." mins</a> &nbsp;";
				echo "<a href='javascript:void(0);' id='sel6_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot6'].",".$array_order['order_id'].",6);'>".$sql_bus_del_info['del_time_slot6']." mins</a> &nbsp;";
				?>
                </div>
                </div>
                <?php
			}
			else
			{
				?>
                <div class="lista" id="time_div_del<?php echo $array_order['order_id'];?>" style="display:none;">
                <?php
				echo "<a href='javascript:void(0);' id='sel7_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot1'].",".$array_order['order_id'].",7);'>".$sql_bus_del_info['pickup_time_slot1']." mins</a> &nbsp;";
				echo "<a href='javascript:void(0);' id='sel8_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot2'].",".$array_order['order_id'].",8);'>".$sql_bus_del_info['pickup_time_slot2']." mins</a> &nbsp;";
				echo "<a href='javascript:void(0);' id='sel9_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot3'].",".$array_order['order_id'].",9);'>".$sql_bus_del_info['pickup_time_slot3']." mins</a> <br>";
				echo "<a href='javascript:void(0);' id='sel10_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot4'].",".$array_order['order_id'].",10);'>".$sql_bus_del_info['pickup_time_slot4']." mins</a> &nbsp;";
				echo "<a href='javascript:void(0);' id='sel11_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot5'].",".$array_order['order_id'].",11);'>".$sql_bus_del_info['pickup_time_slot5']." mins</a> &nbsp;";
				echo "<a href='javascript:void(0);' id='sel12_".$array_order['order_id']."' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot6'].",".$array_order['order_id'].",12);'>".$sql_bus_del_info['pickup_time_slot6']." mins</a> &nbsp;";
			}
				?>
                </div>
                <?php
			?>
            <input type="hidden" name="time_del_pickup" id="time_del_pickup<?php echo $array_order['order_id'];?>" />
            <input type="submit" name="submit" value="SUBMIT" class="button4">
            </form>
            </div>
        </div>
    </div>
</div>

<?php $sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$array_order['order_id']."'"));?>  


  <?php $inc++; } } else { ?>
  <tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No Live orders</td>
  </tr>
  <?php } ?>
</table>




<?php $inc = 1;
  foreach($final_new_array as $array_order){ ?>
 <div style="display: none;">
  <?php if($array_order['type_order'] == 'live'){
	 $div_width = '1000px';
	 $div_height = '500px';
 }else{
	 $div_width = '450px';
	 $div_height = '250px';
 }?>
    <div id="inline_<?php echo $inc; ?>" style="width:<?php echo $div_width; ?>;height:<?php echo $div_height; ?>;overflow:auto;">
        <div class="profle_wrapper profle_wrapper-new">
            
            <?php
			if($array_order['type_order'] == 'live')
			{
			?>
                <div style="width:450px;">
                <div class="restaurant_cont_top" style="min-height:350px;">
<h1>View Order Details</h1>

<?php $sql_menu_order = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$array_order['order_id']."'"));
$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$array_order['order_id']."'"));
$sql_customer_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$array_order['customer_id']."' "));
?>
            
            <div class="ordr-tbl">
            	<div class="ordr-head">
            		<div class="order-head-left">
					
						<h5> Customer Details -</h5>
						
						<p><strong>Customer Name :</strong>  <?php echo $sql_customer_details['firstname']." ".$sql_customer_details['lastname']; ?></p>
                        <?php if($sql_contact_details['phone']!=''){?>
						<p><strong>Phone Number :</strong> <?php echo $sql_contact_details['phone']; ?></p>
                        <?php } ?>
						<p><strong>Address :</strong> <?php echo $sql_contact_details['address']."<br>";
				echo $sql_contact_details['city']." ".$sql_contact_details['state']." ".$sql_contact_details['zipcode']; ?></p>
            		</div>
            		<div class="order-head-right">
						<p> <strong>Order Number</strong><em>:</em>
                        <?php echo "OR-00".$sql_menu_order['order_id']; ?>
                        </p>
						<p> <strong>Order Type</strong><em>:</em>
                        <?php if($sql_menu_order['type'] == 'pickup'){ echo "Pick up"; }
				else { echo "Delivery"; } ?></p>
                        <p> <strong>Order Time</strong><em>:</em>
                                <?php if($sql_menu_order['time'] == ''){ echo "N/A"; }
                        else { echo $sql_menu_order['time']." mins"; } ?></p>
						<p><strong>Date Ordered</strong><em>:</em> <?php echo date("m-d-Y", strtotime($sql_menu_order['order_date'])); ?></p>
            		</div>
            		<div class="clear"></div>
            		
            	</div>
            	<h5 class="sub"> Items Purchased Below -</h5>
            		<div class="clear"></div>
            	<div class="ordr-con">
            		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin: 0 auto; border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">
						<tr>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd; background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Item No.
							</td>
							<td align="left" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd; background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Item Name	
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE; padding: 5px; border-bottom: none;border-right: none;">
								Quantity
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE;padding: 5px; border-bottom: none;border-right: none;">
								Unit Price
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Amount
							</td>
						</tr>
					
                     <?php $sql_items_ordered = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$array_order['order_id']."'");
				$i=1;
				while($array_items_ordered = mysql_fetch_array($sql_items_ordered)){
					$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_items_ordered['menu_id']."'"));
					$menu_price = ($array_items_ordered['quantity']*$array_items_ordered['menu_price']); 
					$arr_spl = explode(",", $array_items_ordered['additional_instructions']); 
					
					/*echo '<pre>';
					print_r($arr_spl);*/
					
					if($array_items_ordered['special_instructions']!=''){
						$row_count = count($arr_spl)+2;
					}else{
						if(!empty($arr_spl[0])){
							$row_count = count($arr_spl)+1;
						}else{
							$row_count = 0;							
						}
						
					}
					
					//echo count($arr_spl);
					?>
					  <!-- Start looping row -->
						<tr>
							<td rowspan="<?php echo $row_count; ?>" align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo $i; ?>
							</td>
						  <td align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 0px;font-size: 14px;">
								<p><?php echo $sql_menu['menu_name']; ?></p>
							
                            </td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo $array_items_ordered['quantity']; ?>
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo "$".$array_items_ordered['menu_price']; ?>
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo "$".$menu_price; ?>
							</td>
						</tr>
                        <?php 
						foreach($arr_spl as $arrspl){
						if(!empty($arrspl)){
						$sql_sp_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$arrspl."'"));
						$sql_ins_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE id = '".$sql_sp_name['special_ins_id']."'"));
						$pr1 = ($array_items_ordered['quantity'] * $sql_sp_name['price']);?>
						<tr>
						  <td class="sub-list" align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo $sql_ins_name['special_instruction']; ?> ----- <?php echo $sql_sp_name['title']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo $array_items_ordered['quantity']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo "$".$sql_sp_name['price']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo "$".$pr1; ?></td>
	                  </tr>
                      <?php if($array_items_ordered['special_instructions']!=''){ ?>
						<tr>
						  <td class="sub-list" align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;" colspan="4"><?php if($array_items_ordered['special_instructions']!=''){ echo "Additional Instructions : ".htmlspecialchars_decode(htmlspecialchars_decode($array_items_ordered['special_instructions']))."<br><br>"; } ?></td>
	                  </tr>
                      <?php } ?>
                      <?php } } ?>
	                  <!-- End looping row -->
						<?php
						$i++;
                        }
                        ?>
                        
						
						 <?php if($sql_menu_order['coupon_code']!=''){ ?> 
						<tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Coupon Code
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo $sql_menu_order['coupon_code']; ?>
							</td>
						</tr>
                        <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Coupon Discount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['coupon_discount']; ?>
							</td>
						</tr>
                        <?php } ?>
                        
                         <?php if($sql_menu_order['reward_points']!=0.00){ ?>
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Reward Point Discount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['reward_points']; ?>
							</td>
						</tr>
						<?php } ?>
                        
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Order Amount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['total_price']; ?>
							</td>
						</tr>
                        
                        <?php if($sql_menu_order['type'] == 'del'){ ?>
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Delivery Charge
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php 
								if($sql_menu_order['delivery_charge'] == 0){
									echo "Free";
								 }
								else {
									echo "$ ".($sql_menu_order['delivery_charge']);
								}?>
							</td>
						</tr>
						<?php } ?>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Tax
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['tax']; ?>
							</td>
						</tr>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Tip
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['tip']; ?>
							</td>
						</tr>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Total
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$ ".($sql_menu_order['total_price'] + $sql_menu_order['delivery_charge'] + $sql_menu_order['tax'] + $sql_menu_order['tip']); ?>
							</td>
						</tr>
                        
					</table>
            	</div>
            	<div class="clear"></div>
                
            </div>
            
            
<div class="clear"></div>
</div>
                
				
				
            </div>
            <?php
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
<?php $inc++; } ?>




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

