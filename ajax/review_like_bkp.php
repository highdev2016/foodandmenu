<?php
include('../admin/lib/conn.php');
$request = array();
$request = array(
	'type' => $_POST['type'],
	'review_id' => $_POST['review_id'],
	'customer_id' => $_POST['customer_id'],
);

$result = array();

if(isset($request['type']) && isset($request['review_id'])){
	$sql = "SELECT COUNT(*) AS total FROM " . $table_prefix . "like_dislike WHERE review_id = '".$request['review_id']."' AND customer_id = '".$request['customer_id']."'";
	$query = mysql_query($sql);
	$count = mysql_fetch_assoc($query);
	if($count['total'] > 0){
		$updSql = "UPDATE " . $table_prefix . "like_dislike SET `is_like` = 0, `is_dislike` = 0 WHERE `review_id` = '" . $request['review_id'] . "' AND `customer_id` = '".$request['customer_id']."'";
		$query = mysql_query($updSql);
		if($query){
			$sql = "UPDATE " . $table_prefix . "like_dislike SET ";
			$sql .= "`is_" . $request['type'] . "` = 1, `is_" . $request['type'] . "_status` = 1";
			$sql .= " WHERE review_id = " . $request['review_id'] . " AND `customer_id` = '".$request['customer_id']."'";
			$ld_query = mysql_query($sql);
		}
	}else{
		$sql = "INSERT INTO `" . $table_prefix . "like_dislike` SET `is_".$request['type']."` = 1, `is_" . $request['type'] . "_status` = 1, `review_id` = '".$request['review_id']."', `customer_id` = '".$request['customer_id']."'";
		$ld_query = mysql_query($sql);
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

