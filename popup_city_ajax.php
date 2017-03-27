
<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="main_body_cont">

<div class="banner_section">
<div class="new_opening"><img src="images/new_opening.png" width="122" height="125" /></div>
<div class="banner_pic" style="height:317px; width:940px;">
<div class="fluid_container">
    	   <div class="camera_wrap camera_azure_skin" id="camera_wrap_1">
            <div data-thumb="images/thumbs/bridge.jpg" data-src="images/banner-pic.jpg">
            <div style="height:300px;
             display:block;"><a href="http://www.happycow.net/" target="_blank" style="display:block !important; display:block; height:250px; ">&nbsp;</a></div>
                <div class="camera_caption fadeFromBottom">
                    Camera is a responsive/adaptive slideshow. <em>Try to resize the browser window</em>
                </div>
            </div>
            <div data-thumb="images/thumbs/leaf.jpg" data-src="images/leaf.jpg">
            <div style="height:300px;
             display:block;"><a href="http://www.happycow.net/" target="_blank" style="display:block !important; display:block; height:250px; ">&nbsp;</a></div>
                <div class="camera_caption fadeFromBottom">
                    It uses a light version of jQuery mobile, <em>navigate the slides by swiping with your fingers</em>
                </div>
            </div>
            <div data-thumb="images/thumbs/road.jpg" data-src="images/road.jpg">
            <div style="height:300px;
             display:block;"><a href="http://www.happycow.net/" target="_blank" style="display:block !important; display:block; height:250px; ">&nbsp;</a></div>
                <div class="camera_caption fadeFromBottom">
                    <em>It's completely free</em> (even if a donation is appreciated)
                </div>
            </div>
            <div data-thumb="images/thumbs/big_bunny_fake.jpg" data-src="images/big_bunny_fake.jpg">
            <div style="height:300px;
             display:block;"><a href="http://www.happycow.net/" target="_blank" style="display:block !important; display:block; height:250px; ">&nbsp;</a></div>
                <div class="camera_caption fadeFromBottom">
                    Camera slideshow provides many options <em>to customize your project</em> as more as possible
                </div>
            </div>
            
            <div data-thumb="images/thumbs/tree.jpg" data-src="images/tree.jpg">
            <div style="height:300px;
             display:block;"><a href="http://www.happycow.net/" target="_blank" style="display:block !important; display:block; height:250px; ">&nbsp;</a></div>
                <div class="camera_caption fadeFromBottom">
                    Different color skins and layouts available, <em>fullscreen ready too</em>
                </div>
            </div>
        </div><!-- #camera_wrap_1 -->

    	
        <!-- #camera_wrap_2 -->
    </div>
<!--<img src="images/banner-pic.jpg" width="940" height="317" />-->
</div>
<div class="banner_shadow"></div>

</div>

<div class="content_container">

<?php include("includes/left_section.php");?>
<div class="body_cont_right">

<div class="right_top">

<div class="right_cont_top">
<h1>Hot Deal</h1>
</div>
<div class="right_cont_middle">

<?php $sql_select_deal = mysql_query("SELECT * FROM restaurant_deals WHERE deals_status =1 LIMIT 0,3");
while($array_deal = mysql_fetch_array($sql_select_deal)){?>
<div class="right_cont_one">

<div class="right_top_section">
<div class="top_image"><img src="thumb_images/<?php echo $array_deal['daily_picture'];?>" width="216" height="150" /></div>
</div>

<div class="right_middle_section">
<h1><?php echo stripslashes($array_deal['daily_name']);?></h1>
<p><?php echo substr(stripslashes($array_deal['daily_description']),0,50);?></p>
</div>

<div class="right_button">
  <a href="restaurant.php?id=<?php echo $array_deal['restaurant_id'];?>"><img src="images/more_button.png" width="77" height="26" /></a> 
  </div>

</div>


<?php } ?>

<div class="clear"></div>
</div>


<div class="right_cont_bottom"></div>

</div>
<div class="clear"></div>

<div class="right_dish_content">

<?php $query_res = "SELECT * FROM restaurant_basic_info WHERE restaurant_city='".$_REQUEST['city']."' AND status = 1";

$sel_product=mysql_query($query_res);
					
if(mysql_num_rows($sel_product)<1)
{
echo "No Results Found";
}

//////////////////////start pagination/////////////////////////
if($_REQUEST['search']!="")
{
$page=1;
}
else
{
$page=$_REQUEST['page'];

if($_REQUEST['page']=="") 
{ 
$page = 1; 
} 
}
$max_results =5; 
$prev = ($page - 1); 
$next = ($page + 1); 
$from = (($page * $max_results) - $max_results); 

$total_results = mysql_num_rows($sel_product); 
$total_pages = ceil($total_results / $max_results); 

$pagination = ''; 

if($page > 1) 
{ 
$pagination .= "<a href=\"index.php?page=$prev\" class=\"more_link_pagination_prev\">Previous</a>"; 
$pagination.="&nbsp;&nbsp;&nbsp;";
} 

for($i = 1; $i <=$total_pages; $i++) 
{ 
if(($page) == $i) 
{ 
$pagination .= $i; 
$pagination.='&nbsp;&nbsp;&nbsp;';
} 
else 
{ 
$pagination .= "<a href=\"index.php?page=$i\" class=\"more_link_pagination\">$i</a>"; 
$pagination.='&nbsp;&nbsp;&nbsp;';
} 
} 

if($page < $total_pages) 
{ 
$pagination .= "<a href=\"index.php?page=$next\" class=\"more_link_pagination_prev\">Next</a>"; 
$pagination.="&nbsp;&nbsp;&nbsp;";
} 

$query_res.=" limit $from,$max_results";
//echo $query_res;
$query_products=mysql_query($query_res);
////////////////////////////////End pagination////////////////////////////////////

while($array_select_restaurant = mysql_fetch_array($query_products)){?>
<div class="dish_content_one">

<div class="dish_cont_left"><img src="uploaded_images/<?php echo $array_select_restaurant['restaurant_image'];?>" width="179" height="109" /></div>

<div class="dish_cont_middle">

<h1><?php echo $array_select_restaurant['restaurant_name'];?></h1>

<ul>
<li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
<li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
<li><a href="#"><img src="images/star-1.png" width="16" height="16" /></a></li>
<li><a href="#"><img src="images/star-2.png" width="16" height="16" /></a></li>
<li><a href="#"><img src="images/star-3.png" width="16" height="15" /></a></li>
</ul>

<h2>18 Reviews</h2>

<p>Takeout only</p>

</div>

<div class="dish_cont_right">
  <a href="restaurant.php?id=<?php echo $array_select_restaurant['id']; ?>"><img src="images/view_more.png" width="130" height="39" class="view_more" /></a> </div>

<div class="clear"></div>
</div>
<?php } ?>

</div>



<div class="clear"></div>

<div class="pagination">

<div align="center">
<?php if($total_pages>1){ echo $pagination;}?>
<!--<ul>
<li><a href="#" class="prev">Previous</a></li>
<li><a href="#" class="active2">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
<li><a href="#">5</a></li>
<li><a href="#">6</a></li>
<li><a href="#" class="prev prev2">Next</a></li>
</ul>-->
</div>
</div>

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
