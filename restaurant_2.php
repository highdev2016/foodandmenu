<?php 
ob_start();
session_start();

$session_id = session_id();

//print_r($_SESSION);
include('admin/lib/conn.php');
include("includes/rest_header.php");
include("includes/functions.php");
//include("search_compete.php");

//echo getRestaurantRating($_REQUEST['id']);
?>
<?php 
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
	
	$array_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['restaurant_id'.$i]."'"));
	$rest_add_lat = $array_basic_info['latitude'];
	$rest_add_lng = $array_basic_info['longitude'];
	
	$distance_in_miles = distance($user_add_lat, $user_add_long, $rest_add_lat, $rest_add_lng, "M");
	//$distance_in_miles = distance(30.3640626,-97.6838601,30.2399151,-97.7530534, "M");
	
	$rest_del_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['restaurant_id'.$i]."'"));
	
	if($user_add_lat == '' && $user_add_long == ''){
		$error_msg1 = 1;
	}
	else {
		if($distance_in_miles < $rest_del_details['delivery_range']){
			if($sql_del_details['delivery'] == 1 || $sql_del_details['pickup'] == 1){
			$sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."'");
			$num_rows = mysql_num_rows($sql_select_cart_items);
			if($num_rows == 0){
				$sql_insert_into_cart = "INSERT INTO restaurant_menuitem_cart SET menu_item_id = '".$_REQUEST['menu_id']."',session_id = '".$session_id."',restaurant_id = '".$_REQUEST['restaurant_id'.$i]."',quantity = '".$_REQUEST['quantity'.$i]."',special_ins = '".$_REQUEST['special_instructions'.$i]."'";
				if($_REQUEST['size'.$i] == 'single'){
					$sql_insert_into_cart.= " ,price = '".$_REQUEST['menu_price'.$i]."'";
				}else if($_REQUEST['size'.$i] == 'multiple'){
					$sql_insert_into_cart.= " ,price = '".$_REQUEST['radio'.$i]."'";
				}
				mysql_query($sql_insert_into_cart);
			}
			else {
				if($_REQUEST['size'.$i] == 'single'){
					$sql_update_cart = "UPDATE restaurant_menuitem_cart SET quantity = quantity+".$_REQUEST['quantity'.$i]."";
					$sql_update_cart.= " WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."' AND restaurant_id = '".$_REQUEST['restaurant_id'.$i]."'";
					mysql_query($sql_update_cart);
				}
				else if($_REQUEST['size'.$i] == 'multiple'){
					$sql_select_this_item = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."' AND restaurant_id = '".$_REQUEST['restaurant_id'.$i]."' AND price = '".$_REQUEST['radio'.$i]."'");
					$sql_rows = mysql_num_rows($sql_select_this_item);
					if($sql_rows == 0){
						$sql_insert = ("INSERT INTO restaurant_menuitem_cart SET session_id = '".$session_id."',menu_item_id = '".$_REQUEST['menu_id']."', restaurant_id = '".$_REQUEST['restaurant_id'.$i]."',price = '".$_REQUEST['radio'.$i]."', quantity = '".$_REQUEST['quantity'.$i]."',special_ins = '".$_REQUEST['special_instructions'.$i]."'");
						mysql_query($sql_insert);
					}else{
					$sql_update_cart = "UPDATE restaurant_menuitem_cart SET quantity = quantity+".$_REQUEST['quantity'.$i]."";
					$sql_update_cart.= " WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."' AND restaurant_id = '".$_REQUEST['restaurant_id'.$i]."' AND price = '".$_REQUEST['radio'.$i]."'";
					mysql_query($sql_update_cart);
					}
				}				
			}
			$error_msg1 = 2;
			}
			else{
				$error_msg = 4;
			}
		}
		else{
			$error_msg1 = 3;
		}
	}
	header("location:restaurant.php?id=".$_REQUEST['id']."&error_msg=$error_msg1#tab");
}

if($_REQUEST['add'] == 'ADD ITEM'){
	$i = $_REQUEST['menu_id'];
	$sql_select_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."'");
	$num_rows = mysql_num_rows($sql_select_cart_items);
	if($num_rows == 0){
		$sql_insert_into_cart = "INSERT INTO restaurant_menuitem_cart SET menu_item_id = '".$_REQUEST['menu_id']."',session_id = '".$session_id."',restaurant_id = '".$_REQUEST['restaurant_id'.$i]."',quantity = '".$_REQUEST['quantity'.$i]."',special_ins = '".$_REQUEST['special_instructions'.$i]."'";
		if($_REQUEST['size'.$i] == 'single'){
			$sql_insert_into_cart.= " ,price = '".$_REQUEST['menu_price'.$i]."'";
		}else if($_REQUEST['size'.$i] == 'multiple'){
			$sql_insert_into_cart.= " ,price = '".$_REQUEST['radio'.$i]."'";
		}
		mysql_query($sql_insert_into_cart);
	}
	else {
		if($_REQUEST['size'.$i] == 'single'){
			$sql_update_cart = "UPDATE restaurant_menuitem_cart SET quantity = quantity+".$_REQUEST['quantity'.$i]."";
			$sql_update_cart.= " WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."' AND restaurant_id = '".$_REQUEST['restaurant_id'.$i]."'";
			mysql_query($sql_update_cart);
		}
		else if($_REQUEST['size'.$i] == 'multiple'){
			$sql_select_this_item = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."' AND restaurant_id = '".$_REQUEST['restaurant_id'.$i]."' AND price = '".$_REQUEST['radio'.$i]."'");
			$sql_rows = mysql_num_rows($sql_select_this_item);
			if($sql_rows == 0){
				$sql_insert = ("INSERT INTO restaurant_menuitem_cart SET session_id = '".$session_id."',menu_item_id = '".$_REQUEST['menu_id']."', restaurant_id = '".$_REQUEST['restaurant_id'.$i]."',price = '".$_REQUEST['radio'.$i]."', quantity = '".$_REQUEST['quantity'.$i]."',special_ins = '".$_REQUEST['special_instructions'.$i]."'");
				mysql_query($sql_insert);
			}else{
			$sql_update_cart = "UPDATE restaurant_menuitem_cart SET quantity = quantity+".$_REQUEST['quantity'.$i]."";
			$sql_update_cart.= " WHERE session_id = '".$session_id."' AND menu_item_id = '".$_REQUEST['menu_id']."' AND restaurant_id = '".$_REQUEST['restaurant_id'.$i]."' AND price = '".$_REQUEST['radio'.$i]."'";
			mysql_query($sql_update_cart);
			}
		}				
	}
	$error_msg1 = 2;
	header("location:restaurant.php?id=".$_REQUEST['id']."&error_msg=$error_msg1#tab");
}
?>

<body>
<style>
#login-poup-area{width:620px; background-color:#EFEFEF; position:fixed; z-index:99999900; top:60px; height:420px; border-radius:7px;}.newpopup h3{color:#fff;padding:15px 0; background-color:#060606; text-align:center; width:100%; border-radius:7px 7px 0 0; font-size:18px;}.newpopup p{color:#000; font:bold 13px/26px 'droid_sansregular';padding-left:10px; margin:5px 10px;}.login_cross_bt{width:21px;height: 21px;position:absolute;margin: 4px 0px 0px 688px;z-index: 90000;}.popcontent label{ color:#a2a2a2; width:100%; float:left;}.popcontent input[type=text], .popcontent input[type=password]{height:26px; line-height:26px; font:normal 12px 'droid_sansregular'; color:#ddd; background-color:#333; width:94%;}#sidetab{display:none; width:620px; margin:0 auto; height:1px;}#fade{ background:#000000; opacity:0.6; filter:alpha(opacity=60); z-index:99; height:800px; width:100%; position:fixed; display:none;}.popcontent a{color:#060606; text-decoration:underline; font:normal 12px 'droid_sansregular'; float:right; margin-top:6px; margin-right:20px;}.popcontent a:hover{color:#FF7200; text-decoration:none;}.popcontent input[type=submit]{cursor:pointer;background-image: linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -o-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -moz-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -webkit-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -ms-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -webkit-gradient(	linear,	left bottom,	left top,	color-stop(0.06, rgb(12,12,12)),	color-stop(1, rgb(69,69,69)));border-radius:3px;border:1px solid #0a0a0a;color: #005A61;width:92px;display: block;text-decoration: none;color:#fff;text-shadow: 0px 0px white, 0px 0px #444; font:normal 15px 'open_sansregular'; float:left; margin-bottom:20px; margin-top:10px; padding:4px 0 5px;}.popcontent input[type=submit]:hover{background-image: linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -o-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -moz-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -webkit-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -ms-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -webkit-gradient(	linear,	left bottom,	left top,	color-stop(0.06, rgb(12,12,12)),	color-stop(1, rgb(51,50,51)));}
</style>

<style type="text/css">
#fade
    {
		position:fixed;
		height:900px;
		z-index:999;
		background:#df6900;
		opacity:0.5;
		display:none;
	}
	
	.pop_item{position: absolute;margin:-100px 105px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999;}
	.pop_item1{position: absolute;margin:722px 105px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999;}
	.pop_item2{position: absolute;margin:100px -286px 0px 0px;background:#f5f5f5;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; z-index:999999999999;}
	.reviews_pop{position: absolute;background:#f5f5f5; margin:722px 135px 0px 0px;box-shadow:0px 1px 5px 0px #aeaeae;width: 500px;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;
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
function check_menu_size(id){
	document.getElementById('add_item_btn'+id).style.display = 'block';
	document.getElementById('add_item_img'+id).style.display = 'none';
}
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
                    
                    <div style="margin-left:20px; color:#0102A4;"><?php if($_REQUEST['error_msg'] == 1){ echo "We cannot locate you.Please be more specific."; }
					else if($_REQUEST['error_msg'] == 2){ echo "Items successfully added to cart"; }
					else if($_REQUEST['error_msg'] == 3){ echo "Your address is not within our delivery range"; } ?></div>
                    
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
                                    <?php if($array_menu['size'] == 'single' && $array_menu['price']!=''){?>
                                    <span style="margin-left:10px;">$<?php echo $array_menu['price'];?></span>
 									<?php } else if($array_menu['size'] == 'multiple' && $array_menu['price']!=''){ ?>
                                    <span style="margin-left:10px;">$<?php echo $array_menu['price'];?>+ </span>
                                    <?php } ?>
                                    <?php if($array_menu['size'] == 'multiple'){?>
                                        <?php if($array_menu['price']!='' || $array_menu['price1']!='' || $array_menu['price2']!=''){?>
                                        <div class="pop_commnt">
                                            <h3>Choose a size</h3>
                                            <?php if($array_menu['price']!=''){ ?>
                                                <input name="radio<?php echo $array_menu['id'];?>" type="radio" value="<?php echo $array_menu['price']; ?>" id="small<?php echo $array_menu['id'];?>" onClick="check_menu_size(<?php echo $array_menu['id'];?>);" />Small
                                                <span>(+$<?php echo $array_menu['price']; ?>)</span>
                                            <?php } ?>
											<?php if($array_menu['price1']!=''){ ?>
                                                <input name="radio<?php echo $array_menu['id'];?>" type="radio" value="<?php echo $array_menu['price1']; ?>" id="medium<?php echo $array_menu['id'];?>"  onClick="check_menu_size(<?php echo $array_menu['id'];?>);"/>Medium
                                                <span>(+$<?php echo $array_menu['price1']; ?>)</span>
                                            <?php } ?>
                                            <?php if($array_menu['price2']!=''){ ?>
                                                <input name="radio<?php echo $array_menu['id'];?>" type="radio" value="<?php echo $array_menu['price2']; ?>" id="large<?php echo $array_menu['id'];?>"  onClick="check_menu_size(<?php echo $array_menu['id'];?>);"/>Large
                                                <span>(+$<?php echo $array_menu['price2']; ?>)</span>
                                            <?php } ?>
                                        </div>
										<?php } ?>
                                    <?php } ?>
                                    
                                    <h3>Special Instructions</h3>
                                    <textarea name="special_instructions<?php echo $array_menu['id'];?>" id="special_instructions<?php echo $array_menu['id'];?>" cols="" rows=""></textarea>
                                    <h3>Quantity</h3>
                                    <input name="quantity<?php echo $array_menu['id'];?>" id="quantity<?php echo $array_menu['id'];?>" type="text" class="pop_quantity" value="1" />
                                    <?php if($array_menu['size'] == 'multiple'){ $display = 'block'; } else { $display = 'none'; } ?>
                                    <div style="margin-left:10px; margin-bottom:10px; display:<?php echo $display; ?>;" id="add_item_img<?php echo $array_menu['id'];?>">
                                    <img src="images/add_item.jpg" title="Add this item" ></div>
                                    
                                    <?php $sql_select_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$_REQUEST['id']."'"); 
									$num_rows_items = mysql_num_rows($sql_select_items);  ?>
									
                                    <?php if($array_menu['size'] == 'single'){ $display1 = 'block'; } else { $display1 = 'none'; } ?>
                                    <div style="display:<?php echo $display1; ?>; margin-top:0px !important;" id="add_item_btn<?php echo $array_menu['id'];?>">
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
                                <a href="#top_div" onClick="add_item('<?php echo $array_menu['id'];?>')" style="color:#EF7011;"><?php echo $array_menu['menu_name'];?></a>
                                <span style="float:right; padding-right:10px;"><?php //echo $array_menu['price'];?>
                                <?php if($array_menu['size'] == 'single'){ 
								echo "$".$array_menu['price']; }
								else if($array_menu['size'] == 'multiple'){
								if(!empty($array_menu['price'])){
									echo "Small $ ".$array_menu['price']." "; 
								}
								if(!empty($array_menu['price1'])){
									echo "Medium $ ".$array_menu['price1']." "; 
								}
								if(!empty($array_menu['price2'])){
									echo "Large $ ".$array_menu['price2']; 
								}
								}
								?></span>
                                <div style="clear:both;"></div></h2>
                                
                                <div class="highslide-gallery">

<!--
	4) This is how you mark up the thumbnail image with an anchor tag around it.
	The anchor's href attribute defines the URL of the full-size image.
-->
<?php /*?>if($array_menu['menu_pic']!="")
{
?>
<a href="uploaded_images/<?php echo $array_menu['menu_pic'];?>" class="highslide" onClick="return hs.expand(this)"><img src="thumb_images/<?php echo $array_menu['menu_pic'];?>" alt="Highslide JS"
		title="Click to enlarge" /></a>
        <?php
}<?php */?>
<!--
	5 (optional). This is how you mark up the caption. The correct class name is important.
-->

<div class="highslide-caption">
	Caption for the first image.
</div>


</div>
                                
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
                       <h2><?php echo stripslashes($sql_restaurant['restaurant_name']); ?><a href="Javascript:void(0);" onClick="closepopularitem()"><img src="images/cross.png" width="22" height="22" /></a></h2>
                       <p><?php $sql_restaurant_category = mysql_query("SELECT * FROM restaurant_category WHERE id IN(".$sql_restaurant['restaurant_category'].")");?>
						<?php 
                        $i=1;
                        while($result_restaurant_category=mysql_fetch_array($sql_restaurant_category))
                        {?>
                        <span style="padding-right:5px; color:#686868;"><?php echo $result_restaurant_category['category_name']; ?> <?php if($i!=mysql_num_rows($sql_restaurant_category)){ echo ",";
                        }?></span>
                        
                        <?php $i++; }
							?></p>
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
                         <p><?php echo $no_reviews; ?>  Reviews</p>    
                      </div>
                      
                      <div class="clear"></div>
                      </div>
                    <div class="clear"></div>
                    
                    </div>
                    
                    <h2 class="local_reviews"><a href="Javascript:void(0);" onClick="showsidetab()"><?php echo $no_reviews; ?> Reviews </a></h2>
                    
                    		<div class="rstrnt2_mre_info">
                            		<h2 class="popular_item"><a href="Javascript:void(0);" onClick="popularitem()">Full Hours, Cuisines, More Info... </a></h2>
                                    
                                    <p><?php if(!empty($sql_restaurant['phone'])) { echo $sql_restaurant['phone']; }?><br /><br>
									
                                    <span>
									<?php echo $sql_restaurant['restaurant_address'];?><br>
									<?php echo $sql_restaurant['restaurant_city'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_state'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_zipcode'];?></span>
                                    </p>
                                    <div class="pckup">
                                    
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
                                    <div>
                                    <?php if(!empty($sql_delivery['delivery_estimated_time'])){?>
                                    	<h4>Delivery</h4>
                                    	<p><?php echo $sql_delivery['delivery_estimated_time']; ?></p>
                                    <?php } ?>
                                    </div>
                            </div>
                            <?php 
							$sql_select_add = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
							$address = $sql_select_add['restaurant_address']." ".$sql_select_add['restaurant_city']." ".$sql_select_add['restaurant_state']." ".$sql_select_add['restaurant_zipcode'];
							$address_map=str_replace(" ","%20",$address);
							$address_map=str_replace("#","%23",$address_map);?>
                            
                            <div style="margin-left:170px; margin-bottom:5px;" id="show_map">
							<a href="javascript:void(0);" onClick="return show_map();"><h4>Show Map</h4></a>
                            </div>
                            <div style="margin-left:170px; margin-bottom:5px; display:none;" id="hide_map">
							<a href="javascript:void(0);" onClick="return show_map();"><h4>Hide Map</h4></a>
                            </div>
							
                            <div style="width: 160px; margin-left:121px; border:1px solid rgb(255, 177, 113); display:none;" id="map_div"><iframe width="160" height="160" src="http://regiohelden.de/google-maps/map_en.php?width=160&amp;height=160&amp;hl=en&amp;q=<?php echo $address_map; ?>%20+(<?php echo stripslashes($sql_select['restaurant_name'])?>)&amp;ie=UTF8&amp;t=&amp;z=14&amp;iwloc=A&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div>
                            
                            
                            </div>
                        </div>
                        
                        <!----------------------------------   cart------------------------------------------>
                        
                        <div class="rstrnt_right_panel" style="display:<?php echo $display1; ?>;">
                        
                        <div class="rstrnt2_mre_info">
                        <h2 class="restrnt2_order">Your Order</h2>
                        
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
                            <td height="30" align="center">$<?php echo ($array_items['quantity']*$array_items['price']); ?></td>
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
                            <td height="30" colspan="3" align="center" style="padding-top:35px;">&nbsp;</td>
                            <td height="30" align="right" style="padding-top:20px;">Subtotal</td>
                            <td height="30" align="center" style="padding-top:20px;">$<?php echo $amount; ?></td>
                          </tr>
                         </table>
                   <h3 style="text-align:center;">Ready to order? </h3>

					<div class="restro2_delivery" style="background:#8099E9;">
                    		<a href="javascript:void(0);" style="cursor:default; color:#ffffff;"><p><h3>Want Delivery?</h3></p>
                            <?php if($sql_restaurant_delivery_details['minimum_ammount'] > $amount){?>
                            <p style="color:#ffffff;">Add $<?php echo ($sql_restaurant_delivery_details['minimum_ammount'] - $amount); ?></p><?php } ?>
                            <p style="color:#ffffff;">Minimum $<?php echo $sql_restaurant_delivery_details['minimum_ammount']; ?></p></a>
                    </div>
                    <div class="restro2_delivery" style="background:#3C3C95; display:none;">
                    		<a href="javascript:void(0);" style="cursor:default; color:#ffffff;"><p><h3>I Want Delivery!</h3></p>
                            <p style="color:#ffffff;">Delivery $2.00</p>
                            <p style="color:#ffffff;">Total $25.00</p></a>
                    </div>
                    <div class="restro2_pick">
                    		<a href="javascript:void(0);"><p><h3>I'll pick it up</h3></p>
                            <p>Total $<?php echo $amount; ?></p></a>
                    </div>
                    <div>
                    <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    
                    </div>	
                        </div>
                        
                        
                        <!---------------------------------- end cart ----------------------------------------->
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
