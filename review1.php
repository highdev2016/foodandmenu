<?php

ob_start();

session_start();



//print_r($_SESSION);

include("includes/header_profile.php");

include("includes/functions.php");

//include("search_compete.php");

?>



<body onLoad="init();">

 <?php if($_REQUEST['abuse_status'] == 1){ $display = 'block'; } else { $display = 'none'; }?>  

    <div id="fade" style="display:<?php echo $display; ?>"></div>





<?php include ("includes/top_search.php");?>



<?php include ("includes/menu_section.php");?>

<?php include ("image_file.php");?>



<?php /*?><link rel="stylesheet" href="calender/jquery-ui.css" />

<script src="calender/jquery-1.8.3.js"></script>

<script src="calender/jquery-ui.js"></script>

<script>

$(function() {

	$( "#post_date" ).datepicker({

		dateFormat:"yy-mm-dd"

	});

	//$( "#post_date" ).datepicker( "dd-mm-yy", "dateFormat" );

});

</script><?php */?>



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



<script type="text/javascript" language="javascript">

function display_reviews(rid,sort_order)

{

	//alert(rid +'    '+sort_order);

	location.href="review.php?id="+rid+"&order="+sort_order+"#tab";

	

}

</script>

<script type="application/javascript">
  /*window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '646665315362675',                            
      status     : true,                                 
      xfbml      : true                                  
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/all.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

function FBShareOp(name,id,image,review){
	var customer_name = name;
	var description	   =	review;
	var share_image	   =	'https://foodandmenu.com/thumb_images/'+image;
	var share_url	   =	'https://foodandmenu.com/restaurant.php?id='+id;	
    var share_capt     =    'caption';
    FB.ui({
        method: 'feed',
        name: customer_name,
       link: share_url,
       picture: share_image,
        //caption: share_capt,
       description: description

    }, function(response) {
        if(response && response.post_id){}
        else{}
    });

}*/

</script>

<?php

if($_REQUEST['submit']!="")

{

	if($_FILES['customer_image']['name']!="")

	    {

		$image=$_FILES['customer_image']['name'];

	    $image=time().$image;

		if ((($_FILES["customer_image"]["type"] == "image/gif")

		  || ($_FILES["customer_image"]["type"] == "image/png")

		  || ($_FILES["customer_image"]["type"] == "image/bmp")

		  || ($_FILES["customer_image"]["type"] == "image/jpg")

		  || ($_FILES["customer_image"]["type"] == "image/jpeg")

		  || ($_FILES["customer_image"]["type"] == "image/pjpeg")))

		  

		{

			

		

		$picture_url_thumb="thumb_images/".$image;

			LIB_StoreUploadImg($post_file_name="customer_image"

								,$file_to_copy_path="$picture_url_thumb"

								,$file_to_copy_width="70"

								,$file_to_copy_height="63"

								,$adjust = ''

								,$watermark_gif=''

								,$watermark_position='');

								

		

}

	}

	mysql_query("insert into restaurant_reviews set post_date='".$_REQUEST['post_date']."',customer_name='".$_REQUEST['customer_name']."',customer_review='".$_REQUEST['review']."',customer_picture='".$image."',restaurant_id='".$_REQUEST['restaurant_id']."'");

	

}

?>



<div class="body_section">

<div style="width:400px; height:1px; margin:0 auto; display:<?php echo $display;?>" id="light">

                                              

<div  style="width:300px; position:absolute; z-index:9999999; background:#fff; padding:50px 20px; color:#000; font-family:Calibri; font-size:18px; height:100px; -moz-box-shadow: 0 0 5px #888;

-webkit-box-shadow: 0 0 5px#888;

box-shadow: 0 0 5px #888; text-align:center;">

<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><img src="images/fancy_closebox.png" style=" margin-left: 259px;

    position: absolute;

    margin-top: -60px; cursor:pointer;"/></a>

                    Your request is sent to Admin

                    </div>

                    </div>

    <div class="body_container">

        <div class="body_top"></div>

        <div class="main_body">

            <div class="food_body_cont">

                <div class="food_content">

                    <!--<div class="food_cont_top">

                    	<h1>Home</h1>

                    </div>-->

                    

                    <?php include("includes/restaurant_top.php");?>

                    

                    <div class="accr_menu" id="tab">

                        <?php include('includes/tab_menu.php');?>

                        </div>

                    <div class="clear"></div>

					<div class="accr_details">

       <?php

	   $total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$_REQUEST['id']."' AND status=1"));


	   $get_cust_id = mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$_REQUEST['id']."' AND status=1");

	   ?>           
       
       
       
       
       
       
         

                        <?php
						$sql = "SELECT rr.id,rr.post_date,rr.customer_name,rr.customer_email,rr.customer_picture, rr.customer_review,rr.restaurant_id, rr.customer_id , rr.restaurant_name , rr.like , rr.dislike ,  rrat.rating_id ,  rrat.rating_id FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['id']."' AND rrat.restaurant_id='".$_REQUEST['id']."' AND rr.status=1 AND rr.review_status = 0 ORDER BY rr.post_date DESC limit 0,3";
						
						$sql_review = mysql_query($sql);

						$num_review=mysql_num_rows($sql_review);
						
						if($num_review>0)
						{
							$counter = 0;
							while($res_review=mysql_fetch_array($sql_review))
							{
								$rev_count = mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews as rr,restaurant_rating as rrat WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['id']."' AND rrat.restaurant_id='".$_REQUEST['id']."' AND rr.status=1 AND rr.customer_id = '".$res_review['customer_id']."' ORDER BY rr.id DESC"));
								$customerInfo = customerInfo($res_review['customer_id']);
								
								
								$rating = getSingleReviewRating($_REQUEST['id'],$res_review['id']);
								
								$sql_updated_review = mysql_query("SELECT * 

								FROM restaurant_reviews as rr,restaurant_rating as rrat 

								WHERE rr.id = rrat.review_id AND rr.restaurant_id='".$_REQUEST['id']."' AND rrat.restaurant_id='".$_REQUEST['id']."' AND rr.status=1 AND rr.review_status = 1 AND parent_id = '".$res_review['id']."' ORDER BY rr.id DESC");
								 

						?>

                      <div class="review_detail sm-right-review">

                      	

                        <div class="arrow_review"><img src="images/arrow_review.jpg" alt="" /></div>
                        
                                    <div class="review_txt">
                                    
                                   <?php 
								   $iinc = 1;

								   while($row_updated_review = mysql_fetch_array($sql_updated_review))

								   { 

								   

									   $rating_updated = getSingleReviewRating($row_updated_review['restaurant_id'],$row_updated_review['id']);

									   

									   $sql_prev_check = mysql_num_rows(mysql_query("SELECT id FROM restaurant_reviews WHERE parent_id = '".$res_review['id']."'"));

									   

									   if($iinc == 2){

											  $prev_rev_stat = 'Previous Review';

									   }else{

										      $prev_rev_stat = '';

									   }

									   

									   ?>

                                       

                                       

                                       

                                       <div id="updated_reviews" class="separetor" style="margin-bottom:50px;">

                                       <div class="rating_content rviw">

		                                    <ul>

		                                    	<?php

												$rem = 5 - $rating_updated;

												if($rating_updated > 0)

												{

													for($i=0; $i<$rating_updated;$i++){

												?>

		                                        <li><img width="16" height="16" src="images/star-1.png"></li>

		                                        <?php

													}

													for($j=0;$j<$rem;$j++){

												?>

		                                        <li><img width="16" height="15" src="images/star-3.png"></li>

		                                        <?php

													}

												}

												else{

										?>

		                                 		<li><div style="width:165px;">&nbsp;</div></li>

		

		                                        <?php

												}

												if($rating_updated > 0)

												{

												?>

		                                        <li><?php echo change_dateformat_reverse($row_updated_review['post_date']); ?></li>

		                                        <?php

												}else{

												?>

		                                         <li>&nbsp;</li>

		                                        <?php

												}

												?>

												

												

		                                	</ul>

		                              <?php echo $customerInfo['firstname']." ".$customerInfo['lastname']; ?>     

		                                   

		                                   

		                                    <?php 

									

									$sql_upd_rev = mysql_fetch_array(mysql_query("SELECT id FROM restaurant_reviews WHERE parent_id = '".$res_review['id']."' ORDER BY id DESC"));

									

									if($row_updated_review['id'] == $sql_upd_rev['id'])

									{

										$upd_status = "Updated Review";

									}

									else

									{

										$upd_status = "";

									}

									 ?>	

		                                   

		                                   <span class="status-review"><!-- <a href=""> --> <?php if($upd_status != '') { ?><img src="../images/refesh-org.png" align="absmiddle"  width="14px" /> <?php } ?><!-- </a> --><?php echo $prev_rev_stat; ?> <?php echo $upd_status; ?> </span> 

		                                </div>   
                                        
                                      <div class="clear"></div>


									    <p class="review-con"><?php echo $row_updated_review['customer_review']?></p>


                                       <?php $sql_owners_comment = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$row_updated_review['id']."'"));

									   if(!empty($sql_owners_comment)){

									   $sql_rest_owner = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment['restaurant_owner_id']."'"));?>

                                     <div class="next-review">

                                       <div class="next-review-head">

                                       <p><strong>Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$row_updated_review['restaurant_id']);?></strong></p>

                                       </div>

                                       <label><?php echo date("m-d-Y", strtotime($sql_owners_comment['post_date']));?>  -  <?php echo "Hi ".$row_updated_review['customer_name']; ?>,</label>

                                       <div class="next-review-cont"><?php echo $sql_owners_comment['comment']; ?></div>

                                       <div class="clear"></div>

                                      </div>

                                       <?php } ?>

                                       

                                        <div class="clear"></div>

                                     </div> 

                                     

                                   <?php

								  

								   $iinc++;

								   }?>

                                   

                                   

                                   

                                    

                                 <div class="rating_content rviw">

                                    <ul>

                                    	<?php

										$rem = 5 - $rating;

										if($rating > 0)

										{

											for($i=0; $i<$rating;$i++){

										?>

                                        <li><img width="16" height="16" src="images/star-1.png"></li>

                                        <?php

											}

											for($j=0;$j<$rem;$j++){

										?>

                                        <li><img width="16" height="15" src="images/star-3.png"></li>

                                        <?php

											}

										}

										else{

								?>

                                 <li><div style="width:165px;">&nbsp;</div></li>



                                        <?php

										}

										if($rating > 0)

										{

										?>

                                        <li><?php echo change_dateformat_reverse($res_review['post_date']); ?></li>

                                        <?php

										}else{

										?>

                                         <li>&nbsp;</li>

                                        <?php

										}

										?>

										

										

                                	</ul>

                                	

                                	 <?php
									

									if($rev_count == 2) 

									{ 

										$prev_status = "Previous Review"; 

									}

									else

									{

										$prev_status = '';

									}

									?>

                                	

                                		<span class="status-review"> <?php echo $prev_status; ?> <!-- <a href=""> <img width="14px" align="absmiddle" src="../images/refesh-org.png"></a>--> </span>

                                    

                                </div>   



                                    
                                       <div class="clear"></div> 
                                       

                                        <p class="review-con">     <?php echo $res_review['customer_review']?></p>

                                       
                                       

                                <?php $sql_owners_comment1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_rev_owners_comment WHERE review_id = '".$res_review['id']."'"));

							   if(!empty($sql_owners_comment1)){

							   $sql_rest_owner1 = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_users WHERE ID = '".$sql_owners_comment1['restaurant_owner_id']."'"));?>

                               <div class="next-review">

							    <div class="next-review-head">

								   <p><strong>Comment From <?php echo getNameTable("restaurant_basic_info","restaurant_name","id",$res_review['restaurant_id']);?></strong></p>

								 </div>  

							   <label><?php echo date("m-d-Y", strtotime($sql_owners_comment1['post_date']));?>  -  <?php echo "Hi ".$res_review['customer_name']; ?></label>

							   <div class="next-review-cont"><?php echo $sql_owners_comment1['comment']; ?></div>

							   </div>

							   <?php } ?>

                                 

                                 

                                 

                                  <div class="clear"></div>

                                   </div>  

                                     <div class="clear"></div>

                                </div>

                               <div class="clear"></div>

                               <?php

							   $counter++;

							}

						}else{?>

                         <div class="review_detail"><h2 style="background-color: #FFFFFF;color: #E46002;font: 24px 'Lobster Two';margin-left: 25px;padding: 0 1px;">No reviews yet</h2></div>

                        <?php

						}

						?>

                           

                           

                           <div class="heading_txt2 heading_txt_nw">

                

                        <a href="write_review.php?id=<?php echo $_REQUEST['id'];?>">Write a Review</a>

                        

                        </div>

                        

                        <div class="clear"></div>   

                              

                    </div>

                </div>

            	<div class="clear"></div>

            	<div class="tab_body_cont"></div>

            </div> 

        

       

       <div class="body_footer_bg"></div>

        <div class="clear"></div>

    </div>

</div>

<div class="clear"></div>

<script type="text/javascript">

function fbpublishreview(msg,address,pict) {

	var publish = {

		method: 'stream.publish',

		display: 'popup',

		name: 'FOOD AND MENU',

		picture: 'https://foodandmenu.com/thumb_images/'+pict,

		caption: '',

		description: (

			'<b>'+msg+'</b><center></center>'+address+'<center></center>'

		),

		href: 'https://foodandmenu.com/'

	};

	FB.ui(publish);

}

</script>

<script type="text/javascript">

function like_unlike_alert(msg){

	if(confirm(msg + '\n\tYou want to login?')){

		top.location.href = "login.php?rev=1";

	}

}

</script>



<script type="text/javascript" src="javascript/prototype.js"></script>

	<script type="text/javascript" src="javascript/effects.js"></script>

	<script type="text/javascript" src="javascript/accordion.js"></script>

	<script type="text/javascript" src="javascript/code_highlighter.js"></script>

	<script type="text/javascript" src="javascript/javascript.js"></script>

	<script type="text/javascript" src="javascript/html.js"></script>

 <script type="text/javascript">

		jQuery(document).ready(function() {

			



			jQuery(".various1").fancybox({

				'titlePosition'		: 'inside',

				'transitionIn'		: 'none',

				'transitionOut'		: 'none'

			});

			

			jQuery("#various2").fancybox({

				'titlePosition'		: 'inside',

				'transitionIn'		: 'none',

				'transitionOut'		: 'none'

			});



			jQuery("#various2").fancybox();



			jQuery("#various3").fancybox({

				'titlePosition'		: 'inside',

				'transitionIn'		: 'none',

				'transitionOut'		: 'none'

			});



			jQuery("#various4").fancybox({

				'padding'			: 0,

				'autoScale'			: false,

				'transitionIn'		: 'none',

				'transitionOut'		: 'none'

			});

			

			jQuery("#various5").fancybox({

				'padding'			: 0,

				'autoScale'			: false,

				'transitionIn'		: 'none',

				'transitionOut'		: 'none'

			});

			

			jQuery(".various6").fancybox({

				'padding'			: 0,

				'autoScale'			: false,

				'transitionIn'		: 'none',

				'transitionOut'		: 'none'

			});

			

			jQuery("#various7").fancybox({

				'padding'			: 0,

				'autoScale'			: false,

				'transitionIn'		: 'none',

				'transitionOut'		: 'none'

			});

		});

	</script>

    

<script type="text/javascript" src="js/jquery-ui.js"></script>

<?php /*?><script type="text/javascript">

jQuery(function() {

	jQuery( "input[name=post_date_test]" ).datepicker({

		dateFormat:"mm-dd-yy"

	});

	

	

});

</script><?php */?>

	

  <link rel="stylesheet" href="calender/jquery-ui.css" />  

	

<?php include("includes/footer.php");?>