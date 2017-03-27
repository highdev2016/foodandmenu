<?php 
session_start();
ob_start();
//include("search_compete.php"); 
include ("includes/header.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
?>
<?php 
	require_once('recaptchalib.php'); 
	$publickey = "6LcWP-MSAAAAAOXVzezbutFv21U82KBS1ea_cE_X";
	$privatekey = "6LcWP-MSAAAAAJn1hKZDMTmEaeP0eyFngz27yTOY";
?>

<?php
$admin_info = getAdminInfo();
$admin_email = $admin_info['email_id']; 
$admin_nicename = $admin_info['nicename']; 
$captcha_code = $_REQUEST['captcha_code'];

if(isset($_REQUEST['submit'])){
	
if($_POST["captcha_code"]!="")
{
//if ($_POST["recaptcha_response_field"]) {
        /*$resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);*/

        if(strcasecmp($_SESSION['6_letters_code'], $captcha_code) == 0){
			
			$sql_select_owner = mysql_query("SELECT * FROM restaurant_owner WHERE email = '".$_REQUEST['email']."'");
			
			$subject = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_subject WHERE id = '".$_REQUEST['subject']."'"));	
			$category = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_contact_category WHERE id = '".$_REQUEST['category']."'"));
				
			$sql_insert_owner = mysql_query("INSERT INTO restaurant_owner SET name = '".$_REQUEST['name']."',email = '".$_REQUEST['email']."',phone = '".$_REQUEST['phone']."',restaurant = '".$_REQUEST['restaurant']."',website = '".$_REQUEST['website']."',subject = '".$subject['subject']."',category = '".$category['contact_category']."',message = '".$_REQUEST['message']."',date_added = '".date('Y-m-d H:i:s')."',status = '1'");
			
			if($sql_insert_owner){
	
				$site_url="https://". $_SERVER['HTTP_HOST'] ."";
				$email	   			  = trim($_POST['email']);
				$name				   = trim($_POST['name']);
				$phone       			  = trim($_POST['phone']);
				$contact_request 		= mysql_real_escape_string(trim($_REQUEST['subject']));
				$user_message 		   = mysql_real_escape_string(trim($_REQUEST['message']));
				$your_restaurant 		= mysql_real_escape_string(stripslashes($_REQUEST['restaurant']));
				$your_website 		= mysql_real_escape_string(trim($_REQUEST['website']));
				$subject_msg 		   = mysql_real_escape_string(trim($subject['subject']));
				$category 		   = mysql_real_escape_string(trim($category['contact_category']));
				
				$mail_to_admin = mailToAdmin($admin_email, $admin_nicename, $email, $name, $phone, $contact_request, $user_message , $your_restaurant, $subject_msg, $category, $your_website);
				$mail_to_user  = mailToUser($name, $email, $admin_email, $admin_nicename, $phone, $contact_request, $user_message, $your_website,$your_restaurant);
				
				if($mail_to_user)
					$msg = "We have saved your response and will contact you as soon as possible.";	
						
			}
              header("location:contact.php?msg=success");	
				
		   
					
        } else {
			$msg1 = "The Validation code does not match!";        
		}
//}
}
else{
	$msg1 = "Please enter the captcha code!";
}
}
	
if($_REQUEST['msg']=='success')
{
	$msg="We have saved your response and will contact you as soon as possible.";
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
	if( document.getElementById('email').value!='' && !emailPattern.test( document.getElementById('email').value )){
		txt+='Please Enter Valid Email\n';
	}
	if(document.getElementById('message').value == ''){
		txt+='Please enter message\n';
	}
	if(document.getElementById('terms').checked == false){
		txt+='Please agree to food and menu terms\n';
	}
	
	
	if( txt!='' ){
		alert('Please fill up the mandatory fields :\n\n'+txt);
		return false;
	} else {
		return true;
	}
}

function getsubject(subject){
	
	$.ajax({
		url : 'getSubcategory.php',
		type : 'POST',
		data : 'subject=' + subject,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("||");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('sub_category').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}



</script>

<body onLoad="init();">

<?php //include ("includes/top_search.php");?>

<?php //include ("includes/menu_section.php");?>

<?php include ("includes/header_inner_new.php");?>

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
<p style="color:#788D23; font-weight:bold;"><?php echo $msg; ?></p>
<?php }?>
<?php 
if($error!=''){ ?>
<p style="color:#FF0000; font-weight:bold;"><?php echo $error; ?></p>
<?php } ?>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };
 </script>
<form name="frm" method="post" action="contact.php" onSubmit="return valid();">
<div class="cont_right_field">

<p>Your Name (*)</p>

<input name="name" id="name" type="text" class="contactfield" value="<?php echo $_REQUEST['name']; ?>" />

<div class="clear"></div>

<p>Your Email (*)</p>

<input name="email" id="email" type="text" class="contactfield" value="<?php echo $_REQUEST['email']; ?>" />

<div class="clear"></div>

<p>Your Phone</p>

<input name="phone" type="text" class="contactfield" value="<?php echo $_REQUEST['phone']; ?>" onKeyPress="return goodchars(event,'1234567890+-');"/>

<div class="clear"></div>

<p>Your Restaurant</p>

<input name="restaurant" type="text" class="contactfield" value="<?php echo $_REQUEST['restaurant']; ?>" />

<div class="clear"></div>

<p>Your Website</p>

<input name="website" type="text" class="contactfield" value="<?php echo $_REQUEST['website']; ?>" />

<div class="clear"></div>

</div>

<div class="clear"></div>

<div class="select_area_content">

<div class="select_area_top">

<h1>So what can we help you with?</h1>

</div>

<div class="select_area_bottom">

<p>Select a subject</p>

<select name="subject" class="selectarea_box" id="selectarea_box" onChange="getsubject(this.value);">
<option value="">-- Select a subject --</option>
<?php $sql_select = mysql_query("SELECT * FROM  restaurant_subject  WHERE id!=''");
while($array_select = mysql_fetch_array($sql_select)){?>
<option value="<?php echo $array_select['id'];?>" <?php echo ($_REQUEST['subject']==$array_select['subject']) ? 'selected' : '' ; ?> ><?php echo $array_select['subject'];?></option>

<?php } ?>
<!--<option value="1" <?php echo ($_REQUEST['subject']=='1') ? 'selected' : '' ; ?> >Registration Request</option>
<option value="2" <?php echo ($_REQUEST['subject']=='2') ? 'selected' : '' ; ?> >General Enquiry</option>
<option value="3" <?php echo ($_REQUEST['subject']=='3') ? 'selected' : '' ; ?>>Grievance</option>-->

</select>

<div class="clear"></div>

<p>Select a category</p>

<div id="res_reqst_cat">
<select name="sub_category" id="sub_category" class="selectarea_box">
<option value="">-- Select Category --</option>
</select>

<?php /*?><select name="category" class="selectarea_box">

<?php $sql_select = mysql_query("SELECT * FROM  restaurant_contact_category  WHERE id!=''");
while($array_select = mysql_fetch_array($sql_select)){?>
<option value="<?php echo $array_select['contact_category'];?>" <?php echo ($_REQUEST['category']==$array_select['contact_category']) ? 'selected' : '' ; ?> ><?php echo $array_select['contact_category'];?></option>

<?php } ?>
</select><?php */?>
    <!--<option value="1" <?php echo ($_REQUEST['category']=='1') ? 'selected' : '' ; ?> >Register my restaurant</option>
    <option value="2" <?php echo ($_REQUEST['category']=='2') ? 'selected' : '' ; ?>>Register as a vendor</option>-->

</div>

<div class="clear"></div>

<div class="select_textfield">

<p>Your Message (*)</p>

<textarea name="message" id="message" cols="" rows="" class="contactarea"><?php echo $_REQUEST['message']; ?></textarea>

<div class="clear"></div>

<h3><input name="terms" id="terms" type="checkbox" value="1" <?php echo ($_REQUEST['terms']=='1')? 'checked' :''; ?> class="select_check" /> <a href="terms.php" target="_blank">Agree to Food and Menus Terms </a></h3>

<div class="clear"></div>

<p>Captcha (*)</p>

<?php //echo recaptcha_get_html($publickey); ?>

<img src="captcha_code_file.php?rand=<?php echo $_SESSION['6_letters_code'];?>" id='captchaimg' style="margin-left:15px;"><br>
<p style="width:245px;">Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</p><br>

<p style="margin-left:-270px;"><input name="captcha_code" id="captcha_code" type="text" class="contactfield" value="<?php echo $_REQUEST['captcha_code']; ?>" /></p>

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

<?php $sql_contact = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_contact_info WHERE page_id = 1")); ?>

<div class="contact_right_middle">
<h1>Call us toll free at </h1>
<h2><?php echo $sql_contact['telephone'];?></h2>

<img src="images/mail.png"/>
<p>Mailing Address</p>

<div class="clear"></div>

<div style="color:#ffffff !important;"><?php echo htmlspecialchars_decode($sql_contact['address']);?></div>

<h3>Telephone:</h3>

<h4><?php echo $sql_contact['telephone'];?></h4>

<h3>Email:</h3>

<h5><?php echo $sql_contact['email'];?></h5>

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

<?php include("includes/footer_new.php");?>