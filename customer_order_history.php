<?php
session_start();
if($_SESSION['customer_id']==''){
	header("location:login.php");
}
include("includes/rest_header.php");
include("admin/lib/conn.php");
include("includes/functions.php");
?>

<script type="text/javascript">
function sort_function(sort_by){
	location.href = 'customer_order_history.php?sort_order='+sort_by;
}
</script>

<body onLoad="init();">

<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php");?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body order_history_section">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top" style="min-height:350px;">
<h1>Customer Order History </h1>
<a href="javascript:history.back();"><input type="button" name="back" value="Back" class="check_order_button" style="float:right; margin-top:-35px;" /></a>

<table width="100%" border="1" cellspacing="0" bordercolor="d6d6d6" cellpadding="0" style="border-collapse:collapse; margin-top:10px;" class="curnt_ordr_details">

  <?php 
  
  //////////////////////start pagination/////////////////////////
  
	$limit = 10;
	$start = 1;
	$slice = 3;
	
	$sql_order1 = "SELECT * FROM restaurant_menu_order WHERE customer_id = '".$_SESSION['customer_id']."'";
	if($_REQUEST['sort_order']!=''){
	$sql_order1.= " ORDER BY ".$_REQUEST['sort_order']."";
	}else{
		$sql_order1.=" ORDER BY order_id DESC ";
	}
	
	$order_num = mysql_num_rows($sql_order1);
	
	$r = mysql_query($sql_order1);
	$totalrows = mysql_num_rows($r);
	
	if(!isset($_GET['page'])){
	$page = 1;
	} else {
	$page = $_GET['page'];
	}
	
	$numofpages = ceil($totalrows / $limit);
	$limitvalue = $page * $limit - ($limit);
	
 	$sql_order1.=" LIMIT $limitvalue, $limit";
	
	//echo $sql_order1;
			
	$query_products=mysql_query($sql_order1);
		
  
  if($totalrows > 0){ ?>
  <tr>
    <th align="center" class="cstmr_order_hstry"><a href="javascript:void(0)" onClick="sort_function('order_id')">Order No.</a></th>
    <th align="center" class="cstmr_order_hstry"><a href="javascript:void(0)" onClick="sort_function('')">Restaurant</a></th>
    <th align="center" class="cstmr_order_hstry"><a href="javascript:void(0)" onClick="sort_function('price_with_del_charge')">Total Price</a></th>
    <th align="center" class="cstmr_order_hstry"><a href="javascript:void(0)" onClick="sort_function('order_date')">Order date  (MM-DD-YYYY)</a></th>
    <th align="center" class="cstmr_order_hstry" style="color:rgb(232, 104, 7);">View Details</th>
  </tr>
  <?php while($array_order = mysql_fetch_array($query_products)){ ?>
  <tr>
    <td align="center"><?php echo  "OR-00".$array_order['order_id']; ?></td>
    <td align="center">
	<?php $sql_restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$array_order['restaurant_id']."'")); ?>
    <?php echo $sql_restaurant_name['restaurant_name']; ?>
    </td>
    <td align="center"><?php echo  "$ ".($array_order['price_with_del_charge']); ?></td>
    <td align="center"><?php echo  date("m-d-Y", strtotime($array_order['order_date'])); ?></td>
    <td align="center"><a href="view_order_details.php?id=<?php echo $array_order['order_id']; ?>" style="color:#4F4F4F;">View Details</a></td>  
  </tr>
  <?php } } else { ?>
  <tr>
    <td align="center" colspan="4">No orders yet.</td>
  </tr>
  <?php } ?>
  
  
</table>
<div class="clear"></div>
</div>
<div class="pagination">

<div align="center">
<?php if($page!= 1){
$pageprev = $page - 1;
echo '<a href="'.$_SERVER['php_SELF'].'?page='.$pageprev.'" class="more_link_pagination_prev">PREVIOUS</a>  ';
}

if (($page + $slice) < $numofpages) {
$this_far = $page + $slice;
} else {
$this_far = $numofpages;
}

if (($start + $page) >= 10 && ($page - 10) > 0) {
$start = $page - 10;
}

for ($i = $start; $i <= $this_far; $i++){
if($i == $page){
echo $i;
}else{
echo '<a href="'.$_SERVER['php_SELF'].'?page='.$i.'" class="more_link_pagination">'.$i.'</a> ';
}
}

if(($totalrows - ($limit * $page)) > 0){
$pagenext = $page + 1;
echo '  <a href="'.$_SERVER['php_SELF'].'?page='.$pagenext.'" class="more_link_pagination_prev">NEXT</a>';
}
?>
</div>
</div>

<div class="clear"></div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<?php /*?><?php include("includes/footer.php");?><?php */?>
<?php include("includes/footer_new.php");?>