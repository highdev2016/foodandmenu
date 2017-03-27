<?php 
include ("lib/conn.php");

$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_REQUEST['id']."'"));

$sql_update = mysql_query("UPDATE restaurant_customer SET account_disabled = 1 WHERE id = '".$_REQUEST['id']."'");

$site_url="https://". $_SERVER['HTTP_HOST'] ."";

/************************************************ Customer ***********************************************/

$email = $sql_customer['email'];  //"priya@infosolz.com"

$name = $sql_customer['firstname'];

/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
			<div style="margin:0 auto;width:700px;clear:both;">
			<div style="background-color:#3F4CA0; height:30px;"></div>
			<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">
			<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />
			</div>
			<div style="width:100%; float:left;">
			<div style="clear:both;"></div>
				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hey '.$name.',</p>
				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Your account has been disabled by Admin due to violation of Food & menu services .</p>
			<div style="clear:both;"></div>
			<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>
			<div style="clear:both;"></div>
				<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>
				<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>
			<div style="clear:both;"></div>
			</div>
			<div style="clear:both;"></div>
			<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >
			<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">
Sent to you from Food & menu</h4>
		</div>
	</div>
	<div style="clear:both;"></div>
	</div>';*/
	
$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 6"));	
			
$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));

$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
			
$from = "support@foodandmenu.com";

$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

$headers .= 'MIME-Version: 1.0' . "\r\n";

$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

$message=$cms_rep;

/*$subject="Account Disabled";*/

$subject = stripslashes($sql_cms['subject']);

mail($email,$subject,$message,$headers);

header("location:manage_customer.php?disable=1&page=".$_REQUEST['page']."");


?>