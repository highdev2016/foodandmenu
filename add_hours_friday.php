<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
?>
<div class="cross_bt" style="margin-left:394px;margin-top:11px;">
<a href="javascript:void(0);" onclick="remove_div_friday(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>

<input type="hidden" name="countdiv_friday[]" value="<?php echo $id; ?>" class="webcampics">

<div class="restaurant_form_field">
<p></p>
<input name="business_hours_fri_from<?php echo $id; ?>" id="business_hours_fri_from<?php echo $id; ?>" type="text" class="restaurant time_pick_ajax" value="" style="width:93px;" onBlur="check_fri_buss_from(this.value,'<?php echo $id; ?>');" />
<span style="color:#888888;">to</span>
<input name="business_hours_fri_to<?php echo $id; ?>" id="business_hours_fri_to<?php echo $id; ?>" type="text" class="restaurant time_pick_ajax" value="" style="width:93px;" onBlur="check_fri_buss_to(this.value,'<?php echo $id; ?>');" />
<div class="clear"></div>
</div>

<div class="clear"></div>