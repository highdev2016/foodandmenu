<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<?php 
ob_start();
session_start();
//print_r($_SESSION);
include("includes/header_profile.php");
include("includes/functions.php");
include("admin/lib/conn.php");

if(isset($_SESSION['customer_id'])){}
else{
header("location:login.php?reservation=1");
$_SESSION['resttid'] = $_REQUEST['id'];
exit();
}
?>

<style type="text/css">
#fade11{
	width: 100%;
	height: 800px;
	position: fixed;
	z-index: 50;
	background: rgb(223, 105, 0);
	opacity: 0.5;
}
.controls {
	margin-top: 16px;
	border: 1px solid transparent;
	border-radius: 2px 0 0 2px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	height: 32px;
	outline: none;
	box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#address {
	background-color: #fff;
	padding: 0 11px 0 13px;
	width: 400px;
	font-family: Roboto;
	font-size: 15px;
	font-weight: 300;
	text-overflow: ellipsis;
}

#address:focus {
	border-color: #4d90fe;
	margin-left: -1px;
	padding-left: 14px;  /* Regular padding-left + 1. */
	width: 401px;
}

.pac-container {
	font-family: Roboto;
	z-index:9999999999999999999999999999999999 !important;
	font-family: Calibri !important;
	font-size:14px !important;
}

#map-canvas{
  display:none;
}

.stick_header{
	position: relative;
}

.header_back{
	height: 80px;
}

</style>

<body onLoad="init();">

<?php if($_REQUEST['error_msg']!=''){ $display = 'block'; } else { $display = 'none'; } ?> 

<div id="fade11" style="display:<?php echo $display; ?>"></div>

<div style="width:400px; height:1px; margin:0 auto; display:<?php echo $display;?>" id="light">
<div  style="width:380px; position:absolute; z-index:9999999; background:#fff; padding:0; color:#000; font-family:Calibri; font-size:18px; height:105px; -moz-box-shadow: 0 0 5px #888;-webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888; text-align:center; margin-top:200px; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; border:#2C4598 2px solid;">
<div class="slide_head" style="padding: 20px 16px;"></div>
<?php 
if(($_REQUEST['error_msg'] == 1) || ($_REQUEST['error_msg'] == 3) || ($_REQUEST['error_msg'] == 4)){
	$style = 'margin-left: 302px; position: absolute; margin-top: -32px; cursor:pointer;';
}
else if($_REQUEST['error_msg'] == 2){
	$style = 'margin-left: 272px; position: absolute; margin-top: -32px; cursor:pointer;';
}
else if($_REQUEST['error_msg'] == 5){
	$style = 'margin-left: 247px; position: absolute; margin-top: -32px; cursor:pointer;';
}else if($_REQUEST['error_msg'] == 6){
	$style = 'margin-left: 305px; position: absolute; margin-top: -32px; cursor:pointer;';
}
else if($_REQUEST['error_msg'] == 7){
	$style = 'margin-left: 158px; position: absolute; margin-top: -32px; cursor:pointer;';
}
else if($_REQUEST['error_msg'] == 8){
	$style = 'margin-left: 299px; position: absolute; margin-top: -32px; cursor:pointer;';
}
?>

<a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade11').style.display='none';document.getElementById('fade').style.display='none'"><img src="images/cross.png" style="<?php echo $style; ?>"/></a>
<p class="pop_txt_new"><?php if($_REQUEST['error_msg'] == 1){ echo "We cannot locate you.Please be more specific."; }
else if($_REQUEST['error_msg'] == 2){ echo "Items successfully added to cart"; }
else if($_REQUEST['error_msg'] == 3){ echo "Your address is not within our delivery range"; }
else if($_REQUEST['error_msg'] == 4){ echo "This restaurant does not give pickup or delivery"; }
else if($_REQUEST['error_msg'] == 5){ echo "Item deleted successfully"; }
else if($_REQUEST['error_msg'] == 6){ echo "Your Request has been sent Successfully."; }
else if($_REQUEST['error_msg'] == 7){ echo "Reservation Sent Successfully."; }
else if($_REQUEST['error_msg'] == 8){ echo "Minimum order amount for this coupon has not reached. Please add more items to your cart."; } ?></p>            
</div></div>


<?php //include ("includes/top_search.php");?>

<?php //include ("includes/menu_section.php");?>
<?php include ("includes/header_inner_new.php"); ?>
<div class="body_section">
    <div class="container">
        <div class="body_top"></div>
        <div class="main_body">
            <div class="food_body_cont">
                <div class="food_content">
                
                    
                    <?php include("includes/restaurant_top.php");?>
                    
                    <div class="accr_menu" <?php /*?>id="tab"<?php */?>>
                        <?php include('includes/tab_menu.php');?>
                        </div>
                    
					<div class="profile_details">

                    <div class="profile_details_top">
                    <h1>Online Reservation Details</h1>
                    </div>
                    
                    <div class="profile_details_bottom">
                    
                    <div class="profile_left">
                    
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
				window.location="https://foodandmenu.com/reservation.php?id="+rest_id+"&error_msg=7";
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
                    
                    <div class="profle_bottom reserve_details_left_sec">
                    <h1>Please Enter Reservation Information Below</h1>
                    <form name="reservation_form" method="post" action="" onSubmit="return check_validation();">
                    <input type="hidden" name="rest_id" id="rest_id" value="<?php echo $_REQUEST['id']; ?>" />
                    <p>Date * :</p>
                    <input name="post_date_test" id="post_date_test" type="text"  class="profilefield timepicker" readonly value="<?php echo date('m-d-Y'); ?>" >&nbsp;<span class="mnth_dte_sec">(mm/dd/yyyy)</span>
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
                    
                    <select name="special_occasions" id="special_occasions" class="profilefield" style="height:25px; width:205px;" onChange="open_div(this.value)">
                    
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
                    <input name="customer_name" id="customer_name" type="text"  class="profilefield" value="<?php echo $row_cust_email['firstname']." ".$row_cust_email['lastname']; ?>" readonly/>
                    <div class="clear"></div>
                    
                    <p>Contact Email * :</p>
                    <input name="contact_email" id="contact_email" type="text"  class="profilefield" value="<?php echo $row_cust_email['email']; ?>" readonly />
                    <div class="clear"></div>
                    
                    <p>Phone No. :</p>
                    <input name="customer_phone" id="customer_phone" type="text"  class="profilefield" value="<?php echo $row_cust_email['phone']; ?>" onKeyPress="return goodchars(event,'1234567890+-');" readonly/>
                    <div class="clear"></div>
                    
                    <p>Additional Comments * :</p>
                    <textarea name="comments" id="comments" cols="" rows="" class="profilearea"></textarea>
                    
                    <div class="clear"></div>
                    
                    <p>Captcha * :</p>
                    <img src="captcha_code_file.php?rand=<?php echo rand();?>" id='captchaimg' style="margin-left:15px;">
                    <div class="clear"></div>
                    <span style="color:#595959; font-family:Arial,Helvetica,sans-serif; font-size:13px; padding-left:142px;">Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</span>
                    <div class="clear"></div>
                    
                    <input id="captcha_code" name="captcha_code" type="text"  class="profilefield_right" style="margin-right:93px"/>
                    <div class="clear"></div>
                    
                    <div id="cap_error_msg" style="color:#ff0000; margin-left:140px; display:none;">The Validation code does not match! </div>
                    
                    <!--<input class="profilebutton" type="submit" value="Submit" name="submit" onclick="return check_time_reservation();">-->
                    <input class="profilebutton" type="button" value="Submit" name="submit" onClick="return check_validation();" style="float:left;">
                    <div id="loader_div" style="float:left; display:none; padding-left:20px; padding-top:10px;" ><img src="images/ajax-loader-review.gif" /></div>
                    <div style="clear:both;"></div>
                    
                    <input type="hidden" name="hid_res_id" id="hid_res_id" value="<?php echo $_REQUEST['id']; ?>"  />
                    </form>
                    
                    
                    </div>
                    
                    
                    </div>
                    <?php
					$get_reservation_hrs = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_business_delivery_takeout_info WHERE restaurant_id = '".$_REQUEST['id']."'"));
					?>
                    <div class="profile_middle_left reservation_hr">
                    <h2>Reservation Hours</h2>
                    <ul>
                    <li class="profile_li_class"> <span>Monday Reservation Hours</span> <span class="pro_sign">:</span> <?php echo date("g:i A", strtotime($get_reservation_hrs['reservation_open_Monday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Monday'])); ?></li>
                    <li class="profile_li_class"> <span>Tuesday Reservation Hours</span> <span class="pro_sign">:</span> <?php echo date("g:i A", strtotime($get_reservation_hrs['reservation_open_Tuesday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Tuesday'])); ?></li>
                    <li class="profile_li_class"> <span>Wednesday Reservation Hours</span> <span class="pro_sign">:</span> <?php echo date("g:i A", strtotime($get_reservation_hrs['reservation_open_Wednesday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Wednesday'])); ?></li>
                    <li class="profile_li_class"> <span>Thursday Reservation Hours</span> <span class="pro_sign">:</span> <?php echo date("g:i A", strtotime($get_reservation_hrs['reservation_open_Thursday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Thursday'])); ?></li>
                    <li class="profile_li_class"> <span>Friday Reservation Hours</span> <span class="pro_sign">:</span> <?php echo date("g:i A", strtotime($get_reservation_hrs['reservation_open_Friday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Friday'])); ?></li>
                    <li class="profile_li_class"> <span>Saturday Reservation Hours</span> <span class="pro_sign">:</span> <?php echo date("g:i A", strtotime($get_reservation_hrs['reservation_open_Saturday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Saturday'])); ?></li>
                    <li class="profile_li_class"> <span>Sunday Reservation Hours</span> <span class="pro_sign">:</span> <?php echo date("g:i A", strtotime($get_reservation_hrs['reservation_open_Sunday']))." - ".date("g:i A", strtotime($get_reservation_hrs['reservation_close_Sunday'])); ?></li>
                    </ul>
                    
                    </div>
                    <?php
					$get_disclaimers = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_cms WHERE id = '13'"));
					?>
                    <div class="profile_middle_left reservation_hr">
                    
                    <h2>Disclaimers</h2>
                    <span style="font-weight:bold;"><?php echo htmlspecialchars_decode($get_disclaimers['description']); ?></span>
                    
                    </div>
                    
                       <div class="clear"></div> 
                    </div>
                </div>
            	<div class="clear"></div>
            	
            </div>
            
                <div class="clear"></div>
                <div class="tab_body_cont"></div>
            <div class="body_footer_bg"></div>
        </div>
        
        <div class="clear"></div>
    </div>
</div>
</div>

<div class="clear"></div>

<script type="text/javascript" src="javascript/prototype.js"></script>
	<script type="text/javascript" src="javascript/effects.js"></script>
	<script type="text/javascript" src="javascript/accordion.js"></script>
	<script type="text/javascript" src="javascript/code_highlighter.js"></script>
	<script type="text/javascript" src="javascript/javascript.js"></script>
	<script type="text/javascript" src="javascript/html.js"></script>
 <script type="text/javascript">
		jQuery(document).ready(function() {
			

			jQuery("#various1").fancybox({
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

<?php include("includes/footer_new.php");?>