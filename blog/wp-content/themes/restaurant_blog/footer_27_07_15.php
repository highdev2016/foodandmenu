<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
    </div>
    <div class="body_footer_bg"></div>
    <div class="clear"></div>
		</div><!-- #main .wrapper -->
	<?php /*?><footer id="colophon" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'twentytwelve_credits' ); ?>
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a>
		</div><!-- .site-info -->
	</footer><?php */?><!-- #colophon -->
    

</div>


</div>

</div>

<div class="clear"></div>

<footer>

    <div class="footer_top"><a href="#0" class="cd-top">Top</a></div>
    
    <div class="footer_mid">
    
        <div class="container">
    
            <div class="footer_mid_box foot_mid_logo">
            
                <a href="https://foodandmenu.com/index.php"><img src="https://foodandmenu.com/images/footer-logo1.png"></a>
            
            </div>
            
            <div class="footer_mid_box">
            
                <h1>Help Links</h1>
                
                <ul>
                    
                    <li><i class="fa fa-caret-right"></i> <a href="https://foodandmenu.com/about.php">About us</a></li>
                    
                    <li><i class="fa fa-caret-right"></i> <a href="https://foodandmenu.com/faq.php">FAQ</a></li>
                    
                    <li><i class="fa fa-caret-right"></i> <a href="https://foodandmenu.com/contact.php">Add a restaurant</a></li>
                    
                    <li><i class="fa fa-caret-right"></i> <a href="https://foodandmenu.com/contact.php">contact us</a></li>
                
                </ul>
            
            </div>
            
            <div class="footer_mid_box">
            
                <h1>Other Links</h1>
                
                <ul>
                    
                    <li><i class="fa fa-caret-right"></i> <a href="https://foodandmenu.com/terms.php">Terms and Condition</a></li>
                    
                    <li><i class="fa fa-caret-right"></i> <a href="https://foodandmenu.com/privacy.php">Privacy Policy</a></li>
                    
                    <li><i class="fa fa-caret-right"></i> <a href="https://foodandmenu.com/advertisement.php">Advertisement</a></li>
                    
                    <li><i class="fa fa-caret-right"></i> <a href="https://foodandmenu.com/career.php">Career</a></li>
                
                </ul>
            
            </div>
            
            <div class="footer_mid_box">
            
            <?php $sql_contact = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_contact_info WHERE page_id = 1")); ?>
            
                <h1>Contact us</h1>
                
                <ul>
                    
                    <li><span class="footer_icon"><i class="fa fa-home"></i></span> <a href="javascript:void(0);" style="font-family: Calibri; font-size: 14px; color: #FFF;"><?php echo htmlspecialchars_decode($sql_contact['address']);?></a></li>
                    
                    <li><span class="footer_icon"><i class="fa fa-phone"></i></span> <a href="javascript:void(0);"> <?php echo $sql_contact['telephone'];?></a></li>
                    
                    <li><span class="footer_icon"><i class="fa fa-envelope"></i></span> <a href="javascript:void(0);"> <?php echo $sql_contact['email'];?></a></li>
                
                </ul>
            
            </div>
            
            <div class="footer_mid_box last_mid_box">
            
                <a href="https://foodandmenu.com/restaurant_admin_login.php">Restaurant Owners Login</a>
                
              <div class="social_sec">
                
                <p>Follow us:</p>
                 <?php
                    $social_media_link=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_social_media WHERE id=1"));
                    ?>   
                  <ul>
                    
                      <li><a href="<?php echo $social_media_link['facebook_link']?>" title="facebook"><img src="https://foodandmenu.com/images/fb-icon.png"></a></li>
                        
                      <li><a href="<?php echo $social_media_link['twitter_link']?>" title="twitter"><img src="https://foodandmenu.com/images/tweet-icon.png"></a></li>
                        
                      <li><a href="<?php echo $social_media_link['google_plus_link']?>" title="google plus"><img src="https://foodandmenu.com/images/gplus-icon.png"></a></li>
                        
                      <li><a href="<?php echo $social_media_link['linkedin_link']?>" title="linked-in"><img src="https://foodandmenu.com/images/linked-in-icon.png"></a></li>
                    
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

<?php wp_footer(); ?>
</body>
</html>