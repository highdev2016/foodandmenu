<?php 
ob_start();
function main()
{
if($_REQUEST['submit']!="")
{
	if(count($_REQUEST['check'])==0)
	{
		mysql_query("update restaurant_deals set deals_status=0");
	}
	else
	{
		//mysql_query("update restaurant_basic_info set featured_status=0");
		$sep="";
		foreach($_REQUEST['check'] as $restaurants)
		{
			 $hot_deals.=$sep.$restaurants;
			 $sep=",";
			
		}
		mysql_query("update restaurant_deals set deals_status=0 where id IN (".$_REQUEST['hot_deal_id'].")")."<br>";
		mysql_query("update restaurant_deals set deals_status=1 where id IN (".$hot_deals.")");
		
	}
	
	header("location:manage_hot_deals.php?success=1");
}


///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	mysql_query("DELETE FROM restaurant_deals WHERE id=".$_REQUEST['delete_id']."");
	$msg1="Successfully deleted deals.";
	header("location:manage_hot_deals.php?success=2&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////

?>

<script type="text/javascript">
function sort_function(sort_by){
	location.href = 'manage_hot_deals.php?sort_order='+sort_by;
}
</script>

<div class="dashboard_section_in">
<form name="frmproduct" action="#" method="post">
<input type="hidden" name="package_details_id" value="<?php echo $_REQUEST['product_id']?>" />
<input type="hidden" name="action" value="<?php echo $_REQUEST['action']?>" />
<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />
<input type="hidden" name="search_market" value="<?php echo $_REQUEST['search_market']?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td height="92"><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Hot Deals</h2> <span style="float:right" class="login_labelin"></span></td>
               </tr>
               <tr>
                 <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td width="20%" class="login_labelin">Restaurant:</td>
                  <td width="37%"><?php /*?><select name="restaurant" id="restaurant" class="login_ipboxin" style="padding:0; height:25px;">
                  <option value="">------SELECT------</option>
                  <?php
				  while($res_restaurant=mysql_fetch_array($sql_restaurant)){
					  ?>
                      <option value="<?php echo $res_restaurant['id']?>" <?php if($_REQUEST['restaurant'] == $res_restaurant['id']) {?> selected="selected" <?php } ?>><?php echo stripslashes($res_restaurant['restaurant_name'])?></option>
				  <?php }
                  ?></select><?php */?>
                  <input type="text" name="restaurant" id="restaurant" value="<?php echo $_REQUEST['restaurant'];?>" class="login_ipboxin"  />
                  </td>
                 
                  <td width="36%" class="login_labelin"><input type="submit" name="search" value="Search" class="login_button"></td>
                  <td width="3%"></td>
                    <td width="4%"></td>
                 </tr>
                   <tr>
                   <td class="login_labelin">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                 </tr>
                 </table></td>
               </tr>
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>
			   		   <?php if($_REQUEST['success']==1)
					  { ?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Status updated successfully</font></td>
					  </tr>
					  <?php } ?>
                      <?php if($_REQUEST['success']==2)
					  { ?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Deal deleted successfully</font></td>
					  </tr>
					  <?php } ?>
             
           
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
                     <td width="5%" height="35" align="center">No</td>
                     <td width="18%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_name')" class="heading_link">Restaurant</a></td>
                     <td width="18%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_city')" class="heading_link">City</a></td>
                     <td width="18%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_state')" class="heading_link">State</a></td>
                     <td width="19%" align="center"><a href="javascript:void(0)" onclick="sort_function('daily_name')" class="heading_link">Hot Deals</a></td>
                     <td width="11%" align="center">Status</td>
                     <td width="11%" align="center">Action</td>
                   </tr>
                  <?php 
				    $query_res="SELECT rd.id,rd.restaurant_name,rd.daily_name,rb.restaurant_city,rb.restaurant_state,rd.deals_status FROM restaurant_deals AS rd LEFT JOIN restaurant_basic_info AS rb ON (rd.restaurant_id = rb.id) WHERE rb.status = 1";
					
					if($_REQUEST['restaurant']!=''){
						$query_res.="  AND rd.restaurant_name LIKE '".$_REQUEST['restaurant']."%'";
					}
					
					if($_REQUEST['sort_order'] == 'restaurant_name')
					{
						$query_res.=" ORDER BY rd.restaurant_name";
					}
					if($_REQUEST['sort_order'] == 'daily_name')
					{
						$query_res.=" ORDER BY rd.daily_name";
					}
					if($_REQUEST['sort_order'] == 'restaurant_city')
					{
						$query_res.=" ORDER BY rb.restaurant_city";
					}
					if($_REQUEST['sort_order'] == 'restaurant_state')
					{
						$query_res.=" ORDER BY rb.restaurant_state";
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
		$pagination .= "<a href=\"manage_hot_deals.php?page=$prev&restaurant=".$_REQUEST['restaurant']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_hot_deals.php?page=$i&restaurant=".$_REQUEST['restaurant']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_hot_deals.php?page=$next&restaurant=".$_REQUEST['restaurant']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
				
					if(mysql_num_rows($query_products)>0)
					{
						$inc=1;
						$sep_id="";
						while($array_products=mysql_fetch_array($query_products))
						{
							$hot_deals.=$sep_id.$array_products['id'];
			                $sep_id=",";
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
                      <td align="center" valign="middle"><?php  echo stripslashes($array_products['restaurant_name']); ?></td> 
                      <td align="center" valign="middle"><?php  echo stripslashes($array_products['restaurant_city']); ?></td> 
                      <td align="center" valign="middle"><?php  echo stripslashes($array_products['restaurant_state']); ?></td> 
                      <td align="center" valign="middle"><?php  echo stripslashes($array_products['daily_name']); ?></td>
                      <td align="center" valign="middle"><input type="checkbox" name="check[]" value="<?php  echo $array_products['id']; ?>" <?php if($array_products['deals_status'] == 1){ ?> checked="checked" <?php } ?> /></td>
           			  <td align="center" valign="middle"><a href="manage_hot_deals.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a></td>
					</tr>
					<?php
						$inc++;}
					}
					?>
                    
             </table></td>
           </tr>
           <tr>
                 <td align="right" valign="top"><input type="hidden" id="hot_deal_id" name="hot_deal_id" value="<?php echo $hot_deals; ?>" /><input type="submit" name="submit" value="Submit" class="normalbutton" /></td>
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