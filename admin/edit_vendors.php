<?php
function main()
{
	include_once("image_file.php");
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
	{
		if($_FILES['image']['name']!="")
	    {
		$image=$_FILES['image']['name'];
	    $image=time().$image;
		if ((($_FILES["image"]["type"] == "image/gif")
		  || ($_FILES["image"]["type"] == "image/png")
		  || ($_FILES["image"]["type"] == "image/bmp")
		  || ($_FILES["image"]["type"] == "image/jpg")
		  || ($_FILES["image"]["type"] == "image/jpeg")
		  || ($_FILES["image"]["type"] == "image/pjpeg")))
		  
		{
			 $picture_url="../uploaded_images/".$image;
			LIB_StoreUploadImg($post_file_name="image"
								,$file_to_copy_path="$picture_url"
								,$file_to_copy_width="200"
								,$file_to_copy_height="180"
								,$adjust = ''
								,$watermark_gif=''
								,$watermark_position='');
		
}
	}
	if($image!="")
	{
			mysql_query("update restaurant_vendors set name='".mysql_real_escape_string($_REQUEST['vendor_name'])."',company_name='".mysql_real_escape_string($_REQUEST['company_name'])."',service_type='".mysql_real_escape_string($_REQUEST['service_type'])."',company_brief_description='".mysql_real_escape_string($_REQUEST['company_brief_description'])."',company_long_description='".mysql_real_escape_string($_REQUEST['company_long_description'])."',product_brief_description='".mysql_real_escape_string($_REQUEST['product_brief_description'])."',product_long_description='".mysql_real_escape_string($_REQUEST['product_long_description'])."',address='".mysql_real_escape_string($_REQUEST['address'])."',city='".mysql_real_escape_string($_REQUEST['city'])."',state='".mysql_real_escape_string($_REQUEST['state'])."',zipcode='".mysql_real_escape_string($_REQUEST['zipcode'])."',phone='".mysql_real_escape_string($_REQUEST['phone'])."',email='".mysql_real_escape_string($_REQUEST['email'])."',social_media='".mysql_real_escape_string($_REQUEST['social_media'])."',website='".mysql_real_escape_string($_REQUEST['website'])."',image='".mysql_real_escape_string($image)."' where id='".$_REQUEST['hid']."'");	
	}
	else{
		mysql_query("update restaurant_vendors set name='".mysql_real_escape_string($_REQUEST['vendor_name'])."',company_name='".mysql_real_escape_string($_REQUEST['company_name'])."',service_type='".mysql_real_escape_string($_REQUEST['service_type'])."',company_brief_description='".mysql_real_escape_string($_REQUEST['company_brief_description'])."',company_long_description='".mysql_real_escape_string($_REQUEST['company_long_description'])."',product_brief_description='".mysql_real_escape_string($_REQUEST['product_brief_description'])."',product_long_description='".mysql_real_escape_string($_REQUEST['product_long_description'])."',address='".mysql_real_escape_string($_REQUEST['address'])."',city='".mysql_real_escape_string($_REQUEST['city'])."',state='".mysql_real_escape_string($_REQUEST['state'])."',zipcode='".mysql_real_escape_string($_REQUEST['zipcode'])."',phone='".mysql_real_escape_string($_REQUEST['phone'])."',email='".mysql_real_escape_string($_REQUEST['email'])."',social_media='".mysql_real_escape_string($_REQUEST['social_media'])."',website='".mysql_real_escape_string($_REQUEST['website'])."' where id='".$_REQUEST['hid']."'");
	}
			$errors="Vendor Details has been added successfully ";
	}
	
	$sql_vendor=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_vendors WHERE id='".$_REQUEST['id']."'"));
?>
<div class="dashboard_section_in">
<script language="javascript" type="text/javascript">
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
function validate()
{
	if(document.getElementById('vendor_name').value=='')
	{
		alert ('Please Enter Vendor Name');
		document.getElementById('vendor_name').focus();
		return false;
	}
	if(document.getElementById('company_name').value=='')
	{
		alert ('Please Enter Company Name');
		document.getElementById('company_name').focus();
		return false;
	}
	if(document.getElementById('service_type').value=='')
	{
		alert ('Please Enter Service Type');
		document.getElementById('service_type').focus();
		return false;
	}
	if(document.getElementById('company_brief_description').value=='')
	{
		alert ('Please Enter Company Brief Description');
		document.getElementById('company_brief_description').focus();
		return false;
	}
	if(document.getElementById('company_long_description').value=='')
	{
		alert ('Please Enter Company Long Description');
		document.getElementById('company_long_description').focus();
		return false;
	}
	if(document.getElementById('product_brief_description').value=='')
	{
		alert ('Please Enter Product Brief Description');
		document.getElementById('product_brief_description').focus();
		return false;
	}
	if(document.getElementById('product_long_description').value=='')
	{
		alert ('Please Enter Product Long Description');
		document.getElementById('product_long_description').focus();
		return false;
	}
	if(document.getElementById('address').value=='')
	{
		alert ('Please Enter Address');
		document.getElementById('address').focus();
		return false;
	}
	if(document.getElementById('city').value=='')
	{
		alert ('Please Enter City');
		document.getElementById('city').focus();
		return false;
	}
	if(document.getElementById('state').value=='')
	{
		alert ('Please Enter State');
		document.getElementById('state').focus();
		return false;
	}
	if(document.getElementById('zipcode').value=='')
	{
		alert ('Please Enter Zipcode');
		document.getElementById('zipcode').focus();
		return false;
	}
	if(document.getElementById('phone').value=='')
	{
		alert ('Please Enter Phone');
		document.getElementById('phone').focus();
		return false;
	}
	
	
    return true;
}

</script>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_vendors.php?page=<?php echo $_REQUEST['page']?>";
}
</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Edit Vendor</h2>
<form name="frmchangpass" action="" method="post"  enctype="multipart/form-data">
            	<table width="65%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <?php if($errors!='')
  {?>
  <tr>
    <td width="46%" align="right"><img src="images/approve.jpg"></td>
    <td width="54%" class="msg"><?=$errors?></td>
  </tr>
  <?
  }
  ?>
  <tr>
    <td class="text1" align="right">Vendor Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="vendor_name" id="vendor_name" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['name']?>"></td>
  </tr>
   <tr>
    <td class="text1" align="right">Company Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="company_name" id="company_name" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['company_name']?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Service Type <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="service_type" id="service_type" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['service_type']?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Company Brief Description<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea name="company_brief_description" id="company_brief_description" rows="3" cols="40"><?php echo $sql_vendor['company_brief_description']?></textarea></td>
  </tr>
   <tr>
    <td class="text1" align="right">Company Long Description<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea name="company_long_description" id="company_long_description" rows="5" cols="40"><?php echo $sql_vendor['company_long_description']?></textarea></td>
  </tr>
  <tr>
    <td class="text1" align="right">Product and Services Brief Description<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea name="product_brief_description" id="product_brief_description" rows="3" cols="40"><?php echo $sql_vendor['product_brief_description']?></textarea></td>
  </tr>
   <tr>
    <td class="text1" align="right">Product and Services Long Description<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><textarea name="product_long_description" id="product_long_description" rows="5" cols="40"><?php echo $sql_vendor['company_long_description']?></textarea></td>
  </tr>
  <tr>
    <td class="text1" align="right">Address<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="address" id="address" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['address']?>"></td>
  </tr>
   <tr>
    <td class="text1" align="right">City<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="city" id="city" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['city']?>"></td>
  </tr>
   <tr>
    <td class="text1" align="right">State<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="state" id="state" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['state']?>"></td>
  </tr> <tr>
    <td class="text1" align="right">Zipcode<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="zipcode" id="zipcode" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['zipcode']?>" onKeyPress="return goodchars(event,'1234567890');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Phone<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="phone" id="phone" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['phone']?>" onKeyPress="return goodchars(event,'1234567890+-');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Email<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="email" id="email" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['email']?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Facebook:</td>
    <td class="normaltext"><input name="social_media" id="social_media" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['social_media']?>"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Website:</td>
    <td class="normaltext"><input name="website" id="website" type="text" class="login_ipboxin"  value="<?php echo $sql_vendor['website']?>">
    <input name="hid" type="hidden" class="login_ipboxin"  value="<?php echo $sql_vendor['id']?>"></td>
  </tr>
   <tr>
    <td class="text1" align="right">Image<font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="image" id="image" type="file" class="login_ipboxin"  value="" style="height:25px;">
    <?php
	if($sql_vendor['image'])
	{
	?>
    <img src="../uploaded_images/<?php echo $sql_vendor['image']?>" height="60" width="60" />
    <?php
	}
	?>
    </td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Edit" class="normalbutton">
    <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"template_admin.php";
?>