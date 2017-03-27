<?php
session_start();
//print_r($_SESSION);
//echo $_SESSION['customer_id'];
if($_REQUEST['cid']!="")
{
	$_SESSION['customer_id']=$_REQUEST['cid'];
	header("location:home.php");
}

//echo $_COOKIE['resCity '];
/*if($_REQUEST['city']!=''){
	$expire=time()+60*60*24*30;
	setcookie("resCity", $_REQUEST['city'], $expire);
}*/

//if($_SESSION['page_type']=="restaurant" || $_SESSION['page_type']=="reservation" || $_SESSION['page_type']=="vendor")
//{
//	$redirect=str_replace('/','',$_SESSION['redirect']);
//	header("location:".$redirect);
//}
 include ("includes/header.php");
 include ("includes/functions.php");
 
//include ("search_compete.php");

function getTimezone($location)
{
	$location = urlencode($location);
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address={$location}&sensor=false";
	$data = file_get_contents($url);
	
	// Get the lat/lng out of the data
	$data = json_decode($data);
	if(!$data) return false;
	if(!is_array($data->results)) return false;
	if(!isset($data->results[0])) return false;
	if(!is_object($data->results[0])) return false;
	if(!is_object($data->results[0]->geometry)) return false;
	if(!is_object($data->results[0]->geometry->location)) return false;
	if(!is_numeric($data->results[0]->geometry->location->lat)) return false;
	if(!is_numeric($data->results[0]->geometry->location->lng)) return false;
	$lat = $data->results[0]->geometry->location->lat;
	$lng = $data->results[0]->geometry->location->lng;
	
	// get the API response for the timezone
	$timestamp = time();
	$timezoneAPI = "https://maps.googleapis.com/maps/api/timezone/json?location={$lat},{$lng}&sensor=false&timestamp={$timestamp}";
	$response = file_get_contents($timezoneAPI);
	if(!$response) return false;
	$response = json_decode($response);
	if(!$response) return false;
	if(!is_object($response)) return false;
	if(!is_string($response->timeZoneId)) return false;
	
	return $response->timeZoneId;
}

?>

<body onLoad="init();">
<?php //print_r($_SESSION)?>
<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>


<script type="text/javascript">
function search_restaurant(sort_order,rest_item,full_address,filter1,filter2,filter3,filter4)
	{
		//alert(sort_order);
		//alert(rest_item);
		//alert(city);
		//alert(subcatid);
		location.href="home.php?rest_item="+rest_item+"&full_address="+full_address+"&sort_order="+sort_order+"&filter1="+filter1+"&filter2="+filter2+"&filter3="+filter3+"&filter4="+filter4;
	}
	
function filter_restaurant(filter1,filter2,filter3,rest_item,full_address,sort_order,filter4){
		if(document.getElementById('checkbox1').checked == true){
			var pickup = filter1;
		}else {
			var pickup = '';
		}
		if(document.getElementById('checkbox2').checked == true){
			var delivery = filter2;
		}else {
			var delivery = '';
		}
		if(document.getElementById('checkbox3').checked == true){
			var free_delivery = filter3;
		}else {
			var free_delivery = '';
		}
		if(document.getElementById('checkbox4').checked == true){
			var have_coupons = filter4;
		}else {
			var have_coupons = '';
		}
		location.href="home.php?rest_item="+rest_item+"&full_address="+full_address+"&filter1="+pickup+"&filter2="+delivery+"&filter3="+free_delivery+"&sort_order="+sort_order+"&filter4="+have_coupons;
	}
</script>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">
<?php
//print_r($_SESSION);
//echo $_SESSION['customer_id'];
?>
<div class="main_body_cont">

<?php include("includes/banner_section.php");?>

<div class="content_container">

<?php include("includes/left_section.php");?>

<div class="body_cont_right">
<?php

$rest_item 	= isset($_REQUEST['rest_item']) ? strtolower(mysql_real_escape_string(trim($_REQUEST['rest_item']))) : '' ; 
$full_address = isset($_REQUEST['full_address']) ? strtolower(trim($_REQUEST['full_address'])) : ''; 
$sub_cat_id   = isset($_REQUEST['sub_cat_id']) ? strtolower(trim($_REQUEST['sub_cat_id'])) : ''; 
$sort_order   = isset($_REQUEST['sort_order']) ? strtolower(trim($_REQUEST['sort_order'])) : '';
$filter1   = isset($_REQUEST['filter1']) ? strtolower(trim($_REQUEST['filter1'])) : '';
$filter2   = isset($_REQUEST['filter2']) ? strtolower(trim($_REQUEST['filter2'])) : '';
$filter3   = isset($_REQUEST['filter3']) ? strtolower(trim($_REQUEST['filter3'])) : '';
$filter4   = isset($_REQUEST['filter4']) ? strtolower(trim($_REQUEST['filter4'])) : '';

//echo $_COOKIE['resCity']; exit;
//echo $_COOKIE['reszip'];

if($_COOKIE['resCity']!="")
{
	$get_city = "SELECT * FROM restaurant_basic_info WHERE restaurant_city='".$_COOKIE['resCity']."' AND status = 1";
 
if($_COOKIE['reszip']!=''){
	$get_city.= " AND restaurant_zipcode = '".$_COOKIE['reszip']."'"; 
}
//echo $get_city; 
 
$sql_select_city = mysql_query($get_city);
 	
 $sep="";
 while($row_select_city=mysql_fetch_array($sql_select_city))
 {
	 $city_in.=$sep.$row_select_city['id'];
	 $sep=",";
 }
// echo $city_in;
 if($city_in!='')
 {
 $sql_select_deal = mysql_query("SELECT * FROM restaurant_deals WHERE deals_status =1 AND daily_name!='' AND restaurant_id IN(".$city_in.") AND (expiry_date	> '".date('Y-m-d')."' OR expiry_date = '0000-00-00') ORDER BY rand() LIMIT 0,3");
 $num_select_deal=mysql_num_rows($sql_select_deal);
 }
 else{
	 $num_select_deal=0;
 }
}
else{
	
 $sql_select_active_restaurant = mysql_query("SELECT * FROM restaurant_basic_info WHERE status = 1");	
 $sep="";
 while($row_select_active_restaurant=mysql_fetch_array($sql_select_active_restaurant))
 {
	 $active_restaurant_in.=$sep.$row_select_active_restaurant['id'];
	 $sep=",";
 }
$sql_select_deal = mysql_query("SELECT * FROM restaurant_deals WHERE deals_status =1 AND daily_name!='' AND restaurant_id IN(".$active_restaurant_in.") AND (expiry_date	> '".date('Y-m-d')."' OR expiry_date = '0000-00-00') ORDER BY rand() LIMIT 0,3");
 $num_select_deal=mysql_num_rows($sql_select_deal);
}

if($num_select_deal>0)
{
	?>
<div class="right_top">

<div class="right_cont_top">
<h1>Hot Deal</h1>
</div>
<div class="right_cont_middle">

<?php 
while($array_deal = mysql_fetch_array($sql_select_deal)){?>
<div class="right_cont_one">

<div class="right_top_section">
<div class="top_image">
<?php if($array_deal['daily_picture']!=''){?>
<img src="thumb_images/<?php echo $array_deal['daily_picture'];?>" width="216" height="150" />
<?php } else { ?>
<img src="images/no_image.png" width="216" height="150" />
<?php } ?></div>
</div>

<div class="right_middle_section">
<h1 style="font-weight:bold"><?php echo stripslashes($array_deal['daily_name']);?></h1>
<p style="font-size:14px;">$<?php echo $array_deal['daily_description'];?> / Your Price : $<?php echo $array_deal['daily_price'];?></p>
<?php /*?><p><?php echo $array_deal['daily_description'];?></p><?php */?>
<p>Expiry Date : <?php echo 
date("m-d-Y", strtotime($array_deal['expiry_date']));?></p>
</div>

<div class="right_button">
  <a href="restaurant.php?id=<?php echo $array_deal['restaurant_id'];?>&deal_id=<?php echo $array_deal['id']; ?>"><img src="images/more_button.png" width="77" height="26" /></a> 
  </div>

</div>


<?php }
?>

<div class="clear"></div>
</div>


<div class="right_cont_bottom"></div>

</div>
<div class="clear"></div>
<?php } ?>
<script type="text/javascript" src="raty-master/lib/jquery.raty.js"></script>
<div class="right_dish_content">

<div class="dish_content_select_box">
<input type="checkbox" name="checkbox1" id="checkbox1" value="pickup" <?php if($_REQUEST['filter1'] == 'pickup') {?> checked = "checked" <?php } ?> onClick="filter_restaurant(this.value,'<?php echo $_GET[filter2]?>','<?php echo $_GET[filter3]?>','<?php echo $_GET[rest_item]?>','<?php echo $_GET[full_address]?>','<?php echo $_GET[sort_order]; ?>','<?php echo $_GET[filter4]?>');">&nbsp;<span style="margin-right:22px;">Pickup</span>

<input type="checkbox" name="checkbox2" id="checkbox2" value="delivery" <?php if($_REQUEST['filter2'] == 'delivery') {?> checked = "checked" <?php } ?> onClick="filter_restaurant('<?php echo $_GET[filter1]?>',this.value,'<?php echo $_GET[filter3]?>','<?php echo $_GET[rest_item]?>','<?php echo $_GET[full_address]?>','<?php echo $_GET[sort_order]; ?>','<?php echo $_GET[filter4]?>');">&nbsp;<span style="margin-right:22px;">Delivery</span>

<input type="checkbox" name="checkbox3" id="checkbox3" value="free_delivery" <?php if($_REQUEST['filter3'] == 'free_delivery') {?> checked = "checked" <?php } ?> onClick="filter_restaurant('<?php echo $_GET[filter1]?>','<?php echo $_GET[filter2]?>',this.value,'<?php echo $_GET[rest_item]?>','<?php echo $_GET[full_address]?>','<?php echo $_GET[sort_order]; ?>','<?php echo $_GET[filter4]?>');">&nbsp;<span style="margin-right:22px;">Free Delivery</span>

<input type="checkbox" name="checkbox4" id="checkbox4" value="have_coupons" <?php if($_REQUEST['filter4'] == 'have_coupons') {?> checked = "checked" <?php } ?> onClick="filter_restaurant('<?php echo $_GET[filter1]?>','<?php echo $_GET[filter2]?>','<?php echo $_GET[filter3]?>','<?php echo $_GET[rest_item]?>','<?php echo $_GET[full_address]?>','<?php echo $_GET[sort_order]; ?>',this.value);">&nbsp;<span>Have Coupons</span>

<select name="sorting_order" id="sorting_order" class="dish_select_box" onChange='search_restaurant(this.value,"<?php echo $_GET[rest_item]?>","<?php echo $_GET[full_address]?>","<?php echo $_GET[filter1];?>","<?php echo $_GET[filter2];?>","<?php echo $_GET[filter3];?>","<?php echo $_GET[filter4]?>");'>
<option class="dish_select_text">- Select Category -</option>
<option value="most-popular" <?php echo ($_GET['sort_order'] == 'most-popular')?'selected="selected"':'' ?> class="dish_select_text">Most Popular</option>
<option value="top-rated" <?php echo ($_GET['sort_order'] == 'top-rated')?'selected="selected"':'' ?> class="dish_select_text">Top Rated</option>
<option value="new" <?php echo ($_GET['sort_order'] == 'new')?'selected="selected"':'' ?> class="dish_select_text">New Restaurants</option>
</select>
<div class="clear"></div>
</div>

<?php
if($_COOKIE['resCity']!="")
{
	$query_res = "SELECT DISTINCT(r.id), r.restaurant_name, r.restaurant_address, r.restaurant_city, r.restaurant_state, r.restaurant_zipcode, r.restaurant_image, r.restaurant_category, r.latitude, r.longitude , r.restaurant_city, r.restaurant_state, r.restaurant_address ,r.restaurant_zipcode , r.restaurant_keyword ";
	
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= " ,rdi.pickup ,rdi.delivery, rdi.delivery_charge, rdi.restaurant_id , rdi.free_delivery "; } 
	
	if($filter4 == 'have_coupons'){
	$query_res .= " ,rdls.restaurant_name ";	
	}
	
	$query_res .= " FROM restaurant_basic_info as r, restaurant_category as rms "; 
	
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= " , restaurant_business_delivery_takeout_info as rdi "; }
	
	if($filter4 == 'have_coupons'){
	$query_res .= " , restaurant_deals as rdls "; }
	
	$query_res .= " WHERE r.id>0 AND r.restaurant_category = rms.id AND r.restaurant_city='".$_COOKIE['resCity']."'  ";
	if($_COOKIE['reszip']!=''){
		$query_res .= " AND  r.restaurant_zipcode='".$_COOKIE['reszip']."'  ";
	}
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= "   AND  r.id = rdi.restaurant_id "; }
	if($filter4 == 'have_coupons'){
	$query_res .= " AND  r.id = rdls.restaurant_id ";
	}
	
	if( isset($filter1) && $filter1!='' && $filter1 == 'pickup'  )
	{
		$query_res .= " AND rdi.pickup = '1'";   // filter by pickup 
	}
	if( isset($filter2) && $filter2!='' && $filter2 == 'delivery'  )
	{
		$query_res .= " AND rdi.delivery = '1'"; // filter by delivery 
	}
	if( isset($filter3) && $filter3!='' && $filter3 == 'free_delivery'  )
	{
		$query_res .= " AND rdi.delivery = '1' AND  rdi.free_delivery = '1' "; // filter by free delivery 
	}
	
	$query_res .= " AND r.status = '1'";     // search by city
	
	if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
	{
		$query_res .= " ORDER BY r.reviewed DESC"; // order by most popular depends on review 
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
	{ 
		$query_res .= " ORDER BY r.rated DESC";  // order by most reviewed depends on rating
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
	{
		$query_res .= " ORDER BY r.id DESC";     // order by new 
	}
	else {
		$query_res .= " ORDER BY r.show_order ASC";
	}
}
else{
	$query_res = "SELECT DISTINCT(r.id), r.restaurant_name, r.restaurant_address, r.restaurant_city, r.restaurant_state, r.restaurant_zipcode, r.restaurant_image, r.restaurant_category, r.latitude, r.longitude , r.restaurant_city, r.restaurant_state, r.restaurant_address ,r.restaurant_zipcode , r.restaurant_keyword ";
	
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= " ,rdi.pickup ,rdi.delivery, rdi.delivery_charge, rdi.restaurant_id , rdi.free_delivery "; } 
	
	if($filter4 == 'have_coupons'){
	$query_res .= " ,rdls.restaurant_name ";	
	}
	
	$query_res .= " FROM restaurant_basic_info as r, restaurant_category as rms "; 
	
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= " , restaurant_business_delivery_takeout_info as rdi "; }
	
	if($filter4 == 'have_coupons'){
	$query_res .= " , restaurant_deals as rdls "; }
	
	$query_res .= "WHERE r.id>0 AND r.restaurant_category = rms.id  ";
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= "   AND  r.id = rdi.restaurant_id "; }
	if($filter4 == 'have_coupons'){
	$query_res .= " AND  r.id = rdls.restaurant_id ";
	}
	
	if( isset($filter1) && $filter1!='' && $filter1 == 'pickup'  )
	{
		$query_res .= " AND rdi.pickup = '1'";   // filter by pickup 
	}
	if( isset($filter2) && $filter2!='' && $filter2 == 'delivery'  )
	{
		$query_res .= " AND rdi.delivery = '1'"; // filter by delivery 
	}
	if( isset($filter3) && $filter3!='' && $filter3 == 'free_delivery'  )
	{
		$query_res .= " AND rdi.delivery = '1' AND  rdi.free_delivery = '1' "; // filter by free delivery 
	}
	
	$query_res .= " AND r.status = '1'";     // search by city
	
	if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
	{
		$query_res .= " ORDER BY r.reviewed DESC"; // order by most popular depends on review 
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
	{ 
		$query_res .= " ORDER BY r.rated DESC";  // order by most reviewed depends on rating
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
	{
		$query_res .= " ORDER BY r.id DESC";     // order by new 
	}
	else {
		$query_res .= " ORDER BY r.show_order ASC";
	}
}
//echo $query_res;
$sel_product=mysql_query($query_res);
					
if(mysql_num_rows($sel_product)<1)
{
	?>
<p class="new1"><?php echo "No Results Found";?></p>
<?php
}

//////////////////////start pagination/////////////////////////
$limit = 20;
$start = 1;
$slice = 3;

 if($_COOKIE['resCity']!="")
{
	$query_res = "SELECT DISTINCT(r.id), r.restaurant_name, r.restaurant_address, r.restaurant_city, r.restaurant_state, r.restaurant_zipcode, r.restaurant_image, r.restaurant_category, r.latitude, r.longitude , r.restaurant_city, r.restaurant_state, r.restaurant_address ,r.restaurant_zipcode , r.restaurant_keyword ";
	
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= " ,rdi.pickup ,rdi.delivery, rdi.delivery_charge, rdi.restaurant_id , rdi.free_delivery "; } 
	
	if($filter4 == 'have_coupons'){
	$query_res .= " ,rdls.restaurant_name ";	
	}
	
	$query_res .= " FROM restaurant_basic_info as r, restaurant_category as rms "; 
	
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= " , restaurant_business_delivery_takeout_info as rdi "; }
	
	if($filter4 == 'have_coupons'){
	$query_res .= " , restaurant_deals as rdls "; }
	
	$query_res .= "WHERE r.id>0 AND r.restaurant_category = rms.id AND r.restaurant_city='".$_COOKIE['resCity']."'  ";
	if($_COOKIE['reszip']!=''){
		$query_res .= "  AND r.restaurant_zipcode='".$_COOKIE['reszip']."'  ";
	}
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= "   AND  r.id = rdi.restaurant_id "; }
	if($filter4 == 'have_coupons'){
	$query_res .= " AND  r.id = rdls.restaurant_id ";
	}
	
	if( isset($filter1) && $filter1!='' && $filter1 == 'pickup'  )
	{
		$query_res .= " AND rdi.pickup = '1'";   // filter by pickup 
	}
	if( isset($filter2) && $filter2!='' && $filter2 == 'delivery'  )
	{
		$query_res .= " AND rdi.delivery = '1'"; // filter by delivery 
	}
	if( isset($filter3) && $filter3!='' && $filter3 == 'free_delivery'  )
	{
		$query_res .= " AND rdi.delivery = '1' AND  rdi.free_delivery = '1' "; // filter by free delivery 
	}
	
	$query_res .= " AND r.status = '1'";     // search by city
	
	if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
	{
		$query_res .= " ORDER BY r.reviewed DESC"; // order by most popular depends on review 
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
	{ 
		$query_res .= " ORDER BY r.rated DESC";  // order by most reviewed depends on rating
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
	{
		$query_res .= " ORDER BY r.id DESC";     // order by new 
	}
	else {
		$query_res .= " ORDER BY r.show_order ASC";
	}
	
	/*$query_res = "SELECT * FROM restaurant_basic_info WHERE restaurant_city='".$_COOKIE['resCity']."' AND status = 1 ";
	if($_COOKIE['reszip']!=''){
		$query_res.= "  AND restaurant_zipcode = '".$_COOKIE['reszip']."' "; 
	}
	if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
	{
		$query_res.= " ORDER BY reviewed DESC"; // order by most popular depends on review 
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
	{ 
		$query_res.= " ORDER BY rated DESC";  // order by most reviewed depends on rating
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
	{
		$query_res.= " ORDER BY id DESC";     // order by new 
	}else {
		$query_res.= " ORDER BY show_order ASC";
	}*/
}
else{
	$query_res = "SELECT DISTINCT(r.id), r.restaurant_name, r.restaurant_address, r.restaurant_city, r.restaurant_state, r.restaurant_zipcode, r.restaurant_image, r.restaurant_category, r.latitude, r.longitude , r.restaurant_city, r.restaurant_state, r.restaurant_address ,r.restaurant_zipcode , r.restaurant_keyword ";
	
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= " ,rdi.pickup ,rdi.delivery, rdi.delivery_charge, rdi.restaurant_id , rdi.free_delivery "; } 
	
	if($filter4 == 'have_coupons'){
	$query_res .= " ,rdls.restaurant_name ";	
	}
	
	$query_res .= " FROM restaurant_basic_info as r, restaurant_category as rms "; 
	
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= " , restaurant_business_delivery_takeout_info as rdi "; }
	
	if($filter4 == 'have_coupons'){
	$query_res .= " , restaurant_deals as rdls "; }
	
	$query_res .= "WHERE r.id>0 AND r.restaurant_category = rms.id  ";
	if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
	$query_res .= "   AND  r.id = rdi.restaurant_id "; }
	if($filter4 == 'have_coupons'){
	$query_res .= " AND  r.id = rdls.restaurant_id ";
	}
	
	if( isset($filter1) && $filter1!='' && $filter1 == 'pickup'  )
	{
		$query_res .= " AND rdi.pickup = '1'";   // filter by pickup 
	}
	if( isset($filter2) && $filter2!='' && $filter2 == 'delivery'  )
	{
		$query_res .= " AND rdi.delivery = '1'"; // filter by delivery 
	}
	if( isset($filter3) && $filter3!='' && $filter3 == 'free_delivery'  )
	{
		$query_res .= " AND rdi.delivery = '1' AND  rdi.free_delivery = '1' "; // filter by free delivery 
	}
	
	$query_res .= " AND r.status = '1'";     // search by city
	
	if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
	{
		$query_res .= " ORDER BY r.reviewed DESC"; // order by most popular depends on review 
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
	{ 
		$query_res .= " ORDER BY r.rated DESC";  // order by most reviewed depends on rating
	}
	elseif( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
	{
		$query_res .= " ORDER BY r.id DESC";     // order by new 
	}
	else {
		$query_res .= " ORDER BY r.show_order ASC";
	}
}

//echo $query_res;
		 
		  $r = mysql_query($query_res);
		  $totalrows = mysql_num_rows($r);
		  
		  if(!isset($_GET['page'])){
		  $page = 1;
		  } else {
		  $page = $_GET['page'];
		  }
		  
		  $numofpages = ceil($totalrows / $limit);
		  $limitvalue = $page * $limit - ($limit);
		  
		 if($_COOKIE['resCity']!="")
		{
			$query_res = "SELECT DISTINCT(r.id), r.restaurant_name, r.restaurant_address, r.restaurant_city, r.restaurant_state, r.restaurant_zipcode, r.restaurant_image, r.restaurant_category, r.latitude, r.longitude , r.restaurant_city, r.restaurant_state, r.restaurant_address ,r.restaurant_zipcode , r.restaurant_keyword ";
	
			if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
			$query_res .= " ,rdi.pickup ,rdi.delivery, rdi.delivery_charge, rdi.restaurant_id , rdi.free_delivery "; } 
			
			if($filter4 == 'have_coupons'){
			$query_res .= " ,rdls.restaurant_name ";	
			}
			
			$query_res .= " FROM restaurant_basic_info as r, restaurant_category as rms "; 
			
			if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
			$query_res .= " , restaurant_business_delivery_takeout_info as rdi "; }
			
			if($filter4 == 'have_coupons'){
			$query_res .= " , restaurant_deals as rdls "; }
			
			$query_res .= "WHERE r.id>0 AND r.restaurant_category = rms.id AND r.restaurant_city='".$_COOKIE['resCity']."'  ";
			if($_COOKIE['reszip']!=''){
				$query_res .= "  AND r.restaurant_zipcode='".$_COOKIE['reszip']."'  ";
			}
			if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
			$query_res .= "   AND  r.id = rdi.restaurant_id "; }
			if($filter4 == 'have_coupons'){
			$query_res .= " AND  r.id = rdls.restaurant_id ";
			}
			
			if( isset($filter1) && $filter1!='' && $filter1 == 'pickup'  )
			{
				$query_res .= " AND rdi.pickup = '1'";   // filter by pickup 
			}
			if( isset($filter2) && $filter2!='' && $filter2 == 'delivery'  )
			{
				$query_res .= " AND rdi.delivery = '1'"; // filter by delivery 
			}
			if( isset($filter3) && $filter3!='' && $filter3 == 'free_delivery'  )
			{
				$query_res .= " AND rdi.delivery = '1' AND  rdi.free_delivery = '1' "; // filter by free delivery 
			}
			
			$query_res .= " AND r.status = '1'";     // search by city
			
			$query_res .= " AND r.featured_status = '1'";
			
			if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
			{
				$query_res .= " ORDER BY r.reviewed DESC"; // order by most popular depends on review 
			}
			elseif( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
			{ 
				$query_res .= " ORDER BY r.rated DESC";  // order by most reviewed depends on rating
			}
			elseif( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
			{
				$query_res .= " ORDER BY r.id DESC";     // order by new 
			}
			else {
				$query_res .= " ORDER BY r.show_order ASC";
			}
		}
		else{
			$query_res = "SELECT DISTINCT(r.id), r.restaurant_name, r.restaurant_address, r.restaurant_city, r.restaurant_state, r.restaurant_zipcode, r.restaurant_image, r.restaurant_category, r.latitude, r.longitude , r.restaurant_city, r.restaurant_state, r.restaurant_address ,r.restaurant_zipcode , r.restaurant_keyword ";
		
			if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
			$query_res .= " ,rdi.pickup ,rdi.delivery, rdi.delivery_charge, rdi.restaurant_id , rdi.free_delivery ";
			} 
			
			if($filter4 == 'have_coupons'){
			$query_res .= " ,rdls.restaurant_name ";	
			}
			
			$query_res .= " FROM restaurant_basic_info as r, restaurant_category as rms "; 
			
			if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
			$query_res .= " , restaurant_business_delivery_takeout_info as rdi "; }
			
			if($filter4 == 'have_coupons'){
			$query_res .= " , restaurant_deals as rdls "; }
			
			$query_res .= "WHERE r.id>0 AND r.restaurant_category = rms.id  ";
			if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
			$query_res .= "   AND  r.id = rdi.restaurant_id "; }
			if($filter4 == 'have_coupons'){
			$query_res .= " AND  r.id = rdls.restaurant_id ";
			}
			
			if( isset($filter1) && $filter1!='' && $filter1 == 'pickup'  )
			{
				$query_res .= " AND rdi.pickup = '1'";   // filter by pickup 
			}
			if( isset($filter2) && $filter2!='' && $filter2 == 'delivery'  )
			{
				$query_res .= " AND rdi.delivery = '1'"; // filter by delivery 
			}
			if( isset($filter3) && $filter3!='' && $filter3 == 'free_delivery'  )
			{
				$query_res .= " AND rdi.delivery = '1' AND  rdi.free_delivery = '1' "; // filter by free delivery 
			}
			
			$query_res .= " AND r.status = '1'";     // search by city
			
			$query_res .= " AND r.featured_status = '1'";
			
			if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
			{
				$query_res .= " ORDER BY r.reviewed DESC"; // order by most popular depends on review 
			}
			elseif( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
			{ 
				$query_res .= " ORDER BY r.rated DESC";  // order by most reviewed depends on rating
			}
			elseif( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
			{
				$query_res .= " ORDER BY r.id DESC";     // order by new 
			}
			else {
				$query_res .= " ORDER BY r.show_order ASC";
			}
		}
		$query_res.=" LIMIT $limitvalue, $limit";
		
		//echo $query_res;
			
$query_products=mysql_query($query_res);

$counter = 1;
while($array_select_restaurant = mysql_fetch_array($query_products)){
$sql_del_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$array_select_restaurant['id']."'"));
?>
<div class="dish_content_one">

<div class="dish_cont_left">
<?php if($array_select_restaurant['restaurant_image']!='') {?>
<img src="uploaded_images/<?php echo $array_select_restaurant['restaurant_image'];?>" width="179" height="109" />
<?php } else { ?>
<img src="images/no_image.png" width="179" height="109" />
<?php } ?>
</div>

<div class="dish_cont_middle">

<h1><?php echo stripslashes($array_select_restaurant['restaurant_name']);?></h1>

<?php 
$rating = '';
$rating = number_format(getRestaurantRating($array_select_restaurant['id']),1); 
?>
<script type="text/javascript" language="javascript">
jQuery(function() {
	jQuery(".stars<?php echo $counter; ?>").each(function() {
		jQuery(this).raty({
			start: jQuery(this).text(),
			readOnly: true,
			score: <?php echo $rating; ?>
		});
	});
});
</script>
<div class="stars<?php echo $counter; ?>"></div>

<?php /*?><ul>
<?php 
$rating = getRestaurantRating($array_select_restaurant['id']); 
?>
<?php
$rem = 5 - $rating;
if($rating == 0)
{
for($i=0; $i<5;$i++){
?>
<li><img width="16" height="15" src="images/star-3.png"></li>
<?php	
}
}
else
{
for($i=0; $i<$rating;$i++){
?>
<li><img width="16" height="16" src="images/star-1.png"></li>
<?php
}
for($j=0;$j<$rem;$j++){
?>
<li><img width="16" height="15" src="images/star-3.png"></li>
<?php
}
}
?>
</ul><?php */?>

<ul>
<?php 
$rating = number_format(getRestaurantRating($array_select_restaurant['id']), 1);
?>
<?php
//echo $one_decimal_place = number_format($rating, 1);
$rat_pt = (explode(".",$rating));
$rat_pt[0];
$rat_pt[1];

$rem = 5 - $rat_pt[0];

if($rating == 0)
{
for($i=0; $i<5;$i++){
?>
<li><img width="16" height="15" src="images/star-3.png"></li>
<?php	
}
}
else
{
if($rat_pt[1]<3 && $rat_pt[1]!=0){
for($i=1; $i<=$rating;$i++){
?>
<li><img width="16" height="16" src="images/star-1.png"></li>
<?php
}
}
else if($rat_pt[1]>7){
for($i=1; $i<=$rating+1;$i++){
?>
<li><img width="16" height="16" src="images/star-1.png"></li>
<?php
}
}
else {
for($i=1; $i<=$rating;$i++){
?>
<li><img width="16" height="16" src="images/star-1.png"></li>
<?php
}
}
if($rat_pt[1]!= '' && $rat_pt[1]>2 && $rat_pt[1]<8){
?>
<li><img width="16" height="15" src="images/star-2.png"></li>
<?php
}
if($rat_pt[1]!= '' && $rat_pt[1]>2 && $rat_pt[1]<=9){
for($j=1;$j<=$rem-1;$j++){
?>
<li><img width="16" height="15" src="images/star-3.png"></li>
<?php
}
}
else {
for($j=1;$j<=$rem;$j++){
?>
<li><img width="16" height="15" src="images/star-3.png"></li>
<?php
}
}
}
?>
</ul>

<h2 style="padding-top:5px;"><?php echo getRestaurantCountRating($array_select_restaurant['id']); ?> Reviews</h2>

<?php if($array_select_restaurant['restaurant_address']!='' ||  $array_select_restaurant['restaurant_city']!='' ||$array_select_restaurant['restaurant_state']!='' ||$array_select_restaurant['restaurant_zipcode']!=''){?>
<p><span style="float:left;"><img src="images/address_pic.png"></span><span style="margin-left:5px; margin-bottom:15px;"><?php echo $array_select_restaurant['restaurant_address']; ?></span></p>
<p style="margin-left:23px; padding-top:0px;"><?php echo $array_select_restaurant['restaurant_city']." ".$array_select_restaurant['restaurant_state']." ".$array_select_restaurant['restaurant_zipcode']; ?></p>
<?php } ?>


</div>

<div class="dish_cont_right">
<?php

$sql_select_add = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$array_select_restaurant['id']."'"));
$address = $sql_select_add['restaurant_address']." ".$sql_select_add['restaurant_city']." ".$sql_select_add['restaurant_state']." ".$sql_select_add['restaurant_zipcode'];

$timezone = getTimezone($address);
							
if($timezone!=''){
	date_default_timezone_set($timezone);
}else{
	date_default_timezone_set('America/Chicago');
}
							
//echo $current_time = '13:00 PM';
$current_time = date('h:i A');

$today = date('l');
/*$timestamp = time(); 
$time =date("G:i:s");
$time1 = strtotime($time);*/
 
/*$del_hours_from = strtotime($sql_del_time['del_hours_from']);
$del_hours_to = strtotime($sql_del_time['del_hours_to']);
$pickup_hours_from = strtotime($sql_del_time['pickup_hours_from']);
$pickup_hours_to = strtotime($sql_del_time['pickup_hours_to']);*/


//echo strtoupper('11:30 am');
$day = strtolower(substr($today,0,3));

echo $time_from = $sql_del_time['business_hours_'.$day.'_from']."<br>";
echo $time_to = $sql_del_time['business_hours_'.$day];

$current_time1 =  DateTime::createFromFormat('H:i A', $current_time);
$time1 =  DateTime::createFromFormat('H:i A', $time_from);
$time2 =  DateTime::createFromFormat('H:i A', $time_to);

//if(($current_time1 > $time1 && $current_time1 < $time2)){ ?>
<?php /*?><a href="restaurant.php?id=<?php echo $array_select_restaurant['id']; ?>"><img src="images/view_more.png" width="130" height="39" class="view_more" /></a>	
<?php }else{ ?>
<a href="restaurant.php?id=<?php echo $array_select_restaurant['id']; ?>"><img src="images/close_right.png" width="130" height="39" class="view_more" alt="restaurant_close" /></a>
<?php } ?><?php */?>

<?php
$sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '".$array_select_restaurant['id']."' AND holiday_date = '".date('Y-m-d')."'");
$restaurant_holiday = '';
while($array_holidays = mysql_fetch_array($sql_holidays)){
	$holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
	$holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);
	
	if($current_time1 > $holiday_from && $current_time1 < $holiday_to){
		$restaurant_holiday = 'close';
	}
}

if($restaurant_holiday!='close'){
	$sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '".strtolower($today)."'"));
	$sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '".$sql_days['id']."' AND restaurant_id = '".$array_select_restaurant['id']."'");
	$restaurant_status = '';
	while($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)){
		$new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
		$new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);
		
		if($current_time1 > $new_from_tm && $current_time1 < $new_to_tm){
			$restaurant_status = 'open';
		}
	}
}else{
	$restaurant_status = '';
}

?>

<?php if($restaurant_status == 'open'){?>
<a href="restaurant.php?id=<?php echo $array_select_restaurant['id']; ?>"><img src="images/view_more.png" width="130" height="39" class="view_more" /></a>
<?php }else{ ?>
<a href="restaurant.php?id=<?php echo $array_select_restaurant['id']; ?>"><img src="images/close_right.png" width="130" height="39" class="view_more" alt="restaurant_close" /></a>
<?php } ?>






<?php /*?><a href="restaurant.php?id=<?php echo $array_select_restaurant['id']; ?>"><img src="images/close_right.png" width="130" height="39" class="view_more" alt="restaurant_close" /></a><?php */?>




</div>

<div class="clear"></div>
</div>
<?php $counter++; } ?>

</div>



<div class="clear"></div>

<div class="pagination">

<div align="center">
<?php if($page!= 1){
$pageprev = $page - 1;
echo '<a href="'.$_SERVER['php_SELF'].'?page='.$pageprev.'&city='.$_REQUEST['city'].'" class="more_link_pagination_prev">PREVIOUS</a>  ';
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
echo '<a href="'.$_SERVER['php_SELF'].'?page='.$i.'&city='.$_REQUEST['city'].'" class="more_link_pagination">'.$i.'</a> ';
}
}

if(($totalrows - ($limit * $page)) > 0){
$pagenext = $page + 1;
echo '  <a href="'.$_SERVER['php_SELF'].'?page='.$pagenext.'&city='.$_REQUEST['city'].'" class="more_link_pagination_prev">NEXT</a>';
}
?>
</div>
</div>

</div>

<div class="clear"></div>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>


<?php include("includes/footer.php");?>