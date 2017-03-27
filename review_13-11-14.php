<?php
ob_start();
session_start();

//print_r($_SESSION);
include("includes/header_profile.php");
include("includes/functions.php");
//include("search_compete.php");
?>

<body onLoad="init();">
 <?php if($_REQUEST['abuse_status'] == 1){ $display = 'block'; } else { $display = 'none'; }?>  
    <div id="fade" style="display:<?php echo $display; ?>"></div>


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

<script type="text/javascript" src="http://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="http://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
	
	var $j = jQuery.noConflict();
	
  $j(document).ready(function() {
   /*
   *   Examples - images
   */
   
   
   $j("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script>

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
<div style="width:400px; height:1px; margin:0 auto; display:<?php echo $display;?>" id="light">
                                              
<div  style="width:300px; position:absolute; z-index:9999999; background:#fff; padding:50px 20px; color:#000; font-family:Calibri; font-size:18px; height:100px; -moz-box-shadow: 0 0 5px #888;
-webkit-box-shadow: 0 0 5px#888;
box-shadow: 0 0 5px #888; text-align:center;">
<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><img src="images/fancy_closebox.png" style=" margin-left: 259px;
    position: absolute;
    margin-top: -60px; cursor:pointer;"/></a>
                    Your request is sent to Admin
                    </div>
                    </div>
    <div class="body_container">
        <div class="body_top"></div>
        <div class="main_body">
            <div class="food_body_cont">
                <div class="food_content">
                    <!--<div class="food_cont_top">
                    	<h1>Home</h1>
                    </div>-->
                    
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
	   $get_cust_id = mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$_REQUEST['id']."' AND status=1");
	   ?>             
                    	<div class="heading_txt2 heading_txt_nw_2"><h2>Total Reviews : <?php echo $total_review?></h2>
                
                        <a href="write_review.php?id=<?php echo $_REQUEST['id'];?>" style="font-size:25px;">Write a Review</a>
                        <div class="clear"></div>
                        
                        </div>
                        <div class="clear"></div>
                        <?php
						
						$sql = "SELECT rr.id,rr.post_date,rr.customer_name,rr.customer_email,rr.customer_picture, rr.customer_review,rr.restaurant_id, rr.customer_id , rr.restaurant_name , rr.like , rr.dislike ,  rrat.rating_id ,  rrat.rating_id FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['id']."' AND rrat.restaurant_id='".$_REQUEST['id']."' AND rr.status=1 AND rr.review_status = 0";
						if(isset($_REQUEST['order']) && $_REQUEST['order'] == 'most-recent'){
							$sql .= " ORDER BY rr.id DESC ";
						}
						else if(isset($_REQUEST['order']) && $_REQUEST['order'] == 'most-rated'){
							//$sql .= " ORDER BY rrat.score_5,rrat.score_4,rrat.score_3,rrat.score_2,rrat.score_1 ASC ";
							$sql .= " ORDER BY rrat.score_1,rrat.score_2,rrat.score_3,rrat.score_4,rrat.score_5 DESC ";
						}
						else{
							$sql .= " ORDER BY rr.post_date DESC";
						}
						//echo $sql;
						$sql_review = mysql_query($sql);
						$num_review=mysql_num_rows($sql_review);
						
						if($num_review>0)
						{
							$counter = 0;
							while($res_review=mysql_fetch_array($sql_review))
							{
								$rev_count = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['id']."' AND rrat.restaurant_id='".$_REQUEST['id']."' AND rr.status=1 AND rr.customer_id = '".$res_review['customer_id']."' ORDER BY rr.id DESC"));
								
								
								
								$customerInfo = customerInfo($res_review['customer_id']);
								//echo $res_review['id'];
								/*echo '<pre>';
								print_r($customerInfo);*/
								$cust_img = ($customerInfo['image']!='') ? $customerInfo['image'] : 'no_image.png';
								$rating = getSingleReviewRating($_REQUEST['id'],$res_review['id']);
								//echo $res_review['id'];
								
								$sql_updated_review = mysql_query("SELECT * 
								FROM restaurant_reviews as rr,restaurant_rating as rrat 
								WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['id']."' AND rrat.restaurant_id='".$_REQUEST['id']."' AND rr.status=1 AND rr.review_status = 1 AND parent_id = '".$res_review['id']."' ORDER BY rr.id DESC");
								
								$sql_count_review_cust = mysql_num_rows(mysql_query("SELECT id FROM restaurant_reviews WHERE customer_id = '".$customerInfo['id']."'"));
								$sql_count_follower_cust = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE following_id = '".$customerInfo['id']."' AND status = '1'"));
								$sql_count_following_cust = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$customerInfo['id']."' AND status = '1'"));
								
								if($sql_count_review_cust > 1)
								{
									$review = "reviews";
								}
								else
								{
									$review = "review";
								}
								
								if($sql_count_follower_cust > 1)
								{
									$follower = "followers";
								}
								else
								{
									$follower = "follower";
								}
								
																	 
						?>
                      <div class="review_detail">
                      	
                        <div class="arrow_review"><img src="images/arrow_review.jpg" alt="" /></div>
                                	<div class="review_light">
                                    <ul>
                                        <li><?php /*?><a  class="various1" href="#inline<?php echo $customerInfo['id']; ?>" title="<?php echo $customerInfo['firstname']; ?>"><?php */?>
                                        <a href="user.php?id=<?php echo $customerInfo['id']; ?>" title="<?php echo $customerInfo['firstname']; ?>">
                                        <img src="thumb_images/<?php echo $cust_img; ?>" alt="" title="" />
                                        
                                        
                                        </a>
										<p><?php echo $customerInfo['firstname']." ".substr($customerInfo['lastname'],0,1)."." ?></p>
                                       <?php if($customerInfo['city'] != '') { ?> <p><?php echo $customerInfo['city'].", ".$customerInfo['state'] ?></p> <?php } ?>
                                       
                                       <?php if($sql_count_review_cust != 0) { ?><p><?php echo $sql_count_review_cust." ".$review; ?></p><?php } ?>
                                       
                                       <?php if($sql_count_follower_cust != 0) { ?><p><?php echo $sql_count_follower_cust." ".$follower; ?></p><?php } ?>
                                       
									   <?php if($sql_count_following_cust != 0) { ?><p><?php echo $sql_count_following_cust." following"; ?></p><?php } ?>
                                       
                                        </li>
                                    </ul>
                                    
                                    <div style="display: none;">
                                    <div id="inline<?php echo $customerInfo['id']; ?>" style="height:250px; min-height:450px; overflow:auto; width:615px;">
									<?php
									
									 $sql_user_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE customer_id = '".$customerInfo['id']."' ORDER BY id DESC");
									
									 ?>
                                    <h1 class="review_top_heading"><span>Total Reviews : <?php echo mysql_num_rows($sql_user_reviews); ?></span></h1>
                                    <?php
									while($array_user_reviews = mysql_fetch_array($sql_user_reviews)){
									?>
                                        <div class="review_top">
                                        <h1><span><a href="restaurant.php?id=<?php echo $array_user_reviews['restaurant_id']; ?>" style="color:#F07A01; text-decoration:none;"><?php echo $array_user_reviews['restaurant_name']; ?></a></span></h1>                                          
                                        <ul>
                                    	<?php
										$rating1 = getSingleReviewRating($array_user_reviews['restaurant_id'],$array_user_reviews['id']);
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
                                    <li><?php echo date("m-d-Y", strtotime($array_user_reviews['post_date']));?></li>    
                                	</ul>
                                          
                                          <p><?php echo $array_user_reviews['customer_review']; ?></p>
                                          </div>
                                          
                                       
                                    <?php } ?>
                                         
                                    </div>
                                    
                                	</div>
    
								</div>
                                
                                    <div class="review_txt">
                                   
                                   <?php 
								   //echo mysql_num_rows($sql_updated_review);
								   $iinc = 1;
								   while($row_updated_review = mysql_fetch_array($sql_updated_review))
								   { 
								   
									   $rating_updated = getSingleReviewRating($row_updated_review['restaurant_id'],$row_updated_review['id']);
									   
									   $sql_prev_check = mysql_num_rows(mysql_query("SELECT id FROM restaurant_reviews WHERE parent_id = '".$res_review['id']."'"));
									   
									   if($iinc == 2){
											  $prev_rev_stat = 'Previous Review';
									   }else{
										      $prev_rev_stat = '';
									   }
									   
									   ?>
                                       
                                       
                                       
                                       <div id="updated_reviews" class="separetor" style="margin-bottom:50px;">
                                       <div class="rating_content">
		                                    <ul>
		                                    	<?php
												$rem = 5 - $rating_updated;
												if($rating_updated > 0)
												{
													for($i=0; $i<$rating_updated;$i++){
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
		
		                                        <?php
												}
												if($rating_updated > 0)
												{
												?>
		                                        <li><?php echo change_dateformat_reverse($row_updated_review['post_date']); ?></li>
		                                        <?php
												}else{
												?>
		                                         <li>&nbsp;</li>
		                                        <?php
												}
												?>
												
												<?php
		                                        if($_SESSION['customer_id']==$row_updated_review['customer_id'])
		                                        {
		                                        ?>
		
												<li><a href="write_review.php?id=<?php echo $_REQUEST['id'];?>"><img src="images/pencil.png" style="margin: 0 5px 0; width:16px;" /> </a> </li>
		                                        <?php
												}
												?>
		                                	</ul>
		                                    
		                                </div>   
                                
                                    <?php 
									
									$sql_upd_rev = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_reviews WHERE parent_id = '".$res_review['id']."' ORDER BY id DESC"));
									
									if($row_updated_review['id'] == $sql_upd_rev['id'])
									{
										$upd_status = "Updated Review";
									}
									else
									{
										$upd_status = "";
									}
									 ?>	
                                   	  <h5 class="rv-date-tm">
<?php echo change_dateformat_reverse($row_updated_review['post_date']); ?>  By <span><?php echo $row_updated_review['customer_name']?></span>  </h5>
			
                                        <div class="rating_content_two review-likes">
		                                    <ul>
											<?php
											
											 if(isset($_SESSION['customer_id'])){ ?>
		
		                                    <li id="li_like_<?php echo $row_updated_review['id']; ?>">
											<?php if(is_customer_has_like_unlike_on_review($row_updated_review['id'], $_SESSION['customer_id'], 'like')){ ?>
		                                    
		                                    <span class="like_text" id="like_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'like'); ?></span><img src="images/like_select.png" width="16" height="16" />
		                                    <?php } else { ?>
		                                    <span class="like_text" id="like_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $res_review['id']; ?>" class="like" review="<?php echo $row_updated_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
											<?php } ?>
		                                    </li>
		                                    <li id="li_dislike_<?php echo $row_updated_review['id']; ?>">
		                                    <?php if(is_customer_has_like_unlike_on_review($row_updated_review['id'], $_SESSION['customer_id'], 'dislike')){ ?>
		                                    <img src="images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'dislike'); ?></span>
		                                    
		                                    <?php /*?><?php } else { ?>
		                                    <li id="li_like_<?php echo $res_review['id']; ?>">
		                                    <span class="like_text" id="like_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $res_review['id']; ?>" class="like" review="<?php echo $res_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
		                                    </li>
		                                    <li id="li_dislike_<?php echo $res_review['id']; ?>">
		                                    <a href="dislike" id="do_dislike_<?php echo $res_review['id']; ?>" class="dislike" review="<?php echo $res_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'dislike'); ?></span>
		                                    </li><?php */?>
		                                    
		                                    
		                                     <?php } else { ?>
		                                     <a href="dislike" id="do_dislike_<?php echo $row_updated_review['id']; ?>" class="dislike" review="<?php echo $row_updated_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'dislike'); ?></span>
											<?php } ?>
		                                    </li>
		                                    
		                                    <!--<li><a href="#"></a></li>-->
		                                    <?php } else { ?>
		                                    <!--<li><a href="#"></a></li>-->
		                                    <li id="li_like_<?php echo $row_updated_review['id']; ?>"><span class="like_text" id="like_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'like'); ?></span><a href="like" onClick="like_unlike_alert('Please Login First to Like this'); return false;"><img src="images/like_select.png" width="16" height="16" /></a></li>
		                                    <li id="li_dislike_<?php echo $row_updated_review['id']; ?>"><a href="dislike"  onClick="like_unlike_alert('Please Login First to Unlike this'); return false;"><img src="images/unlike_select.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'dislike'); ?></span></li>
		                                    <!--<li><a href="#"></a></li>-->
		                                    <?php } ?>
		                                </ul>
                                        
		                                	<span class="status-review"><!-- <a href=""> --> <?php if($upd_status != '') { ?><img src="../images/refesh-org.png" align="absmiddle"  width="14px" /> <?php } ?><!-- </a> --><?php echo $prev_rev_stat; ?> <?php echo $upd_status; ?> </span>
		                                </div>
                                      <div class="clear"></div>
                                      <?php
									  $sql_mul_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$row_updated_review['id']."'");
									  ?>
									    <p class="review-con"><?php echo $row_updated_review['customer_review']?></p>
									    
									  	<div class="rv-img">
									  		<ul>
									  			<?php 
												//echo mysql_num_rows($sql_mul_image);
												
												if(mysql_num_rows($sql_mul_image)!= 0) { 
										while($mul_image = mysql_fetch_array($sql_mul_image))
										{
											$uploaded_image = 'uploaded_images/'.$mul_image['image'];
										?><li><a class="example_cat" href="<?php echo $uploaded_image; ?>"><img src="uploaded_images/<?php echo $mul_image['image']; ?>" height="30"></a></li><?php } } ?>
									  		
									  		</ul>
									  	</div>
                                        
                                        <div class="viewers_comment">
                                    <ul>
                                    <li><a href="mailto:?body=<?php echo $row_updated_review['customer_review']?>&subject=<?php echo date("d-m-Y", strtotime($row_updated_review['post_date'])); ?>  By <?php echo $row_updated_review['customer_name']?>" target="_blank">Email</a></li>
                                    <li><?php if(isset($_SESSION['customer_id'])){?><a href="javascript:void(0);" onClick="fbpublishreview('<?=addslashes($row_updated_review['customer_name'])?>','<?=addslashes($row_updated_review['customer_review'])?>','<?=addslashes($cust_img)?>')">Share with facebook</a><?php }else{ ?><a href="login.php">Share with facebook</a><?php } ?></li>
                                    <?php if($row_updated_review['abuse_status']==0){?>
                                    <li><?php if(isset($_SESSION['customer_id'])){?><a href="report_abuse.php?id=<?php echo $_REQUEST['id'] ?>&r_id=<?php echo $row_updated_review['id']; ?>">Report Abuse</a><?php } else{?><a href="login.php">Report Abuse</a><?php } ?></li>
                                    </ul>
                                    </div>
                                     <div class="clear"></div>
                                   
                                    <div class="next-review">
                                       <?php $sql_owners_comment = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row_updated_review['id']."'"));
									   if(!empty($sql_owners_comment)){
									   $sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment['restaurant_owner_id']."'"));?>
                                       <p>Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row_updated_review['restaurant_id']);?></p>
                                       <p>Business Owner</p>
                                       <p><?php echo date("m-d-Y", strtotime($sql_owners_comment['post_date']));?>  -  <?php echo "Hi ".$row_updated_review['customer_name']; ?></p>
                                       <div><?php echo $sql_owners_comment['comment']; ?></div>
                                       <?php } ?>
                                       <div class="clear"></div>
                                      </div>  
                                     </div> 
                                   <?php
								   } 
								   $iinc++;
								   }?>
                                   
                                   
                                   
                                    
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
										
										<?php
                                        if($_SESSION['customer_id']==$res_review['customer_id'])
                                        {
                                        ?>

										<li><a href="write_review.php?id=<?php echo $_REQUEST['id'];?>"><img src="images/pencil.png" style="margin: 0 5px 0; width:16px;" /> </a> </li>
                                        <?php
										}
										?>
                                	</ul>
                                    
                                </div>   
                                
                               
                                    <?php $uploaded_image = 'uploaded_images/'.$res_review['review_picture'] ?>	
                                    
                                    <?php
									//echo "SELECT id FROM restaurant_reviews WHERE parent_id = '".$res_review['id']."'";
									
									//echo $sql_prev_check;
									
									if($rev_count == 2) 
									{ 
										$prev_status = "Previous Review"; 
									}
									else
									{
										$prev_status = '';
									}
									?>
                                   	  <h5 class="rv-date-tm">
										<?php echo change_dateformat_reverse($res_review['post_date']); ?>  By <span><?php echo $res_review['customer_name']?></span></h5>
                                        
                                         <div class="rating_content_two review-likes">
		                                    <ul>
												<?php
												
												 if(isset($_SESSION['customer_id'])){ ?>
			
			                                    <li id="li_like_<?php echo $res_review['id']; ?>">
												<?php if(is_customer_has_like_unlike_on_review($res_review['id'], $_SESSION['customer_id'], 'like')){ ?>
			                                    
			                                    <span class="like_text" id="like_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'like'); ?></span><img src="images/like_select.png" width="16" height="16" />
			                                    <?php } else { ?>
			                                    <span class="like_text" id="like_count_<?php echo $res_review['id']; ?>"><?php echo get_like_unlike_count_on_review($res_review['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $res_review['id']; ?>" class="like" review="<?php echo $res_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
												<?php } ?>
			                                    </li>
			                                    <li id="li_dislike_<?php echo $res_review['id']; ?>">
			                                    <?php if(is_customer_has_like_unlike_on_review($res_review['id'], $_SESSION['customer_id'], 'dislike')){ ?>
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
		                               	
		                               	<span class="status-review"> <?php echo $prev_status; ?> <!-- <a href=""> <img width="14px" align="absmiddle" src="../images/refesh-org.png"></a>--> </span>
		                                </div> 
                                        
                                       <div class="clear"></div> 
                                        
                                        <?php
									  $sql_mul_image1 = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$res_review['id']."'");
									  ?>
                                        <p class="review-con">     <?php echo $res_review['customer_review']?></p>
                                       
                                       
                                       	<div class="rv-img">
									  		<ul>
									  			<?php if(mysql_num_rows($sql_mul_image1) != 0) { 
										while($mul_image1 = mysql_fetch_array($sql_mul_image1))
										{
											$uploaded_image1 = 'uploaded_images/'.$mul_image1['image'];
										?>
                                        <li><a class="example_cat" href="<?php echo $uploaded_image1; ?>"><img src="uploaded_images/<?php echo $mul_image1['image']; ?>" height="30"></a></li><?php } } ?> 
									  		</ul>
									  	</div>
                                        
                                        <div class="viewers_comment">
                                    <ul>
                                    <li><a href="mailto:?body=<?php echo $res_review['customer_review']?>&subject=<?php echo date("d-m-Y", strtotime($res_review['post_date'])); ?>  By <?php echo $res_review['customer_name']?>" target="_blank">Email</a></li>
                                    <li><?php if(isset($_SESSION['customer_id'])){?><a href="javascript:void(0);" onClick="fbpublishreview('<?=addslashes($res_review['customer_name'])?>','<?=addslashes($res_review['customer_review'])?>','<?=addslashes($cust_img)?>')">Share with facebook</a><?php }else{ ?><a href="login.php">Share with facebook</a><?php } ?></li>
                                    <?php if($res_review['abuse_status']==0){?>
                                    <li><?php if(isset($_SESSION['customer_id'])){?><a href="report_abuse.php?id=<?php echo $_REQUEST['id'] ?>&r_id=<?php echo $res_review['id']; ?>">Report Abuse</a><?php } else{?><a href="login.php">Report Abuse</a><?php } ?></li>
                                    <?php
									}
									?>
                                </ul>
                                </div>
                                
                                
                                <?php $sql_owners_comment1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$res_review['id']."'"));
							   if(!empty($sql_owners_comment1)){
							   $sql_rest_owner1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment1['restaurant_owner_id']."'"));?>
							   <p>Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$res_review['restaurant_id']);?></p>
							   <p>Business Owner</p>
							   <p><?php echo date("m-d-Y", strtotime($sql_owners_comment1['post_date']));?>  -  <?php echo "Hi ".$res_review['customer_name']; ?></p>
							   <div><?php echo $sql_owners_comment1['comment']; ?></div>
							   <?php } ?>
                                
                                	
									
                                    
                                    </div>
                                    
                                    
                                </div>
                               <div class="clear"></div>
                               <?php
							   $counter++;
							}
						}else{?>
                         <div class="review_detail"><h2 style="background-color: #FFFFFF;color: #E46002;font: 24px 'Lobster Two';margin-left: 25px;
padding: 0 1px;">No reviews yet</h2></div>
                        <?php
						}
						?>
                           
                           
                           <div class="heading_txt2 heading_txt_nw">
                
                        <a href="write_review.php?id=<?php echo $_REQUEST['id'];?>">Write a Review</a>
                        
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
<script type="text/javascript">
function fbpublishreview(msg,address,pict) {
	var publish = {
		method: 'stream.publish',
		display: 'popup',
		name: 'FOOD AND MENU',
		picture: 'http://foodandmenu.com/thumb_images/'+pict,
		caption: '',
		description: (
			'<b>'+msg+'</b><center></center>'+address+'<center></center>'
		),
		href: 'http://foodandmenu.com/'
	};
	FB.ui(publish);
}
</script>
<script type="text/javascript">
function like_unlike_alert(msg){
	if(confirm(msg + '\n\tYou want to login?')){
		top.location.href = "login.php?rev=1";
	}
}
</script>

<script type="text/javascript" src="javascript/prototype.js"></script>
	<script type="text/javascript" src="javascript/effects.js"></script>
	<script type="text/javascript" src="javascript/accordion.js"></script>
	<script type="text/javascript" src="javascript/code_highlighter.js"></script>
	<script type="text/javascript" src="javascript/javascript.js"></script>
	<script type="text/javascript" src="javascript/html.js"></script>
 <script type="text/javascript">
		jQuery(document).ready(function() {
			

			jQuery(".various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery("#various2").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			jQuery("#various2").fancybox();

			jQuery("#various3").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			jQuery("#various4").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery("#various5").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery(".various6").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery("#various7").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
	</script>
    
<script type="text/javascript" src="js/jquery-ui.js"></script>
<?php /*?><script type="text/javascript">
jQuery(function() {
	jQuery( "input[name=post_date_test]" ).datepicker({
		dateFormat:"mm-dd-yy"
	});
	
	
});
</script><?php */?>
	
  <link rel="stylesheet" href="calender/jquery-ui.css" />  
	
<?php include("includes/footer.php");?>