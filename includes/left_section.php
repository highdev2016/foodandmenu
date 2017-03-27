<div class="body_cont_left">

<div class="left_feature">

<div class="left_feature_top">
<h1>Feature Cities</h1>
</div>

<div class="left_feature_middle">
<ul>
<?php
$res_featured_city=mysql_query("select * from restaurant_featured_city where status=1 ORDER BY featured_city ASC");
$i=1;
while($row_featured_city=mysql_fetch_array($res_featured_city))
{
?>
<li><a href="search_area.php?featured_city=<?php echo $row_featured_city['featured_city']; ?>" <?php if($_REQUEST['featured_city']==$row_featured_city['featured_city']){?> class="active" <?php } ?>><?php echo $row_featured_city['featured_city']?></a></li>
<?php
$i++;
}
?>
<!--<li><a href="#">Dallas</a></li>
<li><a href="#">Houston</a></li>-->
</ul>
</div>

<div class="left_feature_bottom"></div>

</div>

<div class="left_top">

<div class="left_bg_top">
<h1>Popular cuisine</h1>
</div>

<div class="left_bg_middle">
<ul>
<?php /*?><?php $sql_sub_category = mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE id!=''");
while($array_sub_category = mysql_fetch_array($sql_sub_category)){
	$resarr = array();
	//echo "SELECT id,count(*) as total from restaurant_menu_item WHERE sub_category_id = '".$array_sub_category['id']."' AND status =1 GROUP BY id";
	$qry = mysql_query("SELECT distinct restaurant_id as total from restaurant_menu_item WHERE sub_category_id = '".$array_sub_category['id']."' AND status =1 ");
	while($sql_count = mysql_fetch_array($qry))
	{
		$resarr[]= $sql_count['total'];
	}
	//print_r($resarr);
	?>
<li><a href="search.php?sub_cat_id=<?php echo $array_sub_category['id']; ?>" <?php if($_REQUEST['sub_cat_id'] == $array_sub_category['id']) {?> class="active"<?php } ?>><?php echo $array_sub_category['subcategory_name']; ?> (<?php echo sizeof($resarr);?>)</a></li>
<?php } ?><?php */?>

<?php $sql_sub_category = mysql_query("SELECT * FROM  restaurant_category WHERE id!='' ORDER BY category_name");
while($array_sub_category = mysql_fetch_array($sql_sub_category)){
	$resarr = array();
	//echo "SELECT id,count(*) as total from restaurant_menu_item WHERE sub_category_id = '".$array_sub_category['id']."' AND status =1 GROUP BY id";
	$qry = mysql_query("SELECT distinct id as total from restaurant_basic_info WHERE  find_in_set(".$array_sub_category['id'].",restaurant_category) AND status =1 AND featured_status = 1");
	while($sql_count = mysql_fetch_array($qry))
	{
		$resarr[]= $sql_count['total'];
	}
	//print_r($resarr);
	?>
<li><a href="search.php?sub_cat_id=<?php echo $array_sub_category['id']; ?>" <?php if($_REQUEST['sub_cat_id'] == $array_sub_category['id']) {?> class="active"<?php } ?>><?php echo $array_sub_category['category_name']; ?> (<?php echo sizeof($resarr);?>)</a></li>
<?php } ?>



<!--<li><a href="#" class="active">Pizza (93)</a></li>
<li><a href="#">Italian (78)</a></li>
<li><a href="#">Asian (75)</a></li>
<li><a href="#">Sandwiches (75)</a></li>
<li><a href="#">American (64)</a></li>
<li><a href="#">Chinese (49)</a></li>
<li><a href="#">Salad (44)</a></li>
<li><a href="#">Thai (40)</a></li>
<li><a href="#">Middle Eastern (34)</a></li>
<li><a href="#">Burgers (33)</a></li>-->
</ul>
</div>

<div class="left_bg_bottom"></div>

</div>

<div class="left_details">
<div class="left_details_top">
<h1 style="font-size:17px !important;">Our Updates</h1>
</div>
<div class="left_details_bottom">
<?php $sql_updates = mysql_query("SELECT * FROM restaurant_updates WHERE id!='' ORDER BY id desc LIMIT 0,5");
while($array_updates = mysql_fetch_array($sql_updates)){?>
<h1><?php echo date("m-d-Y", strtotime($array_updates['date']));?></h1>
<div class="update_new"><?php echo $array_updates['short_desc'];?>
<span class="more_link_new"><a href="updates.php?id=<?php echo $array_updates['id'];?>">more...</a></span>
<div style="clear:both;"></div>
</div>
<?php } ?>
</div>
</div>

</div>