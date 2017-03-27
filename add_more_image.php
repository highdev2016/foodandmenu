<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];


?>
<div class="cross_bt" style="margin-left:450px;">
<a href="javascript:void(0);" onclick="remove_div(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>

<input type="hidden" name="countdiv[]" value="<?php echo $id; ?>" class="webcampics">


<p></p>

<input name="review_picture<?php echo $id; ?>" type="file" class="restaurant_browse" />   
<span style="color:#ff0000; margin-left:167px;">[Best size : 425 X 300]</span>

<div class="clear"></div>




