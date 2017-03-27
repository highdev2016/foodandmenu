<?php
session_start();
if($_COOKIE['resCity'] == ''){
	//echo '<script type="text/javascript">';
	//echo 'window.location=home.php?city='.$_COOKIE['resCity'];
	header("location:index.php");
	exit();
}
if (array_key_exists('btn_search', $_GET)) {
unset($_GET['btn_search']);
foreach($_GET as $key => $val)
{
	$qry_string .=$key.'='.$val.'&'; 
}
$qry_string = substr($qry_string,0,-1);
header("location:search.php?".$qry_string);
}

include ("includes/header.php");
include ("includes/functions.php");
include ("admin/lib/conn.php");
?>
<?php /*?><link rel="stylesheet" href="css/jquery.mCustomScrollbar.css" />
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
	$("#content-1").mCustomScrollbar();
</script><?php */?>
<link href="css/circle.css" rel="stylesheet" type="text/css">
<script src="js/progress-circle.js"></script>

<script type="text/javascript">
$(document).mouseup(function (e)
{
    var favourite = $("#favourite_div");
	var follower = $("#follower_div");
	var following = $("#following_div");
	var following_req = $("#following_req_div");
	var notification = $("#notification_div");
	var block = $("#block_users_div");
	

   	if (!favourite.is(e.target) // if the target of the click isn't the container...
        && favourite.has(e.target).length === 0) // ... nor a descendant of the container
    {
        favourite.hide();
    }
	
	if (!follower.is(e.target) // if the target of the click isn't the container...
        && follower.has(e.target).length === 0) // ... nor a descendant of the container
    {
        follower.hide();
    }
	
	if (!following.is(e.target) // if the target of the click isn't the container...
        && following.has(e.target).length === 0) // ... nor a descendant of the container
    {
        following.hide();
    }
	
	if (!following_req.is(e.target) // if the target of the click isn't the container...
        && following_req.has(e.target).length === 0) // ... nor a descendant of the container
    {
        following_req.hide();
    }
	
	if (!notification.is(e.target) // if the target of the click isn't the container...
        && notification.has(e.target).length === 0) // ... nor a descendant of the container
    {
        notification.hide();
    }
	
	if (!block.is(e.target) // if the target of the click isn't the container...
        && block.has(e.target).length === 0) // ... nor a descendant of the container
    {
        block.hide();
    }
});

function open_favourite_div()
{
	$("#block_users_div").hide();
	$("#notification_div").hide();
	$("#following_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").slideDown();
}

function open_notification_div()
{
	$("#block_users_div").hide();
	$("#following_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#notification_div").slideDown();
}

function open_follower_div()
{
	$("#block_users_div").hide();
	$("#notification_div").hide();
	$("#following_div").hide();
	$("#favourite_div").hide();
	$("#follower_div").slideDown();
}

function open_following_div()
{
	$("#block_users_div").hide();
	$("#notification_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#following_div").slideDown();
}

function open_following_req_div()
{
	$("#block_users_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#following_div").hide();
	$("#following_req_div").slideDown();
}

function open_block_users_div()
{
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#following_div").hide();
	$("#following_req_div").hide();
	$("#block_users_div").slideDown();
}

function get_confirm(id){
	$("#block_confirm_user"+id).show();
	$("#fade1").show();
}

function close_block_confirm_user_div(id){
	$("#block_confirm_user"+id).hide();
	$("#fade1").hide();
}

function accept_reject_request(id,val)
{
	//alert(val);
	var hid_user_id = $('#hid_user_id').val();
	
	$.ajax({
			url : 'accept_reject_user.php',
			type : 'POST',
			data : 'id=' + id + '&val=' + val + '&follow_id=' + hid_user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				var data_new = data.split("^");
				
				$("#div_acc_rej"+id).fadeOut(1000);
				$("#follower_span").html(data_new[2]);
				$("#following_span").html(data_new[1]);
				
				 location.reload();
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}

function remove_user_block(id)
{
	var block_count = $("#block_users_span").html();
	//var hid_user_id = $('#hid_user_id').val();
	
	$.ajax({
			url : 'remove_block_user.php',
			type : 'POST',
			data : 'id=' + id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				var new_count = parseInt(block_count) - parseInt(1);
				
				$("#block_users_span").html(new_count);
				
				$("#div_block_user"+id).fadeOut(1000);
				
				if(new_count == 0)
				{
					$("#block_users_div").remove();
				}
				
				 //location.reload();
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}

function confirm_user_blk(id,blk_status){
	
	var follower_count = $("#follower_span").html();
	var block_count = $("#block_users_span").html();
	
	$.ajax({
			url : 'confirm_block_users.php',
			type : 'POST',
			data : 'id=' + id + '&blk_status=' + blk_status ,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				/*var data_new = data.split("^");
				
				$("#div_acc_rej"+id).fadeOut(1000);
				$("#follower_span").html(data_new[2]);
				$("#following_span").html(data_new[1]);
				
				 location.reload();*/
				 
				 if(data!=''){
					 $('#rem_user_follow'+data).fadeOut(1000); 
				 }
				 $("#block_confirm_user"+id).hide();
				 $("#fade1").hide();
				 
				var new_count = parseInt(follower_count) - parseInt(1);
   				var new_block_count = parseInt(block_count) + parseInt(1);
    
   				 $("#follower_span").html(new_count);
				 $("#block_users_span").html(block_count);
				 
				 
				 
				 
				 
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}

function open_desc_div(id)
{
	$("#desc_div"+id).show();
	$("#fade1").show();
}

function close_desc_div(id)
{
	$("#desc_div"+id).hide();
	$("#fade1").hide();
}

</script>
<body onLoad="init();">
<div id="top_div"></div>

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>


<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="main_body_cont">

<?php //include("includes/banner_section.php");?>

<div class="content_container">

<?php include("includes/left_section.php");?>

<?php

$customer_id = $_SESSION['customer_id'];

$sql = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));

$sql_min = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));



$pre_percentage = ($sql['reward_point']/$sql_min['minimum_reward_point'])*100;

if($pre_percentage >= 100)
{
	$percentage = '100';
	$message = "Congratulations!!!! You can now successfully redeem your reward points.";
	$color = "#090";
}
else
{
	$difference = ($sql_min['minimum_reward_point'] - $sql['reward_point']);
	$percentage = $pre_percentage;
	$message = "You need just ".$difference." more points to reach your goal and be able to reedem your points.";
	$color = "#F00";
}

$follower_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$customer_id."' AND status = '1' "));

$following_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1' "));

$favourite_count = mysql_num_rows(mysql_query("SELECT id FROM restaurant_favourite WHERE user_id = '".$customer_id."' "));

$all_follower = mysql_query("SELECT * FROM user_follow WHERE follower_id = '".$customer_id."' AND status = '1' ");

$all_following = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1' ");

$all_following1 = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1' ");

$all_favourite = mysql_query("SELECT * FROM restaurant_favourite WHERE user_id = '".$customer_id."' ");

$follow_request_count = mysql_num_rows(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '0'"));

$follow_request = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '0'");

$block_user_count = mysql_num_rows(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND block_status = '1'")); 

$block_user = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND block_status = '1'"); 

$block_status = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$customer_id."' AND following_id = '".$_REQUEST['id']."' AND block_status = '1'"));
?>


<div class="body_cont_right">


<div class="clear"></div>

<div class="right_dish_content right_user_profile">
<div class="user-profile-top">

<div class="profile-name">
    <h1>User Profile</h1>
</div>
<div class="follow-section">
<div id="content-2" class="content mCustomScrollbar light" data-mcs-theme="minimal-dark">
	<ul>
<?php
	$get_follower_id = mysql_query("SELECT following_id FROM user_follow WHERE follower_id = '".$customer_id."' AND status = '1'");
	$all_user_id = '';
	$sep_follower = '';
	while($row_get_follower_id = mysql_fetch_array($get_follower_id))
	{
		$all_user_id = $all_user_id.$sep_follower.$row_get_follower_id['following_id'];
		$sep_follower = ',';
		
	}
	
	if($all_user_id == '')
	{
		$all_user_id = '0';
	}
	
										
	$sql_get_notification = mysql_query("SELECT * FROM restaurant_notification WHERE user_id in (".$all_user_id.") AND post_date >= CURDATE( ) - INTERVAL 7 DAY ");
	$notification_count = mysql_num_rows($sql_get_notification);
	
	
	if($notification_count > 0)
	{
	?>
	<li>
		 <a href="javascript:void(0);" onClick="open_notification_div();">
			<strong>Notification</strong> <br />
			 <span><?php echo $notification_count;?></span>
		 </a>
		 
		 <div id="notification_div" class="notification" style="display:none;">
			<img src="images/tool-arrow.png" alt="" />
			<?php while($row_all_notification = mysql_fetch_array($sql_get_notification)) { 
				
				echo "<p>".getNameTable("restaurant_customer","firstname","id",$row_all_notification['user_id'])." ".$row_all_notification['notification']."</p>  ";
			
			 } ?>
		</div>    
	
	</li>
	<?php
	}
	else
	{
	?>	<li>
            <a href="javascript:void(0);">
                <strong>Notification</strong> <br />
                 <span><?php echo $notification_count;?></span>
             </a>
        </li>
    
	<?php	
	}
	?>




<?php
if($follower_count > 0)
{
?>
<li>
	 <a href="javascript:void(0);" onClick="open_following_div();">
		<strong>Following</strong> <br />
		 <span id="following_span"><?php echo $follower_count; ?></span>
	 </a>
	 <div id="following_div" style="display:none;">
		<img src="images/tool-arrow.png" alt="" />
		<?php while($row_all_follower = mysql_fetch_array($all_follower)) { 
			
			echo "<a href='user.php?id=".$row_all_follower['following_id']."' style='color:#4E7AD5'>".getNameTable("restaurant_customer","firstname","id",$row_all_follower['following_id'])." ".getNameTable("restaurant_customer","lastname","id",$row_all_following['following_id'])."</a>";
		
		 } ?>
	</div> 
</li>
<?php
}
else
{
?>
<li>
		<a href="javascript:void(0);" style="cursor:default;">
		<strong>Following</strong> <br />
		 <span id="following_span"><?php echo $follower_count; ?></span>
		</a>
</li>
<?php
}
?>

<?php
if($following_count > 0)
{
?>
<li>
	 <a href="javascript:void(0);" onClick="open_follower_div();">
		<strong>Followers</strong> <br />
		 <span id="follower_span"><?php echo $following_count; ?></span>
	 </a>
	 
	 <div id="follower_div" style="display:none;">
		<img src="images/tool-arrow.png" alt="" />
		<?php while($row_all_following = mysql_fetch_array($all_following)) { 
			
			echo "<div class='cancel-img-2' style='position:relative;' id='rem_user_follow".$row_all_following['id']."'><a href='user.php?id=".$row_all_following['follower_id']."' style='color:#4E7AD5'>".getNameTable("restaurant_customer","firstname","id",$row_all_following['follower_id'])." ".getNameTable("restaurant_customer","lastname","id",$row_all_following['follower_id'])."</a>";
			echo "<a class='cross-img' href='javascript:void(0);' onClick='return get_confirm(".$row_all_following['id'].")'><img src='images/1417787649_button_cancel.png' style='margin-top: 18px;
'></a></div><div class='clear'></div>";
		
		 } ?>
	</div>    
</li>
<?php
}
else
{
?>
<li>
		<a href="javascript:void(0);" style="cursor:default;">
		<strong>Followers</strong> <br />
		 <span id="follower_span"><?php echo $following_count; ?></span>
		 </a>
</li>
<?php
}
?>

<?php
if($favourite_count > 0)
{
?>
<li>
	 <a href="javascript:void(0);" onClick="open_favourite_div();">
		<strong>Favorites</strong> <br />
		 <span><?php echo $favourite_count;?></span>
	 </a>
	 
	 <div id="favourite_div" class="favo" style="display:none;">
		<img src="images/tool-arrow.png" alt="" />
		<?php while($row_all_favourite = mysql_fetch_array($all_favourite)) { 
			
			echo "<a href='restaurant.php?id=".$row_all_favourite['restaurant_id']."' style='color:#4E7AD5'>".getNameTable("restaurant_basic_info","restaurant_name","id",$row_all_favourite['restaurant_id'])."</a>  ";
		
		 } ?>
	</div>    
</li>

<?php
}
else
{
?>
<li>
	 <a href="javascript:void(0);" style="cursor:default;">
		<strong>Favorites</strong> <br />
		 <span><?php echo $favourite_count;?></span>
	 </a>
</li>
<?php
}
if($follow_request_count > 0)
{
?>
<li class="big-text">
     <a href="javascript:void(0);" onClick="open_following_req_div();">
        <strong>Following Request</strong> <br />
         <span id="following_req_span"><?php echo $follow_request_count; ?></span>
     </a>
     <div id="following_req_div" style="display:none;">
        <img src="images/tool-arrow.png" alt="" />
        <?php while($row_all_follower_req = mysql_fetch_array($follow_request)) { 
            
            echo "<div class='big-row' id='div_acc_rej".$row_all_follower_req['id']."'><a class='left' href='user.php?id=".$row_all_follower_req['follower_id']."' style='color:#4E7AD5'>".getNameTable("restaurant_customer","firstname","id",$row_all_follower_req['follower_id'])." ".getNameTable("restaurant_customer","lastname","id",$row_all_follower_req['follower_id'])."</a> <div class='left'> <a href='javascript:void(0);' onclick='accept_reject_request(".$row_all_follower_req['id'].",1)' class='button4'> Accept</a> <a href='javascript:void(0);' onclick='accept_reject_request(".$row_all_follower_req['id'].",2)' class='button4'> Reject</a> </div></div>";
        
         } ?>
    </div> 
<?php
}
else
{
?>
	<li class="big-text">
     <a href="javascript:void(0);">
        <strong>Following Request</strong> <br />
         <span id="following_req_span"><?php echo $follow_request_count; ?></span>
     </a>
     </li>
<?php	
}
if($block_user_count > 0)
{
?>
<li class="big-text big-text2">
     <a href="javascript:void(0);" onClick="open_block_users_div();">
        <strong>Blocked Users</strong> <br />
         <span id="block_users_span"><?php echo $block_user_count; ?></span>
     </a>
     <div id="block_users_div" style="display:none;">
        <img src="images/tool-arrow.png" alt="" />
        <?php while($row_all_block_users = mysql_fetch_array($block_user)) { 
            
            echo "<div class='big-row' id='div_block_user".$row_all_block_users['id']."'><a class='left' href='user.php?id=".$row_all_block_users['follower_id']."' style='color:#4E7AD5'>".getNameTable("restaurant_customer","firstname","id",$row_all_block_users['follower_id'])." ".getNameTable("restaurant_customer","lastname","id",$row_all_block_users['follower_id'])."</a> <div class='left'> <a href='javascript:void(0);' onclick='remove_user_block(".$row_all_block_users['id'].")' class='button4'> X</a>  </div></div>";
        
         } ?>
    </div> 
<?php
}
else
{
?>
	<li class="big-text big-text2">
     <a href="javascript:void(0);">
        <strong>Blocked Users</strong> <br />
         <span id="block_users_span"><?php echo $block_user_count; ?></span>
     </a>
     </li>
<?php	
}
?>

</li>
</ul>
</div>
</div>
<div class="clear"></div>
</div>


<div class="total-reward" align="center"  style="width:100%; margin-top:10px;">
<div class="clear"></div>
<span style="font-weight:bold;">Your Total Reward Point is <?php echo $sql['reward_point'];?></span>
<?php /*?><div id="circle"></div>
<div class="clear"></div>
<span style="color:<?php echo $color;?>"><?php echo $message; ?></span><?php */?>
<div class="clear"></div>
</div>


<div class="right_user_div reward-listing-sec" align="center"  style="width:100%; margin-top:10px;">
<!-- <div class="clear"></div> -->
<?php
$sql_mul_reward = mysql_query("SELECT * FROM restaurant_multiple_reward WHERE end_date >= CURRENT_DATE");
$inc = 1;
while($row_mul_reward = mysql_fetch_array($sql_mul_reward))
{
	//echo "SELECT SUM(point_added) AS points WHERE user_id = '".$_SESSION['customer_id']."' AND reward_id = '".$row_mul_reward['id']."'";
	$current_reward_single = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_point_history WHERE user_id = '".$_SESSION['customer_id']."' AND reward_id = '".$row_mul_reward['id']."'"));
	
	if($current_reward_single['point_added'] > $row_mul_reward['redeemable_point']){
		$frac = $current_reward_single['point_added']/$row_mul_reward['redeemable_point'];
		
		$frac_arr = explode(".",$frac);
	
		$tot_rew_pts = $frac_arr[0]*$row_mul_reward['redeemable_point'];
		
		$remaining_part = $current_reward_single['point_added'] - ($frac_arr[0]*$row_mul_reward['redeemable_point']);
	}else{
		$tot_rew_pts = $current_reward_single['point_added'];
		$remaining_part = $current_reward_single['point_added'];
	}
?>
<div class="reward-listing">
<div id="circle<?php echo $inc; ?>" style="margin-left:10px;"></div>
<div class="reward-dtl">
<span class="reward_name"><?php echo $row_mul_reward['name']; ?></span>
<span class="reward_point">Your  Reward Point is <?php if($remaining_part != "") { echo $remaining_part."/".$row_mul_reward['redeemable_point']; } else
{ echo "0/".$row_mul_reward['redeemable_point']; } ?></span>
<?php
if($current_reward_single['point_added'] >= $row_mul_reward['redeemable_point'])
{
?>
<br>
<span class="reward_message">Congratulations!!!!You can now successfully redeem your Reward Points.</span>
<br>
<span style="float:left;  display: inline-block;"><a href="redeem_rewards.php?id=<?php echo $current_reward_single['id']; ?>&point=<?php echo $tot_rew_pts; ?>&cust_id=<?php echo $_SESSION['customer_id']; ?>" class="redeem_message">Click Here To Redeem <?php echo $tot_rew_pts; ?> Points</a></span>
<?php
}
else
{
?>
	<span class="full-block">You need <span style="color:#F00;"><?php echo ($row_mul_reward['redeemable_point'] - $current_reward_single['point_added']);?></span> more points to reach your reward, <a href="javascript:void(0);" onClick="open_desc_div('<?php echo $inc; ?>');">Click here</a> for Reward Details</span>
<?php
}
?>
</div>
<div class="clear"></div>
<?php
$percentage_multiple = number_format(($remaining_part * 100)/$row_mul_reward['redeemable_point'],2);
if($percentage_multiple > 100)
{
	$percentage_multiple = "100";
}
?>
<script type="text/javascript">
$('#circle'+<?php echo $inc; ?>).progressCircle({
nPercent        : <?php echo $percentage_multiple; ?>,
showPercentText : true,
circleSize      : 100,
thickness       : 2
});
</script>

</div>
<?php
$start_date = date('S', strtotime($row_mul_reward['start_date']));
$start_month = date('M', strtotime($row_mul_reward['start_date']));
$start_year = date('Y', strtotime($row_mul_reward['start_date']));

$exp_date = date('S', strtotime($row_mul_reward['end_date']));
$exp_month = date('M', strtotime($row_mul_reward['end_date']));
$exp_year = date('Y', strtotime($row_mul_reward['end_date']));
?>
	<div id="desc_div<?php echo $inc; ?>" style="display:none;" class="assign_item white_content"  >
						
    <div class="close close-new" onclick="close_desc_div('<?php echo $inc; ?>');"><a href = "javascript:void(0);"> </a> </div>
   	 <div class="l-contnt up-contnt"> 
    
    <div class="form-group">
            
                <div class="">
                    <h2 class="up_nw_load"><?php echo $row_mul_reward['name']; ?> Reward Details</h2>
                    <div class="col-md-9 item-pic-2">
                    <p>Description : <?php echo $row_mul_reward['description'];?></p> 
                    <p>Start Date : <?php echo date('d', strtotime($row_mul_reward['start_date']))."".$start_date." ".$start_month." ".$start_year; ?></p>
                    <p>Expiry Date : <?php echo date('d', strtotime($row_mul_reward['end_date']))."".$exp_date." ".$exp_month." ".$exp_year; ?></p>
                    <p>Receiveable Point : <?php echo $row_mul_reward['redeemable_point']; ?></p>
                    <?php
						$reward_types = explode(",",$row_mul_reward['reward_type']);
					?>
                    <p>Points against Actions : 
                    <div>
					<?php foreach($reward_types as $rewards)
						{
					 		echo "<p>".getNameTable("restaurant_reward_type_master","name","id",$rewards)."</p>";
						}
					 ?>
                     </div></p>
                    </div>
                    
               </div>
             </div>

    </div>
    </div>
    <div id="fade1" class="black_overlay"> </div>



<?php
$inc++;
}
?>
</div>



<div class="right_user_div">
<h1><a href="edit_profile.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/edit_profile.png" width="161" height="51"></a></h1>
<div><img src="images/shdw_btm.png" width="204" height="14">
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>

<div class="right_user_div">
<h1><a href="customer_order_history.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/order_history.png" width="161" height="51"></a></h1>
<div><img src="images/shdw_btm.png" width="204" height="14">
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>


<div class="clear"></div>
<div class="right_user_div">
<h1><a href="customer_reviews.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/reviews.png" width="161" height="51"></a></h1>
<div><img src="images/shdw_btm.png" width="204" height="14">
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>



<div class="right_user_div">
<h1><a href="gift_certificate_order_history.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/gift.png" width="161" height="51"></a></h1>
<div><img src="images/shdw_btm.png" width="204" height="14">
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>


</div>



<div class="clear"></div>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>


<?php
while($row_all_following1 = mysql_fetch_array($all_following1)) { 
?>
	<div id="block_confirm_user<?php echo $row_all_following1['id']; ?>" class="factor_details white_content nw_white_cont12 flex_popup flex_popup-n" style="width:200px; background:#ffffff; display:none;">
    						<style type="text/css">
                               .white_content {
                                  /* display:block !important;*/
                               }
							   .flex_popup-n {
								   width:350px !important;
								   left:none !important;
								   top:32% !important;
								   padding-top:20px !important;
								   padding-bottom:20px !important;
								   left:38% !important;
							   }
							   .flex_popup-n p {
								   text-align:center !important;
								   font-size:18px !important;
								  
							   }
							   .yes-no {
								   text-align:center !important;
							   }
							   .yes-no a {
								   display:inline-block;
								   padding:5px 10px;
								   background:#FA8731;
								   color:#fff !important;
								   border-radius:5px;
							   }
							   .yes-no a:hover {
								   text-decoration:none !important;
							   }
							   .yes-no p {
								   padding-bottom:15px !important;
								   color:#333333;
								   
							   }
                               </style>
	<div class="close close-new" onClick="close_block_confirm_user_div('<?php echo $row_all_following1['id'] ?>');"><a href = "javascript:void(0);"></a> </div>
<div class="l-contnt nw-l-cont yes-no"> 
		<p>Do you want to block this user ?</p>
		<a href="javascript:void(0);" onClick="return confirm_user_blk('<?php echo $row_all_following1['id']; ?>','yes');" style="color:#000;">Yes</a>  <a href="javascript:void(0);"  onClick="return confirm_user_blk('<?php echo $row_all_following1['id']; ?>','no');"  style="color:#000;">No</a>
		</div>
		</div>
	</div> 
<?php 
}
?>
<div id="fade1" class="black_overlay"> </div>


<?php include("includes/footer_search.php");?>



<input type="hidden" name="percentage" id="percentage" value="<?php echo $percentage; ?>" />


<script type="text/javascript">

var percent = $("#percentage").val();

$('#circle').progressCircle({
nPercent        : percent,
showPercentText : true,
circleSize      : 100,
thickness       : 2
});
</script>