
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login with Goolge Plus Javascript API</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link href="https://s3.amazonaws.com/hayageek/libs/jquery/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <script type="text/javascript">
(function(){
  var bsa = document.createElement('script');
     bsa.type = 'text/javascript';
     bsa.async = true;
     bsa.src = 'http://s3.buysellads.com/ac/bsa.js';
  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
})();
</script>  
  </head>

  <body>

 <!-- Navbar
    ================================================== -->
 <div class="navbar navbar-fixed-top">
   <div class="navbar-inner">
     <div class="container">
       <a rel="tooltip" title="Login with Goolge Plus Javascript API" class="brand" href="http://hayageek.com/login-with-google-plus-javascript-api/">Goto Article</a>
       <div class="nav-collapse collapse" id="main-menu">
        <ul class="nav" id="main-menu-left">
          <li><a rel="tooltip" href="http://hayageek.com" title="Hayageek.com Home Page">Home</a></li>
        </ul>
        <ul class="nav pull-right" id="main-menu-right" >
 <li style="margin-top:15px;margin-right:5px;"><form id="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
 <input type="hidden" name="cmd" value="_xclick"> 
 <input type="hidden" name="business" value="rskusuma@yahoo.com"> 
 <input type="hidden" name="item_name" value="Support Hayageek.com"> 
 <input type="hidden" name="buyer_credit_promo_code" value=""> 
 <input type="hidden" name="buyer_credit_product_category" value=""> 
 <input type="hidden" name="buyer_credit_shipping_method" value=""> 
 <input type="hidden" name="buyer_credit_user_address_change" value=""> 
 <input type="hidden" name="no_shipping" value="0"> 
 <input type="hidden" name="no_note" value="1"> 
 <input type="hidden" name="currency_code" value="USD"> 
 <input type="hidden" name="tax" value="0"> 
 <input type="hidden" name="lc" value="US"> 
 <input type="hidden" name="bn" value="PP-DonationsBF"> 
 <div><input id="butt" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"> </div>
</form>	</li>        
        <li style="margin-top:15px;margin-right:5px;"><div data-href="http://hayageek.com/login-with-google-plus-javascript-api/" class="fb-like" data-layout="button_count" data-send="false" data-show-faces="false" data-width="120"></div></li>
        <li  style="margin-top:15px;"><a data-url="http://hayageek.com/login-with-google-plus-javascript-api/" href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"></a></li>
        <li style="margin-top:15px;"><div data-href="http://hayageek.com/login-with-google-plus-javascript-api/" class="g-plusone" data-annotation="inline" data-size="medium" data-width="120"></div></li>
        <form class="navbar-search pull-left" method="GET" action="http://hayageek.com/search.php">
            <input type="text" size="30" class="search-query" placeholder="Search" name="q" />
          </form>
 
        </ul>
 
       </div>
     </div>
   </div>
 </div>
 
  <div class="container">


<!-- Masthead
================================================== -->
<br/><br/>

<section id="typography">
  <div class="page-header">
    <h2>Login with Goolge Plus Javascript API</h2>
</div>
  





<div class="row">
<div class="well">
<input class="btn btn-primary" type="button"  value="Login" onclick="login()" />
<div id="profile"></div>
<br>
<input class="btn btn-primary" type="button"  value="Logout" onclick="logout()" />


</div>
</div>
</section>

<div class="row">
<div class="well">
<b>Please Share it with your friends:</b><br/><br/>
<a data-url="http://hayageek.com/login-with-google-plus-javascript-api/" href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"></a>
<div data-href="http://hayageek.com/login-with-google-plus-javascript-api/" class="g-plusone" data-annotation="inline" data-size="medium" data-width="120"></div>
<div data-href="http://hayageek.com/login-with-google-plus-javascript-api/" class="fb-like" data-layout="button_count" data-send="false" data-show-faces="false" data-width="120"></div>
<br/>

<div class="g-person" data-width="450" data-href="//plus.google.com/118255177648356108079" data-layout="landscape" data-rel="author"></div>
<form id="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
 <input type="hidden" name="cmd" value="_xclick"> 
 <input type="hidden" name="business" value="rskusuma@yahoo.com"> 
 <input type="hidden" name="item_name" value="Support Hayageek.com"> 
 <input type="hidden" name="buyer_credit_promo_code" value=""> 
 <input type="hidden" name="buyer_credit_product_category" value=""> 
 <input type="hidden" name="buyer_credit_shipping_method" value=""> 
 <input type="hidden" name="buyer_credit_user_address_change" value=""> 
 <input type="hidden" name="no_shipping" value="0"> 
 <input type="hidden" name="no_note" value="1"> 
 <input type="hidden" name="currency_code" value="USD"> 
 <input type="hidden" name="tax" value="0"> 
 <input type="hidden" name="lc" value="US"> 
 <input type="hidden" name="bn" value="PP-DonationsBF"> 
 <div><input id="butt" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"> </div>
</form>	
</div>
</div>


     <!-- Footer
      ================================================== -->
      <hr>

      <footer id="footer">
        <p class="pull-right"><a href="#top">Back to top</a></p>
        <div class="links">
          <a href="http://hayageek.com" >Blog</a>
        </div>
      </footer>

    </div><!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script>

function loadSocial(){
	
		$.getScript('http://platform.twitter.com/widgets.js');
		 $.getScript("http://connect.facebook.net/en_US/all.js#xfbml=1", function () {
            FB.init({ status: true, cookie: true, xfbml: true });
        });
        $.getScript('https://apis.google.com/js/plusone.js',function()
        {
         	$(".g-plusone").each(function () {
        		    gapi.plusone.render($(this).get(0));
		        });
        });
	
}
	$(document).ready(function()
	{
		setTimeout( "loadSocial()",1000 );
		$('a[rel=tooltip]').tooltip({'placement': 'bottom'});
	});
</script>
<script src="https://s3.amazonaws.com/hayageek/libs/jquery/bootstrap.min.js"></script>

  </body>
</html>
<script type="text/javascript">

function logout()
{
	gapi.auth.signOut();
	location.reload();
}
function login() 
{
  var myParams = {
    'clientid' : '150002918248.apps.googleusercontent.com',
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

            var str = "Name:" + resp['displayName'] + "<br>";
            str += "Image:" + resp['image']['url'] + "<br>";
            str += "<img src='" + resp['image']['url'] + "' /><br>";

            str += "URL:" + resp['url'] + "<br>";
            str += "Email:" + email + "<br>";
            document.getElementById("profile").innerHTML = str;
        });

    }

}
function onLoadCallback()
{
	//gapi.client.setApiKey('AIzaSyADaEVdh1ER74i9H6LVAzRuxbodYiA6YZw');
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

</body>
</html>

