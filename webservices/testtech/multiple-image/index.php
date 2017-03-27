<?php
//include "dbConfig.php";
?>
<html>
<head>
<title>Upload Image in PHP, Image, Images – discussdesk.com</title>
<meta name="description" content="In this PHP tutorial, you will learn how to upload multiple images using PHP and Mysql. Mysql  is used to store uploaded Image. You can display that stored Image in frontend."/>
<meta name="keywords" content="Free Image Upload, Image, Images, Image Upload, Upload Photos, upload pictures, free images, file, php, php tutorial, sql, mysql, Javascript, Jquery"/>
</head>

<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.deskform.js"></script>

<script type="text/javascript" >
 $(document).ready(function() { 
		
            $('#deskImg').die('click').live('change', function()			{ 
			           //$("#displayImg").html('');
			    
				$("#frm").ajaxForm({target: '#displayImg', 
				     beforeSubmit:function(){ 
					
					//console.log('v');
					$("#imgLoading").show();
					 $("#ingLoadButton").hide();
					 }, 
					success:function(){ 
					//console.log('z');
					 $("#imgLoading").hide();
					 $("#ingLoadButton").show();
					}, 
					error:function(){ 
							//console.log('d');
					 $("#imgLoading").hide();
					$("#ingLoadButton").show();
					} }).submit();
					
		
			});
        }); 
</script>

<style>


.displayImg
{
width:200px;
border:solid 1px #dedede;
padding:5px;
margin:5px;
}
#displayImg
{
color:#cc0000;
font-size:12px
}

</style>
<body>


<div style="float: left; padding: 50px 0 0 175px;">

	<div id='displayImg'>
	</div>
	


<form id="frm" method="post" enctype="multipart/form-data" action='processImage.php'>
Upload your image 
<div id='imgLoading' style='display:none'><img src="loading.gif" alt="Uploading...."/></div>
<div id='ingLoadButton'>
<input type="file" name="deskImg" id="deskImg" />
</div>
</form>
<div style="padding:35px 0 0 10px; font:bold 20px arial;"><a href="http://www.discussdesk.com/upload-multiple-image-in-php-and-mysql.htm">Go back to Tutorial</a></div>


</div>
</body>
</html>