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
	location.href = "view_restaurants.php?sort_order="+sort_by+"&restaurant_name="+restaurant_name+"&restaurant_city="+restaurant_city+"&restaurant_state="+restaurant_state+"&email="+email;
}
</script>

<body>
<?php include ("includes/menu_restaurant_admin_panel.php");?>

<?php
$limit = 100;
$start = 1;
$slice = 2;

$query_res = "SELECT * FROM restaurant_basic_info where status=1";
 
if($_REQUEST['restaurant_name']!="")
{
 $query_res.=" AND restaurant_name LIKE '%".$_REQUEST['restaurant_name']."%'";
}

if($_REQUEST['restaurant_city']!="")
{
 $query_res.=" AND restaurant_city = '".$_REQUEST['restaurant_city']."'";
}

if($_REQUEST['restaurant_state']!="")
{
 $query_res.=" AND restaurant_state = '".$_REQUEST['restaurant_state']."'";
}

if($_REQUEST['email']!="")
{
 $query_res.=" AND email = '".$_REQUEST['email']."'";
}

if($_REQUEST['sort_order']){
 $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
}

$r = mysql_query($query_res);
$totalrows = mysql_num_rows($r);

if(!isset($_GET['page']) || ($_REQUEST['search']!="")){
$page = 1;
} else {
$page = $_GET['page'];
}

$numofpages = ceil($totalrows / $limit);
$limitvalue = $page * $limit - ($limit);

$query_res = "SELECT * FROM restaurant_basic_info where status=1";
 
if($_REQUEST['restaurant_name']!="")
{
 $query_res.=" AND restaurant_name LIKE '%".$_REQUEST['restaurant_name']."%'";
}

if($_REQUEST['restaurant_city']!="")
{
 $query_res.=" AND restaurant_city = '".$_REQUEST['restaurant_city']."'";
}

if($_REQUEST['restaurant_state']!="")
{
 $query_res.=" AND restaurant_state = '".$_REQUEST['restaurant_state']."'";
}

if($_REQUEST['email']!="")
{
 $query_res.=" AND email = '".$_REQUEST['email']."'";
}

if($_REQUEST['sort_order']){
 $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
}
 
$query_res.=" LIMIT $limitvalue, $limit";
 
//echo $query_res; 
$sel_product=mysql_query($query_res);

$query_products=mysql_query($query_res);

?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>View all Restaurants</h1>
</div>

<div class="restaurant_cont_field">
<p>
<form name="form1" method="post" action="restaurant_export_excel.php">
<input type="submit" name="export" value="Export to Excel" class="button4" style="margin-left:844px;"/>
</form>
</p>
</div>
                 
<div class="restaurant_cont_field"><table width="100%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;">
  <tr>
    <td width="245" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['restaurant_city'];?>','<?php echo $_REQUEST['restaurant_state'];?>','<?php echo $_REQUEST['email'];?>')" class="heading_link">Restaurant Name</a></td>
    <td width="166" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_city','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['restaurant_city'];?>','<?php echo $_REQUEST['restaurant_state'];?>','<?php echo $_REQUEST['email'];?>')" class="heading_link">City</a></td>
    <td width="173" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_state','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['restaurant_city'];?>','<?php echo $_REQUEST['restaurant_state'];?>','<?php echo $_REQUEST['email'];?>')" class="heading_link">State</a></td>
    <td width="213" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_category_name','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['restaurant_city'];?>','<?php echo $_REQUEST['restaurant_state'];?>','<?php echo $_REQUEST['email'];?>')" class="heading_link">Restaurant Category</a></td>
    <td width="185" class="all_restaurant">Image</td>
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
<?php if($page!= 1){
$pageprev = $page - 1;
echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$pageprev.'&restaurant_name='.$_REQUEST['restaurant_name'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&email='.$_REQUEST['email'].'&category='.$_REQUEST['category'].'&sort_order='.$_REQUEST['sort_order'].'" class="more_link_pagination_prev">PREVIOUS</a>  ';
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
echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'&restaurant_name='.$_REQUEST['restaurant_name'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&email='.$_REQUEST['email'].'&category='.$_REQUEST['category'].'&sort_order='.$_REQUEST['sort_order'].'" class="more_link_pagination">'.$i.'</a> ';
}
}

if(($totalrows - ($limit * $page)) > 0){
$pagenext = $page + 1;
echo '  <a href="'.$_SERVER['PHP_SELF'].'?page='.$pagenext.'&restaurant_name='.$_REQUEST['restaurant_name'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&email='.$_REQUEST['email'].'&category='.$_REQUEST['category'].'&sort_order='.$_REQUEST['sort_order'].'" class="more_link_pagination_prev">NEXT</a>';
}
?>
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

