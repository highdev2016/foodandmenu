<?php
include ("admin/lib/conn.php");
$spl_ins_id = $_POST['spl_ins_id'];
$menu_id = $_POST['menu_id'];
$id = $_POST['id'];

?>
<div class="clear"></div>

<input type="hidden" name="countsplinsdiv<?php echo $menu_id; ?>_<?php echo $id; ?>[]" value="<?php echo $spl_ins_id; ?>" class="webcampics">

<input type="hidden" id="add_ins_option_id_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>" name="add_ins_option_id_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>" value="1">

<?php /*?><div id="spl_div_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>" class="mainmanu"><?php */?><div class="cross_bt add_nw_crs">
<a href="javascript:void(0);" onclick="remove_spl_ins_div(<?php echo $id; ?>,<?php echo $menu_id; ?>,<?php echo $spl_ins_id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>
<?php /*?><input type="hidden" value="1" name="spl_ins_title" id="spl_ins_title">

<input type="hidden" class="webcampics" value="1" name="countdiv_spl_ins[]"><?php */?>

<p style="width:150px;">Special Instruction :</p>
<input type="text" class="restaurant" id="special_instruction_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>" name="special_instruction_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>">
<span><a style="color:#F07200" onClick="add_spl_ins_option(document.getElementById('add_ins_option_id_<?php echo $menu_id; ?>_<?php echo $id; ?>_<?php echo $spl_ins_id; ?>').value,'<?php echo $spl_ins_id; ?>','<?php echo $menu_id; ?>','<?php echo $id; ?>')" href="javascript:void(0);">Add Option</a></span>
<div class="clear"></div>
<?php /*?></div><?php */?>





