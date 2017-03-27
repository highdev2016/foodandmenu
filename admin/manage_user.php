<?php 
ob_start();
function main()
{
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	$get_restaurant_id=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE user_id='".$_REQUEST['delete_id']."'"));
	
	mysql_query("DELETE FROM restaurant_users WHERE id=".$_REQUEST['delete_id']."");
	mysql_query("DELETE FROM restaurant_basic_info WHERE id=".$get_restaurant_id."");
	mysql_query("DELETE FROM restaurant_business_delivery_takeout_info WHERE restaurant_id=".$get_restaurant_id."");
	mysql_query("DELETE FROM restaurant_services_dress_payment WHERE restaurant_id=".$get_restaurant_id."");
	mysql_query("DELETE FROM restaurant_menu_item WHERE restaurant_id=".$get_restaurant_id."");
	mysql_query("DELETE FROM restaurant_photo WHERE restaurant_id=".$get_restaurant_id."");
	mysql_query("DELETE FROM restaurant_video WHERE restaurant_id=".$get_restaurant_id."");
	mysql_query("DELETE FROM restaurant_coupon WHERE restaurant_id=".$get_restaurant_id."");
	mysql_query("DELETE FROM restaurant_deals WHERE restaurant_id=".$get_restaurant_id."");
	$msg1="Successfully deleted user.";
	header("location:manage_user.php?msg1=$msg1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////

?>


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
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Restaurant User</h2> <span style="float:right" class="login_labelin"><a href="add_user.php" style="color:#7D7E7E; text-decoration:none; font-weight:bold;">Add New Restaurant</a></span></td>
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
                 <td class="login_labelin">Name:</td>
                  <td><input type="text" name="name" id="name"  class="login_ipboxin" value="<?php echo $_REQUEST['name'] ?>"></td>
                  <td class="login_labelin">Email:</td>
                  <td><input type="text" name="email" id="email" class="login_ipboxin" value="<?php echo $_REQUEST['email'] ?>"/></td>
                    <td><input type="submit" name="search" value="Search" class="login_button"></td>
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
                 <td align="center" valign="top" class="login_labelin">
                 <table width="100%" height="99" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;">
                     <td width="9%" height="35" align="center">No</td>
                     <td width="18%" align="center">Name</td>
                     <td width="18%" align="center">Email</td>
                     <td width="16%" align="center">Creation Date 
                     (MM-DD-YYYY)</td>
                     <td width="20%" align="center">Status</td>
                     <td width="19%" align="center">Action</td>
                   </tr>
                  <?php
				  	$status_arr = array(1=>'Active',0=>'Inactive');
				    $query_res="select * from restaurant_users where user_type IN ('restaurant','user')";					
					if($_REQUEST['name']!="")
					{
					$query_res.=" AND user_nicename LIKE '".$_REQUEST['name']."%'";	
					}
					if($_REQUEST['email']!="")
					{
					$query_res.=" AND user_email=".$_REQUEST['email']."";	
					}
					 $query_res.=" order by ID";
					
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
		$pagination .= "<a href=\"manage_user.php?page=$prev\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_user.php?page=$i\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_user.php?page=$next\" class=\"more_link_pagination_prev\">Next</a>"; 
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
					  <td height="30" align="center" valign="middle"><?php echo $inc; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['user_nicename']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['user_email']; ?></td> 
                      <td align="center" valign="middle"><?php  echo date('m-d-Y',strtotime($array_products['user_registered'])); ?></td>
                      <td align="center" valign="middle"><?php  echo $status_arr[$array_products['user_status']]; ?></td> 
                      <td align="center" valign="middle"><a href="edit_user.php?action=edit&id=<?php echo $array_products['ID'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure, you want to edit ?');"><img src="images/1304761512_pen.png" alt="Edit" title="Edit" border="0" /></a>&nbsp;&nbsp;<a href="manage_user.php?delete=del&delete_id=<?php echo $array_products['ID'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a></td> 
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