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

		 $subject = htmlspecialchars(stripslashes($_REQUEST['subject']),ENT_QUOTES);

		 $description = htmlspecialchars(stripslashes($_REQUEST['description']),ENT_QUOTES);
		 
		 $email_address = $_REQUEST['email_address'];

  

  $sql="select * from restaurant_auto_responder where page_id=$id";

  $res=mysql_query($sql);

  if(mysql_num_rows($res)==0)

  {

	$query=mysql_query("INSERT INTO restaurant_auto_responder set subject='".$subject."',description='".$description."',page_id='$id' , email_address = '".$email_address."'");

	if($query)

	{

		$msg="Successfully Data Inserted...";

		header("location:manage_auto_responder.php?page_id=$id&msg=$msg");

	}

  }

  

  else

  {

	$sql_about = (" update  restaurant_auto_responder set subject='".$subject."',description='".$description."' , email_address = '".$email_address."' ");
	
	$sql_about .= "where page_id='".$id."'";

	$sql_query=mysql_query($sql_about);

			

	if($sql_query)

	{

	header("location:manage_auto_responder.php?page_id=$id&success=1");

	}

  }

}

	

	//////////////////////End for edit///////////////////////////////////////////



?>


<script type="text/javascript" language="javascript">
function validate()
{

	if(document.myfrm.subject.value=='')

	{

		alert("Please enter subject.");

		document.myfrm.subject.focus();

		return false;

	}

		if(CKEDITOR.instances.description.getData() == ''){

		alert('Please enter description');

		CKEDITOR.instances.description.setData("");

		return false;

	}
	
	if(document.myfrm.email_address.value=='')
	{
		alert("Please enter email_address.");
		document.myfrm.email_address.focus();
		return false;
	}
	return true;

}



</script>



<link href="css/style.css" type="text/css" rel="stylesheet">



 <form name="myfrm" action="" method="POST" onSubmit="return validate();" enctype="multipart/form-data">



<?

$sql_select=mysql_query("select * from  restaurant_auto_responder where page_id='".$_REQUEST['page_id']."'");

$array_select=mysql_fetch_array($sql_select);

?>



<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tableborder" height="127">



<tr>

<?php if($_REQUEST['page_id'] == 1){
		$title = "SIGNUP MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 2){
		$title =  "SIGNUP MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 3){
		$title =  "FRONTEND EDIT PROFILE MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 4){
		$title =  "FRONTEND EDIT PROFILE MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 5){
		$title =  "CUSTOMER PROFILE PASSWORD CHANGED BY ADMIN";
	}
	else if($_REQUEST['page_id'] == 6){
		$title =  "CUSTOMER PROFILE DISABLED BY ADMIN";
	}
	else if($_REQUEST['page_id'] == 7){
		$title =  "CUSTOMER PROFILE DELETED BY ADMIN";
	}
	else if($_REQUEST['page_id'] == 8){
		$title =  "MAIL TO RESTAURANT OWNER AFTER REVIEW POST";
	}
	else if($_REQUEST['page_id'] == 9){
		$title =  "MAIL TO ADMIN AFTER REVIEW POST";
	}
	else if($_REQUEST['page_id'] == 10){
		$title =  "MAIL TO ADMIN AFTER REPORT ABUSE";
	}
	else if($_REQUEST['page_id'] == 11){
		$title =  "CUSTOMER FORGOT PASSWORD";
	}
	else if($_REQUEST['page_id'] == 12){
		$title =  "RESTAURANT ADMIN FORGOT PASSWORD";
	}
	else if($_REQUEST['page_id'] == 13){
		$title =  "MAIL TO VENDOR";
	}
	else if($_REQUEST['page_id'] == 14){
		$title =  "MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 15){
		$title =  "MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 16){
		$title =  "MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 17){
		$title =  "MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 18){
		$title =  "MAIL TO RESTAURANT OWNER";
	}
	else if($_REQUEST['page_id'] == 19){
		$title =  "MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 20){
		$title =  "MAIL TO RESTAURANT OWNER";
	}
	else if($_REQUEST['page_id'] == 21){
		$title =  "MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 22){
		$title =  "MAIL TO RESTAURANT OWNER";
	}
	else if($_REQUEST['page_id'] == 23){
		$title =  "MAIL GIFT CERTIFICATE TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 24){
		$title =  "MAIL PURCHASE DETAILS TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 25){
		$title =  "MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 26){
		$title =  "MAIL TO RESTAURANT OWNER";
	}
	else if($_REQUEST['page_id'] == 27){
		$title =  "MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 28){
		$title =  "MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 29){
		$title =  "MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 30){
		$title =  "MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 31){
		$title =  "MAIL TO RESTAURANT OWNER";
	}
	else if($_REQUEST['page_id'] == 34){
		$title =  "MAIL TO CUSTOMER AFTER RESERVATION CONFIRMATION";
	}
	else if($_REQUEST['page_id'] == 35){
		$title =  "MAIL TO ADMIN";
	}
	else if($_REQUEST['page_id'] == 36){
		$title =  "MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 37){
		$title =  "MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 38){
		$title =  "MAIL TO ADMIN AFTER GIFT CERTIFICATE USED";
	}
	else if($_REQUEST['page_id'] == 39){
		$title =  "MAIL TO RESTAURANT OWNER AFTER GIFT CERTIFICATE USED";
	}
	else if($_REQUEST['page_id'] == 40){
		$title =  "MAIL TO CUSTOMER AFTER GIFT CERTIFICATE USED";
	}
	else if($_REQUEST['page_id'] == 41){
		$title =  "MAIL TO CUSTOMER";
	}
	else if($_REQUEST['page_id'] == 42){
		$title =  "MAIL TO USERS";
	}
	 ?>
    
<td height="92" colspan="2"><h2 style="background:#FA8730; color:#fff; padding:8px; text-align:center;"><?php echo $title; ?></h2><span style="float:right; margin-top:15px;" class="login_labelin"><a href="javascript:void(0);" style="text-decoration:none;" onclick="history.back();" ><input type="button" name="back" id="back" value="Back" class="normalbutton" /></a></span></td>

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
    <td width="34%" height="29" align="right" class="login_labelin">Subject <font color="#FF0000">*</font>:</td>
    <td width="66%" class="login_labelin"><input type="text" name="subject" id="subject" value="<?php echo htmlspecialchars_decode($array_select['subject']); ?>"  style="width:525px; border:1px solid #CCCCCC" class="smalltext"/></td>
</tr>


<?php if($array_select['email_flag'] == 1){?>
<tr>
    <td width="34%" height="29" align="right" class="login_labelin">Admin Email Address <font color="#FF0000">*</font>:</td>
    <td width="66%" class="login_labelin"><input type="text" name="email_address" id="email_address" value="<?php echo htmlspecialchars_decode($array_select['email_address']); ?>"  style="width:525px; border:1px solid #CCCCCC" class="smalltext"/></td>
</tr>
<?php } ?>


<tr>
    <td width="34%" height="29" align="right" class="login_labelin">Description <font color="#FF0000">*</font>:</td>
    <td width="66%"><textarea cols="63" id="description" name="description" rows="10" ><?php echo htmlspecialchars_decode($array_select['description']); ?></textarea><input type="hidden" name="id" value="<?php echo $_REQUEST['page_id'];?>" /></td>
<script type="text/javascript">
CKEDITOR.replace( 'description', {
	toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
		'/',																					// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
	]
});</script>
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