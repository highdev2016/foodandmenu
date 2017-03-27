<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="google-site-verification" content="XDKvinsWwsT8egonri02KDnOicDihl8XokqxsjL-C6M" />
<meta name="msvalidate.01" content="98593D957300F985A120634549B94AC9" />
<link rel="shortcut icon" href="http://www.foodandmenu.com/favicon.ico" type="image/x-icon"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>food & menu</title>
<link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 
<link rel='stylesheet' id='camera-css'  href='css/ui.totop.css' type='text/css' media='all'> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<!--for banner section -->

<script type="text/javascript">
var baseUrl = 'https://foodandmenu.com/';
</script>

<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>

<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.10/themes/smoothness/jquery-ui.css" type="text/css">
<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10/jquery-ui.min.js"></script>

    
    
    
    <script type='text/javascript' src='js/jquery.ui.totop.js'></script> 
    
    <script type="text/javascript">
		$(document).ready(function() {
			/*
			var defaults = {
	  			containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		};
			*/
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
	</script>
<!--end of banner-->



</head>

<link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>


<script type="text/javascript">
function open_slider_div(id)
{
	
	$("#slider_div"+id).css("visibility", "visible").css("opacity", "100");
	$("#fade1").show();
}

function close_slider_div(id)
{
	
	$("#slider_div"+id).css("visibility", "hidden").css("opacity", "0");
	$("#fade1").hide();
}
</script>


<script type="text/javascript" src="https://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="https://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
	
	//var $j = jQuery.noConflict();
	
  $(document).ready(function() {
   /*
   *   Examples - images
   */
   
   
   $("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script>
 

<body onLoad="init();">


<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery(".slidingDiv").hide();
    jQuery(".show_hide").show();
    jQuery('.show_hide').click(function(){
        jQuery(".slidingDiv").slideToggle();
    });
});
</script>

<script type="text/javascript">
function close_city_div()
{
	document.getElementById('slidingDiv').style.display="none";
}
</script>

<style type="text/css">

.slidingDiv{
	display:none;
}
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<!--<script src="//code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<div class="slidingDiv" id="slidingDiv">
<div id="fadenw"></div>
<div id="level_div">
<div class="popup_main">
<div class="popup_form_container">
<div class="close_butt"><a href="#" onClick="close_city_div();"><img src="images/close-butt.png" width="30" height="29" /></a></div>
<div class="popup_bg">
<form name="myfrm_city" method="post" action="" onSubmit="return validate();">
<div class="popup_inner_bg">

<div class="free_membership"><a href="signup.php"><img src="images/free_membership.png" width="125" height="124" /></a></div>

<div class="inner_bg_top" style="padding-top:15px;">
<h1>your city for less</h1>
<p>Get up to 80% off great deals on restaurant in your local city !!!</p>
</div>

<div class="clear"></div>

<div class="popup_divider"><img src="images/popup_divider.png" width="507" height="21" /></div>


<div class="inner_bg_middle">

<p>What city would you like?</p>
<input name="city_address" id="city_address" type="text" class="popup_textfield city_add" autocomplete="off" />


<div class="clear"></div>


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

</div>





<style type="text/css">

.output
{
        font-family:Arial;
        font-size: 10pt;
        color:black;
        padding-left: 3px;
        padding-top: 3px;
        /*border: 1px solid #c9c9c9;*/
        width: 226px;
        background: #fff;
}
.shadow
{
        width:102px;
        position:relative;
        top: 2px;
        left: 2px;
       /* background: #555;*/
}
.shadow div
{
        position:relative;
        top: -2px;
        left: -2px;
		/*z-index: 2147483647;*/
		z-index: 214;
}
.output div
{
		padding:3px 0 !important;
}
#output
{
		max-height:141px !important;
		overflow:auto;
}
</style><div class="header_section">

<div class="header_top">

<div class="header_container">
<div class="logo_left">
<a href="index.php"><img src="images/logo.png" width="173" height="99" /></a>
</div>

<div class="search_right">

<form name="frm_search" id="frm_search" action="search_area.php" method="get">
<div class="search_box">

<div class="left_search">
    <p class="left_search">What are you looking for?<span class="left_search_two">( Restaurant, Cuisine )</span></p>
    <input name="rest_item" id="rest_item" type="text" class="search_textfield" value="" />
</div>

<div class="search_two">
<p class="left_search"> Where?<span class="left_search_two">( City,State or Zip code )</span></p>
<input type="text" name="full_address" id="full_address" class="search_textfield city_add" style="width:230px;" value=""  onfocus="if (this.value!='') this.value = ''" autocomplete="off" />
<div class="shadow" id="shadow">

<div class="output" id="output" >
</div>
</div>
</div>
<div class="search_button"><input name="btn_search" id="btn_search" type="submit" value="search" class="button2"/></div>

<div class="change_city">

	<h1>Change City</h1>
    
    <p><a href="#" class="show_hide">Click Here</a></p>

</div>

<div class="clear"></div>

</div>
</form>

</div>

<div class="clear"></div>
</div>

</div>
</div>
<div class="clear"></div>
   
<div class="menu_section">

<div class="menu_container">

<div class="left_menu">
<ul>
<li><a href="index.php" >Home</a></li>
<li><a href="contact.php" >Contact Us</a></li>
<li><a href="vendor.php" >vendors</a></li>
<li><a href="http://foodandmenu.com/blog">Blog</a></li>
</ul>


</div>


<div class="right_menu" style="width:auto;">
<div class="login_section" style="width:auto;">

<ul style="padding-left:15px; padding-right:15px;">
<li><span style="cart_text"></span>
<a href="cart.php" style="float:left;"><img src="images/cart.png" width="20" height="20"  style="margin-top:5px; padding-right:5px;"/></a>
</li>
<li>Welcome , Priya123</li>   
<li>|</li>  
<li><a href="user_profile.php">User profile</a></li>   
<li>|</li>  
<li><a href="logout.php">Logout</a></li>

</ul>
</div>
</div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

     <!-- FlexSlider -->
  <script defer src="js/jquery.flexslider.js"></script>

    
  <script type="text/javascript">
  	$(window).load(function() {
  // The slider being synced must be initialized first
  var hid_count_new = $("#hid_count_new").val();
 for(i=1;i<=hid_count_new;i++){
  $('#carousel'+i).flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 35,
    itemMargin: 5,
    asNavFor: '#slider'+i
  });
 
  $('#slider'+i).flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"+i
  });
  }
});
  </script>
  
<input type="hidden" name="cust_id" id="cust_id" value="84" />

<input type="hidden" name="hid_user_id" id="hid_user_id" value="84">

	<div class="body_section">
	
		<div class="body_container">
			<div class="body_top"> </div>
			<div class="main_body">
			
				<div class="contact_body_cont" style="min-height:600px;">
				
					<div class="user-profile-section">
						
						<div class="user-profile-top">
							<div class="profile-name">
                            
								<h1>Priya123's Profile</h1>
							</div>
							<div class="follow-section">
								<ul>
                                	
                                    
									<li>
										 <a href="javascript:void(0);" style="cursor:text;">
											 <img src="images/star-on.png" /> <strong> Reviews</strong> <br />
											 <span>10</span>
										 </a>
									</li>
                                    
                                    										<li>
											 <a href="javascript:void(0);" onClick="open_notification_div();">
												<strong>Notification</strong> <br />
												 <span>16</span>
											 </a>
											 
											 <div id="notification_div" style="display:none;" class="notification">
												<img src="images/tool-arrow.png" alt="" />
												<p>Chef reviewed on Mimis Asian Fusion</p>  <p>Chef likes a review of Christi of Mimis Asian Fusion</p>  <p>Chef dislikes a review of Chef of Mimis Asian Fusion</p>  <p>Chef dislikes a review of Chef of Mimis Asian Fusion</p>  <p>Chef likes a review of Chef of Mimis Asian Fusion</p>  <p>Chef dislikes a review of Chef of Mimis Asian Fusion</p>  <p>Chef likes a review of Chef of Mimis Asian Fusion</p>  <p>Chef likes a review of Peggy of Mimis Asian Fusion</p>  <p>Chef likes a review of Peggy of Mimis Asian Fusion</p>  <p>Chef likes a review of Peggy of Mimis Asian Fusion</p>  <p>Chef likes a review of Peggy of Mimis Asian Fusion</p>  <p>Chef likes a review of Peggy of Mimis Asian Fusion</p>  <p>Chef likes a review of Peggy of Mimis Asian Fusion</p>  <p>Chef likes a review of Peggy of Mimis Asian Fusion</p>  <p>Chef dislikes a review of Peggy of Mimis Asian Fusion</p>  <p>Chef likes a review of Peggy of Mimis Asian Fusion</p>  											</div>    
										</li>
										
																			<li>
										 <a href="javascript:void(0);" onClick="open_following_div();">
											<strong>Following</strong> <br />
											 <span id="following_span">1</span>
										 </a>
										 <div id="following_div" style="display:none;">
										 	<img src="images/tool-arrow.png" alt="" />
		                                    <a href='user.php?id=51' style='color:#4E7AD5'>Arturo STEWART</a>	                                    </div> 
									</li>
                                                                        
                                    									<li>
										 <a href="javascript:void(0);" onClick="open_follower_div();">
											<strong>Followers</strong> <br />
											 <span id="follower_span">1</span>
										 </a>
										 
										 <div id="follower_div" style="display:none;">
										 	<img src="images/tool-arrow.png" alt="" />
		                                    <a href='user.php?id=205' style='color:#4E7AD5'>Chef Critics</a>		                                </div>    
									</li>
                                                                        
                                    									<li>
										 <a href="javascript:void(0);" onClick="open_favourite_div();">
											<strong>Favorites</strong> <br />
											 <span>8</span>
										 </a>
										 
										 <div id="favourite_div" style="display:none;" class="favo">
										 	<img src="images/tool-arrow.png" alt="" />
		                                    <a href='restaurant.php?id=1194' style='color:#4E7AD5'>Mimis Asian Fusion</a>  <a href='restaurant.php?id=77198' style='color:#4E7AD5'>Crawfish Shack & Oyster Bar</a>  <a href='restaurant.php?id=89813' style='color:#4E7AD5'>Polvos Mexican Restaurant</a>  <a href='restaurant.php?id=105141' style='color:#4E7AD5'>La Tapatia</a>  <a href='restaurant.php?id=105069' style='color:#4E7AD5'>Bamboo Bistro</a>  <a href='restaurant.php?id=781' style='color:#4E7AD5'>Nonna Gina's Italian Restaurant</a>  <a href='restaurant.php?id=104705' style='color:#4E7AD5'>Third Base Sports Bar</a>  <a href='restaurant.php?id=105061' style='color:#4E7AD5'>Panda 2 Go</a>  		                                </div>    
									</li>
                                    
                                                                        <li class="big-text">
										 <a href="javascript:void(0);" onClick="open_following_req_div();">
											<strong>Following Request</strong> <br />
											 <span id="following_req_span">0</span>
										 </a>
										 <div id="following_req_div" style="display:none;">
										 	<img src="images/tool-arrow.png" alt="" />
		                                    	                                    </div> 
									</li>
                                                                        
                                    
                                    
                                    
                                    
                                    
                                    								</ul>
							</div>
							<div class="clear"> </div>
						</div> <!-- End user-profile-top -->
						<div class="clear"> </div>
						
						<div class="user-cont">
							
							<div class="user-cont-left">
								<div class="pro-pic">
                                									<img src="uploaded_images/1413452206Chrysanthemum.jpg" alt="" width="200" height="180" />
                                    								</div>
								
								<label>
									<h5>Member Since</h5>
									<p>August 2013</p>
								</label>
								
                                								<label>
									<h5>Location</h5>
									<p>Austin, TX</p>
								</label>
                                								
								<!--<label>
									<input type="checkbox" class="regular-checkbox big-checkbox" name="review" id="review" />
									<label for="review"></label>
									
									 Review Votes
								</label>-->
								<div class="clear"> </div>
                                
                                
								
								                                
								<h4>
                                									<strong><a  id="various1" href="#inline84" style="color:#404CA1;" title="">23 likes </a></strong>,  
                                									<strong><a  id="various2" href="#inline_dislike" style="color:#404CA1;" title="">4 dislikes</a> </strong>
                                								</h4>
								
								<!--<div class="review-up">
									<img src="images/reload.png" align="absmiddle" /> 1 Review update
								</div>
								<div class="clear"> </div>
								
								<div class="report-ab">
									<img src="images/report-flag.png" align="absmiddle" /> Report Abuse
								</div>-->
								<div class="clear"> </div>
								
								<div style="display: none;">
                                    <div id="inline84" style="height:250px; min-height:450px; overflow:auto; width:615px;">
                                    	<h2 class="rv-pop-title">Liked Review List</h2>
									                                                                                                                <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>05-14-2014</li>    
                                	</ul>
                                          
                                          <p>LOVE THE TAPIOCA DRINKS!! WEEKENDS CAN BE A LITTLE PACKED BUT OVERALL GREAT FOOD AND COSTUMER SERVICE.!! :)</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>04-25-2014</li>    
                                	</ul>
                                          
                                          <p>I had their Korean BBQ Ribs. They were so Tuff and chewy I could only eat part of them. Very disappointing.
Slow service too! </p>
                                          </div>
                                                                                                                                                                                                                            <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>01-18-2014</li>    
                                	</ul>
                                          
                                          <p>Great Food! Great Service. Will return soon :)</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>03-22-2014</li>    
                                	</ul>
                                          
                                          <p>I loooovee the crispy noodles and Yakisoba!!!</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>02-12-2014</li>    
                                	</ul>
                                          
                                          <p>The food was amazing! Beautiful customer service! </p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>04-07-2014</li>    
                                	</ul>
                                          
                                          <p>I love their food but can&#039;t stand how they require you to print out one of the coupons to be able to use it. They don&#039;t have a bar code, serial number, or anything on them that would make it required to have in hand. They could easily write down on a piece of paper that you showed the coupon on your phone  and it would have the same value as you handing one to them. Because of this (which I see as a customer service issue) I give them only 3 stars.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>07-06-2014</li>    
                                	</ul>
                                          
                                          <p>Love the beef pad thai!  It is wonderful!</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>06-08-2014</li>    
                                	</ul>
                                          
                                          <p>Mimi&#039;s is consistently good.  The General Tso&#039;s Chicken is delicious and the sushi is wonderful too.  The Chicken Noodle Soup is also delicious.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>10-26-2014</li>    
                                	</ul>
                                          
                                          <p>Had the Mimi&#039;s Spicy Soft Noodle and it was delicious!</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>11-13-2014</li>    
                                	</ul>
                                          
                                          <p>The food was great and fresh. My daughter and I like the salt and pepper calamari and tom yum soup.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test11</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test review</p>
                                          </div>
                                                                                                                                                                                                                            <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105141" style="color:#F07A01; text-decoration:none;">La Tapatia</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>07-28-2014</li>    
                                	</ul>
                                          
                                          <p>Great Authentic Mexican Food! I recommend the Carne Guisada tacos on flour tortillas, very tasty. Our waitress was very attentive and provided excellet customer service. Will return soon, Thank you Blanca.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105127" style="color:#F07A01; text-decoration:none;">The Original New Orleans Po-Boy and Gumbo Shop</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>07-17-2014</li>    
                                	</ul>
                                          
                                          <p>This Place has Great Authentic Cajun Food! Crawfish were out of season, but the Crawfish Etoufee was very tasty. The Gumbo Shop has a True Mardi Gras vibe to it, combining both Food &amp; Culture. Darold, the owner and chef, is always there with a smile.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-11-2014</li>    
                                	</ul>
                                          
                                          <p>Test</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105052" style="color:#F07A01; text-decoration:none;">El Torito</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>05-22-2014</li>    
                                	</ul>
                                          
                                          <p>Truly a hidden treasure within the Cannon Square. Anna Salinas, the owner, knows how to express all facets of the Mexican Culture; incorporating Art, Music, and of course Delicious Food! Must try the breakfast tacos. Served all day with  freshly made tortillas and Cafe de Olla!  A quaint Restaurant meant for a more personal dining experience. I highly recommend to anyone in the mood for Authentic Mexican Cuisine. Will revisit soon.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=225" style="color:#F07A01; text-decoration:none;">zpizza</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>01-30-2014</li>    
                                	</ul>
                                          
                                          <p>New Location, Great Pizza...Nice place to go for a quick bite. Will revisit soon :)</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=819" style="color:#F07A01; text-decoration:none;">Curra&#039;s Grill</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>02-04-2014</li>    
                                	</ul>
                                          
                                          <p>I recently visited for lunch last week. Our Waiter recommended the Carniats Tacos, Must Try! It was much quieter after the lunch rush. Will return soon. Thanks Rick.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=781" style="color:#F07A01; text-decoration:none;">Nonna Gina&#039;s Italian Restaurant</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>04-29-2014</li>    
                                	</ul>
                                          
                                          <p>I recently tried Margarita and the Roasted Chicken Specialty Pizza for takeout. The Pizza is very Flavorful and the crust has a brick oven taste. Will return to try the baked lasagna. Thank you Reno!  </p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=77198" style="color:#F07A01; text-decoration:none;">Crawfish Shack &amp; Oyster Bar</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>03-04-2014</li>    
                                	</ul>
                                          
                                          <p>This location has been open for about a week and the Crawfish Shack is off to a great start. The Crawfish boil recipe is very tasty and spicy! I recommend oysters on the half shell, very fresh! The staff is very polite and attentive. Once the weather warms up the large patio will be more inviting. Will revisit soon for Happy Hour!</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105059" style="color:#F07A01; text-decoration:none;">Tuk Tuk Thai Café</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test 3434</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105059" style="color:#F07A01; text-decoration:none;">Tuk Tuk Thai Café</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test review</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test 123.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-10-2014</li>    
                                	</ul>
                                          
                                          <p>Test new ..
</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105127" style="color:#F07A01; text-decoration:none;">The Original New Orleans Po-Boy and Gumbo Shop</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test 123</p>
                                          </div>
                                                                             
                                    </div>
                                    
                                	</div>
                                    
                                    
                                    <div style="display: none;">
                                    <div id="inline_dislike" style="height:250px; min-height:450px; overflow:auto; width:615px;">
                                    	<h2 class="rv-pop-title">Disliked Review List</h2>
									                                                                                                                <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>05-14-2014</li>    
                                	</ul>
                                          
                                          <p>LOVE THE TAPIOCA DRINKS!! WEEKENDS CAN BE A LITTLE PACKED BUT OVERALL GREAT FOOD AND COSTUMER SERVICE.!! :)</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>04-25-2014</li>    
                                	</ul>
                                          
                                          <p>I had their Korean BBQ Ribs. They were so Tuff and chewy I could only eat part of them. Very disappointing.
Slow service too! </p>
                                          </div>
                                                                                                                                                                                                                            <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>04-07-2014</li>    
                                	</ul>
                                          
                                          <p>I love their food but can&#039;t stand how they require you to print out one of the coupons to be able to use it. They don&#039;t have a bar code, serial number, or anything on them that would make it required to have in hand. They could easily write down on a piece of paper that you showed the coupon on your phone  and it would have the same value as you handing one to them. Because of this (which I see as a customer service issue) I give them only 3 stars.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>06-08-2014</li>    
                                	</ul>
                                          
                                          <p>Mimi&#039;s is consistently good.  The General Tso&#039;s Chicken is delicious and the sushi is wonderful too.  The Chicken Noodle Soup is also delicious.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>10-26-2014</li>    
                                	</ul>
                                          
                                          <p>Had the Mimi&#039;s Spicy Soft Noodle and it was delicious!</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>11-13-2014</li>    
                                	</ul>
                                          
                                          <p>The food was great and fresh. My daughter and I like the salt and pepper calamari and tom yum soup.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test11</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test review</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105141" style="color:#F07A01; text-decoration:none;">La Tapatia</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>07-28-2014</li>    
                                	</ul>
                                          
                                          <p>Great Authentic Mexican Food! I recommend the Carne Guisada tacos on flour tortillas, very tasty. Our waitress was very attentive and provided excellet customer service. Will return soon, Thank you Blanca.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-11-2014</li>    
                                	</ul>
                                          
                                          <p>Test</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105052" style="color:#F07A01; text-decoration:none;">El Torito</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>05-22-2014</li>    
                                	</ul>
                                          
                                          <p>Truly a hidden treasure within the Cannon Square. Anna Salinas, the owner, knows how to express all facets of the Mexican Culture; incorporating Art, Music, and of course Delicious Food! Must try the breakfast tacos. Served all day with  freshly made tortillas and Cafe de Olla!  A quaint Restaurant meant for a more personal dining experience. I highly recommend to anyone in the mood for Authentic Mexican Cuisine. Will revisit soon.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>11-24-2014</li>    
                                	</ul>
                                          
                                          <p>Test 123.</p>
                                          </div>
                                                                             
                                    </div>
                                    
                                	</div>
								
							
							</div> <!-- End user-cont -->
							
							
							
							<div class="user-cont-right">
								<div class="right-top" >
									<h4>
                                    										Recent Reviews <span> 10 Reviews</span>
                                        									</h4>
									<div class="clear"> </div>
									<ul class="sortby">
										<li>Sort by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);" onClick="sort_date('84');">Date</a></li> 
										<li style="color: #999">| &nbsp;</li>
										<li><a href="javascript:void(0);" onClick="sort_rating('84');">Rating</a></li> 
										<!--<li>Filter by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);"> Location</a></li>
										<li><a href="javascript:void(0);">Category</a></li>-->
									</ul>
									<div class="clear"> </div>
								</div>
								<div class="clear"> </div>
								
								<div class="right-top" id="right-top">
								
								<div id="loader_div" class="sec-load" style="display:none;"><img src="images/loader_gif.gif"></div>
                                
                                <div id="main_res_div" class="">
                                
                                <!-- Start restu-block -->
                                
                                									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        											<a href="javascript:void(0);" onClick="open_slider_div('128');"><img src="uploaded_images/1401743703menu logo.png" align="" width="169" /></a>
                                        										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=105059">Tuk Tuk Thai Café</a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : Thai</a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=105059">5517 Manchaca Rd, Austin, Tx 78745</a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                                                                            
                                                    <div class="next-row">
	                                                    <div class="rating_content">
	                                                            <ul>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                            </ul>
	                                                            
	                                                        </div>
	                                                        
	                                                         <div class="post_date">
		                                                           <div style="color: #777; font-size: 14px; float:right;">Posted on 11-24-2014</div>
		                                                     </div>
                                                    
                                                    <div class="clear"> </div>
                                                    
                                                    
													                                                         <div class="rv-img">
                                                         <ul>
                                                  <li><a class="example_cat" href="uploaded_images/1416820927dish-1.png"><img src="uploaded_images/1416820927dish-1.png" height="30"></a></li>                                                        
                                                        </ul>
                                                    </div>
                                                                                                        <p>
                                                        Test review                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                                                                                
                                                        <div class="soc_icon">
                                                             
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                   <div class="clear"></div>   
                                                    
                                                    
                                         <div class="user-social-sec-bot">       
                                          <div class="rating_content_two review-likes">
                                          <ul>
													
		                                    <li id="li_like_129">
													                                    
		                                    <span class="like_text" id="like_count_129">1</span><img src="images/like_select.png" width="16" height="16" />
		                                    		                                    </li>
		                                    <li id="li_dislike_129">
		                                    		                                     <a href="dislike" id="do_dislike_129" class="dislike" review="129" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_129">0</span>
													                                    </li>
		                                    
		                                    <!--<li><a href="#"></a></li>-->
		                                    		                                </ul>
                                                  </div>
                                                  <div class="report-ab">  
                                                <a href="mailto:?body=Test review&subject=24-11-2014  By Priya123" target="_blank">Email</a>
                                                                                    			<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=105059">Share with facebook</a>                                                </div>
                                                
                                                                                                <div class="report-ab">
                                                
                                    
                                                    <img src="images/report-flag.png" align="absmiddle">
                                                                                                        <a href="report_abuse.php?id=105059&r_id=129" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                    </div>
                                                  
                                       
                                       </div>  
                                               
                                        <div class="clear"></div>
                                        
                                        
                                                                              			 </div> 	
																						<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																													</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on 11-24-2014                                                </div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													Test 3434												</p>
												<div class="clear"> </div>
                                                
                                                																 <div class="rv-img">
                                                        <ul>
                                                  <li><a class="example_cat" href="uploaded_images/14168208561373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg"><img src="uploaded_images/14168208561373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" height="30"></a></li>                                                        
                                                        </ul>
                                                    </div>
                                                    												
												<div class="like-sec">
													                                                    
													<div class="soc_icon">
														 
                                                        <script type="text/javascript">
                                                          (function() {
                                                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                            po.src = 'https://apis.google.com/js/platform.js';
                                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                          })();
                                                        </script>
                                                        
                                                        <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
													</div>
                                                    
												</div>
												
												
											</div> 
											<div class="clear"> </div>
											<div class="user-social-sec-bot">
											
										  <div class="rating_content_two review-likes">
                                          <ul>
															
			                                    <li id="li_like_128">
															                                    
			                                    <span class="like_text" id="like_count_128">1</span><img src="images/like_select.png" width="16" height="16" />
			                                    			                                    </li>
			                                    <li id="li_dislike_128">
			                                    			                                     <a href="dislike" id="do_dislike_128" class="dislike" review="128" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_128">0</span>
															                                    </li>
			                                    
			                                    <!--<li><a href="#"></a></li>-->
			                                    			                                </ul>
                                          </div>
                                            
                                            <div class="report-ab">
                                            <a href="mailto:?body=Test 3434&subject=24-11-2014  By Priya123" target="_blank">Email</a>
                                            
                                                                                         
                                    		<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=105059">Share with facebook</a>                                            </div>
                                            
                                                                                        <div class="report-ab">  
                                                <img src="images/report-flag.png" align="absmiddle">
                                                                                                <a href="report_abuse.php?id=105059&r_id=128" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                <div class="clear"> </div>
                                            </div>
                                            										
                                        </div>
                                        
										<div class="clear"> </div>
                                        
                                                                               </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        											<a href="javascript:void(0);" onClick="open_slider_div('127');"><img src="uploaded_images/1405519525main.jpg" align="" width="169" /></a>
                                        										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=105127">The Original New Orleans Po-Boy and Gumbo Shop</a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : Cajun/Creole</a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=105127">1701 E Cesar Chavez St Ste B, Austin, TX 78702</a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                        											<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																													</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on 11-24-2014                                                </div>
											</div>

											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													Test 123												</p>
												<div class="clear"> </div>
                                                
                                                												
												<div class="like-sec">
													                                                    
													<div class="soc_icon">
														 
                                                        <script type="text/javascript">
                                                          (function() {
                                                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                            po.src = 'https://apis.google.com/js/platform.js';
                                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                          })();
                                                        </script>
                                                        
                                                        <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
													</div>
                                                    
												</div>
												
												
											</div> 
											<div class="clear"> </div>
											<div class="user-social-sec-bot">
											
										  <div class="rating_content_two review-likes">
                                          <ul>
															
			                                    <li id="li_like_127">
															                                    
			                                    <span class="like_text" id="like_count_127">1</span><img src="images/like_select.png" width="16" height="16" />
			                                    			                                    </li>
			                                    <li id="li_dislike_127">
			                                    			                                     <a href="dislike" id="do_dislike_127" class="dislike" review="127" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_127">0</span>
															                                    </li>
			                                    
			                                    <!--<li><a href="#"></a></li>-->
			                                    			                                </ul>
                                          </div>
                                            
                                            <div class="report-ab">
                                            <a href="mailto:?body=Test 123&subject=24-11-2014  By Priya123" target="_blank">Email</a>
                                            
                                                                                         
                                    		<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=105127">Share with facebook</a>                                            </div>
                                            
                                                                                        <div class="report-ab">  
                                                <img src="images/report-flag.png" align="absmiddle">
                                                                                                <a href="report_abuse.php?id=105127&r_id=127" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                <div class="clear"> </div>
                                            </div>
                                            										
                                        </div>
                                        
										<div class="clear"> </div>
                                        
                                                                               </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        											<a href="javascript:void(0);" onClick="open_slider_div('121');"><img src="uploaded_images/1390075787shrimproll.jpg" align="" width="169" /></a>
                                        										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=1194">Mimis Asian Fusion</a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : Asian Fusion</a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=1194">10001 South IH 35, Austin, TX 78747</a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                                                                            
                                                    <div class="next-row">
	                                                    <div class="rating_content">
	                                                            <ul>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                            </ul>
	                                                            
	                                                        </div>
	                                                        
	                                                         <div class="post_date">
		                                                           <div style="color: #777; font-size: 14px; float:right;">Posted on 11-24-2014</div>
		                                                     </div>
                                                    
                                                    <div class="clear"> </div>
                                                    
                                                    
													                                                    <p>
                                                        Test11                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                                                                                
                                                        <div class="soc_icon">
                                                             
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                   <div class="clear"></div>   
                                                    
                                                    
                                         <div class="user-social-sec-bot">       
                                          <div class="rating_content_two review-likes">
                                          <ul>
													
		                                    <li id="li_like_132">
													                                    
		                                    <span class="like_text" id="like_count_132">1</span><img src="images/like_select.png" width="16" height="16" />
		                                    		                                    </li>
		                                    <li id="li_dislike_132">
		                                    		                                     <a href="dislike" id="do_dislike_132" class="dislike" review="132" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_132">0</span>
													                                    </li>
		                                    
		                                    <!--<li><a href="#"></a></li>-->
		                                    		                                </ul>
                                                  </div>
                                                  <div class="report-ab">  
                                                <a href="mailto:?body=Test11&subject=24-11-2014  By Priya123" target="_blank">Email</a>
                                                                                    			<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194">Share with facebook</a>                                                </div>
                                                
                                                                                                <div class="report-ab">
                                                
                                    
                                                    <img src="images/report-flag.png" align="absmiddle">
                                                                                                        <a href="report_abuse.php?id=1194&r_id=132" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                    </div>
                                                  
                                       
                                       </div>  
                                               
                                        <div class="clear"></div>
                                        
                                        
                                                                              			 </div> 	
											                                                    
                                                    <div class="next-row">
	                                                    <div class="rating_content">
	                                                            <ul>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                            </ul>
	                                                            
	                                                        </div>
	                                                        
	                                                         <div class="post_date">
		                                                           <div style="color: #777; font-size: 14px; float:right;">Posted on 11-24-2014</div>
		                                                     </div>
                                                    
                                                    <div class="clear"> </div>
                                                    
                                                    
													                                                    <p>
                                                        Test                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                                                                                
                                                        <div class="soc_icon">
                                                             
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                   <div class="clear"></div>   
                                                    
                                                    
                                         <div class="user-social-sec-bot">       
                                          <div class="rating_content_two review-likes">
                                          <ul>
													
		                                    <li id="li_like_131">
													                                    
		                                    <span class="like_text" id="like_count_131">1</span><img src="images/like_select.png" width="16" height="16" />
		                                    		                                    </li>
		                                    <li id="li_dislike_131">
		                                    		                                     <a href="dislike" id="do_dislike_131" class="dislike" review="131" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_131">0</span>
													                                    </li>
		                                    
		                                    <!--<li><a href="#"></a></li>-->
		                                    		                                </ul>
                                                  </div>
                                                  <div class="report-ab">  
                                                <a href="mailto:?body=Test&subject=24-11-2014  By Priya123" target="_blank">Email</a>
                                                                                    			<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194">Share with facebook</a>                                                </div>
                                                
                                                                                                <div class="report-ab">
                                                
                                    
                                                    <img src="images/report-flag.png" align="absmiddle">
                                                                                                        <a href="report_abuse.php?id=1194&r_id=131" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                    </div>
                                                  
                                       
                                       </div>  
                                               
                                        <div class="clear"></div>
                                        
                                        
                                                                              			 </div> 	
											                                                    
                                                    <div class="next-row">
	                                                    <div class="rating_content">
	                                                            <ul>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                            </ul>
	                                                            
	                                                        </div>
	                                                        
	                                                         <div class="post_date">
		                                                           <div style="color: #777; font-size: 14px; float:right;">Posted on 11-24-2014</div>
		                                                     </div>
                                                    
                                                    <div class="clear"> </div>
                                                    
                                                    
													                                                    <p>
                                                        Test review                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                                                                                
                                                        <div class="soc_icon">
                                                             
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                   <div class="clear"></div>   
                                                    
                                                    
                                         <div class="user-social-sec-bot">       
                                          <div class="rating_content_two review-likes">
                                          <ul>
													
		                                    <li id="li_like_130">
													                                    
		                                    <span class="like_text" id="like_count_130">1</span><img src="images/like_select.png" width="16" height="16" />
		                                    		                                    </li>
		                                    <li id="li_dislike_130">
		                                    		                                     <a href="dislike" id="do_dislike_130" class="dislike" review="130" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_130">0</span>
													                                    </li>
		                                    
		                                    <!--<li><a href="#"></a></li>-->
		                                    		                                </ul>
                                                  </div>
                                                  <div class="report-ab">  
                                                <a href="mailto:?body=Test review&subject=24-11-2014  By Priya123" target="_blank">Email</a>
                                                                                    			<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194">Share with facebook</a>                                                </div>
                                                
                                                                                                <div class="report-ab">
                                                
                                    
                                                    <img src="images/report-flag.png" align="absmiddle">
                                                                                                        <a href="report_abuse.php?id=1194&r_id=130" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                    </div>
                                                  
                                       
                                       </div>  
                                               
                                        <div class="clear"></div>
                                        
                                        
                                                                              			 </div> 	
											                                                    
                                                    <div class="next-row">
	                                                    <div class="rating_content">
	                                                            <ul>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                            </ul>
	                                                            
	                                                        </div>
	                                                        
	                                                         <div class="post_date">
		                                                           <div style="color: #777; font-size: 14px; float:right;">Posted on 11-24-2014</div>
		                                                     </div>
                                                    
                                                    <div class="clear"> </div>
                                                    
                                                    
													                                                         <div class="rv-img">
                                                         <ul>
                                                  <li><a class="example_cat" href="uploaded_images/1416812766dish-4.png"><img src="uploaded_images/1416812766dish-4.png" height="30"></a></li><li><a class="example_cat" href="uploaded_images/1416812768dish-3.png"><img src="uploaded_images/1416812768dish-3.png" height="30"></a></li><li><a class="example_cat" href="uploaded_images/1416812769dish-7.png"><img src="uploaded_images/1416812769dish-7.png" height="30"></a></li>                                                        
                                                        </ul>
                                                    </div>
                                                                                                        <p>
                                                        Test 123.                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                                                                                
                                                        <div class="soc_icon">
                                                             
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                   <div class="clear"></div>   
                                                    
                                                    
                                         <div class="user-social-sec-bot">       
                                          <div class="rating_content_two review-likes">
                                          <ul>
													
		                                    <li id="li_like_126">
													                                    
		                                    <span class="like_text" id="like_count_126">1</span><img src="images/like_select.png" width="16" height="16" />
		                                    		                                    </li>
		                                    <li id="li_dislike_126">
		                                    		                                     <a href="dislike" id="do_dislike_126" class="dislike" review="126" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_126">0</span>
													                                    </li>
		                                    
		                                    <!--<li><a href="#"></a></li>-->
		                                    		                                </ul>
                                                  </div>
                                                  <div class="report-ab">  
                                                <a href="mailto:?body=Test 123.&subject=24-11-2014  By Priya123" target="_blank">Email</a>
                                                                                    			<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194">Share with facebook</a>                                                </div>
                                                
                                                                                                <div class="report-ab">
                                                
                                    
                                                    <img src="images/report-flag.png" align="absmiddle">
                                                                                                        <a href="report_abuse.php?id=1194&r_id=126" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                    </div>
                                                  
                                       
                                       </div>  
                                               
                                        <div class="clear"></div>
                                        
                                        
                                                                              			 </div> 	
											                                                    
                                                    <div class="next-row">
	                                                    <div class="rating_content">
	                                                            <ul>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                            </ul>
	                                                            
	                                                        </div>
	                                                        
	                                                         <div class="post_date">
		                                                           <div style="color: #777; font-size: 14px; float:right;">Posted on 11-11-2014</div>
		                                                     </div>
                                                    
                                                    <div class="clear"> </div>
                                                    
                                                    
													                                                    <p>
                                                        Test                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                                                                                
                                                        <div class="soc_icon">
                                                             
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                   <div class="clear"></div>   
                                                    
                                                    
                                         <div class="user-social-sec-bot">       
                                          <div class="rating_content_two review-likes">
                                          <ul>
													
		                                    <li id="li_like_124">
													                                    
		                                    <span class="like_text" id="like_count_124">1</span><img src="images/like_select.png" width="16" height="16" />
		                                    		                                    </li>
		                                    <li id="li_dislike_124">
		                                    		                                     <a href="dislike" id="do_dislike_124" class="dislike" review="124" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_124">0</span>
													                                    </li>
		                                    
		                                    <!--<li><a href="#"></a></li>-->
		                                    		                                </ul>
                                                  </div>
                                                  <div class="report-ab">  
                                                <a href="mailto:?body=Test&subject=11-11-2014  By Priya123" target="_blank">Email</a>
                                                                                    			<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194">Share with facebook</a>                                                </div>
                                                
                                                  
                                       
                                       </div>  
                                               
                                        <div class="clear"></div>
                                        
                                        
                                                                              			 </div> 	
											                                                    
                                                    <div class="next-row">
	                                                    <div class="rating_content">
	                                                            <ul>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
	                                                                	                                                            </ul>
	                                                            
	                                                        </div>
	                                                        
	                                                         <div class="post_date">
		                                                           <div style="color: #777; font-size: 14px; float:right;">Posted on 11-10-2014</div>
		                                                     </div>
                                                    
                                                    <div class="clear"> </div>
                                                    
                                                    
													                                                    <p>
                                                        Test new ..
                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                                                                                
                                                        <div class="soc_icon">
                                                             
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                   <div class="clear"></div>   
                                                    
                                                    
                                         <div class="user-social-sec-bot">       
                                          <div class="rating_content_two review-likes">
                                          <ul>
													
		                                    <li id="li_like_122">
													                                    
		                                    <span class="like_text" id="like_count_122">1</span><img src="images/like_select.png" width="16" height="16" />
		                                    		                                    </li>
		                                    <li id="li_dislike_122">
		                                    		                                     <a href="dislike" id="do_dislike_122" class="dislike" review="122" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_122">0</span>
													                                    </li>
		                                    
		                                    <!--<li><a href="#"></a></li>-->
		                                    		                                </ul>
                                                  </div>
                                                  <div class="report-ab">  
                                                <a href="mailto:?body=Test new ..
&subject=10-11-2014  By Priya123" target="_blank">Email</a>
                                                                                    			<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194">Share with facebook</a>                                                </div>
                                                
                                                                                                <div class="report-ab">
                                                
                                    
                                                    <img src="images/report-flag.png" align="absmiddle">
                                                                                                        <a href="report_abuse.php?id=1194&r_id=122" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                    </div>
                                                  
                                       
                                       </div>  
                                               
                                        <div class="clear"></div>
                                        
                                        
                                                                              			 </div> 	
																						<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																													</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on 11-10-2014                                                </div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													Test 56												</p>
												<div class="clear"> </div>
                                                
                                                																 <div class="rv-img">
                                                        <ul>
                                                  <li><a class="example_cat" href="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg"><img src="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" height="30"></a></li>                                                        
                                                        </ul>
                                                    </div>
                                                    												
												<div class="like-sec">
													                                                    
													<div class="soc_icon">
														 
                                                        <script type="text/javascript">
                                                          (function() {
                                                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                            po.src = 'https://apis.google.com/js/platform.js';
                                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                          })();
                                                        </script>
                                                        
                                                        <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=84&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
													</div>
                                                    
												</div>
												
												
											</div> 
											<div class="clear"> </div>
											<div class="user-social-sec-bot">
											
										  <div class="rating_content_two review-likes">
                                          <ul>
															
			                                    <li id="li_like_121">
															                                    <span class="like_text" id="like_count_121">0</span><a href="like" id="do_like_121" class="like" review="121" cid="84"><img src="images/like.png" width="16" height="16" /></a>
															                                    </li>
			                                    <li id="li_dislike_121">
			                                    			                                     <a href="dislike" id="do_dislike_121" class="dislike" review="121" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_121">0</span>
															                                    </li>
			                                    
			                                    <!--<li><a href="#"></a></li>-->
			                                    			                                </ul>
                                          </div>
                                            
                                            <div class="report-ab">
                                            <a href="mailto:?body=Test 56&subject=10-11-2014  By Priya123" target="_blank">Email</a>
                                            
                                                                                         
                                    		<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194">Share with facebook</a>                                            </div>
                                            
                                                                                        <div class="report-ab">  
                                                <img src="images/report-flag.png" align="absmiddle">
                                                                                                <a href="report_abuse.php?id=1194&r_id=121" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                <div class="clear"> </div>
                                            </div>
                                            										
                                        </div>
                                        
										<div class="clear"> </div>
                                        
                                                                              <div class="next-review">
	                                   		<div class="next-review-head">
		                                       <p><strong> Comment From Mimis Asian Fusion</strong></p>
	                                       </div> 
	                                       <label>11-13-2014  -  Hi Priya123</label>
	                                       <div class="next-review-cont">Restaurant Owners comment</div>
	                                        <div class="clear"> </div>
                                       </div>
                                                                               </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                                                
                                                                    
                               <div id="slider_div132" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('132');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider1"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1391380317mimi_diablo.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_pad thai.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391425132mimi_teriyaki chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp tempura roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391424447mimi_white snake.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1410356863dish-6.png" /></li>
                                                                                    <li> <img src="uploaded_images/1410419016rezept-tandoori_chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542534hair spa & Chiken tikka.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413613422193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615787193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615839Hair Spa.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1414362293mimsoftnoodle.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488sushi.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488shrimp rolls.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475487lomein.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416812766dish-4.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812768dish-3.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812769dish-7.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel1" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1391380317mimi_diablo.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_pad thai.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391425132mimi_teriyaki chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp tempura roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391424447mimi_white snake.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410356863dish-6.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419016rezept-tandoori_chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542534hair spa & Chiken tikka.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413613422193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615787193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615839Hair Spa.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1414362293mimsoftnoodle.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488sushi.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488shrimp rolls.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475487lomein.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812766dish-4.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812768dish-3.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812769dish-7.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div131" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('131');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider2"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1391380317mimi_diablo.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_pad thai.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391425132mimi_teriyaki chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp tempura roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391424447mimi_white snake.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1410356863dish-6.png" /></li>
                                                                                    <li> <img src="uploaded_images/1410419016rezept-tandoori_chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542534hair spa & Chiken tikka.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413613422193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615787193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615839Hair Spa.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1414362293mimsoftnoodle.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488sushi.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488shrimp rolls.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475487lomein.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416812766dish-4.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812768dish-3.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812769dish-7.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel2" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1391380317mimi_diablo.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_pad thai.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391425132mimi_teriyaki chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp tempura roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391424447mimi_white snake.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410356863dish-6.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419016rezept-tandoori_chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542534hair spa & Chiken tikka.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413613422193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615787193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615839Hair Spa.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1414362293mimsoftnoodle.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488sushi.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488shrimp rolls.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475487lomein.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812766dish-4.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812768dish-3.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812769dish-7.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div130" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('130');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider3"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1391380317mimi_diablo.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_pad thai.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391425132mimi_teriyaki chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp tempura roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391424447mimi_white snake.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1410356863dish-6.png" /></li>
                                                                                    <li> <img src="uploaded_images/1410419016rezept-tandoori_chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542534hair spa & Chiken tikka.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413613422193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615787193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615839Hair Spa.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1414362293mimsoftnoodle.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488sushi.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488shrimp rolls.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475487lomein.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416812766dish-4.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812768dish-3.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812769dish-7.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel3" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1391380317mimi_diablo.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_pad thai.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391425132mimi_teriyaki chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp tempura roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391424447mimi_white snake.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410356863dish-6.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419016rezept-tandoori_chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542534hair spa & Chiken tikka.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413613422193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615787193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615839Hair Spa.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1414362293mimsoftnoodle.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488sushi.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488shrimp rolls.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475487lomein.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812766dish-4.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812768dish-3.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812769dish-7.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div129" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('129');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider4"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1401324255spinach bacon.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1401324255thai basil fried rice.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1401324255tod mum.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14168208561373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416820927dish-1.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel4" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1401324255spinach bacon.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1401324255thai basil fried rice.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1401324255tod mum.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14168208561373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416820927dish-1.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div128" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('128');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider5"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1401324255spinach bacon.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1401324255thai basil fried rice.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1401324255tod mum.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14168208561373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416820927dish-1.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel5" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1401324255spinach bacon.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1401324255thai basil fried rice.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1401324255tod mum.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14168208561373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416820927dish-1.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div127" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('127');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider6"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1405519313fish plate.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1405519316sandwhich.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1405519316boil crawfish.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1405519316oster.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415277035img5_774_1411052340.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415277035img5_193_1411052032.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415277035img3_367_1409913843.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1415277035img2_205_1409922044.jpg" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel6" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1405519313fish plate.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1405519316sandwhich.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1405519316boil crawfish.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1405519316oster.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415277035img5_774_1411052340.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415277035img5_193_1411052032.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415277035img3_367_1409913843.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415277035img2_205_1409922044.jpg" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div126" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('126');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider7"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1391380317mimi_diablo.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_pad thai.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391425132mimi_teriyaki chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp tempura roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391424447mimi_white snake.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1410356863dish-6.png" /></li>
                                                                                    <li> <img src="uploaded_images/1410419016rezept-tandoori_chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542534hair spa & Chiken tikka.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413613422193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615787193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615839Hair Spa.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1414362293mimsoftnoodle.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488sushi.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488shrimp rolls.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475487lomein.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416812766dish-4.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812768dish-3.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812769dish-7.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel7" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1391380317mimi_diablo.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_pad thai.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391425132mimi_teriyaki chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp tempura roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391424447mimi_white snake.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410356863dish-6.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419016rezept-tandoori_chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542534hair spa & Chiken tikka.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413613422193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615787193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615839Hair Spa.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1414362293mimsoftnoodle.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488sushi.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488shrimp rolls.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475487lomein.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812766dish-4.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812768dish-3.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812769dish-7.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div124" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('124');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider8"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1391380317mimi_diablo.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_pad thai.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391425132mimi_teriyaki chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp tempura roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391424447mimi_white snake.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1410356863dish-6.png" /></li>
                                                                                    <li> <img src="uploaded_images/1410419016rezept-tandoori_chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542534hair spa & Chiken tikka.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413613422193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615787193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615839Hair Spa.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1414362293mimsoftnoodle.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488sushi.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488shrimp rolls.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475487lomein.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416812766dish-4.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812768dish-3.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812769dish-7.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel8" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1391380317mimi_diablo.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_pad thai.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391425132mimi_teriyaki chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp tempura roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391424447mimi_white snake.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410356863dish-6.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419016rezept-tandoori_chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542534hair spa & Chiken tikka.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413613422193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615787193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615839Hair Spa.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1414362293mimsoftnoodle.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488sushi.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488shrimp rolls.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475487lomein.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812766dish-4.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812768dish-3.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812769dish-7.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div122" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('122');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider9"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1391380317mimi_diablo.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_pad thai.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391425132mimi_teriyaki chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp tempura roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391424447mimi_white snake.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1410356863dish-6.png" /></li>
                                                                                    <li> <img src="uploaded_images/1410419016rezept-tandoori_chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542534hair spa & Chiken tikka.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413613422193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615787193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615839Hair Spa.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1414362293mimsoftnoodle.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488sushi.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488shrimp rolls.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475487lomein.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416812766dish-4.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812768dish-3.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812769dish-7.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel9" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1391380317mimi_diablo.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_pad thai.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391425132mimi_teriyaki chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp tempura roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391424447mimi_white snake.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410356863dish-6.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419016rezept-tandoori_chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542534hair spa & Chiken tikka.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413613422193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615787193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615839Hair Spa.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1414362293mimsoftnoodle.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488sushi.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488shrimp rolls.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475487lomein.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812766dish-4.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812768dish-3.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812769dish-7.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                    
                               <div id="slider_div121" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('121');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider10"  class="flexslider">
                                          <ul class="slides">
                                                                                    <li> <img src="uploaded_images/1391380317mimi_diablo.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_pad thai.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391425132mimi_teriyaki chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391380319mimi_shrimp tempura roll.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1391424447mimi_white snake.JPG" /></li>
                                                                                    <li> <img src="uploaded_images/1410356863dish-6.png" /></li>
                                                                                    <li> <img src="uploaded_images/1410419016rezept-tandoori_chicken.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542534hair spa & Chiken tikka.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413613422193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615787193886489.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1413615839Hair Spa.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1414362293mimsoftnoodle.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488sushi.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475488shrimp rolls.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1415475487lomein.jpg" /></li>
                                                                                    <li> <img src="uploaded_images/1416812766dish-4.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812768dish-3.png" /></li>
                                                                                    <li> <img src="uploaded_images/1416812769dish-7.png" /></li>
                                                                                    </ul>
                                        </div>
                                        
                                        <div id="carousel10" class="carousel1 flexslider">
                                            <ul class="slides">
                                                                                            <li>
                                                    <img src="thumb_images/1391380317mimi_diablo.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_pad thai.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391425132mimi_teriyaki chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391380319mimi_shrimp tempura roll.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1391424447mimi_white snake.JPG" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410356863dish-6.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419016rezept-tandoori_chicken.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1410419087tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413541780grilled-tandoori-style-chicken-600x600-64103.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542534hair spa & Chiken tikka.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413542597tumblr_lsfenq1kn11qflpc1o1_.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413613422193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615787193886489.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1413615839Hair Spa.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1414362293mimsoftnoodle.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/14156836751373921750Fleming_s Prime___ St_eak_hou_se & Wine Bar.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488sushi.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475488shrimp rolls.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1415475487lomein.jpg" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812766dish-4.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812768dish-3.png" />
                                                </li>
                                                                                              <li>
                                                    <img src="thumb_images/1416812769dish-7.png" />
                                                </li>
                                                                                          </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                                                                                
                                    <div class="morebox" id="more121">
                                    <a class="more" id="121" href="javascript:void(0);" onClick="slider_load();">Load More Reviews</a>
                                    </div>
                                    
                                                                </div>
                                
                                
                                
                                <div id="fade1" class="black_overlay"> </div>
                                
									
                                <input type="hidden" name="hid_sort" id="hid_sort" value="ASC">
								<input type="hidden" name="hid_count" id="hid_count" value="10">
                                <input type="hidden" name="hid_count_new" id="hid_count_new" value="10">
                                <input type="hidden" name="hid_sort_type" id="hid_sort_type" value="id">
                                	
                                	
									
								</div>
								
								
							
							</div> <!-- End user-cont -->
							
						</div> <!-- End user-cont -->
						
						<div class="clear"> </div>
					</div> <!-- End user-profile-section -->
					
				
				
				</div>
			
			
			</div>
			<div class="body_footer_bg"> </div>
			<div class="clear"></div>
		</div>
	
	</div>
    
   							 

<div class="clear"></div>


<div class="footer_section">
<div class="footer_container">

<div class="footer_cont_top"></div>

<div class="footer_cont_middle">

<div class="cont_left_one"><a href="index.php"><img src="images/footer-logo.png" width="158" height="80" /></a></div>

<div class="cont_left_two">

<h1>Help Links</h1>

<ul>
<li><a href="contact.php">Contact us</a></li>
<li><a href="about.php">About us</a></li>
<li><a href="faq.php">FAQ</a></li>
<li><a href="contact.php">Add a restaurant</a></li>
</ul>
</div>

<div class="cont_left_two">

<h1>Other Links</h1>

<ul>
<li><a href="terms.php">Terms and Condition</a></li>
<li><a href="privacy.php">Privacy Policy</a></li>
<li><a href="advertisement.php">Advertisement</a></li>
<li><a href="career.php">Career</a></li>
</ul>
</div>


<div class="cont_left_three">

<h1><a href="restaurant_admin_login.php" style="color:#ffffff; text-decoration:none;">Restaurant Owners Login</a></h1>

</div>
<div class="clear"></div>
</div>

<div class="footer_cont_bottom"></div>

</div>

<div class="copyright_section">

<p>© 2014 Restaurant website, All right reserved</p>

<div class="clear"></div>
</div>

</div>
<div class="left_side_icon">
<ul>
<li><a href="https://www.facebook.com/pages/Food-and-Menu/383150028457695" target="_blank"><img src="images/facebook.png" width="37" height="37" /></a></li>
<li><a href="https://twitter.com/foodandmenus" target="_blank"><img src="images/twitter.png" width="37" height="37" /></a></li>
<li><a href="rss" target="_blank"><img src="images/rss.png" width="37" height="37" /></a></li>
<li><a href="www.linkedin.com/pub/michael-nguyen/74/951/692/" target="_blank"><img src="images/linked_in.png" width="37" height="37" /></a></li>
<li><a href="https://plus.google.com/u/1/b/100455298389535660288/100455298389535660288/posts/p/pub" target="_blank"><img src="images/google_plus.png" width="37" height="37" /></a></li>
</ul>
</div>
	
	
</body>
</html>


  
 




  <!-- Syntax Highlighter -->
