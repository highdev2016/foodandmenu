<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
$menu_id = $_POST['menu_id'];
?>

<div id="menu_spl_ins_option_<?php echo $menu_id; ?>_<?php echo $id; ?>">
<input type="hidden" name="countsplmenu_<?php echo $menu_id; ?>[]" id="countsplmenu" value="<?php echo $id; ?>">
<input type="hidden" name="menu_spl_ins_option_id_<?php echo $menu_id; ?>_<?php echo $id; ?>" id="menu_spl_ins_option_id_<?php echo $menu_id; ?>_<?php echo $id; ?>" value="1" />

<div style="border-bottom::1px solid dashed #eee;" id="spl_ins_menu_<?php echo $menu_id; ?>">

Special Instruction : <input type="text" class="restaurant" name="splinstxt_<?php echo $menu_id; ?>[]" id="splinstxt" value="">


<a href="javascript:void(0);" onClick="add_menu_spl_ins_option(document.getElementById('menu_spl_ins_option_id<?php echo $menu_id; ?>_<?php echo $id; ?>').value,'<?php echo $menu_id; ?>','<?php echo $id; ?>')" >Add Option</a>


<a href="javascript:void(0);" onclick="remove_menu_spl_ins_div(<?php echo $id; ?>,<?php echo $menu_id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>


</div>


</div>
    






