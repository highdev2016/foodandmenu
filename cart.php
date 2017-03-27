<?php
ob_start();
session_start();

include("admin/lib/conn.php");
include("includes/functions.php");
include("includes/rest_header.php");

if($_REQUEST['submit']=='Check Out')
{
	$_SESSION['ammount']=$_REQUEST['ammount'];
	$_SESSION['card_array']=$_REQUEST['all_card'];
	header("location:paymentdetails.php"); 
}	
if($_REQUEST['del']=='delete' && $_REQUEST['pid']>0){
	$sql = "DELETE from `restaurant_cart` where `deal_id` = '".$_REQUEST['pid']."' AND `customer_id` = '".$_SESSION['customer_id']."'";
	mysql_query($sql);

	header("location:cart.php");
}
else if($_REQUEST['command']=='clear'){
	unset($_SESSION['cart']);
}
else if($_REQUEST['command']=='update'){
	$max=count($_SESSION['cart']);
	for($i=0;$i<$max;$i++){
		$pid=$_SESSION['cart'][$i]['productid'];
		$q=intval($_REQUEST['product'.$pid]);
		if($q>0 && $q<=999){
			$_SESSION['cart'][$i]['qty']=$q;
		}
		else{
			$msg='Some proudcts not updated!, quantity must be a number between 1 and 999';
		}
	}
}

?>
<script language="javascript">
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.getElementById('form1').submit();
			//document.form1.submit();
			//alert($('#form1').serialize());
		}
	}
	function clear_cart(){
		if(confirm('This will empty your shopping cart, continue?')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	function update_cart(){
		document.form1.command.value='update';
		document.form1.submit();
	}


</script>

<body  onLoad="init();">

<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php"); ?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body cart_body_container">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>Cart Listing Page</h1>
</div>

<div class="payment_cont_field">



<form id="form1" name="form1" action="" method="post">
<input type="hidden" name="pid" value="" />
<input type="hidden" name="command" value="" />

<table width="100%" border="1" cellspacing="0" bordercolor="d6d6d6" cellpadding="0" style="border-collapse:collapse;" class="cart_table">
  <?php 
	$sql = "SELECT * FROM `restaurant_cart` WHERE `customer_id` = '".$_SESSION['customer_id']."'";
	$qry = mysql_query($sql);
	if(mysql_num_rows($qry)>0){  
  ?>
  
  <tr>
    <th class="cart_table_text">Deal Name</th>
    <th class="cart_table_text">Deal Price($)</th>
    <th class="cart_table_text">Deal Quantity</th>
    <th class="cart_table_text">Deal Photo</th>
    <th class="cart_table_text">Total Price</th>
    <th class="cart_table_text">Option</th>
  </tr>
  <?php
  	/*$max=count($_SESSION['cart']);
	for($i=0;$i<$max;$i++){
		$pid=$_SESSION['cart'][$i]['productid'];
		$q=$_SESSION['cart'][$i]['qty'];
		$pname=get_product_name($pid);
		if($q==0) continue; */
		$all_cart_id="";
		$card_sep="";
	while($row = mysql_fetch_array($qry)){
		$all_card_id.=$card_sep.$row['deal_id'];
		$card_sep=",";
  ?>
  <tr>
    <td class="cart_table_text2"><?php echo $row['deal_name']; ?></td>
    <td class="cart_table_text2">$<?php echo $row['deal_price']; ?></td>
    <td class="cart_table_text2"><?php echo $row['qty']; ?></td>
    <td class="cart_table_text2"><?php echo get_deals_photo($row['deal_id']); ?></td>
    <td class="cart_table_text2">$<?php echo $row['deal_price']*$row['qty'];?></td>
    <td class="cart_table_text2"><a href="cart.php?pid=<?php echo $row['deal_id']; ?>&del=delete" onClick="return confirm('Are You Sure?');">Remove</a></td>
  </tr>
  
  <?php }  ?>
  <tr>
    <td class="cart_table_text2">Total</td>
    <td class="cart_table_text2" colspan="4"></td>
    <td class="cart_table_text2">$<?php echo get_order_total(); ?></td>
  </tr>
  <?php  }else{ ?>
  <tr>
    <td class="cart_table_text2" colspan="6">Your cart is empty</td>
  </tr>
  <?php } ?>
</table>
<input type="hidden" name="all_card" value="<?php echo $all_card_id?>">
<input type="hidden" name="ammount" value="<?php echo get_order_total();?>">

<input class="listing_button" type="submit" value="Check Out" name="submit" onClick="">

<?php if($_REQUEST['restaurant_id']!=''){ ?>
<input class="multimedia_button" type="button" value="Continue" name="" onClick="location.href='restaurant.php?id=<?php echo $_REQUEST['restaurant_id']; ?>'" />
<?php }else{ ?>
<input class="multimedia_button" type="button" value="Continue" name="" onClick="location.href='index.php'" />
<?php } ?>

</form>

<div class="clear"></div>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<?php include("includes/footer_new.php");?>