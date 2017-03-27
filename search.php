<?php
session_start();
if (array_key_exists('btn_search', $_GET)) {
unset($_GET['btn_search']);
foreach($_GET as $key => $val)
{
	$qry_string .=$key.'='.$val.'&'; 
}
$qry_string = substr($qry_string,0,-1);
header("location:search.php?".$qry_string);
}

include ("includes/header.php");
include ("includes/functions.php");
//include ("search_compete.php");?>

<script language="javascript">
function showsidetab(id)
{
document.getElementById('fade').style.display="block";
document.getElementById('local_review'+id).style.display="block";
document.getElementById('restrnt_left_panel'+id).style.display="block";
}
function closesidetab(id)
{
document.getElementById('fade').style.display="none";
document.getElementById('local_review'+id).style.display="none";
document.getElementById('restrnt_left_panel'+id).style.display="none";

}

function popularitem()
{
 
document.getElementById('fade').style.display="block";
document.getElementById('popular_item').style.display="block";

}
function closepopularitem()
{
document.getElementById('fade').style.display="none";
document.getElementById('popular_item').style.display="none";

}

</script>
<link rel="stylesheet" media="all" href="css/grubhubcharm_85986.css">
<script src="js/go.js"></script>
<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
<style type="text/css">
.dish_content_one .restrnt_left_panel
   {
	   display:none;
   }
.dish_content_one:hover .restrnt_left_panel
   {
	   display:block !important;
	   cursor:pointer;
   }
   .restrnt_left_panel{width:335px; position:absolute; margin:-183px 0px 0px 400px;}
 /*#pop-up
   {
	   display:none;
   }*/
   
  #fade
    {
		position:fixed;
		height:900px;
		z-index:999;
		background:#df6900;
		opacity:0.5;
		display:none;
	}
	
	.pop_item{position: absolute;margin:0px 207px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999;}
	.reviews_pop{position: absolute;background:#f5f5f5; margin:0px 148px 0px 0px;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;
	z-index:99999999;}
	.reviews_pop h2 img{ float:right;}
	.pop_item h2 img{ float:right;}
</style>

<body data-enhance="true" data-role="diner order" onLoad="init();" >
<!--<div id="fade"></div>-->
<div id="top_div"></div>

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>


<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="main_body_cont">

<?php //include("includes/banner_section.php");?>

<div class="content_container">

<?php include("includes/left_section.php");?>

<div class="body_cont_right">


<div class="clear"></div>
<script type="text/javascript" language="javascript">
	function search_restaurant(sort_order,featured_city,subcatid,filter1,filter2,filter3,filter4)
	{
		location.href="search.php?featured_city="+featured_city+"&sub_cat_id="+subcatid+"&sort_order="+sort_order+"&filter1="+filter1+"&filter2="+filter2+"&filter3="+filter3+"&filter4="+filter4;
	}
	function filter_restaurant(filter1,filter2,filter3,featured_city,subcatid,sort_order,filter4){
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
		location.href="search.php?featured_city="+featured_city+"&sub_cat_id="+subcatid+"&filter1="+pickup+"&filter2="+delivery+"&filter3="+free_delivery+"&sort_order="+sort_order+"&filter4="+have_coupons;
	}
</script>
<?php

$rest_item 	= isset($_REQUEST['rest_item']) ? strtolower(mysql_real_escape_string(trim($_REQUEST['rest_item']))) : '' ; 
$featured_city= isset($_REQUEST['featured_city']) ? strtolower(trim($_REQUEST['featured_city'])) : ''; 
$sub_cat_id   = isset($_REQUEST['sub_cat_id']) ? strtolower(trim($_REQUEST['sub_cat_id'])) : ''; 
$sort_order   = isset($_REQUEST['sort_order']) ? strtolower(trim($_REQUEST['sort_order'])) : '';
$filter1   = isset($_REQUEST['filter1']) ? strtolower(trim($_REQUEST['filter1'])) : '';
$filter2   = isset($_REQUEST['filter2']) ? strtolower(trim($_REQUEST['filter2'])) : '';
$filter3   = isset($_REQUEST['filter3']) ? strtolower(trim($_REQUEST['filter3'])) : '';
$filter4   = isset($_REQUEST['filter4']) ? strtolower(trim($_REQUEST['filter4'])) : '';

//rest_item=&city=&sub_cat_id=1&sort_order=most-popular

//$search_arr = searchRestaurant($rest_item, $city);

$restaurant = array();
if($rest_item!='' || $featured_city!='' || $sub_cat_id!=''){ 
//////////////////////start pagination/////////////////////////
$limit = 20;
$start = 1;
$slice = 3;

$sql = "SELECT DISTINCT(r.id), r.restaurant_name, r.restaurant_address, r.restaurant_city, r.restaurant_state, r.restaurant_zipcode, r.restaurant_image, r.restaurant_category, r.latitude, r.longitude ,r.show_order  ";

if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
$sql .= " ,rdi.pickup ,rdi.delivery, rdi.delivery_charge, rdi.restaurant_id "; } 

if($filter4 == 'have_coupons'){
$sql .= " ,rdls.restaurant_name ";	
}

$sql .= " FROM restaurant_basic_info as r, restaurant_category as rms "; 

if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
$sql .= " , restaurant_business_delivery_takeout_info as rdi "; }

if($filter4 == 'have_coupons'){
$sql .= " , restaurant_deals as rdls "; }

if($_REQUEST['rest_item']!=''){
$sql .= "WHERE r.id>0 AND find_in_set(rms.id,r.restaurant_category) ";
if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
$sql .= " AND  r.id = rdi.restaurant_id "; }
if($filter4 == 'have_coupons'){
$sql .= " AND  r.id = rdls.restaurant_id ";
}
}
else {
$sql .= "WHERE r.id>0 AND r.restaurant_category = rms.id  ";
if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
$sql .= "   AND  r.id = rdi.restaurant_id "; }
if($filter4 == 'have_coupons'){
$sql .= " AND  r.id = rdls.restaurant_id ";
}
}

if( isset($rest_item) && $rest_item!='' )
{
	$sql .= "AND( ";
	$sql .= "r.restaurant_name LIKE '%".$rest_item."%' ";     	  // search by restaurant name
	$sql .= "OR rms.category_name LIKE '%".$rest_item."%' ";   // search by cousins
	$sql .= " ) ";
}

if(isset($sub_cat_id) && $sub_cat_id!='')
{
	$sql .= "AND find_in_set(".$sub_cat_id.",r.restaurant_category)";  //= '".$sub_cat_id."' ";
}

if( isset($featured_city) && $featured_city!='' )
{
	$sql .= "AND ( r.restaurant_city = '".$featured_city."')";     // search by city
}
if(isset($_COOKIE['resCity'])){
	$sql .= "AND ( r.restaurant_city = '".$_COOKIE['resCity']."')";     // search by city
}
if(isset($_COOKIE['reszip'])){
	$sql.= " AND restaurant_zipcode = '".$_COOKIE['reszip']."'";      // search by zipcode
}
if( isset($filter1) && $filter1!='' && $filter1 == 'pickup'  )
{
	$sql .= " AND rdi.pickup = '1'";   // filter by pickup 
}
if( isset($filter2) && $filter2!='' && $filter2 == 'delivery'  )
{
	$sql .= " AND rdi.delivery = '1'"; // filter by delivery 
}
if( isset($filter3) && $filter3!='' && $filter3 == 'free_delivery'  )
{
	$sql .= " AND rdi.delivery = '1' AND rdi.free_delivery = '1' "; // filter by free delivery 
}

$sql .= "AND r.status = '1' AND r.featured_status=1 ";     // 

if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
{
	$sql .= " ORDER BY r.reviewed DESC"; // order by most popular depends on review 
}
else if( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
{ 
	$sql .= " ORDER BY r.rated DESC";  // order by most reviewed depends on rating
}
else if( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
{
	$sql .= " ORDER BY r.id DESC";     // order by new 
}
else {
	$sql .= " ORDER BY r.show_order ASC";
}

//echo $sql;
$r = mysql_query($sql);
$totalrows = mysql_num_rows($r);

if(!isset($_GET['page'])){
$page = 1;
} else {
$page = $_GET['page'];
}

$numofpages = ceil($totalrows / $limit);
$limitvalue = $page * $limit - ($limit);
		  
$sql = "SELECT DISTINCT(r.id), r.restaurant_name, r.restaurant_address, r.restaurant_city, r.restaurant_state, r.restaurant_zipcode, r.restaurant_image, r.restaurant_category, r.latitude, r.longitude ,r.show_order  ";

if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
$sql .= " ,rdi.pickup ,rdi.delivery, rdi.delivery_charge, rdi.restaurant_id "; } 

if($filter4 == 'have_coupons'){
$sql .= " ,rdls.restaurant_name ";	
}

$sql .= " FROM restaurant_basic_info as r, restaurant_category as rms "; 

if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
$sql .= " , restaurant_business_delivery_takeout_info as rdi "; }

if($filter4 == 'have_coupons'){
$sql .= " , restaurant_deals as rdls "; }

if($_REQUEST['rest_item']!=''){
$sql .= "WHERE r.id>0 AND find_in_set(rms.id,r.restaurant_category) ";
if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
$sql .= " AND  r.id = rdi.restaurant_id "; }
if($filter4 == 'have_coupons'){
$sql .= " AND  r.id = rdls.restaurant_id ";
}
}
else {
$sql .= "WHERE r.id>0 AND r.restaurant_category = rms.id  ";
if($filter1 == 'pickup' || $filter2 == 'delivery' || $filter3 == 'free_delivery'){
$sql .= "   AND  r.id = rdi.restaurant_id "; }
if($filter4 == 'have_coupons'){
$sql .= " AND  r.id = rdls.restaurant_id ";
}
}

if( isset($rest_item) && $rest_item!='' )
{
	$sql .= "AND( ";
	$sql .= "r.restaurant_name LIKE '%".$rest_item."%' ";     	  // search by restaurant name
	$sql .= "OR rms.category_name LIKE '%".$rest_item."%' ";   // search by cousins
	$sql .= " ) ";
}

if(isset($sub_cat_id) && $sub_cat_id!='')
{
	$sql .= "AND find_in_set(".$sub_cat_id.",r.restaurant_category)";  //= '".$sub_cat_id."' ";
}

if( isset($featured_city) && $featured_city!='' )
{
	$sql .= "AND ( r.restaurant_city = '".$featured_city."')";     // search by city
}
if(isset($_COOKIE['resCity'])){
	$sql .= "AND ( r.restaurant_city = '".$_COOKIE['resCity']."')";     // search by city
}
if(isset($_COOKIE['reszip'])){
	$sql.= " AND restaurant_zipcode = '".$_COOKIE['reszip']."'"; 		// search by zipcode
}
if( isset($filter1) && $filter1!='' && $filter1 == 'pickup'  )
{
	$sql .= " AND rdi.pickup = '1'";   // filter by pickup 
}
if( isset($filter2) && $filter2!='' && $filter2 == 'delivery'  )
{
	$sql .= " AND rdi.delivery = '1'"; // filter by delivery 
}
if( isset($filter3) && $filter3!='' && $filter3 == 'free_delivery'  )
{
	$sql .= " AND rdi.delivery = '1' AND rdi.free_delivery = '1' "; // filter by free delivery 
}

$sql .= "AND r.status = '1' AND r.featured_status=1 ";     // search by city

if( isset($sort_order) && $sort_order!='' && $sort_order =='most-popular'  )
{
	$sql .= " ORDER BY r.reviewed DESC"; // order by most popular depends on review 
}
else if( isset($sort_order) && $sort_order!='' && $sort_order =='top-rated'  )
{ 
	$sql .= " ORDER BY r.rated DESC";  // order by most reviewed depends on rating
}
else if( isset($sort_order) && $sort_order!='' && $sort_order =='new'  )
{
	$sql .= " ORDER BY r.id DESC";     // order by new 
}
else{
	$sql .= " ORDER BY r.show_order";
}

	$sql.=" LIMIT $limitvalue, $limit";
//echo $sql;
$qry=mysql_query($sql);
////////////////////////////////End pagination////////////////////////////////////

//echo $total_pages;
//echo $sql;
//$qry = mysql_query($sql);
//echo mysql_num_rows($qry);
$i= 0;
while($result = mysql_fetch_array($qry))
{	
	$restaurant[$i]['id'] = $result['id'];
	$restaurant[$i]['restaurant_name'] = $result['restaurant_name'];
	$restaurant[$i]['restaurant_image'] = $result['restaurant_image'];
	$restaurant[$i]['latitude'] = $result['latitude'];
	$restaurant[$i]['longitude'] = $result['longitude'];
	$restaurant[$i]['restaurant_address'] = $result['restaurant_address'];
	$restaurant[$i]['restaurant_city'] = $result['restaurant_city'];
	$restaurant[$i]['restaurant_state'] = $result['restaurant_state'];
	$restaurant[$i]['restaurant_zipcode'] = $result['restaurant_zipcode'];
	
	$i++;
}
}
?>
<?php //echo $sql; exit; ?>

<div class="dish_content_select_box">
<input type="checkbox" name="checkbox1" id="checkbox1" value="pickup" <?php if($_REQUEST['filter1'] == 'pickup') {?> checked = "checked" <?php } ?> onClick="filter_restaurant(this.value,'<?php echo $_GET[filter2]?>','<?php echo $_GET[filter3]?>','<?php echo $_GET[featured_city]?>','<?php echo $_GET[sub_cat_id]?>','<?php echo $_GET['sort_order'];?>','<?php echo $_GET[filter4];?>');">&nbsp;<span style="margin-right:22px;">Pickup</span>

<input type="checkbox" name="checkbox2" id="checkbox2" value="delivery" <?php if($_REQUEST['filter2'] == 'delivery') {?> checked = "checked" <?php } ?> onClick="filter_restaurant('<?php echo $_GET[filter1]?>',this.value,'<?php echo $_GET[filter3]?>','<?php echo $_GET[featured_city]?>','<?php echo $_GET[sub_cat_id]?>','<?php echo $_GET['sort_order'];?>','<?php echo $_GET[filter4];?>');">&nbsp;<span style="margin-right:22px;">Delivery</span>

<input type="checkbox" name="checkbox3" id="checkbox3" value="free_delivery" <?php if($_REQUEST['filter3'] == 'free_delivery') {?> checked = "checked" <?php } ?> onClick="filter_restaurant('<?php echo $_GET[filter1]?>','<?php echo $_GET[filter2]?>',this.value,'<?php echo $_GET[featured_city]?>','<?php echo $_GET[sub_cat_id]?>','<?php echo $_GET['sort_order'];?>','<?php echo $_GET[filter4];?>');">&nbsp;<span style="margin-right:22px;">Free Delivery</span>

<input type="checkbox" name="checkbox4" id="checkbox4" value="have_coupons" <?php if($_REQUEST['filter4'] == 'have_coupons') {?> checked = "checked" <?php } ?> onClick="filter_restaurant('<?php echo $_GET[filter1]?>','<?php echo $_GET[filter2]?>','<?php echo $_GET[filter3];?>','<?php echo $_GET[featured_city]?>','<?php echo $_GET[sub_cat_id]?>','<?php echo $_GET['sort_order'];?>',this.value);">&nbsp;<span>Have Coupons</span>

<select name="sorting_order" id="sorting_order" class="dish_select_box" onChange='search_restaurant(this.value,"<?php echo $_GET[featured_city]?>","<?php echo $_GET[sub_cat_id]?>","<?php echo $_GET[filter1];?>","<?php echo $_GET[filter2];?>","<?php echo $_GET[filter3];?>","<?php echo $_GET[filter4];?>");'>
<option class="dish_select_text">- Select Category -</option>
<option value="most-popular" <?php echo ($_GET['sort_order'] == 'most-popular')?'selected="selected"':'' ?> class="dish_select_text">Most Popular</option>
<option value="top-rated" <?php echo ($_GET['sort_order'] == 'top-rated')?'selected="selected"':'' ?> class="dish_select_text">Top Rated</option>
<option value="new" <?php echo ($_GET['sort_order'] == 'new')?'selected="selected"':'' ?> class="dish_select_text">New Restaurants</option>
</select>
<div class="clear"></div>
</div>

<?php if(!empty($restaurant)) { ?>
<div class="restrnt_middle_panel">
<div id="panel_middle">


<div id="wrapper" data-order-context-container="true" class="container_24 paperBackground">
      
      
      
      
      <div data-role="search" class="search container alpha paperBackground" >
        
        
        
        
      
      <div class="grid_15 fullResultsList contents" data-component="search-contents">
        <h2 data-component="search-summary" class="search-summary site_h1 summary">
          
          
        </h2>
        
        <div data-component="search-controls" class="controls searchcontrols" style="">
          
          
        </div>
        
        
        
        
        
        <div style="padding-bottom: 606px;" data-component="search-results" class="searchresults results" data-more-results-per-pull="20" >
        
        <div style="display: none;" data-component="searchresults-pointer" class="searchresults-pointer pointer">
        
        <div class="infoHolder" id="infoHolder" >
        
        <div class="info selectionInfo selectioninfo cachingdisplay" data-component="search-selectioninfo">
          <div class="current grid_8 omega">
                    <div id="restrnt_left_panel83" class="restrnt_left_panel">
                    
                    
            		</div>
          </div>
        </div>
        
      	</div>
        
        
        
        </div>

        <ul data-wire="arrowedlistarrowing:searchresults.arrow" data-component="searchresults-list" class="searchresults-list list arrowedlist">
        
<?php foreach($restaurant as $rest_key=>$rest_val){
$sql_del_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$rest_val['id']."'"));
$timestamp = time(); 
$time =date("G:i:s");
$time1 = strtotime($time);
 
$del_hours_from = strtotime($sql_del_time['del_hours_from']);
$del_hours_to = strtotime($sql_del_time['del_hours_to']);
$pickup_hours_from = strtotime($sql_del_time['pickup_hours_from']);
$pickup_hours_to = strtotime($sql_del_time['pickup_hours_to']);

?>

<li class="" data-restaurant-id="808588" data-search-position="0" id="<?php echo $rest_val['id']; ?>" > 
 
	<div class="dish_content_one" id="dish_contnt_box">
<!-- review pop up--------------------->
<div class="reviews_pop" style="display:none;" id="local_review<?php echo $rest_val['id']; ?>">
                    <h2><?php echo stripslashes($rest_val['restaurant_name']); ?><a href="Javascript:void(0);" onClick="closesidetab(<?php echo $rest_val['id']; ?>)"><img src="images/cross.png" width="22" height="22" /></a></h2>
                    <?php $sql_select = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$rest_val['id']."'");
					while($array_select = mysql_fetch_array($sql_select)){ ?>
                    <div class="pop_commnt"><?php echo $array_select['customer_review']; ?><p><?php echo $array_select['customer_name']; ?></p></div>
                    <?php } ?>
               </div>
<!-- end of review pop up------------->

<!---- popular popup item--------------->

<!----end of popular pop up item----------->
<div class="dish_cont_left">
<?php if($rest_val['restaurant_image']!=''){?>
<a href="restaurant.php?id=<?php echo $rest_val['id']; ?>"><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/thumb_images/".$rest_val['restaurant_image']; ?>" width="179" height="109" /></a>
<?php } else { ?>
<a href="restaurant.php?id=<?php echo $rest_val['id']; ?>"><img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/images/no_image.png" ?>" width="179" height="109" /></a>
<?php } ?>

<div id="dsh_cntnt_lft">
<?php if($del_hours_from!='' && $del_hours_to!='' && $pickup_hours_from!='' && $pickup_hours_to!=''){
	if(($time1 >$del_hours_from  && $time1 <$del_hours_to) || ($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){
	?>
    <a href="restaurant.php?id=<?php echo $rest_val['id']; ?>"><img src="images/view_more.png" width="130" height="39" class="view_more" /></a>
    <?php	
	}else { ?>
	<img src="images/close_right.png" width="130" height="39" class="view_more" alt="restaurant_close" />	
<?php }
}else {?>
<a href="restaurant.php?id=<?php echo $rest_val['id']; ?>"><img src="images/view_more.png" width="130" height="39" class="view_more" /></a>
<?php }?>

</div>



</div>

<div class="dish_cont_middle" id="dish_contnt_descrptn">

<h1><?php echo stripslashes($rest_val['restaurant_name']); ?></h1>
<ul>
<?php 
$rating = number_format(getRestaurantRating($rest_val['id']), 1);
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
<h2><?php echo getRestaurantCountRating($rest_val['id']); ?> Reviews</h2>

<?php if($rest_val['restaurant_address']!='' ||  $rest_val['restaurant_city']!='' ||$rest_val['restaurant_state']!='' ||$rest_val['restaurant_zipcode']!=''){?>
<p><img src="images/address_pic.png"><span style="margin-left:5px;"><?php echo $rest_val['restaurant_address']; ?></span></p>
<p style="margin-left:23px; padding-top:0px;"><?php echo $rest_val['restaurant_city']." ".$rest_val['restaurant_state']." ".$rest_val['restaurant_zipcode']; ?></p>
<?php } ?>

</div>





<div class="clear"></div>

	<!-----------------------hover ------------------------------------------>
                    <?php /*?><div id="restrnt_left_panel<?php echo $rest_val['id']; ?>" class="restrnt_left_panel">
                    
                    <div class="popup_icon"></div>
                    
                    <div class="restrnt_left_panel_box" id="pop-up">
        
        			<h2><?php echo stripslashes($rest_val['restaurant_name']); ?></h2>
                    
                    <?php $sql_get_additional_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$rest_val['id']."'")); ?>
                    <?php if($sql_get_additional_info['pickup'] == 1){?>
                    <div class="rstrnt_pckup">
                    <p>Pickup Available</p>
                    </div>
                    <?php } ?>
                    
                    <div class="rstrnt_reviews_rtngs">
                    <div>
                    
                    <div class="rstrnt_rtngs">
					<?php 
                    $rating = number_format(getRestaurantRating($rest_val['id']), 1);
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
                    <img width="16" height="15" src="images/star-3.png">
                    <?php	
                    }
                    }
                    else
                    {
                    if($rat_pt[1]<3 && $rat_pt[1]!=0){
                    for($i=1; $i<=$rating;$i++){
                    ?>
                    <img width="16" height="16" src="images/star-1.png">
                    <?php
                    }
                    }
                    else if($rat_pt[1]>7){
                    for($i=1; $i<=$rating+1;$i++){
                    ?>
                    <img width="16" height="16" src="images/star-1.png">
                    <?php
                    }
                    }
                    else {
                    for($i=1; $i<=$rating;$i++){
                    ?>
                    <img width="16" height="16" src="images/star-1.png">
                    <?php
                    }
                    }
                    if($rat_pt[1]!= '' && $rat_pt[1]>2 && $rat_pt[1]<8){
                    ?>
                    <img width="16" height="15" src="images/star-2.png">
                    <?php
                    }
                    if($rat_pt[1]!= '' && $rat_pt[1]>2 && $rat_pt[1]<8){
                    for($j=1;$j<=$rem-1;$j++){
                    ?>
                    <img width="16" height="15" src="images/star-3.png">
                    <?php
                    }
                    }
                    else {
                    for($j=1;$j<=$rem;$j++){
                    ?>
                    <img width="16" height="15" src="images/star-3.png">
                    <?php
                    }
                    }
                    }
                    ?>
                            
                      </div>
                      
                      <div class="clear"></div>
                      </div>
                      
                      
                      <div>
                      <h2 class="local_reviews">
                        <?php $total_reviews = getRestaurantCountRating($rest_val['id']); ?>
						<?php if($total_reviews!= 0){ ?> <a href="#top_div" onClick="showsidetab(<?php echo $rest_val['id']; ?>)" ><?php echo getRestaurantCountRating($rest_val['id']); ?> Reviews </a>
                        <?php } ?>
                       </h2>
                      
                   		
                      </div>
                    
                    
                    		<div class="clear"></div>
                    
                    </div>
                    
                    <div class="rstrnt_reviews_rtngs">
                            <h2>Popular Items <img src="images/star_ratng.png" alt="Popular item"></h2>
                            	<div class="rstrnt_itms" style="width:234px;">
                                <?php $sql_pop_items = mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '".$rest_val['id']."' AND purchased!=0 ORDER BY purchased DESC LIMIT 0,5");
								if(mysql_num_rows($sql_pop_items)>0){
									while($array_pop_item = mysql_fetch_array($sql_pop_items)){?>
                                <ul>
                                	<li><div class="new_search"><div style="width:150px; float:left;"><a href="Javascript:void(0);" style="cursor:default;"><?php echo $array_pop_item['menu_name'];?></div><span style="float:right; width:46px; color:#F17B05;"><?php echo "$ ".$array_pop_item['price']; ?></span></a></div></li>
                                </ul>
                                <div class="clear"></div>
                                <?php } } else { ?>
                                There are no popular items yet. Give it a try and let us know what you think.
                                <?php } ?>
                                <div class="clear"></div>
                                </div>
                            
                    </div>
        
        </div>
        <div class="clear"></div>
        <?php  if($del_hours_from!='' && $del_hours_to!='' && $pickup_hours_from!='' && $pickup_hours_to!=''){
			if(($time1 >$del_hours_from  && $time1 <$del_hours_to) || ($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){ ?>
              <div class="saw_order">
                <a href="restaurant.php?id=<?php echo $rest_val['id']; ?>">See Menu and Order Online</a>
              </div>
            <?php } } else{ ?> 
            <div class="saw_order">
            	<a href="restaurant.php?id=<?php echo $rest_val['id']; ?>">See Menu and Order Online</a>
            </div>
        <?php } ?>
		</div><?php */?>

		<!-----------------------hover ------------------------------------------>

</div>

</li>
        
<?php } ?>   
    
        <?php /*?><li class="" data-restaurant-id="280458" data-search-position="1" id="2" >
        <div class="dish_content_one" id="dish_contnt_box">
        <!-- review pop up--------------------->
        <div class="reviews_pop" style="display:none;" id="local_review769">
        <h2>test restaurant<a href="Javascript:void(0);" onClick="closesidetab(769)"><img src="images/cross.png" width="22" height="22" /></a></h2>
                    <div class="pop_commnt">Test Review<p>Priya</p></div>
               </div>
        <!-- end of review pop up------------->
        
        <!---- popular popup item--------------->
        
        
                
        <!----end of popular pop up item----------->
        <div class="dish_cont_left">
        <img src="http://10.10.10.144/priya/restaurant/thumb_images/1382184798images (1).jpg" width="179" height="109" />
        </div>
        
        <div class="dish_cont_middle" id="dish_contnt_descrptn">
        
        <h1>test restaurant</h1>
        <ul>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        <li><img width="16" height="15" src="images/star-3.png"></li>
        </ul>
        <h2>1 Reviews</h2>
        
        </div>
        
        <div id="dsh_cntnt_lft"> 
        
        <a href="restaurant.php?id=769"><img src="images/view_more.png" width="130" height="39" class="view_more" /></a>
        
        </div>
        
        <div class="clear"></div>
        
        
        
        </div>
        </li>
        
        <li class="" data-restaurant-id="74263" data-search-position="2" id="3" >
        <div class="dish_content_one" id="dish_contnt_box">
        <!-- review pop up--------------------->
        <div class="reviews_pop" style="display:none;" id="local_review233">
        <h2>Nanami Sushi Bar & Grill<a href="Javascript:void(0);" onClick="closesidetab(233)"><img src="images/cross.png" width="22" height="22" /></a></h2>
                    <div class="pop_commnt">test<p>Priya</p></div>
               </div>
        <!-- end of review pop up------------->
        
        <!---- popular popup item--------------->
        
        
                
        <!----end of popular pop up item----------->
        <div class="dish_cont_left">
        <img src="http://10.10.10.144/priya/restaurant/thumb_images/1374263909nanami.jpg" width="179" height="109" />
        </div>
        
        <div class="dish_cont_middle" id="dish_contnt_descrptn">
        
        <h1>Nanami Sushi Bar & Grill</h1>
        <ul>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        <li><img width="16" height="16" src="images/star-1.png"></li>
        </ul>
        <h2>1 Reviews</h2>
        
        </div>
        
        <div id="dsh_cntnt_lft"> 
        
        <a href="restaurant.php?id=233"><img src="images/view_more.png" width="130" height="39" class="view_more" /></a>
        
        </div>
        
        <div class="clear"></div>
        
        
        <!-----------------------hover ------------------------------------------>
        
        
        <!-----------------------hover ------------------------------------------>
        
        
        </div>
        </li><?php */?>
        </ul>
        
       </div> 
          
      </div>
      
      <div style="display: none;" class="menu cachingdisplay" data-component="search-menu">
        <div class="current grid_15 alpha">
        </div>
      </div>
      
      <div style="display: block;" class="hintInfo grid_9 current hint" data-component="search-hint">
        
        
        
        <div class="greenArrow">
        </div>
        
        
      </div>
      
      
      
      <div style="display: none;" class="info orderingInfo orderinginfo cachingdisplay" data-component="search-orderinginfo">
        <div class="current grid_9 omega">
        </div>
      </div>
  </div>
  </div>

</div>

</div>

<?php }else{ echo '<div class="dish_content_one" style="text-align:center; padding-top:10px; padding-bottom:10px; font-family: Arial,Helvetica,sans-serif;background-color:#FF9393; color:#FFF;">No result found. Search again.</div>'; }?>

</div>


<div class="clear"></div>

<div class="pagination">

<div align="center">

<?php 
if($totalrows>0){
if($page!= 1){
$pageprev = $page - 1;
echo '<a href="'.$_SERVER['php_SELF'].'?page='.$pageprev.'&rest_item='.$_REQUEST['rest_item'].'&featured_city='.$_REQUEST['featured_city'].'&sub_cat_id='.$_REQUEST['sub_cat_id'].'&sort_order='.$_REQUEST['sort_order'].'&filter1='.$_REQUEST['filter1'].'&filter2='.$_REQUEST['filter2'].'&filter3='.$_REQUEST['filter3'].'" class="more_link_pagination_prev">PREVIOUS</a>  ';
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
echo '<a href="'.$_SERVER['php_SELF'].'?page='.$i.'&rest_item='.$_REQUEST['rest_item'].'&featured_city='.$_REQUEST['featured_city'].'&sub_cat_id='.$_REQUEST['sub_cat_id'].'&sort_order='.$_REQUEST['sort_order'].'&filter1='.$_REQUEST['filter1'].'&filter2='.$_REQUEST['filter2'].'&filter3='.$_REQUEST['filter3'].'" class="more_link_pagination">'.$i.'</a> ';
}
}

if(($totalrows - ($limit * $page)) > 0){
$pagenext = $page + 1;
echo '  <a href="'.$_SERVER['php_SELF'].'?page='.$pagenext.'&rest_item='.$_REQUEST['rest_item'].'&featured_city='.$_REQUEST['featured_city'].'&sub_cat_id='.$_REQUEST['sub_cat_id'].'&sort_order='.$_REQUEST['sort_order'].'&filter1='.$_REQUEST['filter1'].'&filter2='.$_REQUEST['filter2'].'&filter3='.$_REQUEST['filter3'].'" class="more_link_pagination_prev">NEXT</a>';
}
}
?>

</div>
</div>

</div>

<div class="clear"></div>
</div>

</div>



<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>
</div>
<div class="clear"></div>
<script type="text/javascript" src="js/grubhubcat_charm_85986.js">


<?php include("includes/footer_search.php");?>