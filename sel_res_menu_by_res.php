<?php
session_start();
include ("admin/lib/conn.php");
include ("includes/functions.php");
?>
<script type="text/javascript">
$('#checkAllAuto').click(function(){
	$("INPUT[name='check_box[]'][type='checkbox']").attr('checked', $('#checkAllAuto').is(':checked'));
});
$("INPUT[name='check_box[]'][type='checkbox']").click(function(){
	var all_checked = false;
	$("INPUT[name='check_box[]'][type='checkbox']").each(function(){
		if($(this).is(':checked')){
			all_checked = true;
		}else{
			all_checked = false;
			return all_checked;
		}
	});
	$("#checkAllAuto").attr('checked', all_checked);
});
</script>
 
<?php
$res_id =$_REQUEST['id'];

$get_res_menu = mysql_query("SELECT * FROM restaurant_menu_item where restaurant_id = '".$res_id."' ORDER BY menu_name ASC");
$count = mysql_num_rows($get_res_menu);
$i = 1;
if($count > 0)
{
	echo '<label class="pop-subtitle"><input type="checkbox"  name="checkAllAuto" id="checkAllAuto"  value="0"/> <span>Select All Menus</span></label><div class="clear"></div>';
}
elseif($count == 0)
{
	echo "No Menu Found.";
}
while($all_res_menu = mysql_fetch_array($get_res_menu))
{
	echo "<li> <input type='checkbox' name='check_box[]' id='menu_sel_by_owner' value='".$all_res_menu['id']."' >"." ".$all_res_menu['menu_name']."</li>";
	
	$i++;
}
if($count > 0)
{
	echo "<div class='popftr'> <input type='submit' class='button4 center-btn' name='sub_button' id='sub_button' value='Copy Menu' /></div>";
}



?>
