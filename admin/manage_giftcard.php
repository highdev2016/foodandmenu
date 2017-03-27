<?php 
ob_start();
include("../includes/functions.php");
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
	mysql_query("DELETE FROM  restaurant_gift_card WHERE id=".$_REQUEST['delete_id']."");
	header("location:manage_giftcard.php?success=2&page=".$_REQUEST['page']."");
}
///////////////////////End for delete/////////////////////////////////////
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type="text/javascript">
function sort_function(sort_by,post_date,restaurant,username){
	location.href = 'manage_giftcard.php?sort_order='+sort_by+"&post_date="+post_date+"&restaurant="+restaurant+"&username="+username;
}
</script>

<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp1=false; 
	try{
		xmlhttp1=new XMLHttpRequest();
	}
	catch(e) {  
    try{   
	xmlhttp1= new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch(e){
	try{
	xmlhttp1 = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e1){
	xmlhttp1=false;
	}
	}
	}
	return xmlhttp1;
	}
function change_status(id,status){
	
		//alert(status);
		var strURL='change_status.php?id='+id+'&status='+status;
		//alert(strURL);
		//alert(document.frm.photo_1.value);
   		
   		var req = getXMLHTTP();
   		//alert(req);
   		if (req)
   		{
     		req.onreadystatechange = function()
     		{
				//alert(req.readyState);
      			if (req.readyState == 4)
      			{
	 				//alert(req.status);
	 				if (req.status == 200)
         			{
						var gradedateshow=req.responseText;
					    //alert(gradedateshow);
						document.getElementById('msg').innerHTML=gradedateshow;
						setTimeout(function() {
						document.getElementById('msg').innerHTML='';
						}, 2000);
						return false;
				
					 }
					 else
					 {
   	   					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
	 				 }
       			}
      	 	}
   			req.open("GET", strURL, true);
   			req.send(null);
   		 }
 
}
</script>
<script type="application/javascript">
function change_status(id)
{
var $j = jQuery.noConflict();
$j.ajax({
		url : 'change_status_giftcard.php',
		type : 'POST',
		data : 'id=' + id,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			if(data != "")
			{
				$j("#change_status_tr").html('<img src="images/approve.jpg" height="18" align="absmiddle">&nbsp;<font color="#008000">Status Changed Successfully.</font>').fadeIn(1000);
				if(data == 0)
				{
					$j("#span"+id).html('Not Used');
				}
				else
				{
					$j("#span"+id).html('Used');
				}
			}
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
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
             <td>
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage GiftCard</h2> </td>
               </tr>
               <tr>
                 <td></td>
               </tr>
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>
			   		   <?php if($_REQUEST['success']==2) {?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Successfully Deleted Giftcard.</font></td>
					  </tr>
					  <?php
					  }
					  ?>
             			
          <?php /*?> <tr>
             <td></td>
           </tr>
           <?php */?>
         
           <tr>
             <td>
             <table width="100%" border="0" cellspacing="0" cellpadding="0">
               
               <tr>
                 <td>
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr style="padding-bottom:10px;">
                 <td height="39" class="login_labelin">Post Date:</td>
                  <td><input type="text" name="post_date" id="datepicker" class="login_ipboxin" value="<?php echo $_REQUEST['post_date']; ?>"></td>
                  <?php
				  $sql_restaurant=mysql_query("SELECT * FROM restaurant_basic_info WHERE status=1 ORDER BY restaurant_name");
				  ?>
                  <td class="login_labelin">Restaurant:</td>
                  <td><?php /*?><select name="restaurant" id="restaurant" class="login_ipboxin" style="padding:0; height:25px;">
                  <option value="">------SELECT------</option>
                  <?php
				  while($res_restaurant=mysql_fetch_array($sql_restaurant)){
					  ?>
                      <option value="<?php echo $res_restaurant['id']?>"><?php echo stripslashes($res_restaurant['restaurant_name'])?></option>
				  <?php }
                  ?></select><?php */?>
                  <input type="text" name="restaurant" id="restaurant" value="<?php echo $_REQUEST['restaurant'] ?>" class="login_ipboxin" />
                  </td>
                    <td></td>
                 </tr>
                 
                 <tr>
                 <td height="33" class="login_labelin">Username:</td>
                  <td><input type="text" name="username" id="username" class="login_ipboxin" value="<?php echo $_REQUEST['username']; ?>"></td>
                  <td class="login_labelin"><input type="submit" name="search" value="Search" class="login_button"></td>
                  <td>
                  </td>
                    <td></td>
                 </tr>
                 
                   <tr>
                   <td <?php /*?>height="43"<?php */?> colspan="5"><div id="msg" style="text-align:center;"></div></td>
                 </tr>
                 </table>
                 </td>
               </tr>
                 <tr>
						<td id="change_status_tr" style="display:none; padding: 20px 0 0;" height="30" colspan="4" align="center" class="login_labelin">
                        
                        </td>
					  </tr>
               <tr>
                 <td align="center" valign="top" class="login_labelin">
                 <table width="100%" height="99" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse;margin: 20px 0 0; ">
                   <tr class="login_labelin" bgcolor="#404CA1" style="color:#ffffff;">
                        <td width="4%" height="35" align="center">No</td>
                        <td width="13%" align="center"><a href="javascript:void(0)" onclick="sort_function('restaurant_name','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['username']; ?>')" class="heading_link">Restaurant Name</a></td>
                        <td width="10%" align="center"><a href="javascript:void(0)" onclick="sort_function('user_name','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['username']; ?>')" class="heading_link">User Name</a></td>
                        <td width="13%" align="center"><a href="javascript:void(0)" onclick="sort_function('email','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['username']; ?>')" class="heading_link">Email</a></td>
                        <td width="10%" align="center"><a href="javascript:void(0)" onclick="sort_function('city','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['username']; ?>')" class="heading_link">City</a></td>
                        <td width="10%" align="center"><a href="javascript:void(0)" onclick="sort_function('state','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['username']; ?>')" class="heading_link">State</a></td>
                        <td width="10%" align="center"><a href="javascript:void(0)" onclick="sort_function('deal','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['username']; ?>')" class="heading_link">Deal</a></td>
                        <td width="10%" align="center"><a href="javascript:void(0)" onclick="sort_function('price','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['username']; ?>')" class="heading_link">Price</a></td>
                        <td width="10%" align="center"><a href="javascript:void(0)" onclick="sort_function('purchase_date','<?php echo $_REQUEST['post_date']; ?>','<?php echo $_REQUEST['restaurant']; ?>','<?php echo $_REQUEST['username']; ?>')" class="heading_link">Purchase Date</a>
                        (MM-DD-YYYY)
                        </td>
                       
                        <td width="10%" align="center">Status</td>
                        <td width="10%" align="center">Action</td>
                   </tr>
                  	<?php 
				    $query_res="select * from restaurant_gift_card where 1";
					if($_REQUEST['post_date'])
					{
						$query_res.=" AND purchase_date='".change_dateformat($_REQUEST['post_date'])."'";
					}
					if($_REQUEST['restaurant'])
					{
						$query_res.=" AND restaurant_name LIKE '".$_REQUEST['restaurant']."%'";
					}
					if($_REQUEST['username'])
					{
						$query_res.=" AND user_name LIKE '".$_REQUEST['username']."%'";
					}
					if($_REQUEST['sort_order']){
						$query_res.=" ORDER BY ".$_REQUEST['sort_order']."";
					}else{
						$query_res.=" ORDER BY id DESC ";
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
					$pagination .= "<a href=\"manage_giftcard.php?page=$prev&post_date=".$_REQUEST['post_date']."&restaurant=".$_REQUEST['restaurant']."&username=".$_REQUEST['username']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Previous</a>"; 
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
					$pagination .= "<a href=\"manage_giftcard.php?page=$i&post_date=".$_REQUEST['post_date']."&restaurant=".$_REQUEST['restaurant']."&username=".$_REQUEST['username']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination\">$i</a>"; 
					$pagination.='&nbsp;&nbsp;&nbsp;';
					} 
					} 
					
					if($page < $total_pages) 
					{ 
					$pagination .= "<a href=\"manage_giftcard.php?page=$next&post_date=".$_REQUEST['post_date']."&restaurant=".$_REQUEST['restaurant']."&username=".$_REQUEST['username']."&sort_order=".$_REQUEST['sort_order']."\" class=\"more_link_pagination_prev\">Next</a>"; 
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
							$sql_deal=mysql_fetch_array(mysql_query("select * from restaurant_deals where id='".$array_products['deal_id']."'"));
							 
							 $basic_info_detail=mysql_fetch_array(mysql_query("select * from restaurant_basic_info where id='".$array_products['restaurant_id']."'"));
							//echo  "select * from restaurant_basic_info where id='".$array_products['restaurant_id']."'";
							 $get_user_name=mysql_fetch_array(mysql_query("SELECT user_nicename FROM restaurant_users WHERE ID=".$basic_info_detail['user_id'].""));
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
                      <td align="center" valign="middle"><?php  echo stripslashes($basic_info_detail['restaurant_name']); ?></td>
                      <td align="center" valign="middle"><?php  echo stripslashes($array_products['user_name']); ?></td> 
                      <td align="center" valign="middle"><?php  echo $array_products['email']; ?></td>  
                      <td align="center" valign="middle"><?php  echo $array_products['city']; ?></td> 
                      <td align="center" valign="middle"><?php  echo $array_products['state']; ?></td>
                      <td align="center" valign="middle"><?php  echo $sql_deal['daily_name']; ?></td>
                      <td align="center" valign="middle"><?php  echo $array_products['price']; ?></td>
                      <td align="center" valign="middle"><?php  echo date("m-d-Y H:i:s", strtotime($array_products['purchase_date'])); ?></td>
                      <td align="center" valign="middle" class="class_hover">
                      <?php 
					  $gift_cer_id = getNameTable("restaurant_gift_certificate_no","id","id",$array_products['id']);
					  $used_status = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_gift_certificate_no WHERE giftcard_id = '".$array_products['id']."'"));
					  //echo $used_status['used'];
					  //$used_status = getNameTable("restaurant_gift_certificate_no","used","id",$array_products['id']);
					  if($used_status['used'] == 0)
						{
							echo "<span id='span".$array_products['id']."'>Not Used</span>";
						}
						else
						{
							echo "<span id='span".$array_products['id']."'>Used</span>";
						}
					  ?>
                      <a class="used_cls" href="javascript:void(0);" onclick="change_status(<?php echo $array_products['id']; ?>);">Change Status</a>
                      </td>
                      
                      <td align="center" valign="middle"><a href="manage_giftcard.php?delete=del&delete_id=<?php echo $array_products['id'];?>&page=<?=$_REQUEST['page']?>" onClick="return confirm('Are you sure?');"><img src="images/1304761651_DeleteRed.png" alt="Delete" title="Delete" border="0" /></a></td>
					</tr>
					<?php
						$inc++;}
					}
					?>
                    
             </table>
             
             
             </td>
           </tr>
              
                 <td height="20" colspan="10" align="center" valign="middle" bgcolor="#FFF9E3" style="padding:5px 0px 5px 0px; font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#060;"><?=$pagination;?></td>
               </tr>
      </table>
      </td></tr>
       
      </table>
     </td>
     		</tr>
      </table>
</form>    
</div>
<?php
}
require_once"template_admin.php";
?>
<script type="text/javascript" src="https://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="https://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
	
	var $j = jQuery.noConflict();
	
  $j(document).ready(function() {
   /*
   *   Examples - images
   */
   
   
   $j("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script>