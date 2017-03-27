<?php if($_REQUEST['submit'] == 'Subscribe'){
	$sql_select = mysql_query("SELECT * FROM restaurant_subscriber WHERE email = '".$_REQUEST['email']."'");
	if(mysql_num_rows($sql_select) == 0){
		$sql_insert = mysql_query("INSERT INTO restaurant_subscriber SET email = '".$_REQUEST['email']."'");
	}
}?>
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
<form name="frm" method="post" action="">
<input name="email" type="text" class="textfield" value="Enter your email here" />
<input name="submit" type="submit" value="Subscribe" class="button" />
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

<div class="left_side_icon">
<ul>
<li><a href="#"><img src="images/facebook.png" width="37" height="37" /></a></li>
<li><a href="#"><img src="images/twitter.png" width="37" height="37" /></a></li>
<li><a href="#"><img src="images/rss.png" width="37" height="37" /></a></li>
<li><a href="#"><img src="images/linked_in.png" width="37" height="37" /></a></li>
<li><a href="#"><img src="images/google_plus.png" width="37" height="37" /></a></li>
</ul>
</div>


</body>
</html>
