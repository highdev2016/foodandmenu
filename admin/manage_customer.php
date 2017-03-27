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
	$sql_customer = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_REQUEST['delete_id']."' "));
	
	mysql_query("DELETE FROM  restaurant_customer WHERE id=".$_REQUEST['delete_id']."");
	
	$email = $sql_customer['email']; //"priya@infosolz.com"

	$name = $sql_customer['firstname'].' '.$sql_customer['lastname'];
	
	/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">
				<div style="margin:0 auto;width:700px;clear:both;">
				<div style="background-color:#3F4CA0; height:30px;"></div>
				<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">
				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />
				</div>
				<div style="width:100%; float:left;">
				<div style="clear:both;"></div>
					<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$name.',</p>
					<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Your account has been deleted by Admin due to violation of Food & menu services .</p>
				<div style="clear:both;"></div>
				<h3 style="font:bold 15px Arial, Helvetica, sans-serif; color: #fff; border-bottom:1px solid #04303D;margin:0 0 5px 0; background-color:#474747; padding:3px 10px;"></h3>
				<div style="clear:both;"></div>
					<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 4px 0;">Kind regards,</p>
					<p style="font:bold 14px Arial, Helvetica, sans-serif; list-style:none; color:#000000; margin:0 0 15px 0; font-weight:bold;">Food & menu</p>
				<div style="clear:both;"></div>
				</div>
				<div style="clear:both;"></div>
				<div style="background-color:#3F4CA0; margin:10px 0 0 0;" >
				<h4 style="font:normal 20px Arial, Helvetica, sans-serif; color:#fff; text-align:center; line-height:32px; float:none; padding:0; margin:0;">
	Sent to you from Food & menu</h4>
			</div>
		</div>
		<div style="clear:both;"></div>
		</div>';*/
		
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 7"));	
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$name%%',$name,$cms_rep);		
				
	$from = "support@foodandmenu.com";
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message = $cms_rep;
	
	/*$subject="Account Deleted";*/
	
	$subject = stripslashes($sql_cms['subject']);
	
	mail($email,$subject,$message,$headers);

	header("location:manage_customer.php?success=2&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////
?>
<script type="text/javascript">
function sort_function(sort_by,first_name,last_name,email,city,state){
	location.href = 'manage_customer.php?sort_order='+sort_by+"&first_name="+first_name+"&last_name="+last_name+"&email="+email+"&city="+city+"&state="+state;
}

function view(customer_id){
	window.open('user_reviews.php?id='+customer_id,'view','height=500, width=600, resizable=yes, scrollbars=yes');
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
			document.getElementById('city').innerHTML=subCat;
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
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage customer</h2></td>
               </tr>
               <tr>
                 <td></td>
               </tr>
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>
			   		  <?php
					  if($_REQUEST['success']==2)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Successfully deleted customer details</font></td>
					  </tr>
					  <?php
					  }
                       else if($_REQUEST['success']==3)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Successfully updated customer details</font></td>
					  </tr>
					  <?php
					  } else if($_REQUEST['send']==1)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Activation Link Send successfully.</font></td>
					  </tr>
					  <?php
					  }else if($_REQUEST['disable']==1)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Account Disabled successfully.</font></td>
					  </tr>
					  <?php
					  }else if($_REQUEST['enabled']==1)
					  {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Account Enabled successfully.</font></td>
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
                 <td height="41" class="login_labelin">First Name:</td>
                  <td><input type="text" name="first_name" id="first_name" class="login_ipboxin" value="<?php echo $_REQUEST['first_name'];?>"/></td>
                
                  <td class="login_labelin">Last Name:</td>
                  <td><input type="text" name="last_name" id="last_name" class="login_ipboxin" value="<?php echo $_REQUEST['last_name'];?>"></td>
                    <td></td>
                 </tr>
                 <tr>
                
                  <td class="login_labelin">State:</td>
                  <td>
                  <select name="state" id="state" class="login_ipboxin" style="padding:0; height:25px; width:290px;" onchange="get_state_city(this.value);">
                  <option value="">--SELECT--</option>
                  <?php $sql_select_state = mysql_query("SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!=''");
				  while($array_select_state = mysql_fetch_array($sql_select_state)){ ?>
					<option value="<?php echo $array_select_state['restaurant_state']; ?>" <?php if($array_select_state['restaurant_state'] == $_REQUEST['state']){?> selected="selected" <?php } ?>><?php echo $array_select_state['restaurant_state']; ?></option>
                  <?php } ?>
                  
                  
                  <?php $sql_customer_state = mysql_query("SELECT DISTINCT state FROM restaurant_customer WHERE state NOT IN (SELECT DISTINCT(restaurant_state) FROM restaurant_basic_info WHERE restaurant_state!='') AND state!=''");
				  if(mysql_num_rows($sql_customer_state)>0){
					  while($array_customer_state = mysql_fetch_array($sql_customer_state)){ ?>
                      <option  value="<?php echo $array_customer_state['state']; ?>" <?php if($array_customer_state['state'] == $_REQUEST['state']){?> selected="selected" <?php } ?> ><?php echo $array_customer_state['state']; ?></option>
				  <?php }
				  }
				  ?>
				  </select>
                  <?php /*?><input type="text" name="state" id="state" class="login_ipboxin" <?php echo $_REQUEST['state'];?>><?php */?></td>
                  
                  
                  <td height="38" class="login_labelin">City:</td>
                  <td>
                  <select name="city" id="city" class="login_ipboxin" style="padding:0; height:25px; width:290px;">
                  <?php /*?><option value="">--SELECT--</option>
                  <?php $sql_select_city = mysql_query("SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!=''");
				  while($array_select_city = mysql_fetch_array($sql_select_city)){ ?>
					<option value="<?php echo $array_select_city['restaurant_city']; ?>" <?php if($array_select_city['restaurant_city'] == $_REQUEST['city']){?> selected="selected" <?php } ?>><?php echo $array_select_city['restaurant_city']; ?></option>
                  <?php } ?>
                  
                  <?php $sql_customer_city = mysql_query("SELECT DISTINCT city FROM restaurant_customer WHERE city NOT IN (SELECT DISTINCT(restaurant_city) FROM restaurant_basic_info WHERE restaurant_city!='') AND city!=''");
				  if(mysql_num_rows($sql_customer_city)>0){
					  while($array_customer_city = mysql_fetch_array($sql_customer_city)){ ?>
                      <option  value="<?php echo $array_customer_city['city']; ?>" <?php if($array_customer_city['city'] == $_REQUEST['city']){?> selected="selected" <?php } ?> ><?php echo $array_customer_city['city']; ?></option>
				  <?php }
				  }
				  ?><?php */?>
                  </select>
                  <?php /*?><input type="text" name="city" id="city" class="login_ipboxin" <?php echo $_REQUEST['city'];?>/><?php */?></td>
                  
                  <td></td>
                 </tr>
                 <tr>
                 <td height="40" class="login_labelin">Email:</td>
                  <td><input type="text" name="email" id="email" class="login_ipboxin" value="<?php echo $_REQUEST['email'];?>" /></td>
                  <td class="login_labelin" colspan="3">
                  <input type="submit" name="search" value="Search" class="login_button" />
                  <a href="manage_customer.php"><input type="button" name="show_all" value="Show All" class="login_button" style="margin-left:15px;" /></a>
                  </td>
                 </tr>
                 </form>
                 <tr>
                   <td class="login_labelin">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td colspan="2"><form name="form1" method="post" action="users_export_excel.php">
<input type="submit" name="export" value="Export to Excel" class="button_exprt" />
</form></td>
                 </tr>
                 </table></td>
               </tr>
               <tr>
                 <td align="center" valign="top" class="login_labelin">
                 <table width="100%" height="99" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;">
                     <td width="3%" height="35" align="center">No</td>
                     <td width="8%" align="center"><a href="javascript:void(0)" onclick="sort_function('registration_time','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">Registered On</a>
                     (MM-DD-YYYY)</td>
                     <td width="7%" align="center"><a href="javascript:void(0)" onclick="sort_function('firstname','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">Firstname</a></td>
                     <td width="9%" align="center"><a href="javascript:void(0)" onclick="sort_function('lastname','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">Lastname</a></td>
                     <td width="8%" align="center"><a href="javascript:void(0)" onclick="sort_function('city','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">City</a></td>
                     <td width="8%" align="center"><a href="javascript:void(0)" onclick="sort_function('state','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">State</a></td>
                     <td width="13%" align="center"><a href="javascript:void(0)" onclick="sort_function('email','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">Email</a></td>
                     <td width="16%" align="center"><a href="javascript:void(0)" onclick="sort_function('last_logged_in','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">Last Login Time</a></td>
                     <td width="8%" align="center"><a href="javascript:void(0)" onclick="sort_function('no_reviews','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">No. of reviews</a></td>
                     <td width="11%" align="center"><a href="javascript:void(0)" onclick="sort_function('status','<?php echo $_REQUEST['first_name']; ?>','<?php echo $_REQUEST['last_name']; ?>','<?php echo $_REQUEST['email']; ?>','<?php echo $_REQUEST['city']; ?>','<?php echo $_REQUEST['state']; ?>')" class="heading_link">Status</a></td>
                     <td width="11%" align="center">Disable Account</td>
                     <td width="9%" align="center">Action</td>  
                   </tr>
                  <?php 
				    $query_res="select * from  restaurant_customer where 1";
					if($_REQUEST['first_name']!="")
					{
					 $query_res.=" AND firstname LIKE '".$_REQUEST['first_name']."%'";
					}
					if($_REQUEST['last_name']!="")
					{
						 $query_res.=" AND lastname LIKE '".$_REQUEST['last_name']."%'";
					}
					if($_REQUEST['email']!="")
					{
						 $query_res.=" AND email = '".$_REQUEST['email']."'";
					}
					if($_REQUEST['city']!="")
					{
						 $query_res.=" AND city = '".$_REQUEST['city']."'";
					}
					if($_REQUEST['state']!="")
					{
						 $query_res.=" AND state = '".$_REQUEST['state']."'";
					}
					if($_REQUEST['sort_order']!=''){
						$query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
					}
					
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
		$pagination .= "<a href=\"manage_customer.php?page=$prev&first_name=".$_REQUEST['first_name']."&last_name=".$_REQUEST['last_name']."&email=".$_REQUEST['email']."&city=".$_REQUEST['city']."&state=".$_REQUEST['state']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
		$pagination .= "<a href=\"manage_customer.php?page=$i&first_name=".$_REQUEST['first_name']."&last_name=".$_REQUEST['last_name']."&email=".$_REQUEST['email']."&city=".$_REQUEST['city']."&state=".$_REQUEST['state']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination\">$i</a>"; 
		$pagination.='&nbsp;&nbsp;&nbsp;';
		} 
		} 
		
		if($page < $total_pages) 
		{ 
		$pagination .= "<a href=\"manage_customer.php?page=$next&first_name=".$_REQUEST['first_name']."&last_name=".$_REQUEST['last_name']."&email=".$_REQUEST['email']."&city=".$_REQUEST['city']."&state=".$_REQUEST['state']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
                       <td height="30" align="center" valign="middle"><?php /*?><?php $date_array=explode(" ",$array_products['registration_time']); echo change_dateformat_reverse($date_array[0])."&nbsp;".$date_array[1];?><?php */?>
                       <?php /*?><?php if($array_products['registration_time'] != '0000-00-00 00:00:00'){ echo date("m-d-Y", strtotime($array_products['registration_time']))}; ?><?php */?>
                       <?php if($array_products['registration_time']!= '0000-00-00 00:00:00'){ echo date("m-d-Y", strtotime($array_products['registration_time'])); }?>
                       </td>
                      <td align="center" valign="middle"><?php  echo
$array_products['firstname'];?></td> 
                      <td align="center" valign="middle"><?php  echo $array_products['lastname']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['city']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['state']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['email']; ?></td>
                      <td align="center" valign="middle"><?php  echo date("m-d-Y H:i:s", strtotime($array_products['last_logged_in'])); ?></td>
                      <td align="center" valign="middle">
                      <?php $sql_query = mysql_query("SELECT * FROM restaurant_reviews WHERE customer_id = '".$array_products['id']."'"); 
					  $num_row_query = mysql_num_rows($sql_query); ?>
                      <?php if($num_row_query!=0){ ?> 
                      <a href="javascript:void(0);" style="color:#6E6E6E;" onclick="return view('<?php echo $array_products['id'];?>');"><?php } ?>
					  <?php echo $num_row_query; ?>
					  <?php if($num_row_query!=0){ ?></a><?php } ?></td>
                      <td align="center" valign="middle"><?php  if($array_products['status'] == 1){ echo "Active"; } else { echo "Inactive"; }?><br />
					  <?php if($array_products['status'] == 0){ ?> <a href="send_activation_link.php?id=<?php echo $array_products['id']; ?>&page=<?php echo $_REQUEST['page']; ?>"> Send Activation link </a> <?php }?>
                      </td>
                      <td align="center" valign="middle"><?php  if($array_products['account_disabled'] == 1){ ?> 
                      <a href="enable_account.php?id=<?php echo $array_products['id']; ?>">Enable Account</a> <?php } ?><br />
                      
					  <?php if($array_products['account_disabled'] == 0){ ?> <a href="disable_account.php?id=<?php echo $array_products['id']; ?>&page=<?php echo $_REQUEST['page']; ?>"> Disable Account </a> <?php }?>
                      </td>
                      <td align="center" valign="middle"><a href="edit_customer.php?action=edit&id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure, you want to edit ?');"><img src="images/1304761512_pen.png" alt="Edit" title="Edit" border="0" /></a>&nbsp;&nbsp;<a href="manage_customer.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?you want to delete this customer');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a>
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
   
</div>

<?php
}
require_once"template_admin.php";
?>