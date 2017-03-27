<?php
session_start();
ob_start();

if(!isset($_SESSION['admin_login_id'])){
	header("location:admin_login.php");
}
//print_r($_SESSION);
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");

function change_dateformat_reverse_db($date_form1)
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
 
 if($_REQUEST['export'] == "Export to Excel")
{
	header("location:export_admin_online_excel.php?restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']);
}

?>

<script type="text/javascript">
function sort_function(sort_by,restaurant_name,customer_name,contact_email){
	location.href = 'admin_online_reservation.php?sort_order='+sort_by+"&restaurant_name="+restaurant_name+"&customer_name="+customer_name+"&contact_email="+contact_email;
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
<div class="body_section">
  <div class="body_container">
    <div class="body_top"></div>
    <div class="main_body">
      <div class="restaurant_body_cont">
      
      <?php include ("includes/admin_nav_menu.php");?>
      
        <?php /*?><div class="restaurant_cont_top admn-pnl-top">
          <h1>Administration Panel</h1>
        </div><?php */?>
        <div class="restaurant_cont_field" style="margin:0 15px;">
          <p style="color:#454EA8; font-size:21px;margin-left:0px;margin-top:3px;">Search Panel</p>
          <br>
          <form name="frm" method="post" action="admin_online_reservation.php">
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
        <td>
        <select  class="restaurant search_select" name="restaurant_name" id="restaurant_name" style="width:200px;">
        <option value="">--Select--</option>
        </select></td>
         </tr>
              <tr>
                <?php /*?><td width="150">Restaurant Name : </td>
                <td width="184"><input type="text" name="" value="<?php echo $_REQUEST['restaurant_name'];?>" style="height:23px;  width: 168px;" class="restaurant"></td><?php */?>
                <td width="150">Customer Name : </td>
                <td width="184"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" style="height:23px;  width: 168px;" class="restaurant"></td>    
                <td width="150"><span style="margin-left: 16px;"> Contact Email : </span> </td>
                <td width="184"><input type="text" name="contact_email" value="<?php echo $_REQUEST['contact_email'];?>" style="height:23px;  width: 168px;" class="restaurant"></td>            
               
               		
                <td width="150">Date : </td>
                <td width="184">
                	<select class="restaurant search_select" name="mod_date" id="mod_date" onChange="open_cust_date(this.value);">
	                <option value="">---SELECT---</option>
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
				<td  width="150"><div id="start_dt1" style="visibility:<?php echo $display; ?>;"> Start Date : </div></td>	
				<td  width="184" id="start_dt2" style="visibility:<?php echo $display; ?>">
					<input type="text" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date']; ?>" readonly>
				</td>
				<td  width="150"><div id="end_dt1" style="visibility:<?php echo $display; ?>;">End Date : </div></td>	
				<td  width="184" id="end_dt2" style="visibility:<?php echo $display; ?>">
					<input type="text" name="end_date" id="end_date" value="<?php echo $_REQUEST['end_date']; ?>" readonly>
				</td>
              
                <td class="srcpnl-1"  align="right" style="padding-right:22px; " colspan="2">
                	<input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
                  	<a href="admin_online_reservation.php" class="button4" style="margin:0px; text-decoration:none; padding:6px 12px;" >Show All</a>
                  	<input type="submit" name="export" value="Export to Excel" class="button4" style="margin:0 0 0 3px;">
                </td>
              </tr>     
            </table>
          </form>
          <table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
            <tr>
              <td width="4%" class="all_restaurant">Sl No.</td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('date','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Date</a></td>
              <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Restaurant Name</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Customer Name</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('contact_email','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Contact Email</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('people','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">No of people</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('comments','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Comments</a></td>
              <td width="14%" class="all_restaurant">Action</td>
            </tr>
  <?php 
			
  $query_res = ("SELECT * from restaurant_reservations where 1 ");
  
  /*if($_REQUEST['restaurant_name']!=''){
	  $query_res.= " AND restaurant_name LIKE '%".$_REQUEST['restaurant_name']."%' ";
  }*/
  
  if($_REQUEST['restaurant_name']!=''){
	  $query_res.=" AND restaurant_id = '".$_REQUEST['restaurant_name']."' ";  
  }
  
  if($_REQUEST['restaurant_state']!=''){
	  $res_filter_state = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_state = '".$_REQUEST['restaurant_state']."'");
	  
	  $res_state = '';
	  $sep = '';
	  while($res_array_state = mysql_fetch_array($res_filter_state)){
		  $res_state = $res_state.$sep.$res_array_state['id'];
		  $sep = ',';
	  }
	  
	  $query_res.=" AND restaurant_id IN (".$res_state.") ";	  
  }
  
  if($_REQUEST['restaurant_city']!=''){
	  $res_filter_city = mysql_query("SELECT id FROM restaurant_basic_info WHERE restaurant_city = '".$_REQUEST['restaurant_city']."'");
	  
	  $res_city= '';
	  $sep1 = '';
	  while($res_array_city = mysql_fetch_array($res_filter_city)){
		  $res_city = $res_city.$sep1.$res_array_city['id'];
		  $sep1 = ',';
	  }
	  
	  $query_res.=" AND restaurant_id IN (".$res_city.") ";
  }
  
  if($_REQUEST['customer_name']!=''){
	  $query_res.= " AND customer_name LIKE '%".$_REQUEST['customer_name']."%' ";
  }
  
  if($_REQUEST['contact_email']!=''){
	  $query_res.= " AND contact_email = '".$_REQUEST['contact_email']."' ";
  }
  
  /*if($_REQUEST['mod_date']!='')
  {
	  if($_REQUEST['mod_date'] == 'This Month')
	  {
	  	$query_res.=" AND date_format(date,'%Y-%m') = '".date("Y-m")."' ";
	  }
	  if($_REQUEST['mod_date'] == 'Last Month')
	  {
	  	$query_res.=" AND date_format(date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
	  }
	  if($_REQUEST['mod_date'] == 'Last Week')
	  {
		  $query_res.=" AND YEARWEEK(date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
	  }
	   if($_REQUEST['mod_date'] == 'Custom Date')
	  {
		  $custom_date = change_dateformat_reverse_db1($_REQUEST['cust_date']);
		  $query_res.=" AND date_format(date,'%Y-%m-%d') LIKE '%".$custom_date."%' ";
	  }
  }*/
  
  if($_REQUEST['mod_date']!='')
  {
	  if($_REQUEST['mod_date'] == 'This Week')
	   {
		$query_res.=" AND YEARWEEK(date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY)";
	   }
	   if($_REQUEST['mod_date'] == 'Last Week')
	   {
		$query_res.=" AND YEARWEEK(date) = YEARWEEK(CURRENT_DATE - INTERVAL 14 DAY)";
	   }
	   if($_REQUEST['mod_date'] == 'Last Month')
	   {
	  	$query_res.=" AND date_format(date,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m')";
	   }
	   if($_REQUEST['mod_date'] == 'Last 3 Month')
	   {
		 $query_res.=" AND date >= now()-interval 3 month ";
	   }
	   if($_REQUEST['mod_date'] == 'Last 6 Month')
	   {
		 $query_res.=" AND date >= now()-interval 6 month ";
	   }
	   if($_REQUEST['mod_date'] == 'Last Year')
	   {
		$query_res.=" AND date_format(date,'%Y-%m') =  date_format(now() - INTERVAL 12 MONTH, '%Y-%m') ";
	   }
	   if($_REQUEST['mod_date'] == 'Custom Date')
	   {
		  $start_date = change_dateformat_reverse_db1($_REQUEST['start_date']);
		  $end_date = change_dateformat_reverse_db1($_REQUEST['end_date']);
		  $query_res.=" AND date >= '".$start_date." 00:00:00' AND date <= '".$end_date." 59:59:59'";
	   }
  }
  
  if($_REQUEST['sort_order']){
	  $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
  }else{
	  $query_res.=" ORDER BY id DESC ";
  }
  
  
  //echo $query_res;
  $sql_order = mysql_query($query_res);
  if(mysql_num_rows($sql_order)>0){
	  
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
		
		$total_results = mysql_num_rows($sql_order); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if(!isset($_GET['page']) || ($_REQUEST['submit']!="") || $_GET['page']==''){
			$page_num = 1;
		} else {
			$page_num = $_GET['page'];
		}
		
		/*$page_num = 1;
		
		if(isset($_GET['page'])){$page_num = $_GET['page'];}*/
		
		$offset = $page_num; 
		
		if($page_num == 0) {$page_num = 1;}
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"admin_online_reservation.php?page=$prev&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"admin_online_reservation.php?page=$i&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"admin_online_reservation.php?page=$next&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
  while($array_order = mysql_fetch_array($query_products)){ ?>
            <tr>
              <td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
              <td class="all_restaurant2"><?php echo change_dateformat_reverse_db($array_order['date']); ?></td>
              <td class="all_restaurant2"><?php echo $array_order['restaurant_name'];?></td>
              <td class="all_restaurant2"><?php echo $array_order['customer_name']; ?></td>
              <td class="all_restaurant2"><?php echo $array_order['contact_email']; ?></td>
              <td class="all_restaurant2"><?php echo $array_order['people']; ?></td>
              <td class="all_restaurant2"><?php echo $array_order['comments']; ?></td>
              <td class="all_restaurant2"><a class="various1" href="#inline_<?php echo $array_order['id'];?>" title="View" style="color:#686868;">View</a></td>
            </tr>
            
            <div style="display: none;">
                <div id="inline_<?php echo $array_order['id'];?>" style="width:500px;height:300px;overflow:auto;">
                    <div class="profle_wrapper">
                        <div style="width:450px;">
                            <h1 style="color:#2B4494;">Reservation Details</h1>
                            <p style="padding-bottom:5px;"><b>Restaurant Name : </b><?php echo $array_order['restaurant_name']; ?></p>
                            <p style="padding-bottom:5px;"><b>Customer Name : </b><?php echo $array_order['customer_name']; ?></p>
                            <p style="padding-bottom:5px;"><b>Contact Email : </b><?php echo $array_order['contact_email']; ?></p>
                            <p style="padding-bottom:5px;"><b>No. of People : </b><?php echo $array_order['people']; ?></p>
                            <p style="padding-bottom:5px;"><b>Comments : </b><?php echo $array_order['comments']; ?></p>
                            <p style="padding-bottom:5px;"><b>Special Occasions : </b><?php echo $array_order['special_occassion']; ?></p>
                            <p style="padding-bottom:5px;"><b>Date : </b><?php echo change_dateformat_reverse_db($array_order['date']); ?></p>
                            <p style="padding-bottom:5px;"><b>Time : </b><?php echo $array_order['time']; ?></p>
                        </div>
                    </div>
                </div>
			</div>
            
            <?php $inc++; } } else { ?>
            <tr>
              <td class="all_restaurant2" colspan="9" style="text-align:center;">No Records Found.</td>
            </tr>
            <?php } ?>
          </table>
          
          
          <?php if ($total_pages > '1' ) {
	
            $range =5; //set this to what ever range you want to show in the pagination link
            $range_min = ($range % 2 == 0) ? ($range / 2) - 1 : ($range - 1) / 2;
            $range_max = ($range % 2 == 0) ? $range_min + 1 : $range_min;
            $page_min = $page_num- $range_min;
            $page_max = $page_num+ $range_max;

            $page_min = ($page_min < 1) ? 1 : $page_min;
            $page_max = ($page_max < ($page_min + $range - 1)) ? $page_min + $range - 1 : $page_max;
            if ($page_max > $total_pages) {
                $page_min = ($page_min > 1) ? $total_pages - $range + 1 : 1;
                $page_max = $total_pages;
            }

            $page_min = ($page_min < 1) ? 1 : $page_min;
			
			if ($page_num != 1) {
                $page_pagination.= "<a href=\"admin_online_reservation.php?page=$prev&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
				
				}

            for ($i = $page_min;$i <= $page_max;$i++) {
                if ($i == $page_num){
                $page_pagination .= $i; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
                else{
                $page_pagination.= "<a href=\"admin_online_reservation.php?page=$i&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."\" class=\"more_link_pagination\">$i</a>"; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
			}
			
			
			if ($page_num < $total_pages) {
                $page_pagination.= "<a href=\"admin_online_reservation.php?page=$next&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."&mod_date=".$_REQUEST['mod_date']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."\" class=\"more_link_pagination_prev\">Next</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
		} 
?>
          <div style="text-align:center; margin-top:10px;"><?php echo $page_pagination; ?></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="body_footer_bg" ></div>
  </div>
  <div class="clear"></div>
</div>
<div class="clear"></div>

<?php if($_REQUEST['restaurant_state']!='' || $_REQUEST['restaurant_city']!='' || $_REQUEST['restaurant_name']!=''){?>
<script type="text/javascript">
get_state_city('<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>');
get_restaurant('<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant_name']; ?>');
</script>
<?php } ?>
