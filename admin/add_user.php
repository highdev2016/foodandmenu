<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
		
		$data = array( 
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
						);
		
		$user_id = createUser($data);
		$sent_mail_status = sendMailToUser($email_data);
			
		if( isset($user_id) && $user_id!='' )
		$errors = "User created successfully with <br />Email ID: <b>".trim($_REQUEST['email'])."</b>  password: <b>". trim($_REQUEST['userpass'])."</b>";
	}
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
	if(document.getElementById('userpass').value==''){
		txt+='Please Enter Password\n';
	}
	if(document.getElementById('user_type').value==''){
		txt+='Please Select User Type\n';
	}
	if(document.getElementById('user_status').value==''){
		txt+='Please Select User Status\n';
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
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add New Restaurant</h2>
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
    <td class="normaltext"><input name="user_full_name" id="user_full_name" type="text" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
   <td class="text1" align="right">Email<font color="#FF0000">*</font>:</td>
   <td class="normaltext"><input name="email" id="email" type="text" class="login_ipboxin"  value="" onblur="email_exists(this.value);"></td>
  </tr>
  <?php /*?><tr>
   <td class="text1" align="right">Username<font color="#FF0000">*</font>:</td>
   <td class="normaltext"><input name="username" id="username" type="text" class="login_ipboxin"  value=""></td>
  </tr><?php */?>
  <tr>
   <td class="text1" align="right">Password<font color="#FF0000">*</font>:</td>
   <td class="normaltext"><input name="userpass" id="userpass" type="password" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Type<font color="#FF0000">*</font>:</td>
    <td class="normaltext">
        <select class="select_box" id="user_type" name="user_type">
            <option value="">--Select--</option>
            <option value="restaurant">Restaurant</option>
            <option value="user">User</option>
            <option value="vendor">Vendor</option>
        </select>    
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">Status<font color="#FF0000">*</font>:</td>
    <td class="normaltext">
        <select class="select_box" id="user_status" name="user_status">
            <option value="">--Select--</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>    
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
require_once"functions.php";
require_once"template_admin.php";
?>