<?php
ob_start();
session_start();


//print_r($_SESSION);
include("includes/header_profile.php");
include("includes/functions.php");

?>

<body>

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>
<?php include ("image_file.php");?>

<?php /*?><link rel="stylesheet" href="calender/jquery-ui.css" />
<script src="calender/jquery-1.8.3.js"></script>
<script src="calender/jquery-ui.js"></script>
<script>
$(function() {
	$( "#post_date" ).datepicker({
		dateFormat:"yy-mm-dd"
	});
	//$( "#post_date" ).datepicker( "dd-mm-yy", "dateFormat" );
});
</script><?php */?>
<script type="text/javascript" language="javascript">
function display_reviews(rid,sort_order)
{
	//alert(rid +'    '+sort_order);
	location.href="review.php?id="+rid+"&order="+sort_order+"#tab";
	
}
</script>
<?php
if($_REQUEST['submit']!="")
{
	if($_FILES['customer_image']['name']!="")
	    {
		$image=$_FILES['customer_image']['name'];
	    $image=time().$image;
		if ((($_FILES["customer_image"]["type"] == "image/gif")
		  || ($_FILES["customer_image"]["type"] == "image/png")
		  || ($_FILES["customer_image"]["type"] == "image/bmp")
		  || ($_FILES["customer_image"]["type"] == "image/jpg")
		  || ($_FILES["customer_image"]["type"] == "image/jpeg")
		  || ($_FILES["customer_image"]["type"] == "image/pjpeg")))
		  
		{
			
		
		$picture_url_thumb="thumb_images/".$image;
			LIB_StoreUploadImg($post_file_name="customer_image"
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="70"
								,$file_to_copy_height="63"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
								
		
}
	}
	mysql_query("insert into restaurant_reviews set post_date='".$_REQUEST['post_date']."',customer_name='".$_REQUEST['customer_name']."',customer_review='".$_REQUEST['review']."',customer_picture='".$image."',restaurant_id='".$_REQUEST['restaurant_id']."'");
	
}
?>

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
                    
                    <div class="accr_menu" id="tab">
                        <?php include('includes/tab_menu.php');?>
                        </div>
                    <div class="clear"></div>
					<div class="accr_details">
                    <?php if($_REQUEST['success'] == 1){?>
                    <p style="color:#0C0;float: left;font-family: Arial,Helvetica,sans-serif;font-size: 13px;font-weight: normal;">Review submitted successfully</p><?php } ?>
       <?php
	   $total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$_REQUEST['id']."' AND status=1"));
	   ?>             
                    	<div class="heading_txt2"><h2>Total Reviews : <?php echo $total_review?></h2>
                
                        <a href="write_review.php?id=<?php echo $_REQUEST['id'];?>">Write a Review</a>
                        
                        <div class="clear"></div>
                        
                        </div>
                        <div class="clear"></div>
                        <?php
						
						$sql = "SELECT * 
								FROM restaurant_reviews as rr,restaurant_rating as rrat 
								WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['id']."' AND rr.status=1";
						if(isset($_REQUEST['order']) && $_REQUEST['order'] == 'most-recent'){
							$sql .= " ORDER BY rr.id DESC ";
						}
						if(isset($_REQUEST['order']) && $_REQUEST['order'] == 'most-rated'){
							$sql .= " ORDER BY rrat.score_5,rrat.score_4,rrat.score_3,rrat.score_2,rrat.score_1 ASC ";
						}
						
						$sql_review = mysql_query($sql);
						$num_review=mysql_num_rows($sql_review);
						if($num_review>0)
						{
							
							while($res_review=mysql_fetch_array($sql_review))
							{
								$customerInfo = customerInfo($res_review['customer_id']);
								$cust_img = ($customerInfo['image']!='') ? $customerInfo['image'] : 'no_image.png';
								 $rating = getSingleReviewRating($_REQUEST['id'],$res_review['id']);
						?>
                      <div class="review_detail">
                      	
                        <div class="arrow_review"><img src="images/arrow_review.jpg" alt="" /></div>
                                	<div class="review_light">
                                    <ul>
                                        <li><a id="various1" href="#inline1" title="Lorem ipsum dolor sit amet">
                                        <img src="thumb_images/<?php echo $cust_img; ?>" alt="" title="" /></a>
                                        </li>
                                    </ul>
                                    
                                    <div style="display: none;">
                                    <div id="inline1" style="width:600px;height:240px;overflow:auto;">
                                        <div class="review_top">
                                          <img src="images/review_pic.jpg" width="180" height="220" /> 
                                          <h1><span>Name :</span> Name Here</h1>
                                          <ul>
                                          <li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
                                          <li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
                                          <li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
                                          <li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
                                          <li><a href="#"><img src="images/star-3.png" width="15" height="15" /></a></li>
                                          </ul>
                                          
                                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                                          
                                          </div>
                                    </div>
                                </div>

	
    
</div>
                                    <div class="review_txt">
                                   
                                    
                                 <div class="rating_content">
                                    <ul>
                                    	<?php
										$rem = 5 - $rating;
										if($rating > 0)
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
										else{
								?>
                                 <li><div style="width:165px;">&nbsp;</div></li>
                                  <!--<li>&nbsp;</li>
                                  <li>&nbsp;</li>
                                  <li>&nbsp;</li>
                                  <li>&nbsp;</li>-->
                                        <?php
										}
										if($rating > 0)
										{
										?>
                                        <li><?php echo change_dateformat_reverse($res_review['post_date']); ?></li>
                                        <?php
										}else{
										?>
                                         <li>&nbsp;</li>
                                        <?php
										}
										?>
                                	</ul>
                                    
                                </div>   
                                
                                <div class="rating_content_two">
                                    <ul>
									<?php if(isset($_SESSION['customer_id'])){ ?>
                                    <!--<li><a href="#"></a></li>-->
                                    <li id="li_like_<?php echo $res_review['id']; ?>">
									<?php if(is_customer_has_like_unlike_on_review($res_review['id'], $_SESSION['customer_id'], 'like')){?>
                                    
                                    <span class="like_text" id="like_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'like'); ?></span><img src="images/like_select.png" width="16" height="16" />
                                    <?php } else { ?>
                                    <span class="like_text" id="like_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $res_review['id']; ?>" class="like" review="<?php echo $res_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
									<?php } ?>
                                    </li>
                                    <li id="li_dislike_<?php echo $res_review['id']; ?>">
                                    <?php if(is_customer_has_like_unlike_on_review($res_review['id'], $_SESSION['customer_id'], 'dislike')){?>
                                    <img src="images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'dislike'); ?></span>
                                    
                                    <?php /*?><?php } else { ?>
                                    <li id="li_like_<?php echo $res_review['id']; ?>">
                                    <span class="like_text" id="like_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $res_review['id']; ?>" class="like" review="<?php echo $res_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
                                    </li>
                                    <li id="li_dislike_<?php echo $res_review['id']; ?>">
                                    <a href="dislike" id="do_dislike_<?php echo $res_review['id']; ?>" class="dislike" review="<?php echo $res_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'dislike'); ?></span>
                                    </li><?php */?>
                                     <?php } else { ?>
                                     <a href="dislike" id="do_dislike_<?php echo $res_review['id']; ?>" class="dislike" review="<?php echo $res_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'dislike'); ?></span>
									<?php } ?>
                                    </li>
                                    
                                    <!--<li><a href="#"></a></li>-->
                                    <?php } else { ?>
                                    <!--<li><a href="#"></a></li>-->
                                    <li id="li_like_<?php echo $res_review['id']; ?>"><span class="like_text" id="like_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'like'); ?></span><a href="like" onClick="like_unlike_alert('Please Login First to Like this'); return false;"><img src="images/like_select.png" width="16" height="16" /></a></li>
                                    <li id="li_dislike_<?php echo $res_review['id']; ?>"><a href="dislike"  onClick="like_unlike_alert('Please Login First to Unlike this'); return false;"><img src="images/unlike_select.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'dislike'); ?></span></li>
                                    <!--<li><a href="#"></a></li>-->
                                    <?php } ?>
                                </ul>
                                </div>
                                    	
                                   	  <h5>
<?php echo change_dateformat_reverse($res_review['post_date']); ?>  By <span><?php echo $res_review['customer_name']?></span></h5>
                                        <p><?php echo $res_review['customer_review']?></p>
                                        <div class="viewers_comment">
                                    <ul>
                                    <li><a href="mailto:?body=<?php echo $res_review['customer_review']?>&subject=<?php echo date("d-m-Y", strtotime($res_review['post_date'])); ?>  By <?php echo $res_review['customer_name']?>" target="_blank">Email</a></li>
                                    <li><a href="#">Share with facebook</a></li>
                                    <li><a href="report_abuse.php?id=<?php echo $_REQUEST['id'] ?>&r_id=<?php echo $res_review['id']; ?>">Report Abuse</a></li>
                                </ul>
                                </div>
                                    </div>
                                </div>
                               <div class="clear"></div>
                               <?php
							}
						}else{?>
                         <div class="review_detail"><h2 style="background-color: #FFFFFF;color: #E46002;font: 24px 'Lobster Two';margin-left: 25px;
padding: 0 1px;">No reviews yet</h2></div>
                        <?php
						}
						?>
                              
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
<script type="text/javascript">
function like_unlike_alert(msg){
	if(confirm(msg + '\n\tYou want to login?')){
		top.location.href = "login.php?rev=1";
	}
}
</script>

<?php include("includes/footer.php");?>