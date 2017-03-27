<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
//rest_chk_authentication();
//print_r($_SESSION);
if(!isset($_SESSION['restaurant_admin_panel_id'])){
	header('location:restaurant_admin_login.php');
}

function change_dateformat_reverse($param)
{
	 $date=explode("-",$param);
	 $dateformat=$date[2]."-".$date[0]."-".$date[1];
	 return $dateformat;
}

?>
<script type="text/javascript">
function submit_form()
{
	alert(123);
	//document.frm.submit();
	//document.getElementById("frm").submit();
	//document.forms["frm"].submit();
	 $( "#frm" ).submit();
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="js/jQuery.print.js"></script>


<script type="text/javascript">
var $j = jQuery.noConflict();
$j(function() {
    $j("#print_but").click(function() {
    $j("#printdiv").print();
    return (false);
});
});
</script>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<?php /*?><script src="//code.jquery.com/jquery-1.10.2.js"></script><?php */?>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">


<script>
var $j = jQuery.noConflict(); 
    $j(function() {
  	var pickerOpts = {
	changeMonth: true,
	changeYear: true,
    dateFormat:"mm-dd-yy"
	};
		$j( "#order_date" ).datepicker(pickerOpts);
	});
	
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
<script type="text/javascript">
function sort_function(sort_by,order_date,customer_name,customer_email,start_date,end_date){
	location.href = 'my_reports.php?sort_order='+sort_by+"&order_date="+order_date+"&customer_name="+customer_name+"&customer_email="+customer_email+"&start_date="+start_date+"&end_date="+end_date;
}
</script>

<body>

<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont restu_live_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">

<?php $sql_tot_item = "SELECT SUM(quantity) FROM restaurant_food_order_details WHERE restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."'";

if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!=''){
	  $sql_tot_item.=" AND order_date >= '".change_dateformat_reverse($_REQUEST['start_date'])."' AND order_date <= '".change_dateformat_reverse($_REQUEST['end_date'])."'";
  }
  
  $sql = mysql_query($sql_tot_item);
$array = mysql_fetch_array($sql); ?>




<form name="frm" id="frm" method="post" action="my_reports.php">
<table><tr>
<?php /*?><td width="131">Order Date : </td><td width="201"><input type="text" name="order_date" id="order_date" value="<?php echo $_REQUEST['order_date'];?>" class="restaurant"></td>
<td width="183">Customer Name : </td><td width="242"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" class="restaurant"></td>
<td width="164">Customer Email : </td><td width="254"><input type="text" name="customer_email" value="<?php echo $_REQUEST['customer_name'];?>" class="restaurant"></td><tr><tr><?php */?>
<td><p style="margin-top:12px;">Start date :</p></td>
<td><input type="text" name="start_date" id="start_date" value="<?php echo $_REQUEST['start_date'];?>" class="restaurant" autocomplete="off" style="width:180px; margin-top:24px;"></td>
<td><p style="margin-top:12px;">End date :</p></td>
<td><input type="text" name="end_date" id="end_date" value="<?php echo $_REQUEST['end_date'];?>" class="restaurant" autocomplete="off" style="width:180px; margin-top:24px;"></td>
<td><input type="submit" name="submit1" value="Search" class="button4" style="margin:0 0 0 11px;">
<a href="my_reports.php" class="button4" style="margin:0px; text-decoration:none; padding:6px 12px;">Show All</a>
<a href="javascript:void(0);" class="check_order_button noprint" style="text-decoration: none; padding: 6px 10px; float: none; margin: 0px; font-size: 13.3px;" id="print_but" >Print</a>

<?php /*?><input type="submit" name="export" value="Export to Excel" class="button4" style="margin-left:0px;"/>
<?php */?>
<a href="export_excel.php" class="button4" style="text-decoration:none; margin-left:0px;">Export to Excel</a>

<a href="export_reports_pdf.php" title="Export to Pdf" target="_blank" style="text-decoration:none;"><input type="button" name="export_pdf" value="Export to Pdf" class="button4" style="margin:0px;"/></a>
</td>
<tr>
</table>

<div style="padding-bottom:20px;">
<div style="float:left;">
<h1 style="font-size:22px; color:#2B4494;">Items Ordered - <?php echo $array['SUM(quantity)']; ?></h1></div>
<div align="right" class="sort">
Items Per Page : <select name="item_per_page" id="item_per_page" onChange="frm.submit();">
<option value="25"<?php if($_REQUEST['item_per_page'] == 25) { ?> selected <?php } ?>>25</option>
<option value="50"<?php if($_REQUEST['item_per_page'] == 50) { ?> selected <?php } ?>>50</option>
<option value="75"<?php if($_REQUEST['item_per_page'] == 75) { ?> selected <?php } ?>>75</option>
<option value="100"<?php if($_REQUEST['item_per_page'] == 100) { ?> selected <?php } ?>>100</option>
</select>
</div>
</div>
</form>

<div id="printdiv">
	<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<th width="4%" class="all_restaurant">Sl No.</th>
    <?php /*?><td width="11%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('order_date','<?php echo $_REQUEST['order_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_email']; ?>','<?php echo $_REQUEST['start_date']; ?>','<?php echo $_REQUEST['end_date']; ?>')" class="heading_link">Date</a></td>
    <td width="11%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['order_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_email']; ?>','<?php echo $_REQUEST['start_date']; ?>','<?php echo $_REQUEST['end_date']; ?>')" class="heading_link">Customer Name</a></td>
    <!--<td width="13%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_email','<?php echo $_REQUEST['order_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_email']; ?>','<?php echo $_REQUEST['start_date']; ?>','<?php echo $_REQUEST['end_date']; ?>')" class="heading_link">Customer Email</a></td>--><?php */?>
    <th width="20%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('menu_name','<?php echo $_REQUEST['order_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_email']; ?>','<?php echo $_REQUEST['start_date']; ?>','<?php echo $_REQUEST['end_date']; ?>')" class="heading_link">Menu Name</a></th>
    <th width="11%" class="all_restaurant"><!--<a href="javascript:void(0)" onClick="sort_function('quantity','<?php echo $_REQUEST['order_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_email']; ?>','<?php echo $_REQUEST['start_date']; ?>','<?php echo $_REQUEST['end_date']; ?>')" class="heading_link">-->Quantity<!--</a>--></th>
    <th width="9%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('unit_price','<?php echo $_REQUEST['order_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_email']; ?>','<?php echo $_REQUEST['start_date']; ?>','<?php echo $_REQUEST['end_date']; ?>')" class="heading_link">Price</a></th>
    <?php /*?><td width="9%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('tax','<?php echo $_REQUEST['order_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_email']; ?>','<?php echo $_REQUEST['start_date']; ?>','<?php echo $_REQUEST['end_date']; ?>')" class="heading_link">Tax</a></td><?php */?>
    <th width="12%" class="all_restaurant"><!--<a href="javascript:void(0)" onClick="sort_function('sum','<?php echo $_REQUEST['order_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>','<?php echo $_REQUEST['customer_email']; ?>','<?php echo $_REQUEST['start_date']; ?>','<?php echo $_REQUEST['end_date']; ?>')" class="heading_link">-->Sum<!--</a>--></th>
    </tr>
  <?php
  //$query_res = ("SELECT * FROM restaurant_food_order_details WHERE restaurant_id = '769'");
  $query_res = ("SELECT  *  FROM restaurant_food_order_details WHERE restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."'");
  
  /*if($_REQUEST['order_date']!=''){
	  $query_res.=" AND order_date = '".change_dateformat_reverse($_REQUEST['order_date'])."'";
  }
  if($_REQUEST['customer_name']!=''){
	  $query_res.=" AND customer_name = '".$_REQUEST['customer_name']."'";
  }
  if($_REQUEST['customer_email']!=''){
	  $query_res.=" AND customer_email = '".$_REQUEST['customer_email']."'";
  }*/
  if($_REQUEST['start_date']!='' && $_REQUEST['end_date']!=''){
	  $query_res.=" AND order_date >= '".change_dateformat_reverse($_REQUEST['start_date'])."' AND order_date <= '".change_dateformat_reverse($_REQUEST['end_date'])."'";
  }
  $query_res.= ' GROUP BY menu_name';
  if($_REQUEST['sort_order']){
	  $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
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
		
		$total_results = mysql_num_rows($sql_order); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = '';
		$page_num = 1;

		if(isset($_GET['page'])){$page_num = $_GET['page'];}
		
		$offset = $page_num; 
		
		if($page_num == 0) {$page_num = 1;} 
		
		if($page > 1) 
		{ 
			$pagination .= "<a href=\"my_reports.php?page=$prev&order_date=".$_REQUEST['order_date']."&customer_name=".$_REQUEST['customer_name']."&customer_email=".$_REQUEST['customer_email']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
			$pagination .= "<a href=\"my_reports.php?page=$i&order_date=".$_REQUEST['order_date']."&customer_name=".$_REQUEST['customer_name']."&customer_email=".$_REQUEST['customer_email']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination\">$i</a>"; 
			$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
			$pagination .= "<a href=\"my_reports.php?page=$next&order_date=".$_REQUEST['order_date']."&customer_name=".$_REQUEST['customer_name']."&customer_email=".$_REQUEST['customer_email']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
  while($array_order = mysql_fetch_array($query_products)){
  $sql_date_ordered = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$array_order['order_id']."'")); 
  $sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$array_order['customer_id']."'"));
  $sql_quantity = mysql_fetch_array(mysql_query("SELECT SUM(quantity) as qty , SUM(unit_price) as sum_sum FROM  restaurant_food_order_details WHERE menu_id = '".$array_order['menu_id']."'"));
   ?>
  <tr>
  	<td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
    <?php /*?><td class="all_restaurant2"><?php echo date("m-d-Y", strtotime($sql_date_ordered['order_date'])); ?></td>
    <td class="all_restaurant2"><?php echo $sql_customer['firstname']." ".$sql_customer['lastname']; ?></td>
    <!--<td class="all_restaurant2"><?php echo $array_order['customer_email']; ?></td>-->
    <td class="all_restaurant2">
	<?php $sql_menu_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_order['menu_id']."'")); ?>
	<?php echo $sql_menu_name['menu_name']; ?></td><?php */?>
     <td class="all_restaurant2"><?php echo $array_order['menu_name']; ?></td>
    <td class="all_restaurant2"><?php echo $sql_quantity['qty']; ?></td>
    <td class="all_restaurant2"><?php echo "$ ".$array_order['unit_price']; ?></td>
    <?php /*?><td class="all_restaurant2"><?php echo "$ ".$array_order['tax']; ?></td><?php */?>
    <td class="all_restaurant2"><?php echo "$ ".$sql_quantity['sum_sum']; ?></td>
  </tr>
  <?php $inc++; } } else { ?>
  <tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No orders yet</td>
  </tr>
  <?php } ?>
</table>
</div>

<?php
if ($total_pages > '1' ) {

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

            //$page_content .= '<p class="menuPage">';

            

            if ($page_num != 1) {
                $page_pagination .= "<a href=\"my_reports.php?page=$prev&order_date=".$_REQUEST['order_date']."&customer_name=".$_REQUEST['customer_name']."&customer_email=".$_REQUEST['customer_email']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
            }

            for ($i = $page_min;$i <= $page_max;$i++) {
                if ($i == $page_num){
                $page_pagination .= $i; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
                else{
                $page_pagination.= "<a href=\"my_reports.php?page=$i&order_date=".$_REQUEST['order_date']."&customer_name=".$_REQUEST['customer_name']."&customer_email=".$_REQUEST['customer_email']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination\">$i</a>"; 
				$page_pagination.='&nbsp;&nbsp;&nbsp;';
				}
            }

            if ($page_num < $total_pages) {
                $page_pagination.= "<a href=\"my_reports.php?page=$next&order_date=".$_REQUEST['order_date']."&customer_name=".$_REQUEST['customer_name']."&customer_email=".$_REQUEST['customer_email']."&start_date=".$_REQUEST['start_date']."&end_date=".$_REQUEST['end_date']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Next</a>"; 
				$page_pagination.="&nbsp;&nbsp;&nbsp;";
            }

        ?>
<div style="text-align:center; margin-top:10px;"><?php echo $page_pagination; ?></div>
<?php } ?>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

