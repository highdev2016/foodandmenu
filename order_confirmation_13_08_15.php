<?php
include("admin/lib/conn.php");
include("includes/functions.php");

$order_id = $_REQUEST['id'];
?>
<?php
//$sql_confirm_order = mysql_query("UPDATE restaurant_menu_order SET status = 'Confirmed' WHERE order_id = '".$order_id."' ");

$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));

$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$sql_menu['customer_id']."'"));
$customer_name = $sql_customer['firstname']." ".$sql_customer['lastname'];

$sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$sql_menu['restaurant_id']."'"));

$sql_bus_del_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$sql_menu['restaurant_id']."'"));

/*------------------------------ Customer ----------------------------------------*/

$sql_total_price = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));
$date = date('m-d-Y');

if($sql_total_price['type'] == 'pickup'){ 
$order_type = 'Pick up'; }else {
$order_type = 'Delivery'; }

$sql_select1 = mysql_query("SELECT * FROM restaurant_food_order_details WHERE  order_id = '".$order_id."'");
$ii = 1;
while($array_select1 = mysql_fetch_array($sql_select1)) {
$sql_select_product = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select1['menu_id']."'"));
$price = ($array_select1['quantity']*$array_select1['menu_price']);
			
$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> ( Item '.$ii.' ) --- <br>' .$array_select1['quantity'].' X '.$sql_select_product['menu_name'].'------------- '.$array_select1['quantity'].' X $ '.$array_select1['menu_price'].' = $'.$price.'</p>';

$menu_special_ins = $array_select1['additional_instructions'];
$ins_arr = (explode(",",$menu_special_ins));
if(!empty($menu_special_ins)){
	$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;"> Special Instructions ----- </p>';
}
foreach($ins_arr as $insarr){
	if(!empty($insarr)){
	$sql_sp_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$insarr."'"));
	$sql_ins_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE id = '".$sql_sp_name['special_ins_id']."'"));
	$pr1 = ($array_select1['quantity'] * $sql_sp_name['price']);
				
	$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">'.$sql_ins_name['special_instruction'].' ----- '.$sql_sp_name['title'].' -- ' .$array_select1['quantity']. ' X  $ '.$sql_sp_name['price'].' = $'.$pr1.'</p>';
	}
}

if($array_select1['special_ins']!=''){
	$menu_name.= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Additional Instructions -- '.$array_select1['special_ins'].'</p>';
}
	$menu_name.= '<hr>';
$ii++;
}


if($order_type == 'Delivery'){
	$delivery= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Delivery Charge :'.$delivery_charge.'</p>';
}

if($sql_total_price['special_delivery_info']!=''){
	$special_delivery_info= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Special Instructions : '.$sql_total_price['special_delivery_info'].'</p>';
}
if($sql_total_price['tip']!='' && $sql_total_price['tip']!=0.00){
	$tip= '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Tip :$ '.$sql_total_price['tip'].'</p>';
}

$coupon_code = $sql_menu['coupon_code'];
$coupon_discount = $sql_menu['coupon_discount'];

/*if($coupon_code){
	$coupon_code = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Coupon Code : '.$sql_menu['coupon_code'].'</p><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Discount : $ '.$coupon_discount.'</p>';
}*/

$sql_get_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$sql_menu['coupon_code']."'"));

if($coupon_code){
	$coupon_code = '<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Coupon : '.$sql_get_coupon['coupon_name'].'</p><p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Discount : $ '.$coupon_discount.'</p>';
}
 

$date_ordered = date("m-d-Y", strtotime($sql_menu['order_date']));

$subtotal = $sql_total_price['total_price'];

$tax = $sql_total_price['tax'];

$service_fee = $sql_total_price['service_fee'];

$price_with_del_charge = $sql_total_price['price_with_del_charge'];

$confirmation_code = $sql_menu['confirmation_code'];

$restaurant_name = $sql_restaurant['restaurant_name'];

$restaurant_address = $sql_restaurant['restaurant_address']." ".$sql_restaurant['restaurant_city']." ".$sql_restaurant['restaurant_state']." ".$sql_restaurant['restaurant_zipcode'];

/*$email = $sql_customer['email'];//"priya@infosolz.com"

$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 29"));	
			
$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));

$cms_rep=str_replace('%%$customer_name%%',$customer_name,$cms_rep);
$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
$cms_rep=str_replace('%%$date%%',$date,$cms_rep);
$cms_rep=str_replace('%%$menu_name%%',$menu_name,$cms_rep);
$cms_rep=str_replace('%%$delivery%%',$delivery,$cms_rep);
$cms_rep=str_replace('%%$special_delivery_info%%',$special_delivery_info,$cms_rep);
$cms_rep=str_replace('%%$subtotal%%',$subtotal,$cms_rep);
$cms_rep=str_replace('%%$tax%%',$tax,$cms_rep);
$cms_rep=str_replace('%%$tip%%',$tip,$cms_rep);
$cms_rep=str_replace('%%$price_with_del_charge%%',$price_with_del_charge,$cms_rep);
$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
$cms_rep=str_replace('%%$date_ordered%%',$date_ordered,$cms_rep);
$cms_rep=str_replace('%%$confirmation_code%%',$confirmation_code,$cms_rep);
$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_address,$cms_rep);
$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
$cms_rep=str_replace('%%$time%%',$time,$cms_rep);
$cms_rep=str_replace('%%$coupon_code%%',$coupon_code,$cms_rep);


$from = 'support@foodandmenu.com';

$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

$headers .= 'MIME-Version: 1.0' . "\r\n";

$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

$message=$cms_rep;

//$subject="Order Confirmation";

$subject = stripslashes($sql_cms['subject']);

mail($email,$subject,$message,$headers);*/


/*------------------------------ Food And Menu Admin ----------------------------------------*/

/*$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 30"));

$admin_email_address = $sql_cms['email_address'];

$arr_email_address = explode(",",$admin_email_address);
			
$email = "support@foodandmenu.com"; //"priya@infosolz.com"

$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));

$cms_rep=str_replace('%%$customer_name%%',$customer_name,$cms_rep);
$cms_rep=str_replace('%%$order_id%%',$order_id,$cms_rep);
$cms_rep=str_replace('%%$date%%',$date,$cms_rep);
$cms_rep=str_replace('%%$menu_name%%',$menu_name,$cms_rep);
$cms_rep=str_replace('%%$delivery%%',$delivery,$cms_rep);
$cms_rep=str_replace('%%$special_delivery_info%%',$special_delivery_info,$cms_rep);
$cms_rep=str_replace('%%$subtotal%%',$subtotal,$cms_rep);
$cms_rep=str_replace('%%$tax%%',$tax,$cms_rep);
$cms_rep=str_replace('%%$tip%%',$tip,$cms_rep);
$cms_rep=str_replace('%%$price_with_del_charge%%',$price_with_del_charge,$cms_rep);
$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
$cms_rep=str_replace('%%$date_ordered%%',$date_ordered,$cms_rep);
$cms_rep=str_replace('%%$confirmation_code%%',$confirmation_code,$cms_rep);
$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_address,$cms_rep);
$cms_rep=str_replace('%%$order_type%%',$order_type,$cms_rep);
$cms_rep=str_replace('%%$time%%',$time,$cms_rep);
$cms_rep=str_replace('%%$coupon_code%%',$coupon_code,$cms_rep);

$from = $sql_customer['email'];

$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

$headers .= 'MIME-Version: 1.0' . "\r\n";

$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

$message=$cms_rep;

//$subject="Order Confirmation";

$subject = stripslashes($sql_cms['subject']);

//mail($email,$subject,$message,$headers);

foreach($arr_email_address as $val_email){
	mail($val_email,$subject,$message,$headers);
}*/

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Food & menu</title>
<link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 
<link rel='stylesheet' id='camera-css'  href='css/ui.totop.css' type='text/css' media='all'> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript">
		jQuery(document).ready(function() {
			

			jQuery(".various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			jQuery("#various2").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			jQuery("#various2").fancybox();

			jQuery("#various3").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});

			jQuery("#various4").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
	</script>
    
<style type="text/css">
	.menu_container_email p {
		text-align: center;
		padding-top: 18px;
		text-transform: uppercase;
		font-size: 18px;
		color: #fff;
	}
	.reprint {
		padding: 0 100px;
		text-transform: uppercase;
		font-size: 16px;
	}
	.reprint fieldset {
		border-bottom: 0;
		border-left: 0;
		border-right: 0;
		border-top: 2px dashed #009;
		padding-left: 90px;
		text-align: center;
		width: 300px;
		margin: 0 auto 15px auto;
	}
	.reprint fieldset legend {
		padding: 0 10px;
	}
	.reprint fieldset legend a {
		font-size: 18px;
		text-decoration: none;
		color: #000;
	}
	.email_logo {
		 float: left;
    width: 216px;
	}
	.email_logo img{
		 float: left;
    height: auto;
    margin: -20px 0 8px;
    width: 100%;
	}
	
	.new_email_content {
		 border: 2px solid;
    padding: 20px;
	}
	.future_pickup {
		 float: right;
	    position: relative;
	    text-align: right;
	    top: -7px;
	    width: 268px;
	}
	.future_pickup p {
		text-align: right;
		padding-top: 5px;
	}
	.future_pickup p span {
		font-weight: bold;
	}
	.pick_up {
		font-size: 20px;
	}
	.table_content table {
		border-collapse: collapse;
	}
	.table_content table td {
		padding: 8px 5px;
		border: 1px solid #ccc;
	}
	.bottom_future {
		text-align: center;
	}
	.coinfirm_text {
		  border: 1px solid #c5c8d5;
    padding: 13px 0;
	}
	.bottom_future h2 {
		font-size: 20px;
		padding: 10px 0;
	}
	.coinfirm_text h4 {
		font-weight: bold;
		font-size: 18px;
	}
</style>

<script type="text/javascript">
function open_time_popup()
{
	$("#popup_time_div").show();
	$("#fade1").show();
}
function close_time_popup()
{
	$("#popup_time_div").hide();
	$("#fade1").hide();
}

function get_sel_time(val,id)
{
	
	$("#sel"+id).addClass('selected_cls');
	$("#loader_div").show();
	var order_id = <?php echo $order_id; ?>
	
	$.ajax({
		url : 'confirm_order_with_time.php',
		type : 'POST',
		data : 'val=' + val + '&order_id=' + order_id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			
			$("#loader_div").hide();
			$("#popup_time_div").hide();
			$("#fade1").hide();
			window.print();
			
		},
		
		
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
}
</script>

<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
</head>
<body class="confirmed-page">

<div class="body_section">
<div class="menu_section">

<div class="noprint">
<div class="menu_container menu_container_email">
      <p>thank you !!! your order has been confirmed</p>
</div>
</div>

</div>
<div class="body_container">


<div class="main_body new_body">

<div class="noprint">
<div class="reprint">
    <fieldset>
       <legend><a href="javascript:void(0);" onClick="window.print();">Click Here to Print</a>  <a href="javascript:void(0);" onClick="window.print();"><img src="images/1395142445_print.png" alt="print" width="20" height="20" style="margin-left:10px;"/></a></legend>
    </fieldset>
</div>
</div>

<div class="about_body_cont">

<div class="about_cont_middle ">

<div class="new_email_content">
  
  	<div class="full_width">
    <div class="email_logo2" style="width: 37% !important;">
    <?php $sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$order_id."'")); ?>
    
		<h3><?php echo $sql_contact_details['firstname']." ".$sql_contact_details['lastname']; ?></h3>
    
    <div class="clear"></div>
    <p style="padding-top:5px; color:#000000; font-size:15px;"><strong>Phone No. <span>:</span></strong><span> <?php echo $sql_contact_details['phone']; ?></span></p>
    <div class="clear"></div>
    <p style="padding-top:5px; color:#000000; font-size:15px;"><strong>Address <span>:</span></strong> <span> <?php echo $sql_contact_details['address']."<br /> ".$sql_contact_details['city']." ".$sql_contact_details['state']." ".$sql_contact_details['zipcode']; ?><br />
    <?php echo 'Home/Apartment : '.ucfirst($sql_contact_details['home_apartment']); ?><br />
    <?php if($sql_contact_details['home_apartment'] == 'apartment'){ ?>
    <?php if($sql_contact_details['apt_name']!=''){ ?>
    Apartment Name : <?php echo $sql_contact_details['apt_name']; ?><br />
    <?php } ?>
    <?php if($sql_contact_details['apt_no']!=''){ ?>
    Apartment Number : <?php echo $sql_contact_details['apt_no']; ?><br />
    <?php } ?>
    <?php if($sql_contact_details['gate_code']!=''){ ?>
    Gate Code : <?php echo $sql_contact_details['gate_code']; ?><br />
    <?php } ?>
    <?php } ?>
    <?php if($sql_contact_details['home_apartment'] == 'others'){ ?>
    <?php if($sql_contact_details['information']!=''){ ?>
    Information : <?php echo $sql_contact_details['information']; ?><br />
    <?php } ?>
    <?php } ?>
    </span></p></div>
    <div class="email_logo"><a href="https://foodandmenu.com"><img src="images/logo1.png" /></a></div>
    <div class="future_pickup">
    <p class="coinfirm_text"><h2> <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$sql_menu['restaurant_id']); ?></h2></p>
    <p style="color:#000000; font-size:14px;"> Order No : <span> <?php echo 'OR-00'.$order_id; ?>  </span></p>
    <p style="color:#000000; font-size:14px;">Order Placed on <?php echo date("m-d-Y", strtotime($sql_menu['order_date'])); ?> 
    <?php $time = substr($sql_menu['order_date'],-8); ?>
    <?php echo date("g:i A", strtotime($time)); ?>
    </p>
    <div class="coinfirm_text"><h4>Confirmation Code : <?php echo $sql_menu['confirmation_code']; ?></h4></div>
    </div>
    </div>
    
  <div class="clear" style="border-bottom:1px solid #000000;"></div>
  
  <div class="instruction_sec">
  
  	<div class="future_pickup  pickup_new">
    
    <?php if(!empty($sql_contact_details['special_ins'])){ ?>
    	<p style="text-align:left; margin-left:5px; color:#000000; font-size:15px;"> Instructions : </span></p>
        <div class="clear"></div>
    	<p style="text-align:left; margin-left:5px; color:#000000; font-size:15px; width:500px;"><?php echo $sql_contact_details['special_ins']; ?></p>
    <?php } ?>
        
    </div>
    
    <div class="clear"></div>
  	<?php if($sql_menu['spare_napkins'] == 1){ ?>
	<div class="coinfirm_text"><h4>Spare me the napkins and plasticware . I'm trying to save the earth.</h4></div>
    <?php } ?>
    
  </div>
    
    <div class="order_type_sec">    
    <p style="color:#000000; font-size:14px;" class="item_order_type">Order Type : <span class="pick_up"> <?php if($sql_menu['type'] == 'del'){ echo "Delivery"; }else{ echo "Pick Up"; }?></span></p>
    </div>
   
   
    
  <div class="clear"></div>
  
  <div class="table_content">
  
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="13%" align="center" style="padding:10px 5px;  text-transform: uppercase;font-size: 18px; background: #5455AC; color: #fff;">Quantity</td>
        <td colspan="2" style="padding:10px 5px;  text-transform: uppercase;font-size: 18px; background: #5455AC; color: #fff;">Items</td>
        <td width="14%" align="center" colspan="2" style="padding:10px 5px;  text-transform: uppercase;font-size: 18px; background: #5455AC; color: #fff;">Price</td>
      </tr>
    
        <?php
        $sql_select = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$order_id."'");
        $sql_menu_order_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$order_id."'"));
        $i = 1;
        $sub_total = 0;
        while($array_select = mysql_fetch_array($sql_select)){
        $menu_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_select['menu_id']."'")); 
        $menu_special_ins = $array_select['additional_instructions'];
        $ins_arr = (explode(",",$menu_special_ins));
        
        ?>
         
        <tr>
            <td align="center"><?php echo $array_select['quantity']; ?></td>
            <td colspan="2"><?php echo $menu_name['menu_name']." ( $ ".$array_select['menu_price']." )"."<br>";
            
            $ins_price = 0;
            foreach($ins_arr as $insarr){
                if(!empty($insarr)){
                $sql_sp_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$insarr."'"));
                $sql_ins_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE id = '".$sql_sp_name['special_ins_id']."'"));
                $pr1 = ($array_select['quantity'] * $sql_sp_name['price']);
				
                echo $sql_ins_name['special_instruction'].' : '.$sql_sp_name['title'].'';
				
				if(!empty($sql_sp_name['price'])){
					echo ' ( $ '.$sql_sp_name['price']." Extra ) ";
				}
				
				echo "<br>";
				
                $ins_price = $ins_price+$pr1;
                }
            }
			
			if(!empty($array_select['special_instructions'])){
				echo 'Additional Instruction : '.$array_select['special_instructions'];
			}
			
            ?></td>
            <?php $sub_total_amount = ($array_select['quantity']*$array_select['menu_price'] + $ins_price); ?>
            <td align="right" colspan="2">$ <?php echo number_format($sub_total_amount,2);"<br>"; ?></td>
        </tr>
        <?php $i++;
        $sub_total = $sub_total + ($sub_total_amount);
         } ?>
      
      <tr>
        <td width="60%" rowspan="8" align="left" valign="top" colspan="2">
        <span class="payment_type_sec">Payment Type : 
        <?php if($sql_menu_order_details['payment_mode'] == 'cash'){?>
        		<span class="cash_order">Will Pay With Cash</span>
        <?php }else{ ?>
        		<span class="cash_order">Credit Card - Do Not Charge
                </span>
		<?php }?>
        
        <?php if($sql_menu_order_details['coupon_discount']!=''){ ?>
        </span>
        
        <div class="clear"></div>
        
        <img src="images/amount-image.jpg" alt="" align="absmiddle" class="total_amount_pic" />
        
        </td>
        <td align="right"><span><?php if($sql_menu_order_details['coupon_code'] != "") { ?>
         <div class="coinfirm_text"><h4><?php echo getNameTable("restaurant_coupon","coupon_name","coupon_code",$sql_menu_order_details['coupon_code']); ?></h4></div>
	<?php } ?></span> Discount</td>
        <td align="right" colspan="2"><?php echo "$ ".$sql_menu_order_details['coupon_discount']; ?></td>
        </td>
        <?php } ?>
        
      </tr>
      
      <?php if($sql_menu_order_details['reward_points']!=''){ ?>
      <tr>
        <td colspan="2" align="right">Reward Points</td>
        <td align="right"><?php echo "$ ".$sql_menu_order_details['reward_points']; ?></td>
      </tr>
      <?php } ?>
      
      <tr>
        <td colspan="2" align="right">Subtotal</td>
        <td align="right"><?php echo "$ ".number_format(($sub_total-($sql_menu_order_details['coupon_discount'] + $sql_menu_order_details['reward_points'])),2); ?></td>
      </tr>
     
      <?php if($sql_menu_order_details['tax']!=''){ ?>
      <tr>
        <td colspan="2" align="right">Tax</td>
        <td align="right"><?php echo "$ ".$sql_menu_order_details['tax']; ?></td>
      </tr>
      <?php } ?>
      <?php if($sql_menu_order_details['service_fee']!=0){ ?>
      <tr>
        <td colspan="2" align="right">Service Fee</td>
        <td align="right"><?php echo "$ ".$sql_menu_order_details['service_fee']; ?></td>
      </tr>
      <?php } ?>
      <?php if($sql_menu_order_details['type']=='del'){?>
      <tr>
        <td colspan="2" align="right">Delivery Charge</td>
        <td align="right"><?php if($sql_menu_order_details['delivery_charge'] == 0){echo "Free"; }else{ echo "$ ".number_format($sql_menu_order_details['delivery_charge'],2); } ?></td>
      </tr>
      <?php } ?>
      <?php if($sql_menu_order_details['tip']!=''){ ?>
      <tr>
        <td colspan="2" align="right">Tip</td>
        <td align="right"><?php echo "$ ".$sql_menu_order_details['tip']; ?></td>
      </tr>
      <?php } ?>
      <?php $total_amount = ($sub_total+$sql_menu_order_details['tax']+$sql_menu_order_details['delivery_charge']+$sql_menu_order_details['tip'] + $sql_menu_order_details['service_fee'])-($sql_menu_order_details['coupon_discount']+$sql_menu_order_details['reward_points']); ?>
      <tr>
        <td colspan="2" align="right">Total</td>
        <td align="right"><span><?php echo "$ ".number_format($total_amount,2); ?></span></td>
      </tr>
    </table>

  </div>
  
  <div class="bottom_future">
 
 
	Customer Service Phone # 877-333-3221 or Email Us: contact@foodandmenu.com
    
  </div>
  
</div>

</div>
</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

                            
                            
                        <div id="popup_time_div" style="display:none;" class="sml-popup white_content"  >
						
                        	<a id="pop_close" href="javascript:void(0);" onclick="return close_time_popup();"></a>
                        
                         <h2 class="up_nw_load_nw restudnt"><?php if($sql_menu['type'] == 'del'){ echo "Delivery"; }else{ echo "PickUp"; }?> Order<br />
                        <small> <img src="images/downld.png" alt="" align="absmiddle" /> Received: <?php echo date("h:i A", strtotime($sql_menu['order_date'])); ?></small>
                         <div class="clear"></div>
                         </h2>
							<div class="l-contnt l-contnt-new up-contnt"> 
                            
                            <h3>How long?</h3>
                            <div class="relative">
							<form name="submit_menu" id="submit_menu" action="" method="post" class="form-horizontal" onSubmit="return check_empty();">
                           
                            <?php
								
								if($sql_menu['type'] == 'del')
								{
									echo "<a href='javascript:void(0);' id='sel1' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot1'].",1);'>".$sql_bus_del_info['del_time_slot1']." <br /> mins</a> &nbsp;";
									echo "<a href='javascript:void(0);' id='sel2' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot2'].",2);'>".$sql_bus_del_info['del_time_slot2']." <br />mins</a> &nbsp;";
									echo "<a class='last_sml_pop' href='javascript:void(0);' id='sel3' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot3'].",3);'>".$sql_bus_del_info['del_time_slot3']." <br />mins</a> <br>";
									echo "<div class='clear'></div>";
									echo "<a href='javascript:void(0);' id='sel4' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot4'].",4);'>".$sql_bus_del_info['del_time_slot4']." <br />mins</a> &nbsp;";
									echo "<a href='javascript:void(0);' id='sel5' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot5'].",5);'>".$sql_bus_del_info['del_time_slot5']." <br />mins</a> &nbsp;";
									echo "<a class='last_sml_pop' href='javascript:void(0);' id='sel6' onclick='get_sel_time(".$sql_bus_del_info['del_time_slot6'].",6);'>".$sql_bus_del_info['del_time_slot6']." <br />mins</a> &nbsp;";
								}
								else
								{
									echo "<a href='javascript:void(0);' id='sel7' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot1'].",7);'>".$sql_bus_del_info['pickup_time_slot1']." <br />mins</a> &nbsp;";
									echo "<a href='javascript:void(0);' id='sel8' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot2'].",8);'>".$sql_bus_del_info['pickup_time_slot2']." <br />mins</a> &nbsp;";
									echo "<a class='last_sml_pop' href='javascript:void(0);' id='sel9' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot3'].",9);'>".$sql_bus_del_info['pickup_time_slot3']." <br />mins</a> <br>";
									echo "<div class='clear'></div>";
									echo "<a href='javascript:void(0);' id='sel10' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot4'].",10);'>".$sql_bus_del_info['pickup_time_slot4']." <br />mins</a> &nbsp;";
									echo "<a href='javascript:void(0);' id='sel11' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot5'].",11);'>".$sql_bus_del_info['pickup_time_slot5']." <br />mins</a> &nbsp;";
									echo "<a class='last_sml_pop' href='javascript:void(0);' id='sel12' onclick='get_sel_time(".$sql_bus_del_info['pickup_time_slot6'].",12);'>".$sql_bus_del_info['pickup_time_slot6']." <br />mins</a> &nbsp;";
								}
							
							?>
                            
                            
							</form>
                            <div id="loader_div" class="ld-cls" style="display:none;"><img src="images/ajax-loader-review.gif" /></div>
                            </div>
							</div>
							</div>
                            <div id="fade1" class="black_overlay"> </div>


</body>
</html>
<script type="text/javascript">open_time_popup();</script>

