<?php if($_REQUEST['submit_newsletter'] == 'Subscribe'){
	$sql_select_email = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_admin WHERE id = 1"));
	$sql_select = mysql_query("SELECT * FROM restaurant_subscriber WHERE email = '".$_REQUEST['email_subscribe']."'");
	if(mysql_num_rows($sql_select) == 0){
		$sql_insert = mysql_query("INSERT INTO restaurant_subscriber SET email = '".$_REQUEST['email_subscribe']."', subscriber_city = '".$_REQUEST['subscriber_city']."'");
		$id = mysql_insert_id();
		$email=$_REQUEST['email_subscribe'];
	
		$url="<a href='http://www.foodandmenu.com/newsletters_unsubscribe.php?action=view&id=".$id."' target='_blank'>
http://www.foodandmenu.com/newsletters_unsubscribe.php?action=view&id=".$id."</a>";
		
		$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
		
					<div style="margin:0 auto;width:700px;clear:both;">
		
					<div style="background-color:#3F4CA0; height:30px;"></div>
		
					<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">
		
					<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />
		
					</div>
		
					<div style="width:100%; float:left;">
		
					<div style="clear:both;"></div>
		
						<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">***** Welcome to Food & menu *****</p>
		
						<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">This email confirms that your request was correctly processed and you are now registered to receive the Food & menu Newsletter</p>
		
						<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Note: This email address was entered during the registration process. If you did not signup to receive our Food & menu newsletter, you can go at the bottom of this email and click the unsubscribe link to automatically unsubscribe you from our newsletter.</p>
		
					<div style="clear:both;"></div>
		
					<h2 style="color:#fff; font:bold 15px/30px Arial, Helvetica, sans-serif; background-color:#3F4CA0; padding:0 0 0 14px; text-transform:uppercase;">To unsubscribe :</h2>
		
						<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#04303d; margin:0 0 4px 15px;">'.$url.'</p>
		
					<div style="clear:both;"></div>
		
					<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>
		
					<div style="clear:both;"></div>
		
						<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>
		
						<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>
		
					<div style="clear:both;"></div>
		
					</div>
		
					<div style="clear:both;"></div>
		
					<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >
		
					<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">
		
		Sent to you from Food & menu</h4>
		
				</div>
		
			</div>
		
			<div style="clear:both;"></div>
		
			</div>';
		
		$from = $sql_select_email['email_id'];
		
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
		
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
		
		$message=$cms_rep;
		
		$subject='Welcome to Food & menu';
		
		mail($email,$subject,$message,$headers);
		
		
		echo '<script type="text/javascript"> window.location = "http://www.foodandmenu.com/newsletter_subscribe_success.php";</script>'; 
		exit;
	}
	else {
		$error = 1;
	    $redirect_url=str_replace('/','',$_SERVER['REQUEST_URI']);
		 $redirect_url=$redirect_url.'#letter';
		header("location:".$redirect_url);
	}
}?>
<script type="text/javascript">
function checkMessenger(themail)
{
	var tomatch  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!tomatch.test(themail))
	{ 
	window.alert('Invalid Email Address');
	return false;
	}
	return true; 
}
function check_valid(){
	if(document.frm_newsletter.email_subscribe.value == ''){
		alert("Please enter email");
		document.frm_newsletter.email_subscribe.focus();	
		return false;	
	}
	if(document.frm_newsletter.email_subscribe.value == 'Enter your email here'){
		alert("Please enter email");
		document.frm_newsletter.email_subscribe.focus();	
		return false;	
	}
	if ((document.frm_newsletter.email_subscribe.value!="") && (checkMessenger(document.frm_newsletter.email_subscribe.value)==false))
	{
	document.frm_newsletter.email_subscribe.value="";
	document.frm_newsletter.email_subscribe.focus();
	return false;
	}
	if(document.frm_newsletter.subscriber_city.value == ''){
		alert("Please enter your city");
		document.frm_newsletter.subscriber_city.focus();	
		return false;	
	}
	if(document.frm_newsletter.subscriber_city.value == 'Enter your city here'){
		alert("Please enter your city");
		document.frm_newsletter.subscriber_city.focus();	
		return false;	
	}
	return true;
}
</script>
<div class="footer_section">
<div class="footer_container">

<div class="footer_cont_top"></div>

<div class="footer_cont_middle">

<div class="cont_left_one"><a href="home.php"><img src="images/footer-logo.png" width="158" height="80" /></a></div>

<div class="cont_left_two">

<h1>Help Links</h1>

<ul>
<li><a href="contact.php">Contact us</a></li>
<li><a href="about.php">About us</a></li>
<li><a href="faq.php">FAQ</a></li>
<li><a href="contact.php">Add a restaurant</a></li>
</ul>
</div>

<div class="cont_left_two">

<h1>Other Links</h1>

<ul>
<li><a href="terms.php">Terms and Condition</a></li>
<li><a href="privacy.php">Privacy Policy</a></li>
<li><a href="advertisement.php">Advertisement</a></li>
<li><a href="career.php">Career</a></li>
</ul>
</div>


<div class="cont_left_three">
<h1>Newsletter</h1>
<?php if($error == 1){ ?>
<a name="#letter"><p style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:14px;">The email id already exists</p></a><?php } ?>
<form name="frm_newsletter" method="post" action="" onsubmit="return check_valid()">
<input name="email_subscribe" id="email_subscribe" type="text" class="textfield" value="Enter your email here" onfocus="if (this.value=='Enter your email here') this.value = ''" onBlur="(this.value=='')? this.value='Enter your email here':this.value;" style="margin-top:10px;"/>
<input name="subscriber_city" id="subscriber_city" type="text" class="textfield" value="Enter your city here" onfocus="if (this.value=='Enter your city here') this.value = ''" onBlur="(this.value=='')? this.value='Enter your city here':this.value;" style="margin-top:10px;"/>
<input name="submit_newsletter" type="submit" value="Subscribe" class="button" style="margin-top:10px;" />
</form>
</div>
<div class="clear"></div>
</div>

<div class="footer_cont_bottom"></div>

</div>

<div class="copyright_section">

<p>© <?php echo date('Y');?> Restaurant website, All right reserved</p>

<div class="clear"></div>
</div>

</div>
<?php
$social_media_link=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_social_media WHERE id=1"));
?>
<div class="left_side_icon">
<ul>
<li><a href="<?php echo $social_media_link['facebook_link']?>" target="_blank"><img src="images/facebook.png" width="37" height="37" /></a></li>
<li><a href="<?php echo $social_media_link['twitter_link']?>" target="_blank"><img src="images/twitter.png" width="37" height="37" /></a></li>
<li><a href="<?php echo $social_media_link['rss_feed']?>" target="_blank"><img src="images/rss.png" width="37" height="37" /></a></li>
<li><a href="<?php echo $social_media_link['linkedin_link']?>" target="_blank"><img src="images/linked_in.png" width="37" height="37" /></a></li>
<li><a href="<?php echo $social_media_link['google_plus_link']?>" target="_blank"><img src="images/google_plus.png" width="37" height="37" /></a></li>
</ul>
</div>
<?php if(basename($_SERVER['PHP_SELF'])!='home.php' && basename($_SERVER['PHP_SELF'])!='vendor.php' && basename($_SERVER['PHP_SELF'])!='index.php' && basename($_SERVER['PHP_SELF'])!='paymentdetails.php'){?>	
	<?php /*?><script type="text/javascript" src="javascript/prototype.js"></script>
	<script type="text/javascript" src="javascript/effects.js"></script>
	<script type="text/javascript" src="javascript/accordion.js"></script>
	<script type="text/javascript" src="javascript/code_highlighter.js"></script>
	<script type="text/javascript" src="javascript/javascript.js"></script>
	<script type="text/javascript" src="javascript/html.js"></script>

	
    
	<script type="text/javascript">
			
		// 
		//  In my case I want to load them onload, this is how you do it!
		// 
		Event.observe(window, 'load', loadAccordions, false);
	
		//
		//	Set up all accordions
		//
		function loadAccordions() {
			
			var bottomAccordion = new accordion('vertical_container');
			
			
			
			// Open first one
			bottomAccordion.activate($('#vertical_container .accordion_toggle')[0]);
			
			// Open second one
			topAccordion.activate($('#horizontal_container .horizontal_accordion_toggle')[2]);
		}
		
	</script><?php */?>
<?php } ?>

</body>
</html>
