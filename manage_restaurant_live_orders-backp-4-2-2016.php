<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
if(!isset($_SESSION['admin_id'])){
	header("location:admin/login.php");
}
?>

<script type="text/javascript">
function sort_function(sort_by,restaurant_id,order_id,customer_name,customer_address,customer_phone,status){
	location.href = 'manage_restaurant_live_orders.php?sort_order='+sort_by+"&restaurant_id="+restaurant_id+"&order_id="+order_id+"&customer_name="+customer_name+"&customer_address="+customer_address+"&customer_phone="+customer_phone+"&status="+status;
}
</script>
<body>

<?php include ("includes/menu_restaurant_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<?php include ("includes/manage_live_order_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">

<?php if($_REQUEST['msg'] == 'success'){?>
<p style="text-align:center;">Order status changed successfully.</p>
<?php } ?>

<p style="color:#454EA8; font-size:21px;">Search Panel</p><br>
<form name="frm" method="post" action="">
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
<td><input type="submit" name="submit" value="Search" class="button4" style="margin:0px;"></td>
</tr>
</table>
</form>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="4%" class="all_restaurant">Sl No.</td>
    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_id','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Order Id</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Name</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_address','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Address</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_phone','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Customer Phone</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('price_with_del_charge','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Amount</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('status','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Status</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_date','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['order_id']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_address']; ?>','<?php echo $_REQUEST['customer_phone']; ?>','<?php echo $_REQUEST['status']; ?>')" class="heading_link">Date</a></td>
    <td width="14%" class="all_restaurant">Confirmation Code</td>
    <td width="14%" class="all_restaurant"></td>
  </tr>
  <?php
  $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['restaurant_id']."'"));
  
  $today = date('Y-m-d');
  
  $query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$sql_restaurant['id']."' AND order_date LIKE '".$today."%'");
  //$query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '61'");
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
  if($_REQUEST['sort_order']){
	  $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
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
		$pagination .= "<a href=\"manage_restaurant_live_orders.php?page=$prev&restaurant_id=".$_REQUEST['restaurant_id']."&sort_order=".$_REQUEST['sort_order']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_address=".$_REQUEST['customer_address']."&customer_phone=".$_REQUEST['customer_phone']."&status=".$_REQUEST['status']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_restaurant_live_orders.php?page=$i&restaurant_id=".$_REQUEST['restaurant_id']."&sort_order=".$_REQUEST['sort_order']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_address=".$_REQUEST['customer_address']."&customer_phone=".$_REQUEST['customer_phone']."&status=".$_REQUEST['status']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_restaurant_live_orders.php?page=$next&restaurant_id=".$_REQUEST['restaurant_id']."&sort_order=".$_REQUEST['sort_order']."&order_id=".$_REQUEST['order_id']."&customer_name=".$_REQUEST['customer_name']."&customer_address=".$_REQUEST['customer_address']."&customer_phone=".$_REQUEST['customer_phone']."&status=".$_REQUEST['status']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
    <td class="all_restaurant2">
	<?php echo $array_order['price_with_del_charge']; ?>
	<?php //echo "$ ".($array_order['total_price'] + $array_order['delivery_charge']);?></td>
    <td class="all_restaurant2"><?php echo $array_order['status'];?>
    </td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_order['order_date']));?></td>
    <td class="all_restaurant2"><?php echo $array_order['confirmation_code'];?></td>
    <td class="all_restaurant2"><a class="various1" href="#inliine<?php echo $array_order['order_id'];?>" title="View" style="color:#686868;">View</a></td>
  </tr>

<?php $sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$array_order['order_id']."'"));?>
<div style="display: none;">
    <div id="inliine<?php echo $array_order['order_id'];?>" style="width:500px;height:300px;overflow:auto;">
        <div class="profle_wrapper">
            <div style="width:450px;">
                <h1 style="color:#2B4494;">Order Details</h1>
               	<p style="padding-bottom:5px;"><b>Order No. : </b><?php echo "OR-00".$array_order['order_id'];?></p>
                <p style="padding-bottom:5px;"><b>Order Amount : </b><?php echo "$ ".($array_order['total_price'] + $array_order['delivery_charge']); ?></p>
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

