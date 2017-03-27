<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="https://www.foodandmenu.com/favicon.ico" type="image/x-icon"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>food & menu</title>
<link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 
<link rel='stylesheet' id='camera-css'  href='css/ui.totop.css' type='text/css' media='all'> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>

<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />

<!-- JavaScript -->
  <!-- <script type="text/javascript" src="combine.php?type=javascript&files=prototype.js,effects.js,accordion.js,code_highlighter.js,javascript.js,html.js"></script> -->

<script type="text/javascript" src="javascript/prototype.js"></script>
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
			bottomAccordion.activate($$('#vertical_container .accordion_toggle')[0]);
			
			// Open second one
			topAccordion.activate($$('#horizontal_container .horizontal_accordion_toggle')[2]);
		}
		
	</script>

</head>