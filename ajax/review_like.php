<?php
session_start();
include('../admin/lib/conn.php');
include('../includes/functions.php');
$request = array();
$request = array(
	'type' => $_POST['type'],
	'review_id' => $_POST['review_id'],
	'customer_id' => $_POST['customer_id'],
);

$result = array();

//echo 'Test'; exit;

if(isset($request['type']) && isset($request['review_id'])){
	$sql = "SELECT COUNT(*) AS total FROM " . $table_prefix . "like_dislike WHERE review_id = '".$request['review_id']."' AND customer_id = '".$request['customer_id']."'";
	$query = mysql_query($sql);
	$count = mysql_fetch_assoc($query);
	
	$sql_review = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$request['review_id']."'"));
	if($count['total'] > 0){
		$updSql = "UPDATE " . $table_prefix . "like_dislike SET `is_like` = 0, `is_dislike` = 0 WHERE `review_id` = '" . $request['review_id'] . "' AND `customer_id` = '".$request['customer_id']."'";
		$query = mysql_query($updSql);
		if($query){
			$sql = "UPDATE " . $table_prefix . "like_dislike SET ";
			$sql .= "`is_" . $request['type'] . "` = 1, `is_" . $request['type'] . "_status` = 1";
			$sql .= " WHERE review_id = " . $request['review_id'] . " AND `customer_id` = '".$request['customer_id']."'";
			$ld_query = mysql_query($sql);
			
			$sql_insert_notification = mysql_query("INSERT INTO restaurant_notification SET user_id = '".$_SESSION['customer_id']."' , action = '".$request['type']."' , post_date = NOW() , notification = '".$request['type']."s a review of ".getNameTable('restaurant_customer','firstname','id',$sql_review['customer_id'])." of ".getNameTable('restaurant_basic_info','restaurant_name','id',$sql_review['restaurant_id'])."' , rel_id = '".$request['review_id']."' , restaurant_id = '".$sql_review['restaurant_id']."'");
			
	$follower_list = mysql_query("SELECT follower_id FROM user_follow WHERE following_id = '".$_SESSION['customer_id']."'");
	
	while($follower_list_all = mysql_fetch_array($follower_list))
	{
		$email_cust = getNameTable("restaurant_customer","email","id",$follower_list_all['follower_id']);
		
		$cust_name = getNameTable("restaurant_customer","firstname","id",$follower_list_all['follower_id'])." ".getNameTable("restaurant_customer","lastname","id",$follower_list_all['follower_id']);
		
		$name = getNameTable("restaurant_customer","firstname","id",$_SESSION['customer_id'])." ".getNameTable("restaurant_customer","lastname","id",$_SESSION['customer_id']);
		
		$notification = "".$request['type']."s a review of ".getNameTable('restaurant_customer','firstname','id',$sql_review['customer_id'])." of ".getNameTable('restaurant_basic_info','restaurant_name','id',$sql_review['restaurant_id'])." on ".date('m-d-Y')." at ".date('h:i:s A');
		
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 42"));  
		  
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
		
		$cms_rep=str_replace('%%$customer_name%%',$cust_name,$cms_rep);
		$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
		$cms_rep=str_replace('%%$notification%%',$notification,$cms_rep);
		
		
		$from = 'support@foodandmenu.com';
	
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
		$headers .= 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
		$message=$cms_rep;
		
		$subject = str_replace('%%$action%%',$request['type'],stripslashes($sql_cms['subject']));
		
		mail($email_cust,$subject,$message,$headers);
	}
		}
	}else{
		$sql = "INSERT INTO `" . $table_prefix . "like_dislike` SET `is_".$request['type']."` = 1, `is_" . $request['type'] . "_status` = 1, `review_id` = '".$request['review_id']."', `customer_id` = '".$request['customer_id']."'";
		$ld_query = mysql_query($sql);
		
		$sql_insert_notification = mysql_query("INSERT INTO restaurant_notification SET user_id = '".$_SESSION['customer_id']."' , action = '".$request['type']."' , post_date = NOW() , notification = '".$request['type']."s a review of ".getNameTable('restaurant_customer','firstname','id',$sql_review['customer_id'])." of ".getNameTable('restaurant_basic_info','restaurant_name','id',$sql_review['restaurant_id'])."' , rel_id = '".$request['review_id']."' , restaurant_id = '".$sql_review['restaurant_id']."'");
		
		$follower_list = mysql_query("SELECT follower_id FROM user_follow WHERE following_id = '".$_SESSION['customer_id']."'");
	
	while($follower_list_all = mysql_fetch_array($follower_list))
	{
		$email_cust = getNameTable("restaurant_customer","email","id",$follower_list_all['follower_id']);
		
		$cust_name = getNameTable("restaurant_customer","firstname","id",$follower_list_all['follower_id'])." ".getNameTable("restaurant_customer","lastname","id",$follower_list_all['follower_id']);
		
		$name = getNameTable("restaurant_customer","firstname","id",$_SESSION['customer_id'])." ".getNameTable("restaurant_customer","lastname","id",$_SESSION['customer_id']);
		
		$notification = "".$request['type']."s a review of ".getNameTable('restaurant_customer','firstname','id',$sql_review['customer_id'])." of ".getNameTable('restaurant_basic_info','restaurant_name','id',$sql_review['restaurant_id'])." on ".date('m-d-Y')." at ".date('h:i:s A');
		
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 42"));  
		  
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
		
		$cms_rep=str_replace('%%$customer_name%%',$cust_name,$cms_rep);
		$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
		$cms_rep=str_replace('%%$notification%%',$notification,$cms_rep);
		
		
		$from = 'support@foodandmenu.com';
	
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
		$headers .= 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
		$message=$cms_rep;
		
		$subject = str_replace('%%$action%%',$request['type'],stripslashes($sql_cms['subject']));
		
		mail($email_cust,$subject,$message,$headers);
	}
	}
}

//echo $sql;

//$query = mysql_query($sql);
if($ld_query){
	$sql = "SELECT SUM(`is_like`) AS count_like, SUM(`is_dislike`) AS count_dislike FROM " . $table_prefix . "like_dislike WHERE `review_id` = '" . $request['review_id'] . "'";
	$query = mysql_query($sql);
	if($query){
		$row = mysql_fetch_assoc($query);
		$result['count_like'] = $row['count_like'];
		$result['count_dislike'] = $row['count_dislike'];
	}
	
	//$sql = "SELECT `is_like_status`, `is_dislike_status` FROM " . $table_prefix . "like_dislike WHERE `review_id` = '" . $request['review_id'] . "' AND `customer_id` = '" . $request['customer_id'] . "'";
	//	$query = mysql_query($sql);
	//	if($query){
	//		$row = mysql_fetch_assoc($query);
	//		
	//		$result['user']['is_like_status'] = $row['is_like_status'];
	//		$result['user']['is_dislike_status'] = $row['is_dislike_status'];
	//		
	//	}

$sql = "SELECT `is_like`, `is_dislike` FROM " . $table_prefix . "like_dislike WHERE `review_id` = '" . $request['review_id'] . "' AND `customer_id` = '" . $request['customer_id'] . "'";
	$query = mysql_query($sql);
	if($query){
		$row = mysql_fetch_assoc($query);
		
		$result['user']['is_like_status'] = $row['is_like'];
		$result['user']['is_dislike_status'] = $row['is_dislike'];
		
	}
}

echo json_encode($result);

