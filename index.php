
<?php include("includes/header_new.php"); ?>

<body>

<!-- Wrapper section start here -->

	<div id="wrapper">
    
    	<!-- header section start here -->
    <?php
		$currentFile = $_SERVER["PHP_SELF"];
		$parts = Explode('/', $currentFile);
		$page= $parts[count($parts) - 1]; 
	?>
    
            <header>
            
                <div class="container">
            
                	<div class="logo_section slideDown">
                    
                    	<a href="index.php"><img src="images/logo1.png" width="312" height="194"></a>
                    	
                    </div>
                    
                    <div class="nav_section">
                    
                    	<nav>
                        
                        	<ul id="menu">
                               
                                <li><a href="index.php" <?php if($page=="index.php"){?> class="active_menu" <?php }?> >Home</a></li>
                                
                                <li><a href="vendor.php" <?php if($page=="vendor.php"){ $class = "active_menu"; } ?> class="mid_menu <?php echo $class; ?>" >Vendors</a></li>
                                
                                <li><a href="https://foodandmenu.com/blog">Blog</a></li>
                                
                                <li><a href="contact.php" <?php if($page=="contact.php"){?> class="active_menu" <?php }?> >Contact Us</a></li>
                                
                                <?php if(isset($_COOKIE['customer_id'])){	
								$sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
								$row_name = mysql_fetch_array($sql_customer_name); ?>
                                    <li><a href="user_profile.php">User profile</a></li>
                                    <li><a href="logout.php" >Logout</a></li>
								<?php }
								elseif(isset($_SESSION['customer_id'])){
								$sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
								$row_name = mysql_fetch_array($sql_customer_name); ?>
									<li><a href="user_profile.php" class="login_icon log-icon"><span><img src="images/user.png"></span> <span><?php echo $row_name['firstname']; ?></span></a></li>
                                    <!-- <li><a href="user_profile.php"><?php echo $row_name['firstname']; ?></a></li> -->
                                    <li><a href="logout.php" class="regi_icon log-icon"><span><img src="images/logout.png"></span> <span>Logout</span></a></li>
                                    <!-- <li><a href="logout.php" >Logout</a></li> -->
								<?php } else{ ?>
                                    <li><a href="login.php" class="login_icon log-icon"><span><img src="images/login-icon.png"></span> <span>Login</span></a></li>
                                    
                                    <li><a href="signup.php" class="regi_icon log-icon"><span><img src="images/regi-icon.png"></span> <span>Register</span></a></li>
                                <?php } ?>
                            </ul>
                        
                        </nav>
                    
                    </div>
                     <!-- <div class="wlcm">
                    	 <?php if(isset($_COOKIE['customer_id'])){	
	                        $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
	                        $row_name1 = mysql_fetch_array($sql_customer_name1); ?>
	                        
	                        <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
	                        <?php } elseif(isset($_SESSION['customer_id'])){
	                        $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
	                        $row_name1 = mysql_fetch_array($sql_customer_name1); ?>
	                        <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
	                        <?php } ?>
                    </div> -->
                    
                    
                    <?php /*?><div class="login-sec">
                   		<?php if(isset($_COOKIE['customer_id'])){	
                        $sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
                        $row_name = mysql_fetch_array($sql_customer_name); ?>
                        
                        <!-- <a href="javascript:void(0);">Welcome , <?php //echo $row_name['firstname']; ?></a> -->
                        <a href="user_profile.php">User profile</a>
                        <a href="logout.php" >Logout</a>
                        <?php }
                        elseif(isset($_SESSION['customer_id'])){
                        $sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
                        $row_name = mysql_fetch_array($sql_customer_name); ?>
                        <!-- <a href="javascript:void(0);">Welcome , <?php //echo $row_name['firstname']; ?></a> -->
                        <a href="user_profile.php">User profile</a>
                        <a href="logout.php" >Logout</a>
                        <?php } else{ ?>
                    
                    	<a href="login.php" class="login_icon"><span><img src="images/login-icon.png"></span> <span>Login</span></a>
                        
                        <a href="signup.php" class="regi_icon"><span><img src="images/regi-icon.png"></span> <span>Register</span></a>
                        <?php } ?>
                        
                        <div class="clear"></div>
                    
                    </div><?php */?>
                    
                    <div class="clear"></div>
            
              </div>
            
            </header>
        
        <!-- header section end here -->
        
        
        <!-- banner section start here -->
        
        	<section class="banner_section">
            <?php
			$all_banner = mysql_query("SELECT * FROM restaurant_banner WHERE status = 1");
			?>
            	<ul id="demo1">
                <?php while($banner = mysql_fetch_assoc($all_banner)) { ?>
                    <li>
                    <img src="uploaded_images/<?php echo $banner['image']; ?>">
                    
                    </li>
                    <?php } ?>
                    <?php /*?><li><img src="images/banner-bg2.jpg">
                       
                    </li>
                    <li><img src="images/banner-bg3.jpg">
                    
                    </li>
                    <li><img src="images/banner-bg4.jpg">
                      
                    </li><?php */?>
                    
                    </ul>
            
       	    	<div class="black_shade">                	
                     <div class="black_shade2">
                     <div class="container">
                            <div class="col-xs-9 restu_search_panel" id="search_panel">
                               
                        	<img src="images/cook.png" class="cook_pic">
                        
                        	<h1>Eat Smart…Order Online !</h1>
                            
                            <div class="clear"></div>
                    
                    		<div class="search-panel-sec">
                            <form name="search_form" id="search_form" enctype="multipart/form-data" method="post" action="search_result.php" >
                            	<input name="address" id="address" type="text" class="search_field" placeholder="Enter Address">
                                <div id="map-canvas"></div>
                                <!--<select name="" class="search_select"></select>-->
                                
                              <select id="set_value" name="set_value">
                                  <option value="del_pickup">Delivery & Pickup</option>
                                  <option value="del">Delivery</option>
                                  <option value="pickup">Pickup</option>
                              </select>
                                <input name="hid_default" type="hidden" value="default">
                                <input name="search" type="submit" class="search_button" value="Find Restaurants">
                            </form>
                                <div class="clear"></div>
                            
                          </div>
                                </div> 
                      </div>
                    
                    </div>
                
                </div>
            
            </section>
        
        <!-- banner section end here -->
        
        
        <!-- slider section start here -->
        
        	<section class="mid_slide_section">
            
            	<div class="container">
            	<?php
				$all_middle_banner = mysql_query("SELECT * FROM restaurant_middle_banner WHERE status = 1");
				?>
                    <ul id="demo3">
                    <?php while($middle_banner = mysql_fetch_assoc($all_middle_banner)) { ?>
                    <li>
                    <div class="animated wrap-content-info">
                    <img src="uploaded_images/<?php echo $middle_banner['image']; ?>">
                    </div>
                    <div class="slide-desc animated wrap-content">
                        <?php echo $middle_banner['text']; ?>
                    </div>
                    </li>
                    <?php } ?>
                    <?php /*?><li>
                    <div class="animated wrap-content-info">
                    <img src="images/home-banner-2.png">
                    </div>
                    <div class="slide-desc animated wrap-content">
                        <h2>Lorem Ipsum Dolor Amet</h2>
                        <p>Lorem Ipsum is simply <span>dummy text</span> of the printing 
                        and typesetting industry. Lorem Ipsum has been the industry's 
                        standard dummy text ever since the <span>1500s</span></p>
                        <h3>Enjoy.</h3>
                  </div>
                    </li><?php */?>
                    <?php /*?><li>
                    <div class="animated wrap-content-info">
                    <img src="images/home-banner-3.png">
                    </div>
                    <div class="slide-desc animated wrap-content">
                        <h2>Lorem Ipsum Dolor Amet</h2>
                        <p>Lorem Ipsum is simply <span>dummy text</span> of the printing 
                        and typesetting industry. Lorem Ipsum has been the industry's 
                        standard dummy text ever since the <span>1500s</span></p>
                        <h3>Enjoy.</h3>
                  </div>
                    </li><?php */?>
                    
                    </ul>
                
                </div>
            
            </section>
        
        <!-- slider section end here -->
        
        
        <!-- body section start here -->
        
        	<section class="body_mid_section">
            
            	<div class="body_top_sec">
                
                	<div class="container">
                    
                    	<div class="heading_section">
                        
                        	<p><img src="images/star-bar.png" width="410" height="17"></p>
                            
                          <p>FOod and menu is easy as 1,2,3...</p>
                            
                          <p><img src="images/star-bar.png" width="410" height="17"></p>
                            
                            <div class="clear"></div>
                            
                            <div class="bottom_box_sec">
                            
                            	<div class="col-xs-4 top_box_sec animated wrap-content-info">
                                
                                	<span><img src="images/locate-icon.png" width="106" height="106"></span>
                                    
                                    <div class="address_bg">
                                    
                                    <?php
									$home_cntnt1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_home_page_content WHERE  id = 1"));
									$home_cntnt2 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_home_page_content WHERE  id = 2"));
									$home_cntnt3 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_home_page_content WHERE  id = 3"));
									?>
                                    
                                    	<h1>1.  <?php echo $home_cntnt1['heading']; ?></h1>
                                        
                                        <p><?php echo htmlspecialchars_decode($home_cntnt1['description']); ?> </p>
                                    
                                    </div>
                                
                                </div>
                                
                                <div class="col-xs-4 top_box_sec animated wrap-content-info2">
                                
                                	<span><img src="images/click-icon.png" width="106" height="106"></span>
                                    
                                    <div class="address_bg">
                                    
                                    	<h1>2.  <?php echo $home_cntnt2['heading']; ?></h1>
                                        
                                        <p style="background-color:none !important;"><?php echo htmlspecialchars_decode($home_cntnt2['description']); ?> </p>
                                    
                                    </div>
                                
                              </div>
                                
                                <div class="col-xs-4 top_box_sec animated wrap-content-info3">
                                
                                	<span><img src="images/order-online-icon.png" width="106" height="106"></span>
                                    
                                    <div class="address_bg">
                                    
                                    	<h1>3.  <?php echo $home_cntnt3['heading']; ?></h1>
                                        
                                        <p><?php echo htmlspecialchars_decode($home_cntnt3['description']); ?> </p>
                                    
                                    </div>
                                
                              </div>
                            
                            	<div class="clear"></div>  
                            
                            </div>                      
                        	                        
                        </div>
                                                                    
                    </div>
                
                </div>
                
                <div class="delivery-app-sec">
                
                	<div class="container">
                    
                    	<div class="app_deliver_sec">
                
                            <div class="col-xs-6 rollIn animated2 fade_right deliver_app">
                        
                            <h1>The Best Food Delivery App</h1>
                                
                            <p>Now you can make food happen pretty much wherever you are thanks to the free easy-to-use Food and Menu Food Delivery & Takeout App for desktop and mobile. </p>
                                
                            <div class="clear"></div>
                            
                              <div class="app_butt_section">
                                
                                  <a href="#" class="get_app_cls">Get the App Now <img src="images/find-arrow.png" width="7" height="9"></a>
                                  
                                  <a href="#"><img src="images/android-pic.png" width="75" height="88" class="app_icon"></a>
                                  
                                  <a href="#"><img src="images/ios-pic.png" width="72" height="73" class="app_icon"></a>
                                    
                                  <div class="clear"></div>
                              
                              </div>
                        
                        </div>
                        
                            <div class="col-xs-6 rollIn animated2 fade_left deliver_app">
                            
                                <div class="desc_image_sec">
                                    <img src="images/app-desc-pic.png">
                                    <div class="clear"></div>
                                </div>
                            
                            </div>
                        
                            <div class="clear"></div>
                        
                        </div>
                        
                    </div>
                
                </div>
                
                <div class="update_section animated photo-content">
                
                	<div class="container">
                    
                    	<div class="heading_update_section">
                        
                        	  <p><img src="images/star-bar-orange.png" width="410" height="17"></p>
                            
                              <p>Our Updates</p>
                                
                              <p><img src="images/star-bar-orange.png" width="410" height="17"></p>
                          
                        </div>
                        
                        <div class="cmt">
                        <?php $sql_updates = mysql_query("SELECT * FROM restaurant_updates WHERE 1 ORDER BY date DESC ");
						while($array_updates = mysql_fetch_array($sql_updates)){ ?>
						
                          <div class="slide">
                          	<div class="slide_inner">
                                <h2><?php echo date('m-d-Y',strtotime($array_updates['date'])); ?></h2>
                                <div class="up-cont"><?php echo $array_updates['short_desc']; ?> </div>
                                <a class="more" href="updates.php?id=<?php echo $array_updates['id']; ?>">more</a>
                            </div>
                          </div>
                          
                        <?php } ?>  
                                    
                        </div>
                        
                        
                    
                    </div>
                
                </div>
            
            </section>
        
        <!-- body section end here -->
        
        
<?php include("includes/footer_new.php"); ?>