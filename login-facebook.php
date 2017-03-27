<?php
session_start();
require 'facebook/facebook.php';
require 'config/fbconfig.php';
require 'config/functions.php';


$facebook = new Facebook(array(
  'appId'  => APP_ID,
  'secret' => APP_SECRET,
));



// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  //$logoutUrl = $facebook->getLogoutUrl();
  
if (!empty($user_profile)) {
	# User info ok? Let's print it (Here we will be adding the login and registering routines)
	/*echo '<pre>';
	print_r($user_profile);
	echo '</pre><br/>';
	exit;*/
	
	$firstname = $user_profile['first_name'];
	$lastname = $user_profile['last_name'];
	$gender = $user_profile['gender'];
	
	$user_profile = new User();
	$userdata = $user_profile->checkUser($user, 'facebook', $firstname, $lastname);
	/*print_r($userdata);
	exit;*/
	if(!empty($userdata)){
		$_SESSION['customer_id'] = $userdata['id'];
		$_SESSION['oauth_id'] = $user;
		$_SESSION['username'] = $userdata['name'];
		$_SESSION['oauth_provider'] = $userdata['oauth_provider'];
		//header("Location: home.php");
		echo '<script language="javascript">window.location="http://www.foodandmenu.com/index.php";</script>';
		exit;
	}
}
  /*echo '<script language="javascript">window.location="http://www.readysolution.info/toucan/customer/customer_detailpage.php";</script>';*/
} else {
  $loginUrl = $facebook->getLoginUrl();
  header("Location: " . $loginUrl);
  exit;
}

// This call will always work since we are fetching public data.
//$naitik = $facebook->api('/');
