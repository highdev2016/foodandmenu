<?php 
session_start();
include('admin/lib/conn.php');
$sql_update = mysql_query("UPDATE  restaurant_reviews SET abuse_status = 1,abused_by='".$_SESSION['customer_id']."' WHERE id = '".$_REQUEST['r_id']."'");
//echo "UPDATE restaurant_reviews SET abuse_status = 1,abused_by='".$_SESSION['customer_id']."' WHERE id = '".$_REQUEST['r_id']."'";

$sql_reviews=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$_REQUEST['r_id']."'"));
$sql_customer=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$sql_reviews['abused_by']."'"));
$sql_restaurant=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$sql_reviews['restaurant_id']."'"));


	/******************************************** Admin ***********************************************/
					
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 10"));
	
	$admin_email_address = $sql_cms['email_address'];
	
	$arr_email_address = explode(",",$admin_email_address);	
	
	//$email = "support@foodandmenu.com"; //priya@infosolz.com
	
	$customer_name = $sql_customer['firstname'].' '.$sql_customer['lastname'];
	$review = stripslashes($sql_reviews['customer_review']);
	$restaurant_name = stripslashes($sql_restaurant['restaurant_name']);
	$from = $sql_customer['email'];
		
	/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
	
							<div style="margin:0 auto;width:700px;clear:both;">
	
							<div style="background-color:#3F4CA0; height:30px;"></div>
	
							<div style="background-color:#fff; padding:0 0px; ">
	
							<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px;" />
		<div style="height:15px; background-color:#3F4CA0;"></div>
	
							</div>
	
							<div style="width:100%; float:left;">
	
							<div style="clear:both;"></div>
	
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello Admin,</p>
								
								<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$sql_customer['firstname'].'&nbsp;'.$sql_customer['lastname'].' has abused the review "'.stripslashes($sql_reviews['customer_review']).'" of the restaurant "'.stripslashes($sql_restaurant['restaurant_name']).'"</p>
	
							<div style="clear:both;"></div>
	
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
	
			
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep = str_replace('%%$customer_name%%',$customer_name,$cms_rep);
	$cms_rep = str_replace('%%$review%%',$review,$cms_rep);	
	$cms_rep = str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	//$subject="Review Abuse Notification";
	
	$subject = stripslashes($sql_cms['subject']);
	
	mail($email,$subject,$message,$headers);
	
	foreach($arr_email_address as $val_email){
		mail($val_email,$subject,$message,$headers);
	}
	
	
//mysql_query("UPDATE  restaurant_rating SET status = 0 WHERE review_id = '".$_REQUEST['r_id']."'");
//exit();
header("location:review.php?id=".$_REQUEST['id']."&deal_id=".$_REQUEST['deal_id']."&abuse_status=1");
?>