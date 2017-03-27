<?php 
ob_start();
session_start();
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
       <?php
	   $total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$_REQUEST['id']."'"));
	   ?>             
                    	<div class="heading_txt2"><h2>Total Reviews : <?php echo $total_review?></h2>
                        
                        <a href="write_review.php?id=<?php echo $_REQUEST['id'];?>">Write a Review</a>
                        
                        <div class="clear"></div>
                        
                        </div>
                        <div class="clear"></div>
                        <?php
						$sql = "SELECT * 
								FROM restaurant_reviews as rr,restaurant_rating as rrat 
								WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['id']."'";
						if(isset($_REQUEST['order']) && $_REQUEST['order'] == 'most-recent'){
							$sql .= " ORDER BY rr.id DESC ";
						}
						if(isset($_REQUEST['order']) && $_REQUEST['order'] == 'most-rated'){
							$sql .= " ORDER BY rrat.rating_id ASC ";
						}
						//echo $sql;
						$sql_review = mysql_query($sql);
						$num_review=mysql_num_rows($sql_review);
						if($num_review>0)
						{
							
							while($res_review=mysql_fetch_array($sql_review))
							{
								$rating = getSingleReviewRating($_REQUEST['id'],$res_review['id']);
						?>
                      <div class="review_detail">
                      	
                        <div class="arrow_review"><img src="images/arrow_review.jpg" alt="" /></div>
                                	<div class="review_light">
                                    <ul>
                                        <li><a id="various1" href="#inline1" title="Lorem ipsum dolor sit amet">
                                        <img src="thumb_images/<?php echo $res_review['customer_picture'];?>" alt="" title="" /></a>
                                        </li>
                                    </ul>

	
    
</div>
                                    <div class="review_txt">
                                   
                                    
                                 <div class="rating_content">
                                    <ul>
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
                                	</ul>
                                    
                                </div>   
                                
                                <div class="rating_content_two">
                                    <ul>
                                    <li><a href="#"><img src="images/num_pic.png" width="16" height="16" /></a></li>
                                    <li><a href="#"><img src="images/like.png" width="16" height="16" /></a></li>
                                    <li><a href="#"><img src="images/unlike.png" width="16" height="16" /></a></li>
                                    <li><a href="#"><img src="images/num_pic2.png" width="16" height="16" /></a></li>
                                </ul>
                                </div>
                                    	
                                   	  <h5><?php echo $res_review['post_date']?>  By <span><?php echo $res_review['customer_name']?></span></h5>
                                        <p><?php echo $res_review['customer_review']?></p>
                                        <div class="viewers_comment">
                                    <ul>
                                    <li><a href="mailto:?body=<?php echo $res_review['customer_review']?>&subject=<?php echo $res_review['post_date']?>  By <?php echo $res_review['customer_name']?>" target="_blank">Email</a></li>
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

<?php include("includes/footer.php");?>