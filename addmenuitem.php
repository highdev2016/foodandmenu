<?php
include ("admin/lib/conn.php");
$id = $_POST['id'];
$main_menu_id = $_POST['main_menu_id'];

?>
<div class="cross_bt add_nw_crs">
<a href="javascript:void(0);" onclick="remove_menu_div(<?php echo $id; ?>);">
<img  src="images/Close_Box_Red.png">
</a>
</div>



<div id="menu_item_div<?php echo $main_menu_id; ?>_<?php echo $id; ?>">
<input type="hidden" name="add_ins_id_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="add_ins_id_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" value="1" >
<input type="hidden" name="countmenudiv_<?php echo $main_menu_id; ?>[]" value="<?php echo $id; ?>" class="webcampics">
    <div class="new-res-fild">
        <div class="addmenu-fild">
            <label>Menu Items Name :</label>
            <input name="menu_item_name_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="menu_item_name_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" type="text" class="restaurant" />
        </div>
        <div class="addmenu-fild">
            <label>Menu Price :</label>
            <input name="menu_item_price_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="menu_item_price_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" type="text" class="restaurant" onKeyPress="return goodchars(event,'1234567890.');"/>
        </div>
        <div class="addmenu-fild">
            <label>Menu Description  :</label>
            <textarea name="menu_item_description_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="menu_item_description_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" rows="3" cols="25" style="border:1px solid #B5ABC6; margin-top:10px;"></textarea>
        </div>
        <div class="addmenu-fild">
            <label>Menu Picture :</label>
            <input name="menu_item_picture_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="menu_item_picture_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" type="file" class="restaurant_browse" />
        </div>
        <div class="addmenu-fild btnsec">
            <a href="javascript:void(0);" style="font-size:16px;" class="button4 menu-btn" onClick="add_spl_ins(document.getElementById('add_ins_id_<?php echo $main_menu_id; ?>_<?php echo $id; ?>').value,'<?php echo $main_menu_id; ?>','<?php echo $id; ?>')">Add Special Instruction</a>
        </div>
        <div class="clear"></div>
        <div class="addmenu-fild">
            <input type="checkbox" name="menu_item_whats_good_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="menu_item_whats_good_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" value="1" style="height:12px; width: 15px;"> What's Good
        </div>
        <div class="addmenu-fild">
            <input type="checkbox" name="menu_item_spicy_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="menu_item_spicy_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" value="1" style="height:12px; width: 15px;"> Spicy
        </div>
        <div class="addmenu-fild">
            <input type="checkbox" name="menu_item_veggie_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="menu_item_veggie_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" value="1" style="height:12px; width: 15px;"> Veggie
        </div>
        <div class="addmenu-fild">
            <input type="checkbox" name="menu_item_healthy_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" id="menu_item_healthy_<?php echo $main_menu_id; ?>_<?php echo $id; ?>" value="1" style="height:12px; width: 15px;"> Healthy
        </div>
            
    </div> 
</div>

<div class="clear"></div>






