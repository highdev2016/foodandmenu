<?php 
ob_start();
function main()
{

?>

<div class="dashboard_section_in">
<form name="frmproduct" action="#" method="post">
<input type="hidden" name="package_details_id" value="<?php echo $_REQUEST['product_id']?>" />
<input type="hidden" name="action" value="<?php echo $_REQUEST['action']?>" />
<input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>" />
<input type="hidden" name="search_market" value="<?php echo $_REQUEST['search_market']?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td height="92"><h2 style="background:#FA8730; color:#fff; padding:8px;">Manage Restaurant Add Confirmation Notification</h2><span style="float:right" class="login_labelin"><a href="javascript:void(0);" onclick="history.back();" ><input type="button" name="back" id="back" value="Back" class="normalbutton" /></a></span></td>
               </tr>
               <tr>
                 <td>
                 </td>
               </tr>
               <tr>
                 <td style="padding-left:20px; padding-top:15px;"></td>
               </tr>
			   		   <?php if($_REQUEST['success']==1)
					  { ?>
					  <tr>
						<td height="30" colspan="4" align="center" class="login_labelin"><font color="#FF3333"><img src="images/approve.jpg" height="18" align="absmiddle">Status updated successfully</font></td>
					  </tr>
					  <?php } ?>
                      
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
                     <td width="22%" height="35" align="center">No</td>
                     <td width="59%" align="center">Heading</td>
                     <td width="19%" align="center">Action</td>
                   </tr>
                  
                    <tr bgcolor="#ffffff" height="40">
                      <td align="center" valign="middle">1</td> 
                      <td align="center" valign="middle">MAIL TO ADMIN</td> 
                      <td align="center" valign="middle"><a href="manage_auto_responder.php?page_id=21">EDIT</a></td>
					</tr>
                    
                    <tr bgcolor="#eeeeee" height="40">
                      <td align="center" valign="middle">2</td> 
                      <td align="center" valign="middle">MAIL TO RESTAURANT OWNER</td> 
                      <td align="center" valign="middle"><a href="manage_auto_responder.php?page_id=22">EDIT</a></td>
					</tr>
                    
             </table></td>
           </tr>
           
               <tr>
                 <td align="center" valign="top">&nbsp;</td>
                 
               </tr>
               <tr>
                 <td height="20" colspan="10" align="center" valign="middle" bgcolor="#FFF9E3" style="padding:5px 0px 5px 0px; font-family:Verdana, Geneva, sans-serif; font-size:15px; color:#060;"></td>
               </tr>
      </table></td></tr></table>
      </table>
</form>    
</div>

<?php
}
require_once"template_admin.php";
?>