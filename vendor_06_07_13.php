<?php 
ob_start();
session_start();
?>
<?php include ("admin/lib/conn.php");
include('includes/functions.php');?>

<?php include ("includes/header_vendor.php"); ?>

<script type="text/javascript">
function getkey(e)
{
if (window.event)
return window.event.keyCode;
else if (e)
return e.which;
else
return null;
}
function goodchars(e, goods)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
if (goods.indexOf(keychar) != -1)
return true;
if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
return true;
return false;
}
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
function valid(i){
	var txt = '';
	if(document.getElementById('name'+i).value == ''){
		txt += 'Please enter name\n';
		//alert("Please enter name");
		//document.getElementById('name'+i).focus();	
		//return false;	
	}
	if(document.getElementById('email'+i).value == ''){
		txt += 'Please enter email\n';
		//alert("Please enter email");
		//document.getElementById('email'+i).focus();	
		//return false;	
	}
	if ((document.getElementById('email'+i).value!="") && (checkMessenger(document.getElementById('email'+i).value)==false))
	{
		txt += 'Please enter valid email\n';
		//document.getElementById('email'+i).value="";
		//document.getElementById('email'+i).focus();
		//return false;
	}
	if(document.getElementById('company'+i).value == ''){
		txt += 'Please enter company\n';
		//alert("Please enter company");
		//document.getElementById('company'+i).focus();	
		//return false;	
	}
	if(document.getElementById('comments'+i).value == ''){
		txt += 'Please enter comments\n';
		//alert("Please enter comments");
		//document.getElementById('comments'+i).focus();	
		//return false;	
	}
	if(document.getElementById('captcha_code'+i).value == ''){
		txt += 'Please enter captcha code\n';
		//alert("Please enter captcha code");
		//document.getElementById('captcha_code'+i).focus();	
		//return false;	
	}
	if(txt!=''){
		alert('Please fill up the mandatory fields :\n\n'+txt);
		return false;			
		}else{
		return true;
	}
}
function refreshCaptcha(i)
{
	var img = document.images['captchaimg'+i];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
<body>

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>
<?php 
if(isset($_REQUEST['submit'])){
if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['captcha_code']) != 0)
	{
		?>
		<script>
			//alert("<?php echo $_POST['hidid'] ?>");
			//$("#various<?php echo $_POST['hidid'] ?>").trigger('click');
			$("#vendors<?php echo $_POST['hidid'] ?>").bind('click', function () {
				//alert("WORK GOD DAMN IT!");
			});
        </script>
        
        <?php  
		//header("location:vendor.php?error=1");

	} else{

			$email=$_POST['vendor_name'];

			$name=$_POST['name'];

			$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/restaurant/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$_POST['vendor_name'].',</p>

            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$name.' has send you a contact request.</p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Abrief information is gicven below:</p>
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Name : '.$_REQUEST['name'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Email : '.$_REQUEST['email'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Company : '.$_REQUEST['company'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Comments : '.$_REQUEST['comments'].'</p>

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

			$from = $_POST['email'];

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message=$cms_rep;

			$subject="Contact Request";

			mail($email,$subject,$message,$headers);
			
			$email1=$_POST['email'];

			$name1=$_POST['name'];

			$cms_rep1 = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/restaurant/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$name1.',</p>

            				
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Thanks for taking time to check out Food & menu</p>
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Your contact request  is sent to vendor</p>
							

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
              $from1 = "support@foodandmenu.com";
			//$from1 = "sandeep.pandita@hotmail.com";

			$headers1 = "From:".$from1."\nReply-To: ".$from1."\nReturn-Path: ".$from1."\nX-Mailer: PHP\n";

			$headers1 .= 'MIME-Version: 1.0' . "\r\n";

			$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message1=$cms_rep1;

			$subject1="Confirmation mail";

			mail($email1,$subject1,$message1,$headers1);

			$success = 1;
			header("location:vendor.php?success=1");
	}
}
?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="about_body_cont">

<div class="vendor_content">

<div class="vendor_cont_top">
<h1>Vendor</h1>
<?php if($_REQUEST['success'] == 1){?>
<p style="color:#404CA1; margin-bottom:5px; text-align:center; font-family:Arial,Helvetica,sans-serif;">Your request is sent successfully to the Vendor</p>
<?php } else if($_REQUEST['error'] == 1) { ?>
<p style="color:#ff0000; margin-bottom:5px; text-align:center; font-family:Arial,Helvetica,sans-serif;">Validation code does not match</p>
<?php } ?>
</div>

<div class="vendor_cont_bottom">
<?php
$i=1;
$res_vendors=mysql_query("SELECT * FROM restaurant_vendors WHERE 1 order by show_order");
while($row_vendors=mysql_fetch_array($res_vendors))
{
	$sql_select_vendor = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_vendors WHERE id = '".$row_vendors['id']."'"));
?>
<script type="text/javascript">
		$(document).ready(function() {
			

			$("#vendors<?php echo $i; ?>").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
</script>
<div class="vendor_content_one">

<div class="vendor_cont_left"><img src="uploaded_images/<?php echo $row_vendors['image'];?>" width="200" height="180" /></div>

<div class="vendor_cont_middle2">

<p>Company Name : <?php echo $row_vendors['company_name'];?></p>

<p>Name : <?php echo $row_vendors['name'];?></p>

<p>Services Type : <?php echo $row_vendors['service_type'];?></p>

<p>Brief Description About The Company : <?php echo $row_vendors['company_brief_description'];?></p>

<p>Brief Products and Services Description : <?php echo $row_vendors['product_brief_description'];?></p>

</div>

<div class="vendor_cont_right">
  <ul><li>
  <?php if(isset($_SESSION['customer_id'])){?>
		<a class="various1" id="vendors<?php echo $i;?>" href="#inline<?php echo $i;?>" title="Lorem ipsum dolor sit amet"><?php } else { ?><a href="login.php?vendor=1"><?php } ?><img src="images/view_profile.png" width="130" height="39" /></a></li>
	</ul>
 
    
    <div style="display: none;">
		<div id="inline<?php echo $i;?>" style="width:620px;height:480px;overflow:auto;">
			<div class="view_wrapper">

<div class="view_top">

<div class="view_top_left"><img src="uploaded_images/<?php echo $row_vendors['image'];?>" /></div>

<div class="view_top_right">

<h1><?php echo $row_vendors['name'];?></h1>

<p>Company Name : <?php echo $row_vendors['company_name'];?></p>

<p>Address : <?php echo $row_vendors['address'];?></p>

<p>Phone : <?php echo $row_vendors['phone'];?></p>

<p>Email : <a href="mailto:<?php echo $row_vendors['email'];?>"><?php echo $row_vendors['email'];?></a></p>

<p>Social Media : <?php echo $row_vendors['social_media'];?></p>

<p>Website : <a href="<?php echo $row_vendors['website'];?>" target="_blank"><?php echo $row_vendors['website'];?></a></p>

</div>

<div class="clear"></div>
</div>

<div class="view_bottom">

<div class="view_bottom_text">

<p style="width:97% !important;">Product and Service Description : <?php echo $row_vendors['product_long_description'];?></p>

<div class="clear"></div>

<p style="width:97% !important;">About The Person/Company : <?php echo $row_vendors['company_long_description'];?></p>

<div class="clear"></div>
<?php if(isset($_SESSION['customer_id'])){?>
<p>Contact Submission :</p>
<?php } ?>

<div class="clear"></div>

</div>
<form name="frm_vendor" method="post" action="" onSubmit="return valid(<?php echo $i;?>);">
<input type="hidden" name="hidid" value="<?php echo $i;?>" />
<input type="hidden" name="vendor_name" value="<?php echo $sql_select_vendor['name'];?>">
<input type="hidden" name="vendor_email" value="<?php echo $sql_select_vendor['email'];?>">
<p>Name * :</p>

<input name="name" id="name<?php echo $i;?>" type="text"  class="viewfield"/>

<div class="clear"></div>

<p>Email * :</p>

<input name="email" id="email<?php echo $i;?>" type="text"  class="viewfield"/>

<div class="clear"></div>

<p>Phone No :</p>

<input name="phone" id="phone<?php echo $i;?>" type="text"  class="viewfield" onKeyPress="return goodchars(event,'1234567890');"/>

<div class="clear"></div>

<p>Company * :</p>

<input name="company" id="company<?php echo $i;?>" type="text"  class="viewfield"/>

<div class="clear"></div>

<p>Comments * :</p>

<textarea name="comments" id="comments<?php echo $i;?>" cols="" rows="" class="viewarea"></textarea>

<div class="clear"></div>

<p>Captcha * :</p>

<img src="captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg<?php echo $i;?>' style="margin-left:15px;">
<span style="color:#343434; font-family:Arial,Helvetica,sans-serif; font-size:13px;">Can't read the image? click <a href='javascript: refreshCaptcha(<?php echo $i;?>);'>here</a> to refresh</span>
<div class="clear"></div>
<p></p>
<input name="captcha_code" id="captcha_code<?php echo $i;?>" type="text"  class="viewfield"/>
<div class="clear"></div>
<input name="submit" type="submit" class="viewbutton" value="Submit" />
</form>
</div>

</div>
		</div>
	</div>
    </div>

<div class="clear"></div>
</div>
<?php
$i++;
}
?>

<!--<div class="vendor_content_one">

<div class="vendor_cont_left"><img src="images/profile_pic2.png" width="200" height="180" /></div>

<div class="vendor_cont_middle2">

<p>Company Name :</p>

<p>First Name / Last Name :</p>

<p>Services Type :</p>

<p>Brief Description About The Company :</p>

<p>Brief Products and Services Description :</p>

</div>

<div class="vendor_cont_right">
  <ul>
		<li><a id="various2" href="#inline2" title="Lorem ipsum dolor sit amet"><img src="images/view_profile.png" width="130" height="39" /></a></li>
	</ul>
    
    <div style="display: none;">
		<div id="inline2" style="width:620px;height:480px;overflow:auto;">
			<div class="view_wrapper">

<div class="view_top">

<div class="view_top_left"><img src="images/profile_pic2.png" /></div>

<div class="view_top_right">

<h1>Stephen Castro</h1>

<p>Company Name :</p>

<p>Address :</p>

<p>Phone :</p>

<p>Email :</p>

<p>Social Media :</p>

<p>Website :</p>

</div>

<div class="clear"></div>
</div>

<div class="view_bottom">

<div class="view_bottom_text">

<p>Product and Service Description :</p>

<div class="clear"></div>

<p>About The Person/Company :</p>

<div class="clear"></div>

<p>Contact Submission :</p>

<div class="clear"></div>

</div>

<p>Name :</p>

<input name="" type="text"  class="viewfield"/>

<div class="clear"></div>

<p>Email :</p>

<input name="" type="text"  class="viewfield"/>

<div class="clear"></div>

<p>Phone No :</p>

<input name="" type="text"  class="viewfield"/>

<div class="clear"></div>

<p>Company :</p>

<input name="" type="text"  class="viewfield"/>

<div class="clear"></div>

<p>Comments :</p>

<textarea name="" cols="" rows="" class="viewarea"></textarea>

<div class="clear"></div>

<p>Captcha :</p>

<img src="images/captcha.jpg" width="204" height="24" />
<div class="clear"></div>

<input name="" type="button" class="viewbutton" value="Submit" />

</div>

</div>
		</div>
	</div>
    </div>

<div class="clear"></div>
</div>-->


<div class="clear"></div>
</div>

</div>



</div>



</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<script type='text/javascript' src='js/easing.js'></script>
   <!--<script type='text/javascript' src='js/jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='js/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src='js/camera.min.js'></script>-->
    <script type='text/javascript' src='js/jquery.ui.totop.js'></script> 
 <!--   <script>
		$(function(){
			
			$('#camera_wrap_1').camera({
				thumbnails: true
			});

			
		});
	</script>-->
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
<?php include("includes/footer.php");?>