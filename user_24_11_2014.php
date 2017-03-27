<?php 
session_start();
ob_start();


include ("includes/header.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");

$customer_id = $_REQUEST['id'];

?>
<link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
 <script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript">

$(document).mouseup(function (e)
{
    var favourite = $("#favourite_div");
	var follower = $("#follower_div");
	var following = $("#following_div");
	var following_req = $("#following_req_div");
	var notification = $("#notification_div");
	

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
});

	
function follow_user(user_id,follow_id)
{
	var hid_user_id = $('#hid_user_id').val();
	if(user_id != '')
	{
		$.ajax({
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
					
					$("#follow_li").hide().html(new_data[0]).fadeIn(1000);
					$("#following_span").html(new_data[2]);
					$("#follower_span").html(new_data[1]);
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

function open_follower_div()
{
	$("#following_div").hide();
	$("#favourite_div").hide();
	$("#follower_div").slideDown();
}

function open_following_div()
{
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#following_div").slideDown();
}

function open_following_req_div()
{
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#following_div").hide();
	$("#following_req_div").slideDown();
}

function open_favourite_div()
{
	$("#following_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").slideDown();
}

function open_notification_div()
{
	$("#following_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#notification_div").slideDown();
}

function sort_date(user_id)
{
	$("#loader_div").show();
	$("#main_res_div").addClass('load-faad');
	$("#hid_sort_type").val('id');
	$("#hid_count").val('10');
	
	var sort_type = $("#hid_sort").val(); 
	

	$.ajax({
			url : 'sort_data.php',
			type : 'POST',
			data : 'sort_type=' + sort_type + '&user_id=' + user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				$("#main_res_div").html(data);
				
				
				setTimeout(function(){$("#loader_div").hide(); $("#main_res_div").removeClass('load-faad')}, 5000);
				//$("#loader_div").hide();
				
				if(sort_type == "DESC")
				{
					$("#hid_sort").val('ASC');
				}
				if(sort_type == "ASC")
				{
					$("#hid_sort").val('DESC');
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
	$("#loader_div").show();
	$("#main_res_div").addClass('load-faad');
	$("#hid_sort_type").val('score');
	$("#hid_count").val('10');
	
	var sort_type = $("#hid_sort").val(); 
	

	$.ajax({
			url : 'rating_data.php',
			type : 'POST',
			data : 'sort_type=' + sort_type + '&user_id=' + user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				$("#main_res_div").html(data);
				
				
				setTimeout(function(){$("#loader_div").hide(); $("#main_res_div").removeClass('load-faad')}, 5000);
				//$("#loader_div").hide();
				
				if(sort_type == "DESC")
				{
					$("#hid_sort").val('ASC');
				}
				if(sort_type == "ASC")
				{
					$("#hid_sort").val('DESC');
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
	
	$("#slider_div"+id).css("visibility", "visible").css("opacity", "100");
	$("#fade1").show();
}

function close_slider_div(id)
{
	
	$("#slider_div"+id).css("visibility", "hidden").css("opacity", "0");
	$("#fade1").hide();
}
</script>


<script type="text/javascript">

$(function()
{
$('.more').live("click",function()
{
var ID = $(this).attr("id");
var cust_id = $("#cust_id").val();
var hid_count = $("#hid_count").val();
var sort_date_type = $("#hid_sort").val();
var sorting_type = $("#hid_sort_type").val();
//alert(ID);
if(sort_date_type == "DESC")
{
	var sort_type = "ASC";
}
if(sort_date_type == "ASC")
{
	var sort_type = "DESC";
}

//alert(hid_count);
if(ID)
{
$("#more"+ID).html('<img src="images/moreajax.gif" />');

$.ajax({
type: "POST",
url: "ajax_user.php",
data: "lastmsg="+ ID + "&cust_id=" + cust_id + "&new_count=" + hid_count + '&sort_type=' + sort_type + '&sorting_type=' + sorting_type,
cache: false,
success: function(html){
	//alert(html);
var new_hid_count = parseInt(hid_count) + parseInt(5);	
$("#main_res_div").append(html);
$("#more"+ID).remove(); // removing old more button
$("#hid_count").val(new_hid_count);
}
});
}
else
{
$(".morebox").html('The End');// no results
}

return false;
});
});
</script>
<script type="text/javascript" src="http://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="http://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
	
	//var $j = jQuery.noConflict();
	
  $(document).ready(function() {
   /*
   *   Examples - images
   */
   
   
   $("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script>
<body onLoad="init();">

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>

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
 

$like_count = mysql_fetch_array(mysql_query("SELECT SUM(is_like) as like_count FROM restaurant_like_dislike WHERE customer_id = '".$customer_id."' AND is_like_status = 1 "));

$dislike_count = mysql_fetch_array(mysql_query("SELECT SUM(is_dislike) as dislike_count FROM restaurant_like_dislike WHERE customer_id = '".$customer_id."' AND is_dislike_status = 1 "));

$follower_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$customer_id."' AND status = '1' "));

$following_count = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1' "));

$check_follow_status = mysql_fetch_array(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND follower_id = '".$_SESSION['customer_id']."' "));

$check_follow_num = mysql_num_rows(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND follower_id = '".$_SESSION['customer_id']."' "));

$favourite_count = mysql_num_rows(mysql_query("SELECT id FROM restaurant_favourite WHERE user_id = '".$customer_id."' "));

$all_follower = mysql_query("SELECT * FROM user_follow WHERE follower_id = '".$customer_id."' AND status = '1' ");

$all_following = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1' ");

$all_favourite = mysql_query("SELECT * FROM restaurant_favourite WHERE user_id = '".$customer_id."' ");

$like_review = mysql_query("SELECT * FROM restaurant_like_dislike WHERE customer_id = '".$customer_id."' AND is_like_status = 1 ");

$dislike_review = mysql_query("SELECT * FROM restaurant_like_dislike WHERE customer_id = '".$customer_id."' AND is_dislike_status = 1 ");

$follow_request_count = mysql_num_rows(mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '0'"));

$follow_request = mysql_query("SELECT * FROM user_follow WHERE following_id = '".$customer_id."' AND status = '0'");

?>
	<div class="body_section">
	
		<div class="body_container">
			<div class="body_top"> </div>
			<div class="main_body">
			
				<div class="contact_body_cont" style="min-height:600px;">
				
					<div class="user-profile-section">
						
						<div class="user-profile-top">
							<div class="profile-name">
                            
								<h1><?php echo $username."'s"; ?> Profile</h1>
							</div>
							<div class="follow-section">
								<ul>
                                	
                                    
									<li>
										 <a href="javascript:void(0);" style="cursor:text;">
											 <img src="images/star-on.png" /> <strong> Reviews</strong> <br />
											 <span><?php echo $review_count; ?></span>
										 </a>
									</li>
                                    
                                    <?php
									if($_SESSION['customer_id'] == $_REQUEST['id'])
									{
										$get_follower_id = mysql_query("SELECT follower_id FROM user_follow WHERE following_id = '".$customer_id."' AND status = '1'");
										$all_user_id = '';
										$sep_follower = '';
										while($row_get_follower_id = mysql_fetch_array($get_follower_id))
										{
											$all_user_id = $all_user_id.$sep_follower.$row_get_follower_id['follower_id'];
											$sep_follower = ',';
											
										}
										
										if($all_user_id == '')
										{
											$all_user_id = '0';
										}
										
										$sql_get_notification = mysql_query("SELECT * FROM restaurant_notification WHERE user_id in (".$all_user_id.")");
										$notification_count = mysql_num_rows($sql_get_notification);
										
										
										if($notification_count > 0)
										{
										?>
										<li>
											 <a href="javascript:void(0);" onClick="open_notification_div();">
												<strong>Notification</strong> <br />
												 <span><?php echo $notification_count;?></span>
											 </a>
											 
											 <div id="notification_div" style="display:none;">
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
											?>
											<li>
											 <a href="javascript:void(0);">
												<strong>Notification</strong> <br />
												 <span><?php echo $notification_count;?></span>
											 </a>
											 </li>
											
											<?php
										}
									}
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
												
												echo "<a href='user.php?id=".$row_all_following['follower_id']."' style='color:#4E7AD5'>".getNameTable("restaurant_customer","firstname","id",$row_all_following['follower_id'])." ".getNameTable("restaurant_customer","lastname","id",$row_all_following['follower_id'])."</a>";
											
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
										 
										 <div id="favourite_div" style="display:none;">
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
									
                                    
                                    if($_SESSION['customer_id'] == $_REQUEST['id'])
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
									</li>
                                    <?php 
									}
									?>
                                    
                                    
                                    
                                    
                                    
                                    
                                    <?php
									if($_SESSION['customer_id'] != $_REQUEST['id'])
									{
										if($check_follow_num == 0)
										{
                                    ?>
									<li id="follow_li">
										 <a href="javascript:void(0);" onClick="follow_user('<?php echo $_SESSION['customer_id']; ?>','<?php echo $_REQUEST['id']; ?>');" class="follow-btn"><img src="images/follower.png" align="absmiddle" /> Follow </a>
									</li>
                                    <?php
										}
										elseif($check_follow_status['status'] == "0")
										{
										?>
                                        	<a href='javascript:void(0);' class='follow-btn' style='cursor:default; margin: 5px -5px 0; width: 71px;' ><img src='images/follower.png' align='absmiddle'  /> Request Sent</a>
                                        <?php
										}
										elseif($check_follow_status['status'] == "1")
										{
										?>
                                        	<a href='javascript:void(0);' class='follow-btn' style='cursor:default; margin: 5px -5px 0; width: 71px;' ><img src='images/follower.png' align='absmiddle'  /> Following</a>
                                        <?php
										}
									}
									?>
								</ul>
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
								
								<!--<label>
									<input type="checkbox" class="regular-checkbox big-checkbox" name="review" id="review" />
									<label for="review"></label>
									
									 Review Votes
								</label>-->
								<div class="clear"> </div>
                                
                                
								
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
									<strong><a  id="various1" href="#inline<?php echo $customer_id; ?>" style="color:#404CA1;" title=""><?php echo $like." ".$like_word; ?> </a></strong>,  
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
									<strong><a  id="various2" href="#inline_dislike" style="color:#404CA1;" title=""><?php echo $dislike." ".$dislike_word; ?></a> </strong>
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
							
							
							
							<div class="user-cont-right">
								<div class="right-top" >
									<h4>
                                    <?php
									
									if($review_count > 1)
									{
										?>
										Recent Reviews <span> <?php echo $review_count; ?> Reviews</span>
                                        <?php
									}
									else
									{
										?>
										Recent Reviews <span> <?php echo $review_count; ?> Review</span>
                                        <?php
									}
									?>
									</h4>
									<div class="clear"> </div>
									<ul class="sortby">
										<li>Sort by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);" onClick="sort_date('<?php echo $customer_id;?>');">Date</a></li> 
										<li><a href="javascript:void(0);" onClick="sort_rating('<?php echo $customer_id;?>');">Rating</a></li> 
										<!--<li>Filter by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);"> Location</a></li>
										<li><a href="javascript:void(0);">Category</a></li>-->
									</ul>
									<div class="clear"> </div>
								</div>
								<div class="clear"> </div>
								
								<div class="right-top" id="right-top">
								
								<div id="loader_div" class="sec-load" style="display:none;"><img src="images/loader_gif.gif"></div>
                                
                                <div id="main_res_div" class="">
                                
                                <!-- Start restu-block -->
                                
                                <?php 
								$cnt = 1;
								while($row=mysql_fetch_array($sql_res)) 
								{
									
									$sql_main_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$row['id']."'");
									
									
									$msg_id = $row['id'];
									$sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
									$num_rws = mysql_num_rows($sql_photo);
									
									$sql_updated_review = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND parent_id = '".$row['id']."' AND rr.review_status = 1 ORDER BY rr.id DESC");
									
									 ?>
									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        <?php 
										$restaurant_image = getNameTable("restaurant_basic_info","restaurant_image","id",$row['restaurant_id']) ;
										if($num_rws > 0)
										{
										?>
											<a href="javascript:void(0);" onClick="open_slider_div('<?php echo $row['id'] ?>');"><img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" /></a>
                                        <?php
										}
										else
										{
										?>
											<img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" />
                                        <?php
										}
										?>
										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo stripslashes(getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']));?></a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : <?php echo getNameTable("restaurant_basic_info","restaurant_category_name","id",$row['restaurant_id']);?></a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><?php echo getNameTable("restaurant_basic_info","restaurant_address","id",$row['restaurant_id']).", ".getNameTable("restaurant_basic_info","restaurant_city","id",$row['restaurant_id']).", ".getNameTable("restaurant_basic_info","restaurant_state","id",$row['restaurant_id'])." ".getNameTable("restaurant_basic_info","restaurant_zipcode","id",$row['restaurant_id']);?></a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                        <?php while($row_updated_review = mysql_fetch_array($sql_updated_review))
								   					{
														//echo ("SELECT image FROM restaurant_review_images WHERE review_id = '".$row_updated_review['id']."'");
														$sql_mul_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$row_updated_review['id']."'");
														?>
                                                    
                                                    <div class="next-row">
	                                                    <div class="rating_content">
	                                                            <ul>
	                                                                <?php
	                                                                $rating1 = getSingleReviewRating($row_updated_review['restaurant_id'],$row_updated_review['id']);
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
	                                                            </ul>
	                                                            
	                                                        </div>
	                                                        
	                                                         <div class="post_date">
		                                                           <div style="color: #777; font-size: 14px; float:right;">Posted on <?php echo date("m-d-Y", strtotime($row_updated_review['post_date'])); ?></div>
		                                                     </div>
                                                    
                                                    <div class="clear"> </div>
                                                    
                                                    
													<?php 
                                                    //echo mysql_num_rows($sql_mul_image);
                                                    
                                                    if(mysql_num_rows($sql_mul_image)!= 0) {
													?>
                                                         <div class="rv-img">
                                                         <ul>
                                                  <?php   while($mul_image = mysql_fetch_array($sql_mul_image))
                                                    {
                                                        $uploaded_image = 'uploaded_images/'.$mul_image['image'];
                                                    ?><li><a class="example_cat" href="<?php echo $uploaded_image; ?>"><img src="uploaded_images/<?php echo $mul_image['image']; ?>" height="30"></a></li><?php } ?>
                                                        
                                                        </ul>
                                                    </div>
                                                    <?php } ?>
                                                    <p>
                                                        <?php echo $row_updated_review['customer_review'];?>
                                                    </p>
                                                    <div class="clear"> </div>
                                                    
                                                    <div class="like-sec">
                                                        <div class="soc_icon">
                                                            <a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>"> <img src="images/facebook_share.jpg"></a>
                                                        </div>
                                                        
                                                        <div class="soc_icon">
                                                            <?php /*?><a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a><?php */?> 
                                                            <script type="text/javascript">
                                                              (function() {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/platform.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                              })();
                                                            </script>
                                                            
                                                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                
                                                <?php if($row_updated_review['abuse_status']==0){
                                                ?>
                                                <div class="report-ab">
                                                    <img src="images/report-flag.png" align="absmiddle">
                                                    <?php if(isset($_SESSION['customer_id'])){
                                                    ?>
                                                    <a href="report_abuse.php?id=<?php echo $row_updated_review['restaurant_id']; ?>&r_id=<?php echo $row_updated_review['id']; ?>" style="color:#000000;">Report Abuse</a>
                                                    <?php }else{ ?>
                                                    <a href="login.php" style="color:#000000;">Report Abuse</a>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>  
                                               
                                                <div class="clear"></div>
                                       <?php $sql_owners_comment = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row_updated_review['id']."'"));
									   if(!empty($sql_owners_comment)){
									   $sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment['restaurant_owner_id']."'"));?>
                                       <div class="next-review">
	                                       <div class="next-review-head">
		                                       <p><strong> Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row_updated_review['restaurant_id']);?></strong></p>
		                                       <p>Business Owner</p>
	                                       </div>
	                                       <label><?php echo date("m-d-Y", strtotime($sql_owners_comment['post_date']));?>  -  <?php echo "Hi ".$row_updated_review['customer_name']; ?></label>
	                                       <div class="next-review-cont"><?php echo $sql_owners_comment['comment']; ?></div>
	                                       <div class="clear"></div>
                                       </div>
                                       <div class="clear"></div>
                                        <!-- </div>  -->
                                       <?php } ?>
                                       			 </div> 	
											<?php
                                            }
                                            ?>
											<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
															<?php
															$rating1 = getSingleReviewRating($row['restaurant_id'],$row['id']);
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
														</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on <?php echo date("m-d-Y", strtotime($row['post_date'])); ?>
                                                </div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													<?php echo $row['customer_review'];?>
												</p>
												<div class="clear"> </div>
                                                
                                                <?php 
                                                            //echo mysql_num_rows($sql_mul_image);
                                                            
                                                            if(mysql_num_rows($sql_main_image)!= 0) {?>
																 <div class="rv-img">
                                                        <ul>
                                                  <?php   while($mul_image1 = mysql_fetch_array($sql_main_image))
                                                    {
                                                        $uploaded_image1 = 'uploaded_images/'.$mul_image1['image'];
                                                    ?><li><a class="example_cat" href="<?php echo $uploaded_image1; ?>"><img src="uploaded_images/<?php echo $mul_image1['image']; ?>" height="30"></a></li><?php } ?>
                                                        
                                                        </ul>
                                                    </div>
                                                    <?php } ?>
												
												<div class="like-sec">
													<div class="soc_icon">
														<a target="_blank" href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>"> <img src="images/facebook_share.jpg"></a>
													</div>
                                                    
													<div class="soc_icon">
														<?php /*?><a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a><?php */?> 
                                                        <script type="text/javascript">
                                                          (function() {
                                                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                            po.src = 'https://apis.google.com/js/platform.js';
                                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                          })();
                                                        </script>
                                                        
                                                        <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div>
													</div>
                                                    
												</div>
												
												
											</div> 
											
											
                                            
                                            
                                            <?php if($row['abuse_status']==0){
											?>
                                            <div class="report-ab">
                                                <img src="images/report-flag.png" align="absmiddle">
                                                <?php if(isset($_SESSION['customer_id'])){
												?>
                                                <a href="report_abuse.php?id=<?php echo $row['restaurant_id']; ?>&r_id=<?php echo $row['id']; ?>" style="color:#000000;">Report Abuse</a>
                                                <?php }else{ ?>
                                                <a href="login.php" style="color:#000000;">Report Abuse</a> 
                                                <?php } ?>
                                                <div class="clear"> </div>
                                            </div>
                                            <?php } ?>
										
                                        
                                        
										<div class="clear"> </div>
                                        
                                       <?php $sql_owners_comment1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row['id']."'"));
									   if(!empty($sql_owners_comment1)){
									   $sql_rest_owner1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment1['restaurant_owner_id']."'"));?>
                                       <div class="next-review">
	                                   		<div class="next-review-head">
		                                       <p><strong> Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']);?></strong></p>
		                                       <p>Business Owner</p>
	                                       </div> 
	                                       <label><?php echo date("m-d-Y", strtotime($sql_owners_comment1['post_date']));?>  -  <?php echo "Hi ".$row['customer_name']; ?></label>
	                                       <div class="next-review-cont"><?php echo $sql_owners_comment1['comment']; ?></div>
	                                        <div class="clear"> </div>
                                       </div>
                                       <?php } ?>
                                        </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                <?php
								$cnt++; 
								}?>
                                
                                <?php if($num_rws >1){
									$cnt = 1;
								while($row=mysql_fetch_array($sql_res_slider)){ ?>
                                    
                               <div id="slider_div<?php echo $row['id'] ?>" class="factor_details white_content nw_white_cont12 flex_popup" style="visibility:hidden; background:#FFF !important;">
                               <style type="text/css">
                               .white_content {
                                   display:block !important;
                               }
                               </style>
                                <div class="close close-new" onClick="close_slider_div('<?php echo $row['id'] ?>');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont"> 
                                
                                 <div id="main" role="main">
                                      <section class="slider">
                                        <div id="slider<?php echo $cnt; ?>"  class="flexslider">
                                          <ul class="slides">
                                          <?php
                                          $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
                                          
                                          while($row_photo=mysql_fetch_array($sql_photo))
                                          {
                                          ?>
                                          <li> <img src="uploaded_images/<?php echo $row_photo['image_name']; ?>" /></li>
                                          <?php
                                          }
                                          ?>
                                          </ul>
                                        </div>
                                        
                                        <div id="carousel<?php echo $cnt; ?>" class="carousel1 flexslider">
                                            <ul class="slides">
                                            <?php
                                              $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
                                              while($row_photo=mysql_fetch_array($sql_photo))
                                              {
                                              ?>
                                                <li>
                                                    <img src="thumb_images/<?php echo $row_photo['image_name']; ?>" />
                                                </li>
                                              <?php
                                              }
                                              ?>
                                            </ul>
                                            
                                       </div>
                                            
                                      </section>
                                    </div>
                                               
                                
                                
                                </div>
                                </div>
                                
                                <?php $cnt++; 
								} } ?>
                                <?php
								
								if($review_count > 5)
								{
								?>
                                
                                    <div class="morebox" id="more<?php echo $msg_id;?>">
                                    <a class="more" id="<?php echo $msg_id;?>" href="javascript:void(0);" onClick="slider_load();">Load More Reviews</a>
                                    </div>
                                    
                                <?php
								}
								?>
                                </div>
                                
                                
                                
                                <div id="fade1" class="black_overlay"> </div>
                                
									
                                <input type="hidden" name="hid_sort" id="hid_sort" value="ASC">
								<input type="hidden" name="hid_count" id="hid_count" value="10">
                                <input type="hidden" name="hid_count_new" id="hid_count_new" value="<?php echo $review_count; ?>">
                                <input type="hidden" name="hid_sort_type" id="hid_sort_type" value="id">
                                	
                                	
									
								</div>
								
								
							
							</div> <!-- End user-cont -->
							
						</div> <!-- End user-cont -->
						
						<div class="clear"> </div>
					</div> <!-- End user-profile-section -->
					
				
				
				</div>
			
			
			</div>
			<div class="body_footer_bg"> </div>
			<div class="clear"></div>
		</div>
	
	</div>
    
   							 

<div class="clear"></div>
<?php include("includes/footer.php");?>


<?php /*?><script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script><?php */?>
  <?php /*?><script>window.jQuery || document.write('<script src="js/jquery-1.7.min.js">\x3C/script>')</script><?php */?>

  <!-- FlexSlider -->
  <script defer src="js/jquery.flexslider.js"></script>

  <?php /*?><script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script><?php */?>
  
  <script type="text/javascript">
  	$(window).load(function() {
  // The slider being synced must be initialized first
  var hid_count_new = $("#hid_count_new").val();
 for(i=1;i<=hid_count_new;i++){
  $('#carousel'+i).flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 35,
    itemMargin: 5,
    asNavFor: '#slider'+i
  });
 
  $('#slider'+i).flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"+i
  });
  }
});
  </script>




  <!-- Syntax Highlighter -->
