<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Food & menu</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<!--<link rel="shortcut icon" href="../favicon.ico" />
<link rel="icon" href="../favicon.ico" />-->
</head>

<body onload="get_focus();">

<div id="wrapper_main">
	<div id="wrapper_in">
      <div id="top">
       	  <div class="logo"><img alt="auto styles logo" src="images/logo.png"></div>
          <div class="admin_headeing"><p style="color:#404CA1;">Admin Panel</p></div>
      </div>
       
      
     <div id="middle">
    	<div id="login_form">
        	<div class="login_hdr">
            	<h1 style="color:#ffffff;">Login</h1>
            </div>
            <script type="text/javascript" language="javascript">
			function get_focus()
			{
			var username=document.getElementById('username');
			username.focus();
			}
			function check()
			{   
				var username=document.getElementById('username').value;
				var password=document.getElementById('pwd').value;
				var captcha_code=document.getElementById('captcha_code').value;
				if (username=='')
				{
					alert ('Please Enter User Name');
					document.getElementById('username').focus();
					return false;
				}
				if (password=='')
				{
					alert ('Please Enter Password');
					document.getElementById('pwd').focus();
					return false;
				}
				if (captcha_code=='')
				{
					alert ('Please Enter Validation Code');
					document.getElementById('captcha_code').focus();
					return false;
				}
				return true;
				
			}
			</script>
            
            <script type="text/javascript">
			function refreshCaptcha()
			{
				var img = document.images['captchaimg'];
				img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
			}
			</script>
            <form action="checklogin.php" name="form" method="post" onsubmit="return check();">
            <div class="login_middle">
            	
                <?
			if($_REQUEST['error']==1)
			{
			?>
            <div style="margin-left:80px; padding:5px;"> 
                	<label class="login_labelin"><img src="images/remove.png" align="absmiddle" />&nbsp;Incorrect Login! Wrong Username or Password</label>
            </div>
            <?
			}
			?>
            <?
			if($_REQUEST['error']==2)
			{
			?>
            <div style="margin-left:80px; padding:5px;"> 
                	<label class="login_labelin"><img src="images/remove.png" align="absmiddle" />&nbsp;The captcha is not matching!</label>
            </div>
            <?
			}
			?>
                
            	<div class="login_label">
                	<label class="login_labelin">Username :</label>
                </div>
                <div class="login_ipbox">
                	<input name="username" id="username" type="text" class="login_ipboxin" />
                </div>
                <div class="login_label">
                	<label class="login_labelin">Password :</label>
                </div>
                <div class="login_ipbox">
                	<input name="pwd" id="pwd" type="password" class="login_ipboxin" />
                </div>
                
                <div class="login_label">
                	<label class="login_labelin">Captcha :</label>
                </div>
                <div class="login_ipbox">
                	<img src="captcha_code_file.php?rand=<?php echo $_SESSION['6_letters_code'];?>" id='captchaimg' style="margin-left:15px;">
                    <p>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</p>
                </div>
                <div class="login_label">
                	
                </div>
                <div class="login_ipbox">
                	<input name="captcha_code" id="captcha_code" type="text" class="login_ipboxin" />
                </div>
                
                <div class="login_label">
                	&nbsp;
                </div>
                <div class="login_ipbox">
                	<div class="button1"><input type="submit" name="submit" value="Login" class="login_button"/></div>               
                </div>
            </div>
            <div class="login_ftr">
            	<div style="float:left;"><img src="images/shadow1.png" width="99" height="21" alt="shadow1" /></div>
                <div style="float:right;"><img src="images/shadow2.png" width="99" height="21" alt="shadow2" /></div>
            </div>
            <!--<div class="login_ftr">&nbsp;</div>-->
            </form>
        </div>
        
     </div>
    </div>
</div>

<div id="footer" style="position:fixed;">
          <div id="footer_inner">
            <div id="copy_right">Copy Right &copy; <?php echo date('Y');?> All Rights Reserved by Food & Menu </div>
              
              <div class="clear"></div>
          </div>
        </div>



</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 