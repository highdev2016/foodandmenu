<?php 
ob_start();
function main()
{
$sql_newsletter = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_newsletter WHERE  newsletter_id = '".$_REQUEST['id']."'"));
$sql_select = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_admin WHERE id = 1"));

if($_REQUEST['submit'] == 'Send'){
	
	/*$sql_send = mysql_query("SELECT * FROM restaurant_subscriber WHERE 1");
	while($array_send = mysql_fetch_array($sql_send)){
	
	}*/
	/*if(isset($_POST['send_to']) && !empty($_POST['send_to'])){*/
		//$email_ids = implode(',', $_POST['send_to']);
		foreach($_POST['send_to'] as $values)
		{
		$email=$values;
		$sql = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_subscriber WHERE email = '".$email."'"));
		$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE email = '".$email."'"));
		$url="<a href='https://www.foodandmenu.com/newsletters_unsubscribe.php?action=view&id=".$sql_customer['id']."' target='_blank'>
	https://www.foodandmenu.com/newsletters_unsubscribe.php?action=view&id=".$sql_customer['id']."</a>";
		
		$cms_rep = $sql_newsletter['content'];//
		
		$cms_rep.='To Unsubscribe click here :'.$url;
		
		$from = $sql_select['email_id'];
		
		$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
		
		$headers.= 'MIME-Version: 1.0' . "\r\n";
		
		$headers.= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
		
		$message=$cms_rep;
		
		$subject=$sql_newsletter['title'];
		
		$send = mail($email,$subject,$message,$headers);
		
		if($send){
			header("location:manage_newsletter.php?send=1");
		}
	}
	
	//}else{
		//echo 'Please Select Emails First';
	//}
}
?>

<script type="text/javascript">
function check_email(){
var chks = document.getElementsByName('checkbox1[]');
var checkCount = 0;
var text = new Array();
var text1 = new Array();
var strtext = "";
 
for (var i = 0; i < chks.length; i++)
{
if (chks[i].checked)
{
    var arlength = text.length;
    text[arlength] = chks[i].value;
}
}
strtext = text.join(",");
//alert(strtext);
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp1=false; 
	try{
		xmlhttp1=new XMLHttpRequest();
	}
	catch(e) {  
    try{   
	xmlhttp1= new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e){
	try{
	xmlhttp1 = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e1){
	xmlhttp1=false;
	}
	}
	}
	return xmlhttp1;
	}

	$.ajax({
		url : 'get_subscriber_city.php',
		type : 'POST',
		data : 'city=' + strtext,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("||");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('send_to_div').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}

function get_city(state){
	$.ajax({
		url : 'get_news_state_city.php',
		type : 'POST',
		data : 'state=' + state,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("||");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('subscriber_city').innerHTML=subCat;
			document.getElementById('sub_city').innerHTML="City : ";
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}

</script>

<div class="dashboard_section_in">
<form name="frmproduct" action="" method="post">
<input type="hidden" name="package_details_id" value="<?php echo $_REQUEST['product_id']?>" />
<input type="hidden" name="action" value="<?php echo $_REQUEST['action']?>" />
<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />
<input type="hidden" name="search_market" value="<?php echo $_REQUEST['search_market']?>" />
<input type="hidden" name="subs_city" id="subs_city" value="" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Newsletter</h2>
                 </td>
               </tr>
               <tr>
                 <td style="float:right;"><input type="button" name="back" value="Back" onclick="history.back();" class="normalbutton"/></td>
               </tr>
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>           
           <tr>
             <td></td>
           </tr>
           <tr>
             <td><table width="85%" border="0" cellspacing="2" cellpadding="2"  style="padding:3px;" height="160" align="center" >
  <tr>
    <td colspan="2" class="text2"></td>
  </tr>
  
  <?php /*?><tr>
    <td class="text1" align="right" valign="top">State :</td>
    <td class="text1" style="text-align:left;">
    <select name="restaurant_state" id="restaurant_state" class="login_ipboxin" style="width:250px; height:27px; padding:0px;" onchange="get_state_city(this.value);" >
                  	<option value="">Select</option>
                    <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='' ORDER BY restaurant_state");
				  while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
					<option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['restaurant_state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
                  <?php } ?>
                  </select>
    </td>
  </tr><?php */?>
  
  <tr>
    <td class="text1" align="right" valign="top">State :</td>
    <td class="text1" style="text-align:left;">
    <select name="state" id="state" onchange="get_city(this.value);" style="width:200px;">
    <option value="">Select</option>
    <?php $sql_state = mysql_query("SELECT distinct(state) FROM restaurant_customer WHERE state!='' ORDER BY state");
	while($array_state = mysql_fetch_array($sql_state)){ ?>
    <option value="<?php echo $array_state['state']; ?>"><?php echo $array_state['state']; ?></option>
    <?php } ?>
    </select>
    </td>
  </tr>
  
<?php /*?>  <?php $sql_select = mysql_query("SELECT DISTINCT(subscriber_city) FROM restaurant_subscriber WHERE subscriber_city!='' AND status = 1");
  if(mysql_num_rows($sql_select)>0){?><?php */?>
  <tr>
    <td class="text1" align="right" valign="top">
    <div id="sub_city"></div>
    </td>
    <td class="text1" style="text-align:left;">
    <div id="subscriber_city">
    <?php /*?><?php while($array_select = mysql_fetch_array($sql_select)){ ?>
	<input type="checkbox" name="checkbox1[]" value="<?php echo $array_select['subscriber_city']; ?>" style="margin-left:11px;" onclick="return check_email()" /><?php echo $array_select['subscriber_city']."<br>"; ?>
	<?php } ?><?php */?>
    </div>
    </td>
  </tr>
  <?php /*?><?php } ?><?php */?>
  
  <tr>
    <td width="41%" align="right" valign="top" class="text1">Send To :</td>
    <td width="59%" class="normaltext" style="color:#919191; font-family:Trebuchet MS;">
	<a href="#" onclick="check_send_all(); return false;">Check All</a>/<a href="#" onclick="uncheck_send_all(); return false;">Uncheck All</a>
    <div style="border: 1px solid #000000; height: 200px; overflow: auto; padding-left: 5px; width: 400px;">
    <div id="send_to_div">
    <?php
	$sql_send = mysql_query("SELECT id,email FROM restaurant_customer WHERE newsletter_subscription = 1 ORDER BY email");
	$count = 1;
	while($array_send = mysql_fetch_assoc($sql_send)){
		echo ' <input type="checkbox" name="send_to[]"  value="'.$array_send['email'].'" /><input type="hidden" name="send_id['.$array_send['id'].']"  value="'.$array_send['email'].'" />' . $array_send['email'].'<br />';
		$count++;
	}
	?>
    </div>
    </div>
    </td>
  </tr>
  <tr>
    <td width="41%" align="right" class="text1">Newsletter Title :</td>
    <td width="59%" class="normaltext" style="color:#919191; font-family:Trebuchet MS;"><?php echo $sql_newsletter['title'];?></td>
  </tr>
   <tr>
    <td class="text1" align="right" valign="top">Content :</td>
    <td class="normaltext">
    <?php echo $sql_newsletter['content'];?>
</td>
  </tr>
  <tr>
    <td class="inputheading" align="right">&nbsp;</td>
    <td class="normaltext"><input type="submit" name="submit" value="Send" class="normalbutton" /></td>
  </tr>
</table></td></tr></table>
      </table>
</form> 


<script type="text/javascript">
function check_send_all(){
	var checkboxes = document.getElementsByName('send_to[]');
	for (var i in checkboxes){
		checkboxes[i].checked = true;
	}
}
function uncheck_send_all(){	
	var checkboxes = document.getElementsByName('send_to[]');
	for (var i in checkboxes){
		checkboxes[i].checked = false;
	}
}
</script>   


</div>

<?php
}
require_once"template_admin.php";
?>