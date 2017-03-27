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
	header("location:export_admin_gift_excel.php?restaurant_name=".$_REQUEST['restaurant_name']."&certificate_no=".$_REQUEST['certificate_no']."&validation_code=".$_REQUEST['validation_code']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']);
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



function sort_function(sort_by,certificate_no,validation_code,restaurant_name,mod_date,cust_date){
	location.href = 'admin_gift_certificate.php?sort_order='+sort_by+'&certificate_no='+certificate_no+'&validation_code='+validation_code+'&restaurant_name='+restaurant_name+'&mod_date='+mod_date+'&cust_date='+cust_date;
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


function open_cust_date(val)
{
	if(val == 'Custom Date')
	{
		/*$j("#start_dt1").show(500);
		$j("#start_dt2").show(500);
		$j("#end_dt1").show(500);
		$j("#end_dt2").show(500);*/
		$j("#start_dt1").css('visibility', 'visible');
		$j("#start_dt2").css('visibility', 'visible');
		$j("#end_dt1").css('visibility', 'visible');
		$j("#end_dt2").css('visibility', 'visible');
	}
	else
	{
		/*$j("#start_dt1").hide(500);
		$j("#start_dt2").hide(500);
		$j("#end_dt1").hide(500);
		$j("#end_dt2").hide(500);*/
		$j("#start_dt1").css('visibility', 'hidden');
		$j("#start_dt2").css('visibility', 'hidden');
		$j("#end_dt1").css('visibility', 'hidden');
		$j("#end_dt2").css('visibility', 'hidden');
	}
}

function get_state_city(state,city){
	var $j = jQuery.noConflict();
	$j.ajax({
		url : 'get_state_city1.php',
		type : 'POST',
		data : 'state=' + state +'&city=' +city,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('restaurant_city').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}

function get_restaurant(city,restaurant){
	//alert(city);
	var $j = jQuery.noConflict();
	$j.ajax({
		url : 'get_city_restaurant1.php',
		type : 'POST',
		data : 'city=' + city +'&restaurant='+restaurant,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			/*var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];*/
			document.getElementById('restaurant_name').innerHTML=data;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
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
          <td width="150">State:</td>
          <td width="184">
          <select class="restaurant search_select" name="restaurant_state" id="restaurant_state" style="width:200px;"  onchange="get_state_city(this.value , '');">
          <option value="">--Select--</option>
          <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='' ORDER BY restaurant_state");
          while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
            <option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['restaurant_state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
          <?php } ?>
          </select>
          </td>
          <td width="150">City:</td>
          <td width="184">
          <select class="restaurant search_select" name="restaurant_city" id="restaurant_city" style="width:200px;" onChange="get_restaurant(this.value , '');">
          <option value="">--Select--</option>
          <?php /*?><?php $sql_select_city = mysql_query("SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!='' ORDER BY restaurant_city");
          while($array_select_city = mysql_fetch_array($sql_select_city)){ ?>
            <option value="<?php echo $array_select_city['restaurant_city']; ?>" <?php if($array_select_city['restaurant_city'] == $_REQUEST['restaurant_city']){?> selected="selected" <?php } ?>><?php echo $array_select_city['restaurant_city']; ?></option>
          <?php } ?><?php */?>
          </select>
          </td>
                 
         <td width="150" height="39">Restaurant Name:</td>
        <td width="184">
        <select class="restaurant search_select" name="restaurant_name" id="restaurant_name" style="width:200px;">
        <option value="">--Select--</option>
        </select></td>
         </tr>
  
  <tr>
	<td width="150">Certificate No : </td>
	<td width="184"><input type="text" name="certificate_no" value="<?php echo $_REQUEST['certificate_no'];?>" style="height:23px; width: 150px;" class="restaurant"></td>
	<td width="150">Validation Code : </td>
	<td width="184"><input type="text" name="validation_code" value="<?php echo $_REQUEST['validation_code'];?>" style="height:23px; width: 150px;" class="restaurant"></td>

	<?php /*?><td width="150">Restaurant Name : </td>
    <td width="184"><input type="text" name="restaurant_name" value="<?php echo $_REQUEST['restaurant_name'];?>" style="height:23px;  width: 150px;" class="restaurant"></td><?php */?>
  
	<td width="150">Date : </td>
    <td width="184">
    	<select class="restaurant search_select" style="" name="mod_date" id="mod_date" onChange="open_cust_date(this.value);">
        <option value="">--Select--</option>
            <option value="This Week"<?php if($_REQUEST['mod_date'] == 'This Week') { ?> selected <?php } ?>>This Week</option>
            <option value="Last Week"<?php if($_REQUEST['mod_date'] == 'Last Week') { ?> selected <?php } ?>>Last Week</option>
            <option value="Last Month"<?php if($_REQUEST['mod_date'] == 'Last Month') { ?> selected <?php } ?>>Last Month</option>
            <option value="Last 3 Month"<?php if($_REQUEST['mod_date'] == 'Last 3 Month') { ?> selected <?php } ?>>Last 3 Month</option>
            <option value="Last 6 Month"<?php if($_REQUEST['mod_date'] == 'Last 6 Month') { ?> selected <?php } ?>>Last 6 Month</option>
            <option value="Last Year"<?php if($_REQUEST['mod_date'] == 'Last Year') { ?> selected <?php } ?>>Last Year</option>
            <option value="Custom Date"<?php if($_REQUEST['mod_date'] == 'Custom Date') { ?> selected <?php } ?>>Custom Date</option>
	    </select>
    </td>
                <?php
				if($_REQUEST['mod_date'] == 'Custom Date')
				{
					$display = 'visible';
				}
				else
				{
					$display = 'hidden';
				}
				?>
				</tr>
  
  <tr>
				<td  width="184"><div id="start_dt1" style="visibility:<?php echo $display; ?>;"> Start Date : </div></td>	
				<td  width="184" id="start_dt2" style="visibility:<?php echo $display; ?>">
					<input type="text" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date']; ?>" readonly>
				</td>
				<td  width="184"><div id="end_dt1" style="visibility:<?php echo $display; ?>;">End Date : </div></td>	
				<td  width="184" id="end_dt2" style="visibility:<?php echo $display; ?>">
					<input type="text" name="end_date" id="end_date" value="<?php echo $_REQUEST['end_date']; ?>" readonly>
				</td>
                
    <td align="right" style="padding-right:22px;" colspan="2">
    	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
    	<a href="admin_gift_certificate.php" class="button4" style="margin:0px; text-decoration:none; padding:6px 12px;">
    		Show All
    		<!-- <input type="button" name="show_all" value="Show All" class="button4" style="margin:0px;"> -->
    	</a> 
    	<input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0 0 0 3px;">
    </td>
	
</tr>
</table>
</form>

<div id="change_status_msg" style="text-align:center;"></div>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<td width="4%" class="all_restaurant">Sl No.</td>
    
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.purchase_date','<?php echo $_REQUEST['certificate_no']; ?>','<?php echo $_REQUEST['validation_code']; ?>','<?php echo $_REQUSET['restaurant_name'];?>','<?php echo $_REQUEST['mod_date']; ?>','<?php echo $_REQUEST['cust_date']; ?>')" class="heading_link">Purchase Date</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.certificate_no','<?php echo $_REQUEST['certificate_no']; ?>','<?php echo $_REQUEST['validation_code']; ?>','<?php echo $_REQUSET['restaurant_name'];?>','<?php echo $_REQUEST['mod_date']; ?>','<?php echo $_REQUEST['cust_date']; ?>')" class="heading_link">Certificate No</a></td>
    <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.user_name','<?php echo $_REQUEST['certificate_no']; ?>','<?php echo $_REQUEST['validation_code']; ?>','<?php echo $_REQUSET['restaurant_name'];?>','<?php echo $_REQUEST['mod_date']; ?>','<?php echo $_REQUEST['cust_date']; ?>')" class="heading_link">Username</a></td>
    <td width="4%" class="all_restaurant">Restaurant Name</td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.deal','<?php echo $_REQUEST['certificate_no']; ?>','<?php echo $_REQUEST['validation_code']; ?>','<?php echo $_REQUSET['restaurant_name'];?>','<?php echo $_REQUEST['mod_date']; ?>','<?php echo $_REQUEST['cust_date']; ?>')" class="heading_link">Deal</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t1.price','<?php echo $_REQUEST['certificate_no']; ?>','<?php echo $_REQUEST['validation_code']; ?>','<?php echo $_REQUSET['restaurant_name'];?>','<?php echo $_REQUEST['mod_date']; ?>','<?php echo $_REQUEST['cust_date']; ?>')" class="heading_link">Amount</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.validation_code','<?php echo $_REQUEST['certificate_no']; ?>','<?php echo $_REQUEST['validation_code']; ?>','<?php echo $_REQUSET['restaurant_name'];?>','<?php echo $_REQUEST['mod_date']; ?>','<?php echo $_REQUEST['cust_date']; ?>')" class="heading_link">Validation Code</a></td>
    <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('t2.expiry_date','<?php echo $_REQUEST['certificate_no']; ?>','<?php echo $_REQUEST['validation_code']; ?>','<?php echo $_REQUSET['restaurant_name'];?>','<?php echo $_REQUEST['mod_date']; ?>','<?php echo $_REQUEST['cust_date']; ?>')" class="heading_link">Expiry Date</a></td>
    <td width="14%" class="all_restaurant">Action</td>
    <td width="14%" class="all_restaurant">Used Status</td>
    
  </tr>
  <?php 
$query_res = ("SELECT t1.*,t2.giftcard_id, t2.certificate_no, t2.validation_code, t2.expiry_date, t2.used , t2.confirm_status ,t2.deal_id ,t2.restaurant_id FROM restaurant_gift_card AS t1 , restaurant_gift_certificate_no AS t2 WHERE t1.id = t2.giftcard_id");

if($_REQUEST['certificate_no']!=''){
	$query_res.=  " AND certificate_no = '".$_REQUEST['certificate_no']."'";
}
if($_REQUEST['validation_code']!=''){
	$query_res.=  " AND validation_code = '".$_REQUEST['validation_code']."'";
}

if($_REQUEST['restaurant_state']!=''){
	$query_res.= " AND state = '".$_REQUEST['restaurant_state']."' ";
}

if($_REQUEST['restaurant_city']!=''){
	$query_res.= " AND city = '".$_REQUEST['restaurant_city']."' ";
}

if($_REQUEST['restaurant_name']!=''){
	  /*$res_all_id = mysql_fetch_array(mysql_query("SELECT restaurant_name FROM restaurant_gift_card WHERE 1"));
	  $res_filter = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_name LIKE '".$_REQUEST['restaurant_name']."%'"));
	  
	  if($res_filter['id'] == '')
	  {
		  $res_filter['id'] = 0;
	  }

	  $query_res.=" AND t1.restaurant_id in (".$res_filter['id'].")";*/
	  
	  $query_res.= " AND restaurant_id = '".$_REQUEST['restaurant_name']."' ";
	  
  }


  if($_REQUEST['mod_date']!='')
  {
	  if($_REQUEST['mod_date'] == 'This Week')
	   {
		$query_res.=" AND YEARWEEK(purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
	   }
	   if($_REQUEST['mod_date'] == 'Last Week')
	   {
		$query_res.=" AND YEARWEEK(purchase_date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
	   }
	   if($_REQUEST['mod_date'] == 'Last Month')
	   {
	  	$query_res.=" AND date_format(purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
	   }
	   if($_REQUEST['mod_date'] == 'Last 3 Month')
	   {
		 $query_res.=" AND purchase_date >= now()-interval 3 month ";
	   }
	   if($_REQUEST['mod_date'] == 'Last 6 Month')
	   {
		 $query_res.=" AND purchase_date >= now()-interval 6 month ";
	   }
	   if($_REQUEST['mod_date'] == 'Last Year')
	   {
		$query_res.=" AND date_format(purchase_date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
	   }
	   if($_REQUEST['mod_date'] == 'Custom Date')
	   {
		  $start_date = change_dateformat_reverse_db1($_REQUEST['start_date']);
		  $end_date = change_dateformat_reverse_db1($_REQUEST['end_date']);
		  $query_res.=" AND purchase_date >= '".$start_date." 00:00:00' AND purchase_date <= '".$end_date." 59:59:59'";
	   }
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
		$pagination .= "<a href=\"admin_gift_certificate.php?page=$prev&mod_date=".$_REQUEST['mod_date']."&restaurant_name=".$_REQUEST['restaurant_name']."&certificate_no=".$_REQUEST['certificate_no']."&validation_code=".$_REQUEST['validation_code']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"admin_gift_certificate.php?page=$i&mod_date=".$_REQUEST['mod_date']."&restaurant_name=".$_REQUEST['restaurant_name']."&certificate_no=".$_REQUEST['certificate_no']."&validation_code=".$_REQUEST['validation_code']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"admin_gift_certificate.php?page=$next&mod_date=".$_REQUEST['mod_date']."&restaurant_name=".$_REQUEST['restaurant_name']."&certificate_no=".$_REQUEST['certificate_no']."&validation_code=".$_REQUEST['validation_code']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
    
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_all_certificate['purchase_date'])); ?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['certificate_no'];?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['user_name']; ?></td>
    <td class="all_restaurant2"><?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$array_all_certificate['restaurant_id']);?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['deal'];?></td>
    <td class="all_restaurant2"><?php echo "$ ".$array_all_certificate['price'];?></td>
    <td class="all_restaurant2"><?php echo $array_all_certificate['validation_code'];?></td>
    <td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($array_all_certificate['expiry_date']));?>
    <td class="all_restaurant2 view_certificate"><a href="view_certificate.php?giftcard_id=<?php echo $array_all_certificate['id']; ?>&noprint=yes"  class="example_cat" >View Certificate</a></td>
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
    <td class="all_restaurant2" colspan="10" style="text-align:center;">No Gift Certificates</td>
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

<?php if($_REQUEST['restaurant_state']!='' || $_REQUEST['restaurant_city']!='' || $_REQUEST['restaurant_name']!=''){?>
<script type="text/javascript">
get_state_city('<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>');
get_restaurant('<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>');
</script>
<?php } ?>

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

