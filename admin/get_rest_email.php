<?php
    include('lib/conn.php');
    $emp_id = mysql_real_escape_string($_POST['emp_id']); // $_POST is an array (not a function)
    // mysql_real_escape_string is to prevent sql injection
	
    $sql = "SELECT * FROM restaurant_admin_panel WHERE email_id='".$emp_id."'"; // Username must enclosed in two quotations

    $query = mysql_query($sql);

    if(mysql_num_rows($query) == 0)
    {
        echo('EMPID_AVAILABLE');
    }
    else
    {
        echo('EMPID_EXISTS');
    }
?>