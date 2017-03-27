<?php 
include ("admin/lib/conn.php");

if(isset($_REQUEST['submit'])){
	
	$sep = '';
	foreach($_REQUEST['looking_for'] as $val){
		$looking_for = $looking_for.$sep.$val;
		$sep = ",";
	}
	
	$dob_date = substr($_REQUEST['dob_of_birth'], 3,2);
	$dob_month = substr($_REQUEST['dob_of_birth'], 0,2);
	$dob_year = substr($_REQUEST['dob_of_birth'], 6,4);
	
	$date_of_birth = $dob_year."-".$dob_month."-".$dob_date;
	
	
	$sql_select_customer = mysql_query("SELECT * FROM restaurant_customer WHERE email = '".$_REQUEST['email']."'");
	$num_row = mysql_num_rows($sql_select_customer);
	if($num_row == 0){
		$sql_insert = mysql_query("INSERT INTO restaurant_customer SET firstname = '".$_REQUEST['firstname']."',lastname = '".$_REQUEST['lastname']."',email = '".$_REQUEST['email']."',password = '".md5($_REQUEST['password'])."',registration_time=NOW(), date_of_birth = '".$date_of_birth."' , gender = '".$_REQUEST['gender']."' , looking_for = '".$looking_for."' , relationship_status = '".$_REQUEST['relationship_status']."',address = '".$_REQUEST['address']."',phone = '".$_REQUEST['phone']."',city = '".$_REQUEST['city']."',state = '".$_REQUEST['state']."',zip = '".$_REQUEST['zip']."' , home_apartment = '".$_REQUEST['apart']."' , information = '".$_REQUEST['information']."' , apt_name = '".$_REQUEST['apt_name']."' , apt_no = '".$_REQUEST['apt_no']."' ");
		$customer_id = mysql_insert_id();
		
		if($_REQUEST['subscribe'] == 1){
			$sql_select_subscriber = mysql_num_rows(mysql_query("SELECT * FROM restaurant_subscriber WHERE email = '".$_REQUEST['email']."'"));
			if($sql_select_subscriber == 0){
				$sql_insert_newsletter_subscriber = mysql_query("INSERT INTO restaurant_subscriber SET email = '".$_REQUEST['email']."' , status = 1");
			}
		}
		
		
		
		if($sql_insert){
			/********************************** Customer ***************************************/
			$site_url="https://". $_SERVER['HTTP_HOST'] ."";

			$email = $_POST['email'];//"priya@infosolz.com"
			
			$name = $_POST['firstname']." ".$_POST['lastname'];
			
			$url="<a href='$site_url/account_verification.php?id=".$customer_id."' target='_blank'>$site_url/AccountVerificationEmail" ."</a>";
			
			/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
			
						<div style="margin:0 auto;width:700px;clear:both;">
			
						<div style="background-color:#3F4CA0; height:30px;"></div>
			
						<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">
			
						<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />
			
						</div>
			
						<div style="width:100%; float:left;">
			
						<div style="clear:both;"></div>
			
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$name.',</p>
			
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
			
				</div>';*/
			
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 1"));	
			
			$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
			
			$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
			$cms_rep=str_replace('%%$activationlink%%',$url,$cms_rep);
			
			$from = "support@foodandmenu.com";
			
			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
			
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
			
			$message=$cms_rep;
			
			//$subject="Account activation";
			
			$subject = stripslashes($sql_cms['subject']);
			
			mail($email,$subject,$message,$headers);
			
			
			
			/************************************ Admin ***************************************/
	
			$sql_cms1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 2"));
			
			$admin_email_address = $sql_cms1['email_address'];
			
			$arr_email_address = explode(",",$admin_email_address);
			
			//$email = "priya@infosolz.com";//support@foodandmenu.com

			$name = "Admin";
			
			$customer_name = $_REQUEST['firstname'].' '.$_REQUEST['lastname'];
			$customer_email = $_REQUEST['email'];
			$customer_dob = $_REQUEST['dob_of_birth'];
			
			/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$name.',</p>

            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">A customer has registered at Food & menu </p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">The details of the customer is given below : </p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> Name : '.$_REQUEST['firstname'].' '.$_REQUEST['lastname'].' </p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> Email : '.$_REQUEST['email'].' </p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> Date of Birth : '.$_REQUEST['dob_of_birth'].' </p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> Gender : '.$_REQUEST['gender'].' </p>
							
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
				
			$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms1['description']));
			
			$cms_rep = str_replace('%%$name%%',$name,$cms_rep);
			$cms_rep = str_replace('%%$customer_name%%',$customer_name,$cms_rep);
			$cms_rep = str_replace('%%$customer_email%%',$customer_email,$cms_rep);
			$cms_rep = str_replace('%%$customer_dob%%',$customer_dob,$cms_rep);
			
			$from = $_POST['email'];

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message=$cms_rep;

			$subject = stripslashes($sql_cms1['subject']);

			foreach($arr_email_address as $val_email){
				mail($val_email,$subject,$message,$headers);
			}
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
<?php include ("includes/header_inner_new.php");?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js" type="text/javascript"></script>
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
	if(document.frm.address.value == ''){
		alert("Please enter address.");
		document.frm.address.focus();	
		return false;	
	}
	if(document.frm.city.value == ''){
		alert("Please enter city.");
		document.frm.city.focus();	
		return false;	
	}
	if(document.frm.state.value == ''){
		alert("Please enter state.");
		document.frm.state.focus();	
		return false;	
	}
	if(document.frm.zip.value == ''){
		alert("Please enter zip.");
		document.frm.zip.focus();	
		return false;	
	}
	if(document.frm.phone.value == ''){
		alert("Please enter phone.");
		document.frm.phone.focus();	
		return false;	
	}
	/*if(document.getElementById("male").checked==false && document.getElementById("female").checked==false){
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
	}*/
	return true;
}

function get_city(state){
	//alert(state);
	$.ajax({
		url : 'get_distinct_city.php',
		type : 'POST',
		data : 'state=' + state,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('city').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});

}
</script>

<?php /*?><link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script><?php */?>

<link rel="stylesheet" href="../calender/jquery-ui.css" />
<script src="../calender/jquery-1.8.3.js"></script>
<script src="../calender/jquery-ui.js"></script>

<script>
var $j = jQuery.noConflict();
  $j(function() {
    $j( "#datepicker" ).datepicker(
	{dateFormat: 'mm-dd-yy',

  changeDate: true,

  changeMonth: true,

  changeYear: true,
  
  yearRange: "-90:+0",

  showButtonPanel: true });
  });
  
  
</script>
<script type="text/javascript">
function show_div(val)
  {
	  var $j = jQuery.noConflict();
	  
	  if(val == "others")
	  {
		  $j("#apt_name").val('');
		  $j("#apt_no").val('');
		  $j("#apt_div").slideUp(1000);
		  $j("#info_div").slideDown(1000);
		  
	  }
	  if(val == "apartment")
	  {
		  $j("#information").val('');
		  $j("#info_div").slideUp(1000);
		  $j("#apt_div").slideDown(1000);
	  }
	  if(val == "home")
	  {
		  $j("#apt_name").val('');
		  $j("#apt_no").val('');
		  $j("#information").val('');
		  $j("#info_div").slideUp(1000);
		  $j("#apt_div").slideUp(1000);
	  }
  }
</script>

<body class="login_bg">

<div class="body_section">
<div class="login_wrapper">

<div class="container">
<div class="login_body">

<div class="login_body_cont">

<div class="registration_logo_section">
<?php /*?><?php if($_SESSION['city'])
{
?>
<a href="home.php?city=<?php echo $_SESSION['city']?>"><img src="images/logo.png" /></a>
<?php
}
else{
?><?php */?>
<a href="index.php"><img src="images/logo1.png" /></a>
<?php /*?><?php
}
?><?php */?>
<h1>Eat Smart…Order Online !</h1>
<div class="clear"></div>
</div>

<div class="registration_section">

<div class="registration_left reg_left_nw">

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
<input name="dob_of_birth" id="datepicker" type="text" class="regifield"  value="<?php echo $_POST['dob_of_birth']; ?>"/>

<div class="clear"></div>


<p>Phone Number * : </p>
<input name="phone" type="text" class="regifield" value="" onKeyPress="return goodchars(event,'1234567890+-');"/>

<div class="clear"></div>

</div>

<div class="clear"></div>


</div>

</div>



<div class="registration_right reg_right_nw">
<div class="regi_sign_up_two">

<div class="regi_left_top" style="margin-top:55px;">

</div>

<div class="regi_field_section">

<?php /*?><p>Gender * : </p>
<p class="gender_radion">
<span class="radio_left_gen"><input type="radio" id="male" name="gender" value="male"  <?php if($_POST['gender'] == 'male'){ ?> checked="checked" <?php } ?>  /></span>
<span class="gender_cls">Male</span>
<span class="radio_left_gen"><input type="radio" id="female" name="gender" value="female"  <?php if($_POST['gender'] == 'female'){ ?> checked="checked" <?php } ?>  /></span><span class="gender_cls">Female</span>
<div class="clear"></div>
</p>

<div class="clear"></div>

<p>Looking For * : </p>
<p class="gender_radion">
<span class="radio_left_gen"><input type="checkbox" name="looking_for[]" value="friends" id="friends" <?php if(in_array("friends", $_POST['looking_for'])){?> checked="checked" <?php } ?> /></span>
<span class="gender_cls">Friends</span>
<span class="radio_left_gen"><input type="checkbox" name="looking_for[]" value="dating" id="dating" <?php if(in_array("dating", $_POST['looking_for'])){?> checked="checked" <?php } ?> /></span>
<span class="gender_cls">Dating</span>
<span class="radio_left_gen"><input type="checkbox" name="looking_for[]" value="relationship" id="relationship" <?php if(in_array("relationship", $_POST['looking_for'])){?> checked="checked" <?php } ?> /></span>
<span class="gender_cls">A Relationship</span>
<span class="radio_left_gen"><input type="checkbox" name="looking_for[]" value="networking" id="networking" <?php if(in_array("networking", $_POST['looking_for'])){?> checked="checked" <?php } ?> /></span>
<span class="gender_cls">Networking</span>
<div class="clear"></div>
</p>
<div class="clear"></div>

<p>Relationship Status * : </p>
<select name="relationship_status" class="sel_cls">
<option value="">Select</option>
<option value="single" <?php if($_POST['relationship_status'] == 'single'){?> selected="selected" <?php } ?>>Single</option>
<option value="in_a_relation" <?php if($_POST['relationship_status'] == 'in_a_relation'){?> selected="selected" <?php } ?>>In a Relationship</option>
<option value="engaged" <?php if($_POST['relationship_status'] == 'engaged'){?> selected="selected" <?php } ?>>Engaged</option>
<option value="married" <?php if($_POST['relationship_status'] == 'married'){?> selected="selected" <?php } ?>>Married</option>
<option value="widowed" <?php if($_POST['relationship_status'] == 'widowed'){?> selected="selected" <?php } ?>>Widowed</option>
<option value="separated" <?php if($_POST['relationship_status'] == 'separated'){?> selected="selected" <?php } ?>>Separated</option>
<option value="divorced" <?php if($_POST['relationship_status'] == 'divorced'){?> selected="selected" <?php } ?>>Divorced</option>
</select>
<div class="clear"></div><?php */?>

<p>Address * : </p>
<input name="address" type="text" class="regifield"  value=""/>

<div class="clear"></div>

<p>State * : </p>
<select name="state" class="sel_cls" onChange="return get_city(this.value);">
<option value="">Select</option>
<?php $sql_get_state = mysql_query("SELECT DISTINCT(state) FROM restaurant_city_state WHERE 1 ORDER BY state");
while($array_state = mysql_fetch_array($sql_get_state)){ ?>
<option value="<?php echo $array_state['state']; ?>"><?php echo $array_state['state']; ?></option>
<?php } ?>
</select>
<div class="clear"></div>

<p>City * : </p>
<select name="city" id="city" class="sel_cls" >
<option value="">Select</option>
</select>


<div class="clear"></div>



<p>Zip * : </p>
<input name="zip" type="text" class="regifield"  value="" onKeyPress="return goodchars(event,'1234567890');"/>

<div class="clear"></div>

<p>Home/Apartment * : </p>
<select name="apart" id="apart" class="sel_cls" onChange="show_div(this.value);">
<option value="">---Select---</option>
<option value="home">Home</option>
<option value="apartment">Apartment</option>
<option value="others">Others</option>
</select>

<div class="clear"></div>

<div id="apt_div" style="display:none;">
<p>Apartment Name</p>
<input name="apt_name" type="text" id="apt_name" class="regifield"  value="" style=""  />

<div class="clear"></div>

<p>Apartment Number</p>
<input name="apt_no" type="text" id="apt_no" class="regifield"  value="" style=""  /> 
</div>
<div class="clear"></div>

<div id="info_div" style="display:none;">
<p>Information</p>
<input name="information" type="information" id="information" class="regifield"  value=""  />
</div>
<div class="clear"></div>

<p class="subscribe_reg">Subscribe for Food and Menu Newsletter : 
<input type="checkbox" name="subscribe" id="subscribe" value="1"  checked="checked" /></p>

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

<?php //include ("includes/sign_up_right.php");?>



</div>

<div class="clear"></div>
</form>
</div>

</div>

</div>

<?php /*?><div class="body_footer_bg"></div><?php */?>


<div class="clear"></div>
</div>
</div>

</div>
<?php include ("includes/footer_new.php"); ?>
</body>
</html>
