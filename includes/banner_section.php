<div class="banner_section">
<div class="new_opening"><img src="images/new_opening.png" width="122" height="125" /></div>
<div class="banner_pic" style="height:317px; width:940px;">
<div class="fluid_container">
    	   <div class="camera_wrap camera_azure_skin" id="camera_wrap_1" style="height:500px;">
           
           <?php $sql_banner = mysql_query("SELECT * FROM restaurant_banner WHERE status = 1"); 
		   while($array_banner = mysql_fetch_array($sql_banner)){?>
            <div data-thumb="thumb_images/<?php echo $array_banner['image'];?>" data-src="uploaded_images/<?php echo $array_banner['image'];?>">
            <div style="height:300px;
             display:block;"><a href="<?php echo $array_banner['link']; ?>" target="_blank" style="display:block !important; display:block; height:300px;">&nbsp;</a></div>
                <div class="camera_caption fadeFromBottom">
                    <?php echo stripslashes($array_banner['text']); ?></em>
                </div>
            </div>
            
            <?php } ?>
            
            
            
            
        </div><!-- #camera_wrap_1 -->

    	
        <!-- #camera_wrap_2 -->
    </div>
<!--<img src="images/banner-pic.jpg" width="940" height="317" />-->
</div>
<div class="banner_shadow"></div>

</div>