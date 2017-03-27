<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
if(!isset($_SESSION['admin_id'])){
	header("location:admin/login.php");
}

///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	$sql_select= mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$_REQUEST['delete_id']."'"));
	$sql_update_review = mysql_query("UPDATE restaurant_basic_info SET reviewed = reviewed - 1 WHERE id = '".$sql_select['restaurant_id']."'");
	$sql_update_customer = mysql_query("UPDATE restaurant_customer SET no_reviews = no_reviews - 1 WHERE id = '".$sql_select['customer_id']."'");
	$sql_select_rating = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rating WHERE review_id = '".$_REQUEST['delete_id']."'"));
	
	if($sql_select_rating['score_1'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 1 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_2'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 2 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_3'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 3 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_4'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 4 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_5'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 5 WHERE id = '".$sql_select['restaurant_id']."'");}
	
	mysql_query("DELETE FROM restaurant_reviews WHERE id=".$_REQUEST['delete_id']."");
	mysql_query("DELETE FROM restaurant_rating WHERE review_id=".$_REQUEST['delete_id']."");
	mysql_query("DELETE FROM  restaurant_like_dislike WHERE  review_id=".$_REQUEST['delete_id']."");
	header("location:my_reviews.php?success=1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////

?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
  $(function() {
   $("#date").datepicker({ dateFormat: "yy-mm-dd" }).val()
  });
  </script>
  
<script type="text/javascript">
function sort_function(sort_by,restaurant_id,post_date,customer_name){
	location.href = 'manage_restaurant_reviews.php?sort_order='+sort_by+"&restaurant_id="+restaurant_id+"&post_date="+post_date+"&customer_name="+customer_name;
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
<td width="80">Post Date : </td><td width="176"><input type="text" name="date" id="date" value="<?php echo $_REQUEST['date'];?>" class="restaurant"></td>
<td width="155">Customer Name : </td><td width="198"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" class="restaurant"></td>
<td width="191"><input type="submit" name="submit" value="Search" class="button4" style="margin:0 0 0 5px;"></td>
<tr>
</table>
</form>


<?php if($_REQUEST['success'] == 1){ ?>
<p style="text-align:center;">Review deleted successfully.</p>
<?php } else if($_REQUEST['reply'] == 1){ ?>
<p style="text-align:center;">Reply sent successfully.</p>
<?php } ?>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="6%" class="all_restaurant">Sl No.</td>
    <td width="11%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('post_date','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">Post Date (MM-DD-YYYY) </a></td>
    <td width="15%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">Customer Name</a></td>
    <td width="10%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('city','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">City</a></td>
    <td width="11%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('state','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">State</a></td>
    <td width="34%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_review','<?php echo $_REQUEST['restaurant_id']; ?>','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">Reviews</a></td>
    <td width="13%" class="all_restaurant">Action</td>
  </tr>
  <?php 
  $today = date('Y-m-d');
  $query_res = ("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$_REQUEST['restaurant_id']."' AND status = 1");
  //$query_res = ("SELECT * FROM restaurant_reviews WHERE restaurant_id = '61' AND status = 1");
	if($_REQUEST['date']!=''){
		$query_res.= " AND post_date = '".$_REQUEST['date']."'";
	}
	if($_REQUEST['customer_name']!=''){
		$query_res.= " AND customer_name LIKE  '%".$_REQUEST['customer_name']."%'";
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
		$pagination .= "<a href=\"manage_restaurant_reviews.php?page=$prev&restaurant_id=".$_REQUEST['restaurant_id']."&date=".$_REQUEST['date']."&customer_name=".$_REQUEST['customer_name']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_restaurant_reviews.php?page=$i&restaurant_id=".$_REQUEST['restaurant_id']."&date=".$_REQUEST['date']."&customer_name=".$_REQUEST['customer_name']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_restaurant_reviews.php?page=$next&restaurant_id=".$_REQUEST['restaurant_id']."&date=".$_REQUEST['date']."&customer_name=".$_REQUEST['customer_name']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_order['post_date'])); ?></td>
    <td class="all_restaurant2"><?php echo $array_order['customer_name']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['city']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['state']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['customer_review']; ?></td>
    <td class="all_restaurant2">
    <a href="reply_reviews.php?customer_id=<?php echo $array_order['customer_id'];?>&review_id=<?=$array_order['id']?>&page=<?=$_REQUEST['page']?>&restaurant_id=<?php echo $_REQUEST['restaurant_id']; ?>">
    <img src="admin/images/1373904457_reply.png" alt="Reply" title="Reply" border="0" />
    </a>
    </td>
  </tr>
  <?php $inc++; } } else { ?>
  <tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No Reviews yet</td>
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

