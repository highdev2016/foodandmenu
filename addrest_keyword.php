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
<p></p>

<input name="restaurant_keyword<?php echo $id; ?>" id="restaurant_keyword<?php echo $id; ?>" type="text" class="restaurant" />

<div class="clear"></div>
</div>
<div class="clear"></div>