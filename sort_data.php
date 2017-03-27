<?php
session_start();
include ("admin/lib/conn.php");
//include ("includes/header_profile.php");
include ("includes/functions.php"); ?>

<script type="text/javascript">
var baseUrl = '<?php echo 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']); ?>';
</script>
<?php /*?><script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10/jquery-ui.min.js"></script><?php */?>
<script type="text/javascript" src="js/resturent.js"></script>


<?php /*?><script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.10/themes/smoothness/jquery-ui.css" type="text/css">

<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" /><?php */?>


<link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

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
 
<?php $sort_type = $_REQUEST['sort_type'];

$customer_id = $_REQUEST['user_id'];

$sql = "SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND rr.review_status = 0 AND rr.review_status = 0 order by id ".$sort_type." LIMIT 0,5";

$sql_res = mysql_query($sql);

$count = mysql_num_rows($sql_res);
$count11 = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND rr.review_status = 0 AND rr.review_status = 0 order by id ".$sort_type." "));

$cnt = 1;

$confirm = "'Are you sure to Report Abuse this Review?'";
while($row=mysql_fetch_array($sql_res)) 
{
	$sql_main_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$row['id']."'");
	
	$msg_id = $row['id'];
	$sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
	$num_rws = mysql_num_rows($sql_photo);
	
	$sql_updated_review = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND parent_id = '".$row['id']."' AND rr.review_status = 1 ORDER BY rr.id DESC");
	
	
	$html_data.='<div class="restu-block">
		
		<div class="restu-block-left">';
		 
		$restaurant_image = getNameTable("restaurant_basic_info","restaurant_image","id",$row['restaurant_id']) ;
		if($num_rws > 0)
		{
			
			$html_data.='<a href="javascript:void(0);" onClick="open_slider_div('.$row['id'].');"><img src="uploaded_images/'.$restaurant_image.'" align="" width="169" /></a>';
			
		}
		else
		{
			$html_data.='<img src="uploaded_images/'.$restaurant_image.'" align="" width="169" />';
		}
		
		$html_data.='</div>
		<div class="restu-block-right">
		<div class="restu-name-sec">
		<h1 class="res_name"><a href="restaurant.php?id='.$row['restaurant_id'].'">'.stripslashes(getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id'])).'</a></h1>
					<div class="clear"> </div>
					<a href="javascript:void(0);" class="small-cat">Categories : '.getNameTable("restaurant_basic_info","restaurant_category_name","id",$row['restaurant_id']).'</a>
					</div>
					<div class="location-sec res_add">
					<img src="images/address_pic.png" alt="" />
						<a href="restaurant.php?id='.$row['restaurant_id'].'">'.getNameTable("restaurant_basic_info","restaurant_address","id",$row['restaurant_id']).', '.getNameTable("restaurant_basic_info","restaurant_city","id",$row['restaurant_id']).', '.getNameTable("restaurant_basic_info","restaurant_state","id",$row['restaurant_id']).', '.getNameTable("restaurant_basic_info","restaurant_zipcode","id",$row['restaurant_id']).'</a>		
				</div>
				</div>
		<div class="restu-block-right">';		
		while($row_updated_review = mysql_fetch_array($sql_updated_review))
		{
						
					$sql_mul_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$row_updated_review['id']."'");
					
                    
					$html_data.='<div class="next-row">
					<div class="rating_content">
							<ul>';
								
								$rating1 = getSingleReviewRating($row_updated_review['restaurant_id'],$row_updated_review['id']);
								//echo $rating1;
								$rem = 5 - $rating1;
								if($rating1 > 0)
								{
									for($i=0; $i<$rating1;$i++){
								
								$html_data.='<li><img width="16" height="16" src="images/star-1.png"></li>';
									}
									for($j=0;$j<$rem;$j++){
								$html_data.='<li><img width="16" height="15" src="images/star-3.png"></li>';
									}
								}
								else{
								?>
								<?php
								}
							$html_data.='</ul>
							
						</div>
					<div class="post_date">
							<div style="color: #777; font-size: 14px; float:right;">Posted on '.date("m-d-Y", strtotime($row_updated_review['post_date'])).'</div>
					</div>
					<div class="clear"> </div>';
                                                    
                    if(mysql_num_rows($sql_mul_image)!= 0) {
					
		$html_data.='<div class="rv-img">
					<ul>';
		while($mul_image = mysql_fetch_array($sql_mul_image))
					{
					$uploaded_image = 'uploaded_images/'.$mul_image['image'];
		$html_data.='<li><a class="example_cat" href="'.$uploaded_image.'"><img src="uploaded_images/'.$mul_image['image'].'" height="30"></a></li>'; }
		$html_data.='</ul>
					</div>';
					 }
		$html_data.='<p>
						'.$row_updated_review['customer_review'].'
					</p>
					<div class="clear"> </div>
					
					<div class="like-sec">						
						<div class="soc_icon">
							
							<script type="text/javascript">
							  (function() {
								var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
								po.src = "https://apis.google.com/js/platform.js";
								var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
							  })();
							</script>
							
							<div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id='.$_REQUEST['id'].'&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
						</div>
					</div>';
					
					$html_data.='<div class="clear"></div><div class="user-social-sec-bot">';
					
					
					$html_data.='<div class="rating_content_two review-likes">
						  <ul>';
							 if(isset($_SESSION['customer_id'])){
			$html_data.='<li id="li_like_'.$row_updated_review['id'].'">';
							 if(is_customer_has_like_unlike_on_review($row_updated_review['id'], $_SESSION['customer_id'], 'like')){ 
			$html_data.='<span class="like_text" id="like_count_'.$row_updated_review['id'].'">'. get_like_unlike_count_on_review($row_updated_review['id'], 'like').'</span><img src="images/like_select.png" width="16" height="16" />';
							 } else { 
			$html_data.='<span class="like_text" id="like_count_'.$row_updated_review['id'].'">'.get_like_unlike_count_on_review($row_updated_review['id'], 'like').'</span><a href="like" id="do_like_'.$row_updated_review['id'].'" class="like" review="'.$row_updated_review['id'].'" cid="'.$_SESSION['customer_id'].'"><img src="images/like.png" width="16" height="16" /></a>';
							}
			$html_data.='</li>
							<li id="li_dislike_'.$row_updated_review['id'].'">';
							if(is_customer_has_like_unlike_on_review($row_updated_review['id'], $_SESSION['customer_id'], 'dislike')){
			$html_data.='<img src="images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_'.$row_updated_review['id'].'">'.get_like_unlike_count_on_review($row_updated_review['id'], 'dislike').'</span>';
			 } else {
				 
			$html_data.='<a href="dislike" id="do_dislike_'.$row_updated_review['id'].'" class="dislike" review="'. $row_updated_review['id'].'" cid="'.$_SESSION['customer_id'].'"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_'.$row_updated_review['id'].'">'.get_like_unlike_count_on_review($row_updated_review['id'], 'dislike').'</span>';
			 } 
			$html_data.='</li>';
			 } else {
			$html_data.='<li id="li_like_'.$row_updated_review['id'].'"><span class="like_text" id="like_count_'.$row_updated_review['id'].'">'.get_like_unlike_count_on_review($row_updated_review['id'], 'like').'</span><a href="like" onClick="like_unlike_alert("Please Login First to Like this"); return false;"><img src="images/like_select.png" width="16" height="16" /></a></li>
							<li id="li_dislike_'.$row_updated_review['id'].'"><a href="dislike"  onClick="like_unlike_alert("Please Login First to Unlike this"); return false;"><img src="images/unlike_select.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_'.$row_updated_review['id'].'">'. get_like_unlike_count_on_review($row_updated_review['id'], 'dislike').'</span></li>';
						 } 
			$html_data.='</ul></div>';
					
					
					
					$html_data.='<div class="report-ab srt">  
								<a href="mailto:?body='.$row['customer_review'].'&subject='.date("d-m-Y", strtotime($row_updated_review['post_date'])).'  By '.$row_updated_review['customer_name'].'" target="_blank">Email</a>';
					$cust_img = getNameTable("restaurant_basic_info","restaurant_image","id",$row_updated_review['restaurant_id']);
					if(isset($_SESSION['customer_id'])){
					$html_data.='<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id='.$row_updated_review['restaurant_id'].'">Share with facebook</a>';
					 }else{
					$html_data.='<a href="login.php">Share with facebook</a>';
					 } 
					 $html_data.='</div>';
					 if($row_updated_review['abuse_status']==0){
						 
				$html_data.='<div class="report-ab srt">
					<img src="images/report-flag.png" align="absmiddle">';
					 if(isset($_SESSION['customer_id'])){
				
					$html_data.='<a href="report_abuse.php?id='.$row_updated_review['restaurant_id'].'&r_id='.$row_updated_review['id'].'" style="color:#000000;" onClick="return confirm('.$confirm.');">Report Abuse</a>';
					 }else{
					$html_data.='<a href="login.php" style="color:#000000;">Report Abuse</a>';
					 } 
				$html_data.='</div>';
				 } 
				
				
				
				$html_data.='</div><div class="clear"></div>'; 
				
				$sql_owners_comment = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row_updated_review['id']."'"));
				if(!empty($sql_owners_comment)){
			   $sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment['restaurant_owner_id']."'"));
			   $rest_owner = getNameTable("restaurant_basic_info","restaurant_name","id",$row_updated_review['restaurant_id']);
			   $html_data.='
			   <div class="next-review">
	   		   <div class="next-review-head">
			   <p><strong>Comment From '.$rest_owner.'</strong></p>
			   </div>
			   <label>'.date("m-d-Y", strtotime($sql_owners_comment['post_date'])).'  -  "Hi "'.$row_updated_review['customer_name'].'</label>
			   <div class="next-review-cont">'.$sql_owners_comment['comment'].'</div>
			   <div class="clear"></div>
	   			</div>';
			    } 
				
		 $html_data.='</div>
	<div class="clear"></div>';
				
				
									   
					}
					
			$html_data.='<div class="restu-block-top">
				<div class="restu-name-sec">
					
					<div class="rating_content">
						<ul>';
							
							$rating1 = getSingleReviewRating($row['restaurant_id'],$row['id']);
							//echo $rating1;
							$rem = 5 - $rating1;
							if($rating1 > 0)
							{
								for($i=0; $i<$rating1;$i++){
							
							$html_data.='<li><img width="16" height="16" src="images/star-1.png"></li>';
							
								}
								for($j=0;$j<$rem;$j++){
							
							$html_data.='<li><img width="16" height="15" src="images/star-3.png"></li>';
							
								}
							}
							else{
							?>
							<?php
							}
							
						$html_data.='</ul>
						
					</div> 
					
				</div>
				
				
				<div class="post_date">
				Posted on '.date("m-d-Y", strtotime($row['post_date'])).'
				</div>
			</div>
			<div class="clear"> </div>
			<div class="restu-block-botm">
				<p>
					'.$row['customer_review'].'
				</p>';
			 if(mysql_num_rows($sql_main_image)!= 0) { 
			 $html_data.='<div class="rv-img">
					<ul>';
			  while($mul_image1 = mysql_fetch_array($sql_main_image))
				{
				$uploaded_image1 = 'uploaded_images/'.$mul_image1['image'];
			$html_data.='<li><a class="example_cat" href="'.$uploaded_image1.'"><img src="uploaded_images/'.$mul_image1['image'].'" height="30"></a></li>'; }
				$html_data.='</ul>
				</div>';
				 }
			 $html_data.='<div class="clear"></div>
				<div class="like-sec">
					<div class="soc_icon">
						
						<script type="text/javascript">
						  (function() {
							var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
							po.src = "https://apis.google.com/js/platform.js";
							var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
						  })();
						</script>
						
						<div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id='.$_REQUEST['id'].'&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
					</div>
				</div>
			</div> ';
			
			$html_data.='<div class="clear"></div><div class="user-social-sec-bot">';
			$html_data.='<div class="rating_content_two review-likes">
								<ul>';
								 if(isset($_SESSION['customer_id'])){
					$html_data.='<li id="li_like_'.$row['id'].'">';
								if(is_customer_has_like_unlike_on_review($row['id'], $_SESSION['customer_id'], 'like')){
					$html_data.='<span class="like_text" id="like_count_'.$row['id'].'">'.get_like_unlike_count_on_review($row['id'], 'like').'</span><img src="images/like_select.png" width="16" height="16" />';
								 } else {
					$html_data.='<span class="like_text" id="like_count_'.$row['id'].'">'.get_like_unlike_count_on_review($row['id'], 'like').'</span><a href="like" id="do_like_'.$row['id'].'" class="like" review="'.$row['id'].'" cid="'.$_SESSION['customer_id'].'"><img src="images/like.png" width="16" height="16" /></a>';
								 }
					$html_data.='</li>
								<li id="li_dislike_'.$row['id'].'">';
								if(is_customer_has_like_unlike_on_review($row['id'], $_SESSION['customer_id'], 'dislike')){ 
					$html_data.='<img src="images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_'.$row['id'].'">'.get_like_unlike_count_on_review($row['id'], 'dislike').'</span>';
								  } else { 
					$html_data.='<a href="dislike" id="do_dislike_'.$row['id'].'" class="dislike" review="'.$row['id'].'" cid="'.$_SESSION['customer_id'].'"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_'.$row['id'].'">'.get_like_unlike_count_on_review($row['id'], 'dislike').'</span>';
								}
					$html_data.='</li>';
					 } else {
						 
					$html_data.='<li id="li_like_'.$row['id'].'"><span class="like_text" id="like_count_'.$row['id'].'">'.get_like_unlike_count_on_review($row['id'], 'like').'</span><a href="like" onClick="like_unlike_alert("Please Login First to Like this"); return false;"><img src="images/like_select.png" width="16" height="16" /></a></li>
								<li id="li_dislike_'.$row['id'].'"><a href="dislike"  onClick="like_unlike_alert("Please Login First to Unlike this"); return false;"><img src="images/unlike_select.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_'.$row['id'].'">'.get_like_unlike_count_on_review($row['id'], 'dislike').'</span></li>';
							}
					$html_data.='</ul>
							</div>';
			
			
			$html_data.='<div class="report-ab srt">  
						<a href="mailto:?body='.$row['customer_review'].'&subject='.date("d-m-Y", strtotime($row['post_date'])).'  By '.$row['customer_name'].'" target="_blank">Email</a>';
			$cust_img = getNameTable("restaurant_basic_info","restaurant_image","id",$row['restaurant_id']);
			if(isset($_SESSION['customer_id'])){
			$html_data.='<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id='.$row['restaurant_id'].'">Share with facebook</a>';
			 }else{
			$html_data.='<a href="login.php">Share with facebook</a>';
			 } 
			 $html_data.='</div>';
			 
			 if($row['abuse_status']==0){
			
			$html_data.='<div class="report-ab srt">
				<img src="images/report-flag.png" align="absmiddle">';
				 if(isset($_SESSION['customer_id'])){
				
				$html_data.='<a href="report_abuse.php?id='.$row['restaurant_id'].'&r_id='.$row['id'].'" style="color:#000000;"  onClick="return confirm('.$confirm.');">Report Abuse</a>';
				 }else{ 
				$html_data.='<a href="login.php" style="color:#000000;">Report Abuse</a>';
				
				 } 
			$html_data.='</div>';
			 }
		$html_data.='</div><div class="clear"> </div>';
		
		$sql_owners_comment1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row['id']."'"));
		if(!empty($sql_owners_comment1)){
	   $sql_rest_owner1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment1['restaurant_owner_id']."'"));
	   $rest_owner1 = getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']);
	   $html_data.='
	   <div class="next-review">
	   <div class="next-review-head">
	   <p><strong>Comment From '.$rest_owner1.'</strong></p>
	   </div>
	   <label>'.date("m-d-Y", strtotime($sql_owners_comment1['post_date'])).'  -  "Hi "'.$row['customer_name'].'</label>
	   <div class="next-review-cont">'.$sql_owners_comment1['comment'].'</div>
	   <div class="clear"></div>
	   </div>';
	   }
                                       
	$html_data.='</div>
	<div class="clear"></div></div>';
	
	
$cnt++; 
}

if($count11>5){
$html_data.='<div class="morebox" id="more'.$msg_id.'">
			<a class="more" id="'.$msg_id.'" href="javascript:void(0);" onClick="slider_load();">Load More Reviews</a>
			</div>';
}

echo $html_data;
?>