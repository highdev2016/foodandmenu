<?php 
session_start();
ob_start();


include ("includes/header.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");

$customer_id = $_REQUEST['id'];

?>
<link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />


<script type="text/javascript">
function open_slider_div(id)
{
	//var $j = jQuery.noConflict();
	
	$("#slider_div"+id).css("visibility", "visible").css('opacity', '100');
	$("#fade1").show();
}

function close_slider_div(id)
{
	//var $j = jQuery.noConflict();
	
	$("#slider_div"+id).css("visibility", "hidden").css('opacity', '0');
	$("#fade1").hide();
}
</script>


<script type="text/javascript">
//var $j = jQuery.noConflict();

$(function()
{
$('.more').live("click",function()
{
var ID = $(this).attr("id");
var cust_id = $("#cust_id").val();
var hid_count = $("#hid_count").val();
//alert(hid_count);
if(ID)
{
$("#more"+ID).html('<img src="images/moreajax.gif" />');

$.ajax({
type: "POST",
url: "ajax_user.php",
data: "lastmsg="+ ID + "&cust_id=" + cust_id + "&new_count=" + hid_count,
cache: false,
success: function(html){
	//alert(html);
var new_hid_count = parseInt(hid_count) + parseInt(5);	
$("#right-top").append(html);
$("#more"+ID).remove(); // removing old more button
$("#hid_count").val(new_hid_count);
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

$sql = "SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND rr.review_status = 0 AND rr.review_status = 0 order by id DESC LIMIT 0,5";

$sql_res = mysql_query($sql);

$sql_slider = "SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 order by id DESC";

$sql_res_slider = mysql_query($sql_slider);

$page_review_count = mysql_num_rows($sql_res);

$review_count = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND parent_id = 0 AND rr.review_status = 0 order by id desc"));
 

$like_count = mysql_fetch_array(mysql_query("SELECT SUM(is_like) as like_count FROM restaurant_like_dislike WHERE customer_id = '".$customer_id."' AND is_like_status = 1 "));

$dislike_count = mysql_fetch_array(mysql_query("SELECT SUM(is_dislike) as dislike_count FROM restaurant_like_dislike WHERE customer_id = '".$customer_id."' AND is_dislike_status = 1 "));

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
								
								<?php
								if($like_count['like_count'] > 1)
								{
									$like_word = "likes";
								}
								else
								{
									$like_word = "like";
								}
								
								if($dislike_count['dislike_count'] > 1)
								{
									$dislike_word = "dislikes";
								}
								else
								{
									$dislike_word = "dislike";
								}
								
								?>
                                
								<h4>
									<strong><?php echo $like_count['like_count']." ".$like_word; ?> </strong>,  
									<strong><?php echo $dislike_count['dislike_count']." ".$dislike_word; ?> </strong>
								</h4>
								
								<!--<div class="review-up">
									<img src="images/reload.png" align="absmiddle" /> 1 Review update
								</div>
								<div class="clear"> </div>
								
								<div class="report-ab">
									<img src="images/report-flag.png" align="absmiddle" /> Report Abuse
								</div>-->
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
                                
                                <?php 
								$cnt = 1;
								while($row=mysql_fetch_array($sql_res)) 
								{
									$msg_id = $row['id'];
									$sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
									$num_rws = mysql_num_rows($sql_photo);
									
									$sql_updated_review = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND parent_id = '".$row['id']."' AND rr.review_status = 1 ORDER BY rr.id DESC");
									
									 ?>
									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        <?php 
										$restaurant_image = getNameTable("restaurant_basic_info","restaurant_image","id",$row['restaurant_id']) ;
										if($num_rws > 0)
										{
										?>
											<a href="javascript:void(0);" onClick="open_slider_div('<?php echo $row['id'] ?>');"><img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" /></a>
                                        <?php
										}
										else
										{
										?>
											<img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" />
                                        <?php
										}
										?>
										</div>
										
										<div class="restu-block-right">
											<div class="restu-block-top">
												<div class="restu-name-sec">
													<h1 class="res_name"><a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo stripslashes(getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']));?></a></h1>
													<div class="clear"> </div>
													<a href="javascript:void(0);" class="small-cat">Categories : <?php echo getNameTable("restaurant_basic_info","restaurant_category_name","id",$row['restaurant_id']);?></a>
													<div class="clear"> </div>
                                                    
													<?php while($row_updated_review = mysql_fetch_array($sql_updated_review))
								   					{
													?>
                                                    <div class="rating_content">
                                                            <ul>
                                                                <?php
                                                                $rating1 = getSingleReviewRating($row_updated_review['restaurant_id'],$row_updated_review['id']);
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
                                                        <div class="clear"></div>
                                                        
                                                    
                                                    <div class="restu-block-botm">
                                                    <div class="post_date">
                                                       
                                                            <div style="color: #777; font-size: 14px; float:right; margin-top:26px;">Posted on <?php echo date("m-d-Y", strtotime($row_updated_review['post_date'])); ?></div>
                                                    </div>
                                                    <p>
                                                        <?php echo $row_updated_review['customer_review'];?>
                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                        <div class="soc_icon">
                                                            <a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194"> <img src="images/facebook_share.jpg"></a>
                                                        </div>
                                                        
                                                        <div class="soc_icon">
                                                            <?php /*?><a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a><?php */?> 
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:60px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="clear"> </div>
                                                </div>
                                                
                                                <?php if($row_updated_review['abuse_status']==0){
                                                ?>
                                                <div class="report-ab">
                                                    <img src="images/report-flag.png" align="absmiddle">
                                                    <?php if(isset($_SESSION['customer_id'])){
                                                    ?>
                                                    <a href="report_abuse.php?id=<?php echo $row_updated_review['restaurant_id']; ?>&r_id=<?php echo $row_updated_review['id']; ?>" style="color:#000000;">Report Abuse</a>
                                                    <?php }else{ ?>
                                                    <a href="login.php" style="color:#000000;">Report Abuse</a>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>     
                                                        
                                                    
                                                    
                                                    <?php
													}
													?>
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
												
												<div class="location-sec res_add">
													<img src="images/address_pic.png" alt="" />
														<a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo getNameTable("restaurant_basic_info","restaurant_address","id",$row['restaurant_id']);?></a>
                                                        
												</div>
                                                <div class="post_date">
                                                Posted on <?php echo date("m-d-Y", strtotime($row['post_date'])); ?>
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
														<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=1194"> <img src="images/facebook_share.jpg"></a>
													</div>
                                                    
													<div class="soc_icon">
														<?php /*?><a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a><?php */?> 
                                                        <script type="text/javascript">
                                                          (function() {
                                                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                            po.src = 'https://apis.google.com/js/platform.js';
                                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                          })();
                                                        </script>
                                                        
                                                        <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:60px;"></iframe></div>
													</div>
                                                    
												</div>
												
												<div class="clear"> </div>
											</div> 
											
											<div class="clear"> </div>
                                            
                                            
                                            <?php if($row['abuse_status']==0){
											?>
                                            <div class="report-ab">
                                                <img src="images/report-flag.png" align="absmiddle">
                                                <?php if(isset($_SESSION['customer_id'])){
												?>
                                                <a href="report_abuse.php?id=<?php echo $row['restaurant_id']; ?>&r_id=<?php echo $row['id']; ?>" style="color:#000000;">Report Abuse</a>
                                                <?php }else{ ?>
                                                <a href="login.php" style="color:#000000;">Report Abuse</a>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
										</div>
										
										<div class="clear"> </div>
									</div>
           
                                    
                                <?php
								$cnt++; 
								}?>
                                
                                <?php if($num_rws >1){
									$cnt = 1;
								while($row=mysql_fetch_array($sql_res_slider)){ ?>
                                    
                               <div id="slider_div<?php echo $row['id'] ?>" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('<?php echo $row['id'] ?>');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider<?php echo $cnt; ?>"  class="flexslider">
                                          <ul class="slides">
                                          <?php
                                          $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
                                          
                                          while($row_photo=mysql_fetch_array($sql_photo))
                                          {
                                          ?>
                                          <li> <img src="uploaded_images/<?php echo $row_photo['image_name']; ?>" /></li>
                                          <?php
                                          }
                                          ?>
                                          </ul>
                                        </div>
                                        
                                        <div id="carousel<?php echo $cnt; ?>" class="carousel1 flexslider">
                                            <ul class="slides">
                                            <?php
                                              $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
                                              while($row_photo=mysql_fetch_array($sql_photo))
                                              {
                                              ?>
                                                <li>
                                                    <img src="thumb_images/<?php echo $row_photo['image_name']; ?>" />
                                                </li>
                                              <?php
                                              }
                                              ?>
                                            </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                <?php $cnt++; 
								} } ?>
                                <?php
								
								if($review_count > 5)
								{
								?>
                                
                                    <div class="morebox" id="more<?php echo $msg_id;?>">
                                    <a class="more" id="<?php echo $msg_id;?>" href="javascript:void(0);" onClick="slider_load();">Load More Reviews</a>
                                    </div>
                                    
                                <?php
								}
								?>
                                
                                
                                
                                
                                <div id="fade1" class="black_overlay"> </div>
                                
									
                                    
								<input type="hidden" name="hid_count" id="hid_count" value="10">
                                <input type="hidden" name="hid_count_new" id="hid_count_new" value="<?php echo $review_count; ?>">
                                
                                	
									
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
<?php include("includes/footer.php");?>


<?php /*?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><?php */?>
  <?php /*?><script>window.jQuery || document.write('<script src="js/jquery-1.7.min.js">\x3C/script>')</script><?php */?>

  <!-- FlexSlider -->
  <script defer src="js/jquery.flexslider.js"></script>

  <?php /*?><script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script><?php */?>
  
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


  <!-- Syntax Highlighter -->
