<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Update")
	{
		
		if($_REQUEST['userpass']!=''){
					$data = array( 
						'user_nicename' => mysql_real_escape_string(trim($_REQUEST['user_full_name'])),
						'user_status' => trim($_REQUEST['user_status']),
						'display_name' => mysql_real_escape_string(trim($_REQUEST['user_full_name'])),
						'user_type' => mysql_real_escape_string(trim($_REQUEST['user_type'])),
						'user_pass' => md5($_REQUEST['userpass'])
						);
		}
		else {
			$data = array( 
						'user_nicename' => mysql_real_escape_string(trim($_REQUEST['user_full_name'])),
						'user_status' => trim($_REQUEST['user_status']),
						'display_name' => mysql_real_escape_string(trim($_REQUEST['user_full_name'])),
						'user_type' => mysql_real_escape_string(trim($_REQUEST['user_type']))
						);
		}
		/*$data = array( 
						'user_login' => '',
						'user_pass' => md5(trim($_REQUEST['userpass'])),
						'user_nicename' => mysql_real_escape_string(trim($_REQUEST['user_full_name'])),
						'user_email' => mysql_real_escape_string(trim($_REQUEST['email'])),
						'user_url' => '',
						'user_registered' => date('Y-m-d H:i:s'),
						'user_activation_key' => '',
						'user_status' => trim($_REQUEST['user_status']),
						'display_name' => mysql_real_escape_string(trim($_REQUEST['user_full_name'])),
						'user_type' => mysql_real_escape_string(trim($_REQUEST['user_type'])),
						);
		$email_data = array( 
						'user_login' => '',
						'user_pass' => trim($_REQUEST['userpass']),
						'user_nicename' => mysql_real_escape_string(trim($_REQUEST['user_full_name'])),
						'user_email' => mysql_real_escape_string(trim($_REQUEST['email'])),
						'user_url' => '',
						'user_registered' => date('Y-m-d H:i:s'),
						'user_activation_key' => '',
						'user_status' => trim($_REQUEST['user_status']),
						'display_name' => mysql_real_escape_string(trim($_REQUEST['user_full_name'])),
						'user_type' => mysql_real_escape_string(trim($_REQUEST['user_type'])),
						);*/
		
		$user_status = updateUser($data, trim($_REQUEST['hid']));
		//$sent_mail_status = sendMailToUser($email_data);
			
		if( $user_status )
		$errors = "User updated successfully";
	}
	
	if($_REQUEST['userpass']!=''){
		 $sql_select = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_admin WHERE id = 1"));

	$email=$_REQUEST['email'];
	
	$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:65px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px;" />

  <div style="height:15px; background-color:#3F4CA0;"></div>
       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$_REQUEST['user_full_name'].',</p>

            				<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Your restaurant login password for food & menu is Changed.
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">New Password : '.$_REQUEST['userpass'].'</p>

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
	
	$from = $sql_select['email_id'];
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	$subject="Password Changed";
	
	mail($email,$subject,$message,$headers);
	}
	
	//$sql_rest_user = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_vendors WHERE id='".$_REQUEST['id']."'"));
	$sql_rest_user = getRestaurant_User($_REQUEST['id']);
	//echo '<pre>';
	//print_r($sql_rest_user);
	

?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
function validate()
{
	var txt = '';
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	if(document.getElementById('user_full_name').value==''){
		txt+='Please Enter Your Name\n';
	}
	if(document.getElementById('email').value==''){
		txt+='Please Enter Email\n';
	}
	if( document.getElementById('email').value!='' && !emailPattern.test( document.getElementById('email').value )){
		txt+='Please Enter Valid Email\n';
	}
	if(document.getElementById('user_type').value==''){
		txt+='Please Select User Type\n';
	}
	if(document.getElementById('user_status').value==''){
		txt+='Please Select User Status\n';
	}
		if(document.getElementById('userpass').value!='')
	{
		if(document.getElementById('confirm_password').value=='')
		{
		alert ('Please enter confirm password');
		document.getElementById('confirm_password').focus();
		return false;
		}
		if(document.getElementById('userpass').value!=document.getElementById('confirm_password').value)
		{
		alert ('Password mismatch');
		document.getElementById('confirm_password').value = '';
		document.getElementById('confirm_password').focus();
		return false;
		}		
	}
	if( txt!='' ){
		alert('Please fill up the mandatory fields :\n\n'+txt);
		return false;
	} else {
		return true;
	}
	
}

function email_exists(email) {
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	if( document.getElementById('email').value!='' && !emailPattern.test( document.getElementById('email').value )){
		alert('Please Enter Valid Email\n');
		return false;
	}else{

	//alert(email);
    var result= null;
    $.ajax({
		type: "POST",
        url: 'ajax/email.php',
        data: {email: email},
        success: function(data) {
            result = data;
			//alert(result);
			if(result > 0){
				alert('Email already exist');
				$('#email').val('');
				$('#email').focus();
				return false;
			}else{
				return true;
			}
			
        }
    });
	}
}
</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_user.php?page=<?php echo $_REQUEST['page']?>";
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Update Restaurant</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate()" enctype="multipart/form-data">
            	<table width="65%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <?phpif($errors!='')
  {?>
  <tr>
    <td width="46%" align="right"><img src="images/approve.jpg"></td>
    <td width="54%" class="msg"><?=$errors?></td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td class="text1" align="right">Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="user_full_name" id="user_full_name" type="text" class="login_ipboxin"  value="<?php echo $sql_rest_user['user_nicename']; ?>"></td>
  </tr>
  <tr>
   <td class="text1" align="right">Email<font color="#FF0000">*</font>:</td>
   <td class="normaltext"><input name="email" id="email" type="text" class="login_ipboxin"  value="<?php echo $sql_rest_user['user_email']; ?>" readonly="readonly"></td>
  </tr>
  <tr>
   <td class="text1" align="right">Password :</td>
   <td class="normaltext"><input name="userpass" id="userpass" type="password" class="login_ipboxin"  value=""></td>
  </tr>
   <tr>
   <td class="text1" align="right">Confirm Password :</td>
   <td class="normaltext"><input name="confirm_password" id="confirm_password" type="password" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Type<font color="#FF0000">*</font>:</td>
    <td class="normaltext">
        <select class="select_box" id="user_type" name="user_type">
            <option value="">--Select--</option>
            <option value="restaurant" <?php echo ($sql_rest_user['user_type'] == 'restaurant')? 'selected="selected"' : ''; ?>>Restaurant</option>
        </select>    
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">Status<font color="#FF0000">*</font>:</td>
    <td class="normaltext">
        <select class="select_box" id="user_status" name="user_status">
            <option value="">--Select--</option>
            <option value="1" <?php echo ($sql_rest_user['user_status'] == '1')? 'selected="selected"' : ''; ?>>Active</option>
            <option value="0" <?php echo ($sql_rest_user['user_status'] == '0')? 'selected="selected"' : ''; ?>>Inactive</option>
        </select>    
    </td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext">
    	<input name="hid" type="hidden" value="<?php echo $sql_rest_user['ID']; ?>">
    	<input name="submit" type="submit" value="Update" class="normalbutton">
        <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/>
    </td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"functions.php";
require_once"template_admin.php";
?>