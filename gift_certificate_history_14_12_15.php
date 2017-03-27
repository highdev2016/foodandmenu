<?php 
session_start();
ob_start();


include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");


if(!isset($_SESSION['customer_id'])){
	header("location:index.php");
}

$customer_id = $_SESSION['customer_id'];

function change_dateformat_reverse_db($date_form1)
 {
  if($date_form1!=''){
   $date2=explode("-",$date_form1);
   $dateformat1=$date2[1]."-".$date2[2]."-".$date2[0];
   return $dateformat1;
   }
  else{
   $dateformat1='';
   return $dateformat1;
   }
 }

/*if($_REQUEST['gift_id']!=''){
	$gift_id = $_REQUEST['gift_id'];
	
	$sql_update_gift_cer_status = mysql_query("UPDATE restaurant_certificate_no SET used = '1' WHERE giftcard_id = '".$gift_id."' ");
	header("location:gift_certificate_history.php?success=1");
}*/

if($_REQUEST['submit_con_gift'] == 'Yes'){
	$sql_update = mysql_query("UPDATE restaurant_gift_certificate_no SET used = '1' WHERE giftcard_id = '".$_REQUEST['gift_cer_id']."' ");
	header("location:gift_certificate_history.php?success=1");
}

?>


<script type="text/javascript">
function getkey(e)
{
if (window.event)
return window.event.keyCode;
else if (e)
return e.which;
else
return null;
}
function goodchars(e, goods)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
if (goods.indexOf(keychar) != -1)
return true;
if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
return true;
return false;
}

var $j = jQuery.noConflict();
$j(document).mouseup(function (e)
{
    var favourite = $j("#favourite_div");
	var follower = $j("#follower_div");
	var following = $j("#following_div");
	var following_req = $j("#following_req_div");
	var notification = $j("#notification_div");
	var block = $j("#block_users_div");
	

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

	
function follow_user(user_id,follow_id)
{
	var $j = jQuery.noConflict();
	var hid_user_id = $('#hid_user_id').val();
	if(user_id != '')
	{
		$j.ajax({
			url : 'user_follow.php',
			type : 'POST',
			data : 'user_id=' + user_id + '&follow_id=' + follow_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				if(data != "You have already Followed this user!!")
				{
					new_data = data.split("^");
					
					$j("#follow_li").hide().html(new_data[0]).fadeIn(1000);
					$j("#following_span").html(new_data[2]);
					$j("#follower_span").html(new_data[1]);
				}
				else
				{
					alert(data);
					window.location.href='user.php?id='+follow_id;
				}
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
	}
	else
	{
		window.location.href='login.php?user_id='+hid_user_id;
	}
}


function accept_reject_request(id,val)
{
	var $j = jQuery.noConflict();
	var hid_user_id = $('#hid_user_id').val();
	
	$j.ajax({
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
				
				$j("#div_acc_rej"+id).fadeOut(1000);
				$j("#follower_span").html(data_new[2]);
				$j("#following_span").html(data_new[1]);
				
				location.reload();
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}


function confirm_user_blk(id,blk_status){
	
	var $j = jQuery.noConflict();
	var follower_count = $("#follower_span").html();
	var block_count = $("#block_users_span").html();
	
	$j.ajax({
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
					 $j('#rem_user_follow'+data).fadeOut(1000); 
				 }
				 $j("#block_confirm_user"+id).hide();
				 $j("#fade1").hide();
				 
				var new_count = parseInt(follower_count) - parseInt(1);
				var new_block_count = parseInt(block_count) + parseInt(1);
    
   				 $j("#follower_span").html(new_count);
				 $j("#block_users_span").html(block_count);
				 
				 
				 
				 
				 
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}

function open_favourite_div()
{
	var $j = jQuery.noConflict();
	$j("#block_users_div").hide();
	$j("#notification_div").hide();
	$j("#following_div").hide();
	$j("#follower_div").hide();
	$j("#favourite_div").slideDown();
}

function open_notification_div()
{
	var $j = jQuery.noConflict();
	$j("#block_users_div").hide();
	$j("#following_div").hide();
	$j("#follower_div").hide();
	$j("#favourite_div").hide();
	$j("#notification_div").slideDown();
}

function open_follower_div()
{
	var $j = jQuery.noConflict();
	$j("#block_users_div").hide();
	$j("#notification_div").hide();
	$j("#following_div").hide();
	$j("#favourite_div").hide();
	$j("#follower_div").slideDown();
}

function open_following_div()
{
	var $j = jQuery.noConflict();
	$j("#block_users_div").hide();
	$j("#notification_div").hide();
	$j("#follower_div").hide();
	$j("#favourite_div").hide();
	$j("#following_div").slideDown();
}

function open_following_req_div()
{
	var $j = jQuery.noConflict();
	$j("#block_users_div").hide();
	$j("#follower_div").hide();
	$j("#favourite_div").hide();
	$j("#following_div").hide();
	$j("#following_req_div").slideDown();
}

function open_block_users_div()
{
	var $j = jQuery.noConflict();
	$j("#follower_div").hide();
	$j("#favourite_div").hide();
	$j("#following_div").hide();
	$j("#following_req_div").hide();
	$j("#block_users_div").slideDown();
}

function sort_date(user_id)
{
	var $j = jQuery.noConflict();
	$j("#loader_div").show();
	$j("#main_res_div").addClass('load-faad');
	$j("#hid_sort_type").val('id');
	$j("#hid_count").val('10');
	
	var sort_type = $j("#hid_sort").val(); 
	

	$j.ajax({
			url : 'sort_data.php',
			type : 'POST',
			data : 'sort_type=' + sort_type + '&user_id=' + user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				$j("#main_res_div").html(data);
				
				
				//setTimeout(function(){$("#loader_div").hide(); $("#main_res_div").removeClass('load-faad')}, 5000);
				//$("#loader_div").hide();
				
				$j("#loader_div").hide(); 
				$j("#main_res_div").removeClass('load-faad');
				
				if(sort_type == "DESC")
				{
					$j("#hid_sort").val('ASC');
				}
				if(sort_type == "ASC")
				{
					$j("#hid_sort").val('DESC');
				}
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}

function sort_rating(user_id)
{
	var $j = jQuery.noConflict();
	$j("#loader_div").show();
	$j("#main_res_div").addClass('load-faad');
	$j("#hid_sort_type").val('score');
	$j("#hid_count").val('10');
	
	var sort_type = $j("#hid_sort").val(); 
	

	$j.ajax({
			url : 'rating_data.php',
			type : 'POST',
			data : 'sort_type=' + sort_type + '&user_id=' + user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				$j("#main_res_div").html(data);
				
				
				//setTimeout(function(){$("#loader_div").hide(); $("#main_res_div").removeClass('load-faad')}, 5000);
				//$("#loader_div").hide();
				
				$j("#loader_div").hide();
				$j("#main_res_div").removeClass('load-faad');
				
				if(sort_type == "DESC")
				{
					$j("#hid_sort").val('ASC');
				}
				if(sort_type == "ASC")
				{
					$j("#hid_sort").val('DESC');
				}
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}

</script>

<script type="text/javascript">
function open_slider_div(id)
{
	var $j = jQuery.noConflict();
	$j("#slider_div"+id).css("visibility", "visible").css("opacity", "100");
	$j("#fade1").show();
}

function close_slider_div(id)
{
	var $j = jQuery.noConflict();
	$j("#slider_div"+id).css("visibility", "hidden").css("opacity", "0");
	$j("#fade1").hide();
}

function get_confirm(id){
	var $j = jQuery.noConflict();
	$j("#block_confirm_user"+id).show();
	$j("#fade1").show();
}

function close_block_confirm_user_div(id){
	var $j = jQuery.noConflict();
	$j("#block_confirm_user"+id).hide();
	$j("#fade1").hide();
}
</script>


<script type="text/javascript">
function remove_user_block(id)
{
	var $j = jQuery.noConflict();
	var block_count = $("#block_users_span").html();
	//var hid_user_id = $('#hid_user_id').val();
	
	$j.ajax({
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
				
				$j("#block_users_span").html(new_count);
				
				$j("#div_block_user"+id).fadeOut(1000);
				
				if(new_count == 0)
				{
					$j("#block_users_div").remove();
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

function open_desc_div(id)
{
	var $j = jQuery.noConflict();
	$j("#desc_div"+id).show();
	$j("#fade1").show();
}

function close_desc_div(id)
{
	var $j = jQuery.noConflict();
	$j("#desc_div"+id).hide();
	$j("#fade1").hide();
}

</script>
<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />

<body>


<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php");?>

<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $customer_id; ?>" />

<input type="hidden" name="hid_user_id" id="hid_user_id" value="<?php echo $_REQUEST['id']; ?>">

<?php 
$username = getNameTable("restaurant_customer","firstname","id",$customer_id);

$joining_date = date("F Y", strtotime(getNameTable("restaurant_customer","registration_time","id",$customer_id)));

$profile_pic = getNameTable("restaurant_customer","image","id",$customer_id);

$address = getNameTable("restaurant_customer","city","id",$customer_id).", ".getNameTable("restaurant_customer","state","id",$customer_id);

$sql = "SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND rr.review_status = 0 order by id DESC LIMIT 0,5";

//echo $sql;

$sql_res = mysql_query($sql);

$sql_slider = "SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 order by id DESC";

$sql_res_slider = mysql_query($sql_slider);

$page_review_count = mysql_num_rows($sql_res);

$review_count = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 order by id desc"));

/*echo "SELECT * FROM restaurant_like_dislike as rld INNER JOIN restaurant_reviews as rr ON rr.id = rld.review_id  WHERE rld.customer_id = '".$customer_id."' AND rld.is_like_status = 1 AND rld.is_like = 1 ";

echo "SELECT * FROM restaurant_like_dislike as rld INNER JOIN restaurant_reviews as rr ON rr.id = rld.review_id  WHERE rld.customer_id = '".$customer_id."' AND rld.is_dislike_status = 1 AND rld.is_dislike = 1 ";*/


$like_count = mysql_fetch_array(mysql_query("SELECT SUM(is_like) as like_count FROM restaurant_like_dislike as rld INNER JOIN restaurant_reviews as rr ON rr.id = rld.review_id  WHERE rld.customer_id = '".$customer_id."' AND rld.is_like_status = 1 AND rld.is_like = 1"));

$like_review = mysql_query("SELECT * FROM restaurant_like_dislike as rld INNER JOIN restaurant_reviews as rr ON rr.id = rld.review_id  WHERE rld.customer_id = '".$customer_id."' AND rld.is_like_status = 1 AND rld.is_like = 1 ");

$dislike_count = mysql_fetch_array(mysql_query("SELECT SUM(is_dislike) as dislike_count FROM restaurant_like_dislike as rld INNER JOIN restaurant_reviews as rr ON rr.id = rld.review_id  WHERE rld.customer_id = '".$customer_id."' AND rld.is_dislike_status = 1 AND rld.is_dislike = 1 "));

$dislike_review = mysql_query("SELECT * FROM restaurant_like_dislike as rld INNER JOIN restaurant_reviews as rr ON rr.id = rld.review_id  WHERE rld.customer_id = '".$customer_id."' AND rld.is_dislike_status = 1 AND rld.is_dislike = 1 ");

$follower_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$customer_id."' AND status = '1' "));

$following_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1' "));

$check_follow_status = mysql_fetch_array(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND follower_id = '".$_SESSION['customer_id']."' "));

$check_follow_num = mysql_num_rows(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND follower_id = '".$_SESSION['customer_id']."' "));

$favourite_count = mysql_num_rows(mysql_query("SELECT id FROM restaurant_favourite WHERE user_id = '".$customer_id."' "));

$all_follower = mysql_query("SELECT * FROM user_follow WHERE follower_id = '".$customer_id."' AND status = '1' ");

$all_following = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1' ");

$all_following1 = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1' ");

$all_favourite = mysql_query("SELECT * FROM restaurant_favourite WHERE user_id = '".$customer_id."' ");





$follow_request_count = mysql_num_rows(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '0'"));

$follow_request = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '0'");

$block_user_count = mysql_num_rows(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND block_status = '1'")); 

$block_user = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND block_status = '1'"); 

$block_status = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$_SESSION['customer_id']."' AND following_id = '".$_REQUEST['id']."' AND block_status = '1'"));

?>
	<div class="body_section">
	
		<div class="container">
			<div class="body_top"> </div>
			<div class="main_body">
			
				<div class="contact_body_cont" style="min-height:600px;">
				
					<div class="user-profile-section">
						
						<div class="user-profile-top">
							<div class="profile-name">
                            
								<h1><?php echo $username."'s"; ?> Profile</h1>
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
                                            
                                            echo "<a href='user.php?id=".$row_all_follower['following_id']."' style='color:#4E7AD5'>".getNameTable("restaurant_customer","firstname","id",$row_all_follower['following_id'])." ".getNameTable("restaurant_customer","lastname","id",$row_all_follower['following_id'])."</a>";
                                        
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
							<div class="clear"> </div>
						</div> <!-- End user-profile-top -->
						<div class="clear"> </div>
                        
                        
                        
                                        
                                        
						
						<div class="user-cont">
							
							<div class="user-cont-left">
								<div class="pro-pic">
                                <?php if($profile_pic != "")
								{
									?>
									<img src="uploaded_images/<?php echo $profile_pic; ?>" alt="" width="200" height="180" />
                                    <?php
								}
								else
								{
									?>
                                    <img src="images/no_image.png" alt="" width="200" />
                                    <?php
								}
								?>
								</div>
								
								<label>
									<h5>Member Since</h5>
									<p><?php echo $joining_date; ?></p>
								</label>
								
                                <?php
								if($address != ', ')
								{
								?>
								<label>
									<h5>Location</h5>
									<p><?php echo $address; ?></p>
								</label>
                                <?php
								}
								?>
                                
                                <?php
								if($like_count['like_count'] > 1)
								{
									$like_word = "likes";
								}
								else
								{
									$like_word = "like";
								}
								
								if($dislike_count['dislike_count'] > 1)
								{
									$dislike_word = "dislikes";
								}
								else
								{
									$dislike_word = "dislike";
								}
								
								if($like_count['like_count'] == '')
								{
									$like = 0;
								}
								else
								{
									$like = $like_count['like_count'];
								}
								
								
								if($dislike_count['dislike_count'] == '')
								{
									$dislike = 0;
								}
								else
								{
									$dislike = $dislike_count['dislike_count'];
								}
								
								
								?>
                                
								<h4>
                                <?php
								if($like_count['like_count'] > 0)
								{
								?>
									<strong><a  id="various1" class="likes_inline" href="#inline<?php echo $customer_id; ?>" style="color:#404CA1;" title=""><?php echo $like." ".$like_word; ?> </a></strong>,  
                                <?php
								}
								else
								{
								?>
                                	<strong><?php echo $like." ".$like_word; ?></strong>,
								<?php
                                }
								if($dislike_count['dislike_count'] > 0)
								{
								?>
									<strong><a  id="various2" class="likes_inline" href="#inline_dislike" style="color:#404CA1;" title=""><?php echo $dislike." ".$dislike_word; ?></a> </strong>
                                <?php
								}
								else
								{
								?>
                                    <strong><?php echo $dislike." ".$dislike_word; ?> </strong>
                                <?php
								}
                                ?>
								</h4>
                                
                                <div class="user_left_bottom_pic">
                                
                                <div>
									<a href="edit_profile.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/edit_profile.png" width="161" height="51"></a>
								</div>
								<div class="clear"> </div>
                                
                                <div>
									<a href="edit_shipping_billing.php"><img src="images/edit_shipping.png" width="161" height="51"></a>
								</div>
								<div class="clear"> </div>
                                
                                <div>
									<a href="order_history.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/order_history.png" width="161" height="51"></a>
								</div>
								<div class="clear"> </div>
                                
                                <div>
									<a href="gift_certificate_history.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/gift.png" width="161" height="51"></a>
								</div>
								<div class="clear"> </div>
                                
                                <div>
									<a href="customer_reviews.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/reviews.png" width="161" height="51"></a>
								</div>
								<div class="clear"> </div>
                                
                                <div>
									<a href="onlinereservation.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/online_reservation.png" width="161" height="51"></a>
								</div>
								<div class="clear"> </div>
                                
                                </div>
                                
								<!--<div class="review-up">
									<img src="images/reload.png" align="absmiddle" /> 1 Review update
								</div>
								<div class="clear"> </div>
								
								<div class="report-ab">
									<img src="images/report-flag.png" align="absmiddle" /> Report Abuse
								</div>-->
								<div class="clear"> </div>
								
								<div style="display: none;">
                                    <div id="inline<?php echo $customer_id; ?>" style="height:250px; min-height:450px; overflow:auto; width:615px;">
                                    	<h2 class="rv-pop-title">Liked Review List</h2>
									<?php
									while($like_fetch = mysql_fetch_array($like_review))
									{
									 $sql_user_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$like_fetch['review_id']."' ORDER BY id DESC");
									
									 ?>
                                    <?php /*?><h1 class="review_top_heading"><span>Total Reviews : <?php echo mysql_num_rows($sql_user_reviews); ?></span></h1><?php */?>
                                    <?php
									while($array_user_reviews = mysql_fetch_array($sql_user_reviews)){
										
									?>
                                        <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=<?php echo $array_user_reviews['restaurant_id']; ?>" style="color:#F07A01; text-decoration:none;"><?php echo $array_user_reviews['restaurant_name']; ?></a></span></h1>                                          
                                        <ul>
                                    	<?php
										$rating1 = getSingleReviewRating($array_user_reviews['restaurant_id'],$array_user_reviews['id']);
										//echo $rating1;
										$rem = 5 - $rating1;
										if($rating1 > 0)
										{
											for($i=0; $i<$rating1;$i++){
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
                                    <?php } 
									}
									?>
                                         
                                    </div>
                                    
                                	</div>
                                    
                                    
                                    <div style="display: none;">
                                    <div id="inline_dislike" style="height:250px; min-height:450px; overflow:auto; width:615px;">
                                    	<h2 class="rv-pop-title">Disliked Review List</h2>
									<?php
									while($dislike_fetch = mysql_fetch_array($dislike_review))
									{
									 $sql_user_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$dislike_fetch['review_id']."' ORDER BY id DESC");
									
									 ?>
                                    <?php /*?><h1 class="review_top_heading"><span>Total Reviews : <?php echo mysql_num_rows($sql_user_reviews); ?></span></h1><?php */?>
                                    <?php
									while($array_user_reviews = mysql_fetch_array($sql_user_reviews)){
										
									?>
                                        <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=<?php echo $array_user_reviews['restaurant_id']; ?>" style="color:#F07A01; text-decoration:none;"><?php echo $array_user_reviews['restaurant_name']; ?></a></span></h1>                                          
                                        <ul>
                                    	<?php
										$rating1 = getSingleReviewRating($array_user_reviews['restaurant_id'],$array_user_reviews['id']);
										//echo $rating1;
										$rem = 5 - $rating1;
										if($rating1 > 0)
										{
											for($i=0; $i<$rating1;$i++){
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
                                    <?php } 
									}
									?>
                                         
                                    </div>
                                    
                                	</div>
								
							
							</div> <!-- End user-cont -->
							
                            <?php
							$sql_user_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."' "));
							?>
							
							
							<div class="user-cont-right">
                            
								
								<div class="right-top" id="right-top">
								
								<div id="loader_div" class="sec-load" style="display:none;"><img src="images/loader_gif.gif"></div>
                                
                                <div id="main_res_div" class="">
                                
                                <!-- Start restu-block -->
                                
                                <div class="restu-block">
                                
                                <?php if($_REQUEST['success'] == 1) {?>
                                	<p style="color:#090; margin-bottom:5px; font-size:16px;">Gift Certificate Confirmed Successfully.</p>
                                <?php } ?>
                                
                                <h1 class="clss_pro_edit">Gift Certificate Order History</h1>
                                
                                
                                
								<?php
                                $query_res = ("SELECT * from restaurant_gift_card where customer_id = '".$_SESSION['customer_id']."' ");
                                
                                if($_REQUEST['restaurant_name']!=''){
                                  $query_res.= " AND restaurant_id = '".$_REQUEST['restaurant_name']."' ";
                                }
								
								$query1 = mysql_query($query_res);
								$deal_amt = 0;
								$act_amt = 0;
								while($array_res = mysql_fetch_array($query1)){
									$sql_select_deal = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_deals WHERE id = '".$array_res['deal_id']."' "));
									$deal_amt = $deal_amt+$array_res['price'];
									$act_amt = $act_amt+$sql_select_deal['daily_description'];
								}
								$amount_saved = ($act_amt - $deal_amt);
                                ?>
                                <p class="save_txt">You Save <span>$<?php echo $amount_saved; ?></span> at this restaurant by using Food and menu</p>
                                
                                <form name="gift_cer_frm" id="gift_cer_frm" method="post" action="" class="reserve_form">
                                
                                <div class="reserve_select_sec">
                                <?php
								$sql_sel_res = mysql_query("SELECT DISTINCT(restaurant_id) as res_id FROM restaurant_gift_card WHERE customer_id = '".$_SESSION['customer_id']."'");
								$res_in = '';
								$sep2 = '';
								while($row_res1 = mysql_fetch_array($sql_sel_res))
								{
									$res_in = $res_in.$sep2.$row_res1['res_id'];
									$sep2 = ',';
								}
								?>
                                <select name="restaurant_name" id="restaurant_name" class="reserve_select" style="width:300px;">
                                	<option value="">Select</option>
                                    <?php $sql_sel_restaurant = mysql_query("SELECT * FROM restaurant_basic_info WHERE status = '1' AND id IN (".$res_in.") ORDER BY restaurant_name ASC");
									while($array_sel_restaurant = mysql_fetch_array($sql_sel_restaurant)){ ?>
                                    <option value="<?php echo $array_sel_restaurant['id']; ?>" <?php if($array_sel_restaurant['id'] == $_REQUEST['restaurant_name']){ ?> selected="selected" <?php } ?>><?php echo $array_sel_restaurant['restaurant_name']; ?></option>
                                    <?php } ?>
                                </select>
                                
                                <input type="submit" name="search" id="search" value="Search">
                                
                                <a href="gift_certificate_history.php"><input type="button" name="show_all" id="show_all" value="Show All"></a>
                                
                                <div class="clear"></div>
                                
                                </div>
								
								<table width="99%" border="1" bordercolor="#dddddd" cellspacing="0" cellpadding="0" align="center" class="reserve_table" style="border-collapse:collapse;">
                                <tr>
                                  <?php /*?><td width="4%" class="all_restaurant">Sl No.</td><?php */?>
                                  <td width="12%" class="all_restaurant">Restaurant Name</td>
                                  <td width="12%" class="all_restaurant">Deal</td>
                                  <td width="12%" class="all_restaurant">Price</td>
                                  <td width="12%" class="all_restaurant">Purchase Date (MM-DD-YYYY)</td>
                                  <td width="12%" class="all_restaurant">Expiry Date (MM-DD-YYYY)</td>
                                  <td width="14%" class="all_restaurant" align="center">Action</td>
                                  <td width="14%" class="all_restaurant">Used Status</td>
                                </tr>
  <?php 
			
  $query_res = ("SELECT * from restaurant_gift_card where customer_id = '".$_SESSION['customer_id']."' ");
  
  if($_REQUEST['restaurant_name']!=''){
	  $query_res.= " restaurant_id = '".$_REQUEST['restaurant_name']."' ";
  }
  
  $query_res.=" ORDER BY id DESC ";
 
  //echo $query_res;
  $sql_order = mysql_query($query_res);
  if(mysql_num_rows($sql_order)>0){
	  
		//////////////////////start pagination/////////////////////////
		if($_REQUEST['search']!="")
		{
			$page=1;
		}
		else
		{
			$page=$_REQUEST['page'];
			
			if($_REQUEST['page']=="") 
			{ 
			$page = 1; 
			} 
		}
		if($_REQUEST['item_per_page'] == "")
		{
			$max_results = 10; 
		}
		else
		{
			$max_results = $_REQUEST['item_per_page'];
		} 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sql_order); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if(!isset($_GET['page']) || ($_REQUEST['submit']!="") || $_GET['page']==''){
			$page_num = 1;
		} else {
			$page_num = $_GET['page'];
		}
		
		/*$page_num = 1;
		
		if(isset($_GET['page'])){$page_num = $_GET['page'];}*/
		
		$offset = $page_num; 
		
		if($page_num == 0) {$page_num = 1;}
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"gift_certificate_history.php?page=$prev&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		for($i = 1; $i <=$total_pages; $i++) 
		{ 
		if(($page) == $i) 
		{ 
		$pagination .= $i; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		else 
		{ 
		$pagination .= "<a href=\"gift_certificate_history.php?page=$i&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"gift_certificate_history.php?page=$next&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
		if($_REQUEST['page']!="")
		{
			$j=($_REQUEST['page']-1)*$max_results;
		}
		if($_REQUEST['search']!="")
		{
		$j=0;	
		}
	  ?>
      
      

		<?php $inc = 1;
        while($array_order = mysql_fetch_array($query_products)){
		$sql_used_check = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_gift_certificate_no WHERE giftcard_id = '".$array_order['id']."'"));
		?>
            <tr>
              <td class="all_restaurant2"><?php echo $array_order['restaurant_name']; ?></td>
              <td class="all_restaurant2"><?php echo $array_order['deal']; ?></td>
              <td class="all_restaurant2"><?php echo $array_order['price']; ?></td>
              <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_order['purchase_date']))."<br>";
			  $arr_date_time = explode(" ",$array_order['purchase_date']); 
			  echo date("g:i A", strtotime($arr_date_time[1]));
			  ?></td>
              <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($sql_used_check['expiry_date'])); ?></td>
              <td class="all_restaurant2"><a href="view_certificate.php?giftcard_id=<?php echo $array_order['id']; ?>"  class="example_cat used_cls" style="text-align:center;">View Certificate</a></td>
              <td class="all_restaurant2"><?php
			  if($sql_used_check['used'] == 1) {  echo "Already Used"; } else { echo "Not Used"; ?><?php }?><?php /*?><a href="javascript:void(0);" onClick="return confirm_gift_cer('<?php echo $array_order['id']; ?>');">Confirm</a> <?php */?>
              <br>
              <?php if($sql_used_check['used']!='1'){?>
              	<a href="javascript:void(0);" onClick="open_conf_div('<?php echo $sql_used_check['giftcard_id']; ?>');" class="used_cls">Click to Use</a>
              <?php } ?>
              </td>
            </tr>
            
            <?php $inc++; } } else { ?>
            <tr>
              <td class="all_restaurant2" colspan="9" style="text-align:center;">No gift certificate ordered yet.</td>
            </tr>
            <?php } ?>
          </table>		
			<?php if ($total_pages > '1' ) {
	
            $range =5; //set this to what ever range you want to show in the pagination link
            $range_min = ($range % 2 == 0) ? ($range / 2) - 1 : ($range - 1) / 2;
            $range_max = ($range % 2 == 0) ? $range_min + 1 : $range_min;
            $page_min = $page_num- $range_min;
            $page_max = $page_num+ $range_max;

            $page_min = ($page_min < 1) ? 1 : $page_min;
            $page_max = ($page_max < ($page_min + $range - 1)) ? $page_min + $range - 1 : $page_max;
            if ($page_max > $total_pages) {
                $page_min = ($page_min > 1) ? $total_pages - $range + 1 : 1;
                $page_max = $total_pages;
            }

            $page_min = ($page_min < 1) ? 1 : $page_min;
			
			if ($page_num != 1) {
                $page_pagination.= "<a href=\"gift_certificate_history.php?page=$prev&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
				
				}

            for ($i = $page_min;$i <= $page_max;$i++) {
                if ($i == $page_num){
                $page_pagination .= $i; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
                else{
                $page_pagination.= "<a href=\"gift_certificate_history.php?page=$i&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination\">$i</a>"; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
			}
			
			
			if ($page_num < $total_pages) {
                $page_pagination.= "<a href=\"gift_certificate_history.php?page=$next&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Next</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
		} 
?>
          <div style="text-align:center; margin-top:15px; margin-bottom:10px;"><?php echo $page_pagination; ?></div>
          <?php } ?>							
                                
                                
                                
                                </div>    
                                
                                        <div class="clear"> </div>
									</div>
                                    
                                
                                
                                </div>
                                
                                
										
                                              
                                        
										
                                        
                                        <div class="clear"> </div>
									</div>
                                
                                
                                </div>
                                
                                <?php /*?><?php 
								$query_res1 = ("SELECT * from restaurant_gift_card where customer_id = '".$_SESSION['customer_id']."' ");
  
								  if($_REQUEST['restaurant_name']!=''){
									  $query_res1.= " restaurant_id = '".$_REQUEST['restaurant_name']."' ";
								  }
								  
								  $query_res1.=" ORDER BY id DESC ";
								  
								  $query_products1 = mysql_query($query_res1);
								  
								while($array_order = mysql_fetch_array($query_products1)){ ?>
                                <div id="confirm_gift_cer<?php echo $array_order['id']; ?>" class="factor_details white_content nw_white_cont12 flex_popup flex_popup-n" style="width:200px; background:#ffffff; display:none;">
                                        <div class="close close-new" onClick="close_confirm_gift_cer('<?php echo $array_order['id'] ?>');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont yes-no"> 
                                <p>Are You Sure , you want to confirm gift certificate ?</p>
                                <a href="gift_certificate_history.php?gift_id=<?php echo $array_order['id']; ?>" style="color:#000;">Yes</a>  <a href="javascript:void(0);"  onClick="return close_confirm_gift_cer('<?php echo $array_order['id'] ?>');"  style="color:#000;">No</a>
                                </div>
                                </div>
								<?php } ?><?php */?>
                                
                                
                                <?php
										while($row_all_following1 = mysql_fetch_array($all_following1)) { 
										 ?>
										<div id="block_confirm_user<?php echo $row_all_following1['id']; ?>" class="white_content flex_popup edit_pop" style="display:none;">
                                        <div class="close close-new" onClick="close_block_confirm_user_div('<?php echo $row_all_following1['id'] ?>');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont yes-no"> 
											<p>Do you want to block this user ?</p>
                                            <a href="javascript:void(0);" onClick="return confirm_user_blk('<?php echo $row_all_following1['id']; ?>','yes');" style="color:#000;" class="yes_butt">Yes</a>  <a href="javascript:void(0);"  onClick="return confirm_user_blk('<?php echo $row_all_following1['id']; ?>','no');"  style="color:#000;" class="yes_butt">No</a>
                                           <!-- <br>
        <a href="javascript:void(0);" onClick="close_block_confirm_user_div('<?php echo $row_all_following1['id']; ?>');">Cancel</a>-->
                                            </div>
                                            </div>
										</div> 
										<?php 
										}
										?>
                                
                                <div id="fade1" class="black_overlay"> </div>
                                
									
                                <input type="hidden" name="hid_sort" id="hid_sort" value="ASC">
								<input type="hidden" name="hid_count" id="hid_count" value="10">
                                <input type="hidden" name="hid_count_new" id="hid_count_new" value="<?php echo $review_count; ?>">
                                <input type="hidden" name="hid_sort_type" id="hid_sort_type" value="id">
                                	
                                </form> 	
									
								</div>
								
								
							
							</div> <!-- End user-cont -->
            <div class="body_footer_bg"> </div>
							
						</div> <!-- End user-cont -->
						
						<div class="clear"> </div>
					</div> <!-- End user-profile-section -->
					
                <div id="conf_gift_cer_div" style="display:none; width:20%; left:39%;" class="white_content flex_popup edit_pop"  >
                    <form name="con_gift_cer" id="con_gift_cer" method="post" action="">
                    <input type="hidden" name="gift_cer_id" id="gift_cer_id" value="">
                        <div class="close close-new" onClick="close_gift_cer_div();"><a href = "javascript:void(0);"> </a> </div>
                        <div class="l-contnt nw-l-cont yes-no"> 
                        <p>Are you sure you want to use the Gift Certificate? Once confirm used the Gift Certificate can no longer be valid.</p>
                        <input type="submit" name="submit_con_gift" id="submit_con_gift" value="Yes" class="yes_butt11"> 
                        <a href="javascript:void(0);" onClick="close_gift_cer_div();" style="color:#000;" class="yes_butt">No</a>
                        </div>
                    </form>
                </div>
                <div id="fade1" class="black_overlay"> </div>
				
				
				</div>
			
			
			</div>			
			<div class="clear"></div>
		</div>
	
	</div>
    
   							 

<div class="clear"></div>
<?php include("includes/footer_new.php");?>

<script>
function open_conf_div(val){
	var $j = jQuery.noConflict();
	$j("#conf_gift_cer_div").show();
	$j("#fade1").show();
	$j("#gift_cer_id").val(val);
}
function close_gift_cer_div(){
	var $j = jQuery.noConflict();
	$j("#conf_gift_cer_div").hide();
	$j("#fade1").hide();
	$j("#gift_cer_id").val('');
}
</script>


<script type="text/javascript" src="http://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="http://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
	
	var $j = jQuery.noConflict();
	
  $j(document).ready(function() {
   /*
   *   Examples - images
   */
   
   
   $j("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script>
 
<script>
function confirm_gift_cer(id){
	var $j = jQuery.noConflict();
	$j("#confirm_gift_cer"+id).show();
	$j("#fade1").show();
}

function close_confirm_gift_cer(id){
	var $j = jQuery.noConflict();
	$j("#confirm_gift_cer"+id).hide();
	$j("#fade1").hide();
}
</script>