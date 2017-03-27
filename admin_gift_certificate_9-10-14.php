<?php
ob_start();
session_start();
if(!isset($_SESSION['admin_login_id'])){
	header("location:admin_login.php");
}
//print_r($_SESSION);
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");

//rest_chk_authentication();
//print_r($_SESSION);

if($_REQUEST['export'] == "Export to Excel")
{
	header("location:export_admin_gift_excel.php?restaurant_name=".$_REQUEST['restaurant_name']."&certificate_no=".$_REQUEST['certificate_no']."&validation_code=".$_REQUEST['validation_code']."&mod_date=".$_REQUEST['mod_date']."&cust_date=".$_REQUEST['cust_date']);
}


function change_dateformat_reverse_db($date_form1)
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






function sort_function(sort_by,order_id,customer_name,customer_address,customer_phone,status){
	location.href = 'admin_gift_certificate.php?sort_order='+sort_by;
}
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
var $j = jQuery.noConflict();

$j(function() {
  var pickerOpts = {
	changeMonth: true,
	changeYear: true,
    dateFormat:"mm-dd-yy"
}; 
$j( "#cust_date" ).datepicker(pickerOpts);
});

function open_cust_date(val)
{
	if(val == 'Custom Date')
	{
		$j("#cust_date").show(500);
	}
	else
	{
		$j("#cust_date").hide(500);
	}
}
</script>

<body>
<?php include ("includes/menu_admin_add_res_front.php");?>
<?php //include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<?php include ("includes/admin_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">


<p style="color:#454EA8; font-size:21px;">Search Panel</p><br>
<form name="frm" method="post" action="admin_gift_certificate.php">
<table class="sec-pnl-top">
  <tr>
	<td width="150">Certificate No : </td>
	<td width="184"><input type="text" name="certificate_no" value="<?php echo $_REQUEST['certificate_no'];?>" style="height:23px; width: 150px;" class="restaurant"></td>
	<td width="150">Validation Code : </td>
	<td width="184"><input type="text" name="validation_code" value="<?php echo $_REQUEST['validation_code'];?>" style="height:23px; width: 150px;" class="restaurant"></td>

	<td width="150">Restaurant Name : </td>
    <td width="184"><input type="text" name="restaurant_name" value="<?php echo $_REQUEST['restaurant_name'];?>" style="height:23px;  width: 150px;" class="restaurant"></td>
  </tr>
  
  <tr>
	<td width="150">Date : </td>
    <td width="184">
    	<select class="restaurant" style="" name="mod_date" id="mod_date" onChange="open_cust_date(this.value);">
		    <option value="">---SELECT---</option>
		    <option value="This Month"<?php if($_REQUEST['mod_date'] == 'This Month') { ?> selected <?php } ?>>This Month</option>
		    <option value="Last Month"<?php if($_REQUEST['mod_date'] == 'Last Month') { ?> selected <?php } ?>>Last Month</option>
		    <option value="Last Week"<?php if($_REQUEST['mod_date'] == 'Last Week') { ?> selected <?php } ?>>Last Week</option>
		    <option value="Custom Date"<?php if($_REQUEST['mod_date'] == 'Custom Date') { ?> selected <?php } ?>>Purchase Date</option>
	    </select>
    </td>
                <?php
				if($_REQUEST['mod_date'] == 'Custom Date')
				{
					$display = 'block';
				}
				else
				{
					$display = 'none';
				}
				?>
    <td width="150" id="cust_date_td" colspan="3"> 
    	<input style="display:<?php echo $display; ?>;"   type="text" name="cust_date" id="cust_date" value="<?php echo $_REQUEST['cust_date']; ?>">
    </td>
                
    <td align="right" style="padding-right:3px; ">
    	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
    	<a href="admin_gift_certificate.php" class="button4" style="margin:0px; text-decoration:none; padding:6px 12px;">
    		Show All
    		<!-- <input type="button" name="show_all" value="Show All" class="button4" style="margin:0px;"> -->
    	</a> </td>
    		<td><input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0px;"></td>
    
	
</tr>
</table>
</form>

<div id="change_status_msg" style="text-align:center;"></div>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="4%" class="all_restaurant">Sl No.</td>
    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.user_name')" class="heading_link">Username</a></td>
    <td width="4%" class="all_restaurant">Restaurant Name</td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.deal')" class="heading_link">Deal</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.purchase_date')" class="heading_link">Purchase Date</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.price')" class="heading_link">Amount</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.certificate_no')" class="heading_link">Certificate No</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.validation_code')" class="heading_link">Validation Code</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.expiry_date')" class="heading_link">Expiry Date</a></td>
    <td width="14%" class="all_restaurant">Action</td>
    
  </tr>
  <?php 
$query_res = ("SELECT t1.*,t2.* FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 WHERE t1.id = t2.giftcard_id");

if($_REQUEST['certificate_no']!=''){
	$query_res.=  " AND certificate_no = '".$_REQUEST['certificate_no']."'";
}
if($_REQUEST['validation_code']!=''){
	$query_res.=  " AND validation_code = '".$_REQUEST['validation_code']."'";
}

if($_REQUEST['mod_date']!='')
  {
	  if($_REQUEST['mod_date'] == 'This Month')
	  {
	  	$query_res.=" AND date_format(purchase_date,'%Y-%m') = '".date("Y-m")."' ";
	  }
	  if($_REQUEST['mod_date'] == 'Last Month')
	  {
	  	$query_res.=" AND date_format(purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
	  }
	  if($_REQUEST['mod_date'] == 'Last Week')
	  {
		  $query_res.=" AND YEARWEEK(purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
	  }
	   if($_REQUEST['mod_date'] == 'Custom Date')
	  {
		  $custom_date = change_dateformat_reverse_db($_REQUEST['cust_date']);
		  $query_res.=" AND date_format(purchase_date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
	  }
  }
  
  if($_REQUEST['restaurant_name']!=''){
	  	  
	  $res_all_id = mysql_fetch_array(mysql_query("SELECT restaurant_name FROM restaurant_gift_card WHERE 1"));
	  $res_filter = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_name LIKE '".$_REQUEST['restaurant_name']."%'"));
	  
	  if($res_filter['id'] == '')
	  {
		  $res_filter['id'] = 0;
	  }

	  $query_res.=" AND t1.restaurant_id in (".$res_filter['id'].")";
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
		$max_results =10; 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sql_num_rows); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"admin_gift_certificate.php?page=$prev&mod_date=".$_REQUEST['mod_date']."&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"admin_gift_certificate.php?page=$i&mod_date=".$_REQUEST['mod_date']."&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"admin_gift_certificate.php?page=$next&mod_date=".$_REQUEST['mod_date']."&restaurant_name=".$_REQUEST['restaurant_name']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
		if($_REQUEST['page']!="")
		{
			$j=($_REQUEST['page']-1)*10;
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
    <td class="all_restaurant2"><?php echo $array_all_certificate['user_name']; ?></td>
    <td class="all_restaurant2"><?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$array_all_certificate['restaurant_id']);?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['deal'];?></td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_all_certificate['purchase_date'])); ?></td>
    <td class="all_restaurant2"><?php echo "$ ".$array_all_certificate['price'];?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['certificate_no'];?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['validation_code'];?></td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_all_certificate['expiry_date']));?>
    <td class="all_restaurant2" id="used_td<?php echo $array_all_certificate['validation_code']; ?>">
    <?php
	if($array_all_certificate['used'] == 0 )
	{
		if($array_all_certificate['confirm_status'] == 'Confirmed')	
		{
			if($curr_date < $array_all_certificate['expiry_date'])
			{
		
				echo "Not Used";
			?>
			</td>
			<?php
			}
			else
			{
				echo "<span style='color:#F00;font-weight:bold;'>Expired.</span>";
			}
		}
		else
		{
			echo "<span style='color:#F00;font-weight:bold;'>Not Confirmed by Admin.</span>";
		}
	}
	else
	{
		echo "<span style='color:#35aa47;font-weight:bold;'>Already Used.</span>";
	}
	?>
    
  </tr>
  


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

