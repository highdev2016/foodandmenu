<?php
session_start();
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$page = $parts[count($parts) - 1];
?>
            <!-- header section start here -->

            <header class="stick_header banner-serve">

                <div class="container">

                    <div class="logo_section slideDown">

                        <a href="index.php"><img src="images/logo1.png"></a>

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
                    
                    <?php if(isset($_COOKIE['customer_id'])){	
	                        $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_COOKIE['customer_id']."'");
	                        $row_name1 = mysql_fetch_array($sql_customer_name1); ?>
	                        
	                        <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
	                        <?php } elseif(isset($_SESSION['customer_id'])){
	                        $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
	                        $row_name1 = mysql_fetch_array($sql_customer_name1); ?>
	                        <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
	                        <?php } ?>


					<?php /* ?> <div class="wlcm">
                        <?php
                        if (isset($_COOKIE['customer_id'])) {
                            $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '" . $_COOKIE['customer_id'] . "'");
                            $row_name1 = mysql_fetch_array($sql_customer_name1);
                            ?>

                            <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
                            <?php
                        } elseif (isset($_SESSION['customer_id'])) {
                            $sql_customer_name1 = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '" . $_SESSION['customer_id'] . "'");
                            $row_name1 = mysql_fetch_array($sql_customer_name1);
                            ?>
                            <a href="javascript:void(0);">Welcome, &nbsp;<i class="fa fa-user"></i> <?php echo $row_name1['firstname']; ?></a>
                        <?php } ?>
                    </div> <?php */ ?>
                    <?php /* ?><div class="login-sec">

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

                      </div><?php */ ?>

                    <div class="clear"></div>

                </div>

                <!-- address section start here  -->

                <section class="search_address_section">

                    <div class="container">

                        <h1>Your Address: <?php echo $_SESSION['address']; ?></h1>

                        <h2><a href="index.php"><?php /* ?><span>CLICK HERE</span> TO<?php */ ?> CHANGE ADDRESS</a></h2>

                    </div>

                </section>

                <!-- address section end here  -->

            </header>
