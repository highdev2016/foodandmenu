<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
		$sql_review=mysql_fetch_array(mysql_query("select customer from restaurant_reviews where id='".$_REQUEST['review_hid']."'"));
		
			 $cms_rep1 = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="https://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$sql_review['custmer_name'].',</p>
							
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
			header("location:review_reply.php?success=1");
	}
?>
<div class="dashboard_section_in">

<script language="javascript" type="text/javascript">
function validate()
{
	if(document.getElementById('title').value=='')
	{
		alert ('Please enter title');
		document.getElementById('title').focus();
		return false;
	}
	if(document.getElementById('content').value=="")
	{
		alert('Please enter some content');
		document.getElementById('content').focus();
		return false;
	}
    return true;
}
</script>
<?php
$sql_customer=mysql_fetch_array(mysql_query("select id,email from restaurant_customer where id='".$_REQUEST['customer_id']."'"));
?>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Reply To Customer</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
            	<table width="85%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Send To <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="title" id="title" type="text" class="login_ipboxin" style="height:25px;"  value="<?php echo $sql_customer['email']?>" readonly="readonly"><input name="review_hid" id="review_hid" type="hidden"  value="<?php echo $_REQUEST['review_id']?>" ></td>
  </tr>
   <tr>
    <td class="text1" align="right" valign="top">Content <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea cols="63" id="content" name="content" rows="5" ></textarea>
   
</td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Add" class="normalbutton"></td>
  </tr>
</table>
</form>
</div>
<?php

}
require_once"template_admin.php";
?>