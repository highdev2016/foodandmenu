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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="js/jQuery.print.js"></script>


<body>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
 
<script type="text/javascript">
$(function() {
    $("#print_but").click(function() {
    $("#printdiv").print();
    return (false);
});
});
</script> 
  
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

<script type="text/javascript">
var $j = jQuery.noConflict();

/*$j(window).scroll(function()
{
    //if($j(window).scrollTop() == $j(document).height() - $j(window).height())
	
	//if ($j(document).height() <= $j(window).scrollTop() + $j(window).height())
	 if ($j(window).scrollTop() >= $j(document).height() - $j(window).height() - 10)
    {*/
		
		
		
		//alert(limit);		
        //$j('div#loadmoreajaxloader').show();
        function load_more()
		{
			$j('div#loadmoreajaxloader').hide();
			$j('div#loadmoreajaxloaderimg').show();
			
			var start_date_ajax = $j("#start_date").val();
			var end_date_ajax = $j("#end_date").val();
			var limit = $j("#hid_limit").val();
			var num_rows = $j("#hid_num_rows").val();

			$j.ajax({
			url: "loadmore.php",
			type : 'POST',
			data : 'start_date_ajax=' + start_date_ajax+ '&end_date_ajax=' + end_date_ajax+ '&limit=' +limit,
			success: function(html)
			{
				//alert(html);
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
		
		/*setTimeout(function(){ load_more() }, 1000);
    }
});*/
</script>



<script type="text/javascript">
function sort_function(sort_by,submit1,start_date,end_date){
	location.href = 'balance.php?sort_order='+sort_by+'&submit='+submit1+'&start_date='+start_date+'&end_date='+end_date;
}
</script>

<script>
var $q = jQuery.noConflict();
$q( document ).ready(function() {
	var enq_dat = new Date();
	
	$q(window).on('load',function() {
	  //$j('#end_date').datepicker('option', 'minDate', enq_dat);
	});	  
});
$q(function()
{
    $q('#start_date').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function(dateStr) {
		  var date = $q(this).datepicker('getDate');		  
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $q('#end_date').datepicker('option', 'minDate', date);
		}
      });
      $q('#end_date').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function (selectedDate) {
		  var date = $q(this).datepicker('getDate');
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $q('#start_date').datepicker('option', 'maxDate', date || 0);
		}
      });
});

/*$j(function()
{
    $j('#start_date').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy"
      });
      $j('#end_date').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy"
      });
});*/
</script>

<script>
function check_validtion()
{
	var $j = jQuery.noConflict()
	
	if($j("#start_date").val() == "")
	{
		alert("Start Date cannot be Empty!!");
		return false;
	}
	
}
</script>




<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont restu_live_cont balance_live_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field">

<ul class="tab-look">
	<li><a href="billing.php">Statements</a></li>
	<li class="active"><a href="balance_16_10.php">Balance</a></li>
</ul>

<div class="clear"></div>


<?php
if($_REQUEST['submit'] == "Search")
{
	$start_date = change_dateformat_reverse($_REQUEST['start_date']);
	
	if($_REQUEST['end_date'] != "")
	{
		$end_date = change_dateformat_reverse($_REQUEST['end_date']);
	}
	else
	{
		$end_date = date('Y-m-d');
	}
	
	
	//echo "SELECT * FROM restaurant_menu_order WHERE order_date >= '".$end_date."' AND order_date <= '".$start_date."' AND restaurant_id = '".$_SESSION['restaurant']."'";
	
	$sql_num_rows = mysql_num_rows(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$sql = "SELECT * FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'";
	
	if($_REQUEST['sort_order']!=''){
		$sql.= " ORDER BY ".$_REQUEST['sort_order']." ASC "; 
	}
	
	$sql.="  LIMIT 0,10";
	
	$sql_search = mysql_query($sql);	
	
	$num_rows = mysql_num_rows($sql_search);
	
	
	
	$get_totals = mysql_fetch_array(mysql_query("SELECT SUM(tax) as tot_tax, SUM(tip) as tot_tip, SUM(commission) as tot_commission, SUM(coupon_discount) as tot_coupons, SUM(price_with_del_charge) as tot_sales, SUM(credit_card_fee) as tot_cc_fee , SUM(service_fee) as service_fee FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$get_cash_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cash FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND payment_mode = 'cash' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$get_cc_total =  mysql_fetch_array(mysql_query("SELECT SUM(price_with_del_charge) as tot_cc FROM restaurant_menu_order WHERE order_date >= '".$start_date."' AND order_date <= '".$end_date."' AND payment_mode = 'credit_card' AND restaurant_id = '".$_SESSION['restaurant']."'"));
	
	$sql_res_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant']."'"));
	
}
?>

<?php
if($_REQUEST['submit'] == "Search")
{
	if($_REQUEST['start_date'] != '')
	{
		if($_REQUEST['end_date']=='')
		{
			$sr_end_dt = date('m-d-Y');
		}else{
			$sr_end_dt = $_REQUEST['end_date'];
		}
	}
	
}
?>
<div class="tab-look-restu" style="padding:2%;">
          <form name="frm" method="post" action="balance.php" onSubmit="return check_validtion();">
            <table class="sec-pnl-top balance_pnl" width="100%">
              <tr>
               <td width="138px">
					Specify your Search : 
				</td>
                
               	<td width="79px">Start Date : </td>
                <td width="81px">
                <input type="text" name="start_date" id="start_date" class="restaurant" style="width: 100px; text-align: left;" value="<?php echo $_REQUEST['start_date']; ?>" autocomplete="off">
                </td>
                <td width="74px" >End Date : </td>
                <td width="47px" id="cust_date_td">
                <input type="text" name="end_date" id="end_date" class="restaurant" style="width: 100px; text-align: left;" value="<?php echo $sr_end_dt; ?>" autocomplete="off">
                </td>
                
                <td align="right" width="48	">
			    	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
    			</td>
    		
                  <input type="hidden" name="hid_limit" id="hid_limit" value="10" />
                  <input type="hidden" name="hid_num_rows" id="hid_num_rows" value="<?php echo $sql_num_rows; ?>" />
               
                <td>
                	<?php
					if($_REQUEST['submit'] == "Search" && $sql_num_rows > 0)
					{
					?>
					<a href="javascript:void(0);" class="check_order_button" style="text-decoration: none; padding: 7px; float: none; font-size: 13.3px; margin: 0px 0px 0px 6px; position: relative; left: 5px;" id="print_but" >Print</a>
					<?php
					}
					?>
                </td>
                <td align="right" width="255px">
                	 <?php
					if($_REQUEST['submit'] == "Search"  && $sql_num_rows > 0)
					{
					?>
			    	<input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0 6px 0 0px;">
                    <a href="balance_export_pdf.php?start_date=<?php echo $_REQUEST['start_date']."&end_date=".$_REQUEST['end_date'];?>" title="Export to Pdf" target="_blank" style="text-decoration:none;"><input type="button" name="export_pdf" value="Export to Pdf" class="button4" style="margin:0px;"></a>
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
	if($sql_num_rows > 0)
	{
		$start_date_summary = str_replace("-","/",$_REQUEST['start_date']);
		$end_date_summary = str_replace("-","/",$_REQUEST['end_date']);
	?>
    <div id="printdiv">
    	
    <span class="blnce-head" style="color: #666666;display: block;font-size: 17px;font-weight: bold;margin: 20px 0 0;padding: 26px 0 0;text-align: center;" >Summary for <?php echo $start_date_summary; ?> - <?php echo str_replace("-","/",$sr_end_dt); ?></span>
    
    <table cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse; margin-top:9px;">
    <tr style="text-align:center;">
    	
     	<th class="all_restaurant">Count</th>
	    <th class="all_restaurant">Total Sales</th>
	    <th class="all_restaurant">Total Cash</th>
	    <th class="all_restaurant">Total CC</th>
	    <th class="all_restaurant">Total Tax</th>
	    <th class="all_restaurant">Total Coupons</th>
	    <th class="all_restaurant">Total Tip</th>
	    <th class="all_restaurant">Total Commission</th>
        <th class="all_restaurant">Total CC Fee</th>
        <th class="all_restaurant">Total Service Fee</th>
        <th class="all_restaurant">Amount Due</th>
    
    </tr>
    <?php
	 	$amount_due = ($get_cc_total['tot_cc'] - $get_totals['tot_commission'] - $get_totals['tot_cc_fee']);
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
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$get_totals['service_fee'];?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "><?php echo "$".$amount_due;?></td>
    <?php /*?><td><?php echo "$";?></td>
    <td><?php echo "$";?></td><?php */?>
    </tr>
    </table>
    
	<div id="postswrapper" style="margin-bottom:22px;">
	<table  class="tbl-two" cellspacing="0" cellpadding="0" bordercolor="c5c8d5" border="1" align="center" width="99%" style="border-collapse:collapse; margin-top:20px;">
    <tr style="text-align:center;">
    <th class="all_restaurant">Serial No.</th>
    <th class="all_restaurant">Date</th>
    <th class="all_restaurant">Order #</th>
    <th class="all_restaurant">Restaurant</th>
    <th class="all_restaurant">Type</th>
    <th class="all_restaurant">Total</th>
    <th class="all_restaurant">Credit Card Fee</th>
    <th class="all_restaurant">Service Fee</th>
    <th class="all_restaurant">Commission</th>
    <th class="all_restaurant">Coupons</th>
    <th class="all_restaurant">Status</th>
    <th class="all_restaurant" >Action</th>
    </tr>
    
	<?php
	$sl_no=1;
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
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo $sl_no; ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo date('m-d-Y h:i:s a', strtotime($fetch_array['order_date'])); ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo "OR-00".$fetch_array['order_id']; ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$fetch_array['restaurant_id']); ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo $payment_mode; ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo "$".$fetch_array['price_with_del_charge']; ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo "$".$fetch_array['credit_card_fee']; ?> </td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo "$".$fetch_array['service_fee']; ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo "$".$fetch_array['commission']; ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo "$".$fetch_array['coupon_discount']; ?> </td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <?php echo $status; ?></td>
    <td class="all_restaurant2" style="color: #686868;font-family: Calibri;font-size: 13px;padding: 17px "> <a href="javascript:void(0);" title="View" onClick="open_view_div('<?php echo $fetch_array['order_id'] ?>');" style="color:#686868;">View</a></td>
    
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
