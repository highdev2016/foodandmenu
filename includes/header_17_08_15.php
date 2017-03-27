<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="google-site-verification" content="XDKvinsWwsT8egonri02KDnOicDihl8XokqxsjL-C6M" />
<meta name="msvalidate.01" content="98593D957300F985A120634549B94AC9" />
<link rel="shortcut icon" href="https://www.foodandmenu.com/favicon.ico" type="image/x-icon"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>food & menu</title>
<link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 
<link rel='stylesheet' id='camera-css'  href='css/ui.totop.css' type='text/css' media='all'> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style_new.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/animation.css">
<link href="css/responsive.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'> 
<!-- Web Fonts  -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Fascinate+Inline' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster+Two:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<!--for banner section -->


<script type="text/javascript">
var baseUrl = '<?php echo 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']); ?>';
</script>

<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>

<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.10/themes/smoothness/jquery-ui.css" type="text/css">
<?php /*?><script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10/jquery-ui.min.js"></script><?php */?>

<?php if(basename($_SERVER['PHP_SELF']) == 'index.php'){?>	
	
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

<!-- scroll to top -->

	<script src="jquery/main.js"></script>

</head>




<?php if($_REQUEST['city']!="")
{
	$_SESSION['city']=$_REQUEST['city'];
}?>