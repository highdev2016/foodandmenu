<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
if(!isset($_SESSION['restaurant_admin_panel_id'])){
	header('location:restaurant_admin_login.php');
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
	/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
                        <div style="margin:0 auto;width:700px;clear:both;">
  						<div style="background-color:#3F4CA0; height:30px;"></div>
    					<div style="background-color:#fff; padding:0 0px; ">
        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px; " />
                        <div style="height:15px; background-color:#3F4CA0;"></div>
       		 			</div>
        				<div style="width:100%; float:left;">
            			<div style="clear:both;"></div>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$name.',</p>
      
                            <p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">The order status for Order No. OR-00'.$order_id.' ordered on '.date("d-m-Y", strtotime($sql_cust['order_date'])).' is confirmed by the restaurant owner.</p>
		
						  <div style="clear:both;"></div>

 						<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>

						<div style="clear:both;"></div>

						<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>

						<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>

						<div style="clear:both;"></div>

						</div>

						<div style="clear:both;"></div>

						<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >

						<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">
Sent to you from Food & menu</h4>
					</div>
				</div>
				<div style="clear:both;"></div>
				</div>';*/
	
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
	/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
                        <div style="margin:0 auto;width:700px;clear:both;">
  						<div style="background-color:#3F4CA0; height:30px;"></div>
    					<div style="background-color:#fff; padding:0 0px; ">
        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px; " />
                        <div style="height:15px; background-color:#3F4CA0;"></div>
       		 			</div>
        				<div style="width:100%; float:left;">
            			<div style="clear:both;"></div>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$name.',</p>
      
                            <p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">The order status for Order No. OR-00'.$order_id.' confirmed by you is changed successfully.</p>
		
						  <div style="clear:both;"></div>

 						<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>

						<div style="clear:both;"></div>

						<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>

						<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>

						<div style="clear:both;"></div>

						</div>

						<div style="clear:both;"></div>

						<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >

						<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">
Sent to you from Food & menu</h4>
					</div>
				</div>
				<div style="clear:both;"></div>
				</div>';*/
				
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
$j( "#cust_date" ).datepicker(pickerOpts);
});

function open_cust_date(val)
{
	if(val == 'Custom Date')
	{
		$j("#cust_date_td").show(500);
	}
	else
	{
		$j("#cust_date_td").hide(500);
	}
}
</script>

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">

<?php if($_REQUEST['msg'] == 'success'){?>
<p style="text-align:center;">Order status changed successfully.</p>
<?php } ?>

<p style="color:#454EA8; font-size:21px;">Search Panel</p><br>
<form name="frm" method="post" action="restaurant_live_orders.php">
<table><tr>
<td width="114">Order Id : </td><td width="219"><input type="text" name="order_id" value="<?php echo $_REQUEST['order_id'];?>" style="height:23px;" class="restaurant"></td>
<td width="152">Customer Name : </td><td width="277"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" style="height:23px;" class="restaurant"></td>
<td width="115">Customer Phone : </td><td width="298"><input type="text" name="customer_phone" value="<?php echo $_REQUEST['customer_phone'];?>" style="height:23px;" class="restaurant"></td><tr>
<tr>
<td width="114">Customer Address : </td><td width="219"><input type="text" name="customer_address" value="<?php echo $_REQUEST['customer_address'];?>" style="height:23px;" class="restaurant"></td>
<td>Status : </td><td><select name="status" class="restaurant_list">
<option value="">Select</option>
<option value="Pending">Pending</option>
<option value="Confirmed">Confirmed</option>
</select></td>
<td width="146">Date : </td>
                <td width="184"><select class="restaurant" name="mod_date" id="mod_date" onChange="open_cust_date(this.value);">
                <option value="">---SELECT---</option>
                <option value="This Month"<?php if($_REQUEST['mod_date'] == 'This Month') { ?> selected <?php } ?>>This Month</option>
                <option value="Last Month"<?php if($_REQUEST['mod_date'] == 'Last Month') { ?> selected <?php } ?>>Last Month</option>
                <option value="Last Week"<?php if($_REQUEST['mod_date'] == 'Last Week') { ?> selected <?php } ?>>Last Week</option>
                <option value="Custom Date"<?php if($_REQUEST['mod_date'] == 'Custom Date') { ?> selected <?php } ?>>Custom Date</option>
                </select>
                </td>
                <?php
				if($_REQUEST['mod_date'] == 'Custom Date')
				{
					$display = 'block';
				}
				else
				{
					$display = 'none';
				}
				?>
                <td width="146" style="display:<?php echo $display; ?>;" id="cust_date_td" ><input type="text" name="cust_date" id="cust_date" value="<?php echo $_REQUEST['cust_date']; ?>"></td>
<td><input type="submit" name="submit" value="Search" class="button4" style="margin:0px;"></td>
</tr>
</table>
</form>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="4%" class="all_restaurant">Sl No.</td>
    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_id','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Order Id</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Name</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_address','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Address</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_phone','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Phone</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('price_with_del_charge','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Amount</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('status','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Status</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_date','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Date</a></td>
    <td width="14%" class="all_restaurant"></td>
  </tr>
  <?php 
  $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant_admin_panel_id']."'"));
  $_SESSION['restaurant'] = $sql_restaurant['id'];
  $today = date('Y-m-d');
  
  $query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$_SESSION['restaurant']."' AND order_date LIKE '".$today."%'");
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
	  if($_REQUEST['mod_date'] == 'This Month')
	  {
	  	$query_res.=" AND date_format(order_date,'%Y-%m') = '".date("Y-m")."' ";
	  }
	  if($_REQUEST['mod_date'] == 'Last Month')
	  {
	  	$query_res.=" AND date_format(order_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
	  }
	  if($_REQUEST['mod_date'] == 'Last Week')
	  {
		  $query_res.=" AND YEARWEEK(order_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
	  }
	   if($_REQUEST['mod_date'] == 'Custom Date')
	  {
		  $custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
		  $query_res.=" AND date_format(order_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
	  }
  }

  if($_REQUEST['sort_order']){
	  $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
  }else{
	  $query_res.=" ORDER BY order_id DESC ";
  }
  
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
		$max_results =10; 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sql_order); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$prev&mod_date=".$_REQUEST['mod_date']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$i&mod_date=".$_REQUEST['mod_date']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"restaurant_live_orders.php?page=$next&mod_date=".$_REQUEST['mod_date']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
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
  while($array_order = mysql_fetch_array($query_products)){
  $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$array_order['customer_id']."'"));?>
  <tr>
  	<td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
    <td class="all_restaurant2"><?php echo "OR-00".$array_order['order_id'];?></td>
    <td class="all_restaurant2"><?php echo $sql_customer['firstname']." ".$sql_customer['lastname'];?></td>
    <td class="all_restaurant2"><?php echo $sql_customer['address']."<br>";
	echo $sql_customer['city'];?>&nbsp;&nbsp;<?php echo $sql_customer['state'];?>&nbsp;&nbsp;<?php echo $sql_customer['zip']; ?></td>
    <td class="all_restaurant2"><?php echo $sql_customer['phone'];?></td>
    <td class="all_restaurant2"><?php echo "$ ".($array_order['price_with_del_charge']);?></td>
    <td class="all_restaurant2"><?php echo $array_order['status'];?>
    <?php if($array_order['status'] == 'Pending'){ ?>
	<span style="float:right;"><a class="various1" href="#inline<?php echo $array_order['order_id'];?>" title="Edit" style="color:#686868;">EDIT</a></span>
	<?php }?>
    </td>
    <td class="all_restaurant2"><?php echo date("d-m-Y", strtotime($array_order['order_date']));?></td>
    <td class="all_restaurant2"><a class="various1" href="#inline_<?php echo $array_order['order_id'];?>" title="View" style="color:#686868;">View</a></td>
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
    <div id="inline_<?php echo $array_order['order_id'];?>" style="width:500px;height:300px;overflow:auto;">
        <div class="profle_wrapper">
            <div style="width:450px;">
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
                <?php } ?>
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

<?php if($total_pages > 1){ ?>
<div style="text-align:center; margin-top:10px;"><?php echo $pagination; ?></div><?php } ?>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

