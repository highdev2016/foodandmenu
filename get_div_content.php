<?php include ("admin/lib/conn.php");
$sql_restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
?>

<div id="restrnt_left_panel" class="restrnt_left_panel">
                    
        <div class="popup_icon"></div>
        
        <div class="restrnt_left_panel_box" id="pop-up">

        <h2><?php echo stripslashes($sql_restaurant_name['restaurant_name']); ?></h2>
        
        <?php $sql_get_additional_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['id']."'")); ?>
        <?php if($sql_get_additional_info['pickup'] == 1){?>
        <div class="rstrnt_pckup">
        <p>Pickup Available</p>
        </div>
        <?php } ?>
        
        <div class="">
        <div>
        
        <?php /*?><div class="rstrnt_rtngs">
        <?php 
        $rating = number_format(getRestaurantRating($_REQUEST['id']), 1);
        ?>
        <?php
        //echo $one_decimal_place = number_format($rating, 1);
        $rat_pt = (explode(".",$rating));
        $rat_pt[0];
        $rat_pt[1];
        
        $rem = 5 - $rat_pt[0];
        
        if($rating == 0)
        {
        for($i=0; $i<5;$i++){
        ?>
        <img width="16" height="15" src="images/star-3.png">
        <?php	
        }
        }
        else
        {
        if($rat_pt[1]<3 && $rat_pt[1]!=0){
        for($i=1; $i<=$rating;$i++){
        ?>
        <img width="16" height="16" src="images/star-1.png">
        <?php
        }
        }
        else if($rat_pt[1]>7){
        for($i=1; $i<=$rating+1;$i++){
        ?>
        <img width="16" height="16" src="images/star-1.png">
        <?php
        }
        }
        else {
        for($i=1; $i<=$rating;$i++){
        ?>
        <img width="16" height="16" src="images/star-1.png">
        <?php
        }
        }
        if($rat_pt[1]!= '' && $rat_pt[1]>2 && $rat_pt[1]<8){
        ?>
        <img width="16" height="15" src="images/star-2.png">
        <?php
        }
        if($rat_pt[1]!= '' && $rat_pt[1]>2 && $rat_pt[1]<8){
        for($j=1;$j<=$rem-1;$j++){
        ?>
        <img width="16" height="15" src="images/star-3.png">
        <?php
        }
        }
        else {
        for($j=1;$j<=$rem;$j++){
        ?>
        <img width="16" height="15" src="images/star-3.png">
        <?php
        }
        }
        }
        ?>
                
          </div><?php */?>
          
          <div class="clear"></div>
          </div>
          
          
         <div>
          <?php /*?><h2 class="local_reviews">
            <?php $total_reviews = getRestaurantCountRating($_REQUEST['id']); ?>
            <?php if($total_reviews!= 0){ ?> <a href="#top_div" onClick="showsidetab(<?php echo $_REQUEST['id']; ?>)" ><?php echo getRestaurantCountRating($_REQUEST['id']); ?> Reviews </a>
            <?php } ?>
           </h2><?php */?>
          
            
          </div>
        
        
                <div class="clear"></div>
        
        </div>
        
         <div class="rstrnt_reviews_rtngs">
                <h2>Popular Items <img src="images/star_ratng.png" alt="Popular item"></h2>
                    <div class="rstrnt_itms" style="width:234px;">
                    <?php $sql_pop_items = mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '".$_REQUEST['id']."' AND purchased!=0 ORDER BY purchased DESC LIMIT 0,5");
                    if(mysql_num_rows($sql_pop_items)>0){
                        while($array_pop_item = mysql_fetch_array($sql_pop_items)){?>
                    <ul>
                        <li><div class="new_search"><div style="width:150px; float:left;"><a href="Javascript:void(0);" style="cursor:default;"><?php echo $array_pop_item['menu_name'];?></div><span style="float:right; width:46px; color:#F17B05;"><?php echo "$ ".$array_pop_item['price']; ?></span></a></div></li>
                    </ul>
                    <div class="clear"></div>
                    <?php } } else { ?>
                    There are no popular items yet. Give it a try and let us know what you think.
                    <?php } ?>
                    <div class="clear"></div>
                    </div>
                
        </div>

</div>
<div class="clear"></div>
<?php  if($del_hours_from!='' && $del_hours_to!='' && $pickup_hours_from!='' && $pickup_hours_to!=''){
if(($time1 >$del_hours_from  && $time1 <$del_hours_to) || ($time1 >$pickup_hours_from  && $time1 <$pickup_hours_to)){ ?>
  <div class="saw_order">
    <a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>">See Menu and Order Online</a>
  </div>
<?php } } else{ ?> 
<div class="saw_order">
    <a href="restaurant.php?id=<?php echo $_REQUEST['id']; ?>">See Menu and Order Online</a>
</div>
<?php } ?>
</div>