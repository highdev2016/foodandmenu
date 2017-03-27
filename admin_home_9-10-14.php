<?php
session_start();
ob_start();

if(!isset($_SESSION['admin_login_id'])){
	header("location:admin_login.php");
}

include ("admin/lib/conn.php");
include ("includes/functions.php");



if($_REQUEST['export'] == "Export to Excel")
{
	header("location:export_admin_home_excel.php?restaurant_name=".$_REQUEST['restaurant_name']."&order_id=".$_REQUEST['order_id']."&confirmation_code=".$_REQUEST['confirmation_code']."&mod_date=".$_REQUEST['mod_date']."&cust_date=".$_REQUEST['cust_date']);
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
$j( "#cust_date" ).datepicker(pickerOpts);
});

function open_cust_date(val)
{
	if(val == 'Custom Date')
	{
		$j("#cust_date").show(500);
	}
	else
	{
		$j("#cust_date").hide(500);
	}
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
                <td width="150">Restaurant Name : </td>
                <td width="184"><input type="text" name="restaurant_name" value="<?php echo $_REQUEST['restaurant_name'];?>" style="height:23px;  width: 150px;" class="restaurant"></td>
                <td width="150" align="right" style="padding-right:10px;">Order Number : </td>
                <td width="184"><input type="text" name="order_id" value="<?php echo $_REQUEST['order_id'];?>" style="height:23px;  width: 150px;" class="restaurant"></td>  
                <td width="150" align="left" style="padding-right:10px;">Confirmation Code : </td>
                <td width="184"><input type="text" name="confirmation_code" value="<?php echo $_REQUEST['confirmation_code'];?>" style="height:23px;  width: 150px;" class="restaurant"></td>              
               </tr>
               
               <tr>
               
               		<td width="150">Date : </td>
                <td width="184"><select class="restaurant search_select" name="mod_date" id="mod_date" onChange="open_cust_date(this.value);">
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
                <td width="150" id="cust_date_td" colspan="3">
                <input type="text" name="cust_date" id="cust_date" class="restaurant" style="width:150px; margin-left:15px;display:<?php echo $display; ?>;" value="<?php echo $_REQUEST['cust_date']; ?>"></td>
                
                <td align="right" style="padding-right:3px; ">
    	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
    	<a href="admin_home.php" class="button4" style="margin:0px; text-decoration:none; padding:6px 12px;">
    		Show All
    		<!-- <input type="button" name="show_all" value="Show All" class="button4" style="margin:0px;"> -->
    	</a> </td>
    		<td><input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0px;"></td>
                  
               </tr>
               
              <tr>
                <td colspan="5">&nbsp;</td>
                
                  </tr>
            </table>
          </form>
          <table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
            <tr>
              <td width="4%" class="all_restaurant">Sl No.</td>
              <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_id','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['confirmation_code']; ?>')" class="heading_link">Order Id</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('type','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Order Type</a></td>
              <td width="14%" class="all_restaurant">Restaurant Name</td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Name</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_address','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Address</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_phone','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Phone</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('price_with_del_charge','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Amount</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('confirmation_code','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Confirmation Code</a></td>
              <?php /*?><td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('status','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Status</a></td><?php */?>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_date','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Date</a></td>
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
  if($_REQUEST['restaurant_name']!=''){
	  	  
	  $res_all_id = mysql_fetch_array(mysql_query("SELECT restaurant_name FROM restaurant_menu_order WHERE 1"));
	  $res_filter = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_name LIKE '".addslashes($_REQUEST['restaurant_name'])."%'"));
	  
	  if($res_filter['id'] == '')
	  {
		  $res_filter['id'] = 0;
	  }

	  $query_res.=" AND restaurant_id in (".$res_filter['id'].")";
  }
  if($_REQUEST['confirmation_code']!=''){
	  $query_res.=" AND confirmation_code LIKE '%".$_REQUEST['confirmation_code']."%'";
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
		$max_results =10; 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sql_order); 
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
              <td class="all_restaurant2"><?php if($array_order['type'] == 'pickup') { echo "Pick Up"; } else { echo "Delivery"; }?></td>
              <td class="all_restaurant2"><?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$array_order['restaurant_id']);?></td>
              <td class="all_restaurant2"><?php echo $sql_customer['firstname']." ".$sql_customer['lastname'];?></td>
              <td class="all_restaurant2"><?php echo $sql_customer['address']."<br>";
	echo $sql_customer['city'];?>&nbsp;&nbsp;<?php echo $sql_customer['state'];?>&nbsp;&nbsp;<?php echo $sql_customer['zip']; ?></td>
              <td class="all_restaurant2"><?php echo $sql_customer['phone'];?></td>
              <td class="all_restaurant2"><?php echo "$ ".($array_order['price_with_del_charge']);?></td>
              <td class="all_restaurant2"><?php echo $array_order['confirmation_code']; ?></td>
              <?php /*?><td class="all_restaurant2"><?php echo $array_order['status'];?>
    <?php if($array_order['status'] == 'Pending'){ ?>
	<span style="float:right;"><a class="various1" href="#inline<?php echo $array_order['order_id'];?>" title="Edit" style="color:#686868;">EDIT</a></span>
	<?php }?>
    </td><?php */?>
              <td class="all_restaurant2"><?php echo date("d-m-Y", strtotime($array_order['order_date']));?></td>
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
            <?php /*?><div style="display: none;">
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
</div><?php */?>
            <?php $inc++; } } else { ?>
            <tr>
              <td class="all_restaurant2" colspan="9" style="text-align:center;">No  orders available</td>
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
			
			if ($page_num != 1) {
                $page_pagination.= "<a href=\"admin_home.php?page=$prev&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."&mod_date=".$_REQUEST['mod_date']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
				
				}

            for ($i = $page_min;$i <= $page_max;$i++) {
                if ($i == $page_num){
                $page_pagination .= $i; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
                else{
                $page_pagination.= "<a href=\"admin_home.php?page=$i&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."&mod_date=".$_REQUEST['mod_date']."\" class=\"more_link_pagination\">$i</a>"; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;'; 
				}
			}
			
			
			if ($page_num < $total_pages) {
                $page_pagination.= "<a href=\"admin_home.php?page=$next&order_id=".$_REQUEST['order_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&confirmation_code=".$_REQUEST['confirmation_code']."&mod_date=".$_REQUEST['mod_date']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
