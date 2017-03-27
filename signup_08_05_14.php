<?php 
include ("admin/lib/conn.php");

if(isset($_REQUEST['submit'])){
	$sql_select_customer = mysql_query("SELECT * FROM restaurant_customer WHERE email = '".$_REQUEST['email']."'");
	$num_row = mysql_num_rows($sql_select_customer);
	if($num_row == 0){
		$sql_insert = mysql_query("INSERT INTO restaurant_customer SET firstname = '".$_REQUEST['firstname']."',lastname = '".$_REQUEST['lastname']."',email = '".$_REQUEST['email']."',password = '".md5($_REQUEST['password'])."',registration_time=NOW()");
		$customer_id = mysql_insert_id();
		
		if($sql_insert){
			
			$site_url="http://". $_SERVER['HTTP_HOST'] ."";

			$email=$_POST['email'];

			$name=$_POST['firstname'];

		    $url="<a href='$site_url/account_verification.php?id=".$customer_id."' target='_blank'>$site_url/AccountVerificationEmail" ."</a>";

			$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hey '.$name.',</p>

            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Thanks for taking the time to check out Food & menu</p>

                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Please click on the link below to activate your account</p>

             			<div style="clear:both;"></div>

						<h2 style="color:#fff; font:bold 15px/30px Arial, Helvetica, sans-serif; background-color:#3F4CA0; padding:0 0 0 14px; text-transform:uppercase;">Activation Link :</h2>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#04303d; margin:0 0 4px 15px;">'.$url.'</p>

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

			$from = "support@foodandmenu.com";

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message=$cms_rep;

			$subject="Account activation";

			mail($email,$subject,$message,$headers);

			$success = 1;
			
			header("location:account_activation.php");

		}
	}
	else {
		$error = 1;
	}
}
?>
<?php include ("includes/reg_header.php");?>

<script type="text/javascript">
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
	if(document.frm.firstname.value == ''){
		alert("Please enter firstname");
		document.frm.firstname.focus();	
		return false;	
	}
	if(document.frm.lastname.value == ''){
		alert("Please enter lastname");
		document.frm.lastname.focus();
		return false;		
	}
	if(document.frm.email.value == ''){
		alert("Please enter email");
		document.frm.email.focus();	
		return false;	
	}
	if ((document.frm.email.value!="") && (checkMessenger(document.frm.email.value)==false))
	{
	document.frm.email.value="";
	document.frm.email.focus();
	return false;
	}
	if(document.frm.password.value == ''){
		alert("Please enter password");
		document.frm.password.focus();	
		return false;	
	}
	if(document.frm.password.value.length<6){
		alert("Password should be atleast 6 characters in length");
		document.frm.password.focus();	
		return false;	
	}
	if(document.frm.confirm_password.value == ''){
		alert("Please enter confirmed password");
		document.frm.confirm_password.focus();	
		return false;	
	}
	if(document.frm.password.value!=document.frm.confirm_password.value){
		alert("Password Mismatch");
		document.frm.confirm_password.value = '';
		document.frm.confirm_password.focus();
		return false;	
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
	if(document.getElementById("male").checked==false && document.getElementById("female").checked==false){
		alert("Please Select Gender.");
		return false;
	}
	if(document.getElementById("friends").checked==false && document.getElementById("dating").checked==false && document.getElementById("relationship").checked==false &&  document.getElementById("networking").checked==false){
		alert('Please Select Looking for.');
		return false;
	}
	if(document.frm.relationship_status.value == ''){
		alert("Please enter relationship status.");
		document.frm.relationship_status.focus();	
		return false;	
	}
	return true;
}
</script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

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

<body class="login_bg">

<div class="body_section">
<div class="login_wrapper">

<div class="login_container">
<div class="login_body">

<div class="login_body_cont">

<div class="registration_logo_section">
<?php if($_SESSION['city'])
{
?>
<a href="home.php?city=<?php echo $_SESSION['city']?>"><img src="images/logo.png" width="216" height="99" /></a>
<?php
}
else{
	?>
<a href="home.php"><img src="images/logo.png" width="216" height="99" /></a>
<?php
}
?>
</div>

<div class="registration_section">

<div class="registration_left">

<div class="regi_sign_up">

<div class="regi_left_top">

<h1>Create an Account </h1>
</div>

<form name="frm" method="post" action="" onSubmit="return valid();">
<div class="regi_field_section">
<?php if($success == 1) {?>
<p style="color:#404CA1; margin-bottom:5px;">Your registration process is completed successfully.Please check your mail to activate your account.</p>
<?php } else if($error == 1){ ?>
<p style="color:red; margin-bottom:5px;">The email address already exists in our system</p>
<?php }?>
<div class="first_name">
<p>First Name * :</p>
<input name="firstname" type="text" class="signupfield" value="<?php echo $_POST['firstname']?>" />
</div>

<div class="first_name">
<p>Last Name * :</p>
<input name="lastname" type="text" class="signupfield"  value="<?php echo $_POST['lastname']?>"/>
</div>

<div class="clear"></div>

<p>Email Address * : </p>
<input name="email" type="text" class="regifield"  value="<?php echo $_POST['email']?>"/>

<div class="clear"></div>

<p>Password * : </p>
<input name="password" type="password" class="regifield" />

<div class="clear"></div>

<p>Password Confirmation * : </p>
<input name="confirm_password" type="password" class="regifield" />

<div class="clear"></div>

<p>Date of Birth * : </p>
<input name="dob_of_birth" id="datepicker" type="text" class="regifield"  value="<?php echo $_POST['dob_of_birth']?>"/>

<div class="clear"></div>

</div>

<div class="clear"></div>


</div>

</div>

<?php /*?><?php include ("includes/sign_up_right.php");?><?php */?>

<div class="registration_right">
<div class="regi_sign_up_two">

<div class="regi_left_top" style="margin-top:55px;">

</div>

<div class="regi_field_section">

<p>Gender * : 
<input type="radio" id="male" name="gender" value="male" style="margin-left:20px;" /><span class="gender_cls">Male</span>
<input type="radio" id="female" name="gender" value="female" /><span class="gender_cls">Female</span></p>

<div class="clear"></div>

<p>Looking For * : 
<input type="checkbox" name="looking_for" value="friends" id="friends" /><span class="gender_cls">Friends</span>
<input type="checkbox" name="looking_for" value="dating" id="dating" /><span class="gender_cls">Dating</span>
<input type="checkbox" name="looking_for" value="relationship" id="relationship" /><span class="gender_cls">A Relationship</span>
<input type="checkbox" name="looking_for" value="networking" id="networking" /><span class="gender_cls">Networking</span></p>

<div class="clear"></div>

<p>Relationship Status * : </p>
<select name="relationship_status" class="sel_cls">
<option value="">Select</option>
<option value="single">Single</option>
<option value="in_a_relation">In a Relationship</option>
<option value="engaged">Engaged</option>
<option value="married">Married</option>
<option value="widowed">Widowed</option>
<option value="separated">Separated</option>
<option value="divorced">Divorced</option>
</select>
<div class="clear"></div>

<p>Subscribe for Food and Menu Newsletter : 
<input type="checkbox" name="subscribe" id="subscribe" value="1" /></p>

<div class="clear"></div>

<div class="regi_login">

<div class="submit_button_left">

<input class="signupbutton" type="button" value="Back" name="name" onClick="history.back();">

</div>

<div class="submit_button_left">

<input class="signupbutton_two" type="submit" value="Sign up" name="submit">

</div>
<div class="clear"></div>
<div class="submit_text"><p>By registering you agree to the <a href="terms.php">Terms and Conditions</a> and <a href="privacy.php">Privacy Policy</a>. </p></div>

</div>


</div>

</div>
</div>

<div class="clear"></div>
</form>
</div>

</div>

</div>

<div class="body_footer_bg"></div>

<div class="clear"></div>
</div>
</div>

</div>

</body>
</html>
