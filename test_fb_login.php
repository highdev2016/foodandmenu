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

//var city = allDetails.city;
var city = allDetails.location.name;
var link_var = allDetails.link;

//alert(city);
alert(city);

/*$.ajax({

	url : 'fb_login.php',

	type : 'POST',

	data : 'id=' + id + '&email=' + email + '&first_name=' + first_name + '&last_name=' + last_name + '&gender=' + gender + '&link_var=' + link_var,

	beforeSend : function(jqXHR, settings ){

	},

	success : function( data, textStatus, jqXHR){
		//alert(data);
		window.location.href = 'https://foodandmenu.com/home.php';

	},

	error : function( jqXHR, textStatus, errorThrown){

	}

});*/
	
console.log('Successful login for: ' + response.name);
document.getElementById('status').innerHTML =
'Thanks for logging in, ' + response.name + '!';

});
}
checkLoginState();
function logout(){
	FB.logout(function(response) {
			// Person is now logged out
			window.location.href = 'https://foodandmenu.com/home.php';
		});
 }
 

</script>

<fb:login-button scope="public_profile,email,user_location" onlogin="checkLoginState();">
</fb:login-button>