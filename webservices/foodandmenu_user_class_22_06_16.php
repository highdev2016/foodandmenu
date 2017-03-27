<?php
session_start();
include("../admin/image_file.php");
//if($_SERVER['HTTP_HOST'] == "localhost/bigmunk_api/") {
//	define('DOMAIN', "localhost/bigmunk_api/");
//} else {
////define('PROFILE', "");
//define('DOMAIN', "");
//}
?>
<?php /*?><script src="jquery/main.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry"></script><?php */?>

<?php
error_reporting(0);
function distance($start,$destination) {
        $from = urlencode($start);
		$to = urlencode($destination);
		$data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$from."&destinations=".$to."&language=en-EN&key=AIzaSyB07MAPrJw5QMASepJKym-rXy9DJ9wdMKU");
		$data = json_decode($data);
		//echo "DataSet".print_r($data);
		//exit;
	   $time = 0;
		$distance = 0;
		foreach($data->rows[0]->elements as $road){
			$time += $road->duration->value;
			$distance += $road->distance->value;
		}
		
		//$distance=14.5;
		$distance=round(($distance * 0.000621371),2);
		//echo "<br>distance".$distance;
		//exit;
		 return ($distance);
    }



/*
function getRestaurantRating($restaurantid)
{
	$total_count = 0;
	$total_review_count = 0;
	$count_rating = array();
	
	$sql2= "select sum(score_1) as sc1,sum(score_2) as sc2,sum(score_3) as sc3,sum(score_4) as sc4,sum(score_5) as sc5 from `restaurant_rating` where `restaurant_id` = '".$restaurantid."' AND `status` = '1'";
	$result2 = @mysql_query($sql2);
	$rs2 = @mysql_fetch_array($result2);
	for($j = 1; $j<=5; $j++)
	{
		$count_rating[$j] = $rs2['sc' . $j];
		$total_review_count += $rs2['sc' . $j];
	}
	
	for($i = 1; $i<=5; $i++)
	{
		$total_count += ($i * $count_rating[$i]);
		//$total_review_count += $rs['score_' . $i];
	}
	//echo $total_count."<br>";
	//echo $total_review_count;
	//return round($total_count/$total_review_count);
	if($total_count == 0 || $total_review_count == 0)
		return 0;
	else		
		return $total_count/$total_review_count;	
}

*/

function getRestaurantRating($restaurantid)
{
	$total_count = 0;
	$total_review_count = 0;
	$count_rating = array();
	
	$sql2= "select sum(score_1) as sc1,sum(score_2) as sc2,sum(score_3) as sc3,sum(score_4) as sc4,sum(score_5) as sc5 from `restaurant_rating` where `restaurant_id` = '".$restaurantid."' AND `status` = '1'";
	$result2 = @mysql_query($sql2);
	$rs2 = @mysql_fetch_array($result2);
	for($j = 1; $j<=5; $j++)
	{
		$count_rating[$j] = $rs2['sc' . $j];
		$total_review_count += $rs2['sc' . $j];
	}
	
	for($i = 1; $i<=5; $i++)
	{
		$total_count += ($i * $count_rating[$i]);
		//$total_review_count += $rs['score_' . $i];
	}
	//echo $total_count."<br>";
	//echo $total_review_count;
	//return round($total_count/$total_review_count);
	if($total_count == 0 || $total_review_count == 0)
		return 0;
	else		
		return $total_count/$total_review_count;	
}

function rate($rating, $restaurantid, $review_id , $customer_id){
	$insert = '';
	$customer_id = $customer_id;
	$insert = "INSERT INTO `restaurant_rating` SET 
									`restaurant_id` = '".$restaurantid."', 
									`customer_id` = '".$customer_id."', 
									`review_id` = '".$review_id."', 
									`counter` = '', 
									`value` = '',
									`status` = '1'";
		 							
									
	switch ($rating) {
			case 0:
				$insert .= ",`score_1` = '1'" ;
				break;
			case 1:
				$insert .= ",`score_1` = '1'" ;
				break;   
			case 2:
				$insert .= ",`score_2` = '1'" ;
				break;
			case 3:
				$insert .= ",`score_3` = '1'" ;
				break;
			case 4:
				$insert .= ",`score_4` = '1'" ;
				break;
			case 5:
				$insert .= ",`score_5` = '1'" ;
				break;
	}								
	$result = @mysql_query($insert); 
	
}

function getTimezone($location) {
    $location = urlencode($location);
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address={$location}&sensor=false";
    $data = file_get_contents($url);

    // Get the lat/lng out of the data
    $data = json_decode($data);
    if (!$data)
        return false;
    if (!is_array($data->results))
        return false;
    if (!isset($data->results[0]))
        return false;
    if (!is_object($data->results[0]))
        return false;
    if (!is_object($data->results[0]->geometry))
        return false;
    if (!is_object($data->results[0]->geometry->location))
        return false;
    if (!is_numeric($data->results[0]->geometry->location->lat))
        return false;
    if (!is_numeric($data->results[0]->geometry->location->lng))
        return false;
    $lat = $data->results[0]->geometry->location->lat;
    $lng = $data->results[0]->geometry->location->lng;

    // get the API response for the timezone
    $timestamp = time();
    $timezoneAPI = "https://maps.googleapis.com/maps/api/timezone/json?location={$lat},{$lng}&sensor=false&timestamp={$timestamp}";
    $response = file_get_contents($timezoneAPI);
    if (!$response)
        return false;
    $response = json_decode($response);
    if (!$response)
        return false;
    if (!is_object($response))
        return false;
    if (!is_string($response->timeZoneId))
        return false;

    return $response->timeZoneId;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

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


class rhourinfo 
{
	function rhourval($log)
	{
		
		$get_reservation_hrs = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['resid']."'"));
		$foodandmenu['resall']['reservation_open_Monday'] =date("g:i A", strtotime($get_reservation_hrs['reservation_open_Monday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Monday']));
		
		$foodandmenu['resall']['reservation_open_Tuesday'] =date("g:i A", strtotime($get_reservation_hrs['reservation_open_Tuesday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Tuesday']));
		
		$foodandmenu['resall']['reservation_open_Wednesday'] =date("g:i A", strtotime($get_reservation_hrs['reservation_open_Wednesday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Wednesday']));
		
		
		$foodandmenu['resall']['reservation_open_Thursday'] =date("g:i A", strtotime($get_reservation_hrs['reservation_open_Thursday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Thursday']));
		
		$foodandmenu['resall']['reservation_open_Friday'] =date("g:i A", strtotime($get_reservation_hrs['reservation_open_Friday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Friday']));
		
		$foodandmenu['resall']['reservation_open_Saturday'] =date("g:i A", strtotime($get_reservation_hrs['reservation_open_Saturday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Saturday']));
		
		$foodandmenu['resall']['reservation_open_Sunday'] =date("g:i A", strtotime($get_reservation_hrs['reservation_open_Saturday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_open_Sunday']));
		
		
		
		
		
		return $foodandmenu['resall'];
	}
	
}



class putlike 
{
	function putlikeval($log)
	{
		
$get_num=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_like_dislike` WHERE `customer_id` ='".$_REQUEST['resid']."' AND 
`review_id`='".$_REQUEST['review_id']."'"));
        if($get_num==0)
		{
			$put_like_do="INSERT INTO restaurant_like_dislike (review_id,customer_id,is_like,is_dislike,is_like_status,is_dislike_status)
VALUES ('".$_REQUEST['review_id']."','".$_REQUEST['resid']."','1','0','1','1')";
      mysql_query($put_like_do);
	  $foodandmenu['resall']['put_like'] ="success";
		}
		else
		   {
			   $put_like_do="UPDATE `restaurant_like_dislike` SET `is_like` = '1',
`is_dislike` = '0' WHERE `review_id` ='".$_REQUEST['review_id']."'";
mysql_query($put_like_do);
	  $foodandmenu['resall']['put_like'] ="success";
			   
		   }
		
		

		
		return $foodandmenu['resall'];
	}
	
}

class putdlike 
{
	function putdlikeval($log)
	{
		
$get_num=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_like_dislike` WHERE `customer_id` ='".$_REQUEST['resid']."' AND 
`review_id`='".$_REQUEST['review_id']."'"));
        if($get_num==0)
		{
			$put_dlike_do="INSERT INTO restaurant_like_dislike (review_id,customer_id,is_like,is_dislike,is_like_status,is_dislike_status)
VALUES ('".$_REQUEST['review_id']."','".$_REQUEST['resid']."','0','1','1','1')";
      mysql_query($put_dlike_do);
	  $foodandmenu['resall']['put_dlike'] ="success";
		}
		else
		   {
			   $put_dlike_do="UPDATE `restaurant_like_dislike` SET `is_like` = '0',
`is_dislike` = '1' WHERE `review_id` ='".$_REQUEST['review_id']."'";
mysql_query($put_dlike_do);
	  $foodandmenu['resall']['put_dlike'] ="success";
			   
		   }
		
		

		
		return $foodandmenu['resall'];
	}
	
}

class city_state_resinfo 
{
	function restaurant_city_state($log)
	{
		 $res_city=mysql_query("SELECT *
FROM `restaurant_city_state`
WHERE `state` = '".$_REQUEST['state']."' GROUP BY city ORDER BY `city` ASC ");
         $i=0;
			while($row_city=mysql_fetch_array($res_city))
			 {
				$foodandmenu['resall']['city'][$i] =$row_city['city'];
				$foodandmenu['resall']['zip'][$i] =$row_city['zip'];
				$i++;
			}

		

		
		return $foodandmenu['resall'];
	}
	
}

class resreviewinfo 
{
	function reviewval($log)
	{
		$rating = number_format(getRestaurantRating($_REQUEST['resid']),1);
$total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$_REQUEST['resid']."' AND status=1"));
		$foodandmenu['resall']['rating_this_restaurant'] =$rating;
		$foodandmenu['resall']['review_this_restaurant'] =$total_review;
		return $foodandmenu['resall'];
	}
	
}


class restaurant_couponinfo
{
	function restaurant_coupon($log)
	{
		$foodandmenu['resall']=array();
$res_copon=mysql_query("SELECT * FROM `restaurant_coupon` WHERE `restaurant_id`='".$_REQUEST['id']."'");

    while($row_copon=mysql_fetch_array($res_copon))
	 {
		
		array_push($foodandmenu['resall'], array(
		'coupon_id' =>$row_copon['id'],
		'coupon_name' =>$row_copon['coupon_name'],
		'coupon_code' =>$row_copon['coupon_code'],
		'discount' =>$row_copon['discount'],
		'start_date' =>$row_copon['start_date'],
		'end_date' =>$row_copon['end_date'],
		'coupon_image' =>"https://foodandmenu.com/uploaded_images/".$row_copon['coupon_image'],
		'coupon_description' =>$row_copon['coupon_description']));
		
	}
	return $foodandmenu['resall'];
	}
}




class restaurant_hot_info
{
	function restaurant_hot($log)
	{
		
$res_hot=mysql_query("SELECT * FROM restaurant_deals WHERE deals_status =1");
$i=0;
    while($row_hot=mysql_fetch_array($res_hot))
	 {
		$foodandmenu['resall'][$i] =$row_hot['restaurant_id'];
		$i++;
	}
	return $foodandmenu['resall'];
	}
}


class restaurant_reviews_info
{
	function restaurant_reviews_top($log)
	{
		
$res_reviews_top=mysql_query("SELECT * FROM `restaurant_reviews` WHERE `score` = '5'");
$i=0;
    while($row_reviews_top=mysql_fetch_array($res_reviews_top))
	 {
		$foodandmenu['resall'][$i] =$row_reviews_top['restaurant_id'];
		$i++;
	}
	return $foodandmenu['resall'];
	}
}


class resprofileinfo 
{
	function profileval($log)
	{
		$customer_id=$_REQUEST['mid'];
		$sql_select_customer = mysql_query("SELECT * FROM restaurant_customer WHERE  id = '".$customer_id."'");
		$num_row = mysql_num_rows($sql_select_customer);
		$row_user = mysql_fetch_array($sql_select_customer);
		
		
		$foodandmenu['resall']['firstname'] =htmlspecialchars(stripslashes($row_user['firstname']));
		$foodandmenu['resall']['lastname'] =htmlspecialchars(stripslashes($row_user['lastname']));
		$foodandmenu['resall']['email'] =$row_user['email'];
		$foodandmenu['resall']['address'] =htmlspecialchars(stripslashes($row_user['address']));
		$foodandmenu['resall']['phone'] =$row_user['phone'];
		$foodandmenu['resall']['image'] ="https://foodandmenu.com/uploaded_images/".$row_user['image'];
		$foodandmenu['resall']['city'] =$row_user['city'];
		$foodandmenu['resall']['state'] =$row_user['state'];
		$foodandmenu['resall']['zip'] =$row_user['zip'];
		$foodandmenu['resall']['home_apartment'] =htmlspecialchars(stripslashes($row_user['home_apartment']));
		$foodandmenu['resall']['apt_name'] =$row_user['apt_name'];
		$foodandmenu['resall']['apt_no'] =$row_user['apt_no'];
		$foodandmenu['resall']['gate_code'] =$row_user['gate_code'];
		$foodandmenu['resall']['gender'] =$row_user['gender'];
		$foodandmenu['resall']['date_of_birth'] =$row_user['date_of_birth'];
		return $foodandmenu['resall'];
	}
	
}

class profileupdateinfo 
{
	function profileupdateval($log)
	{
		$customer_id=$_REQUEST['user_id'];
		$sql_select_customer1 = mysql_query("SELECT * FROM restaurant_customer WHERE  id = '".$customer_id."'");
		$num_row = mysql_num_rows($sql_select_customer1);
		if($num_row!=0)
		{
			$profile_edit="UPDATE `restaurant_customer` SET `firstname` = '".mysql_real_escape_string($_REQUEST['firstname'])."',
`lastname` = '".mysql_real_escape_string($_REQUEST['lastname'])."',
`address` = '".mysql_real_escape_string($_REQUEST['address'])."',
`phone` = '".mysql_real_escape_string($_REQUEST['phone'])."',
`city` ='".mysql_real_escape_string($_REQUEST['city'])."',
`state` = '".mysql_real_escape_string($_REQUEST['state'])."',
`zip` = '".mysql_real_escape_string($_REQUEST['zip'])."',
`home_apartment` = '".mysql_real_escape_string($_REQUEST['home_apartment'])."',
`apt_name` = '".mysql_real_escape_string($_REQUEST['apt_name'])."',
`apt_no` ='".mysql_real_escape_string($_REQUEST['apt_no'])."',
`gate_code` = '".$_REQUEST['gate_code']."',
`gender` = '".$_REQUEST['gender']."',
`date_of_birth`='".$_REQUEST['date_of_birth']."' WHERE `id` ='".$customer_id."'";
		 mysql_query($profile_edit);
		
		$foodandmenu['resall']['profile_update'] ="success";
		}
		return $foodandmenu['resall'];
	}
	
}

class resinfo 
{
	function allResval($log)
	{
		
		$search_distance = mysql_fetch_assoc(mysql_query("SELECT search_mile FROM restaurant_admin WHERE id = 1"));

		//===============Code same as Location search===========//
		/* $address_post=$_REQUEST['address'];
		$address_str_array=explode(",",$_REQUEST['address']);

		if(sizeof($address_str_array)== 1)
			{
			$address_post_array=explode(" ",$address_post);
			//print_r($address_post_array);
		    //exit;
			}
		else
			{
			$address_str = str_replace(" ","",$address_post);
			$address_post_array=explode(",",$address_str);
			//print_r($address_post_array);
		    //exit;
 		 	}

		If(sizeof($address_post_array)> 2)
		{
			$address_post_array=array_slice($address_post_array, 0, 2);
			//print_r($address_post_array);
		   // exit;
		} */
		  
		//===============End Code same as Location search===========//
		$address_post=$_REQUEST['address'];
		
		$address_str_array=explode(",",$_REQUEST['address']);

		 if(sizeof($address_str_array)== 1)
			{
			$address_post_array=explode(" ",$address_post);
			 If(sizeof($address_post_array)> 2)
			  {
			 $address_post_array=array_slice($address_post_array, 0, 2);
			 //print_r($address_post_array);
			 // exit;
			  }
			}
		else
			{
			$address_str = str_replace(",","",$address_post);
			$address_post_array=explode(" ",$address_str);
			
			If(is_numeric($address_post_array[2]))
				{
				//$address_post_array=array_slice($address_post_array, 0, 3);
				$var = $address_post_array[2];
				$address_post_array=array();
				array_push($address_post_array,$var);
				//print_r($address_post_array);
				} 
				else 
				{
				$address_post_array=array_slice($address_post_array, 0, 2);
				//print_r($address_post_array);
				//exit;
				}
 			} 

		
		if($_REQUEST['pageCount']==1)
		{
		$num_item=$_REQUEST['pageCount']*10;
		$frm=0;
		}
		else
		   {
			$frm1=$_REQUEST['pageCount']-1;
			$frm=$frm1*10;
			$num_item=10;  
		   }
		
		$_SESSION['address']="";
		
		$_SESSION['address'] = $address_post;
		
		/*$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' .$address_post. '&sensor=false');
		
		$output = json_decode($geocode);
		
		$lat = $output->results[0]->geometry->location->lat;
		$long = $output->results[0]->geometry->location->lng;*/
		
		$foodandmenu['resall'] = array();
		//echo "SELECT t1.*,t2.* FROM restaurant_basic_info as t1 , restaurant_business_delivery_takeout_info as t2 , restaurant_services_dress_payment as t3 WHERE t1.id = t2.restaurant_id AND t1.id = t3.restaurant_id AND t1.restaurant_city='".$address_post."'  LIMIT ".$frm." ,".$num_item;
		if(is_numeric($address_post_array[0]))
		   {
			   $sql_search = mysql_query("SELECT t1.*,t2.*,t1.id as ResId FROM restaurant_basic_info as t1 , restaurant_business_delivery_takeout_info as t2 , restaurant_services_dress_payment as t3 WHERE t1.id = t2.restaurant_id AND t1.id = t3.restaurant_id AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_zipcode='".$address_post_array[0]."'  LIMIT ".$frm." ,".$num_item);
		   }
		   else
		      {
				  
					if($address_post_array[2]!="")
					   {
						$sql_search = mysql_query("SELECT t1.*,t2.*,t1.id as ResId FROM restaurant_basic_info as t1 , restaurant_business_delivery_takeout_info as t2 , restaurant_services_dress_payment as t3 WHERE t1.id = t2.restaurant_id AND t1.id = t3.restaurant_id AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."' AND t1.restaurant_state='".$address_post_array[1]."' AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.restaurant_zipcode='".$address_post_array[2]."'  LIMIT ".$frm." ,".$num_item);
					   }  
					  else if($address_post_array[1]!="")
					   {
						$sql_search = mysql_query("SELECT t1.*,t2.*,t1.id as ResId FROM restaurant_basic_info as t1 , restaurant_business_delivery_takeout_info as t2 , restaurant_services_dress_payment as t3 WHERE t1.id = t2.restaurant_id AND t1.id = t3.restaurant_id AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."' AND t1.restaurant_state='".$address_post_array[1]."'  LIMIT ".$frm." ,".$num_item);
					   } 
					  else if($address_post_array[0]!="")
					   {
						$sql_search = mysql_query("SELECT t1.*,t2.*,t1.id as ResId FROM restaurant_basic_info as t1 , restaurant_business_delivery_takeout_info as t2 , restaurant_services_dress_payment as t3 WHERE t1.id = t2.restaurant_id AND t1.id = t3.restaurant_id AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."'  LIMIT ".$frm." ,".$num_item);
					   }
				  
			  }
			   
//echo "SELECT t1.*,t2.*,t1.id as ResId FROM restaurant_basic_info as t1 , restaurant_business_delivery_takeout_info as t2 , restaurant_services_dress_payment as t3 WHERE t1.id = t2.restaurant_id AND t1.id = t3.restaurant_id AND t1.restaurant_city='".$address_post_array[0]."'  LIMIT ".$frm." ,".$num_item;
//exit;
			   
			   
$num_rows_rsp = mysql_num_rows($sql_search);
                
                while ($res_array = mysql_fetch_array($sql_search)) {
					$res_add = $res_array['restaurant_address']." ".$res_array['restaurant_city']." ".$res_array['restaurant_state']." ".$res_array['restaurant_zipcode']." ".$res_array['restaurant_country'];
					
					
					
					
                    $distance = distance($address_post, $res_add);
					
					
					//echo "distance".$distance."<br>";
					//echo $search_distance['search_mile'];
					//exit;
                    if ($distance <= $search_distance['search_mile']) {
						
						$sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '" . $res_array['ResId'] . "' AND status = 1");
						$no_reviews = mysql_num_rows($sql_reviews);
						$rating = number_format(getRestaurantRating($res_array['id']), 1);
						
						$address = $res_array['restaurant_address']." ".$res_array['restaurant_city']." ".$res_array['restaurant_state']." ".$res_array['restaurant_zipcode'];
						
						$timezone = getTimezone($address);

						if ($timezone != '') {
							date_default_timezone_set($timezone);
						} else {
							date_default_timezone_set('America/Chicago');
						}

						$current_time = date('h:i A');
						$today = date('l');

						$current_time1 = DateTime::createFromFormat('H:i A', $current_time);
						$day = strtolower(substr($today, 0, 3));

						$sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '" . $res_array['ResId'] . "' AND holiday_date = '" . date('Y-m-d') . "'");
						$restaurant_holiday = '';
						while ($array_holidays = mysql_fetch_array($sql_holidays)) {
							$holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
							$holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);

							if ($current_time1 > $holiday_from && $current_time1 < $holiday_to) {
								$restaurant_holiday = 'close';
							}
						}
						$restaurant_status = 'close';
						
						
						if ($restaurant_holiday != 'close') {
							$sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '" . strtolower($today) . "'"));
							$sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $res_array['ResId'] . "'");
							
							while ($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)) {
								$new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
								$new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);

								if ($current_time1 > $new_from_tm && $current_time1 < $new_to_tm) {
									$restaurant_status = 'open';
								}
								else
								{
									$restaurant_status = 'close';
								}
							}
						} else {
							$restaurant_status = 'close';
						}
						
						//echo "SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $res_array['ResId'] . "' ORDER BY delivery_range";
						
						$sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $res_array['ResId'] . "' ORDER BY delivery_range") or die(mysql_error());
						$del_fee = 0.00;
						
						//echo "<br>test".$distance;
						
						while ($array_del_charge = mysql_fetch_array($sql_del_crge)) {
							if ($distance <= (float)$array_del_charge['delivery_range']) {
								$del_fee = $array_del_charge['delivery_charge'];
								break;
							}
						}
						//echo $del_fee;
						//exit;
						
						if ($res_array['minimum_ammount'] != "")
						{
							$del_min = number_format($res_array['minimum_ammount'], 2);
						}
						else
						{
							$del_min = "0.00";
						}
						
						
						$rating = number_format(getRestaurantRating($res_array['restaurant_id']),1);
$total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$res_array['restaurant_id']."' AND status=1"));



$total_coupon=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_coupon`  where restaurant_id='".$res_array['restaurant_id']."'"));

if($total_coupon==0 || $total_coupon=="")
{
	$is_coupan="false";
	$coupon_count=0;
}
else
   {
	$is_coupan="true";
	$coupon_count=$total_coupon;   
   }



$total_hot_deals=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_deals`   where restaurant_id='".$res_array['restaurant_id']."'"));

if($total_hot_deals==0 || $total_hot_deals=="")
{
	$is_hot_deals="false";
	$hotdeal_count=0;
}
else
   {
	$is_hot_deals="true";
	$hotdeal_count=$total_hot_deals;   
   }





		//$foodandmenu['resall']['rating_this_restaurant'] =$rating;
		//$foodandmenu['resall']['review_this_restaurant'] =$total_review;
						
		$review_id_this="";				
						
						
		$res_review_id=mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$res_array['restaurant_id']."' AND status=1");
while($row_res_review_id=mysql_fetch_array($res_review_id))
{
	$review_id_this.=$row_res_review_id['id'].",";
}				
						
						////About Tax//
						
						if($res_array['tax']=="")
						$res_array['tax']=0.00;
						
                        array_push($foodandmenu['resall'], array(
						'restaurant_id' => $res_array['restaurant_id'],
						'restaurant_name' => html_entity_decode(htmlspecialchars(stripslashes($res_array['restaurant_name']))),
						'is_success' =>'true',
						'is_coupan' =>$is_coupan,
						'coupon_count' =>$coupon_count,
						'is_hot_deals' =>$is_hot_deals,
						'hotdeal_count' =>$hotdeal_count,
						'message' =>'message1',
						'restaurant_del_min_km'=>$distance,
						'phone' => $res_array['phone'],
						'tax' => $res_array['tax'],
						'delivery' => $res_array['delivery'],
						'pickup' => $res_array['pickup'],
						'restaurant_category' => $res_array['restaurant_category_name'],
						'restaurant_image' => "https://foodandmenu.com/uploaded_images/".$res_array['restaurant_image'],
						'restaurant_address' => $address,
						'review_id_this' => $review_id_this,
						'restaurant_reviews' => $total_review,
						'restaurant_rating' => $rating,
						'restaurant_open_status' => $restaurant_status,
						'restaurant_del_min' => $del_min,
						'restaurant_del_fee' => strval($del_fee),
						'commission' => $res_array['commission'],
						'credit_card_fee' => $res_array['credit_card_fee'],
						'service_fee' => $res_array['service_fee'],
						'distance' => strval($distance)
						));
                    }
                }
                
		return $foodandmenu['resall'];
	
	}
	
}


class rating_resinfo 
{	
	function rating_allResval($log)
	{
		
		$search_distance = mysql_fetch_assoc(mysql_query("SELECT search_mile FROM restaurant_admin WHERE id = 1"));
		//===============Code same as Location search===========//
		$address_post=$_REQUEST['address'];
		
		$address_str_array=explode(",",$_REQUEST['address']);

		 if(sizeof($address_str_array)== 1)
			{
			$address_post_array=explode(" ",$address_post);
			 If(sizeof($address_post_array)> 2)
			  {
			 $address_post_array=array_slice($address_post_array, 0, 2);
			 //print_r($address_post_array);
			 // exit;
			  }
			}
		else
			{
			$address_str = str_replace(",","",$address_post);
			$address_post_array=explode(" ",$address_str);
			
			If(is_numeric($address_post_array[2]))
				{
				//$address_post_array=array_slice($address_post_array, 0, 3);
				$var = $address_post_array[2];
				$address_post_array=array();
				array_push($address_post_array,$var);
				//print_r($address_post_array);
				} 
				else 
				{
				$address_post_array=array_slice($address_post_array, 0, 2);
				//print_r($address_post_array);
				//exit;
				}
 			}
		/* $address_post=$_REQUEST['address'];
		$address_str_array=explode(",",$_REQUEST['address']);

		if(sizeof($address_str_array)== 1)
			{
			$address_post_array=explode(" ",$address_post);
			//print_r($address_post_array);
		    //exit;
			}
		else
			{
			$address_str = str_replace(" ","",$address_post);
			$address_post_array=explode(",",$address_str);
			
 			}

		If(sizeof($address_post_array)> 2)
		{
			$address_post_array=array_slice($address_post_array, 0, 2);
		} */
		  
		//===============End Code same as Location search===========//
		
		//===================Previous Coding by Debashis===========//
		//if($_REQUEST['address']=="")
		//{
			//$address_post = str_replace("_"," ",$_SESSION['address']);
		//}
		//else
		//{
			//$address_post = str_replace("_"," ",$_REQUEST['address']);
		//}
		
		//$address_post_array=explode(" ",$address_post);
		//===================Previous Coding End===========//
		
		if($_REQUEST['pageCount']==1)
		{
		$num_item=$_REQUEST['pageCount']*10;
		$frm=0;
		}
		else
		   {
			$frm1=$_REQUEST['pageCount']-1;
			$frm=$frm1*10;
			$num_item=10;  
		   }
		
		
		
		
		
		$_SESSION['address'] = $address_post;
		
		/*$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' .$address_post. '&sensor=false');
		
		$output = json_decode($geocode);
		
		$lat = $output->results[0]->geometry->location->lat;
		$long = $output->results[0]->geometry->location->lng;*/
		
		$foodandmenu['resall'] = array();
		 if(is_numeric($address_post_array[0]))
		   {
		
								$sql_search = mysql_query("SELECT t1. * ,t1.id as ResId, t2. * , (
				(
				SUM( `t4`.`score_1` *1 ) + SUM( `t4`.`score_2` *2 ) + SUM( `t4`.`score_3` *3 ) + SUM( `t4`.`score_4` *4 ) + SUM( `t4`.`score_5` *5 )
				) / ( count( `t4`.`review_id` ) )
				) AS Total
				FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_rating AS t4
				WHERE t4.status = '1'
				AND t1.id = t2.restaurant_id
				AND t1.id = t4.restaurant_id
				AND t1.id = t3.restaurant_id
				AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_zipcode='".$address_post_array[0]."'
				GROUP BY t3.restaurant_id
				ORDER BY Total DESC   LIMIT ".$frm." ,".$num_item);
		   }
		   else
		   {
			    	if($address_post_array[2]!="")
					{
						$sql_search = mysql_query("SELECT t1. * ,t1.id as ResId, t2. * , (
						(
						SUM( `t4`.`score_1` *1 ) + SUM( `t4`.`score_2` *2 ) + SUM( `t4`.`score_3` *3 ) + SUM( `t4`.`score_4` *4 ) + SUM( `t4`.`score_5` *5 )
						) / ( count( `t4`.`review_id` ) )
						) AS Total
						FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_rating AS t4
						WHERE t4.status = '1'
						AND t1.id = t2.restaurant_id
						AND t1.id = t4.restaurant_id
						AND t1.id = t3.restaurant_id
						AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."' AND t1.restaurant_state='".$address_post_array[1]."' AND t1.restaurant_zipcode='".$address_post_array[2]."'
						GROUP BY t3.restaurant_id
						ORDER BY Total DESC   LIMIT ".$frm." ,".$num_item);
						
					}
					else if($address_post_array[1]!="")
					{
						$sql_search = mysql_query("SELECT t1. * ,t1.id as ResId, t2. * , (
						(
						SUM( `t4`.`score_1` *1 ) + SUM( `t4`.`score_2` *2 ) + SUM( `t4`.`score_3` *3 ) + SUM( `t4`.`score_4` *4 ) + SUM( `t4`.`score_5` *5 )
						) / ( count( `t4`.`review_id` ) )
						) AS Total
						FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_rating AS t4
						WHERE t4.status = '1'
						AND t1.id = t2.restaurant_id
						AND t1.id = t4.restaurant_id
						AND t1.id = t3.restaurant_id
						AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."' AND t1.restaurant_state='".$address_post_array[1]."'
						GROUP BY t3.restaurant_id
						ORDER BY Total DESC   LIMIT ".$frm." ,".$num_item);
						
					}
					else if($address_post_array[0]!="")
					{
						$sql_search = mysql_query("SELECT t1. * ,t1.id as ResId, t2. * , (
						(
						SUM( `t4`.`score_1` *1 ) + SUM( `t4`.`score_2` *2 ) + SUM( `t4`.`score_3` *3 ) + SUM( `t4`.`score_4` *4 ) + SUM( `t4`.`score_5` *5 )
						) / ( count( `t4`.`review_id` ) )
						) AS Total
						FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_rating AS t4
						WHERE t4.status = '1'
						AND t1.id = t2.restaurant_id
						AND t1.id = t4.restaurant_id
						AND t1.id = t3.restaurant_id
						AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."'
						GROUP BY t3.restaurant_id
						ORDER BY Total DESC   LIMIT ".$frm." ,".$num_item);
					}
		   }

                
                while ($res_array = mysql_fetch_array($sql_search)) {
					$res_add = $res_array['restaurant_address']." ".$res_array['restaurant_city']." ".$res_array['restaurant_state']." ".$res_array['restaurant_zipcode']." ".$res_array['restaurant_country'];
					
					
					
					
                    $distance = distance($address_post, $res_add);
                    if ($distance <= $search_distance['search_mile']) {
						
						$sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '" . $res_array['id'] . "' AND status = 1");
						$no_reviews = mysql_num_rows($sql_reviews);
						$rating = number_format(getRestaurantRating($res_array['id']), 1);
						
						$address = $res_array['restaurant_address']." ".$res_array['restaurant_city']." ".$res_array['restaurant_state']." ".$res_array['restaurant_zipcode'];
						
						$timezone = getTimezone($address);

						if ($timezone != '') {
							date_default_timezone_set($timezone);
						} else {
							date_default_timezone_set('America/Chicago');
						}

						$current_time = date('h:i A');
						$today = date('l');

						$current_time1 = DateTime::createFromFormat('H:i A', $current_time);
						$day = strtolower(substr($today, 0, 3));

						$sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '" . $res_array['id'] . "' AND holiday_date = '" . date('Y-m-d') . "'");
						$restaurant_holiday = '';
						while ($array_holidays = mysql_fetch_array($sql_holidays)) {
							$holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
							$holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);

							if ($current_time1 > $holiday_from && $current_time1 < $holiday_to) {
								$restaurant_holiday = 'close';
							}
						}
						$restaurant_status = '';
						if ($restaurant_holiday != 'close') {
							$sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '" . strtolower($today) . "'"));
							$sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $res_array['ResId'] . "'");
							
							while ($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)) {
								$new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
								$new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);

								if ($current_time1 > $new_from_tm && $current_time1 < $new_to_tm) {
									$restaurant_status = 'open';
								}
								else
								{
									$restaurant_status = 'close';
								}
							}
						} else {
							$restaurant_status = 'close';
						}
						
						$sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $res_array['ResId'] . "' ORDER BY delivery_range");
						$del_fee = 0.00;
						while ($array_del_charge = mysql_fetch_array($sql_del_crge)) {
							if ($distance <= (float)$array_del_charge['delivery_range']) {
								$del_fee = $array_del_charge['delivery_charge'];
								break;
							}
						}
						
						if ($res_array['minimum_ammount'] != "")
						{
							$del_min = number_format($res_array['minimum_ammount'], 2);
						}
						else
						{
							$del_min = "0.00";
						}
						
						
						$rating = number_format(getRestaurantRating($res_array['restaurant_id']),1);
$total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$res_array['restaurant_id']."' AND status=1"));



$total_coupon=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_coupon`  where restaurant_id='".$res_array['restaurant_id']."'"));

if($total_coupon==0 || $total_coupon=="")
{
	$is_coupan="false";
	$coupon_count=0;
}
else
   {
	$is_coupan="true";
	$coupon_count=$total_coupon;   
   }



$total_hot_deals=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_deals`   where restaurant_id='".$res_array['restaurant_id']."'"));

if($total_hot_deals==0 || $total_hot_deals=="")
{
	$is_hot_deals="false";
	$hotdeal_count=0;
}
else
   {
	$is_hot_deals="true";
	$hotdeal_count=$total_hot_deals;   
   }





		//$foodandmenu['resall']['rating_this_restaurant'] =$rating;
		//$foodandmenu['resall']['review_this_restaurant'] =$total_review;
						
						
						
						
						
						if($res_array['tax']=="")
						$res_array['tax']=0.00;
						
						
                        array_push($foodandmenu['resall'], array(
						'restaurant_rating' => $rating,
						'restaurant_id' => $res_array['restaurant_id'],
						'restaurant_name' => html_entity_decode(htmlspecialchars(stripslashes($res_array['restaurant_name']))),
						'is_success' =>'true',
						'is_coupan' =>$is_coupan,
						'coupon_count' =>$coupon_count,
						'is_hot_deals' =>$is_hot_deals,
						'hotdeal_count' =>$hotdeal_count,
						'message' =>'message1',
						'restaurant_del_min_km'=>$distance,
						'phone' => $res_array['phone'],
						'tax' => $res_array['tax'],
						'delivery' => $res_array['delivery'],
						'pickup' => $res_array['pickup'],
						'restaurant_category' => $res_array['restaurant_category_name'],
						'restaurant_image' => "https://foodandmenu.com/uploaded_images/".$res_array['restaurant_image'],
						'restaurant_address' => $address,
						'restaurant_reviews' => $total_review,
						'restaurant_open_status' => $restaurant_status,
						'restaurant_del_min' => $del_min,
						'restaurant_del_fee' => strval($del_fee),
						'commission' => $res_array['commission'],
						'credit_card_fee' => $res_array['credit_card_fee'],
						'service_fee' => $res_array['service_fee'],
						'distance' => strval($distance)
						));
						
						
						
						
						
						
						
                    }
                }
                
				
				
				
				/*function aasort (&$array, $key) {
					$sorter=array();
					$ret=array();
					reset($array);
					foreach ($array as $ii => $va) {
						$sorter[$ii]=$va[$key];
					}
					asort($sorter);
					foreach ($sorter as $ii => $va) {
						$ret[$ii]=$array[$ii];
					}
					$array=$ret;
				}
				
				
				 aasort($foodandmenu['resall'],"restaurant_rating");
				 print_r($foodandmenu['resall']);*/
				
				
				
		return $foodandmenu['resall'];
	
	}
}





class hot_resinfo 
{function hot_allResval($log)
	{
		
		$search_distance = mysql_fetch_assoc(mysql_query("SELECT search_mile FROM restaurant_admin WHERE id = 1"));
		//===============Code same as Location search===========//
		$address_post=$_REQUEST['address'];
		
		$address_str_array=explode(",",$_REQUEST['address']);

		 if(sizeof($address_str_array)== 1)
			{
			$address_post_array=explode(" ",$address_post);
			 If(sizeof($address_post_array)> 2)
			  {
			 $address_post_array=array_slice($address_post_array, 0, 2);
			 //print_r($address_post_array);
			 // exit;
			  }
			}
		else
			{
			$address_str = str_replace(",","",$address_post);
			$address_post_array=explode(" ",$address_str);
			
			If(is_numeric($address_post_array[2]))
				{
				//$address_post_array=array_slice($address_post_array, 0, 3);
				$var = $address_post_array[2];
				$address_post_array=array();
				array_push($address_post_array,$var);
				//print_r($address_post_array);
				} 
				else 
				{
				$address_post_array=array_slice($address_post_array, 0, 2);
				//print_r($address_post_array);
				//exit;
				}
 			}
		/* $address_post=$_REQUEST['address'];
		$address_str_array=explode(",",$_REQUEST['address']);

		if(sizeof($address_str_array)== 1)
			{
			$address_post_array=explode(" ",$address_post);
			//print_r($address_post_array);
		    //exit;
			}
		else
			{
			$address_str = str_replace(" ","",$address_post);
			$address_post_array=explode(",",$address_str);
			
 			}

		If(sizeof($address_post_array)> 2)
		{
			$address_post_array=array_slice($address_post_array, 0, 2);
		} */
		  
		//===============End Code same as Location search===========//
		//===============Previous code By Debashis==================//
		//$address_post = str_replace("_"," ",$_REQUEST['address']);
		//$address_post_array=explode(" ",$address_post);
		//===============Previous code end By Debashis==================//
		
		
		
		if($_REQUEST['pageCount']==1)
		{
		$num_item=$_REQUEST['pageCount']*10;
		$frm=0;
		}
		else
		   {
			$frm1=$_REQUEST['pageCount']-1;
			$frm=$frm1*10;
			$num_item=10;  
		   }
		
		
		
		
		
		$_SESSION['address'] = $address_post;
		
		/*$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' .$address_post. '&sensor=false');
		
		$output = json_decode($geocode);
		
		$lat = $output->results[0]->geometry->location->lat;
		$long = $output->results[0]->geometry->location->lng;*/
		
		$foodandmenu['resall'] = array();
		
		 if(is_numeric($address_post_array[0]))
		   {
			   
				$sql_search = mysql_query("SELECT t1 . * , t1.id as ResId, t2 . * , COUNT( t4.id ) AS pit1
				FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_deals AS t4
				WHERE t1.id = t4.restaurant_id
				AND t1.id = t2.restaurant_id
				AND t1.id = t3.restaurant_id
				AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_zipcode='".$address_post_array[0]."'
				GROUP BY t3.restaurant_id ORDER BY pit1 DESC LIMIT ".$frm." ,".$num_item);
		   }
		   else
		   {
			    if($address_post_array[2]!="")
				{
					$sql_search = mysql_query("SELECT t1 . * , t1.id as ResId, t2 . * , COUNT( t4.id ) AS pit1
					FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_deals AS t4
					WHERE t1.id = t4.restaurant_id
					AND t1.id = t2.restaurant_id
					AND t1.id = t3.restaurant_id
					AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."' AND t1.restaurant_state='".$address_post_array[1]."' AND t1.restaurant_zipcode='".$address_post_array[2]."'
					GROUP BY t3.restaurant_id ORDER BY pit1 DESC LIMIT ".$frm." ,".$num_item);
				}
				 else if($address_post_array[1]!="")
				{
					$sql_search = mysql_query("SELECT t1 . * , t1.id as ResId, t2 . * , COUNT( t4.id ) AS pit1
					FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_deals AS t4
					WHERE t1.id = t4.restaurant_id
					AND t1.id = t2.restaurant_id
					AND t1.id = t3.restaurant_id
					AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."' AND t1.restaurant_state='".$address_post_array[1]."'
					GROUP BY t3.restaurant_id ORDER BY pit1 DESC LIMIT ".$frm." ,".$num_item);
				}
				 else if($address_post_array[0]!="")
				{
					$sql_search = mysql_query("SELECT t1 . * , t1.id as ResId, t2 . * , COUNT( t4.id ) AS pit1
					FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_deals AS t4
					WHERE t1.id = t4.restaurant_id
					AND t1.id = t2.restaurant_id
					AND t1.id = t3.restaurant_id
					AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."'
					GROUP BY t3.restaurant_id ORDER BY pit1 DESC LIMIT ".$frm." ,".$num_item);
				}
		   }

                
                while ($res_array = mysql_fetch_array($sql_search)) {
					$res_add = $res_array['restaurant_address']." ".$res_array['restaurant_city']." ".$res_array['restaurant_state']." ".$res_array['restaurant_zipcode']." ".$res_array['restaurant_country'];
					
					
					
					
                    $distance = distance($address_post, $res_add);
                    if ($distance <= $search_distance['search_mile']) {
						
						$sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '" . $res_array['id'] . "' AND status = 1");
						$no_reviews = mysql_num_rows($sql_reviews);
						$rating = number_format(getRestaurantRating($res_array['id']), 1);
						
						$address = $res_array['restaurant_address']." ".$res_array['restaurant_city']." ".$res_array['restaurant_state']." ".$res_array['restaurant_zipcode'];
						
						$timezone = getTimezone($address);

						if ($timezone != '') {
							date_default_timezone_set($timezone);
						} else {
							date_default_timezone_set('America/Chicago');
						}

						$current_time = date('h:i A');
						$today = date('l');

						$current_time1 = DateTime::createFromFormat('H:i A', $current_time);
						$day = strtolower(substr($today, 0, 3));

						$sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '" . $res_array['ResId'] . "' AND holiday_date = '" . date('Y-m-d') . "'");
						$restaurant_holiday = '';
						while ($array_holidays = mysql_fetch_array($sql_holidays)) {
							$holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
							$holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);

							if ($current_time1 > $holiday_from && $current_time1 < $holiday_to) {
								$restaurant_holiday = 'close';
							}
						}
						$restaurant_status = '';
						if ($restaurant_holiday != 'close') {
							$sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '" . strtolower($today) . "'"));
							$sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $res_array['id'] . "'");
							
							while ($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)) {
								$new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
								$new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);

								if ($current_time1 > $new_from_tm && $current_time1 < $new_to_tm) {
									$restaurant_status = 'open';
								}
								else
								{
									$restaurant_status = 'close';
								}
							}
						} else {
							$restaurant_status = 'close';
						}
						
						$sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $res_array['ResId'] . "' ORDER BY delivery_range");
						$del_fee = 0.00;
						while ($array_del_charge = mysql_fetch_array($sql_del_crge)) {
							if ($distance <= (float)$array_del_charge['delivery_range']) {
								$del_fee = $array_del_charge['delivery_charge'];
								break;
							}
						}
						
						if ($res_array['minimum_ammount'] != "")
						{
							$del_min = number_format($res_array['minimum_ammount'], 2);
						}
						else
						{
							$del_min = "0.00";
						}
						
						
						$rating = number_format(getRestaurantRating($res_array['restaurant_id']),1);
$total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$res_array['restaurant_id']."' AND status=1"));



$total_coupon=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_coupon`  where restaurant_id='".$res_array['restaurant_id']."'"));

if($total_coupon==0 || $total_coupon=="")
{
	$is_coupan="false";
	$coupon_count=0;
}
else
   {
	$is_coupan="true";
	$coupon_count=$total_coupon;   
   }



$total_hot_deals=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_deals`   where restaurant_id='".$res_array['restaurant_id']."'"));

if($total_hot_deals==0 || $total_hot_deals=="")
{
	$is_hot_deals="false";
	$hotdeal_count=0;
}
else
   {
	$is_hot_deals="true";
	$hotdeal_count=$total_hot_deals;   
   }





		//$foodandmenu['resall']['rating_this_restaurant'] =$rating;
		//$foodandmenu['resall']['review_this_restaurant'] =$total_review;
						
						
						
						
						if($res_array['tax']=="")
						$res_array['tax']=0.00;
						
						
                        array_push($foodandmenu['resall'], array(
						'restaurant_id' => $res_array['restaurant_id'],
						'restaurant_name' => html_entity_decode(htmlspecialchars(stripslashes($res_array['restaurant_name']))),
						'is_success' =>'true',
						'is_coupan' =>$is_coupan,
						'coupon_count' =>$coupon_count,
						'hotdeal_count' =>$res_array['pit1'],
						'message' =>'message1',
						'restaurant_del_min_km'=>$distance,
						'phone' => $res_array['phone'],
						'tax' => $res_array['tax'],
						'delivery' => $res_array['delivery'],
						'pickup' => $res_array['pickup'],
						'restaurant_category' => $res_array['restaurant_category_name'],
						'restaurant_image' => "https://foodandmenu.com/uploaded_images/".$res_array['restaurant_image'],
						'restaurant_address' => $address,
						'restaurant_reviews' => $total_review,
						'restaurant_rating' => $rating,
						'restaurant_open_status' => $restaurant_status,
						'restaurant_del_min' => $del_min,
						'restaurant_del_fee' => strval($del_fee),
						'commission' => $res_array['commission'],
						'credit_card_fee' => $res_array['credit_card_fee'],
						'service_fee' => $res_array['service_fee'],
						'distance' => strval($distance)
						));
                    
					  
					}
                }
                
		return $foodandmenu['resall'];
	
	}
}

class coupan_resinfo 
{
	function coupan_allResval($log)
	{
		
		$search_distance = mysql_fetch_assoc(mysql_query("SELECT search_mile FROM restaurant_admin WHERE id = 1"));
		
		//===============Code same as Location search===========//
		$address_post=$_REQUEST['address'];
		
		$address_str_array=explode(",",$_REQUEST['address']);

		 if(sizeof($address_str_array)== 1)
			{
			$address_post_array=explode(" ",$address_post);
			 If(sizeof($address_post_array)> 2)
			  {
			 $address_post_array=array_slice($address_post_array, 0, 2);
			 //print_r($address_post_array);
			 // exit;
			  }
			}
		else
			{
			$address_str = str_replace(",","",$address_post);
			$address_post_array=explode(" ",$address_str);
			
			If(is_numeric($address_post_array[2]))
				{
				//$address_post_array=array_slice($address_post_array, 0, 3);
				$var = $address_post_array[2];
				$address_post_array=array();
				array_push($address_post_array,$var);
				//print_r($address_post_array);
				} 
				else 
				{
				$address_post_array=array_slice($address_post_array, 0, 2);
				//print_r($address_post_array);
				//exit;
				}
 			}
		/* $address_post=$_REQUEST['address'];
		$address_str_array=explode(",",$_REQUEST['address']);

		if(sizeof($address_str_array)== 1)
			{
			$address_post_array=explode(" ",$address_post);
			//print_r($address_post_array);
		    //exit;
			}
		else
			{
			$address_str = str_replace(" ","",$address_post);
			$address_post_array=explode(",",$address_str);
			
 			}

		If(sizeof($address_post_array)> 2)
		{
			$address_post_array=array_slice($address_post_array, 0, 2);
		} */
		  
		//===============End Code same as Location search===========//
		//===============Previous code By Debashis==================//
		//$address_post = str_replace("_"," ",$_REQUEST['address']);
		//$address_post_array=explode(" ",$address_post);
		//===============Previous code end By Debashis==================//
		if($_REQUEST['pageCount']==1)
		{
		$num_item=$_REQUEST['pageCount']*10;
		$frm=0;
		}
		else
	   {
		$frm1=$_REQUEST['pageCount']-1;
		$frm=$frm1*10;
		$num_item=10;  
	   }

	   $_SESSION['address'] = $address_post;
		
		/*$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' .$address_post. '&sensor=false');
		
		$output = json_decode($geocode);
		
		$lat = $output->results[0]->geometry->location->lat;
		$long = $output->results[0]->geometry->location->lng;*/
		
		$foodandmenu['resall'] = array();
		
		if(is_numeric($address_post_array[0]))
		   {
                $sql_search = mysql_query("SELECT t1. * , t1.id as ResId, t2. * , COUNT(t4.id) as pit
				FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_coupon AS t4
				WHERE t3.restaurant_id = t1.id
				AND t1.id = t2.restaurant_id
				AND t1.id = t3.restaurant_id
				GROUP BY t3.restaurant_id
				AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_zipcode='".$address_post_array[0]."'
				ORDER BY pit DESC LIMIT ".$frm." ,".$num_item);
		   }
		   else
		   {
			   if($address_post_array[2]!="")
				{
					 $sql_search = mysql_query("SELECT t1. * , t1.id as ResId, t2. * , COUNT(t4.id) as pit
				FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_coupon AS t4
				WHERE t3.restaurant_id = t1.id
				AND t1.id = t2.restaurant_id
				AND t1.id = t3.restaurant_id
				GROUP BY t3.restaurant_id
				AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."' AND t1.restaurant_state='".$address_post_array[1]."' AND t1.restaurant_zipcode='".$address_post_array[2]."'
				ORDER BY pit DESC LIMIT ".$frm." ,".$num_item);
				}
				else if($address_post_array[1]!="")
				{
					 $sql_search = mysql_query("SELECT t1. * , t1.id as ResId, t2. * , COUNT(t4.id) as pit
				FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_coupon AS t4
				WHERE t3.restaurant_id = t1.id
				AND t1.id = t2.restaurant_id
				AND t1.id = t3.restaurant_id
				GROUP BY t3.restaurant_id
				AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."' AND t1.restaurant_state='".$address_post_array[1]."'
				ORDER BY pit DESC LIMIT ".$frm." ,".$num_item);
				}
				 else if($address_post_array[0]!="")
				{
					 $sql_search = mysql_query("SELECT t1. * , t1.id as ResId, t2. * , COUNT(t4.id) as pit
				FROM restaurant_basic_info AS t1, restaurant_business_delivery_takeout_info AS t2, restaurant_services_dress_payment AS t3, restaurant_coupon AS t4
				WHERE t3.restaurant_id = t1.id
				AND t1.id = t2.restaurant_id
				AND t1.id = t3.restaurant_id
				GROUP BY t3.restaurant_id
				AND (t2.delivery = 1 OR t2.pickup = 1) AND t1.featured_status = 1 AND t1.restaurant_city='".$address_post_array[0]."'
				ORDER BY pit DESC LIMIT ".$frm." ,".$num_item);
				}
		   }

                
                while ($res_array = mysql_fetch_array($sql_search)) {
					$res_add = $res_array['restaurant_address']." ".$res_array['restaurant_city']." ".$res_array['restaurant_state']." ".$res_array['restaurant_zipcode']." ".$res_array['restaurant_country'];
					
										
					
                    $distance = distance($address_post, $res_add);
                    if ($distance <= $search_distance['search_mile']) {
						
						$sql_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '" . $res_array['id'] . "' AND status = 1");
						$no_reviews = mysql_num_rows($sql_reviews);
						$rating = number_format(getRestaurantRating($res_array['id']), 1);
						
						$address = $res_array['restaurant_address']." ".$res_array['restaurant_city']." ".$res_array['restaurant_state']." ".$res_array['restaurant_zipcode'];
						
						$timezone = getTimezone($address);

						if ($timezone != '') {
							date_default_timezone_set($timezone);
						} else {
							date_default_timezone_set('America/Chicago');
						}

						$current_time = date('h:i A');
						$today = date('l');

						$current_time1 = DateTime::createFromFormat('H:i A', $current_time);
						$day = strtolower(substr($today, 0, 3));

						$sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '" . $res_array['id'] . "' AND holiday_date = '" . date('Y-m-d') . "'");
						$restaurant_holiday = '';
						while ($array_holidays = mysql_fetch_array($sql_holidays)) {
							$holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
							$holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);

							if ($current_time1 > $holiday_from && $current_time1 < $holiday_to) {
								$restaurant_holiday = 'close';
							}
						}
						$restaurant_status = '';
						if ($restaurant_holiday != 'close') {
							$sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '" . strtolower($today) . "'"));
							$sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $res_array['ResId'] . "'");
							
							while ($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)) {
								$new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
								$new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);

								if ($current_time1 > $new_from_tm && $current_time1 < $new_to_tm) {
									$restaurant_status = 'open';
								}
								else
								{
									$restaurant_status = 'close';
								}
							}
						} else {
							$restaurant_status = 'close';
						}
						
						$sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $res_array['ResId'] . "' ORDER BY delivery_range");
						$del_fee = 0.00;
						while ($array_del_charge = mysql_fetch_array($sql_del_crge)) {
							if ($distance <= (float)$array_del_charge['delivery_range']) {
								$del_fee = $array_del_charge['delivery_charge'];
								break;
							}
						}
						
						if ($res_array['minimum_ammount'] != "")
						{
							$del_min = number_format($res_array['minimum_ammount'], 2);
						}
						else
						{
							$del_min = "0.00";
						}
						
						
						$rating = number_format(getRestaurantRating($res_array['restaurant_id']),1);
$total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$res_array['restaurant_id']."' AND status=1"));



$total_coupon=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_coupon`  where restaurant_id='".$res_array['restaurant_id']."'"));

if($total_coupon==0 || $total_coupon=="")
{
	$is_coupan="false";
	$coupon_count=0;
}
else
   {
	$is_coupan="true";
	$coupon_count=$total_coupon;   
   }



$total_hot_deals=mysql_num_rows(mysql_query("SELECT * FROM `restaurant_deals`   where restaurant_id='".$res_array['restaurant_id']."'"));

if($total_hot_deals==0 || $total_hot_deals=="")
{
	$is_hot_deals="false";
	$hotdeal_count=0;
}
else
   {
	$is_hot_deals="true";
	$hotdeal_count=$total_hot_deals;   
   }





		//$foodandmenu['resall']['rating_this_restaurant'] =$rating;
		//$foodandmenu['resall']['review_this_restaurant'] =$total_review;
						
						
						
						
						
						
						
						if($res_array['tax']=="")
						$res_array['tax']=0.00;
												
                        array_push($foodandmenu['resall'], array(
						'restaurant_id' => $res_array['restaurant_id'],
						'restaurant_name' => html_entity_decode(htmlspecialchars(stripslashes($res_array['restaurant_name']))),
						'is_success' =>'true',
						'coupon_count' =>$res_array['pit'],
						'is_hot_deals' =>$is_hot_deals,
						'hotdeal_count' =>$hotdeal_count,
						'message' =>'message1',
						'restaurant_del_min_km'=>$distance,
						'phone' => $res_array['phone'],
						'tax' => $res_array['tax'],
						'delivery' => $res_array['delivery'],
						'pickup' => $res_array['pickup'],
						'restaurant_category' => $res_array['restaurant_category_name'],
						'restaurant_image' => "https://foodandmenu.com/uploaded_images/".$res_array['restaurant_image'],
						'restaurant_address' => $address,
						'restaurant_reviews' => $total_review,
						'restaurant_rating' => $rating,
						'restaurant_open_status' => $restaurant_status,
						'restaurant_del_min' => $del_min,
						'restaurant_del_fee' => strval($del_fee),
						'commission' => $res_array['commission'],
						'credit_card_fee' => $res_array['credit_card_fee'],
						'service_fee' => $res_array['service_fee'],
						'distance' => strval($distance)
						));
                    
					
					
					
					}
                }
                
		return $foodandmenu['resall'];
	
	}
}






























class ginfo 
{
	function saveg($log)
	{
		$id = $_REQUEST['oauth_uid'];
$email = $_REQUEST['email'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$gender = $_REQUEST['gender'];
$provider = $_REQUEST['provider'];
$city = $_REQUEST['city'];


$foodandmenu['resall'] = array();

$sql_select = mysql_query("SELECT * FROM restaurant_customer WHERE oauth_uid = '".$id."'");
//$sql_select1 = mysql_query("SELECT * FROM restaurant_customer WHERE email= '".$email."'");
$num_rows = mysql_num_rows($sql_select);
//$num_rows1 = mysql_num_rows($sql_select1);
$row_select = mysql_fetch_array($sql_select);

if($num_rows == 0){
	
	$sql_insert_customer = mysql_query("INSERT INTO restaurant_customer SET firstname = '".mysql_real_escape_string($first_name)."' , lastname = '".mysql_real_escape_string($last_name)."', email = '".$email."' , gender = '".$gender."' , oauth_uid = '".$id."' , oauth_provider = '".$provider."' , 	registration_time = NOW() , city = '".$city."' , status = '1' , last_logged_in = '".date('Y-m-d H:i:s')."'");
	$customer_id = mysql_insert_id();
	$_SESSION['customer_id'] = $last_id;
	$sql_select = mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$customer_id."'");
	$row_select = mysql_fetch_array($sql_select);
	
	$foodandmenu['resall']['customer_id'] =$customer_id;

	
	
	
	
	
}
else{
	$foodandmenu['resall']['Message'] ="user already exists";
	
}


                       
		return $foodandmenu['resall'];
	}
	
}





class lastdeliveryaddress 
{
	function ldeliveryaddress($log)
	{
		if($_REQUEST['customer_id']!="")
		{
		$resorder=mysql_fetch_array(mysql_query("SELECT *
FROM `restaurant_menu_order`
WHERE `customer_id` ='".$_REQUEST['customer_id']."' 
ORDER BY `restaurant_menu_order`.`order_id` DESC
LIMIT 0 , 1")); 




$resorder1=mysql_fetch_array(mysql_query("SELECT *
FROM `restaurant_order_contact_details`
WHERE `contact_det_id` ='".$resorder['order_id']."'
LIMIT 0 , 1"));
		
$foodandmenu['resall']['d_phone']=$resorder1["phone"];
$foodandmenu['resall']['d_city']=$resorder1["city"];
$foodandmenu['resall']['d_state']=$resorder1["state"];
$foodandmenu['resall']['d_apt_name']=$resorder1["apt_name"];
$foodandmenu['resall']['d_apt_no']=$resorder1["apt_no"];
$foodandmenu['resall']['d_zipcode']=$resorder1["zipcode"];



$resorder2=mysql_fetch_array(mysql_query("SELECT *
FROM `restaurant_customer`
WHERE `id` ='".$_REQUEST['customer_id']."'"));


$foodandmenu['resall']['billing_address']=$resorder2["billing_address"];
$foodandmenu['resall']['billing_home_apartment']=$resorder2["billing_home_apartment"];
$foodandmenu['resall']['billing_apt_name']=$resorder2["billing_apt_name"];
$foodandmenu['resall']['billing_apt_no']=$resorder2["billing_apt_no"];
$foodandmenu['resall']['billing_phone']=$resorder2["billing_phone"];
$foodandmenu['resall']['billing_state']=$resorder2["billing_state"];
$foodandmenu['resall']['billing_state']=$resorder2["billing_state"];
$foodandmenu['resall']['billing_city']=$resorder2["billing_city"];
$foodandmenu['resall']['billing_zip']=$resorder2["billing_zip"];








                       
		return $foodandmenu['resall'];
		}
	}
	
}








































class resdetail1 
{
	function restaurant_detail1($log){
		$restaurant_id = $_REQUEST['id'];
		$sql_resataurant_menu_category = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id = '".$restaurant_id."' ORDER BY show_order ");
		$foodandmenu['resall'] = array();
		while($array_menu_category = mysql_fetch_array($sql_resataurant_menu_category)){
			$sql_restaurant_menu_subcategory = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE restaurant_id = '".$restaurant_id."' AND category_id = '".$array_menu_category['id']."' ORDER BY show_order ");
			
			$foodandmenu['subcat'] = array();
			while($array_menu_subcategory = mysql_fetch_array($sql_restaurant_menu_subcategory)){
			$sql_restauarnt_menu = mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '".$restaurant_id."' AND category_id = '".$array_menu_category['id']."' AND sub_category_id = '".$array_menu_subcategory['id']."' ORDER BY show_order");
			$foodandmenu['menu_item'] = array();
				while($array_restaurant_menu = mysql_fetch_array($sql_restauarnt_menu)){
					$sql_special_ins = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE restaurant_id = '".$restaurant_id."' AND menu_id = '".$array_restaurant_menu['id']."' ");
					$foodandmenu['spl_ins'] = array();
					while($array_special_ins = mysql_fetch_array($sql_special_ins)){
						$sql_special_ins_option = mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE restaurant_id = '".$restaurant_id."' AND special_ins_id = '".$array_special_ins['id']."' ");
						
						$foodandmenu['spl_ins_option'] = array();
						while($array_special_ins_option = mysql_fetch_array($sql_special_ins_option)){
							array_push($foodandmenu['spl_ins_option'], array(
								'id' => $array_special_ins_option['id'],
								'title' => html_entity_decode(htmlspecialchars(stripslashes($array_special_ins_option['title']))),
								'price' => $array_special_ins_option['price'],
								'show_order' => $array_special_ins_option['show_order'],
								));
						}
						array_push($foodandmenu['spl_ins'], array(
								'special_instruction' => html_entity_decode(htmlspecialchars(stripslashes($array_special_ins['special_instruction']))),
								$foodandmenu['spl_ins_option']
								));
					}
					//if($array_restaurant_menu['price']=="")
					//$array_restaurant_menu['price']="0.00";
					 array_push($foodandmenu['menu_item'], array(
								'menu_id' => $array_restaurant_menu['id'],
								'menu_name' => html_entity_decode(htmlspecialchars(stripslashes($array_restaurant_menu['menu_name']))),
								'price' => $array_restaurant_menu['price'],
								'description' => html_entity_decode(htmlspecialchars(stripslashes($array_restaurant_menu['description']))),
								'menu_pic' => $array_restaurant_menu['menu_pic'],
								'whats_good' => $array_restaurant_menu['whats_good'],
								'spicy' => $array_restaurant_menu['spicy'],
								'veggie' => $array_restaurant_menu['veggie'],
								'healthy' => $array_restaurant_menu['healthy'],
								$foodandmenu['spl_ins']
								));
				}
				array_push($foodandmenu['subcat'], array(
						'subcategory_name' => $array_menu_subcategory['subcategory_name'],
						$foodandmenu['menu_item']
						));
				
			}
			
			array_push($foodandmenu['resall'], array(
						'category_name' => $array_menu_category['category_name'],$foodandmenu['subcat']
						));
			
			
		}
		 if(empty($foodandmenu['resall']))
		  {
		 $foodandmenu['resall']['msg']="No Menu List";
		  }
	 return $foodandmenu['resall'];
	
	}
	
}

class resdeals 
{
	function restaurant_deals($log){
		$restaurant_id = $_REQUEST['id'];
		$sql_select_deal = mysql_query("SELECT * FROM restaurant_deals WHERE deals_status =1 AND daily_name!='' AND restaurant_id = '".$restaurant_id."' AND (expiry_date	> '".date('Y-m-d')."' OR expiry_date = '0000-00-00')");
		 $foodandmenu['restaurant_deals'] = array();
		 while($array_deal = mysql_fetch_array($sql_select_deal)){
			 array_push($foodandmenu['restaurant_deals'], array(
						'deal_name' => $array_deal['daily_name'],
						'deal_image' => $array_deal['daily_picture'],
						'deal_price' => $array_deal['daily_description'],
						'deal_your_price' => $array_deal['daily_price'],
						'deal_expiry_date' => $array_deal['expiry_date'],
						));
		 }
		 
		return $foodandmenu['restaurant_deals'];
	}
	
}



class changepassword 
{
	function do_changepassword($log)
	{
		$user_id=$_REQUEST['user_id'];
		$sql_check_user = mysql_query("SELECT * FROM restaurant_customer WHERE id='".$user_id."' AND password='".md5($_REQUEST['oldpassword'])."'");
		$num_rows_user = mysql_num_rows($sql_check_user);
		 if($num_rows_user==0)
		 {
			 $foodandmenu['restaurant_deals']="Password not match";
		 }
		 else
		    {
				$sql_check_user = mysql_query("UPDATE `restaurant_customer` SET `password` = '".md5($_REQUEST['newpassword'])."' WHERE id='".$user_id."'");
				$foodandmenu['restaurant_deals']="Password changed successfully";
			}
		 
		return $foodandmenu['restaurant_deals'];
	}
	
}























class rescoupon 
{
	function restaurant_coupon($log){
		$restaurant_id = $_REQUEST['id'];
		 $sql_coupons = mysql_query("SELECT * FROM restaurant_coupon WHERE restaurant_id = '".$restaurant_id."' AND coupon_status =1 AND end_date >= '".date('Y-m-d')."' AND show_coupon = 1");
		 $foodandmenu['restaurant_coupon'] = array();
		 while($array_coupon = mysql_fetch_array($sql_coupons)){
			 array_push($foodandmenu['restaurant_coupon'], array(
						'coupon_name' => htmlspecialchars(stripslashes($array_coupon['coupon_name'])),
						'coupon_price' => $array_coupon['coupon_price'],
						'coupon_discount' => $array_coupon['discount'],
						'coupon_code' => $array_coupon['coupon_code'],
						'start_date' => $array_coupon['start_date'],
						'end_date' => $array_coupon['end_date'],
						'coupon_image' => $array_coupon['coupon_image'],
						'coupon_description' => htmlspecialchars(stripslashes($array_coupon['coupon_description'])),
						'minimum_order_amount' => $array_coupon['minimum_order_amount'],
						
						));
		 }
		 
		return $foodandmenu['restaurant_coupon'];
	}
	
}

class reslogin
{
	function restaurant_login($log)
	{
		$username = mysql_real_escape_string($_REQUEST['username']);
		$password = mysql_real_escape_string($_REQUEST['password']);
		
		$check_log = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE email = '".$username."' AND password = '".md5($password)."'"));
					
					if($check_log['id'] > 0)
					{
						$foodandmenu['user_detail'] = array(
							'user_id' => $check_log['id'],
							'username' => $check_log['firstname']." ".$check_log['lastname'],
							'email_id' => $check_log['email'],
							'reward_point' => $check_log['reward_point'],
							'status' => 'success'
						);
					}
					else
					{
						$foodandmenu['user_detail'] = array(
							'status' => 'failure'
						);
					}
					
		return $foodandmenu['user_detail'];
	}
}



class tempaddtocart
{
	function restaurant_order_temp($data)
	{
		$data1=urlencode($data);
	 $ssd="INSERT INTO `temp_restaurant` (`id`, `content`) VALUES (NULL,'".$data1."')";
		
		
		mysql_query($ssd);
		
		$foodandmenu['temp_cart_insert_status']['temp_id']=mysql_insert_id();
		//$foodandmenu['temp_cart_insert_status']=$ssd;
		return $foodandmenu['temp_cart_insert_status'];
	}

}





class thankinfo
{
	function thankval($data)
	{
		$data1=urlencode($data);
	 $ssdf="UPDATE `restaurant_menu_order` SET `status` = 'Confirmed' WHERE `order_id` ='".$_REQUEST['order_id']."'";
		
		
		mysql_query($ssdf);
		
		$foodandmenu['resall']['thankyou']="success";  
		 
	return $foodandmenu['resall'];
	}

}
























class rescouponinfo
{
	function couponval($data)
	{
		$today = date("Y-m-d"); 
	$res_coupon = mysql_fetch_array(mysql_query("SELECT * FROM `restaurant_coupon` WHERE `coupon_code` = '".$_REQUEST['coupon_code']."'AND  CURDATE() < `end_date`"));
	if($res_coupon['coupon_name']!="")
	   {
		$foodandmenu['resall']['coupon_status']="valid";
	   }
	   else
	      {
			$foodandmenu['resall']['coupon_status']="Invalid";  
		  }
	return $foodandmenu['resall'];
	
	
	}

}































class resaddtocart
{
	function restaurant_addtocart($data)
	{
		
		
		$temp_id=$_REQUEST['temp_id'];
		
		
		$order_query="SELECT * FROM `temp_restaurant` WHERE `id`='".$temp_id."'"; 
		$res_order_data=mysql_fetch_array(mysql_query($order_query));
		
		$data_jason=urldecode($res_order_data['content']);
		$data=json_decode($data_jason);
		
		//print_r($data);
		
		  $num_row=count($data->items);
		
		
		for($i=0;$i<=$num_row-1;$i++)
		 {
		
		 $menu_item_id = $data->items[$i]->menuItemId;
		$session_id = rand(11111111,9999999999999999);
		$restaurant_id =$data->restaurantId;
		$menu_price =$data->items[$i]->price;
		$quantity = $data->items[$i]->quantity;
		$price = $menu_price*$quantity;
		$special_ins =$data->items[$i]->specialInstruction;
		$additional_instructions = $data->items[$i]->additionalInstruction;
		
		 $str_additonal_ins = str_replace("-",",",$additional_instructions);
		
		$sql_del_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '" . $restaurant_id . "'"));
		
		$tax = ($sql_del_details['tax'] / 100 * $price);
		 $sql_insert_into_cart = mysql_query("INSERT INTO restaurant_menuitem_cart SET menu_item_id = '" . $menu_item_id . "',session_id = '" . $session_id . "',restaurant_id = '" . $restaurant_id . "',quantity = '" . $quantity . "',special_ins = '" . $special_ins . "' , menu_price = '" . $menu_price . "' , price = '" . $price . "' ,tax = '" . $tax . "' , additional_instructions = '".$str_additonal_ins."' ");
		
		$today = date("Y-m-d");
		
		
		
		
		$sql_insert_into_cart=mysql_query("INSERT INTO `restaurant_menu_order` (`order_id`, `group_id`, `restaurant_id`, `customer_id`, `total_price`, `order_date`, `type`, `delivery_charge`, `tax`, `tip`, `special_delivery_info`, `commission`, `credit_card_fee`, `service_fee`, `status`, `time`, `price_with_del_charge`, `customer_name`, `customer_address`, `customer_phone`, `confirmation_code`, `payment_mode`, `spare_napkins`, `coupon_code`, `coupon_discount`, `reward_points`, `type_order`, `group_order_id`, `group_order_details_id`, `card_type`, `card_no`, `cvv_no`, `expiry_date`) VALUES (NULL, '0', '$data->restaurantId', '$data->customerId', '$data->totalAmount', '$today', '$data->orderType', '$data->deliveryCharge', '$data->tax', '0', '0', '0', '0', '0', 'Pending', '0', '0', '0', '0', '0', '0', 'credit_card', '0', '0', '0', '0', 'live', NULL, NULL, '', '0', '0', '04-17')");
		
		
		 $order_id=mysql_insert_id();
			
			
			
			
			
		mysql_query("DELETE FROM `temp_restaurant` WHERE `id`='".$temp_id."'");	
			
			
			
			
			
			
			
				
		if(!$sql_insert_into_cart){
			$foodandmenu['cart_insert_status'] = array(
							'status' => 'failure',
							'order_id' => $order_id
						);
		}else{
			$foodandmenu['cart_insert_status'] = array(
							'status' => 'success',
							'order_id' => $order_id
						);
		}
		
		return $foodandmenu['cart_insert_status'];
		
	  }    //end--for--loop----------------// 
	}

}

class rescartitems 
{
	function restaurant_cartitems($log){
		 $session_id = $_REQUEST['session_id'];
		 $sql_cart_items = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."'");
		 $foodandmenu['cart_items'] = array();
		 while($array_cart_items = mysql_fetch_array($sql_cart_items)){
			 $array_menu_item_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_cart_items['menu_item_id']."' "));
			 array_push($foodandmenu['cart_items'], array(
			 			'cart_item_id' => $array_cart_items['id'],
						'menu_item_id' => $array_cart_items['menu_item_id'],
						'menu_item_name' => $array_menu_item_name['menu_name'],
						'restaurant_id' => $array_cart_items['restaurant_id'],
						'menu_price' => $array_cart_items['menu_price'],
						'price' => $array_cart_items['price'],
						'tax' => $array_cart_items['tax'],
						'quantity' => $array_cart_items['quantity'],
						'special_ins' => $array_cart_items['special_ins']
						));
		 }
		return $foodandmenu['cart_items'];
	}
}

class resdelcartitems 
{
	function restaurant_delcartitems($log){
		 $cart_item_id = $_REQUEST['cart_item_id'];
		 $sql_delete_cart_items = mysql_query("DELETE FROM restaurant_menuitem_cart WHERE id = '".$cart_item_id."'");
		 if(!$sql_delete_cart_items){
			 $foodandmenu['del_cart_status'] = array(
			 				'status' => 'failure'
			 ); 
		 }else{
			 $foodandmenu['del_cart_status'] = array(
			 				'status' => 'success'
			 );
		 }
		 return $foodandmenu['del_cart_status'];
	}
}

class rescheckpickupdel 
{
	function restaurant_checkpickupdel($log){
		$restaurant_id = $_REQUEST['restaurant_id'];
		$sql_select_add = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" .$restaurant_id. "'"));
		$address = $sql_select_add['restaurant_address'] . " " . $sql_select_add['restaurant_city'] . " " . $sql_select_add['restaurant_state'] . " " . $sql_select_add['restaurant_zipcode'];
		$timezone = getTimezone($address);
		 

		if ($timezone != '') {
			date_default_timezone_set($timezone);
		} else {
			date_default_timezone_set('America/Chicago');
		}

		$current_time_home = date('h:i A');

		$timestamp = time();
		$time = date("G:i:s");
		//$time = "10:15:00";

		$time1 = strtotime($time);
		$today = strtolower(date('l'));

		$day = strtolower(substr($today, 0, 3));

		$sql_bus_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '" . $restaurant_id . "'"));

		$sql_pickup_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_take_out_master WHERE restaurant_id = '" . $restaurant_id . "'"));

		$sql_del_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_delivery_details_master WHERE restaurant_id = '" . $restaurant_id . "'"));

		$time_from_pickup = $sql_pickup_time['from_time_' . $today];
		$time_to_pickup = $sql_pickup_time['to_time_' . $today];

		$time_from_del = $sql_del_time['delivery_from_' . $today];
		$time_to_del = $sql_del_time['delivery_to_' . $today];

		$time_from = $sql_bus_time['business_hours_' . $day . '_from'];
		$time_to = $sql_bus_time['business_hours_' . $day];


		$current_time1 = DateTime::createFromFormat('H:i A', $current_time_home);
		$time1 = DateTime::createFromFormat('H:i A', $time_from_pickup);
		$time2 = DateTime::createFromFormat('H:i A', $time_to_pickup);

		$time3 = DateTime::createFromFormat('H:i A', $time_from_del);
		$time4 = DateTime::createFromFormat('H:i A', $time_to_del);

		$time11 = DateTime::createFromFormat('H:i A', $time_from);
		$time22 = DateTime::createFromFormat('H:i A', $time_to);


		/*************************************** BUSINESS HOURS *********************************** */

		$sql_holidays = mysql_query("SELECT * FROM restaurant_holidays_master WHERE restaurant_id = '" . $restaurant_id . "' AND holiday_date = '" . date('Y-m-d') . "'");
		$restaurant_holiday = '';
		while ($array_holidays = mysql_fetch_array($sql_holidays)) {
			$holiday_from = DateTime::createFromFormat('H:i A', $array_holidays['time_from']);
			$holiday_to = DateTime::createFromFormat('H:i A', $array_holidays['time_to']);

			if ($current_time1 > $holiday_from && $current_time1 < $holiday_to) {
				$restaurant_holiday = 'close';
			}
		}



		if ($restaurant_holiday != 'close') {
			$sql_days = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_days_masters WHERE days = '" . $today . "'"));
			$sql_select_bushrs = mysql_query("SELECT * FROM restaurant_buss_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $restaurant_id . "'");
			$restaurant_status = '';
			while ($array_select_bushrs = mysql_fetch_array($sql_select_bushrs)) {
				$new_from_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_from']);
				$new_to_tm = DateTime::createFromFormat('H:i A', $array_select_bushrs['time_to']);

				if ($current_time1 > $new_from_tm && $current_time1 < $new_to_tm) {
					$restaurant_status = 'open';
				}
			}
		} else {
			$restaurant_status = '';
		}


		$sql_pickup_hrs = mysql_query("SELECT * FROM restaurant_pickup_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $restaurant_id . "'");
		$restaurant_pickup_status = '';
		while ($array_pickup_hrs = mysql_fetch_array($sql_pickup_hrs)) {
			$pickup_from_tm = DateTime::createFromFormat('H:i A', $array_pickup_hrs['time_from']);
			$pickup_to_tm = DateTime::createFromFormat('H:i A', $array_pickup_hrs['time_to']);

			if ($current_time1 > $pickup_from_tm && $current_time1 < $pickup_to_tm) {
				$restaurant_pickup_status = 'open';
			}
		}


		$sql_delivery_hrs = mysql_query("SELECT * FROM restaurant_del_hrs WHERE days_id = '" . $sql_days['id'] . "' AND restaurant_id = '" . $restaurant_id . "'");
		$restaurant_delivery_status = '';
		while ($array_delivery_hrs = mysql_fetch_array($sql_delivery_hrs)) {
			$delivery_from_tm = DateTime::createFromFormat('H:i A', $array_delivery_hrs['time_from']);
			$delivery_to_tm = DateTime::createFromFormat('H:i A', $array_delivery_hrs['time_to']);

			if ($current_time1 > $delivery_from_tm && $current_time1 < $delivery_to_tm) {
				$restaurant_delivery_status = 'open';
			}
		}

		$foodandmenu['restaurant_status'] = array();
		if ($restaurant_status == 'open') {
				array_push($foodandmenu['restaurant_status'],array(
							'rest_status' => 'open'
				));
			if ($restaurant_pickup_status == 'open') {
				array_push($foodandmenu['restaurant_status'],array(
							'pickup' => 'available'
				));
			} else {
				array_push($foodandmenu['restaurant_status'],array(
							'pickup' => 'unavailable'
				));
			}
			if ($restaurant_delivery_status == 'open') {
				array_push($foodandmenu['restaurant_status'],array(
							'delivery' => 'available'
				));
			} else {
				array_push($foodandmenu['restaurant_status'],array(
							'delivery' => 'unavailable'
				));
			}
		} else {
			array_push($foodandmenu['restaurant_status'],array(
							'rest_status' => 'close'
				));
		}
		
		return $foodandmenu['restaurant_status'];
	}
}

class ressignup 
{
	function restaurant_ressignup($log){
		$firstname = mysql_real_escape_string($_REQUEST['firstname']);
		$lastname = mysql_real_escape_string($_REQUEST['lastname']);
		$email = mysql_real_escape_string($_REQUEST['email']);
		$password = md5($_REQUEST['password']);
		$address = mysql_real_escape_string($_REQUEST['address']);
		$phone = mysql_real_escape_string($_REQUEST['phone']);
		$date_of_birth = $_REQUEST['date_of_birth'];
		$state = $_REQUEST['state'];
		$city = $_REQUEST['city'];
		$zip = $_REQUEST['zip'];
		
		$sql_insert_customer = mysql_query("INSERT INTO restaurant_customer SET firstname = '".$firstname."' , lastname = '".$lastname."' , email = '".$email."' , password = '".$password."' , address = '".$address."' , phone = '".$phone."' , date_of_birth = '".$date_of_birth."' , state = '".$state."' , city = '".$city."' , zip = '".$zip."' , status = '1' , registration_time = '".date('Y-m-d H:i:s')."' ");
		$customer_id = mysql_insert_id();
		
		$foodandmenu['signup_status'] = array();
		
		array_push($foodandmenu['signup_status'],array(
							'status' => 'success',
							'customer_id' => $customer_id
				));
				
		return $foodandmenu['signup_status'];
	}
}

class resdelcharge 
{
	function restaurant_resdelcharge($log){
		$restaurant_id = $_REQUEST['restaurant_id'];
		$address_post = $_REQUEST['address'];
		
		$array_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '" . $restaurant_id . "'"));

    	$rest_address = $array_basic_info['restaurant_address'] . "," . $array_basic_info['restaurant_city'] . "," . $array_basic_info['restaurant_state'] . "," . $array_basic_info['restaurant_zipcode'] . "," . $array_basic_info['restaurant_country'];
		
		$start = str_replace(' ', '+', $rest_address);
    	$finish = str_replace('_', '+', $address);
		
	/*	$url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $start . '&destinations=' . $finish . '&mode=driving&language=en&sensor=false';
		$data = file_get_contents($url);
		$data = utf8_decode($data);
		$obj = json_decode($data);
	
		$distance = 0.621371 * ($obj->rows[0]->elements[0]->distance->text);*/
		
		$distance = distance($address_post, $rest_address);
		
		$rest_del_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '" . $restaurant_id . "'"));
		
		$foodandmenu['delivery_charge_status'] = array();
		
		if ($distance == 0) {
        	array_push($foodandmenu['delivery_charge_status'],array(
							'status' => 'error'
				));
   		 }else{
        $sql_del_crge = mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $restaurant_id . "' ORDER BY delivery_range");
        while ($array_del_charge = mysql_fetch_array($sql_del_crge)) {
            if ($distance <= $array_del_charge['delivery_range']) {
                $_SESSION['del_charge_new'] = $array_del_charge['delivery_charge'];
                break;
            }
        }

        $sql_del_charge = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_delivery_charge WHERE restaurant_id = '" . $restaurant_id . "' ORDER BY delivery_range DESC LIMIT 0,1"));   
    }
	
		array_push($foodandmenu['delivery_charge_status'],array(
							'status' => 'success',
							'delivery_charge' => $_SESSION['del_charge_new']
				));
			
		return $foodandmenu['delivery_charge_status'];
	}
}


class resforgot_password 
{
	function restaurant_resforgot_password($log){
		$email = $_REQUEST['email'];
		
		$sql_forgot_pass = "SELECT * FROM  restaurant_customer where email='".$email."'";
		
		$query_pass=mysql_query($sql_forgot_pass);

		$array_forgot_pass=mysql_fetch_array($query_pass);
		
		$no_check=mysql_num_rows($query_pass);
		
		$member_id=$array_forgot_pass['id'];
		
		$name=$array_forgot_pass['firstname'];
		
		$foodandmenu['forgot_password'] = array();
		if($no_check>0)
		{
			$new_password = generateRandomString();
			
			$name = $array_forgot_pass['firstname'].' '.$array_forgot_pass['lastname'];

			$email = $_REQUEST['email'];

			$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #000000;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; padding:0 0px; ">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px; " />
                         <div style="height:15px; background-color:#3F4CA0;"></div>
       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; list-style-type:none; margin:0 0 4px 15px;">Hey '.$name.'</p>

            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; list-style-type:none; margin:0 0 4px 15px;">Please check below for your new password.</p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; list-style-type:none; margin:0 0 4px 15px;">New Password : '.$new_password.'</p>

						<div style="clear:both;"></div>

 						<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #000000;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>

						<div style="clear:both;"></div>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>

							<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>

						<div style="clear:both;"></div>

						</div>

						<div style="clear:both;"></div>

						<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >

						<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">

Sent to you from Food and menu</h4>

					</div>

				</div>

				<div style="clear:both;"></div>

				</div>';
				
			$from = "support@foodandmenu.com";

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

			$message = $cms_rep;

			$subject='Forgot Password Mail';

			mail($email,$subject,$message,$headers);
			
			$sql_update = mysql_query("UPDATE restaurant_customer SET password = '".md5($new_password)."' WHERE email = '".$email."' ");
			
			array_push($foodandmenu['forgot_password'],array(
					'status' => 'success',
					'message' => 'Please check your mail for new password.'
			));
		}else{
			array_push($foodandmenu['forgot_password'],array(
					'status' => 'success',
					'message' => 'The Email Address does not exist.',
			));
		}
		
		return $foodandmenu['forgot_password'];
	}
}

class resreview_rating 
{
	function restaurant_resreview_rating($log){
			
	}
}

class reswrite_review 
{
	function restaurant_write_review($log){
			$post_date = $_REQUEST['post_date'];
			$customer_id = $_REQUEST['customer_id'];
			$customer_review = $_REQUEST['customer_review'];
			$review_image = $_REQUEST['review_image'];
			$restaurant_id = $_REQUEST['restaurant_id'];
			$rate_count = $_REQUEST['rate_count'];
			
			$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$customer_id."' "));
			
			$customer_name = $sql_customer['firstname'];
			$customer_email = $sql_customer['email'];
			$city = $sql_customer['city'];
			$state = $sql_customer['state'];
			$customer_picture = $sql_customer['image'];
			
			$sql_count=mysql_num_rows(mysql_query("select * from restaurant_reviews where customer_id='".$customer_id."' AND restaurant_id='".$restaurant_id."'"));
			$sql_all=mysql_fetch_array(mysql_query("select * from restaurant_reviews where customer_id='".$customer_id."' AND restaurant_id='".$restaurant_id."' ORDER BY ID ASC "));
			
			$restaurant_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$restaurant_id."' "));
			
			$restaurant_name = $restaurant_basic_info['restaurant_name'];
			
			if($sql_count>0)
			{
				$status = 1;
				$parent_id = $sql_all['id'];
			}
			else
			{
				$status = 0;
				$parent_id = 0;
			}
			
			$sql_review = mysql_query("insert into restaurant_reviews set post_date='".$post_date."',customer_name='".$customer_name."',customer_review='".htmlspecialchars(stripslashes($customer_review),ENT_QUOTES)."', customer_picture='".$customer_picture."',restaurant_id='".$restaurant_id."', restaurant_name = '".$restaurant_name."', customer_id='".$customer_id."',status='1', customer_email = '".$customer_email."',city = '".$city."',state = '".$state."', review_status = '".$status."' , parent_id = '".$parent_id."' "); 
			
			$review_id = mysql_insert_id();
	
			if($parent_id == 0){
				$sql_update = mysql_query("UPDATE restaurant_reviews SET score = score+".$rate_count." WHERE id = '".$review_id."' ");
			}else{
				$sql_sel_rev = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$restaurant_id."' AND parent_id = 0 AND customer_id = '".$customer_id."' "));
				$sql_update = mysql_query("UPDATE restaurant_reviews SET score = score+".$rate_count." WHERE id = '".$sql_sel_rev['id']."' ");
			}
			
		
		/*----image-----*/
		foreach($_FILES['documents']['tmp_name'] as $key => $tmp_name)
         {
    $file_name = $key.$_FILES['documents']['name'][$key];
    $file_size =$_FILES['documents']['size'][$key];
    $file_tmp =$_FILES['documents']['tmp_name'][$key];
    $file_type=$_FILES['documents']['type'][$key]; 
    move_uploaded_file($file_tmp,"../uploaded_images/".$file_name);

	$sql_insert_review_images = mysql_query("INSERT INTO restaurant_review_images SET review_id = '".$review_id."' , image = '".$file_name."'");
	//mysql_query("INSERT INTO restaurant_photo SET image_name = '".$file_name."' , restaurant_id = '".$_REQUEST['restaurant_id']."'");	
		
		}
		
		
		
		
		
	
			
			$curr_date = date('Y-m-d');
		
			$sql_mul_reward = mysql_query("SELECT * FROM restaurant_multiple_reward WHERE start_date <= '".$curr_date."' AND end_date >= '".$curr_date."' AND status = '1'");
			
			while($row_mul_reward = mysql_fetch_array($sql_mul_reward))
			{
				 $type_id = explode(",",$row_mul_reward['reward_type']);
				 
				 if(in_array(4 , $type_id))
				 {
					 $point_new = $row_mul_reward['point'];
				 }
				 
				$sql_reward_point = mysql_query("SELECT * FROM restaurant_point_history WHERE user_id = '".$customer_id."' AND reward_id = '".$row_mul_reward['id']."'");
				if(mysql_num_rows($sql_reward_point) > 0){
					$sql_add_point = mysql_query("UPDATE restaurant_point_history SET point_added = point_added+'".$point_new."' WHERE user_id = '".$customer_id."' AND reward_id = '".$row_mul_reward['id']."'");
				}else{
					$sql_add_point = mysql_query("INSERT INTO restaurant_point_history SET point_added = point_added+'".$point_new."' , user_id = '".$customer_id."' , reward_id = '".$row_mul_reward['id']."'");
				}
					 
			}
			
			mysql_query("UPDATE restaurant_basic_info SET reviewed = reviewed + 1 WHERE id = '".$restaurant_id."'");
			mysql_query("UPDATE restaurant_customer SET no_reviews = no_reviews + 1 WHERE id = '".$customer_id."'");
			
			$rating_status = rate($_REQUEST['rate_count'],$restaurant_id, $review_id, $customer_id);
			
			
			$rate = getRestaurantRating($restaurant_id);
			mysql_query("UPDATE restaurant_basic_info SET rated = '".$rate."' WHERE id = '".$restaurant_id."'");
			
			
		$foodandmenu['review_insert_status'] = array();
		
		array_push($foodandmenu['review_insert_status'],array(
							'status' => 'success'
				));
				
		return $foodandmenu['review_insert_status'];		
	
     
  }
}


class res_insert_order 
{
	function restaurant_insert_order($log){
		
		$unique_ref_length = 5;  
	
		// A true/false variable that lets us know if we've  
		// found a unique reference number or not  
		$unique_ref_found = false;  
		  
		// Define possible characters.  
		// Notice how characters that may be confused such  
		// as the letter 'O' and the number zero don't exist  
		$possible_chars = "123456789BCDFGHJKMNPQRSTVWXYZ";  
		
		// Until we find a unique reference, keep generating new ones  
		while (!$unique_ref_found) {  
		  
			// Start with a blank reference number  
			$unique_ref = "";  
			  
			// Set up a counter to keep track of how many characters have   
			// currently been added  
			$i = 0;  
			  
			// Add random characters from $possible_chars to $unique_ref   
			// until $unique_ref_length is reached  
			while ($i < $unique_ref_length) {  
			  
				// Pick a random character from the $possible_chars list  
				$char = substr($possible_chars, mt_rand(0, strlen($possible_chars)-1), 1);  
				  
				$unique_ref .= $char;  
				  
				$i++;   
			}
			
			$query = "SELECT `confirmation_code` FROM `restaurant_menu_order`  WHERE  `confirmation_code` = '".$unique_ref."'";
			$result = mysql_query($query) or die(mysql_error().' '.$query);  
			if (mysql_num_rows($result)==0) {  
			  
				// We've found a unique number. Lets set the $unique_ref_found  
				// variable to true and exit the while loop  
				$unique_ref_found = true; 
			}  
		}  
		  
		$unique_no = $unique_ref; 
		
		$restaurant_id = $_REQUEST['restaurant_id'];
		$customer_id = $_REQUEST['customer_id'];	
		$amount = $_REQUEST['amount'];
		$order_type = $_REQUEST['order_type'];
		$delivery_info = $_REQUEST['delivery_info'];
		$tax = $_REQUEST['tax'];
		$tip = $_REQUEST['tip'];
		$payment_mode = $_REQUEST['payment_mode'];
		$save_earth = $_REQUEST['save_earth'];
		$delivery_charge = $_REQUEST['delivery_charge'];
		$session_id = $_REQUEST['session_id'];
		$first_name = mysql_real_escape_string($_REQUEST['first_name']);
		$last_name = mysql_real_escape_string($_REQUEST['last_name']);
		$email = mysql_real_escape_string($_REQUEST['email']);
		$phone = $_REQUEST['phone'];
		$address = mysql_real_escape_string($_REQUEST['address']);
		$city = $_REQUEST['city'];
		$state = $_REQUEST['state'];
		$zipcode = $_REQUEST['zipcode'];
		$save_earth = $_REQUEST['save_earth'];
		$apart = $_REQUEST['apart'];
		$apt_name = $_REQUEST['apt_name'];
		$apt_no = $_REQUEST['apt_no'];
		$gate_code = $_REQUEST['gate_code'];
		$information = $_REQUEST['information'];
		
		
		$sql_restaurant_basic = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$restaurant_id."'"));
		$sql_del_com_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$restaurant_id."'"));
		$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$customer_id."'"));
		$sql_delivery_charge = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$restaurant_id."'"));
		$commission = (($amount + $tax + $tip + $sql_delivery_charge['service_fee'])*$sql_del_com_info['commission'])/100;
		
		$sql_insert_order = "INSERT INTO restaurant_menu_order SET customer_id = '".$customer_id."',restaurant_id = '".$restaurant_id."', total_price = '".$amount."', order_date = '".date('Y-m-d H:i:s')."', type = '".$order_type."',status = 'Pending',customer_name = '".htmlspecialchars(stripslashes($sql_customer['firstname']),ENT_QUOTES)."',customer_address = '".htmlspecialchars(stripslashes($sql_customer['address']),ENT_QUOTES)."', special_delivery_info = '".htmlspecialchars(stripslashes($delivery_info),ENT_QUOTES)."', customer_phone = '".$sql_customer['phone']."', tax = '".$tax."' , tip = '".$tip."' , confirmation_code = '".$unique_no."', payment_mode = '".$payment_mode."' , spare_napkins = '".$_REQUEST['save_earth']."',delivery_charge = '".$delivery_charge."', price_with_del_charge = '".($delivery_charge+$amount+$tax+$tip+$sql_delivery_charge['service_fee'])."' , service_fee = '".$sql_delivery_charge['service_fee']."' , commission = '".$commission."' ";
		
		mysql_query($sql_insert_order);
	
		$order_id = mysql_insert_id();
		
		$sql_total_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));
		
		$sql_select = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".$session_id."' AND restaurant_id = '".$restaurant_id."' AND group_id = '0' AND group_order_details_id = '0' ");
		
		while($array_select = mysql_fetch_array($sql_select)) {
			$sql_menu_item = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select['menu_item_id']."'"));
			$sum = ($array_select['quantity']*$array_select['price'] + $array_select['tax']);
			
			$sql_insert_food_details = mysql_query("INSERT INTO restaurant_food_order_details SET  order_id = '".$order_id."' , customer_id = '".$customer_id."',  menu_id  = '".$array_select['menu_item_id']."',restaurant_id = '".$restaurant_id."',quantity = '".$array_select['quantity']."', unit_price = '".$array_select['price']."',special_instructions = '".htmlspecialchars(stripslashes($array_select['special_ins']),ENT_QUOTES)."', additional_instructions = '".htmlspecialchars(stripslashes($array_select['additional_instructions']),ENT_QUOTES)."' , order_date = '".$sql_total_price['order_date']."',customer_name='".htmlspecialchars(stripslashes($sql_customer['firstname']),ENT_QUOTES)."',customer_email='".$sql_customer['email']."',menu_name = '".trim(htmlspecialchars(stripslashes($sql_menu_item['menu_name']),ENT_QUOTES))."',sum = '".$sum."', menu_price = '".$array_select['menu_price']."', tax = '".$array_select['tax']."' ");
			
			$sql_update = mysql_query("UPDATE restaurant_menu_item SET purchased = purchased + ".$array_select['quantity']." WHERE id = '".$array_select['menu_item_id']."'");
		}
		
		$sql_contact_details = mysql_query("INSERT INTO restaurant_order_contact_details SET firstname = '".htmlspecialchars(stripslashes($first_name),ENT_QUOTES)."',lastname = '".htmlspecialchars(stripslashes($last_name),ENT_QUOTES)."', email='".$email."', phone='".$phone."', address='".htmlspecialchars(stripslashes($address),ENT_QUOTES)."', city='".htmlspecialchars(stripslashes($city),ENT_QUOTES)."', state='".htmlspecialchars(stripslashes($state),ENT_QUOTES)."', zipcode='".$_REQUEST['zipcode']."', special_ins='".htmlspecialchars(stripslashes($delivery_info),ENT_QUOTES)."', save_earth='".$save_earth."', customer_id='".$customer_id."', order_id = '".$order_id."', home_apartment = '".$apart."' , apt_name = '".$apt_name."' , apt_no = '".$apt_no."' , gate_code = '".$gate_code."', information = '".$information."'");
		
		$foodandmenu['order_insert_status'] = array();
		
		array_push($foodandmenu['order_insert_status'],array(
							'status' => 'success',
							'order_id' => $order_id
				));
				
		return $foodandmenu['order_insert_status'];		
	}
}

class res_reservation 
{
	function restaurant_reservation($log){
		$restaurant_id = $_REQUEST['restaurant_id'];
		$date = $_REQUEST['date'];
		$time = $_REQUEST['time'];
		$people = $_REQUEST['people'];	
		$special_occassion = $_REQUEST['special_occassion'];
		$customer_phone = $_REQUEST['customer_phone'];
		$contact_email = $_REQUEST['contact_email'];
		$comments = $_REQUEST['comments'];	
		$customer_id = $_REQUEST['customer_id'];
		
		$sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$restaurant_id."' "));
		
		$restaurant_name = $sql_restaurant['restaurant_name'];
			
		$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$customer_id."' "));
		
		$customer_name = $sql_customer['firstname']." ".$sql_customer['lastname'];
		
		$sql_insert_reservation = mysql_query("INSERT INTO restaurant_reservations SET restaurant_id = '".$restaurant_id."' , restaurant_name = '".$restaurant_name."' , date = '".$date."', time = '".$time."', people = '".$people."', special_occassion = '".$special_occassion."', customer_phone = '".$customer_phone."', contact_email = '".$contact_email."', comments = '".$comments."', customer_id = '".$customer_id."', customer_name = '".$customer_name."', type_order = 'reservation' ");
		
		$foodandmenu['reservation_insert_status'] = array();
		
		array_push($foodandmenu['reservation_insert_status'],array(
							'status' => 'success'
				));
				
		return $foodandmenu['reservation_insert_status'];		
	}
}

class res_rating_reviews 
{
	function restaurant_rating_reviews($log){
		 $restaurant_id = $_REQUEST['rid'];
		
		$sql_review = mysql_query("SELECT rr.id,rr.post_date,rr.customer_name,rr.customer_email,rr.customer_picture, rr.customer_review,rr.restaurant_id, rr.customer_id , rr.restaurant_name , rr.like , rr.dislike ,  rrat.rating_id ,  rrat.rating_id FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['rid']."' AND rrat.restaurant_id='".$_REQUEST['rid']."' AND rr.status=1 AND rr.review_status = 0");
		$foodandmenu['resall']['restaurant_id']=$_REQUEST['rid'];
		$i=0;	
		
		
		while($res_review=mysql_fetch_array($sql_review))
		{
			$i++;
			
			
			 //mysql_query("SELECT * FROM `restaurant_review_images` ");
			
			
			
			
			$rating = getSingleReviewRating($_REQUEST['rid'],$res_review['id']);
					
			$foodandmenu['resall']['customer_id'][$i]=$res_review['customer_id'];
			$foodandmenu['resall']['rating'][$i]=$rating;
			$foodandmenu['resall']['customer_review'][$i]=$res_review['customer_review'];
			$foodandmenu['resall']['rating'][$i]=$rating;
			$foodandmenu['resall']['customer_name'][$i]=$res_review['customer_name'];
			
			//$foodandmenu['resall']['restaurant_name']=$res_review['restaurant_name'];
				
			
		}
		
		
		
		
		
		return $foodandmenu['resall'];		
	}
}

//------------------------------add--review--rating---------------------------------------------------//



//--------------------------------------------------------------------------------------------------------//

class profileImageUpload
{
	function profileimageUpload($log){
		
		$customer_id=$_REQUEST['customer_id'];
		
		foreach($_FILES['documents']['tmp_name'] as $key => $tmp_name)
         {
    $file_name = $key.$_FILES['documents']['name'][$key];
    $file_size =$_FILES['documents']['size'][$key];
    $file_tmp =$_FILES['documents']['tmp_name'][$key];
    $file_type=$_FILES['documents']['type'][$key]; 
    move_uploaded_file($file_tmp,"../uploaded_images/".$file_name);

	//$sql_insert_review_images = mysql_query("INSERT INTO restaurant_customer SET review_id = '".$review_id."' , image = '".$file_name."'");
		mysql_query("UPDATE `restaurant_customer` SET `image` = '".$file_name."' WHERE id='".$customer_id."'");	
		$foodandmenu['update_profile_status']="Image upload done";
		}
		
		return $foodandmenu['update_profile_status'];		
	}
}

class res_update_profile 
{
	function restaurant_update_profile($log){
		$id = $_REQUEST['id'];
		$firstname = $_REQUEST['firstname'];
		$lastname = $_REQUEST['lastname'];
		$email = $_REQUEST['email'];
		$address = $_REQUEST['address'];
		$phone = $_REQUEST['phone'];
		$date_of_birth = $_REQUEST['date_of_birth'];
		$state = $_REQUEST['state'];
		$city = $_REQUEST['city'];
		$zip = $_REQUEST['zip'];
		
		$sql_insert_customer = mysql_query("UPDATE restaurant_customer SET firstname = '".$firstname."' , lastname = '".$lastname."' , email = '".$email."' , address = '".$address."' , phone = '".$phone."' , date_of_birth = '".$date_of_birth."' , state = '".$state."' , city = '".$city."' , zip = '".$zip."' WHERE id = '".$id."' ");
		
		$foodandmenu['update_profile_status'] = array();
		
		array_push($foodandmenu['update_profile_status'],array(
							'status' => 'success',
				));
				
		return $foodandmenu['update_profile_status'];		
	}
}

class res_order_history 
{
	function restaurant_order_history($log)
	{
		$customer_id = $_REQUEST['customer_id'];

		$sql_order = mysql_query("SELECT * FROM restaurant_menu_order WHERE customer_id = '".$customer_id."'");
		
		$foodandmenu['restaurant_order_history']['order_history'] = array();
		
		while($order_history = mysql_fetch_array($sql_order))
		{
			
			
			$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$order_history['order_id']."'"));
			
			
			$restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$order_history['restaurant_id']."'"));
			$sql_order_details = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$order_history['order_id']."'");
			
			$foodandmenu['restaurant_order_details']['menu_item'] = array();
			
			while($row_order_details = mysql_fetch_array($sql_order_details))
			{
				array_push($foodandmenu['restaurant_order_details']['menu_item'],array(
					'menu_id' => $row_order_details['menu_id'],
					'menu_name' => htmlspecialchars(stripslashes($row_order_details['menu_name'])),
					//'quantity' => $row_order_details['menu_id'],
					'menu_price' => $row_order_details['menu_id'],
					'unit_price' => $row_order_details['menu_id'],
					'tax' => $row_order_details['menu_id'],
					'special_instructions' => htmlspecialchars(stripslashes($row_order_details['special_instructions'])),
					'additional_instruction' => htmlspecialchars(stripslashes($row_order_details['additional_instructions']))
				));
			}
			
			
							$resorder=mysql_fetch_array(mysql_query("SELECT *
				FROM `restaurant_menu_order`
				WHERE `customer_id` ='".$order_history['customer_id']."' 
				ORDER BY `restaurant_menu_order`.`order_id` DESC
				LIMIT 0 , 1")); 
				
				
				
				
				$resorder1=mysql_fetch_array(mysql_query("SELECT *
				FROM `restaurant_order_contact_details`
				WHERE `contact_det_id` ='".$order_history['order_id']."'
				LIMIT 0 , 1"));
						
				$foodandmenu['resall']['ship_bill']['d_phone']=$resorder1["phone"];
				$foodandmenu['resall']['ship_bill']['d_city']=$resorder1["city"];
				$foodandmenu['resall']['ship_bill']['d_state']=$resorder1["state"];
				$foodandmenu['resall']['ship_bill']['d_apt_name']=$resorder1["apt_name"];
				$foodandmenu['resall']['ship_bill']['d_apt_no']=$resorder1["apt_no"];
				$foodandmenu['resall']['ship_bill']['d_zipcode']=$resorder1["zipcode"];
				
				
				
				$resorder2=mysql_fetch_array(mysql_query("SELECT *
				FROM `restaurant_customer`
				WHERE `id` ='".$_REQUEST['customer_id']."'"));
				
				
				$foodandmenu['resall']['ship_bill']['billing_address']=$resorder2["billing_address"];
				$foodandmenu['resall']['ship_bill']['billing_home_apartment']=$resorder2["billing_home_apartment"];
				$foodandmenu['resall']['ship_bill']['billing_apt_name']=$resorder2["billing_apt_name"];
				$foodandmenu['resall']['ship_bill']['billing_apt_no']=$resorder2["billing_apt_no"];
				$foodandmenu['resall']['ship_bill']['billing_phone']=$resorder2["billing_phone"];
				$foodandmenu['resall']['ship_bill']['ship_bill']['billing_state']=$resorder2["billing_state"];
				$foodandmenu['resall']['ship_bill']['billing_state']=$resorder2["billing_state"];
				$foodandmenu['resall']['ship_bill']['billing_city']=$resorder2["billing_city"];
				$foodandmenu['resall']['ship_bill']['billing_zip']=$resorder2["billing_zip"];
				
				
				
				
				$foodandmenu['resall1']['user_info']['customer_id']=$_REQUEST['customer_id'];
				$foodandmenu['resall1']['user_info']['customer_name']=$order_history['customer_name'];
				
				
				
			
			array_push($foodandmenu['restaurant_order_history']['order_history'],
							array(
							'order_id' => $order_history['order_id'],
							'restaurant_id' => $order_history['restaurant_id'],
							'reastaurant_name' => htmlspecialchars(stripslashes($restaurant_name['restaurant_name'])),
							'reastaurant_image'=>"https://foodandmenu.com/uploaded_images/".$restaurant_name['restaurant_image'],
							'total_price' => $order_history['total_price'],
							'order_date' => $order_history['order_date'],
							'type' => $order_history['type'],
							'delivery_charge' => $order_history['delivery_charge'],
							'tax' => $order_history['tax'],
							'tip' => $order_history['tip'],
							'special_delivery_info' => htmlspecialchars(stripslashes($order_history['special_delivery_info'])),
							'commission' => $order_history['commission'],
							'credit_card_fee' => $order_history['credit_card_fee'],
							'service_fee' => $order_history['service_fee'],
							'status' => $order_history['status'],
							'price_with_del_charge' => $order_history['price_with_del_charge'],
							'customer_name' => $order_history['customer_name'],
							'customer_address' => $order_history['customer_address'],
							'customer_phone' => $order_history['customer_phone'],
							'confirmation_code' => $order_history['confirmation_code'],
							'payment_mode' => $order_history['payment_mode'],
							'spare_napkins' => $order_history['spare_napkins'],
							'coupon_code' => $order_history['coupon_code'],
							'coupon_discount' => $order_history['coupon_discount'],
							'reward_points' => $order_history['reward_points'],
							'type_order' => $order_history['type_order'],
							'card_type' => $order_history['card_type'],
							'card_no' => $order_history['card_no'],
							'cvv_no' => $order_history['cvv_no'],
							'expiry_date' => $order_history['expiry_date'],
							'address'=>$sql_contact_details['address'],
							'city'=>$sql_contact_details['city'],
							'state'=>$sql_contact_details['state'],
							'zipcode'=>$sql_contact_details['zipcode'],
							$foodandmenu['restaurant_order_details'],
							$foodandmenu['resall'],
							$foodandmenu['resall1']
							
					));
		}
		return $foodandmenu['restaurant_order_history'];
	}
}









//----------------------------------------lastorder_status--------------------------------------------------------------//


class res_lastorder_status 
{
	function restaurant_lastorder($log)
	{
		$customer_id = $_REQUEST['customer_id'];

		$sql_order = mysql_query("SELECT * FROM restaurant_menu_order WHERE customer_id = '".$customer_id."'ORDER BY `restaurant_menu_order`.`order_id` DESC
LIMIT 0 , 1");
		
		$foodandmenu['restaurant_order_history']['order_history'] = array();
		
		while($order_history = mysql_fetch_array($sql_order))
		{
			
			
			$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$order_history['order_id']."'"));
			
			
			$restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$order_history['restaurant_id']."'"));
			$sql_order_details = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$order_history['order_id']."'");
			
			$foodandmenu['restaurant_order_details']['menu_item'] = array();
			
			while($row_order_details = mysql_fetch_array($sql_order_details))
			{
				array_push($foodandmenu['restaurant_order_details']['menu_item'],array(
					'menu_id' => $row_order_details['menu_id'],
					'menu_name' => htmlspecialchars(stripslashes($row_order_details['menu_name'])),
					//'quantity' => $row_order_details['menu_id'],
					'menu_price' => $row_order_details['menu_id'],
					'unit_price' => $row_order_details['menu_id'],
					'tax' => $row_order_details['menu_id'],
					'special_instructions' => htmlspecialchars(stripslashes($row_order_details['special_instructions'])),
					'additional_instruction' => htmlspecialchars(stripslashes($row_order_details['additional_instructions']))
				));
			}
			
			
							$resorder=mysql_fetch_array(mysql_query("SELECT *
				FROM `restaurant_menu_order`
				WHERE `customer_id` ='".$order_history['customer_id']."' 
				ORDER BY `restaurant_menu_order`.`order_id` DESC
				LIMIT 0 , 1")); 
				
				
				
				
				$resorder1=mysql_fetch_array(mysql_query("SELECT *
				FROM `restaurant_order_contact_details`
				WHERE `contact_det_id` ='".$order_history['order_id']."'
				LIMIT 0 , 1"));
						
				$foodandmenu['resall']['ship_bill']['d_phone']=$resorder1["phone"];
				$foodandmenu['resall']['ship_bill']['d_city']=$resorder1["city"];
				$foodandmenu['resall']['ship_bill']['d_state']=$resorder1["state"];
				$foodandmenu['resall']['ship_bill']['d_apt_name']=$resorder1["apt_name"];
				$foodandmenu['resall']['ship_bill']['d_apt_no']=$resorder1["apt_no"];
				$foodandmenu['resall']['ship_bill']['d_zipcode']=$resorder1["zipcode"];
				
				
				
				$resorder2=mysql_fetch_array(mysql_query("SELECT *
				FROM `restaurant_customer`
				WHERE `id` ='".$_REQUEST['customer_id']."'"));
				
				
				$foodandmenu['resall']['ship_bill']['billing_address']=$resorder2["billing_address"];
				$foodandmenu['resall']['ship_bill']['billing_home_apartment']=$resorder2["billing_home_apartment"];
				$foodandmenu['resall']['ship_bill']['billing_apt_name']=$resorder2["billing_apt_name"];
				$foodandmenu['resall']['ship_bill']['billing_apt_no']=$resorder2["billing_apt_no"];
				$foodandmenu['resall']['ship_bill']['billing_phone']=$resorder2["billing_phone"];
				$foodandmenu['resall']['ship_bill']['ship_bill']['billing_state']=$resorder2["billing_state"];
				$foodandmenu['resall']['ship_bill']['billing_state']=$resorder2["billing_state"];
				$foodandmenu['resall']['ship_bill']['billing_city']=$resorder2["billing_city"];
				$foodandmenu['resall']['ship_bill']['billing_zip']=$resorder2["billing_zip"];
				
				
				
				
				$foodandmenu['resall1']['user_info']['customer_id']=$_REQUEST['customer_id'];
				$foodandmenu['resall1']['user_info']['customer_name']=$order_history['customer_name'];
				
				
				
			
			array_push($foodandmenu['restaurant_order_history']['order_history'],
							array(
							'order_id' => $order_history['order_id'],
							'restaurant_id' => $order_history['restaurant_id'],
							'reastaurant_name' => htmlspecialchars(stripslashes($restaurant_name['restaurant_name'])),
							'reastaurant_image'=>"https://foodandmenu.com/uploaded_images/".$restaurant_name['restaurant_image'],
							'total_price' => $order_history['total_price'],
							'order_date' => $order_history['order_date'],
							'type' => $order_history['type'],
							'delivery_charge' => $order_history['delivery_charge'],
							'tax' => $order_history['tax'],
							'tip' => $order_history['tip'],
							'special_delivery_info' => $order_history['special_delivery_info'],
							'commission' => $order_history['commission'],
							'credit_card_fee' => $order_history['credit_card_fee'],
							'service_fee' => $order_history['service_fee'],
							'status' => $order_history['status'],
							'price_with_del_charge' => $order_history['price_with_del_charge'],
							'customer_name' => $order_history['customer_name'],
							'customer_address' => $order_history['customer_address'],
							'customer_phone' => $order_history['customer_phone'],
							'confirmation_code' => $order_history['confirmation_code'],
							'payment_mode' => $order_history['payment_mode'],
							'spare_napkins' => $order_history['spare_napkins'],
							'coupon_code' => $order_history['coupon_code'],
							'coupon_discount' => $order_history['coupon_discount'],
							'reward_points' => $order_history['reward_points'],
							'type_order' => $order_history['type_order'],
							'card_type' => $order_history['card_type'],
							'card_no' => $order_history['card_no'],
							'cvv_no' => $order_history['cvv_no'],
							'expiry_date' => $order_history['expiry_date'],
							'address'=>$sql_contact_details['address'],
							'city'=>$sql_contact_details['city'],
							'state'=>$sql_contact_details['state'],
							'zipcode'=>$sql_contact_details['zipcode'],
							$foodandmenu['restaurant_order_details'],
							$foodandmenu['resall'],
							$foodandmenu['resall1']
							
					));
		}
		return $foodandmenu['restaurant_order_history'];
	}
}


//----------------------------------------------finish---------------------------------------------------------------------------//



















?>