<?php

ob_start();

function main()
{

	include("image_file.php");

	///////////////////////////For Edit////////////////////////////////////////////////

	$msg="";

	if(count($_POST)>0 && $_REQUEST['submit1']=="Submit")

	{

		 $id  =  mysql_real_escape_string($_REQUEST['page_id']);

		 $address = htmlspecialchars(stripslashes($_REQUEST['address']),ENT_QUOTES);

		 $telephone = htmlspecialchars(stripslashes($_REQUEST['telephone']),ENT_QUOTES);
		 
		 $email = $_REQUEST['email'];

  

  $sql="select * from  restaurant_contact_info where page_id=$id";

  $res=mysql_query($sql);

  if(mysql_num_rows($res)==0)

  {

	$query=mysql_query("insert into   restaurant_contact_info set address='".$address."',telephone='".$telephone."',email='".$email."',page_id='$id'");

	if($query)

	{

		$msg="Successfully Data Inserted...";

		header("location:manage_contact.php?page_id=$id&msg=$msg");

	}

  }

  

  else

  {

	$sql_about = ("update  restaurant_contact_info set address='".$address."',telephone='".$telephone."',email='".$email."'");

	$sql_about .= "where page_id='".$id."'";

	

	$sql_query=mysql_query($sql_about);

			

	if($sql_query)

	{

	header("location:manage_contact.php?page_id=$id&success=1");

	}

  }

}

	

	//////////////////////End for edit///////////////////////////////////////////
?>
<script type="text/javascript" language="javascript">
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
		if(CKEDITOR.instances.address.getData() == ''){

		alert('Please enter address');

		CKEDITOR.instances.address.setData("");

		return false;

	}
	if(document.myfrm.telephone.value=='')
	{
		alert("Please enter telephone.");
		document.myfrm.telephone.focus();
		return false;
	}
	if(document.myfrm.email.value=='')
	{
		alert("Please enter email.");
		document.myfrm.email.focus();
		return false;
	}
	if ((document.myfrm.email.value!="") && (checkMessenger(document.myfrm.email.value)==false))
	{
	document.myfrm.email.value="";
	document.myfrm.email.focus();
	return false;
	}
	return true;
}



</script>



<link href="css/style.css" type="text/css" rel="stylesheet">



 <form name="myfrm" action="" method="POST" onSubmit="return validate();" enctype="multipart/form-data">



<?

$sql_select=mysql_query("select * from  restaurant_contact_info where page_id='".$_REQUEST['page_id']."'");

$array_select=mysql_fetch_array($sql_select);

?>



<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tableborder" height="127">



  <tr>



    <td colspan="2" style="color:#ffffff; font-weight:bold; font-family:Trebuchet MS;" bgcolor="#FA8730" align="center" height="30">



	Manage Contact Info



	</td>



  </tr>


  <?php if($_REQUEST['success']==1)
  {?>
  <tr>
    <td width="34%" height="28" align="right"><img src="images/approve.jpg"></td>
	<td width="66%" class="msg">Details updated successfully</td>
  </tr>
  <?php
  }
  ?>

 

<tr>



    <td width="34%" height="29" align="right" class="login_labelin">Address <font color="#FF0000">*</font>:</td>



    <td width="66%"><textarea cols="63" id="address" name="address" rows="10" ><?php echo htmlspecialchars_decode($array_select['address']); ?></textarea><input type="hidden" name="id" value="<?php echo $_REQUEST['page_id'];?>" /></td>
		<script type="text/javascript">
        CKEDITOR.replace( 'address',
        {
        fullPage : false,
        extraPlugins : 'docprops'
        });
        </script>



  </tr>
  
   <tr>



    <td width="34%" height="29" align="right" class="login_labelin">Telephone <font color="#FF0000">*</font>:</td>



    <td width="66%" class="login_labelin"><input type="text" name="telephone" id="telephone" value="<?php echo htmlspecialchars_decode($array_select['telephone']); ?>"  style="width:525px; border:1px solid #CCCCCC" class="smalltext" onKeyPress="return goodchars(event,'1234567890+-');"/></td>



  </tr>
  
   <tr>



    <td width="34%" height="29" align="right" class="login_labelin">Email <font color="#FF0000">*</font>:</td>



    <td width="66%" class="login_labelin"><input type="text" name="email" id="email" value="<?php echo htmlspecialchars_decode($array_select['email']); ?>"  style="width:525px; border:1px solid #CCCCCC" class="smalltext"/></td>



  </tr>

  

    <tr>



    <td height="30" align="right" class="inputheading">&nbsp;</td>



    <td><input name="submit1" type="submit" value="Submit" class="normalbutton"></td>



  </tr>



</table>



</form>



<?php



}



require_once"template_admin.php";



?>