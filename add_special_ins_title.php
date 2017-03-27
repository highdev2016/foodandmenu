<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
$special_ins_id = $_POST['special_ins_id'];
$menu_id = $_POST['menu_id'];
?>
<div class="cross_bt" style="margin-left:440px;">
<a href="javascript:void(0);" onclick="remove_spl_title_div(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>
<?php /*?><input type="hidden" id="splins_title" name="splins_title" value="1"><?php */?>

<input type="hidden" name="countdiv_spl_ins_title[]" value="<?php echo $id; ?>" class="webcampics">

<div style="border-bottom:1px dashed #787878; width:460px;"></div>
<p style="width:150px;">Title :</p>
<input name="spl_title_<?php echo $menu_id; ?>_<?php echo $special_ins_id; ?>_<?php echo $id; ?>" id="spl_title_<?php echo $menu_id; ?>_<?php echo $special_ins_id; ?>_<?php echo $id; ?>" type="text" class="restaurant" />
<div class="clear"></div>

<p style="width:150px;">Price :</p>
<input name="spl_price_<?php echo $menu_id; ?>_<?php echo $special_ins_id; ?>_<?php echo $id; ?>" id="spl_price_<?php echo $menu_id; ?>_<?php echo $special_ins_id; ?>_<?php echo $id; ?>" type="text" class="restaurant" onkeypress="return goodchars(event,'1234567890.');" />
<div class="clear"></div>