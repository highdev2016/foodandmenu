<?php
include("../admin/lib/conn.php");
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
 */
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_PlusService.php';

session_start();

$client = new Google_Client();
$client->setApplicationName("Food and Menu");
// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
$client->setClientId('60990435655-ptr6dioe63q2ieflhnbgvkbp654t9op3.apps.googleusercontent.com');
$client->setClientSecret('kh2KJfxpD6rJSflZLYrjosrn');
$client->setRedirectUri('http://foodandmenu.com/gplus/');
$client->setDeveloperKey('AIzaSyDeHmAIwRMw5rm-wwlt2SimK-ngejYwlfw');
$plus = new Google_PlusService($client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}

if ($client->getAccessToken()) {
  $me = $plus->people->get('me');

  // These fields are currently filtered through the PHP sanitize filters.
  // See http://www.php.net/manual/en/filter.filters.sanitize.php
  $url = filter_var($me['url'], FILTER_VALIDATE_URL);
  $img = filter_var($me['image']['url'], FILTER_VALIDATE_URL);
  $name = filter_var($me['displayName'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
  $personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";

  $optParams = array('maxResults' => 100);
  $activities = $plus->activities->listActivities('me', 'public', $optParams);
  $activityMarkup = '';
  foreach($activities['items'] as $activity) {
    // These fields are currently filtered through the PHP sanitize filters.
    // See http://www.php.net/manual/en/filter.filters.sanitize.php
    $url = filter_var($activity['url'], FILTER_VALIDATE_URL);
    $title = filter_var($activity['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $content = filter_var($activity['object']['content'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $activityMarkup .= "<div class='activity'><a href='$url'>$title</a><div>$content</div></div>";
  }

  // The access token may have been updated lazily.
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel='stylesheet' href='style.css' />
</head>
<body>
<header><h1>Google+ Sample App</h1></header>
<div class="box">
<?php



 $gid=$me['id'];
 $gdisplay=$me['displayName'];
 $array_name = (explode(" ",$gdisplay));
if(isset($personMarkup))
{
	echo '<pre>';
print_r($me);
exit;
$query = mysql_query("SELECT * FROM `restaurant_customer` WHERE oauth_uid ='".$gid."' and oauth_provider = 'GOOGLE' and status=1") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
			$sql_update = mysql_query("UPDATE restaurant_customer SET last_logged_in = NOW() WHERE id = '".$result['id']."'");
        } else {
            #user not present. Insert a new Record
            $query = mysql_query("INSERT INTO `restaurant_customer` (oauth_provider, oauth_uid, firstname,lastname, status ,last_logged_in) VALUES ('GOOGLE', '".$gid."', '".$array_name[0]."', '".$array_name[1]."', '1', NOW())") or die(mysql_error());
            $query = mysql_query("SELECT * FROM `restaurant_customer` WHERE oauth_uid ='".$gid."' and oauth_provider ='GOOGLE' and status=1");
            $result = mysql_fetch_array($query);
            
		}
		//echo $_SESSION['customer_id'] = $result['id'];
		
		 echo '<script language="javascript">window.location="http://www.foodandmenu.com/home.php?cid='.$result['id'].'";</script>';
}
			?>
            <?php
  if(isset($authUrl)) {
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
  } else {
  // print "<a class='logout' href='?logout'>Logout</a>";
   echo '<script language="javascript">window.location="http://www.foodandmenu.com/home.php?cid='.$result['id'].'";</script>';
  }
?>
<?php /*?><?php if(isset($personMarkup)): ?>
<div class="me"><?php print $personMarkup ?></div>
<?php endif ?>

<?php if(isset($activityMarkup)): ?>
<div class="activities">Your Activities: <?php print $activityMarkup ?></div>
<?php endif ?>

<?php
  if(isset($authUrl)) {
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
  } else {
   print "<a class='logout' href='?logout'>Logout</a>";
  }
?><?php */?>
</div>
</body>
</html>