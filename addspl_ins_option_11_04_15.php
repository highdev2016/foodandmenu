<?php
include ("admin/lib/conn.php");
$spl_ins_id = $_POST['spl_ins_id'];
$menu_id = $_POST['menu_id'];
$id = $_POST['id'];
$option_id = $_POST['option_id'];

?>
<div class="clear"></div>

<input type="hidden" name="countsplinsoptiondiv<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>[]" value="<?php echo $option_id; ?>" class="webcampics">

<div id="spl_titlediv_<?php echo $menu_id; ?>_<?php echo $spl_ins_id; ?>_<?php echo $option_id; ?>"><div class="cross_bt" style="margin-left:440px;">
<a href="javascript:void(0);" onclick="remove_spl_title_div(<?php echo $menu_id; ?>,<?php echo $spl_ins_id; ?>,<?php echo $option_id; ?>);">
<img src="images/Close_Box_Red.png">
</a>
</div>

<input type="hidden" name="countdiv_spl_ins_title[]" value="1" class="webcampics">

<div style="border-bottom:1px dashed #787878; width:460px;"></div>
<p style="width:150px;">Title :</p>
<input name="spl_title_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>_<?php echo $option_id; ?>" id="spl_title_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>_<?php echo $option_id; ?>" type="text" class="restaurant">
<div class="clear"></div>

<p style="width:150px;">Price :</p>
<input name="spl_price_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>_<?php echo $option_id; ?>" id="spl_price_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>_<?php echo $option_id; ?>" type="text" class="restaurant" onkeypress="return goodchars(event,'1234567890.');">
<div class="clear"></div></div>





