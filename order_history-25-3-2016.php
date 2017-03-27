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


?>



<?php /*?><link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="js/resturent.js"></script><?php */?>
<?php /*?> <script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" /><?php */?>

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
	var hid_user_id = $j('#hid_user_id').val();
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
	var hid_user_id = $j('#hid_user_id').val();
	
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
	var follower_count = $j("#follower_span").html();
	var block_count = $j("#block_users_span").html();
	
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
	$$j("#hid_count").val('10');
	
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
	var block_count = $j("#block_users_span").html();
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
<?php /*?><script type="text/javascript" src="https://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="https://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
  $(document).ready(function() {
   
   
   $("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script><?php */?>
 
<?php 
$query_res = ("SELECT * from restaurant_reservations WHERE customer_id = '".$_SESSION['customer_id']."' ");
if($_REQUEST['restaurant_name']!=''){
  $query_res.= " restaurant_id = '".$_REQUEST['restaurant_name']."' ";
}
$query_res.=" ORDER BY id DESC ";

$query1 = mysql_query($query_res);
?>
 
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en"></script>
<script>
	function initialize() {
		<?php while($array_res = mysql_fetch_array($query1)){ ?>
		  var mapOptions = {
			zoom: 12,
			center: new google.maps.LatLng('<?php echo $array_res['latitude']; ?>', '<?php echo $array_res['longitude']; ?>')
		  };
		  var map = new google.maps.Map(document.getElementById('map_canvas'+<?php echo $array_res['id']; ?>),
			  mapOptions);
		<?php } ?>
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>

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
									<strong><a  id="various1" href="#inline<?php echo $customer_id; ?>" style="color:#404CA1;" title="" class="likes_inline"><?php echo $like." ".$like_word; ?> </a></strong>,  
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
									<strong><a  id="various2" href="#inline_dislike" style="color:#404CA1;" title="" class="likes_inline"><?php echo $dislike." ".$dislike_word; ?></a> </strong>
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
                                
                                <h1 class="clss_pro_edit">My Order History</h1>
								
								<?php
								$sql_order_saving = "SELECT * FROM restaurant_menu_order WHERE customer_id = '".$_SESSION['customer_id']."'";
								
								if($_REQUEST['restaurant_name']!=''){
								  $sql_order_saving.= " AND restaurant_id = '".$_REQUEST['restaurant_name']."' ";
								}
								
								$query_order_saving = mysql_query($sql_order_saving);
								
								$total_saving = 0;
								$tot_sav = 0;
								while($array_order_saving = mysql_fetch_array($query_order_saving)){
									$tot_sav = $array_order_saving['coupon_discount'] + $array_order_saving['reward_points'];
									$total_saving = $total_saving+$tot_sav;
								}
								
								?>
                                
                                <p class="save_txt">You Save <span>$<?php echo $total_saving; ?></span> at this restaurant by using Food and menu</p>
                                
                                <form name="reservation_frm" id="reservation_frm" method="post" action="order_history.php" class="reserve_form">
                                
                                <div class="reserve_select_sec">
                                <?php
								$sql_sel_res = mysql_query("SELECT DISTINCT(restaurant_id) as res_id FROM restaurant_menu_order WHERE customer_id = '".$_SESSION['customer_id']."'");
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
                                    
                                    <a href="order_history.php"><input type="button" name="show_all" id="show_all" value="Show All"></a>
                                    
                                    <div class="clear"></div>
                                
                                </div>
								
								<table width="99%" border="1" bordercolor="#dddddd" cellspacing="0" cellpadding="0" align="center" class="reserve_table" style="border-collapse:collapse;">
                                <tr>
                                  <?php /*?><td width="4%" class="all_restaurant">Sl No.</td><?php */?>
                                  <td width="14%" class="all_restaurant">Order No.</td>
                                  <td width="12%" class="all_restaurant">Restaurant Name</td>
                                  <td width="12%" class="all_restaurant">Total Price</td>
                                  <td width="14%" class="all_restaurant">Order date  (MM-DD-YYYY)</td>
                                  <td width="14%" class="all_restaurant">View Details</td>
                                  <?php /*?><td width="14%" class="all_restaurant">Status</td>
                                  <td width="14%" class="all_restaurant">Action</td><?php */?>
                                </tr>
                                
						
                                
                                
  <?php 
    $limit = 10;
	$start = 1;
	$slice = 3;
  
  $sql_order1 = "SELECT * FROM restaurant_menu_order WHERE customer_id = '".$_SESSION['customer_id']."'";
  
  //$query_res = ("SELECT * from restaurant_reservations WHERE customer_id = '".$_SESSION['customer_id']."' ");
  
  if($_REQUEST['restaurant_name']!=''){
	  $sql_order1.= " AND restaurant_id = '".$_REQUEST['restaurant_name']."' ";
  }
  
  $sql_order1.=" ORDER BY order_id DESC ";
 
 // echo $sql_order1;
  $sql_order = mysql_query($sql_order1);
  
  
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
		$pagination .= "<a href=\"order_history.php?page=$prev&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"order_history.php?page=$i&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"order_history.php?page=$next&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$sql_order1.=" limit $from,$max_results";
		//echo $sql_order1;
		$query_products=mysql_query($sql_order1);
		
		$query_products1=mysql_query($sql_order1);
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
       while($array_order = mysql_fetch_array($query_products)){ ?>
            <tr>
              <td class="all_restaurant2"><?php echo  "OR-00".$array_order['order_id']; ?></td>
              <td class="all_restaurant2">
			  <?php $sql_restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$array_order['restaurant_id']."'")); ?>
    <?php echo $sql_restaurant_name['restaurant_name']; ?>
              </td>
              <td class="all_restaurant2"><?php echo  "$ ".($array_order['price_with_del_charge']); ?></td>
              <td class="all_restaurant2"><?php echo  date("m-d-Y", strtotime($array_order['order_date']))."<br>"; ?>
              <?php $arr_date_time = explode(" ",$array_order['order_date']); 
			  echo date("g:i A", strtotime($arr_date_time[1]));
			  ?>
              </td>
              <td class="all_restaurant2"><a href="javascript:void(0);" onClick="open_details_div('<?php echo $array_order['order_id']; ?>');"  class="used_cls">View Details</a></td>
            </tr>
        
            <?php $inc++; } } else { ?>
            <tr>
              <td class="all_restaurant2" colspan="9" style="text-align:center;">No Records Found.</td>
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
                $page_pagination.= "<a href=\"order_history.php?page=$prev&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
				
				}

            for ($i = $page_min;$i <= $page_max;$i++) {
                if ($i == $page_num){
                $page_pagination .= $i; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
                else{
                $page_pagination.= "<a href=\"order_history.php?page=$i&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination\">$i</a>"; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
			}
			
			
			if ($page_num < $total_pages) {
                $page_pagination.= "<a href=\"order_history.php?page=$next&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
					
<?php $inc = 1;
       while($array_order1 = mysql_fetch_array($query_products1)){ ?>				
                <div id="view_details_div<?php echo $array_order1['order_id'];?>" style="display:none;" class="white_content"  >
<div class="close close-new" onClick="close_details_div('<?php echo $array_order1['order_id'];?>');"><a href = "javascript:void(0);"> </a> </div>
<div class="l-contnt up-contnt"> 
	<div class="" style="min-height:350px;">
<h1>View Order Details</h1>
<?php /*?><a href="javascript:history.back();"><input type="button" name="back" value="Back" class="check_order_button" style="float:right; margin-top:-35px;" /></a><?php */?>

<?php $sql_menu_order = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$array_order1['order_id']."'"));
$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$array_order1['order_id']."'"));
$sql_customer_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."' "));
?>
            
            <div class="ordr-tbl">
            	<div class="ordr-head">
            		<div class="order-head-left" style="width:55%;">
					
						<h5> Customer Details -</h5>
						
						<p><strong>Customer Name :</strong>  <?php echo $sql_customer_details['firstname']." ".$sql_customer_details['lastname']; ?></p>
                        <?php if($sql_contact_details['phone']!=''){?>
						<p><strong>Phone Number :</strong> <?php echo $sql_contact_details['phone']; ?></p>
                        <?php } ?>
						<p><strong>Address :</strong> <?php echo $sql_contact_details['address']."<br>";
				echo $sql_contact_details['city']." ".$sql_contact_details['state']." ".$sql_contact_details['zipcode']; ?></p>
            		</div>
            		<div class="order-head-right">
						<p><strong>Order Number</strong><em>:</em>
                        <?php echo "OR-00".$sql_menu_order['order_id']; ?>
                        </p>
						<p><strong>Order Type</strong><em>:</em>
                        <?php if($sql_menu_order['type'] == 'pickup'){ echo "Pick up"; }
				else { echo "Delivery"; } ?></p>
						<p><strong>Date Ordered</strong><em>:</em> <?php echo date("m-d-Y", strtotime($sql_menu_order['order_date'])); ?></p>
            		</div>
            		<div class="clear"></div>
            		
            	</div>
            	<h5 class="sub"> Items Purchased Below -</h5>
            		<div class="clear"></div>
            	<div class="ordr-con">
            		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin: 0 auto; border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">
						<tr>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd; background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Item No.
							</td>
							<td align="left" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd; background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Item Name	
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE; padding: 5px; border-bottom: none;border-right: none;">
								Quantity
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE;padding: 5px; border-bottom: none;border-right: none;">
								Unit Price
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Amount
							</td>
						</tr>
					
                     <?php $sql_items_ordered = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$array_order1['order_id']."'");
				$i=1;
				while($array_items_ordered = mysql_fetch_array($sql_items_ordered)){
					$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_items_ordered['menu_id']."'"));
					$menu_price = ($array_items_ordered['quantity']*$array_items_ordered['menu_price']); 
					$arr_spl = explode(",", $array_items_ordered['additional_instructions']); 
					
					/*echo '<pre>';
					print_r($arr_spl);*/
					
					if($array_items_ordered['special_instructions']!=''){
						$row_count = count($arr_spl)+2;
					}else{
						if(!empty($arr_spl[0])){
							$row_count = count($arr_spl)+1;
						}else{
							$row_count = 0;							
						}
						
					}
					
					//echo count($arr_spl);
					?>
					  <!-- Start looping row -->
						<tr>
							<td rowspan="<?php echo $row_count; ?>" align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo $i; ?>
							</td>
						  <td align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 0px;font-size: 14px;">
								<p><?php echo $sql_menu['menu_name']; ?></p>
							
                            </td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo $array_items_ordered['quantity']; ?>
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo "$".$array_items_ordered['menu_price']; ?>
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo "$".$menu_price; ?>
							</td>
						</tr>
                        <?php 
						foreach($arr_spl as $arrspl){
						if(!empty($arrspl)){
						$sql_sp_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$arrspl."'"));
						$sql_ins_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE id = '".$sql_sp_name['special_ins_id']."'"));
						$pr1 = ($array_items_ordered['quantity'] * $sql_sp_name['price']);?>
						<tr>
						  <td class="sub-list" align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo $sql_ins_name['special_instruction']; ?> ----- <?php echo $sql_sp_name['title']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo $array_items_ordered['quantity']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo "$".$sql_sp_name['price']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo "$".$pr1; ?></td>
	                  </tr>
                      <?php if($array_items_ordered['special_instructions']!=''){ ?>
						<tr>
						  <td class="sub-list" align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;" colspan="4"><?php if($array_items_ordered['special_instructions']!=''){ echo "Additional Instructions : ".htmlspecialchars_decode(htmlspecialchars_decode($array_items_ordered['special_instructions']))."<br><br>"; } ?></td>
	                  </tr>
                      <?php } ?>
                      <?php } } ?>
	                  <!-- End looping row -->
						<?php
						$i++;
                        }
                        ?>
                        
						
						 <?php if($sql_menu_order['coupon_code']!=''){ ?> 
						<tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Coupon Name
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php 
								if($sql_menu_order['coupon_name']!="")
								{
								echo $sql_menu_order['coupon_name']; 
								}
								else
								   {
									echo "N/A";   
								   }
								?>
							</td>
						</tr>
                        <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Coupon Discount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['coupon_discount']; ?>
							</td>
						</tr>
                        <?php } ?>
                        
                         <?php if($sql_menu_order['reward_points']!=0.00){ ?>
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Reward Point Discount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['reward_points']; ?>
							</td>
						</tr>
						<?php } ?>
                        
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Order Amount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['total_price']; ?>
							</td>
						</tr>
                        
                        <?php if($sql_menu_order['type'] == 'del'){ ?>
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Delivery Charge
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php 
								if($sql_menu_order['delivery_charge'] == 0){
									echo "Free";
								 }
								else {
									echo "$ ".(number_format($sql_menu_order['delivery_charge'],2));
								}?>
							</td>
						</tr>
						<?php } ?>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Tax
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['tax']; ?>
							</td>
						</tr>
                        <?php if($sql_menu_order['service_fee']!=0){ ?>
                        <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Service Fee
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['service_fee']; ?>
							</td>
						</tr>
                        <?php } ?>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Tip
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['tip']; ?>
							</td>
						</tr>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Total
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$ ".($sql_menu_order['total_price'] + $sql_menu_order['delivery_charge'] + $sql_menu_order['tax'] + $sql_menu_order['tip'] + $sql_menu_order['service_fee']); ?>
							</td>
						</tr>
                        
					</table>
            	</div>
            	<div class="clear"></div>
            	<p><a href="check_out.php?type=<?php echo $sql_menu_order['type']; ?>&order_id=<?php echo $sql_menu_order['order_id']; ?>&reorder=1" class="check_order_button" style="text-decoration: none; margin-left: 0px; float: left;"> Resubmit Order </a></p>
          		<div class="clear"></div>
            </div>
            
            
<div class="clear"></div>
</div>
</div>
</div>
<?php } ?>
<div id="fade1" class="black_overlay"> </div>

				
				</div>
			
			
			</div>
			
			<div class="clear"></div>
		</div>
	
	</div>
    
<script>
function open_details_div(order_id){
	var $j = jQuery.noConflict();
	$j("#view_details_div"+order_id).show();
	$j("#fade1").show();
}

function close_details_div(order_id){
	var $j = jQuery.noConflict();
	$j("#view_details_div"+order_id).hide();
	$j("#fade1").hide();
}
</script>   							 

<div class="clear"></div>
<?php include("includes/footer_new.php");?>


