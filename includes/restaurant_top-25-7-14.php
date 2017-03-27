<?php
//session_start();
//print_r($_SESSI0N);
ob_start();

if(isset($_SESSION['page_type']))
{
	unset($_SESSION['page_type']);
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

if($_REQUEST['command']=='add'){
	if($_REQUEST['deals']>0){
		
	if(isset($_SESSION['customer_id'])){
		//echo $_REQUEST['deals']."<br>";
		//echo $_REQUEST['deals_qty']."<br>";
		//exit();
	$pid = $_REQUEST['deals']; // deals id
	$qty = $_REQUEST['deals_qty'];
	addtocart($pid,$qty);
	//print_r($_SESSION['cart']);
	header("location:cart.php");
	exit(); }
	else{
		$_SESSION['page_type']='restaurant';
		$_SESSION['redirect']=$_SERVER['REQUEST_URI'];
		header("location:login.php");
		$_SESSION['resttid'] = $_REQUEST['id'];
		$_SESSION['deal_id'] = $_REQUEST['deal_id'];
		exit();
	}
	}
	else{
		$deal_error = 1;
	}
}


if($_REQUEST['submit'] == 'Submit'){
	
if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['captcha_code']) != 0)
	{  
		//$msg1 = "The Validation code does not match!";
		header("location:profile.php?id=".$_REQUEST['profile_id'].'&status=error');

	}
	else{
		
			$sql_username = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));
			$sql_res_name = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));
			
			$custo_name = $sql_username['firstname']." ".$sql_username['lastname'];
			//$post_date=date('d-m-Y');
			
			$post_date=$_REQUEST['post_date_test']; 
			
			$month = substr($post_date,0,2);
			$date  = substr($post_date,3,2);
			$year  = substr($post_date,6,4);
			
			$posted_date = $year."-".$month."-".$date;
			
			$time=$_POST['time'];
			$how_many_people=$_POST['how_many_people'];
			$special_occasions=$_POST['special_occasions'];
            $contact_email=$_POST['contact_email'];
			$comments=$_POST['comments'];
			$username = $sql_username['firstname'].' '.$sql_username['lastname'];
			$restaurant_name = $sql_res_name['restaurant_name'];
			
			$sql_reservation = mysql_query("INSERT INTO restaurant_reservations SET restaurant_id = '".$_REQUEST['id']."', restaurant_name = '".$sql_res_name['restaurant_name']."' , date = '".$posted_date."',time = '".$time."' , people = '".$how_many_people."', special_occassion = '".$special_occasions."' , contact_email = '".$contact_email."', comments = '".$comments."', customer_id = '".$_SESSION['customer_id']."' , customer_name = '".$custo_name."'");
			
			/************************************************** Admin ************************************/
				
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 16"));
			
			$admin_email_address = $sql_cms1['email_address'];
			
			$arr_email_address = explode(",",$admin_email_address);
				
			//$email = 'support@foodandmenu.com';//"priya@infosolz.com"
			
			/*$cms_rep = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; height:110px;padding:0 30px; border-bottom:15px solid #3F4CA0;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />

       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
								Hello Admin,</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
								User Reservation Details are as follows.</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
								Name : '.$sql_username['firstname'].' '.$sql_username['lastname'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
								Date : '.$post_date.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
								Time : '.$time.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
								How many People :'.$how_many_people.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
								Special Ocassions : '.$special_occasions.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">
								Comments : '.$comments.'</p>
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
			
			$cms_rep=str_replace('%%$username%%',$username,$cms_rep);
			$cms_rep=str_replace('%%$post_date%%',$post_date,$cms_rep);
			$cms_rep=str_replace('%%$time%%',$time,$cms_rep);
			$cms_rep=str_replace('%%$how_many_people%%',$how_many_people,$cms_rep);
			$cms_rep=str_replace('%%$special_occasions%%',$special_occasions,$cms_rep);
			$cms_rep=str_replace('%%$comments%%',$comments,$cms_rep);	
			
			$from = $contact_email;

			$headers = "From:".$from."\nReply-To: ".$from."\nReturn-Path: ".$from."\nX-Mailer: PHP\n";

			$headers .= 'MIME-Version: 1.0' . "\r\n";

			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message=$cms_rep;

			//$subject="Reservation Request";
			
			$subject = stripslashes($sql_cms['subject']);

			//mail($email,$subject,$message,$headers);
			
			foreach($arr_email_address as $val_email){
				mail($val_email,$subject,$message,$headers);
			}
			
			
			/******************************************** Customer **************************************/
			
			/*$cms_rep1 = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; padding:0 0px">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />
                         <div style="height:15px; background-color:#3F4CA0;"></div>
       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello ,'.$sql_username['firstname'].'</p>

            				
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Thanks for the resevation at '.$sql_res_name['restaurant_name'].'</p>
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Information about the reservation</p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Date : '.$post_date.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Time : '.$time.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">How many People : '.$how_many_people.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Special Ocassions : '.$special_occasions.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Contact Email : '.$_REQUEST['contact_email'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Comments : '.$comments.'</p><br>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">You will get an email once your reservation has been confirmed ! Thanks </p>
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
				
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 17"));	
			
			$cms_rep1 = htmlspecialchars_decode(stripslashes($sql_cms['description']));
			
			$cms_rep1=str_replace('%%$username%%',$username,$cms_rep1);
			$cms_rep1=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep1);
			$cms_rep1=str_replace('%%$post_date%%',$post_date,$cms_rep1);
			$cms_rep1=str_replace('%%$time%%',$time,$cms_rep1);
			$cms_rep1=str_replace('%%$how_many_people%%',$how_many_people,$cms_rep1);
			$cms_rep1=str_replace('%%$special_occasions%%',$special_occasions,$cms_rep1);
			$cms_rep1=str_replace('%%$contact_email%%',$contact_email,$cms_rep1);
			$cms_rep1=str_replace('%%$comments%%',$comments,$cms_rep1);	

			$from1 = "support@foodandmenu.com";

			$headers1 = "From:".$from1."\nReply-To: ".$from1."\nReturn-Path: ".$from1."\nX-Mailer: PHP\n";

			$headers1 .= 'MIME-Version: 1.0' . "\r\n";

			$headers1 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message1=$cms_rep1;

			//$subject1="Reservation Confirmation mail";
			
			$subject1 = stripslashes($sql_cms['subject']);

			mail($contact_email,$subject1,$message1,$headers1);
			
			
			/***************************************** Restaurant Owner **********************************/
			
			/*$cms_rep2 = '<div style="width:100%;clear:both; border-bottom:3px solid #04303d;">

                        <div style="margin:0 auto;width:700px;clear:both;">

  						<div style="background-color:#3F4CA0; height:30px;"></div>

    					<div style="background-color:#fff; padding:0 0px;">

        				<img src="http://www.foodandmenu.com/images/logo.png" alt="" style="margin:10px 0; float:left;" />
                         <div style="height:15px; background-color:#3F4CA0;"></div>
       		 			</div>

        				<div style="width:100%; float:left;">

            			<div style="clear:both;"></div>

							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Hello ,'.$sql_username['firstname'].'</p>

            				
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Thanks for the resevation at '.$sql_res_name['restaurant_name'].'</p>
							
                			<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Information about the reservation</p>
							
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Date : '.$post_date.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Time : '.$time.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">How many People : '.$how_many_people.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Special Ocassions : '.$special_occasions.'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Contact Email : '.$_REQUEST['contact_email'].'</p>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">Comments : '.$comments.'</p><br>
							<p style="font:bold 12px Arial, Helvetica, sans-serif; color:#000000; margin:0 0 4px 15px;">You will get an email once your reservation has been confirmed ! Thanks </p>
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
				
			$res_email = (explode(",",$sql_res_name['email']));
				
			$sql_cms = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_auto_responder WHERE page_id = 18"));	
			
			$cms_rep2 = htmlspecialchars_decode(stripslashes($sql_cms['description']));
			
			$cms_rep2=str_replace('%%$username%%',$username,$cms_rep2);
			$cms_rep2=str_replace('%%$restaurant_name%%',$restaurant_name,$cms_rep2);
			$cms_rep2=str_replace('%%$post_date%%',$post_date,$cms_rep2);
			$cms_rep2=str_replace('%%$time%%',$time,$cms_rep2);
			$cms_rep2=str_replace('%%$how_many_people%%',$how_many_people,$cms_rep2);
			$cms_rep2=str_replace('%%$special_occasions%%',$special_occasions,$cms_rep2);
			$cms_rep2=str_replace('%%$contact_email%%',$contact_email,$cms_rep2);
			$cms_rep2=str_replace('%%$comments%%',$comments,$cms_rep2);	

			$from2 = "support@foodandmenu.com";

			$headers2 = "From:".$from2."\nReply-To: ".$from2."\nReturn-Path: ".$from2."\nX-Mailer: PHP\n";
			
			$inc = 1;
			foreach($res_email as $val_email){
				if($inc!=1){
					$headers2.= "Bcc:".$val_email."\n";
				}
				$inc++;
			}

			$headers2 .= 'MIME-Version: 1.0' . "\r\n";

			$headers2 .= 'Content-type: text/html; charset=utf-8' . "\r\n";	 

			$message2=$cms_rep2;

			/*$subject2="Reservation Confirmation mail";*/
			
			$subject2 = stripslashes($sql_cms['subject']);
			
			mail($res_email[0],$subject2,$message2,$headers2);
			
			//mail("priya@infosolz.com",$subject2,$message2,$headers2);
			
			
	header("location:restaurant.php?id=".$_REQUEST['profile_id'].'&error_msg=6');
	
	}
}


?>

<script type="text/javascript">
function printDiv(no)
{
var divToPrint=document.getElementById('coupon_image'+no);
var newWin=window.open('','Print-Window','width=768,height=1024,top=50,left=100');
newWin.document.open();
    newWin.document.write('<html><head><style>#in {display:none}</style><body   onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
newWin.document.close();
//setTimeout(function(){newWin.close();},10);

}
</script>
<!--<script type="text/javascript" src="raty-master/demo/js/jquery.min.js"></script>-->
<script type="text/javascript" src="raty-master/lib/jquery.raty.js"></script>

<div class="food_cont_bottom">
<?php $sql_restaurant = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_basic_info WHERE id = '".$_REQUEST['id']."'"));?>
<div class="food_left_side">
<?php if($sql_restaurant['restaurant_image']!='') {?>
    <img src="uploaded_images/<?php echo $sql_restaurant['restaurant_image'];?>" />
    <?php } else { ?>
    <img src="images/no_image.png" /><?php } ?>
   <?php $sql_photo = mysql_query("SELECT * FROM restaurant_photo WHERE restaurant_id = '".$_REQUEST['id']."'"); 
   if(mysql_num_rows($sql_photo)>0){?> 
    <div id="wrap">
    
    <h1 class="photos">Photo</h1>

<ul id="mycarouse2" class="jcarousel-skin-tango highslide-gallery">

<?php 
while($array_photo = mysql_fetch_array($sql_photo)){ ?>
<li><a class='highslide' href='uploaded_images/<?php echo $array_photo['image_name'];?>' onclick="return hs.expand(this)">
<img src='thumb_images/<?php echo $array_photo['image_name'];?>' alt='Mountain valley'/></a></li>
<?php } ?>

<div class="clear"></div>

</ul>

</div>

<div class="clear"></div><?php } ?>

<?php $sql_select_video = mysql_query("SELECT * FROM restaurant_video WHERE  restaurant_id = '".$_REQUEST['id']."'");
if(mysql_num_rows($sql_select_video)>0){?>
<div id="wrap" style="width:515px;">

<h1 class="photos">Video</h1>

<ul id="mycarousel" class="jcarousel-skin-tango highslide-gallery2">

<!--

<!--<a href="http://www.youtube.com/embed/0Mz4NTozNXw?rel=0" frameborder="0" allowfullscreen" 
onclick="return hs.htmlExpand(this, {objectType: 'iframe', width: 480, height: 385, 
allowSizeReduction: false, wrapperClassName: 'draggable-header no-footer', 
preserveContent: false, objectLoadTime: 'after'})"
class="highslide">-->
<?php
while($array_video = mysql_fetch_array($sql_select_video)){ ?>
<li><a class="video"  title="Video1" href="<?php echo $array_video['video_link'];?>" target="_blank">
<?php if($array_video['video_image']!=''){?> 
<img src="thumb_images/<?php echo $array_video['video_image']?>" class="video_image" />
<?php } else { ?> 
<img src="images/no_image.png" class="video_image" />
<?php } ?>
</a> </li>
<?php  } ?>   
<!--  <a class="video"  title="Video1" href="http://www.youtube.com/v/ZeStnz5c2GI?fs=1&amp;autoplay=1"> 
<img src="images/vid-2.png" class="video_image" /> </a>   
<a class="video"  title="Video1" href="http://www.youtube.com/v/ZeStnz5c2GI?fs=1&amp;autoplay=1"> 
<img src="images/vid-3.png" class="video_image" /> </a>   
<a class="video"  title="Video1" href="http://www.youtube.com/v/ZeStnz5c2GI?fs=1&amp;autoplay=1"> <img src="images/vid-4.png" class="video_image" /> </a>-->

<div class="clear"></div> 

</ul>
<?php } ?>
<?php
$sql_additional_reservation=mysql_fetch_array(mysql_query("SELECT reservation from restaurant_services_dress_payment WHERE restaurant_id=".$_REQUEST['id'].""));
//echo $sql_additional_reservation['reservation'];
if($sql_additional_reservation['reservation']==1)
{
$rand_id = time();
?>
<div class="reservation2" style="width:141px; float:left;"><!--<a href="#">Reservation</a>-->
    
<ul>
<li><?php if(isset($_SESSION['customer_id'])){?><a id="various3" href="#inline<?php echo $rand_id; ?>" title="Lorem ipsum dolor sit amet"><?php } else { $_SESSION['page_type']='reservation';
$_SESSION['redirect']=$_SERVER['REQUEST_URI']; ?><a href="login.php" > 
<?php $_SESSION['resttid'] = $_REQUEST['id'];
$_SESSION['deal_id'] = $_REQUEST['deal_id']; } ?>

Make a Reservation</a><?php if($_REQUEST['status']=="error"){?>&nbsp;<span>The Validation code does not match!</span><?php } ?>
<?php if($_REQUEST['status']=="success"){?>&nbsp;<span style="color:#404CA1">Your request has been sent successfully !</span><?php } ?>
<?php /*?><input type="text" name="post_date_test" value="" /><?php */?>
</li>
</ul>

<div style="display: none;">
<div id="inline<?php echo $rand_id; ?>" style="width:500px;height:550px;overflow:auto;">
<div class="profle_wrapper">

<div class="profle_top">

<h1>Reservation Details</h1>

<div class="clear"></div>
</div>
<?php /*?><script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" language="javascript">
$(function() {
$( "#post_date" ).datepicker();
});
</script><?php */?>
<script type="text/javascript">
function refreshCaptcha()
{
var img = document.images['captchaimg'];
img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
function getkey(e)
{
if (window.event)
return window.event.keyCode;
else if (e)
return e.which;
else
return null;
}
function goodchars(e, goods)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
if (goods.indexOf(keychar) != -1)
return true;
if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
return true;
return false;
}
function checkMessenger(themail)
{
var tomatch  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if (!tomatch.test(themail))
{ 
window.alert('Invalid Email Address');
return false;
}
return true; 
}
function valid(){
if(document.getElementById("post_date_test").value=="")
{
alert("Please enter date");
document.getElementById("post_date_test").focus();
return false;	
}
if(document.getElementById("time").value=="")
{
alert("Please enter time");
document.getElementById("time").focus();
return false;	
}
if(document.getElementById("how_many_people").value=="")
{
alert("Please enter number of people");
document.getElementById("how_many_people").focus();
return false;	
}
if(document.getElementById("special_occasions").value=="")
{
alert("Please enter special occasion");
document.getElementById("special_occasions").focus();
return false;	
}
if(document.getElementById("contact_email").value=="")
{
alert("Please enter contact email id");
document.getElementById("contact_email").focus();
return false;	
}
if ((document.getElementById("contact_email").value!="") && (checkMessenger(document.getElementById("contact_email").value)==false))
{
document.getElementById("contact_email").value="";
document.getElementById("contact_email").focus();
return false;
}
if(document.getElementById("comments").value=="")
{
alert("Please enter comments");
document.getElementById("comments").focus();
return false;	
}
if(document.getElementById("captcha_code").value=="")
{
alert("Please enter captcha");
document.getElementById("captcha_code").focus();
return false;	
}
}


</script>
<script type="text/javascript">
/*function valButton(btn) {
var cnt = -1;
for (var i=btn.length-1; i > -1; i--) {
if (btn[i].checked) {cnt = i; i = -1;}
}
//alert(cnt);
if (cnt > -1) return btn[cnt].value;
else return null;
}
function radio_check(){
var btn = valButton(frm_deals.deals);
if (btn == null)
{
alert('Please select deal');
return false;
}
return true;
}*/

function radio_check() {
var radios = document.getElementsByName('deals');


for (var i = 0; i < radios.length; i++) {
if (radios[i].checked) {
//alert("Selected Value = " + radios[i].value);
return true; // checked
}
};

// not checked, show error
alert('Please select deal');
//document.getElementById('ValidationError').innerHTML = 'Error!!!';
return false;
}                
</script>

<!--<script type="text/javascript">
function check_it(test){
alert(test);
return false;
}
</script>-->


<div class="profle_bottom" style="width:450px;">
<form name="reservation_form" method="post" action="" onSubmit="return valid();">

<p>Date * :</p>
<input name="post_date_test" id="post_date_test" type="text"  class="profilefield"/>&nbsp;(mm/dd/yyyy)
<div class="clear"></div>

<p>Time * :</p>
<input name="time" id="time" type="text"  class="profilefield"/>
<div class="clear"></div>

<p>How Many People * :</p>
<input name="how_many_people" id="how_many_people" type="text"  class="profilefield" onKeyPress="return goodchars(event,'1234567890');"/>
<div class="clear"></div>

<p>Special Occasions * :</p>
<input name="special_occasions" id="special_occasions" type="text"  class="profilefield"/>
<input name="profile_id" id="profile_id" type="hidden"  class="profilefield" value="<?php echo $_REQUEST['id']?>"/>
<div class="clear"></div>

<p>Contact Email * :</p>
<input name="contact_email" id="contact_email" type="text"  class="profilefield"/>
<div class="clear"></div>

<p>Additional Comments * :</p>
<textarea name="comments" id="comments" cols="" rows="" class="profilearea"></textarea>

<div class="clear"></div>

<p>Captcha * :</p>
<img src="captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg' style="margin-left:15px;">
<div class="clear"></div>
<span style="color:#595959; font-family:Arial,Helvetica,sans-serif; font-size:13px; padding-left:142px;">Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</span>
<div class="clear"></div>

<input id="captcha_code" name="captcha_code" type="text"  class="profilefield_right" style="margin-right:104px"/>
<div class="clear"></div>

<input class="profilebutton" type="submit" value="Submit" name="submit">
</form>


</div>

</div>
</div>
</div>
</div>
<?php
}
?>


<div class="clear"></div>

<div style="margin-top:10px;">
<!-- AddThis Button BEGIN -->
<!-- AddThis Button END -->

<!-- AddThis Button BEGIN -->
<!--<div class="addthis_toolbox addthis_default_style " style="width:400px; float:left;">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<?php /*?><a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a><?php */?>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5160175349da4375"></script>-->
<!-- AddThis Button END -->
<div class="clear"></div>
</div>

</div>

    
    
    
</div> 
                        <div class="food_middle_side">
                            <div class="middle_top">
                             <?php $rating = number_format(getRestaurantRating($sql_restaurant['id']),1);
							 //echo $rating = 3; ?>
                            	<h1><?php echo stripslashes($sql_restaurant['restaurant_name']);?></h1>
                                <script type="text/javascript" language="javascript">
								jQuery(function() {
									jQuery(".stars").each(function() {
										jQuery(this).raty({
											start: jQuery(this).text(),
											readOnly: true,
											score: <?php echo $rating; ?>
										});
									});
								});
                                </script>
                                
                                
                                <?php //echo $rating; ?>
                                <div style="float:left; padding-left:10px; width:100px;"><div class="stars"></div></div>
                               <?php /*?> <ul>
                                <?php 
									$rating = getRestaurantRating($sql_restaurant['id']); 
								?>
                                    	<?php
										$rem = 5 - $rating;
										if($rating == 0)
										{
											for($i=0; $i<5;$i++){
										?>
                                        <li><img width="16" height="15" src="images/star-3.png"></li>
                                        <?php	
											}
										}
										else
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
										
										?>
                                        <li><?php echo $res_review['post_date']; ?></li>
                                </ul><?php */?>
                            	<p style="float:left; padding-top:2px; width:100px;"><?php echo getRestaurantCountRating($sql_restaurant['id']); ?> reviews</p>
                            </div>
                         <div class="clear"></div>   
                            <div class="category_asian">
                            <?php $sql_restaurant_category = mysql_query("SELECT * FROM restaurant_category WHERE id IN(".$sql_restaurant['restaurant_category'].")");?>
                           <div class="category_pic" style="border-radius: 3px; margin: 10px 0 0 10px; padding: 4px 5px;">
                           <img src="images/category-icon.png" width="20" height="22" /> 
                           <h1 style="font-size: 19px; line-height: 20px; padding: 0 0 5px;">Categories - </h1><?php //echo $sql_restaurant_category['category_name'] 
											$i=1;
							                 while($result_restaurant_category=mysql_fetch_array($sql_restaurant_category))
											 {?>
											<span style="color: #686868; font-size: 14px; font-weight: normal; float:left; padding-left:26px; padding-top:2px; padding-right: 5px; background: url(../images/bullet2.png) top 8px left 12px no-repeat ;"><?php echo $result_restaurant_category['category_name']; ?> <?php if($i!=mysql_num_rows($sql_restaurant_category)){ echo ",";
											}?></span>
                                            
											 <?php $i++; }
							?>
                            <div class="clear"></div>
                            </div>
                            </div>
                            
                        	<div class="clear"></div>
                            <div class="middle_center">
                                <img src="images/address_pic.png" />
                                <p>
                                    <?php echo $sql_restaurant['restaurant_address'];?></p>
                                 <p style="padding-top:0px; padding-left:38px;"><?php echo $sql_restaurant['restaurant_city'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_state'];?>&nbsp;&nbsp;<?php echo $sql_restaurant['restaurant_zipcode'];?>
                                </p>
                            </div>
                        	<div class="clear"></div>
                            <div class="middle_bottom">
                              <img src="images/phone.png" alt="" />
                              <p><?php echo $sql_restaurant['phone'];?></p> 
                            </div>
                            <?php if($sql_restaurant['website']!=""){?>
                            <div class="clear"></div>
                            <div class="middle_bottom">
                              <img src="images/website.png" alt=""  />
                              <p>
                              <a href="<?php echo $sql_restaurant['website']?>" target="_blank" style="color:#686868; text-decoration:none;">Website</a></p> 
                              <?php /*?><?php echo $sql_restaurant['website']?><?php */?>
                            </div>
                           <?php
							}
							?>
                        </div>
                        <div class="map_right_side deal_side"><!--<img src="images/restaurant_map.png" width="365" height="176" />-->
                        
                        <div class="map_right_field deal_side">
                        <?php if($deal_error == 1){ ?>
                        <p style="color:#ff0000; padding-bottom:0px; font-size:14px; padding-top:18px; font-size:16px; margin-left:10px;">Please select deal.</p>
                        <?php } ?>
                        <?php $sql_deals = mysql_query("SELECT * FROM restaurant_deals WHERE restaurant_id = '".$_REQUEST['id']."' AND deals_status = 1 AND (expiry_date	> '".date('Y-m-d')."' OR expiry_date ='0000-00-00')");
						if(mysql_num_rows($sql_deals)){ ?>
                        <h1>Daily Deals</h1> 
                                               
                        <form name="frm_deals" id="frm_deals" action="" method="post">
                        <?php 
						$dl = 1;
						while($array_deals = mysql_fetch_array($sql_deals)){ ?>
                          <div style="padding-bottom:5px; margin-left:10px;">
                        <div style="float:left; width:30px;"><input name="deals" type="radio" value="<?php echo $array_deals['id']; ?>" class="right_radio deal_radio" <?php if($array_deals['id'] == $_REQUEST['deal_id']){?> checked="checked" <?php } ?>/></div>
                        <div style="float:left; width:278px;"> 
						<p style="padding:5px 0px !important;">$<?php echo $array_deals['daily_description'];?> / Your Price $<?php echo $array_deals['daily_price'];?>  /  Expiry Date : <?php echo date("m-d-Y", strtotime($array_deals['expiry_date'])); ?></p></div>
                       <!-- <div class="clear"></div>-->
                        
                          <div class="more_but">
                          <a class="various5" href="#inline_<?php echo $dl; ?>" title="More Info" style="text-decoration:none;">
                          <p class="right_list_button" style="width:84px; color:#FFF; font-size:15px; text-align:center; padding:5px;">More Info</p></a>
                          </div>
                          
                          <div style="display: none;">
                            <div id="inline_<?php echo $dl; ?>" style="width:500px;height:250px;overflow:auto;">
                                <div class="profle_wrapper">
                                    <div class="profle_top">
                                        <div class="clear"></div>
                                        </div>
                                            <div class="profle_bottom" style="width:450px;">
                                            <b><?php echo $array_deals['disclaimer_title']; ?></b><br />
                                            <?php echo $array_deals['disclaimer']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        <div class="clear"></div>
                        </div>
                        <?php $dl++; } ?>
                        <select name="deals_qty" id="deals_qty" class="right_list">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        <input type="hidden" name="command" value="add" />
                        <input name="submit" type="submit" class="right_list_button" value="Add To Cart" onclick="return radio_check();" />
                        </form>
                        
                        <div class="clear"></div>
                        <?php } ?>
                        <div class="list_style">
                        
                        
                        <div class="clear"></div>
                        
                        
                        <!--<p>Minimun Purches of $37.50</p>-->
                           
                        
                         <?php 
						 //if(isset($_SESSION['customer_id'])){
						 $sql_coupons = mysql_query("SELECT * FROM restaurant_coupon WHERE restaurant_id = '".$_REQUEST['id']."' AND coupon_status =1");
						 if(mysql_num_rows($sql_coupons)>0){ ?>
                         
                        <!--<p><a href="#">Gift Certificate Information</a></p>--> 
                        <h2>Coupons</h2>
                        
                        <!--<img src="images/price_tag.jpg" width="200" height="48" />--> 
                       
						<?php 
						$i=1;
						while($array_coupons = mysql_fetch_array($sql_coupons)){ ?>
                        <div class="reservation3"><!--<a href="#">Reservation</a>-->
                            
  <ul>
		<li><?php if(isset($_SESSION['customer_id'])){?><a class="various6" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>" style="text-decoration:none;">
        <?php if($array_coupons['coupon_image']!=''){?>
        <img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="95" height="70" />
        <?php } else { ?>
        <img src="images/no_image.png" width="95" height="70" /></a><?php } }else{?><a href="login.php">
        <?php if($array_coupons['coupon_image']!=''){?>
        <img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="95" height="70" />
        <?php } else { ?>
        <img src="images/no_image.png" width="95" height="70" />
        <?php } ?>        
        </a> <?php } ?>
        <p style="font-weight:bold"><?php echo $array_coupons['coupon_description'];?></p>
        </li>
	</ul>
    
    <div style="display: none;">
		<div id="inline<?php echo $array_coupons['id'];?>" style="width:450px;height:450px;overflow:auto;">
			<div class="profle_wrapper">

<div class="discount_one">

<div class="discount_one_top">

<div class="discount_top_left"><a href="javascript:void(0);" onclick="printDiv(<?php echo $i ?>);"><img src="images/print_coupon.png" width="100" height="60" /></a></div>

<div class="discount_top_right"><a href="#"><img src="images/share.png" width="118" height="41" onclick="fbpublish('<?=addslashes($array_coupons['coupon_name'])?>','<?=addslashes($array_coupons['coupon_description'])?>','<?=addslashes($array_coupons['coupon_image'])?>')"/></a></div>

<div class="clear"></div>

</div>

<div class="discount_one_botton" id="coupon_image<?php echo $i?>">
<?php if($array_coupons['coupon_image']!=''){?>
<img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="425" height="300" />
<?php } else { ?>
<img src="images/no_image.png" width="425" height="300" />
<?php } ?>

</div>

<!--<ul>

<li><img src="images/coupon-1.jpg" width="425" height="300" /></li>

</ul>-->
<div class="clear"></div>
</div>

</div>
		</div>
	</div>
                            </div>
                            <?php 
							$i++;
							} } //} ?>
                            <div class="clear"></div>
                            <?php /*?><?php
						
						 $num_disclaimer=mysql_num_rows(mysql_query("SELECT * FROM restaurant_disclaimer WHERE restaurant_id='".$_REQUEST['id']."'"));?> 
                          <?php $result_disclaimer=mysql_fetch_array(mysql_query("SELECT * FROM restaurant_disclaimer WHERE restaurant_id='".$_REQUEST['id']."'"));?> 
                          <?php
						  if($num_disclaimer>0)
						  { 
						  ?>
                          <a id="various5" href="#inline5" title="Click here for More Information" style="text-decoration:none;">
                          <p class="right_list_button" style="width:170px; color:#FFF">Click here for More Information</p></a>
                          <?php
						  }
						  ?>  <?php */?>
                            
                        
                        </div>
                        
                        </div>
                        <div class="clear"></div>
                        
                        </div>
                        
                        
                        
                        <div class="clear"></div>
                        
                    </div>
                    
                    <div class="social_image">

                            <div class="soc_icon">
                            <a href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>"  target="_blank">
                            <img src="images/facebook_share.jpg" /></a></div>
                            
                            
                            <div class="soc_icon"><a href="http://twitter.com/home?status=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>" target="_blank"><img src="images/twitter_logo.png" /></a></div>
                            
                            <div class="soc_icon"><a href="mailto:<?php echo $sql_restaurant['email']; ?>" target="_top"><img src="images/mail_icon.png" /></a></div>
                            
                            <!-- Place this tag where you want the +1 button to render. -->
                            <div class="g-plusone soc_icon" data-annotation="inline" data-width="300"></div>
                            <!-- Place this tag after the last +1 button tag. -->
                            <script type="text/javascript">
                              (function() {
                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                po.src = 'https://apis.google.com/js/platform.js';
                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                              })();
                            </script>
                            
                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:450px; height:60px;"></iframe></div>
                            
                            <div class="clear"></div>
                            
                            </div>
                    
                    <script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
                    <script type="text/javascript">

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel();
});

jQuery(document).ready(function() {
    jQuery('#mycarouse2').jcarousel();
});


</script>
                    <script src="http://connect.facebook.net/en_US/all.js"></script>
<script language="Javascript">

FB.init({ 
	appId: '173774529467714', 
	status: true, 
	cookie: true,
	xfbml : true 
});
function fbpublish(msg,address,pict) {
	var publish = {
		method: 'stream.publish',
		display: 'popup',
		name: 'FOOD AND MENU',
		picture: 'http://foodandmenu.com/uploaded_images/'+pict,
		caption: '',
		description: (
			'<b>'+msg+'</b><center></center>'+address+'<center></center>'
		),
		href: 'http://foodandmenu.com/'
	};
	FB.ui(publish);
}
</script>