<?php
error_reporting(E_ALL);
include("../includes/functions.php");
function change_dateformat_reverse($date_form1)
 {
  if($date_form1!=''){
   $date2=explode("-",$date_form1);
   $dateformat1=$date2[2]."-".$date2[0]."-".$date2[1];
   return $dateformat1;
   }
  else{
   $dateformat1='';
   return $dateformat1;
   }
 }
function main()
{
	include_once("image_file.php");
	$errors="";
	if(count($_POST) > 0 && $_REQUEST['submit'] == "Add")
	{
		$type = '';
		$sep ='';
		$reward_ty_nm = '';
		$sepp1 = '';
		$inc = 1;
		foreach($_REQUEST['reward_type'] as $reward_type)
		{
			$type = $type.$sep.$reward_type;
			$reward_type_name = $inc.". ".getNameTable("restaurant_reward_type_master","name","id",$reward_type);
			$reward_ty_nm =$reward_ty_nm.$sepp1.$reward_type_name;
			$sep = ',';
			$sepp1 = '<br>';
			$inc++;
		}
		$sql_mul_reward = mysql_query("SELECT * FROM restaurant_multiple_reward WHERE start_date <= '".change_dateformat_reverse($_REQUEST['start_date'])."' AND end_date >= '".change_dateformat_reverse($_REQUEST['start_date'])."'");
		
		while($row_mul_reward = mysql_fetch_array($sql_mul_reward))
		{
			 $type_id = explode(",",$row_mul_reward['reward_type']);
			 
			 foreach($_REQUEST['reward_type'] as $reward_type1)
			{
				 if(in_array($reward_type1 , $type_id))
				 {
					 $point_new = $row_mul_reward['id'];
				 }
			}
				 
		}
		
		if($point_new == '')
		{
			mysql_query("insert into restaurant_multiple_reward set name='".mysql_real_escape_string($_REQUEST['name'])."',description='".mysql_real_escape_string($_REQUEST['description'])."',reward_type='".$type."', redeemable_point = '".$_REQUEST['redeemable_point']."', point = '".$_REQUEST['reward_point']."', start_date = '".change_dateformat_reverse($_REQUEST['start_date'])."', end_date = '".change_dateformat_reverse($_REQUEST['end_date'])."', status='".$_REQUEST['status']."' , promote = '".$_REQUEST['promote']."' , post_date = NOW(),	price = '".$_REQUEST['amount']."'");
		
		
		  
	
		
	if($_REQUEST['promote'] == '1')
	{
		/*if($_REQUEST['option'] == "state")
		{
			$all_state = '';
			$sep_new = '';
			foreach($_REQUEST['state'] as $state)
			{
				$all_state = $all_state.$sep_new."'".$state."'";
				$sep_new = ',';
			}
			if($all_state == '')
			{
				$all_state = '0';
			}

			$sql_customer = mysql_query("SELECT * FROM restaurant_customer WHERE state in (".$all_state.")");
		}*/
		if($_REQUEST['option'] == "state")
		{
			$all_city = '';
			$sep_new = '';
			foreach($_REQUEST['city'] as $city)
			{
				$all_city = $all_city.$sep_new."'".$city."'";
				$sep_new = ',';
			}
			if($all_city == '')
			{
				$all_city = '0';
			}

			$sql_customer = mysql_query("SELECT * FROM restaurant_customer WHERE city in (".$all_city.")");
		}
		if($_REQUEST['option'] == "user")
		{
			$all_user = '';
			$sep_new = '';
			foreach($_REQUEST['user'] as $user)
			{
				$all_user = $all_user.$sep_new."'".$user."'";
				$sep_new = ',';
			}
			if($all_user == '')
			{
				$all_user = '0';
			}

			$sql_customer = mysql_query("SELECT * FROM restaurant_customer WHERE id in (".$all_user.")");
		}
		
		while($row_customer = mysql_fetch_array($sql_customer))
		{	
		
			$email_cust = $row_customer['email'];
			
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 41"));  
			  
			$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
			
			$cms_rep=str_replace('%%$name%%',$row_customer['firstname']." ".$row_customer['lastname'],$cms_rep);
			$cms_rep=str_replace('%%$reward_name%%',$_REQUEST['name'],$cms_rep);
			$cms_rep=str_replace('%%$description%%',$_REQUEST['description'],$cms_rep);
			$cms_rep=str_replace('%%$start_date%%',$_REQUEST['start_date'],$cms_rep);
			$cms_rep=str_replace('%%$end_date%%',$_REQUEST['end_date'],$cms_rep);
			$cms_rep=str_replace('%%$point%%',$_REQUEST['reward_point'],$cms_rep);
			$cms_rep=str_replace('%%$reward_type%%',$reward_ty_nm,$cms_rep);
			
			$from = 'support@foodandmenu.com';
		
			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
		
			$headers .= 'MIME-Version: 1.0' . "\r\n";
		
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
		
			$message=$cms_rep;
			
			$subject = stripslashes($sql_cms['subject']);
			
			mail($email_cust,$subject,$message,$headers);
		}
	}
		
		header("location:manage_rewards.php?success=1");
		
	}
	else
	{
		header("location:manage_rewards.php?error=1");
	}
			
	}
?>
<div class="dashboard_section_in">
<script type="text/javascript" src="../js/jquery-1.8.3.js"></script>

<script type="text/javascript" src="../js/jquery-ui.js"></script>

<link rel="stylesheet" href="../calender/jquery-ui.css" />
<script src="../calender/jquery-1.8.3.js"></script>
<script src="../calender/jquery-ui.js"></script>
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
	if(document.getElementById('name').value=='')
	{
		alert ('Please enter Name.');
		document.getElementById('name').focus();
		return false;
	}
	if(document.getElementsByName('reward_type').value=='')
	{
		alert ('Please enter Reward Type.');
		document.getElementById('reward_type').focus();
		return false;
	}
	var chks = document.getElementsByName('reward_type[]');
	var hasChecked = false;
	for (var i = 0; i < chks.length; i++)
	{
	if (chks[i].checked)
	{
	hasChecked = true;
	break;
	}
	}
	if (hasChecked == false)
	{
	alert("Please select Reward Type.");
	return false;
	}
	if(document.getElementById('reward_point').value=='')
	{
		alert ('Please enter Reward Point.');
		document.getElementById('reward_point').focus();
		return false;
	}
	if(document.getElementById('redeemable_point').value=='')
	{
		alert ('Please enter Redeemable Point.');
		document.getElementById('redeemable_point').focus();
		return false;
	}
	if(document.getElementById('start_date').value=='')
	{
		alert ('Please Enter Start Date.');
		document.getElementById('start_date').focus();
		return false;
	}
	if(document.getElementById('end_date').value=='')
	{
		alert ('Please Enter End Date.');
		document.getElementById('end_date').focus();
		return false;
	}
	if(document.getElementById('status').value=='')
	{
		alert ('Please Select Status.');
		document.getElementById('status').focus();
		return false;
	}
	
	if(document.getElementById('amount').value=='')
	{
		alert ('Please Enter Amount.');
		document.getElementById('amount').focus();
		return false;
	}
	
	
	
	
	
	
    return true;
}

var $j = jQuery.noConflict();
$j( document ).ready(function() {
 var enq_dat = new Date();
 $j(window).on('load',function() {
   $j('#end_date').datepicker('option', 'minDate', enq_dat);
 });   
});
$j(function()
{
    $j('#start_date').datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat:"mm-dd-yy",
  onSelect: function(dateStr) {
    var date = $j(this).datepicker('getDate');    
    if (date) {
    date.setDate(date.getDate());
    }
    $j('#end_date').datepicker('option', 'minDate', date);
  }
      });
      $j('#end_date').datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat:"mm-dd-yy",
  onSelect: function (selectedDate) {
    var date = $j(this).datepicker('getDate');
    if (date) {
    date.setDate(date.getDate());
    }
    $j('#start_date').datepicker('option', 'maxDate', date || 0);
  }
      });
});
</script>
<script type="text/javascript">
function open_filter_tr()
{
	var $j = jQuery.noConflict();
	
	$j("#filter_tr").slideToggle();
	
	if($j("#filter_tr").css('display') == 'none')
	{
		 $j("input:radio[name='option']").each(function (i) {        
        	this.checked = false;
    	 });
		$j("#replace_tr").html('');
	}
	
}

function get_desired_list(val,cond)
{
	var $j = jQuery.noConflict();
	
	if(cond == '')
	{
		if(val != '')
		{
				$j.ajax({
				url : 'get_state_list.php',
				type : 'POST',
				data : 'val=' + val + '&cond=' + cond,
				//dataType : 'json',
				beforeSend : function(jqXHR, settings ){
					//alert(url);
				},
				success : function(data, textStatus, jqXHR){
					//alert(data);
					$j('#replace_tr').html(data).slideDown(1000);
				},
				/*complete : function(jqXHR, textStatus){
					alert(3);
				},*/
				error : function(jqXHR, textStatus, errorThrown){
				}
			});
		}
	}
	else
	{
		$j.ajax({
				url : 'get_state_list.php',
				type : 'POST',
				data : 'val=' + val + '&cond=' + cond,
				//dataType : 'json',
				beforeSend : function(jqXHR, settings ){
					//alert(url);
				},
				success : function(data, textStatus, jqXHR){
					//alert(data);
					$j('#city_tr').html(data).slideDown(1000);
				},
				/*complete : function(jqXHR, textStatus){
					alert(3);
				},*/
				error : function(jqXHR, textStatus, errorThrown){
				}
			});
	}
}

</script>
<h2 style="background:#FA8730; color:#fff; padding:8px;">Add Reward Point</h2>
<form name="frmchangpass" action="" method="post" onsubmit="return validate();" enctype="multipart/form-data">
 <table width="90%" border="0" cellspacing="2" cellpadding="2" class="list-tbl"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Name <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="name" id="name" type="text" class="login_ipboxin"  value=""></td>
  </tr>
  
  
  
  
  
  
  
  <tr>
    <td class="text1" align="right">Description :</td>
    <td class="normaltext"><textarea id="description" cols="25" rows="5" name="description" style="width: 282px; height: 92px;"></textarea>
    <script type="text/javascript">

				CKEDITOR.replace( 'description',

				{
					toolbar:[['Source','-','Bold','Italic','Underline','-','Undo','Redo','-','Find','Replace','-','SelectAll','-','Scayt','-','About']],
					fullPage : false,

					extraPlugins : 'docprops'

				});

			</script></td>
  </tr>
   <tr>
    <td class="text1" align="right">Reward Type <font color="#FF0000">*</font>:</td>
    <td class="normaltext">
    <?php $sql_sel = mysql_query("SELECT * FROM restaurant_reward_type_master WHERE 1");
	while($array_sel = mysql_fetch_array($sql_sel)){ ?>
    <input type="checkbox" name="reward_type[]" value="<?php echo $array_sel['id']; ?>" /><span class="text1"> <?php echo $array_sel['name']; ?> </span><br />
    <?php } ?> </td>
  </tr>
  <tr>
    <td class="text1" align="right">Reward Point <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="reward_point" id="reward_point" type="text" class="login_ipboxin"  value="" onkeypress="return goodchars(event,'1234567890.');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Redeemable Point <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="redeemable_point" id="redeemable_point" type="text" class="login_ipboxin"  value="" onkeypress="return goodchars(event,'1234567890.');"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Start Date <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="start_date" id="start_date" type="text" class="login_ipboxin" readonly="readonly"  value="" autocomplete="off"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Expiry Date <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="end_date" id="end_date" type="text" class="login_ipboxin"  readonly="readonly" value="" autocomplete="off"></td>
  </tr>
  <tr>
    <td class="text1" align="right">Status <font color="#FF0000">*</font>:</td>
    <td class="normaltext">
    <select name="status" id="status" class="login_ipboxin" style="height:28px; width:286px;">
        <option value="">Select</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select></td>
  </tr>
  <tr>
    <td class="text1" align="right">Promote :</td>
    <td class="normaltext"><input name="promote" id="promote" type="checkbox" value="1" onclick="open_filter_tr();"> <span class="text1">(Click here to select the listing type.)</span></td>
  </tr>
  <tr id="filter_tr" style="display:none;">
    <td class="text1" align="right"></td>
    <td class="text1" align="left" style="text-align:left !important;">
     <input type="radio" name="option" id="option" value="state" onclick="get_desired_list(this.value,'');"  /> State
   <?php /*?> <input type="radio" name="option" id="option" value="city" onclick="get_desired_list(this.value);"  /> City<?php */?>
    <input type="radio" name="option" id="option" value="user" onclick="get_desired_list(this.value);"  /> User
    </td>
  </tr>
  
  <tr>
    <td class="text1" align="right">Amount <font color="#FF0000">*</font>:</td>
    <td class="normaltext"><input name="amount" id="amount" type="text" class="login_ipboxin"  value=""></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td id="replace_tr" class="list-class"> </td>
  </tr>
  
  <tr>
  	<td>&nbsp;</td>
    <td id="city_tr" class="list-class"> </td>
  </tr>
  
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input name="submit" type="submit" value="Add" class="normalbutton"></td>
  </tr>
</table>
</form>
</div>
<?php

}
require_once"template_admin.php";
?>