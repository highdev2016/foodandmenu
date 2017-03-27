<?php
session_start();
ob_start();
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

if(!isset($_SESSION['admin_login_id'])){
	header("location:admin_login.php");
}

include ("admin/lib/conn.php");
include ("includes/functions.php");



if($_REQUEST['export'] == "Export to Excel")
{
	header("location:export_admin_home_excel.php?restaurant_name=".$_REQUEST['restaurant_name']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']);
}


//print_r($_SESSION);
include ("includes/header_vendor.php");




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

function change_dateformat_reverse_db1($date_form1)
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

?>

<script type="text/javascript">
function sort_function(sort_by,order_id,restaurant_id,confirmation_code){
	location.href = 'admin_home.php?sort_order='+sort_by+"&order_id="+order_id+"&restaurant_id="+restaurant_id+"&confirmation_code="+confirmation_code;
}
</script>
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

function get_state_city(state,city){
	var $j = jQuery.noConflict();
	$j.ajax({
		url : 'get_state_city1.php',
		type : 'POST',
		data : 'state=' + state +'&city=' +city,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('restaurant_city').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}

function get_restaurant(city,restaurant){
	//alert(city);
	var $j = jQuery.noConflict();
	$j.ajax({
		url : 'get_city_restaurant1.php',
		type : 'POST',
		data : 'city=' + city +'&restaurant='+restaurant,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			/*var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];*/
			document.getElementById('restaurant_name').innerHTML=data;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}
</script>
<body>
<?php include ("includes/menu_admin_add_res_front.php");?>
<div class="body_section">
  <div class="body_container">
    <div class="body_top"></div>
    <div class="main_body">
      <div class="restaurant_body_cont">
      
      <?php include ("includes/admin_nav_menu.php");?>
      
        <?php /*?><div class="restaurant_cont_top admn-pnl-top">
          <h1>Administration Panel</h1>
        </div><?php */?>
        <div class="restaurant_cont_field" style="margin:0 15px;">
          <p style="color:#454EA8; font-size:21px;margin-left:0px;margin-top:3px;">Search Panel</p>
          <br>
          <form name="frm" method="post" action="admin_home.php">
            <table class="sec-pnl-top">
            <tr>
            <td width="150">State:</td>
              <td width="184">
              <select name="restaurant_state" id="restaurant_state" style="width:200px;" class="restaurant search_select"  onchange="get_state_city(this.value , '');">
              <option value="">--Select--</option>
              <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='' ORDER BY restaurant_state");
              while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
                <option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['restaurant_state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
              <?php } ?>
              </select>
              </td>
              <td width="150">City:</td>
              <td width="184">
              <select class="restaurant search_select" name="restaurant_city" id="restaurant_city" style="width:200px;" onChange="get_restaurant(this.value , '');">
              <option value="">--Select--</option>
              <?php /*?><?php $sql_select_city = mysql_query("SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!='' ORDER BY restaurant_city");
              while($array_select_city = mysql_fetch_array($sql_select_city)){ ?>
                <option value="<?php echo $array_select_city['restaurant_city']; ?>" <?php if($array_select_city['restaurant_city'] == $_REQUEST['restaurant_city']){?> selected="selected" <?php } ?>><?php echo $array_select_city['restaurant_city']; ?></option>
              <?php } ?><?php */?>
              </select>
              </td>
                     
             <td width="150" height="39">Restaurant Name:</td>
        <td width="184">
        <select class="restaurant search_select" name="restaurant_name" id="restaurant_name" style="width:200px;">
        <option value="">--Select--</option>
        </select></td>
         </tr>
            
              <tr>
               	<td width="150">Date : </td>
                <td width="184"><select class="restaurant search_select" name="mod_date" id="mod_date" onChange="open_cust_date(this.value);">
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
				
				<td  width="150"><div id="start_dt1" style="visibility:<?php echo $display; ?>;"> Start Date : </div></td>	
				<td  width="184" id="start_dt2" style="visibility:<?php echo $display; ?>">
					<input type="text" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date']; ?>" readonly>
				</td>
				<td  width="150"><div id="end_dt1" style="visibility:<?php echo $display; ?>;">End Date : </div></td>	
				<td  width="184" id="end_dt2" style="visibility:<?php echo $display; ?>">
					<input type="text" name="end_date" id="end_date" value="<?php echo $_REQUEST['end_date']; ?>" readonly>
				</td>
                 </tr>
               
               <tr>
               <td  width="150">&nbsp;</td>	
				<td  width="184">&nbsp;
					
				</td>
				<td  width="150">&nbsp;</td>	
				<td  width="184">&nbsp;
					
				</td>
               
                <td align="right" width="184" style="padding-right:22px;" colspan="2">
			    	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
			    	<a href="admin_home.php" class="button4" style="margin:0px; text-decoration:none; padding:6px 12px;">
			    		Show All
			    		<!-- <input type="button" name="show_all" value="Show All" class="button4" style="margin:0px;"> -->
			    	</a> 
			    	<input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0 0 0 3px;">
    			</td>
               </tr>
               
              <tr>
                <td colspan="5">&nbsp;</td>
                
                  </tr>
            </table>
          </form>
          
<?php
///////////////////////////////////////// Creation of Array (3 Tables) /////////////////////////////////////////////

$rest_live_orders = ("SELECT * FROM restaurant_menu_order WHERE 1");

if($_REQUEST['restaurant_state']!=''){
	  $res_filter_state = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_state = '".$_REQUEST['restaurant_state']."'");
	  
	  $res_state = '';
	  $sep = '';
	  while($res_array_state = mysql_fetch_array($res_filter_state)){
		  $res_state = $res_state.$sep.$res_array_state['id'];
		  $sep = ',';
	  }
	  
	  $rest_live_orders.=" AND restaurant_id IN (".$res_state.") ";
}
if($_REQUEST['restaurant_city']!=''){
	  $res_filter_city = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_city = '".$_REQUEST['restaurant_city']."'");
	  
	  $res_city= '';
	  $sep1 = '';
	  while($res_array_city = mysql_fetch_array($res_filter_city)){
		  $res_city = $res_city.$sep1.$res_array_city['id'];
		  $sep1 = ',';
	  }
	  
	  $rest_live_orders.=" AND restaurant_id IN (".$res_city.") ";
}
if($_REQUEST['restaurant_name']!=''){
	  $rest_live_orders.=" AND restaurant_id = ".$_REQUEST['restaurant_name']." ";
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
//echo $rest_live_orders;
$query_res = mysql_query($rest_live_orders);
while($res = mysql_fetch_assoc($query_res)) {
	
	$live_orders[] = $res;
}


$gift_cer = ("SELECT t1.*,t2.* FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 WHERE t1.id = t2.giftcard_id ");

if($_REQUEST['restaurant_state']!=''){
	  $res_filter_state = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_state = '".$_REQUEST['restaurant_state']."'");
	  
	  $res_state = '';
	  $sep = '';
	  while($res_array_state = mysql_fetch_array($res_filter_state)){
		  $res_state = $res_state.$sep.$res_array_state['id'];
		  $sep = ',';
	  }
	  
	  $gift_cer.=" AND t1.restaurant_id IN (".$res_state.") ";
}
if($_REQUEST['restaurant_city']!=''){
	  $res_filter_city = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_city = '".$_REQUEST['restaurant_city']."'");
	  
	  $res_city= '';
	  $sep1 = '';
	  while($res_array_city = mysql_fetch_array($res_filter_city)){
		  $res_city = $res_city.$sep1.$res_array_city['id'];
		  $sep1 = ',';
	  }
	  
	  $gift_cer.=" AND t1.restaurant_id IN (".$res_city.") ";
}
if($_REQUEST['restaurant_name']!=''){
	  $gift_cer.=" AND t1.restaurant_id = ".$_REQUEST['restaurant_name']." ";
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


$reservation = ("SELECT * from restaurant_reservations WHERE 1 ");

if($_REQUEST['restaurant_state']!=''){
	  $res_filter_state = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_state = '".$_REQUEST['restaurant_state']."'");
	  
	  $res_state = '';
	  $sep = '';
	  while($res_array_state = mysql_fetch_array($res_filter_state)){
		  $res_state = $res_state.$sep.$res_array_state['id'];
		  $sep = ',';
	  }
	  
	  $reservation.=" AND restaurant_id IN (".$res_state.") ";
}
if($_REQUEST['restaurant_city']!=''){
	  $res_filter_city = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_city = '".$_REQUEST['restaurant_city']."'");
	  
	  $res_city= '';
	  $sep1 = '';
	  while($res_array_city = mysql_fetch_array($res_filter_city)){
		  $res_city = $res_city.$sep1.$res_array_city['id'];
		  $sep1 = ',';
	  }
	  
	  $reservation.=" AND restaurant_id IN (".$res_city.") ";
}
if($_REQUEST['restaurant_name']!=''){
	  $reservation.=" AND restaurant_id = ".$_REQUEST['restaurant_name']." ";
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
		  ?>
          <table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
            <tr>
              <td width="4%" class="all_restaurant">Sl No.</td>
              <td width="14%" class="all_restaurant">Date</td>
              <td width="14%" class="all_restaurant">Order Type</td>
              <td width="12%" class="all_restaurant">Order Id</td>
              <?php /*?><td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('type','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Order Type</a></td><?php */?>
              <?php /*?><td width="14%" class="all_restaurant">Restaurant Name</td><?php */?>
              <td width="14%" class="all_restaurant">Customer Name</td>
              <td width="14%" class="all_restaurant">Customer Address</td>
              <td width="14%" class="all_restaurant">Customer Phone</td>
              <td width="14%" class="all_restaurant">Amount</td>
              <?php /*?><td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('confirmation_code','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Confirmation Code</a></td><?php */?>
              <?php /*?><td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('status','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Status</a></td><?php */?>
              <td width="14%" class="all_restaurant">Action</td>
              <!--<td width="14%" class="all_restaurant"></td>--> 
            </tr>
            <?php 
  $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant_admin_panel_id']."'"));
  $_SESSION['restaurant'] = $sql_restaurant['id'];
  $today = date('Y-m-d');
  
  $query_res = ("SELECT * FROM restaurant_menu_order WHERE 1");
  //$query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '1194'");
  $order_id = substr($_REQUEST['order_id'],5);
  if($_REQUEST['order_id']!=''){
	  $query_res.=" AND order_id = '".$order_id."'";
  }
  /*if($_REQUEST['restaurant_name']!=''){
	  $res_all_id = mysql_fetch_array(mysql_query("SELECT restaurant_name FROM restaurant_menu_order WHERE 1"));
	  $res_filter = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_name LIKE '".addslashes($_REQUEST['restaurant_name'])."%'"));
	  
	  if($res_filter['id'] == '')
	  {
		  $res_filter['id'] = 0;
	  }

	  $query_res.=" AND restaurant_id in (".$res_filter['id'].")";
  }*/
  
  if($_REQUEST['restaurant_name']!=''){
	  $query_res.=" AND restaurant_id = '".$_REQUEST['restaurant_name']."' ";  
  }
  
  if($_REQUEST['restaurant_state']!=''){
	  $res_filter_state = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_state = '".$_REQUEST['restaurant_state']."'");
	  
	  $res_state = '';
	  $sep = '';
	  while($res_array_state = mysql_fetch_array($res_filter_state)){
		  $res_state = $res_state.$sep.$res_array_state['id'];
		  $sep = ',';
	  }
	  
	  $query_res.=" AND restaurant_id IN (".$res_state.") ";
	  
	  /*if($res_filter['id'] == '')
	  {
		  $res_filter['id'] = 0;
	  }
	  $query_res.=" AND restaurant_id = '".$res_filter['id']."'";*/
	  
  }
  
  if($_REQUEST['restaurant_city']!=''){
	  $res_filter_city = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_city = '".$_REQUEST['restaurant_city']."'");
	  
	  $res_city= '';
	  $sep1 = '';
	  while($res_array_city = mysql_fetch_array($res_filter_city)){
		  $res_city = $res_city.$sep1.$res_array_city['id'];
		  $sep1 = ',';
	  }
	  
	  $query_res.=" AND restaurant_id IN (".$res_city.") ";
	  
	  /*if($res_filter['id'] == '')
	  {
		  $res_filter['id'] = 0;
	  }
      */
	  //$query_res.=" AND restaurant_id = '".$res_filter['id']."'";
  }
  
  if($_REQUEST['confirmation_code']!=''){
	  $query_res.=" AND confirmation_code LIKE '%".$_REQUEST['confirmation_code']."%'";
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
		  $start_date = change_dateformat_reverse_db1($_REQUEST['start_date']);
		  $end_date = change_dateformat_reverse_db1($_REQUEST['end_date']);
		  $query_res.=" AND order_date >= '".$start_date." 00:00:00' AND order_date <= '".$end_date." 59:59:59'";
		  //$query_res.=" AND order_date LIKE '%".$start_date."%' AND order_date LIKE '%".$end_date."%'";
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
		$max_results =10; 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = count($final_array); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if(!isset($_GET['page']) || ($_REQUEST['submit']!="") || $_GET['page']==''){
			$page_num = 1;
		} else {
			$page_num = $_GET['page'];
		}
		
		/*$page_num = 1;
		
		if(isset($_GET['page'])){$page_num = $_GET['page'];}*/
		
		$offset = $page_num; 
		
		if($page_num == 0) {$page_num = 1;}
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$prev&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$i&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$next&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		
		$final_new_array = array_slice($final_array,$from,$max_results);
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
		if($_REQUEST['page']!="")
		{
			$j=($_REQUEST['page']-1)*10;
		}
		if($_REQUEST['search']!="")
		{
		$j=0;	
		}
	  ?>
            <?php $inc = 1;
  foreach($final_new_array as $array_order){
  $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$array_order['customer_id']."'"));?>
            <tr>
              <td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
              
              <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_order['order_date']));?></td>
              <td class="all_restaurant2"><?php 
				if($array_order['type_order'] == 'live')
				{
					//echo "Live Order";
					if($array_order == 'pickup'){
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
              <?php /*?><td class="all_restaurant2"><?php 
			  	if($array_order['type_order'] == 'live')
				{
					if($array_order['type'] == 'pickup') { echo "Pick Up"; } else { echo "Delivery"; }
				}
				else
				{
					echo "N/A";
				}
			  
			  
			  ?></td><?php */?>
              <?php /*?><td class="all_restaurant2"><?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$array_order['restaurant_id']);?></td><?php */?>
              
              <td class="all_restaurant2"><?php echo $sql_customer['firstname']." ".$sql_customer['lastname'];?></td>
              
              <td class="all_restaurant2"><?php echo $sql_customer['address']."<br>";
			  
	echo $sql_customer['city'];?>&nbsp;&nbsp;<?php echo $sql_customer['state'];?>&nbsp;&nbsp;<?php echo $sql_customer['zip']; ?></td>
    
              <td class="all_restaurant2"><?php echo $sql_customer['phone'];?></td>
              
              <td class="all_restaurant2"><?php if($array_order['type_order'] == 'live')
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
												}?></td>
              
              <?php /*?><td class="all_restaurant2"><?php echo $array_order['confirmation_code']; ?></td><?php */?>
              
              <td class="all_restaurant2"><a class="various1" href="#inline_<?php echo $inc;?>" title="View" style="color:#686868;">View</a></td>
              <?php /*?><td class="all_restaurant2"><?php echo $array_order['status'];?>
    <?php if($array_order['status'] == 'Pending'){ ?>
	<span style="float:right;"><a class="various1" href="#inline<?php echo $array_order['order_id'];?>" title="Edit" style="color:#686868;">EDIT</a></span>
	<?php }?>
    </td><?php */?>
              <?php /*?><td class="all_restaurant2"><a class="various1" href="#inline_<?php echo $array_order['order_id'];?>" title="View" style="color:#686868;">View</a></td><?php */?>
            </tr>
            <?php /*?><div style="display: none;">
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
</div><?php */?>
            <?php $sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$array_order['order_id']."'"));?>
            



            <?php $inc++; } } else { ?>
            <tr>
              <td class="all_restaurant2" colspan="11" style="text-align:center;">No  orders available</td>
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
                <div >
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
			
			if ($page_num != 1) {
                $page_pagination.= "<a href=\"admin_home.php?page=$prev&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
				
				}

            for ($i = $page_min;$i <= $page_max;$i++) {
                if ($i == $page_num){
                $page_pagination .= $i; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
                else{
                $page_pagination.= "<a href=\"admin_home.php?page=$i&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."\" class=\"more_link_pagination\">$i</a>"; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;'; 
				}
			}
			
			
			if ($page_num < $total_pages) {
                $page_pagination.= "<a href=\"admin_home.php?page=$next&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."\" class=\"more_link_pagination_prev\">Next</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
		} 
?>
          <div style="text-align:center; margin-top:10px;"><?php echo $page_pagination; ?></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="body_footer_bg" ></div>
  </div>
  <div class="clear"></div>
</div>
<div class="clear"></div>

<?php if($_REQUEST['restaurant_state']!='' || $_REQUEST['restaurant_city']!='' || $_REQUEST['restaurant_name']!=''){?>
<script type="text/javascript">
get_state_city('<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>');
get_restaurant('<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>');
</script>
<?php } ?>