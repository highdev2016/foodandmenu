<?php 
ob_start();
function main()
{
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	mysql_query("DELETE FROM restaurant_admin_panel WHERE id =".$_REQUEST['delete_id']."");
	$msg1="Successfully deleted restaurant admin panel.";
	header("location:manage_restaurant_admin_panel.php?msg1=$msg1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////

?>

<script type="text/javascript">
function sort_function(sort_by,restaurant_state,restaurant_city,restaurant,restaurant_key){
	location.href = 'manage_restaurant_admin_panel.php?sort_order='+sort_by+"&restaurant_state="+restaurant_state+"&restaurant_city="+restaurant_city+"&restaurant="+restaurant+"&restaurant_key="+restaurant_key;
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
<form name="frmproduct" action="" method="post">
<input type="hidden" name="package_details_id" value="<?php echo $_REQUEST['product_id']?>" />
<input type="hidden" name="action" value="<?php echo $_REQUEST['action']?>" />
<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />
<input type="hidden" name="search_market" value="<?php echo $_REQUEST['search_market']?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Restaurant Admin Panel</h2> <span style="float:right" class="login_labelin"><a href="add_restaurant_admin_panel.php" style="color:#7D7E7E; text-decoration:none; font-weight:bold;">Add Restaurant Admin Panel</a></span></td>
               </tr>
               <tr>
                 <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td width="18%" height="38" class="login_labelin">State :</td>
                  <td width="27%">
                  <select name="restaurant_state" id="restaurant_state" class="login_ipboxin" style="padding:0; height:25px; width:200px;" onchange="get_state_city(this.value);">
                  <option value="">--SELECT--</option>
                  <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='' ORDER BY restaurant_state");
				  while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
					<option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['restaurant_state']){?> selected="selected" <?php } ?> ><?php echo $array_select_state['restaurant_state']; ?></option>
                  <?php } ?>
                  </select>
                  </td>
                 
                  <td width="16%" class="login_labelin">City :</td>
                  <td width="39%">
                  <select name="restaurant_city" id="restaurant_city" class="login_ipboxin" style="padding:0; height:25px; width:200px;" onchange="get_restaurant(this.value);">
                  <option value="">--SELECT--</option>
                  <?php /*?><?php $sql_select_city = mysql_query("SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!='' ORDER BY restaurant_city");
				  while($array_select_city = mysql_fetch_array($sql_select_city)){ ?>
					<option value="<?php echo $array_select_city['restaurant_city']; ?>" <?php if($array_select_city['restaurant_city'] == $_REQUEST['restaurant_city']){?> selected="selected" <?php } ?> ><?php echo $array_select_city['restaurant_city']; ?></option>
                  <?php } ?><?php */?>
                  </select>
                  </td>
                 </tr>
                 
                 <tr>
                 <td width="18%" height="36" class="login_labelin">Restaurant Name :</td>
                  <td width="27%">
                  <?php /*?><input type="text" name="restaurant" id="restaurant" value="" class="login_ipboxin" /><?php */?>
                  <select name="restaurant" id="restaurant" class="login_ipboxin" style="padding:0; height:25px; width:200px;">
                 <option value="">--SELECT--</option>
                  <?php /*?> <?php
				  $sql_restaurant = mysql_query("SELECT * FROM restaurant_basic_info WHERE status = 1 ORDER BY restaurant_name ASC ");
				  while($res_restaurant=mysql_fetch_array($sql_restaurant)){
					  ?>
                      <option value="<?php echo $res_restaurant['id']?>" <?php if($_REQUEST['restaurant'] == $res_restaurant['id']) {?> selected="selected" <?php } ?>><?php echo stripslashes($res_restaurant['restaurant_name'])?></option>
				  <?php }
                  ?><?php */?>
                  </select>
                  </td>
                  
                 <td width="16%" height="36" class="login_labelin">Restaurant Name :</td>
                  <td width="39%">
                  <input type="text" name="restaurant_key" id="restaurant_key" value="" class="login_ipboxin" style="width:190px;" />
                  </td>
                 </tr>
                 
                   <tr>
                   <td height="40" colspan="2" class="login_labelin"><input type="submit" name="search" value="Search" class="login_button" style="margin-right:10px;">
                  <a href="manage_restaurant_admin_panel.php"><input type="button" name="show_all" value="Show All" class="login_button"></a>
                  </td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 
                 </table></td>
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
                 <td>&nbsp;</td>
               </tr>
               <tr>
                 <td align="center" valign="top" class="login_labelin">
                 <table width="100%" height="99" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;">
                     <td width="2%" height="35" align="center">No</td>
                     <td width="9%" align="center"><a href="javascript:void(0)" onclick="sort_function('ra.firstname','<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['restaurant_key']; ?>')" class="heading_link">First Name</a></td>
                     <td width="9%" align="center"><a href="javascript:void(0)" onclick="sort_function('ra.lastname','<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['restaurant_key']; ?>')" class="heading_link">Last Name</a></td>
                     <td width="12%" align="center"><a href="javascript:void(0)" onclick="sort_function('ra.security_code','<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['restaurant_key']; ?>')" class="heading_link">Security Code</a></td>
                     <td width="17%" align="center"><a href="javascript:void(0)" onclick="sort_function('rbi.restaurant_name','<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['restaurant_key']; ?>')" class="heading_link">Restaurant Name</a></td>
                     <td width="11%" align="center"><a href="javascript:void(0)" onclick="sort_function('ra.state','<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['restaurant_key']; ?>')" class="heading_link">State</a></td>
                     <td width="13%" align="center"><a href="javascript:void(0)" onclick="sort_function('ra.city','<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['restaurant_key']; ?>')" class="heading_link">City</a></td>
                     <td width="14%" align="center"><a href="javascript:void(0)" onclick="sort_function('ra.email_id','<?php echo $_REQUEST['restaurant_state']; ?>','<?php echo $_REQUEST['restaurant_city']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['restaurant_key']; ?>')" class="heading_link">Email</a></td>
                     <td width="13%" align="center">Action</td>  
                   </tr>
                   
                  <?php 
				    $query_res=" SELECT ra.id, ra.state, ra.city,ra.firstname,ra.lastname,ra.security_code,ra.email_id,ra.restaurant_id,rbi.restaurant_name  FROM restaurant_admin_panel ra INNER JOIN restaurant_basic_info rbi ON ra.restaurant_id = rbi.id WHERE ra.id!='' ";
					
					if($_REQUEST['restaurant_state']!=''){
						$query_res.=" AND ra.state = '".$_REQUEST['restaurant_state']."' ";
					}
					if($_REQUEST['restaurant_city']!=''){
						$query_res.=" AND ra.city = '".$_REQUEST['restaurant_city']."' ";
					}
					if($_REQUEST['restaurant']!=''){
						$query_res.=" AND rbi.restaurant_name = '".$_REQUEST['restaurant']."' ";
					}
					if($_REQUEST['restaurant_key']!=''){
						$query_res.=" AND rbi.restaurant_name LIKE '%".$_REQUEST['restaurant_key']."%' ";
					}
					
					if($_REQUEST['sort_order']){
						$query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
					}else{
						$query_res.=" ORDER BY ra.id desc";
					}
					//echo $query_res."<br>";
					
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
		$max_results =10; 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sel_product); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"manage_restaurant_admin_panel.php?page=$prev&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."&restaurant=".$_REQUEST['restaurant']."&restaurant_key=".$_REQUEST['restaurant_key']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_restaurant_admin_panel.php?page=$i&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."&restaurant=".$_REQUEST['restaurant']."&restaurant_key=".$_REQUEST['restaurant_key']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_restaurant_admin.php?page=$next&restaurant_state=".$_REQUEST['restaurant_state']."&restaurant_city=".$_REQUEST['restaurant_city']."&restaurant=".$_REQUEST['restaurant']."&restaurant_key=".$_REQUEST['restaurant_key']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
								$j=($_REQUEST['page']-1)*10;
							}
							if($_REQUEST['search']!="")
							{
							$j=0;	
							}
					?>
					  <td height="30" align="center" valign="middle"><?php echo $a=($j+$inc); ?></td>
                      <td align="center" valign="middle"><?php echo $array_products['firstname']; ?></td>
                      <td align="center" valign="middle"><?php echo $array_products['lastname']; ?></td>
                      <td align="center" valign="middle"><?php echo $array_products['security_code']; ?></td>
                      <td align="center" valign="middle"><?php $sql_restaurant_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$array_products['restaurant_id']."'"));
					  echo stripslashes($sql_restaurant_name['restaurant_name']);
					   ?></td>
                    <td align="center" valign="middle"><?php  echo $array_products['state']; ?></td>
                    <td align="center" valign="middle"><?php  echo $array_products['city']; ?></td>
                    <td align="center" valign="middle"><?php  echo $array_products['email_id']; ?></td>
                     <td align="center" valign="middle"><a href="edit_restaurant_admin_panel.php?id=<?php echo $array_products['id'];?>">EDIT</a> &nbsp;&nbsp;<a href="manage_restaurant_admin_panel.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><!--<img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" />-->
                     DELETE</a>
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