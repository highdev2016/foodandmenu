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

		 $heading = htmlspecialchars(stripslashes($_REQUEST['heading']),ENT_QUOTES);

		 $description = htmlspecialchars(stripslashes($_REQUEST['description']),ENT_QUOTES);

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

  

  $sql="select * from restaurant_home_page_content where id = 1";

  $res=mysql_query($sql);

  if(mysql_num_rows($res)==0)

  {

	$query=mysql_query("insert into  restaurant_home_page_content set heading='".$heading."',description='".$description."'");

	if($query)

	{

		$msg="Successfully Data Inserted...";

		header("location:manage_first_section.php?msg=$msg");

	}

  }

  

  else

  {

	$sql_about = ("update  restaurant_home_page_content set heading='".$heading."',description='".$description."' WHERE id = 1");

	
	

	$sql_query=mysql_query($sql_about);

			

	if($sql_query)

	{

	header("location:manage_first_section.php?success=1");

	}

  }

}

	

	//////////////////////End for edit///////////////////////////////////////////



?>









<script type="text/javascript" language="javascript">



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

$sql_select=mysql_query("select * from  restaurant_home_page_content where id = 1");

$array_select=mysql_fetch_array($sql_select);

?>



<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tableborder" height="127">



  <tr>



    <td colspan="2" style="color:#ffffff; font-weight:bold; font-family:Trebuchet MS;" bgcolor="#FA8730" align="center" height="30">




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



    <td width="34%" height="29" align="right" class="login_labelin">Title <font color="#FF0000">*</font>:</td>



    <td width="66%" class="login_labelin"><input type="text" name="heading" id="heading" value="<?php echo htmlspecialchars_decode($array_select['heading']); ?>"  style="width:525px; border:1px solid #CCCCCC" class="smalltext"/></td>



  </tr>

<tr>



    <td width="34%" height="29" align="right" class="login_labelin">Description <font color="#FF0000">*</font>:</td>



    <td width="66%"><textarea cols="63" id="description" name="description" rows="10" ><?php echo htmlspecialchars_decode($array_select['description']); ?></textarea></td>
    <script type="text/javascript">

				CKEDITOR.replace( 'description',

				{

					fullPage : false,

					extraPlugins : 'docprops'

				});

			</script>



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



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>