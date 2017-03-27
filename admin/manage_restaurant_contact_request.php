<?php 
ob_start();
function main()
{
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	
	$sql_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_owner WHERE id = '".$_REQUEST['delete_id']."'"));
	$sql_select_user = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE user_email = '".$sql_owner['email']."'"));
	$sql_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$sql_select_user['ID']."'"));
	
	mysql_query("DELETE FROM restaurant_owner WHERE id='".$_REQUEST['delete_id']."'");
	mysql_query("DELETE FROM restaurant_users WHERE user_email='".$sql_owner['email']."'");
	mysql_query("DELETE FROM restaurant_basic_info WHERE user_id='".$sql_select_user['ID']."'");
	mysql_query("DELETE FROM restaurant_business_delivery_takeout_info WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_coupon WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_deals WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_disclaimer WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_extra_business_hours WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_gift_card WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_menu_item WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_photo WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_rating WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_reviews WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_services_dress_payment WHERE restaurant_id='".$sql_basic_info['id']."'");
	mysql_query("DELETE FROM  restaurant_video WHERE restaurant_id='".$sql_basic_info['id']."'");
	
	header("location:manage_restaurant_contact_request.php?success=3&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////
?>

<div class="dashboard_section_in">
<form name="frmproduct" action="manage_restaurant_contact_request.php" method="post">
<input type="hidden" name="package_details_id" value="<?php echo $_REQUEST['product_id']?>" />
<input type="hidden" name="action" value="<?php echo $_REQUEST['action']?>" />
<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />
<input type="hidden" name="search_market" value="<?php echo $_REQUEST['search_market']?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Contact Request</h2></td>
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
                      
                      <?php if($_REQUEST['success'] ==3){ ?>
                      <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Contact request deleted successfully</font></td>
					  </tr>
                      <?php } ?>
             
           
           <tr>
             <td></td>
           </tr>
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               
               <tr>
                 <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td class="login_labelin">Email:</td>
                  <td><input type="text" name="email" id="email" / class="login_ipboxin" value="<?php echo $_REQUEST['email'];?>"></td>
                  <?php
				  $sql_restaurant=mysql_query("SELECT * FROM restaurant_basic_info WHERE status=1 ORDER BY restaurant_name");
				  ?>
                  <td class="login_labelin">Restaurant:</td>
                  <td><?php /*?><select name="restaurant" id="restaurant" class="login_ipboxin" style="padding:0; height:25px;">
                  <option value="">------SELECT------</option>
                  <?php
				  while($res_restaurant=mysql_fetch_array($sql_restaurant)){
					  ?>
                      <option value="<?php echo $res_restaurant['restaurant_name']?>" <?php if($_REQUEST['restaurant'] == $res_restaurant['restaurant_name']) {?> selected="selected" <?php } ?>><?php echo stripslashes($res_restaurant['restaurant_name'])?></option>
				  <?php }
                  ?></select><?php */?>
                  <input type="text" name="restaurant" class="login_ipboxin" value="<?php echo $_REQUEST['restaurant']; ?>"/>
                  </td>
                    <td></td>
                 </tr>
                 <tr>
                 <td height="46" class="login_labelin">Status:</td>
                  <td><select class="login_ipboxin" id="contact_status" name="contact_status" style="height:28px; width:287px;">
                  <option value="">Select</option>
        <option value="1" <?php echo ($_REQUEST['contact_status']=='1') ? 'selected="selected"' : '';  ?>>Pending</option>
        <option value="2" <?php echo ($_REQUEST['contact_status']=='2') ? 'selected="selected"' : '';  ?>>Approved but login details not sent</option>
        <option value="3" <?php echo ($_REQUEST['contact_status']=='3') ? 'selected="selected"' : '';  ?>>Denied</option>
        <option value="4" <?php echo ($_REQUEST['contact_status']=='4') ? 'selected="selected"' : '';  ?>>Approved and sent login details</option>
     </select></td>
                  
                  <td class="login_labelin"><input type="submit" name="search" value="Search" class="login_button"></td>
                  <td></td>
                    <td></td>
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
                     <td width="5%" height="35" align="center">No</td>
                     <td width="8%" align="center">Name</td>
                     <td width="14%" align="center">Email</td>
                     <td width="8%" align="center">Phone</td>
                     <td width="14%" align="center">Restaurant Name</td>
                     <td width="14%" align="center">Message</td>
                     <td width="14%" align="center">Subject</td>
                     <td width="11%" align="center">Status</td>
                     <td width="12%" align="center">Action</td>  
                   </tr>
                  <?php 
				    $query_res="select * from restaurant_owner where 1";
					if($_REQUEST['email']!=''){
						
						$query_res.=" AND email = '".$_REQUEST['email']."'";
						
					}
					if($_REQUEST['restaurant']!=''){
						
						$query_res.="  AND restaurant LIKE '".$_REQUEST['restaurant']."%'";
						
					}
					if($_REQUEST['contact_status']!=''){
						
						$query_res.="  AND status = '".$_REQUEST['contact_status']."'";
						
					}
					$query_res.=" order by id";
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
		$pagination .= "<a href=\"manage_restaurant_contact_request.php?page=$prev&email=".$_REQUEST['email']."&restaurant=".$_REQUEST['restaurant']."&status=".$_REQUEST['status']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_restaurant_contact_request.php?page=$i&email=".$_REQUEST['email']."&restaurant=".$_REQUEST['restaurant']."&status=".$_REQUEST['status']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_restaurant_contact_request.php?page=$next&email=".$_REQUEST['email']."&restaurant=".$_REQUEST['restaurant']."&status=".$_REQUEST['status']."\" class=\"more_link_pagination_prev\">Next</a>"; 
		$pagination.="&nbsp;&nbsp;&nbsp;";
		} 
		
		$query_res.=" limit $from,$max_results";
		//echo $query_res;
		$query_products=mysql_query($query_res);
		////////////////////////////////End pagination////////////////////////////////////
		$status_arr = array(
								1 => '<span style="color:#D48651">Pending</span>', 
								2 => '<span style="color:#5C66A9">Approved but login details not sent</span>', 
								3 => '<span style="color:#F00">Denied</span>', 
								4 => '<span style="color:#0C0">Approved and sent login details</span>'
		);
		$subject_arr = array(
								1 => 'Restaurant Request', 
								2 => 'General Enquiry', 
								3 => 'Grievance'
		);
		//print_r($status_arr);		
					if(mysql_num_rows($query_products)>0)
					{
						$inc=1;
						while($array_contacts=mysql_fetch_array($query_products))
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
					?>
					  <td height="30" align="center" valign="middle"><?php echo $a=($j+$inc); ?></td>
                      <td align="center" valign="middle"><?php  echo $array_contacts['name']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_contacts['email']; ?></td> 
                      <td align="center" valign="middle"><?php  echo $array_contacts['phone']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_contacts['restaurant']; ?></td> 
                      <td align="center" valign="middle"><?php  echo $array_contacts['message']; ?></td> 
                      <td align="center" valign="middle"><?php  echo $array_contacts['subject']; ?></td> 
                      <td align="center" valign="middle"><?php  echo $status_arr[$array_contacts['status']]; ?></td> 
           
                     <td align="center" valign="middle">
                     	<a href="edit_contact.php?action=edit&id=<?php echo $array_contacts['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure, you want to edit ?');"><img src="images/1304761512_pen.png" alt="Update status" title="Update status" border="0" /></a>&nbsp;&nbsp;<a href="manage_restaurant_contact_request.php?delete=del&delete_id=<?php echo $array_contacts['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a>
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
                 <td height="20" colspan="11" align="center" valign="middle" bgcolor="#FFF9E3" style="padding:5px 0px 5px 0px; font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#060;"><?=$pagination;?></td>
               </tr>
      </table></td></tr></table>
      </table>
</form>    
</div>

<?php
}
require_once"template_admin.php";
?>