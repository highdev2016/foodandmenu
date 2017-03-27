<?php 
ob_start();
session_start();
include ("includes/header.php");
include("admin/lib/conn.php");
include("includes/functions.php");

?>

<?php 
if(isset($_REQUEST['submit'])){
	$password = md5($_REQUEST['password']);
	$email = $_REQUEST['email'];
	$sql_customer = mysql_query("SELECT * FROM  restaurant_customer WHERE email = '".$email."' AND password = '".$password."' AND status = 1");
	$row = mysql_fetch_array($sql_customer);
	if(mysql_num_rows($sql_customer) > 0 && $row['account_disabled'] == 0){
		if($_REQUEST['checkbox'] == 1){
		$expire=time()+60*60*24*30;
		setcookie("customer_id", $row['id'], $expire); }
		$_SESSION['customer_id'] = $row['id'];
		$sql_update_login_time = mysql_query("UPDATE restaurant_customer SET last_logged_in = NOW() WHERE id = '".$_SESSION['customer_id']."'");
		if($_REQUEST['rev']==1){
			header("location:write_review.php?id=".$_SESSION['resttid']."&deal_id=".$_SESSION['deal_id']."");	
		}
		else if($_REQUEST['coupon'] == '1'){
			header("location:restaurant.php?id=".$_REQUEST['restaurant_id']."");
		}
		else if($_REQUEST['type'] == 'del'){
			header("location:check_out.php?type=del");
		}
		else if($_REQUEST['user_id']!=''){
			header("location:user.php?id=".$_REQUEST['user_id']."");
		}
		else if($_REQUEST['reservation'] == 1){
			header("location:reservation.php?id=".$_SESSION['resttid']."");	
		}
		else if($_REQUEST['checkout_type'] == 'pickup'){
			header("location:check_out.php?type=pickup");	
		}
		else if($_REQUEST['checkout_type'] == 'del'){
			header("location:check_out.php?type=del");	
		}
		else if(isset($_SESSION['resttid'])){
			header("location:restaurant.php?id=".$_SESSION['resttid']."&deal_id=".$_SESSION['deal_id']."");	
		}
		else if(isset($_SESSION['address'])){
			header("location:search_result.php");
		}
		else if($_REQUEST['vendor'] == 1){
			header("location:vendor.php");
		}
		else{
		header("location:index.php");
		}
	}
	else if(mysql_num_rows($sql_customer) > 0 && $row['account_disabled'] == 1){
		$error = 2;
	}
	else{
		$error = 1;
	}
}
?>

<?php include ("includes/reg_header.php");
 ?>
 <?php include ("includes/header_inner_new.php"); ?>

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
	return true;
}
</script>

<style type="text/css">

.stick_header{
	position: relative;
}

.header_back{
	height: 80px;
}

</style>

<body class="login_bg">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<script>

window.fbAsyncInit = function() {
	FB.init({
	appId      : '646665315362675',
	cookie     : true,  // enable cookies to allow the server to access 
						// the session
	xfbml      : true,  // parse social plugins on this page
	version    : 'v2.1' // use version 2.1
	});
	
	// Now that we've initialized the JavaScript SDK, we call 
	// FB.getLoginStatus().  This function gets the state of the
	// person visiting this page and can return one of three states to
	// the callback you provide.  They can be:
	//
	// 1. Logged into your app ('connected')
	// 2. Logged into Facebook, but not your app ('not_authorized')
	// 3. Not logged into Facebook and can't tell if they are logged into
	//    your app or not.
	//
	// These three cases are handled in the callback function.
	
	/*FB.getLoginStatus(function(response) {
	statusChangeCallback(response);
	});*/

};

function login() {
	FB.login(function(response) {
	  if (response.authResponse) {
		testAPI() ;
	  } else {
		// cancelled
	  }
	},{'scope':'email,user_location,user_hometown'});
}
  
// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
	console.log('statusChangeCallback');
	console.log(response);
	// The response object is returned with a status field that lets the
	// app know the current login status of the person.
	// Full docs on the response object can be found in the documentation
	// for FB.getLoginStatus().
	if (response.status === 'connected') {
	  // Logged into your app and Facebook.
	  testAPI();
	} else if (response.status === 'not_authorized') {
	  // The person is logged into Facebook, but not your app.
	  //document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';
	  login();
	} else {
	  // The person is not logged into Facebook, so we're not sure if
	  // they are logged into this app or not.
	  //document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
	  login();
	}
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
	FB.getLoginStatus(function(response) {
	  statusChangeCallback(response);
	});
}



// Load the SDK asynchronously
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
console.log('Welcome!  Fetching your information.... ');
FB.api('/me', function(response) {
	
var allDetails = JSON.stringify(response);

allDetails = JSON.parse(allDetails);

//alert(allDetails);

var id = allDetails.id;

var email = allDetails.email;

var first_name = allDetails.first_name;

var last_name = allDetails.last_name;

var gender = allDetails.gender;

var location = allDetails.location.name;

var link_var = allDetails.link;


var city1 = location.split(","); 

var city = city1[0];

$.ajax({

	url : 'fb_login.php',

	type : 'POST',

	data : 'id=' + id + '&email=' + email + '&first_name=' + first_name + '&last_name=' + last_name + '&gender=' + gender + '&link_var=' + link_var + '&city=' + city ,

	beforeSend : function(jqXHR, settings ){

	},

	success : function( data, textStatus, jqXHR){
		//alert(data);
		window.location.href = 'https://foodandmenu.com/index.php';

	},

	error : function( jqXHR, textStatus, errorThrown){

	}

});
	
console.log('Successful login for: ' + response.name);
document.getElementById('status').innerHTML =
'Thanks for logging in, ' + response.name + '!';

});
}
checkLoginState();
function logout(){
	FB.logout(function(response) {
			// Person is now logged out
			window.location.href = 'https://foodandmenu.com/index.php';
		});
 }
</script>



<script type="text/javascript">
 
function logout_google_plus()
{
    gapi.auth.signOut();
    location.reload();
}
function login_google_plus() 
{
  var myParams = {
    'clientid' : '649462469914-3qle67l5mk2br8nfflo9hfirkig717q2.apps.googleusercontent.com',
    'cookiepolicy' : 'single_host_origin',
    'callback' : 'loginCallback',
    'approvalprompt':'force',
    'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
  };
  gapi.auth.signIn(myParams);
}
 
function loginCallback(result)
{
    if(result['status']['signed_in'])
    {
        var request = gapi.client.plus.people.get(
        {
            'userId': 'me'
        });
        request.execute(function (resp)
        {
            var email = '';
            if(resp['emails'])
            {
                for(i = 0; i < resp['emails'].length; i++)
                {
                    if(resp['emails'][i]['type'] == 'account')
                    {
                        email = resp['emails'][i]['value'];
                    }
                }
            }
					
			var  id = resp['id'];
			var  email = email;
			var  name = resp['displayName'].split(" "); 
			var  first_name = name[0];
			var  last_name = name[1];
			var  gender = resp['gender'];
					
			
			$.ajax({

				url : 'save_gplus_data.php',
			
				type : 'POST',
			
				data : 'id=' + id + '&email=' + email + '&first_name=' + first_name + '&last_name=' + last_name + '&gender=' + gender ,
			
				beforeSend : function(jqXHR, settings ){
			
				},
			
				success : function( data, textStatus, jqXHR){
					//alert(data);
					window.location.href = 'https://foodandmenu.com/index.php';
			
				},
			
				error : function( jqXHR, textStatus, errorThrown){
			
				}

			});
			
			
			
        });
 
    }
 
}
function onLoadCallback()
{
    gapi.client.setApiKey('AIzaSyBJgJZEMFFhon1qCXqtV9GUObComGgEDe4');
    gapi.client.load('plus', 'v1',function(){});
}
 
</script>

<script type="text/javascript">
      (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
</script>


<div class="body_section">
<div class="login_wrapper">

<div class="container">
<div class="login_body">

<div class="login_body_cont">

<div class="registration_logo_section">
<?php /*?><?php if($_SESSION['city'])
{
?>
<a href="index.php?city=<?php echo $_SESSION['city']?>"><img src="images/logo.png" /></a>
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

<div class="registration_left">

<div class="regi_sign_up">

<div class="regi_left_top">
<?php if($_REQUEST['changestatus']==""){?>
<h2>You must sign in to add your review</h2>
<?php } ?>
<h1>Log in</h1>
</div>

<form name="frm" method="post" action="" onSubmit="return valid();">
<div class="regi_field_section">
<?php if($error == 1){ ?>
<p class="req_succ_err" style="color:red; margin-bottom:5px;">The email address or password entered is not valid.</p>
<?php } ?>
<?php if($error == 2){ ?>
<p class="req_succ_err" style="color:red; margin-bottom:5px;">Your Account has been disabled.</p>
<?php } ?>
<?php if($_REQUEST['changestatus']==1){ ?>
<p class="req_succ_err" style="color:#788D23; margin-bottom:5px;">Your password is changed successfully</p>
<?php } ?>

<p>Email Address * : </p>
<input name="email" type="text" class="regifield" autocomplete="off" />

<div class="clear"></div>

<p>Password * :</p>
<input name="password" type="password" class="regifield" />

<div class="clear"></div>

<input name="checkbox" type="checkbox" value="1" class="regicheckbox" />
<p>Keep me logged in </p>

</div>

<div class="regi_login">

<input class="regibutton" type="submit" value="log in" name="submit">


<ul>
<li><a href="forgot_password.php">Forgot Password?</a></li>
<li>Not a member yet? <a href="signup.php">register for FREE.</a></li>
</ul>

</div>
</form>
</div>

</div>

<?php //include ("includes/sign_up_right.php");?>

<div class="registration_right">
<div class="regi_sign_up_two">

<h1>Connect with Facebook</h1>

<?php //if($_SESSION['customer_id'] == 0) { ?>

<!--<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>-->
<a href="javascript:void(0);" onClick="checkLoginState();"><img src="images/fb_connect.png" width="38" height="37" /></a>

<?php //} ?>
                         
<a href="javascript:void(0);" onClick="login_google_plus();"><img src="images/sign_up_with.png" width="38" height="37" /> </a>
<ul>
<li>We won't automatically post to your wall</li>
<li>One less password to remember</li>
</ul>

<img class="log-pic" src="images/cook.png">

</div>
</div>

<div class="clear"></div>

</div>

</div>

</div>

<?php /*?><div class="body_footer_bg"><?php */?>

<?php /*?></div><?php */?>

<div class="clear"></div>
</div>
</div>

</div>
<?php include ("includes/footer_new.php"); ?>

</body>
</html>

