<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
$menu_id = $_POST['menu_id'];
?>
<div class="cross_bt" style="margin-left:440px;">
<a href="javascript:void(0);" onclick="remove_spl_div(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>
<input type="hidden" id="spl_ins_title" name="spl_ins_title" value="1">

<input type="hidden" name="countdiv_spl_ins[]" value="<?php echo $id; ?>" class="webcampics">

<p style="width:150px;">Special Instruction :</p>
<input name="special_instruction_<?php echo $menu_id; ?>_<?php echo $id; ?>" id="special_instruction_<?php echo $menu_id; ?>_<?php echo $id; ?>" type="text" class="restaurant" />
<span><a href="javascript:void(0);" onClick="add_special_ins_title(document.getElementById('spl_ins_title').value,'<?php echo $id; ?>','<?php echo $menu_id; ?>')" style="color:#F07200">Add Option</a></span>
<div class="clear"></div>

<?php /*?><p>Title :</p>
<input name="spl_title_<?php echo $menu_id; ?>_<?php echo $id; ?>" id="spl_title_<?php echo $menu_id; ?>_<?php echo $id; ?>" type="text" class="restaurant" />
<span style="margin-left:10px;"><a href="javascript:void(0);" onClick="add_special_ins_title(document.getElementById('spl_ins_title').value,'<?php echo $id; ?>')" style="color:#F07200">Add new</a></span>
<div class="clear"></div>

<p>Price :</p>
<input name="spl_price<?php echo $id; ?>" id="spl_price<?php echo $id; ?>" type="text" class="restaurant" />
<div class="clear"></div><?php */?>