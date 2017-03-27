<?php
include('lib/conn.php');
function getSingleReviewRating($id,$reviewid)
{
$sql= "select `score_1`,`score_2`,`score_3`,`score_4`,`score_5` from `restaurant_rating` where `restaurant_id` = '".$id."' AND `review_id` = '".$reviewid."'";

	$result = @mysql_query($sql);
	$rs = @mysql_fetch_array($result);
	$srr = 0;
	if($rs['score_1']>0)
		return $srr = 1;
		elseif($rs['score_2']>0)
			return $srr = 2; 
			elseif($rs['score_3']>0)
				return $srr = 3; 
				elseif($rs['score_4']>0)
					return $srr = 4; 
					elseif($rs['score_5']>0)
						return $srr = 5; 

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>User Reviews</title>
</head>
<body>

<div id="inline<?php echo $customerInfo['id']; ?>" style="width:600px;height:auto; min-height:250px;">
<?php $sql_user_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE customer_id = '".$_REQUEST['id']."'"); ?>
<h1 class="review_top_heading" style="padding:0px;"><span>Total Reviews : <?php echo mysql_num_rows($sql_user_reviews); ?></span></h1>
<?php
while($array_user_reviews = mysql_fetch_array($sql_user_reviews)){
$sql_rating = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rating WHERE restaurant_id = '".$array_user_reviews['restaurant_id']."' AND customer_id = '".$_REQUEST['id']."'"));
?>
<div class="review_top">
	<h1 style="padding:0px;"><span><?php echo $array_user_reviews['restaurant_name']; ?></span></h1>                                          
	<ul>
	<?php
	$rating = getSingleReviewRating($array_user_reviews['restaurant_id'],$sql_rating['review_id']);
	//echo $rating;
	$rem = 5 - $rating;
	if($rating > 0)
	{
		for($i=0; $i<$rating;$i++){
	?>
	<li><img width="16" height="16" src="images/star-1.png"></li>
	<?php
		}
		for($j=0;$j<$rem;$j++){
	?>
	<li><img width="16" height="15" src="images/star-3.png"></li>
	<?php
		}
	}
	else{
	?>
	<?php
	}
	?>
<li><?php echo date("m-d-Y", strtotime($array_user_reviews['post_date']));?></li>    
</ul>
	<p><?php echo $array_user_reviews['customer_review']; ?></p>
</div>
<?php } ?>
                                         
</div>

</body>
</html>