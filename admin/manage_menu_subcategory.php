<?php 
ob_start();
function main()
{
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	mysql_query("DELETE FROM restaurant_menu_subcategory WHERE id=".$_REQUEST['delete_id']."");
	$msg1="Successfully deleted subcategory.";
	header("location:manage_menu_subcategory.php?msg1=$msg1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////
?>


<script type="text/javascript">
function sort_function(sort_by,category,subcategory){
	location.href = "manage_menu_subcategory.php?sort_order="+sort_by+"&category="+category+"&subcategory="+subcategory;
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
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Menu Subcategory</h2> <span style="float:right" class="login_labelin"><a href="add_menu_subcategory.php" style="color:#7D7E7E; text-decoration:none; font-weight:bold;">Add Menu Subcategory</a></span></td>
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
                   <?php
				  $sql_restaurant=mysql_query("SELECT * FROM restaurant_menu_category WHERE 1 ORDER BY category_name");
				  ?>
                 <tr>
                 <td class="login_labelin">Category Name:</td>
                  <td><select name="category" id="category" class="login_ipboxin" style="padding:0; height:25px;">
                  <option value="">------SELECT------</option>
                  <?php
				  while($res_restaurant=mysql_fetch_array($sql_restaurant)){
					  ?>
                      <option value="<?php echo $res_restaurant['id']?>" <?php if($_REQUEST['category'] == $res_restaurant['id']){ ?> selected="selected" <?php }?>><?php echo stripslashes($res_restaurant['category_name'])?></option>
				  <?php }
                  ?></select>
                  </td>
               <?php $query_subcat=mysql_query("select * from restaurant_menu_subcategory where 1");?> 
                  <td class="login_labelin">Subcategory:</td>
                  <td>
                  <select name="subcategory" id="subcategory" class="login_ipboxin" style="padding:0; height:25px;">
                    <option value="">------SELECT------</option>
                   <?php
				  while($res_subcat=mysql_fetch_array($query_subcat)){
					  ?>
                      <option value="<?php echo $res_subcat['subcategory_name']?>" <?php if($_REQUEST['subcategory'] == $res_subcat['subcategory_name']){ ?> selected="selected" <?php }?>><?php echo stripslashes($res_subcat['subcategory_name'])?></option>
				  <?php }
                  ?>
                  </select>
                  <!--<input type="text" name="subcategory" class="login_ipboxin">--></td>
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
                     <td width="10%" height="35" align="center">No</td>
                     <td width="30%" align="center">
                     <a href="javascript:void(0)" onclick="sort_function('rmc.category_name','<?php echo $_REQUEST['category']; ?>','<?php echo $_REQUEST['subcategory']; ?>')" class="heading_link">Category Name</a></td>
                     <td width="30%" align="center">
                     <a href="javascript:void(0)" onclick="sort_function('rms.subcategory_name','<?php echo $_REQUEST['category']; ?>','<?php echo $_REQUEST['subcategory']; ?>')" class="heading_link">Subcategory Name</a></td>
                     <td width="15%" align="center">
                     <a href="javascript:void(0)" onclick="sort_function('rms.show_order','<?php echo $_REQUEST['category']; ?>','<?php echo $_REQUEST['subcategory']; ?>')" class="heading_link">Show Order</a></td>
                     <td width="15%" align="center">Action</td>  
                   </tr>
                    <?php 
				    $min_order_id=mysql_fetch_array(mysql_query("SELECT MIN(show_order) as min_id FROM restaurant_menu_subcategory"));
                    $max_order_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_menu_subcategory"));
				  
				    $query_res="select rmc.category_name, rms.id,rms.category_id, rms.subcategory_name, rms.subcategory_desc, rms.show_order from restaurant_menu_subcategory rms INNER JOIN restaurant_menu_category rmc ON rmc.id = rms.category_id where  1";
					if($_REQUEST['category']!="")
					{
						$query_res.=" AND rms.category_id=".$_REQUEST['category']."";
					}
					
					if($_REQUEST['subcategory']!="")
					{
						$query_res.=" AND rms.subcategory_name LIKE '".$_REQUEST['subcategory']."%'";
					}
					
					if($_REQUEST['sort_order']){
						$query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
					}
					else{
						$query_res.= " ORDER BY rms.show_order";
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
		$max_results = 50; 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sel_product); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"manage_menu_subcategory.php?page=$prev&category=".$_REQUEST['category']."&subcategory=".$_REQUEST['subcategory']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_menu_subcategory.php?page=$i&category=".$_REQUEST['category']."&subcategory=".$_REQUEST['subcategory']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_menu_subcategory.php?page=$next&category=".$_REQUEST['category']."&subcategory=".$_REQUEST['subcategory']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
                      <?php
					  $sql_category=mysql_fetch_array(mysql_query("select * from restaurant_menu_category where id='".$array_products['category_id']."'")); 
					  ?>
					  <td align="center" valign="middle"><?php  echo $sql_category['category_name']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['subcategory_name']; ?></td>  
           			  <td align="center" valign="middle"><?php if($min_order_id['min_id']!=$array_products['show_order']) {?><a href="order_change_up_sub_cat.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?>&page=<?php echo $_REQUEST['page']; ?>"><img src="images/up2.gif" border="0"/></a><?php } ?>&nbsp;&nbsp;<?php if($max_order_id['max_id']!=$array_products['show_order']){ ?><a href="order_change_down_sub_cat.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?>&page=<?php echo $_REQUEST['page']; ?>"><img src="images/drop2.gif" border="0"/></a><?php } ?></td> 
                      <td align="center" valign="middle"><a href="edit_menu_subcategory.php?action=edit&id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure, you want to edit ?');"><img src="images/1304761512_pen.png" alt="Edit" title="Edit" border="0" /></a>&nbsp;&nbsp;<a href="manage_menu_subcategory.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a>
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