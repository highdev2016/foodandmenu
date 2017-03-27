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
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=="del" && $_REQUEST['delete_id']!='')
{
	mysql_query("DELETE FROM restaurant_reviews WHERE id=".$_REQUEST['delete_id']."");
	mysql_query("DELETE FROM restaurant_rating WHERE review_id=".$_REQUEST['delete_id']."");
	mysql_query("DELETE FROM  restaurant_like_dislike WHERE  	review_id=".$_REQUEST['delete_id']."");
	$msg1="Successfully deleted reviews.";
	header("location:manage_reviews.php?msg1=$msg1&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////
if($_REQUEST['action']=="active")
{
	mysql_query("update restaurant_reviews set status=1 where id='".$_REQUEST['active_id']."'");
	mysql_query("update restaurant_rating set status=1 where review_id='".$_REQUEST['active_id']."'");
	header("location:manage_reviews.php");
}
if($_REQUEST['action']=="inactive")
{
	mysql_query("update restaurant_reviews set status=0 where id='".$_REQUEST['inactive_id']."'");
	mysql_query("update restaurant_rating set status=1 where review_id='".$_REQUEST['inactive_id']."'");
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
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

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
                 <td>Post Date:</td>
                  <td><input type="text" name="post_date" id="datepicker" /></td>
                  <?php
				  $sql_restaurant=mysql_query("SELECT * FROM restaurant_basic_info WHERE status=1 ORDER BY restaurant_name");
				  ?>
                  <td>Restaurant:</td>
                  <td><select name="restaurant" id="restaurant">
                  <option value="">------SELECT------</option>
                  <?php
				  while($res_restaurant=mysql_fetch_array($sql_restaurant)){
					  ?>
                      <option value="<?php echo $res_restaurant['id']?>"><?php echo stripslashes($res_restaurant['restaurant_name'])?></option>
				  <?php }
                  ?></select></td>
                    <td><input type="submit" name="search" value="Search" /></td>
                 </tr>
                 </table></td>
               </tr>
               <tr>
                 <td align="center" valign="top" class="login_labelin">
                 <table width="100%" height="99" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;">
                     <td width="12%" height="35" align="center">No</td>
                     <td width="12%" align="center">Post Date</td>
                     <td width="12%" align="center">Customer Email</td>
                     <td width="12%" align="center">restaurant</td>
                     <td width="32%" align="center">Reviews</td>
                     <td width="20%" align="center">Action</td>  
                   </tr>
                  <?php 
				    $query_res="select * from restaurant_reviews where 1";
					if($_REQUEST['post_date'])
					{
					$query_res.=" AND post_date='".change_dateformat($_REQUEST['post_date'])."'";
					}
					if($_REQUEST['restaurant'])
					{
					$query_res.=" AND restaurant_id=".$_REQUEST['restaurant']."";
					}
					$query_res.=" order by post_date desc";
			
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
		$pagination .= "<a href=\"manage_reviews.php?page=$prev\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_reviews.php?page=$i\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_reviews.php?page=$next\" class=\"more_link_pagination_prev\">Next</a>"; 
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
							$sql_customer=mysql_fetch_array(mysql_query("select id,email from restaurant_customer where id='".$array_products['customer_id']."'"));
							$sql_restaurant=mysql_fetch_array(mysql_query("select restaurant_name from restaurant_basic_info where id='".$array_products['restaurant_id']."'"));
					?>
					  <td height="30" align="center" valign="middle"><?php echo $a=($j+$inc); ?></td>
                      <td align="center" valign="middle"><?php  echo change_dateformat_reverse($array_products['post_date']); ?></td>
                       <td align="center" valign="middle"><?php  echo $sql_customer['email']; ?></td>
                        <td align="center" valign="middle"><?php  echo $sql_restaurant['restaurant_name']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['customer_review']; ?></td>
                      
           
                     <td align="center" valign="middle">
                    <?php /*?> <?php 
					 if($array_products['status']==0)
					 { echo  "Abused";
                     
					 }
					 ?><?php */?>
                     <?php
					 if($array_products['status']==0)
					 {
					 ?>
                     <a href="manage_reviews.php?active_id=<?=$array_products['id']?>&page=<?=$_REQUEST['page']?>&action=active">Active</a>
                     <?php } else{?><a href="manage_reviews.php?inactive_id=<?=$array_products['id']?>&page=<?=$_REQUEST['page']?>&action=inactive">Inactive</a><?php }?>&nbsp;&nbsp;<a href="review_reply.php?customer_id=<?php echo $sql_customer['id'];?>&review_id=<?=$array_products['id']?>&page=<?=$_REQUEST['page']?>"><img src="images/1373904457_reply.png" alt="Reply" title="Reply" border="0" /></a>&nbsp;&nbsp;<a href="manage_reviews.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a>
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