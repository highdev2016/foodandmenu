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
$j( "#cust_date" ).datepicker(pickerOpts);
});

function open_cust_date(val)
{
	if(val == 'Custom Date')
	{
		$j("#cust_date_td").show(500);
	}
	else
	{
		$j("#cust_date_td").hide(500);
	}
}
</script>
<body>
<?php include ("includes/menu_admin_add_res_front.php");?>
<div class="body_section">
  <div class="body_container">
    <div class="body_top"></div>
    <div class="main_body">
      <div class="restaurant_body_cont">
        <div class="restaurant_cont_top admn-pnl-top">
          <h1>Administration Panel</h1>
        </div>
        <div class="restaurant_cont_field">
          <p style="color:#454EA8; font-size:21px;margin-left:0px;margin-top:3px;">Search Panel</p>
          <br>
          <form name="frm" method="post" action="admin_online_reservation.php">
            <table>
              <tr>
                <td width="146">Restaurant Name : </td>
                <td width="184"><input type="text" name="" value="<?php echo $_REQUEST['restaurant_name'];?>" style="height:23px;  width: 168px;" class="restaurant"></td>
                <td width="128">Customer Name : </td>
                <td width="184"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" style="height:23px;  width: 168px;" class="restaurant"></td>    
                <td width="146">Contact Email : </td>
                <td width="184"><input type="text" name="contact_email" value="<?php echo $_REQUEST['contact_email'];?>" style="height:23px;  width: 168px;" class="restaurant"></td>            
               </tr>
               
               <tr>
               		
                <td width="146">Date : </td>
                <td width="184"><select class="restaurant" name="mod_date" id="mod_date" onChange="open_cust_date(this.value);">
                <option value="">---SELECT---</option>
                <option value="This Month"<?php if($_REQUEST['mod_date'] == 'This Month') { ?> selected <?php } ?>>This Month</option>
                <option value="Last Month"<?php if($_REQUEST['mod_date'] == 'Last Month') { ?> selected <?php } ?>>Last Month</option>
                <option value="Last Week"<?php if($_REQUEST['mod_date'] == 'Last Week') { ?> selected <?php } ?>>Last Week</option>
                <option value="Custom Date"<?php if($_REQUEST['mod_date'] == 'Custom Date') { ?> selected <?php } ?>>Custom Date</option>
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
                <td width="146" style="display:<?php echo $display; ?>;" id="cust_date_td" ><input type="text" name="cust_date" id="cust_date" value="<?php echo $_REQUEST['cust_date']; ?>"></td>
               </tr>
               
              <tr>
                <td colspan="5">&nbsp;</td>
                <td class="srcpnl-"><input type="submit" name="submit" value="Search" class="button4" style="margin:0px;">
                  <a href="admin_online_reservation.php" class="button4" style="margin:0px; text-decoration:none; padding:6px 13px;" >Show All</a></td>
                  </tr>
            </table>
          </form>
          <table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
            <tr>
              <td width="4%" class="all_restaurant">Sl No.</td>
              <td width="12%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Restaurant Name</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Customer Name</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('contact_email','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Contact Email</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('date','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Date</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('people','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">No of people</a></td>
              <td width="14%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('comments','<?php echo $_REQUEST['restaurant_name']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['contact_email']; ?>')" class="heading_link">Comments</a></td>
            </tr>
  <?php 
			
  $query_res = ("SELECT * from restaurant_reservations where 1 ");
  
  if($_REQUEST['restaurant_name']!=''){
	  $query_res.= " AND restaurant_name LIKE '%".$_REQUEST['restaurant_name']."%' ";
  }
  
  if($_REQUEST['customer_name']!=''){
	  $query_res.= " AND customer_name LIKE '%".$_REQUEST['customer_name']."%' ";
  }
  
  if($_REQUEST['contact_email']!=''){
	  $query_res.= " AND contact_email = '".$_REQUEST['contact_email']."' ";
  }
  
  if($_REQUEST['mod_date']!='')
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
              <td class="all_restaurant2"><?php echo $array_order['restaurant_name'];?></td>
              <td class="all_restaurant2"><?php echo $array_order['customer_name']; ?></td>
              <td class="all_restaurant2"><?php echo $array_order['contact_email']; ?></td>
              <td class="all_restaurant2"><?php echo change_dateformat_reverse_db($array_order['date']); ?></td>
              <td class="all_restaurant2"><?php echo $array_order['people']; ?></td>
              <td class="all_restaurant2"><?php echo $array_order['comments']; ?></td>
            </tr>
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
                $page_pagination.= "<a href=\"admin_online_reservation.php?page=$prev&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
				
				}

            for ($i = $page_min;$i <= $page_max;$i++) {
                if ($i == $page_num){
                $page_pagination .= $i; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
                else{
                $page_pagination.= "<a href=\"admin_online_reservation.php?page=$i&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."\" class=\"more_link_pagination\">$i</a>"; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
			}
			
			
			if ($page_num < $total_pages) {
                $page_pagination.= "<a href=\"admin_online_reservation.php?page=$next&restaurant_name=".$_REQUEST['restaurant_name']."&customer_name=".$_REQUEST['customer_name']."&contact_email=".$_REQUEST['contact_email']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
