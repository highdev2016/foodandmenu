<?php
ob_start();
session_start();
include ("includes/header_vendor.php");?>
<?php include ("admin/lib/conn.php");?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />
<script>
  $(function() {
	$('#del_hours_from').timepicker({ 'timeFormat': 'h:i A' });
	$('#del_hours_to').timepicker({ 'timeFormat': 'h:i A' });
	$('#pickup_hours_from').timepicker({ 'timeFormat': 'h:i A' });
	$('#pickup_hours_to').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_open_Monday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_close_Monday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_open_Tuesday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_close_Tuesday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_open_Wednesday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_close_Wednesday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_open_Thursday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_close_Thursday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_open_Friday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_close_Friday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_open_Saturday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_close_Saturday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_open_Sunday').timepicker({ 'timeFormat': 'h:i A' });
	$('#reservation_close_Sunday').timepicker({ 'timeFormat': 'h:i A' });
	$('.time_pick').timepicker({ 'timeFormat': 'h:i A' });
  });
  
 /* $('body').on('click', 'input.time_pick_ajax', function(event) {
 
 
    $(this).timepicker({ 'timeFormat': 'h:i A' });
  });
  
  $('.time_pick_ajax').bind('load', function() {
    $(this).timepicker();
});*/
</script>
<script type="text/javascript">
function add_cell(id){
	$.ajax({
		url : 'addextrahours.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu').appendChild(menuDiv);
			document.getElementById('item_id').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus').focus();
}

function remove_div(delId)
{
	var div = document.getElementById("business_div_" + delId);
	div.parentNode.removeChild(div);
}

function add_delivery_hours_cell(id){
	$.ajax({
		url : 'addextra_delivery_hours.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_del_hrs_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('del_hours').appendChild(menuDiv);
			document.getElementById('delivery_hours_id').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_delivery_hours').focus();
}

function remove_delivery_hours_div(delId)
{
	var div = document.getElementById("business_div_del_hrs_" + delId);
	div.parentNode.removeChild(div);
}

function add_pickup_hours_cell(id){
	$.ajax({
		url : 'addextra_pickup_hours.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_pickup_hrs_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('pickup_hours').appendChild(menuDiv);
			document.getElementById('pickup_hours_id').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_pickup_hours').focus();
}

function remove_pickup_hours_div(delId)
{
	var div = document.getElementById("business_div_pickup_hrs_" + delId);
	div.parentNode.removeChild(div);
}

function add_del_charge_cell(id){
	$.ajax({
		url : 'addextra_del_charge.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_del_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('del_charge').appendChild(menuDiv);
			document.getElementById('del_charge_item_id').value=parseInt(id)+1;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_del_charge').focus();
}

function remove_del_charge_div(delId)
{
	var div = document.getElementById("business_div_del_" + delId);
	div.parentNode.removeChild(div);
}

function get_reservation_hours(val){
	if(val == 1){
		$('#reservation_hrs_div').show(500);
	}else{
		$('#reservation_hrs_div').hide(500);
		$('#reservation_open').val('');
		$('#reservation_close').val('');
	}
	
}

</script>

<body>

<?php include ("includes/menu_admin_edit_res.php");?>


<?php
/*------------------------------- Delete Monday Business Hours ---------------------------------------------*/
if($_REQUEST['delete_mon_buss_hrs']!=''){
	mysql_query("DELETE FROM restaurant_buss_hrs WHERE id = '".$_REQUEST['delete_mon_buss_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&bus_del_success=1");
}
/*------------------------------- Delete Monday Business Hours ---------------------------------------------*/

/*------------------------------- Delete Tuesday Business Hours ---------------------------------------------*/
if($_REQUEST['delete_tue_buss_hrs']!=''){
	mysql_query("DELETE FROM restaurant_buss_hrs WHERE id = '".$_REQUEST['delete_tue_buss_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&bus_del_success=1");
}
/*------------------------------- Delete Tuesday Business Hours ---------------------------------------------*/

/*------------------------------- Delete Wednesday Business Hours ---------------------------------------------*/
if($_REQUEST['delete_wed_buss_hrs']!=''){
	mysql_query("DELETE FROM restaurant_buss_hrs WHERE id = '".$_REQUEST['delete_wed_buss_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&bus_del_success=1");
}
/*------------------------------- Delete Wednesday Business Hours ---------------------------------------------*/


/*------------------------------- Delete Thursday Business Hours ---------------------------------------------*/
if($_REQUEST['delete_thu_buss_hrs']!=''){
	mysql_query("DELETE FROM restaurant_buss_hrs WHERE id = '".$_REQUEST['delete_thu_buss_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&bus_del_success=1");
}
/*------------------------------- Delete Thursday Business Hours ---------------------------------------------*/


/*------------------------------- Delete Friday Business Hours ---------------------------------------------*/
if($_REQUEST['delete_fri_buss_hrs']!=''){
	mysql_query("DELETE FROM restaurant_buss_hrs WHERE id = '".$_REQUEST['delete_fri_buss_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&bus_del_success=1");
}
/*------------------------------- Delete Friday Business Hours ---------------------------------------------*/


/*------------------------------- Delete Saturday Business Hours ---------------------------------------------*/
if($_REQUEST['delete_sat_buss_hrs']!=''){
	mysql_query("DELETE FROM restaurant_buss_hrs WHERE id = '".$_REQUEST['delete_sat_buss_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&bus_del_success=1");
}
/*------------------------------- Delete Saturday Business Hours ---------------------------------------------*/


/*------------------------------- Delete Sunday Business Hours ---------------------------------------------*/
if($_REQUEST['delete_sun_buss_hrs']!=''){
	mysql_query("DELETE FROM restaurant_buss_hrs WHERE id = '".$_REQUEST['delete_sun_buss_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&bus_del_success=1");
}
/*------------------------------- Delete Sunday Business Hours ---------------------------------------------*/


/*------------------------------- Delete Monday Delivery Hours ---------------------------------------------*/
if($_REQUEST['delete_mon_del_hrs']!=''){
	mysql_query("DELETE FROM restaurant_del_hrs WHERE id = '".$_REQUEST['delete_mon_del_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_del_success=1");
}
/*------------------------------- Delete Monday Delivery Hours ---------------------------------------------*/


/*------------------------------- Delete Tuesday Delivery Hours ---------------------------------------------*/
if($_REQUEST['delete_tue_del_hrs']!=''){
	mysql_query("DELETE FROM restaurant_del_hrs WHERE id = '".$_REQUEST['delete_tue_del_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_del_success=1");
}
/*------------------------------- Delete Tuesday Delivery Hours ---------------------------------------------*/


/*------------------------------- Delete Wednesday Delivery Hours ---------------------------------------------*/
if($_REQUEST['delete_wed_del_hrs']!=''){
	mysql_query("DELETE FROM restaurant_del_hrs WHERE id = '".$_REQUEST['delete_wed_del_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_del_success=1");
}
/*------------------------------- Delete Wednesday Delivery Hours ---------------------------------------------*/


/*------------------------------- Delete Thursday Delivery Hours ---------------------------------------------*/
if($_REQUEST['delete_thu_del_hrs']!=''){
	mysql_query("DELETE FROM restaurant_del_hrs WHERE id = '".$_REQUEST['delete_thu_del_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_del_success=1");
}
/*------------------------------- Delete Thursday Delivery Hours ---------------------------------------------*/


/*------------------------------- Delete Friday Delivery Hours ---------------------------------------------*/
if($_REQUEST['delete_fri_del_hrs']!=''){
	mysql_query("DELETE FROM restaurant_del_hrs WHERE id = '".$_REQUEST['delete_fri_del_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_del_success=1");
}
/*------------------------------- Delete Friday Delivery Hours ---------------------------------------------*/


/*------------------------------- Delete Saturday Delivery Hours ---------------------------------------------*/
if($_REQUEST['delete_sat_del_hrs']!=''){
	mysql_query("DELETE FROM restaurant_del_hrs WHERE id = '".$_REQUEST['delete_sat_del_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_del_success=1");
}
/*------------------------------- Delete Saturday Delivery Hours ---------------------------------------------*/


/*------------------------------- Delete Sunday Delivery Hours ---------------------------------------------*/
if($_REQUEST['delete_sun_del_hrs']!=''){
	mysql_query("DELETE FROM restaurant_del_hrs WHERE id = '".$_REQUEST['delete_sun_del_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_del_success=1");
}
/*------------------------------- Delete Sunday Delivery Hours ---------------------------------------------*/


/*------------------------------- Delete Monday Pickup Hours ---------------------------------------------*/
if($_REQUEST['delete_mon_pickup_hrs']!=''){
	mysql_query("DELETE FROM restaurant_pickup_hrs WHERE id = '".$_REQUEST['delete_mon_pickup_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&pickup_del_success=1");
}
/*------------------------------- Delete Monday Pickup Hours ---------------------------------------------*/


/*------------------------------- Delete Tuesday Pickup Hours ---------------------------------------------*/
if($_REQUEST['delete_tue_pickup_hrs']!=''){
	mysql_query("DELETE FROM restaurant_pickup_hrs WHERE id = '".$_REQUEST['delete_tue_pickup_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&pickup_del_success=1");
}
/*------------------------------- Delete Tuesday Pickup Hours ---------------------------------------------*/


/*------------------------------- Delete Wednesday Pickup Hours ---------------------------------------------*/
if($_REQUEST['delete_wed_pickup_hrs']!=''){
	mysql_query("DELETE FROM restaurant_pickup_hrs WHERE id = '".$_REQUEST['delete_wed_pickup_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&pickup_del_success=1");
}
/*------------------------------- Delete Wednesday Pickup Hours ---------------------------------------------*/


/*------------------------------- Delete Thursday Pickup Hours ---------------------------------------------*/
if($_REQUEST['delete_thu_pickup_hrs']!=''){
	mysql_query("DELETE FROM restaurant_pickup_hrs WHERE id = '".$_REQUEST['delete_thu_pickup_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&pickup_del_success=1");
}
/*------------------------------- Delete Thursday Pickup Hours ---------------------------------------------*/


/*------------------------------- Delete Friday Pickup Hours ---------------------------------------------*/
if($_REQUEST['delete_fri_pickup_hrs']!=''){
	mysql_query("DELETE FROM restaurant_pickup_hrs WHERE id = '".$_REQUEST['delete_fri_pickup_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&pickup_del_success=1");
}
/*------------------------------- Delete Friday Pickup Hours ---------------------------------------------*/


/*------------------------------- Delete Saturday Pickup Hours ---------------------------------------------*/
if($_REQUEST['delete_sat_pickup_hrs']!=''){
	mysql_query("DELETE FROM restaurant_pickup_hrs WHERE id = '".$_REQUEST['delete_sat_pickup_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&pickup_del_success=1");
}
/*------------------------------- Delete Saturday Pickup Hours ---------------------------------------------*/


/*------------------------------- Delete Sunday Pickup Hours ---------------------------------------------*/
if($_REQUEST['delete_sat_pickup_hrs']!=''){
	mysql_query("DELETE FROM restaurant_pickup_hrs WHERE id = '".$_REQUEST['delete_sat_pickup_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&pickup_del_success=1");
}
/*------------------------------- Delete Sunday Pickup Hours ---------------------------------------------*/


if($_REQUEST['delete']!=''){
	mysql_query("DELETE FROM restaurant_extra_business_hours WHERE id = '".$_REQUEST['delete']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&success=1");
}

if($_REQUEST['delete_del_hrs']!=''){
	mysql_query("DELETE FROM restaurant_delivery_details_master WHERE id = '".$_REQUEST['delete_del_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_del_success=1");
}

if($_REQUEST['delete_pickup_hrs']!=''){
	mysql_query("DELETE FROM restaurant_take_out_master WHERE id = '".$_REQUEST['delete_pickup_hrs']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_pickup_success=1");
}

if($_REQUEST['delete_del_charge']!=''){
	mysql_query("DELETE FROM restaurant_delivery_charge WHERE id = '".$_REQUEST['delete_del_charge']."'");
	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&del_success=1");
}


$sql_sel_pickup_hrs = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_take_out_master WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'"));

$sql_sel_del_hrs = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_delivery_details_master WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'"));


if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	
	$payment="";
	$payment_sep="";
	foreach($_REQUEST['payment_method'] as $single_method)
	{
		$payment.=$payment_sep.$single_method;
		$payment_sep=",";
	}
	
	$sql_bus_del_hrs = mysql_num_rows(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['hid']."'"));
	
	if($sql_bus_del_hrs > 0){
		mysql_query("update restaurant_business_delivery_takeout_info set business_hours_mon='".mysql_real_escape_string(trim($_REQUEST['business_hours_mon']))."',business_hours_mon_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_mon_from']))."',business_hours_tue='".mysql_real_escape_string(trim($_REQUEST['business_hours_tue']))."',business_hours_tue_from='".mysql_real_escape_string(trim($_REQUEST['business_hours_tue_from']))."',business_hours_wed='".mysql_real_escape_string(trim($_REQUEST['business_hours_wed']))."',business_hours_wed_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_wed_from']))."',business_hours_thu='".mysql_real_escape_string(trim($_REQUEST['business_hours_thu']))."',business_hours_thu_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_thu_from']))."',business_hours_fri='".mysql_real_escape_string(trim($_REQUEST['business_hours_fri']))."',business_hours_fri_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_fri_from']))."',business_hours_sat='".mysql_real_escape_string(trim($_REQUEST['business_hours_sat']))."',business_hours_sat_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_sat_from']))."',business_hours_sun='".mysql_real_escape_string(trim($_REQUEST['business_hours_sun']))."',business_hours_sun_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_sun_from']))."',holidays='".mysql_real_escape_string($_REQUEST['holidays'])."',holidays_from = '".mysql_real_escape_string($_REQUEST['holidays_from'])."',delivery='".mysql_real_escape_string($_REQUEST['delivery'])."',minimum_ammount='".mysql_real_escape_string($_REQUEST['minimum_ammount'])."', delivery_estimated_time='".mysql_real_escape_string($_REQUEST['estimated_delivery_time'])."',pickup='".mysql_real_escape_string($_REQUEST['pickup'])."',drive_thru='".mysql_real_escape_string($_REQUEST['drive_thru'])."',tax = '".mysql_real_escape_string($_REQUEST['tax'])."' , commission = '".mysql_real_escape_string($_REQUEST['commission'])."' , del_hours_from = '".$_REQUEST['del_hours_from']."', del_hours_to = '".$_REQUEST['del_hours_to']."', pickup_hours_from = '".$_REQUEST['pickup_hours_from']."' , pickup_hours_to = '".$_REQUEST['pickup_hours_to']."' , reservation_open_Monday = '".date('H:i', strtotime($_REQUEST['reservation_open_Monday']))."' , reservation_close_Monday = '".date('H:i', strtotime($_REQUEST['reservation_close_Monday']))."' , reservation_open_Tuesday = '".date('H:i', strtotime($_REQUEST['reservation_open_Tuesday']))."' , reservation_close_Tuesday = '".date('H:i', strtotime($_REQUEST['reservation_close_Tuesday']))."' , reservation_open_Wednesday = '".date('H:i', strtotime($_REQUEST['reservation_open_Wednesday']))."' , reservation_close_Wednesday = '".date('H:i', strtotime($_REQUEST['reservation_close_Wednesday']))."' , reservation_open_Thursday = '".date('H:i', strtotime($_REQUEST['reservation_open_Thursday']))."' , reservation_close_Thursday = '".date('H:i', strtotime($_REQUEST['reservation_close_Thursday']))."' , reservation_open_Friday = '".date('H:i', strtotime($_REQUEST['reservation_open_Friday']))."' , reservation_close_Friday = '".date('H:i', strtotime($_REQUEST['reservation_close_Friday']))."' , reservation_open_Saturday = '".date('H:i', strtotime($_REQUEST['reservation_open_Saturday']))."' , reservation_close_Saturday = '".date('H:i', strtotime($_REQUEST['reservation_close_Saturday']))."' , reservation_open_Sunday = '".date('H:i', strtotime($_REQUEST['reservation_open_Sunday']))."' , reservation_close_Sunday = '".date('H:i', strtotime($_REQUEST['reservation_close_Sunday']))."' , credit_card_fee = '".$_REQUEST['credit_card_fee']."' , service_fee = '".$_REQUEST['service_fee']."' , del_time_slot1 = '".$_REQUEST['del_time_slot1']."' , del_time_slot2 = '".$_REQUEST['del_time_slot2']."' , del_time_slot3 = '".$_REQUEST['del_time_slot3']."' , del_time_slot4 = '".$_REQUEST['del_time_slot4']."' , del_time_slot5 = '".$_REQUEST['del_time_slot5']."' , del_time_slot6 = '".$_REQUEST['del_time_slot6']."' , pickup_time_slot1 = '".$_REQUEST['pick_time_slot1']."' , pickup_time_slot2 = '".$_REQUEST['pick_time_slot2']."' , pickup_time_slot3 = '".$_REQUEST['pick_time_slot3']."' , pickup_time_slot4 = '".$_REQUEST['pick_time_slot4']."' , pickup_time_slot5 = '".$_REQUEST['pick_time_slot5']."' , pickup_time_slot6 = '".$_REQUEST['pick_time_slot6']."' where restaurant_id='".mysql_real_escape_string($_REQUEST['hid'])."'");
	}else{
		mysql_query("INSERT INTO restaurant_business_delivery_takeout_info SET restaurant_id='".mysql_real_escape_string($_REQUEST['hid'])."' , business_hours_mon='".mysql_real_escape_string(trim($_REQUEST['business_hours_mon']))."',business_hours_mon_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_mon_from']))."',business_hours_tue='".mysql_real_escape_string(trim($_REQUEST['business_hours_tue']))."',business_hours_tue_from='".mysql_real_escape_string(trim($_REQUEST['business_hours_tue_from']))."',business_hours_wed='".mysql_real_escape_string(trim($_REQUEST['business_hours_wed']))."',business_hours_wed_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_wed_from']))."',business_hours_thu='".mysql_real_escape_string(trim($_REQUEST['business_hours_thu']))."',business_hours_thu_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_thu_from']))."',business_hours_fri='".mysql_real_escape_string(trim($_REQUEST['business_hours_fri']))."',business_hours_fri_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_fri_from']))."',business_hours_sat='".mysql_real_escape_string(trim($_REQUEST['business_hours_sat']))."',business_hours_sat_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_sat_from']))."',business_hours_sun='".mysql_real_escape_string(trim($_REQUEST['business_hours_sun']))."',business_hours_sun_from = '".mysql_real_escape_string(trim($_REQUEST['business_hours_sun_from']))."',holidays='".mysql_real_escape_string($_REQUEST['holidays'])."',holidays_from = '".mysql_real_escape_string($_REQUEST['holidays_from'])."',delivery='".mysql_real_escape_string($_REQUEST['delivery'])."',minimum_ammount='".mysql_real_escape_string($_REQUEST['minimum_ammount'])."', delivery_estimated_time='".mysql_real_escape_string($_REQUEST['estimated_delivery_time'])."',pickup='".mysql_real_escape_string($_REQUEST['pickup'])."',drive_thru='".mysql_real_escape_string($_REQUEST['drive_thru'])."',tax = '".mysql_real_escape_string($_REQUEST['tax'])."' , commission = '".mysql_real_escape_string($_REQUEST['commission'])."' , del_hours_from = '".$_REQUEST['del_hours_from']."', del_hours_to = '".$_REQUEST['del_hours_to']."', pickup_hours_from = '".$_REQUEST['pickup_hours_from']."' , pickup_hours_to = '".$_REQUEST['pickup_hours_to']."' , reservation_open_Monday = '".date('H:i', strtotime($_REQUEST['reservation_open_Monday']))."' , reservation_close_Monday = '".date('H:i', strtotime($_REQUEST['reservation_close_Monday']))."' , reservation_open_Tuesday = '".date('H:i', strtotime($_REQUEST['reservation_open_Tuesday']))."' , reservation_close_Tuesday = '".date('H:i', strtotime($_REQUEST['reservation_close_Tuesday']))."' , reservation_open_Wednesday = '".date('H:i', strtotime($_REQUEST['reservation_open_Wednesday']))."' , reservation_close_Wednesday = '".date('H:i', strtotime($_REQUEST['reservation_close_Wednesday']))."' , reservation_open_Thursday = '".date('H:i', strtotime($_REQUEST['reservation_open_Thursday']))."' , reservation_close_Thursday = '".date('H:i', strtotime($_REQUEST['reservation_close_Thursday']))."' , reservation_open_Friday = '".date('H:i', strtotime($_REQUEST['reservation_open_Friday']))."' , reservation_close_Friday = '".date('H:i', strtotime($_REQUEST['reservation_close_Friday']))."' , reservation_open_Saturday = '".date('H:i', strtotime($_REQUEST['reservation_open_Saturday']))."' , reservation_close_Saturday = '".date('H:i', strtotime($_REQUEST['reservation_close_Saturday']))."' , reservation_open_Sunday = '".date('H:i', strtotime($_REQUEST['reservation_open_Sunday']))."' , reservation_close_Sunday = '".date('H:i', strtotime($_REQUEST['reservation_close_Sunday']))."' , credit_card_fee = '".$_REQUEST['credit_card_fee']."' , service_fee = '".$_REQUEST['service_fee']."' , del_time_slot1 = '".$_REQUEST['del_time_slot1']."' , del_time_slot2 = '".$_REQUEST['del_time_slot2']."' , del_time_slot3 = '".$_REQUEST['del_time_slot3']."' , del_time_slot4 = '".$_REQUEST['del_time_slot4']."' , del_time_slot5 = '".$_REQUEST['del_time_slot5']."' , del_time_slot6 = '".$_REQUEST['del_time_slot6']."' , pickup_time_slot1 = '".$_REQUEST['pick_time_slot1']."' , pickup_time_slot2 = '".$_REQUEST['pick_time_slot2']."' , pickup_time_slot3 = '".$_REQUEST['pick_time_slot3']."' , pickup_time_slot4 = '".$_REQUEST['pick_time_slot4']."' , pickup_time_slot5 = '".$_REQUEST['pick_time_slot5']."' , pickup_time_slot6 = '".$_REQUEST['pick_time_slot6']."'");
	}
		
	
	$sql_ser_dress = mysql_num_rows(mysql_query("SELECT * FROM restaurant_services_dress_payment WHERE restaurant_id='".mysql_real_escape_string($_REQUEST['hid'])."'"));
	if($sql_ser_dress == 0){
		mysql_query("INSERT INTO restaurant_services_dress_payment set catering_service='".mysql_real_escape_string($_REQUEST['catering_service'])."',self_service='".mysql_real_escape_string($_REQUEST['self_service'])."',waiter_service='".mysql_real_escape_string($_REQUEST['waiter_service'])."',kid_friendly='".mysql_real_escape_string($_REQUEST['kid_friendly'])."',handicape='".mysql_real_escape_string($_REQUEST['handicape'])."',outdoor_seating='".mysql_real_escape_string($_REQUEST['outdoor_seating'])."',alchohol='".mysql_real_escape_string($_REQUEST['alchohol'])."',bar_seating='".mysql_real_escape_string($_REQUEST['bar_seating'])."',wi_fi='".mysql_real_escape_string($_REQUEST['wi_fi'])."',live_music='".mysql_real_escape_string($_REQUEST['live_music'])."',reservation='".mysql_real_escape_string($_REQUEST['reservation'])."',dress_code='".mysql_real_escape_string($_REQUEST['dress_code'])."',payment_method='".mysql_real_escape_string($payment)."', restaurant_id='".mysql_real_escape_string($_REQUEST['hid'])."'");
	}else{
		mysql_query("update restaurant_services_dress_payment set catering_service='".mysql_real_escape_string($_REQUEST['catering_service'])."',self_service='".mysql_real_escape_string($_REQUEST['self_service'])."',waiter_service='".mysql_real_escape_string($_REQUEST['waiter_service'])."',kid_friendly='".mysql_real_escape_string($_REQUEST['kid_friendly'])."',handicape='".mysql_real_escape_string($_REQUEST['handicape'])."',outdoor_seating='".mysql_real_escape_string($_REQUEST['outdoor_seating'])."',alchohol='".mysql_real_escape_string($_REQUEST['alchohol'])."',bar_seating='".mysql_real_escape_string($_REQUEST['bar_seating'])."',wi_fi='".mysql_real_escape_string($_REQUEST['wi_fi'])."',live_music='".mysql_real_escape_string($_REQUEST['live_music'])."',reservation='".mysql_real_escape_string($_REQUEST['reservation'])."',dress_code='".mysql_real_escape_string($_REQUEST['dress_code'])."',payment_method='".mysql_real_escape_string($payment)."' where restaurant_id='".mysql_real_escape_string($_REQUEST['hid'])."'");
	}
	
	
	
	$sql_del_hrs_detail = mysql_num_rows(mysql_query("SELECT * FROM restaurant_delivery_details_master WHERE restaurant_id = '".$_REQUEST['hid']."'"));
	
	if($sql_del_hrs_detail > 0){
		$sql_update_del_hrs = mysql_query("UPDATE restaurant_delivery_details_master SET delivery_from_monday = '".$_REQUEST['delivery_from_monday']."' ,delivery_to_monday = '".$_REQUEST['delivery_to_monday']."' ,delivery_from_tuesday = '".$_REQUEST['delivery_from_tuesday']."' ,delivery_to_tuesday = '".$_REQUEST['delivery_to_tuesday']."' ,delivery_from_wednesday = '".$_REQUEST['delivery_from_wednesday']."' ,delivery_to_wednesday = '".$_REQUEST['delivery_to_wednesday']."' ,delivery_from_thursday = '".$_REQUEST['delivery_from_thursday']."' ,delivery_to_thursday = '".$_REQUEST['delivery_to_thursday']."' ,delivery_from_friday = '".$_REQUEST['delivery_from_friday']."' ,delivery_to_friday = '".$_REQUEST['delivery_to_friday']."' ,delivery_from_saturday = '".$_REQUEST['delivery_from_saturday']."' ,delivery_to_saturday = '".$_REQUEST['delivery_to_saturday']."' ,	delivery_from_sunday = '".$_REQUEST['delivery_from_sunday']."' ,delivery_to_sunday = '".$_REQUEST['delivery_to_sunday']."' WHERE restaurant_id = '".$_REQUEST['hid']."' ");
	}else{
		$sql_insert_del_hrs = mysql_query("INSERT INTO restaurant_delivery_details_master SET restaurant_id = '".$_REQUEST['hid']."' , delivery_from_monday = '".$_REQUEST['delivery_from_monday']."' ,delivery_to_monday = '".$_REQUEST['delivery_to_monday']."' ,delivery_from_tuesday = '".$_REQUEST['delivery_from_tuesday']."' ,delivery_to_tuesday = '".$_REQUEST['delivery_to_tuesday']."' ,delivery_from_wednesday = '".$_REQUEST['delivery_from_wednesday']."' ,delivery_to_wednesday = '".$_REQUEST['delivery_to_wednesday']."' ,delivery_from_thursday = '".$_REQUEST['delivery_from_thursday']."' ,delivery_to_thursday = '".$_REQUEST['delivery_to_thursday']."' ,delivery_from_friday = '".$_REQUEST['delivery_from_friday']."' ,delivery_to_friday = '".$_REQUEST['delivery_to_friday']."' ,delivery_from_saturday = '".$_REQUEST['delivery_from_saturday']."' ,delivery_to_saturday = '".$_REQUEST['delivery_to_saturday']."' ,	delivery_from_sunday = '".$_REQUEST['delivery_from_sunday']."' ,delivery_to_sunday = '".$_REQUEST['delivery_to_sunday']."' ");
	}
	
	
	$sql_pick_hrs_detail = mysql_num_rows(mysql_query("SELECT * FROM restaurant_take_out_master WHERE restaurant_id = '".$_REQUEST['hid']."'"));
	
	if($sql_del_hrs_detail > 0){
		$sql_update_pickup_hrs = mysql_query("UPDATE restaurant_take_out_master SET from_time_monday = '".$_REQUEST['from_time_monday']."' ,to_time_monday = '".$_REQUEST['to_time_monday']."' ,from_time_tuesday = '".$_REQUEST['from_time_tuesday']."' ,to_time_tuesday = '".$_REQUEST['to_time_tuesday']."' ,from_time_wednesday = '".$_REQUEST['from_time_wednesday']."' ,to_time_wednesday = '".$_REQUEST['to_time_wednesday']."' ,from_time_thursday = '".$_REQUEST['from_time_thursday']."' ,to_time_thursday = '".$_REQUEST['to_time_thursday']."' ,from_time_friday = '".$_REQUEST['from_time_friday']."' ,to_time_friday = '".$_REQUEST['to_time_friday']."' ,from_time_saturday = '".$_REQUEST['from_time_saturday']."' ,to_time_saturday = '".$_REQUEST['to_time_saturday']."' ,	from_time_sunday = '".$_REQUEST['from_time_sunday']."' ,to_time_sunday = '".$_REQUEST['to_time_sunday']."' WHERE restaurant_id = '".$_REQUEST['hid']."' ");
	}else{
		$sql_insert_pickup_hrs = mysql_query("INSERT INTO restaurant_take_out_master SET restaurant_id = '".$_REQUEST['hid']."' , from_time_monday = '".$_REQUEST['from_time_monday']."' ,to_time_monday = '".$_REQUEST['to_time_monday']."' ,from_time_tuesday = '".$_REQUEST['from_time_tuesday']."' ,to_time_tuesday = '".$_REQUEST['to_time_tuesday']."' ,from_time_wednesday = '".$_REQUEST['from_time_wednesday']."' ,to_time_wednesday = '".$_REQUEST['to_time_wednesday']."' ,from_time_thursday = '".$_REQUEST['from_time_thursday']."' ,to_time_thursday = '".$_REQUEST['to_time_thursday']."' ,from_time_friday = '".$_REQUEST['from_time_friday']."' ,to_time_friday = '".$_REQUEST['to_time_friday']."' ,from_time_saturday = '".$_REQUEST['from_time_saturday']."' ,to_time_saturday = '".$_REQUEST['to_time_saturday']."' ,	from_time_sunday = '".$_REQUEST['from_time_sunday']."' ,to_time_sunday = '".$_REQUEST['to_time_sunday']."' ");
	}
	
	
	$sql_select_business_extrahours = mysql_query("SELECT * FROM restaurant_extra_business_hours WHERE restaurant_id = '".$_REQUEST['hid']."'");
	$k = 1;
	while($array_business_extrahours = mysql_fetch_array($sql_select_business_extrahours)){
		$sql_update_business_hours = mysql_query("UPDATE restaurant_extra_business_hours SET title = '".$_REQUEST['businesshours_title'.$k]."' , hours = '".$_REQUEST['hours'.$k]."', hours_from = '".$_REQUEST['hoursfrom'.$k]."' WHERE id = '".$array_business_extrahours['id']."'");
		$k++;
	}
	
	$sql_select_business_hrs = mysql_query("SELECT * FROM restaurant_delivery_details_master WHERE restaurant_id = '".$_REQUEST['hid']."'");
	$i = 1;
	while($array_business_extrahours = mysql_fetch_array($sql_select_business_hrs)){
		$sql_update_business_hours = mysql_query("UPDATE restaurant_delivery_details_master SET delivery_from = '".$_REQUEST['delhoursfrom_'.$i]."', delivery_to = '".$_REQUEST['delhoursto_'.$i]."' WHERE id = '".$array_business_extrahours['id']."'");
		$i++;
	}
	
	$sql_select_pickup_hrs = mysql_query("SELECT * FROM restaurant_take_out_master WHERE restaurant_id = '".$_REQUEST['hid']."'");
	$m = 1;
	while($array_business_pickup_hours = mysql_fetch_array($sql_select_pickup_hrs)){
		$sql_update_business_hours = mysql_query("UPDATE restaurant_take_out_master SET from_time = '".$_REQUEST['pickuphoursfrom_'.$m]."', to_time = '".$_REQUEST['pickuphoursto_'.$m]."' WHERE id = '".$array_business_pickup_hours['id']."'");
		$m++;
	}
	
	$sql_select_del_charges = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '".$result_additional['restaurant_id']."'");
$j = 1;
while($array_del_charges = mysql_fetch_array($sql_select_del_charges)){
	$sql_update_del_charges = mysql_query("UPDATE restaurant_delivery_charge SET delivery_range = '".$_REQUEST['delivery_range_'.$j]."',delivery_charge = '".$_REQUEST['delivery_charge_'.$j]."' WHERE id = '".$array_del_charges['id']."'");
	$j++;
	}
	
	foreach($_POST['countdiv'] as $countDiv){
		$restaurant_id = $_SESSION['rest_id'];
		$business_hours_title = $_POST['business_hours_title'.$countDiv];
		$hours = $_POST['hours_'.$countDiv];
		$hours_from = $_POST['hours_from_'.$countDiv];
		
		$sql_extra_business_hours = "insert into restaurant_extra_business_hours set restaurant_id='".$_REQUEST['hid']."', title='".$business_hours_title."', hours='".$hours."' , hours_from = '".$hours_from."'";
		mysql_query($sql_extra_business_hours);
	}
	
	foreach($_POST['countdiv_del_hrs'] as $countdiv_Del_Hrs){
		$restaurant_id = $_SESSION['rest_id'];
		$delivery_from = $_POST['del_hours_from_'.$countdiv_Del_Hrs];
		$delivery_to = $_POST['del_hours_to_'.$countdiv_Del_Hrs];
		
		$sql_restaurant_delivery_hrs = "insert into restaurant_delivery_details_master set restaurant_id='".$_REQUEST['hid']."', delivery_to='".$delivery_to."', delivery_from = '".$delivery_from."' ";
		mysql_query($sql_restaurant_delivery_hrs);
	}
	
	foreach($_POST['countdiv_pickup_hrs'] as $countdiv_Pickup_Hrs){
		$restaurant_id = $_SESSION['rest_id'];
		$pickup_from = $_POST['pickup_hours_from_'.$countdiv_Pickup_Hrs];
		$pickup_to = $_POST['pickup_hours_to_'.$countdiv_Pickup_Hrs];
		
		$sql_restaurant_pickup_hrs = "insert into restaurant_take_out_master set restaurant_id='".$_REQUEST['hid']."', from_time='".$pickup_from."', to_time = '".$pickup_to."' ";
		mysql_query($sql_restaurant_pickup_hrs);
	}
	
	
	foreach($_POST['countdiv_del'] as $countDiv_del){
	$restaurant_id = $res_basic_info['id'];
	$delivery_range = $_POST['delivery_range'.$countDiv_del];
	$delivery_charge = $_POST['delivery_charge'.$countDiv_del];
	
	$sql_del_charge = "insert into restaurant_delivery_charge SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', delivery_range='".$delivery_range."', delivery_charge='".$delivery_charge."'";
	mysql_query($sql_del_charge);
		}
		
	$sql_select_delivery_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'");
	$num_del_rows = mysql_num_rows($sql_select_delivery_crge);
	
	if($num_del_rows == 0){
		$sql_update_delivery = mysql_query("UPDATE restaurant_business_delivery_takeout_info SET free_delivery = '1' WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'");
	}else{
		$sql_update_delivery = mysql_query("UPDATE restaurant_business_delivery_takeout_info SET free_delivery = '' WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'");
	}
	
	
	/*--------------------------------------- Update Monday Business Hours ---------------------------------------------*/
	$sql_mon_bussiness_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '1'");
	$k_mon = 1;
	while($array_mon_bussiness_hrs = mysql_fetch_array($sql_mon_bussiness_hrs)){
		$sql_update_mon_buss_hrs = mysql_query("UPDATE restaurant_buss_hrs SET time_from = '".$_REQUEST['businesshoursmon_from'.$k_mon]."' , time_to = '".$_REQUEST['businesshoursmon_to'.$k_mon]."' WHERE id = '".$array_mon_bussiness_hrs['id']."'");
		$k_mon++;
	}
	/*--------------------------------------- Update Monday Business Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Tuesday Business Hours ---------------------------------------------*/
	$sql_tue_bussiness_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '2'");
	$k_tue = 1;
	while($array_tue_bussiness_hrs = mysql_fetch_array($sql_tue_bussiness_hrs)){
		$sql_update_tue_buss_hrs = mysql_query("UPDATE restaurant_buss_hrs SET time_from = '".$_REQUEST['businesshourstue_from'.$k_tue]."' , time_to = '".$_REQUEST['businesshourstue_to'.$k_tue]."' WHERE id = '".$array_tue_bussiness_hrs['id']."'");
		$k_tue++;
	}
	/*--------------------------------------- Update Tuesday Business Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Wednesday Business Hours ---------------------------------------------*/
	$sql_wed_bussiness_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '3'");
	$k_wed = 1;
	while($array_wed_bussiness_hrs = mysql_fetch_array($sql_wed_bussiness_hrs)){
		$sql_update_wed_buss_hrs = mysql_query("UPDATE restaurant_buss_hrs SET time_from = '".$_REQUEST['businesshourswed_from'.$k_wed]."' , time_to = '".$_REQUEST['businesshourswed_to'.$k_wed]."' WHERE id = '".$array_wed_bussiness_hrs['id']."'");
		$k_wed++;
	}
	/*--------------------------------------- Update Wednesday Business Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Thursday Business Hours ---------------------------------------------*/
	$sql_thu_bussiness_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '4'");
	$k_thu = 1;
	while($array_thu_bussiness_hrs = mysql_fetch_array($sql_thu_bussiness_hrs)){
		$sql_update_thu_buss_hrs = mysql_query("UPDATE restaurant_buss_hrs SET time_from = '".$_REQUEST['businesshoursthu_from'.$k_thu]."' , time_to = '".$_REQUEST['businesshoursthu_to'.$k_thu]."' WHERE id = '".$array_thu_bussiness_hrs['id']."'");
		$k_thu++;
	}
	/*--------------------------------------- Update Thursday Business Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Friday Business Hours ---------------------------------------------*/
	$sql_fri_bussiness_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '5'");
	$k_fri = 1;
	while($array_fri_bussiness_hrs = mysql_fetch_array($sql_fri_bussiness_hrs)){
		$sql_update_fri_buss_hrs = mysql_query("UPDATE restaurant_buss_hrs SET time_from = '".$_REQUEST['businesshoursfri_from'.$k_fri]."' , time_to = '".$_REQUEST['businesshoursfri_to'.$k_fri]."' WHERE id = '".$array_fri_bussiness_hrs['id']."'");
		$k_fri++;
	}
	/*--------------------------------------- Update Friday Business Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Saturday Business Hours ---------------------------------------------*/
	$sql_sat_bussiness_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '6'");
	$k_sat = 1;
	while($array_sat_bussiness_hrs = mysql_fetch_array($sql_sat_bussiness_hrs)){
		$sql_update_sat_buss_hrs = mysql_query("UPDATE restaurant_buss_hrs SET time_from = '".$_REQUEST['businesshourssat_from'.$k_sat]."' , time_to = '".$_REQUEST['businesshourssat_to'.$k_sat]."' WHERE id = '".$array_sat_bussiness_hrs['id']."'");
		$k_sat++;
	}
	/*--------------------------------------- Update Saturday Business Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Sunday Business Hours ---------------------------------------------*/
	$sql_sun_bussiness_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '7'");
	$k_sun = 1;
	while($array_sun_bussiness_hrs = mysql_fetch_array($sql_sun_bussiness_hrs)){
		$sql_update_sun_buss_hrs = mysql_query("UPDATE restaurant_buss_hrs SET time_from = '".$_REQUEST['businesshourssun_from'.$k_sun]."' , time_to = '".$_REQUEST['businesshourssun_to'.$k_sun]."' WHERE id = '".$array_sun_bussiness_hrs['id']."'");
		$k_sun++;
	}
	/*--------------------------------------- Update Sunday Business Hours ---------------------------------------------*/
	
	
	
	/*------------------------------------------- Monday Business Hours -------------------------------------------------*/
	foreach($_POST['countdiv_monday'] as $countdiv_monday){
		$restaurant_id = $res_basic_info['id'];
		$bus_hrs_mon_from = $_POST['business_hours_mon_from'.$countdiv_monday];
		$bus_hrs_mon_to = $_POST['business_hours_mon_to'.$countdiv_monday];
		
		if($bus_hrs_mon_from!='' && $bus_hrs_mon_to!=''){
			$sql_bus_hrs_monday = "INSERT INTO restaurant_buss_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='1', time_from='".$bus_hrs_mon_from."' , time_to = '".$bus_hrs_mon_to."' ";
			mysql_query($sql_bus_hrs_monday);
		}
	}
	/*------------------------------------------- Monday Business Hours -------------------------------------------------*/
	
	
	
	
	/*------------------------------------------- Tuesday Business Hours -------------------------------------------------*/
	foreach($_POST['countdiv_tuesday'] as $countdiv_tuesday){
		$restaurant_id = $res_basic_info['id'];
		$bus_hrs_tue_from = $_POST['business_hours_tue_from'.$countdiv_tuesday];
		$bus_hrs_tue_to = $_POST['business_hours_tue_to'.$countdiv_tuesday];
		
		if($bus_hrs_tue_from!='' && $bus_hrs_tue_to!=''){
			$sql_bus_hrs_tuesday = "INSERT INTO restaurant_buss_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='2', time_from='".$bus_hrs_tue_from."' , time_to = '".$bus_hrs_tue_to."' ";
			mysql_query($sql_bus_hrs_tuesday);
		}
	}
	/*------------------------------------------- Tuesday Business Hours -------------------------------------------------*/
	
	
	
	/*------------------------------------------- Wednesday Business Hours -------------------------------------------------*/
	foreach($_POST['countdiv_wednesday'] as $countdiv_wednesday){
		$restaurant_id = $res_basic_info['id'];
		$bus_hrs_wed_from = $_POST['business_hours_wed_from'.$countdiv_wednesday];
		$bus_hrs_wed_to = $_POST['business_hours_wed_to'.$countdiv_wednesday];
		
		if($bus_hrs_wed_from!='' && $bus_hrs_wed_to!=''){
			$sql_bus_hrs_wednesday = "INSERT INTO restaurant_buss_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='3', time_from='".$bus_hrs_wed_from."' , time_to = '".$bus_hrs_wed_to."' ";
			mysql_query($sql_bus_hrs_wednesday);
		}
	}
	/*------------------------------------------- Wednesday Business Hours -------------------------------------------------*/
	
	/*------------------------------------------- Thursday Business Hours -------------------------------------------------*/
	foreach($_POST['countdiv_thursday'] as $countdiv_thursday){
		$restaurant_id = $res_basic_info['id'];
		$bus_hrs_thu_from = $_POST['business_hours_thu_from'.$countdiv_thursday];
		$bus_hrs_thu_to = $_POST['business_hours_thu_to'.$countdiv_thursday];
		
		if($bus_hrs_thu_from!='' && $bus_hrs_thu_to!=''){
			$sql_bus_hrs_thursday = "INSERT INTO restaurant_buss_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='4', time_from='".$bus_hrs_thu_from."' , time_to = '".$bus_hrs_thu_to."' ";
			mysql_query($sql_bus_hrs_thursday);
		}
	}
	/*------------------------------------------- Thursday Business Hours -------------------------------------------------*/
	
	
	/*------------------------------------------- Friday Business Hours -------------------------------------------------*/
	foreach($_POST['countdiv_friday'] as $countdiv_friday){
		$restaurant_id = $res_basic_info['id'];
		$bus_hrs_fri_from = $_POST['business_hours_fri_from'.$countdiv_friday];
		$bus_hrs_fri_to = $_POST['business_hours_fri_to'.$countdiv_friday];
		
		if($bus_hrs_fri_from!='' && $bus_hrs_fri_to!=''){
			$sql_bus_hrs_friday = "INSERT INTO restaurant_buss_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='5', time_from='".$bus_hrs_fri_from."' , time_to = '".$bus_hrs_fri_to."' ";
			mysql_query($sql_bus_hrs_friday);
		}
	}
	/*------------------------------------------- Friday Business Hours -------------------------------------------------*/
	
	
	/*------------------------------------------- Saturday Business Hours -------------------------------------------------*/
	foreach($_POST['countdiv_saturday'] as $countdiv_saturday){
		$restaurant_id = $res_basic_info['id'];
		$bus_hrs_sat_from = $_POST['business_hours_sat_from'.$countdiv_saturday];
		$bus_hrs_sat_to = $_POST['business_hours_sat_to'.$countdiv_saturday];
		
		if($bus_hrs_sat_from!='' && $bus_hrs_sat_to!=''){
			$sql_bus_hrs_saturday = "INSERT INTO restaurant_buss_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='6', time_from='".$bus_hrs_sat_from."' , time_to = '".$bus_hrs_sat_to."' ";
			mysql_query($sql_bus_hrs_saturday);
		}
	}
	/*------------------------------------------- Saturday Business Hours -------------------------------------------------*/
	
	
	/*------------------------------------------- Sunday Business Hours -------------------------------------------------*/
	foreach($_POST['countdiv_sunday'] as $countdiv_sunday){
		$restaurant_id = $res_basic_info['id'];
		$bus_hrs_sun_from = $_POST['business_hours_sun_from'.$countdiv_sunday];
		$bus_hrs_sun_to = $_POST['business_hours_sun_to'.$countdiv_sunday];
		
		if($bus_hrs_sun_from!='' && $bus_hrs_sun_to!=''){
			$sql_bus_hrs_sunday = "INSERT INTO restaurant_buss_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='7', time_from='".$bus_hrs_sun_from."' , time_to = '".$bus_hrs_sun_to."' ";
			mysql_query($sql_bus_hrs_sunday);
		}
	}
	/*------------------------------------------- Sunday Business Hours -------------------------------------------------*/
	
	
	/*--------------------------------------- Update Monday Delivery Hours ---------------------------------------------*/
	$sql_mon_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '1'");
	$k_mon = 1;
	while($array_mon_del_hrs = mysql_fetch_array($sql_mon_del_hrs)){
		$sql_update_mon_del_hrs = mysql_query("UPDATE restaurant_del_hrs SET time_from = '".$_REQUEST['deliveryhoursmon_from'.$k_mon]."' , time_to = '".$_REQUEST['deliveryhoursmon_to'.$k_mon]."' WHERE id = '".$array_mon_del_hrs['id']."'");
		$k_mon++;
	}
	/*--------------------------------------- Update Monday Delivery Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Tuesday Delivery Hours ---------------------------------------------*/
	$sql_tue_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '2'");
	$k_tue = 1;
	while($array_tue_del_hrs = mysql_fetch_array($sql_tue_del_hrs)){
		$sql_update_tue_del_hrs = mysql_query("UPDATE restaurant_del_hrs SET time_from = '".$_REQUEST['deliveryhourstue_from'.$k_tue]."' , time_to = '".$_REQUEST['deliveryhourstue_to'.$k_tue]."' WHERE id = '".$array_tue_del_hrs['id']."'");
		$k_tue++;
	}
	/*--------------------------------------- Update Tuesday Delivery Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Wednesday Delivery Hours ---------------------------------------------*/
	$sql_wed_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '3'");
	$k_wed = 1;
	while($array_wed_del_hrs = mysql_fetch_array($sql_wed_del_hrs)){
		$sql_update_wed_del_hrs = mysql_query("UPDATE restaurant_del_hrs SET time_from = '".$_REQUEST['deliveryhourswed_from'.$k_wed]."' , time_to = '".$_REQUEST['deliveryhourswed_to'.$k_wed]."' WHERE id = '".$array_wed_del_hrs['id']."'");
		$k_wed++;
	}
	/*--------------------------------------- Update Wednesday Delivery Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Thursday Delivery Hours ---------------------------------------------*/
	$sql_thu_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '4'");
	$k_thu = 1;
	while($array_thu_del_hrs = mysql_fetch_array($sql_thu_del_hrs)){
		$sql_update_thu_del_hrs = mysql_query("UPDATE restaurant_del_hrs SET time_from = '".$_REQUEST['deliveryhoursthu_from'.$k_thu]."' , time_to = '".$_REQUEST['deliveryhoursthu_to'.$k_thu]."' WHERE id = '".$array_thu_del_hrs['id']."'");
		$k_thu++;
	}
	/*--------------------------------------- Update Thursday Delivery Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Friday Delivery Hours ---------------------------------------------*/
	$sql_fri_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '5'");
	$k_fri = 1;
	while($array_fri_del_hrs = mysql_fetch_array($sql_fri_del_hrs)){
		$sql_update_fri_del_hrs = mysql_query("UPDATE restaurant_del_hrs SET time_from = '".$_REQUEST['deliveryhoursfri_from'.$k_fri]."' , time_to = '".$_REQUEST['deliveryhoursfri_to'.$k_fri]."' WHERE id = '".$array_fri_del_hrs['id']."'");
		$k_fri++;
	}
	/*--------------------------------------- Update Friday Delivery Hours ---------------------------------------------*/
	
	
	
	/*--------------------------------------- Update Saturday Delivery Hours ---------------------------------------------*/
	$sql_sat_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '6'");
	$k_sat = 1;
	while($array_sat_del_hrs = mysql_fetch_array($sql_sat_del_hrs)){
		$sql_update_sat_del_hrs = mysql_query("UPDATE restaurant_del_hrs SET time_from = '".$_REQUEST['deliveryhourssat_from'.$k_sat]."' , time_to = '".$_REQUEST['deliveryhourssat_to'.$k_sat]."' WHERE id = '".$array_sat_del_hrs['id']."'");
		$k_sat++;
	}
	/*--------------------------------------- Update Saturday Delivery Hours ---------------------------------------------*/
	
	
	
	/*--------------------------------------- Update Sunday Delivery Hours ---------------------------------------------*/
	$sql_sun_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '7'");
	$k_sun = 1;
	while($array_sun_del_hrs = mysql_fetch_array($sql_sun_del_hrs)){
		$sql_update_sun_del_hrs = mysql_query("UPDATE restaurant_del_hrs SET time_from = '".$_REQUEST['deliveryhourssun_from'.$k_sun]."' , time_to = '".$_REQUEST['deliveryhourssun_to'.$k_sun]."' WHERE id = '".$array_sun_del_hrs['id']."'");
		$k_sun++;
	}
	/*--------------------------------------- Update Sunday Delivery Hours ---------------------------------------------*/
	
	
	/*------------------------------------------- Monday Delivery Hours -------------------------------------------------*/
	foreach($_POST['countdiv_del_monday'] as $countdiv_del_monday){
		$restaurant_id = $res_basic_info['id'];
		$del_hrs_mon_from = $_POST['delivery_hours_mon_from'.$countdiv_del_monday];
		$del_hrs_mon_to = $_POST['delivery_hours_mon_to'.$countdiv_del_monday];
		
		if($del_hrs_mon_from!='' && $del_hrs_mon_to!=''){
			$sql_del_hrs_monday = "INSERT INTO restaurant_del_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='1', time_from='".$del_hrs_mon_from."' , time_to = '".$del_hrs_mon_to."' ";
			mysql_query($sql_del_hrs_monday);
		}
	}
	/*------------------------------------------- Monday Delivery Hours -------------------------------------------------*/
	
	
	/*------------------------------------------- Tuesday Delivery Hours -------------------------------------------------*/
	foreach($_POST['countdiv_del_tuesday'] as $countdiv_del_tuesday){
		$restaurant_id = $res_basic_info['id'];
		$del_hrs_tue_from = $_POST['delivery_hours_tue_from'.$countdiv_del_tuesday];
		$del_hrs_tue_to = $_POST['delivery_hours_tue_to'.$countdiv_del_tuesday];
		
		if($del_hrs_tue_from!='' && $del_hrs_tue_to!=''){
			$sql_del_hrs_tuesday = "INSERT INTO restaurant_del_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='2', time_from='".$del_hrs_tue_from."' , time_to = '".$del_hrs_tue_to."' ";
			mysql_query($sql_del_hrs_tuesday);
		}
	}
	/*------------------------------------------- Tuesday Delivery Hours -------------------------------------------------*/
	
	
	/*------------------------------------------- Wednesday Delivery Hours -------------------------------------------------*/
	foreach($_POST['countdiv_del_wednesday'] as $countdiv_del_wednesday){
		$restaurant_id = $res_basic_info['id'];
		$del_hrs_wed_from = $_POST['delivery_hours_wed_from'.$countdiv_del_wednesday];
		$del_hrs_wed_to = $_POST['delivery_hours_wed_to'.$countdiv_del_wednesday];
		
		if($del_hrs_wed_from!='' && $del_hrs_wed_to!=''){
			$sql_del_hrs_wednesday = "INSERT INTO restaurant_del_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='3', time_from='".$del_hrs_wed_from."' , time_to = '".$del_hrs_wed_to."' ";
			mysql_query($sql_del_hrs_wednesday);
		}
	}
	/*------------------------------------------- Wednesday Delivery Hours -------------------------------------------------*/
	
	
	/*------------------------------------------- Thursday Delivery Hours -------------------------------------------------*/
	foreach($_POST['countdiv_del_thursday'] as $countdiv_del_thursday){
		$restaurant_id = $res_basic_info['id'];
		$del_hrs_thu_from = $_POST['delivery_hours_thu_from'.$countdiv_del_thursday];
		$del_hrs_thu_to = $_POST['delivery_hours_thu_to'.$countdiv_del_thursday];
		
		if($del_hrs_thu_from!='' && $del_hrs_thu_to!=''){
			$sql_del_hrs_thursday = "INSERT INTO restaurant_del_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='4', time_from='".$del_hrs_thu_from."' , time_to = '".$del_hrs_thu_to."' ";
			mysql_query($sql_del_hrs_thursday);
		}
	}
	/*------------------------------------------- Thursday Delivery Hours -------------------------------------------------*/
	
	
	
	/*------------------------------------------- Friday Delivery Hours -------------------------------------------------*/
	foreach($_POST['countdiv_del_friday'] as $countdiv_del_friday){
		$restaurant_id = $res_basic_info['id'];
		$del_hrs_fri_from = $_POST['delivery_hours_fri_from'.$countdiv_del_friday];
		$del_hrs_fri_to = $_POST['delivery_hours_fri_to'.$countdiv_del_friday];
		
		if($del_hrs_fri_from!='' && $del_hrs_fri_to!=''){
			$sql_del_hrs_friday = "INSERT INTO restaurant_del_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='5', time_from='".$del_hrs_fri_from."' , time_to = '".$del_hrs_fri_to."' ";
			mysql_query($sql_del_hrs_friday);
		}
	}
	/*------------------------------------------- Friday Delivery Hours -------------------------------------------------*/
	
	
	
	/*------------------------------------------- Saturday Delivery Hours -------------------------------------------------*/
	foreach($_POST['countdiv_del_saturday'] as $countdiv_del_saturday){
		$restaurant_id = $res_basic_info['id'];
		$del_hrs_sat_from = $_POST['delivery_hours_sat_from'.$countdiv_del_saturday];
		$del_hrs_sat_to = $_POST['delivery_hours_sat_to'.$countdiv_del_saturday];
		
		if($del_hrs_sat_from!='' && $del_hrs_sat_to!=''){
			$sql_del_hrs_saturday = "INSERT INTO restaurant_del_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='6', time_from='".$del_hrs_sat_from."' , time_to = '".$del_hrs_sat_to."' ";
			mysql_query($sql_del_hrs_saturday);
		}
	}
	/*------------------------------------------- Saturday Delivery Hours -------------------------------------------------*/
	
	
	
	/*------------------------------------------- Sunday Delivery Hours -------------------------------------------------*/
	foreach($_POST['countdiv_del_sunday'] as $countdiv_del_sunday){
		$restaurant_id = $res_basic_info['id'];
		$del_hrs_sun_from = $_POST['delivery_hours_sun_from'.$countdiv_del_sunday];
		$del_hrs_sun_to = $_POST['delivery_hours_sun_to'.$countdiv_del_sunday];
		
		if($del_hrs_sun_from!='' && $del_hrs_sun_to!=''){
			$sql_del_hrs_sunday = "INSERT INTO restaurant_del_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='7', time_from='".$del_hrs_sun_from."' , time_to = '".$del_hrs_sun_to."' ";
			mysql_query($sql_del_hrs_sunday);
		}
	}
	/*------------------------------------------- Sunday Delivery Hours -------------------------------------------------*/
	
	
	
	/*--------------------------------------- Update Monday Pickup Hours ---------------------------------------------*/
	$sql_mon_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '1'");
	$k_mon = 1;
	while($array_mon_pickup_hrs = mysql_fetch_array($sql_mon_pickup_hrs)){
		$sql_update_mon_pickup_hrs = mysql_query("UPDATE restaurant_pickup_hrs SET time_from = '".$_REQUEST['pickuphoursmon_from'.$k_mon]."' , time_to = '".$_REQUEST['pickuphoursmon_to'.$k_mon]."' WHERE id = '".$array_mon_pickup_hrs['id']."'");
		$k_mon++;
	}
	/*--------------------------------------- Update Monday Pickup Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Tuesday Pickup Hours ---------------------------------------------*/
	$sql_tue_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '2'");
	$k_tue = 1;
	while($array_tue_pickup_hrs = mysql_fetch_array($sql_tue_pickup_hrs)){
		$sql_update_tue_pickup_hrs = mysql_query("UPDATE restaurant_pickup_hrs SET time_from = '".$_REQUEST['pickuphourstue_from'.$k_tue]."' , time_to = '".$_REQUEST['pickuphourstue_to'.$k_tue]."' WHERE id = '".$array_tue_pickup_hrs['id']."'");
		$k_tue++;
	}
	/*--------------------------------------- Update Tuesday Pickup Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Wednesday Pickup Hours ---------------------------------------------*/
	$sql_wed_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '3'");
	$k_wed = 1;
	while($array_wed_pickup_hrs = mysql_fetch_array($sql_wed_pickup_hrs)){
		$sql_update_wed_pickup_hrs = mysql_query("UPDATE restaurant_pickup_hrs SET time_from = '".$_REQUEST['pickuphourswed_from'.$k_wed]."' , time_to = '".$_REQUEST['pickuphourswed_to'.$k_wed]."' WHERE id = '".$array_wed_pickup_hrs['id']."'");
		$k_wed++;
	}
	/*--------------------------------------- Update Wednesday Pickup Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Thursday Pickup Hours ---------------------------------------------*/
	$sql_thu_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '4'");
	$k_thu = 1;
	while($array_thu_pickup_hrs = mysql_fetch_array($sql_thu_pickup_hrs)){
		$sql_update_thu_pickup_hrs = mysql_query("UPDATE restaurant_pickup_hrs SET time_from = '".$_REQUEST['pickuphoursthu_from'.$k_thu]."' , time_to = '".$_REQUEST['pickuphoursthu_to'.$k_thu]."' WHERE id = '".$array_thu_pickup_hrs['id']."'");
		$k_thu++;
	}
	/*--------------------------------------- Update Thursday Pickup Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Friday Pickup Hours ---------------------------------------------*/
	$sql_fri_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '5'");
	$k_fri = 1;
	while($array_fri_pickup_hrs = mysql_fetch_array($sql_fri_pickup_hrs)){
		$sql_update_fri_pickup_hrs = mysql_query("UPDATE restaurant_pickup_hrs SET time_from = '".$_REQUEST['pickuphoursfri_from'.$k_fri]."' , time_to = '".$_REQUEST['pickuphoursfri_to'.$k_fri]."' WHERE id = '".$array_fri_pickup_hrs['id']."'");
		$k_fri++;
	}
	/*--------------------------------------- Update Friday Pickup Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Saturday Pickup Hours ---------------------------------------------*/
	$sql_sat_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '6'");
	$k_sat = 1;
	while($array_sat_pickup_hrs = mysql_fetch_array($sql_sat_pickup_hrs)){
		$sql_update_sat_pickup_hrs = mysql_query("UPDATE restaurant_pickup_hrs SET time_from = '".$_REQUEST['pickuphourssat_from'.$k_sat]."' , time_to = '".$_REQUEST['pickuphourssat_to'.$k_sat]."' WHERE id = '".$array_sat_pickup_hrs['id']."'");
		$k_sat++;
	}
	/*--------------------------------------- Update Saturday Pickup Hours ---------------------------------------------*/
	
	
	/*--------------------------------------- Update Sunday Pickup Hours ---------------------------------------------*/
	$sql_sun_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['hid']."' AND days_id = '7'");
	$k_sun = 1;
	while($array_sun_pickup_hrs = mysql_fetch_array($sql_sun_pickup_hrs)){
		$sql_update_sun_pickup_hrs = mysql_query("UPDATE restaurant_pickup_hrs SET time_from = '".$_REQUEST['pickuphourssun_from'.$k_sun]."' , time_to = '".$_REQUEST['pickuphourssun_to'.$k_sun]."' WHERE id = '".$array_sun_pickup_hrs['id']."'");
		$k_sun++;
	}
	/*--------------------------------------- Update Sunday Pickup Hours ---------------------------------------------*/
	
	
	/*------------------------------------------- Monday Pickup Hours -------------------------------------------------*/
	foreach($_POST['countdiv_pickup_monday'] as $countdiv_pickup_monday){
		$restaurant_id = $res_basic_info['id'];
		$pickup_hrs_mon_from = $_POST['pickup_hours_mon_from'.$countdiv_pickup_monday];
		$pickup_hrs_mon_to = $_POST['pickup_hours_mon_to'.$countdiv_pickup_monday];
		
		if($pickup_hrs_mon_from!='' && $pickup_hrs_mon_to!=''){
			$sql_pickup_hrs_monday = "INSERT INTO restaurant_pickup_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='1', time_from='".$pickup_hrs_mon_from."' , time_to = '".$pickup_hrs_mon_to."' ";
			mysql_query($sql_pickup_hrs_monday);
		}
	}
	/*------------------------------------------- Monday Pickup Hours -------------------------------------------------*/
	
	
	/*------------------------------------------- Tuesday Pickup Hours -------------------------------------------------*/
	foreach($_POST['countdiv_pickup_tuesday'] as $countdiv_pickup_tuesday){
		$restaurant_id = $res_basic_info['id'];
		$pickup_hrs_tue_from = $_POST['pickup_hours_tue_from'.$countdiv_pickup_tuesday];
		$pickup_hrs_tue_to = $_POST['pickup_hours_tue_to'.$countdiv_pickup_tuesday];
		
		if($pickup_hrs_tue_from!='' && $pickup_hrs_tue_to!=''){
			$sql_pickup_hrs_tuesday = "INSERT INTO restaurant_pickup_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='2', time_from='".$pickup_hrs_tue_from."' , time_to = '".$pickup_hrs_tue_to."' ";
			mysql_query($sql_pickup_hrs_tuesday);
		}
	}
	/*------------------------------------------- Tuesday Pickup Hours -------------------------------------------------*/
	
	
	
	/*------------------------------------------- Wednesday Pickup Hours -------------------------------------------------*/
	foreach($_POST['countdiv_pickup_wednesday'] as $countdiv_pickup_wednesday){
		$restaurant_id = $res_basic_info['id'];
		$pickup_hrs_wed_from = $_POST['pickup_hours_wed_from'.$countdiv_pickup_wednesday];
		$pickup_hrs_wed_to = $_POST['pickup_hours_wed_to'.$countdiv_pickup_wednesday];
		
		if($pickup_hrs_wed_from!='' && $pickup_hrs_wed_to!=''){
			$sql_pickup_hrs_wednesday = "INSERT INTO restaurant_pickup_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='3', time_from='".$pickup_hrs_wed_from."' , time_to = '".$pickup_hrs_wed_to."' ";
			mysql_query($sql_pickup_hrs_wednesday);
		}
	}
	/*------------------------------------------- Wednesday Pickup Hours -------------------------------------------------*/
	
	
	/*------------------------------------------- Thursday Pickup Hours -------------------------------------------------*/
	foreach($_POST['countdiv_pickup_thursday'] as $countdiv_pickup_thursday){
		$restaurant_id = $res_basic_info['id'];
		$pickup_hrs_thu_from = $_POST['pickup_hours_thu_from'.$countdiv_pickup_thursday];
		$pickup_hrs_thu_to = $_POST['pickup_hours_thu_to'.$countdiv_pickup_thursday];
		
		if($pickup_hrs_thu_from!='' && $pickup_hrs_thu_to!=''){
			$sql_pickup_hrs_thursday = "INSERT INTO restaurant_pickup_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='4', time_from='".$pickup_hrs_thu_from."' , time_to = '".$pickup_hrs_thu_to."' ";
			mysql_query($sql_pickup_hrs_thursday);
		}
	}
	/*------------------------------------------- Thursday Pickup Hours -------------------------------------------------*/
	
	
	
	/*------------------------------------------- Friday Pickup Hours -------------------------------------------------*/
	foreach($_POST['countdiv_pickup_friday'] as $countdiv_pickup_friday){
		$restaurant_id = $res_basic_info['id'];
		$pickup_hrs_fri_from = $_POST['pickup_hours_fri_from'.$countdiv_pickup_friday];
		$pickup_hrs_fri_to = $_POST['pickup_hours_fri_to'.$countdiv_pickup_friday];
		
		if($pickup_hrs_fri_from!='' && $pickup_hrs_fri_to!=''){
			$sql_pickup_hrs_friday = "INSERT INTO restaurant_pickup_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='5', time_from='".$pickup_hrs_fri_from."' , time_to = '".$pickup_hrs_fri_to."' ";
			mysql_query($sql_pickup_hrs_friday);
		}
	}
	/*------------------------------------------- Friday Pickup Hours -------------------------------------------------*/
	
	
	
	/*------------------------------------------- Saturday Pickup Hours -------------------------------------------------*/
	foreach($_POST['countdiv_pickup_saturday'] as $countdiv_pickup_saturday){
		$restaurant_id = $res_basic_info['id'];
		$pickup_hrs_sat_from = $_POST['pickup_hours_sat_from'.$countdiv_pickup_saturday];
		$pickup_hrs_sat_to = $_POST['pickup_hours_sat_to'.$countdiv_pickup_saturday];
		
		if($pickup_hrs_sat_from!='' && $pickup_hrs_sat_to!=''){
			$sql_pickup_hrs_saturday = "INSERT INTO restaurant_pickup_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='6', time_from='".$pickup_hrs_sat_from."' , time_to = '".$pickup_hrs_sat_to."' ";
			mysql_query($sql_pickup_hrs_saturday);
		}
	}
	/*------------------------------------------- Saturday Pickup Hours -------------------------------------------------*/
	
	
	
	/*------------------------------------------- Sunday Pickup Hours -------------------------------------------------*/
	foreach($_POST['countdiv_pickup_sunday'] as $countdiv_pickup_sunday){
		$restaurant_id = $res_basic_info['id'];
		$pickup_hrs_sun_from = $_POST['pickup_hours_sun_from'.$countdiv_pickup_sunday];
		$pickup_hrs_sun_to = $_POST['pickup_hours_sun_to'.$countdiv_pickup_sunday];
		
		if($pickup_hrs_sun_from!='' && $pickup_hrs_sun_to!=''){
			$sql_pickup_hrs_sunday = "INSERT INTO restaurant_pickup_hrs SET restaurant_id='".$_REQUEST['restaurant_edit_id']."', days_id='7', time_from='".$pickup_hrs_sun_from."' , time_to = '".$pickup_hrs_sun_to."' ";
			mysql_query($sql_pickup_hrs_sunday);
		}
	}
	/*------------------------------------------- Sunday Pickup Hours -------------------------------------------------*/
	
	
	
	
	
	

	header("location:edit_additional.php?restaurant_edit_id=".$_REQUEST['hid']."&success=2");		
}
?>
<script type="text/javascript">
function getkey(e)
{
if (window.event)
return window.event.keyCode;
else if (e)
return e.which;
else
return null;
}
function goodchars(e, goods)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
if (goods.indexOf(keychar) != -1)
return true;
if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
return true;
return false;
}
function validate()
{
	if(document.getElementById('business_hours').value=="")
	{
		alert("Please select business hours");
		document.getElementById('business_hours').focus();
		return false;
	}
	if(document.getElementById('holidays').value=="")
	{
		alert("Please enter holidays");
		document.getElementById('holidays').focus();
		return false;
	}
	if(document.getElementById('minimum_ammount').value=="")
	{
		alert("Please enter minimum ammount");
		document.getElementById('minimum_ammount').focus();
		return false;
	}
	if(document.getElementById('delivery_charge').value=="")
	{
		alert("Please enter delivery charge");
		document.getElementById('delivery_charge').focus();
		return false;
	}
	if(document.getElementById('delivery_range').value=="")
	{
		alert("Please enter delivery range");
		document.getElementById('delivery_range').focus();
		return false;
	}
	if(document.getElementById('delivery_hours').value=="")
	{
		alert("Please enter delivery hours");
		document.getElementById('delivery_hours').focus();
		return false;
	}
	if(document.getElementById('estimated_delivery_time').value=="")
	{
		alert("Please enter estimated delivery time");
		document.getElementById('estimated_delivery_time').focus();
		return false;
	}
	if(document.getElementById('payment_method1').value=="" && document.getElementById('payment_method2').value==""&&document.getElementById('payment_method3').value==""&&document.getElementById('payment_method4').value==""&&document.getElementById('payment_method5').value=="")
	{
		alert("Please select payment method");
		document.getElementById('payment_method1').focus();
		return false;
	}
	
	return true;
}

function Converttimeformat(tm) {
	var hours1 = tm.split(":");
	
	if(hours1[0] < 10)
	{
		var time = "0" + hours1[0] + ":" + hours1[1];
	}
	else
	{
		var time = tm;
	}
	
	var hrs = Number(time.match(/^(\d+)/)[1]);
	var mnts = Number(time.match(/:(\d+)/)[1]);
	//var format = time.match(/\s(.*)$/)[1];
	var format = tm.substr(tm.length - 2);
	//alert(format);
	if (format == "PM" && hrs < 12) hrs = hrs + 12;
	if (format == "AM" && hrs == 12) hrs = hrs - 12;
	var hours = hrs.toString();
	var minutes = mnts.toString();
	if (hrs < 10) hours = "0" + hours;
	if (mnts < 10) minutes = "0" + minutes;
	return (hours + ":" + minutes + ":00");
}
</script>
<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">
<?php
$sql_restaurant_name=mysql_fetch_array(mysql_query("select restaurant_name from restaurant_basic_info where id='".$_REQUEST['restaurant_edit_id']."'"));
?>
<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>Edit <?php echo stripslashes($sql_restaurant_name['restaurant_name']); ?></h1>
</div>

<div class="restaurant_nav">
<ul>
    <li><a href="edit_restaurant.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Basic Info</a></li>
    <li><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="active7">Additional Info</a></li>
    <li><a href="edit_restaurant_menu.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Menu</a></li>
    <li><a href="edit_multimedia.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Multimedia</a></li>
    <li><a href="edit_special_offer.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Special Offer</a></li>
    <li><a href="edit_confirmation.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>">Confirmation</a></li>
</ul>
                    
                    </div>
                    <?php 
					if($_REUQEST['status']=="error")
					{
					?>
                    <div style="padding:10px 0; text-align:center; border:0px solid  #F00; width:960px; color:#F00; font-family:Arial, Helvetica, sans-serif">Please fill up the basic information first</div>
                    <?php
					}
					?>
	  <?
      $res_business_delivery_detail=mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info where restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
		 $row_business_delivery_details=mysql_num_rows($res_business_delivery_detail);
		if($row_business_delivery_details>0)
		{
		$result_business_delivery_details=mysql_fetch_array($res_business_delivery_detail);	
		}
		
		$res_service_detail=mysql_query("SELECT * FROM restaurant_services_dress_payment where restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
		 $row_service_detail=mysql_num_rows($res_service_detail);
		if($row_service_detail>0)
		{
		$result_service_detail=mysql_fetch_array($res_service_detail);	
		}
		
		$business_extra_hours = mysql_query("SELECT * FROM restaurant_extra_business_hours WHERE restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
		
		$business_delivery_hours = mysql_query("SELECT * FROM restaurant_delivery_details_master WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' ");
		
		$business_pickup_hours = mysql_query("SELECT * FROM restaurant_take_out_master WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' ");
		
		$sql_del_charges = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'");	 
	?>


<div class="restaurant_cont_field">
<p style="text-align:center;"><?php if($_REQUEST['success'] == 1){
	echo "Business extra hours deleted successfully.";
}?>
</p>

<p style="text-align:center;"><?php if($_REQUEST['del_success'] == 1){
	echo "Delivery charge deleted successfully.";
}?>
</p>

<p style="text-align:center;"><?php if($_REQUEST['del_del_success'] == 1){
	echo "Delivery Hours deleted successfully.";
}?>
</p>

<p style="text-align:center;"><?php if($_REQUEST['del_pickup_success'] == 1){
	echo "Pickup Hours deleted successfully.";
}?>
</p>

<p style="text-align:center;"><?php if($_REQUEST['bus_del_success'] == 1){
	echo "Business Hours deleted successfully.";
}?>
</p>

<p style="text-align:center;"><?php if($_REQUEST['pickup_del_success'] == 1){
	echo "Pickup Hours deleted successfully.";
}?>
</p>


<form name="myfrm" method="post" action="" onSubmit="validate()">
<?php if($_REQUEST['success'] == 2){?>
<p style="text-align:center;">Restaurant Additional Info updated successfully.</p>
<?php } ?>
<input type="hidden" name="hid" value="<?php echo $_REQUEST['restaurant_edit_id']?>">
<div class="restaurant_form_field">

<div id="allmenu">

<p>Business Open Hours :</p>
<div class="clear"></div>



<!--------------------------------------- Monday Business Hours -------------------------------------->

<script type="text/javascript">
function add_cell_monday(id){
	$.ajax({
		url : 'add_hours_monday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_monday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_monday').appendChild(menuDiv);
			document.getElementById('item_id_monday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_monday').focus();
}

function remove_div_monday(delId)
{
	var div = document.getElementById("business_div_monday_" + delId);
	div.parentNode.removeChild(div);
}

function check_mon_buss_from(val,id)
{
	var bussto = Converttimeformat($("#business_hours_mon_to"+id).val());
	var value = Converttimeformat(val);
	
	if(bussto != "")
	{
		if(value > bussto)
		{
			alert("From time cannot be greater than To time.");
			$("#business_hours_mon_from"+id).val('');
		}
	}
}

function check_mon_buss_to(val,id)
{
	var bussfrom = Converttimeformat($("#business_hours_mon_from"+id).val());
	var value = Converttimeformat(val);
	
	if(bussfrom != "")
	{
		if(value < bussfrom)
		{
			alert("To time cannot be less than From time.");
			$("#business_hours_mon_to"+id).val('');
		}
	}
}

</script>


<p>Business Hours (Monday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_monday(document.getElementById('item_id_monday').value)" id="item_focus_monday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_monaday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '1'");
if(mysql_num_rows($sql_monaday_buss_hrs) > 0){
$id_mon = 1;
while($array_monday_buss_hrs = mysql_fetch_array($sql_monaday_buss_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_mon_buss_hrs=<?php echo $array_monday_buss_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="businesshoursmon_from<?php echo $id_mon; ?>" id="businesshoursmon_from<?php echo $id_mon; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_monday_buss_hrs['time_from']; ?>" style="width:93px;" onBlur="check_mon_buss_from(this.value,'<?php echo $id_mon; ?>');" />
<span style="color:#888888;">to</span>
<input name="businesshoursmon_to<?php echo $id_mon; ?>" id="businesshoursmon_to<?php echo $id_mon; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_monday_buss_hrs['time_to']; ?>" style="width:93px;" onBlur="check_mon_buss_to(this.value,'<?php echo $id_mon; ?>');" />

<?php 
$id_mon++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_monday">
<?php if(mysql_num_rows($sql_monaday_buss_hrs) == 0){?>
<input name="business_hours_mon_from1" id="business_hours_mon_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_mon_buss_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="business_hours_mon_to1" id="business_hours_mon_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_mon_buss_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_monday" name="item_id_monday" value="2">

<input type="hidden" name="countdiv_monday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Monday Business Hours -------------------------------------->



<!--------------------------------------- Tuesday Business Hours -------------------------------------->

<script type="text/javascript">
function add_cell_tuesday(id){
	$.ajax({
		url : 'add_hours_tuesday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_tuesday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_tuesday').appendChild(menuDiv);
			document.getElementById('item_id_tuesday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_tuesday').focus();
}

function remove_div_tuesday(delId)
{
	var div = document.getElementById("business_div_tuesday_" + delId);
	div.parentNode.removeChild(div);
}

function check_tue_buss_from(val,id)
{
	var bussto = Converttimeformat($("#business_hours_tue_to"+id).val());
	var value = Converttimeformat(val);
	
	if(bussto != "")
	{
		if(value > bussto)
		{
			alert("From time cannot be greater than To time.");
			$("#business_hours_tue_from"+id).val('');
		}
	}
}

function check_tue_buss_to(val,id)
{
	var bussfrom = Converttimeformat($("#business_hours_tue_from"+id).val());
	var value = Converttimeformat(val);
	
	if(bussfrom != "")
	{
		if(value < bussfrom)
		{
			alert("To time cannot be less than From time.");
			$("#business_hours_tue_to"+id).val('');
		}
	}
}

</script>


<p>Business Hours (Tuesday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_tuesday(document.getElementById('item_id_tuesday').value)" id="item_focus_tuesday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_tuesday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '2'");
if(mysql_num_rows($sql_tuesday_buss_hrs) > 0){
$id_tue = 1;
while($array_tuesday_buss_hrs = mysql_fetch_array($sql_tuesday_buss_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_tue_buss_hrs=<?php echo $array_tuesday_buss_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="businesshourstue_from<?php echo $id_tue; ?>" id="businesshourstue_from<?php echo $id_tue; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_tuesday_buss_hrs['time_from']; ?>" style="width:93px;" onBlur="check_tue_buss_from(this.value,'<?php echo $id_tue; ?>');" />
<span style="color:#888888;">to</span>
<input name="businesshourstue_to<?php echo $id_tue; ?>" id="businesshourstue_to<?php echo $id_tue; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_tuesday_buss_hrs['time_to']; ?>" style="width:93px;" onBlur="check_tue_buss_to(this.value,'<?php echo $id_tue; ?>');" />

<?php 
$id_tue++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_tuesday">
<?php if(mysql_num_rows($sql_tuesday_buss_hrs) == 0){?>
<input name="business_hours_tue_from1" id="business_hours_tue_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_tue_buss_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="business_hours_tue_to1" id="business_hours_tue_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_tue_buss_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_tuesday" name="item_id_tuesday" value="2">


<input type="hidden" name="countdiv_tuesday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Tuesday Business Hours -------------------------------------->



<!--------------------------------------- Wednesday Business Hours -------------------------------------->

<script type="text/javascript">
function add_cell_wednesday(id){
	$.ajax({
		url : 'add_hours_wednesday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_wednesday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_wednesday').appendChild(menuDiv);
			document.getElementById('item_id_wednesday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_wednesday').focus();
}

function remove_div_wednesday(delId)
{
	var div = document.getElementById("business_div_wednesday_" + delId);
	div.parentNode.removeChild(div);
}

function check_wed_buss_from(val,id)
{
	var bussto = Converttimeformat($("#business_hours_wed_to"+id).val());
	var value = Converttimeformat(val);
	
	if(bussto != "")
	{
		if(value > bussto)
		{
			alert("From time cannot be greater than To time.");
			$("#business_hours_wed_from"+id).val('');
		}
	}
}

function check_wed_buss_to(val,id)
{
	var bussfrom = Converttimeformat($("#business_hours_wed_from"+id).val());
	var value = Converttimeformat(val);
	
	if(bussfrom != "")
	{
		if(value < bussfrom)
		{
			alert("To time cannot be less than From time.");
			$("#business_hours_wed_to"+id).val('');
		}
	}
}

</script>

<p>Business Hours (Wednesday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_wednesday(document.getElementById('item_id_wednesday').value)" id="item_focus_wednesday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_wednesday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'  AND days_id = '3'");
if(mysql_num_rows($sql_wednesday_buss_hrs) > 0){
$id_wed = 1;
while($array_wednesday_buss_hrs = mysql_fetch_array($sql_wednesday_buss_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_wed_buss_hrs=<?php echo $array_wednesday_buss_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="businesshourswed_from<?php echo $id_wed; ?>" id="businesshourswed_from<?php echo $id_wed; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_wednesday_buss_hrs['time_from']; ?>" style="width:93px;" onBlur="check_wed_buss_from(this.value,'<?php echo $id_wed; ?>');" />
<span style="color:#888888;">to</span>
<input name="businesshourswed_to<?php echo $id_wed; ?>" id="businesshourswed_to<?php echo $id_wed; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_wednesday_buss_hrs['time_to']; ?>" style="width:93px;" onBlur="check_wed_buss_to(this.value,'<?php echo $id_wed; ?>');" />

<?php 
$id_wed++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_wednesday">
<?php if(mysql_num_rows($sql_wednesday_buss_hrs) == 0){?>
<input name="business_hours_wed_from1" id="business_hours_wed_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_wed_buss_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="business_hours_wed_to1" id="business_hours_wed_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_wed_buss_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_wednesday" name="item_id_wednesday" value="2">

<input type="hidden" name="countdiv_wednesday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>
<!--------------------------------------- Wednesday Business Hours -------------------------------------->


<!--------------------------------------- Thursday Business Hours -------------------------------------->

<script type="text/javascript">
function add_cell_thursday(id){
	$.ajax({
		url : 'add_hours_thursday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_thursday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_thursday').appendChild(menuDiv);
			document.getElementById('item_id_thursday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_thursday').focus();
}

function remove_div_thursday(delId)
{
	var div = document.getElementById("business_div_thursday_" + delId);
	div.parentNode.removeChild(div);
}

function check_thu_buss_from(val,id)
{
	var bussto = Converttimeformat($("#business_hours_thu_to"+id).val());
	var value = Converttimeformat(val);
	
	if(bussto != "")
	{
		if(value > bussto)
		{
			alert("From time cannot be greater than To time.");
			$("#business_hours_thu_from"+id).val('');
		}
	}
}

function check_thu_buss_to(val,id)
{
	var bussfrom = Converttimeformat($("#business_hours_thu_from"+id).val());
	var value = Converttimeformat(val);
	
	if(bussfrom != "")
	{
		if(value < bussfrom)
		{
			alert("To time cannot be less than From time.");
			$("#business_hours_thu_to"+id).val('');
		}
	}
}

</script>

<p>Business Hours (Thursday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_thursday(document.getElementById('item_id_thursday').value)" id="item_focus_thursday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_thursday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'  AND days_id = '4'");
if(mysql_num_rows($sql_thursday_buss_hrs) > 0){
$id_thu = 1;
while($array_thursday_buss_hrs = mysql_fetch_array($sql_thursday_buss_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_thu_buss_hrs=<?php echo $array_thursday_buss_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="businesshoursthu_from<?php echo $id_thu; ?>" id="businesshoursthu_from<?php echo $id_thu; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_thursday_buss_hrs['time_from']; ?>" style="width:93px;" onBlur="check_thu_buss_from(this.value,'<?php echo $id_thu; ?>');" />
<span style="color:#888888;">to</span>
<input name="businesshoursthu_to<?php echo $id_thu; ?>" id="businesshoursthu_to<?php echo $id_thu; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_thursday_buss_hrs['time_to']; ?>" style="width:93px;" onBlur="check_thu_buss_to(this.value,'<?php echo $id_thu; ?>');" />

<?php 
$id_thu++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_thursday">
<?php if(mysql_num_rows($sql_thursday_buss_hrs) == 0){?>
<input name="business_hours_thu_from1" id="business_hours_thu_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_thu_buss_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="business_hours_thu_to1" id="business_hours_thu_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_thu_buss_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_thursday" name="item_id_thursday" value="2">

<input type="hidden" name="countdiv_thursday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>
<!--------------------------------------- Thursday Business Hours -------------------------------------->


<!--------------------------------------- Friday Business Hours -------------------------------------->

<script type="text/javascript">
function add_cell_friday(id){
	$.ajax({
		url : 'add_hours_friday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_friday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_friday').appendChild(menuDiv);
			document.getElementById('item_id_friday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_friday').focus();
}

function remove_div_friday(delId)
{
	var div = document.getElementById("business_div_friday_" + delId);
	div.parentNode.removeChild(div);
}

function check_fri_buss_from(val,id)
{
	var bussto = Converttimeformat($("#business_hours_fri_to"+id).val());
	var value = Converttimeformat(val);
	
	if(bussto != "")
	{
		if(value > bussto)
		{
			alert("From time cannot be greater than To time.");
			$("#business_hours_fri_from"+id).val('');
		}
	}
}

function check_fri_buss_to(val,id)
{
	var bussfrom = Converttimeformat($("#business_hours_fri_from"+id).val());
	var value = Converttimeformat(val);
	
	if(bussfrom != "")
	{
		if(value < bussfrom)
		{
			alert("To time cannot be less than From time.");
			$("#business_hours_fri_to"+id).val('');
		}
	}
}

</script>

<p>Business Hours (Friday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_friday(document.getElementById('item_id_friday').value)" id="item_focus_friday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_friday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'  AND days_id = '5'");
if(mysql_num_rows($sql_friday_buss_hrs) > 0){
$id_fri = 1;
while($array_friday_buss_hrs = mysql_fetch_array($sql_friday_buss_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_fri_buss_hrs=<?php echo $array_friday_buss_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="businesshoursfri_from<?php echo $id_fri; ?>" id="businesshoursfri_from<?php echo $id_fri; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_friday_buss_hrs['time_from']; ?>" style="width:93px;" onBlur="check_fri_buss_from(this.value,'<?php echo $id_fri; ?>');" />
<span style="color:#888888;">to</span>
<input name="businesshoursfri_to<?php echo $id_fri; ?>" id="businesshoursfri_to<?php echo $id_fri; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_friday_buss_hrs['time_to']; ?>" style="width:93px;" onBlur="check_fri_buss_to(this.value,'<?php echo $id_fri; ?>');" />

<?php 
$id_fri++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_friday">
<?php if(mysql_num_rows($sql_friday_buss_hrs) == 0){?>
<input name="business_hours_fri_from1" id="business_hours_fri_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_fri_buss_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="business_hours_fri_to1" id="business_hours_fri_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_fri_buss_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_friday" name="item_id_friday" value="2">

<input type="hidden" name="countdiv_friday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>
<!--------------------------------------- Friday Business Hours -------------------------------------->



<!--------------------------------------- Saturday Business Hours -------------------------------------->

<script type="text/javascript">
function add_cell_saturday(id){
	$.ajax({
		url : 'add_hours_saturday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_saturday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_saturday').appendChild(menuDiv);
			document.getElementById('item_id_saturday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_saturday').focus();
}

function remove_div_saturday(delId)
{
	var div = document.getElementById("business_div_saturday_" + delId);
	div.parentNode.removeChild(div);
}

function check_sat_buss_from(val,id)
{
	var bussto = Converttimeformat($("#business_hours_sat_to"+id).val());
	var value = Converttimeformat(val);
	
	if(bussto != "")
	{
		if(value > bussto)
		{
			alert("From time cannot be greater than To time.");
			$("#business_hours_sat_from"+id).val('');
		}
	}
}

function check_sat_buss_to(val,id)
{
	var bussfrom = Converttimeformat($("#business_hours_sat_from"+id).val());
	var value = Converttimeformat(val);
	
	if(bussfrom != "")
	{
		if(value < bussfrom)
		{
			alert("To time cannot be less than From time.");
			$("#business_hours_sat_to"+id).val('');
		}
	}
}

</script>

<p>Business Hours (Saturday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_saturday(document.getElementById('item_id_saturday').value)" id="item_focus_saturday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_saturday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'  AND days_id = '6'");
if(mysql_num_rows($sql_saturday_buss_hrs) > 0){
$id_sat = 1;
while($array_saturday_buss_hrs = mysql_fetch_array($sql_saturday_buss_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_sat_buss_hrs=<?php echo $array_saturday_buss_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="businesshourssat_from<?php echo $id_sat; ?>" id="businesshourssat_from<?php echo $id_sat; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_saturday_buss_hrs['time_from']; ?>" style="width:93px;" onBlur="check_sat_buss_from(this.value,'<?php echo $id_sat; ?>');" />
<span style="color:#888888;">to</span>
<input name="businesshourssat_to<?php echo $id_sat; ?>" id="businesshourssat_to<?php echo $id_sat; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_saturday_buss_hrs['time_to']; ?>" style="width:93px;" onBlur="check_sat_buss_to(this.value,'<?php echo $id_sat; ?>');" />

<?php 
$id_sat++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_saturday">
<?php if(mysql_num_rows($sql_saturday_buss_hrs) == 0){?>
<input name="business_hours_sat_from1" id="business_hours_sat_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sat_buss_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="business_hours_sat_to1" id="business_hours_sat_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sat_buss_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_saturday" name="item_id_saturday" value="2">

<input type="hidden" name="countdiv_saturday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>
<!--------------------------------------- Saturday Business Hours -------------------------------------->



<!--------------------------------------- Sunday Business Hours -------------------------------------->

<script type="text/javascript">
function add_cell_sunday(id){
	$.ajax({
		url : 'add_hours_sunday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'business_div_sunday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_sunday').appendChild(menuDiv);
			document.getElementById('item_id_sunday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_sunday').focus();
}

function remove_div_sunday(delId)
{
	var div = document.getElementById("business_div_sunday_" + delId);
	div.parentNode.removeChild(div);
}

function check_sun_buss_from(val,id)
{
	var bussto = Converttimeformat($("#business_hours_sun_to"+id).val());
	var value = Converttimeformat(val);
	
	if(bussto != "")
	{
		if(value > bussto)
		{
			alert("From time cannot be greater than To time.");
			$("#business_hours_sun_from"+id).val('');
		}
	}
}

function check_sun_buss_to(val,id)
{
	var bussfrom = Converttimeformat($("#business_hours_sun_from"+id).val());
	var value = Converttimeformat(val);
	
	if(bussfrom != "")
	{
		if(value < bussfrom)
		{
			alert("To time cannot be less than From time.");
			$("#business_hours_sun_to"+id).val('');
		}
	}
}

</script>

<p>Business Hours (Sunday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_sunday(document.getElementById('item_id_sunday').value)" id="item_focus_sunday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_sunday_buss_hrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."'  AND days_id = '7'");
if(mysql_num_rows($sql_sunday_buss_hrs) > 0){
$id_sun = 1;
while($array_sunday_buss_hrs = mysql_fetch_array($sql_sunday_buss_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_sun_buss_hrs=<?php echo $array_sunday_buss_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="businesshourssun_from<?php echo $id_sun; ?>" id="businesshourssun_from<?php echo $id_sun; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_sunday_buss_hrs['time_from']; ?>" style="width:93px;" onBlur="check_sun_buss_from(this.value,'<?php echo $id_sun; ?>');" />
<span style="color:#888888;">to</span>
<input name="businesshourssun_to<?php echo $id_sun; ?>" id="businesshourssun_to<?php echo $id_sun; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_sunday_buss_hrs['time_to']; ?>" style="width:93px;" onBlur="check_sun_buss_to(this.value,'<?php echo $id_sun; ?>');" />

<?php 
$id_sun++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_sunday">
<?php if(mysql_num_rows($sql_sunday_buss_hrs) == 0){?>
<input name="business_hours_sun_from1" id="business_hours_sun_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sun_buss_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="business_hours_sun_to1" id="business_hours_sun_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sun_buss_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_sunday" name="item_id_sunday" value="2">

<input type="hidden" name="countdiv_sunday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>
<!--------------------------------------- Sunday Business Hours -------------------------------------->



<p>Holidays* :</p>

<?php /*?><input name="holidays" id="holidays" type="text" class="restaurant" value="<?php echo stripslashes($result_business_delivery_details['holidays'])?>" /><?php */?>
<input name="holidays_from" id="holidays_from" type="text" class="restaurant time_pick" value="<?php echo $result_business_delivery_details['holidays_from']; ?>" style="width:93px;" onBlur="check_holiday_from(this.value);" />
<span style="color:#888888;">to</span>
<input name="holidays" id="holidays" type="text" class="restaurant time_pick" value="<?php echo $result_business_delivery_details['holidays']; ?>" style="width:93px;" onBlur="check_holiday_to(this.value);" />


<div class="clear"></div>

<script type="text/javascript">
function check_res_buss_from(val,id)
{
	var bussto = Converttimeformat($("#hours"+id).val());
	var value = Converttimeformat(val);
	
	if(bussto != "")
	{
		if(value > bussto)
		{
			alert("From time cannot be greater than To time.");
			$("#hoursfrom"+id).val('');
		}
	}
}

function check_res_buss_to(val,id)
{
	var bussfrom = Converttimeformat($("#hoursfrom"+id).val());
	var value = Converttimeformat(val);
	
	if(bussfrom != "")
	{
		if(value < bussfrom)
		{
			alert("To time cannot be less than From time.");
			$("#hours"+id).val('');
		}
	}
}

</script>

<script type="text/javascript">
function check_res_bus_hrs_from(val,id)
{
	var bus_hrsto = Converttimeformat($("#hours_"+id).val());
	var value = Converttimeformat(val);
	
	if(bus_hrsto != "")
	{
		if(value > bus_hrsto)
		{
			alert("From time cannot be greater than To time.");
			$("#hours_from_"+id).val('');
		}
	}
}

function check_res_bus_hrs_to(val,id)
{
	var bus_hrsfrom = Converttimeformat($("#hours_from_"+id).val());
	var value = Converttimeformat(val);
	
	if(bus_hrsfrom != "")
	{
		if(value < bus_hrsfrom)
		{
			alert("To time cannot be less than From time.");
			$("#hours_"+id).val('');
		}
	}
}

</script>


<div style="margin-left:173px;"><a href="javascript:void(0);" onClick="add_cell(document.getElementById('item_id').value)" id="item_focus"><img src="images/add_bus_hrs.png"  style="margin-left:0;" width="213"/></a></div>


<?php if(mysql_num_rows($business_extra_hours)>0){
$id=1;
while($array_business_extra_hours = mysql_fetch_array($business_extra_hours)){?>
<div class="cross_bt" style="margin-left:394px;">
<a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete=<?php echo $array_business_extra_hours['id'];?>" >
<img  src="images/Close_Box_Red.png">
</a>
</div>
<p>Business hours Title :</p>
<input name="businesshours_title<?php echo $id; ?>" id="business_hours_title<?php echo $id; ?>" type="text" class="restaurant" value="<?php echo $array_business_extra_hours['title'];?>" />

<div class="clear"></div>
<p>Hours :</p>
<?php /*?><input name="hours_<?php echo $id; ?>" id="hours<?php echo $id; ?>" type="text" class="restaurant" value="<?php echo $array_business_extra_hours['hours'];?>" /><?php */?>
<input name="hoursfrom<?php echo $id; ?>" id="hoursfrom<?php echo $id; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_business_extra_hours['hours_from']; ?>" style="width:93px;" onBlur="check_res_buss_from(this.value,'<?php echo $id; ?>');" />
<span style="color:#888888;">to</span>
<input name="hours<?php echo $id; ?>" id="hours<?php echo $id; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_business_extra_hours['hours']; ?>" style="width:93px;" onBlur="check_res_buss_to(this.value,'<?php echo $id; ?>');" />
<div style="border-bottom:1px dashed #787878; width:387px;"></div>
<?php $id++; } } ?>

<input type="hidden" id="item_id" name="item_id" value="1">

<div class="clear"></div>
</div>

<h1>Delivery Details -</h1>

<div class="clear"></div>

<p>Delivery* :</p>

<input name="delivery" id="delivery1" type="radio" value="1" class="radio_section" <?php if($result_business_delivery_details['delivery']==1){?> checked <?php } ?> />
<p class="restaurant_radio_field">Yes</p>
<input name="delivery" id="delivery2" type="radio" value="0" class="radio_section" <?php if($result_business_delivery_details['delivery']==0){?> checked <?php } ?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Minimum Amount* ($) :</p>

<input name="minimum_ammount" id="minimum_ammount" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['minimum_ammount']?>" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<?php /*?><p>Delivery Charge* ($) :</p>

<input name="delivery_charge" id="delivery_charge" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['delivery_charge']?>"  onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<p>Delivery Range* (miles) :</p>

<input name="delivery_range" id="delivery_range" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['delivery_range']?>"  onKeyPress="return goodchars(event,'1234567890.');" />

<div class="clear"></div><?php */?>

<?php /*?><p>Delivery Hours* :</p>

<input name="delivery_hours" id="delivery_hours" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['delivery_hours']?>" />

<div class="clear"></div><?php */?>

<p>Estimate Delivery Time* :</p>

<input name="estimated_delivery_time" id="estimated_delivery_time" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['delivery_estimated_time']?>" />

<div class="clear"></div>


<!--------------------------------------- Monday Delivery Hours -------------------------------------->

<script type="text/javascript">
function add_cell_del_monday(id){
	$.ajax({
		url : 'add_hours_del_monday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'delivery_div_monday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_delivery_monday').appendChild(menuDiv);
			document.getElementById('item_id_del_monday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_del_monday').focus();
}

function remove_del_div_monday(delId)
{
	var div = document.getElementById("delivery_div_monday_" + delId);
	div.parentNode.removeChild(div);
}

function check_mon_del_from(val,id)
{
	var delto = Converttimeformat($("#delivery_hours_mon_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#delivery_hours_mon_from"+id).val('');
		}
	}
}

function check_mon_del_to(val,id)
{
	var delfrom = Converttimeformat($("#delivery_hours_mon_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#delivery_hours_mon_to"+id).val('');
		}
	}
}

</script>


<p>Delivery Hours (Monday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_del_monday(document.getElementById('item_id_del_monday').value)" id="item_focus_del_monday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_monaday_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '1'");
if(mysql_num_rows($sql_monaday_del_hrs) > 0){
$id_mon = 1;
while($array_monday_del_hrs = mysql_fetch_array($sql_monaday_del_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_mon_del_hrs=<?php echo $array_monday_del_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="deliveryhoursmon_from<?php echo $id_mon; ?>" id="deliveryhoursmon_from<?php echo $id_mon; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_monday_del_hrs['time_from']; ?>" style="width:93px;" onBlur="check_mon_del_from(this.value,'<?php echo $id_mon; ?>');" />
<span style="color:#888888;">to</span>
<input name="deliveryhoursmon_to<?php echo $id_mon; ?>" id="deliveryhoursmon_to<?php echo $id_mon; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_monday_del_hrs['time_to']; ?>" style="width:93px;" onBlur="check_del_buss_to(this.value,'<?php echo $id_mon; ?>');" />

<?php 
$id_mon++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_delivery_monday">
<?php if(mysql_num_rows($sql_monaday_del_hrs) == 0){?>
<input name="delivery_hours_mon_from1" id="delivery_hours_mon_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_mon_del_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="delivery_hours_mon_to1" id="delivery_hours_mon_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_mon_del_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_del_monday" name="item_id_del_monday" value="2">

<input type="hidden" name="countdiv_del_monday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Monday Delivery Hours -------------------------------------->


<!--------------------------------------- Tuesday Delivery Hours -------------------------------------->

<script type="text/javascript">
function add_cell_del_tuesday(id){
	$.ajax({
		url : 'add_hours_del_tuesday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'delivery_div_tuesday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_delivery_tuesday').appendChild(menuDiv);
			document.getElementById('item_id_del_tuesday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_del_tuesday').focus();
}

function remove_del_div_tuesday(delId)
{
	var div = document.getElementById("delivery_div_tuesday_" + delId);
	div.parentNode.removeChild(div);
}

function check_tue_del_from(val,id)
{
	var delto = Converttimeformat($("#delivery_hours_tue_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#delivery_hours_tue_from"+id).val('');
		}
	}
}

function check_tue_del_to(val,id)
{
	var delfrom = Converttimeformat($("#delivery_hours_tue_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#delivery_hours_tue_to"+id).val('');
		}
	}
}

</script>


<p>Delivery Hours (tuesday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_del_tuesday(document.getElementById('item_id_del_tuesday').value)" id="item_focus_del_tuesday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_tuesday_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '2'");
if(mysql_num_rows($sql_tuesday_del_hrs) > 0){
$id_tue = 1;
while($array_tuesday_del_hrs = mysql_fetch_array($sql_tuesday_del_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_tue_del_hrs=<?php echo $array_tuesday_del_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="deliveryhourstue_from<?php echo $id_tue; ?>" id="deliveryhourstue_from<?php echo $id_tue; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_tuesday_del_hrs['time_from']; ?>" style="width:93px;" onBlur="check_tue_del_from(this.value,'<?php echo $id_tue; ?>');" />
<span style="color:#888888;">to</span>
<input name="deliveryhourstue_to<?php echo $id_tue; ?>" id="deliveryhourstue_to<?php echo $id_tue; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_tuesday_del_hrs['time_to']; ?>" style="width:93px;" onBlur="check_del_buss_to(this.value,'<?php echo $id_tue; ?>');" />

<?php 
$id_tue++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_delivery_tuesday">
<?php if(mysql_num_rows($sql_tuesday_del_hrs) == 0){?>
<input name="delivery_hours_tue_from1" id="delivery_hours_tue_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_tue_del_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="delivery_hours_tue_to1" id="delivery_hours_tue_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_tue_del_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_del_tuesday" name="item_id_del_tuesday" value="2">

<input type="hidden" name="countdiv_del_tuesday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Tuesday Delivery Hours -------------------------------------->


<!--------------------------------------- Wednesday Delivery Hours -------------------------------------->

<script type="text/javascript">
function add_cell_del_wednesday(id){
	$.ajax({
		url : 'add_hours_del_wednesday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'delivery_div_wednesday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_delivery_wednesday').appendChild(menuDiv);
			document.getElementById('item_id_del_wednesday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_del_wednesday').focus();
}

function remove_del_div_wednesday(delId)
{
	var div = document.getElementById("delivery_div_wednesday_" + delId);
	div.parentNode.removeChild(div);
}

function check_wed_del_from(val,id)
{
	var delto = Converttimeformat($("#delivery_hours_wed_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#delivery_hours_wed_from"+id).val('');
		}
	}
}

function check_wed_del_to(val,id)
{
	var delfrom = Converttimeformat($("#delivery_hours_wed_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#delivery_hours_wed_to"+id).val('');
		}
	}
}

</script>


<p>Delivery Hours (Wednesday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_del_wednesday(document.getElementById('item_id_del_wednesday').value)" id="item_focus_del_wednesday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_wednesday_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '3'");
if(mysql_num_rows($sql_wednesday_del_hrs) > 0){
$id_wed = 1;
while($array_wednesday_del_hrs = mysql_fetch_array($sql_wednesday_del_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_wed_del_hrs=<?php echo $array_wednesday_del_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="deliveryhourswed_from<?php echo $id_wed; ?>" id="deliveryhourswed_from<?php echo $id_wed; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_wednesday_del_hrs['time_from']; ?>" style="width:93px;" onBlur="check_wed_del_from(this.value,'<?php echo $id_wed; ?>');" />
<span style="color:#888888;">to</span>
<input name="deliveryhourswed_to<?php echo $id_wed; ?>" id="deliveryhourswed_to<?php echo $id_wed; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_wednesday_del_hrs['time_to']; ?>" style="width:93px;" onBlur="check_del_buss_to(this.value,'<?php echo $id_wed; ?>');" />

<?php 
$id_wed++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_delivery_wednesday">
<?php if(mysql_num_rows($sql_wednesday_del_hrs) == 0){?>
<input name="delivery_hours_wed_from1" id="delivery_hours_wed_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_wed_del_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="delivery_hours_wed_to1" id="delivery_hours_wed_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_wed_del_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_del_wednesday" name="item_id_del_wednesday" value="2">

<input type="hidden" name="countdiv_del_wednesday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Wednesday Delivery Hours -------------------------------------->


<!--------------------------------------- Thursday Delivery Hours -------------------------------------->

<script type="text/javascript">
function add_cell_del_thursday(id){
	$.ajax({
		url : 'add_hours_del_thursday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'delivery_div_thursday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_delivery_thursday').appendChild(menuDiv);
			document.getElementById('item_id_del_thursday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_del_thursday').focus();
}

function remove_del_div_thursday(delId)
{
	var div = document.getElementById("delivery_div_thursday_" + delId);
	div.parentNode.removeChild(div);
}

function check_thu_del_from(val,id)
{
	var delto = Converttimeformat($("#delivery_hours_thu_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#delivery_hours_thu_from"+id).val('');
		}
	}
}

function check_thu_del_to(val,id)
{
	var delfrom = Converttimeformat($("#delivery_hours_thu_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#delivery_hours_thu_to"+id).val('');
		}
	}
}

</script>


<p>Delivery Hours (Thursday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_del_thursday(document.getElementById('item_id_del_thursday').value)" id="item_focus_del_thursday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_thursday_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '4'");
if(mysql_num_rows($sql_thursday_del_hrs) > 0){
$id_thu = 1;
while($array_thursday_del_hrs = mysql_fetch_array($sql_thursday_del_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_thu_del_hrs=<?php echo $array_thursday_del_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="deliveryhoursthu_from<?php echo $id_thu; ?>" id="deliveryhoursthu_from<?php echo $id_thu; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_thursday_del_hrs['time_from']; ?>" style="width:93px;" onBlur="check_thu_del_from(this.value,'<?php echo $id_thu; ?>');" />
<span style="color:#888888;">to</span>
<input name="deliveryhoursthu_to<?php echo $id_thu; ?>" id="deliveryhoursthu_to<?php echo $id_thu; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_thursday_del_hrs['time_to']; ?>" style="width:93px;" onBlur="check_del_buss_to(this.value,'<?php echo $id_thu; ?>');" />

<?php 
$id_thu++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_delivery_thursday">
<?php if(mysql_num_rows($sql_thursday_del_hrs) == 0){?>
<input name="delivery_hours_thu_from1" id="delivery_hours_thu_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_thu_del_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="delivery_hours_thu_to1" id="delivery_hours_thu_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_thu_del_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_del_thursday" name="item_id_del_thursday" value="2">

<input type="hidden" name="countdiv_del_thursday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Thursday Delivery Hours -------------------------------------->


<!--------------------------------------- Friday Delivery Hours -------------------------------------->

<script type="text/javascript">
function add_cell_del_friday(id){
	$.ajax({
		url : 'add_hours_del_friday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'delivery_div_friday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_delivery_friday').appendChild(menuDiv);
			document.getElementById('item_id_del_friday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_del_friday').focus();
}

function remove_del_div_friday(delId)
{
	var div = document.getElementById("delivery_div_friday_" + delId);
	div.parentNode.removeChild(div);
}

function check_fri_del_from(val,id)
{
	var delto = Converttimeformat($("#delivery_hours_fri_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#delivery_hours_fri_from"+id).val('');
		}
	}
}

function check_fri_del_to(val,id)
{
	var delfrom = Converttimeformat($("#delivery_hours_fri_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#delivery_hours_fri_to"+id).val('');
		}
	}
}

</script>


<p>Delivery Hours (Friday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_del_friday(document.getElementById('item_id_del_friday').value)" id="item_focus_del_friday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_friday_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '5'");
if(mysql_num_rows($sql_friday_del_hrs) > 0){
$id_fri = 1;
while($array_friday_del_hrs = mysql_fetch_array($sql_friday_del_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_fri_del_hrs=<?php echo $array_friday_del_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="deliveryhoursfri_from<?php echo $id_fri; ?>" id="deliveryhoursfri_from<?php echo $id_fri; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_friday_del_hrs['time_from']; ?>" style="width:93px;" onBlur="check_fri_del_from(this.value,'<?php echo $id_fri; ?>');" />
<span style="color:#888888;">to</span>
<input name="deliveryhoursfri_to<?php echo $id_fri; ?>" id="deliveryhoursfri_to<?php echo $id_fri; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_friday_del_hrs['time_to']; ?>" style="width:93px;" onBlur="check_del_buss_to(this.value,'<?php echo $id_fri; ?>');" />

<?php 
$id_fri++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_delivery_friday">
<?php if(mysql_num_rows($sql_friday_del_hrs) == 0){?>
<input name="delivery_hours_fri_from1" id="delivery_hours_fri_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_fri_del_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="delivery_hours_fri_to1" id="delivery_hours_fri_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_fri_del_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_del_friday" name="item_id_del_friday" value="2">

<input type="hidden" name="countdiv_del_friday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Friday Delivery Hours -------------------------------------->


<!--------------------------------------- Saturday Delivery Hours -------------------------------------->

<script type="text/javascript">
function add_cell_del_saturday(id){
	$.ajax({
		url : 'add_hours_del_saturday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'delivery_div_saturday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_delivery_saturday').appendChild(menuDiv);
			document.getElementById('item_id_del_saturday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_del_saturday').focus();
}

function remove_del_div_saturday(delId)
{
	var div = document.getElementById("delivery_div_saturday_" + delId);
	div.parentNode.removeChild(div);
}

function check_sat_del_from(val,id)
{
	var delto = Converttimeformat($("#delivery_hours_sat_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#delivery_hours_sat_from"+id).val('');
		}
	}
}

function check_sat_del_to(val,id)
{
	var delfrom = Converttimeformat($("#delivery_hours_sat_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#delivery_hours_sat_to"+id).val('');
		}
	}
}

</script>


<p>Delivery Hours (Saturday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_del_saturday(document.getElementById('item_id_del_saturday').value)" id="item_focus_del_saturday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_saturday_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '6'");
if(mysql_num_rows($sql_saturday_del_hrs) > 0){
$id_sat = 1;
while($array_saturday_del_hrs = mysql_fetch_array($sql_saturday_del_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_sat_del_hrs=<?php echo $array_saturday_del_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="deliveryhourssat_from<?php echo $id_sat; ?>" id="deliveryhourssat_from<?php echo $id_sat; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_saturday_del_hrs['time_from']; ?>" style="width:93px;" onBlur="check_sat_del_from(this.value,'<?php echo $id_sat; ?>');" />
<span style="color:#888888;">to</span>
<input name="deliveryhourssat_to<?php echo $id_sat; ?>" id="deliveryhourssat_to<?php echo $id_sat; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_saturday_del_hrs['time_to']; ?>" style="width:93px;" onBlur="check_del_buss_to(this.value,'<?php echo $id_sat; ?>');" />

<?php 
$id_sat++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_delivery_saturday">
<?php if(mysql_num_rows($sql_saturday_del_hrs) == 0){?>
<input name="delivery_hours_sat_from1" id="delivery_hours_sat_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sat_del_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="delivery_hours_sat_to1" id="delivery_hours_sat_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sat_del_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_del_saturday" name="item_id_del_saturday" value="2">

<input type="hidden" name="countdiv_del_saturday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Saturday Delivery Hours -------------------------------------->


<!--------------------------------------- Sunday Delivery Hours -------------------------------------->

<script type="text/javascript">
function add_cell_del_sunday(id){
	$.ajax({
		url : 'add_hours_del_sunday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'delivery_div_sunday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_delivery_sunday').appendChild(menuDiv);
			document.getElementById('item_id_del_sunday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_del_sunday').focus();
}

function remove_del_div_sunday(delId)
{
	var div = document.getElementById("delivery_div_sunday_" + delId);
	div.parentNode.removeChild(div);
}

function check_sun_del_from(val,id)
{
	var delto = Converttimeformat($("#delivery_hours_sun_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#delivery_hours_sun_from"+id).val('');
		}
	}
}

function check_sun_del_to(val,id)
{
	var delfrom = Converttimeformat($("#delivery_hours_sun_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#delivery_hours_sun_to"+id).val('');
		}
	}
}

</script>


<p>Delivery Hours (Sunday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_del_sunday(document.getElementById('item_id_del_sunday').value)" id="item_focus_del_sunday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_sunday_del_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '7'");
if(mysql_num_rows($sql_sunday_del_hrs) > 0){
$id_sun = 1;
while($array_sunday_del_hrs = mysql_fetch_array($sql_sunday_del_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_sun_del_hrs=<?php echo $array_sunday_del_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="deliveryhourssun_from<?php echo $id_sun; ?>" id="deliveryhourssun_from<?php echo $id_sun; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_sunday_del_hrs['time_from']; ?>" style="width:93px;" onBlur="check_sun_del_from(this.value,'<?php echo $id_sun; ?>');" />
<span style="color:#888888;">to</span>
<input name="deliveryhourssun_to<?php echo $id_sun; ?>" id="deliveryhourssun_to<?php echo $id_sun; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_sunday_del_hrs['time_to']; ?>" style="width:93px;" onBlur="check_del_buss_to(this.value,'<?php echo $id_sun; ?>');" />

<?php 
$id_sun++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_delivery_sunday">
<?php if(mysql_num_rows($sql_sunday_del_hrs) == 0){?>
<input name="delivery_hours_sun_from1" id="delivery_hours_sun_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sun_del_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="delivery_hours_sun_to1" id="delivery_hours_sun_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sun_del_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_del_sunday" name="item_id_del_sunday" value="2">

<input type="hidden" name="countdiv_del_sunday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Sunday Delivery Hours -------------------------------------->







<?php /*?><p>Delivery Hours : </p>

<input name="del_hours_from_1" id="del_hours_from_1" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['del_hours_from']; ?>" style="width:93px;" />
<span style="color:#888888;">to</span>
<input name="del_hours_to_1" id="del_hours_to_1" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['del_hours_to']; ?>" style="width:93px;" /><?php */?>

<script type="text/javascript">
function check_res_delhrs_from(val,id)
{
	var delhrsto = Converttimeformat($("#delhoursto_"+id).val());
	var value = Converttimeformat(val);
	
	if(delhrsto != "")
	{
		if(value > delhrsto)
		{
			alert("From time cannot be greater than To time.");
			$("#delhoursfrom_"+id).val('');
		}
	}
}

function check_res_delhrs_to(val,id)
{
	var delhrsfrom = Converttimeformat($("#delhoursfrom_"+id).val());
	var value = Converttimeformat(val);
	
	if(delhrsfrom != "")
	{
		if(value < delhrsfrom)
		{
			alert("To time cannot be less than From time.");
			$("#delhoursto_"+id).val('');
		}
	}
}

</script>

<script type="text/javascript">
function check_res_del_hrs_from(val,id)
{
	var del_hrsto = Converttimeformat($("#del_hours_to_"+id).val());
	var value = Converttimeformat(val);
	
	if(del_hrsto != "")
	{
		if(value > del_hrsto)
		{
			alert("From time cannot be greater than To time.");
			$("#del_hours_from_"+id).val('');
		}
	}
}

function check_res_del_hrs_to(val,id)
{
	var del_hrsfrom = Converttimeformat($("#del_hours_from_"+id).val());
	var value = Converttimeformat(val);
	
	if(del_hrsfrom != "")
	{
		if(value < del_hrsfrom)
		{
			alert("To time cannot be less than From time.");
			$("#del_hours_to_"+id).val('');
		}
	}
}

</script>

<?php /*?><input type="hidden" id="delivery_hours_id" name="delivery_hours_id" value="1">

<div style="margin-left:210px; margin-bottom:20px;"><a href="javascript:void(0);" onClick="add_delivery_hours_cell(document.getElementById('delivery_hours_id').value)" id="item_focus_delivery_hours"><img src="images/add_new_del_hrs.png"></a></div>

<div class="clear"></div><?php */?>

<?php /*?><div id="del_hours">
<?php if($business_delivery_hours > 0){ 
$kk = 1;
while($array_delivery_hours = mysql_fetch_array($business_delivery_hours)){ ?>
<div class="cross_bt" style="margin-left:394px;">
<a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_del_hrs=<?php echo $array_delivery_hours['id'];?>" >
<img  src="images/Close_Box_Red.png">
</a>
</div>

<div class="clear"></div>
<p>Delivery Hours :</p>
<input name="delhoursfrom_<?php echo $kk; ?>" id="delhoursfrom_<?php echo $kk; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_delivery_hours['delivery_from']; ?>" style="width:93px;" onBlur="check_res_delhrs_from(this.value,'<?php echo $kk; ?>');" />
<span style="color:#888888;">to</span>
<input name="delhoursto_<?php echo $kk; ?>" id="delhoursto_<?php echo $kk; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_delivery_hours['delivery_to']; ?>" style="width:93px;" onBlur="check_res_delhrs_to(this.value,'<?php echo $kk; ?>')" />
<div style="border-bottom:1px dashed #787878; width:387px;"></div>

<?php $kk++; } } ?>
</div><?php */?>

<input type="hidden" id="del_charge_item_id" name="del_charge_item_id" value="1">

<div style="margin-left:210px; margin-top:20px;"><a href="javascript:void(0);" onClick="add_del_charge_cell(document.getElementById('del_charge_item_id').value)" id="item_focus_del_charge"><img src="images/add_new_del_crg.png"></a></div>

<div class="clear"></div>

<div id="del_charge">
<?php if($sql_del_charges > 0){ 
$j = 1;
while($array_del_charges = mysql_fetch_array($sql_del_charges)){ ?>
<div class="cross_bt" style="margin-left:394px;">
<a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_del_charge=<?php echo $array_del_charges['id'];?>" >
<img  src="images/Close_Box_Red.png">
</a>
</div>
<p>Delivery Range (miles) :</p>
<input name="delivery_range_<?php echo $j; ?>" id="delivery_range_<?php echo $j; ?>" type="text" value="<?php echo $array_del_charges['delivery_range']; ?>" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" />
<div class="clear"></div>
<p>Delivery Charge ($) :</p>
<input name="delivery_charge_<?php echo $j; ?>" id="delivery_charge_<?php echo $j; ?>" type="text" value="<?php echo $array_del_charges['delivery_charge']; ?>" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" />
<div class="clear"></div>
<div style="border-bottom:1px dashed #787878; width:387px;"></div>

<?php $j++; } } ?>
</div>

<h1>Take Out Details -</h1>

<div class="clear"></div>

<?php /*?><p>Pick Up Hours : </p>
<input name="pickup_hours_from" id="pickup_hours_from" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['pickup_hours_from']; ?>" style="width:93px;" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_to" id="pickup_hours_to" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['pickup_hours_to']; ?>" style="width:93px;" />
<div class="clear"></div><?php */?>

<script type="text/javascript">
function check_res_pickuphrs_from(val,id)
{
	var pickuphrsto = Converttimeformat($("#pickuphoursto_"+id).val());
	var value = Converttimeformat(val);
	
	if(pickuphrsto != "")
	{
		if(value > pickuphrsto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickuphoursfrom_"+id).val('');
		}
	}
}

function check_res_pickuphrs_to(val,id)
{
	var pickuphrsfrom = Converttimeformat($("#pickuphoursfrom_"+id).val());
	var value = Converttimeformat(val);
	
	if(pickuphrsfrom != "")
	{
		if(value < pickuphrsfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickuphoursto_"+id).val('');
		}
	}
}

</script>

<script type="text/javascript">
function check_res_pickup_hrs_from(val,id)
{
	var pickup_hrsto = Converttimeformat($("#pickuphoursto_"+id).val());
	var value = Converttimeformat(val);
	
	if(pickup_hrsto != "")
	{
		if(value > pickup_hrsto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickup_hours_to_"+id).val('');
		}
	}
}

function check_res_pickup_hrs_to(val,id)
{
	var pickup_hrsfrom = Converttimeformat($("#pickup_hours_from_"+id).val());
	var value = Converttimeformat(val);
	
	if(pickup_hrsfrom != "")
	{
		if(value < pickup_hrsfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickup_hours_to_"+id).val('');
		}
	}
}

</script>


<?php /*?><input type="hidden" id="pickup_hours_id" name="pickup_hours_id" value="1">

<div style="margin-left:210px; margin-bottom:20px;"><a href="javascript:void(0);" onClick="add_pickup_hours_cell(document.getElementById('pickup_hours_id').value)" id="item_focus_pickup_hours"><img src="images/add_new_pkc_hrs.png"></a></div>

<div class="clear"></div><?php */?>

<?php /*?><div id="pickup_hours">
<?php if($business_pickup_hours > 0){ 
$mm = 1;
while($array_pickup_hours = mysql_fetch_array($business_pickup_hours)){ ?>
<div class="cross_bt" style="margin-left:394px;">
<a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_pickup_hrs=<?php echo $array_pickup_hours['id'];?>" >
<img  src="images/Close_Box_Red.png">
</a>
</div>

<div class="clear"></div>
<p>Pickup Hours :</p>
<input name="pickuphoursfrom_<?php echo $mm; ?>" id="pickuphoursfrom_<?php echo $mm; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_pickup_hours['from_time']; ?>" style="width:93px;" onBlur="check_res_pickuphrs_from(this.value,'<?php echo $mm; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickuphoursto_<?php echo $mm; ?>" id="pickuphoursto_<?php echo $mm; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_pickup_hours['to_time']; ?>" style="width:93px;" onBlur="check_res_pickuphrs_to(this.value,'<?php echo $mm; ?>');" />
<div style="border-bottom:1px dashed #787878; width:387px;"></div>

<?php $mm++; } } ?>
</div><?php */?>





<p>Pick Up* :</p>

<input name="pickup" id="pickup1" type="radio" value="1" class="radio_section" <?php if($result_business_delivery_details['pickup']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="pickup" type="radio" value="0" class="radio_section" <?php if($result_business_delivery_details['pickup']==0){?> checked<?php }?> />
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>


<!--------------------------------------- Monday Pickup Hours -------------------------------------->

<script type="text/javascript">
function add_cell_pickup_monday(id){
	$.ajax({
		url : 'add_hours_pickup_monday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'pickup_div_monday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_pickup_monday').appendChild(menuDiv);
			document.getElementById('item_id_pickup_monday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_pickup_monday').focus();
}

function remove_pickup_div_monday(delId)
{
	var div = document.getElementById("pickup_div_monday_" + delId);
	div.parentNode.removeChild(div);
}

function check_mon_pickup_from(val,id)
{
	var delto = Converttimeformat($("#pickup_hours_mon_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickup_hours_mon_from"+id).val('');
		}
	}
}

function check_mon_pickup_to(val,id)
{
	var delfrom = Converttimeformat($("#pickup_hours_mon_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickup_hours_mon_to"+id).val('');
		}
	}
}

</script>


<p>Pickup Hours (Monday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_pickup_monday(document.getElementById('item_id_pickup_monday').value)" id="item_focus_pickup_monday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_monaday_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '1'");
if(mysql_num_rows($sql_monaday_pickup_hrs) > 0){
$id_mon = 1;
while($array_monday_pickup_hrs = mysql_fetch_array($sql_monaday_pickup_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_mon_pickup_hrs=<?php echo $array_monday_pickup_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="pickuphoursmon_from<?php echo $id_mon; ?>" id="pickuphoursmon_from<?php echo $id_mon; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_monday_pickup_hrs['time_from']; ?>" style="width:93px;" onBlur="check_mon_pickup_from(this.value,'<?php echo $id_mon; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickuphoursmon_to<?php echo $id_mon; ?>" id="pickuphoursmon_to<?php echo $id_mon; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_monday_pickup_hrs['time_to']; ?>" style="width:93px;" onBlur="check_pickup_buss_to(this.value,'<?php echo $id_mon; ?>');" />

<?php 
$id_mon++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_pickup_monday">
<?php if(mysql_num_rows($sql_monaday_pickup_hrs) == 0){?>
<input name="pickup_hours_mon_from1" id="pickup_hours_mon_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_mon_pickup_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_mon_to1" id="pickup_hours_mon_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_mon_pickup_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_pickup_monday" name="item_id_pickup_monday" value="2">

<input type="hidden" name="countdiv_pickup_monday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Monday Pickup Hours -------------------------------------->

<!--------------------------------------- Tuesday Pickup Hours -------------------------------------->

<script type="text/javascript">
function add_cell_pickup_tuesday(id){
	$.ajax({
		url : 'add_hours_pickup_tuesday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'pickup_div_tuesday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_pickup_tuesday').appendChild(menuDiv);
			document.getElementById('item_id_pickup_tuesday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_pickup_tuesday').focus();
}

function remove_pickup_div_tuesday(delId)
{
	var div = document.getElementById("pickup_div_tuesday_" + delId);
	div.parentNode.removeChild(div);
}

function check_tue_pickup_from(val,id)
{
	var delto = Converttimeformat($("#pickup_hours_tue_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickup_hours_tue_from"+id).val('');
		}
	}
}

function check_tue_pickup_to(val,id)
{
	var delfrom = Converttimeformat($("#pickup_hours_tue_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickup_hours_tue_to"+id).val('');
		}
	}
}

</script>


<p>Pickup Hours (Tuesday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_pickup_tuesday(document.getElementById('item_id_pickup_tuesday').value)" id="item_focus_pickup_tuesday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_tuesday_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '2'");
if(mysql_num_rows($sql_tuesday_pickup_hrs) > 0){
$id_tue = 1;
while($array_tuesday_pickup_hrs = mysql_fetch_array($sql_tuesday_pickup_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_tue_pickup_hrs=<?php echo $array_tuesday_pickup_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="pickuphourstue_from<?php echo $id_tue; ?>" id="pickuphourstue_from<?php echo $id_tue; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_tuesday_pickup_hrs['time_from']; ?>" style="width:93px;" onBlur="check_tue_pickup_from(this.value,'<?php echo $id_tue; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickuphourstue_to<?php echo $id_tue; ?>" id="pickuphourstue_to<?php echo $id_tue; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_tuesday_pickup_hrs['time_to']; ?>" style="width:93px;" onBlur="check_pickup_buss_to(this.value,'<?php echo $id_tue; ?>');" />

<?php 
$id_tue++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_pickup_tuesday">
<?php if(mysql_num_rows($sql_tuesday_pickup_hrs) == 0){?>
<input name="pickup_hours_tue_from1" id="pickup_hours_tue_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_tue_pickup_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_tue_to1" id="pickup_hours_tue_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_tue_pickup_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_pickup_tuesday" name="item_id_pickup_tuesday" value="2">

<input type="hidden" name="countdiv_pickup_tuesday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Tuesday Pickup Hours -------------------------------------->

<!--------------------------------------- Wednesday Pickup Hours -------------------------------------->

<script type="text/javascript">
function add_cell_pickup_wednesday(id){
	$.ajax({
		url : 'add_hours_pickup_wednesday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'pickup_div_wednesday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_pickup_wednesday').appendChild(menuDiv);
			document.getElementById('item_id_pickup_wednesday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_pickup_wednesday').focus();
}

function remove_pickup_div_wednesday(delId)
{
	var div = document.getElementById("pickup_div_wednesday_" + delId);
	div.parentNode.removeChild(div);
}

function check_wed_pickup_from(val,id)
{
	var delto = Converttimeformat($("#pickup_hours_wed_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickup_hours_wed_from"+id).val('');
		}
	}
}

function check_wed_pickup_to(val,id)
{
	var delfrom = Converttimeformat($("#pickup_hours_wed_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickup_hours_wed_to"+id).val('');
		}
	}
}

</script>


<p>Pickup Hours (Wednesday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_pickup_wednesday(document.getElementById('item_id_pickup_wednesday').value)" id="item_focus_pickup_wednesday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_wednesday_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '3'");
if(mysql_num_rows($sql_wednesday_pickup_hrs) > 0){
$id_wed = 1;
while($array_wednesday_pickup_hrs = mysql_fetch_array($sql_wednesday_pickup_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_wed_pickup_hrs=<?php echo $array_wednesday_pickup_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="pickuphourswed_from<?php echo $id_wed; ?>" id="pickuphourswed_from<?php echo $id_wed; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_wednesday_pickup_hrs['time_from']; ?>" style="width:93px;" onBlur="check_wed_pickup_from(this.value,'<?php echo $id_wed; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickuphourswed_to<?php echo $id_wed; ?>" id="pickuphourswed_to<?php echo $id_wed; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_wednesday_pickup_hrs['time_to']; ?>" style="width:93px;" onBlur="check_pickup_buss_to(this.value,'<?php echo $id_wed; ?>');" />

<?php 
$id_wed++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_pickup_wednesday">
<?php if(mysql_num_rows($sql_wednesday_pickup_hrs) == 0){?>
<input name="pickup_hours_wed_from1" id="pickup_hours_wed_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_wed_pickup_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_wed_to1" id="pickup_hours_wed_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_wed_pickup_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_pickup_wednesday" name="item_id_pickup_wednesday" value="2">

<input type="hidden" name="countdiv_pickup_wednesday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Wednesday Pickup Hours -------------------------------------->

<!--------------------------------------- Thursday Pickup Hours -------------------------------------->

<script type="text/javascript">
function add_cell_pickup_thursday(id){
	$.ajax({
		url : 'add_hours_pickup_thursday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'pickup_div_thursday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_pickup_thursday').appendChild(menuDiv);
			document.getElementById('item_id_pickup_thursday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_pickup_thursday').focus();
}

function remove_pickup_div_thursday(delId)
{
	var div = document.getElementById("pickup_div_thursday_" + delId);
	div.parentNode.removeChild(div);
}

function check_thu_pickup_from(val,id)
{
	var delto = Converttimeformat($("#pickup_hours_thu_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickup_hours_thu_from"+id).val('');
		}
	}
}

function check_thu_pickup_to(val,id)
{
	var delfrom = Converttimeformat($("#pickup_hours_thu_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickup_hours_thu_to"+id).val('');
		}
	}
}

</script>


<p>Pickup Hours (Thursday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_pickup_thursday(document.getElementById('item_id_pickup_thursday').value)" id="item_focus_pickup_thursday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_thursday_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '4'");
if(mysql_num_rows($sql_thursday_pickup_hrs) > 0){
$id_thu = 1;
while($array_thursday_pickup_hrs = mysql_fetch_array($sql_thursday_pickup_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_thu_pickup_hrs=<?php echo $array_thursday_pickup_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="pickuphoursthu_from<?php echo $id_thu; ?>" id="pickuphoursthu_from<?php echo $id_thu; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_thursday_pickup_hrs['time_from']; ?>" style="width:93px;" onBlur="check_thu_pickup_from(this.value,'<?php echo $id_thu; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickuphoursthu_to<?php echo $id_thu; ?>" id="pickuphoursthu_to<?php echo $id_thu; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_thursday_pickup_hrs['time_to']; ?>" style="width:93px;" onBlur="check_pickup_buss_to(this.value,'<?php echo $id_thu; ?>');" />

<?php 
$id_thu++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_pickup_thursday">
<?php if(mysql_num_rows($sql_thursday_pickup_hrs) == 0){?>
<input name="pickup_hours_thu_from1" id="pickup_hours_thu_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_thu_pickup_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_thu_to1" id="pickup_hours_thu_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_thu_pickup_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_pickup_thursday" name="item_id_pickup_thursday" value="2">

<input type="hidden" name="countdiv_pickup_thursday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Thursday Pickup Hours -------------------------------------->

<!--------------------------------------- Friday Pickup Hours -------------------------------------->

<script type="text/javascript">
function add_cell_pickup_friday(id){
	$.ajax({
		url : 'add_hours_pickup_friday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'pickup_div_friday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_pickup_friday').appendChild(menuDiv);
			document.getElementById('item_id_pickup_friday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_pickup_friday').focus();
}

function remove_pickup_div_friday(delId)
{
	var div = document.getElementById("pickup_div_friday_" + delId);
	div.parentNode.removeChild(div);
}

function check_fri_pickup_from(val,id)
{
	var delto = Converttimeformat($("#pickup_hours_fri_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickup_hours_fri_from"+id).val('');
		}
	}
}

function check_fri_pickup_to(val,id)
{
	var delfrom = Converttimeformat($("#pickup_hours_fri_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickup_hours_fri_to"+id).val('');
		}
	}
}

</script>


<p>Pickup Hours (Friday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_pickup_friday(document.getElementById('item_id_pickup_friday').value)" id="item_focus_pickup_friday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_friday_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '5'");
if(mysql_num_rows($sql_friday_pickup_hrs) > 0){
$id_fri = 1;
while($array_friday_pickup_hrs = mysql_fetch_array($sql_friday_pickup_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_fri_pickup_hrs=<?php echo $array_friday_pickup_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="pickuphoursfri_from<?php echo $id_fri; ?>" id="pickuphoursfri_from<?php echo $id_fri; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_friday_pickup_hrs['time_from']; ?>" style="width:93px;" onBlur="check_fri_pickup_from(this.value,'<?php echo $id_fri; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickuphoursfri_to<?php echo $id_fri; ?>" id="pickuphoursfri_to<?php echo $id_fri; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_friday_pickup_hrs['time_to']; ?>" style="width:93px;" onBlur="check_pickup_buss_to(this.value,'<?php echo $id_fri; ?>');" />

<?php 
$id_fri++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_pickup_friday">
<?php if(mysql_num_rows($sql_friday_pickup_hrs) == 0){?>
<input name="pickup_hours_fri_from1" id="pickup_hours_fri_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_fri_pickup_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_fri_to1" id="pickup_hours_fri_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_fri_pickup_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_pickup_friday" name="item_id_pickup_friday" value="2">

<input type="hidden" name="countdiv_pickup_friday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Friday Pickup Hours -------------------------------------->

<!--------------------------------------- Saturday Pickup Hours -------------------------------------->

<script type="text/javascript">
function add_cell_pickup_saturday(id){
	$.ajax({
		url : 'add_hours_pickup_saturday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'pickup_div_saturday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_pickup_saturday').appendChild(menuDiv);
			document.getElementById('item_id_pickup_saturday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_pickup_saturday').focus();
}

function remove_pickup_div_saturday(delId)
{
	var div = document.getElementById("pickup_div_saturday_" + delId);
	div.parentNode.removeChild(div);
}

function check_sat_pickup_from(val,id)
{
	var delto = Converttimeformat($("#pickup_hours_sat_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickup_hours_sat_from"+id).val('');
		}
	}
}

function check_sat_pickup_to(val,id)
{
	var delfrom = Converttimeformat($("#pickup_hours_sat_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickup_hours_sat_to"+id).val('');
		}
	}
}

</script>


<p>Pickup Hours (Saturday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_pickup_saturday(document.getElementById('item_id_pickup_saturday').value)" id="item_focus_pickup_saturday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_saturday_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '6'");
if(mysql_num_rows($sql_saturday_pickup_hrs) > 0){
$id_sat = 1;
while($array_saturday_pickup_hrs = mysql_fetch_array($sql_saturday_pickup_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_sat_pickup_hrs=<?php echo $array_saturday_pickup_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="pickuphourssat_from<?php echo $id_sat; ?>" id="pickuphourssat_from<?php echo $id_sat; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_saturday_pickup_hrs['time_from']; ?>" style="width:93px;" onBlur="check_sat_pickup_from(this.value,'<?php echo $id_sat; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickuphourssat_to<?php echo $id_sat; ?>" id="pickuphourssat_to<?php echo $id_sat; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_saturday_pickup_hrs['time_to']; ?>" style="width:93px;" onBlur="check_pickup_buss_to(this.value,'<?php echo $id_sat; ?>');" />

<?php 
$id_sat++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_pickup_saturday">
<?php if(mysql_num_rows($sql_saturday_pickup_hrs) == 0){?>
<input name="pickup_hours_sat_from1" id="pickup_hours_sat_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sat_pickup_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_sat_to1" id="pickup_hours_sat_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sat_pickup_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_pickup_saturday" name="item_id_pickup_saturday" value="2">

<input type="hidden" name="countdiv_pickup_saturday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Saturday Pickup Hours -------------------------------------->

<!--------------------------------------- Sunday Pickup Hours -------------------------------------->

<script type="text/javascript">
function add_cell_pickup_sunday(id){
	$.ajax({
		url : 'add_hours_pickup_sunday.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'pickup_div_sunday_' + id;
			//menuDiv.setAttribute("class","mainmanu");
			menuDiv.innerHTML = menuContent;
			document.getElementById('allmenu_pickup_sunday').appendChild(menuDiv);
			document.getElementById('item_id_pickup_sunday').value=parseInt(id)+1;
			
			$('.time_pick_ajax').timepicker({ 'timeFormat': 'h:i A' });
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus_pickup_sunday').focus();
}

function remove_pickup_div_sunday(delId)
{
	var div = document.getElementById("pickup_div_sunday_" + delId);
	div.parentNode.removeChild(div);
}

function check_sun_pickup_from(val,id)
{
	var delto = Converttimeformat($("#pickup_hours_sun_to"+id).val());
	var value = Converttimeformat(val);
	
	if(delto != "")
	{
		if(value > delto)
		{
			alert("From time cannot be greater than To time.");
			$("#pickup_hours_sun_from"+id).val('');
		}
	}
}

function check_sun_pickup_to(val,id)
{
	var delfrom = Converttimeformat($("#pickup_hours_sun_from"+id).val());
	var value = Converttimeformat(val);
	
	if(delfrom != "")
	{
		if(value < delfrom)
		{
			alert("To time cannot be less than From time.");
			$("#pickup_hours_sun_to"+id).val('');
		}
	}
}

</script>


<p>Pickup Hours (Sunday):</p>
<div class="cross_bt" style="margin-left:414px;margin-top:11px;"><a href="javascript:void(0);" onClick="add_cell_pickup_sunday(document.getElementById('item_id_pickup_sunday').value)" id="item_focus_pickup_sunday"><img  src="images/grn-plus.png"></a>
</div>
<?php 
$sql_sunday_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE restaurant_id = '".$_REQUEST['restaurant_edit_id']."' AND days_id = '7'");
if(mysql_num_rows($sql_sunday_pickup_hrs) > 0){
$id_sun = 1;
while($array_sunday_pickup_hrs = mysql_fetch_array($sql_sunday_pickup_hrs)){ ?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;"><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id'];?>&delete_sun_pickup_hrs=<?php echo $array_sunday_pickup_hrs['id'];?>">
<img  src="images/Close_Box_Red.png">
</a></div>
<input name="pickuphourssun_from<?php echo $id_sun; ?>" id="pickuphourssun_from<?php echo $id_sun; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_sunday_pickup_hrs['time_from']; ?>" style="width:93px;" onBlur="check_sun_pickup_from(this.value,'<?php echo $id_sun; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickuphourssun_to<?php echo $id_sun; ?>" id="pickuphourssun_to<?php echo $id_sun; ?>" type="text" class="restaurant time_pick" value="<?php echo $array_sunday_pickup_hrs['time_to']; ?>" style="width:93px;" onBlur="check_pickup_buss_to(this.value,'<?php echo $id_sun; ?>');" />

<?php 
$id_sun++; ?>
<p></p>
<?php }
 } ?>


<div id="allmenu_pickup_sunday">
<?php if(mysql_num_rows($sql_sunday_pickup_hrs) == 0){?>
<input name="pickup_hours_sun_from1" id="pickup_hours_sun_from1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sun_pickup_from(this.value,'1');" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_sun_to1" id="pickup_hours_sun_to1" type="text" class="restaurant time_pick" value="" style="width:93px;" onBlur="check_sun_pickup_to(this.value,'1');" />
<?php } ?>

<input type="hidden" id="item_id_pickup_sunday" name="item_id_pickup_sunday" value="2">

<input type="hidden" name="countdiv_pickup_sunday[]" value="1" class="webcampics">

<div class="clear"></div>
</div>

<!--------------------------------------- Sunday Pickup Hours -------------------------------------->




<p>Drive-Thru* :</p>

<input name="drive_thru" id="drive_thru1" type="radio" value="1" class="radio_section" <?php if($result_business_delivery_details['drive_thru']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="drive_thru" id="drive_thru2" type="radio" value="0"  class="radio_section" <?php if($result_business_delivery_details['drive_thru']==0){?> checked<?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

</div>

<div class="restaurant_form_field">

<p>Tax (%) :</p>

<input name="tax" id="tax" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['tax']?>" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<p>Commission (%) :</p>

<input name="commission" id="commission" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['commission']?>" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<p>Credit Card Fee (%) :</p>

<input name="credit_card_fee" id="credit_card_fee" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['credit_card_fee']?>" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<p>Service Fee ($) :</p>

<input name="service_fee" id="service_fee" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['service_fee']?>" onKeyPress="return goodchars(event,'1234567890.');"/>

<h1>Delivery Order Time</h1>

<div class="clear"></div>

<p>Time Slot 1 :</p>

<input name="del_time_slot1" id="del_time_slot1" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['del_time_slot1']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 2 :</p>

<input name="del_time_slot2" id="del_time_slot2" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['del_time_slot2']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 3 :</p>

<input name="del_time_slot3" id="del_time_slot3" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['del_time_slot3']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 4 :</p>

<input name="del_time_slot4" id="del_time_slot4" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['del_time_slot4']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 5 :</p>

<input name="del_time_slot5" id="del_time_slot5" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['del_time_slot5']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 6 :</p>

<input name="del_time_slot6" id="del_time_slot6" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['del_time_slot6']?>" onKeyPress="return goodchars(event,'1234567890+');"/>


<h1>Pickup Order Time</h1>

<div class="clear"></div>

<p>Time Slot 1 :</p>

<input name="pick_time_slot1" id="pick_time_slot1" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['pickup_time_slot1']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 2 :</p>

<input name="pick_time_slot2" id="pick_time_slot2" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['pickup_time_slot2']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 3 :</p>

<input name="pick_time_slot3" id="pick_time_slot3" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['pickup_time_slot3']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 4 :</p>

<input name="pick_time_slot4" id="pick_time_slot4" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['pickup_time_slot4']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 5 :</p>

<input name="pick_time_slot5" id="pick_time_slot5" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['pickup_time_slot5']?>" onKeyPress="return goodchars(event,'1234567890+');"/>

<p>Time Slot 6 :</p>

<input name="pick_time_slot6" id="pick_time_slot6" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['pickup_time_slot6']?>" onKeyPress="return goodchars(event,'1234567890.');"/>


<h1>Services -</h1>

<div class="clear"></div>

<p>Catering Service* :</p>

<input name="catering_service" id="catering_service1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['catering_service']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="catering_service" id="catering_service2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['catering_service']==0){?> checked<?php }?> />
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Self Service* :</p>

<input name="self_service" id="self_service1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['self_service']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="self_service" id="self_service2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['self_service']==0){?> checked<?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Waiter Service* :</p>

<input name="waiter_service" id="water_service1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['waiter_service']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="waiter_service" id="water_service2"  type="radio" value="0" class="radio_section" <?php if($result_service_detail['waiter_service']==0){?> checked<?php }?> />
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Kid Friendly* :</p>

<input name="kid_friendly" id="kid_friendly1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['kid_friendly']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="kid_friendly" id="kid_friendly2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['kid_friendly']==0){?> checked<?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Handicape* :</p>

<input name="handicape" id="handicape1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['handicape']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="handicape" id="handicape2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['handicape']==0){?> checked<?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Outdoor Seating* :</p>

<input name="outdoor_seating" id="outdoor_seating1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['outdoor_seating']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="outdoor_seating" id="outdoor_seating2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['outdoor_seating']==0){?> checked<?php }?> />
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Alcohol* :</p>

<input name="alchohol" id="alchohol1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['alchohol']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="alchohol" id="alchohol2" type="radio" value="0"  class="radio_section" <?php if($result_service_detail['alchohol']==0){?> checked<?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Bar Seating* :</p>

<input name="bar_seating" id="bar_Seating1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['bar_seating']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="bar_seating" id="bar_Seating2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['bar_seating']==0){?> checked<?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Wi-Fi* :</p>

<input name="wi_fi" id="wi_fi1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['wi_fi']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="wi_fi" id="wi_fi2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['wi_fi']==0){?> checked<?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Live Music* :</p>

<input name="live_music" id="live_music1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['live_music']==1){?> checked<?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="live_music" id="live_music2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['live_music']==0){?> checked<?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Reservation :</p>

<input name="reservation" id="reservation1" type="radio" value="1" class="radio_section" <?php if($result_service_detail['reservation']==1){?> checked<?php }?> onClick="get_reservation_hours(this.value);"/>
<p class="restaurant_radio_field">Yes</p>
<input name="reservation" id="reservation2" type="radio" value="0" class="radio_section" <?php if($result_service_detail['reservation']==0){?> checked<?php }?> onClick="get_reservation_hours(this.value);"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>


<div id="reservation_hrs_div" style="display:none;">

<script type="text/javascript">
function check_res_mon_from(val)
{
	var mon_res_to_value = Converttimeformat($("#reservation_close_Monday").val());
	var value = Converttimeformat(val);
	
	if(mon_res_to_value != "")
	{
		if(value > mon_res_to_value)
		{
			alert("From time cannot be greater than To time.");
			$("#reservation_open_Monday").val('');
		}
	}
}

function check_res_mon_to(val)
{
	var mon_res_from_value = Converttimeformat($("#reservation_open_Monday").val());
	var value = Converttimeformat(val);
	
	if(mon_res_from_value != "")
	{
		if(value < mon_res_from_value)
		{
			alert("To time cannot be less than From time.");
			$("#reservation_close_Monday").val('');
		}
	}
}

</script>


<p>Reservation Hours(Monday) : </p>

<input name="reservation_open_Monday" id="reservation_open_Monday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_open_Monday']; ?>" style="width:93px;" onBlur="check_res_mon_from(this.value);" />
<span style="color:#888888;">to</span>
<input name="reservation_close_Monday" id="reservation_close_Monday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_close_Monday']; ?>" style="width:93px;" onBlur="check_res_mon_to(this.value);" />

<div class="clear"></div>

<script type="text/javascript">
function check_res_tue_from(val)
{
	var tue_res_to_value = Converttimeformat($("#reservation_close_Tuesday").val());
	var value = Converttimeformat(val);
	
	if(tue_res_to_value != "")
	{
		if(value > tue_res_to_value)
		{
			alert("From time cannot be greater than To time.");
			$("#reservation_open_Tuesday").val('');
		}
	}
}

function check_res_tue_to(val)
{
	var tue_res_from_value = Converttimeformat($("#reservation_open_Tuesday").val());
	var value = Converttimeformat(val);
	
	if(tue_res_from_value != "")
	{
		if(value < tue_res_from_value)
		{
			alert("To time cannot be less than From time.");
			$("#reservation_close_Tuesday").val('');
		}
	}
}

</script>


<p>Reservation Hours(Tuesday) : </p>

<input name="reservation_open_Tuesday" id="reservation_open_Tuesday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_open_Tuesday']; ?>" style="width:93px;" onBlur="check_res_tue_from(this.value);" />
<span style="color:#888888;">to</span>
<input name="reservation_close_Tuesday" id="reservation_close_Tuesday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_close_Tuesday']; ?>" style="width:93px;" onBlur="check_res_tue_to(this.value);" />

<div class="clear"></div>

<script type="text/javascript">
function check_res_wed_from(val)
{
	var wed_res_to_value = Converttimeformat($("#reservation_close_Wednesday").val());
	var value = Converttimeformat(val);
	
	if(wed_res_to_value != "")
	{
		if(value > wed_res_to_value)
		{
			alert("From time cannot be greater than To time.");
			$("#reservation_open_Wednesday").val('');
		}
	}
}

function check_res_wed_to(val)
{
	var wed_res_from_value = Converttimeformat($("#reservation_open_Wednesday").val());
	var value = Converttimeformat(val);
	
	if(wed_res_from_value != "")
	{
		if(value < wed_res_from_value)
		{
			alert("To time cannot be less than From time.");
			$("#reservation_close_Wednesday").val('');
		}
	}
}

</script>

<p>Reservation Hours(Wednesday) : </p>

<input name="reservation_open_Wednesday" id="reservation_open_Wednesday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_open_Wednesday']; ?>" style="width:93px;" onBlur="check_res_wed_from(this.value);" />
<span style="color:#888888;">to</span>
<input name="reservation_close_Wednesday" id="reservation_close_Wednesday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_close_Wednesday']; ?>" style="width:93px;" onBlur="check_res_wed_to(this.value);" />

<div class="clear"></div>

<script type="text/javascript">
function check_res_thu_from(val)
{
	var thu_res_to_value = Converttimeformat($("#reservation_close_Thursday").val());
	var value = Converttimeformat(val);
	
	if(thu_res_to_value != "")
	{
		if(value > thu_res_to_value)
		{
			alert("From time cannot be greater than To time.");
			$("#reservation_open_Thursday").val('');
		}
	}
}

function check_res_thu_to(val)
{
	var thu_res_from_value = Converttimeformat($("#reservation_open_Thursday").val());
	var value = Converttimeformat(val);
	
	if(thu_res_from_value != "")
	{
		if(value < thu_res_from_value)
		{
			alert("To time cannot be less than From time.");
			$("#reservation_close_Thursday").val('');
		}
	}
}

</script>

<p>Reservation Hours(Thursday) : </p>

<input name="reservation_open_Thursday" id="reservation_open_Thursday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_open_Thursday']; ?>" style="width:93px;" onBlur="check_res_thu_from(this.value);" />
<span style="color:#888888;">to</span>
<input name="reservation_close_Thursday" id="reservation_close_Thursday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_close_Thursday']; ?>" style="width:93px;" onBlur="check_res_thu_to(this.value);" />

<div class="clear"></div>

<script type="text/javascript">
function check_res_fri_from(val)
{
	var fri_res_to_value = Converttimeformat($("#reservation_close_Friday").val());
	var value = Converttimeformat(val);
	
	if(fri_res_to_value != "")
	{
		if(value > fri_res_to_value)
		{
			alert("From time cannot be greater than To time.");
			$("#reservation_open_Friday").val('');
		}
	}
}

function check_res_fri_to(val)
{
	var fri_res_from_value = Converttimeformat($("#reservation_open_Friday").val());
	var value = Converttimeformat(val);
	
	if(fri_res_from_value != "")
	{
		if(value < fri_res_from_value)
		{
			alert("To time cannot be less than From time.");
			$("#reservation_close_Friday").val('');
		}
	}
}

</script>

<p>Reservation Hours(Friday) : </p>

<input name="reservation_open_Friday" id="reservation_open_Friday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_open_Friday']; ?>" style="width:93px;" onBlur="check_res_fri_from(this.value);" />
<span style="color:#888888;">to</span>
<input name="reservation_close_Friday" id="reservation_close_Friday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_close_Friday']; ?>" style="width:93px;" onBlur="check_res_fri_to(this.value);" />

<div class="clear"></div>

<script type="text/javascript">
function check_res_sat_from(val)
{
	var sat_res_to_value = Converttimeformat($("#reservation_close_Saturday").val());
	var value = Converttimeformat(val);
	
	if(sat_res_to_value != "")
	{
		if(value > sat_res_to_value)
		{
			alert("From time cannot be greater than To time.");
			$("#reservation_open_Saturday").val('');
		}
	}
}

function check_res_sat_to(val)
{
	var sat_res_from_value = Converttimeformat($("#reservation_open_Saturday").val());
	var value = Converttimeformat(val);
	
	if(sat_res_from_value != "")
	{
		if(value < sat_res_from_value)
		{
			alert("To time cannot be less than From time.");
			$("#reservation_close_Saturday").val('');
		}
	}
}

</script>

<p>Reservation Hours(Saturday) : </p>

<input name="reservation_open_Saturday" id="reservation_open_Saturday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_open_Saturday']; ?>" style="width:93px;" onBlur="check_res_sat_from(this.value);" />
<span style="color:#888888;">to</span>
<input name="reservation_close_Saturday" id="reservation_close_Saturday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_close_Saturday']; ?>" style="width:93px;" onBlur="check_res_sat_to(this.value);" />

<div class="clear"></div>

<script type="text/javascript">
function check_res_sun_from(val)
{
	var sun_res_to_value = Converttimeformat($("#reservation_close_Sunday").val());
	var value = Converttimeformat(val);
	
	if(sun_res_to_value != "")
	{
		if(value > sun_res_to_value)
		{
			alert("From time cannot be greater than To time.");
			$("#reservation_open_Sunday").val('');
		}
	}
}

function check_res_sun_to(val)
{
	var sun_res_from_value = Converttimeformat($("#reservation_open_Sunday").val());
	var value = Converttimeformat(val);
	
	if(sun_res_from_value != "")
	{
		if(value < sun_res_from_value)
		{
			alert("To time cannot be less than From time.");
			$("#reservation_close_Sunday").val('');
		}
	}
}

</script>

<p>Reservation Hours(Sunday) : </p>

<input name="reservation_open_Sunday" id="reservation_open_Sunday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_open_Sunday']; ?>" style="width:93px;" onBlur="check_res_sun_from(this.value);" />
<span style="color:#888888;">to</span>
<input name="reservation_close_Sunday" id="reservation_close_Sunday" type="text" class="restaurant" value="<?php echo $result_business_delivery_details['reservation_close_Sunday']; ?>" style="width:93px;" onBlur="check_res_sun_to(this.value);" />

<div class="clear"></div>

</div>

<h1>Dress Code -</h1>

<div class="clear"></div>

<p>Dress Code</p>

<select name="dress_code" id="dress_code" class="restaurant_list">
<option value="Casual" <?php if($result_service_detail['dress_code']=="Casual"){?> selected<?php }?>>Casual</option>
<option value="Dressy" <?php if($result_service_detail['dress_code']=="Dressy"){?> selected<?php }?>>Dressy</option>
</select>

<div class="clear"></div>

<h1>Payment Method -</h1>

<div class="clear"></div>

<div class="payment_left">

<p>Payment Method</p>

</div>
<?php
$payment_array=explode(",",$result_service_detail['payment_method']);
?>

<div class="payment_right">
<h2><input name="payment_method[]" id="payment_method1" type="checkbox" value="Cash" <?php if(in_array("Cash",$payment_array)){?> checked<?php }?>  /> Cash</h2>
<h2><input name="payment_method[]" id="payment_method2" type="checkbox" value="Visa Card" <?php if(in_array("Visa Card",$payment_array)){?> checked<?php }?> /> Visa Card</h2>
<h2><input name="payment_method[]" id="payment_method3" type="checkbox" value="Master Card" <?php if(in_array("Master Card",$payment_array)){?> checked<?php }?> /> Master Card</h2>
<h2><input name="payment_method[]" id="payment_method4" type="checkbox" value="Amex Card" <?php if(in_array("Amex Card",$payment_array)){?> checked<?php }?> /> Amex Card</h2>
<h2><input name="payment_method[]" id="payment_method5" type="checkbox" value="Discovery Card" <?php if(in_array("Discovery Card",$payment_array)){?> checked<?php }?> /> Discovery Card</h2>
</div>

<div class="clear"></div>

<input class="button4" type="submit" value="Save & Continue" name="submit">

</div>

<div class="clear"></div>
</form>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<script type="text/javascript">
get_reservation_hours('<?php echo $result_service_detail['reservation']; ?>');
</script>
