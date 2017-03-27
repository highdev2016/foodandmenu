<?php
    include('lib/conn.php');
    $rest_id = mysql_real_escape_string($_POST['rest_id']); // $_POST is an array (not a function)
    // mysql_real_escape_string is to prevent sql injection
	
    $sql = "SELECT * FROM restaurant_admin_panel WHERE restaurant_id = '".$rest_id."'"; // Username must enclosed in two quotations

    $query = mysql_query($sql);

    if(mysql_num_rows($query) == 0)
    {
        echo('REST_AVAILABLE');
    }
    else
    {
        echo('REST_EXISTS');
    }
?>