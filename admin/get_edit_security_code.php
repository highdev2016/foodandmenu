<?php
    include('lib/conn.php');
    $security_code = mysql_real_escape_string($_POST['security_code']); // $_POST is an array (not a function)
	$id = $_POST['id'];
    // mysql_real_escape_string is to prevent sql injection
	
    $sql = "SELECT * FROM restaurant_admin_panel WHERE security_code='".$security_code."' AND id!='".$id."'"; // Username must enclosed in two quotations

    $query = mysql_query($sql);

    if(mysql_num_rows($query) == 0)
    {
        echo('SEC_CODE_AVAILABLE');
    }
    else
    {
        echo('SEC_CODE_EXISTS');
    }
?>