<?php

ob_start();

function main()



{

	

	///////////////////////////For Edit////////////////////////////////////////////////

	$msg="";

	if(count($_POST)>0 && $_REQUEST['submit1']=="Submit")

	{

	 $id  =  $_REQUEST['page_id'];

	 $heading = mysql_real_escape_string($_REQUEST['heading']);

	 $string = $_REQUEST['description'];



  

  //$sql="select * from shiv_about where id=1";

  //$res=mysql_query($sql);

  //if(mysql_num_rows($res)==0)

 // {

	$query_temple=mysql_query("insert into shiv_about set heading='".htmlspecialchars($heading)."',description='".htmlspecialchars($string)."'");

	if($query_temple)

	{

		//$msg="Successfully Data Inserted...";

			header("location:aboutus.php?msg=1");

	}

  //}

	}

  if(count($_POST)>0 && $_REQUEST['submit1']=="Update")

  {

	//$id  =  $_REQUEST['page_id'];

	 $heading = mysql_real_escape_string($_REQUEST['heading']);

	 $string = mysql_real_escape_string($_REQUEST['description']);

	 //echo "update shiv_about set heading='".htmlspecialchars($heading)."',description='".htmlspecialchars($_REQUEST['description'])."' where id=1";

	 //exit();

			mysql_query("update shiv_about set heading='".htmlspecialchars($heading)."',description='".htmlspecialchars($_REQUEST['description'])."' where id=1");

			//$msg="Details Successfully Updated";

			header("location:aboutus.php?msg=2");

	

  }

	//}

	

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

 $query_event=mysql_query("select * from shiv_about where id=1");

 $array_utility_details=mysql_fetch_array($query_event);

 $about_num_rows=mysql_num_rows($query_event);

 ?>



<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tableborder" height="127">



  <tr>



    <td colspan="2" style="color:#151515; font-size:13px; font-family:Trebuchet MS; padding-left:8px; font-weight:bold;" bgcolor="#A5BFDD" align="left" height="30">



	Manage About Us



	</td>



  </tr>



  <?php 

  if(empty($_REQUEST['msg'])){ $_REQUEST['msg']='';}

  if($_REQUEST['msg']==1)

  {?>

  

  <tr>

    <td width="10%" height="28" align="right"><img src="images/approve.jpg"></td>

    <td width="90%" class="msg">Data Inserted Successfully...</td>

  </tr>



  <?php

  }



  if($_REQUEST['msg']==2)

  {

  ?>

  

  <tr>

    <td width="10%" height="28" align="right"><img src="images/approve.jpg"></td>

    <td width="90%" class="msg">Details Updated Successfully.. </td>

  </tr>



  <?php

  }

  ?>



  <tr>



    <td width="10%" height="29" align="left" class="left_label">Heading <font color="#FF0000">*</font>:</td>



    <td width="90%" class="login_labelin"><input type="text" name="heading" id="heading" value="<?php echo $array_utility_details['heading']?>"  style="width:480px; border:1px solid #CCCCCC" class="smalltext"/></td>



  </tr>

  

<tr>



    <td width="10%" height="29" align="left" class="left_label">Description <font color="#FF0000">*</font>:</td>



    <td width="90%">

    <textarea cols="63" id="description" name="description" rows="10" ><?php echo htmlspecialchars_decode($array_utility_details['description']);?></textarea></td>

			<script type="text/javascript">

				CKEDITOR.replace( 'description',

				{

					fullPage : false,

					extraPlugins : 'docprops'

				});

			</script>  </tr>

  

    <tr>



    <td height="30" align="right" class="inputheading">&nbsp;</td>



    <td>

    <?php

	if($about_num_rows==0)

	{

	?>

    <input name="submit1" type="submit" value="Submit" class="LoginButton">

    <?php

	}

	else

	{

	?>

    <input name="submit1" type="submit" value="Update" class="LoginButton">

    <?php } ?>

    </td>



  </tr>



</table>



</form>



<?php



}



require_once"template_admin.php";



?>