<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
//rest_chk_authentication();
//print_r($_SESSION);
//echo $_SESSION['restaurant_id'];
if(!isset($_SESSION['restaurant_admin_panel_id'])){
	header('location:restaurant_admin_login.php');
}
function change_dateformat_reverse($param)

	{
	
		 $date=explode("-",$param);
		
		 $dateformat=$date[2]."-".$date[0]."-".$date[1];
		
		 return $dateformat;
	
	}

function date_before_prev($date)
{
	//$date_new = date('Y-d-m', strtotime($date));
		
	$date_bef = date ('Y-m-d', strtotime ( '-7 day' . $date ) );
	
	return $date_bef;
}	

if($_REQUEST['export'] == "Export to Excel")
{
	header("location:export_billing_excel.php?statement=".$_REQUEST['statement']);
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jQuery.print.js"></script>

<script type="text/javascript">
var $j = jQuery.noConflict();
$j(function() {
    $j("#print_but").click(function() {
    $j("#printdiv").print();
    return (false);
});
});
</script>
<body>
<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
	$(function() {
  	var pickerOpts = {
    dateFormat:"mm-dd-yy"
	};
		$( "#order_date" ).datepicker(pickerOpts);
	});
	
	 $(function() {
  	var pickerOpts = {
    dateFormat:"mm-dd-yy"
	};
		$( "#start_date" ).datepicker(pickerOpts);
	});
	
	 $(function() {
  	var pickerOpts = {
    dateFormat:"mm-dd-yy"
	};
		$( "#end_date" ).datepicker(pickerOpts);
	});
</script>
<script type="text/javascript">
function sort_function(sort_by,order_date,order_number,order_type){
	location.href = 'billing.php?sort_order='+sort_by+"&order_date="+order_date+"&order_number="+order_number+"&order_type="+order_type;
}
</script>

<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">



<a href="javascript:void(0);">Statements</a>
<a href="javascript:void(0);">Balance</a>

<form name="frm" method="post" action="">
<table><tr>
<td width="153"><select name="statement" id="statement">
<option value="">---SELECT---</option>

<?php
$prev_date = date('Y-m-d');
for($i = 1;$i<=24;$i++){
	
	if($i==1)
	{
		$date = $prev_date;
	}
	else
	{
		$date = date('Y-m-d' ,strtotime("-1 day" .$prev_date)) ;
	}
	
	$prev_date = date_before_prev($date);
	
	$sql_statement_date = mysql_num_rows(mysql_query("SELECT order_id FROM restaurant_menu_order WHERE order_date >= '".$prev_date."' AND order_date <= '".$date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	if($sql_statement_date > 1)
	{
		$order = "Orders";
	}
	else
	{
		$order = "Order";
	}
	?>
    <option value="<?php echo $date."^".$prev_date; ?>"<?php if($_REQUEST['statement'] == $date."^".$prev_date) { ?> selected <?php } ?>><?php echo date('m/d/Y', strtotime($prev_date))." - ".date('m/d/Y', strtotime($date))." : ".$sql_statement_date." ".$order; ?></option>
<?php } ?>
</select></td>
<td width="173"><input type="submit" name="submit" value="Search" class="button4" style="margin:0px;"></td>
<?php
if($_REQUEST['submit'] == "Search")
{
	?><td width="173"><input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0px;"></td><?php
}
?>
<tr>
</table>
</form>

<?php
if($_REQUEST['submit'] == "Search")
{
?>
<a href="javascript:void(0);" class="check_order_button noprint" style="float:right; text-decoration:none; margin:0px 10px 5px 0px;" id="print_but" >Print</a>
<?php
}
?>

<?php
if($_REQUEST['submit'] == 'Search')
{
	$search_date = $_REQUEST['statement'];
	
	$get_search_date = explode("^",$search_date);

	$query_res = mysql_query("SELECT * FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND restaurant_id = '".$_SESSION['restaurant']."'");
	
	$num_rows = mysql_num_rows($query_res);
	
	
	
	$get_totals = mysql_fetch_array(mysql_query("SELECT SUM(tax) as tot_tax, SUM(tip) as tot_tip, SUM(commission) as tot_commission, SUM(coupon_discount) as tot_coupons, SUM(price_with_del_charge) as tot_sales FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."'  AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$get_cash_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cash FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND payment_mode = 'cash'  AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$get_cc_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cc FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND payment_mode = 'credit_card' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$sql_res_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant']."'"));
	
	?>
    <div id="printdiv">
	Statement : <?php echo date('m/d/Y', strtotime($get_search_date[1]))." - ".date('m/d/Y', strtotime($get_search_date[0]))."<br>"; ?>
	
	<?php
	
	echo "To: ".$sql_res_details['restaurant_name']."<br>";
	
	echo $sql_res_details['restaurant_address']."<br>";
	
	?>
    Date : 
    <?php
	echo date('m/d/Y h:i:s a')."<br>";
	if($num_rows > 0)
	{
	?>
    <br>
	<span style="font-weight:bold; color:#4A7AD5; font-size:19px;">Summary</span>
    <table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse; margin-top:20px;">
    <tr style="text-align:center;">
    <td class="all_restaurant">Count</td><td class="all_restaurant">Total Sales</td><td class="all_restaurant">Total Cash</td><td class="all_restaurant">Total CC</td><td class="all_restaurant">Total Tax</td><td class="all_restaurant">Total Coupons</td><td class="all_restaurant">Total Tip</td><td class="all_restaurant">Total Commission</td><!--<td>Total CC Fee</td><td>Amount Due</td>-->
    </tr>
    <tr style="text-align:center;">
    <td class="all_restaurant2"><?php echo $num_rows; ?></td>
    <td class="all_restaurant2"><?php echo "$".$get_totals['tot_sales'];?></td>
    <td class="all_restaurant2"><?php echo "$".$get_cash_total['tot_cash']; ?></td>
    <td class="all_restaurant2"><?php if($get_cc_total['tot_cc'] != '') echo "$".$get_cc_total['tot_cc']; else echo "$0.00"; ?></td>
    <td class="all_restaurant2"><?php echo "$".$get_totals['tot_tax'];?></td>
    <td class="all_restaurant2"><?php echo "$".$get_totals['tot_coupons'];?></td>
    <td class="all_restaurant2"><?php echo "$".$get_totals['tot_tip'];?></td>
    <td class="all_restaurant2"><?php echo "$".$get_totals['tot_commission'];?></td>
    <?php /*?><td><?php echo "$";?></td>
    <td><?php echo "$";?></td><?php */?>
    </tr>
    </table>
    
   <!-- EAT24 Deposited Into Your Account: $ -->
    
    
    <table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse; margin-top:20px;">
    <tr style="text-align:center;">
    <td class="all_restaurant">Order Time</td><td class="all_restaurant">Order #</td><td class="all_restaurant">Restaurant</td><td class="all_restaurant">Type</td><td class="all_restaurant">Tax</td><td class="all_restaurant">Delivery Fee</td><td class="all_restaurant">Tip</td><td class="all_restaurant">Total</td>
    </tr>
    <?php while($fetch_array = mysql_fetch_array($query_res))
	{
		if($fetch_array['payment_mode'] == "cash")
		{
			$payment_mode = "Cash";
		}
		else
		{
			$payment_mode = "Prepaid";
		}
		
	?>
    <tr style="text-align:center;">
    <td class="all_restaurant2"><?php echo date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])); ?></td>
    <td class="all_restaurant2"><?php echo "OR-00".$fetch_array['order_id']; ?></td>
    <td class="all_restaurant2"><?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']); ?></td>
    <td class="all_restaurant2"><?php echo $payment_mode; ?></td>
    <td class="all_restaurant2"><?php echo "$".$fetch_array['tax']; ?></td>
    <td class="all_restaurant2"><?php echo "$".number_format($fetch_array['delivery_charge'],2); ?></td>
    <td class="all_restaurant2"><?php echo "$".$fetch_array['tip']; ?></td>
    <td class="all_restaurant2"><?php echo "$".$fetch_array['price_with_del_charge']; ?></td>
    </tr>
    <?php
	}
	?>
    </table>
    </div>
    
    <?php
}
else
{
	?><p>No Records Found.</p><?php
}
}
?>


</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

