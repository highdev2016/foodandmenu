<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;">
<a href="javascript:void(0);" onclick="remove_pickup_div_tuesday(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>

<input type="hidden" name="countdiv_pickup_tuesday[]" value="<?php echo $id; ?>" class="webcampics">

<div class="restaurant_form_field">
<p></p>
<input name="pickup_hours_tue_from<?php echo $id; ?>" id="pickup_hours_tue_from<?php echo $id; ?>" type="text" class="restaurant time_pick_ajax" value="" style="width:93px;" onBlur="check_tue_pickup_from(this.value,'<?php echo $id; ?>');" />
<span style="color:#888888;">to</span>
<input name="pickup_hours_tue_to<?php echo $id; ?>" id="pickup_hours_tue_to<?php echo $id; ?>" type="text" class="restaurant time_pick_ajax" value="" style="width:93px;" onBlur="check_tue_pickup_to(this.value,'<?php echo $id; ?>');" />
<div class="clear"></div>
</div>

<div class="clear"></div>