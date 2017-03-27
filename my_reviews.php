<?php
ob_start();
session_start();
include ("includes/header_vendor.php");
include ("admin/lib/conn.php");
include ("includes/functions.php");
//rest_chk_authentication();
//print_r($_SESSION);
if(!isset($_SESSION['restaurant_admin_panel_id'])){
	header('location:restaurant_admin_login.php');
}

///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	$sql_select= mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$_REQUEST['delete_id']."'"));
	$sql_update_review = mysql_query("UPDATE restaurant_basic_info SET reviewed = reviewed - 1 WHERE id = '".$sql_select['restaurant_id']."'");
	$sql_update_customer = mysql_query("UPDATE restaurant_customer SET no_reviews = no_reviews - 1 WHERE id = '".$sql_select['customer_id']."'");
	$sql_select_rating = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rating WHERE review_id = '".$_REQUEST['delete_id']."'"));
	
	if($sql_select_rating['score_1'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 1 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_2'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 2 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_3'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 3 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_4'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 4 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_5'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated - 5 WHERE id = '".$sql_select['restaurant_id']."'");}
	
	mysql_query("DELETE FROM restaurant_reviews WHERE id=".$_REQUEST['delete_id']."");
	mysql_query("DELETE FROM restaurant_photo WHERE image_name='".$sql_select['review_picture']."'");
	mysql_query("DELETE FROM restaurant_rating WHERE review_id=".$_REQUEST['delete_id']."");
	mysql_query("DELETE FROM  restaurant_like_dislike WHERE  review_id=".$_REQUEST['delete_id']."");
	header("location:my_reviews.php?success=1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////

?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
  $(function() {
   $("#date").datepicker({ dateFormat: "yy-mm-dd" }).val()
  });
  </script>
  
<script type="text/javascript">
function sort_function(sort_by,post_date,customer_name){
	location.href = 'my_reviews.php?sort_order='+sort_by+"&post_date="+post_date+"&customer_name="+customer_name;
}
</script>
<body>

<?php include ("includes/menu_rest_admin_panel.php");?>
<?php include ("image_file.php");?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body">

<div class="restaurant_body_cont restu_live_cont">

<?php include ("includes/restaurant_nav_menu.php");?>

<div class="restaurant_cont_field" style="margin:0 15px;">

<p style="color:#454EA8; font-size:21px;">Search Panel</p><br>
<form name="frm" method="post" action="">
<table class="sec-pnl-top"><tr>
<td width="80">Post Date : </td><td width="176"><input type="text" name="date" id="date" value="<?php echo $_REQUEST['date'];?>" class="restaurant"></td>
<td width="155">Customer Name : </td><td width="198"><input type="text" name="customer_name" value="<?php echo $_REQUEST['customer_name'];?>" class="restaurant"></td>
<td width="191"><input type="submit" name="submit" value="Search" class="button4" style="margin:0 0 0 5px;"></td>
<tr>
</table>
</form>

<form name="frm1" id="frm1" method="post" action="my_reviews.php">
<div id="success_msg" style="display:none; color:#090;">Successfully Comment Posted against the Review.</div>
<div align="right"  class="sort">
Items Per Page : <select name="item_per_page" id="item_per_page" onChange="frm1.submit();">
<option value="25"<?php if($_REQUEST['item_per_page'] == 25) { ?> selected <?php } ?>>25</option>
<option value="50"<?php if($_REQUEST['item_per_page'] == 50) { ?> selected <?php } ?>>50</option>
<option value="75"<?php if($_REQUEST['item_per_page'] == 75) { ?> selected <?php } ?>>75</option>
<option value="100"<?php if($_REQUEST['item_per_page'] == 100) { ?> selected <?php } ?>>100</option>
</select>
</div>

</form>




<?php if($_REQUEST['success'] == 1){ ?>
<p style="text-align:center;">Review deleted successfully.</p>
<?php } else if($_REQUEST['reply'] == 1){ ?>
<p style="text-align:center;">Reply sent successfully.</p>
<?php } ?>

<table width="99%" border="1" bordercolor="c5c8d5" cellspacing="0" cellpadding="0" style="border-collapse:collapse; margin-top:20px;" align="center">
  <tr>
  	<th width="6%" class="all_restaurant">Sl No.</th>
    <th width="11%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('post_date','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">Post Date</a></th>
    <th width="15%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_name','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">Customer Name</a></th>
    <th width="10%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('city','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">City</a></td>
    <th width="11%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('state','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">State</a></th>
    <th width="10%" class="all_restaurant">Review Image</th>
    <th width="34%" class="all_restaurant"><a href="javascript:void(0)" onClick="sort_function('customer_review','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['customer_name']; ?>')" class="heading_link">Reviews</a></th>
    <th width="13%" class="all_restaurant">Action</th>
  </tr>
  <?php 
  $today = date('Y-m-d');
  $query_res = ("SELECT * FROM restaurant_reviews WHERE restaurant_id = '".$_SESSION['restaurant_admin_panel_id']."' AND status = 1");
  //$query_res = ("SELECT * FROM restaurant_reviews WHERE restaurant_id = '61' AND status = 1");
	if($_REQUEST['date']!=''){
		$query_res.= " AND post_date = '".$_REQUEST['date']."'";
	}
	if($_REQUEST['customer_name']!=''){
		$query_res.= " AND customer_name LIKE  '%".$_REQUEST['customer_name']."%'";
	}
	if($_REQUEST['sort_order']){
        $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
    }else{
		$query_res.=" ORDER BY id DESC";
			
	}
  $sql_order = mysql_query($query_res);
  if(mysql_num_rows($sql_order)>0){
	  
		//////////////////////start pagination/////////////////////////
		if($_REQUEST['search']!="")
		{
			$page=1;
		}
		else
		{
			$page=$_REQUEST['page'];
			
			if($_REQUEST['page']=="") 
			{ 
			$page = 1; 
			} 
		}
		if($_REQUEST['item_per_page'] == "")
		{
			$max_results = 25; 
		}
		else
		{
			$max_results = $_REQUEST['item_per_page'];
		}  
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sql_order); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"my_reviews.php?page=$prev&date=".$_REQUEST['date']."&customer_name=".$_REQUEST['customer_name']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		for($i = 1; $i <=$total_pages; $i++) 
		{ 
		if(($page) == $i) 
		{ 
		$pagination .= $i; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		else 
		{ 
		$pagination .= "<a href=\"my_reviews.php?page=$i&date=".$_REQUEST['date']."&customer_name=".$_REQUEST['customer_name']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"my_reviews.php?page=$next&date=".$_REQUEST['date']."&customer_name=".$_REQUEST['customer_name']."&item_per_page=".$_REQUEST['item_per_page']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
		if($_REQUEST['page']!="")
		{
			$j=($_REQUEST['page']-1)*$max_results;
		}
		if($_REQUEST['search']!="")
		{
		$j=0;	
		}
	  ?>	
  <input type="hidden" id="res_id" value="<?php echo $_SESSION['restaurant_admin_panel_id']; ?>" >
  <?php $inc = 1;
  while($array_order = mysql_fetch_array($query_products)){ ?>
  <tr>
  	<td class="all_restaurant2"><?php echo $a=($j+$inc); ?></td>
    <td class="all_restaurant2"><?php echo 
date("m-d-Y", strtotime($array_order['post_date'])); ?></td>
    <td class="all_restaurant2"><?php echo $array_order['customer_name']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['city']; ?></td>
    <td class="all_restaurant2"><?php echo $array_order['state']; ?></td>
    <td class="all_restaurant2"><?php if($array_order['review_picture']){ ?><img src="thumb_images/<?php echo $array_order['review_picture'];?>" height="39" width="39"><?php } ?></td>
    <td class="all_restaurant2"><?php echo $array_order['customer_review']; ?></td>
    
    <td class="all_restaurant2">
    
    <?php /*?><a href="reply_reviews.php?customer_id=<?php echo $array_order['customer_id'];?>&review_id=<?=$array_order['id']?>&page=<?=$_REQUEST['page']?>"><?php */?>
    
    <a href="javascript:void(0);" onClick="open_review_div(<?php echo $array_order['id']; ?>)" >
    
    <img src="admin/images/1373904457_reply.png" alt="Comment on this Review" title="Comment on this Review" border="0" />
    </a><?php /*?><a href="my_reviews.php?delete=del&delete_id=<?php echo $array_order['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="admin/images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a><?php */?>
    </td>
  </tr>
  
  <?php 
  
  $get_owner_review = mysql_fetch_array(mysql_query("SELECT comment FROM restaurant_rev_owners_comment WHERE review_id = '".$array_order['id']."'"));
  
  ?>
  
  <div id="review_div<?php echo $array_order['id']; ?>" class="factor_details white_content nw_white_cont nw_white_cont-new" style="display:none;">
        <div class="close close-new" onClick="close_review_div('<?php echo $array_order['id']; ?>');"><a href = "javascript:void(0);"></a> </div>
        <div class="l-contnt nw-l-cont pop-up-cont"> 
               <h2 class="pop-title up_nw_load_nw" style="margin-bottom: 18px !important;">Reply on Review</h2>
                        
                        <div class="form-body reason_reject">
                        
                        <div class="form-group" style="margin-bottom:15px;">
										<label class="control-label pop-text pop-text-n">
                                        
                                        <?php
										$rev_count = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$array_order['restaurant_id']."' AND rrat.restaurant_id='".$array_order['restaurant_id']."' AND rr.status=1 AND rr.customer_id = '".$array_order['customer_id']."' ORDER BY rr.id DESC"));

								

								

								

								$customerInfo = customerInfo($array_order['customer_id']);

								//echo $res_review['id'];

								/*echo '<pre>';

								print_r($customerInfo);*/

								$cust_img = ($customerInfo['image']!='') ? $customerInfo['image'] : 'no_image.png';

								$rating = getSingleReviewRating($array_order['restaurant_id'],$array_order['id']);

								//echo $res_review['id'];

								

								$sql_updated_review = mysql_query("SELECT * 

								FROM restaurant_reviews as rr,restaurant_rating as rrat 

								WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$array_order['restaurant_id']."' AND rrat.restaurant_id='".$array_order['restaurant_id']."' AND rr.status=1 AND rr.review_status = 1 AND parent_id = '".$array_order['id']."' ORDER BY rr.id DESC");

								

								$sql_count_review_cust = mysql_num_rows(mysql_query("SELECT id FROM restaurant_reviews WHERE customer_id = '".$customerInfo['id']."'"));

								$sql_count_follower_cust = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE following_id = '".$customerInfo['id']."' AND status = '1'"));

								$sql_count_following_cust = mysql_num_rows(mysql_query("SELECT id FROM user_follow WHERE follower_id = '".$customerInfo['id']."' AND status = '1'"));

								

								if($sql_count_review_cust > 1)

								{

									$review = "reviews";

								}

								else

								{

									$review = "review";

								}

								

								if($sql_count_follower_cust > 1)

								{

									$follower = "followers";

								}

								else

								{

									$follower = "follower";

								} 
										
										?>
                                        
                                        <div class="review_light review_light-new-a">

                                    

                                       		<div class="img-sec-left img-sec-left-new">

		                                        <a href="user.php?id=<?php echo $customerInfo['id']; ?>" title="<?php echo $customerInfo['firstname']; ?>">

		                                        <img src="thumb_images/<?php echo $cust_img; ?>" alt="" title="" />

		                                        </a>

	                                        </div>

	                                        <div class="name-sec-right name-sec-right-new">

												<p class="custoname"><?php echo $customerInfo['firstname']." ".substr($customerInfo['lastname'],0,1)."." ?></p>

		                                       <?php if($customerInfo['city'] != '') { ?> <p class="custoinfo"><?php echo $customerInfo['city'].", ".$customerInfo['state'] ?></p> <?php } ?>

		                                       

		                                       <?php if($sql_count_review_cust != 0) { ?><p><img src="images/star-on.png" width="16px" alt="" align="absmiddle" /> <?php echo $sql_count_review_cust." ".$review; ?></p><?php } ?>

		                                       

		                                       <?php if($sql_count_follower_cust != 0) { ?><p><img src="images/follower.png" width="16px" alt="" align="absmiddle" /> <?php echo $sql_count_follower_cust." ".$follower; ?></p><?php } ?>

		                                       

											   <?php if($sql_count_following_cust != 0) { ?><p> <img src="images/following.png" width="16px" alt="" align="absmiddle" /> <?php echo $sql_count_following_cust." following"; ?></p><?php } ?>

	                                        </div>

											<div class="clear"></div>
                                    

                                    <div style="display: none;">

                                    <div id="inline<?php echo $customerInfo['id']; ?>" style="height:250px; min-height:450px; overflow:auto; width:615px;">

									<?php

									

									 $sql_user_reviews = mysql_query("SELECT * FROM restaurant_reviews WHERE customer_id = '".$customerInfo['id']."' ORDER BY id DESC");

									

									 ?>

                                    <h1 class="review_top_heading"><span>Total Reviews : <?php echo mysql_num_rows($sql_user_reviews); ?></span></h1>

                                    <?php

									while($array_user_reviews = mysql_fetch_array($sql_user_reviews)){

									?>

                                        <div class="review_top">

                                        <h1><span><a href="restaurant.php?id=<?php echo $array_user_reviews['restaurant_id']; ?>" style="color:#F07A01; text-decoration:none;"><?php echo $array_user_reviews['restaurant_name']; ?></a></span></h1>                                          

                                        <ul>

                                    	<?php

										$rating1 = getSingleReviewRating($array_user_reviews['restaurant_id'],$array_user_reviews['id']);

										//echo $rating1;

										$rem = 5 - $rating1;

										if($rating1 > 0)

										{

											for($i=0; $i<$rating1;$i++){

										?>

                                        <li><img width="16" height="16" src="images/star-1.png"></li>

                                        <?php

											}

											for($j=0;$j<$rem;$j++){

										?>

                                        <li><img width="16" height="15" src="images/star-3.png"></li>

                                        <?php

											}

										}

										else{

								        ?>

                                        <?php

										}

										?>

                                    <li><?php echo date("m-d-Y", strtotime($array_user_reviews['post_date']));?></li>    

                                	</ul>
                                          <p><?php echo $array_user_reviews['customer_review']; ?></p>
                                          </div>
                                    <?php } ?> 

                                    </div>
                                	</div>
								</div>
                                        
                                        
                                        
                                        
										</label>
                                        
                                        <div class="text_pad pop-fild pop-fild-new">
                                     <div class="date-review-new">   <?php echo  
date("m-d-Y", strtotime($array_order['post_date']));?> by <?php echo $array_order['customer_name']; ?></div>

<div class="rating_content rviw review">

		                                    <ul>

		                                    	<?php
 $rating_updated = getSingleReviewRating($array_order['restaurant_id'],$array_order['id']);

												$rem = 5 - $rating_updated;

												if($rating_updated > 0)

												{

													for($i=0; $i<$rating_updated;$i++){

												?>

		                                        <li><img width="16" height="16" src="images/star-1.png"></li>

		                                        <?php

													}

													for($j=0;$j<$rem;$j++){

												?>

		                                        <li><img width="16" height="15" src="images/star-3.png"></li>

		                                        <?php

													}

												}

												else{

										?>

		                                 		<li><div style="width:165px;">&nbsp;</div></li>

		

		                                        <?php

												}

												?>

												

												

		                                	</ul>

		                                   

		                                </div>
<div class="clear"></div>



                                   <div class="customer-review">     <?php echo $array_order['customer_review']; ?></div>
                                            </div>
                                        <div class="clear"></div>
                                        </div>
                        
                        
                        
                                
                               		<div class="form-group">
										<label class="control-label pop-text pop-text-n">Reply Content                                 			<span class="required">*</span>        
										</label>
                                        
                                        <div class="text_pad pop-fild pop-fild-new">
                    <textarea onKeyUp="check_val(<?php echo $array_order['id']; ?>);"  style="border: 1px solid rgb(181, 171, 198); border-radius: 2px; width: 328px; height: 80px;" id="rep_content<?php echo $array_order['id'] ?>" ><?php if($get_owner_review['comment'] != '') { echo $get_owner_review['comment']; } ?></textarea>
                    
                    <div id="error_msg_div<?php echo $array_order['id']; ?>" style="color:#F00; display:none;"></div>
                                            
                                           
                                            
                                            
                                            </div>
                                        
                                        </div>
                                        <div class="clear"></div>
                    <div class="btn-row" style="margin-top:10px; padding-left:40%;">
                  
                    <input id="submit" type="button" value="Reply" class="button4" style="margin-left:0px;" onClick="submit_owner_review('<?php echo $array_order['id'] ?>');">
                    <input id="cancel" type="button" value="Cancel" class="button4" style="margin-left:0px;" onClick="close_review_div('<?php echo $array_order['id'] ?>');">
                    
                    <span id="loader_span<?php echo $array_order['id'] ?>" style="margin-left: 39px; display:none;"><img src="images/ajax-loader-review.gif" /></span>
                    
                     </div> 
                                       </div>
                  
            </div>
        </div>
        <div id="fade1" class="black_overlay"> </div>
  
  
  <?php $inc++; } } else { ?>
  <tr>
    <td class="all_restaurant2" colspan="9" style="text-align:center;">No Reviews yet</td>
  </tr>
  <?php } ?>
</table>


<?php if($total_pages > 1){ ?>
<div style="text-align:center; margin-top:10px;"><?php echo $pagination; ?></div><?php } ?>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<script type="text/javascript">

function open_review_div(id)
{
	var $j = jQuery.noConflict();
	
	$j("#review_div"+id).show();
	$j("#fade1").show();
}

function close_review_div(id)
{
	var $j = jQuery.noConflict();
	
	$j("#review_div"+id).hide();
	$j("#fade1").hide();
}

function check_val(id)
{
	var $j = jQuery.noConflict();
	
	var comment = $j("#rep_content"+id).val();
	
	if(comment != '')
	{
		$j("#error_msg_div"+id).hide(500);
	}
	else
	{
		$j("#error_msg_div"+id).show(500);
	}
}

function submit_owner_review(id)
{
	var $j = jQuery.noConflict();
	
	var comment = $j("#rep_content"+id).val();
	
	var res_id = $j("#res_id").val();
	
	if(comment != '')
	{
		$j("#loader_span"+id).show();
		
		$j.ajax({
			url : 'submit_owner_comment.php',
			type : 'POST',
			data : 'id=' + id + '&comment=' + comment + '&res_id=' + res_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				if(data == 'Success')
				{
					setTimeout(function() 
					{
						$j("#success_msg").fadeIn(1500);
						$j("#loader_span"+id).hide();
						$j("#review_div"+id).hide();
						$j("#fade1").hide();
						
					},4000);
					
				}
				
				setTimeout(function() { $j("#success_msg").fadeOut(1500); },5000);
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
	}
	else
	{
		$j("#error_msg_div"+id).html('Comment Field Must Not Left Blank!!').fadeIn(500);
	}
}

</script>