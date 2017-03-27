<?php
function main()
{
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Add")
	{
			mysql_query("insert into  restaurant_admin_panel set  restaurant_id='".$_REQUEST['rest_name']."', state = '".$_REQUEST['state']."' , city = '".$_REQUEST['restaurant_city']."' , firstname = '".htmlspecialchars(stripslashes($_REQUEST['firstname']),ENT_QUOTES)."' , lastname = '".htmlspecialchars(stripslashes($_REQUEST['lastname']),ENT_QUOTES)."' , security_code = '".htmlspecialchars(stripslashes($_REQUEST['security_code']),ENT_QUOTES)."' , email_id='".$_REQUEST['email_id']."',password='".md5($_REQUEST['pwd'])."',status='Active'");
			
			$restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['rest_name']."'"));
			
			$site_url="https://foodandmenu.com";

			$email=$_REQUEST['email_id'];
			
			$url="<a href='$site_url/restaurant_admin_login.php'>$site_url/Restaurant Login" ."</a>";
			$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:111px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="https://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>
						
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">The Restaurant Admin panel credentials for the restaurant '.stripslashes($restaurant_name['restaurant_name']).' is given below .</p>
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Please click on the link below with your follwing credentials</p>

             			<div style="clear:both;"></div>
	 
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#04303d; margin:0 0 4px 15px;">Email: '.$email.'</p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#04303d; margin:0 0 4px 15px;">Password: '.$_REQUEST['pwd'].'</p>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#04303d; margin:0 0 4px 15px;">'.$url.'</p>

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

			$from = "support@foodandmenu.com";

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message=$cms_rep;

			$subject="Food&Menu Restaurant Admin Panel";

			mail($email,$subject,$message,$headers);
					
			$errors="Restaurant Admin Panel Created Successfully ";
	}
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
function checkMessenger(themail)
{
	var tomatch  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!tomatch.test(themail))
	{ 
	window.alert('Invalid Email Address');
	return false;
	}
	return true; 
}

function valide()
{
	if(document.getElementById('state').value=="")
	{
		alert("Please select state.");
		document.getElementById('state').focus();
		return false;
	}
	if(document.getElementById('restaurant_city').value=="")
	{
		alert("Please select city.");
		document.getElementById('restaurant_city').focus();
		return false;
	}
	if(document.getElementById('rest_name').value=="")
	{
		alert("Please select restaurant name.");
		document.getElementById('rest_name').focus();
		return false;
	}
	if(document.getElementById('firstname').value=="")
	{
		alert("Please select first name.");
		document.getElementById('firstname').focus();
		return false;
	}
	if(document.getElementById('email_id').value=="")
	{
		alert("Please enter email id");
		document.getElementById('email_id').focus();
		return false;
	}
	if(document.getElementById('security_code').value=="")
	{
		alert("Please select security code.");
		document.getElementById('security_code').focus();
		return false;
	}
	/*var x=document.forms["frmchangpass"]["email_id"].value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
	alert("Not a valid e-mail address");
	return false;
	}*/	
	
	if ((document.getElementById('email_id').value!="") && (checkMessenger(document.getElementById('email_id').value)==false))
	{
	document.getElementById('email_id').value="";
	document.getElementById('email_id').focus();
	return false;
	}
	if(document.getElementById('pwd').value=="")
	{
		alert("Please enter password");
		document.getElementById('pwd').focus();
		return false;
	}
	if(document.getElementById('conpwd').value=="")
	{
		alert("Please enter confirm password");
		document.getElementById('conpwd').focus();
		return false;
	}
	if(document.getElementById('pwd').value!=document.getElementById('conpwd').value)
	{
		alert("Password mismatch");
		document.getElementById('conpwd').value = '';
		document.getElementById('conpwd').focus();
		return false;
	}
	if(document.frm.val1.value=='REST_EXISTS')
	{
		alert('The restaurant name already exists!');
		return false;
	}
	if(document.frm.val.value=='EMPID_EXISTS')
	{
		alert('The employee ID already exists!');
		document.frm.emp_id.value='';
		document.frm.emp_id.focus();
		return false;
	}
	
    return true;
}

</script>

<script type="text/javascript">
function check_email(){
	
	$.ajax({
		type: "POST",
		data: {
			emp_id: $('#email_id').val(),
		},
		url: "get_rest_email.php",
		success: function(data)
		{
			//alert(data);
			if(data == 'EMPID_EXISTS')
			{
				 $('#user')
					.css('color', 'red')
					.html("This Email Id already exists!");  
					document.frm.val.value = 'EMPID_EXISTS';
			}
			else if(data == 'EMPID_AVAILABLE')
			{
				$('#user')
					.css('color', 'green')
					.html("Email Id available.");
					document.frm.val.value = 'EMPID_AVAILABLE';
			}
		}
	})	      
}

function check_security_code(){
	$.ajax({
		type: "POST",
		data: {
			security_code: $('#security_code').val(),
		},
		url: "get_security_code.php",
		success: function(data)
		{
			//alert(data);
			if(data == 'SEC_CODE_EXISTS')
			{
				 $('#sec_span')
					.css('color', 'red')
					.html("This Security Code already exists!");  
					document.frm.val_sec.value = 'SEC_CODE_EXISTS';
			}
			else if(data == 'SEC_CODE_AVAILABLE')
			{
				$('#sec_span')
					.css('color', 'green')
					.html("Security Code available.");
					document.frm.val_sec.value = 'SEC_CODE_AVAILABLE';
			}
		}
	})	      

}

function check_restaurant(){
	$.ajax({
		type: "POST",
		data: {
			rest_id: $('#rest_name').val(),
		},
		url: "get_rest_name.php",
		success: function(data)
		{
			//alert(data);
			if(data == 'REST_EXISTS')
			{
				 $('#user1')
					.css('color', 'red')
					.html("This Restaurant name already exists!");  
					document.frm.val1.value = 'REST_EXISTS';
			}
			else if(data == 'REST_AVAILABLE')
			{
				$('#user1')
					.css('color', 'green')
					.html("");
					document.frm.val1.value = 'REST_AVAILABLE';
			}
		}
	})	      

}

function get_state_city(state){
	//alert(state);
	$.ajax({
		url : 'get_state_city.php',
		type : 'POST',
		data : 'state=' + state,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('restaurant_city').innerHTML=subCat;
			document.getElementById('rest_name').innerHTML=subCatid;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}

function get_city_restaurant(city){
	$.ajax({
		url : 'get_city_restaurant.php',
		type : 'POST',
		data : 'city=' + city,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var subCat = data;
			document.getElementById('rest_name').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}

</script>

<h2 style="background:#FA8730; color:#fff; padding:8px;">Add restaurant admin panel </h2>
<form name="frm" action="" method="post" onsubmit="return valide()">
            	<table width="85%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
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
    <td class="text1" align="right">State <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><select name="state" id="state" class="select_box" onchange="get_state_city(this.value);">
    <option value="">Select</option>
    <?php $sql_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='' ORDER BY restaurant_state");
	while($array_state = mysql_fetch_array($sql_state)){?>
    	<option value="<?php echo $array_state['restaurant_state']; ?>"><?php echo $array_state['restaurant_state']; ?></option>
    <?php } ?>
    </select>
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">City <font color="#FF0000">*</font>:</td>
    <td class="normaltext">
    <select name="restaurant_city" id="restaurant_city" class="select_box" onchange="get_city_restaurant(this.value);">
    	<option value="">Select</option>  
    </select>
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">Restaurant Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext">
    <select name="rest_name" id="rest_name" class="select_box" onchange="check_restaurant();">
        <option value="">Select</option>
        <?php /*?><?php $sql_select = mysql_query("SELECT * FROM restaurant_basic_info WHERE id!= '' ORDER BY restaurant_name");
        while($array_select = mysql_fetch_array($sql_select)){ ?>
        <option value="<?php echo $array_select['id']; ?>"><?php echo stripslashes($array_select['restaurant_name']); ?></option>
        <?php } ?><?php */?>
    </select>
    <input type="hidden" name="val1" id="val1" value=""/>
    <span id="user1" style="font:14px Arial,Helvetica,sans-serif; margin-left:5px; margin-top:10px;"></span>
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">First Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="firstname" id="firstname" type="text" class="login_ipboxin"  value="" autocomplete="off" >
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">Last Name :</td>
    <td class="normaltext"><input name="lastname" id="lastname" type="text" class="login_ipboxin"  value="" autocomplete="off" >
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">Email-Id <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="email_id" id="email_id" type="text" class="login_ipboxin"  value="" onkeyup="return check_email();" autocomplete="off" >
    <input type="hidden" name="val" id="val" value=""/>
    <span id="user" style="font:14px Arial,Helvetica,sans-serif; margin-left:5px; margin-top:10px;"></span>
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">Security Code <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="security_code" id="security_code" type="text" class="login_ipboxin"  value="" autocomplete="off" onkeyup="return check_security_code();">
    <input type="hidden" name="val_sec" id="val_sec" value=""/>
    <span id="sec_span" style="font:14px Arial,Helvetica,sans-serif; margin-left:5px; margin-top:10px;"></span>
    </td>
  </tr>
  <tr>
    <td class="text1" align="right">Password <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="pwd" id="pwd" type="password" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="text1" align="right">Confirm Password <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="conpwd" id="conpwd" type="password" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Add" class="normalbutton" style="background-color: #EB6F00; border:0; outline:0; padding:8px 12px; text-align:center; color:#fff; cursor:pointer; "></td>
  </tr>
</table>
</form>
</div>
<?php

}
require_once"template_admin.php";
?>