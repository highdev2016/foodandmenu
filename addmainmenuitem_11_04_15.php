<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
$res_id = $_POST['res_id'];

?>
<div class="cross_bt">
<a href="javascript:void(0);" onclick="remove_main_menu_div(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>
<input type="hidden" id="menu_id_<?php echo $id; ?>" name="menu_id_<?php echo $id; ?>" value="2">

<input type="hidden" name="countmainmenudiv[]" value="<?php echo $id; ?>" class="webcampics">

<div class="new-res-fild">
	<div class="catsec">
		<label>Main Category : </label>
		<select name="menu_main_category<?php echo $id; ?>" id="menu_main_category<?php echo $id; ?>" class="restaurant_list" onChange="getSubcat(this.value,'<?php echo $id; ?>');">
		    <option value="">--Select Category --</option>
            <?php $sql_get_restaurant_category = mysql_query("SELECT * FROM restaurant_menu_category WHERE restaurant_id IN (".$res_id.") ORDER BY category_name ASC");
			while($array_restaurant_category = mysql_fetch_array($sql_get_restaurant_category)){ ?>
			<option value="<?php echo $array_restaurant_category['id']; ?>"><?php echo $array_restaurant_category['category_name']; ?></option>	
            <?php } ?>
		</select>
	</div>
	<div class="catsec">
		<label>Sub Category : </label>
        <div id="menu_sub_category_div<?php echo $id; ?>">
            <select name="menu_sub_category<?php echo $id; ?>" id="menu_sub_category<?php echo $id; ?>" class="restaurant_list">
                    <option value="">Select</option>
            </select>
        </div>
	</div>
	<div class="btnsec">
		<?php /*?><a href="javascript:void(0);" class="button4 menu-btn">Apply setting</a><?php */?>
		<a href="javascript:void(0);" class="button4 menu-btn" onClick="add_menu_item(document.getElementById('menu_id_<?php echo $id; ?>').value,'<?php echo $id; ?>')">Add Menu</a>
	</div>
    
    <div id="all_menu_item_<?php echo $id; ?>">
    <div id="menu_item_div<?php echo $id; ?>_1">
    <input type="hidden" name="countmenudiv[]" value="1" class="webcampics">
    <input type="hidden" name="add_ins_id_<?php echo $id; ?>_1" id="add_ins_id_<?php echo $id; ?>_1" value="1" >
    <input type="hidden" name="countsplinsdiv[]" value="1" class="webcampics">
        <div class="new-res-fild">
            <div class="addmenu-fild">
                <label>Menu Items Name :</label>
                <input name="menu_item_name_<?php echo $id; ?>_1" id="menu_item_name_<?php echo $id; ?>_1" type="text" class="restaurant" />
            </div>
            <div class="addmenu-fild">
                <label>Menu Price :</label>
                <input name="menu_item_price_<?php echo $id; ?>_1" id="menu_item_price_<?php echo $id; ?>_1" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"/>
            </div>
            <div class="addmenu-fild">
                <label>Menu Description  :</label>
                <textarea name="menu_item_description_<?php echo $id; ?>_1" id="menu_item_description_<?php echo $id; ?>_1" rows="3" cols="25" style="border:1px solid #B5ABC6; margin-top:10px;"></textarea>
            </div>
            <div class="addmenu-fild">
                <label>Menu Picture :</label>
                <input name="menu_item_picture_<?php echo $id; ?>_1" id="menu_item_picture_<?php echo $id; ?>_1" type="file" class="restaurant_browse" />
            </div>
            <div class="addmenu-fild btnsec">
                <a href="javascript:void(0);" style="font-size:16px;" class="button4 menu-btn" onClick="add_spl_ins(document.getElementById('add_ins_id_<?php echo $id; ?>_1').value,'<?php echo $id; ?>','1')">Add Special Instruction</a>
            </div>
        </div> 
        
        <div>
        
        
        </div>
        
    </div>
    <div class="clear"></div>
</div>
</div>
<div class="clear"></div>






