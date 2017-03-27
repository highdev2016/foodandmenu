<?php
session_start();
//print_r($_SESSI0N);
ob_start();
?>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />
<?php
if(isset($_SESSION['page_type']))
{
	unset($_SESSION['page_type']);
}
function change_dateformat_reverse($date_form1)
	{
	 if($date_form1!=''){
	  $date2=explode("-",$date_form1);
	  $dateformat1=$date2[1]."-".$date2[2]."-".$date2[0];
	  return $dateformat1;
	  }
	 else{
	  $dateformat1='';
	  return $dateformat1;
	  }
	}

if($_REQUEST['command']=='add'){
	if($_REQUEST['deals']>0){
		
	if(isset($_SESSION['customer_id'])){
		//echo $_REQUEST['deals']."<br>";
		//echo $_REQUEST['deals_qty']."<br>";
		//exit();
	$pid = $_REQUEST['deals']; // deals id
	$qty = $_REQUEST['deals_qty'];
	addtocart($pid,$qty);
	//print_r($_SESSION['cart']);
	header("location:cart.php?restaurant_id=".$_REQUEST['id']."");
	exit(); }
	else{
		$_SESSION['page_type']='restaurant';
		$_SESSION['redirect']=$_SERVER['REQUEST_URI'];
		header("location:login.php");
		$_SESSION['resttid'] = $_REQUEST['id'];
		$_SESSION['deal_id'] = $_REQUEST['deal_id'];
		exit();
	}
	}
	else{
		$deal_error = 1;
	}
}

?>

<?php

$ses_rest_id = $_REQUEST['id'];
if($_REQUEST['apply'] == 'Apply')
{
	$coupon_code = $_REQUEST['coup_code_top'];
	$sql_check_cart = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".session_id()."' AND restaurant_id = '".$_REQUEST['hid_res_id']."'");
	
	$cart_num_row = mysql_num_rows($sql_check_cart);
	
	$sql_select_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$coupon_code."'"));
	
	if($cart_num_row > 0)
	{		
		if($_SESSION['group_order_details_id'.$ses_rest_id]!=''){
			$_SESSION['coupon_code'.$ses_rest_id."_".$_SESSION['group_order_details_id'.$ses_rest_id]] = $sql_select_coupon['coupon_code'];
		}
		
		$_SESSION['coupon_code'.$ses_rest_id] = $sql_select_coupon['coupon_code'];
		$cart_amount = 0;
		while($array_items = mysql_fetch_array($sql_check_cart)){
			$cart_amount = $cart_amount + ($array_items['price']*$array_items['quantity']); 
		}
		
		if($sql_select_coupon['minimum_order_amount'] < $cart_amount)
		{
			if($sql_select_coupon['discount']!=0.00)
			{
				$coupon_discount = ($sql_select_coupon['discount']*$cart_amount)/100;
			}
			else
			{
				$coupon_discount = $sql_select_coupon['coupon_price'];
			}
		}
		else
		{
			if($_SESSION['group_order_details_id'.$ses_rest_id]!=''){
				$_SESSION['coupon_code'.$ses_rest_id."_".$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
				$_SESSION['coupon_discount'.$ses_rest_id."_".$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
			}
			
			$_SESSION['coupon_code'.$ses_rest_id] = '';
			$_SESSION['coupon_discount'.$ses_rest_id] = '';
			header("location:restaurant.php?id=".$_REQUEST['hid_res_id'].'&error_msg=8');
			
		}
		if($_SESSION['group_order_details_id'.$ses_rest_id]!=''){
			$_SESSION['coupon_discount'.$ses_rest_id."_".$_SESSION['group_order_details_id'.$ses_rest_id]] = $coupon_discount;
		}
		$_SESSION['coupon_discount'.$ses_rest_id] = $coupon_discount;
		//header("location:restaurant.php?id=".$_REQUEST['hid_res_id']."");
	}
	else
	{
		if($_SESSION['group_order_details_id'.$ses_rest_id]!=''){
			$_SESSION['coupon_code'.$ses_rest_id."_".$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
			$_SESSION['coupon_discount'.$ses_rest_id."_".$_SESSION['group_order_details_id'.$ses_rest_id]] = '';
		}
		$_SESSION['coupon_code'.$ses_rest_id] = '';
		$_SESSION['coupon_discount'.$ses_rest_id] = '';
		header("location:restaurant.php?id=".$_REQUEST['hid_res_id']."");
	}
}

?>

<script type="text/javascript">
function printDiv(no,coupon_id,restaurant_id)
{
	var $j = jQuery.noConflict();
	$j.ajax({

			url : 'use_coupon.php',
			type : 'POST',
			data : 'coupon_id='+coupon_id+'&restaurant_id='+restaurant_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
                if(data == "success")
				{
					
					var divToPrint=document.getElementById('coupon_image'+no);

					var newWin=window.open('','Print-Window','width=768,height=1024,top=50,left=100');
					newWin.document.open();
						newWin.document.write('<html><head><style>#in {display:none}</style><body   onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
					newWin.document.close();

				}

			},

			/*complete : function(jqXHR, textStatus){

				alert(3);

			},*/

			error : function(jqXHR, textStatus, errorThrown){

			}	

		});
	
	
	

//setTimeout(function(){newWin.close();},10);

}
</script>
<!--<script type="text/javascript" src="raty-master/demo/js/jquery.min.js"></script>-->
<script type="text/javascript" src="raty-master/lib/jquery.raty.js"></script>

<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />
<script>
/*var $j = jQuery.noConflict();
  $j(function() {
	$j('#time').timepicker({ 'timeFormat': 'h:i A' });
  });*/
</script>

<script type="text/javascript">

function add_favourite(res_id,user_id)
{
	var $j = jQuery.noConflict();
	if(user_id != '')
	{
		$j.ajax({
			url : 'add_favourite.php',
			type : 'POST',
			data : 'res_id=' + res_id + '&user_id=' + user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				if(data != "You have already added this Restaurant as Favourite!!")
				{
					$j("#favourite_p").hide().html(data).fadeIn(1000);
				}
				else
				{
					alert(data);
					window.location.href='restaurant.php?id='+res_id;
				}
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
	}
	else
	{
		window.location.href='login.php';
	}
}

</script>

<script type="application/javascript">
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '646665315362675',                            
      status     : true,                                 
      xfbml      : true                                  
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/all.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

function FBShareOp(name,id,image,desc,folder_name){
	var restaurant_name = name;
	var description	   =	desc;
	var share_image	   =	'https://foodandmenu.com/'+folder_name+'/'+image;
	var share_url	   =	'https://foodandmenu.com/restaurant.php?id='+id;	
    var share_capt     =    'caption';
    FB.ui({
        method: 'feed',
        name: restaurant_name,
       link: share_url,
       picture: share_image,
        //caption: share_capt,
       description: description

    }, function(response) {
        if(response && response.post_id){}
        else{}
    });

}

</script>




<style type="text/css">
.ui-timepicker-wrapper{
	width:202px !important;
}

.flexslider .slides img {
    display: block;
    height: auto;
    width: 100%;
	margin:25px 0 0;
}

.carousel-flex .slides img{
    border: 1px solid #dddddd;
    height: 60px;
    padding: 2px;
    width: 88%;
	margin:0 0 15px;
}

/*.carousel-flex .slides > li{
	width:111px !important;
}*/

.carousel-flex .flex-direction-nav a{
	top:23%;
}

.flex-viewport {
    max-height: 390px;
	width: 546px;
	margin:0 auto;
}

.l-contnt{
	max-height:550px;
	overflow:visible;
}

.white_content_new{
	top:5%;
}

.black_pop_bg{
	background: rgba(255, 255, 255, 1);
    border: none;
    box-shadow: none;
    padding: 0;
    width: 45%;
}

.flex-direction-nav .flex-next{
	right:-7px;
}

.flex-direction-nav .flex-prev{
	left: -6px;
}

.food_left_side img{
	margin: 12px 0;
}

.close-new{
	background: transparent url("../images/cross.png") no-repeat scroll 0 0 !important;
    right: 4px;
    top: 12px;
}

.slide_head{
	background: rgba(0, 0, 0, 0) url("../images/left_feature_middle.png") repeat scroll 0 0;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    padding: 10px 16px;
}

.slide_head h1{
	color: #ffffff;
    font: 20px "calibri";
	margin:0;
}

#fancybox-close{
	background:url("../images/cross.png") no-repeat;
	right:11px;
	top:11px;
}

#fancybox-outer{
	border-radius:5px;
}

.profle_wrapper{
	border-radius:5px;
}

.profle_wrapper_list{
	margin: 0 auto;
    width: 484px;
	border-radius:5px;
}

.discount_top_left {
    margin: 11px 0 0;
}

</style>

<?php $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));?>
<div class="food_cont_top title-top">
	<h1><?php echo $sql_restaurant['restaurant_name']; ?></h1>
    <div>
    <?php $rating = number_format(getRestaurantRating($sql_restaurant['id']),1); ?>
        <script type="text/javascript" language="javascript">
        jQuery(function() {
            jQuery(".stars").each(function() {
                jQuery(this).raty({
                    start: jQuery(this).text(),
                    readOnly: true,
                    score: <?php echo $rating; ?>
                });
            });
        });
        </script>
        <div class="restu_top_review" style="float:left; padding-left:0; width:100px;">
        <a href="review.php?id=<?php echo $_REQUEST['id']; ?>"> 
       		<div class="stars"></div>
        </a>
        </div>
        <?php  
         $total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$_REQUEST['id']."' AND status=1"));
        ?>
        <p style="float:left; padding-top:2px; width:100px;">
        <a href="review.php?id=<?php echo $_REQUEST['id']; ?>"><?php echo $total_review; ?> reviews </a></p></div>
        
        
        <div class="social_image social_image2">

                            <div class="soc_icon">
                            <?php /*?><a href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>"  target="_blank"><?php */?>
                            <a href="javascript:void(0);" onClick="FBShareOp('<?php echo $sql_restaurant['restaurant_name']; ?>','<?php echo $sql_restaurant['id']; ?>','<?php echo $sql_restaurant['restaurant_image']; ?>','<?php echo $sql_restaurant['restaurant_category_name']; ?>','uploaded_images')">
                            <img src="images/facebook_share.png" /></a></div>
                            
                            
                            <div class="soc_icon"><a href="http://twitter.com/home?status=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>" target="_blank"><img src="images/twitter_logo.png" /></a></div>
                            
                            <div class="soc_icon"><a href="mailto:<?php echo $sql_restaurant['email']; ?>" target="_top"><img src="images/mail_icon.png" /></a></div>
                            
                            <!-- Place this tag where you want the +1 button to render. -->
                            <div class="g-plusone soc_icon" data-annotation="inline" data-width="300"></div>
                            <!-- Place this tag after the last +1 button tag. -->
                            <script type="text/javascript">
                              (function() {
                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                po.src = 'https://apis.google.com/js/platform.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                              })();
                            </script>
                            
                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:330px; height:24px;"></iframe></div>
                            
                            <div class="clear"></div>
                            
                            </div>
        
        <div class="clear"></div>
    
    
	
</div>
<div class="food_cont_bottom">

<div class="food_left_side">
<div class="restu_top_pic">
<?php if($sql_restaurant['restaurant_image']!='') {?>
    <img src="uploaded_images/<?php echo $sql_restaurant['restaurant_image'];?>" />
    <?php } else { ?>
    <img src="images/no_image.png" /><?php } ?>
   <?php $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$_REQUEST['id']."'"); 
   if(mysql_num_rows($sql_photo)>0){?> 
    <div id="wrap">
    
    <h1 class="photos">Photo</h1>

<ul id="mycarouse2" class="jcarousel-skin-tango highslide-gallery">

<?php 
while($array_photo = mysql_fetch_array($sql_photo)){ ?>
<li><a class="highslide" href='javascript:void(0);' onclick="open_slider_div();">
<img src='thumb_images/<?php echo $array_photo['image_name'];?>' width="39" height="39"/></a></li>
<?php } ?>



<div class="clear"></div>

</ul>

</div>

<div class="clear"></div><?php } ?>
</div>

<?php $sql_photo1 = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$_REQUEST['id']."'");
	$sql_photo2 = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$_REQUEST['id']."'");
 ?>

<div id="slider_div" style="visibility:hidden;" class="white_content_new black_pop_bg"  >
<div class="slide_head"><h1><?php echo $sql_restaurant['restaurant_name']; ?></h1></div>
<div class="close close-new" onclick="close_slider_div();"><a href = "javascript:void(0);"> </a> </div>
<div class="l-contnt up-contnt"> 
    <div id="slider" class="flexslider slider_flex">
        <ul class="slides">
        <?php while($array_photo1 = mysql_fetch_array($sql_photo1)){ ?>
            <li>
                <div><img src="uploaded_images/<?php echo $array_photo1['image_name'];?>"></div>
            </li>
        <?php } ?>
        </ul>

    </div>

    <div id="carousel" class="flexslider carousel-flex">
        <ul class="slides">
        <?php while($array_photo2 = mysql_fetch_array($sql_photo2)){ ?>
            <li><img src="uploaded_images/<?php echo $array_photo2['image_name'];?>"></li>
        <?php } ?>    
        </ul>
    </div>

</div>
</div>
<div id="fade1" class="black_overlay"> </div>

<?php $sql_select_video = mysql_query("SELECT * FROM restaurant_video WHERE  restaurant_id = '".$_REQUEST['id']."'");
if(mysql_num_rows($sql_select_video)>0){?>
<div id="wrap" style="width:515px;">

<h1 class="photos">Video</h1>

<ul id="mycarousel" class="jcarousel-skin-tango highslide-gallery2">

<?php
while($array_video = mysql_fetch_array($sql_select_video)){ ?>
<li><a class="video"  title="Video1" href="<?php echo $array_video['video_link'];?>" target="_blank">
<?php if($array_video['video_image']!=''){?> 
<img src="thumb_images/<?php echo $array_video['video_image']?>" class="video_image" />
<?php } else { ?> 
<img src="images/no_image.png" class="video_image" />
<?php } ?>
</a> </li>
<?php  } ?>
<div class="clear"></div> 

</ul>
<?php } ?>


<?php
$sql_additional_reservation=mysql_fetch_array(mysql_query("SELECT reservation from restaurant_services_dress_payment WHERE restaurant_id=".$_REQUEST['id'].""));
//echo $sql_additional_reservation['reservation'];
if($sql_additional_reservation['reservation']==1)
{
$rand_id = time();
?>
<?php /*?><div class="reservation2" style="width:141px; float:left;"><!--<a href="#">Reservation</a>-->
    
<ul>
<li><?php if(isset($_SESSION['customer_id'])){?><a id="various3" href="#inline<?php echo $rand_id; ?>" title="Make a Reservation"><?php } else { $_SESSION['page_type']='reservation';
$_SESSION['redirect']=$_SERVER['REQUEST_URI']; ?><a href="login.php" > 
<?php $_SESSION['resttid'] = $_REQUEST['id'];
$_SESSION['deal_id'] = $_REQUEST['deal_id']; } ?>

Make a Reservation</a><?php if($_REQUEST['status']=="error"){?>&nbsp;<span>The Validation code does not match!</span><?php } ?>
<?php if($_REQUEST['status']=="success"){?>&nbsp;<span style="color:#404CA1">Your request has been sent successfully !</span><?php } ?>



</li>
</ul>

<div id="cap_success_msg" style="color:#57BD18;display:none; width:286px; margin-top:10px;">Your Request has been sent Successfully. </div>

<div style="display: none;">
<div id="inline<?php echo $rand_id; ?>" style="width:500px;height:550px;overflow:auto;">
<div class="profle_wrapper">



</div>
</div>
</div>
</div><?php */?>
<?php
}
?>


<div class="clear"></div>

<div style="margin-top:10px;">
<!-- AddThis Button BEGIN -->
<!-- AddThis Button END -->

<!-- AddThis Button BEGIN -->
<!--<div class="addthis_toolbox addthis_default_style " style="width:400px; float:left;">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<?php /*?><a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a><?php */?>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5160175349da4375"></script>-->
<!-- AddThis Button END -->
<div class="clear"></div>
</div>

</div>

    
    
    
</div> 
                        <div class="food_middle_side">
                            <div class="middle_top">
                             
                            </div>
                         <div class="clear"></div>   
                            <div class="category_asian">
                            <?php $sql_restaurant_category = mysql_query("SELECT * FROM restaurant_category WHERE id IN(".$sql_restaurant['restaurant_category'].")");?>
                           <div class="category_pic" style="border-radius: 3px; margin: 10px 0 0 10px; padding: 4px 5px;">
                           <img src="images/category-icon.png" width="20" height="22" style="float:left;" /> 
                           <h1 style="font-size: 19px; line-height: 20px; padding: 0 0 5px; float:left; width:100px;" >Categories - </h1><?php //echo $sql_restaurant_category['category_name'] 
											$i=1;
							                 while($result_restaurant_category=mysql_fetch_array($sql_restaurant_category))
											 {?>
											<span style="color: #686868; font-size: 14px; font-weight: normal; float:left; padding-left:5px; padding-top:2px; padding-right: 5px;   width:124px; float:left; display:block;"><?php echo $result_restaurant_category['category_name']; ?> <?php if($i!=mysql_num_rows($sql_restaurant_category)){ echo ",";
											}?></span>
                                            
											 <?php $i++; }
							?>
                            <div class="clear"></div>
                            <div class="clear"></div>
                            </div>
                            </div>
                            
                        	<div class="clear"></div>
                            <div class="middle_center">
                                <img src="images/address_pic.png" />
                                <p>
                                    <?php echo $sql_restaurant['restaurant_address'];?></p>
                                 <p style="padding-top:0px; padding-left:38px;"><?php echo $sql_restaurant['restaurant_city'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_state'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_zipcode'];?>
                                </p>
                            </div>
                        	<div class="clear"></div>
                            <div class="middle_bottom">
                              <img src="images/phone.png" alt="" style="margin-top:7px;" />
                              <p style="padding-top:7px;"><?php echo $sql_restaurant['phone'];?></p> 
                            </div>
                            
                            <?php
							$check_favourite = mysql_num_rows(mysql_query("SELECT id FROM restaurant_favourite WHERE user_id = '".$_SESSION['customer_id']."' AND restaurant_id = '".$_REQUEST['id']."'"));
							?>
							  <p id="favourite_p" class="fav-p" style="float:left; margin-top:35px;">
							  <?php
							  if($check_favourite == 0)
							  {
							  ?>
							  <a href="javascript:void(0);" class="right_list_button" onclick="add_favourite('<?php echo  $_REQUEST['id']; ?>','<?php echo $_SESSION['customer_id']; ?>');" style="color:#ffffff; text-decoration:none;">Add to Favourite</a>
							  <?php
							  }
							  else
							  {
							  ?>
							  <a href='javascript:void(0);' class='right_list_button'  style='color:#ffffff; text-decoration:none; cursor:default;'>Added to Favourite</a>
							  <?php  
							  }
							  ?>
                              </p>
                            
                            <?php /*?><?php if($sql_restaurant['website']!=""){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['website']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/website.png" alt="" style="margin-top:7px;"  />
                              <p style="padding-top:7px;">Website</p>
                              </a>
                            </div>
                           <?php
							}
							?>
                            
                            <?php if($sql_restaurant['restaurant_facebook_url']!="" && $sql_restaurant['restaurant_facebook_url']!="#"){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['restaurant_facebook_url']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/facebook.png" alt="" style="margin-top:7px;" width="18px"  />
                              <p style="padding-top:5px;">Facebook</p>
                              </a>
                            </div>
                           <?php
							}
							?>
                            
                            <?php if($sql_restaurant['restaurant_twitter_url']!="" && $sql_restaurant['restaurant_twitter_url']!="#"){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['restaurant_twitter_url']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/twitter.png" alt="" style="margin-top:7px;" width="18px" />
                              <p style="padding-top:5px;">Twitter</p>
                              </a>
                            </div>
                           <?php
							}
							?>
                            
                            <?php if($sql_restaurant['restaurant_google_plus_url']!="" && $sql_restaurant['restaurant_google_plus_url']!="#"){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['restaurant_google_plus_url']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/google_plus.png" alt="" style="margin-top:7px;" width="18px" />
                              <p style="padding-top:5px;">Google Plus</p>
                              </a>
                            </div>
                           <?php
							}
							?>
                            
                            <?php if($sql_restaurant['restaurant_urbanspoon_url']!="" && $sql_restaurant['restaurant_urbanspoon_url']!="#"){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['restaurant_urbanspoon_url']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/urbanspoon.png" alt="" style="margin-top:7px;" width="18px" />
                              <p style="padding-top:5px;">Urbanspoon</p>
                              </a>
                            </div>
                           <?php
							}
							?><?php */?>
                            
                            
                        </div>
                        <div class="map_right_side deal_side deal_site_top"><!--<img src="images/restaurant_map.png" width="365" height="176" />-->
                        
                        <div class="map_right_field deal_side">
                        <?php if($deal_error == 1){ ?>
                        <p style="color:#ff0000; padding-bottom:0px; font-size:14px; padding-top:18px; font-size:16px; margin-left:10px;">Please select deal.</p>
                        <?php } ?>
                        <?php $sql_deals = mysql_query("SELECT * FROM restaurant_deals WHERE restaurant_id = '".$_REQUEST['id']."' AND (expiry_date	> '".date('Y-m-d')."' OR expiry_date ='0000-00-00')");
						if(mysql_num_rows($sql_deals)){ ?>
                        <h1>eGift Certificate Hot Deals</h1> 
                                               
                        <form name="frm_deals" id="frm_deals" action="" method="post">
                        <?php 
						$dl = 1;
						while($array_deals = mysql_fetch_array($sql_deals)){ ?>
                          <div class="certi_date">
                        <div style="float:left; width:30px;"><input name="deals" type="radio" value="<?php echo $array_deals['id']; ?>" class="right_radio deal_radio" <?php if($array_deals['id'] == $_REQUEST['deal_id']){?> checked="checked" <?php } ?>/></div>
                        <div style="float:left; width:278px;"> 
						<p style="padding:5px 0px !important;">$<?php echo $array_deals['daily_description'];?> / Your Price $<?php echo $array_deals['daily_price'];?>  /  Expiry Date : <?php echo date("m-d-Y", strtotime($array_deals['expiry_date'])); ?></p></div>
                       <!-- <div class="clear"></div>-->
                        
                          <div class="more_but">
                          <a class="various5" href="#inline_<?php echo $dl; ?>" title="More Info" style="text-decoration:none;">
                          <p class="right_list_button" style="width:84px; color:#FFF; font-size:15px; text-align:center; padding:5px;">More Info</p></a>
                          </div>
                          
                          <div style="display: none;">
                            <div id="inline_<?php echo $dl; ?>" style="width:561px;height:250px;overflow:auto;">
                                <div class="profle_wrapper restu_profile" style="margin:0;">
                                    <div class="profle_top">
                                        <div class="clear"></div>
                                        </div>
                                            <div class="profle_bottom" style="width:521px;">
                                            <h2><?php echo $array_deals['disclaimer_title']; ?></h2>
                                            <p><?php echo $array_deals['disclaimer']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        <div class="clear"></div>
                        </div>
                        <?php $dl++; } ?>
                        <div style="float:right;">
                        <select name="deals_qty" id="deals_qty" class="right_list">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        <input type="hidden" name="command" value="add" />
                        <input name="submit" type="submit" class="right_list_button" value="Add To Cart" onclick="return radio_check();" />
                        
                        </div>
                        </form>
                        
                        <div class="clear"></div>
                        <?php } ?>
                        <div class="list_style">
                        
                        
                        <div class="clear"></div>
                        
                        
                        <!--<p>Minimun Purches of $37.50</p>-->
                           
                        
                         <?php 
						 //if(isset($_SESSION['customer_id'])){
						 $sql_coupons = mysql_query("SELECT * FROM restaurant_coupon WHERE restaurant_id = '".$_REQUEST['id']."' AND coupon_status =1 AND end_date >= '".date('Y-m-d')."' AND show_coupon = 1");
						 if(mysql_num_rows($sql_coupons)>0){ ?>
                         
                         <?php if($_REQUEST['cou_use'] == 1){ ?>
                         <p style="font-size:15px; font-weight:bold; color:#000000;">Coupon Used Successfully.</p>
                         <?php } ?> 
                         
                        <!--<p><a href="#">Gift Certificate Information</a></p>--> 
                        <h2>Online Coupons</h2>
                        
                        <!--<img src="images/price_tag.jpg" width="200" height="48" />--> 
                       
                      
						<?php 
						$i=1;
						while($array_coupons = mysql_fetch_array($sql_coupons)){
							
							if(($array_coupons['online_redeem'] == '0' && $array_coupons['coupon_print'] > 0) || ($array_coupons['online_redeem'] == '1' && $array_coupons['apply_coupon'] > 0)){
							?>
                        
                         <form action="" method="post" name="coupon_frm" id="coupon_frm" >
                         
                         <input type="hidden" name="coup_code_top" id="coup_code_top" value="<?php echo $array_coupons['coupon_code']; ?>" />
                        <div class="reservation3"><!--<a href="#">Reservation</a>-->
                            
  <ul>
		<li><?php if(isset($_SESSION['customer_id'])){?>
        <?php if($array_coupons['coupon_image']!=''){?>
        <a class="various6" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>" style="text-decoration:none;"><img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="95" height="70" /></a>
        <?php } else { ?>
        <a class="various6" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>" style="text-decoration:none;"><img src="images/no_image.png" width="95" height="70" /></a><?php } }else{?><a href="login.php?coupon=1&restaurant_id=<?php echo $_REQUEST['id']; ?>">
        <?php if($array_coupons['coupon_image']!=''){?>
        <img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="95" height="70" />
        <?php } else { ?>
        <img src="images/no_image.png" width="95" height="70" />
        <?php } ?>        
        </a> <?php } ?>
        <p style="font-weight:bold"><?php echo $array_coupons['coupon_description'];?></p>
        <?php
		if($array_coupons['coupon_code'] != '' && $array_coupons['show_coupon_code'] == 1)
		{
		?>
        Coupon Code <p class="cupon-code" style="font-weight:bold"><?php echo $array_coupons['coupon_code'];?></p>
        <?php
		}
		?>
       <?php
	   $sql_check_cart_check = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".session_id()."' AND restaurant_id = '".$_REQUEST['id']."'");
	   
		$cart_num_row_check = mysql_num_rows($sql_check_cart_check);
		
		$cart_amount = 0;
		while($array_items = mysql_fetch_array($sql_check_cart_check)){
			$cart_amount = $cart_amount + ($array_items['price']*$array_items['quantity']); 
		}
	
		$sql_select_coupon_check = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$array_coupons['coupon_code']."'"));	
		
	    if($cart_num_row_check > 0)
		{
			if($sql_select_coupon_check['online_redeem'] == 1){
			//if($sql_select_coupon_check['minimum_order_amount'] < $cart_amount)
			//{
		?>
       	 <input type="submit" name="apply" value="Apply" class="coupon-apply" />
        <?php
			//}
			}else{
				if(isset($_SESSION['customer_id'])){
				 ?>
				 <a class="various6 coupon-apply" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>" style="text-decoration:none;">Print Coupon</a>  
		<?php }else{ ?>
				 <a href="login.php" class="coupon-apply" style="text-decoration:none;">Print Coupon</a>
        <?php			
				}
				}
		}
		?>
        </li>
	</ul>
    
    <div style="display: none;">
		<div id="inline<?php echo $array_coupons['id'];?>" style="width:550px; height:450px;overflow:auto;">
			<div class="profle_wrapper_list">

                <div class="discount_one">
                
                <div class="discount_one_top">
                
                <?php //if($array_coupons['online_redeem'] == '0'){ ?>
                
                <div class="discount_top_left"><a href="javascript:void(0);" onclick="printDiv('<?php echo $i ?>','<?php echo $array_coupons['id']; ?>','<?php echo $_REQUEST['id']; ?>');"><img src="images/print_coupon.png" width="100" height="60" /></a></div>
                
                <?php //} ?>
                
               
                
                <div class="discount_top_right">
                <?php /*?><a href="restaurant.php?use_coupon=<?php echo $array_coupons['id']; ?>&restaurant_id=<?php echo $_REQUEST['id']; ?>" onclick="return confirm('Are you Sure?');" style="text-decoration:none;"><span style="color:#EB6E00; font-weight:bold;"> Use Coupon </span></a><?php */?>
                <a href="#"><img src="images/share.png" width="118" height="41" onclick="fbpublish('<?=addslashes($array_coupons['coupon_name'])?>','<?=addslashes($array_coupons['coupon_description'])?>','<?=addslashes($array_coupons['coupon_image'])?>')" style="float: right; margin-right: 5px; margin-top: 30px;"/></a></div>
                
                <div class="clear"></div>
                
                </div>
                
                <div class="clear"></div>
                <div class="discount_one_botton" id="coupon_image<?php echo $i?>">
                <?php if($array_coupons['coupon_image']!=''){?>
                <img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="425" height="300" />
                <?php } else { ?>
                <img src="images/no_image.png" width="425" height="300" />
                <?php } ?>
                <?php if($array_coupons['coupon_code']!=''){?>
                Coupon Code : <span class="cupon-code" style="font-weight:bold;"><?php echo $array_coupons['coupon_code']; ?></span>
                <?php } ?>
                
                </div>
                
                
                
                <!--<ul>
                
                <li><img src="images/coupon-1.jpg" width="425" height="300" /></li>
                
                </ul>-->
                <div class="clear"></div>
                </div>

</div>
		</div>
	</div>
                            </div>
                            <input type="hidden" name="hid_res_id" value="<?php echo $_REQUEST['id']; ?>" />
                            </form>
                            
                            
                            <?php 
							}
							$i++;
							} } //} ?>
                             
                            <div class="clear"></div>
                            <?php /*?><?php
						 $num_disclaimer=mysql_num_rows(mysql_query("SELECT * FROM restaurant_disclaimer WHERE restaurant_id='".$_REQUEST['id']."'"));?> 
                          <?php $result_disclaimer=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_disclaimer WHERE restaurant_id='".$_REQUEST['id']."'"));?> 
                          <?php
						  if($num_disclaimer>0)
						  { 
						  ?>
                          <a id="various5" href="#inline5" title="Click here for More Information" style="text-decoration:none;">
                          <p class="right_list_button" style="width:170px; color:#FFF">Click here for More Information</p></a>
                          <?php
						  }
						  ?>  <?php */?>
                            
                        
                        </div>
                        
                        </div>
                        <div class="clear"></div>
                        
                        </div>
                        
                        
                        
                        <div class="clear"></div>
                        
                    </div>
                    
                    <?php /*?><div class="social_image social_image2">

                            <div class="soc_icon">
                            <a href="javascript:void(0);" onClick="FBShareOp('<?php echo $sql_restaurant['restaurant_name']; ?>','<?php echo $sql_restaurant['id']; ?>','<?php echo $sql_restaurant['restaurant_image']; ?>','<?php echo $sql_restaurant['restaurant_category_name']; ?>','uploaded_images')">
                            <img src="images/facebook_share.jpg" /></a></div>
                            
                            
                            <div class="soc_icon"><a href="http://twitter.com/home?status=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>" target="_blank"><img src="images/twitter_logo.png" /></a></div>
                            
                            <div class="soc_icon"><a href="mailto:<?php echo $sql_restaurant['email']; ?>" target="_top"><img src="images/mail_icon.png" /></a></div>
                            
                            <!-- Place this tag where you want the +1 button to render. -->
                            <div class="g-plusone soc_icon" data-annotation="inline" data-width="300"></div>
                            <!-- Place this tag after the last +1 button tag. -->
                            <script type="text/javascript">
                              (function() {
                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                po.src = 'https://apis.google.com/js/platform.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                              })();
                            </script>
                            
                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:330px; height:24px;"></iframe></div>
                            
                            <div class="clear"></div>
                            
                            </div><?php */?>
                    
<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
<script type="text/javascript">

/*jQuery(document).ready(function() {
jQuery('#mycarousel').jcarousel();
});*/

jQuery(document).ready(function() {
jQuery('#mycarouse2').jcarousel();
});


</script>


<script type="text/javascript">
var $j = jQuery.noConflict();
function open_slider_div()
{
	$j("#slider_div").css('visibility','visible');
	$j("#slider_div").css('opacity','1');
	$j("#fade1").show();
}

function close_slider_div()
{
	$j("#slider_div").css('visibility','hidden');
	$j("#slider_div").css('opacity','0');
	$j("#fade1").hide();
}

</script>

<script type="text/javascript" src="js/jquery.flexslider.js"></script>
<script type="text/javascript">
var $j = jQuery.noConflict();
//$j(window).load(function() {
  // The slider being synced must be initialized first
  $j('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 100,
    itemMargin: 5,
    asNavFor: '#slider'
  });
 
  $j('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"
  });
//});
</script>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<script language="Javascript">

FB.init({ 
	appId: '173774529467714', 
	status: true, 
	cookie: true,
	xfbml : true 
});
function fbpublish(msg,address,pict) {
	var publish = {
		method: 'stream.publish',
		display: 'popup',
		name: 'FOOD AND MENU',
		picture: 'https://foodandmenu.com/uploaded_images/'+pict,
		caption: '',
		description: (
			'<b>'+msg+'</b><center></center>'+address+'<center></center>'
		),
		href: 'https://foodandmenu.com/'
	};
	FB.ui(publish);
}
</script>

