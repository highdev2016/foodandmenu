<?php
ob_start();
session_start();
//print_r($_SESSION);
include ("admin/lib/conn.php");
//$sql_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_SESSION['restaurant_id']."'"));

$sql_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE user_id = '".$_SESSION['restaurant_id']."'"));

$sql_basic = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE user_id = '".$_SESSION['restaurant_id']."'"));

if(isset($_REQUEST['submit'])){
	
	$sql_update_basic_info = mysql_query("UPDATE restaurant_basic_info SET status = 1 WHERE id = '".$sql_basic_info['id']."'");
		
	$sql_update_business = mysql_query("UPDATE restaurant_business_delivery_takeout_info SET status = 1 WHERE restaurant_id = '".$sql_basic_info['id']."'");
	$sql_update_services = mysql_query("UPDATE restaurant_services_dress_payment SET status = 1 WHERE restaurant_id = '".$sql_basic_info['id']."'");
	$sql_update_menu = mysql_query("UPDATE restaurant_menu_item SET status = 1 WHERE restaurant_id = '".$sql_basic_info['id']."'");
	
	$sql_extra_business_hours = mysql_query("UPDATE restaurant_extra_business_hours SET status = 1 WHERE restaurant_id = '".$sql_basic_info['id']."'");
	
	$sql_select = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_admin WHERE id = 1"));
	
	$restaurant_name = $sql_basic['restaurant_name'];
	$restaurant_address = $sql_basic['restaurant_address'];
	$restaurant_city = $sql_basic['restaurant_city'];
	$restaurant_state = $sql_basic['restaurant_state'];
	$restaurant_zipcode = $sql_basic['restaurant_zipcode'];
	$display_name = $sql_res_owner['display_name'];
		
	
	/********************************************** Admin **********************************************/
				
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 21"));
	
	$admin_email_address = $sql_cms['email_address'];
	
	$arr_email_address = explode(",",$admin_email_address);
	
	$email=$sql_select['email_id'];//"priya@infosolz.com"
	
	/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; padding:0 0px; ">
    					  <img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px; " />
    					  <div style="height:15px; background-color:#3F4CA0;"></div>
       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello Admin,</p>
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">A new restaurant is added to Food & menu</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Details of new added Restaurant :</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant Name :'.$sql_basic['restaurant_name'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant Address :'.$sql_basic['restaurant_address'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant City :'.$sql_basic['restaurant_city'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant State :'.$sql_basic['restaurant_state'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant Zipcode :'.$sql_basic['restaurant_zipcode'].'</p>

             			<div style="clear:both;"></div>

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
		
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_address,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_city%%',$restaurant_city,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_state%%',$restaurant_state,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_zipcode%%',$restaurant_zipcode,$cms_rep);	
	
	$res_email = (explode(",",$sql_basic['email']));
	
	$from = $res_email[0];
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	/*$subject="New restaurant added";*/
	
	$subject = stripslashes($sql_cms['subject']);
	
	//mail($email,$subject,$message,$headers);
	
	foreach($arr_email_address as $val_email){
		mail($val_email,$subject,$message,$headers);
	}

	
	
	
	/********************************************** Restaurant Owner **********************************************/
	if($_SESSION['admin_id']!="")
	{
	 $sql_res_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE ID = '".$_SESSION['rest_id']."'"));
	 $res_email = (explode(",",$sql_res_owner['email']));
	 $email = $res_email[0]; //"priya@infosolz.com"
	}else{
	$sql_res_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$_SESSION['restaurant_id']."'"));
	$email=$sql_res_owner['user_email']; //"priya@infosolz.com"
	}	
	/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; padding:0 0px; ">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0 10px 10px; " />
						<div style="height:15px; background-color:#3F4CA0;"></div>

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello '.$sql_res_owner['display_name'].',</p>
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Your restaurant is added to Food & menu</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Details of your Restaurant :</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant Name :'.$sql_basic['restaurant_name'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant Address :'.$sql_basic['restaurant_address'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant City :'.$sql_basic['restaurant_city'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant State :'.$sql_basic['restaurant_state'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Restaurant Zipcode :'.$sql_basic['restaurant_zipcode'].'</p>

             			<div style="clear:both;"></div>

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
	
	$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 21"));	
	
	$cms_rep = htmlspecialchars_decode(stripslashes($sql_cms['description']));
	
	$cms_rep=str_replace('%%$display_name%%',$display_name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_address%%',$restaurant_address,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_city%%',$restaurant_city,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_state%%',$restaurant_state,$cms_rep);
	$cms_rep=str_replace('%%$restaurant_zipcode%%',$restaurant_zipcode,$cms_rep);
	
	$from = $sql_select['email_id'];
	
	$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";
	
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 
	
	$message=$cms_rep;
	
	//$subject="Restaurant added";
	
	$subject = stripslashes($sql_cms['subject']);
	
	mail($email,$subject,$message,$headers);
	header("location:add_restaurant.php");
}
?>
<?php include ("image_file.php");?>

<body>

<?php include ("includes/header_confirmation.php");?>

<?php include ("includes/menu_res_add_user.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="confirmation_body_cont confirmation_bdy_cnt2">

<div class="restaurant_cont_top">
<h1>Add New Restaurant</h1>
</div>

<div class="restaurant_nav">
                    
                    
                    <ul>
                    <li><a href="add_restaurant.php">Basic Info</a></li>
                    <li><a href="additional.php">Additional Info</a></li>
                    <li><a href="restaurant_menu.php">Menu</a></li>
                    <li><a href="multimedia.php">Multimedia</a></li>
                    <li><a href="special_offer.php" >Special Offer</a></li>
                    <li><a href="confirmation.php" class="active7">Confirmation</a></li>
                    
                    
                    
                    </ul>
                    
                    </div>

<div class="restaurant_cont_field">

<div id="vertical_container" >
<?php if($_REQUEST['success']==1){?>
<p class="new1" style="text-align:center;">Restaurant details confirmed successfully</p>
<?php } ?>
                       <?php  
					   $sql_basic_info = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE user_id = '".$_SESSION['restaurant_id']."'")); 
?>
                            <h1 class="accordion_toggle">Basic Info</h1>
                            <div class="accordion_content2">   
                                <!--<div class="light_box_cam"><h2>Knife and Fork Caesar</h2>
                                                                                                
                              </div>-->
                                <div class="clear"></div>
                                <div class="multimedia_form_field">

            <p>Name : </p>
            
            <h2><?php echo $sql_basic_info['name'];?></h2>
            
            <div class="clear"></div>
            
            <p>Phone No :</p>
            
            <h2><?php echo $sql_basic_info['phone'];?></h2>
            
            <div class="clear"></div>
            
            <p>Fax No :</p>
            
            <h2><?php echo $sql_basic_info['fax'];?></h2>
            
            <div class="clear"></div>
            
            <p>Email Address :</p>
            
            <h2><?php echo $sql_basic_info['email'];?></h2>
            
            <div class="clear"></div>
            
            <p>Website :</p>
            
            <h2><?php echo $sql_basic_info['website'];?></h2>
            
            <div class="clear"></div>
            
            </div>

        <div class="multimedia_form_field">
        
                        <p>Restaurant Name :</p>
                        
                        <h2><?php echo $sql_basic_info['restaurant_name'];?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Address :</p>
                        
                        <h2><?php echo $sql_basic_info['restaurant_address'];?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>City :</p>
                        
                        <h2><?php echo $sql_basic_info['restaurant_city'];?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>State :</p>
                        
                        <h2><?php echo $sql_basic_info['restaurant_state'];?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Zip Code :</p>
                        
                        <h2><?php echo $sql_basic_info['restaurant_zipcode'];?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Country :</p>
                        
                        <h2><?php echo $sql_basic_info['restaurant_country'];?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Restaurant Categories :</p>
                        
                        <h2 style="float:none !important;"><?php $sql_select_res_category = mysql_query("SELECT * FROM restaurant_category WHERE id IN (".$sql_basic_info['restaurant_category'].")");			
			//echo $sql_select_res_category['category_name'];
			$category_sep="";
			while($result_restaurant_category=mysql_fetch_array($sql_select_res_category))
											 {
					$all_category.=$category_sep.$result_restaurant_category['category_name'];
					$category_sep=", ";
											 }
											 echo $all_category;
			?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Picture :</p>
                        
                        <h2><?php if($sql_basic_info['restaurant_image']!=''){?><img src="thumb_images/<?php echo $sql_basic_info['restaurant_image'];?>" height="50" width="50" style="padding-bottom:5px;"><?php } else { ?>
                        <img src="images/no_image.png" height="50" width="50" style="padding-bottom:5px;">
                        <?php } ?></h2>
                        
                        <div class="clear"></div>
        
        </div>

<div class="clear"></div>
                                                       
                            </div>
                            
                            <h1 class="accordion_toggle">Additional Info</h1>
                            <div class="accordion_content2"> 
                            
                              
                                <?php $sql_business = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$sql_basic_info['id']."'"));?>
                                <div class="clear"></div> 
                                
                                <div class="multimedia_form_field">

                        <h1>Business Open Hours -</h1>
                        
                        <div class="clear"></div>
                        <?php if($sql_business['business_hours_mon']!=''){?>
                        <p>Business Hours Monday :</p>
                        <h2> <?php echo $sql_business['business_hours_mon']; ?></h2>
                        <div class="clear"></div>
                        <?php } ?>
                        <?php if($sql_business['business_hours_tue']!=''){?>
                        <p>Business Hours Tuesday :</p>
                        <h2> <?php echo $sql_business['business_hours_tue']; ?></h2>
                        <div class="clear"></div>
                        <?php } ?>
                        <?php if($sql_business['business_hours_wed']!=''){?>
                        <p>Business Hours Wednesday :</p>
                        <h2> <?php echo $sql_business['business_hours_wed']; ?></h2>
                        <div class="clear"></div>
                        <?php } ?>
                        <?php if($sql_business['business_hours_thu']!=''){?>
                        <p>Business Hours Thursday :</p>
                        <h2> <?php echo $sql_business['business_hours_thu']; ?></h2>
                        <div class="clear"></div>
                        <?php } ?>
                        <?php if($sql_business['business_hours_fri']!=''){?>
                        <p>Business Hours Friday :</p>
                        <h2> <?php echo $sql_business['business_hours_fri']; ?></h2>
                        <div class="clear"></div>
                        <?php } ?>
                        <?php if($sql_business['business_hours_sat']!=''){?>
                        <p>Business Hours Saturday :</p>
                        <h2> <?php echo $sql_business['business_hours_sat']; ?></h2>
                        <div class="clear"></div>
                        <?php } ?>
                        
                        <p>Holidays :</p>
                        
                        <h2><?php echo $sql_business['holidays']; ?></h2>
                        
                        <div class="clear"></div>
                        <?php 
						$sql_business_extra_hours = mysql_query("SELECT * FROM restaurant_extra_business_hours WHERE restaurant_id = '".$sql_basic_info['id']."'");
						if(mysql_num_rows($sql_business_extra_hours)>0){?>
                        <h1>Other Business Hours -</h1>
                        <?php 
						while($array_business_hrs = mysql_fetch_array($sql_business_extra_hours)){?>
                        <p><?php echo $array_business_hrs['title']; ?> :</p>
                        <h2> <?php echo $array_business_hrs['hours']; ?></h2>
                        <div class="clear"></div>
                        <?php } } ?>
                        
                        
                        <h1>Delivery Details -</h1>
                        
                        <div class="clear"></div>
                        
                        <p>Delivery :</p>
                        
                        <h2><?php if($sql_business['delivery'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
                        
                        <div class="clear"></div>
                        <?php if($sql_business['delivery']==1){?>
                        <p>Minimum Amount :</p>
                        
                        <h2><?php echo $sql_business['minimum_ammount']; ?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Delivery Charge :</p>
                        
                        <h2><?php echo $sql_business['delivery_charge']; ?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Delivery Range :</p>
                        
                        <h2><?php echo $sql_business['delivery_range']; ?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Delivery Hours :</p>
                        
                        <h2><?php echo $sql_business['delivery_hours']; ?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Estimate Delivery Time :</p>
                        
                        <h2><?php echo $sql_business['delivery_estimated_time']; ?></h2>
                        
                        <div class="clear"></div>
                        <?php } ?>
                        <h1>Take Out Details -</h1>
                        
                        <div class="clear"></div>
                        
                        <p>Pick Up :</p>
                        
                        <h2><?php if($sql_business['pickup'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
                        
                        <div class="clear"></div>
                        
                        <p>Drive-Thru :</p>
                        
                        <h2><?php if($sql_business['drive_thru'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
                        
                        <div class="clear"></div>
                        
                        </div>
<?php $sql_cat_service = mysql_fetch_array(mysql_query("SELECT * FROM  restaurant_services_dress_payment WHERE restaurant_id = '".$sql_basic_info['id']."'"));?>
<div class="multimedia_form_field">

        <h1>Services -</h1>
        
        <div class="clear"></div>
        
        <p>Catering Service :</p>
        
        <h2><?php if($sql_cat_service['catering_service'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Self Service :</p>
        
        <h2><?php if($sql_cat_service['self_service'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Waiter Service :</p>
        
        <h2><?php if($sql_cat_service['waiter_service'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Kid Friendly :</p>
        
        <h2><?php if($sql_cat_service['kid_friendly'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Handicape :</p>
        
        <h2><?php if($sql_cat_service['handicape'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Outdoor Seating :</p>
        
        <h2><?php if($sql_cat_service['outdoor_seating'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Alcohol :</p>
        
        <h2><?php if($sql_cat_service['alchohol'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Bar Seating :</p>
        
        <h2><?php if($sql_cat_service['bar_seating'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Wi-Fi :</p>
        
        <h2><?php if($sql_cat_service['wi_fi'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <p>Live Music :</p>
        
        <h2><?php if($sql_cat_service['live_music'] == 1){ echo "Yes"; } else { echo "No"; } ?></h2>
        
        <div class="clear"></div>
        
        <h1>Dress Code -</h1>
        
        <div class="clear"></div>
        
        <p>Dress Code</p>
        
        <h2><?php echo $sql_cat_service['dress_code'];?></h2>
        
        <div class="clear"></div>
        
        <h1>Payment Method -</h1>
        
        <div class="clear"></div>
        
        <div class="payment_left">
        
        <p>Payment Method</p>
        
        <h2><?php echo $sql_cat_service['payment_method'];?></h2>
        
        </div>
        
        <div class="clear"></div>

</div>                
                             
                            </div>
                            
                            <h1 class="accordion_toggle">Menu</h1>
                            
                         <?php /*?>   <?php $sql_select_menu = mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '".$sql_basic_info['id']."'");
							if(mysql_num_rows($sql_select_menu)>0){
							while($array_menu = mysql_fetch_array($sql_select_menu)){?>
                            <div class="accordion_content2"> 
                            
                            
                            <div class="multimedia_form_field">

        <div class="clear"></div>
        
        <p>Main Category :</p>
        
        <h2><?php $sql_select_category = mysql_fetch_array
(mysql_query("SELECT * FROM restaurant_category WHERE  	id = '".$array_menu['category_id']."'"));
echo $sql_select_category['category_name'];?></h2>
        
        <div class="clear"></div>
        
        <p>Sub Category :</p>
        
        <h2><?php $sql_select_category = mysql_fetch_array
(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE  	id = '".$array_menu['sub_category_id']."'"));
echo $sql_select_category['subcategory_name'];?></h2>
        
        <div class="clear"></div>
        
        <p>Menu Items Name :</p>
        
        <h2><?php echo $array_menu['menu_name'];?></h2>
        
        <div class="clear"></div>
        
        
        </div>
        
        <div class="multimedia_form_field">
        
                <p>Menu Price :</p>
                
                <h2><?php echo $array_menu['price'];?></h2>
                
                <div class="clear"></div>
                
                <p>Menu Description :</p>
                
                <h2><?php echo $array_menu['description'];?></h2>
                
                <div class="clear"></div>
                
                <p>Menu Picture :</p>
                
                <h2><img src="thumb_images/<?php echo $array_menu['menu_pic']; ?>" height="50" width="50" style="padding-bottom:5px;"></h2>
                
                <div class="clear"></div>
        
        </div>
                            
                           <div class="clear"></div> 
                            </div>
                            <?php } } else{ ?>
                            <div class="accordion_content2"> 
                            <p>No menu items added</p></div>
                            <?php } ?><?php */?>
                            <div class="accordion_content2"> 
                            <?php $sql_select_menu = mysql_query("SELECT * FROM restaurant_menu_item WHERE restaurant_id = '".$sql_basic_info['id']."'");
							if(mysql_num_rows($sql_select_menu)>0){
							while($array_menu = mysql_fetch_array($sql_select_menu)){?>
                            
                         <div class="multimedia_form_field">

        <div class="clear"></div>
        
        <p>Main Category :</p>
        
        <h2><?php $sql_select_category = mysql_fetch_array
(mysql_query("SELECT * FROM restaurant_menu_category WHERE  	id = '".$array_menu['category_id']."'"));
echo $sql_select_category['category_name'];?></h2>
        
        <div class="clear"></div>
        
        <p>Sub Category :</p>
        
        <h2><?php $sql_select_category = mysql_fetch_array
(mysql_query("SELECT * FROM restaurant_menu_subcategory WHERE  	id = '".$array_menu['sub_category_id']."'"));
echo $sql_select_category['subcategory_name'];?></h2>
        
        <div class="clear"></div>
        
        <p>Menu Items Name :</p>
        
        <h2><?php echo $array_menu['menu_name'];?></h2>
        
        <div class="clear"></div>
        
        
        </div>
        
        <div class="multimedia_form_field">
        
                <p>Menu Price :</p>
                
                <h2><?php if($array_menu['price']!=''){ echo "$ ".$array_menu['price']; } ?></h2>
                
                <div class="clear"></div>
                
                <p>Menu Description :</p>
                
                <h2><?php echo $array_menu['description'];?></h2>
                
                <div class="clear"></div>
                
                <p>Menu Picture :</p>
                
                <h2><?php if($array_menu['menu_pic']!=''){?><img src="thumb_images/<?php echo $array_menu['menu_pic']; ?>" height="50" width="50" style="padding-bottom:5px;"><?php } else { ?>
                <img src="images/no_image.png" height="50" width="50" style="padding-bottom:5px;">
                <?php } ?></h2>
                
                <div class="clear"></div>
        
        </div>
        					<?php } } else{ ?>
        					
                            <p>No menu items added</p>
                            <?php } ?>
        					
        
        					
        
                            
                           <div class="clear"></div> 
                            </div>
                            
                                           
                        </div>
                        <form name="frm" method="post" action="">
                        <input class="multimedia_button" type="submit" value="Confirm" name="submit">
                        </form>
                        

<div class="clear"></div>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

