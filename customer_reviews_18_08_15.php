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

function change_dateformat_reverse($date_form1)
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


include_once("image_file.php");
if(isset($_REQUEST['submit'])){
	
		$sep = '';
		foreach($_REQUEST['looking_for'] as $val){
			$looking_for = $looking_for.$sep.$val;
			$sep = ",";
		}
		
		$dob_date = substr($_REQUEST['dob_of_birth'], 3,2);
		$dob_month = substr($_REQUEST['dob_of_birth'], 0,2);
		$dob_year = substr($_REQUEST['dob_of_birth'], 6,4);
		
		$date_of_birth = $dob_year."-".$dob_month."-".$dob_date;
	
		if($_FILES['image']['name']!="")
	    {
		$image=$_FILES['image']['name'];
	    $image=time().$image;
		if ((($_FILES["image"]["type"] == "image/gif")
		  || ($_FILES["image"]["type"] == "image/png")
		  || ($_FILES["image"]["type"] == "image/bmp")
		  || ($_FILES["image"]["type"] == "image/jpg")
		  || ($_FILES["image"]["type"] == "image/jpeg")
		  || ($_FILES["image"]["type"] == "image/pjpeg")))
		 {
			$picture_url="thumb_images/".$image;
			LIB_StoreUploadImg($post_file_name="image"
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="70"
								,$file_to_copy_height="70"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		    $big_picture_url="uploaded_images/".$image;
			LIB_StoreUploadImg($post_file_name="image"
								,$file_to_copy_path="$big_picture_url"
								,$file_to_copy_width="200"
								,$file_to_copy_height="180"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
}
	}
	
		$sql_update = mysql_query("UPDATE restaurant_customer SET firstname = '".$_REQUEST['firstname']."',lastname = '".$_REQUEST['lastname']."',address = '".$_REQUEST['address']."',phone = '".$_REQUEST['phone']."',city = '".$_REQUEST['city']."',state = '".$_REQUEST['state']."',zip = '".$_REQUEST['zip']."' , home_apartment = '".$_REQUEST['apart']."' , information = '".$_REQUEST['information']."' , apt_name = '".$_REQUEST['apt_name']."' , apt_no = '".$_REQUEST['apt_no']."' , date_of_birth = '".$date_of_birth."' , gender = '".$_REQUEST['gender']."' , looking_for = '".$looking_for."' , relationship_status = '".$_REQUEST['relationship_status']."'  WHERE id = '".$_SESSION['customer_id']."'");
		
		$sql_update_review_tab = ("UPDATE restaurant_reviews SET customer_name = '".$_REQUEST['firstname']."'");
		if($image!=''){
		$sql_update_review_tab.= " , customer_picture = '".$image."'";
		}
		$sql_update_review_tab.= "  WHERE customer_id = '".$_SESSION['customer_id']."' ";
		
		$query_update_review_tab = mysql_query($sql_update_review_tab);
		
		$sql_update_food_order_details = mysql_query("UPDATE restaurant_food_order_details SET customer_name = '".$_REQUEST['firstname']."' WHERE customer_id = '".$_SESSION['customer_id']."'");
		
		$sql_update_ret_reservation = mysql_query("UPDATE restaurant_reservations SET customer_name = '".$_REQUEST['firstname']." ".$_REQUEST['lastname']."' ");
		
		
		$sql_select_subscriber = mysql_num_rows(mysql_query("SELECT * FROM restaurant_subscriber WHERE email = '".$_REQUEST['hid_email']."'"));
		if($sql_select_subscriber == 1){
			if($_REQUEST['subscribe'] == 1){
				$sql_update = mysql_query("UPDATE restaurant_subscriber SET status = 1 WHERE email = '".$_REQUEST['hid_email']."'");
			}else{
				$sql_update = mysql_query("UPDATE restaurant_subscriber SET status = 0 WHERE email = '".$_REQUEST['hid_email']."'");
			}
		}
		
		/*if($_REQUEST['password']!=''){
		$sql_update_password = mysql_query("UPDATE restaurant_customer SET password = '".md5($_REQUEST['password'])."' WHERE id = '".$_SESSION['customer_id']."'");
		}*/
		
		if($_REQUEST['password']!=''){
			$sql_select_old_password = mysql_num_rows(mysql_query("SELECT * FROM restaurant_customer WHERE password = '".md5($_REQUEST['old_password'])."' AND id = '".$customer_id."'"));
			if($sql_select_old_password == 1){
				$sql_update_password = mysql_query("UPDATE restaurant_customer SET password = '".md5($_REQUEST['password'])."' WHERE id = '".$customer_id."'");
			}else{
				header("location:edit_profile.php?error=1");
				exit;
			}
			
		}
		
		
		if($image!=''){
		$sql_update_image = mysql_query("UPDATE restaurant_customer SET image = '".$image."' WHERE id = '".$_SESSION['customer_id']."'");
		}
		
		if($sql_update){
			
		/****************************************  Customer  *****************************************/
		$email = $_REQUEST['hid_email']; //"priya@infosolz.com"
	
		$name = $_REQUEST['firstname']." ".$_REQUEST['lastname'];
		
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 3"));
		
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
		
		$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	
		$from = "support@foodandmenu.com";
	
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
		$headers .= 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
		$message=$cms_rep;
	
		/*$subject="Profile Edited Successfully";*/
		
		$subject = stripslashes($sql_cms['subject']);
	
		mail($email,$subject,$message,$headers);		
		
		
		/*******************************************  Admin  *****************************************/
			
		$sql_cms1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 4"));
		
		$admin_email_address = $sql_cms1['email_address'];
		
		$arr_email_address = explode(",",$admin_email_address);
		
		//$email = "support@foodandmenu.com"; //priya@infosolz.com
	
		$name = "Admin";
		
		$customer_name = $_REQUEST['firstname']." ".$_REQUEST['lastname'];
		
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms1['description']));
		
		$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
		
		$cms_rep=str_replace('%%$customer_name%%',$customer_name,$cms_rep);
	
		$from = "support@foodandmenu.com";
	
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
		$headers .= 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
		$message=$cms_rep;
	
		$subject = stripslashes($sql_cms1['subject']);
		
		foreach($arr_email_address as $val_email){
			mail($val_email,$subject,$message,$headers);
		}
		
		
		header("location:edit_profile.php?success=1");
		
		}
}

?>

<link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="js/resturent.js"></script>
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
					//alert(data);
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
	//alert(val);
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
				 
				window.location.href='edit_profile.php';
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


function get_city(state,sel_state){
	//alert(state);
	//alert(sel_state);
	var $j = jQuery.noConflict();
	$j.ajax({
		url : 'get_distinct_city1.php',
		type : 'POST',
		data : 'state=' + state+'&'+'sel_state=' + sel_state,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('city').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
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

function show_div(val)
{
	  var $j = jQuery.noConflict();
	  
	  if(val == "others")
	  {
		  $j("#apt_name").val('');
		  $j("#apt_no").val('');
		  $j("#apt_div").slideUp(1000);
		  $j("#info_div").slideDown(1000);
		  
	  }
	  if(val == "apartment")
	  {
		  $j("#information").val('');
		  $j("#info_div").slideUp(1000);
		  $j("#apt_div").slideDown(1000);
	  }
	  if(val == "home")
	  {
		  $j("#apt_name").val('');
		  $j("#apt_no").val('');
		  $j("#information").val('');
		  $j("#info_div").slideUp(1000);
		  $j("#apt_div").slideUp(1000);
	  }
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


</script>

 
 
 




<body>

<?php //include ("includes/top_search.php");?>

<?php //include ("includes/menu_section.php");?>

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
							
							
							
							
                            <div class="right_dish_content new_right_dish">

<div id="inline<?php echo $_SESSION['customer_id']; ?>" class="review_dish_inner_box">
<?php //$sql_user_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE customer_id = '".$_SESSION['customer_id']."'");

$customer_id = $_SESSION['customer_id'];

$sql_res = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND rr.review_status = 0 order by id DESC"); ?>
<h1 class="review_top_heading"><span>Total Reviews : <?php echo mysql_num_rows($sql_res); ?></span></h1>
<a href="javascript:history.back();"><input type="button" name="back" value="Back" class="check_order_button" style="float:right; margin-top:-33px;" /></a>
<?php
while($row = mysql_fetch_array($sql_res)){

$sql_main_image = mysql_query("SELECT image FROM restaurant_review_images WHERE review_id = '".$row['id']."'");
							
$msg_id = $row['id'];
$sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$row['restaurant_id']."'");
$num_rws = mysql_num_rows($sql_photo);

$sql_updated_review = mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.customer_id='".$customer_id."' AND rrat.customer_id='".$customer_id."' AND rr.status=1 AND parent_id = '".$row['id']."' AND rr.review_status = 1 ORDER BY rr.id DESC");
									
?>

<?php /*?><div class="review_top" style="width:711px;">
<h1><span><?php echo $array_user_reviews['restaurant_name']; ?></span></h1>                                          
<ul>
<?php
$rating = getSingleReviewRating($array_user_reviews['restaurant_id'],$array_user_reviews['id']);
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

<?php
if(mysql_num_rows($sql_mul_image)!= 0) {
?>
<div class="rv-img">
    <ul>
    <?php   while($mul_image = mysql_fetch_array($sql_mul_image))
    {
    $uploaded_image = 'uploaded_images/'.$mul_image['image'];
    ?><li><a class="example_cat" href="<?php echo $uploaded_image; ?>"><img src="uploaded_images/<?php echo $mul_image['image']; ?>" height="30"></a></li>
	<?php } ?>
    </ul>
</div>
<?php } ?>
                                                    
<p><?php echo $array_user_reviews['customer_review']; ?></p>
</div><?php */?>

<div class="restu-block">
										
<div class="restu-block-left">
<?php 
$restaurant_image = getNameTable("restaurant_basic_info","restaurant_image","id",$row['restaurant_id']) ;
if($num_rws > 0)
{
?>
    <a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" /></a>
<?php
}
else
{
?>
    <a href="restaurant.php?id=<?php echo $row['restaurant_id']; ?>"><img src="uploaded_images/<?php echo $restaurant_image; ?>" align="" width="169" /></a>
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
                     
                     <div class="clear"></div>
                     
                     <div class="user-social-sec-bot">       
  <div class="rating_content_two review-likes">
  <ul>
    <?php
    
     if(isset($_SESSION['customer_id'])){ ?>

    <li id="li_like_<?php echo $row_updated_review['id']; ?>">
    <?php if(is_customer_has_like_unlike_on_review($row_updated_review['id'], $_SESSION['customer_id'], 'like')){ ?>
    
    <span class="like_text" id="like_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'like'); ?></span><img src="images/like_select.png" width="16" height="16" />
    <?php } else { ?>
    <span class="like_text" id="like_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $row_updated_review['id']; ?>" class="like" review="<?php echo $row_updated_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
    <?php } ?>
    </li>
    <li id="li_dislike_<?php echo $row_updated_review['id']; ?>">
    <?php if(is_customer_has_like_unlike_on_review($row_updated_review['id'], $_SESSION['customer_id'], 'dislike')){ ?>
    <img src="images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'dislike'); ?></span>
    
    <?php /*?><?php } else { ?>
    <li id="li_like_<?php echo $row['id']; ?>">
    <span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $row['id']; ?>" class="like" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
    </li>
    <li id="li_dislike_<?php echo $row['id']; ?>">
    <a href="dislike" id="do_dislike_<?php echo $row['id']; ?>" class="dislike" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span>
    </li><?php */?>
    
    
     <?php } else { ?>
     <a href="dislike" id="do_dislike_<?php echo $row_updated_review['id']; ?>" class="dislike" review="<?php echo $row_updated_review['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'dislike'); ?></span>
    <?php } ?>
    </li>
    
    <!--<li><a href="#"></a></li>-->
    <?php } else { ?>
    <!--<li><a href="#"></a></li>-->
    <li id="li_like_<?php echo $row_updated_review['id']; ?>"><span class="like_text" id="like_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'like'); ?></span><a href="like" onClick="like_unlike_alert('Please Login First to Like this'); return false;"><img src="images/like_select.png" width="16" height="16" /></a></li>
    <li id="li_dislike_<?php echo $row_updated_review['id']; ?>"><a href="dislike"  onClick="like_unlike_alert('Please Login First to Unlike this'); return false;"><img src="images/unlike_select.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row_updated_review['id']; ?>"><?php echo get_like_unlike_count_on_review($row_updated_review['id'], 'dislike'); ?></span></li>
    <!--<li><a href="#"></a></li>-->
    <?php } ?>
</ul>
          </div>
          <div class="report-ab">  
        <a href="mailto:?body=<?php echo $row_updated_review['customer_review']?>&subject=<?php echo date("d-m-Y", strtotime($row_updated_review['post_date'])); ?>  By <?php echo $row_updated_review['customer_name']?>" target="_blank">Email</a>
        <?php $cust_img = getNameTable("restaurant_basic_info","restaurant_image","id",$row_updated_review['restaurant_id']);?>
        <?php if(isset($_SESSION['customer_id'])){?><a target="_blank" href="https://www.facebook.com/share.php?u=https://foodandmenu.com/restaurant.php?id=<?php echo $row_updated_review['restaurant_id']; ?>">Share with facebook</a><?php }else{ ?><a href="login.php">Share with facebook</a><?php } ?>
        </div>
        
        <?php if($row_updated_review['abuse_status']==0){ ?>
        <div class="report-ab">
        

            <img src="images/report-flag.png" align="absmiddle">
            <?php if(isset($_SESSION['customer_id'])){
            ?>
            <a href="report_abuse.php?id=<?php echo $row_updated_review['restaurant_id']; ?>&r_id=<?php echo $row_updated_review['id']; ?>" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
            <?php }else{ ?>
            <a href="login.php" style="color:#000000;">Report Abuse</a>
            <?php } ?>
        </div>
        <?php } ?>  

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
                <?php /*?><div class="soc_icon">
                    <a target="_blank" href="https://www.facebook.com/share.php?u=https://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>"> <img src="images/facebook_share.jpg"></a>
                </div><?php */?>
                
                <div class="soc_icon">
                    <?php /*?><a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a><?php */?> 
                    <?php /*?><script type="text/javascript">
                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/platform.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script><?php */?>
                    
                    <?php /*?><div class="soc_icon"><iframe src="https://www.facebook.com/plugins/like.php?href=https://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div><?php */?>
                </div>
                
            </div>
            
            
            
           <div class="clear"></div>   
            
            
   
       
<div class="clear"></div>


<?php $sql_owners_comment = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row_updated_review['id']."'"));
if(!empty($sql_owners_comment)){
$sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment['restaurant_owner_id']."'"));?>
<div class="next-review">
   <div class="next-review-head">
       <p><strong> Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row_updated_review['restaurant_id']);?></strong></p>
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
        
        <div class="clear"></div>
        
        <div class="user-social-sec-bot">
    
  <div class="rating_content_two review-likes">
  <ul>
        <?php
        
         if(isset($_SESSION['customer_id'])){ ?>

        <li id="li_like_<?php echo $row['id']; ?>">
        <?php if(is_customer_has_like_unlike_on_review($row['id'], $_SESSION['customer_id'], 'like')){ ?>
        
        <span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><img src="images/like_select.png" width="16" height="16" />
        <?php } else { ?>
        <span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $row['id']; ?>" class="like" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
        <?php } ?>
        </li>
        <li id="li_dislike_<?php echo $row['id']; ?>">
        <?php if(is_customer_has_like_unlike_on_review($row['id'], $_SESSION['customer_id'], 'dislike')){ ?>
        <img src="images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span>
        
        <?php /*?><?php } else { ?>
        <li id="li_like_<?php echo $row['id']; ?>">
        <span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><a href="like" id="do_like_<?php echo $row['id']; ?>" class="like" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/like.png" width="16" height="16" /></a>
        </li>
        <li id="li_dislike_<?php echo $row['id']; ?>">
        <a href="dislike" id="do_dislike_<?php echo $row['id']; ?>" class="dislike" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span>
        </li><?php */?>
         <?php } else { ?>
         <a href="dislike" id="do_dislike_<?php echo $row['id']; ?>" class="dislike" review="<?php echo $row['id']; ?>" cid="<?php echo $_SESSION['customer_id']; ?>"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span>
        <?php } ?>
        </li>
        
        <!--<li><a href="#"></a></li>-->
        <?php } else { ?>
        <!--<li><a href="#"></a></li>-->
        <li id="li_like_<?php echo $row['id']; ?>"><span class="like_text" id="like_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'like'); ?></span><a href="like" onClick="like_unlike_alert('Please Login First to Like this'); return false;"><img src="images/like_select.png" width="16" height="16" /></a></li>
        <li id="li_dislike_<?php echo $row['id']; ?>"><a href="dislike"  onClick="like_unlike_alert('Please Login First to Unlike this'); return false;"><img src="images/unlike_select.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_<?php echo $row['id']; ?>"><?php echo get_like_unlike_count_on_review($row['id'], 'dislike'); ?></span></li>
        <!--<li><a href="#"></a></li>-->
        <?php } ?>
    </ul>
  </div>
    
    <div class="report-ab">
    <a href="mailto:?body=<?php echo $row['customer_review']?>&subject=<?php echo date("d-m-Y", strtotime($row['post_date'])); ?>  By <?php echo $row['customer_name']?>" target="_blank">Email</a>
    
    <?php $cust_img = getNameTable("restaurant_customer","image","id",$_SESSION['customer_id']);?>
     
    <?php if(isset($_SESSION['customer_id'])){?><a target="_blank" href="https://www.facebook.com/share.php?u=https://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>">Share with facebook</a><?php }else{ ?><a href="login.php">Share with facebook</a><?php } ?>
    </div>
    
    <?php if($row['abuse_status']==0){ ?>
    <div class="report-ab">  
        <img src="images/report-flag.png" align="absmiddle">
        <?php if(isset($_SESSION['customer_id'])){
        ?>
        <a href="report_abuse.php?id=<?php echo $row['restaurant_id']; ?>&r_id=<?php echo $row['id']; ?>" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
        <?php }else{ ?>
        <a href="login.php" style="color:#000000;">Report Abuse</a> 
        <?php } ?>
        <div class="clear"> </div>
    </div>
    <?php } ?>
    
    <div class="clear"></div>

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
            <?php /*?><div class="soc_icon">
                <a target="_blank" href="https://www.facebook.com/share.php?u=https://foodandmenu.com/restaurant.php?id=<?php echo $row['restaurant_id']; ?>"> <img src="images/facebook_share.jpg"></a>
            </div><?php */?>
            
            <div class="soc_icon">
                <?php /*?><a target="_blank" href="javascript:void(0);"> <img src="images/fb-like.png"></a><?php */?> 
                <?php /*?><script type="text/javascript">
                  (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    po.src = 'https://apis.google.com/js/platform.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                  })();
                </script><?php */?>
                
                <?php /*?><div class="soc_icon"><iframe src="https://www.facebook.com/plugins/like.php?href=https://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:auto; height:21px;"></iframe></div><?php */?>
            </div>
            
        </div>
        
        
    </div> 
    
<div class="clear"> </div>

<?php $sql_owners_comment1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row['id']."'"));
if(!empty($sql_owners_comment1)){
$sql_rest_owner1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment1['restaurant_owner_id']."'"));?>
<div class="next-review">
    <div class="next-review-head">
       <p><strong> Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row['restaurant_id']);?></strong></p>
   </div> 
   <label><?php echo date("m-d-Y", strtotime($sql_owners_comment1['post_date']));?>  -  <?php echo "Hi ".$row['customer_name']; ?></label>
   <div class="next-review-cont"><?php echo $sql_owners_comment1['comment']; ?></div>
    <div class="clear"> </div>
</div>
<?php } ?>
</div>
<div class="clear"> </div>
</div>

<?php } ?>

</div>

</div>
								
								
							
							</div> <!-- End user-cont -->
							
						</div> <!-- End user-cont -->
						
						<div class="clear"> </div>
					</div> <!-- End user-profile-section -->
					
				
				
				</div>
			
            <div class="body_footer_bg"> </div>
			
			</div>

			<div class="clear"></div>
		</div>
	
	</div>
    
   							 

<div class="clear"></div>
<?php //include("includes/footer.php");?>
<?php include("includes/footer_new.php");?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<?php /*?><script src="//code.jquery.com/jquery-1.7.2.js"></script><?php */?>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
var $j = jQuery.noConflict();
  $j(function() {
    $j( "#datepicker" ).datepicker
		({
		   dateFormat: 'mm-dd-yy',
		   
		   changeDate: true,
	
		   changeMonth: true,
		
		   changeYear: true,
		  
		   yearRange: "-90:+0"
		});
  });
</script>

<script type="text/javascript">
get_city('<?php echo $row['state']; ?>','<?php echo $row['city']; ?>');
</script>
