<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="google-site-verification" content="XDKvinsWwsT8egonri02KDnOicDihl8XokqxsjL-C6M" />
<meta name="msvalidate.01" content="98593D957300F985A120634549B94AC9" />
<link rel="shortcut icon" href="http://www.foodandmenu.com/favicon.ico" type="image/x-icon"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>food & menu</title>
<link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 
<link rel='stylesheet' id='camera-css'  href='css/ui.totop.css' type='text/css' media='all'> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<!--for banner section -->
<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
<?php if(basename($_SERVER['PHP_SELF']) == 'home.php'){?>	
	
	<script type='text/javascript' src='js/easing.js'></script>
    <!--<script type='text/javascript' src='js/jquery.mobile.customized.min.js'></script>-->
    <script type='text/javascript' src='js/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='js/camera.min.js'></script>
	<script>
		jQuery(function(){
			
			jQuery('#camera_wrap_1').camera({
				thumbnails: true
			});

			jQuery('#camera_wrap_2').camera({
				height: '317px',
				loader: 'bar',
				pagination: false,
				thumbnails: true
			});
		});
	</script>
<?php } ?>
    
    
    
    <script type='text/javascript' src='js/jquery.ui.totop.js'></script> 
    
    <script type="text/javascript">
		$(document).ready(function() {
			/*
			var defaults = {
	  			containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		};
			*/
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
	</script>
<!--end of banner-->
</head>
<?php if($_REQUEST['city']!="")
{
	$_SESSION['city']=$_REQUEST['city'];
}?>