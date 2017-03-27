<?php
session_start();
print_r($_SESSION['gplusdata']);
require 'admin/lib/conn.php';
if (!isset($_SESSION['gplusdata'])) {
    // Redirection to login page twitter or facebook
    header("location: index.php");
}
else
{
$me=$_SESSION['gplusdata'];
/*$query = mysql_query("SELECT * FROM `restaurant_customer` WHERE oauth_uid = '$user' and oauth_provider = '$oauth_provider'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
        } else {
            #user not present. Insert a new Record
            $query = mysql_query("INSERT INTO `restaurant_customer` (oauth_provider, oauth_uid, firstname, lastname, status) VALUES ('$oauth_provider', '$user', '$firstname','$lastname', '1')") or die(mysql_error());
            $query = mysql_query("SELECT * FROM `restaurant_customer` WHERE oauth_uid = '$user' and oauth_provider = '$oauth_provider'");
            $result = mysql_fetch_array($query);
$_SESSION['customer_id'] = $me['id'];
		}
*/
?>
<?php 
echo '<script language="javascript">window.location="http://www.foodandmenu.com";</script>'; 
}
?>