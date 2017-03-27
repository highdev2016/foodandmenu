<?php
session_start();
include("includes/rest_header.php");
include("admin/lib/conn.php");
include("includes/functions.php");
?>

<body onLoad="init();">

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top" style="min-height:350px;">
<h1>View Order Details</h1>
<a href="javascript:history.back();"><input type="button" name="back" value="Back" class="check_order_button" style="float:right; margin-top:-35px;" /></a>

<?php $sql_menu_order = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$_REQUEST['id']."'"));
$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$_REQUEST['id']."'"));?>

			<table width="970" border="1" cellspacing="0" bordercolor="ffbd8c" cellpadding="0" style="border-collapse:collapse; margin-top:10px; margin-bottom:20px;" class="curnt_ordr_details">
              <tr>
                <td width="25%"><h3>Order No.</h3></td>
                <td ><?php echo "OR-00".$sql_menu_order['order_id']; ?></td>
                </tr>
                <tr>
                <td valign="top" ><h3>Contact Details</h3></td>   
                <td ><?php echo $sql_contact_details['address']."<br>";
				echo $sql_contact_details['city']." ".$sql_contact_details['state']." ".$sql_contact_details['zipcode']; ?></td>
                </tr>
                <tr>
                <td valign="top" ><h3>Phone No</h3></td>
                <td ><?php echo $sql_contact_details['phone']; ?></td>
                </tr>
                <tr>
                <td valign="top" ><h3>Menu Items</h3></td>
                <td >
				<?php $sql_items_ordered = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$_REQUEST['id']."'");
				$i=1;
				while($array_items_ordered = mysql_fetch_array($sql_items_ordered)){
					$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_items_ordered['menu_id']."'"));
					$menu_price = ($array_items_ordered['quantity']*$array_items_ordered['menu_price']);
										
					echo $i.") ".$sql_menu['menu_name']." ---------- " .$array_items_ordered['quantity']. " X  $ ".$array_items_ordered['menu_price']." = $ " .$menu_price. "<br><br>"; 
					
					$arr_spl = explode(",", $array_items_ordered['additional_instructions']);
					if(!empty($arr_spl)){
						echo "Special Instructions ----- " ."<br>";	
					}
					foreach($arr_spl as $arrspl){
						if(!empty($arrspl)){
							$sql_sp_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$arrspl."'"));
							$sql_ins_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE id = '".$sql_sp_name['special_ins_id']."'"));
							$pr1 = ($array_items_ordered['quantity'] * $sql_sp_name['price']);
							
							echo $sql_ins_name['special_instruction'].' ----- '.$sql_sp_name['title'].' --- ' .$array_items_ordered['quantity']. ' X  $ '.$sql_sp_name['price'].' = $'.$pr1 ."<br>";
						}						
					}
					if($array_items_ordered['special_instructions']!=''){ echo "Additional Instructions : ".htmlspecialchars_decode(htmlspecialchars_decode($array_items_ordered['special_instructions']))."<br><br>"; }
					$i++;
					} ?>
                </td>
              </tr>
             <?php if($sql_menu_order['coupon_code']!=''){ ?> 
              <tr>
                <td valign="top" ><h3>Coupon Code</h3></td>
                <td >
				 <?php echo $sql_menu_order['coupon_code']; ?>
                </td>
              </tr>
				<tr>
                <td valign="top" ><h3>Coupon Discount</h3></td>
                <td >
				 <?php echo "$ ".$sql_menu_order['coupon_discount']; ?>
                </td>
              </tr>
              <?php } ?>
              
              <?php if($sql_menu_order['reward_points']!=''){ ?>
              <tr>
                <td valign="top" ><h3>Reward Point Discount</h3></td>
                <td >
				 <?php echo "$ ".$sql_menu_order['reward_points']; ?>
                </td>
              </tr>
              <?php } ?>
              
             <tr>
                <td width="25%" ><h3>Order Amount</h3></td>
             	<td ><?php echo "$ ".($sql_menu_order['total_price']); ?></td>
             </tr>
             <?php if($sql_menu_order['type'] == 'del'){?>
             <tr>
                <td width="25%" ><h3>Delivery Charge</h3></td>
             	<td ><?php 
				if($sql_menu_order['delivery_charge'] == 0){
					echo "Free";
				 }
				else {
					echo "$ ".($sql_menu_order['delivery_charge']);
				}?></td>
             </tr>
             <?php } ?>
             <tr>
                <td width="25%" ><h3>Tax</h3></td>
             	<td ><?php echo "$ ".($sql_menu_order['tax']); ?></td>
             </tr>
             <tr>
                <td width="25%" ><h3>Tip</h3></td>
             	<td ><?php echo "$ ".($sql_menu_order['tip']); ?></td>
             </tr>
             <tr>
                <td width="25%" ><h3>Total</h3></td>
             	<td ><?php echo "$ ".($sql_menu_order['total_price'] + $sql_menu_order['delivery_charge'] + $sql_menu_order['tax'] + $sql_menu_order['tip']); ?></td>
             </tr>
             <tr>
                <td valign="top" ><h3>Order Type</h3></td>
                <td ><?php if($sql_menu_order['type'] == 'pickup'){ echo "Pick up"; }
				else { echo "Delivery"; } ?></td>
             </tr>
              <?php if($sql_contact_details['special_ins']!=''){?>
              <tr>
                <td valign="top" ><h3>Special Instructions</h3></td>
                <td ><?php echo $sql_contact_details['special_ins']; ?></td>
                </tr>   
                <?php } ?>        
            </table>
            <p><a href="check_out.php?type=<?php echo $sql_menu_order['type']; ?>&order_id=<?php echo $sql_menu_order['order_id']; ?>&reorder=1" class="check_order_button" style="text-decoration:none; margin-left:255px;"> Resubmit Order </a></p>
<div class="clear"></div>
</div>

<div class="clear"></div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<?php include("includes/footer.php");?>