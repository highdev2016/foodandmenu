<?php
function main()
{
	function change_dateformat_reverse($date_form1)
	{
	 if($date_form1!=''){
	  $date2=explode("-",$date_form1);
	  $dateformat1=$date2[1]."-".$date2[2]."-".$date2[0];
	  return $dateformat1;
	  }
	 else{
	  $dateformat1='';
	  return $dateformat1;
	  }
	}
	
	$errors="";
	if(count($_POST)>0 && $_REQUEST['submit']=="Edit")
	{
		
		mysql_query("update restaurant_owner set `date_status_changed` = '".date('Y-m-d H:i:s')."', status='".$_REQUEST['contact_status']."' where id='".$_REQUEST['hid']."'");
			
		$errors="Status changed successfully ";
	}
	
	$sql_contact = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_owner WHERE id='".$_REQUEST['id']."'"));
?>
<script type="text/javascript">
function cancel_it()
{
	window.location.href="manage_restaurant_contact_request.php?page=<?php echo $_REQUEST['page']?>";
}
</script>
<div class="dashboard_section_in">

<form name="frmchangpass" action="" method="post" enctype="multipart/form-data">
  <table width="65%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr><td colspan="2" class="text2"></td></tr>
  <?php if($errors!=''){ ?>
  <tr>
    <td width="46%" align="right"><img src="images/approve.jpg"></td>
    <td width="54%" class="msg"><?=$errors?></td>
  </tr>
  <?php } ?>
  <tr>
    <td class="text1" align="right">Name <font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php echo $sql_contact['name'];?></td>
  </tr>
   <tr>
    <td class="text1" align="right">Email <font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php echo $sql_contact['email'];?></td>
  </tr>
  <tr>
    <td class="text1" align="right">Phone <font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php echo $sql_contact['phone'];?></td>
  </tr>
  <tr>
    <td class="text1" align="right">Restaurant Name<font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php echo stripslashes($sql_contact['restaurant']);?></td>
  </tr>
   <tr>
    <td class="text1" align="right">Website<font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php echo $sql_contact['website'];?></td>
  </tr>
  <tr>
    <td class="text1" align="right">Subject<font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php echo $sql_contact['subject'] //echo getContactSubject($sql_contact['subject']);?></td>
  </tr>
   <tr>
    <td class="text1" align="right">Category<font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php echo $sql_contact['category'];//getContactCategory($sql_contact['subject'],$sql_contact['category']);?></td>
  </tr>
  <tr>
    <td class="text1" align="right">Message<font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php echo stripslashes($sql_contact['message']);?></td>
  </tr>
  <tr>
    <td class="text1" align="right">Request date<font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left"><?php
	$date_array=explode(" ",$sql_contact['date_added']); //echo change_dateformat_reverse($date_array[0])."&nbsp;".$date_array[1];
	
	echo date("m-d-Y H:i:s", strtotime($sql_contact['date_added'])); ?></td>
  </tr>
  <tr>
    <td class="text1" align="right">Status<font color="#FF0000"></font>:</td>
    <td class="text1" style="text-align:left">
     <select class="select_box" id="contact_status" name="contact_status">
        <option value="1" <?php echo ($sql_contact['status']=='1') ? 'selected="selected"' : '';  ?>>Pending</option>
        <option value="2" <?php echo ($sql_contact['status']=='2') ? 'selected="selected"' : '';  ?>>Approved but login details not sent</option>
        <option value="3" <?php echo ($sql_contact['status']=='3') ? 'selected="selected"' : '';  ?>>Denied</option>
        <option value="4" <?php echo ($sql_contact['status']=='4') ? 'selected="selected"' : '';  ?>>Approved and sent login details</option>
     </select>
	</td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <input type="hidden" name="hid" id="hid" value="<?php echo $sql_contact['id']?>" />
    <td class="normaltext"><input name="submit" type="submit" value="Edit" class="normalbutton">
    <input type="button" name="cancel" value="Cancel" onclick="cancel_it()" class="normalbutton"/></td>
  </tr>
</table>
</form>
            </div>
<?php

}
require_once"functions.php";
require_once"template_admin.php";
?>