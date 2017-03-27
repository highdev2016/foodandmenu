<?php
session_start();
if($_REQUEST['command']=='add' && $_REQUEST['deals']>0){
	if(isset($_SESSION['customer_id'])){
	$pid = $_REQUEST['deals']; // deals id
	$qty = $_REQUEST['deals_qty'];
	addtocart($pid,$qty);
	//print_r($_SESSION['cart']);
	header("location:cart.php");
	exit(); }
	else{
		header("location:login.php");
		$_SESSION['rest_id'] = $_REQUEST['id'];
		exit();
	}
}

?>


<div class="food_cont_bottom">
<?php $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));?>
                        <div class="food_left_side">
                        	<img src="uploaded_images/<?php echo $sql_restaurant['restaurant_image'];?>" />
                           <?php $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$_REQUEST['id']."'"); 
						   if(mysql_num_rows($sql_photo)>0){?> 
                            <div id="wrap">
                            
                            <h1 class="photos">Photo</h1>

  <ul id="mycarouse2" class="jcarousel-skin-tango">
    <div class="highslide-gallery">
<!--
	4) This is how you mark up the thumbnail images with an anchor tag around it.
	The anchor's href attribute defines the URL of the full-size image. Given the captionEval
	option is set to 'this.img.alt', the caption is grabbed from the alt attribute of
	the thumbnail image.
-->
<?php 
while($array_photo = mysql_fetch_array($sql_photo)){ ?>
<a class='highslide' href='uploaded_images/<?php echo $array_photo['image_name'];?>' onclick="return hs.expand(this)">
<img src='thumb_images/<?php echo $array_photo['image_name'];?>' alt='Mountain valley'/></a>
<?php } ?>

	<div class="clear"></div>
</div>
  </ul>

</div>

<div class="clear"></div><?php } ?>

 <?php $sql_select_video = mysql_query("SELECT * FROM restaurant_video WHERE  restaurant_id = '".$_REQUEST['id']."'");
 if(mysql_num_rows($sql_select_video)>0){?>
 <div id="wrap">

<h1 class="photos">Video</h1>

  <ul id="mycarousel" class="jcarousel-skin-tango">
    <div class="highslide-gallery2">
                    <!--
   
<!--<a href="http://www.youtube.com/embed/0Mz4NTozNXw?rel=0" frameborder="0" allowfullscreen" 
		onclick="return hs.htmlExpand(this, {objectType: 'iframe', width: 480, height: 385, 
		allowSizeReduction: false, wrapperClassName: 'draggable-header no-footer', 
		preserveContent: false, objectLoadTime: 'after'})"
        class="highslide">-->
       <?php
	   while($array_video = mysql_fetch_array($sql_select_video)){ ?>
       <a class="video"  title="Video1" href="<?php echo $array_video['video_link'];?>"> 
       <img src="thumb_images/<?php echo $array_video['video_image']?>" class="video_image" /> </a> 
       <?php  } ?>   
<!--   <a class="video"  title="Video1" href="http://www.youtube.com/v/ZeStnz5c2GI?fs=1&amp;autoplay=1"> 
       <img src="images/vid-2.png" class="video_image" /> </a>   
       <a class="video"  title="Video1" href="http://www.youtube.com/v/ZeStnz5c2GI?fs=1&amp;autoplay=1"> 
       <img src="images/vid-3.png" class="video_image" /> </a>   
       <a class="video"  title="Video1" href="http://www.youtube.com/v/ZeStnz5c2GI?fs=1&amp;autoplay=1"> <img src="images/vid-4.png" class="video_image" /> </a>-->

                      <div class="clear"></div> 
                      </div>
  </ul>
  <?php } ?>
  <?php
  if(isset($_SESSION['customer_id']))
  {
  ?>
  <div class="reservation2"><!--<a href="#">Reservation</a>-->
                            
  <ul>
		<li><a id="various3" href="#inline3" title="Lorem ipsum dolor sit amet">Make a Reservation</a><?php if($_REQUEST['status']=="error"){?>&nbsp;<span>The Validation code does not match!</span><?php } ?></li>
	</ul>
    
    <div style="display: none;">
		<div id="inline3" style="width:500px;height:550px;overflow:auto;">
			<div class="profle_wrapper">

<div class="profle_top">

<h1>Reservation Details</h1>

<div class="clear"></div>
</div>

<div class="profle_bottom">
<form name="reservation_form" method="post" action="" onSubmit="return valid();">

<p>Date :</p>
<input name="post_date" type="text"  class="profilefield" id="post_date"/>
<div class="clear"></div>

<p>Time :</p>
<input name="time" id="time" type="text"  class="profilefield"/>
<div class="clear"></div>

<p>How Many People</p>
<input name="how_many_people" id="how_many_people" type="text"  class="profilefield"/>
<div class="clear"></div>

<p>Special Occasions</p>
<input name="special_occasions" id="special_occasions" type="text"  class="profilefield"/>
<input name="profile_id" id="profile_id" type="hidden"  class="profilefield" value="<?php echo $_REQUEST['id']?>"/>
<div class="clear"></div>

<p>Contact Email</p>
<input name="contact_email" id="contact_email" type="text"  class="profilefield"/>
<div class="clear"></div>

<p>Additional Comments</p>
<textarea name="comments" id="comments" cols="" rows="" class="profilearea"></textarea>

<div class="clear"></div>

<p>Captcha</p>
<img src="captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg' style="margin-left:15px;">
<span style="color:#595959; font-family:Arial,Helvetica,sans-serif; font-size:13px;">Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</span>
<div class="clear"></div>

<input id="captcha_code" name="captcha_code" type="text"  class="profilefield_right"/>
<div class="clear"></div>

<input class="profilebutton" type="submit" value="Submit" name="submit">
</form>
</div>

</div>
		</div>
	</div>
</div>
<?php
}
?>

</div>

                            
                        </div> 
                        <div class="food_middle_side">
                            <div class="middle_top">
                            	<h1><?php echo $sql_restaurant['restaurant_name'];?></h1>
                                <ul>
                                    <li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
                                    <li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
                                    <li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
                                    <li><a href="#"><img src="images/star-2.png" width="16" height="16" /></a></li>
                                    <li><a href="#"><img src="images/star-3.png" width="16" height="15" /></a></li>
                                </ul>
                            	<p>62 reviews</p>
                            </div>
                            
                            <div class="category_asian">
                            <?php $sql_restaurant_category = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_category WHERE id = '".$sql_restaurant['restaurant_category']."'"));?>
                            <h1>Categories : <?php echo $sql_restaurant_category['category_name']?></h1>
                            
                            </div>
                            
                        	<div class="clear"></div>
                            <div class="middle_center">
                                <img src="images/address_pic.png" />
                                <p>
                                    <?php echo $sql_restaurant['restaurant_address'];?><br>
                                    <?php echo $sql_restaurant['restaurant_city'];?>,<?php echo $sql_restaurant['restaurant_state'];?>
                                </p>
                            </div>
                        	<div class="clear"></div>
                            <div class="middle_bottom">
                              <img src="images/phone.png" alt="" />
                              <p><?php echo $sql_restaurant['phone'];?></p> 
                            </div>
                            
                        </div>
                        <div class="map_right_side"><!--<img src="images/restaurant_map.png" width="365" height="176" />-->
                        
                        <div class="map_right_field">
                        <?php $sql_deals = mysql_query("SELECT * FROM restaurant_deals WHERE restaurant_id = '".$_REQUEST['id']."' AND deals_status = 1");
						if(mysql_num_rows($sql_deals)){ ?>
                        <h1>Daily Deals</h1>
                        <form name="frm_deals" id="frm_deals" action="" method="post" >
                        <?php while($array_deals = mysql_fetch_array($sql_deals)){ ?>
                        <p><input checked="checked" name="deals" type="radio" value="<?php echo $array_deals['id']; ?>" class="right_radio" /><?php echo $array_deals['daily_name'];?> | Your Price <span>$<?php echo $array_deals['daily_price'];?></span></p>
                        <?php } ?>
                        
                        <select name="deals_qty" id="deals_qty" class="right_list">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        <input type="hidden" name="command" value="add" />
                        <input name="" type="submit" class="right_list_button" value="Add To Cart" />
                        </form>
                        <div class="clear"></div>
                        <?php } ?>
                        <div class="list_style">
                        
                        
                        <div class="clear"></div>
                        
                        
                        <!--<p>Minimun Purches of $37.50</p>-->
                        
                        
                         <?php 
						 if(isset($_SESSION['customer_id'])){
						 $sql_coupons = mysql_query("SELECT * FROM restaurant_coupon WHERE restaurant_id = '".$_REQUEST['id']."' AND coupon_status =1");
						 if(mysql_num_rows($sql_coupons)>1){ ?>
                         
                        <p><a href="#">Gift Certificate Information</a></p> 
                        <h2>Coupons</h2>
                        
                        <!--<img src="images/price_tag.jpg" width="200" height="48" />--> 
                       
						<?php while($array_coupons = mysql_fetch_array($sql_coupons)){ ?>
                        <div class="reservation3"><!--<a href="#">Reservation</a>-->
                            
  <ul>
		<li><a id="various5" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>">
        <img src="thumb_images/<?php echo $array_coupons['coupon_image'];?>" width="68" height="48" /></a></li>
	</ul>
    
    <div style="display: none;">
		<div id="inline4" style="width:450px;height:450px;overflow:auto;">
			<div class="profle_wrapper">

<div class="discount_one">

<div class="discount_one_top">

<div class="discount_top_left"><a href="#"><img src="images/print_coupon.png" width="100" height="60" /></a></div>

<div class="discount_top_right"><a href="#"><img src="images/share.png" width="118" height="41" /></a></div>

<div class="clear"></div>

</div>

<div class="discount_one_botton">

<img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="425" height="300" />

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
                            <?php } } } ?>
                            
                            
                        
                        </div>
                        
                        </div>
                        <div class="clear"></div>
                        
                        </div>
                        
                        <div class="clear"></div>
                        
                    </div>