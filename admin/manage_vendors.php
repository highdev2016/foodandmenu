<?php 
ob_start();
function main()
{
	if($_REQUEST['submit']!="")
{
	if(count($_REQUEST['show_status'])==0)
	{
		mysql_query("update restaurant_vendors set status=0");
	}
	else
	{
		mysql_query("update restaurant_vendors set status=0");
		foreach($_REQUEST['show_status'] as $vendor)
		{
			
			mysql_query("update restaurant_vendors set status=1 where id='".$vendor."'");
		}
	}
	header("location:manage_vendors.php");
}
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	mysql_query("DELETE FROM restaurant_vendors WHERE id=".$_REQUEST['delete_id']."");
	$msg1="Successfully deleted vendor.";
	header("location:manage_vendors.php?msg1=$msg1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////
?>

<script type="text/javascript">
function sort_function(sort_by,company_name,service_type){
	location.href="manage_vendors.php?sort_order="+sort_by+"&company_name="+company_name+"&service_type="+service_type;
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
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Vendors</h2> <span style="float:right" class="login_labelin"><a href="add_vendors.php" style="color:#7D7E7E; text-decoration:none; font-weight:bold;">Add Vendors</a></span></td>
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
                 <td class="login_labelin">Company Name:</td>
                  <td><input type="text" name="company_name" id="company_name"  class="login_ipboxin" value="<?php echo $_REQUEST['company_name'] ?>"></td>
                  <td class="login_labelin">Service Type:</td>
                  <td>
                  <select name="service_type" class="login_ipboxin" style="height:28px;">
                  <option value="">Select</option>
                  <?php $sql_select = mysql_query("SELECT DISTINCT(service_type) FROM restaurant_vendors WHERE id!=''");
				  while($array_select = mysql_fetch_array($sql_select)){?>
                  <option value="<?php echo $array_select['service_type'];?>" <?php if($_REQUEST['service_type'] == $array_select['service_type']){?> selected="selected" <?php } ?>><?php echo $array_select['service_type'];?></option>
                  <?php } ?>
                  </select>
                  <!--<input type="text" name="service_type" id="service_type" class="login_ipboxin" value="<?php echo $_REQUEST['service_type'] ?>"/>--></td>
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
                     <td width="3%" height="35" align="center">No</td>
                     <td width="11%" align="center"><a href="javascript:void(0)" onclick="sort_function('name','<?php echo $_REQUEST['company_name']; ?>','<?php echo $_REQUEST['service_type']; ?>')" class="heading_link">Name</a></td>
                     <td width="11%" align="center"><a href="javascript:void(0)" onclick="sort_function('email','<?php echo $_REQUEST['company_name']; ?>','<?php echo $_REQUEST['service_type']; ?>')" class="heading_link">Email</a></td>
                     <td width="12%" align="center"><a href="javascript:void(0)" onclick="sort_function('company_name','<?php echo $_REQUEST['company_name']; ?>','<?php echo $_REQUEST['service_type']; ?>')" class="heading_link">Company Name</a></td>
                     <td width="8%" align="center"><a href="javascript:void(0)" onclick="sort_function('city','<?php echo $_REQUEST['company_name']; ?>','<?php echo $_REQUEST['service_type']; ?>')" class="heading_link">City</a></td>
                     <td width="11%" align="center"><a href="javascript:void(0)" onclick="sort_function('state','<?php echo $_REQUEST['company_name']; ?>','<?php echo $_REQUEST['service_type']; ?>')" class="heading_link">State</a></td>
                     <td width="16%" align="center"><a href="javascript:void(0)" onclick="sort_function('service_type','<?php echo $_REQUEST['company_name']; ?>','<?php echo $_REQUEST['service_type']; ?>')" class="heading_link">Service Type</a></td>
                     <td width="11%" align="center"><a href="javascript:void(0)" onclick="sort_function('show_order','<?php echo $_REQUEST['company_name']; ?>','<?php echo $_REQUEST['service_type']; ?>')" class="heading_link">Show Order</a></td>
                     <td width="6%" align="center">Status</td>
                     <td width="11%" align="center">Action</td>  
                   </tr>
		<?php 
        $query_res="select * from restaurant_vendors where 1";
        
        if($_REQUEST['company_name'])
        {
            $query_res.=" AND company_name LIKE '".$_REQUEST['company_name']."%'";
        }
        if($_REQUEST['service_type'])
        {
            $query_res.=" AND service_type = '".$_REQUEST['service_type']."'";
        }
        //$query_res.=" order by show_order ASC";
        if($_REQUEST['sort_order']){
            $query_res.=" order by ".$_REQUEST['sort_order']."";
        }
        else {
            $query_res.=" order by show_order";
        }
        //echo $query_res;
        
        $min_order_id=mysql_fetch_array(mysql_query("SELECT MIN(show_order) as min_id FROM restaurant_vendors"));


		$max_order_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_vendors"));
					
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
		$pagination .= "<a href=\"manage_vendors.php?page=$prev&sort_order=".$_REQUEST['sort_order']."&company_name=".$_REQUEST['company_name']."&service_type=".$_REQUEST['service_type']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_vendors.php?page=$i&sort_order=".$_REQUEST['sort_order']."&company_name=".$_REQUEST['company_name']."&service_type=".$_REQUEST['service_type']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_vendors.php?page=$next&sort_order=".$_REQUEST['sort_order']."&company_name=".$_REQUEST['company_name']."&service_type=".$_REQUEST['service_type']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
					?>
					  <td height="30" align="center" valign="middle"><?php echo $a=($j+$inc); ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['name']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['email']; ?></td> 
                      <td align="center" valign="middle"><?php  echo $array_products['company_name']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['city']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['state']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['service_type']; ?></td>
                       <td align="center" valign="middle"><?php if($min_order_id['min_id']!=$array_products['show_order']){?><a href="order_change_up.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?>"><img src="images/up2.gif" border="0"/></a><?php } ?>&nbsp;&nbsp;<?php if($max_order_id['max_id']!=$array_products['show_order']){?><a href="order_change_down.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?>"><img src="images/drop2.gif" border="0"/></a><?php } ?></td>
                        <td align="center" valign="middle"><input type="checkbox" name="show_status[]" value="<?=$array_products['id']?>" <?php if($array_products['status']==1){?> checked="checked"<?php } ?> /></td>
           
                     <td align="center" valign="middle"><a href="edit_vendors.php?action=edit&id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure, you want to edit ?');"><img src="images/1304761512_pen.png" alt="Edit" title="Edit" border="0" /></a>&nbsp;&nbsp;<a href="manage_vendors.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a>
                      </td>
					</tr>
					<?php
						$inc++;}
					}
					?>
                    
             </table></td>
           </tr>
               <tr>
                 <td align="right" valign="top"><input type="submit" name="submit" value="Submit" /></td>
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