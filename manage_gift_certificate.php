<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
if(!isset($_SESSION['restaurant_admin_panel_id'])){
	header('location:restaurant_admin_login.php');
}
//rest_chk_authentication();
//print_r($_SESSION);
//echo $_SESSION['restaurant_admin_panel_id'];
function change_dateformat_reverse_db1($date_form1)
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

?>

<script type="text/javascript">

function change_status(validation_code){
	
	var $j = jQuery.noConflict();
	//var arr_user = user.split(",");
	
	$j.ajax({
		url : 'change_used_status.php',
		type : 'POST',
		data : 'validation_code=' + validation_code,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			
			$j("#change_status_msg").html(data);
			$j("#used_td"+validation_code).html('<span style="color:#35aa47;font-weight:bold;">Already Used.</span>');
			
			//alert(emp_all);
	
	//alert($j('#assign_new'+id).css('display'));
	
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
	return false;
	
}

function open_confirm_order(id)
{
	var $j = jQuery.noConflict();
	
	$j("#confirm_div"+id).show();
	$j("#fade1").show();
}

function close_confirm_div(id)
{
	var $j = jQuery.noConflict();
	
	$j("#confirm_div"+id).hide();
	$j("#fade1").hide();
}


function confirm_gift_certificate(validation_code,id){
	
	var $j = jQuery.noConflict();
	
	var user_val_code = $j("#user_val_code"+id).val();
	var certificate_no = $j("#certificate_no"+id).val();
	
	if(user_val_code != '' && certificate_no != '')
	{
	
		$j.ajax({
			url : 'confirm_gift_certificate_res.php',
			type : 'POST',
			data : 'validation_code=' + validation_code + '&user_val_code=' + user_val_code + '&certificate_no=' + certificate_no,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				//var val_code = "'"+validation_code+"'";
				
				$j("#confirm_div"+id).hide();
				$j("#fade1").hide();
				$j("#change_status_msg").html(data);
				
				if(data == "Gift Certificate marked as used Successfully.")
				{
					$j("#used_td"+validation_code).html('<span style="color:#35aa47;font-weight:bold;">Already Used.</span>');
				}
				//$j("#used_td"+validation_code).html('<a href="javascript:void(0);" onClick="change_status('+val_code+')" class="used_cls">Mark As Used</a>');
				
				//alert(emp_all);
		
		//alert($j('#assign_new'+id).css('display'));
		
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
	}
	elseif(user_val_code == '')
	{
		$j("#error_msg_div"+id).html('This Field Should not be Empty.');
		return false;
	}
	elseif(certificate_no == '')
	{
		$j("#error_msg_div1"+id).html('This Field Should not be Empty.');
		return false;
	}
	
}





function sort_function(sort_by,order_id,customer_name,customer_address,customer_phone,status){
	location.href = 'manage_gift_certificate.php?sort_order='+sort_by;
}

</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<script type="text/javascript">
var $j = jQuery.noConflict();

$j(function() {
  var pickerOpts = {
	changeMonth: true,
	changeYear: true,
    dateFormat:"mm-dd-yy"
}; 
$j( "#start_date" ).datepicker(pickerOpts);
});

$j(function() {
  var pickerOpts = {
	changeMonth: true,
	changeYear: true,
    dateFormat:"mm-dd-yy"
}; 
$j( "#end_date" ).datepicker(pickerOpts);
});
</script>

<script type="text/javascript" src="https://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="https://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
	
	var $j = jQuery.noConflict();
	
  $j(document).ready(function() {
   /*
   *   Examples - images
   */
   
   
   $j("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script>
 
<style type="text/css">

#fancybox-content{
	width:100% !important;
}

#fancybox-content #printdiv div{
	width:100% !important;
}

#fancybox-content #printdiv div table{
	width:100%;
}

</style>

<body>

<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont restu_live_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">

<p style="color:#454EA8; font-size:21px;">Search Panel</p><br>
<form name="frm" method="post" action="">
<table class="sec-pnl-top"><tr>
<td width="114">Username : </td><td width="219"><input type="text" name="username" value="<?php echo $_REQUEST['username'];?>" style="height:23px;" class="restaurant"></td>
<td width="152">Certificate No : </td><td width="219"><input type="text" name="certificate_no" value="<?php echo $_REQUEST['certificate_no'];?>" style="height:23px;" class="restaurant">
</td>
<?php /*?><td width="86">Validation Code : </td><td width="247"><input type="text" name="validation_code" value="<?php echo $_REQUEST['validation_code'];?>" style="height:23px;" class="restaurant">
</td><?php */?>
</tr>
<tr>
<td>Start date : </td>
<td><input type="text" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date'];?>" style="height:23px;" class="restaurant"></td>
<td>End Date : </td>
<td><input type="text" name="end_date" id="end_date" value="<?php echo $_REQUEST['end_date'];?>" style="height:23px;" class="restaurant"></td>
<td width="86"><input type="submit" name="submit" value="Search" class="button4" style="margin:0px;"></td>
<td width="67"><a href="manage_gift_certificate.php" style="text-decoration:none;"><input type="button" name="show_all" value="Show All" class="button4" style="margin:0px;"></a></td>

</tr>
</table>
</form>

<form name="frm1" id="frm1" method="post" action="manage_gift_certificate.php">
<div align="right"  class="sort">
Items Per Page : <select name="item_per_page" id="item_per_page" onChange="frm1.submit();">
<option value="25"<?php if($_REQUEST['item_per_page'] == 25) { ?> selected <?php } ?>>25</option>
<option value="50"<?php if($_REQUEST['item_per_page'] == 50) { ?> selected <?php } ?>>50</option>
<option value="75"<?php if($_REQUEST['item_per_page'] == 75) { ?> selected <?php } ?>>75</option>
<option value="100"<?php if($_REQUEST['item_per_page'] == 100) { ?> selected <?php } ?>>100</option>
</select>
</div>

</form>


<div id="change_status_msg" style="text-align:center;"></div>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<th width="4%" class="all_restaurant">Sl No.</th>
    <th width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.purchase_date')" class="heading_link">Purchase Date</a></th>
    <th width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.certificate_no')" class="heading_link">Certificate No</a></th>
    <th width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.user_name')" class="heading_link">Username</a></th>
    <th width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.deal')" class="heading_link">Deal</a></th>
    <?php /*?><td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.validation_code')" class="heading_link">Validation Code</a></td><?php */?>
    <th width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.expiry_date')" class="heading_link">Expiry Date</a></th>
    <th width="14%" class="all_restaurant">View Certificate</th>
    <th width="14%" class="all_restaurant">Action</th>
    
  </tr>
  <?php 
$query_res = ("SELECT t1.*,t2.giftcard_id, t2.certificate_no, t2.validation_code, t2.expiry_date, t2.used , t2.confirm_status ,t2.deal_id ,t2.restaurant_id FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 WHERE t1.restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."' AND t1.id = t2.giftcard_id AND t2.restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."'");


//$query_res = ("SELECT t1.*,t2.giftcard_id, t2.certificate_no, t2.validation_code, t2.expiry_date, t2.used , t2.confirm_status ,t2.deal_id ,t2.restaurant_id FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 ");




if($_REQUEST['certificate_no']!=''){
	$query_res.=  " AND certificate_no = '".$_REQUEST['certificate_no']."'";
}
if($_REQUEST['validation_code']!=''){
	$query_res.=  " AND validation_code = '".$_REQUEST['validation_code']."'";
}
if($_REQUEST['username']!=''){
	$query_res.=  " AND user_name LIKE '%".$_REQUEST['username']."%'";
}
if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!=''){
	$start_date = change_dateformat_reverse_db1($_REQUEST['start_date']);
	$end_date = change_dateformat_reverse_db1($_REQUEST['end_date']);
	$query_res.=" AND purchase_date >= '".$start_date." 00:00:00' AND purchase_date <= '".$end_date." 59:59:59'";
}
if($_REQUEST['sort_order']!=''){
	$query_res.= " ORDER BY ".$_REQUEST['sort_order']." ASC ";
}else{
	$query_res.= " ORDER BY t1.id DESC ";
}

//echo $query_res;


$sql_num_rows = mysql_query($query_res);

  if(mysql_num_rows($sql_num_rows) > 0){
	  
		//////////////////////start pagination/////////////////////////
		if($_REQUEST['search']!="")
		{
			$page=1;
		}
		else
		{
			$page=$_REQUEST['page'];
			
			if($_REQUEST['page']=="") 
			{ 
			$page = 1; 
			} 
		}
		if($_REQUEST['item_per_page'] == "")
		{
			$max_results = 25; 
		}
		else
		{
			$max_results = $_REQUEST['item_per_page'];
		}  
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sql_num_rows); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"manage_gift_certificate.php?page=$prev&item_per_page=".$_REQUEST['item_per_page']."&username=".$_REQUEST['username']."&certificate_no=".$_REQUEST['certificate_no']."&validation_code=".$_REQUEST['validation_code']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		for($i = 1; $i <=$total_pages; $i++) 
		{ 
		if(($page) == $i) 
		{ 
		$pagination .= $i; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		else 
		{ 
		$pagination .= "<a href=\"manage_gift_certificate.php?page=$i&item_per_page=".$_REQUEST['item_per_page']."&username=".$_REQUEST['username']."&certificate_no=".$_REQUEST['certificate_no']."&validation_code=".$_REQUEST['validation_code']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_gift_certificate.php?page=$next&item_per_page=".$_REQUEST['item_per_page']."&username=".$_REQUEST['username']."&certificate_no=".$_REQUEST['certificate_no']."&validation_code=".$_REQUEST['validation_code']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
		if($_REQUEST['page']!="")
		{
			$j=($_REQUEST['page']-1)*$max_results;
		}
		if($_REQUEST['search']!="")
		{
		$j=0;	
		}
	  ?>	
  
  <?php $inc = 1;
  
  $curr_date = date('Y-m-d');
  
  while($array_all_certificate = mysql_fetch_array($query_products)){
  ?>
  <tr>
  	<td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_all_certificate['purchase_date'])); ?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['certificate_no'];?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['user_name']; ?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['deal'];?></td>
    <?php /*?><td class="all_restaurant2"><?php echo $array_all_certificate['validation_code'];?></td><?php */?>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_all_certificate['expiry_date']));?></td>
    <td class="all_restaurant2 view_certificate"><a href="view_certificate.php?giftcard_id=<?php echo $array_all_certificate['id']; ?>&noprint=yes"  class="example_cat" >View Certificate</a></td>
    
    <td class="all_restaurant2" id="used_td<?php echo $array_all_certificate['validation_code']; ?>">
    <?php
	if($array_all_certificate['used'] == 0 )
	{
		if($array_all_certificate['confirm_status'] == 'Confirmed')	
		{
			//if($curr_date < $array_all_certificate['expiry_date'])
			//{
		?>
			<a href="javascript:void(0);" onClick="open_confirm_order('<?php echo $inc; ?>')" class="used_cls">Mark As Used</a>
			</td>
		<?php
			/*}
			else
			{
				echo "<span style='color:#F00;font-weight:bold;'>Expired.</span>";
			}*/
		}
		else
		{
			echo "<span style='color:#F00;font-weight:bold;' class='view_certificate'>Not Confirmed by Admin.<br></a></span>";
			
			//<br><a href='javascript:void(0);' onClick='open_confirm_order(".$inc.");'>Click Here to Confirm
		}
	}
	else
	{
		echo "<span style='color:#35aa47;font-weight:bold;'>Already Used.</span>";
	}
	?>
    
  </tr>
  
  
			<div id="confirm_div<?php echo $inc; ?>" style="display:none;" class="assign_item white_content"  >
                    
                    <div class="close close-new" onClick="close_confirm_div('<?php echo $inc; ?>');"><a href = "javascript:void(0);"> </a> </div>
                    	<div class="l-contnt up-contnt pop-up-cont"> 
                        
                        
                        <h2 class="pop-title up_nw_load_nw" style="margin-bottom: 6px;">Mark Gift Certificate As Used</h2>
                        
                        <div class="form-body reason_reject">
                                
                               		<div class="form-group">
										<label class="control-label pop-text">Validation Code                                  			<span class="required">*</span>        
										</label>
                                        
                                        <div class="text_pad pop-fild">
                       
                                           <input type="text" name="validation_code" id="user_val_code<?php echo $inc; ?>" class="restaurant">
                                             
                                            <div id="error_msg_div<?php echo $inc; ?>" style="color:#F00;"></div>
                                            
                                           
                                            
                                            
                                            </div>
                                        
                                        </div>
                                        
                                        <div class="form-group">
										<label class="control-label pop-text">Certificate No.                                  			<span class="required">*</span>        
										</label>
                                        
                                        <div class="text_pad pop-fild">
                       
                                           <input type="text" name="certificate_no" id="certificate_no<?php echo $inc; ?>" class="restaurant">
                                             
                                            <div id="error_msg_div1<?php echo $inc; ?>" style="color:#F00;"></div>
                                            
                                           
                                            
                                            
                                            </div>
                                        
                                        </div>
										
                        		
                        
                            <div class="btn-row" style="margin-top:10px">
										<input type="submit" name="reject" id="reject" value="Submit" class="button4" onClick="confirm_gift_certificate('<?php echo $array_all_certificate['validation_code']; ?>','<?php echo $inc; ?>');">
                                        <button type="button" class="button4" onClick="close_confirm_div('<?php echo $inc; ?>');">Cancel</button>
                                      </div> 
                                       </div>
                        
                        
                        </div>
                        </div>
                        <div id="fade1" class="black_overlay"> </div>

  <?php $inc++; } } else { ?>
  <tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No Gift Certificates</td>
  </tr>
  <?php } ?>
</table>

<?php if($total_pages > 1){ ?>
<div style="text-align:center; margin-top:10px;"><?php echo $pagination; ?></div><?php } ?>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

