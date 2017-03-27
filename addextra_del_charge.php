<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
?>
<div class="cross_bt" style="margin-left:394px;">
<a href="javascript:void(0);" onclick="remove_del_charge_div(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>

<input type="hidden" name="countdiv_del[]" value="<?php echo $id; ?>" class="webcampics">

<div class="restaurant_form_field">

<p>Delivery Range (miles) :</p>
<input name="delivery_range<?php echo $id; ?>" id="delivery_range<?php echo $id; ?>" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" />
<div class="clear"></div>

<p>Delivery Charge ($) :</p>
<input name="delivery_charge<?php echo $id; ?>" id="delivery_charge<?php echo $id; ?>" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');" />
<div class="clear"></div>
<div style="border-bottom:1px dashed #787878; width:387px;"></div>

</div>

<div class="clear"></div>