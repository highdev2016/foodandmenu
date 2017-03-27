<?php
session_start();
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

?>

<?php
$ses_rest_id = $_REQUEST['id'];
if($_REQUEST['apply'] == 'Apply')
{
	$coupon_code = $_REQUEST['coup_code_top'];
	$sql_check_cart = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".session_id()."' AND restaurant_id = '".$_REQUEST['hid_res_id']."'");
	
	$cart_num_row = mysql_num_rows($sql_check_cart);
	
	$sql_select_coupon = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$coupon_code."'"));
	
	if($cart_num_row > 0)
	{
		$_SESSION['coupon_code'.$ses_rest_id] = $sql_select_coupon['coupon_code'];
		$cart_amount = 0;
		while($array_items = mysql_fetch_array($sql_check_cart)){
			$cart_amount = $cart_amount + ($array_items['price']*$array_items['quantity']); 
		}
		
		if($sql_select_coupon['minimum_order_amount'] < $cart_amount)
		{
			if($sql_select_coupon['discount']!=0.00)
			{
				$coupon_discount = ($sql_select_coupon['discount']*$cart_amount)/100;
			}
			else
			{
				$coupon_discount = $sql_select_coupon['coupon_price'];
			}
		}
		else
		{
			$_SESSION['coupon_code'.$ses_rest_id] = '';
			$_SESSION['coupon_discount'.$ses_rest_id] = '';
			header("location:restaurant.php?id=".$_REQUEST['hid_res_id'].'&error_msg=8');
			
		}
		$_SESSION['coupon_discount'.$ses_rest_id] = $coupon_discount;
		//header("location:restaurant.php?id=".$_REQUEST['hid_res_id']."");
	}
	else
	{
		$_SESSION['coupon_code'.$ses_rest_id] = '';
		$_SESSION['coupon_discount'.$ses_rest_id] = '';
		header("location:restaurant.php?id=".$_REQUEST['hid_res_id']."");
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

<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />
<script>
/*var $j = jQuery.noConflict();
  $j(function() {
	$j('#time').timepicker({ 'timeFormat': 'h:i A' });
  });*/
</script>

<script type="text/javascript">

function add_favourite(res_id,user_id)
{
	var $j = jQuery.noConflict();
	if(user_id != '')
	{
		$j.ajax({
			url : 'add_favourite.php',
			type : 'POST',
			data : 'res_id=' + res_id + '&user_id=' + user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				if(data != "You have already added this Restaurant as Favourite!!")
				{
					$j("#favourite_p").hide().html(data).fadeIn(1000);
				}
				else
				{
					alert(data);
					window.location.href='restaurant.php?id='+res_id;
				}
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
	}
	else
	{
		window.location.href='login.php';
	}
}

</script>

<script type="application/javascript">
  window.fbAsyncInit = function() {
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

function FBShareOp(name,id,image,desc,folder_name){
	var restaurant_name = name;
	var description	   =	desc;
	var share_image	   =	'https://foodandmenu.com/'+folder_name+'/'+image;
	var share_url	   =	'https://foodandmenu.com/restaurant.php?id='+id;	
    var share_capt     =    'caption';
    FB.ui({
        method: 'feed',
        name: restaurant_name,
       link: share_url,
       picture: share_image,
        //caption: share_capt,
       description: description

    }, function(response) {
        if(response && response.post_id){}
        else{}
    });

}

</script>




<style type="text/css">
.ui-timepicker-wrapper{
	width:202px !important;
}
</style>


<div class="food_cont_top title-top">
	<h1>Home</h1>
	<?php
	$check_favourite = mysql_num_rows(mysql_query("SELECT id FROM restaurant_favourite WHERE user_id = '".$_SESSION['customer_id']."' AND restaurant_id = '".$_REQUEST['id']."'"));
	?>
      <p id="favourite_p" class="fav-p">
      <?php
	  if($check_favourite == 0)
	  {
	  ?>
      <a href="javascript:void(0);" class="right_list_button" onclick="add_favourite('<?php echo  $_REQUEST['id']; ?>','<?php echo $_SESSION['customer_id']; ?>');" style="color:#ffffff; text-decoration:none;">Add to Favourite</a></p>
      <?php
	  }
	  else
	  {
	  ?>
      <a href='javascript:void(0);' class='right_list_button'  style='color:#ffffff; text-decoration:none; cursor:default;'>Added to Favourite</a>
      <?php  
	  }
	  ?>
</div>
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
<img src='thumb_images/<?php echo $array_photo['image_name'];?>' width="39" height="39"/></a></li>
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
<li><?php if(isset($_SESSION['customer_id'])){?><a id="various3" href="#inline<?php echo $rand_id; ?>" title="Make a Reservation"><?php } else { $_SESSION['page_type']='reservation';
$_SESSION['redirect']=$_SERVER['REQUEST_URI']; ?><a href="login.php" > 
<?php $_SESSION['resttid'] = $_REQUEST['id'];
$_SESSION['deal_id'] = $_REQUEST['deal_id']; } ?>

Make a Reservation</a><?php if($_REQUEST['status']=="error"){?>&nbsp;<span>The Validation code does not match!</span><?php } ?>
<?php if($_REQUEST['status']=="success"){?>&nbsp;<span style="color:#404CA1">Your request has been sent successfully !</span><?php } ?>



</li>
</ul>

<div id="cap_success_msg" style="color:#57BD18;display:none; width:286px; margin-top:10px;">Your Request has been sent Successfully. </div>

<div style="display: none;">
<div id="inline<?php echo $rand_id; ?>" style="width:500px;height:550px;overflow:auto;">
<div class="profle_wrapper">

<div class="profle_top">

<h1>Reservation Details</h1>

<div class="clear"></div>
</div>
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



function check_validation()
{
	var $j = jQuery.noConflict();	
	
	if($j("#post_date_test").val() == '' || $j("#tp1").val() == "" ||  $j("#how_many_people").val() == "" || $j("#special_occasions").val() == "" || $j("#comments").val() == "" || $j("#captcha_code").val() == ""){
		if($j("#post_date_test").val() == "")
		{
			alert("Please enter date");
			$j("#post_date_test").focus();
			return false;	
		}
		
		if($j("#tp1").val() == "")
		{
			alert("Please enter time");
			$j("#time").focus();
			return false;	
		}
		if($j("#how_many_people").val() == "")
		{
			alert("Please enter number of people");
			$j("#how_many_people").focus();
			return false;
		}
		
		if($j("#special_occasions").val() == "")
		{
			alert("Please enter special occasion");
			$j("#special_occasions").focus();
			return false;	
		}
		
		if($j("#special_occasions").val() == "others"){
			if($j("#others_occassions").val() == "")
			{
				alert("Please enter Occasion Name.");
				$j("#others_occassions").focus();
				return false;	
			}	
		}
		if($j("#comments").val() == "")
		{
			alert("Please enter comments");
			$j("#comments").focus();
			return false;	
		}
		if($j("#captcha_code").val() == "")
		{
			alert("Please enter captcha");
			$j("#captcha_code").focus();
			return false;	
		}
	
	}else{
	
	$j('#loader_div').show();
	
	
	var post_date_test 		= $j('#post_date_test').val();
	var time 				= $j('#timepick').val();
	var how_many_people 	= $j('#how_many_people').val();
	var special_occasions 	= $j('#special_occasions').val();
	var customer_name 		= $j('#customer_name').val();
	var contact_email 		= $j('#contact_email').val();
	var customer_phone 		= $j('#customer_phone').val();
	var comments 			= $j('#comments').val();
	var captcha_code 		= $j('#captcha_code').val();
	var rest_id				= $j('#rest_id').val();
	
	$j.ajax({
		url : 'online_reservation.php',
		type : 'POST',
		data : 'captcha_code=' + captcha_code  + '&time=' + time  + '&how_many_people=' + how_many_people  + '&special_occasions=' + special_occasions  + '&customer_name=' + customer_name  + '&contact_email=' + contact_email  + '&customer_phone=' + customer_phone  + '&comments=' + comments  + '&post_date_test=' + post_date_test + '&rest_id=' + rest_id ,
		//dataType : 'json',
		beforeSend : function(jqXHR, settings ){
			//alert(url);
		},
		success : function(data, textStatus, jqXHR){
			//alert(data);
			
			if(data == 'Error'){
				$j('#loader_div').hide();
				$j('#cap_error_msg').slideDown(1000);
				$j('#cap_success_msg').slideUp(1000);
				//$j('html, body').animate({ scrollTop: $j('#cap_error_msg').offset().top - 1000 }, '100');
				return false;
			}else{
				//$j('#cap_success_msg').fadeIn(1000);
				$j.fancybox.close();
				$j('#loader_div').hide();
				window.location="http://foodandmenu.com/restaurant.php?id="+rest_id+"&error_msg=7";
			}
			
	
		},
		/*complete : function(jqXHR, textStatus){
			alert(3);
		},*/
		error : function(jqXHR, textStatus, errorThrown){
		}
	});
	}
}

</script>
<script type="text/javascript">
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

<script>
var $j = jQuery.noConflict();

$j(function() {
  var pickerOpts = {
	changeMonth: true,
	changeYear: true,
    dateFormat:"mm-dd-yy",
	minDate: 0,
	onSelect: function(dateText, inst) {
                    var date = $j(this).datepicker('getDate'),
					day1  = date.getDate(),  
					month = date.getMonth() + 1,              
					year =  date.getFullYear(); 
           			day  = date.getDay(); 
					
					var weekday = new Array(7);
						weekday[0] = "Sunday";
						weekday[1] = "Monday";
						weekday[2] = "Tuesday";
						weekday[3] = "Wednesday";
						weekday[4] = "Thursday";
						weekday[5] = "Friday";
						weekday[6] = "Saturday";

   				    var n = weekday[day]; 
					
					var sel_date = day1 + '-' + month + '-' + year;
					
					var res_id = $j("#hid_res_id").val();
					 //alert(res_id);
					 
					 //$j(".ui-timepicker-wrapper").html('');
					 
					$j.ajax({
					url : 'get_reservation_time_ajax.php',
					type : 'POST',
					data : 'day=' + n+ '&restaurant_id=' + res_id+ '&sel_date=' +sel_date,
					//dataType : 'json',
					beforeSend : function(jqXHR, settings ){
						//alert(url);
					},
					success : function(data, textStatus, jqXHR){
						//alert(data);
						
						$j("#time_pick").html(data);
						
						//$j('#market_div').html(data);
					},
					/*complete : function(jqXHR, textStatus){
						alert(3);
					},*/
					error : function(jqXHR, textStatus, errorThrown){
					}
				});
					
					
					
                   
		}
	
}; 
$j( "#post_date_test" ).datepicker(pickerOpts, 'minDate');
});



/*function timefunction(){
	$j(document).ready(function() {
          $j.post( 
             "http://foodandmenu.com/includes/get_server_time.php",
             { getTimeset: "Servertime" },
             function(data) {
                $j('#curr_time').html(data);
             }
          );
   });
}
setInterval("timefunction()", 1000);*/

function open_div(val)
{
	if(val == 'others')
	{
		$j("#others_div").slideDown(1000);
		$j("#others_head_div").slideDown(1000);
	}
	else
	{
		$j("#others_div").slideUp(1000);
		$j("#others_head_div").slideUp(1000);
		$j("#others_occassions").val('');
		
	}
}
</script>
<!--<script type="text/javascript">
function check_it(test){
alert(test);
return false;
}
</script>-->


<div class="profle_bottom" style="width:450px;">
<form name="reservation_form" method="post" action="" onSubmit="return check_validation();">
<input type="hidden" name="rest_id" id="rest_id" value="<?php echo $_REQUEST['id']; ?>" />
<p>Date * :</p>
<input name="post_date_test" id="post_date_test" type="text"  class="profilefield timepicker" readonly="readonly" value="<?php echo date('m-d-Y'); ?>" >&nbsp;(mm/dd/yyyy)
<div class="clear"></div>


<?php 
$sql_get_time = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['id']."'"));

$curr_day = date("l");

$start_time = $sql_get_time['reservation_open_'.$curr_day];
$end_time = $sql_get_time['reservation_close_'.$curr_day];

$curernt_time = date('H:i');
?>



<script type="text/javascript">
/*var $j = jQuery.noConflict();

	$j(document).ready(function(){
    
		$j('input.timepicker').timepicker({
			
			
			minTime: new Date(0, 0, 0, '<?php echo $start_time[0]; ?>', 0, 0),
			maxTime: new Date(0, 0, 0, '<?php echo $end_time[0]; ?>', 0, 0),
			
			startTime: new Date(0, 0, 0, '<?php echo $start_time[0]; ?>', 0, 0),
			
			interval: 30
		});
		
	
});
*/
</script>
<script>

function Converttimeformat(tm) {

var hours1 = tm.split(":");

if(hours1[0] < 10)
{
 	var time = "0" + hours1[0] + ":" + hours1[1];
}
else
{
 	var time = tm;
}

var hrs = Number(time.match(/^(\d+)/)[1]);
var mnts = Number(time.match(/:(\d+)/)[1]);
//var format = time.match(/\s(.*)$/)[1];
var format = tm.substr(tm.length - 2);
//alert(format);
if (format == "pm" && hrs < 12) hrs = hrs + 12;
if (format == "am" && hrs == 12) hrs = hrs - 12;
var hours = hrs.toString();
var minutes = mnts.toString();
if (hrs < 10) hours = "0" + hours;
if (mnts < 10) minutes = "0" + minutes;
return (hours + ":" + minutes + ":00");
}


function check_time_reservation()
{
	var $j = jQuery.noConflict()
	
	var input_date = $j("#post_date_test").val();
	
	
	var input_time = Converttimeformat($j("#timepick").val());
	
	
	var fullDate = new Date();
	
	var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
	
	var curr_date	 = twoDigitMonth + "-" + fullDate.getDate() + "-" + fullDate.getFullYear();
	
	//alert(curr_date);
	
	var curr_time = Converttimeformat($j("#curr_time").text());
	
	
	if(input_date == curr_date && Date.parse('05/01/2011 ' + input_time) < Date.parse('05/01/2011 ' + curr_time))
	{
		alert("Please Select proper time for Reservation");
		$j("#tp1").val('');
		
		return false;
	}
}

var $j = jQuery.noConflict()

$j("#tp1").on('keydown',  function(event){
    var key = event.charCode || event.keyCode || event.which; //alert (key);
    var char = String.fromCharCode(event.key);
    if( key === 8 || key === 46 ){
        event.preventDefault();
        return false;
    }    
});

</script>

<p>Time * :</p>

<span id="time_pick">

<!--<input id="tp1" class="timepicker profilefield" name="time"  onKeyPress="return goodchars(event,'');" />-->
<?php 

$time1 = strtotime($start_time);
$time2 = strtotime($end_time);

//echo $time1."<br>";
if($time1 > strtotime($curernt_time))
{
	$now        = $start_time;
	
}
else
{
	$now        = $curernt_time;
}
//$now        = $curernt_time;
$curr_tm    = explode(':',$now);

//echo $now;

if($curr_tm[1] > 30){
	$rounded_time = ($curr_tm[0]+1).":00";
}else{
	$rounded_time = $curr_tm[0].":30";
}

$round_time = strtotime($rounded_time);

if($time1 > strtotime($curernt_time))
{
	$round_time_start = ($round_time - 1800);
}
else
{
	$round_time_start = $round_time;
}

//echo $curernt_time;
//echo $rounded_time;
/*$interval   = 30;   // in minutes

// add interval to the time
$time_w_interval = $now + ($interval * 60);

// round DOWN to nearest half hour
$rounded_time = floor($time_w_interval / ($interval * 60)) * ($interval * 60);

$round_time = strtotime($rounded_time);

echo $time2."<br>";
echo $round_time;*/

?>
<select name="timepick" class="profilefield" style="height:25px; width:205px;"  id="timepick" >
<?php 
for($i=$round_time_start;$i<=$time2;$i=$i+1800)
{
?>
<option value='<?php echo date("h:i A", $i);?>'><?php echo date("h:i A", $i);?></option>
<?php 
}
?>
</select>


</span>

<input type="hidden" name="curr_time" id="curr_time">
<div class="clear"></div>

<p>How Many People * :</p>
<input name="how_many_people" id="how_many_people" type="text"  class="profilefield" onKeyPress="return goodchars(event,'1234567890');"/>
<div class="clear"></div>

<p>Special Occasions * :</p>

<select name="special_occasions" id="special_occasions" class="profilefield" style="height:25px; width:205px;" onchange="open_div(this.value)">

<option value="">---SELECT---</option>
<?php $sql_occasions = mysql_query("SELECT id , occassions FROM restaurant_occassions WHERE status = 'Active' ORDER BY occassions");
	  while($row_occasions = mysql_fetch_array($sql_occasions))
	  {
	?>
    <option value="<?php echo $row_occasions['id'];?>"><?php echo $row_occasions['occassions'];?></option>
    <?php

}
?>
<option value="others">Others</option>
</select>
<p id="others_head_div" style="display:none;"></p>
<p id="others_div" style="display:none; padding-left:0px; "><input name="others_occassions" id="others_occassions" type="text"  class="profilefield"  /></p>

<?php /*?><input name="special_occasions" id="special_occasions" type="text"  class="profilefield"/><?php */?>

<input name="profile_id" id="profile_id" type="hidden"  class="profilefield" value="<?php echo $_REQUEST['id']?>"/>
<div class="clear"></div>

<?php
	
	$sql_cust_email = mysql_query("SELECT email,firstname,lastname,phone  FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'");
	$row_cust_email = mysql_fetch_array($sql_cust_email);
	
?>

<p>Name * :</p>
<input name="customer_name" id="customer_name" type="text"  class="profilefield" value="<?php echo $row_cust_email['firstname']." ".$row_cust_email['lastname']; ?>" readonly="readonly"/>
<div class="clear"></div>

<p>Contact Email * :</p>
<input name="contact_email" id="contact_email" type="text"  class="profilefield" value="<?php echo $row_cust_email['email']; ?>" readonly="readonly" />
<div class="clear"></div>

<p>Phone No. :</p>
<input name="customer_phone" id="customer_phone" type="text"  class="profilefield" value="<?php echo $row_cust_email['phone']; ?>" onkeypress="return goodchars(event,'1234567890+-');" readonly="readonly"/>
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

<div id="cap_error_msg" style="color:#ff0000; margin-left:140px; display:none;">The Validation code does not match! </div>

<!--<input class="profilebutton" type="submit" value="Submit" name="submit" onclick="return check_time_reservation();">-->
<input class="profilebutton" type="button" value="Submit" name="submit" onclick="return check_validation();" style="float:left;">
<div id="loader_div" style="float:left; display:none; padding-left:20px; padding-top:10px;" ><img src="images/ajax-loader-review.gif" /></div>
<div style="clear:both;"></div>

<input type="hidden" name="hid_res_id" id="hid_res_id" value="<?php echo $_REQUEST['id']; ?>"  />
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
                                <?php  
								 $total_review=mysql_num_rows(mysql_query("SELECT * FROM restaurant_reviews where restaurant_id='".$_REQUEST['id']."' AND status=1"));
								?>
                            	<p style="float:left; padding-top:2px; width:100px;">
								<?php echo $total_review; ?>
								<?php //echo getRestaurantCountRating($sql_restaurant['id']); ?> reviews</p>
                            </div>
                         <div class="clear"></div>   
                            <div class="category_asian">
                            <?php $sql_restaurant_category = mysql_query("SELECT * FROM restaurant_category WHERE id IN(".$sql_restaurant['restaurant_category'].")");?>
                           <div class="category_pic" style="border-radius: 3px; margin: 10px 0 0 10px; padding: 4px 5px;">
                           <img src="images/category-icon.png" width="20" height="22" style="float:left;" /> 
                           <h1 style="font-size: 19px; line-height: 20px; padding: 0 0 5px; float:left; width:100px;" >Categories - </h1><?php //echo $sql_restaurant_category['category_name'] 
											$i=1;
							                 while($result_restaurant_category=mysql_fetch_array($sql_restaurant_category))
											 {?>
											<span style="color: #686868; font-size: 14px; font-weight: normal; float:left; padding-left:5px; padding-top:2px; padding-right: 5px;   width:124px; float:left; display:block;"><?php echo $result_restaurant_category['category_name']; ?> <?php if($i!=mysql_num_rows($sql_restaurant_category)){ echo ",";
											}?></span>
                                            
											 <?php $i++; }
							?>
                            <div class="clear"></div>
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
                              <img src="images/phone.png" alt="" style="margin-top:7px;" />
                              <p style="padding-top:7px;"><?php echo $sql_restaurant['phone'];?></p> 
                            </div>
                            
                            <?php if($sql_restaurant['website']!=""){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['website']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/website.png" alt="" style="margin-top:7px;"  />
                              <p style="padding-top:7px;">Website</p>
                              </a>
                              <?php /*?><?php echo $sql_restaurant['website']?><?php */?>
                            </div>
                           <?php
							}
							?>
                            
                            <?php if($sql_restaurant['restaurant_facebook_url']!="" && $sql_restaurant['restaurant_facebook_url']!="#"){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['restaurant_facebook_url']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/facebook.png" alt="" style="margin-top:7px;" width="18px"  />
                              <p style="padding-top:5px;">Facebook</p>
                              </a>
                            </div>
                           <?php
							}
							?>
                            
                            <?php if($sql_restaurant['restaurant_twitter_url']!="" && $sql_restaurant['restaurant_twitter_url']!="#"){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['restaurant_twitter_url']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/twitter.png" alt="" style="margin-top:7px;" width="18px" />
                              <p style="padding-top:5px;">Twitter</p>
                              </a>
                            </div>
                           <?php
							}
							?>
                            
                            <?php if($sql_restaurant['restaurant_google_plus_url']!="" && $sql_restaurant['restaurant_google_plus_url']!="#"){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['restaurant_google_plus_url']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/google_plus.png" alt="" style="margin-top:7px;" width="18px" />
                              <p style="padding-top:5px;">Google Plus</p>
                              </a>
                            </div>
                           <?php
							}
							?>
                            
                            <?php if($sql_restaurant['restaurant_urbanspoon_url']!="" && $sql_restaurant['restaurant_urbanspoon_url']!="#"){ ?>
                            <div class="middle_bottom">
                              <a href="<?php echo $sql_restaurant['restaurant_urbanspoon_url']?>" target="_blank" style="color:#686868; text-decoration:none;"><img src="images/urbanspoon.png" alt="" style="margin-top:7px;" width="18px" />
                              <p style="padding-top:5px;">Urbanspoon</p>
                              </a>
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
                        <?php $sql_deals = mysql_query("SELECT * FROM restaurant_deals WHERE restaurant_id = '".$_REQUEST['id']."' AND (expiry_date	> '".date('Y-m-d')."' OR expiry_date ='0000-00-00')");
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
						 $sql_coupons = mysql_query("SELECT * FROM restaurant_coupon WHERE restaurant_id = '".$_REQUEST['id']."' AND coupon_status =1 AND end_date >= '".date('Y-m-d')."' AND show_coupon = 1");
						 if(mysql_num_rows($sql_coupons)>0){ ?>
                         
                        <!--<p><a href="#">Gift Certificate Information</a></p>--> 
                        <h2>Coupons</h2>
                        
                        <!--<img src="images/price_tag.jpg" width="200" height="48" />--> 
                       
                      
						<?php 
						$i=1;
						while($array_coupons = mysql_fetch_array($sql_coupons)){ ?>
                        
                         <form action="" method="post" name="coupon_frm" id="coupon_frm" >
                         
                         <input type="hidden" name="coup_code_top" id="coup_code_top" value="<?php echo $array_coupons['coupon_code']; ?>" />
                        <div class="reservation3"><!--<a href="#">Reservation</a>-->
                            
  <ul>
		<li><?php if(isset($_SESSION['customer_id'])){?>
        <?php if($array_coupons['coupon_image']!=''){?>
        <a class="various6" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>" style="text-decoration:none;"><img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="95" height="70" /></a>
        <?php } else { ?>
        <a class="various6" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>" style="text-decoration:none;"><img src="images/no_image.png" width="95" height="70" /></a><?php } }else{?><a href="login.php">
        <?php if($array_coupons['coupon_image']!=''){?>
        <img src="uploaded_images/<?php echo $array_coupons['coupon_image'];?>" width="95" height="70" />
        <?php } else { ?>
        <img src="images/no_image.png" width="95" height="70" />
        <?php } ?>        
        </a> <?php } ?>
        <p style="font-weight:bold"><?php echo $array_coupons['coupon_description'];?></p>
        <?php
		if($array_coupons['coupon_code'] != '' && $array_coupons['show_coupon_code'] == 1)
		{
		?>
        Coupon Code <p class="cupon-code" style="font-weight:bold"><?php echo $array_coupons['coupon_code'];?></p>
        <?php
		}
		?>
       <?php
	   $sql_check_cart_check = mysql_query("SELECT * FROM restaurant_menuitem_cart WHERE session_id = '".session_id()."' AND restaurant_id = '".$_REQUEST['id']."'");
	   
		$cart_num_row_check = mysql_num_rows($sql_check_cart_check);
		
		$cart_amount = 0;
		while($array_items = mysql_fetch_array($sql_check_cart_check)){
			$cart_amount = $cart_amount + ($array_items['price']*$array_items['quantity']); 
		}
	
		$sql_select_coupon_check = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_coupon WHERE coupon_code = '".$array_coupons['coupon_code']."'"));	
		
	    if($cart_num_row_check > 0)
		{
			if($sql_select_coupon_check['online_redeem'] == 1){
			//if($sql_select_coupon_check['minimum_order_amount'] < $cart_amount)
			//{
		?>
       	 <input type="submit" name="apply" value="Apply" class="coupon-apply" />
        <?php
			//}
			}else{
				if(isset($_SESSION['customer_id'])){
				 ?>
				 <a class="various6 coupon-apply" href="#inline<?php echo $array_coupons['id'];?>" title="<?php echo $array_coupons['coupon_name'];?>" style="text-decoration:none;">Print Coupon</a>  
		<?php }else{ ?>
				 <a href="login.php" class="coupon-apply" style="text-decoration:none;">Print Coupon</a>
        <?php			
				}
				}
		}
		?>
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
<?php if($array_coupons['coupon_code']!=''){?>
Coupon Code : <span class="cupon-code" style="font-weight:bold;"><?php echo $array_coupons['coupon_code']; ?></span>
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
                            <input type="hidden" name="hid_res_id" value="<?php echo $_REQUEST['id']; ?>" />
                            </form>
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
                    
                    <div class="social_image social_image2">

                            <div class="soc_icon">
                            <?php /*?><a href="http://www.facebook.com/share.php?u=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>"  target="_blank"><?php */?>
                            <a href="javascript:void(0);" onClick="FBShareOp('<?php echo $sql_restaurant['restaurant_name']; ?>','<?php echo $sql_restaurant['id']; ?>','<?php echo $sql_restaurant['restaurant_image']; ?>','<?php echo $sql_restaurant['restaurant_category_name']; ?>','uploaded_images')">
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
                            
                            <div class="soc_icon"><iframe src="http://www.facebook.com/plugins/like.php?href=http://foodandmenu.com/restaurant.php?id=<?php echo $_REQUEST['id']?>&layout=standard&show_faces=false&width=450&action=like&colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:330px; height:24px;"></iframe></div>
                            
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

