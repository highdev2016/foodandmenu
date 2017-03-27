<?php
ob_start();
session_start();
 include ("includes/header_vendor.php");?>
<?php include ("admin/lib/conn.php");?>
<?php include ("image_file.php");?>

<body>

<?php include ("includes/menu_admin_add_res.php");?>


<?php

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


if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	if($_FILES['daily_picture']!="")
		{
		$video_image1=$_FILES['daily_picture']['name'];
		//$video_image = time().preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '_', $video_image1);
	    //$video_image=time().$video_image;
		$video_image11 = preg_replace('/[^a-zA-Z0-9_\.-]/s', '_', $video_image1);
		$video_image_name = str_replace(' ','_',$video_image11);
		$video_image=time().$video_image_name;
		
		if ((($_FILES["daily_picture".$j]["type"] == "image/gif")
		  || ($_FILES["daily_picture".$j]["type"] == "image/png")
		  || ($_FILES["daily_picture".$j]["type"] == "image/bmp")
		  || ($_FILES["daily_picture".$j]["type"] == "image/jpg")
		  || ($_FILES["daily_picture".$j]["type"] == "image/jpeg")
		  || ($_FILES["daily_picture".$j]["type"] == "image/pjpeg")))
		  
		{
			
			$picture_url="uploaded_images/".$video_image;
			LIB_StoreUploadImg($post_file_name="daily_picture"
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="425"
								,$file_to_copy_height="300"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
			
			$picture_url_thumb="thumb_images/".$video_image;
			LIB_StoreUploadImg($post_file_name="daily_picture"
								,$file_to_copy_path="$picture_url_thumb"
								,$file_to_copy_width="100"
								,$file_to_copy_height="75"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
								
		
}

		}
		
		if($_FILES['daily_picture']['name']!=""){	
		mysql_query("update restaurant_coupon set coupon_status='".$_REQUEST['coupon_deal']."',coupon_name='".$_REQUEST['coupon_name']."', coupon_price = '".$_REQUEST['coupon_price']."',  discount =  '".$_REQUEST['discount_percent']."', start_date = '".change_dateformat($_REQUEST['start_date'])."' , end_date = '".change_dateformat($_REQUEST['end_date'])."' ,coupon_description='".$_REQUEST['coupon_description']."',coupon_image='".$video_image."', minimum_order_amount = '".$_REQUEST['minimum_order_amount']."' , show_coupon = '".$_REQUEST['show_coupon']."' , show_coupon_code = '".$_REQUEST['show_coupon_code']."' , online_redeem = '".$_REQUEST['online_status']."' where id='".$_REQUEST['deals_hid']."'");
		
		}
		else{
			
			mysql_query("update restaurant_coupon set coupon_status='".$_REQUEST['coupon_deal']."',coupon_name='".$_REQUEST['coupon_name']."', coupon_price = '".$_REQUEST['coupon_price']."',  discount =  '".$_REQUEST['discount_percent']."', start_date = '".change_dateformat($_REQUEST['start_date'])."' , end_date = '".change_dateformat($_REQUEST['end_date'])."' ,coupon_description='".$_REQUEST['coupon_description']."', minimum_order_amount = '".$_REQUEST['minimum_order_amount']."'  , show_coupon = '".$_REQUEST['show_coupon']."' , show_coupon_code = '".$_REQUEST['show_coupon_code']."' , online_redeem = '".$_REQUEST['online_status']."' where id='".$_REQUEST['deals_hid']."'");
			
		}
		
		header("location:admin_special_offer.php?success=2");
		

}
?>

<link rel="stylesheet" href="calender/jquery-ui.css" />
<script src="calender/jquery-1.8.3.js"></script>
<script src="calender/jquery-ui.js"></script>
<script type="text/javascript">
function validate()
{
	if(document.getElementById('photo1').value=="" && document.getElementById('photo2').value=="" && document.getElementById('photo3').value=="" && document.getElementById('photo4').value=="" && document.getElementById('photo5').value=="" && document.getElementById('photo6').value=="")
	{
		alert("Please select atleast one image");
		document.getElementById('photo1').focus();
		return false;
	}
	
	//if(document.getElementById('video1').value=="" && document.getElementById('video2').value=="" && document.getElementById('video3').value=="" && document.getElementById('video4').value=="" && document.getElementById('video5').value=="")
//	{
//		alert("Please enter atleast one video");
//		document.getElementById('video1').focus();
//		return false;
//	}
	
	
	return true;
}

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

</script>

<script type="text/javascript">

var $j = jQuery.noConflict();

$j(document).ready(function() {
	var enq_dat = new Date();
	$j(window).on('load',function() {
	  $j('#end_date').datepicker('option', 'minDate', enq_dat);
	});	  
});
$j(function()
{
    $j('#start_date').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function(dateStr) {
		  var date = $j(this).datepicker('getDate');		  
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $j('#end_date').datepicker('option', 'minDate', date);
		}
      });
      $j('#end_date').datepicker({
		changeMonth: true,
        changeYear: true,
		dateFormat:"mm-dd-yy",
		onSelect: function (selectedDate) {
		  var date = $j(this).datepicker('getDate');
		  if (date) {
				date.setDate(date.getDate());
		  }
		  $j('#start_date').datepicker('option', 'maxDate', date || 0);
		}
      });
});



</script>

<script type="text/javascript">
function disable_coupon_percent()
{
	var $j = jQuery.noConflict();
	
	var coupon_price = $j("#coupon_price").val();
	
	if(coupon_price != '')
	{
		$j("#discount_percent").val('');
		$j("#discount_percent").prop('disabled', true);
	}
	else
	{
		$j("#discount_percent").prop('disabled', false);
	}
}

function disable_coupon_price()
{
	var $j = jQuery.noConflict();
	
	var coupon_percent = $j("#discount_percent").val();
	
	if(coupon_percent != '')
	{
		$j("#coupon_price").val('');
		$j("#coupon_price").prop('disabled', true);
	}
	else
	{
		$j("#coupon_price").prop('disabled', false);
	}
}

function check_order_amount()
{
	var $j = jQuery.noConflict();
	
	if($j("#coupon_price").prop('disabled', false))
	{
		var coupon_price = $j("#coupon_price").val();
		var order_amount = $j("#minimum_order_amount").val();
		
		if(parseFloat(order_amount) <= parseFloat(coupon_price))
		{
			alert("Minimum Order Amount must be greater than Coupon Price");
			$j("#minimum_order_amount").val('');
			$j("#minimum_order_amount").focus();
		}
		
	}
	else
	{
		return true;
	}
	
}

function check_order_coupon_price()
{
	var $j = jQuery.noConflict();
	var order_amount = $j("#minimum_order_amount").val();
	var discount_percent = $j("#discount_percent").val();
	
	if(order_amount != '')
	{
		var coupon_price = $j("#coupon_price").val();
		
		if(parseFloat(coupon_price) >= parseFloat(order_amount))
		{
			alert("Coupon Price must be less than Minimum Order Amount");
			$j("#coupon_price").val('');
			$j("#coupon_price").focus();
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

function check_coupon_code(code,res_id,coupon_id){

	var $j = jQuery.noConflict();
	
	$j.ajax({
		url : 'check_coupon_code_edit.php',
		type : 'POST',
		data : 'code=' + code + '&res_id=' + res_id + '&coupon_id=' + coupon_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			
			if(data == 'Exists'){
				$j("#err_cd").slideDown(1000);
				$j("#coupon_code").val('');
			}else{
				$j("#err_cd").slideUp(1000);
			}
			
	
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});

}

var $j = jQuery.noConflict();
$j(document).ready(function() {
 $j('.coupon_code').bind('copy paste',function(e) { 
 e.preventDefault(); //disable cut,copy,paste
 });
});

</script>

<?php
$select_deals=mysql_fetch_array(mysql_query("select * from restaurant_coupon where id='".$_REQUEST['coupon_id']."'"));
?>
<div class="body_section">
<?php

$basic_info=mysql_fetch_array(mysql_query("select restaurant_name from restaurant_basic_info where id='".$_SESSION['rest_id']."'"));
?>
<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top">
<h1>Edit <?php echo stripslashes($basic_info['restaurant_name'])?></h1>
</div>

<div class="restaurant_nav">
                    
                    <ul>
                    <li><a href="add_admin_restaurant.php">Basic Info</a></li>
                    <li><a href="admin_additional.php">Additional Info</a></li>
                    <li><a href="admin_restaurant_menu.php">Menu</a></li>
                    <li><a href="admin_multimedia.php">Multimedia</a></li>
                    <li><a href="admin_special_offer.php" class="active7">Special Offer</a></li>
                    <li><a href="admin_confirmation.php">Confirmation</a></li>
                    </ul>
                    
                    </div>

<div class="restaurant_cont_field">
<form name="myfrm" method="post" enctype="multipart/form-data">


<div class="restaurant_form_field" style="padding-left:250px;">

<h1 style="padding-left:150px;">Coupons</h1>

<div class="clear"></div>

<p>Coupon Deals* :</p>

<input name="coupon_deal"  type="radio" value="1" class="radio_section" <?php if($select_deals['coupon_status']==1){?> checked <?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="coupon_deal" type="radio" value="0" class="radio_section" <?php if($select_deals['coupon_status']==0){?> checked <?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon* :</p>

<input name="show_coupon"  type="radio" value="1" class="radio_section" <?php if($select_deals['show_coupon']==1){?> checked <?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon" type="radio" value="0" class="radio_section" <?php if($select_deals['show_coupon']==0){?> checked <?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Show Coupon Code* :</p>

<input name="show_coupon_code"  type="radio" value="1" class="radio_section" <?php if($select_deals['show_coupon_code']==1){?> checked <?php }?>/>
<p class="restaurant_radio_field">Yes</p>
<input name="show_coupon_code" type="radio" value="0" class="radio_section" <?php if($select_deals['show_coupon_code']==0){?> checked <?php }?>/>
<p class="restaurant_radio_field">No</p>

<div class="clear"></div>

<p>Coupon Name* :</p>

<input name="coupon_name" type="text" class="restaurant" value="<?php echo $select_deals['coupon_name']?>" />

<div class="clear"></div>

<p>Coupon Price* :</p>

<input name="coupon_price" id="coupon_price" onKeyUp="disable_coupon_percent()" type="text" class="restaurant" value="<?php echo $select_deals['coupon_price']?>" onKeyPress="return goodchars(event,'1234567890.');"  onBlur="check_order_coupon_price();" />

<div class="clear"></div>


<p>Discount Percentage* :</p>

<input name="discount_percent" id="discount_percent" onKeyUp="disable_coupon_price()" type="text" class="restaurant" value="<?php echo $select_deals['discount']?>" onKeyPress="return goodchars(event,'1234567890.');" />

<div class="clear"></div>

<p>Start Date* :</p>

<input name="start_date" id="start_date" type="text" class="restaurant start_date" readonly value="<?php echo date("m-d-Y", strtotime($select_deals['start_date']));?>" />

<div class="clear"></div>

<p>End Date* :</p>

<input name="end_date" id="end_date" type="text" class="restaurant end_date" readonly value="<?php echo date("m-d-Y", strtotime($select_deals['end_date']));?>" />

<div class="clear"></div>

<p>Minimum Order Amount* :</p>

<input name="minimum_order_amount" id="minimum_order_amount" type="text" class="restaurant" value="<?php echo $select_deals['minimum_order_amount']?>" onKeyPress="return goodchars(event,'1234567890.');" onBlur="check_order_amount()" />

<div class="clear"></div>

<p>Coupon Code* :</p>

<input name="coupon_code" id="coupon_code" type="text" class="restaurant coupon_code" value="<?php echo $select_deals['coupon_code']?>" onKeyUp="check_coupon_code(this.value, '<?php echo $_REQUEST['restaurant_edit_id']; ?>','<?php echo $_REQUEST['coupon_id']; ?>');" />

<div class="clear"></div>

<div id="err_cd" style="color:#ff0000; margin-left:167px; margin-bottom:10px; display:none;"> The Coupon Code Already Exists. </div>


<p>Coupon Description* :</p>

<textarea name="coupon_description" cols="25" rows="5" ><?php echo $select_deals['coupon_description']?></textarea>

<div class="clear"></div>

<p>Online Status* :</p>

<input name="online_status"  type="radio" value="1" class="radio_section" <?php if($select_deals['online_redeem'] == 1){ ?> checked <?php } ?>/>
<p class="restaurant_radio_field">Online</p>
<input name="online_status" type="radio" value="0" class="radio_section" <?php if($select_deals['online_redeem'] == 0){ ?> checked <?php } ?>/>
<p class="restaurant_radio_field">Offline</p>

<div class="clear"></div>

<p>Picture :</p>

<input name="daily_picture" type="file" class="restaurant_browse" />
<span style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>
<input type="hidden" name="deals_hid" value="<?php echo $select_deals['id']?>">
<?php
if($select_deals['coupon_image']!="")
{
?>
<img src="uploaded_images/<?php echo $select_deals['coupon_image']?>" height="40" width="40" >
<?php
}
?>

<div class="clear"></div>

<input class="button4" type="submit" value="Save & Continue" name="submit">

</div>

<div class="clear"></div>
</form>


</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<script type="text/javascript">
<?php if($select_deals['coupon_price'] == 0.00){ ?>
disable_coupon_price();
<?php }else{ ?>
disable_coupon_percent();
<?php }?>
</script>