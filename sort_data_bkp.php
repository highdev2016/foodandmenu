<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");

$sort_type = $_REQUEST['sort_type'];

$sql = "SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND rr.review_status = 0 AND rr.review_status = 0 order by id ".$sort_type." LIMIT 0,5";

$sql_res = mysql_query($sql);

$cnt = 1;
while($row=mysql_fetch_array($sql_res)) 
{
	$msg_id = $row['id'];
	$sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
	$num_rws = mysql_num_rows($sql_photo);
	
	$sql_updated_review = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND parent_id = '".$row['id']."' AND rr.review_status = 1 ORDER BY rr.id ".$sort_type."");
	
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
		<div class="restu-name-sec">
		<h1 class="res_name"><a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo stripslashes(getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']));?></a></h1>
					<div class="clear"> </div>
					<a href="javascript:void(0);" class="small-cat">Categories : <?php echo getNameTable("restaurant_basic_info","restaurant_category_name","id",$row['restaurant_id']);?></a>
					
					</div>
					
					<div class="location-sec res_add">
					<img src="images/address_pic.png" alt="" />
						<a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo getNameTable("restaurant_basic_info","restaurant_address","id",$row['restaurant_id']);?></a>
						
				</div>
					
					
					
		<div class="restu-block-right">
		
		
					
		<?php while($row_updated_review = mysql_fetch_array($sql_updated_review))
					{
					?>
					
						
						
					
					<div class="post_date">
					   
							<div style="color: #777; font-size: 14px; float:right; margin-top:26px;">Posted on <?php echo date("m-d-Y", strtotime($row_updated_review['post_date'])); ?></div>
					</div>
					
					<div>
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
				
				</div>   
						
					
					
					<?php
					}
					?>
			<div class="restu-block-top">
				<div class="restu-name-sec">
					
					
					
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
}

echo "Test";
?>