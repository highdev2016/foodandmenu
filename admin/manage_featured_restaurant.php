<?php 
ob_start();
function main()
{
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['submit']!="")
{
	if(count($_REQUEST['restaurant'])==0)
	{
		mysql_query("update restaurant_basic_info set featured_status=0");
	}
	else
	{
		//mysql_query("update restaurant_basic_info set featured_status=0");
		$sep="";
		foreach($_REQUEST['restaurant'] as $restaurants)
		{
			 $featured_city.=$sep.$restaurants;
			$sep=",";
			
		}
		mysql_query("update restaurant_basic_info set featured_status=0 where id IN (".$_REQUEST['all_restaurant_id'].")");
		mysql_query("update restaurant_basic_info set featured_status=1 where id IN (".$featured_city.")");
		
	}
	
	header("location:manage_featured_restaurant.php?page=".$_REQUEST['page']."");
}
?>

<script type="text/javascript">
function sort_function(sort_by,restaurant_id){
	location.href = "manage_featured_restaurant.php?sort_order="+sort_by+"&restaurant_id="+restaurant_id;
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

</script>


<div class="dashboard_section_in">
<form name="frmproduct" action="" method="post">

<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Featured Restaurant</h2> </td>
               </tr>
               <tr>
                 <td></td>
               </tr>
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>
			   		   <?php if($_REQUEST['success']==1)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Banner added successfully</font></td>
					  </tr>
					  <?php
					  }
					  else if($_REQUEST['success']==2)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Successfully deleted banner</font></td>
					  </tr>
					  <?php
					  }
                       else if($_REQUEST['success']==3)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Successfully updated banner</font></td>
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
                 
                  <td class="login_labelin">State:</td>
                  <td>
                  <select name="restaurant_state" id="restaurant_state" class="login_ipboxin" style="width:210px; height:27px; padding:0px;" onchange="get_state_city(this.value);" >
                  	<option value="">Select</option>
                    <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!=''");
				  while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
					<option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['restaurant_state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
                  <?php } ?>
                  </select>
                  
                  <?php /*?><input type="text" name="restaurant_state" id="restaurant_state" value="<?php echo $_REQUEST['restaurant_state']; ?>" class="login_ipboxin" style="width:200px;" /><?php */?>
                  </td> 
                  
                  <td height="45" class="login_labelin">City:</td>
                  <td>
                  <select name="restaurant_city" id="restaurant_city" class="login_ipboxin" style="width:210px; height:27px; padding:0px;">
                  	<option value="">Select</option>
                  </select>
                  
                  <?php /*?><input type="text" name="restaurant_city" id="restaurant_city" value="<?php echo $_REQUEST['restaurant_city']; ?>" class="login_ipboxin" style="width:200px;" /><?php */?>
                  </td>
                  
                  <td class="login_labelin">Zipcode:</td>
                  <td>
                  <select name="restaurant_zipcode" id="restaurant_zipcode" class="login_ipboxin" style="width:210px; height:27px; padding:0px;">
                  	<option value="">Select</option>
                    <?php $sql_select_zipcode = mysql_query("SELECT DISTINCT(restaurant_zipcode) FROM restaurant_basic_info WHERE restaurant_zipcode!=''");
				  while($array_select_zipcode = mysql_fetch_array($sql_select_zipcode)){ ?>
					<option value="<?php echo $array_select_zipcode['restaurant_zipcode']; ?>" <?php if($array_select_zipcode['restaurant_zipcode'] == $_REQUEST['restaurant_zipcode']){?> selected="selected" <?php } ?>><?php echo $array_select_zipcode['restaurant_zipcode']; ?></option>
                  <?php } ?>
                  </select>
                  
                  
                  
                  <?php /*?><input type="text" name="restaurant_zipcode" id="restaurant_zipcode" value="<?php echo $_REQUEST['restaurant_zipcode']; ?>" class="login_ipboxin" style="width:200px;" /><?php */?>
                  </td>
                 </tr>
                 <tr>
                   
                  <td height="34" class="login_labelin">Restaurant:</td>
                  <td><?php /*?><?php
				  $sql_restaurant=mysql_query("SELECT * FROM restaurant_basic_info WHERE status=1 ORDER BY restaurant_name");
				  ?><select name="restaurant_id" id="restaurant" class="login_ipboxin" style="padding:0; height:25px;">
                  <option value="">------SELECT------</option>
                  <?php
				  while($res_restaurant=mysql_fetch_array($sql_restaurant)){
					  ?>
                      <option value="<?php echo $res_restaurant['id']?>"><?php echo stripslashes($res_restaurant['restaurant_name'])?></option>
				  <?php }
                  ?></select><?php */?>
                  <input type="text" name="restaurant_id" id="restaurant" value="<?php echo $_REQUEST['restaurant_id']; ?>" class="login_ipboxin" style="width:200px;" />
                  </td>
                  
                    <td colspan="4">
                    <input type="submit" name="search" value="Search" class="login_button" style="margin-right:15px;">
                    <a href="manage_featured_restaurant.php"><input type="button" name="show_all" value="Show All" class="login_button"></a>
                    </td>
                 </tr>
                   <tr>
                   <td class="login_labelin">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 
                 </tr>
                 </table></td>
               </tr>
               <tr>
                 <td align="center" valign="top" class="login_labelin">
                 <table width="100%" height="99" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;">
                     <td width="7%" height="35" align="center">No</td>
                     <td width="19%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_name','<?php echo $_REQUEST['restaurant_id']; ?>')" class="heading_link">Restaurant</a></td>
                     <td width="15%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_city','<?php echo $_REQUEST['restaurant_id']; ?>')" class="heading_link">City</a></td>
                     <td width="12%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_state','<?php echo $_REQUEST['restaurant_id']; ?>')" class="heading_link">State</a></td>
                     <td width="12%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_zipcode','<?php echo $_REQUEST['restaurant_id']; ?>')" class="heading_link">Zipcode</a></td>
                     <td width="14%" align="center">Status</td>
                     <td width="21%" align="center"><a href="javascript:void(0)" onclick="sort_function('show_order','<?php echo $_REQUEST['restaurant_id']; ?>')" class="heading_link">Show Order</a></td>                  
                   </tr>
                   <?php
				   $sql_feature_city=mysql_query("SELECT * FROM restaurant_featured_city where status=1");
				   $city_sep="";
				   $feature_city="";
				   while($res_feature_city=mysql_fetch_array($sql_feature_city))
				   {
					 $feature_city.=$city_sep."'".$res_feature_city['featured_city']."'";  
					 $city_sep=",";
				   }
				   //echo $feature_city;
				   ?>
                   
                  <?php
					$limit = 100;
					$start = 1;
					$slice = 2;
					
					$query_res="SELECT * FROM restaurant_basic_info where status=1";
					if($_REQUEST['restaurant_id']!="")
					{
					 $query_res.=" AND restaurant_name LIKE '".$_REQUEST['restaurant_id']."%'";	
					}
					if($_REQUEST['restaurant_city']!="")
					{
					 $query_res.=" AND restaurant_city = '".$_REQUEST['restaurant_city']."'";	
					}
					if($_REQUEST['restaurant_state']!="")
					{
					 $query_res.=" AND restaurant_state = '".$_REQUEST['restaurant_state']."'";	
					}
					if($_REQUEST['restaurant_zipcode']!="")
					{
					 $query_res.=" AND restaurant_zipcode = '".$_REQUEST['restaurant_zipcode']."'";	
					}
					
				    //$query_res.=" AND restaurant_city IN (".$feature_city.")";
					
					if($_REQUEST['sort_order']){
						$query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
					}
					else{
						$query_res.= " ORDER BY show_order";
					}
					
					$r = mysql_query($query_res);
					$totalrows = mysql_num_rows($r);
					
					
					 /*if($_REQUEST['search']!="")
					{
						$page=1;
					}*/
					
					if(!isset($_GET['page']) || ($_REQUEST['search']!="")){
					$page = 1;
					} else {
					$page = $_GET['page'];
					}
					
					$numofpages = ceil($totalrows / $limit);
					
					if($page!=''){
						$limitvalue = $page * $limit - ($limit);
					}else{
						$limitvalue = 0;
					}
					
					
					$query_res="SELECT * FROM restaurant_basic_info where status=1";
					if($_REQUEST['restaurant_id']!="")
					{
					 $query_res.=" AND restaurant_name LIKE '".$_REQUEST['restaurant_id']."%'";	
					}
					if($_REQUEST['restaurant_city']!="")
					{
					 $query_res.=" AND restaurant_city = '".$_REQUEST['restaurant_city']."'";	
					}
					if($_REQUEST['restaurant_state']!="")
					{
					 $query_res.=" AND restaurant_state = '".$_REQUEST['restaurant_state']."'";	
					}
					if($_REQUEST['restaurant_zipcode']!="")
					{
					 $query_res.=" AND restaurant_zipcode = '".$_REQUEST['restaurant_zipcode']."'";	
					}
				    //$query_res.=" AND restaurant_city IN (".$feature_city.")";
					
					if($_REQUEST['sort_order']){
						$query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
					}
					else{
						$query_res.= " ORDER BY show_order";
					}
					
					$query_res.=" LIMIT $limitvalue, $limit";
					
					//echo $query_res;
					
					$sel_product=mysql_query($query_res);
					
					$query_products=mysql_query($query_res);
				 
					
					$min_order_id=mysql_fetch_array(mysql_query("SELECT MIN(show_order) as min_id FROM restaurant_basic_info where status=1 AND restaurant_city IN (".$feature_city.")"));
                    $max_order_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_basic_info where status=1 AND restaurant_city IN (".$feature_city.")"));
					
					$sel_product=mysql_query($query_res);
					
					if(mysql_num_rows($sel_product)<1)
					{
						echo "No Results Found";
					}
					
					/*//////////////////////start pagination/////////////////////////
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
		$pagination .= "<a href=\"manage_featured_restaurant.php?page=$prev&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_featured_restaurant.php?page=$i&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_featured_restaurant.php?page=$next&sort_order=".$_REQUEST['sort_order']."&restaurant_id=".$_REQUEST['restaurant_id']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////*/
				
					if(mysql_num_rows($query_products)>0)
					{
						
						$inc=1;
						$sep_id="";
						while($array_products=mysql_fetch_array($query_products))
						{
							$featured_all_city.=$sep_id.$array_products['id'];
			                $sep_id=",";
							$sql_city=mysql_fetch_array(mysql_query("SELECT id,featured_status from  restaurant_basic_info where id='".$array_products['id']."'"));
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
					?>
                  
					  <td height="30" align="center" valign="middle"><?php echo $a=($j+$inc); ?></td>
                      <td align="center" valign="middle" style="text-align:center;"><?php  echo stripslashes($array_products['restaurant_name']); ?></td>
                      <td align="center" valign="middle" style="text-align:center;"><?php  echo stripslashes($array_products['restaurant_city']); ?></td>
                      <td align="center" valign="middle" style="text-align:center;"><?php  echo stripslashes($array_products['restaurant_state']); ?></td>
                      <td align="center" valign="middle" style="text-align:center;"><?php  echo stripslashes($array_products['restaurant_zipcode']); ?></td>
                      <td align="center" valign="middle"> <input type="checkbox" name="restaurant[]" value="<?php  echo $array_products['id']; ?>" <?php if($sql_city['featured_status']==1){?> checked="checked"<?php } ?> /></td> 
                       <td align="center" valign="middle"><?php if($min_order_id['min_id']!=$array_products['show_order']){?><a href="order_change_up_res.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?><?php if($_REQUEST['page']!=''){?>&page=<?php echo $_REQUEST['page']; ?><?php } ?>"><img src="images/up2.gif" border="0"/></a><?php } ?>&nbsp;&nbsp;<?php if($max_order_id['max_id']!=$array_products['show_order']){?><a href="order_change_down_res.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?><?php if($_REQUEST['page']!=''){?>&page=<?php echo $_REQUEST['page']; ?><?php } ?>"><img src="images/drop2.gif" border="0"/></a><?php } ?><?php if($min_order_id['min_id']!=$array_products['show_order']){?>&nbsp;&nbsp;<a href="order_change_top_res.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?><?php if($_REQUEST['page']!=''){?>&page=<?php echo $_REQUEST['page']; ?><?php } ?>"><img src="images/old-go-top.png" width="14" height="11" title="Go To Top" /></a><?php } ?><?php if($max_order_id['max_id']!=$array_products['show_order']) { ?>&nbsp;&nbsp;<a href="order_change_bottom_res.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?><?php if($_REQUEST['page']!=''){?>&page=<?php echo $_REQUEST['page']; ?><?php } ?>"><img src="images/old-go-bottom.png" width="14" height="11" title="Go To Bottom" /></a><?php } ?>
                       </td>
                     
					</tr>
					<?php
						$inc++;}
					}
					?>
                    
             </table></td>
           </tr>
               <tr>
                 <td align="right" valign="top"><input type="hidden" id="all_restaurant_id" name="all_restaurant_id" value="<?php echo $featured_all_city?>" /><input type="submit" name="submit" value="Submit" class="normalbutton" /></td>
               </tr>
               <tr>
                 <td height="20" colspan="10" align="center" valign="middle" bgcolor="#FFF9E3" style="padding:5px 0px 5px 0px; font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#060;">
				 <?php 
				 if($page!= 1){
					$pageprev = $page - 1;
					echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$pageprev.'&sort_order='.$_REQUEST['sort_order'].'&restaurant_id='.$_REQUEST['restaurant_id'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&restaurant_zipcode='.$_REQUEST['restaurant_zipcode'].'"class="more_link_pagination_prev">PREVIOUS</a>  ';
					}
					
					if (($page + $slice) < $numofpages) {
					$this_far = $page + $slice;
					} else {
					$this_far = $numofpages;
					}
					
					if (($start + $page) >= 10 && ($page - 10) > 0) {
					$start = $page - 10;
					}
					
					for ($i = $start; $i <= $this_far; $i++){
					if($i == $page){
					echo $i;
					}else{
					echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$i.'&sort_order='.$_REQUEST['sort_order'].'&restaurant_id='.$_REQUEST['restaurant_id'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&restaurant_zipcode='.$_REQUEST['restaurant_zipcode'].'" class="more_link_pagination">'.$i.'</a> ';
					}
					}
					
					if(($totalrows - ($limit * $page)) > 0){
					$pagenext = $page + 1;
					echo '  <a href="'.$_SERVER['PHP_SELF'].'?page='.$pagenext.'&sort_order='.$_REQUEST['sort_order'].'&restaurant_id='.$_REQUEST['restaurant_id'].'&restaurant_city='.$_REQUEST['restaurant_city'].'&restaurant_state='.$_REQUEST['restaurant_state'].'&restaurant_zipcode='.$_REQUEST['restaurant_zipcode'].'" class="more_link_pagination_prev">NEXT</a>';
					}
					?>
                 
                 </td>
               </tr>
      </table></td></tr></table>
      </table>
</form>    
</div>

<?php
}
require_once"template_admin.php";
?>