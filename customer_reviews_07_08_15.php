<?php
session_start();
if (array_key_exists('btn_search', $_GET)) {
unset($_GET['btn_search']);
foreach($_GET as $key => $val)
{
	$qry_string .=$key.'='.$val.'&'; 
}
$qry_string = substr($qry_string,0,-1);
header("location:search.php?".$qry_string);
}

include ("includes/header_profile.php");
include ("includes/functions.php");
include ("admin/lib/conn.php"); ?>

<body onLoad="init();">
<div id="top_div"></div>

<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php");?>

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


<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="main_body_cont">

<?php //include("includes/banner_section.php");?>

<div class="content_container">

<?php /*?><?php include("includes/left_section.php");?><?php */?>

<div class="body_cont_right">


<div class="clear"></div>

<div class="right_dish_content">

<div id="inline<?php echo $_SESSION['customer_id']; ?>" style="width:723px;height:auto; min-height:250px;">
<?php //$sql_user_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE customer_id = '".$_SESSION['customer_id']."'");

$customer_id = $_SESSION['customer_id'];

$sql_res = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND rr.review_status = 0 order by id DESC"); ?>
<h1 class="review_top_heading"><span>Total Reviews : <?php echo mysql_num_rows($sql_res); ?></span></h1>
<a href="javascript:history.back();"><input type="button" name="back" value="Back" class="check_order_button" style="float:right; margin-top:-33px;" /></a>
<?php
while($row = mysql_fetch_array($sql_res)){

$sql_main_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$row['id']."'");
							
$msg_id = $row['id'];
$sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
$num_rws = mysql_num_rows($sql_photo);

$sql_updated_review = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND parent_id = '".$row['id']."' AND rr.review_status = 1 ORDER BY rr.id DESC");
									
?>

<?php /*?><div class="review_top" style="width:711px;">
<h1><span><?php echo $array_user_reviews['restaurant_name']; ?></span></h1>                                          
<ul>
<?php
$rating = getSingleReviewRating($array_user_reviews['restaurant_id'],$array_user_reviews['id']);
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
<?php
}
?>
<li><?php echo date("m-d-Y", strtotime($array_user_reviews['post_date']));?></li>    
</ul>

<?php
if(mysql_num_rows($sql_mul_image)!= 0) {
?>
<div class="rv-img">
    <ul>
    <?php   while($mul_image = mysql_fetch_array($sql_mul_image))
    {
    $uploaded_image = 'uploaded_images/'.$mul_image['image'];
    ?><li><a class="example_cat" href="<?php echo $uploaded_image; ?>"><img src="uploaded_images/<?php echo $mul_image['image']; ?>" height="30"></a></li>
	<?php } ?>
    </ul>
</div>
<?php } ?>
                                                    
<p><?php echo $array_user_reviews['customer_review']; ?></p>
</div><?php */?>

<div class="restu-block">
										
<div class="restu-block-left">
<?php 
$restaurant_image = getNameTable("restaurant_basic_info","restaurant_image","id",$row['restaurant_id']) ;
if($num_rws > 0)
{
?>
    <a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" /></a>
<?php
}
else
{
?>
    <a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" /></a>
<?php
}
?>
</div>
<div class="restu-block-right">
    <div class="restu-name-sec">
        <h1 class="res_name"><a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo stripslashes(getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']));?></a></h1>
        <div class="clear"> </div>
        <a href="javascript:void(0);" class="small-cat">Categories : <?php echo getNameTable("restaurant_basic_info","restaurant_category_name","id",$row['restaurant_id']);?></a>
    </div>
                
    <div class="location-sec res_add">
        <img src="images/address_pic.png" alt="" />
        <a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo getNameTable("restaurant_basic_info","restaurant_address","id",$row['restaurant_id']).", ".getNameTable("restaurant_basic_info","restaurant_city","id",$row['restaurant_id']).", ".getNameTable("restaurant_basic_info","restaurant_state","id",$row['restaurant_id'])." ".getNameTable("restaurant_basic_info","restaurant_zipcode","id",$row['restaurant_id']);?></a>
    </div>
</div>      
                                        
<div class="restu-block-right">
        
<?php while($row_updated_review = mysql_fetch_array($sql_updated_review))
            {
                //echo ("SELECT image FROM restaurant_review_images WHERE review_id = '".$row_updated_review['id']."'");
                $sql_mul_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$row_updated_review['id']."'");
                ?>
            
            <div class="next-row">
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
                    
                     <div class="post_date">
                           <div style="color: #777; font-size: 14px; float:right;">Posted on <?php echo date("m-d-Y", strtotime($row_updated_review['post_date'])); ?></div>
                     </div>
            
            <div class="clear"> </div>
            
            
            <?php 
            //echo mysql_num_rows($sql_mul_image);
            
            if(mysql_num_rows($sql_mul_image)!= 0) {
            ?>
                 <div class="rv-img">
                 <ul>
          <?php   while($mul_image = mysql_fetch_array($sql_mul_image))
            {
                $uploaded_image = 'uploaded_images/'.$mul_image['image'];
            ?><li><a class="example_cat" href="<?php echo $uploaded_image; ?>"><img src="uploaded_images/<?php echo $mul_image['image']; ?>" height="30"></a></li><?php } ?>
                
                </ul>
            </div>
            <?php } ?>
            <p>
                <?php echo $row_updated_review['customer_review'];?>
            </p>
            <div class="clear"> </div>
            
            <div class="like-sec">
                <?php /*?><div class="soc_icon">
                    <a target="_blank" href="https://www.facebook.com/share.php?u=https://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>"> <img src="images/facebook_share.jpg"></a>
                </div><?php */?>
                
                <div class="soc_icon">
                    <?php /*?><a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a><?php */?> 
                    <?php /*?><script type="text/javascript">
                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/platform.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script><?php */?>
                    
                    <?php /*?><div class="soc_icon"><iframe src="https://www.facebook.com/plugins/like.php?href=https://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div><?php */?>
                </div>
                
            </div>
            
            
            
           <div class="clear"></div>   
            
            
 <div class="user-social-sec-bot">       
  <div class="rating_content_two review-likes">
  <ul>
    <?php
    
     if(isset($_SESSION['customer_id'])){ ?>

    <li id="li_like_<?php echo $row_updated_review['id']; ?>">
    <?php if(is_customer_has_like_unlike_on_review($row_updated_review['id'], $_SESSION['customer_id'], 'like')){ ?>
    
    <span class="like_text" id="like_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'like'); ?></span><img src="images/like_select.png" width="16" height="16" />
    <?php } else { ?>
    <span class="like_text" id="like_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $row_updated_review['id']; ?>" class="like" review="<?php echo $row_updated_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
    <?php } ?>
    </li>
    <li id="li_dislike_<?php echo $row_updated_review['id']; ?>">
    <?php if(is_customer_has_like_unlike_on_review($row_updated_review['id'], $_SESSION['customer_id'], 'dislike')){ ?>
    <img src="images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'dislike'); ?></span>
    
    <?php /*?><?php } else { ?>
    <li id="li_like_<?php echo $row['id']; ?>">
    <span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $row['id']; ?>" class="like" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
    </li>
    <li id="li_dislike_<?php echo $row['id']; ?>">
    <a href="dislike" id="do_dislike_<?php echo $row['id']; ?>" class="dislike" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span>
    </li><?php */?>
    
    
     <?php } else { ?>
     <a href="dislike" id="do_dislike_<?php echo $row_updated_review['id']; ?>" class="dislike" review="<?php echo $row_updated_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'dislike'); ?></span>
    <?php } ?>
    </li>
    
    <!--<li><a href="#"></a></li>-->
    <?php } else { ?>
    <!--<li><a href="#"></a></li>-->
    <li id="li_like_<?php echo $row_updated_review['id']; ?>"><span class="like_text" id="like_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'like'); ?></span><a href="like" onClick="like_unlike_alert('Please Login First to Like this'); return false;"><img src="images/like_select.png" width="16" height="16" /></a></li>
    <li id="li_dislike_<?php echo $row_updated_review['id']; ?>"><a href="dislike"  onClick="like_unlike_alert('Please Login First to Unlike this'); return false;"><img src="images/unlike_select.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'dislike'); ?></span></li>
    <!--<li><a href="#"></a></li>-->
    <?php } ?>
</ul>
          </div>
          <div class="report-ab">  
        <a href="mailto:?body=<?php echo $row_updated_review['customer_review']?>&subject=<?php echo date("d-m-Y", strtotime($row_updated_review['post_date'])); ?>  By <?php echo $row_updated_review['customer_name']?>" target="_blank">Email</a>
        <?php $cust_img = getNameTable("restaurant_basic_info","restaurant_image","id",$row_updated_review['restaurant_id']);?>
        <?php if(isset($_SESSION['customer_id'])){?><a target="_blank" href="https://www.facebook.com/share.php?u=https://foodandmenu.com/restaurant.php?id=<?php echo $row_updated_review['restaurant_id']; ?>">Share with facebook</a><?php }else{ ?><a href="login.php">Share with facebook</a><?php } ?>
        </div>
        
        <?php if($row_updated_review['abuse_status']==0){ ?>
        <div class="report-ab">
        

            <img src="images/report-flag.png" align="absmiddle">
            <?php if(isset($_SESSION['customer_id'])){
            ?>
            <a href="report_abuse.php?id=<?php echo $row_updated_review['restaurant_id']; ?>&r_id=<?php echo $row_updated_review['id']; ?>" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
            <?php }else{ ?>
            <a href="login.php" style="color:#000000;">Report Abuse</a>
            <?php } ?>
        </div>
        <?php } ?>  

</div>  
       
<div class="clear"></div>


<?php $sql_owners_comment = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row_updated_review['id']."'"));
if(!empty($sql_owners_comment)){
$sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment['restaurant_owner_id']."'"));?>
<div class="next-review">
   <div class="next-review-head">
       <p><strong> Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row_updated_review['restaurant_id']);?></strong></p>
   </div>
   <label><?php echo date("m-d-Y", strtotime($sql_owners_comment['post_date']));?>  -  <?php echo "Hi ".$row_updated_review['customer_name']; ?></label>
   <div class="next-review-cont"><?php echo $sql_owners_comment['comment']; ?></div>
   <div class="clear"></div>
</div>
<div class="clear"></div>
<!-- </div>  -->
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
        
        <?php 
                    //echo mysql_num_rows($sql_mul_image);
                    
                    if(mysql_num_rows($sql_main_image)!= 0) {?>
                         <div class="rv-img">
                <ul>
          <?php   while($mul_image1 = mysql_fetch_array($sql_main_image))
            {
                $uploaded_image1 = 'uploaded_images/'.$mul_image1['image'];
            ?><li><a class="example_cat" href="<?php echo $uploaded_image1; ?>"><img src="uploaded_images/<?php echo $mul_image1['image']; ?>" height="30"></a></li><?php } ?>
                
                </ul>
            </div>
            <?php } ?>
        
        <div class="like-sec">
            <?php /*?><div class="soc_icon">
                <a target="_blank" href="https://www.facebook.com/share.php?u=https://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>"> <img src="images/facebook_share.jpg"></a>
            </div><?php */?>
            
            <div class="soc_icon">
                <?php /*?><a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a><?php */?> 
                <?php /*?><script type="text/javascript">
                  (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    po.src = 'https://apis.google.com/js/platform.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                  })();
                </script><?php */?>
                
                <?php /*?><div class="soc_icon"><iframe src="https://www.facebook.com/plugins/like.php?href=https://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div><?php */?>
            </div>
            
        </div>
        
        
    </div> 
    <div class="clear"> </div>
    <div class="user-social-sec-bot">
    
  <div class="rating_content_two review-likes">
  <ul>
        <?php
        
         if(isset($_SESSION['customer_id'])){ ?>

        <li id="li_like_<?php echo $row['id']; ?>">
        <?php if(is_customer_has_like_unlike_on_review($row['id'], $_SESSION['customer_id'], 'like')){ ?>
        
        <span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><img src="images/like_select.png" width="16" height="16" />
        <?php } else { ?>
        <span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $row['id']; ?>" class="like" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
        <?php } ?>
        </li>
        <li id="li_dislike_<?php echo $row['id']; ?>">
        <?php if(is_customer_has_like_unlike_on_review($row['id'], $_SESSION['customer_id'], 'dislike')){ ?>
        <img src="images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span>
        
        <?php /*?><?php } else { ?>
        <li id="li_like_<?php echo $row['id']; ?>">
        <span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $row['id']; ?>" class="like" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
        </li>
        <li id="li_dislike_<?php echo $row['id']; ?>">
        <a href="dislike" id="do_dislike_<?php echo $row['id']; ?>" class="dislike" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span>
        </li><?php */?>
         <?php } else { ?>
         <a href="dislike" id="do_dislike_<?php echo $row['id']; ?>" class="dislike" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span>
        <?php } ?>
        </li>
        
        <!--<li><a href="#"></a></li>-->
        <?php } else { ?>
        <!--<li><a href="#"></a></li>-->
        <li id="li_like_<?php echo $row['id']; ?>"><span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><a href="like" onClick="like_unlike_alert('Please Login First to Like this'); return false;"><img src="images/like_select.png" width="16" height="16" /></a></li>
        <li id="li_dislike_<?php echo $row['id']; ?>"><a href="dislike"  onClick="like_unlike_alert('Please Login First to Unlike this'); return false;"><img src="images/unlike_select.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span></li>
        <!--<li><a href="#"></a></li>-->
        <?php } ?>
    </ul>
  </div>
    
    <div class="report-ab">
    <a href="mailto:?body=<?php echo $row['customer_review']?>&subject=<?php echo date("d-m-Y", strtotime($row['post_date'])); ?>  By <?php echo $row['customer_name']?>" target="_blank">Email</a>
    
    <?php $cust_img = getNameTable("restaurant_customer","image","id",$_SESSION['customer_id']);?>
     
    <?php if(isset($_SESSION['customer_id'])){?><a target="_blank" href="https://www.facebook.com/share.php?u=https://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>">Share with facebook</a><?php }else{ ?><a href="login.php">Share with facebook</a><?php } ?>
    </div>
    
    <?php if($row['abuse_status']==0){ ?>
    <div class="report-ab">  
        <img src="images/report-flag.png" align="absmiddle">
        <?php if(isset($_SESSION['customer_id'])){
        ?>
        <a href="report_abuse.php?id=<?php echo $row['restaurant_id']; ?>&r_id=<?php echo $row['id']; ?>" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
        <?php }else{ ?>
        <a href="login.php" style="color:#000000;">Report Abuse</a> 
        <?php } ?>
        <div class="clear"> </div>
    </div>
    <?php } ?>

</div>

<div class="clear"> </div>

<?php $sql_owners_comment1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row['id']."'"));
if(!empty($sql_owners_comment1)){
$sql_rest_owner1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment1['restaurant_owner_id']."'"));?>
<div class="next-review">
    <div class="next-review-head">
       <p><strong> Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']);?></strong></p>
   </div> 
   <label><?php echo date("m-d-Y", strtotime($sql_owners_comment1['post_date']));?>  -  <?php echo "Hi ".$row['customer_name']; ?></label>
   <div class="next-review-cont"><?php echo $sql_owners_comment1['comment']; ?></div>
    <div class="clear"> </div>
</div>
<?php } ?>
</div>
<div class="clear"> </div>
</div>

<?php } ?>

</div>

</div>


<div class="clear"></div>



</div>

<div class="clear"></div>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>


<?php include("includes/footer_new.php");?>