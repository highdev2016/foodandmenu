<?php 
ob_start();
session_start();

$session_id = session_id();
$_SESSION['cart_rest_id'] = $_REQUEST['id'];

//print_r($_SESSION);
include('admin/lib/conn.php');
include("includes/rest_header.php");
include("includes/functions.php");
//include("search_compete.php");

//echo getRestaurantRating($_REQUEST['id']);
?>
<?php 
/*if($_REQUEST['order'] == 'cancel'){
	mysql_query("DELETE FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_REQUEST['id']."'");
	header("location:restaurant.php?id=".$_REQUEST['id']."");
}*/

if($_REQUEST['sub'] == 'sub'){
	$sql_select_item = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE id = '".$_REQUEST['cart_id']."'"));
	if($sql_select_item['quantity'] == 1){
		mysql_query("DELETE FROM restaurant_menuitem_cart WHERE id = '".$_REQUEST['cart_id']."'");
	}
	else {
		mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity-1 WHERE id = '".$_REQUEST['cart_id']."'"); }
		header("location:restaurant.php?id=".$_REQUEST['id']."#tab");
}
if($_REQUEST['add'] == 'add'){
	mysql_query("UPDATE restaurant_menuitem_cart SET quantity = quantity+1 WHERE id = '".$_REQUEST['cart_id']."'");	
	header("location:restaurant.php?id=".$_REQUEST['id']."#tab");
}

$sql_del_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['id']."'"));

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);
  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

if($_REQUEST['submit'] == 'VERIFY ADDRESS'){
	$i = $_REQUEST['menu_id'];
	
	$address = $_REQUEST['address'.$i];
	if($address!=''){
	$myaddress = urlencode($address);
	//here is the google api url
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$myaddress&sensor=false";
	//get the content from the api using file_get_contents
	$getmap = file_get_contents($url); 
	//the result is in json format. To decode it use json_decode
	$googlemap = json_decode($getmap);
	//get the latitute, longitude from the json result by doing a for loop
	foreach($googlemap->results as $res){
		$address = $res->geometry;
		$latlng = $address->location;
		$formattedaddress = $res->formatted_address;
	}
	}
	
	$user_add_lat = $latlng->lat;
	$user_add_long = $latlng->lng;
	
/*	$user_add_lat = 11;
	$user_add_long = 11;*/
	
	$array_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['restaurant_id'.$i]."'"));
	$rest_add_lat = $array_basic_info['latitude'];
	$rest_add_lng = $array_basic_info['longitude'];
	
	$distance_in_miles = distance($user_add_lat, $user_add_long, $rest_add_lat, $rest_add_lng, "M");
	$distance = round($distance_in_miles,2);
	
	//echo $distance; exit;
	
	//$distance = 25.22;
	
	//$distance_in_miles = distance(30.3640626,-97.6838601,30.2399151,-97.7530534, "M");
	//$distance_in_miles = 5;
	
	$rest_del_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['restaurant_id'.$i]."'"));
	
	if($distance == 0){
		$error_msg1 = 1;
	}
	else {
		$sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '".$_REQUEST['id']."'");
		while($array_del_charge = mysql_fetch_array($sql_del_crge)){
			if($distance <= $array_del_charge['delivery_range']){
				$_SESSION['del_charge'] = $array_del_charge['delivery_charge'];
				break;
			}
		}
		
		$sql_del_charge = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '".$_REQUEST['id']."' ORDER BY delivery_range DESC LIMIT 0,1"));
		
	if($distance <= $sql_del_charge['delivery_range']){
		
		
		if($sql_del_details['delivery'] == 1 || $sql_del_details['pickup'] == 1){
		
	$sql_spcl_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$i."'");
	$spl_price = 0;
	$sep = '';
	$spl_ins = '';
	while($array_spcl_ins = mysql_fetch_array($sql_spcl_ins)){
		$spl_ins = $spl_ins;
		if($_REQUEST['radio'.$i.'_'.$array_spcl_ins['id']]!=''){
		$spl_ins.= $sep.$_REQUEST['radio'.$i.'_'.$array_spcl_ins['id']]; }
		$sep = ',';
		$sql_spl_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$_REQUEST['radio'.$i.'_'.$array_spcl_ins['id']]."'"));
		$spl_price = $sql_spl_price['price'] + $spl_price;
	}
	
	$total_price = $spl_price + $_REQUEST['menu_price'.$i];
	
	$sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."'");
	$num_rows = mysql_num_rows($sql_select_cart_items);
	//if($num_rows == 0){
	
	$tax = ($sql_del_details['tax']/100 * $total_price);
	$sql_insert_into_cart = "INSERT INTO restaurant_menuitem_cart SET menu_item_id = '".$_REQUEST['menu_id']."',session_id = '".$session_id."',restaurant_id = '".$_REQUEST['restaurant_id'.$i]."',quantity = '".$_REQUEST['quantity'.$i]."',special_ins = '".$_REQUEST['special_instructions'.$i]."',menu_price = '".$_REQUEST['menu_price'.$i]."', price = '".$total_price."', additional_instructions = '".$spl_ins."',tax = '".$tax."'";
		
	mysql_query($sql_insert_into_cart);
	
	$error_msg1 = 2;
	}
			else{
				$error_msg1 = 4;
			}
		}else{
			
			$error_msg1 = 3;
		}
	}
	header("location:restaurant.php?id=".$_REQUEST['id']."&error_msg=$error_msg1");
}


if($_REQUEST['add'] == 'ADD ITEM'){
	$i = $_REQUEST['menu_id'];
	$sql_spcl_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$i."'");
	$spl_price = 0;
	$sep = '';
	$spl_ins = '';
	while($array_spcl_ins = mysql_fetch_array($sql_spcl_ins)){
		$spl_ins = $spl_ins;
		if($_REQUEST['radio'.$i.'_'.$array_spcl_ins['id']]!=''){
		$spl_ins.= $sep.$_REQUEST['radio'.$i.'_'.$array_spcl_ins['id']]; }
		$sep = ',';
		$sql_spl_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$_REQUEST['radio'.$i.'_'.$array_spcl_ins['id']]."'"));
		$spl_price = $sql_spl_price['price'] + $spl_price;
		
	}
	//echo $spl_ins; exit;
		
	$total_price = $spl_price + $_REQUEST['menu_price'.$i];
	
	$sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."'");
	$num_rows = mysql_num_rows($sql_select_cart_items);
	//if($num_rows == 0){
	$tax = ($sql_del_details['tax']/100 * $total_price);
	$sql_insert_into_cart = "INSERT INTO restaurant_menuitem_cart SET menu_item_id = '".$_REQUEST['menu_id']."',session_id = '".$session_id."',restaurant_id = '".$_REQUEST['restaurant_id'.$i]."',quantity = '".$_REQUEST['quantity'.$i]."',special_ins = '".$_REQUEST['special_instructions'.$i]."' , menu_price = '".$_REQUEST['menu_price'.$i]."' , price = '".$total_price."' , additional_instructions = '".$spl_ins."',tax = '".$tax."'";
	
	mysql_query($sql_insert_into_cart);
	
	$error_msg1 = 2;
	header("location:restaurant.php?id=".$_REQUEST['id']."&error_msg=$error_msg1");
}
?>

<style type="text/css">
#fade11{
	width: 100%;
	height: 800px;
	position: fixed;
	z-index: 50;
	background: rgb(223, 105, 0);
	opacity: 0.5;
}
</style>

<body onLoad="init();">

<?php if($_REQUEST['error_msg']!=''){ $display = 'block'; } else { $display = 'none'; }?> 

<div id="fade11" style="display:<?php echo $display; ?>"></div>

<div style="width:400px; height:1px; margin:0 auto; display:<?php echo $display;?>" id="light">
<div  style="width:300px; position:absolute; z-index:9999999; background:#fff; padding:50px 20px; color:#000; font-family:Calibri; font-size:18px; height:100px; -moz-box-shadow: 0 0 5px #888;
-webkit-box-shadow: 0 0 5px#888;
box-shadow: 0 0 5px #888; text-align:center; margin-top:200px;">
<?php 
if(($_REQUEST['error_msg'] == 1) || ($_REQUEST['error_msg'] == 3) || ($_REQUEST['error_msg'] == 4)){
	$style = 'margin-left: 293px; position: absolute; margin-top: -60px; cursor:pointer;';
}
else if($_REQUEST['error_msg'] == 2){
	$style = 'margin-left: 272px; position: absolute; margin-top: -60px; cursor:pointer;';
}
?>

<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade11').style.display='none';document.getElementById('fade').style.display='none'"><img src="images/fancy_closebox.png" style="<?php echo $style; ?>"/></a>
<?php if($_REQUEST['error_msg'] == 1){ echo "We cannot locate you.Please be more specific."; }
else if($_REQUEST['error_msg'] == 2){ echo "Items successfully added to cart"; }
else if($_REQUEST['error_msg'] == 3){ echo "Your address is not within our delivery range"; }
else if($_REQUEST['error_msg'] == 4){ echo "This restaurant does not give pickup or delivery"; } ?>               
</div></div>

<style>
#login-poup-area{width:620px; background-color:#EFEFEF; position:fixed; z-index:99999900; top:60px; height:420px; border-radius:7px;}.newpopup h3{color:#fff;padding:15px 0; background-color:#060606; text-align:center; width:100%; border-radius:7px 7px 0 0; font-size:18px;}.newpopup p{color:#000; font:bold 13px/26px 'droid_sansregular';padding-left:10px; margin:5px 10px;}.login_cross_bt{width:21px;height: 21px;position:absolute;margin: 4px 0px 0px 688px;z-index: 90000;}.popcontent label{ color:#a2a2a2; width:100%; float:left;}.popcontent input[type=text], .popcontent input[type=password]{height:26px; line-height:26px; font:normal 12px 'droid_sansregular'; color:#ddd; background-color:#333; width:94%;}#sidetab{display:none; width:620px; margin:0 auto; height:1px;}#fade{ background:#000000; opacity:0.6; filter:alpha(opacity=60); z-index:99; height:800px; width:100%; position:fixed; display:none;}.popcontent a{color:#060606; text-decoration:underline; font:normal 12px 'droid_sansregular'; float:right; margin-top:6px; margin-right:20px;}.popcontent a:hover{color:#FF7200; text-decoration:none;}.popcontent input[type=submit]{cursor:pointer;background-image: linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -o-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -moz-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -webkit-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -ms-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -webkit-gradient(	linear,	left bottom,	left top,	color-stop(0.06, rgb(12,12,12)),	color-stop(1, rgb(69,69,69)));border-radius:3px;border:1px solid #0a0a0a;color: #005A61;width:92px;display: block;text-decoration: none;color:#fff;text-shadow: 0px 0px white, 0px 0px #444; font:normal 15px 'open_sansregular'; float:left; margin-bottom:20px; margin-top:10px; padding:4px 0 5px;}.popcontent input[type=submit]:hover{background-image: linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -o-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -moz-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -webkit-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -ms-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -webkit-gradient(	linear,	left bottom,	left top,	color-stop(0.06, rgb(12,12,12)),	color-stop(1, rgb(51,50,51)));}
</style>

<style type="text/css">
#fade
    {
		position:absolute;
		height:900px;
		z-index:999;
		background:#df6900;
		opacity:0.5;
		display:none;
	}
	
	.pop_item{position: absolute;margin:-100px 105px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999;}
	.pop_item1{position: absolute;margin:0px 105px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999;}
	.pop_item2{position: absolute;margin:100px -286px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999;}
	.reviews_pop{position: absolute;background:#f5f5f5; margin:0px 135px 0px 0px;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;
              z-index:99999999;}
	.reviews_pop h2 img{ float:right;}
	.pop_item h2 img{ float:right;}
</style>

<script language="javascript">
function showsidetab()
{
	document.getElementById('fade').style.display="block";
	document.getElementById('local_review').style.display="block";
}
function closesidetab()
{
	document.getElementById('fade').style.display="none";
	document.getElementById('local_review').style.display="none";
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
function add_item(id)
{
	document.getElementById('fade').style.display="block";
	document.getElementById('add_item'+id).style.display="block";
}
function closeadditem(id)
{
	document.getElementById('fade').style.display="none";
	document.getElementById('add_item'+id).style.display="none";
}
/*function check_menu_size(id){
	document.getElementById('add_item_btn'+id).style.display = 'block';
	document.getElementById('add_item_img'+id).style.display = 'none';
}*/
function del_block(id){
	document.getElementById('del_add'+id).style.display="block";
}
function closedel_add(id)
{
	document.getElementById('del_add'+id).style.display="none";
}
function check_validation(id){
	if(document.getElementById('submit').value == 'VERIFY ADDRESS'){
	if(document.getElementById('address'+id).value == ''){
		alert('Please enter a valid street address.');
		document.getElementById('address'+id).focus();
		return false;
	}
	}
	return true;
}
</script>

<script type="text/javascript">
function show_map(){
	if(document.getElementById('map_div').style.display == 'none'){
	document.getElementById('map_div').style.display = 'block';
	document.getElementById('hide_map').style.display = 'block';
	document.getElementById('show_map').style.display = 'none';
	}
	else if(document.getElementById('map_div').style.display == 'block'){
	document.getElementById('map_div').style.display = 'none';
	document.getElementById('hide_map').style.display = 'none';
	document.getElementById('show_map').style.display = 'block';	
	}
}
</script>

<div id="fade"></div>
<div id="top_div"></div>
<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>

<div class="body_section">

    <div class="body_container">
        <div class="body_top"></div>
        <div class="main_body">
            <div class="food_body_cont">
                <div class="food_content">
                    <div class="food_cont_top">
                    	<h1>Home</h1>
                    </div>
                    
                    <?php include("includes/restaurant_top.php");?>
                    <script type="text/javascript">
					jQuery(function(){
						var YouTubeRegex = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
						jQuery('a.video').each(function(i){
							jQuery(this).click(function(event){
								event.preventDefault();
								var videoID = jQuery(this).attr('href').match(YouTubeRegex);
								//alert(videoID[1]);
								jQuery('div#fade').show();
								jQuery('div#video_content').css({
									padding : '10px',
								}).html('<span style="float: left;font-size: 20px;margin-left: 240px;margin-top: 190px;">Loading Video</span>');
								jQuery('div#sidetab').show();
								setTimeout(function(){
									jQuery('div#video_content').html('<iframe width="600" height="400" src="//www.youtube.com/embed/' + videoID[1] + '?wmode=transparent&autoplay=1" frameborder="0" allowfullscreen></iframe>');
								}, 5000);
							});
						});
						jQuery('a#video_close').click(function(event){
							event.preventDefault();
							jQuery('div#sidetab').hide();
							jQuery('div#fade').hide();
							jQuery('div#video_content').html('').removeAttr('style');
						});
					});
					</script>
                    <div class="accr_menu" id="tab">
                        <?php include('includes/tab_menu.php');?>
                        </div>
                    <div class="clear"></div>
					<div class="accr_details">
                    <div class="menu_nav">
                    <ul>
                    <li><a href="restaurant.php?id=<?php echo $_REQUEST['id'];?>#tab"  <?php if($_REQUEST['c_id']==''){ ?> class="active6" <?php } ?>>All Available Items</a></li>
                    <?php $sql_menu_category = mysql_query("SELECT * FROM restaurant_menu_category WHERE id!=''");
					while($array_menu_catyegory = mysql_fetch_array($sql_menu_category)){?>
                    <li><a href="restaurant.php?id=<?php echo $_REQUEST['id'];?>&c_id=<?php echo $array_menu_catyegory['id'];?>#tab" <?php if($array_menu_catyegory['id'] == $_REQUEST['c_id']){ ?> class="active6" <?php }?>><?php echo $array_menu_catyegory['category_name'];?></a></li>
                    <?php } ?>
                    
                    </ul>
                    
                    </div>
                    
                    <div id="vertical_container" class="rstrnt_panel">
                    
                        <?php
						$all_menu_id="";
						$menu_sep="";
						$res_restaurant_main_category=mysql_query("select sub_category_id from restaurant_menu_item where restaurant_id='".$_REQUEST['id']."'");
						while($select_restaurant_main_category=mysql_fetch_array($res_restaurant_main_category))
						{
						$all_menu_id.=$menu_sep.$select_restaurant_main_category['sub_category_id'];
						$menu_sep=",";
						}
						?>
                        
                        <?php $sql_sub_category =("SELECT * FROM restaurant_menu_subcategory WHERE id IN(".$all_menu_id.")");
						if($_REQUEST['c_id']){
							$sql_sub_category.= " AND category_id = '".$_REQUEST['c_id']."'";
						}
						$sql_sub_category.= "ORDER BY show_order";
						$sql_query = mysql_query($sql_sub_category);
						if(mysql_num_rows($sql_query)>0){
						while($array_sub_category = mysql_fetch_array($sql_query)){?>
                            <h1 class="accordion_toggle"><?php echo $array_sub_category['subcategory_name'];?></h1>
                            <div class="accordion_content"> 
                           <?php 
						   $sql_subcat = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '".$_REQUEST['id']."' AND sub_category_id = '".$array_sub_category['id']."'"));
						   ?>
                            <?php if($sql_subcat['subcategory_desc']!=""){ ?>
                            <p><?php echo $sql_subcat['subcategory_desc']?></p>
                            <?php } ?>
                            <?php $sql_menu = mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '".$_REQUEST['id']."' AND sub_category_id = '".$array_sub_category['id']."' ORDER BY last_updated");
							if(mysql_num_rows($sql_menu)>0){
							while($array_menu = mysql_fetch_array($sql_menu)){ ?>
                            
                                <div class="pop_item" style="display:none;" id="add_item<?php echo $array_menu['id'];?>">
                                <form name="add_item_frm" method="post" action="" onSubmit="return check_validation(<?php echo $array_menu['id'];?>);">
                                <input type="hidden" name="menu_id" id="menu_id" value="<?php echo $array_menu['id']; ?>">
                                <input type="hidden" name="size<?php echo $array_menu['id'];?>" id="size<?php echo $array_menu['id'];?>" value="<?php echo $array_menu['size']; ?>">
                                <input type="hidden" name="restaurant_id<?php echo $array_menu['id'];?>" id="restaurant_id<?php echo $array_menu['id'];?>" value="<?php echo $_REQUEST['id']; ?>">
                                <input type="hidden" name="menu_price<?php echo $array_menu['id'];?>" id="menu_price<?php echo $array_menu['id'];?>" value="<?php echo $array_menu['price'];?>">
                                    <h2>Add Item<a href="Javascript:void(0);" onClick="closeadditem('<?php echo $array_menu['id'];?>')"><img src="images/cross.png" width="22" height="22" /></a></h2>
                                    <h3><?php echo $array_menu['menu_name'];?></h3>
                                    <?php if($array_menu['menu_name']!='' && $array_menu['price']!='0.00'){?>
                                    <span style="margin-left:10px;">$ <?php echo $array_menu['price']; ?>  </span><?php } ?>
                                    
                                    <?php if($array_menu['description']!=''){?>
                                    <p style="border-bottom:none;"><?php echo $array_menu['description'];?></p>
                                    <?php } ?>
                                    
                                        <?php $sql_select_special_instructions = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$array_menu['id']."'");
										while($array_special_instructions = mysql_fetch_array($sql_select_special_instructions)){ ?>
                                         <div class="pop_commnt">
                                         <h3><?php echo $array_special_instructions['special_instruction']; ?></h3>
                                        
                                        <div>
                                        <?php $sql_sub_ins = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE special_ins_id = '".$array_special_instructions['id']."'");
										while($array_spl_ins = mysql_fetch_array($sql_sub_ins)){ ?>
                                                <span style="width:32%; float:left;"><!--<input name="radio<?php echo $array_menu['id'];?>_<?php echo $array_special_instructions['id']; ?>" type="radio" value="<?php echo $array_spl_ins['price']; ?>" id="small<?php echo $array_menu['id'];?>" /><?php echo $array_spl_ins['title']; ?>-->
                                                <input name="radio<?php echo $array_menu['id'];?>_<?php echo $array_special_instructions['id']; ?>" type="radio" value="<?php echo $array_spl_ins['id']; ?>" id="small<?php echo $array_menu['id'];?>" /><?php echo $array_spl_ins['title']; ?>
                                                
                                                <br>(+$<?php echo $array_spl_ins['price']; ?>)</span>
                                         <?php } ?>
                                         </div> 
                                           <div class="clear"></div>  
                                         </div>
                                        <div class="clear"></div>
                                    <?php } ?>
                                      
                                        
                                    <h3>Special Instructions</h3>
                                    <textarea name="special_instructions<?php echo $array_menu['id'];?>" id="special_instructions<?php echo $array_menu['id'];?>" cols="" rows=""></textarea>
                                    <h3>Quantity</h3>
                                    <input name="quantity<?php echo $array_menu['id'];?>" id="quantity<?php echo $array_menu['id'];?>" type="text" class="pop_quantity" value="1" />
                                    
                                    <?php /*?><div style="margin-left:10px; margin-bottom:10px;" id="add_item_img<?php echo $array_menu['id'];?>">
                                    <img src="images/add_item.jpg" title="Add this item" ></div><?php */?>
                                    
                                    <?php $sql_select_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_REQUEST['id']."'"); 
									$num_rows_items = mysql_num_rows($sql_select_items);  ?>
									
                                    
                                    <div style="margin-top:0px !important;" id="add_item_btn<?php echo $array_menu['id'];?>">
                                    <?php if($num_rows_items == 0){ ?>
									<a href="#" onClick="del_block(<?php echo $array_menu['id'];?>);"><img src="images/add_item1.jpg" title="Add this item" style="margin:10px;" ></a><?php } else { ?>
                                    <input name="add" id="add" type="submit" value="ADD ITEM" class="pop_button" />
                                    <?php } ?>
                                    </div>
                                    <div class="pop_item2" style="display:none;" id="del_add<?php echo $array_menu['id'];?>">
                                        <h2>Where are you?<a href="Javascript:void(0);" onClick="closedel_add('<?php echo $array_menu['id'];?>')"><img src="images/cross.png" width="22" height="22" /></a></h2>
                                        <h3>We want to make sure this restaurant is convenient for delivery or pickup.</h3>
                                            <h3>Please enter your address </h3>
                                            <input name="address<?php echo $array_menu['id'];?>" id="address<?php echo $array_menu['id'];?>" type="text" class="pop_quantity" style="width:350px;" />
                                           <?php if($num_rows_items == 0){?> 
                                          <div><input name="submit" id="submit" type="submit" value="VERIFY ADDRESS" class="pop_button" style="width:150px;" /></div>
                                          <?php } ?>
                          			</div>
                                    
                                    
                                </form>               
                                </div>
                                
                                
                                <div class="light_box_cam">
                                <h2 style="float:none;">
                                <a href="#top_div" onClick="add_item('<?php echo $array_menu['id'];?>')" style="color:#EF7011;"><?php echo stripslashes($array_menu['menu_name']); ?></a>
                                <?php
								if($array_menu['menu_pic']!="")
								{
								?>
								<a href="uploaded_images/<?php echo $array_menu['menu_pic'];?>" class="highslide" onClick="return hs.expand(this)">
								<img src="thumb_images/<?php echo $array_menu['menu_pic'];?>" alt="<?php echo stripslashes($array_menu['menu_name']); ?>" title="Click to enlarge" height="30" width="30" style="margin-top:0px;" /></a>
								<?php } ?>
                                    
                                <span style="float:right; padding-right:10px;">
								<?php if($array_menu['price']!='' && $array_menu['price']!= '0.00'){ echo "$ ".$array_menu['price']; } ?>
                                </span>
                                <div style="clear:both;"></div></h2>
                                
                                
                                
                                <!--<div class="highslide-gallery">-->

<!--
	4) This is how you mark up the thumbnail image with an anchor tag around it.
	The anchor's href attribute defines the URL of the full-size image.
-->
<?php /*?><?php
if($array_menu['menu_pic']!="")
{
?>
<a href="uploaded_images/<?php echo $array_menu['menu_pic'];?>" class="highslide" onClick="return hs.expand(this)">
<img src="thumb_images/<?php echo $array_menu['menu_pic'];?>" alt="<?php echo stripslashes($array_menu['menu_name']); ?>" title="Click to enlarge" /></a>
<?php } ?><?php */?>
<!--
	5 (optional). This is how you mark up the caption. The correct class name is important.
-->

<!--<div class="highslide-caption">
	Caption for the first image.
</div>


</div>-->

</div>
                                <div class="clear"></div>
                                <p><?php if($array_menu['description']!=""){?><?php echo $array_menu['description'];?><br><?php } ?></p>
                                  
                                 
                                
                                <?php } } else {?> 
                                <p> No items Available</p>
                                <?php }?>
                            </div>
                            
                            <?php } } else { ?>
                            <p style="font:14px Arial,Helvetica,sans-serif; text-align:center; padding:8px 0; color: #686868;">No items available</p>
                            <?php } ?>
                            
                        </div>
                        
                       <div id="restro_2left_panel"> 
                       <?php $sql_cart = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_REQUEST['id']."'");
					   $cart_row = mysql_num_rows($sql_cart);
					   if($cart_row == 0){
						   $display = 'block';
						   $display1 = 'none';
					   }else {
						   $display = 'none';
						   $display1 = 'block';
					   }?>
                       
                       <div class="rstrnt_right_panel" style="min-height:405px; display:<?php echo $display; ?>;">
                        <div class="rstrnt2_reviews_rtngs">
                    	<div>
                       <?php $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'")); ?>
                       <div class="reviews_pop" style="display:none;" id="local_review">
                            		<h2><?php echo stripslashes($sql_restaurant['restaurant_name']); ?><a href="Javascript:void(0);" onClick="closesidetab()"><img src="images/cross.png" width="22" height="22" /></a></h2>
                                    <?php $sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$_REQUEST['id']."'");
									while($array_reviews = mysql_fetch_array($sql_reviews)){ ?>
                                    <div class="pop_commnt"><?php echo $array_reviews['customer_review']; ?><p><?php echo $array_reviews['customer_name']; ?></p></div>
                                    <?php } ?>                                
                          </div></div>
                    	<!-------------------- popular pop item --------------------------------------------->
                    	<div class="pop_item1" style="display:none;" id="popular_item">
                       <h2><?php echo stripslashes($sql_restaurant['restaurant_name']); ?><a href="Javascript:void(0);" onClick="closepopularitem()" style="float:right;"><img src="images/cross.png" width="22" height="22" /></a></h2>
                       <div class="restro_fution"><?php $sql_restaurant_category = mysql_query("SELECT * FROM restaurant_category WHERE id IN(".$sql_restaurant['restaurant_category'].")");?>
						<?php 
                        $i=1;
                        while($result_restaurant_category=mysql_fetch_array($sql_restaurant_category))
                        {?>
                        <span><?php echo $result_restaurant_category['category_name']; ?> <?php if($i!=mysql_num_rows($sql_restaurant_category)){ echo ",";
                        }?></span>
                        
                        <?php $i++; }
							?></div>
                            <?php $sql_delivery = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['id']."'"));?>
                           <table width="500" border="0" cellspacing="10" cellpadding="3">
                           <?php if(!empty($sql_delivery['business_hours_mon'])){?>
                              <tr>
                                <td class="fll_hr">Monday</td>
                                <td><?php echo $sql_delivery['business_hours_mon']; ?></td>
                              </tr>
                           <?php } ?>
                           <?php if(!empty($sql_delivery['business_hours_tue'])){?>
                              <tr>
                                <td class="fll_hr">Tuesday</td>
                                <td><?php echo $sql_delivery['business_hours_tue']; ?></td>
                              </tr>
                          <?php } ?>
                          <?php if(!empty($sql_delivery['business_hours_wed'])){?>
                              <tr>
                                <td class="fll_hr">Wednesday</td>
                                <td><?php echo $sql_delivery['business_hours_wed']; ?></td>
                              </tr>
                          <?php } ?>
                          <?php if(!empty($sql_delivery['business_hours_thu'])){?>
                              <tr>
                                <td class="fll_hr">Thursday</td>
                                <td><?php echo $sql_delivery['business_hours_thu']; ?></td>
                              </tr>
                          <?php } ?>
                          <?php if(!empty($sql_delivery['business_hours_fri'])){?>
                              <tr>
                                <td class="fll_hr">Friday</td>
                                <td><?php echo $sql_delivery['business_hours_fri']; ?></td>
                              </tr>
                          <?php } ?>
                          <?php if(!empty($sql_delivery['business_hours_sat'])){?>
                              <tr>
                                <td class="fll_hr">Saturday</td>
                                <td><?php echo $sql_delivery['business_hours_sat']; ?></td>
                              </tr>
                          <?php } ?>
                          <?php if(!empty($sql_delivery['business_hours_sun'])){?>
                              <tr>
                                <td class="fll_hr">Sunday</td>
                                <td><?php echo $sql_delivery['business_hours_sun']; ?></td>
                              </tr>
                          <?php } ?>
                           </table>                                              
                    </div>
                    	<!-------------------- popular pop item --------------------------------------------->
                        
                        
                    <div>
                    
                    <div class="rstrnt2_rtngs">
					<?php $sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$_REQUEST['id']."'");
					$no_reviews = mysql_num_rows($sql_reviews); ?>
                    <div>
                    <?php 
                    $rating = number_format(getRestaurantRating($_REQUEST['id']), 1);
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
                    ?></div>
                         <p style="width:70px !important;"><?php echo $no_reviews; ?>  Reviews</p>    
                      </div>
                      
                    <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    
                    </div>
                    
                    <h2 class="local_reviews">
                    <?php if($no_reviews == 0){?>
                    <?php echo $no_reviews; ?> Reviews 
                    <?php }else { ?>
                    <a href="#top_div" onClick="showsidetab()"><?php echo $no_reviews; ?> Reviews </a>
                    <?php } ?></h2>
                    
                    <div class="rstrnt2_mre_info">
                            <h2 class="popular_item"><a href="#top_div" onClick="popularitem()">Full Hours, Cuisines, More Info... </a></h2>
                            
                            <p><?php if(!empty($sql_restaurant['phone'])) { echo $sql_restaurant['phone']; }?><br /><br>
                            
                            <span>
                            <?php echo $sql_restaurant['restaurant_address'];?><br>
                            <?php echo $sql_restaurant['restaurant_city'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_state'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_zipcode'];?></span>
                            </p>
                            <div class="pckup">
                            
                            <?php 
							$timestamp = time(); 
							$time = date("G:i:s");
							//$time = "10:15:00";
							
							$time1 = strtotime($time);
							 
							$del_hours_from = strtotime($sql_delivery['del_hours_from']);
							$del_hours_to = strtotime($sql_delivery['del_hours_to']);
							$pickup_hours_from = strtotime($sql_delivery['pickup_hours_from']);
							$pickup_hours_to = strtotime($sql_delivery['pickup_hours_to']);	
							?>
                            
                            <?php if($sql_delivery['delivery'] == 1){?>
                            <div>
                            <?php if(!empty($sql_delivery['delivery_charge'])){?>
                                <p>Delivery $<?php echo $sql_delivery['delivery_charge']; ?></p>
                            <?php } ?>
                            <?php if(!empty($sql_delivery['minimum_ammount'])){ ?>
                                <p>Minimum $<?php echo $sql_delivery['minimum_ammount']; ?></p> 
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <div>
                                <h4>Pickup</h4>
                                <p><?php if($sql_delivery['pickup'] == 1){ echo "Available"; } else { echo "Unavailable"; }?></p>
                            </div>
                            <?php if($sql_delivery['pickup_hours_from']!='' && $sql_delivery['pickup_hours_to']!=''){ ?>
                            <div>
                                <h4>Pickup Hours</h4>
                                <?php if($pickup_hours_from!='' && $pickup_hours_to!=''){
								if($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to){ ?>
								<p style="color:#9AA930; font-weight:bold; font-size:17px;">Open Now</p>
								<?php }else { ?>
								<p style="color:#C00007;">Not taking orders for pickup at this time.</p>
								<?php } } else { ?>
								<p style="color:#9AA930; font-weight:bold; font-size:17px;">Open Now</p>
								<?php }?>
                                <p><?php echo $sql_delivery['pickup_hours_from']." to ".$sql_delivery['pickup_hours_to'];?></p>
                            </div>
                            <?php } ?>
                            <div>
                            <?php if(!empty($sql_delivery['delivery_estimated_time'])){?>
                                <h4>Delivery</h4>
                                <p><?php echo $sql_delivery['delivery_estimated_time']; ?></p>
                            <?php } ?>
                            </div>
                            <?php if($sql_delivery['del_hours_from']!='' && $sql_delivery['del_hours_to']!=''){ ?>
                            <div>
                                <h4>Delivery Hours</h4>
                                <?php if($del_hours_from!='' && $del_hours_to!=''){
								if($time1 >$del_hours_from  && $time1 <$del_hours_to){ ?>
								<p style="color:#9AA930; font-weight:bold; font-size:17px;">Open Now</p>
								<?php }else { ?>
								<p style="color:#C00007;">Not taking orders for delivery at this time.</p>
								<?php } } else { ?>
								<p style="color:#9AA930; font-weight:bold; font-size:17px;">Open Now</p>
								<?php }?>
                                <p><?php echo $sql_delivery['del_hours_from']." to ".$sql_delivery['del_hours_to'];?></p>
                            </div>
                            <?php } ?>
                    </div>
                    <?php 
                    $sql_select_add = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
                    $address = $sql_select_add['restaurant_address']." ".$sql_select_add['restaurant_city']." ".$sql_select_add['restaurant_state']." ".$sql_select_add['restaurant_zipcode'];
                    $address_map=str_replace(" ","%20",$address);
                    $address_map=str_replace("#","%23",$address_map);?>
                    
                    
                    
                    
                    </div>
                        </div>
                        
                        <!----------------------------------   cart------------------------------------------>
                        
                        <div class="rstrnt_right_panel" style="display:<?php echo $display1; ?>;">
                        
                        <div class="rstrnt2_mre_info">
                        <h2 class="restrnt2_order">Your Order</h2>
                        
                        <?php if($del_hours_from!='' && $del_hours_to!=''){
							if(($time1 >$del_hours_from  && $time1 <$del_hours_to)){
							}else { ?>
                            <p style="color:#C00007; font-size:16px;">Not taking orders for delivery at this time.</p>
							<?php }
						}?>
                        
                        <?php if($pickup_hours_from!='' && $pickup_hours_to!=''){
							if(($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){
							}else { ?>
                            <p style="color:#C00007; font-size:16px;">Not taking orders for pickup at this time.</p>
							<?php }
						}?>
                        
                        
                        
                        <table width="100%" border="0" cellspacing="1" class="restro2_table">
                          <tr>
                            <td height="20" colspan="3" align="center" class="restro2_table_bg"><h2>Qty</h2></td>
                            <td width="53%" height="20" align="center" class="restro2_table_bg"><h2>Item</h2></td>
                            <td width="24%" height="20" align="center" class="restro2_table_bg"><h2>Price</h2></td>
                            </tr>
                          <?php 
						  $sql_restaurant_delivery_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id	 = '".$_REQUEST['id']."'"));
						  $sql_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_REQUEST['id']."'");
						  $amount = 0;
						  while($array_items = mysql_fetch_array($sql_items)){ ?>  
                          <tr>
                            <td height="30" colspan="3" align="center"><a href="#"><?php echo $array_items['quantity']; ?></a></td>
                            <td height="30" align="center"><?php $sql_item_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_items['menu_item_id']."'"));
							echo $sql_item_name['menu_name']; ?></td>
                            <td height="30" align="left" style="padding-left:10px;">$ <?php echo ($array_items['quantity']*$array_items['price']); ?></td>
                          </tr>
                          <tr class="item_hover">
                            <td width="8%" height="30" align="center"><a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&sub=sub&cart_id=<?php echo $array_items['id']; ?>">-</a></td>
                            <td width="8%" height="30" align="center"><a href="#">&nbsp;</a></td>
                            <td width="7%" height="30" align="center"><a style="margin-left:23px;" href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>&add=add&cart_id=<?php echo $array_items['id']; ?>">+</a></td>
                            <td height="30" align="center"><a href="#">&nbsp;</a></td>
                            <td height="30" align="center"><a href="#">&nbsp;</a></td>
                          </tr>
                          <?php 
						  $amount = $amount + ($array_items['price']*$array_items['quantity']);
						  } ?>
                          <tr>
                            <td height="20" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
                            <td height="20" align="right" style="padding-top:20px;">Subtotal</td>
                            <td height="20" align="left" style="padding-left:10px; padding-top:20px;">$ <?php echo $amount; ?></td>
                          </tr>
                          <tr>
                            <td height="20" colspan="3" align="center">&nbsp;</td>
                            <td height="20" align="right">Tax</td>
                            <td height="20" align="left" style="padding-left:10px;">
                            <?php 
							$tax = ($sql_restaurant_delivery_details['tax']/100 * $amount);
							$tax1 = round($tax, 2);
							echo "$ ".$tax1;;
							?>
                            </td>
                          </tr>
                          <tr>
                            <td height="20" colspan="3" align="center">&nbsp;</td>
                            <td height="20" align="right">Total</td>
                            <td height="20" align="left" style="padding-left:10px;">$ <?php echo ($tax1 + $amount); ?></td>
                          </tr>
                         </table>
                         
                    <?php /*?><h3 style="text-align:center;">Ready to order? </h3>
					<?php if($sql_restaurant_delivery_details['minimum_ammount'] > $amount){ $display_del1 = 'block'; $display_del2 = 'none'; }
					else { $display_del1 = 'none'; $display_del2 = 'block'; }?>
					<div class="restro2_delivery" style="background:#8099E9;display:<?php echo $display_del1; ?>;">
                        <a href="javascript:void(0);" style="cursor:default; color:#ffffff;"><p><h3>Want Delivery?</h3></p>
                        <?php if($sql_restaurant_delivery_details['minimum_ammount'] > $amount){?>
                        <p style="color:#ffffff;">Add $<?php echo ($sql_restaurant_delivery_details['minimum_ammount'] - $amount); ?></p><?php } ?>
                        <p style="color:#ffffff;">Minimum $<?php echo $sql_restaurant_delivery_details['minimum_ammount']; ?></p></a>
                    </div>
                    <div class="restro2_delivery" style="background:#3C3C95; display:<?php echo $display_del2; ?>;">
                    	<?php if(!isset($_SESSION['customer_id'])){ ?>
                        <a href="login.php" style="cursor:pointer; color:#ffffff;">
						<?php 	} else { ?>
                        <a href="check_out.php?type=del" style="cursor:pointer; color:#ffffff;">
                        <?php } ?>
                        <p><h3>I Want Delivery!</h3></p>
                        <p style="color:#ffffff;">Delivery <?php if($sql_del_details['delivery_charge'] == ''){ echo "Free"; }
                        else{
                            echo "$".$sql_del_details['delivery_charge'];
                        }?></p>
                        <p style="color:#ffffff;">Total $<?php echo ($amount + $sql_del_details['delivery_charge']); ?></p></a>
                    </div>
                    <?php if($sql_del_details['pickup'] == 1){ $display_pickup = 'block'; } else { $display_pickup = 'none'; }?>
                    <div class="restro2_pick" style="display:<?php echo $display_pickup;?>">
                    	<?php if(!isset($_SESSION['customer_id'])){ ?>
                        <a href="login.php">
						<?php } else { ?>
                        <a href="check_out.php?type=pickup">
                        <?php } ?>
                        <p><h3>I'll pick it up</h3></p>
                        <p>Total $<?php echo $amount; ?></p></a>
                    </div><?php */?>
                    
                    <form name="order_del_frm" method="post" action="">
                    <?php 
					 if($pickup_hours_from!='' && $pickup_hours_to!=''){
					 if($time1 <$pickup_hours_from  || $time1 >$pickup_hours_to){ 
                     $class_pickup = "disabled"; } else { 
					 $class_pickup = "checked"; }}else{
					 $class_pickup = "checked"; } ?>
                    
                    <input type="radio" name="delivery_type" value="pickup" style="margin-right:5px;" id="pickup" <?php echo $class_pickup; ?>onClick="return del_type();"><span style="margin-right:50px;">PICKUP &nbsp;<img src="images/pickup.png"></span>
                    <?php /*?><?php if(($sql_restaurant_delivery_details['minimum_ammount'] > $amount) || ($time1 <$del_hours_from  || $time1 >$del_hours_to)){
					$class_del = "disabled"; } ?><?php */?>
                    
                    <?php /*?><?php if($sql_restaurant_delivery_details['minimum_ammount'] > $amount){
						$class_del = "disabled";
					}else if(($time1 <$del_hours_from  || $time1 >$del_hours_to)){
						$class_del = "disabled";
					}?><?php */?>
                    
                    <?php if($sql_restaurant_delivery_details['minimum_ammount'] > $amount){
					$class_del = "disabled";	
					}elseif($del_hours_from!='' && $del_hours_to!=''){
						if($time1 <$del_hours_from  || $time1 >$del_hours_to){
							$class_del = "disabled";
						}
					}?>
                    
                    <?php if($sql_restaurant_delivery_details['delivery'] == 1){ ?>
                    <input type="radio" name="delivery_type" value="del" style="margin-right:5px;" id="del" <?php echo $class_del; ?> onClick="return del_type();"><span>DELIVERY &nbsp;<img src="images/delivery.png"></span><?php } ?>
                    <p>Delivery Minimum : $ <?php echo $sql_restaurant_delivery_details['minimum_ammount']; ?> (Before tax)</p>
                    <p>No minimum on pickup orders</p>
                    <br>
                    
                    <script type="text/javascript">
					function del_type(){
						if(document.order_del_frm.delivery_type[0].checked == true){
							document.getElementById('check_out_pickup').style.display = 'block';
							document.getElementById('check_out_del').style.display = 'none';
						}
						else if(document.order_del_frm.delivery_type[1].checked == true){
							document.getElementById('check_out_pickup').style.display = 'none';
							document.getElementById('check_out_del').style.display = 'block';
						}						
					}
					</script>
					<?php if(!isset($_SESSION['customer_id'])){
						$link = 'login.php';
					}else {
						$link = 'check_out.php?type=pickup';
					}
					?>
                    <div id="check_out_pickup">
                    <?php if($del_hours_from!='' && $del_hours_to!='' && $pickup_hours_from!='' && $pickup_hours_to!=''){
					if(($time1 >$del_hours_from  && $time1 <$del_hours_to && $sql_restaurant_delivery_details['minimum_ammount'] < $amount) || ($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){ ?>
                    <a href="<?php echo $link; ?>" class="check_order_button" style="text-decoration:none; margin-left:50px; margin-top:10px; padding:5px 50px;"> Check Out </a>
                    <?php } }else{ ?>
					<a href="<?php echo $link; ?>" class="check_order_button" style="text-decoration:none; margin-left:50px; margin-top:10px; padding:5px 50px;"> Check Out </a>
                    <?php } ?>
                    
                    </div>
                    <?php if(!isset($_SESSION['customer_id'])){
						$link1 = 'login.php';
					}else {
						$link1 = 'check_out.php?type=del';
					}
					?>
                    <div id="check_out_del" style="display:none;">
                    <?php if($del_hours_from!='' && $del_hours_to!='' && $pickup_hours_from!='' && $pickup_hours_to!=''){
					if(($time1 >$del_hours_from  && $time1 <$del_hours_to && $sql_restaurant_delivery_details['minimum_ammount'] < $amount) || ($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){ ?>
                    <a href="<?php echo $link1; ?>" class="check_order_button" style="text-decoration:none; margin-left:50px; margin-top:10px; padding:5px 50px;"> Check Out </a>
                    <?php } }else{ ?>
                    <a href="<?php echo $link1; ?>" class="check_order_button" style="text-decoration:none; margin-left:50px; margin-top:10px; padding:5px 50px;"> Check Out </a>
                    <?php } ?>
                    </div>
                    </form>
                    <div>
                    <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    
                    </div>	
                        </div>
                        
                        <div style="margin-bottom:5px;" id="show_map">
                        <a href="javascript:void(0);" onClick="return show_map();"><h4>Show Map</h4></a>
                        </div>
                    
                        <div style="margin-bottom:5px; display:none;" id="hide_map">
                        <a href="javascript:void(0);" onClick="return show_map();"><h4>Hide Map</h4></a>
                        </div>
                        
                        <div style="width: 300px; height:200px; margin-bottom:10px; border:1px solid rgb(255, 177, 113); display:none;" id="map_div"><iframe width="300" height="200" src="http://regiohelden.de/google-maps/map_en.php?width=300&amp;height=200&amp;hl=en&amp;q=<?php echo $address_map; ?>%20+(<?php echo stripslashes($sql_select_add['restaurant_name'])?>)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=A&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div>
                    
                        <!---------------------------------- end cart --------------------------------------->
                        </div>
                        
                        <div class="clear"></div>
                    </div>
                </div>
            	<div class="clear"></div>
            	<div class="tab_body_cont"></div>
            </div> <div class="body_footer_bg"></div>
        </div>
       
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>



<div id="sidetab">
<div id="login-poup-area">
<a href="close" id="video_close"><img src="images/close.png" width="32" height="32" alt="" style="position:absolute; z-index:11111; cursor:pointer; right:-7px; top:-6px;"></a>
    <div class="newpopup">
        <div class="popcontent" id="video_content"></div>
    	<div class="clear"></div>
    </div>
</div>
</div>
<script type="text/javascript" src="javascript/prototype.js"></script>
	<script type="text/javascript" src="javascript/effects.js"></script>
	<script type="text/javascript" src="javascript/accordion.js"></script>
	<script type="text/javascript" src="javascript/code_highlighter.js"></script>
	<script type="text/javascript" src="javascript/javascript.js"></script>
	<script type="text/javascript" src="javascript/html.js"></script>

    

	
    
	<script type="text/javascript">
			
		// 
		//  In my case I want to load them onload, this is how you do it!
		// 
		Event.observe(window, 'load', loadAccordions, false);
	
		//
		//	Set up all accordions
		//
		function loadAccordions() {
			
			var bottomAccordion = new accordion('vertical_container');
			
			
			
			// Open first one
			bottomAccordion.activate($$('#vertical_container .accordion_toggle')[0]);
			
			// Open second one
			topAccordion.activate($$('#horizontal_container .horizontal_accordion_toggle')[2]);
		}
		
	</script>
<?php include("includes/footer.php");?>
