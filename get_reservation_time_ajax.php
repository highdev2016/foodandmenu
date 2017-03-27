<?php
include ("admin/lib/conn.php");

$selected_day = $_REQUEST['day'];
$res_id 	  = $_REQUEST['restaurant_id'];
$date	   	  = $_REQUEST['sel_date'];

$new_date = explode('-',$date);

$sql_get_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$res_id."'"));

/*$start_time = explode(":",$sql_get_time['reservation_open_'.$selected_day]);
$end_time = explode(":",$sql_get_time['reservation_close_'.$selected_day]);
*/

$start_time = $sql_get_time['reservation_open_'.$selected_day];
$end_time = $sql_get_time['reservation_close_'.$selected_day];



$time1 = strtotime($start_time);
$time2 = strtotime($end_time);

$time_start = ($time1 - 1800);


if($new_date[0]<10)
{
	$final_date = '0'.$new_date[0];
}
else
{
	$final_date = $new_date[0];
}

if($new_date[1]<10)
{
	$final_month = '0'.$new_date[1];
}
else
{
	$final_month = $new_date[1];
}

$sel_date = $final_date."-".$final_month."-".$new_date[2];

$curernt_time = date('H:i');

$curr_date = date('d-m-Y');

if($time1 > strtotime($curernt_time))
{
	$now        = $start_time;
}
else
{
	$now        = $curernt_time;
}

$curr_tm    		 = explode(':',$now);

if($curr_tm[1] > 30){
	$rounded_time = ($curr_tm[0]).":30";
}else{
	$rounded_time = $curr_tm[0].":00";
}

$round_time = strtotime($rounded_time);

//$round_time_start = ($round_time - 1800); 

if($time1 > strtotime($curernt_time))
{
	$round_time_start = ($round_time - 1800);
}
else
{
	$round_time_start = $round_time;
}

/*echo $date."<br>";
echo $curr_date."<br>";*/

//echo date("h:i A", $time1);
 
if($sel_date == $curr_date)
{
	$select_box = '<select name="timepick" class="profilefield" style="height:25px; width:205px;"  id="timepick"';
	for($i=$round_time_start;$i<=$time2;$i=$i+1800)
	{
		$select_box.='<option value='.date("h:i A", $i).'>'.date("h:i A", $i).'</option>';	
	}
	$select_box.='</select>';
}
else
{
	$select_box = '<select name="timepick" class="profilefield" style="height:25px; width:205px;"  id="timepick"';
	for($i=$time_start;$i<=$time2;$i=$i+1800)
	{
		$select_box.='<option value='.date("h:i A", $i).'>'.date("h:i A", $i).'</option>';
	}
	$select_box.='</select>';
}

echo $select_box;
?>
 