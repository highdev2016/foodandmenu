<?php 
require_once('lib/conn.php');

$sql_update = mysql_query("UPDATE restaurant_gift_card SET status = '".$_REQUEST['status']."' WHERE id = '".$_REQUEST['id']."'");
?>
<div id="msg" style="padding-bottom:3px; color:#000000; font-family:Verdana,Arial,Helvetica,sans-serif; text-align:center; font-size:14px; color:#6E6E6E;">Status updated successfully.</div>
