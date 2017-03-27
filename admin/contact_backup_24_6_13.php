<?php 
session_start();
include ("includes/header.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
?>
<?php
$admin_info = getAdminInfo();
$admin_email = $admin_info['email_id']; 
$admin_nicename = $admin_info['nicename']; 

if(isset($_REQUEST['submit'])){
if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['captcha_code']) != 0)
	{  
		$msg1 = "The Validation code does not match!";

	}else{
		
		$sql_insert_owner = mysql_query("INSERT INTO restaurant_owner SET name = '".$_REQUEST['name']."',email = '".$_REQUEST['email']."',phone = '".$_REQUEST['phone']."',restaurant = '".$_REQUEST['restaurant']."',website = '".$_REQUEST['website']."',subject = '".$_REQUEST['subject']."',category = '".$_REQUEST['category']."',message = '".$_REQUEST['message']."',date_added = '".date('Y-m-d H:i:s')."',status = '1'");
		
		if($sql_insert_owner){

			$site_url="http://". $_SERVER['HTTP_HOST'] ."";
			$email	   			  = trim($_POST['email']);
			$name				   = trim($_POST['name']);
			$phone       			  = trim($_POST['phone']);
			$contact_request 		= mysql_real_escape_string(trim($_REQUEST['subject']));
			$user_message 		   = mysql_real_escape_string(trim($_REQUEST['message']));
			
			$mail_to_admin = mailToAdmin($admin_email, $admin_nicename, $email, $name, $phone, $contact_request, $user_message );
			$mail_to_user  = mailToUser($name, $email, $admin_email, $admin_nicename, $phone, $contact_request, $user_message );
			
			if($mail_to_user)
				$msg = "We have saved your response and will contact you as soon as possible.";			
		}

	}
}

?>
<script type="text/javascript">
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
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
function valid(){
	var txt = '';
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	if(document.getElementById('name').value==''){
		txt+='Please Enter Your Name\n';
	}
	if(document.getElementById('email').value == ''){
		txt+='Please enter email address\n';
	}
	alert(txt);
	if ((document.frm.email.value!="") && (checkMessenger(document.frm.email.value)==false))
	{
	document.frm.email.value="";
	document.frm.email.focus();
	return false;
	}
	if(document.frm.message.value==''){
		alert('Please enter message');
		document.frm.message.focus();
		return false;
	}
	if(document.frm.terms.checked==false){
		alert('Please agree to food and menu terms');
		document.frm.terms.focus();
		return false;
	}
	if(document.frm.captcha_code.value==''){
		alert('Please enter captcha code');
		document.frm.captcha_code.focus();
		return false;
	}
	if( txt!='' ){
		alert('Please fill up the mandatory fields :\n\n'+txt);
		return false;
	} else {
		return true;
	}
}



</script>

<body>

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="contact_body_cont">

<div class="contact_left_panel">

<div class="cont_left_panel_top">
<h1>Contact Us</h1>
</div>

<div class="cont_left_panel_middle">

<p>Your Satisfaction is important to us at food and Menus. Please refer to our FAQ or just simply fill out the contact form below. We will get back to you
as soon as possible.</p>
<?php if($msg1!=''){?>
<p style="color:#E90101;"><?php echo $msg1; ?></p>
<?php } else if($msg!=''){?>
<p style="color:#788D23;"><?php echo $msg; ?></p>
<?php }?>
<form name="frm" method="post" action="" onSubmit="return valid();">
<div class="cont_right_field">

<p>Your Name (*)</p>

<input name="name" id="name" type="text" class="contactfield" />

<div class="clear"></div>

<p>Your Email (*)</p>

<input name="email" id="email" type="text" class="contactfield" />

<div class="clear"></div>

<p>Your Phone</p>

<input name="phone" type="text" class="contactfield" onKeyPress="return goodchars(event,'1234567890+-');"/>

<div class="clear"></div>

<p>Your Restaurant</p>

<input name="restaurant" type="text" class="contactfield" />

<div class="clear"></div>

<p>Your Website</p>

<input name="website" type="text" class="contactfield" />

<div class="clear"></div>

</div>

<div class="clear"></div>

<div class="select_area_content">

<div class="select_area_top">

<h1>So what can we help you with?</h1>

</div>

<div class="select_area_bottom">

<p>Select a subject</p>

<select name="subject" class="selectarea_box" id="selectarea_box" >

<option value="1">Registration Request</option>
<option value="2">General Enquiry</option>
<option value="3">Grievance</option>

</select>

<div class="clear"></div>

<p>Select a category</p>

<div id="res_reqst_cat">
<select name="category" class="selectarea_box">
    <option value="1">Register my restaurant</option>
    <option value="2">Register as a vendor</option>
</select>
</div>

<div class="clear"></div>

<div class="select_textfield">

<p>Your Message (*)</p>

<textarea name="message" cols="" rows="" class="contactarea"></textarea>

<div class="clear"></div>

<h3><input name="terms" type="checkbox" value="" class="select_check" /> Agree to Food and Menus Terms </h3>

<div class="clear"></div>

<p>Captcha (*)</p>

<img src="captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg' style="margin-left:15px;">
<span style="color:#595959; font-family:Arial,Helvetica,sans-serif; font-size:13px;">Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</span>
<br />

<input id="captcha_code" name="captcha_code" type="text" class="contactfield2" />

<div class="clear"></div>

<input name="submit" type="submit" value="Submit" class="button3" />

<div class="clear"></div>

</div>
</form>

<div class="clear"></div>
</div>

</div>

<div class="contact_info">

<h1>If you would like to send correspondence to our office, please address it to :</h1>

<p>Food and Menus</p>
<p>P.O.BOX 685103</p>
<p>Austin, Tx, 78768</p>

</div>

</div>

<div class="cont_left_panel_bottom"></div>

</div>

<div class="contact_right_panel">

<div class="contact_right_top">
<h1>Contact Info</h1>
</div>
<?php $sql_contact = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_contact_info WHERE page_id = 1"));?>
<div class="contact_right_middle">
<h1>Call us toll free at </h1>
<h2><?php echo $sql_contact['telephone'];?></h2>

<img src="images/mail.png"/>
<p>Mailing Address</p>

<div class="clear"></div>

<?php echo htmlspecialchars_decode($sql_contact['address']);?>

<h3>Telephone:</h3>

<h4><?php echo $sql_contact['telephone'];?></h4>

<h3>Email:</h3>

<h5><?php echo $sql_contact['email'];?> </h5>

</div>

<div class="contact_right_bottom"></div>

</div>

<div class="clear"></div>

</div>


</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<?php include("includes/footer.php");?>