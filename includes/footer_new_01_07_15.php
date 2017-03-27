 <!-- footer section start here -->
        
        	<footer>
            
            	<div class="footer_top"><a href="#0" class="cd-top">Top</a></div>
                
                <div class="footer_mid">
                
                	<div class="container">
                
                        <div class="footer_mid_box foot_mid_logo">
                        
                        	<a href="index.php"><img src="images/footer-logo1.png"></a>
                        
                        </div>
                        
                        <div class="footer_mid_box">
                        
                        	<h1>Help Links</h1>
                            
                            <ul>
                            	
                                <li><a href="about.php">About us</a></li>
                                
                                <li><a href="faq.php">FAQ</a></li>
                                
                                <li><a href="contact.php">Add a restaurant</a></li>
                                
                                <li><a href="contact.php">contact us</a></li>
                            
                            </ul>
                        
                        </div>
                        
                        <div class="footer_mid_box">
                        
                        	<h1>Other Links</h1>
                            
                            <ul>
                            	
                                <li><a href="terms.php">Terms and Condition</a></li>
                                
                                <li><a href="privacy.php">Privacy Policy</a></li>
                                
                                <li><a href="advertisement.php">Advertisement</a></li>
                                
                                <li><a href="career.php">Career</a></li>
                            
                            </ul>
                        
                        </div>
                        
                        <div class="footer_mid_box">
                        
                        <?php $sql_contact = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_contact_info WHERE page_id = 1")); ?>
                        
                        	<h1>Contact us</h1>
                            
                            <ul>
                            	
                                <li><a href="javascript:void(0);" style="font-family: Calibri; font-size: 14px; color: #FFF;"><?php echo htmlspecialchars_decode($sql_contact['address']);?></a></li>
                                
                                <li><a href="javascript:void(0);">Telephone: <?php echo $sql_contact['telephone'];?></a></li>
                                
                                <li><a href="javascript:void(0);">Email: <?php echo $sql_contact['email'];?></a></li>
                            
                            </ul>
                        
                        </div>
                        
                        <div class="footer_mid_box last_mid_box">
                        
                        	<a href="restaurant_admin_login.php">Restaurant Owners Login</a>
                            
                          <div class="social_sec">
                            
                           	<p>Follow us:</p>
                             <?php
								$social_media_link=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_social_media WHERE id=1"));
								?>   
                              <ul>
                                
                               	  <li><a href="<?php echo $social_media_link['facebook_link']?>" title="facebook"><img src="images/fb-icon.png"></a></li>
                                    
                                  <li><a href="<?php echo $social_media_link['twitter_link']?>" title="twitter"><img src="images/tweet-icon.png"></a></li>
                                    
                                  <li><a href="<?php echo $social_media_link['google_plus_link']?>" title="google plus"><img src="images/gplus-icon.png"></a></li>
                                    
                                  <li><a href="<?php echo $social_media_link['linkedin_link']?>" title="linked-in"><img src="images/linked-in-icon.png"></a></li>
                                
                              </ul>
                            
                            </div>
                        
                        </div>
                        
                        <div class="clear"></div>
                    
                    </div>
                
                </div>
                
                <div class="footer_bottom">
                
                	<p>© <?php echo date('Y'); ?> Food and menu, All right reserved</p>
                
                </div>
            
            </footer>
        
        <!-- footer section end here -->
        
        	    
</div>

<!-- Wrapper section end here -->



</body>
</html>
