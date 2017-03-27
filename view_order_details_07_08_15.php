<?php
session_start();
include("includes/rest_header.php");
include("admin/lib/conn.php");
include("includes/functions.php");
?>

<body onLoad="init();">

<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont">

<div class="restaurant_cont_top" style="min-height:350px;">
<h1>View Order Details</h1>
<a href="javascript:history.back();"><input type="button" name="back" value="Back" class="check_order_button" style="float:right; margin-top:-35px;" /></a>

<?php $sql_menu_order = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_order WHERE order_id = '".$_REQUEST['id']."'"));
$sql_contact_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_order_contact_details WHERE order_id = '".$_REQUEST['id']."'"));
$sql_customer_details = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."' "));
?>
            
            <div class="ordr-tbl">
            	<div class="ordr-head">
            		<div class="order-head-left">
					
						<h5> Customer Details -</h5>
						
						<p><strong>Customer Name :</strong>  <?php echo $sql_customer_details['firstname']." ".$sql_customer_details['lastname']; ?></p>
                        <?php if($sql_contact_details['phone']!=''){?>
						<p><strong>Phone Number :</strong> <?php echo $sql_contact_details['phone']; ?></p>
                        <?php } ?>
						<p><strong>Address :</strong> <?php echo $sql_contact_details['address']."<br>";
				echo $sql_contact_details['city']." ".$sql_contact_details['state']." ".$sql_contact_details['zipcode']; ?></p>
            		</div>
            		<div class="order-head-right">
						<p> <strong>Order Number</strong><em>:</em>
                        <?php echo "OR-00".$sql_menu_order['order_id']; ?>
                        </p>
						<p> <strong>Order Type</strong><em>:</em>
                        <?php if($sql_menu_order['type'] == 'pickup'){ echo "Pick up"; }
				else { echo "Delivery"; } ?></p>
						<p><strong>Date Ordered</strong><em>:</em> <?php echo date("m-d-Y", strtotime($sql_menu_order['order_date'])); ?></p>
            		</div>
            		<div class="clear"></div>
            		
            	</div>
            	<h5 class="sub"> Items Purchased Below -</h5>
            		<div class="clear"></div>
            	<div class="ordr-con">
            		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin: 0 auto; border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">
						<tr>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd; background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Item No.
							</td>
							<td align="left" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd; background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Item Name	
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE; padding: 5px; border-bottom: none;border-right: none;">
								Quantity
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE;padding: 5px; border-bottom: none;border-right: none;">
								Unit Price
							</td>
							<td align="center" style="font-weight: bold;font-size: 14px;border: 1px solid #ddd;background: #EEEEEE;padding: 5px; border-bottom: none; border-right: none;">
								Amount
							</td>
						</tr>
					
                     <?php $sql_items_ordered = mysql_query("SELECT * FROM restaurant_food_order_details WHERE order_id = '".$_REQUEST['id']."'");
				$i=1;
				while($array_items_ordered = mysql_fetch_array($sql_items_ordered)){
					$sql_menu = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item WHERE id = '".$array_items_ordered['menu_id']."'"));
					$menu_price = ($array_items_ordered['quantity']*$array_items_ordered['menu_price']); 
					$arr_spl = explode(",", $array_items_ordered['additional_instructions']); 
					
					/*echo '<pre>';
					print_r($arr_spl);*/
					
					if($array_items_ordered['special_instructions']!=''){
						$row_count = count($arr_spl)+2;
					}else{
						if(!empty($arr_spl[0])){
							$row_count = count($arr_spl)+1;
						}else{
							$row_count = 0;							
						}
						
					}
					
					//echo count($arr_spl);
					?>
					  <!-- Start looping row -->
						<tr>
							<td rowspan="<?php echo $row_count; ?>" align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo $i; ?>
							</td>
						  <td align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 0px;font-size: 14px;">
								<p><?php echo $sql_menu['menu_name']; ?></p>
							
                            </td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo $array_items_ordered['quantity']; ?>
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo "$".$array_items_ordered['menu_price']; ?>
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;">
								<?php echo "$".$menu_price; ?>
							</td>
						</tr>
                        <?php 
						foreach($arr_spl as $arrspl){
						if(!empty($arrspl)){
						$sql_sp_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_item_special_instruction WHERE id = '".$arrspl."'"));
						$sql_ins_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE id = '".$sql_sp_name['special_ins_id']."'"));
						$pr1 = ($array_items_ordered['quantity'] * $sql_sp_name['price']);?>
						<tr>
						  <td class="sub-list" align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo $sql_ins_name['special_instruction']; ?> ----- <?php echo $sql_sp_name['title']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo $array_items_ordered['quantity']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo "$".$sql_sp_name['price']; ?></td>
						  <td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;"><?php echo "$".$pr1; ?></td>
	                  </tr>
                      <?php if($array_items_ordered['special_instructions']!=''){ ?>
						<tr>
						  <td class="sub-list" align="left" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;" colspan="4"><?php if($array_items_ordered['special_instructions']!=''){ echo "Additional Instructions : ".htmlspecialchars_decode(htmlspecialchars_decode($array_items_ordered['special_instructions']))."<br><br>"; } ?></td>
	                  </tr>
                      <?php } ?>
                      <?php } } ?>
	                  <!-- End looping row -->
						<?php
						$i++;
                        }
                        ?>
                        
						
						 <?php if($sql_menu_order['coupon_code']!=''){ ?> 
						<tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Coupon Code
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo $sql_menu_order['coupon_code']; ?>
							</td>
						</tr>
                        <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Coupon Discount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['coupon_discount']; ?>
							</td>
						</tr>
                        <?php } ?>
                        
                         <?php if($sql_menu_order['reward_points']!=0.00){ ?>
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Reward Point Discount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['reward_points']; ?>
							</td>
						</tr>
						<?php } ?>
                        
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Order Amount
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['total_price']; ?>
							</td>
						</tr>
                        
                        <?php if($sql_menu_order['type'] == 'del'){ ?>
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Delivery Charge
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php 
								if($sql_menu_order['delivery_charge'] == 0){
									echo "Free";
								 }
								else {
									echo "$ ".(number_format($sql_menu_order['delivery_charge'],2));
								}?>
							</td>
						</tr>
						<?php } ?>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Tax
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['tax']; ?>
							</td>
						</tr>
                        <?php if($sql_menu_order['service_fee']!=0){ ?>
                        <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Service Fee
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['service_fee']; ?>
							</td>
						</tr>
                        <?php } ?>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Tip
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$".$sql_menu_order['tip']; ?>
							</td>
						</tr>
                        
                         <tr>
							<td colspan="4" align="right" style="border: 1px solid #ddd;border-bottom: none;border-right: none; padding: 3px 28px 3px 3px;font-size: 14px;font-weight: bold;">
								Total
							</td>
							<td align="center" style="border: 1px solid #ddd;border-bottom: none;border-right: none;padding: 3px;font-size: 14px;font-weight: bold;">
								<?php echo "$ ".($sql_menu_order['total_price'] + $sql_menu_order['delivery_charge'] + $sql_menu_order['tax'] + $sql_menu_order['tip'] + $sql_menu_order['service_fee']); ?>
							</td>
						</tr>
                        
					</table>
            	</div>
            	<div class="clear"></div>
            	<p><a href="check_out.php?type=<?php echo $sql_menu_order['type']; ?>&order_id=<?php echo $sql_menu_order['order_id']; ?>&reorder=1" class="check_order_button" style="text-decoration: none; margin-left: 0px; float: left;"> Resubmit Order </a></p>
          		<div class="clear"></div>
            </div>
            
            
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

<?php /*?><?php include("includes/footer.php");?><?php */?>
<?php include("includes/footer_new.php");?>