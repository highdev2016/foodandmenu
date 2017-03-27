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

<body>

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>


<?php
if(count($_POST)>0 && $_REQUEST['submit']=="Save & Continue")
{
	
		
		
			mysql_query("update restaurant_disclaimer set disclaimer='".$_REQUEST['disclaimer']."'  where id='".$_REQUEST['disclaimer_hid']."'");
			
		
		
		header("location:edit_special_offer.php?restaurant_edit_id=".$_REQUEST['restaurant_edit_id']."");
		

}
?>
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
</script>

<link rel="stylesheet" href="calender/jquery-ui.css" />
<script src="calender/jquery-1.8.3.js"></script>
<script src="calender/jquery-ui.js"></script>
<script>
$(function() {
	$( "#expiry_date" ).datepicker({
		dateFormat:"mm-dd-yy"
	});
	
	//$( "#post_date" ).datepicker( "dd-mm-yy", "dateFormat" );
});
</script>
<?php
$select_disclaimer=mysql_fetch_array(mysql_query("select * from restaurant_disclaimer where id='".$_REQUEST['disclaimer_id']."'"));
?>
<div class="body_section">
<?php

$basic_info=mysql_fetch_array(mysql_query("select restaurant_name from restaurant_basic_info where id='".$_REQUEST['restaurant_edit_id']."'"));
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
                     <li><a href="edit_restaurant.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Basic Info</a></li>
                    <li><a href="edit_additional.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Additional Info</a></li>
                    <li><a href="edit_restaurant_menu.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Menu</a></li>
                    <li><a href="edit_multimedia.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Multimedia</a></li>
                    <li><a href="edit_special_offer.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" class="active7">Special Offer</a></li>
                    <li><a href="edit_confirmation.php?restaurant_edit_id=<?php echo $_REQUEST['restaurant_edit_id']?>" >Confirmation</a></li>
                    
                    
                    </ul>
                    
                    </div>

<div class="restaurant_cont_field">
<form name="myfrm" method="post" enctype="multipart/form-data">


<div class="restaurant_form_field" style="padding-left:250px;">

<h1 style="padding-left:150px;">Disclaimer </h1>

<div class="clear"></div>



<p>Disclaimer* :</p>

<input name="disclaimer" type="text" class="restaurant" value="<?php echo $select_disclaimer['disclaimer']?>" />
<input name="disclaimer_hid" type="hidden" class="restaurant" value="<?php echo $select_disclaimer['id']?>" />

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
