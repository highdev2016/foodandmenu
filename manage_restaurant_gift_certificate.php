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
function sort_function(sort_by,restaurant_id,deal,restaurant_name,email,user_name,city,state,purchase_date){
	location.href = 'manage_restaurant_gift_certificate.php?sort_order='+sort_by+"&restaurant_id="+restaurant_id+"&deal="+deal+"&restaurant_name="+restaurant_name+"&email="+email+"&user_name="+user_name+"&city="+city+"&state="+state+"&purchase_date="+purchase_date;
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
<td width="114">Deal : </td><td width="219"><input type="text" name="deal" value="<?php echo $_REQUEST['deal'];?>" style="height:23px;" class="restaurant"></td>
<td width="152">Restaurant Name : </td><td width="277"><input type="text" name="restaurant_name" value="<?php echo $_REQUEST['restaurant_name'];?>" style="height:23px;" class="restaurant"></td>
<td width="115">Customer Name : </td><td width="298"><input type="text" name="user_name" value="<?php echo $_REQUEST['user_name'];?>" style="height:23px;" class="restaurant"></td><tr>
<tr>
<td width="114">Email : </td><td width="219"><input type="text" name="email" value="<?php echo $_REQUEST['email'];?>" style="height:23px;" class="restaurant"></td>
<td> </td><td> </td>
<td><input type="submit" name="submit" value="Search" class="button4" style="margin:0px;"></td>
</tr>
</table>
</form>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="4%" class="all_restaurant">Sl No.</td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('deal','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['deal']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['user_name']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>','<?php echo $_REQUEST['purchase_date']; ?>')" class="heading_link">Deal</a></td>
    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['deal']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['user_name']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>','<?php echo $_REQUEST['purchase_date']; ?>')" class="heading_link">Restaurant Name</a></td>
    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['deal']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['user_name']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>','<?php echo $_REQUEST['purchase_date']; ?>')" class="heading_link">Date (MM-DD-YYYY)</a></td>
    <td width="12%" class="all_restaurant">Time</td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('email','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['deal']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['user_name']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>','<?php echo $_REQUEST['purchase_date']; ?>')" class="heading_link">Email</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('user_name','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['deal']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['user_name']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>','<?php echo $_REQUEST['purchase_date']; ?>')" class="heading_link">Customer Name</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('city','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['deal']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['user_name']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>','<?php echo $_REQUEST['purchase_date']; ?>')" class="heading_link">City</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('state','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['deal']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['user_name']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>','<?php echo $_REQUEST['purchase_date']; ?>')" class="heading_link">State</a></td>
  </tr>
  <?php 
  $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['restaurant_id']."'"));
  $today = date('Y-m-d');
  
  $query_res = ("SELECT * from restaurant_gift_card where restaurant_id = '".$sql_restaurant['id']."'");
  //$query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '".$sql_restaurant['id']."' AND order_date LIKE '".$today."%'");
  //$query_res = ("SELECT * FROM restaurant_menu_order WHERE restaurant_id = '61'");

  if($_REQUEST['deal']!=''){
	  $query_res.=" AND deal LIKE '%".$_REQUEST['deal']."%'";
  }
  if($_REQUEST['restaurant_name']!=''){
	  $query_res.=" AND restaurant_name LIKE '%".$_REQUEST['restaurant_name']."%'";
  }
  if($_REQUEST['email']!=''){
	  $query_res.=" AND email = '".$_REQUEST['email']."'";
  }
  if($_REQUEST['user_name']!=''){
	  $query_res.=" AND user_name LIKE '%".$_REQUEST['user_name']."%'";
  }
  if($_REQUEST['city']!=''){
	  $query_res.=" AND city = '".$_REQUEST['city']."'";
  }
  if($_REQUEST['state']!=''){
	  $query_res.=" AND state = '".$_REQUEST['state']."'";
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
		$pagination .= "<a href=\"manage_restaurant_gift_certificate.php?page=$prev&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."&deal=".$_REQUEST['deal']."&restaurant_name=".$_REQUEST['restaurant_name']."&email=".$_REQUEST['email']."&user_name=".$_REQUEST['user_name']."&city=".$_REQUEST['city']."&state=".$_REQUEST['state']."&purchase_date=".$_REQUEST['purchase_date']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_restaurant_gift_certificate.php?page=$i&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."&deal=".$_REQUEST['deal']."&restaurant_name=".$_REQUEST['restaurant_name']."&email=".$_REQUEST['email']."&user_name=".$_REQUEST['user_name']."&city=".$_REQUEST['city']."&state=".$_REQUEST['state']."&purchase_date=".$_REQUEST['purchase_date']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_restaurant_gift_certificate.php?page=$next&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."&deal=".$_REQUEST['deal']."&restaurant_name=".$_REQUEST['restaurant_name']."&email=".$_REQUEST['email']."&user_name=".$_REQUEST['user_name']."&city=".$_REQUEST['city']."&state=".$_REQUEST['state']."&purchase_date=".$_REQUEST['purchase_date']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
    <td class="all_restaurant2"><?php echo $array_order['deal']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['restaurant_name']; ?></td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_order['purchase_date'])); ?></td>
    <td class="all_restaurant2"><?php echo substr($array_order['purchase_date'],10,9); ?></td>
    <td class="all_restaurant2"><?php echo $array_order['email']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['user_name']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['city']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['state']; ?></td>
  </tr>

  <?php $inc++; } } else { ?>
  <tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No Gift Certificates</td>
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

