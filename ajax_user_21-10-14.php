<?php
include ("admin/lib/conn.php");
include ("includes/functions.php");

$customer_id = $_REQUEST['cust_id'];
$new_count = $_REQUEST['new_count'];
$sort_type = $_REQUEST['sort_type'];

if(isSet($_POST['lastmsg']))
{
$lastmsg=$_POST['lastmsg'];
$sql = ("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 ");
if($sort_type == 'DESC'){
	$sql.=" AND rr.id<'$lastmsg' order by id DESC limit 5";
}else{
	$sql.=" AND rr.id>'$lastmsg' order by id ASC limit 5";
}
$result = mysql_query($sql);


$count=mysql_num_rows($result);
$sql1 = ("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 ");
if($sort_type == 'DESC'){
	$sql1.=" AND rr.id<'$lastmsg' order by id DESC limit 6";
}else{
	$sql1.=" AND rr.id>'$lastmsg' order by id ASC limit 6";
}
$result1 = mysql_query($sql1);
$count1=mysql_num_rows($result1);
$cnt = $new_count - 4;
while($row=mysql_fetch_array($result))
{
	$sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
	$num_rws = mysql_num_rows($sql_photo);
	
	if($count1 == 6){
		$msg_id = $row['id'];
	}else{
		$msg_id = '';
	}


?>
<div class="restu-block">
										
<div class="restu-block-left">
<?php 
$restaurant_image = getNameTable("restaurant_basic_info","restaurant_image","id",$row['restaurant_id']) 
?>
<?php if($num_rws >1){ ?>
    <a href="javascript:void(0);" onClick="open_slider_div('<?php echo $row['id'] ?>');"><img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" /></a>
    <?php }else{ ?>
    <img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" />
    <?php } ?>
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
                <a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>"> <img src="images/facebook_share.jpg"></a>
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
        
        	<?php if($row['abuse_status']==0){ ?>
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
            
        <div class="clear"> </div>
    </div> 
    
    <div class="clear"> </div>
</div>

<div class="clear"> </div>
</div> 

<?php /*?><div id="slider_div<?php echo $row['id'] ?>" class="factor_details white_content nw_white_cont" style="visibility:hidden;">
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
                    
                    <div id="carousel<?php echo $cnt; ?>" class="flexslider">
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
</div><?php */?>




<?php
$cnt++;
}
?>
<div id="fade1" class="black_overlay"> </div>
<div class="morebox" id="more<?php echo $msg_id;?>">
<a href="#" id="<?php echo $msg_id; ?>" class="more" onclick="slider_load();">Load More Reviews</a>
</div>
<?php

}
?>