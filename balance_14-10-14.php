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
	header("location:export_balance_excel.php?start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']);
}


?>
<?php /*?><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jQuery.print.js"></script><?php */?>

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
<?php /*?><link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script><?php */?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
	/*$(function() {
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
	});*/
	
	function open_view_div(id)
	{
		alert(id);
		var $j = jQuery.noConflict();
		
		$j("#inline_"+id).show();
	}
</script>
<script type="text/javascript">
function sort_function(sort_by,order_date,order_number,order_type){
	location.href = 'billing.php?sort_order='+sort_by+"&order_date="+order_date+"&order_number="+order_number+"&order_type="+order_type;
}
</script>

<script>
var $j = jQuery.noConflict();
$j( document ).ready(function() {
	var enq_dat = new Date();
	$j(window).on('load',function() {
	  $j('#end_date').datepicker('option', 'minDate', enq_dat);
	});	  
});
$j(function()
{
    $j('#start_date').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function(dateStr) {
		  var date = $j(this).datepicker('getDate');		  
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $j('#end_date').datepicker('option', 'minDate', date);
		}
      });
      $j('#end_date').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function (selectedDate) {
		  var date = $j(this).datepicker('getDate');
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $j('#start_date').datepicker('option', 'maxDate', date || 0);
		}
      });
});
</script>




<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px; width: 959px">

<ul class="tab-look">
	<li><a href="billing.php">Statements</a></li>
	<li class="active"><a href="balance.php">Balance</a></li>
</ul>

<div class="clear"></div>

<div class="tab-look-restu" style="padding:2%;">
          <form name="frm" method="post" action="balance.php">
            <table class="sec-pnl-top" width="100%">
              <tr>
               <td width="193">
					Specify your Search : 
				</td>
                
               	<td width="127">Start Date : </td>
                <td width="177">
                <input type="text" name="start_date" id="start_date" class="restaurant" style="width:150px;" value="<?php echo $_REQUEST['start_date']; ?>" autocomplete="off">
                </td>
                <td width="103">End Date : </td>
                <td width="180" id="cust_date_td">
                <input type="text" name="end_date" id="end_date" class="restaurant" style="width:150px;" value="<?php echo $_REQUEST['end_date']; ?>" autocomplete="off"></td>
                
                <td align="left" style="padding-right:5px;">
			    	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
    			</td>
    		
                  
               </tr>
               
              <tr>
                <td colspan="6" align="right"  style="padding-right:5px;">
                	 <?php
					if($_REQUEST['submit'] == "Search")
					{
					?>
			    	<input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0 0 0 3px;">
                    <?php
					}
					?>
                    
                    <?php
					if($_REQUEST['submit'] == "Search")
					{
					?>
					<a href="javascript:void(0);" class="check_order_button noprint" style="float: right; text-decoration: none; padding: 7px 10px; font-size: 13px; margin: 0px 0px 5px 5px;" id="print_but" >Print</a>
					<?php
					}
					?>
                </td>
                
                  </tr>
            </table>
          </form>
          


<?php
if($_REQUEST['submit'] == "Search")
{
	$start_date = change_dateformat_reverse($_REQUEST['start_date']);
	$end_date = change_dateformat_reverse($_REQUEST['end_date']);
	
	
	//echo "SELECT * FROM restaurant_menu_order WHERE order_date >= '".$end_date."' AND order_date <= '".$start_date."' AND restaurant_id = '".$_SESSION['restaurant']."'";
	
	$sql_search = mysql_query("SELECT * FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'");
	
	
	$num_rows = mysql_num_rows($sql_search);
	
	
	$get_totals = mysql_fetch_array(mysql_query("SELECT SUM(tax) as tot_tax, SUM(tip) as tot_tip, SUM(commission) as tot_commission, SUM(coupon_discount) as tot_coupons, SUM(price_with_del_charge) as tot_sales FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$get_cash_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cash FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$get_cc_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cc FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$sql_res_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant']."'"));
	
	
	if($num_rows > 0)
	{
	
	?>
    <div id="printdiv">
    <span style="font-weight:bold; color:#4A7AD5; font-size:19px;">Summary for <?php echo $_REQUEST['start_date']; ?> - <?php echo $_REQUEST['end_date']; ?></span>
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
    
	
	<table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse; margin-top:20px;">
    <tr style="text-align:center;">
    <td class="all_restaurant">Order #</td><td class="all_restaurant">Restaurant</td><td class="all_restaurant">Date</td><td class="all_restaurant">Type</td><td class="all_restaurant">Total</td><td class="all_restaurant">Commission</td><td class="all_restaurant">Coupons</td><td class="all_restaurant">Status</td><td class="all_restaurant">Action</td>
    </tr>
    
	<?php
	while($fetch_array = mysql_fetch_array($sql_search))
	{
		
		if($fetch_array['payment_mode'] == "cash")
		{
			$payment_mode = "Cash";
			$status = "Unpaid";
		}
		else
		{
			$payment_mode = "Prepaid";
			$status = "Paid";
		}
		
		
		?>
    <tr style="text-align:center;">
    <td class="all_restaurant2"><?php echo "OR-00".$fetch_array['order_id']; ?></td>
    <td class="all_restaurant2"><?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']); ?></td>
    <td class="all_restaurant2"><?php echo date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])); ?></td>
    <td class="all_restaurant2"><?php echo $payment_mode; ?></td>
    <td class="all_restaurant2"><?php echo "$".$fetch_array['price_with_del_charge']; ?></td>
    <td class="all_restaurant2"><?php echo "$".$fetch_array['commission']; ?></td>
    <td class="all_restaurant2"><?php echo "$".$fetch_array['coupon_discount']; ?></td>
    <td class="all_restaurant2"><?php echo $status; ?></td>
    <td class="all_restaurant2"><a class="various1" href="#inline_<?php echo $fetch_array['order_id'];?>" title="View" style="color:#686868;">View</a></td>
    
    </tr>
    <?php
    $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$fetch_array['customer_id']."'"));
	
	$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$fetch_array['order_id']."'"));
	?>
    <div style="display: none;">
    	<div id="inline_<?php echo $fetch_array['order_id'];?>" style="width:500px;height:300px;overflow:auto;">
        <div class="profle_wrapper">
            <div style="width:450px;">
                <h1 style="color:#2B4494;">Order Details</h1>
               	<p style="padding-bottom:5px;"><b>Order No. : </b><?php echo "OR-00".$fetch_array['order_id'];?></p>
                <p style="padding-bottom:5px;"><b>Order Amount : </b><?php echo "$ ".($fetch_array['price_with_del_charge']); ?></p>
                <p style="padding-bottom:5px;"><b>Customer Name : </b><?php echo $sql_customer['firstname']." ".$sql_customer['lastname']; ?></p>
                <p style="padding-bottom:5px;"><b>Contact Details : </b><?php echo $sql_contact_details['address']."<br>";
				echo $sql_contact_details['city']." ".$sql_contact_details['state']." ".$sql_contact_details['zipcode']; ?></p>
                <p style="padding-bottom:5px;"><b>Phone No. : </b><?php echo $sql_contact_details['phone']; ?></p>
                <p style="padding-bottom:5px;"><b>Menu Items ----- </b><br>
				<?php $sql_items_ordered = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$fetch_array['order_id']."'");
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
                <?php } ?>
            </div>
        </div>
    </div>
    </div>
    <?php
	}
	?>
    
    </table>
    </div>
	<?php	
	}
	else
	{
		?><p  class="no-record">No Records Found.</p><?php
	}
}
?>
</div>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

