<?php 
ob_start();
session_start();

function change_dateformat($date_form)
	{
	 if($date_form!=''){
	  $date1=explode("-",$date_form);
	  $dateformat=$date1[2]."-".$date1[0]."-".$date1[1];
	  return $dateformat;
	}
	else{
	  $dateformat='';
	  return $dateformat;
	}
}
//print_r($_SESSION);
//include("includes/header_profile.php");
include("includes/rest_header.php");
include("includes/functions.php");
include("admin/lib/conn.php");


// check customer is loggedin or not
if(isset($_SESSION['customer_id'])){}
else{
header("location:login.php?rev=1");
$_SESSION['resttid'] = $_REQUEST['id'];
exit();
}
//-----------------------------------
 
?>

<body onLoad="init();">

<?php //include ("includes/top_search.php");?>

<?php //include ("includes/menu_section.php");?>

<?php include ("includes/header_inner_new.php");?>

<?php include ("image_file.php");?>
<?php /*?><link rel="stylesheet" href="calender/jquery-ui.css" />
<script src="calender/jquery-1.8.3.js"></script>
<script src="calender/jquery-ui.js"></script>
<script>
jQuery(function() {
	jQuery( "#post_date" ).datepicker({
		dateFormat:"yy-mm-dd"
	});
	//$( "#post_date" ).datepicker( "dd-mm-yy", "dateFormat" );
});

</script><?php */?>
<?php /*?><script type="text/javascript" src="raty-master/demo/js/jquery.min.js"></script><?php */?>
<script type="text/javascript" src="raty-master/lib/jquery.raty.js"></script>
<script type="text/javascript" language="javascript">
jQuery.noConflict();
(function(cash) {
jQuery(document).ready(function() {
	jQuery('#star').raty({
		click: function(score, evt) {
			jQuery('#rate_count').val(score);
			//alert('ID: ' + jQuery(this).attr('id') + "\nscore: " + score + "\nevent: " + evt);
		}
	});	
});
})(jQuery);
</script>
<script type="text/javascript">
function valid_review(){
	if(document.getElementById('date_111').value==''){
		alert('Please enter date');
		document.getElementById('date_111').focus();
		return false;
	}
	if(document.getElementById('customer_name').value==''){
		alert('Please enter customer name');
		document.getElementById('customer_name').focus();
		return false;
	}
	if(document.getElementById('rate_count').value==''){
		alert('Please give your rating');
		return false;
	}
	if(document.getElementById('review').value==''){
		alert('Please enter review');
		document.getElementById('review').focus();
		return false;
	}
	return true;
}
</script>

<?php

	$sql_count=mysql_num_rows(mysql_query("select * from restaurant_reviews where customer_id='".$_SESSION['customer_id']."' AND restaurant_id='".$_REQUEST['id']."'"));
	
	$sql_all=mysql_fetch_array(mysql_query("select * from restaurant_reviews where customer_id='".$_SESSION['customer_id']."' AND restaurant_id='".$_REQUEST['id']."' ORDER BY ID ASC "));
	
	/*if($sql_count>0)
	{
	   $res_reviews=mysql_fetch_array(mysql_query("select * from restaurant_reviews where customer_id='".$_SESSION['customer_id']."' AND restaurant_id='".$_REQUEST['id']."'"));
	   
		$res_rating=mysql_fetch_array(mysql_query("select * from restaurant_rating where customer_id='".$_SESSION['customer_id']."' AND restaurant_id='".$_REQUEST['id']."'"));
	 
	}*/
?>
<?php
$sql_restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
$msg = '';
if($_REQUEST['btn_submit']!="")
{
	
	if($_FILES['customer_image']['name']!="")
	    {
		$image=$_FILES['customer_image']['name'];
	    $image=time().$image;
		if ((($_FILES["customer_image"]["type"] == "image/gif")
		  || ($_FILES["customer_image"]["type"] == "image/png")
		  || ($_FILES["customer_image"]["type"] == "image/bmp")
		  || ($_FILES["customer_image"]["type"] == "image/jpg")
		  || ($_FILES["customer_image"]["type"] == "image/jpeg")
		  || ($_FILES["customer_image"]["type"] == "image/pjpeg")))
		  
		{
			
		
		$picture_url_thumb="thumb_images/".$image;
			LIB_StoreUploadImg($post_file_name="customer_image"
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="70"
								,$file_to_copy_height="63"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
								
		
}
	}
	
	
	if($_FILES['review_picture']['name']!="")
	    {
		$image_review1=$_FILES['review_picture']['name'];
		$image_review = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image_review1);
	    //$image=time().$image;
		if ((($_FILES["review_picture"]["type"] == "image/gif")
		  || ($_FILES["review_picture"]["type"] == "image/png")
		  || ($_FILES["review_picture"]["type"] == "image/bmp")
		  || ($_FILES["review_picture"]["type"] == "image/jpg")
		  || ($_FILES["review_picture"]["type"] == "image/jpeg")
		  || ($_FILES["review_picture"]["type"] == "image/pjpeg")))
		  
		{
			 $picture_url_review="uploaded_images/".$image_review;
			LIB_StoreUploadImg($post_file_name="review_picture"
								,$file_to_copy_path="$picture_url_review"
								,$file_to_copy_width="425"
								,$file_to_copy_height="300"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');	
								
			$picture_url_review="thumb_images/".$image_review;
			LIB_StoreUploadImg($post_file_name="review_picture"
								,$file_to_copy_path="$picture_url_review"
								,$file_to_copy_width="100"
								,$file_to_copy_height="75"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
        }

	}
	
	if($_REQUEST['review']!="")
	{
		
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

	$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
	
	$sql_insert = ("insert into restaurant_reviews set post_date='".change_dateformat($_REQUEST['post_date'])."',customer_name='".htmlspecialchars(stripslashes($_REQUEST['customer_name']),ENT_QUOTES)."',customer_review='".htmlspecialchars(stripslashes($_REQUEST['review']),ENT_QUOTES)."', customer_picture='".$image."',restaurant_id='".$_REQUEST['id']."', restaurant_name = '".htmlspecialchars(stripslashes($sql_restaurant_name['restaurant_name']),ENT_QUOTES)."', customer_id='".$_SESSION['customer_id']."',status=1, customer_email = '".$sql_customer['email']."',city = '".$sql_customer['city']."',state = '".$sql_customer['state']."', review_status = '".$status."' , parent_id = '".$parent_id."' ");
	
	/*if($image_review != ''){
		$sql_insert.= " , review_picture = '".$image_review."' ";
	}*/
	$query_review = mysql_query($sql_insert);
	
	$review_id = mysql_insert_id();
	
	if($parent_id == 0){
		$sql_update = mysql_query("UPDATE restaurant_reviews SET score = score+".$_REQUEST['rate_count']." WHERE id = '".$review_id."' ");
	}else{
		$sql_sel_rev = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$_REQUEST['id']."' AND parent_id = 0 AND customer_id = '".$_SESSION['customer_id']."' "));
		$sql_update = mysql_query("UPDATE restaurant_reviews SET score = score+".$_REQUEST['rate_count']." WHERE id = '".$sql_sel_rev['id']."' ");
	}
	
	$sql_insert_notification = mysql_query("INSERT INTO restaurant_notification SET user_id = '".$_SESSION['customer_id']."' , action = 'review' , post_date = NOW() , notification = 'reviewed on ".htmlspecialchars(stripslashes($sql_restaurant_name['restaurant_name']),ENT_QUOTES)."' , rel_id = '".$review_id."' , restaurant_id = '".$_REQUEST['id']."' ");
	
	$follower_list = mysql_query("SELECT follower_id FROM user_follow WHERE following_id = '".$_SESSION['customer_id']."'");
	
	while($follower_list_all = mysql_fetch_array($follower_list))
	{
		$email_cust = getNameTable("restaurant_customer","email","id",$follower_list_all['follower_id']);
		
		$cust_name = getNameTable("restaurant_customer","firstname","id",$follower_list_all['follower_id'])." ".getNameTable("restaurant_customer","lastname","id",$follower_list_all['follower_id']);
		
		$name = getNameTable("restaurant_customer","firstname","id",$_SESSION['customer_id'])." ".getNameTable("restaurant_customer","lastname","id",$_SESSION['customer_id']);
		
		$notification = "reviewed on ".htmlspecialchars(stripslashes($sql_restaurant_name['restaurant_name']))." on ".date('m-d-Y')." at ".date('h:i:s A');
		
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
		
		$subject = str_replace('%%$action%%','Review',stripslashes($sql_cms['subject']));
		
		mail('priya@infosolz.com',$subject,$message,$headers);
	}
	
	
	
	
	foreach($_POST['countdiv'] as $countDiv){
		
		/*----image-----*/
		if($_FILES['review_picture'.$countDiv]['name']!="")
		{
			$image1=$_FILES['review_picture'.$countDiv]['name'];
			$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
			//$image=time().$image;
			if ((($_FILES["review_picture".$countDiv]["type"] == "image/gif")
			|| ($_FILES["review_picture".$countDiv]["type"] == "image/png")
			|| ($_FILES["review_picture".$countDiv]["type"] == "image/bmp")
			|| ($_FILES["review_picture".$countDiv]["type"] == "image/jpg")
			|| ($_FILES["review_picture".$countDiv]["type"] == "image/jpeg")
			|| ($_FILES["review_picture".$countDiv]["type"] == "image/pjpeg")))
			{
				$picture_url="uploaded_images/".$image;
				LIB_StoreUploadImg($post_file_name="review_picture".$countDiv
				,$file_to_copy_path="$picture_url"
				,$file_to_copy_width="800"
				,$file_to_copy_height="600"
				,$adjust = ''
				,$watermark_gif=''
				,$watermark_position='');
				
				$picture_url_thumb="thumb_images/".$image;
				LIB_StoreUploadImg($post_file_name="review_picture".$countDiv
				,$file_to_copy_path="$picture_url_thumb"
				,$file_to_copy_width="35"
				,$file_to_copy_height="35"
				,$adjust = ''
				,$watermark_gif=''
				,$watermark_position='');
			}
			
		$review_image = $image;
		$sql_insert_review_images = mysql_query("INSERT INTO restaurant_review_images SET review_id = '".$review_id."' , image = '".$review_image."'");
		mysql_query("INSERT INTO restaurant_photo SET image_name = '".$review_image."' , restaurant_id = '".$_REQUEST['id']."'");	
		}
		/*----end-----*/
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
			 
			$sql_reward_point = mysql_query("SELECT * FROM restaurant_point_history WHERE user_id = '".$_SESSION['customer_id']."' AND reward_id = '".$row_mul_reward['id']."'");
			if(mysql_num_rows($sql_reward_point) > 0){
				$sql_add_point = mysql_query("UPDATE restaurant_point_history SET point_added = point_added+'".$point_new."' WHERE user_id = '".$_SESSION['customer_id']."' AND reward_id = '".$row_mul_reward['id']."'");
			}else{
				$sql_add_point = mysql_query("INSERT INTO restaurant_point_history SET point_added = point_added+'".$point_new."' , user_id = '".$_SESSION['customer_id']."' , reward_id = '".$row_mul_reward['id']."'");
			}
				 
		}
		
		/*if($point_new == ''){
			$sql_get_reward_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));
			$point_new = $sql_get_reward_point['online_reservation'];
		}*/
	
	
	
	
	
	mysql_query("UPDATE restaurant_basic_info SET reviewed = reviewed + 1 WHERE id = '".$_REQUEST['id']."'");
	mysql_query("UPDATE restaurant_customer SET no_reviews = no_reviews + 1 WHERE id = '".$_SESSION['customer_id']."'");
	
	$rating_status = rate($_REQUEST['rate_count'],$_REQUEST['id'], $review_id);
	
	
	$rate = getRestaurantRating($_REQUEST['id']);
	mysql_query("UPDATE restaurant_basic_info SET rated = '".$rate."' WHERE id = '".$_REQUEST['id']."'");
	
	
	$sql_get_total_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
	
	$sql_min_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));
	
	
	
	if($sql_get_total_point['reward_point'] >= $sql_min_point['minimum_reward_point'])
	{
								
		//Mail to Admin //
		
		$name = 'Admin';
		$cust_name = $sql_get_total_point['firstname']." ".$sql_get_total_point['lastname'];
		if($sql_get_total_point['gender'] == 'male')
		{
			$sex = 'His';
		}
		elseif($sql_get_total_point['gender'] == 'female')
		{
			$sex = 'Her';
		}
		elseif($sql_get_total_point['gender'] == '')
		{
			$sex = 'His/Her';
		}
		
		$reward_point = $sql_get_total_point['reward_point'];
		
		//$email = 'priya@infosolz.com';
		$res_email = (explode(",",$sql_restaurant_name['email']));

		$email = $res_email[0];
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 35"));  
		  
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
		$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
		$cms_rep=str_replace('%%$customer_name%%',$cust_name,$cms_rep);
		$cms_rep=str_replace('%%$sex%%',$sex,$cms_rep);
		$cms_rep=str_replace('%%$reward_point%%',$reward_point,$cms_rep);
		
		
		$from = 'support@foodandmenu.com';

		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

		$headers .= 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

		$message=$cms_rep;

		//$subject="Gift Certificate";
		
		$subject = stripslashes($sql_cms['subject']);
		
		//
		$inc = 1;
		foreach($res_email as $val_email){
			if($inc!=1){
				$headers.= "Bcc:".$val_email."\n";
			}
			$inc++;
		}
		
		mail($email,$subject,$message,$headers);
		
		//Mail to Customer
		
		/*$email_cust = $sql_get_total_point['email'];
		$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 36"));  
		  
		$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
		//$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
		$cms_rep=str_replace('%%$customer_name%%',$cust_name,$cms_rep);
		//$cms_rep=str_replace('%%$sex%%',$sex,$cms_rep);
		$cms_rep=str_replace('%%$reward_point%%',$reward_point,$cms_rep);
		
		
		$from = 'support@foodandmenu.com';

		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

		$headers .= 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

		$message=$cms_rep;

		//$subject="Gift Certificate";
		
		$subject = stripslashes($sql_cms['subject']);
		
		mail($email_cust,$subject,$message,$headers);*/
	}
	
	/*************************************  Restaurant Owner  ************************************/
	$restaurant_name = $sql_restaurant_name['restaurant_name'];
	$review = htmlspecialchars(stripslashes($_REQUEST['review']),ENT_QUOTES);
	$rate_cnt = $_REQUEST['rate_count'];
	
	$res_email = (explode(",",$sql_restaurant_name['email']));
	
	$email = $res_email[0];//"priya@infosolz.com"

	$name = $sql_restaurant_name['name'];
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 8"));	
			
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);	
	$cms_rep=str_replace('%%$review%%',$review,$cms_rep);	
	$cms_rep=str_replace('%%$rate_cnt%%',$rate_cnt,$cms_rep);
	
	$from = "support@foodandmenu.com";

	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$inc = 1;
	foreach($res_email as $val_email){
		if($inc!=1){
			$headers.= "Bcc:".$val_email."\n";
		}
		$inc++;
	}

	$headers .= 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

	$message=$cms_rep;

	//$subject="Review posted against restaurant - ".$sql_restaurant_name['restaurant_name']."";
	
	$sub = stripslashes($sql_cms['subject']);
	$sub = str_replace('%%$restaurant_name%%',$restaurant_name,$sub);
	$subject = $sub;

	mail($email,$subject,$message,$headers);
	
	
	/*****************************************  Admin  ******************************************/
		
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 9"));
			
	$admin_email_address = $sql_cms['email_address'];
	
	$arr_email_address = explode(",",$admin_email_address);
			
	//$email = "support@foodandmenu.com";//priya@infosolz.com

	$name = "Admin";

	/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

				<div style="margin:0 auto;width:700px;clear:both;">

				<div style="background-color:#3F4CA0; height:30px;"></div>

				<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

				</div>

				<div style="width:100%; float:left;">

				<div style="clear:both;"></div>

					<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$name.',</p>
					
					<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
						A customer has posted review against restaurant - '.$sql_restaurant_name['restaurant_name'].'.
					</p>
					<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
						Review posted - '.htmlspecialchars(stripslashes($_REQUEST['review']),ENT_QUOTES).'
					</p>
					<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
						Rating - '.$_REQUEST['rate_count'].'
					</p>
				<div style="clear:both;"></div>

				<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>

				<div style="clear:both;"></div>

					<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>

					<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>

				<div style="clear:both;"></div>

				</div>

				<div style="clear:both;"></div>

				<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >

				<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">

Sent to you from Food & menu</h4>

			</div>

		</div>

		<div style="clear:both;"></div>

		</div>';*/
	
			
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);	
	$cms_rep=str_replace('%%$review%%',$review,$cms_rep);	
	$cms_rep=str_replace('%%$rate_cnt%%',$rate_cnt,$cms_rep);	

	$from = $sql_customer['email'];

	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

	$headers .= 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

	$message=$cms_rep;

	//$subject="Review posted against restaurant - ".$sql_restaurant_name['restaurant_name']."";
	
	$sub = stripslashes($sql_cms['subject']);
	$sub = str_replace('%%$restaurant_name%%',$restaurant_name,$sub);
	$subject = $sub;

	//mail($email,$subject,$message,$headers);
	
	foreach($arr_email_address as $val_email){
		mail($val_email,$subject,$message,$headers);
	}
	
	
	
	}
	$msg = 'Review submitted successfully';
	
	/*mysql_query("insert into restaurant_reviews set post_date='".$_REQUEST['post_date']."',customer_name='".$_REQUEST['customer_name']."',customer_review='".$_REQUEST['review']."',customer_picture='".$image."',restaurant_id='".$_REQUEST['restaurant_id']."'");*/
	
	
	header("location:review.php?id=".$_REQUEST['id']."&successs=1#tab");
	
}
$customerInfo = customerInfo($_SESSION['customer_id']);
?>


<script type="text/javascript">
function add_cell(id){
	//alert(id);
	var $j = jQuery.noConflict();
	
	$j.ajax({
		url : 'add_more_image.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var menuContent = data;
			var menuDiv = document.createElement('div');
			var menuDivid = menuDiv.id = 'menu_div_' + id;
			menuDiv.setAttribute("class","mainmanu1");
			menuDiv.innerHTML = menuContent;
			//alert(menuDiv);
			document.getElementById('allmenu').appendChild(menuDiv);
			document.getElementById('item_id').value=parseInt(id)+1;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
	document.getElementById('item_focus').focus();
}

function remove_div(delId)
{
	var div = document.getElementById("menu_div_" + delId);
	div.parentNode.removeChild(div);
}
</script>

<div class="body_section">
    <div class="body_container">
        <div class="body_top"></div>
        <div class="main_body">
            <div class="food_body_cont">
                <div class="food_content">
                    
                    <?php include("includes/restaurant_top.php");?>
                    
                    <div class="accr_menu" id="tab">
                    <?php include('includes/tab_menu.php');?>
                    </div>
                        
                    <div class="clear"></div>
					<div class="accr_details">
                    
                    <div class="restaurant_review_field">
                    <?php if($res_reviews['abuse_status']==1 && $res_reviews['status']==0){?>
                    <p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#DC3646; font-weight:bold; text-align:center; border:1px solid; width:950px;">Your review has been abused.</p>
                    <?php
					}
					?>

	    


<div class="clear"></div>
<?php /*?><p style="color:#0C0;float: left;font-family: Arial,Helvetica,sans-serif;font-size: 13px;font-weight: normal;"><?php echo ($msg!='')?$msg:''; ?></p><?php */?>
<div class="clear"></div>
<form name="reviewfrm" method="post" action="" enctype="multipart/form-data" onSubmit="return valid_review();">
<input type="hidden" name="restaurant_id" id="restaurant_id" value="<?php echo $_REQUEST['id']?>">
<div class="restaurant_form_field">

<p>Date :</p>

<input name="post_date" id="date_111" type="text" class="restaurant" value="<?php echo date('m-d-Y'); ?>" readonly />
<!--<small><br /><span style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#595959;">(YYYY-MM-DD)</span></small>-->
<input name="rate_count" id="rate_count" type="hidden" value="" />

<div class="clear"></div>

<p>Customer Name* :</p>

<input name="customer_name" id="customer_name" type="text" class="restaurant" value="<?php echo $customerInfo['firstname']; ?>" readonly />

<div class="clear"></div>
<p>Rating :</p>
<div id="star" class="new_rating"></div>

<div class="clear"></div>

</div>

<div class="restaurant_form_field">

<?php /*?><p>Customer Pic :</p>

<input name="customer_image" type="file" class="restaurant_browse" />

<div class="clear"></div><?php */?>

<div id="allmenu" style="position: relative;">
<input type="hidden" name="countdiv[]" value="1" class="webcampics">
<p>Picture :</p>
<input type="hidden" id="item_id" name="item_id" value="2">

<input name="review_picture1" type="file" class="restaurant_browse" />   
<span style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="add_item" style=" position: absolute; top: 15px; margin: 0px; right: -5px;"><a style="text-decoration:none;" class="button4" href="javascript:void(0);" onClick="add_cell(document.getElementById('item_id').value)">Add New</a></div>
<?php
 /*?>if($res_reviews['review_picture'] != '')
{
	?>
    <div align="center"><img src="thumb_images/<?php echo $res_reviews['review_picture']; ?>"></div>
    <?php
}<?php */
?>
<div class="clear"></div>
</div>




<p>Review* :</p>

<textarea name="review" id="review" cols="" rows="" class="restaurant_browse2"></textarea>

<div class="clear"></div>
<input type="hidden" name="review_hid" id="review_hid" value="<?php echo $res_reviews['id']?>">
<input type="hidden" name="rating_hid" id="rating_hid" value="<?php echo $res_rating['rating_id']?>">

<input class="button4" type="submit" value="Submit" name="btn_submit" <?php if($res_reviews['abuse_status']==1 && $res_reviews['status']==0){?> disabled=disabled <?php }?> >

</div>

</form>

<div class="clear"></div>

</div>
                        
                        
                        
                        
                        
                    </div>
                </div>
            	<div class="clear"></div>
            	<div class="tab_body_cont"></div>
            </div> <div class="body_footer_bg"></div>
        </div>
       
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>

<?php include("includes/footer_new.php");?>