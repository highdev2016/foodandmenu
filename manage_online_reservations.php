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
function sort_function(sort_by,restaurant_id,restaurant_name,customer_name,contact_email,date,people,comments){
	location.href = 'manage_online_reservations.php?sort_order='+sort_by+"&restaurant_id="+restaurant_id+"&restaurant_name="+restaurant_name+"&customer_name="+customer_name+"&contact_email="+contact_email+"&date="+date+"&people="+people+"&comments="+comments;
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

<p style="color:#454EA8; font-size:21px;">Search Panel</p><br>
<form name="frm" method="post" action="">
<table><tr>
<td width="114">Restaurant Name : </td><td width="219"><input type="text" name="restaurant_name" value="<?php echo $_REQUEST['restaurant_name'];?>" style="height:23px;" class="restaurant"></td>
<td width="152">Customer Name : </td><td width="277"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" style="height:23px;" class="restaurant"></td>
<td width="115">Contact Email : </td><td width="298"><input type="text" name="contact_email" value="<?php echo $_REQUEST['contact_email'];?>" style="height:23px;" class="restaurant"></td>
<td><input type="submit" name="submit" value="Search" class="button4" style="margin:0px;"></td>
</tr>
</table>
</form>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="4%" class="all_restaurant">Sl No.</td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>','<?php echo $_REQUEST['date']; ?>','<?php echo $_REQUEST['people']; ?>','<?php echo $_REQUEST['comments']; ?>')" class="heading_link">Restaurant Name</a></td>
    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>','<?php echo $_REQUEST['date']; ?>','<?php echo $_REQUEST['people']; ?>','<?php echo $_REQUEST['comments']; ?>')" class="heading_link">Customer Name</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('contact_email','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>','<?php echo $_REQUEST['date']; ?>','<?php echo $_REQUEST['people']; ?>','<?php echo $_REQUEST['comments']; ?>')" class="heading_link">Contact Email</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('date','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>','<?php echo $_REQUEST['date']; ?>','<?php echo $_REQUEST['people']; ?>','<?php echo $_REQUEST['comments']; ?>')" class="heading_link">Date</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('people','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>','<?php echo $_REQUEST['date']; ?>','<?php echo $_REQUEST['people']; ?>','<?php echo $_REQUEST['comments']; ?>')" class="heading_link">No of people</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('comments','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>','<?php echo $_REQUEST['date']; ?>','<?php echo $_REQUEST['people']; ?>','<?php echo $_REQUEST['comments']; ?>')" class="heading_link">Comments</a></td>
  </tr>
  <?php 
  $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['restaurant_id']."'"));
  $today = date('Y-m-d');
  
  $query_res = ("SELECT * from restaurant_reservations where restaurant_id = '".$sql_restaurant['id']."'");
  //$query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$sql_restaurant['id']."' AND order_date LIKE '".$today."%'");
  //$query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '61'");

  if($_REQUEST['restaurant_name']!=''){
	  $query_res.=" AND restaurant_name LIKE '%".$_REQUEST['restaurant_name']."%'";
  }
  if($_REQUEST['customer_name']!=''){
	  $query_res.=" AND customer_name LIKE '%".$_REQUEST['customer_name']."%'";
  }
  if($_REQUEST['contact_email']!=''){
	  $query_res.=" AND contact_email = '".$_REQUEST['contact_email']."'";
  }
  
  if($_REQUEST['sort_order']){
	  $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
  }else{
	  $query_res.=" ORDER BY date DESC";
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
		$pagination .= "<a href=\"manage_online_reservations.php?page=$prev&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."&date=".$_REQUEST['date']."&people=".$_REQUEST['people']."&comments=".$_REQUEST['comments']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_online_reservations.php?page=$i&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."&date=".$_REQUEST['date']."&people=".$_REQUEST['people']."&comments=".$_REQUEST['comments']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_online_reservations.php?page=$next&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."&date=".$_REQUEST['date']."&people=".$_REQUEST['people']."&comments=".$_REQUEST['comments']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
  while($array_order = mysql_fetch_array($query_products)){ ?>
  <tr>
  	<td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
    <td class="all_restaurant2"><?php echo $array_order['restaurant_name']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['customer_name']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['contact_email']; ?></td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_order['date'])); ?></td>
    <td class="all_restaurant2"><?php echo $array_order['people']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['comments']; ?></td>
  </tr>

  <?php $inc++; } } else { ?>
  <tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No Reservations Yet</td>
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

