<?php /*?><?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
require_once 'src/apiClient.php';
require_once 'src/contrib/apiPlusService.php';

session_start();

$client = new apiClient();
$client->setApplicationName("Food and Menu");
$client->setScopes(array('https://www.googleapis.com/auth/plus.me'));
$plus = new apiPlusService($client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}

if ($client->getAccessToken()) {
  $me = $plus->people->get('me');

  $optParams = array('maxResults' => 100);
  $activities = $plus->activities->listActivities('me', 'public',$optParams);

  // The access token may have been updated lazily.
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
?>
<div>
 <?php if(isset($me))
 { 
 
 $_SESSION['gplusdata']=$me;
  header("location: home.php");
 
 } ?>

<?php
  if(isset($authUrl)) {
    print "<a class='login' href='$authUrl'>Google Plus Login </a>";
  } else {
   print "<a class='logout' href='index.php?logout'>Logout</a>";
  }
?><br/>
</div>

<?php */?>
<?php
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_PlusService.php';

// Set your cached access token. Remember to replace $_SESSION with a
// real database or memcached.
session_start();

$client = new Google_Client();
$client->setApplicationName('Google+ PHP Starter Application');
// Visit https://code.google.com/apis/console?api=plus to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId(/*'insert_your_oauth2_client_id'*/'24225774119-dqrmnt8qeqd7v47m6nf3nd9k1s291u93.apps.googleusercontent.com');
$client->setClientSecret(/*'insert_your_oauth2_client_secret'*/'RORmrtzI6swq3rZuKzg5bqKc');
$client->setRedirectUri(/*'insert_your_oauth2_redirect_uri'*/'http://www.foodandmenu.com/gplus/home.php');
$client->setDeveloperKey(/*'insert_your_simple_api_key'*/'AIzaSyBgsEfIyprHMgX6jY3urjMsbehoOVLjSg0');
$plus = new Google_PlusService($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $activities = $plus->activities->listActivities('me', 'public');
  print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';

  // We're not done yet. Remember to update the cached access token.
  // Remember to replace $_SESSION with a real database or memcached.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a href='$authUrl'>Connect Me!</a>";
}




