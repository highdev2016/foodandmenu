<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
?>
<div class="cross_bt" style="margin-left:394px;">
<a href="javascript:void(0);" onclick="remove_div(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>

<input type="hidden" name="countdiv[]" value="<?php echo $id; ?>" class="webcampics">

<div class="restaurant_form_field">
<div class="clear"></div>
<p>Business hours Title :</p>

<input name="business_hours_title<?php echo $id; ?>" id="business_hours_title<?php echo $id; ?>" type="text" class="restaurant" />

<div class="clear"></div>
<p>Hours :</p>
<?php /*?><input name="hours<?php echo $id; ?>" id="hours<?php echo $id; ?>" type="text" class="restaurant" /><?php */?>
<input name="hours_from_<?php echo $id; ?>" id="hours_from_<?php echo $id; ?>" type="text" class="restaurant time_pick_ajax" value="<?php echo $result_business_delivery_details['hours_from']; ?>" style="width:93px;" onblur="check_res_bus_hrs_from(this.value,'<?php echo $id; ?>');" />
<span style="color:#888888;">to</span>
<input name="hours_<?php echo $id; ?>" id="hours_<?php echo $id; ?>" type="text" class="restaurant time_pick_ajax" value="<?php echo $result_business_delivery_details['hours']; ?>" style="width:93px;" onblur="check_res_bus_hrs_to(this.value,'<?php echo $id; ?>');" />
<div style="border-bottom:1px dashed #787878; width:387px;"></div>
<div class="clear"></div>
</div>




<div class="clear"></div>