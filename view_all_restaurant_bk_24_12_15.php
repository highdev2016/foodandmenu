<?php
ob_start();
session_start();
//print_r($_SESSION);
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
rest_chk_authentication();
?>
<script type="text/javascript">
function sort_function(sort_by,restaurant_name,category){
	location.href = "view_all_restaurant.php?sort_order="+sort_by+"&restaurant_name="+restaurant_name+"&category="+category;
}

function get_state_city(state){
	//alert(state);
	$.ajax({
		url : 'get_state_city.php',
		type : 'POST',
		data : 'state=' + state,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('restaurant_city').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}

function get_restaurant(city){
	//alert(city);
	$.ajax({
		url : 'get_city_restaurant.php',
		type : 'POST',
		data : 'city=' + city,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			/*var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];*/
			document.getElementById('restaurant_name').innerHTML=data;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}
</script>

<body>
<?php include ("includes/menu_admin_add_res.php");?>
<?php
if($_REQUEST['action']=="delete")
{
	$restaurant_user_id=mysql_fetch_array(mysql_query("Select * from restaurant_basic_info where id='".$_REQUEST['restaurant_del_id']."'"));
	mysql_query("DELETE FROM restaurant_owner WHERE email = '".$restaurant_user_id['email']."'");
	mysql_query("DELETE FROM restaurant_basic_info where id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_business_delivery_takeout_info where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_services_dress_payment where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_menu_item where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_photo where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_video where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_coupon where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_deals where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_users where id='".$restaurant_user_id['user_id']."' AND user_type='restaurant'");
	mysql_query("DELETE FROM restaurant_extra_business_hours where restaurant_id='".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_menu_special_instruction WHERE restaurant_id = '".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_menu_item_special_instruction WHERE restaurant_id = '".$_REQUEST['restaurant_del_id']."'");
	mysql_query("DELETE FROM restaurant_delivery_charge WHERE restaurant_id = '".$_REQUEST['restaurant_del_id']."'");
	header("location:view_all_restaurant.php?success=1&page=".$_REQUEST['page']."");
}
?>
<?php
$limit = 100;
$start = 1;
$slice = 2;

$query_res = "SELECT * FROM restaurant_basic_info where status=1";

if($_REQUEST['restaurant_name_key']!="")
{
 $query_res.=" AND restaurant_name LIKE '%".$_REQUEST['restaurant_name_key']."%'";
}

if($_REQUEST['restaurant_name']!="")
{
 $query_res.=" AND id = '".$_REQUEST['restaurant_name']."'";
}

if($_REQUEST['restaurant_state']!="")
{
 $query_res.=" AND restaurant_state = '".$_REQUEST['restaurant_state']."'";
}

if($_REQUEST['restaurant_city']!="")
{
 $query_res.=" AND restaurant_city = '".$_REQUEST['restaurant_city']."'";
}

if($_REQUEST['category']!="")
{
 //$query_res.=" AND restaurant_category=".$_REQUEST['category']."";
 $query_res.=" AND find_in_set(".$_REQUEST['category'].",restaurant_category)";
}

if($_REQUEST['sort_order']){
 $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
}

$r = mysql_query($query_res);
$totalrows = mysql_num_rows($r);

if(!isset($_GET['page']) || ($_REQUEST['search']!="") || $_GET['page']==''){
$page = 1;
} else {
$page = $_GET['page'];
}

$numofpages = ceil($totalrows / $limit);
$limitvalue = $page * $limit - ($limit);

$query_res = "SELECT * FROM restaurant_basic_info where status=1";

if($_REQUEST['restaurant_name_key']!="")
{
 $query_res.=" AND restaurant_name LIKE '%".$_REQUEST['restaurant_name_key']."%'";
}

if($_REQUEST['restaurant_name']!="")
{
 $query_res.=" AND id = '".$_REQUEST['restaurant_name']."'";
}

if($_REQUEST['restaurant_state']!="")
{
 $query_res.=" AND restaurant_state = '".$_REQUEST['restaurant_state']."'";
}

if($_REQUEST['restaurant_city']!="")
{
 $query_res.=" AND restaurant_city = '".$_REQUEST['restaurant_city']."'";
}

if($_REQUEST['category']!="")
{
 //$query_res.=" AND restaurant_category=".$_REQUEST['category']."";
 $query_res.=" AND find_in_set(".$_REQUEST['category'].",restaurant_category)";
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

<div class="restaurant_body_cont view_restu_cont">

<div class="restaurant_cont_top">
<h1>View Restaurants</h1>
</div>
<div class="restaurant_cont_field">
<form name="frmproduct" action="view_all_restaurant.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td class="all_restaurant">State:</td>
                  <td>
				  <select name="restaurant_state" id="restaurant_state" style="width:200px;"  onchange="get_state_city(this.value);">
                  <option value="">--Select--</option>
                  <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='' ORDER BY restaurant_state");
				  while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
					<option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['restaurant_state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
                  <?php } ?>
                  </select>
				  </td>
                  <td class="all_restaurant">City:</td>
                  <td>
				  <select name="restaurant_city" id="restaurant_city" style="width:200px;" onChange="get_restaurant(this.value);">
                  <option value="">--Select--</option>
                 <?php $sql_select_city = mysql_query("SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!='' ORDER BY restaurant_city");
				  while($array_select_city = mysql_fetch_array($sql_select_city)){ ?>
					<option value="<?php echo $array_select_city['restaurant_city']; ?>" <?php if($array_select_city['restaurant_city'] == $_REQUEST['restaurant_city']){?> selected="selected" <?php } ?>><?php echo $array_select_city['restaurant_city']; ?></option>
                  <?php } ?>
                  </select>
				  </td>
                 
                 <td height="39" class="all_restaurant">Restaurant Name:</td>
                  <td>
				  <select name="restaurant_name" id="restaurant_name" style="width:200px;">
                  <option value="">--Select--</option>
                  <?php $sql_restaurant_name = mysql_query("SELECT * FROM restaurant_basic_info WHERE id!='' GROUP BY restaurant_name");
				  while($array_restaurant_name = mysql_fetch_array($sql_restaurant_name)){ ?>
                  <option value="<?php echo $array_restaurant_name['id']; ?>" <?php if($array_restaurant_name['id'] == $_REQUEST['restaurant_name']){ ?> selected="selected" <?php } ?>><?php echo stripslashes($array_restaurant_name['restaurant_name']); ?></option>
				  <?php } ?>
                  </select>
				  <?php /*?><input type="text" name="restaurant_name" id="restaurant_name"  class="login_ipboxin" value="<?php echo $_REQUEST['restaurant_name'];?>"><?php */?></td>
                  
              </tr>
                  
                  <tr>
                  <?php
				  $res_category=mysql_query("SELECT * FROM restaurant_category WHERE 1 ORDER BY category_name");
				  ?>
                  <td height="31" class="all_restaurant">Category:</td>
                  <td><select name="category" id="category" style="width:200px;">
                  <option value="">--Select--</option>
                  <?php
				  while($all_category=mysql_fetch_array($res_category))
				  {
				  ?>
                  <option value="<?php echo $all_category['id']?>" <?php if($_REQUEST['category'] == $all_category['id']){?> selected = "selected" <?php } ?>><?php echo $all_category['category_name']?></option>
                  <?php
				  }
				  ?>
                  </select></td>
                  
                  <td height="39" class="all_restaurant">Restaurant Name:</td>
                  <td>
                  <input type="text" name="restaurant_name_key" id="restaurant_name_key"  class="login_ipboxin" value="<?php echo $_REQUEST['restaurant_name_key'];?>" style="width:195px;"></td>   
                  
                <td colspan="4"><input type="submit" name="search" value="Search" class="button4" style="margin-left:0px;">
                
                <a href="view_all_restaurant.php"><input type="button" name="show_all" value="Show All" class="button4" style="margin-left:15px;"></a></td>
              </tr>
                 
                 </table>
                 </form>
                 </div>
                 
                 <?php if($_REQUEST['success'] == 1){?>
                 <div style="text-align:center;">Restaurant deleted successfully</div>
                 <?php } ?>
<div class="restaurant_cont_field"><table width="98%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;">
  <tr>
    <th width="245" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['category'];?>')" class="heading_link">Restaurant Name</a></th>
    <th width="166" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_city','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['category'];?>')" class="heading_link">City</a></th>
    <th width="173" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_state','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['category'];?>')" class="heading_link">State</a></th>
    <th width="213" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_category_name','<?php echo $_REQUEST['restaurant_name'];?>','<?php echo $_REQUEST['category'];?>')" class="heading_link">Restaurant Category</a></th>
    <th width="205" class="all_restaurant">Image</th>
    <th width="217" class="all_restaurant">Action</th>
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
    <td class="all_restaurant2" width="217"><a href="edit_restaurant.php?restaurant_edit_id=<?php echo $row_restaurant['id']?>" class="all_edit">Edit</a>&nbsp;
<a href="view_all_restaurant.php?action=delete&restaurant_del_id=<?php echo $row_restaurant['id']?>&page=<?php echo $_REQUEST['page']; ?>" class="all_edit" onClick="return confirm('Are you want to delete the restaurant?');">Delete</a></td>
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
echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$pageprev.'&restaurant_name='.$_REQUEST['restaurant_name'].'&category='.$_REQUEST['category'].'&sort_order='.$_REQUEST['sort_order'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&restaurant_name_key='.$_REQUEST['restaurant_name_key'].'" class="more_link_pagination_prev">PREVIOUS</a>  ';
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
echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'&restaurant_name='.$_REQUEST['restaurant_name'].'&category='.$_REQUEST['category'].'&sort_order='.$_REQUEST['sort_order'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&restaurant_name_key='.$_REQUEST['restaurant_name_key'].'" class="more_link_pagination">'.$i.'</a> ';
}
}

if(($totalrows - ($limit * $page)) > 0){
$pagenext = $page + 1;
echo '  <a href="'.$_SERVER['PHP_SELF'].'?page='.$pagenext.'&restaurant_name='.$_REQUEST['restaurant_name'].'&category='.$_REQUEST['category'].'&sort_order='.$_REQUEST['sort_order'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&restaurant_name_key='.$_REQUEST['restaurant_name_key'].'" class="more_link_pagination_prev">NEXT</a>';
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

