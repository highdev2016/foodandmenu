<?php
ob_start();
session_start();
//print_r($_SESSION);

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

 include ("includes/header_vendor.php");?>
<?php include ("admin/lib/conn.php");?>
<?php include ("image_file.php");?>
<?php 
if($_REQUEST['action']=='del' && $_REQUEST['del_coupon_id']!=''){
	mysql_query("delete from restaurant_coupon where id='".$_REQUEST['del_coupon_id']."'");
	header("location:spl_admin_special_offer.php?success=1");
	exit();
}
if($_REQUEST['action']=='del' && $_REQUEST['del_deal_id']!=''){
	mysql_query("delete from restaurant_deals where id='".$_REQUEST['del_deal_id']."'");
	header("location:spl_admin_special_offer.php?success=3");
	exit();
}

if($_REQUEST['action']=='del' && $_REQUEST['del_disclaimer_id']!=''){
	mysql_query("delete from restaurant_disclaimer where id='".$_REQUEST['del_disclaimer_id']."'");
	header("location:spl_admin_special_offer.php");
	exit();
}
?>
<body>

<?php include ("includes/menu_admin_addedit_res.php");?>


<?php
$res_basic_info=mysql_query("SELECT * FROM restaurant_basic_info where id='".$_SESSION['restid']."'");
$row_res_id  = mysql_fetch_array($res_basic_info);
$restaurant_id = $row_res_id['id'];

if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	$row_basic_info=mysql_num_rows($res_basic_info);
    if($row_basic_info>0)
	{ 
	for($i=1;$i<=4;$i++)
	{
		if($_REQUEST['coupon_name'.$i]!="")
		{
	if($_FILES['coupon_picture'.$i]['name']!="")
	    {
		$image1=$_FILES['coupon_picture'.$i]['name'];
		$image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $image1);
	    //$image=time().$image;
		if ((($_FILES["coupon_picture".$i]["type"] == "image/gif")
		  || ($_FILES["coupon_picture".$i]["type"] == "image/png")
		  || ($_FILES["coupon_picture".$i]["type"] == "image/bmp")
		  || ($_FILES["coupon_picture".$i]["type"] == "image/jpg")
		  || ($_FILES["coupon_picture".$i]["type"] == "image/jpeg")
		  || ($_FILES["coupon_picture".$i]["type"] == "image/pjpeg")))
		  
		{
			 $picture_url="uploaded_images/".$image;
			LIB_StoreUploadImg($post_file_name="coupon_picture".$i
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="425"
								,$file_to_copy_height="300"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');	
								
			$picture_url="thumb_images/".$image;
			LIB_StoreUploadImg($post_file_name="coupon_picture".$i
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="100"
								,$file_to_copy_height="75"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');	
		
        }

	}
	mysql_query("insert into restaurant_coupon set coupon_status='".$_REQUEST['coupon_deal'.$i]."',coupon_name='".htmlspecialchars(stripslashes($_REQUEST['coupon_name'.$i]),ENT_QUOTES)."', coupon_price = '".$_REQUEST['coupon_price'.$i]."', discount =  '".$_REQUEST['discount_percent'.$i]."', coupon_code =  '".$_REQUEST['coupon_code'.$i]."', start_date = '".change_dateformat($_REQUEST['start_date'.$i])."' , end_date = '".change_dateformat($_REQUEST['end_date'.$i])."' ,coupon_description='".htmlspecialchars(stripslashes($_REQUEST['coupon_description'.$i]),ENT_QUOTES)."', coupon_print = '".$_REQUEST['coupon_print'.$i]."', apply_coupon = '".$_REQUEST['apply_coupon'.$i]."', reappear_date = '".change_dateformat($_REQUEST['reappear_date'.$i])."', coupon_image='".$image."',restaurant_id='".$restaurant_id."' , minimum_order_amount = '".$_REQUEST['minimum_order_amount'.$i]."'  , show_coupon = '".$_REQUEST['show_coupon'.$i]."'  , show_coupon_code = '".$_REQUEST['show_coupon_code'.$i]."', online_redeem = '".$_REQUEST['online_status'.$i]."'  ");
		}
	}
	for($j=1;$j<=4;$j++)
	{
		if($_REQUEST['daily_name'.$j]!="")
		{
		if($_FILES['daily_picture'.$j]['name']!="")
		{
		$video_image1=$_FILES['daily_picture'.$j]['name'];
		$video_image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $video_image1);
	    //$video_image=time().$video_image;
		if ((($_FILES["daily_picture".$j]["type"] == "image/gif")
		  || ($_FILES["daily_picture".$j]["type"] == "image/png")
		  || ($_FILES["daily_picture".$j]["type"] == "image/bmp")
		  || ($_FILES["daily_picture".$j]["type"] == "image/jpg")
		  || ($_FILES["daily_picture".$j]["type"] == "image/jpeg")
		  || ($_FILES["daily_picture".$j]["type"] == "image/pjpeg")))
		  
		{
			
		$picture_url_thumb="thumb_images/".$video_image;
			LIB_StoreUploadImg($post_file_name="daily_picture".$j
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="216"
								,$file_to_copy_height="150"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
								
		$picture_url_thumb="thumb_images/".$video_image;
			LIB_StoreUploadImg($post_file_name="daily_picture".$j
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="100"
								,$file_to_copy_height="75"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
								
		
}

		}
		
	//	echo "insert into restaurant_deals set deals_status='".$_REQUEST['daily_deals'.$j]."',daily_name='".$_REQUEST['daily_name'.$j]."',daily_price='".$_REQUEST['daily_price'.$j]."',daily_description='".$_REQUEST['daily_description'.$j]."',daily_picture='".$video_image."',expiry_date='".$_REQUEST['expiry_date'.$j]."',special_rules='".$_REQUEST['special_rules'.$j]."',restaurant_id='".$_SESSION['rest_id']."'";
		//exit();
		mysql_query("insert into restaurant_deals set deals_status='".htmlspecialchars(stripslashes($_REQUEST['daily_deals'.$j]),ENT_QUOTES)."',daily_name='".htmlspecialchars(stripslashes($_REQUEST['daily_name'.$j]),ENT_QUOTES)."',daily_price='".$_REQUEST['daily_price'.$j]."',daily_description='".htmlspecialchars(stripslashes($_REQUEST['daily_description'.$j]),ENT_QUOTES)."',daily_picture='".$video_image."',expiry_date='".change_dateformat($_REQUEST['expiry_date'.$j])."',special_rules='".htmlspecialchars(stripslashes($_REQUEST['special_rules'.$j]),ENT_QUOTES)."',disclaimer_title='".htmlspecialchars(stripslashes($_REQUEST['disclaimer_title'.$j]),ENT_QUOTES)."',disclaimer='".htmlspecialchars(stripslashes($_REQUEST['disclaimer'.$j]),ENT_QUOTES)."',restaurant_id='".$restaurant_id."',restaurant_name = '".htmlspecialchars(stripslashes($row_res_id['restaurant_name']),ENT_QUOTES)."'");		
		$insert_id=mysql_insert_id();
		mysql_query("update restaurant_deals set certificate_no='00110-".$insert_id."' where id='".$insert_id."'");
	
	$basic_info_for_certificate=mysql_fetch_array(mysql_query("select * from restaurant_basic_info where id='".$restaurant_id."'"));
	
	$basic_info_certificate_details=mysql_fetch_array(mysql_query("select * from restaurant_deals where restaurant_id='".$$restaurant_id."'"));
	
	//$cms_rep = '<table width="700" border="0" bordercolor="c3c6d4" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin:0 auto; border:#c3c6d4 1px solid;">
//  <tr style="border-bottom:#404CA1 1px solid;">
//    <td width="349"><img src="http://www.foodandmenu.com/images/logo_certificate.png" width="216" height="99" style="margin:5px 0 5px 10px;" /></td>
//    <td width="351" valign="top"><p style="font-family:Trebuchet MS, Arial, Helvetica, sans-serif; font-size:14px; color:#000; font-weight:bold; float:right; padding-right:20px;">Certificate #: '.$basic_info_certificate_details['certificate_no'].'</p></td>
//  </tr>
//  
//  <tr>
//    <td colspan="2" valign="top"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:22px; padding:5px 0 10px 10px;">$10 Food and Menu Gift Certificate</h1></td>
//  </tr>
//  
//  <tr>
//  
//  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Redeemable only at (Restaurant):</h1>
//  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$basic_info_for_certificate['restaurant_name'].'</h2>
//  </td>
//  
//  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Date of Purchased:</h1>
//  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.change_dateformat_reverse(date('Y-m-d')).'</h2></td>
//  
//  </tr>
//  
//  <tr>
//  
//  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Address:</h1>
//  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$basic_info_for_certificate['restaurant_address'].'</h2>
//  </td>
//  
//  <td><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Expiration Date:</h1>
//  <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$_REQUEST['expiry_date'.$j].'</h2></td>
//  
//  </tr>
//  
//  <tr>
//  
//  <td colspan="2"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Phone:</h1>
//    <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px;">'.$basic_info_for_certificate['phone'].'</h2>
//    </td>
//  
//  </tr>
//  
//  <tr>
//  
//  <td colspan="2"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Special Rules:</h1>
//    <h2 style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 20px 10px;  border-bottom: 1px solid #C3C6D4;">'.$_REQUEST['special_rules'.$j].'</h2>
//    </td>
//  
//  </tr>
//  
//  <tr>
//  
//  <td colspan="2"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">Instruction to use:</h1>
//    
//    <ol type="1">
//    
//    <li style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px; line-height:26px;">Simply print the food and Menus gift certificate.</li>
//    
//    <li style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px; line-height:26px;">Present the food and Menus gift Certificate to the restaurant before ordering.</li>
//    
//    <li style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 0 0 0 10px; line-height:26px;">Enjoy your meal!</li>
//    
//    </ol>
//    
//    </td>
//  
//  </tr>
//  
//  <tr>
//  
//  <td colspan="2"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; color:#000000; padding: 0 0 0 10px;">TERMS & CONDITIONS FOR FOOD AND MENUS GIFT CERTIFICATES:</h1>
//    
//    <ol type="1">
//    
//    <li style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#585858; font-weight:normal; padding: 0 10px 0 10px; line-height:26px;">All gift certificates will contain an expiration date of one year from issue date.
//(unless required by law)</li>
//    
//    <li style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#585858; font-weight:normal; padding: 0 10px 0 10px; line-height:26px;">Gift certificates indicate a specific dollar value, purhcases cannot exceed the value
//of the gift certificate. If a purchase exceeds the value of the gift certificate, the customer
//can pay the difference in person.</li>
//    
//    <li style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#585858; font-weight:normal; padding: 0 10px 0 10px; line-height:26px;">No cash refunds should be made if the purchase does not equal the total value of the certificate.
//(unless required by)
//</li>
//    
//     <li style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#585858; font-weight:normal; padding: 0 10px 0 10px; line-height:26px;">NO credits for unused amounts of the certificate should be honored.</li>
//     
//      <li style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#585858; font-weight:normal; padding: 0 10px 0 10px; line-height:26px;">Gift certificate must be use in one visit.</li>
//      
//      <li style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#585858; font-weight:normal; padding: 0 10px 0 10px; line-height:26px;">Gift certificate cannot be combined with any other offers.</li>
//    
//    </ol>
//    
//    <p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; font-weight:normal; padding: 30px 10px 0 10px; line-height:18px; text-align:justify;">
//    
//    Terms & Conditions applicable to all food and menus Gift Certificates (unless otherwise set fourth below, in Food and Menus Terms of sale,
//or in the special rules): Unless Prohibited by applicable law the following restrictions also apply. See below for further details.
//discount Food and Menus gift certificate will expires one year from the date of purchased. However, even if the discount offer stated on your food and menus
//gif certificate has expired, applicable law may require the restaurant to allow you to redeem your food and menus gift certificate beyond its expiration date for
//good/services equal to the amount you paid for it. If you have gone to the restaurant and the restaurant has refused to redeem the cash value of 
//your expired food and menus gift certificate, and applicable law entitles you to such redemption, Food and Menus will refund the Purchase price of the
//food and menu gift certificate per its terms of sale. Pertial Redemptions: If you redeem the food and menus gift certificate for less than
//its face value, you only will be entitled ro a credit or cash equal to the difference between the face value and the amount you redeemed from the
//restaurant if applicable law requires it. If you redeem this Food and Menus Gift certificate for less then the total face value, you will not be entitled to
//receive any credit or cash for the difference between the face value and the amount you redeemed, (unless otherwise required by applicable law).
//You will only be entitled toa redemption value equal  to the amount you paid (listed above) for the food and menus gift certificate less then amount
//actually redeemed. Redemption Value: If not redeemed by the discount food and menus gift certificate expiration date, this food and menus will continue to have 
//a redemption value equal to the amount you paid at the restaurant for the period specified by applicable law. The redemption value
//will be reduced by the amount of purchases made. This food and menu gift certificate expiration date above, the restaurant will, in its descrition:
//(1) allow you to redeem this food and menus gift certificate for the product or services specified on the food and menus gift certificate or (2) allow you to redeem
//the food and menus gift certificate to purchase other good/services from the restaurant for up to the amount you paid (listed above)
//for the food and menus gift certificate. this food and menus gift certificate can only be used for making purchases of good/services at the restaurant. Restaurant is solely responcible
//for food and menus gift cerficate redeemption. Food and Menus Gift Certificate cannot be redeemed for cash or applied as 
//payment to any account unless required by applicable law. Neither food and menus, LLC nor the restaurant shall be responsible for food and menus gift certificates that are
//lost or damaged. Food and Menus Gift Certificates is for promotional purposes.
//Use to food and menus gift certificate are subject to food and Menuss Terms of sale.
//    
//    </p>
//    
//    </td>
//  
//  </tr>
//  
//</table>';
//
//			$email = $basic_info_for_certificate['email'];
//			$from = 'support@foodandmenu.com';
//
//			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
//
//			$headers .= 'MIME-Version: 1.0' . "\r\n";
//
//			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
//
//			$message=$cms_rep;
//
//			$subject="Gift Certificate";
//
//			mail($email,$subject,$message,$headers);
		}
	}
	$disclaimer_row=mysql_num_rows(mysql_query("SELECT * FROM restaurant_disclaimer WHERE restaurant_id='".$restaurant_id."'"));
	if($disclaimer_row>0)
	{
		mysql_query("update restaurant_disclaimer set disclaimer='".$_REQUEST['disclaimer']."',description='".$_REQUEST['dis_description']."' WHERE restaurant_id='".$restaurant_id."'");
	}
	else{
	mysql_query("insert into restaurant_disclaimer set restaurant_id='".$restaurant_id."', disclaimer='".$_REQUEST['disclaimer']."',description='".$_REQUEST['dis_description']."'");
	}
	header("location:spl_admin_confirmation.php");
	}
}
?>
<link rel="stylesheet" href="calender/jquery-ui.css" />
<script src="calender/jquery-1.8.3.js"></script>
<script src="calender/jquery-ui.js"></script>
<script>
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

$(function() {
	$( "#expiry_date1" ).datepicker({
		dateFormat:"mm-dd-yy"
	});
	$( "#expiry_date2" ).datepicker({
		dateFormat:"mm-dd-yy"
	});
	$( "#expiry_date3" ).datepicker({
		dateFormat:"mm-dd-yy"
	});
	$( "#expiry_date4" ).datepicker({
		dateFormat:"mm-dd-yy"
	});
	//$( "#post_date" ).datepicker( "dd-mm-yy", "dateFormat" );
});

$( document ).ready(function() {
	$(window).on('load',function() {
	  $('#reappear_date1').datepicker({changeMonth: true, changeYear: true, dateFormat:"mm-dd-yy",});
	  $('#reappear_date2').datepicker({changeMonth: true, changeYear: true, dateFormat:"mm-dd-yy",});
	  $('#reappear_date3').datepicker({changeMonth: true, changeYear: true, dateFormat:"mm-dd-yy",});
	  $('#reappear_date4').datepicker({changeMonth: true, changeYear: true, dateFormat:"mm-dd-yy",});
	});	  
});

$( document ).ready(function() {
	var enq_dat = new Date();
	$(window).on('load',function() {
	  $('#end_date1').datepicker('option', 'minDate', enq_dat);
	  $('#end_date2').datepicker('option', 'minDate', enq_dat);
	  $('#end_date3').datepicker('option', 'minDate', enq_dat);
	  $('#end_date4').datepicker('option', 'minDate', enq_dat);
	});	  
});
$(function()
{
    $('#start_date1').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function(dateStr) {
		  var date = $(this).datepicker('getDate');		  
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $('#end_date1').datepicker('option', 'minDate', date);
		}
      });
    $('#end_date1').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function (selectedDate) {
		  var date = $(this).datepicker('getDate');
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $('#start_date1').datepicker('option', 'maxDate', date || 0);
		}
      });
	  
	$('#start_date2').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function(dateStr) {
		  var date = $(this).datepicker('getDate');		  
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $('#end_date2').datepicker('option', 'minDate', date);
		}
      });
    $('#end_date2').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function (selectedDate) {
		  var date = $(this).datepicker('getDate');
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $('#start_date2').datepicker('option', 'maxDate', date || 0);
		}
      });  
	  
	$('#start_date3').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function(dateStr) {
		  var date = $(this).datepicker('getDate');		  
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $('#end_date3').datepicker('option', 'minDate', date);
		}
      });
    $('#end_date3').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function (selectedDate) {
		  var date = $(this).datepicker('getDate');
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $('#start_date3').datepicker('option', 'maxDate', date || 0);
		}
      });
	  
	$('#start_date4').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function(dateStr) {
		  var date = $(this).datepicker('getDate');		  
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $('#end_date4').datepicker('option', 'minDate', date);
		}
      });
    $('#end_date4').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function (selectedDate) {
		  var date = $(this).datepicker('getDate');
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $('#start_date4').datepicker('option', 'maxDate', date || 0);
		}
      }); 
	   
});

function disable_coupon_percent1()
{
	var $j = jQuery.noConflict();
	
	var coupon_price = $j("#coupon_price1").val();
	
	if(coupon_price != '')
	{
		$j("#discount_percent1").val('');
		$j("#discount_percent1").prop('disabled', true);
	}
	else
	{
		$j("#discount_percent1").prop('disabled', false);
	}
}

function disable_coupon_price1()
{
	var $j = jQuery.noConflict();
	
	var coupon_percent = $j("#discount_percent1").val();
	
	if(coupon_percent != '')
	{
		$j("#coupon_price1").val('');
		$j("#coupon_price1").prop('disabled', true);
	}
	else
	{
		$j("#coupon_price1").prop('disabled', false);
	}
}

function disable_coupon_percent2()
{
	var $j = jQuery.noConflict();
	
	var coupon_price = $j("#coupon_price2").val();
	
	if(coupon_price != '')
	{
		$j("#discount_percent2").val('');
		$j("#discount_percent2").prop('disabled', true);
	}
	else
	{
		$j("#discount_percent2").prop('disabled', false);
	}
}

function disable_coupon_price2()
{
	var $j = jQuery.noConflict();
	
	var coupon_percent = $j("#discount_percent2").val();
	
	if(coupon_percent != '')
	{
		$j("#coupon_price2").val('');
		$j("#coupon_price2").prop('disabled', true);
	}
	else
	{
		$j("#coupon_price2").prop('disabled', false);
	}
}

function disable_coupon_percent3()
{
	var $j = jQuery.noConflict();
	
	var coupon_price = $j("#coupon_price3").val();
	
	if(coupon_price != '')
	{
		$j("#discount_percent3").val('');
		$j("#discount_percent3").prop('disabled', true);
	}
	else
	{
		$j("#discount_percent3").prop('disabled', false);
	}
}

function disable_coupon_price3()
{
	var $j = jQuery.noConflict();
	
	var coupon_percent = $j("#discount_percent3").val();
	
	if(coupon_percent != '')
	{
		$j("#coupon_price3").val('');
		$j("#coupon_price3").prop('disabled', true);
	}
	else
	{
		$j("#coupon_price3").prop('disabled', false);
	}
}

function disable_coupon_percent4()
{
	var $j = jQuery.noConflict();
	
	var coupon_price = $j("#coupon_price4").val();
	
	if(coupon_price != '')
	{
		$j("#discount_percent4").val('');
		$j("#discount_percent4").prop('disabled', true);
	}
	else
	{
		$j("#discount_percent4").prop('disabled', false);
	}
}

function disable_coupon_price4()
{
	var $j = jQuery.noConflict();
	
	var coupon_percent = $j("#discount_percent4").val();
	
	if(coupon_percent != '')
	{
		$j("#coupon_price4").val('');
		$j("#coupon_price4").prop('disabled', true);
	}
	else
	{
		$j("#coupon_price4").prop('disabled', false);
	}
}

function check_order_amount1()
{
	var $j = jQuery.noConflict();
	
	if($j("#coupon_price1").prop('disabled', false))
	{
		var coupon_price = $j("#coupon_price1").val();
		var order_amount = $j("#minimum_order_amount1").val();
		
		if(parseFloat(order_amount) <= parseFloat(coupon_price))
		{
			alert("Minimum Order Amount must be greater than Coupon Price");
			$j("#minimum_order_amount1").val('');
			$j("#minimum_order_amount1").focus();
		}
		
	}
	else
	{
		return true;
	}
	
}

function check_order_amount2()
{
	var $j = jQuery.noConflict();
	
	if($j("#coupon_price2").prop('disabled', false))
	{
		var coupon_price = $j("#coupon_price2").val();
		var order_amount = $j("#minimum_order_amount2").val();
		
		if(parseFloat(order_amount) <= parseFloat(coupon_price))
		{
			alert("Minimum Order Amount must be greater than Coupon Price");
			$j("#minimum_order_amount2").val('');
			$j("#minimum_order_amount2").focus();
		}
	}
	else
	{
		return true;
	}
}


function check_order_amount3()
{
	var $j = jQuery.noConflict();
	
	if($j("#coupon_price3").prop('disabled', false))
	{
		var coupon_price = $j("#coupon_price3").val();
		var order_amount = $j("#minimum_order_amount3").val();
		
		if(parseFloat(order_amount) <= parseFloat(coupon_price))
		{
			alert("Minimum Order Amount must be greater than Coupon Price");
			$j("#minimum_order_amount3").val('');
			$j("#minimum_order_amount3").focus();
		}
	}
	else
	{
		return true;
	}
}


function check_order_amount4()
{
	var $j = jQuery.noConflict();
	
	if($j("#coupon_price4").prop('disabled', false))
	{
		var coupon_price = $j("#coupon_price4").val();
		var order_amount = $j("#minimum_order_amount4").val();
		
		if(parseFloat(order_amount) <= parseFloat(coupon_price))
		{
			alert("Minimum Order Amount must be greater than Coupon Price");
			$j("#minimum_order_amount4").val('');
			$j("#minimum_order_amount4").focus();
		}
	}
	else
	{
		return true;
	}
}


function check_order_coupon_price1()
{
	var $j = jQuery.noConflict();
	var order_amount = $j("#minimum_order_amount1").val();
	var discount_percent = $j("#discount_percent1").val();
	
	if(order_amount != '')
	{
		var coupon_price = $j("#coupon_price1").val();
		
		if(parseFloat(coupon_price) >= parseFloat(order_amount))
		{
			alert("Coupon Price must be less than Minimum Order Amount");
			$j("#coupon_price1").val('');
			$j("#coupon_price1").focus();
		}
		if(coupon_price == '')
		{
			if(discount_percent == '')
			{
				alert("Coupon Price cannot be left blank.");
			}
		}
	}
	else
	{
		return true;
	}
}

function check_order_coupon_price2()
{
	var $j = jQuery.noConflict();
	var order_amount = $j("#minimum_order_amount2").val();
	var discount_percent = $j("#discount_percent2").val();
	
	if(order_amount != '')
	{
		var coupon_price = $j("#coupon_price2").val();
		
		if(parseFloat(coupon_price) >= parseFloat(order_amount))
		{
			alert("Coupon Price must be less than Minimum Order Amount");
			$j("#coupon_price2").val('');
			$j("#coupon_price2").focus();
		}
		if(coupon_price == '')
		{
			if(discount_percent == '')
			{
				alert("Coupon Price cannot be left blank.");
			}
		}
	}
	else
	{
		return true;
	}
}

function check_order_coupon_price3()
{
	var $j = jQuery.noConflict();
	var order_amount = $j("#minimum_order_amount3").val();
	var discount_percent = $j("#discount_percent3").val();
	
	if(order_amount != '')
	{
		var coupon_price = $j("#coupon_price3").val();
		
		if(parseFloat(coupon_price) >= parseFloat(order_amount))
		{
			alert("Coupon Price must be less than Minimum Order Amount");
			$j("#coupon_price3").val('');
			$j("#coupon_price3").focus();
		}
		if(coupon_price == '')
		{
			if(discount_percent == '')
			{
				alert("Coupon Price cannot be left blank.");
			}
		}
	}
	else
	{
		return true;
	}
}

function check_order_coupon_price4()
{
	var $j = jQuery.noConflict();
	var order_amount = $j("#minimum_order_amount4").val();
	var discount_percent = $j("#discount_percent4").val();
	
	if(order_amount != '')
	{
		var coupon_price = $j("#coupon_price4").val();
		
		if(parseFloat(coupon_price) >= parseFloat(order_amount))
		{
			alert("Coupon Price must be less than Minimum Order Amount");
			$j("#coupon_price4").val('');
			$j("#coupon_price4").focus();
		}
		if(coupon_price == '')
		{
			if(discount_percent == '')
			{
				alert("Coupon Price cannot be left blank.");
			}
		}
	}
	else
	{
		return true;
	}
}

function check_coupon_code(code,res_id,id){

	var $j = jQuery.noConflict();
	
	$j.ajax({
		url : 'check_coupon_code.php',
		type : 'POST',
		data : 'code=' + code + '&res_id=' + res_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			
			if(data == 'Exists'){
				$j("#err_cd"+id).slideDown(1000);
				$j("#coupon_code"+id).val('');
			}else{
				$j("#err_cd"+id).slideUp(1000);
			}
			
	
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});

}

$(document).ready(function() {
 $('.coupon_code').bind('copy paste',function(e) { 
 e.preventDefault(); //disable cut,copy,paste
 });
});

</script>
<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>Add New Restaurant</h1>
</div>

<div class="restaurant_nav">
                    
                    
                    <ul>
                    <li><a href="spl_admin_add_restaurant.php">Basic Info</a></li>
                    <li><a href="spl_admin_additional.php">Additional Info</a></li>
                    <li><a href="spl_admin_restaurant_menu.php">Menu</a></li>
                    <li><a href="spl_admin_multimedia.php">Multimedia</a></li>
                    <li><a href="spl_admin_special_offer.php" class="active7">Special Offer</a></li>
                    <li><a href="spl_admin_confirmation.php">Confirmation</a></li>
                    </ul>
                    
                    </div>
<?php $basic_info_for_disclaimer=mysql_fetch_array(mysql_query("select * from restaurant_disclaimer where restaurant_id='".$restaurant_id."'"));?>
<div class="restaurant_cont_field">
<form name="myfrm" method="post" enctype="multipart/form-data">
<?php if($_REQUEST['success'] == 1){?>
<p style="text-align:center;">Coupon deleted successfully</p>
<?php } else if($_REQUEST['success'] == 2){ ?>
<p style="text-align:center;">Coupon updated successfully</p>
<?php } else if($_REQUEST['success'] == 3){ ?>
<p style="text-align:center;">Deal deleted successfully</p>
<?php } else if($_REQUEST['success'] == 4){ ?>
<p style="text-align:center;">Deal updated successfully</p>
<?php } ?>

<?php
	$randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	$randomString1 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	$randomString2 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	$randomString3 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
?>

<div class="restaurant_form_field">

<h1>Coupon 1</h1>

<div class="clear"></div>

<p>Coupon Deals :</p>

<input name="coupon_deal1"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="coupon_deal1" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon* :</p>

<input name="show_coupon1"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon1" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon Code* :</p>

<input name="show_coupon_code1"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon_code1" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Coupon Name :</p>

<input name="coupon_name1" type="text" class="restaurant" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price1" id="coupon_price1" onKeyUp="disable_coupon_percent1()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"  onBlur="check_order_coupon_price1()" />

<div class="clear"></div>

<p>Discount Percentage* :</p>

<input name="discount_percent1" id="discount_percent1" onKeyUp="disable_coupon_price1()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" />

<div class="clear"></div>

<p>Start Date* :</p>

<input name="start_date1" id="start_date1" type="text" class="restaurant start_date" readonly />

<div class="clear"></div>

<p>End Date* :</p>

<input name="end_date1" id="end_date1" type="text" class="restaurant end_date" readonly />

<div class="clear"></div>

<p>Minimum Order Amount* :</p>

<input name="minimum_order_amount1" id="minimum_order_amount1" type="text" onKeyPress="return goodchars(event,'1234567890.');" class="restaurant"  onBlur="check_order_amount1()" />

<div class="clear"></div>

<p>Coupon Code* :</p>

<input name="coupon_code1" id="coupon_code1" type="text" class="restaurant coupon_code" value="<?php echo $randomString; ?>" onKeyUp="check_coupon_code(this.value, '<?php echo $restaurant_id; ?>',1);" />

<div class="clear"></div>

<div id="err_cd1" style="color:#ff0000; margin-left:167px; margin-bottom:10px; display:none;"> The Coupon Code Already Exists. </div>

<p>Coupon Description :</p>

<textarea name="coupon_description1" cols="25" rows="5" ></textarea>

<div class="clear"></div>

<p>Online Status* :</p>

<input name="online_status1"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Online</p>
<input name="online_status1" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">Offline</p>

<div class="clear"></div>

<p>No. of times Coupon Print* :</p>

<input name="coupon_print2" id="coupon_print2" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>No. of times Apply Coupon* :</p>

<input name="apply_coupon2" id="apply_coupon2" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Reappear Date :</p>

<input name="reappear_date2" id="reappear_date2" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Picture :</p>

<input name="coupon_picture1" type="file" class="restaurant_browse" />
<span style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="clear"></div>

<h1>Coupon 2</h1>

<div class="clear"></div>

<p>Coupon Deals :</p>

<input name="coupon_deal2" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="coupon_deal2" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon* :</p>

<input name="show_coupon2"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon2" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon Code* :</p>

<input name="show_coupon_code2"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon_code2" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Coupon Name :</p>

<input name="coupon_name2" type="text" class="restaurant" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price2" id="coupon_price2" onKeyUp="disable_coupon_percent2()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"  onBlur="check_order_coupon_price2()" />

<div class="clear"></div>

<p>Discount Percentage* :</p>

<input name="discount_percent2" id="discount_percent2" onKeyUp="disable_coupon_price2()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" />

<div class="clear"></div>

<p>Start Date* :</p>

<input name="start_date2" id="start_date2" type="text" class="restaurant start_date" readonly />

<div class="clear"></div>

<p>End Date* :</p>

<input name="end_date2" id="end_date2" type="text" class="restaurant end_date" readonly />

<div class="clear"></div>

<p>Minimum Order Amount* :</p>

<input name="minimum_order_amount2" id="minimum_order_amount2" type="text" onKeyPress="return goodchars(event,'1234567890.');" class="restaurant"  onBlur="check_order_amount2()" />

<div class="clear"></div>

<p>Coupon Code* :</p>

<input name="coupon_code2" id="coupon_code2" type="text" class="restaurant coupon_code" value="<?php echo $randomString1; ?>" onKeyUp="check_coupon_code(this.value, '<?php echo $restaurant_id; ?>',2);"  />

<div class="clear"></div>

<div id="err_cd2" style="color:#ff0000; margin-left:167px; margin-bottom:10px; display:none;"> The Coupon Code Already Exists. </div>

<p>Coupon Description :</p>

<textarea name="coupon_description2" cols="25" rows="5" ></textarea>

<div class="clear"></div>

<p>Online Status* :</p>

<input name="online_status2"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Online</p>
<input name="online_status2" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">Offline</p>

<div class="clear"></div>

<p>No. of times Coupon Print* :</p>

<input name="coupon_print2" id="coupon_print2" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>No. of times Apply Coupon* :</p>

<input name="apply_coupon2" id="apply_coupon2" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Reappear Date :</p>

<input name="reappear_date2" id="reappear_date2" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Picture :</p>

<input name="coupon_picture2" type="file" class="restaurant_browse" />
<span style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="clear"></div>

<h1>Coupon 3</h1>

<div class="clear"></div>
<p>Coupon Deals :</p>
<input name="coupon_deal3" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="coupon_deal3" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon* :</p>

<input name="show_coupon3"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon3" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon Code* :</p>

<input name="show_coupon_code3"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon_code3" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Coupon Name :</p>

<input name="coupon_name3" type="text" class="restaurant" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price3" id="coupon_price3" onKeyUp="disable_coupon_percent3()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"  onBlur="check_order_coupon_price3()" />

<div class="clear"></div>

<p>Discount Percentage* :</p>

<input name="discount_percent3" id="discount_percent3" onKeyUp="disable_coupon_price3()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" />

<div class="clear"></div>

<p>Start Date* :</p>

<input name="start_date3" id="start_date3" type="text" class="restaurant start_date" readonly />

<div class="clear"></div>

<p>End Date* :</p>

<input name="end_date3" id="end_date3" type="text" class="restaurant end_date" readonly />

<div class="clear"></div>

<p>Minimum Order Amount* :</p>

<input name="minimum_order_amount3" id="minimum_order_amount3" type="text" onKeyPress="return goodchars(event,'1234567890.');" class="restaurant"  onBlur="check_order_amount3()" />

<div class="clear"></div>

<p>Coupon Code* :</p>
<input name="coupon_code3" id="coupon_code3" type="text" class="restaurant coupon_code" value="<?php echo $randomString2; ?>" onKeyUp="check_coupon_code(this.value, '<?php echo $restaurant_id; ?>',3);"  />
<div class="clear"></div>

<div id="err_cd3" style="color:#ff0000; margin-left:167px; margin-bottom:10px; display:none;"> The Coupon Code Already Exists. </div>

<p>Coupon Description :</p>

<textarea name="coupon_description3" cols="25" rows="5" ></textarea>

<div class="clear"></div>

<p>Online Status* :</p>

<input name="online_status3"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Online</p>
<input name="online_status3" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">Offline</p>

<div class="clear"></div>

<p>No. of times Coupon Print* :</p>

<input name="coupon_print3" id="coupon_print3" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>No. of times Apply Coupon* :</p>

<input name="apply_coupon3" id="apply_coupon3" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Reappear Date :</p>

<input name="reappear_date3" id="reappear_date3" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>


<p>Picture :</p>

<input name="coupon_picture3" type="file" class="restaurant_browse" />
<span style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="clear"></div>

<h1>Coupon 4</h1>

<div class="clear"></div>

<p>Coupon Deals :</p>
<input name="coupon_deal4" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="coupon_deal4" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon* :</p>

<input name="show_coupon4"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon4" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon Code* :</p>

<input name="show_coupon_code4"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon_code4" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Coupon Name :</p>

<input name="coupon_name4" type="text" class="restaurant" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price4" id="coupon_price4" onKeyUp="disable_coupon_percent4()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"  onBlur="check_order_coupon_price4()" />

<div class="clear"></div>

<p>Discount Percentage* :</p>

<input name="discount_percent4" id="discount_percent4" onKeyUp="disable_coupon_price4()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" />

<div class="clear"></div>

<p>Start Date* :</p>

<input name="start_date4" id="start_date4" type="text" class="restaurant start_date" readonly />

<div class="clear"></div>

<p>End Date* :</p>

<input name="end_date4" id="end_date4" type="text" class="restaurant end_date" readonly />

<div class="clear"></div>

<p>Minimum Order Amount* :</p>

<input name="minimum_order_amount4" id="minimum_order_amount4" type="text" onKeyPress="return goodchars(event,'1234567890.');" class="restaurant"  onBlur="check_order_amount4()" />

<div class="clear"></div>

<p>Coupon Code* :</p>

<input name="coupon_code4" id="coupon_code4" type="text" class="restaurant coupon_code" value="<?php echo $randomString3; ?>" onKeyUp="check_coupon_code(this.value, '<?php echo $restaurant_id; ?>',4);"  />

<div class="clear"></div>

<div id="err_cd4" style="color:#ff0000; margin-left:167px; margin-bottom:10px; display:none;"> The Coupon Code Already Exists. </div>

<p>Coupon Description :</p>

<textarea name="coupon_description4" cols="25" rows="5" ></textarea>

<div class="clear"></div>

<p>Online Status* :</p>

<input name="online_status4"  type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Online</p>
<input name="online_status4" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">Offline</p>

<div class="clear"></div>

<p>No. of times Coupon Print* :</p>

<input name="coupon_print4" id="coupon_print4" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>No. of times Apply Coupon* :</p>

<input name="apply_coupon4" id="apply_coupon4" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Reappear Date :</p>

<input name="reappear_date4" id="reappear_date4" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Picture :</p>

<input name="coupon_picture4" type="file" class="restaurant_browse" />
<span style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="clear"></div>

<?php /*?><h1>Disclaimer  </h1>

<div class="clear"></div>

<p>Disclaimer Title :</p>

<input name="disclaimer" type="text" class="restaurant" value="<?php echo $basic_info_for_disclaimer['disclaimer']?>" />

<div class="clear"></div>
<p>Disclaimer Description :</p>
<textarea name="dis_description" rows="5" cols="25"><?php echo $basic_info_for_disclaimer['description']?></textarea>

<div class="clear"></div><?php */?>

<div class="clear"></div>

</div>

<div class="restaurant_form_field">

<h1>Daily Deals  </h1>

<div class="clear"></div>

<p>Daily Deals :</p>

<input name="daily_deals1" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals1" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily Description :</p>

<input name="daily_name1" type="text" class="restaurant" />

<div class="clear"></div>

<p>Price :</p>

<input name="daily_description1" type="text" class="restaurant" />

<div class="clear"></div>

<p>Your Price :</p>

<input name="daily_price1" type="text" class="restaurant" />

<div class="clear"></div>

<p>Picture :</p>

<input name="daily_picture1" type="file" class="restaurant_browse" />

<div class="clear"></div>

<p>Expiry Date :</p>

<input name="expiry_date1" id="expiry_date1" type="text" class="restaurant_browse" />

<div class="clear"></div>

<p>Special Rules :</p>

<input name="special_rules1" type="text" class="restaurant_browse" />

<div class="clear"></div>

<p>Disclaimer Title :</p>

<input name="disclaimer_title1" type="text" class="restaurant_browse" />

<p>Disclaimer Description :</p>

<textarea name="disclaimer1" id="disclaimer1" rows="5" cols="25"></textarea>

<div class="clear"></div>


<h1>Daily Deals - 1</h1>

<div class="clear"></div>

<p>Daily Deals :</p>

<input name="daily_deals2" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals2" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily Description :</p>

<input name="daily_name2" type="text" class="restaurant" />

<div class="clear"></div>

<p>Price :</p>

<input name="daily_description2" type="text" class="restaurant" />

<div class="clear"></div>

<p>Your Price :</p>

<input name="daily_price2" type="text" class="restaurant" />

<div class="clear"></div>

<p>Picture :</p>

<input name="daily_picture2" type="file" class="restaurant_browse" />

<div class="clear"></div>

<p>Expiry Date :</p>

<input name="expiry_date2" id="expiry_date2" type="text" class="restaurant_browse" />

<div class="clear"></div>

<p>Special Rules :</p>

<input name="special_rules2" type="text" class="restaurant_browse" />

<div class="clear"></div>

<p>Disclaimer Title :</p>

<input name="disclaimer_title2" type="text" class="restaurant_browse" />

<p>Disclaimer Description :</p>

<textarea name="disclaimer2" id="disclaimer2" rows="5" cols="25"></textarea>

<div class="clear"></div>


<h1>Daily Deals - 2</h1>

<div class="clear"></div>

<p>Daily Deals :</p>

<input name="daily_deals3" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals3" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily description :</p>

<input name="daily_name3" type="text" class="restaurant" />

<div class="clear"></div>

<p>Price :</p>

<input name="daily_description3" type="text" class="restaurant" />

<div class="clear"></div>

<p>Your Price :</p>

<input name="daily_price3" type="text" class="restaurant" />

<div class="clear"></div>

<p>Picture :</p>

<input name="daily_picture3" type="file" class="restaurant_browse" />

<div class="clear"></div>

<p>Expiry Date :</p>

<input name="expiry_date3" id="expiry_date3" type="text" class="restaurant_browse" />

<div class="clear"></div>

<p>Special Rules :</p>

<input name="special_rules3" type="text" class="restaurant_browse" />

<div class="clear"></div>

<p>Disclaimer Title :</p>

<input name="disclaimer_title3" type="text" class="restaurant_browse" />

<p>Disclaimer Description :</p>

<textarea name="disclaimer3" id="disclaimer3" rows="5" cols="25"></textarea>

<div class="clear"></div>

<h1>Daily Deals - 3</h1>

<div class="clear"></div>

<p>Daily Deals :</p>

<input name="daily_deals4" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals4" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily Description :</p>

<input name="daily_name4" type="text" class="restaurant" />

<div class="clear"></div>

<p>Price :</p>

<input name="daily_description4" type="text" class="restaurant" />

<div class="clear"></div>

<p>Your Price :</p>

<input name="daily_price4" type="text" class="restaurant" />

<div class="clear"></div>

<p>Picture :</p>

<input name="daily_picture4" type="file" class="restaurant_browse" />

<div class="clear"></div>

<p>Expiry Date :</p>

<input name="expiry_date4" id="expiry_date4" type="text" class="restaurant_browse" />

<div class="clear"></div>

<p>Special Rules :</p>

<input name="special_rules4" type="text" class="restaurant_browse" />

<div class="clear"></div>

<p>Disclaimer Title :</p>

<input name="disclaimer_title4" type="text" class="restaurant_browse" />

<p>Disclaimer Description :</p>

<textarea name="disclaimer4" id="disclaimer4" rows="5" cols="25"></textarea>

<div class="clear"></div>

<input class="button4" type="submit" value="Save & Continue" name="submit">

</div>

<div class="clear"></div>
</form>

<?php
if($_SESSION['restid']!="")
{
$sql_deals = mysql_query("SELECT * FROM restaurant_coupon WHERE restaurant_id='".$restaurant_id."'");
if(mysql_num_rows($sql_deals)>0){?>
<div style="width:970px; margin:0 auto;">
<h3>Coupon List</h3>
<table width="100%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:10px;" align="center">
  <tr>
    <td width="22%" class="all_restaurant">Coupon Name</td>
    <td width="18%" class="all_restaurant">Coupon Code</td>
    <td width="18%" class="all_restaurant">Coupon Discount (%)</td>
    <td width="18%" class="all_restaurant">Coupon Discount  Price</td>
    <td width="20%" class="all_restaurant">Coupon Deals</td>
    <td width="20%" class="all_restaurant">Online Status</td>
    <td width="21%" class="all_restaurant">Action</td>
  </tr>
  <?php
	while($array_deals = mysql_fetch_array($sql_deals)){
  ?>
  <tr>
    <td class="all_restaurant2"><?php echo $array_deals['coupon_name']?></td>
    <td class="all_restaurant2"><?php echo $array_deals['coupon_code']?></td>
    <td class="all_restaurant2"><?php echo $array_deals['discount']?></td>
    <td class="all_restaurant2"><?php echo $array_deals['coupon_price']?></td>
    <td class="all_restaurant2"><?php if($array_deals['coupon_status'] == 1){ echo "Yes"; }else{ echo "No"; }?></td>
    <td class="all_restaurant2"><?php if($array_deals['online_redeem'] == 1){ echo "Online"; }else{ echo "Offline"; }?></td>
    <td class="all_restaurant2"><a href="edit_daily_coupon1_spl_admin.php?coupon_id=<?php echo $array_deals['id']?>" class="all_edit">Edit</a>&nbsp;<a href="special_offer.php?action=del&del_coupon_id=<?php echo $array_deals['id']?>" class="all_edit" onClick="return confirm('Are you sure you want to delete this coupon deals?');">Delete</a></td>
  </tr>
<?php } ?>
</table></div>
<?php
}
?>

<?php
$sql_deals = mysql_query("SELECT * FROM restaurant_deals WHERE restaurant_id='".$restaurant_id."'");
if(mysql_num_rows($sql_deals)>0){?>
<div style="width:970px; margin:20px auto;">
<h3>Daily Deals List</h3>
<table width="100%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:10px;" align="center">
  <tr>
    <td width="22%" class="all_restaurant">Daily Description</td>
    <td width="20%" class="all_restaurant">Price ($)</td>
    <td width="18%" class="all_restaurant">Your Price ($)</td>
    <td width="21%" class="all_restaurant">Action</td>
  </tr>
  <?php
	while($array_deals = mysql_fetch_array($sql_deals)){
  ?>
  <tr>
    <td class="all_restaurant2"><?php echo $array_deals['daily_name']?> <?php if($array_deals['expiry_date'] <= date('Y-m-d') && $array_deals['expiry_date']!='0000-00-00'){?>
    <span style="color:#ff0000; margin-left:5px;">[This deal has expired]</span>
	<?php }?></td>
    <td class="all_restaurant2"><?php echo $array_deals['daily_description']?></td>
    <td class="all_restaurant2"><?php echo $array_deals['daily_price']?></td>
    <td class="all_restaurant2"><a href="edit_daily_deals1_spl_admin.php?deals_id=<?php echo $array_deals['id']?>" class="all_edit">Edit</a>&nbsp;<a href="special_offer.php?action=del&del_deal_id=<?php echo $array_deals['id']?>" class="all_edit" onClick="return confirm('Are you sure you want to delete this daily deals?');">Delete</a></td>
  </tr>
<?php } ?>
</table></div>
<?php
}

}
?>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>
