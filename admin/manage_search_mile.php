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

		 $search_mile = htmlspecialchars(stripslashes($_REQUEST['search_mile']),ENT_QUOTES);

	    if($_FILES['cms_image']['name']!="")

		{

		$image=$_FILES['cms_image']['name'];

	    $image=time().$image;

		if ((($_FILES["cms_image"]["type"] == "image/gif")

		  || ($_FILES["cms_image"]["type"] == "image/png")

		  || ($_FILES["cms_image"]["type"] == "image/bmp")

		  || ($_FILES["cms_image"]["type"] == "image/jpg")

		  || ($_FILES["cms_image"]["type"] == "image/jpeg")

		  || ($_FILES["cms_image"]["type"] == "image/pjpeg")))

		  

		{

			 $picture_url="../uploaded_images/".$image;

			LIB_StoreUploadImg($post_file_name="cms_image"

								,$file_to_copy_path="$picture_url"

								,$file_to_copy_width="216"

								,$file_to_copy_height="150"

								,$adjust = ''

								,$watermark_gif=''

								,$watermark_position='');

		

		}

	}

  


	$sql_about = ("update restaurant_admin set search_mile='".$search_mile."' WHERE id = 1");

	
	

	$sql_query=mysql_query($sql_about);

			

	if($sql_query)

	{

	header("location:manage_search_mile.php?success=1");

	}

}

	

	//////////////////////End for edit///////////////////////////////////////////



?>









<script type="text/javascript" language="javascript">

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

	if(document.myfrm.heading.value=='')

	{

		alert("Please enter heading.");

		document.myfrm.heading.focus();

		return false;

	}

		if(CKEDITOR.instances.description.getData() == ''){

		alert('Please enter description');

		CKEDITOR.instances.description.setData("");

		return false;

	}
	

	return true;

}



</script>



<link href="css/style.css" type="text/css" rel="stylesheet">



 <form name="myfrm" action="" method="POST" onsubmit="return validate();" enctype="multipart/form-data">



<?

$sql_select=mysql_query("select * from  restaurant_admin where id = 1");

$array_select=mysql_fetch_array($sql_select);

?>



<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tableborder" height="127">



  <tr>



    <td colspan="2" style="color:#ffffff; font-weight:bold; font-family:Trebuchet MS;" bgcolor="#FA8730" align="center" height="30">

	Manage Search Mile


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



    <td width="34%" height="29" align="right" class="login_labelin">Search Mile <font color="#FF0000">*</font>:</td>



    <td width="66%" class="login_labelin"><input type="text" name="search_mile" id="search_mile" value="<?php echo $array_select['search_mile']; ?>"  style="width:525px; border:1px solid #CCCCCC" class="smalltext" onKeyPress="return goodchars(event,'1234567890.');" /></td>



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