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
 include ("includes/header_vendor.php");?>
<?php include ("admin/lib/conn.php");?>
<?php include ("image_file.php");?>
<?php 
if($_REQUEST['action']=='del' && $_REQUEST['del_coupon_id']!=''){
	mysql_query("delete from restaurant_coupon where id='".$_REQUEST['del_coupon_id']."'");
	header("location:edit_special_offer1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&success=2");
	exit();
}
if($_REQUEST['action']=='del' && $_REQUEST['del_deal_id']!=''){
	mysql_query("delete from restaurant_deals where id='".$_REQUEST['del_deal_id']."'");
	header("location:edit_special_offer1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."&success=4");
	exit();
}

if($_REQUEST['action']=='del' && $_REQUEST['del_disclaimer_id']!=''){
	mysql_query("delete from restaurant_disclaimer where id='".$_REQUEST['del_disclaimer_id']."'");
	header("location:edit_special_offer1.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."");
	exit();
}
?>


<script type="text/javascript">
/*var $j = jQuery.noConflict();

$j(function() {
  var pickerOpts = {
	changeMonth: true,
	changeYear: true,
    dateFormat:"mm-dd-yy",
	minDate: 0,
}; 
$j( ".start_date" ).datepicker(pickerOpts, 'minDate');
$j( ".end_date" ).datepicker(pickerOpts, 'minDate');
});*/
</script>

<style type="text/css">
.restaurant_nav{
	display:none;
}
</style>

<body>

<?php include ("includes/menu_rest_admin_panel.php");?>

<?php //include ("includes/restaurant_nav_menu.php");?>


<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	$res_basic_info=mysql_query("SELECT * FROM restaurant_basic_info where id='".$_REQUEST['restaurant_edit_id']."'");
	$row_basic_info=mysql_num_rows($res_basic_info);
	$row_res_id = mysql_fetch_array($res_basic_info);
    if($row_basic_info>0)
	{
	for($i=1;$i<=4;$i++)
	{
		if($_REQUEST['coupon_deal'.$i]!="")
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
	mysql_query("insert into restaurant_coupon set coupon_status='".$_REQUEST['coupon_deal'.$i]."',coupon_name='".htmlspecialchars(stripslashes($_REQUEST['coupon_name'.$i]),ENT_QUOTES)."', coupon_price = '".$_REQUEST['coupon_price'.$i]."', discount =  '".$_REQUEST['discount_percent'.$i]."', coupon_code =  '".$_REQUEST['coupon_code'.$i]."', start_date = '".change_dateformat($_REQUEST['start_date'.$i])."' , end_date = '".change_dateformat($_REQUEST['end_date'.$i])."' ,coupon_description='".htmlspecialchars(stripslashes($_REQUEST['coupon_description'.$i]),ENT_QUOTES)."', coupon_print = '".$_REQUEST['coupon_print'.$i]."', apply_coupon = '".$_REQUEST['apply_coupon'.$i]."', reappear_date = '".change_dateformat($_REQUEST['reappear_date'.$i])."', online_redeem = '".$_REQUEST['online_status'.$i]."' , coupon_image='".$image."',restaurant_id='".$_REQUEST['restaurant_edit_id']."' , minimum_order_amount = '".$_REQUEST['minimum_order_amount'.$i]."' , show_coupon = '".$_REQUEST['show_coupon'.$i]."' , show_coupon_code = '".$_REQUEST['show_coupon_code'.$i]."' ");
		}
	}
	for($j=1;$j<=4;$j++)
	{
		if($_REQUEST['daily_deals'.$j]!="")
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
								
		
}

		}
		mysql_query("insert into restaurant_deals set deals_status='".htmlspecialchars(stripslashes($_REQUEST['daily_deals'.$j]),ENT_QUOTES)."',daily_name='".htmlspecialchars(stripslashes($_REQUEST['daily_name'.$j]),ENT_QUOTES)."',daily_price='".$_REQUEST['daily_price'.$j]."',daily_description='".htmlspecialchars(stripslashes($_REQUEST['daily_description'.$j]),ENT_QUOTES)."',daily_picture='".$video_image."',expiry_date='".change_dateformat($_REQUEST['expiry_date'.$j])."',special_rules='".htmlspecialchars(stripslashes($_REQUEST['special_rules'.$j]),ENT_QUOTES)."',disclaimer_title='".htmlspecialchars(stripslashes($_REQUEST['disclaimer_title'.$j]),ENT_QUOTES)."',disclaimer='".htmlspecialchars(stripslashes($_REQUEST['disclaimer'.$j]),ENT_QUOTES)."', restaurant_id='".$_REQUEST['restaurant_edit_id']."',restaurant_name = '".htmlspecialchars(stripslashes($row_res_id['restaurant_name']),ENT_QUOTES)."'");
		$insert_id=mysql_insert_id();
		mysql_query("update restaurant_deals set certificate_no='00110-".$insert_id."' where id='".$insert_id."'");
	
		}
	}

	//mysql_query("insert into restaurant_disclaimer set restaurant_id='".$_REQUEST['restaurant_edit_id']."', disclaimer='".$_REQUEST['disclaimer']."'");
	
	$disclaimer_row=mysql_num_rows(mysql_query("SELECT * FROM restaurant_disclaimer WHERE restaurant_id='".$_REQUEST['restaurant_edit_id']."'"));
	if($disclaimer_row>0)
	{
		mysql_query("update restaurant_disclaimer set disclaimer='".$_REQUEST['disclaimer']."',description='".$_REQUEST['dis_description']."' WHERE restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
	}
	else{
	mysql_query("insert into restaurant_disclaimer set restaurant_id='".$_REQUEST['restaurant_edit_id']."', disclaimer='".$_REQUEST['disclaimer']."',description='".$_REQUEST['dis_description']."'");
	}
	
	
	header("location:restaurant.php?id=".$_REQUEST['restaurant_edit_id']."");
	
	}
	else{
		header("location:restaurant.php?id=".$_REQUEST['restaurant_edit_id']."&status=error");
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
</script>
<script type="text/javascript">
function validate()
{
	if(document.getElementById('photo1').value=="" && document.getElementById('photo2').value=="" && document.getElementById('photo3').value=="" && document.getElementById('photo4').value=="" && document.getElementById('photo5').value=="" && document.getElementById('photo6').value=="")
	{
		alert("Please select atleast one image");
		document.getElementById('photo1').focus();
		return false;
	}
		
	return true;
}


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

<?php
$sql_disclaimer=mysql_fetch_array(mysql_query("select * from restaurant_disclaimer where restaurant_id='".$_REQUEST['restaurant_edit_id']."'"));
?>
<?php
$sql_restaurant_name=mysql_fetch_array(mysql_query("select restaurant_name from restaurant_basic_info where id='".$_REQUEST['restaurant_edit_id']."'"));
?>
<div class="restaurant_body_cont spl_body_cont">

<div class="restaurant_cont_top">
<h1>Edit <?php echo stripslashes($sql_restaurant_name['restaurant_name'])?></h1>
</div>

<div class="restaurant_nav">
                    
                    
                    <ul>
                     <li><a href="edit_restaurant.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Basic Info</a></li>
                    <li><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Additional Info</a></li>
                    <li><a href="edit_restaurant_menu.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Menu</a></li>
                    <li><a href="edit_multimedia.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Multimedia</a></li>
                    <li><a href="edit_special_offer.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="active7">Special Offer</a></li>
                    <li><a href="edit_confirmation.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Confirmation</a></li>
                    
                    
                    </ul>
                    
                    </div>
<?php $basic_info_for_disclaimer=mysql_fetch_array(mysql_query("select * from restaurant_disclaimer where restaurant_id='".$_REQUEST['restaurant_edit_id']."'"));?>
<div class="restaurant_cont_field spl_additional_cont_field">
<form name="myfrm"  method="post" enctype="multipart/form-data">
<?php if($_REQUEST['success']==1){?>
<p style="text-align:center;">Coupon updated successfully</p>
<?php } else if($_REQUEST['success']==2){ ?>
<p style="text-align:center;">Coupon deleted successfully</p>
<?php } else if($_REQUEST['success']==3){ ?>
<p style="text-align:center;">Deals updated successfully</p>
<?php } else if($_REQUEST['success']==4){ ?>
<p style="text-align:center;">Deals deleted successfully</p>
<?php } ?>

<?php
	$randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	$randomString1 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	$randomString2 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
	$randomString3 = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
?>
<div class="restaurant_form_field">

<h1>Coupons</h1>

<div class="clear"></div>

<p>Coupon Deals* :</p>

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

<p>Coupon Name* :</p>

<input name="coupon_name1" type="text" class="restaurant" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price1" id="coupon_price1" onKeyUp="disable_coupon_percent1()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" onBlur="check_order_coupon_price1()" />

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

<input name="minimum_order_amount1" id="minimum_order_amount1" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" onBlur="check_order_amount1()" />

<div class="clear"></div>

<p>Coupon Code* :</p>

<input name="coupon_code1" id="coupon_code1" type="text" class="restaurant coupon_code" value="<?php echo $randomString; ?>" onKeyUp="check_coupon_code(this.value, '<?php echo $_REQUEST['restaurant_edit_id']; ?>',1);" />

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

<input name="coupon_print1" id="coupon_print1" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>No. of times Apply Coupon* :</p>

<input name="apply_coupon1" id="apply_coupon1" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Reappear Date :</p>

<input name="reappear_date1" id="reappear_date1" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>


<p>Picture :</p>

<input name="coupon_picture1" type="file" class="restaurant_browse" />
<div class="clear"></div>
<span class="restaurant_browse_span" style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="clear"></div>

<h1>Coupon 1</h1>

<div class="clear"></div>

<p>Coupon Deals* :</p>

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

<p>Coupon Name* :</p>

<input name="coupon_name2" type="text" class="restaurant" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price2" id="coupon_price2" type="text" onKeyUp="disable_coupon_percent2()" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" onBlur="check_order_coupon_price2()" />

<div class="clear"></div>

<p>Discount Percentage* :</p>

<input name="discount_percent2" id="discount_percent2" onKeyUp="disable_coupon_price2()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>


<p>Start Date* :</p>

<input name="start_date2" id="start_date2" type="text" class="restaurant start_date" readonly />

<div class="clear"></div>

<p>End Date* :</p>

<input name="end_date2" id="end_date2" type="text" class="restaurant end_date" readonly />

<div class="clear"></div>

<p>Minimum Order Amount* :</p>

<input name="minimum_order_amount2" id="minimum_order_amount2" type="text" onBlur="check_order_amount2()"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" />

<div class="clear"></div>

<p>Coupon Code* :</p>

<input name="coupon_code2" id="coupon_code2" type="text" class="restaurant coupon_code"  value="<?php echo $randomString1; ?>"  onKeyUp="check_coupon_code(this.value,'<?php echo $_REQUEST['restaurant_edit_id']; ?>',2);" />

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
<div class="clear"></div>
<span class="restaurant_browse_span" style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="clear"></div>

<h1>Coupon 2</h1>

<div class="clear"></div>
<p>Coupon Deals* :</p>
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

<p>Coupon Name* :</p>

<input name="coupon_name3" type="text" class="restaurant" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price3" id="coupon_price3" type="text" onKeyUp="disable_coupon_percent3()" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" onBlur="check_order_coupon_price3()" />

<div class="clear"></div>

<p>Discount Percentage* :</p>

<input name="discount_percent3" id="discount_percent3" onKeyUp="disable_coupon_price3()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<p>Start Date* :</p>

<input name="start_date3" id="start_date3" type="text" class="restaurant start_date" readonly />

<div class="clear"></div>

<p>End Date* :</p>

<input name="end_date3" id="end_date3" type="text" class="restaurant end_date" readonly />

<div class="clear"></div>

<p>Minimum Order Amount* :</p>

<input name="minimum_order_amount3" id="minimum_order_amount3" type="text"  onkeypress="return goodchars(event,'1234567890.');" class="restaurant" onBlur="check_order_amount3()" />

<div class="clear"></div>

<p>Coupon Code* :</p>

<input name="coupon_code3" id="coupon_code3" type="text" class="restaurant coupon_code"  value="<?php echo $randomString2; ?>"  onKeyUp="check_coupon_code(this.value,'<?php echo $_REQUEST['restaurant_edit_id']; ?>',3);" />

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
<div class="clear"></div>
<span class="restaurant_browse_span" style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="clear"></div>

<h1>Coupon 3</h1>

<div class="clear"></div>

<p>Coupon Deals* :</p>
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

<p>Coupon Name* :</p>

<input name="coupon_name4" type="text" class="restaurant" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price4" id="coupon_price4" type="text" onKeyUp="disable_coupon_percent4()" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" onBlur="check_order_coupon_price4()" />

<div class="clear"></div>

<p>Discount Percentage* :</p>

<input name="discount_percent4" id="discount_percent4" onKeyUp="disable_coupon_price4()" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"/>

<div class="clear"></div>

<p>Start Date* :</p>

<input name="start_date4" id="start_date4" type="text" class="restaurant start_date" readonly />

<div class="clear"></div>

<p>End Date* :</p>

<input name="end_date4" id="end_date4" type="text" class="restaurant end_date" readonly />

<div class="clear"></div>

<p>Minimum Order Amount* :</p>

<input name="minimum_order_amount4" id="minimum_order_amount4" type="text" onKeyPress="return goodchars(event,'1234567890.');" class="restaurant" onBlur="check_order_amount4()" />

<div class="clear"></div>

<p>Coupon Code* :</p>

<input name="coupon_code4" id="coupon_code4" type="text" class="restaurant coupon_code"  value="<?php echo $randomString3; ?>" onKeyUp="check_coupon_code(this.value,'<?php echo $_REQUEST['restaurant_edit_id']; ?>',4);"  />

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
<div class="clear"></div>
<span class="restaurant_browse_span" style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

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

<h1>Daily Deals </h1>

<div class="clear"></div>

<p>Daily Deals* :</p>

<input name="daily_deals1" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals1" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily Description* :</p>

<input name="daily_name1" type="text" class="restaurant" />

<div class="clear"></div>

<p>Price* :</p>

<input name="daily_description1" type="text" class="restaurant" />

<div class="clear"></div>

<p>Your Price* :</p>

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

<div class="clear"></div>

<p>Disclaimer Description :</p>

<textarea name="disclaimer1" id="disclaimer1" rows="5" cols="25"></textarea>

<div class="clear"></div>


<h1>Daily Deals - 1</h1>

<div class="clear"></div>

<p>Daily Deals* :</p>

<input name="daily_deals2" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals2" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily Description* :</p>

<input name="daily_name2" type="text" class="restaurant" />

<div class="clear"></div>

<p>Price* :</p>

<input name="daily_description2" type="text" class="restaurant" />

<div class="clear"></div>

<p>Your Price* :</p>

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

<div class="clear"></div>

<p>Disclaimer Description :</p>

<textarea name="disclaimer2" id="disclaimer2" rows="5" cols="25"></textarea>

<div class="clear"></div>


<h1>Daily Deals - 2</h1>

<div class="clear"></div>

<p>Daily Deals* :</p>

<input name="daily_deals3" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals3" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily Description* :</p>

<input name="daily_name3" type="text" class="restaurant" />

<div class="clear"></div>

<p>Price* :</p>

<input name="daily_description3" type="text" class="restaurant" />

<div class="clear"></div>

<p>Your Price* :</p>

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

<div class="clear"></div>

<p>Disclaimer Description :</p>

<textarea name="disclaimer3" id="disclaimer3" rows="5" cols="25"></textarea>

<div class="clear"></div>


<h1>Daily Deals - 3</h1>

<div class="clear"></div>

<p>Daily Deals* :</p>

<input name="daily_deals4" type="radio" value="1" class="radio_section"/>
<p class="restaurant_radio_field">Yes</p>
<input name="daily_deals4" type="radio" value="0" class="radio_section"/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Daily Name* :</p>

<input name="daily_name4" type="text" class="restaurant" />

<div class="clear"></div>

<p>Daily Price* :</p>

<input name="daily_price4" type="text" class="restaurant" />

<div class="clear"></div>

<p>Daily Description* :</p>

<input name="daily_description4" type="text" class="restaurant" />

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

<div class="clear"></div>

<p>Disclaimer Description :</p>

<textarea name="disclaimer4" id="disclaimer4" rows="5" cols="25"></textarea>

<div class="clear"></div>


<input class="button4 edit_submit" type="submit" value="Save & Continue" name="submit">

</div>

<div class="clear"></div>
</form>

<?php 
$sql_deals = mysql_query("SELECT * FROM restaurant_coupon WHERE restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
if(mysql_num_rows($sql_deals)>0){?>
<div style="width:970px; margin:0 auto;">
<h3>Coupon List</h3>
<table width="98%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:10px;" align="center">
  <tr>
    <th width="22%" class="all_restaurant">Coupon Name</th>
    <th width="18%" class="all_restaurant">Coupon Code</th>
    <th width="18%" class="all_restaurant">Coupon Discount (%)</th>
    <th width="18%" class="all_restaurant">Coupon Discount  Price</th>
    <th width="20%" class="all_restaurant">Coupon Deals</th>
    <th width="20%" class="all_restaurant">Online Status</th>
    <th width="21%" class="all_restaurant">Action</th>
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
    <td class="all_restaurant2"><a href="edit_daily_coupon1.php?coupon_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit">Edit</a>&nbsp;<a href="edit_special_offer.php?action=del&del_coupon_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit" onClick="return confirm('Are you sure you want to delete this coupon deals?');">Delete</a></td>
  </tr>
<?php } ?>
</table></div>
<?php
}
?>

<?php 
$sql_deals = mysql_query("SELECT * FROM restaurant_deals WHERE restaurant_id='".$_REQUEST['restaurant_edit_id']."'");
if(mysql_num_rows($sql_deals)>0){?>
<div style="width:970px; margin:20px auto;">
<h3>Daily Deals List</h3>
<table width="98%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:10px;" align="center">
  <tr>
    <th width="22%" class="all_restaurant">Daily Description</th>
    <th width="20%" class="all_restaurant">Price ($)</th>
    <th width="18%" class="all_restaurant">Your Price ($)</th>
    <th width="21%" class="all_restaurant">Action</th>
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
    <td class="all_restaurant2"><a href="edit_daily_deals.php?deals_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit">Edit</a>&nbsp;<a href="edit_special_offer.php?action=del&del_deal_id=<?php echo $array_deals['id']?>&restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="all_edit" onClick="return confirm('Are you sure you want to delete this daily deals?');">Delete</a></td>
  </tr>
<?php } ?>
</table></div>
<?php
}
?>



</div>

</div>

</div>
<!--<div class="body_footer_bg"></div>-->
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<?php include("includes/footer_new.php"); ?>
