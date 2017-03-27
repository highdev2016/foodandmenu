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

/*if($_REQUEST['export_pdf'] == 'Export to Pdf'){
	header("location:billing_export_pdf.php?statement=".$_REQUEST['statement']);
}*/


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

function open_view_div(id)
{
	var $j = jQuery.noConflict()
	
	$j("#view_details"+id).show();
	$j("#fade1").show();
}

function close_view_div(id)
{
	var $j = jQuery.noConflict()
	
	$j("#view_details"+id).hide();
	$j("#fade1").hide();
}

</script>

<script>
function load_more()
{
	$j('div#loadmoreajaxloader').hide();
	$j('div#loadmoreajaxloaderimg').show();
	
	var search_date = $j("#hid_search_date").val();
	
	var new_search_date = search_date.split("^");
	
	var start_date_ajax = new_search_date[1];
	var end_date_ajax = new_search_date[0];
	var limit = $j("#hid_limit").val();
	var num_rows = $j("#hid_num_rows").val();

	$j.ajax({
	url: "loadmorebilling.php",
	type : 'POST',
	data : 'start_date_ajax=' + start_date_ajax+ '&end_date_ajax=' + end_date_ajax+ '&limit=' +limit,
	success: function(html)
	{
		var new_limit = parseInt(limit) + parseInt(10);
		
		if(html)
		{
			$j('div#loadmoreajaxloaderimg').hide();
			$j("#postswrapper").append(html).fadeIn(1000);
			$j('#hid_limit').val(new_limit)
			$j('div#loadmoreajaxloader').show();
			if(num_rows <= new_limit)
			{
				$j('div#loadmoreajaxloader').hide();
			}
		}else
		{
			$j('div#loadmoreajaxloader').html('<center>No more posts to show.</center>');
		}
	}
	});
}

function get_statement(yr,statement){
	
	var $j = jQuery.noConflict();
	
	$j.ajax({
	url: "statement_history.php",
	type : 'POST',
	data : 'year=' + yr +'&statement=' +statement,
	success: function(html)
	{
		
		$j("#statement_drop_down").html(html);
	}
	});
}

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
function sort_function(sort_by,submit1,statement){
	location.href = 'billing.php?sort_order='+sort_by+'&submit='+submit1+'&statement='+statement;
}
</script>

<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont restu_live_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px; width: 959px">


<ul class="tab-look">
	<li class="active"><a href="billing.php">Statements</a></li>
	<li><a href="balance.php">Balance</a></li>
</ul>

<div class="clear"></div>

<?php
if($_REQUEST['submit1'] == 'Search')
{
	$year = $_REQUEST['year'];
}

if($_REQUEST['submit'] == 'Search')
{
	$search_date = $_REQUEST['statement'];
	
	$year = $_REQUEST['hid_year'];
	
	$get_search_date = explode("^",$search_date);
	
	$sql_num_rows = mysql_num_rows(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$sql_res = "SELECT * FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND restaurant_id = '".$_SESSION['restaurant']."'";
	
	if($_REQUEST['sort_order']!=''){
		$sql_res.= "ORDER BY ".$_REQUEST['sort_order']." ASC"; 
	}else{
		$sql_res.= "ORDER BY order_id DESC"; 
	}
	
	$sql_res.=" LIMIT 0,10";
	
	$query_res = mysql_query($sql_res);
	
	$num_rows = mysql_num_rows($query_res);
	
	
	
	$get_totals = mysql_fetch_array(mysql_query("SELECT SUM(tax) as tot_tax, SUM(tip) as tot_tip, SUM(commission) as tot_commission, SUM(coupon_discount) as tot_coupons, SUM(price_with_del_charge) as tot_sales , SUM(credit_card_fee) as tot_cc_fee , SUM(service_fee) as ser_fee FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."'  AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$get_cash_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cash FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND payment_mode = 'cash'  AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$get_cc_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cc FROM restaurant_menu_order WHERE order_date >= '".$get_search_date[1]."' AND order_date <= '".$get_search_date[0]."' AND payment_mode = 'credit_card' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$sql_res_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant']."'"));
}
	?>

<div class="tab-look-restu">
<form name="search_frm" method="post" class="st-frm">

<table>
<tr>
	<td>
		Select Year : 
	</td>
	<td>
    	
        <select name="year" id="year" onChange="get_statement(this.value,'');">
        <option value="">---SELECT---</option>
        <?php
		for($i=date('Y');$i>=2000;$i--)
		{
		?>
        <option value="<?php echo $i; ?>"<?php if($year == $i) { ?> selected <?php } ?>><?php echo $i; ?></option>
        <?php	
		}
		?>
        </select>
    </td>
</tr>
</table>

</form>




<form name="frm" method="post" action="" class="st-frm">

<div id="statement_drop_down" style="width:520px; float:left; margin-top:-12px;">

</div>
<div>
<?php
if($_REQUEST['submit'] == "Search" && $sql_num_rows > 0)
{
	?>
    <input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0px;">&nbsp;&nbsp;
    <a href="billing_export_pdf.php?statement=<?php echo $_REQUEST['statement']; ?>" title="Export to Pdf" target="_blank" style="text-decoration:none;"><input type="button" name="export_pdf" value="Export to Pdf" class="button4" style="margin:0px;"></a>
	<?php
}
?>

<?php
if($_REQUEST['submit'] == "Search" && $sql_num_rows > 0)
{
?>
<a href="javascript:void(0);" class="check_order_button noprint" style="text-decoration:none; margin-left:5px;" id="print_but" >Print</a>
<?php
}
?>
</div>

<div class="clear"></div>
        
</form>


		<?php
		if($_REQUEST['submit'] == "Search")
		{ 
		if($sql_num_rows > 0)
		{
		?>

    <div id="printdiv" class="printdiv-class" style="padding: 2%;">
    	
    	<h4 class="ttl" style="color: #666666; font-size: 18px;font-weight: bold;text-align: center;text-transform: uppercase;margin: 0 0 44px;font-family: Calibri;">
    		Statement : <?php echo date('m/d/Y', strtotime($get_search_date[1]))." - ".date('m/d/Y', strtotime($get_search_date[0]))."<br>"; ?>		
    	</h4>
	
		<div class="restu-top" style=" border-bottom: 1px solid #DDDDDD;float: left;margin: 0 0 20px;position: relative;width: 100%;">
	
			<div class="restu-info" style="bottom: -1px;float: left;position: relative;width: 30%;font-family: Calibri;">
				
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td style="border-left: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;margin: 0;padding: 1%;font-family: Calibri; color: #686868;">
							To : 
						</td>
						<td style="border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;margin: 0;padding: 1%;font-family: Calibri; color: #686868;"> 
							<span class="fr_to">
								<?php
								  echo $sql_res_details['restaurant_name'];
								?>
							</span>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;margin: 0;padding: 1%;font-family: Calibri; color: #686868;">
							<p style="margin:5px 0; border-bottom:1px dashed #dddddd">
							<?php
								echo $sql_res_details['restaurant_address']." ".$sql_res_details['restaurant_city']." ".$sql_res_details['restaurant_state']." ".$sql_res_details['restaurant_zipcode']."<br>";
								?>
                                </p>
                                <p>
                                <?php
								if($sql_res_details['phone'] != '')
								{
									echo "Phone : ".$sql_res_details['phone']."<br>";
								}
							?>
							</p>
						</td>
					</tr>
					
				</table>
				
				<!-- <label style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;float: left;margin: 0;padding: 1%;width: 94%;">
					<?php
						//echo "To: ".$sql_res_details['restaurant_name']."<br>";
					?>
				</label>
				<label style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;float: left;margin: 0;padding: 1%;width: 94%;">
					<p style="margin:5px 0">
					<?php
						//echo $sql_res_details['restaurant_address']."<br>";
					?>
					</p>
				</label> -->
			</div>
			
			<div class="restu-date text-center" style="bottom: -1px;float: right;position: absolute;right: 0px;width: 25.5%; font-family: Calibri;text-align: center !important;">
				
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td colspan="3" style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;margin: 0;padding: 1%;width: 94%;">
							Date
						</td>
						
					</tr>
					<tr>
						<td style="border-left: 1px solid #ddd; border-top: 1px solid #ddd; margin: 0px; padding: 1% 0px 1% 5%;font-family: Calibri; color: #686868;">
							<span class="fr-dt">
								<?php
								echo date('m/d/Y');
								?>
							</span>
						</td>
						<td style="border-top: 1px solid #DDDDDD;margin: 0;padding: 1% 0; font-family: Calibri; color: #686868;">
							<span class="fr-tm">
								<?php
								echo date('h:i:s');
								?>
							</span>
						</td>
						<td style="border-right: 1px solid #ddd; border-top: 1px solid #ddd; margin: 0px; padding: 1% 5% 1% 0%; font-family: Calibri; color: #686868;">
							<span class="fr-am">
								<?php
								echo date('a');
								?>
							</span> 
						</td>
					</tr>
					
				</table>	
				
				
				
				
				<!-- <label style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;float: left;margin: 0;padding: 1%;width: 94%;">
			  	  Date  
			  	</label>
			    <label style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-top: 1px solid #DDDDDD;float: left;margin: 0;padding: 1%;width: 94%;">
				    <?php
					echo date('m/d/Y h:i:s a')."<br>";
					?>
				</label> -->
			</div>
    	</div>
    	<div class="clear"></div>
		
    <div class="clear"></div>
    
	<span style="font-weight:bold; color:#4A7AD5; font-size:19px;">Summary</span>
    
	<div class="clear"></div>
    <table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="100%" style="border-collapse:collapse; margin-top:20px;">
    <tr style="text-align:center;">
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Count</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Sales</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Cash</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total CC</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Tax</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Coupons</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Tip</td>
	    <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Commission</td>
        <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total CC Fee</td>
        <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Total Service Fee</td>
        <td class="all_restaurant" style=" color: #686868;font-family: Calibri;font-size: 13px;font-weight: bold;padding: 17px ">Amount Due</td>
	    <!--<td>Total CC Fee</td><td>Amount Due</td>-->
	 </tr> 
     <?php
	 	$amount_due = ($get_cc_total['tot_cc'] - $get_totals['tot_commission'] - $get_totals['tot_cc_fee'] - $get_totals['service_fee']);
	 ?>
    <tr style="text-align:center;">
	    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo $sql_num_rows; ?></td>
	    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_totals['tot_sales'];?></td>
	    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_cash_total['tot_cash']; ?></td>
	    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php if($get_cc_total['tot_cc'] != '') echo "$".$get_cc_total['tot_cc']; else echo "$0.00"; ?></td>
	    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_totals['tot_tax'];?></td>
	    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_totals['tot_coupons'];?></td>
	    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_totals['tot_tip'];?></td>
	    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_totals['tot_commission'];?></td>
        <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_totals['tot_cc_fee'];?></td>
        <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_totals['ser_fee'];?></td>
        <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$amount_due;?></td>
	    <?php /*?><td><?php echo "$";?></td>
	    <td><?php echo "$";?></td><?php */?>
    </tr>
    </table>
    
   <!-- EAT24 Deposited Into Your Account: $ -->
    
    <div id="postswrapper" style="margin-bottom:22px; width: 100%">
    <table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="100%" style="border-collapse:collapse; margin-top:20px;">
    <tr style="text-align:center;">
    <td style="width:61px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Serial No.</td>
    <td style="width:148px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Order Time</td>
    <td style="width:82px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Order #</td>
    <td style="width:100px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Restaurant</td>
    <td style="width:42px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Type</td>
    <td style="width:48px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Tax</td>
    <td style="width:80px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Delivery Fee</td>
    <td style="width:80px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Tip</td>
    <td style="width:50px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Commission</td>
    <td style="width:93px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Total</td>
    <td style="width:93px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Credit Card Fee</td>
    <td style="width:93px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Service Fee</td>
    <td style="width:93px; padding: 10px 0px; color: #686868;font-family: Calibri; font-size: 13px;font-weight: bold; text-align: center;">Action</td>
    </tr>
    <?php 
	$sl_no=1;
	while($fetch_array = mysql_fetch_array($query_res))
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
    <td style="width:61px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 54px;display: block;margin: auto;"> <?php echo $sl_no; ?></span> </td>
    <td style="width:148px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"> <span style="width: 145px;display: block;margin: auto;"><?php echo date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])); ?> </span> </td>
    <td style="width:82px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 80px;display: block;margin: auto;"> <?php echo "OR-00".$fetch_array['order_id']; ?> </span> </td>
    <td style="width:100px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 100px;display: block;margin: auto;"> <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']); ?> </span> </td>
    <td style="width:42px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 40px;display: block;margin: auto;"> <?php echo $payment_mode; ?> </span> </td>
    <td style="width:48px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 40px;display: block;margin: auto;"> <?php echo "$".$fetch_array['tax']; ?> </span> </td>
    <td style="width:80px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 74px;display: block;margin: auto;"> <?php echo "$".number_format($fetch_array['delivery_charge'],2); ?> </span></td>
    <td style="width:80px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 50px;display: block;margin: auto;"> <?php echo "$".$fetch_array['tip']; ?></span> </td>
    <td style="width:50px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 50px;display: block;margin: auto;"> <?php echo "$".$fetch_array['commission']; ?></span> </td>
    <td style="width:93px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 60px;display: block;margin: auto;"> <?php echo "$".$fetch_array['price_with_del_charge']; ?></span> </td>
    <td style="width:93px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 60px;display: block;margin: auto;"> <?php echo "$".$fetch_array['credit_card_fee']; ?></span> </td>
    <td style="width:93px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 60px;display: block;margin: auto;"> <?php echo "$".$fetch_array['service_fee']; ?></span> </td>
    <td style="width:93px; padding: 9px 0px; color: #686868;font-family: Calibri; font-size: 13px; text-align: center;"><span style="width: 60px;display: block;margin: auto;"> <a href="javascript:void(0);" title="View" onClick="open_view_div('<?php echo $fetch_array['order_id'] ?>');" style="color:#686868;">View</a> </span> </td>
    </tr>
    
    <?php
    $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$fetch_array['customer_id']."'"));
	
	$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$fetch_array['order_id']."'"));
	?>
    	<div id="view_details<?php echo $fetch_array['order_id'] ?>" class="factor_details white_content nw_white_cont" style="display:none;">
        <div class="close close-new" onClick="close_view_div('<?php echo $fetch_array['order_id'] ?>');"><a href = "javascript:void(0);"></a> </div>
        <div class="l-contnt nw-l-cont"> 
                <h1 style="color:#2B4494;">Order Details</h1>
               	<p style="padding-bottom:5px;"><b>Order No. : </b><?php echo "OR-00".$fetch_array['order_id'];?></p>
                <p style="padding-bottom:5px;"><b>Order Amount : </b><?php echo "$".($fetch_array['price_with_del_charge']); ?></p>
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
    <div id="fade1" class="black_overlay"> </div>
    
    <?php
	$sl_no++;
	}
	?>
    </table>
    </div>
    <?php
	if($sql_num_rows > 10)
	{
	?>
        <div id="loadmoreajaxloader" class="ias_trigger"><center><a href="javascript:void(0);" onClick="load_more();">Load More Records</a></center></div>
        <div id="loadmoreajaxloaderimg" style="display:none;" class="ias_trigger"><center><img src="images/ajax-loader-review.gif"></center></div>
    <?php
	}
	?>
    </div>
    
    <?php
}
else
{
	?><p class="no-record">No Records Found.</p><?php
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
<?php if($_REQUEST['submit'] == "Search"){ ?>
<script type="text/javascript">
get_statement('<?php echo $year; ?>','<?php echo $_REQUEST['statement']; ?>');
</script>
<?php } ?>