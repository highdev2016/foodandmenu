<?php
ob_start();
session_start();
//print_r($_SESSION);
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
rest_chk_authentication();
?>
<body>
<?php include ("includes/top_search.php");?>
<?php include ("includes/menu_section.php");?>
<?php
if($_REQUEST['action']=="delete")
{
	$restaurant_user_id=mysql_fetch_array(mysql_query("Select user_id from restaurant_basic_info where id='".$_REQUEST['restaurant_del_id']."'"));
	mysql_query("Delete from restaurant_basic_info where id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("Delete from restaurant_business_delivery_takeout_info where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("Delete from restaurant_services_dress_payment where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("Delete from restaurant_menu_item where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("Delete from restaurant_photo where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("Delete from restaurant_video where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("Delete from restaurant_coupon where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("Delete from restaurant_deals where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("Delete from restaurant_users where id='".$restaurant_user_id."' AND user_type='restaurant'");
	mysql_query("Delete from restaurant_extra_business_hours where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	header("location:view_all_restaurant.php");
}
?>
<?php
//$res_retsurant=mysql_query("SELECT * FROM restaurant_basic_info where status=1 ORDER BY restaurant_name");
 $query_res = "SELECT * FROM restaurant_basic_info where status=1";
 
 if($_REQUEST['restaurant_name']!="")
 {
	 $query_res.=" AND restaurant_name LIKE '".$_REQUEST['restaurant_name']."%'";
 }
 
 if($_REQUEST['category']!="")
 {
	 $query_res.=" AND restaurant_category=".$_REQUEST['category']."";
 }
 
 $query_res.=" ORDER BY restaurant_name";
 
 
$sel_product=mysql_query($query_res);
					
if(mysql_num_rows($sel_product)<1)
{
	?>
<p class="new1"><?php echo "No Results Found";?></p>
<?php
}

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
$max_results =50; 
$prev = ($page - 1); 
$next = ($page + 1); 
$from = (($page * $max_results) - $max_results); 

$total_results = mysql_num_rows($sel_product); 
$total_pages = ceil($total_results / $max_results); 

$pagination = ''; 

if($page > 1) 
{ 
$pagination .= "<a href=\"view_all_restaurant.php?page=$prev\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
$pagination .= "<a href=\"view_all_restaurant.php?page=$i\" class=\"more_link_pagination\">$i</a>"; 
$pagination.='&nbsp;&nbsp;&nbsp;';
} 
} 

if($page < $total_pages) 
{ 
$pagination .= "<a href=\"view_all_restaurant.php?page=$next\" class=\"more_link_pagination_prev\">Next</a>"; 
$pagination.="&nbsp;&nbsp;&nbsp;";
} 

$query_res.=" limit $from,$max_results";
//echo $query_res;
$query_products=mysql_query($query_res);
?>


<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>View Restaurants</h1>
</div>
<div class="restaurant_cont_field">
<form name="frmproduct" action="" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td class="all_restaurant">Restaurant Name:</td>
                  <td><input type="text" name="restaurant_name" id="restaurant_name"  class="login_ipboxin" value=""></td>
                  <?php
				  $res_category=mysql_query("SELECT * FROM restaurant_category WHERE 1 ORDER BY category_name");
				  ?>
                  <td class="all_restaurant">Category:</td>
                  <td><select name="category" id="category">
                  <option value="">------Select-------</option>
                  <?php
				  while($all_category=mysql_fetch_array($res_category))
				  {
				  ?>
                  <option value="<?php echo $all_category['id']?>"><?php echo $all_category['category_name']?></option>
                  <?php
				  }
				  ?>
                  </select></td>
                    <td><input type="submit" name="search" value="Search" class="button4" style="margin-left:59px;"></td>
                 </tr>
                 
                 </table>
                 </form>
                 </div>
<div class="restaurant_cont_field"><table width="100%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;">
  <tr>
    <td width="214" class="all_restaurant">Restaurant Name</td>
    <td width="135" class="all_restaurant">Restaurant Category</td>
    <td width="171" class="all_restaurant">Image</td>
    <td width="109" class="all_restaurant">Action</td>
  </tr>
  <?php
  while($row_restaurant=mysql_fetch_array($query_products))
  {
	  $sql_category=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_category WHERE id='".$row_restaurant['restaurant_category']."'"));
  ?>
  <tr>
    <td class="all_restaurant2"><?php echo stripslashes($row_restaurant['restaurant_name'])?></td>
    <td class="all_restaurant2"><?php echo stripslashes($sql_category['category_name'])?></td>
    <td class="all_restaurant2"><?php if($row_restaurant['restaurant_image']!=""){?><img src="thumb_images/<?php echo $row_restaurant['restaurant_image']?>" width="60" height="60"><?php } else{?><img src="images/no_image.png" width="60" height="60"> <?php }?></td>
    <td class="all_restaurant2" width="109"><a href="edit_restaurant.php?restaurant_edit_id=<?php echo $row_restaurant['id']?>" class="all_edit">Edit</a>&nbsp;
    <?php
	if($_SESSION['restaurant_user_type']!='admin_restaurant')
	{
    ?><a href="view_all_restaurant.php?action=delete&restaurant_del_id=<?php echo $row_restaurant['id']?>" class="all_edit" onClick="return confirm('Are you want to delete the restaurant?');">Delete</a>
    <?php
	}
	?></td>
  </tr>
  <?php
  }
  ?>
</table>
</div>

</div>
<div class="clear"></div>

<div class="pagination">

<div align="center">
<?php if($total_pages>1){ echo $pagination;}?>

</div>
</div>
</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

