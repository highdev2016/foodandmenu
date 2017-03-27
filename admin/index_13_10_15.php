<?php
function main()
{
?>     

<div class="dashboard_section_in">



<table width="100%" border="0" cellspacing="2" cellpadding="2" style="font-size:14px;">

  <tr>

    <td height="30" colspan="3" align="center" class="home_main_heading" style="color: #404CA1; 

    font-size: 20px;font-style: italic;line-height: 40px; text-align: center; font-family:Verdana, Geneva, sans-serif;" >Dashboard</td>

  </tr>

  <tr>

  <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;"><table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Restaurant</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_restaurant_category.php">Add restaurant category</a></td> 

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_restaurant_category.php">Manage restaurant category</a></td> 

      </tr>
          
      <tr>

        <td width="7%" class="home_menu_link">3)</td>

        <td width="93%" class="home_menu_link"><a href="manage_restaurant_contact_request.php">Manage restaurant contact request</a></td> 

      </tr>    
      <tr>

        <td width="7%" class="home_menu_link">4)</td>

        <td width="93%" class="home_menu_link"><a href="../view_all_restaurant.php">View all restaurants</a></td> 

      </tr>    

    </table></td>
    <td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
	<table width="100%" border="0" cellspacing="2" cellpadding="2">
    
      <tr>
    
        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25"> Manage Rewards </td>
    
      </tr>
    
      <?php /*?><tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="manage_reward_point.php">Manage Reward Points</a></td>
      </tr><?php */?>
      
      <tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="add_reward_point.php">Add Reward Points</a></td>
      </tr>
      
      <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="manage_rewards.php">Manage Reward</a></td>
      </tr>
      
    </table>
	<?php /*?><table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Menu</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_menu_category.php">Add menu category</a></td> 

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_menu_category.php">Manage menu category</a></td> 

      </tr>    
     <tr>

        <td width="7%" class="home_menu_link">3)</td>

        <td width="93%" class="home_menu_link"><a href="add_menu_subcategory.php">Add menu subcategory</a></td> 

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">4)</td>

        <td width="93%" class="home_menu_link"><a href="manage_menu_subcategory.php">Manage menu subcategory</a></td> 

      </tr>    

    </table><?php */?></td>
    <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;"><table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Vendor</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_vendors.php">Add vendor</a></td> 

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_vendors.php">Manage Vendor</a></td> 

      </tr>    
    
    </table></td>
    <td></td>



  </tr> 

  
  
  
  
  <!-- 2nd row start -->
  <tr>

  <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Restaurant User</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_user.php">Add new restaurant</a></td> 

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_user.php">Manage restaurant user</a></td> 

      </tr>
    </table></td>
    <td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Banner</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_banner.php">Add Banner</a></td> 

      </tr>
       <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_banner.php">Manage Banner</a></td> 
        </tr>
    <tr>
    <td width="7%" class="home_menu_link">3)</td>

        <td width="93%" class="home_menu_link"><a href="add_middle_banner.php">Add Middle Banner</a></td> 

      </tr>
       <tr>

        <td width="7%" class="home_menu_link">4)</td>

        <td width="93%" class="home_menu_link"><a href="manage_middle_banner.php">Manage Middle Banner</a></td> 


      </tr>    </table>
    </td>
    <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage CMS Pages</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="manage_cms.php?page_id=1">Manage About Us</a></td> 

      </tr>
       <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="manage_cms.php?page_id=2">Manage Advertisement</a></td> 
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">3)</td>
        <td width="93%" class="home_menu_link"><a href="manage_cms1.php?page_id=3">Manage FAQ</a></td> 
      </tr><tr>
        <td width="7%" class="home_menu_link">4)</td>
        <td width="93%" class="home_menu_link"><a href="manage_cms1.php?page_id=4">Manage Terms and conditions</a></td> 
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">5)</td>
        <td width="93%" class="home_menu_link"><a href="manage_cms1.php?page_id=5">Manage Privacy Policy</a></td> 
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">6)</td>
        <td width="93%" class="home_menu_link"><a href="manage_cms1.php?page_id=6">Manage Career</a></td> 
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">7)</td>
        <td width="93%" class="home_menu_link"><a href="manage_contact.php?page_id=1">Manage Contact Info</a></td> 
      </tr>
       <tr>
        <td width="7%" class="home_menu_link">8)</td>
        <td width="93%" class="home_menu_link"><a href="manage_cms.php?page_id=13">Manage Disclaimer</a></td> 
      </tr>
   
    
    </table>
    </td>
    <td></td>



  </tr>  
  
  
  
  <tr>

  <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Updates</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_updates.php">Add updates</a></td> 

      </tr>
		 <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_updates.php">Manage updates</a></td> 

      </tr>
    </table></td>
    
    <td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;"><table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Featured</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="manage_featured_city.php">Featured City</a></td> 

      </tr>
		  <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_featured_restaurant.php">Featured Restaurant</a></td> 

      </tr>
		
    </table>
    
    </td>
    <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Newsletter</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_newsletter.php">Add Newsletter</a></td> 

      </tr>
      <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="manage_newsletter.php">Manage Newsletter</a></td> 
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">3)</td>
        <td width="93%" class="home_menu_link"><a href="manage_newsletter_users.php">Manage Newsletter Users</a></td> 
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">4)</td>
        <td width="93%" class="home_menu_link"><a href="add_newsletter_image.php">Add Newsletter Image</a></td> 
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">5)</td>
        <td width="93%" class="home_menu_link"><a href="manage_newsletter_image.php">Manage Newsletter Image</a></td> 
      </tr>
      
		
    </table>
    
    </td>
    <td></td>



  </tr>
  
  
  <tr>

  <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Customer</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="manage_customer.php">Manage Customer</a></td> 

      </tr>
		 
    </table></td>
    
    <td width="30%" valign="top" style="border:#404CA1 2px solid;color:#ffffff; text-align: center;font-weight: bold;"><table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Reviews</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="manage_reviews.php">Manage Reviews</a></td> 

      </tr>
		 
    </table>
    
    </td>
    <td width="35%" valign="top" style="color:#ffffff; text-align: center;font-weight: bold; border:#404CA1 2px solid;">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Restaurant Admin</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_restaurant_admin.php">Add Restaurant Admin</a></td> 

      </tr>
      <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_restaurant_admin.php">Manage Restaurant Admin</a></td> 

      </tr>
		 
    </table>
    
    </td>
    <td></td>



  </tr>
  
  <tr>

  <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Contact form subject</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_subject.php">Add Subject</a></td> 

      </tr>
      <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_subject.php">Manage Subject</a></td> 

      </tr>
		 
    </table></td>
    
    <td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Contact category</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_contact_category.php">Add Contact category</a></td> 

      </tr>
      <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_contact_category.php">Manage Contact Category</a></td> 

      </tr>
		 
    </table>
    </td>
    <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Restaurant Add Admin</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="add_restaurant_special_admin.php">Add Restaurant Add Admin</a></td> 

      </tr>
      <tr>

        <td width="7%" class="home_menu_link">2)</td>

        <td width="93%" class="home_menu_link"><a href="manage_restaurant_special_admin.php">Manage Restaurant Add Admin</a></td> 

      </tr>
		 
    </table>
    
    </td>
    <td></td>



  </tr>
  <tr>

  <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Content For Payment Email</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="admin_payment_email.php">Manage Email Content</a></td> 

      </tr>
      
		 
    </table></td>
    <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Social Media</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="manage_social_media.php">Social Media Link</a></td> 

      </tr>
      
		 
    </table></td>
 
    <td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Gift Card</td>

      </tr>

      <tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="manage_giftcard.php">Manage Gift Card</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="manage_cms1.php?page_id=12">Manage Gift Card Content</a></td>
      </tr>
      </table></td>
  </tr>
  
  
  <tr>

<td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Hot Deals</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="manage_hot_deals.php">Manage Hot Deals</a></td> 

      </tr>
      
		 
    </table>
</td>
    <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Blog</td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="https://foodandmenu.com/blog/wp-admin/" target="_blank">Manage Blog</a></td> 
      </tr>
</table>
  </td>
 
    <td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Restaurant Admin Panel</td>

      </tr>

      <tr>
      	<td width="7%" class="home_menu_link">1)</td><td width="93%" class="home_menu_link"><a href="add_restaurant_admin_panel.php">Add Restaurant Admin Panel</a></td>
      </tr>
      <tr>
      	<td width="7%" class="home_menu_link">2)</td><td width="93%" class="home_menu_link"><a href="manage_restaurant_admin_panel.php">Manage Restaurant Admin Panel</a></td>
	  </tr> 
    </table>
  </td>
  </tr> 
  
  
  <tr>

<td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Restaurants Live Orders</td>

      </tr>

      <tr>

        <td width="7%" class="home_menu_link">1)</td>

        <td width="93%" class="home_menu_link"><a href="../manage_all_restaurants.php">Manage Restaurants Live Orders</a></td> 

      </tr>
      
		 
    </table>
</td>
    <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
    	<table width="100%" border="0" cellspacing="2" cellpadding="2">
    
      <tr>
    
        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25"> Import / Export Restaurant Data </td>
    
      </tr>
    
      <tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="../view_restaurants.php">Export To Excel</a></td>
      </tr>
      
      <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="../import_csv_file.php">Import CSV File</a></td>
      </tr>
      
    </table>
    </td>
 <td width="35%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25">Manage Occassions</td>

      </tr>

      <tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="add_occassions.php">Add Occassions</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="manage_occassions.php">Manage Occassions</a></td>
      </tr>
		 
    </table>
</td>
    
  </tr>
  
    <tr>
<td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">

<?php /*?><table width="100%" border="0" cellspacing="2" cellpadding="2">
    
      <tr>
    
        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25"> Manage Rewards </td>
    
      </tr><?php */?>
    
      <?php /*?><tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="manage_reward_point.php">Manage Reward Points</a></td>
      </tr><?php */?>
      
      <?php /*?><tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="add_reward_point.php">Add Reward Points</a></td>
      </tr>
      
      <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="manage_rewards.php">Manage Reward</a></td>
      </tr>
      
    </table><?php */?>
    
    <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25"> Manage Notifications </td>

      </tr>

      <tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="manage_customer_signup.php">Customer Signup Notification</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="manage_customer_edit_profile.php">Customer Edit Profile Notification</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">3)</td>
        <td width="93%" class="home_menu_link"><a href="manage_auto_responder.php?page_id=11">Customer Forgot Password</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">4)</td>
        <td width="93%" class="home_menu_link"><a href="manage_auto_responder.php?page_id=12">Restaurant Admin Forgot Password</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">5)</td>
        <td width="93%" class="home_menu_link"><a href="manage_review_rating.php">Reviews and Rating Notification</a></td>
      </tr>
     
      <tr>
        <td width="7%" class="home_menu_link">6)</td>
        <td width="93%" class="home_menu_link"><a href="manage_vendor_notifications.php">Vendor Notifications</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">7)</td>
        <td width="93%" class="home_menu_link"><a href="manage_reservation_notifications.php">Reservation Notifications</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">8)</td>
        <td width="93%" class="home_menu_link"><a href="manage_rest_confirmation_notifications.php">Restaurant Add Confirmation Notifications</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">9)</td>
        <td width="93%" class="home_menu_link"><a href="manage_gift_certificate_notifications.php">Gift Certificate Notification</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">10)</td>
        <td width="93%" class="home_menu_link"><a href="manage_order_status_notifications.php">Order Status Change Notifications</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">11)</td>
        <td width="93%" class="home_menu_link"><a href="manage_menu_order_notifications.php">Menu Order Notification</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">12)</td>
        <td width="93%" class="home_menu_link"><a href="manage_menu_order_confirmation_notifications.php">Menu Order Confirmation Notification</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">13)</td>
        <td width="93%" class="home_menu_link"><a href="manage_reward_alert_notifications.php">Reward  Alert Notiication</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">14)</td>
        <td width="93%" class="home_menu_link"><a href="manage_auto_responder.php?page_id=42">Notification</a></td>
      </tr>
      
       <tr>
        <td width="7%" class="home_menu_link">15)</td>
        <td width="93%" class="home_menu_link"><a href="manage_contact_notifications.php">Restaurant Contact Notification</a></td>
      </tr>
      
      <tr>
        <td width="7%" class="home_menu_link">16)</td>
        <td width="93%" class="home_menu_link"><a href="manage_auto_responder.php?page_id=46">Group Order Notification</a></td>
      </tr>
    </table>
  </td>

    <td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25"> Manage Home Page Content </td>

      </tr>

      <tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="manage_first_section.php">Manage First Section</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">2)</td>
        <td width="93%" class="home_menu_link"><a href="manage_second_section.php">Manage Second Section</a></td>
      </tr>
      <tr>
        <td width="7%" class="home_menu_link">3)</td>
        <td width="93%" class="home_menu_link"><a href="manage_third_section.php?page_id=11">Manage Third Section</a></td>
      </tr>
      
    </table>
  </td>
 
   <td width="30%" valign="top" style="border:#404CA1 2px solid; color:#ffffff; text-align: center;font-weight: bold;">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">

      <tr>

        <td colspan="2" bgcolor="#404CA1" class="home_submain_heading" height="25"> Manage Search Mile </td>

      </tr>

      <tr>
        <td width="7%" class="home_menu_link">1)</td>
        <td width="93%" class="home_menu_link"><a href="manage_search_mile.php">Manage Search Mile</a></td>
      </tr>
            
    </table>
  </td>
  </tr> 
  
  
  <tr>
  	<td width="35%" valign="top" style="color:#000000; text-align: center;font-weight: bold;"></td>
  </tr> 

</table>            

</div>

<?php

}

require_once"template_admin.php";

