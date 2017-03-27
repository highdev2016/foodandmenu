<?php 
ob_start();
session_start();
include("includes/rest_header.php");
include("includes/functions.php");

?>

<body>

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
                        
                        <?php $sql_sub_category = ("SELECT * FROM restaurant_menu_subcategory WHERE 1");
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
                                <div class="light_box_cam"><h2><?php echo $array_menu['menu_name'];?></h2>
                                
                                <div class="highslide-gallery">

<!--
	4) This is how you mark up the thumbnail image with an anchor tag around it.
	The anchor's href attribute defines the URL of the full-size image.
--><a href="uploaded_images/<?php echo $array_menu['menu_pic'];?>" class="highslide" onClick="return hs.expand(this)"><img src="thumb_images/<?php echo $array_menu['menu_pic'];?>" alt="Highslide JS"
		title="Click to enlarge" /></a><!--
	5 (optional). This is how you mark up the caption. The correct class name is important.
-->

<div class="highslide-caption">
	Caption for the first image.
</div>


</div>
                                
                              </div>
                                <div class="clear"></div>
                                <p><?php echo $array_menu['description'];?></p>
                                 
                                
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

<?php include("includes/footer.php");?>