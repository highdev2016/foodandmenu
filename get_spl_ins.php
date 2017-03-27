<?php
include ("admin/lib/conn.php");
?>
<script type="text/javascript">
$('#checkAllAuto_ins').click(function(){
	$("INPUT[name='ins_menu[]'][type='checkbox']").attr('checked', $('#checkAllAuto_ins').is(':checked'));
});
$("INPUT[name='ins_menu[]'][type='checkbox']").click(function(){
	var all_checked = false;
	$("INPUT[name='ins_menu[]'][type='checkbox']").each(function(){
		if($(this).is(':checked')){
			all_checked = true;
		}else{
			all_checked = false;
			return all_checked;
		}
	});
	$("#checkAllAuto_ins").attr('checked', all_checked);
});
</script>
<?php
$menu_id = $_REQUEST['menu_ins'];

$men_id = $_REQUEST['menu_id'];

$sql_get_menu = mysql_query("SELECT * FROM restaurant_menu_special_instruction WHERE menu_id = '".$menu_id."' ");
$count = mysql_num_rows($sql_get_menu);
if($count > 0)
{
	echo '<label class="pop-subtitle"><input type="checkbox"  name="checkAllAuto_ins" id="checkAllAuto_ins"  value="0"/> <span>Select All Special Instruction</span></label><div class="clear"></div>';
}
elseif($count == 0)
{
	echo "No Special Instructions Found.";
}
while($row_get_menu = mysql_fetch_assoc($sql_get_menu))
{
	echo '<li><input type="checkbox" name="ins_menu[]" id="ins_menu" value="'.$row_get_menu['id'].'"> '.$row_get_menu['special_instruction'].'</li>';
}

echo '<input type="hidden" name="hid_menu_ins" id="hid_menu_ins" value="'.$men_id.'">';

if($count > 0)
{
	echo "<div class='popftr' style='position:relative;'> <input type='submit' class='button4 center-btn' name='sub_ins_button' id='sub_button' value='Copy Special Instructions' /></div>";
}

?>