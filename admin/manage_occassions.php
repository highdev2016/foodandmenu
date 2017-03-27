<?php 
ob_start();
function main()
{
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	mysql_query("DELETE FROM  restaurant_occassions WHERE id=".$_REQUEST['delete_id']."");
	header("location:manage_occassions.php?msg1=1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////

?>

<script type="text/javascript">
function sort_function(sort_by,occassions){
	location.href = 'manage_occassions.php?sort_order='+sort_by+"&occassions="+occassions;
}
</script>

<div class="dashboard_section_in">
<form name="frmproduct" action="manage_occassions.php" method="post">
<input type="hidden" name="action" value="<?php echo $_REQUEST['action']?>" />
<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td>
               
               
               
               
               
               
               
               
               
               </td>
               </tr>
               <tr>
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Occassions</h2> <span style="float:right" class="login_labelin"><a href="add_occassions.php" style="color:#7D7E7E; text-decoration:none; font-weight:bold;">Add Occassions</a></span></td>
               </tr>
               
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>
			   <?php if($_REQUEST['msg1'] == 1)
              {?>
              <tr>
                <td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle"><?php echo "Occassions Deleted Successfully.";?></font></td>
              </tr>
              <?php
              }
              ?> 
                        
           <tr>
             <td>
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 <td width="14%" class="login_labelin">Occassions:</td>
                  <td width="33%"><input type="text" name="occassions" id="occassions"  class="login_ipboxin" value="<?php echo $_REQUEST['occassions'] ?>"></td>
                  <td width="12%"><input type="submit" name="search" value="Search" class="login_button"></td>
                    <td width="38%"><a href="manage_occassions.php"><input type="button" name="search" value="Show All" class="login_button"></a></td>
                 </tr>
                   <tr>
                   <td class="login_labelin">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td width="3%">&nbsp;</td>
                 </tr>
                 </table>
             </td>
           </tr>
           
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
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;" height="20">
                     <td width="20%" height="35" align="center">No</td>
                     <td width="40%" align="center"><a href="javascript:void(0)" onclick="sort_function('occassions','<?php echo $_REQUEST['occassions']; ?>')" class="heading_link">Occassions</a></td>
                     <td width="25%" align="center"><a href="javascript:void(0)" onclick="sort_function('status','<?php echo $_REQUEST['occassions']; ?>')" class="heading_link">Status</a></td>
                     <td width="25%" align="center">Action</td>  
                   </tr>
                  <?php 
				    $query_res="SELECT * FROM restaurant_occassions ";
					
					if($_REQUEST['occassions']!=''){
						$query_res.= " WHERE occassions LIKE '%".$_REQUEST['occassions']."%' ";
					}
					if($_REQUEST['sort_order']!=''){
						$query_res.= " ORDER BY ".$_REQUEST['sort_order']." ASC ";
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
		$max_results =10; 
		$prev = ($page - 1); 
		$next = ($page + 1); 
		$from = (($page * $max_results) - $max_results); 
		
		$total_results = mysql_num_rows($sel_product); 
		$total_pages = ceil($total_results / $max_results); 
		
		$pagination = ''; 
		
		if($page > 1) 
		{ 
		$pagination .= "<a href=\"manage_occassions.php?page=$prev&occassions=".$_REQUEST['occassions']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_occassions.php?page=$i&occassions=".$_REQUEST['occassions']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_occassions.php?page=$next&occassions=".$_REQUEST['occassions']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
                      
                      <td align="center" valign="middle"><?php  echo $array_products['occassions']; ?></td>
                      
                      <td align="center" valign="middle"><?php  echo $array_products['status']; ?></td>  
           
                     <td align="center" valign="middle"><a href="edit_occassions.php?action=edit&id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure, you want to edit ?');" title="Edit"><img src="images/1304761512_pen.png" alt="Edit" title="Edit" border="0" /></a>&nbsp;&nbsp;<a href="manage_occassions.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');" title="Delete"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a>
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