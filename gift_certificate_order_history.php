<?php
session_start();
include("includes/rest_header.php");
include("admin/lib/conn.php");
include("includes/functions.php");
?>




<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
<body onLoad="init();">

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top" style="min-height:350px;">
<h1>Customer Gift Certifacate Order History </h1>
<a href="javascript:history.back();"><input type="button" name="back" id="back" value="Back" class="check_order_button" style="float:right; margin-top:-33px;" ></a>

<table width="970" border="1" cellspacing="0" bordercolor="d6d6d6" cellpadding="0" style="border-collapse:collapse; margin-top:10px;" class="curnt_ordr_details">

  <?php $sql_order = mysql_query("SELECT * from restaurant_gift_card where customer_id = '".$_SESSION['customer_id']."' ORDER BY id DESC");
  $order_num = mysql_num_rows($sql_order); 
  if($order_num > 0){ ?>
  <tr>
    <td align="center" class="cstmr_order_hstry">Restaurant Name</td>
    <td align="center" class="cstmr_order_hstry">Username</td>
    <td align="center" class="cstmr_order_hstry">Email</td>
    <td align="center" class="cstmr_order_hstry">Deal</td>
    <td align="center" class="cstmr_order_hstry">Price</td>
    <td align="center" class="cstmr_order_hstry">Purchase Date (MM-DD-YYYY)</td>
    <td align="center" class="cstmr_order_hstry">Expiry Date (MM-DD-YYYY)</td>
    <td align="center" class="cstmr_order_hstry">Action</td>
    <td align="center" class="cstmr_order_hstry">Used Status</td>
  </tr>
  <?php while($array_order = mysql_fetch_array($sql_order)){ 
  	$sql_used_check = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_gift_certificate_no WHERE giftcard_id = '".$array_order['id']."'"));
  
  ?> 
  <tr>
    <td align="center"><?php echo $array_order['restaurant_name']; ?></td>
    <td align="center"><?php echo $array_order['user_name']; ?></td>
    <td align="center"><?php echo $array_order['email']; ?></td>
    <td align="center"><?php echo $array_order['deal']; ?></td> 
    <td align="center"><?php echo $array_order['price']; ?></td> 
    <td align="center"><?php echo date("m-d-Y", strtotime($array_order['purchase_date'])); ?></td>
    <td align="center"><?php echo date("m-d-Y", strtotime($sql_used_check['expiry_date'])); ?></td>
	<td align="center"><a href="view_certificate.php?giftcard_id=<?php echo $array_order['id']; ?>"  class="example_cat">View Certificate</a></td> 
    <td align="center"><?php if($sql_used_check['used'] == 1) {  echo "Already Used"; } else { echo "Not Used"; }?></td>
  </tr> 
  <?php } } else { ?>
  <tr>
  <td colspan="4"> No gift certificate ordered yet. </td>
  </tr>
  <?php } ?>
</table>


                        
<div class="clear"></div>
</div>

<div class="clear"></div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>
<?php include("includes/footer.php");?>
<div class="clear"></div>

<script type="text/javascript" src="http://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="http://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
	
	//var $j = jQuery.noConflict();
	
  $(document).ready(function() {
   /*
   *   Examples - images
   */
   
   
   $("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script>
