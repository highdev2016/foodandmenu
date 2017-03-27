<?php 
ob_start();
function main()
{
///////////////////For Delete//////////////////////////////////////////////
if($_REQUEST['delete']=='del')
{
	$sql_select = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_featured_city WHERE id = '".$_REQUEST['delete_id']."'"));
	mysql_query("delete from restaurant_featured_city where featured_city='".$sql_select['featured_city']."'");
	header("location:manage_featured_city.php");
}

if($_REQUEST['submit']!="")
{
	if(count($_REQUEST['city'])==0)
	{
		mysql_query("update restaurant_featured_city set status=0");
	}
	else
	{
		mysql_query("update restaurant_featured_city set status=0");
		foreach($_REQUEST['city'] as $cities)
		{
			
			mysql_query("update restaurant_featured_city set status=1 where id='".$cities."'");
		}
	}
	header("location:manage_featured_city.php");
}
?>

<script type="text/javascript">
function validate(){
	if(document.getElementById('restaurant_state').value!='' && document.getElementById('restaurant_city').value == ''){
		alert('Please select city.');
		document.getElementById('restaurant_city').focus();
		return false;
	}
	return true;
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
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Featured City</h2> </td>
               </tr>
               <tr>
                 <td></td>
               </tr>
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>
                      
               <tr>
                 <td></td>
               </tr>
           
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               
               <tr>
                 <td>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                 
                  <td class="login_labelin">State:</td>
                  <td>
                  <select name="restaurant_state" id="restaurant_state" class="login_ipboxin" style="width:250px; height:27px; padding:0px;" onchange="get_state_city(this.value);" >
                  	<option value="">Select</option>
                    <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='' ORDER BY restaurant_state");
				  while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
					<option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['restaurant_state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
                  <?php } ?>
                  </select>
                  </td> 
                  
                  <td height="45" class="login_labelin">City:</td>
                  <td>
                  <select name="restaurant_city" id="restaurant_city" class="login_ipboxin" style="width:250px; height:27px; padding:0px;">
                  	<option value="">Select</option>
                  </select>
                  </td>
                  
                  <td class="login_labelin"><input type="submit" name="search" value="Search" class="login_button" style="margin-right:15px;" onclick="return validate();">
                    <a href="manage_featured_city.php"><input type="button" name="show_all" value="Show All" class="login_button"></a></td>
                  <td>
                  </td>
                 </tr>
                 
                 </table>
                 </td>
               </tr>
               
               <tr>
                 <td align="center" valign="top" class="login_labelin">
                 <table width="100%" height="99" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;">
                     <td width="17%" height="35" align="center">No</td>
                     <td width="33%" align="center">City</td>
                     <td width="16%" align="center">Status</td>
                     <td width="17%" align="center">Action</td>
                     <td width="17%" align="center">Show Order</td>
                   </tr>
                  <?php 
					$min_order_id=mysql_fetch_array(mysql_query("SELECT MIN(show_order) as min_id FROM restaurant_featured_city WHERE 1"));
					$max_order_id=mysql_fetch_array(mysql_query("SELECT MAX(show_order) as max_id FROM restaurant_featured_city WHERE 1"));
				  
				    $query_res="SELECT DISTINCT(featured_city),id,status,show_order from restaurant_featured_city where featured_city!='' ";
					
					if($_REQUEST['restaurant_city']!=''){
						$query_res.= " AND featured_city = '".$_REQUEST['restaurant_city']."' ";
					}
					
					$query_res.=" GROUP BY featured_city order by show_order ASC";
					
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
		$pagination .= "<a href=\"manage_featured_city.php?page=$prev\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_featured_city.php?page=$i\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_featured_city.php?page=$next\" class=\"more_link_pagination_prev\">Next</a>"; 
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
							$sql_city=mysql_fetch_array(mysql_query("SELECT id,status from  restaurant_featured_city where featured_city='".$array_products['featured_city']."'"));
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
                      <td align="center" valign="middle" style="text-align:center;"><?php  echo $array_products['featured_city']; ?></td>
                      <td align="center" valign="middle"> <input type="checkbox" name="city[]" value="<?php  echo $sql_city['id']; ?>" <?php if($sql_city['status']==1){?> checked="checked"<?php } ?> /></td> 
                       <td align="center" valign="middle" style="text-align:center;"><a href="manage_featured_city.php?delete=del&delete_id=<?php echo $sql_city['id']?>&page=" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a></td>
                        <td align="center" valign="middle" style="text-align:center;">
                        <?php if($min_order_id['min_id']!=$array_products['show_order']){?><a href="fea_city_change_up_res.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?><?php if($_REQUEST['page']!=''){?>&page=<?php echo $_REQUEST['page']; ?><?php } ?>"><img src="images/up2.gif" border="0"/></a><?php } ?>		                        &nbsp;&nbsp;
						<?php if($max_order_id['max_id']!=$array_products['show_order']){?><a href="fea_city_change_down_res.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?><?php if($_REQUEST['page']!=''){?>&page=<?php echo $_REQUEST['page']; ?><?php } ?>"><img src="images/drop2.gif" border="0"/></a><?php } ?><?php if($min_order_id['min_id']!=$array_products['show_order']){?>
                        &nbsp;&nbsp;
                        <a href="fea_city_change_top_res.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?><?php if($_REQUEST['page']!=''){?>&page=<?php echo $_REQUEST['page']; ?><?php } ?>"><img src="images/old-go-top.png" width="14" height="11" title="Go To Top" /></a><?php } ?><?php if($max_order_id['max_id']!=$array_products['show_order']) { ?>
                        &nbsp;&nbsp;
                        <a href="fea_city_change_bottom_res.php?id=<?=$array_products['id']?>&show_order=<?=$array_products['show_order']?><?php if($_REQUEST['page']!=''){?>&page=<?php echo $_REQUEST['page']; ?><?php } ?>"><img src="images/old-go-bottom.png" width="14" height="11" title="Go To Bottom" /></a><?php } ?>
                        </td>         
					</tr>
					<?php
						$inc++;}
					}
					?>
                    
             </table></td>
           </tr>
               <tr>
                 <td align="right" valign="top"><input type="submit" name="submit" value="Submit" class="normalbutton" /></td>
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