<?php
error_reporting(1); 
ob_start()
session_start();

//print_r($_SESSION);
include("includes/rest_header.php");
include("includes/functions.php");
?>

<body>
<style>
#login-poup-area{width:620px; background-color:#EFEFEF; position:fixed; z-index:99999900; top:60px; height:420px; border-radius:7px;}.newpopup h3{color:#fff;padding:15px 0; background-color:#060606; text-align:center; width:100%; border-radius:7px 7px 0 0; font-size:18px;}.newpopup p{color:#000; font:bold 13px/26px 'droid_sansregular';padding-left:10px; margin:5px 10px;}.login_cross_bt{width:21px;height: 21px;position:absolute;margin: 4px 0px 0px 688px;z-index: 90000;}.popcontent label{ color:#a2a2a2; width:100%; float:left;}.popcontent input[type=text], .popcontent input[type=password]{height:26px; line-height:26px; font:normal 12px 'droid_sansregular'; color:#ddd; background-color:#333; width:94%;}#sidetab{display:none; width:620px; margin:0 auto; height:1px;}#fade{ background:#000000; opacity:0.6; filter:alpha(opacity=60); z-index:99; height:800px; width:100%; position:fixed; display:none;}.popcontent a{color:#060606; text-decoration:underline; font:normal 12px 'droid_sansregular'; float:right; margin-top:6px; margin-right:20px;}.popcontent a:hover{color:#FF7200; text-decoration:none;}.popcontent input[type=submit]{cursor:pointer;background-image: linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -o-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -moz-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -webkit-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -ms-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(69,69,69) 100%);background-image: -webkit-gradient(	linear,	left bottom,	left top,	color-stop(0.06, rgb(12,12,12)),	color-stop(1, rgb(69,69,69)));border-radius:3px;border:1px solid #0a0a0a;color: #005A61;width:92px;display: block;text-decoration: none;color:#fff;text-shadow: 0px 0px white, 0px 0px #444; font:normal 15px 'open_sansregular'; float:left; margin-bottom:20px; margin-top:10px; padding:4px 0 5px;}.popcontent input[type=submit]:hover{background-image: linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -o-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -moz-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -webkit-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -ms-linear-gradient(bottom, rgb(12,12,12) 6%, rgb(51,50,51) 100%);background-image: -webkit-gradient(	linear,	left bottom,	left top,	color-stop(0.06, rgb(12,12,12)),	color-stop(1, rgb(51,50,51)));}
</style>
<div id="fade"></div>
<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>

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
                    <script type="text/javascript">
					jQuery(function(){
						var YouTubeRegex = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
						jQuery('a.video').each(function(i){
							jQuery(this).click(function(event){
								event.preventDefault();
								var videoID = jQuery(this).attr('href').match(YouTubeRegex);
								//alert(videoID[1]);
								jQuery('div#fade').show();
								jQuery('div#video_content').css({
									padding : '10px',
								}).html('<span style="float: left;font-size: 20px;margin-left: 240px;margin-top: 190px;">Loading Video</span>');
								jQuery('div#sidetab').show();
								setTimeout(function(){
									jQuery('div#video_content').html('<iframe width="600" height="400" src="//www.youtube.com/embed/' + videoID[1] + '?wmode=transparent&autoplay=1" frameborder="0" allowfullscreen></iframe>');
								}, 5000);
							});
						});
						jQuery('a#video_close').click(function(event){
							event.preventDefault();
							jQuery('div#sidetab').hide();
							jQuery('div#fade').hide();
							jQuery('div#video_content').html('').removeAttr('style');
						});
					});
					</script>
                    <div class="accr_menu" id="tab">
                        <?php include('includes/tab_menu.php');?>
                        </div>
                    <div class="clear"></div>
					<div class="accr_details">
                    <div class="menu_nav">
                    
                    
                    <ul>
                    <li><a href="restaurant.php?id=<?php echo $_REQUEST['id'];?>#tab"  <?php if($_REQUEST['c_id']==''){ ?> class="active6" <?php } ?>>All Available Items</a></li>
                    <?php $sql_menu_category = mysql_query("SELECT * FROM restaurant_menu_category WHERE id!=''");
					
					while($array_menu_catyegory = mysql_fetch_array($sql_menu_category)){?>
                    <li><a href="restaurant.php?id=<?php echo $_REQUEST['id'];?>&c_id=<?php echo $array_menu_catyegory['id'];?>#tab" <?php if($array_menu_catyegory['id'] == $_REQUEST['c_id']){ ?> class="active6" <?php }?>><?php echo $array_menu_catyegory['category_name'];?></a></li>
                    <?php } ?>
                    
                    
                    </ul>
                    
                    </div>
                        
                        
                        <div id="vertical_container" >
                        <?php
						$all_menu_id="";
						$menu_sep="";
						$res_restaurant_main_category=mysql_query("select sub_category_id from restaurant_menu_item where restaurant_id='".$_REQUEST['id']."'");
						while($select_restaurant_main_category=mysql_fetch_array($res_restaurant_main_category))
						{
						$all_menu_id.=$menu_sep.$select_restaurant_main_category['sub_category_id'];
						$menu_sep=",";
						}
						
						?>
                        
                        <?php $sql_sub_category =("SELECT * FROM restaurant_menu_subcategory WHERE id IN(".$all_menu_id.")");
						if($_REQUEST['c_id']){
						$sql_sub_category.= " AND category_id = '".$_REQUEST['c_id']."'";
						}
						$sql_query = mysql_query($sql_sub_category);
						if(mysql_num_rows($sql_query)>0){
						while($array_sub_category = mysql_fetch_array($sql_query)){?>
                            <h1 class="accordion_toggle"><?php echo $array_sub_category['subcategory_name'];?></h1>
                            <div class="accordion_content"> 
                            <?php $sql_menu = mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '".$_REQUEST['id']."' AND sub_category_id = '".$array_sub_category['id']."'");
							if(mysql_num_rows($sql_menu)>0){
							while($array_menu = mysql_fetch_array($sql_menu)){ ?>  
                                <div class="light_box_cam">
                                <h2 style="float:none;"><?php if($array_menu['menu_pic']!=""){?>
                                <a href="uploaded_images/<?php echo $array_menu['menu_pic'];?>" class="highslide" onClick="return hs.expand(this)" style="color: #EF7011;float: left;font: 17px "Lobster Two";margin: 15px 0 5px 10px;"><?php echo $array_menu['menu_name'];?></a>
                                <?php
								}else{
								?>
                                <?php echo $array_menu['menu_name'];?>
                                <?php
								}
								?><span style="float:right; padding-right:10px;">$ <?php echo $array_menu['price'];?></span>
                                <div style="clear:both;"></div></h2>
                                
                                <div class="highslide-gallery">

<!--
	4) This is how you mark up the thumbnail image with an anchor tag around it.
	The anchor's href attribute defines the URL of the full-size image.
-->
<?php /*?>if($array_menu['menu_pic']!="")
{
?>
<a href="uploaded_images/<?php echo $array_menu['menu_pic'];?>" class="highslide" onClick="return hs.expand(this)"><img src="thumb_images/<?php echo $array_menu['menu_pic'];?>" alt="Highslide JS"
		title="Click to enlarge" /></a>
        <?php
}<?php */?>
<!--
	5 (optional). This is how you mark up the caption. The correct class name is important.
-->

<div class="highslide-caption">
	Caption for the first image.
</div>


</div>
                                
                              </div>
                                <div class="clear"></div>
                                <p><?php if($array_menu['description']!=""){?><?php echo $array_menu['description'];?><br><?php } ?></p>
                                  
                                 
                                
                                <?php } } else {?> 
                                <p> No items Available</p>
                                <?php }?>
                            </div>
                            
                            <?php } } else { ?>
                            <p style="font:14px Arial,Helvetica,sans-serif; text-align:center; padding:8px 0; color: #686868;">No items available</p>
                            <?php } ?>
                            
                        </div>
                        
                        
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



<div id="sidetab">
<div id="login-poup-area">
<a href="close" id="video_close"><img src="images/close.png" width="32" height="32" alt="" style="position:absolute; z-index:11111; cursor:pointer; right:-7px; top:-6px;"></a>
    <div class="newpopup">
        <div class="popcontent" id="video_content"></div>
    	<div class="clear"></div>
    </div>
</div>
</div>
<?php include("includes/footer.php");?>
