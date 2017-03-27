<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
rest_chk_authentication();
//print_r($_SESSION);
if(count($_POST)>0 && $_REQUEST['submit']=="Reply")
	{
		$sql_review=mysql_fetch_array(mysql_query("SELECT * from restaurant_reviews where id='".$_REQUEST['review_hid']."'"));
		
		$sql_update = mysql_query("UPDATE restaurant_reviews SET rest_owner_reply = 1 WHERE id = '".$_REQUEST['review_hid']."'");
		
			 $cms_rep1 = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$sql_review['customer_name'].',</p>
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Thanks for your valuable feedback</p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$_REQUEST['content'].'</p>
             			<div style="clear:both;"></div>

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

				</div>';
	$email= $_REQUEST['title']; 
	
	$from = 'support@foodandmenu.com';
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message1=$cms_rep1;
	
	$subject1="Email from food and menu";
	
	mail($email,$subject1,$message1,$headers);
	header("location:my_reviews.php?reply=1");
	}

?>

<script language="javascript" type="text/javascript">
function validate()
{
	if(document.frmchangpass.content.value=="")
	{
		alert('Please enter some content');
		document.frmchangpass.content.focus();
		return false;
	}
    return true;
}
</script>

<body>

<?php include ("includes/menu_res_add_user.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<?php include ("includes/manage_live_order_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">
<?php $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_REQUEST['customer_id']."'")); ?>

<form name="frmchangpass" action="" method="post" onSubmit="return validate()" enctype="multipart/form-data">
<input name="review_hid" id="review_hid" type="hidden"  value="<?php echo $_REQUEST['review_id']?>" >
<input name="title" id="title" type="hidden" class="restaurant" style="height:25px;"  value="<?php echo $sql_customer['email']?>">
<table width="99%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <tr>
    <td  align="right" style="width:40%">Send To :</td>
    <td><input name="name" id="name" type="text" class="restaurant" style="height:25px;"  value="<?php echo $sql_customer['firstname']." ".$sql_customer['lastname']; ?>" readonly="readonly"></td>
  </tr>
   <tr>
    <td  align="right" valign="top" style="width:40%;">Content <font color="#FF0000">*</font>:</td>
    <td><textarea cols="20" name="content" rows="5" style="border:1px solid #B5ABC6; border-radius: 2px; width: 500px; height: 135px;" ></textarea></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td><input name="submit" type="submit" value="Reply" class="button4" style="margin-left:0px;"></td>
  </tr>
</table>
</form>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

