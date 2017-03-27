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

  

  $sql="select * from restaurant_cms where page_id=$id";

  $res=mysql_query($sql);

  if(mysql_num_rows($res)==0)

  {

	$query=mysql_query("insert into  restaurant_cms set heading='".$heading."',description='".$description."',page_id='$id'");

	if($query)

	{

		$msg="Successfully Data Inserted...";

		header("location:manage_cms1.php?page_id=$id&msg=$msg");

	}

  }

  

  else

  {

	$sql_about = ("update  restaurant_cms set heading='".$heading."',description='".$description."'");

	$sql_about .= "where page_id='".$id."'";

	

	$sql_query=mysql_query($sql_about);

			

	if($sql_query)

	{

	header("location:manage_cms1.php?page_id=$id&success=1");

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



 <form name="myfrm" action="" method="POST" onSubmit="return validate();" enctype="multipart/form-data">



<?

$sql_select=mysql_query("select * from  restaurant_cms where page_id='".$_REQUEST['page_id']."'");

$array_select=mysql_fetch_array($sql_select);

?>



<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tableborder" height="127">



  <tr>



    <td colspan="2" style="color:#ffffff; font-weight:bold; font-family:Trebuchet MS;" bgcolor="#FA8730" align="center" height="30">



	<?php 
	if($_REQUEST['page_id'] == 3){
		echo "Manage FAQ";
	}
	else if($_REQUEST['page_id'] == 4){
		echo "Manage Terms and conditions";
	}
	else if($_REQUEST['page_id'] == 5){
		echo "Manage Privacy Policy";
	}
	else if($_REQUEST['page_id'] == 6){
		echo "Manage Career";
	}
	else if($_REQUEST['page_id'] == 12){
		echo "Manage Gift Card Content";
	}
	?>



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



    <td width="34%" height="29" align="right" class="login_labelin">Heading <font color="#FF0000">*</font>:</td>



    <td width="66%" class="login_labelin"><input type="text" name="heading" id="heading" value="<?php echo htmlspecialchars_decode($array_select['heading']); ?>"  style="width:525px; border:1px solid #CCCCCC" class="smalltext"/></td>



  </tr>

<tr>



    <td width="34%" height="29" align="right" class="login_labelin">Description <font color="#FF0000">*</font>:</td>



    <td width="66%"><textarea cols="63" id="description" name="description" rows="10" ><?php echo htmlspecialchars_decode($array_select['description']); ?></textarea><input type="hidden" name="id" value="<?php echo $_REQUEST['page_id'];?>" /></td>
    <script type="text/javascript">

				CKEDITOR.replace( 'description',

				{
					toolbar:[['Source','-','Bold','Italic','Underline','-','Undo','Redo','-','Find','Replace','-','SelectAll','-','Scayt','-','About']],
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



?>