<?php
function main()
{
	include_once("image_file.php");
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
	{
		$sep = '';
		foreach($_REQUEST['looking_for'] as $val){
			$looking_for = $looking_for.$sep.$val;
			$sep = ",";
		}
		
		$dob_date = substr($_REQUEST['dob_of_birth'], 3,2);
		$dob_month = substr($_REQUEST['dob_of_birth'], 0,2);
		$dob_year = substr($_REQUEST['dob_of_birth'], 6,4);
		
		$date_of_birth = $dob_year."-".$dob_month."-".$dob_date;
		
	if($_FILES['image']['name']!="")
	    {
		$image=$_FILES['image']['name'];
	    $image=time().$image;
		if ((($_FILES["image"]["type"] == "image/gif")
		  || ($_FILES["image"]["type"] == "image/png")
		  || ($_FILES["image"]["type"] == "image/bmp")
		  || ($_FILES["image"]["type"] == "image/jpg")
		  || ($_FILES["image"]["type"] == "image/jpeg")
		  || ($_FILES["image"]["type"] == "image/pjpeg")))
		 {
			$picture_url="../thumb_images/".$image;
			LIB_StoreUploadImg($post_file_name="image"
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="70"
								,$file_to_copy_height="70"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
}
	}
		mysql_query("UPDATE restaurant_customer set firstname='".mysql_real_escape_string($_REQUEST['firstname'])."',lastname='".mysql_real_escape_string($_REQUEST['lastname'])."',email='".mysql_real_escape_string($_REQUEST['email'])."',status='".mysql_real_escape_string($_REQUEST['status'])."',address='".mysql_real_escape_string($_REQUEST['address'])."',phone='".mysql_real_escape_string($_REQUEST['phone_no'])."', date_of_birth = '".$date_of_birth."' , gender = '".$_REQUEST['gender']."' where id='".$_REQUEST['id']."' ");
		
		$sql_select_subscriber = mysql_num_rows(mysql_query("SELECT * FROM restaurant_subscriber WHERE email = '".$_REQUEST['hid_email']."'"));
		if($sql_select_subscriber == 1){
			if($_REQUEST['subscribe'] == 1){
				$sql_update = mysql_query("UPDATE restaurant_subscriber SET status = 1 WHERE email = '".$_REQUEST['hid_email']."'");
			}else{
				$sql_update = mysql_query("UPDATE restaurant_subscriber SET status = 0 WHERE email = '".$_REQUEST['hid_email']."'");
			}
		}
			
		if($image!=''){
		$sql_update_image = mysql_query("UPDATE restaurant_customer SET image = '".$image."' WHERE id = '".$_REQUEST['id']."'");
		}
		if($_REQUEST['password']!=''){
			
		 $sql_update = mysql_query("UPDATE restaurant_customer SET password = '".md5($_REQUEST['password'])."' WHERE id = '".$_REQUEST['id']."'");
		 
		 $sql_select = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_admin WHERE id = 1"));
		 
	
	/********************************************** Customer **********************************************/

	$email = $_REQUEST['email']; //"priya@infosolz.com"
	
	$name = $_REQUEST['firstname'].' '.$_REQUEST['lastname'];
	
	$password = $_REQUEST['password'];
	
	/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$_REQUEST['firstname'].',</p>

            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Your profile password for food & menu is Changed.
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">New Password : '.$_REQUEST['password'].'</p>

             			<div style="clear:both;"></div>

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

				</div>';*/
				
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 5"));	
			
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));	
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	
	$cms_rep=str_replace('%%$password%%',$password,$cms_rep);		
	
	$from = $sql_select['email_id'];
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	/*$subject = "Password Changed";*/
	
	$subject = stripslashes($sql_cms['subject']);
	
	mail($email,$subject,$message,$headers);
		 
	}
	header("location:manage_customer.php?success=3&page=".$_REQUEST['page']."");
	}
	
	$sql_banner=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id='".$_REQUEST['id']."'"));
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
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
function validate()
{
	if(document.getElementById('firstname').value=='')
	{
		alert ('Please enter firstname');
		document.getElementById('firstname').focus();
		return false;
	}
	if(document.getElementById('lastname').value=='')
	{
		alert ('Please enter lastname');
		document.getElementById('lastname').focus();
		return false;
	}
	if(document.getElementById('email').value=='')
	{
		alert ('Please enter email');
		document.getElementById('email').focus();
		return false;
	}
	if ((document.getElementById('email').value!="") && (checkMessenger(document.getElementById('email').value)==false))
	{
	document.getElementById('email').value="";
	document.getElementById('email').focus();
	return false;
	}
	if(document.getElementById('password').value!='')
	{
		if(document.getElementById('confirm_password').value=='')
		{
		alert ('Please enter confirm password');
		document.getElementById('confirm_password').focus();
		return false;
		}
		if(document.getElementById('password').value!=document.getElementById('confirm_password').value)
		{
		alert ('Password mismatch');
		document.getElementById('confirm_password').value = '';
		document.getElementById('confirm_password').focus();
		return false;
		}		
	}
	if(document.frm.dob_of_birth.value == ''){
		alert("Please enter date of birth.");
		document.frm.dob_of_birth.focus();	
		return false;	
	}
	if(document.getElementById("male").checked==false && document.getElementById("female").checked==false){
		alert("Please Select Gender.");
		return false;
	}
	/*if(document.getElementById("friends").checked==false && document.getElementById("dating").checked==false && document.getElementById("relationship").checked==false &&  document.getElementById("networking").checked==false){
		alert('Please Select Looking for.');
		return false;
	}
	if(document.frm.relationship_status.value == ''){
		alert("Please enter relationship status.");
		document.frm.relationship_status.focus();	
		return false;	
	}*/
    return true;
}
</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_customer.php?page=<?php echo $_REQUEST['page']?>";
}
</script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script>
  $(function() {
    $( "#datepicker" ).datepicker(
	{dateFormat: 'mm-dd-yy',

  changeDate: true,

  changeMonth: true,

  changeYear: true,
  
  yearRange: "-90:+0",

  showButtonPanel: true });
  });
</script>

<h2 style="background:#FA8730; color:#fff; padding:8px;">Edit Customer</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
<input type="hidden" name="hid_email" id="hid_email" value="<?php echo $sql_banner['email']; ?>" />
            	<table width="75%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Firstname <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="firstname" id="firstname" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo $sql_banner['firstname'];?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Lastname <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="lastname" id="lastname" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo $sql_banner['lastname'];?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Email <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="email" id="email" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo $sql_banner['email'];?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Address :</td>
    <td class="normaltext"><input name="address" id="address" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo $sql_banner['address'];?>" ></td>
  </tr>
  <tr>
    <td class="text1" align="right">Phone No. :</td>
    <td class="normaltext"><input name="phone_no" id="phone_no" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo $sql_banner['phone'];?>"  onKeyPress="return goodchars(event,'1234567890+-');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Upload Image :</td>
    <td class="normaltext"><input name="image" id="image" type="file" class="login_ipboxin" style="height:25px;" >
    <?php if($sql_banner['image']!=''){ ?>
    <img src="../thumb_images/<?php echo $sql_banner['image'];?>" />
    <?php } ?></td>
  </tr>
  <tr>
    <td class="text1" align="right">Password :</td>
    <td class="normaltext"><input name="password" id="password" type="password" class="login_ipboxin" style="height:25px;"  value="" ></td>
  </tr>
  <tr>
    <td class="text1" align="right">Confirm Password :</td>
    <td class="normaltext"><input name="confirm_password" id="confirm_password" type="password" class="login_ipboxin" style="height:25px;"  value="" ></td>
  </tr>
  <tr>
    <td class="text1" align="right">Status :</td>
    <td class="normaltext"><input type="checkbox" name="status" value="1" <?php if($sql_banner['status'] == 1){?> checked="checked" <?php } ?> /></td>
  </tr>
   <tr>
    <td class="text1" align="right">Date of Birth <font color="#FF0000">*</font> :</td>
    <td class="normaltext"><input name="dob_of_birth" id="datepicker" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo date("d-m-Y", strtotime($sql_banner['date_of_birth']));?>" ></td>
  </tr>
  <tr>
    <td class="text1" align="right">Gender <font color="#FF0000">*</font> :</td>
    <td class="normaltext"><input type="radio" id="male" name="gender" value="male"  <?php if($sql_banner['gender'] == 'male'){?> checked="checked" <?php } ?>/></span>
<span class="text1">Male</span>
<span class="radio_left_gen"><input type="radio" id="female" name="gender" value="female"   <?php if($sql_banner['gender'] == 'female'){?> checked="checked" <?php } ?>/></span><span class="text1">Female</span></td>
  </tr>
  
  <?php /*?><tr>
    <td class="text1" align="right">Looking For <font color="#FF0000">*</font> :</td>
    <?php $looking_for = explode(",",$sql_banner['looking_for']); ?>
    <td class="normaltext">
    <p class="gender_radion">
<span class="radio_left_gen"><input type="checkbox" name="looking_for[]" value="friends" id="friends" <?php if(in_array("friends", $looking_for)){?>  checked="checked" <?php } ?>/></span>
<span class="gender_cls">Friends</span>
<span class="radio_left_gen"><input type="checkbox" name="looking_for[]" value="dating" id="dating" <?php if(in_array("dating", $looking_for)){?>  checked="checked" <?php } ?>/></span>
<span class="gender_cls">Dating</span>
<span class="radio_left_gen"><input type="checkbox" name="looking_for[]" value="relationship" id="relationship" <?php if(in_array("relationship", $looking_for)){?>  checked="checked" <?php } ?>/></span>
<span class="gender_cls">A Relationship</span>
<span class="radio_left_gen"><input type="checkbox" name="looking_for[]" value="networking" id="networking" <?php if(in_array("networking", $looking_for)){?>  checked="checked" <?php } ?>/></span>
<span class="gender_cls">Networking</span>
<div class="clear"></div>
</p>
    </td>
  </tr><?php */?>
  <?php /*?><tr>
    <td class="text1" align="right">Relationship Status <font color="#FF0000">*</font> :</td>
    <td class="normaltext">
    <select name="relationship_status" class="select_box">
        <option value="">Select</option>
        <option value="single" <?php if($sql_banner['relationship_status'] == 'single'){?> selected="selected" <?php } ?>>Single</option>
        <option value="in_a_relation" <?php if($sql_banner['relationship_status'] == 'in_a_relation'){?> selected="selected" <?php } ?>>In a Relationship</option>
        <option value="engaged" <?php if($sql_banner['relationship_status'] == 'engaged'){?> selected="selected" <?php } ?>>Engaged</option>
        <option value="married" <?php if($sql_banner['relationship_status'] == 'married'){?> selected="selected" <?php } ?>>Married</option>
        <option value="widowed" <?php if($sql_banner['relationship_status'] == 'widowed'){?> selected="selected" <?php } ?>>Widowed</option>
        <option value="separated" <?php if($sql_banner['relationship_status'] == 'separated'){?> selected="selected" <?php } ?>>Separated</option>
        <option value="divorced" <?php if($sql_banner['relationship_status'] == 'divorced'){?> selected="selected" <?php } ?>>Divorced</option>
    </select></td>
  </tr><?php */?>
  
  <?php $sql_newsletter_subs = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_subscriber WHERE email = '".$sql_banner['email']."' ")); ?>
  
  <tr>
    <td class="text1" align="right">Subscribe for Food and Menu Newsletter :</td>
    <td class="normaltext">
    <input type="checkbox" name="subscribe" id="subscribe" value="1" <?php if($sql_newsletter_subs['status'] == 1){?> checked="checked" <?php } ?> />
    </td>
  </tr>
  
  
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Edit" class="normalbutton">
    <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"template_admin.php";
?>