<?php
include ("admin/lib/conn.php");
$spl_ins_id = $_POST['spl_ins_id'];
$id = $_POST['id'];

?>

<input type="hidden" name="countoptions<?php echo $spl_ins_id; ?>[]" value="<?php echo $id; ?>" class="webcampics">
<table>
<tbody><tr>
 <td>
  Title : <input type="text" class="restaurant" name="ins_title_<?php echo $spl_ins_id; ?>_<?php echo $id; ?>" id="ins_title_<?php echo $spl_ins_id; ?>_<?php echo $id; ?>" value="">
 </td>
  <td>
 Price : <input type="text" class="restaurant" name="ins_price_<?php echo $spl_ins_id; ?>_<?php echo $id; ?>" id="ins_price_<?php echo $spl_ins_id; ?>_<?php echo $id; ?>" value="">
  </td>
 <td>
 <a href="javascript:void(0);"  onclick="remove_spl_option_div(<?php echo $spl_ins_id; ?>,<?php echo $id; ?>);"><img src="images/Close_Box_Red.png"></a>
 </td>
</tr>

</tbody></table>





