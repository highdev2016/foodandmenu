<?php 
ob_start();
function main()
{
	
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
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	mysql_query("DELETE FROM restaurant_updates WHERE id=".$_REQUEST['delete_id']."");
	header("location:manage_updates.php?success=2&page=".$_REQUEST['page']."");
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
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Updates</h2> <span style="float:right" class="login_labelin"><a href="add_updates.php" style="color:#7D7E7E; text-decoration:none; font-weight:bold;">Add Updates</a></span></td>
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
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Updates added successfully</font></td>
					  </tr>
					  <?php
					  }
					  else if($_REQUEST['success']==2)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Successfully deleted updates</font></td>
					  </tr>
					  <?php
					  }
                       else if($_REQUEST['success']==3)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Successfully updated updates</font></td>
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
                     <td width="14%" height="35" align="center">No</td>
                     <td width="21%" align="center">Date (MM-DD-YYYY)</td>
                     <td width="47%" align="center">Short Description</td>
                     <td width="18%" align="center">Action</td>  
                   </tr>
                  <?php 
				    $query_res="select * from restaurant_updates where 1";
					
					$query_res.=" order by id";
					
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
		$pagination .= "<a href=\"manage_updates.php?page=$prev\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_updates.php?page=$i\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_updates.php?page=$next\" class=\"more_link_pagination_prev\">Next</a>"; 
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
                      <td align="center" valign="middle"><?php  echo
change_dateformat_reverse($array_products['date']); ; ?></td> 
                      <td align="center" valign="middle"><?php  echo $array_products['short_desc']; ?></td>
                      
           
                     <td align="center" valign="middle"><a href="edit_updates.php?action=edit&id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure, you want to edit ?');"><img src="images/1304761512_pen.png" alt="Edit" title="Edit" border="0" /></a>&nbsp;&nbsp;<a href="manage_updates.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?you want to delete this update');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a>
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