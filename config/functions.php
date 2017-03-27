<?php

require 'dbconfig.php';

class User {
    function checkUser($user, $oauth_provider, $firstname,$lastname) 
	{
        $query = mysql_query("SELECT * FROM `restaurant_customer` WHERE oauth_uid = '$user' and oauth_provider = '$oauth_provider'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
			$sql_update = mysql_query("UPDATE restaurant_customer SET last_logged_in = NOW() WHERE id = '".$result['id']."'");
            # User is already present
        } else {
            #user not present. Insert a new Record
            $query = mysql_query("INSERT INTO `restaurant_customer` (oauth_provider, oauth_uid, firstname, lastname, status, last_logged_in) VALUES ('$oauth_provider', '$user', '$firstname','$lastname', '1' , NOW())") or die(mysql_error());
            $query = mysql_query("SELECT * FROM `restaurant_customer` WHERE oauth_uid = '$user' and oauth_provider = '$oauth_provider'");
            $result = mysql_fetch_array($query);
            return $result;
        }
		return $result;
    }
}

?>
