<?php
ob_start();
session_start();
if(!isset($_SESSION['admin_id'])){
	header("location:admin/login.php");
}
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
?>
<script type="text/javascript">
function sort_function(sort_by,restaurant_name,restaurant_city,restaurant_state,email){
	location.href = "manage_all_restaurants.php?sort_order="+sort_by+"&restaurant_name="+restaurant_name+"&restaurant_city="+restaurant_city+"&restaurant_state="+restaurant_state+"&email="+email;
}
</script>

<body>
<?php include ("includes/menu_restaurant_admin_panel.php");?>

<?php
$query_res = "SELECT rbi.id,rbi.name, rbi.email,  rbi.website, rbi.restaurant_name, rbi.restaurant_address , rbi.restaurant_city , rbi.restaurant_state, rbi.restaurant_zipcode, rbi.restaurant_country, rbi.restaurant_category, rbi.restaurant_category_name, rbi.restaurant_image, rbi.status, rbi.featured_status, rbi.show_order FROM restaurant_basic_info rbi INNER JOIN restaurant_admin_panel ra ON rbi.id = ra.restaurant_id  where rbi.status=1";
 
 if($_REQUEST['restaurant_name']!="")
 {
	 $query_res.=" AND rbi.restaurant_name = '".$_REQUEST['restaurant_name']."'";
 } 
 if($_REQUEST['rest_name']!="")
 {
	 $query_res.=" AND rbi.restaurant_name LIKE '%".$_REQUEST['rest_name']."%'";
 }
 if($_REQUEST['restaurant_city']!="")
 {
	 $query_res.=" AND rbi.restaurant_city = '".$_REQUEST['restaurant_city']."'";
 }
 
 if($_REQUEST['restaurant_state']!="")
 {
	 $query_res.=" AND rbi.restaurant_state = '".$_REQUEST['restaurant_state']."'";
 }
 
 if($_REQUEST['email']!="")
 {
	 $query_res.=" AND rbi.email = '".$_REQUEST['email']."'";
 }
 
 if($_REQUEST['sort_order']){
 	 $query_res.=" ORDER BY rbi.".$_REQUEST['sort_order']."";
 }
 
//echo $query_res; 
$sel_product=mysql_query($query_res);
					


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
$max_results =100; 
$prev = ($page - 1); 
$next = ($page + 1); 
$from = (($page * $max_results) - $max_results); 

$total_results = mysql_num_rows($sel_product); 
$total_pages = ceil($total_results / $max_results); 

$pagination = ''; 

if($page > 1) 
{ 
$pagination .= "<a href=\"manage_all_restaurants.php?page=$prev&restaurant_name=".$_REQUEST['restaurant_name']."&restaurant_city=".$_REQUEST['restaurant_city']."&restaurant_state=".$_REQUEST['restaurant_state']."&email=".$_REQUEST['email']."&category=".$_REQUEST['category']."&sort_order=".$_REQUEST['sort_order']."&rest_name=".$_REQUEST['rest_name']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
$pagination .= "<a href=\"manage_all_restaurants.php?page=$i&restaurant_name=".$_REQUEST['restaurant_name']."&restaurant_city=".$_REQUEST['restaurant_city']."&restaurant_state=".$_REQUEST['restaurant_state']."&email=".$_REQUEST['email']."&category=".$_REQUEST['category']."&sort_order=".$_REQUEST['sort_order']."&rest_name=".$_REQUEST['rest_name']."\" class=\"more_link_pagination\">$i</a>"; 
$pagination.='&nbsp;&nbsp;&nbsp;';
} 
} 

if($page < $total_pages) 
{ 
$pagination .= "<a href=\"manage_all_restaurants.php?page=$next&restaurant_name=".$_REQUEST['restaurant_name']."&restaurant_city=".$_REQUEST['restaurant_city']."&restaurant_state=".$_REQUEST['restaurant_state']."&email=".$_REQUEST['email']."&category=".$_REQUEST['category']."&sort_order=".$_REQUEST['sort_order']."&rest_name=".$_REQUEST['rest_name']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
<form name="frmproduct" action="manage_all_restaurants.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td width="18%" class="all_restaurant">Restaurant Name:</td>
                  <td width="24%">
                  <select name="restaurant_name" id="restaurant_name" style="width:215px;">
                  <option value="">--Select--</option>
                  <?php $sql_restaurant_name = mysql_query("SELECT * FROM restaurant_basic_info WHERE id!=''");
				  while($array_restaurant_name = mysql_fetch_array($sql_restaurant_name)){ ?>
                  <option value="<?php echo $array_restaurant_name['id']; ?>" <?php if($array_restaurant_name['id'] == $_REQUEST['restaurant_name']){ ?> selected="selected" <?php } ?>><?php echo stripslashes($array_restaurant_name['restaurant_name']); ?></option>
				  <?php } ?>
                  </select>
                  <?php /*?><input type="text" name="restaurant_name" id="restaurant_name"  class="restaurant" value="<?php echo $_REQUEST['restaurant_name'];?>" style="height:16px;"><?php */?></td>
                  
                  <td width="18%" class="all_restaurant">Restaurant Name:</td>
                  <td width="24%">
                  <input type="text" name="rest_name" id="rest_name"  class="restaurant" value="<?php echo $_REQUEST['rest_name'];?>" style="height:16px;"></td>
                  
                  <td width="11%" class="all_restaurant">City:</td>
                  <td width="16%">
                  <select name="restaurant_city" id="restaurant_city" style="width:215px;">
                  <option value="">--Select--</option>
                  <?php $sql_select_city = mysql_query("SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!=''");
				  while($array_select_city = mysql_fetch_array($sql_select_city)){ ?>
					<option value="<?php echo $array_select_city['restaurant_city']; ?>" <?php if($array_select_city['restaurant_city'] == $_REQUEST['restaurant_city']){?> selected="selected" <?php } ?>><?php echo $array_select_city['restaurant_city']; ?></option>
                  <?php } ?>
                  </select>
                  <?php /*?><input type="text" name="restaurant_city" id="restaurant_city"  class="restaurant" value="<?php echo $_REQUEST['restaurant_city'];?>" style="height:16px;"><?php */?></td>
                 </tr>
                 
                 <tr>
                  <td width="6%" height="24" class="all_restaurant">State:</td>
                  <td width="25%">
				  <select name="restaurant_state" id="restaurant_state" style="width:215px;">
                  <option value="">--Select--</option>
                  <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!=''");
				  while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
					<option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['restaurant_state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
                  <?php } ?>
                  </select>
				  <?php /*?><input type="text" name="restaurant_state" id="restaurant_state"  class="restaurant" value="<?php echo $_REQUEST['restaurant_state'];?>" style="height:16px;"><?php */?></td>
                  
                  <td class="all_restaurant">Email:</td>
                  <td><input type="text" name="email" id="email"  class="restaurant" value="<?php echo $_REQUEST['email'];?>" style="height:16px;"></td>
                  
                  <td colspan="4">
                  <input type="submit" name="search" value="Search" class="button4" style="margin:0 0 0 5px;">
                  <a href="manage_all_restaurants.php"><input type="button" name="show_all" value="Show All" class="button4" style="margin-left:15px;" ></a>
                  </td>
                 </tr>
                 
                 </table>
                 </form>
                 </div>
                 
<div class="restaurant_cont_field"><table width="100%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;">
  <tr>
    <td width="245" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['restaurant_city'];?>','<?php echo $_REQUEST['restaurant_state'];?>','<?php echo $_REQUEST['email'];?>')" class="heading_link">Restaurant Name</a></td>
    <td width="166" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_city','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['restaurant_city'];?>','<?php echo $_REQUEST['restaurant_state'];?>','<?php echo $_REQUEST['email'];?>')" class="heading_link">City</a></td>
    <td width="173" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_state','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['restaurant_city'];?>','<?php echo $_REQUEST['restaurant_state'];?>','<?php echo $_REQUEST['email'];?>')" class="heading_link">State</a></td>
    <td width="213" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_category_name','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['restaurant_city'];?>','<?php echo $_REQUEST['restaurant_state'];?>','<?php echo $_REQUEST['email'];?>')" class="heading_link">Restaurant Category</a></td>
    <td width="185" class="all_restaurant">Image</td>
    <td width="237" class="all_restaurant" align="center">Action</td>
  </tr>
  <?php
  while($row_restaurant=mysql_fetch_array($query_products))
  {
  ?>
  <tr>
    <td class="all_restaurant2"><?php echo stripslashes($row_restaurant['restaurant_name'])?></td>
    <td class="all_restaurant2"><?php echo stripslashes($row_restaurant['restaurant_city'])?></td>
    <td class="all_restaurant2"><?php echo stripslashes($row_restaurant['restaurant_state'])?></td>
    <td class="all_restaurant2"><?php 
	$str = $row_restaurant['restaurant_category'];
	$restaurant_category = explode(",",$str);
	$i=1;
	foreach($restaurant_category as $val){
		$sql_category=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_category WHERE id='".$val."'"));
		echo stripslashes($sql_category['category_name']);
		if(count($restaurant_category)!= $i){
			echo " , ";
		}
		$i++;
	}
	?></td>
    
    <td class="all_restaurant2"><?php if($row_restaurant['restaurant_image']!=""){?><img src="thumb_images/<?php echo $row_restaurant['restaurant_image']?>" width="60" height="60"><?php } else{?><img src="images/no_image.png" width="60" height="60"> <?php }?></td>
    <td class="all_restaurant2" width="237"><a href="manage_restaurant_live_orders.php?restaurant_id=<?php echo $row_restaurant['id']?>" class="all_edit">Manage Live Orders</a>&nbsp;
    </td>
  </tr>
  <?php
  }
  ?>
</table>
</div>
<?php
if(mysql_num_rows($sel_product)<1)
{
	?>
<p class="new1 no_res"><?php echo "No Results Found";?></p>
<?php
} ?>
<div class="pagination" style="padding-top:10px; margin-top:10px; width:100%;">
<div align="center">
<?php if($total_pages>1){ echo $pagination;}?>
</div>
</div>
</div>
<div class="clear"></div>


</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

