<?php 
ob_start();

function main()
{
	function change_dateformat($date_form)
	{
	 if($date_form!=''){
	  $date1=explode("-",$date_form);
	  $dateformat=$date1[2]."-".$date1[0]."-".$date1[1];
	  return $dateformat;
	}
	else{
	  $dateformat='';
	  return $dateformat;
	}
}
	
function change_dateformat_reverse($date_form1)
{
 if($date_form1!=''){
  $date2=explode("-",$date_form1);
  $dateformat1=$date2[1]."-".$date2[2]."-".$date2[0];
  return $dateformat1;
  }
 else{
  $dateformat1='';
  return $dateformat1;
  }
}


function getRestaurantRating($restaurantid)
{
	$total_count = 0;
	$total_review_count = 0;
	$count_rating = array();
	
	$sql2= "select sum(score_1) as sc1,sum(score_2) as sc2,sum(score_3) as sc3,sum(score_4) as sc4,sum(score_5) as sc5 from `restaurant_rating` where `restaurant_id` = '".$restaurantid."' AND `status` = '1'";
	$result2 = @mysql_query($sql2);
	$rs2 = @mysql_fetch_array($result2);
	for($j = 1; $j<=5; $j++)
	{
		$count_rating[$j] = $rs2['sc' . $j];
		$total_review_count += $rs2['sc' . $j];
	}
	
	for($i = 1; $i<=5; $i++)
	{
		$total_count += ($i * $count_rating[$i]);
		//$total_review_count += $rs['score_' . $i];
	}
	//echo $total_count."<br>";
	//echo $total_review_count;
	//return round($total_count/$total_review_count);
	if($total_count == 0 || $total_review_count == 0)
		return 0;
	else		
		return $total_count/$total_review_count;	
}

///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	$sql_select= mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$_REQUEST['delete_id']."'"));
	$sql_update_review = mysql_query("UPDATE restaurant_basic_info SET reviewed = reviewed - 1 WHERE id = '".$sql_select['restaurant_id']."'");
	$sql_get_reward_point = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));
	$sql_update_customer = mysql_query("UPDATE restaurant_customer SET no_reviews = no_reviews - 1 , reward_point = reward_point - ".$sql_get_reward_point['online_review_rating']." WHERE id = '".$sql_select['customer_id']."'");
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
	
	
	$sql_ratt = mysql_query("SELECT * FROM restaurant_reviews WHERE parent_id=".$_REQUEST['delete_id'].""); 
	while($arr_res_ratt = mysql_fetch_array($sql_ratt)){
		mysql_query("DELETE FROM restaurant_reviews WHERE parent_id=".$_REQUEST['delete_id']."");
		mysql_query("DELETE FROM restaurant_rating WHERE review_id=".$arr_res_ratt['id']."");
	}
	mysql_query("DELETE FROM restaurant_reviews WHERE id=".$_REQUEST['delete_id']."");
	mysql_query("DELETE FROM restaurant_photo WHERE image_name='".$sql_select['review_picture']."'");
	mysql_query("DELETE FROM restaurant_rating WHERE review_id=".$_REQUEST['delete_id']."");
	
	$rate = getRestaurantRating($sql_select['restaurant_id']);
	
	mysql_query("UPDATE restaurant_basic_info SET rated = '".$rate."' WHERE id = '".$sql_select['restaurant_id']."'");
		
	mysql_query("DELETE FROM  restaurant_like_dislike WHERE review_id=".$_REQUEST['delete_id']."");
	$msg1="Successfully deleted reviews.";
	header("location:manage_reviews.php?msg1=$msg1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////
if($_REQUEST['action']=="active")
{
	$sql_select= mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$_REQUEST['active_id']."'"));
	$sql_update_review = mysql_query("UPDATE restaurant_basic_info SET reviewed = reviewed + 1 WHERE id = '".$sql_select['restaurant_id']."'");
	$sql_update_customer = mysql_query("UPDATE restaurant_customer SET no_reviews = no_reviews + 1 WHERE id = '".$sql_select['customer_id']."'");
	$sql_select_rating = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rating WHERE review_id = '".$_REQUEST['active_id']."'"));
	
	if($sql_select_rating['score_1'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated + 1 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_2'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated + 2 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_3'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated + 3 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_4'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated + 4 WHERE id = '".$sql_select['restaurant_id']."'");}
	else if($sql_select_rating['score_5'] == 1){
	$sql_update_rating = mysql_query("UPDATE restaurant_basic_info SET 	rated = rated + 5 WHERE id = '".$sql_select['restaurant_id']."'");}	
	
	mysql_query("update restaurant_reviews set status=1,abuse_status=0 where id='".$_REQUEST['active_id']."'");
	mysql_query("update restaurant_rating set status=1 where review_id='".$_REQUEST['active_id']."'");
	header("location:manage_reviews.php");
}
if($_REQUEST['action']=="inactive")
{
	$sql_select= mysql_fetch_array(mysql_query("SELECT * FROM restaurant_reviews WHERE id = '".$_REQUEST['inactive_id']."'"));
	$sql_update_review = mysql_query("UPDATE restaurant_basic_info SET reviewed = reviewed - 1 WHERE id = '".$sql_select['restaurant_id']."'");
	$sql_update_customer = mysql_query("UPDATE restaurant_customer SET no_reviews = no_reviews - 1 WHERE id = '".$sql_select['customer_id']."'");
	$sql_select_rating = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rating WHERE review_id = '".$_REQUEST['inactive_id']."'"));
	
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
	
	mysql_query("update restaurant_reviews set status=0 where id='".$_REQUEST['inactive_id']."'");
	mysql_query("update restaurant_rating set status=0 where review_id='".$_REQUEST['inactive_id']."'");
	header("location:manage_reviews.php");
}

?>
<script>
  $(function() {
    $( "#datepicker" ).datepicker(
	{dateFormat: 'mm-dd-yy',

  changeDate: true,

  changeMonth: true,

  changeYear: true,
  
  yearRange: "-90:+0",

  showButtonPanel: true });
  });
</script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type="text/javascript">
function sort_function(sort_by,post_date,email,restaurant){
	location.href = 'manage_reviews.php?sort_order='+sort_by+"&post_date="+post_date+"&email="+email+"&restaurant="+restaurant;
}

function get_state_city(state){
	//alert(state);
	$.ajax({
		url : 'get_state_city.php',
		type : 'POST',
		data : 'state=' + state,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];
			document.getElementById('restaurant_city').innerHTML=subCat;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}

function get_restaurant(city){
	//alert(city);
	$.ajax({
		url : 'get_city_restaurant.php',
		type : 'POST',
		data : 'city=' + city,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(1);
		},
		success : function( data, textStatus, jqXHR){
			//alert(data);
			/*var getVal = data.split("^");
			var subCat = getVal[0];
			var subCatid = getVal[1];*/
			document.getElementById('restaurant').innerHTML=data;
		},
		/*complete : function( jqXHR, textStatus){
			alert(3);
		},*/
		error : function( jqXHR, textStatus, errorThrown){
			
		}
	});
}
</script>


<div class="dashboard_section_in">
<form name="frmproduct" action="manage_reviews.php" method="post">
<input type="hidden" name="package_details_id" value="<?php echo $_REQUEST['product_id']?>" />
<input type="hidden" name="action" value="<?php echo $_REQUEST['action']?>" />
<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />
<input type="hidden" name="search_market" value="<?php echo $_REQUEST['search_market']?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Reviews</h2> </td>
               </tr>
               <tr>
                 <td></td>
               </tr>
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>
			   		   <?php if($_REQUEST['msg1']!='')
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle"><?php echo $_REQUEST['msg1'];?></font></td>
					  </tr>
					  <?php
					  }
					  else if($msg1!='')
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle"><?php echo $msg1;?></font></td>
					  </tr>
					  <?php
					  }
					  ?>
             
           
           <tr>
             <td></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               
               <tr>
                 <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td height="34" class="login_labelin">State:</td>
                 <td>
                  <select name="state" id="state" class="login_ipboxin" style="padding:0; height:25px; width:290px;" onchange="get_state_city(this.value);" >
                  <option value="">--SELECT--</option>
                  <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='' ORDER BY restaurant_state");
				  while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
					<option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
                  <?php } ?>
                  
                  
                  <?php $sql_review_state = mysql_query("SELECT DISTINCT state FROM restaurant_reviews WHERE state NOT IN (SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='') AND state!=''");
				  if(mysql_num_rows($sql_review_state)>0){
					  while($array_review_state = mysql_fetch_array($sql_review_state)){ ?>
                      <option  value="<?php echo $array_review_state['state']; ?>" <?php if($array_review_state['state'] == $_REQUEST['state']){?> selected="selected" <?php } ?> ><?php echo $array_review_state['state']; ?></option>
				  <?php }
				  }
				  ?>
				  </select></td>
                  
                 
                  <td height="34" class="login_labelin">Restaurant:</td>
                 <td>
                  <input type="text" name="restaurant_key" id="restaurant_key" value="<?php echo $_REQUEST['restaurant_key']; ?>" class="login_ipboxin" /></td>
                  
                  
                  
                  
                  <td></td>
                 </tr>
                 
                 <tr>
                 
                 <td class="login_labelin">City:</td>
                  <td><select name="restaurant_city" id="restaurant_city" class="login_ipboxin" style="padding:0; height:25px; width:290px;" onchange="get_restaurant(this.value);" >
                  <option value="">--SELECT--</option>
                  <?php /*?><?php $sql_select_city = mysql_query("SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!='' ORDER BY restaurant_city");
				  while($array_select_city = mysql_fetch_array($sql_select_city)){ ?>
					<option value="<?php echo $array_select_city['restaurant_city']; ?>" <?php if($array_select_city['restaurant_city'] == $_REQUEST['city']){?> selected="selected" <?php } ?>><?php echo $array_select_city['restaurant_city']; ?></option>
                  <?php } ?>
                  
                  <?php $sql_review_city = mysql_query("SELECT DISTINCT city FROM restaurant_reviews WHERE city NOT IN (SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!='') AND city!=''");
				  if(mysql_num_rows($sql_review_city)>0){
					  while($array_review_city = mysql_fetch_array($sql_review_city)){ ?>
                      <option  value="<?php echo $array_review_city['city']; ?>" <?php if($array_review_city['city'] == $_REQUEST['city']){?> selected="selected" <?php } ?> ><?php echo $array_review_city['city']; ?></option>
				  <?php }
				  }
				  ?><?php */?>
				  </select>
                  </td>
                  
                 
                  <td height="34" class="login_labelin">Email:</td>
                  <td><input type="text" name="email" id="email" class="login_ipboxin" value="<?php echo $_REQUEST['email'];?>" /></td>
                  
                  <td></td>
                  </tr>
                  
                 <tr>
                 
                 <?php
				  $sql_restaurant=mysql_query("SELECT * FROM restaurant_basic_info WHERE status=1 ORDER BY restaurant_name");
				  ?>
                  <td class="login_labelin">Restaurant:</td>
                  <td><select name="restaurant" id="restaurant" class="login_ipboxin" style="padding:0; height:25px; width:290px;">
                  <option value="">--SELECT--</option>
                  <?php /*?><?php
				  while($res_restaurant=mysql_fetch_array($sql_restaurant)){
					  ?>
                      <option value="<?php echo $res_restaurant['id']?>" <?php if($res_restaurant['id'] == $_REQUEST['restaurant']){?> selected="selected" <?php } ?>><?php echo stripslashes($res_restaurant['restaurant_name'])?></option>
				  <?php }
                  ?><?php */?>
                  </select>
                  <?php /*?><input type="text" name="restaurant" id="restaurant" value="<?php echo $_REQUEST['restaurant']; ?>" class="login_ipboxin" /><?php */?>
                  </td>
                  
                  <td height="39" class="login_labelin">Post Date:</td>
                 <td><input type="text" name="post_date" id="datepicker" class="login_ipboxin" value="<?php echo $_REQUEST['post_date']; ?>" /></td>
                 </tr>
                 <tr>
                   <td height="42" colspan="3" class="login_labelin"><input type="submit" name="search" value="Search" class="login_button" style="margin-right:15px;" /> 
                  <a href="manage_reviews.php"><input type="button" name="show_all" value="Show All" class="login_button" /></a>
                  </td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 </table></td>
               </tr>
               <tr>
                 <td align="center" valign="top" class="login_labelin">
                 <table width="100%" height="99" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;">
                     <td width="8%" height="35" align="center">No</td>
                     <td width="9%" align="center"><a href="javascript:void(0)" onclick="sort_function('post_date','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['restaurant']; ?>')" class="heading_link">Post Date</a>
                     (MM-DD-YYYY)</td>
                     <td width="13%" align="center"><a href="javascript:void(0)" onclick="sort_function('customer_email','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['restaurant']; ?>')" class="heading_link">Customer Email</a></td>
                     <td width="14%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_name','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['restaurant']; ?>')" class="heading_link">Restaurant</a></td>
                     <td width="7%" align="center"><a href="javascript:void(0)" onclick="sort_function('city','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['restaurant']; ?>')" class="heading_link">City</a></td>
                     <td width="7%" align="center"><a href="javascript:void(0)" onclick="sort_function('state','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['restaurant']; ?>')" class="heading_link">State</a></td>
                     <td width="10%" align="center">Review Image</td>
                     <td width="33%" align="center"><a href="javascript:void(0)" onclick="sort_function('customer_review','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['restaurant']; ?>')" class="heading_link">Reviews</a></td>
                     <td width="9%" align="center">Action</td>  
                   </tr>
	  	<?php 
        $email = $_REQUEST['email'];
        $sql_cust = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE email = '".$email."'"));
        
        $query_res="SELECT * FROM restaurant_reviews WHERE 1";
        if($_REQUEST['post_date'])
        {
            $query_res.=" AND post_date='".change_dateformat($_REQUEST['post_date'])."'";
        }
        if($_REQUEST['restaurant'])
        {
            $query_res.=" AND restaurant_name = '".$_REQUEST['restaurant']."'";
        }
		if($_REQUEST['restaurant_key'])
        {
            $query_res.=" AND restaurant_name LIKE '%".$_REQUEST['restaurant_key']."%'";
        }
        if($_REQUEST['email']){
            $query_res.=" AND customer_id=".$sql_cust['id']."";
        }
		if($_REQUEST['restaurant_city'])
        {
            $query_res.=" AND city = '".$_REQUEST['restaurant_city']."'";
        }
		if($_REQUEST['state'])
        {
            $query_res.=" AND state = '".$_REQUEST['state']."'";
        }
        if($_REQUEST['sort_order']){
            $query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
        }else{
			$query_res.=" ORDER BY id DESC";
		}
		
		//echo $query_res; 
        
        $sel_product=mysql_query($query_res);
        
        if(mysql_num_rows($sel_product)<1)
        {
            echo "No Results Found";
        }
        
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
		$max_results =50; 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sel_product); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"manage_reviews.php?page=$prev&post_date=".$_REQUEST['post_date']."&email=".$_REQUEST['email']."&restaurant=".$_REQUEST['restaurant']."&sort_order=".$_REQUEST['sort_order']."&restaurant_city=".$_REQUEST['restaurant_city']."&state=".$_REQUEST['state']."&restaurant_key=".$_REQUEST['restaurant_key']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_reviews.php?page=$i&post_date=".$_REQUEST['post_date']."&email=".$_REQUEST['email']."&restaurant=".$_REQUEST['restaurant']."&sort_order=".$_REQUEST['sort_order']."&restaurant_city=".$_REQUEST['restaurant_city']."&state=".$_REQUEST['state']."&restaurant_key=".$_REQUEST['restaurant_key']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_reviews.php?page=$next&post_date=".$_REQUEST['post_date']."&email=".$_REQUEST['email']."&restaurant=".$_REQUEST['restaurant']."&sort_order=".$_REQUEST['sort_order']."&restaurant_city=".$_REQUEST['restaurant_city']."&state=".$_REQUEST['state']."&restaurant_key=".$_REQUEST['restaurant_key']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
				
					if(mysql_num_rows($query_products)>0)
					{
						$inc=1;
						while($array_products=mysql_fetch_array($query_products))
						{
							if($inc%2==0)
                        	{
					?>
                    <tr bgcolor="#ffffff" height="40">
                    <?
							}
							else
							{
					?>
                    <tr bgcolor="#eeeeee" height="40">
                    <?
							}
							if($_REQUEST['page']!="")
							{
								$j=($_REQUEST['page']-1)*50;
							}
							if($_REQUEST['search']!="")
							{
							$j=0;	
							}
							$sql_customer=mysql_fetch_array(mysql_query("select * from restaurant_customer where id='".$array_products['customer_id']."'"));
							$sql_restaurant=mysql_fetch_array(mysql_query("select * from restaurant_basic_info where id='".$array_products['restaurant_id']."'"));
					?>
					  <td height="30" align="center" valign="middle"><?php echo $a=($j+$inc); ?></td>
                      <td align="center" valign="middle"><?php  echo date("m-d-Y", strtotime($array_products['post_date'])); ?></td>
                       <td align="center" valign="middle"><?php  echo $sql_customer['email']; ?></td>
                        <td align="center" valign="middle"><?php  echo stripslashes($sql_restaurant['restaurant_name']); ?></td>
                        <td align="center" valign="middle"><?php  echo stripslashes($array_products['city']); ?></td>
                        <td align="center" valign="middle"><?php  echo stripslashes($array_products['state']); ?></td>
                        <td align="center" valign="middle"><?php if($array_products['review_picture'] != '') { ?><img src="../thumb_images/<?php echo $array_products['review_picture']; ?>" height="39" width="39" /><?php } ?></td>
                      <td align="center" valign="middle"><?php  echo stripslashes($array_products['customer_review']); ?></td>
                      
           
                     <td align="center" valign="middle">
                    <?php /*?> <?php 
					 if($array_products['status']==0)
					 { echo  "Abused";
                     
					 }
					 ?><?php */?>
                     <?php
					 if($array_products['abuse_status']==1)
					 {
					 if($array_products['status']==0)
					 {
					 ?>
                     <a href="manage_reviews.php?active_id=<?=$array_products['id']?>&page=<?=$_REQUEST['page']?>&action=active">Active</a>
                     <?php } else{?><a href="manage_reviews.php?inactive_id=<?=$array_products['id']?>&page=<?=$_REQUEST['page']?>&action=inactive">Inactive</a><?php }?>&nbsp;&nbsp;
                     <?php
					 }
					 ?><a href="review_reply.php?customer_id=<?php echo $sql_customer['id'];?>&review_id=<?=$array_products['id']?>&page=<?=$_REQUEST['page']?>"><img src="images/1373904457_reply.png" alt="Reply" title="Reply" border="0" /></a>&nbsp;&nbsp;
                     <?php /*?><?php
                      if($array_products['abuse_status']==1)
					 {
						 ?><?php */?>
                     <a href="manage_reviews.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a>
                     <?php /*?><?php
					 }
					 ?><?php */?>
                      </td>
					</tr>
					<?php
						$inc++;}
					}
					?>
                    
             </table></td>
           </tr>
               <tr>
                 <td align="center" valign="top">&nbsp;</td>
               </tr>
               <tr>
                 <td height="20" colspan="10" align="center" valign="middle" bgcolor="#FFF9E3" style="padding:5px 0px 5px 0px; font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#060;"><?=$pagination;?></td>
               </tr>
      </table></td></tr></table>
      </table>
</form>    
</div>

<?php
}
require_once"template_admin.php";
?>