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
		$_SESSION['resttid'] = $_REQUEST['id'];
		exit();
	}
}


if(isset($_REQUEST['submit'])){
if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['captcha_code']) != 0)
	{  
		//$msg1 = "The Validation code does not match!";
		header("location:profile.php?id=".$_REQUEST['profile_id'].'&status=error');

	}
	else{
		
		$sql_username = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
		$sql_res_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
			$post_date=date('d-m-Y');
			$time=$_POST['time'];
			$how_many_people=$_POST['how_many_people'];
			$special_occasions=$_POST['special_occasions'];
            $contact_email=$_POST['contact_email'];
			$comments=$_POST['comments'];
			$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello Admin,</p>

            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">User Reservation Details are as follows.</p>
							
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Date : '.$post_date.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Time : '.$time.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">How many People : '.$how_many_people.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Special Ocassions : '.$special_occasions.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Comments : '.$comments.'</p>

             			<div style="clear:both;"></div>

 						<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>

						<div style="clear:both;"></div>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>

						<div style="clear:both;"></div>

						</div>

						<div style="clear:both;"></div>

						<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >

						<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">

Sent to you from Food & menu</h4>

					</div>

				</div>

				<div style="clear:both;"></div>

				</div>';

            //$email= 'sandeep.pandita@hotmail.com';
			$email = 'support@foodandmenu.com';
			//$email = 'priya@infosolz.com';
			$from = $contact_email;

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message=$cms_rep;

			$subject="Reservation Request";

			mail($email,$subject,$message,$headers);
			
			
			
			
			$cms_rep1 = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello ,'.$sql_username['firstname'].'</p>

            				
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Thanks for the resevation at '.$sql_res_name['restaurant_name'].'</p>
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Information about the reservation</p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Date : '.$post_date.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Time : '.$time.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">How many People : '.$how_many_people.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Special Ocassions : '.$special_occasions.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Contact Email : '.$_REQUEST['contact_email'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Comments : '.$comments.'</p><br>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">You will get an email once your reservation has been confirmed ! Thanks </p>
             			<div style="clear:both;"></div>

 						<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>

						<div style="clear:both;"></div>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>

						<div style="clear:both;"></div>

						</div>

						<div style="clear:both;"></div>

						<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >

						<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">

Sent to you from Food & menu</h4>

					</div>

				</div>

				<div style="clear:both;"></div>

				</div>';

			$from1 = "support@foodandmenu.com";

			$headers1 = "From:".$from1."\nReply-To: ".$from1."\nReturn-Path: ".$from1."\nX-Mailer: PHP\n";

			$headers1 .= 'MIME-Version: 1.0' . "\r\n";

			$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message1=$cms_rep1;

			$subject1="Reservation Confirmation mail";

			mail($contact_email,$subject1,$message1,$headers1);
	}
}


?>


<script type="text/javascript" src="raty-master/demo/js/jquery.min.js"></script>
<script type="text/javascript" src="raty-master/lib/jquery.raty.js"></script>

<div class="food_cont_bottom">
<?php $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));?>
                        <div class="food_left_side">
                        <?php if($sql_restaurant['restaurant_image']!='') {?>
                        	<img src="uploaded_images/<?php echo $sql_restaurant['restaurant_image'];?>" />
                            <?php } else { ?>
                            <img src="images/no_image.png" /><?php } ?>
                           <?php $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$_REQUEST['id']."'"); 
						   if(mysql_num_rows($sql_photo)>0){?> 
                            <div id="wrap">
                            
                            <h1 class="photos">Photo</h1>

  <ul id="mycarouse2" class="jcarousel-skin-tango">
    <div class="highslide-gallery">
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
       <a class="video"  title="Video1" href="<?php echo $array_video['video_link'];?>" target="_blank"> 
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
 
  <div class="reservation2"><!--<a href="#">Reservation</a>-->
                            
  <ul>
		<li><?php if(isset($_SESSION['customer_id'])){?><a id="various3" href="#inline3" title="Lorem ipsum dolor sit amet"><?php } else { ?><a href="login.php" > 
<?php $_SESSION['resttid'] = $_REQUEST['id']; } ?>

        Make a Reservation</a><?php if($_REQUEST['status']=="error"){?>&nbsp;<span>The Validation code does not match!</span><?php } ?></li>
	</ul>
    
    <div style="display: none;">
		<div id="inline3" style="width:500px;height:550px;overflow:auto;">
			<div class="profle_wrapper">

<div class="profle_top">

<h1>Reservation Details</h1>

<div class="clear"></div>
</div>
<?php /*?><script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" language="javascript">
	$(function() {
		$( "#post_date" ).datepicker();
	});
</script><?php */?>
<script type="text/javascript">
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
function getkey(e)
{
if (window.event)
return window.event.keyCode;
else if (e)
return e.which;
else
return null;
}
function goodchars(e, goods)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
if (goods.indexOf(keychar) != -1)
return true;
if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
return true;
return false;
}
function checkMessenger(themail)
{
	var tomatch  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!tomatch.test(themail))
	{ 
	window.alert('Invalid Email Address');
	return false;
	}
	return true; 
}
function valid(){
	if(document.getElementById("time").value=="")
	{
		alert("Please enter time");
		document.getElementById("time").focus();
	    return false;	
	}
	if(document.getElementById("how_many_people").value=="")
	{
		alert("Please enter number of people");
		document.getElementById("how_many_people").focus();
	    return false;	
	}
	if(document.getElementById("special_occasions").value=="")
	{
		alert("Please enter special occasion");
		document.getElementById("special_occasions").focus();
	    return false;	
	}
	if(document.getElementById("contact_email").value=="")
	{
		alert("Please enter contact email id");
		document.getElementById("contact_email").focus();
	    return false;	
	}
	if ((document.getElementById("contact_email").value!="") && (checkMessenger(document.getElementById("contact_email").value)==false))
	{
	document.getElementById("contact_email").value="";
	document.getElementById("contact_email").focus();
	return false;
	}
	if(document.getElementById("comments").value=="")
	{
		alert("Please enter comments");
		document.getElementById("comments").focus();
	    return false;	
	}
	if(document.getElementById("captcha_code").value=="")
	{
		alert("Please enter captcha");
		document.getElementById("captcha_code").focus();
	    return false;	
	}
}


</script>
<div class="profle_bottom">
<form name="reservation_form" method="post" action="" onSubmit="return valid();">

<p>Time * :</p>
<input name="time" id="time" type="text"  class="profilefield"/>
<div class="clear"></div>

<p>How Many People * :</p>
<input name="how_many_people" id="how_many_people" type="text"  class="profilefield" onKeyPress="return goodchars(event,'1234567890');"/>
<div class="clear"></div>

<p>Special Occasions * :</p>
<input name="special_occasions" id="special_occasions" type="text"  class="profilefield"/>
<input name="profile_id" id="profile_id" type="hidden"  class="profilefield" value="<?php echo $_REQUEST['id']?>"/>
<div class="clear"></div>

<p>Contact Email * :</p>
<input name="contact_email" id="contact_email" type="text"  class="profilefield"/>
<div class="clear"></div>

<p>Additional Comments * :</p>
<textarea name="comments" id="comments" cols="" rows="" class="profilearea"></textarea>

<div class="clear"></div>

<p>Captcha * :</p>
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


</div>

                            
                        </div> 
                        <div class="food_middle_side">
                            <div class="middle_top">
                             <?php $rating = getRestaurantRating($sql_restaurant['id']); ?>
                            	<h1><?php echo $sql_restaurant['restaurant_name'];?></h1>
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
                                <div style="float:left; padding-left:10px; width:100px;"><div class="stars"></div></div>
                               <?php /*?> <ul>
                                <?php 
									$rating = getRestaurantRating($sql_restaurant['id']); 
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
                                        <li><?php echo $res_review['post_date']; ?></li>
                                </ul><?php */?>
                            	<p style="float:left; padding-top:2px; width:100px;"><?php echo getRestaurantCountRating($sql_restaurant['id']); ?> reviews</p>
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
                         
                        <!--<p><a href="#">Gift Certificate Information</a></p>--> 
                        <h2>Coupons</h2>
                        
                        <!--<img src="images/price_tag.jpg" width="200" height="48" />--> 
                       
						<?php while($array_coupons = mysql_fetch_array($sql_coupons)){ ?>
                        <div class="reservation3"><!--<a href="#">Reservation</a>-->
                            
  <ul>
		<li><a class="various6" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>">
        <img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="95" height="70" /></a></li>
	</ul>
    
    <div style="display: none;">
		<div id="inline<?php echo $array_coupons['id'];?>" style="width:450px;height:450px;overflow:auto;">
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