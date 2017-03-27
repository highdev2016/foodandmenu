<?php 
session_start();
ob_start();


//include("search_compete.php"); 
include ("includes/header.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");

$customer_id = $_REQUEST['id'];

?>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

<script type="text/javascript" src="js/jssor.js"></script>
<script type="text/javascript" src="js/jssor.slider.js"></script>

<script>

jQuery(document).ready(function ($) {

	var _SlideshowTransitions = [
	//Fade in L
		{$Duration: 1200, x: 0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade out R
		, { $Duration: 1200, x: -0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade in R
		, { $Duration: 1200, x: -0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade out L
		, { $Duration: 1200, x: 0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

	//Fade in T
		, { $Duration: 1200, y: 0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	//Fade out B
		, { $Duration: 1200, y: -0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	//Fade in B
		, { $Duration: 1200, y: -0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade out T
		, { $Duration: 1200, y: 0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

	//Fade in LR
		, { $Duration: 1200, x: 0.3, $Cols: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	//Fade out LR
		, { $Duration: 1200, x: 0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	//Fade in TB
		, { $Duration: 1200, y: 0.3, $Rows: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade out TB
		, { $Duration: 1200, y: 0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

	//Fade in LR Chess
		, { $Duration: 1200, y: 0.3, $Cols: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	//Fade out LR Chess
		, { $Duration: 1200, y: -0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade in TB Chess
		, { $Duration: 1200, x: 0.3, $Rows: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	//Fade out TB Chess
		, { $Duration: 1200, x: -0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

	//Fade in Corners
		, { $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
	//Fade out Corners
		, { $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $SlideOut: true, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }

	//Fade Clip in H
		, { $Duration: 1200, $Delay: 20, $Clip: 3, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade Clip out H
		, { $Duration: 1200, $Delay: 20, $Clip: 3, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade Clip in V
		, { $Duration: 1200, $Delay: 20, $Clip: 12, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
	//Fade Clip out V
		, { $Duration: 1200, $Delay: 20, $Clip: 12, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
		];

	var options = {
		$AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
		$AutoPlayInterval: 1500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
		$PauseOnHover: 1,                                //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

		$DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
		$ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
		$SlideDuration: 800,                                //Specifies default duration (swipe) for slide in milliseconds

		$SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
			$Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
			$Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
			$TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
			$ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
		},

		$ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
			$Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
			$ChanceToShow: 1                               //[Required] 0 Never, 1 Mouse Over, 2 Always
		},

		$ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
			$Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
			$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

			$ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
			$SpacingX: 8,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
			$DisplayPieces: 10,                             //[Optional] Number of pieces to display, default value is 1
			$ParkingPosition: 360                          //[Optional] The offset position to park thumbnail
		}
	};

	var jssor_slider1 = new $JssorSlider$("slider1_container", options);
	var jssor_slider2 = new $JssorSlider$("slider2_container", options);
	var jssor_slider3 = new $JssorSlider$("slider3_container", options);
	var jssor_slider4 = new $JssorSlider$("slider4_container", options);
	var jssor_slider5 = new $JssorSlider$("slider5_container", options);
	
	
	//responsive code begin
	//you can remove responsive code if you don't want the slider scales while window resizes
	function ScaleSlider() {
		var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
		if (parentWidth)
			jssor_slider1.$ScaleWidth(Math.max(Math.min(parentWidth, 800), 300));
		else
			window.setTimeout(ScaleSlider, 30);
		
		var parentWidth = jssor_slider2.$Elmt.parentNode.clientWidth;
		if (parentWidth)
			jssor_slider2.$ScaleWidth(Math.max(Math.min(parentWidth, 800), 300));
		else
			window.setTimeout(ScaleSlider, 30);	
			
			
		var parentWidth = jssor_slider3.$Elmt.parentNode.clientWidth;
		if (parentWidth)
			jssor_slider3.$ScaleWidth(Math.max(Math.min(parentWidth, 800), 300));
		else
			window.setTimeout(ScaleSlider, 30);		
			
			
		var parentWidth = jssor_slider4.$Elmt.parentNode.clientWidth;
		if (parentWidth)
			jssor_slider4.$ScaleWidth(Math.max(Math.min(parentWidth, 800), 300));
		else
			window.setTimeout(ScaleSlider, 30);		
			
			
		var parentWidth = jssor_slider5.$Elmt.parentNode.clientWidth;
		if (parentWidth)
			jssor_slider5.$ScaleWidth(Math.max(Math.min(parentWidth, 800), 300));
		else
			window.setTimeout(ScaleSlider, 30);		
			
			
			
	}

	ScaleSlider();

	if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
		$(window).bind('resize', ScaleSlider);
	}


	//if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
	//    $(window).bind("orientationchange", ScaleSlider);
	//}
	//responsive code end
});
</script>
    
<script type="text/javascript">
function open_slider_div(id)
{
	var $j = jQuery.noConflict();
	
	$j("#slider_div"+id).show();
	$j("#fade1").show;
}

function close_slider_div(id)
{
	var $j = jQuery.noConflict();
	
	$j("#slider_div"+id).hide();
	$j("#fade1").hide;
}
</script>


<script type="text/javascript">
$(function()
{
$('.more').live("click",function()
{
var ID = $(this).attr("id");
var cust_id = $("#cust_id").val();
//alert(ID);
if(ID)
{
$("#more"+ID).html('<img src="images/moreajax.gif" />');

$.ajax({
type: "POST",
url: "ajax_user.php",
data: "lastmsg="+ ID + "&cust_id=" + cust_id,
cache: false,
success: function(html){
	//alert(html);
$("#right-top").append(html);
$("#more"+ID).remove(); // removing old more button
}
});
}
else
{
$(".morebox").html('The End');// no results
}

return false;
});
});
</script>
<body onLoad="init();">

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>

<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $customer_id; ?>" />

<?php 
$username = getNameTable("restaurant_customer","firstname","id",$customer_id);

$joining_date = date("F Y", strtotime(getNameTable("restaurant_customer","registration_time","id",$customer_id)));

$profile_pic = getNameTable("restaurant_customer","image","id",$customer_id);

$address = getNameTable("restaurant_customer","address","id",$customer_id);

$sql = "SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 order by id desc LIMIT 0,5";

$sql_res = mysql_query($sql);

$page_review_count = mysql_num_rows($sql_res);

$review_count = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 order by id desc"));
 

?>
	<div class="body_section">
	
		<div class="body_container">
			<div class="body_top"> </div>
			<div class="main_body">
			
				<div class="contact_body_cont" style="min-height:600px;">
				
					<div class="user-profile-section">
						
						<div class="user-profile-top">
							<div class="profile-name">
                            
								<h1><?php echo $username."'s"; ?> Profile</h1>
							</div>
							<div class="follow-section">
								<ul>
									<li>
										 <a href="javascript:void(0);">
											 <img src="images/star-on.png" /> <strong> Reviews</strong> <br />
											 <span><?php echo $review_count; ?></span>
										 </a>
									</li>
									
									<li>
										 <a href="javascript:void(0);">
											<strong>Following</strong> <br />
											 <span>2,014</span>
										 </a>
									</li>
									<li>
										 <a href="javascript:void(0);">
											<strong>Followers</strong> <br />
											 <span>2,014</span>
										 </a>
									</li>
									<li>
										 <a href="javascript:void(0);">
											<strong>Favorites</strong> <br />
											 <span>139</span>
										 </a>
									</li>
									<li>
										 <a href="javascript:void(0);" class="follow-btn"><img src="images/follower.png" align="absmiddle" /> Follow </a>
									</li>
								</ul>
							</div>
							<div class="clear"> </div>
						</div> <!-- End user-profile-top -->
						<div class="clear"> </div>
						
						<div class="user-cont">
							
							<div class="user-cont-left">
								<div class="pro-pic">
                                <?php if($profile_pic != "")
								{
									?>
									<img src="uploaded_images/<?php echo $profile_pic; ?>" alt="" width="200" height="180" />
                                    <?php
								}
								else
								{
									?>
                                    <img src="images/no_image.png" alt="" width="200" />
                                    <?php
								}
								?>
								</div>
								
								<label>
									<h5>Member Since</h5>
									<p><?php echo $joining_date; ?></p>
								</label>
								
								<label>
									<h5>Location</h5>
									<p><?php echo $address; ?></p>
								</label>
								
								<label>
									<input type="checkbox" class="regular-checkbox big-checkbox" name="review" id="review" />
									<label for="review"></label>
									
									 Review Votes
								</label>
								<div class="clear"> </div>
								
								<h4>
									<strong>3 likes</strong>,  
									<strong>2 dislikes</strong>
								</h4>
								
								<div class="review-up">
									<img src="images/reload.png" align="absmiddle" /> 1 Review update
								</div>
								<div class="clear"> </div>
								
								<div class="report-ab">
									<img src="images/report-flag.png" align="absmiddle" /> Report Abuse
								</div>
								<div class="clear"> </div>
								
								
								
							
							</div> <!-- End user-cont -->
							
							
							
							<div class="user-cont-right">
								<div class="right-top" >
									<h4>
                                    <?php
									
									if($review_count > 1)
									{
										?>
										Recent Reviews <span> <?php echo $review_count; ?> Reviews</span>
                                        <?php
									}
									else
									{
										?>
										Recent Reviews <span> <?php echo $review_count; ?> Review</span>
                                        <?php
									}
									?>
									</h4>
									<div class="clear"> </div>
									<ul class="sortby">
										<li>Sort by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);">Date</a></li>
										
										<li>Filter by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);"> Location</a></li>
										<li><a href="javascript:void(0);">Category</a></li>
									</ul>
									<div class="clear"> </div>
								</div>
								<div class="clear"> </div>
								
								<div class="right-top" id="right-top">
                                
                                <!-- Start restu-block -->
                                
                                <?php while($row=mysql_fetch_array($sql_res)) 
								{
									$msg_id = $row['id'];
									
									$sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
									 ?>
									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        <?php 
										$restaurant_image = getNameTable("restaurant_basic_info","restaurant_image","id",$row['restaurant_id']) 
										?>
											<a href="javascript:void(0);" onClick="open_slider_div('<?php echo $row['id'] ?>');"><img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" /></a>
										</div>
										
										<div class="restu-block-right">
											<div class="restu-block-top">
												<div class="restu-name-sec">
													<h1 class="res_name"><a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo stripslashes(getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']));?></a></h1>
													<div class="clear"> </div>
													<a href="javascript:void(0);" class="small-cat">Categories : <?php echo getNameTable("restaurant_basic_info","restaurant_category_name","id",$row['restaurant_id']);?></a>
													<div class="clear"> </div>
													<div class="rating_content">
														<ul>
															<?php
															$rating1 = getSingleReviewRating($row['restaurant_id'],$row['id']);
															//echo $rating1;
															$rem = 5 - $rating1;
															if($rating1 > 0)
															{
																for($i=0; $i<$rating1;$i++){
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
															else{
															?>
															<?php
															}
															?>
														</ul>
														
													</div> 
                                                    
												</div>
												
												<div class="location-sec">
													<img src="images/address_pic.png" alt="" />
														<?php echo getNameTable("restaurant_basic_info","restaurant_address","id",$row['restaurant_id']);?><br>
                                                        <div style="color: #777; font-size: 14px; float:right; margin-top:26px;">Posted on <?php echo date("m-d-Y", strtotime($row['post_date'])); ?></div>
												</div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													<?php echo $row['customer_review'];?>
												</p>
												<div class="clear"> </div>
												
												<div class="like-sec">
													
													<div class="soc_icon">
														<a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a>
													</div>
													<div class="soc_icon">
														<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194"> <img src="images/facebook_share.jpg"></a>
													</div>
													
													
												</div>
												
												<div class="clear"> </div>
											</div> 
											
											<div class="clear"> </div>
										</div>
										
										<div class="clear"> </div>
									</div>
                                    
           <div id="slider_div<?php echo $row['id'] ?>" class="factor_details white_content nw_white_cont" style="display:none;">
            <div class="close close-new" onClick="close_slider_div('<?php echo $row['id'] ?>');"><a href = "javascript:void(0);"></a> </div>
            <div class="l-contnt nw-l-cont"> 
    		
            
            <?php
            while($row_photo = mysql_fetch_array($sql_photo))
			{
			 ?>
             
             	
             <?php
			}
            
            
            
            ?>
            
            
            </div>
            </div>
            <div id="fade1" class="black_overlay"> </div>
                                    
                                    <?php 
								}
								
								if($review_count > 5)
								{
								?>
                                
                                    <div class="morebox" id="more<?php echo $msg_id;?>">
                                    <a class="more" id="<?php echo $msg_id;?>" href="javascript:void(0);">Load More Reviews</a>
                                    </div>
                                    
                                <?php
								}
								?>
                                     <!-- End restu-block -->
									
									<!--<div class="restu-block">
										
										<div class="restu-block-left">
											<img src="images/thumbstrip10.jpg" align="" />
										</div>
										
										<div class="restu-block-right">
											<div class="restu-block-top">
												<div class="restu-name-sec">
													<h1>Lorem ipsum dolor sit amet</h1>
													<div class="clear"> </div>
													<a href="javascript:void(0);" class="small-cat">Categories : Lorem ipsum, dolor sit (dolor sit)</a>
													<div class="clear"> </div>
													<div class="rating_content">
														<ul>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="16" src="images/star-1.png"></li>
															<li><img width="16" height="15" src="images/star-3.png"></li>
														</ul>
														
													</div> 
												</div>
												
												<div class="location-sec">
													<img src="images/address_pic.png" alt="" />
														160 Lorem ipsum dolor <br /> Lorem ipsum dolor sit amet
												</div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
												</p>
												<div class="clear"> </div>
												
												<div class="like-sec">
													
													<div class="soc_icon">
														<a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a>
													</div>
													<div class="soc_icon">
														<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194"> <img src="images/facebook_share.jpg"></a>
													</div>
													
													
												</div>
												
												<div class="clear"> </div>
											</div> 
											
											<div class="clear"> </div>
										</div>
										
										<div class="clear"> </div>
									</div>--> 
									
									
								</div>
								
								
							
							</div> <!-- End user-cont -->
							
						</div> <!-- End user-cont -->
						
						<div class="clear"> </div>
					</div> <!-- End user-profile-section -->
					
				
				<?php 
				$sql = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 order by id ASC LIMIT 0,5");
				$ii = 1;
				while($row=mysql_fetch_array($sql))
				{
				?>
				<div id="slider<?php echo $ii; ?>_container" style="position: relative; top: 0px; left: 0px; width: 800px;
        height: 456px; background: #191919; overflow: hidden;">
        
            <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                    background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
                </div>
                <div style="position: absolute; display: block; background: url(../images/loading.gif) no-repeat center center;
                    top: 0px; left: 0px;width: 100%;height:100%;">
                </div>
            </div>
             <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 356px; overflow: hidden;">
              <?php
				 $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
				while($row_photo = mysql_fetch_array($sql_photo))
				{
				 ?>
             <div>
                <img u="image" src="uploaded_images/<?php echo $row_photo['image_name'];?>" />
                <img u="thumb" src="thumb_images/<?php echo $row_photo['image_name'];?>" />
            </div>
            <?php } ?>
                </div>
<style>
/* jssor slider arrow navigator skin 05 css */
/*
.jssora05l              (normal)
.jssora05r              (normal)
.jssora05l:hover        (normal mouseover)
.jssora05r:hover        (normal mouseover)
.jssora05ldn            (mousedown)
.jssora05rdn            (mousedown)
*/
.jssora05l, .jssora05r, .jssora05ldn, .jssora05rdn
{
position: absolute;
cursor: pointer;
display: block;
background: url(../images/a17.png) no-repeat;
overflow:hidden;
}
.jssora05l { background-position: -10px -40px; }
.jssora05r { background-position: -70px -40px; }
.jssora05l:hover { background-position: -130px -40px; }
.jssora05r:hover { background-position: -190px -40px; }
.jssora05ldn { background-position: -250px -40px; }
.jssora05rdn { background-position: -310px -40px; }
</style>
<!-- Arrow Left -->
        <span u="arrowleft" class="jssora05l" style="width: 40px; height: 40px; top: 158px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora05r" style="width: 40px; height: 40px; top: 158px; right: 8px">
        </span>
        <!-- Arrow Navigator Skin End -->
        
        <!-- Thumbnail Navigator Skin Begin -->
        <div u="thumbnavigator" class="jssort01" style="position: absolute; width: 800px; height: 100px; left:0px; bottom: 0px;">
            <!-- Thumbnail Item Skin Begin -->
            <style>
                /* jssor slider thumbnail navigator skin 01 css */
                /*
                .jssort01 .p           (normal)
                .jssort01 .p:hover     (normal mouseover)
                .jssort01 .pav           (active)
                .jssort01 .pav:hover     (active mouseover)
                .jssort01 .pdn           (mousedown)
                */
                .jssort01 .w {
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    width: 100%;
                    height: 100%;
                }

                .jssort01 .c {
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    width: 68px;
                    height: 68px;
                    border: #000 2px solid;
                }

                .jssort01 .p:hover .c, .jssort01 .pav:hover .c, .jssort01 .pav .c {
                    background: url(../images/t01.png) center center;
                    border-width: 0px;
                    top: 2px;
                    left: 2px;
                    width: 68px;
                    height: 68px;
                }

                .jssort01 .p:hover .c, .jssort01 .pav:hover .c {
                    top: 0px;
                    left: 0px;
                    width: 70px;
                    height: 70px;
                    border: #fff 1px solid;
                }
            </style>
            <div u="slides" style="cursor: move;">
                <div u="prototype" class="p" style="position: absolute; width: 72px; height: 72px; top: 0; left: 0;">
                    <div class=w><thumbnailtemplate style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></thumbnailtemplate></div>
                    <div class=c>
                    </div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        <!-- Thumbnail Navigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">jquery slider plugin</a>
        
    </div>
    <?php  $ii++; } ?>
    
    
	
    			
				
				
				
				
				</div>
			
			
			</div>
			<div class="body_footer_bg"> </div>
			<div class="clear"></div>
		</div>
	
	</div>

<div class="clear"></div>
<?php include("includes/footer.php");?>


    <!-- Jssor Slider End -->