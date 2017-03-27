<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="google-site-verification" content="XDKvinsWwsT8egonri02KDnOicDihl8XokqxsjL-C6M" />
<meta name="msvalidate.01" content="98593D957300F985A120634549B94AC9" />
<link rel="shortcut icon" href="https://www.foodandmenu.com/favicon.ico" type="image/x-icon"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1">
<title>food & menu</title>
<link rel='stylesheet' id='camera-css'  href='css/camera.css' type='text/css' media='all'> 
<link rel='stylesheet' id='camera-css'  href='css/ui.totop.css' type='text/css' media='all'> 
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<!--for banner section -->


<script type="text/javascript">
var baseUrl = 'https://foodandmenu.com/';
</script>

<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>

<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.10/themes/smoothness/jquery-ui.css" type="text/css">

    
    
    
    <script type='text/javascript' src='js/jquery.ui.totop.js'></script> 
    
    <script type="text/javascript">
		$(document).ready(function() {
			/*
			var defaults = {
	  			containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		};
			*/
			
			$().UItoTop({ easingType: 'easeOutQuart' });
			
		});
	</script>
<!--end of banner-->



</head>





<link rel="stylesheet" href="css/demo.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="js/resturent.js"></script>

<script type="text/javascript">

$(document).mouseup(function (e)
{
    var favourite = $("#favourite_div");
	var follower = $("#follower_div");
	var following = $("#following_div");
	var following_req = $("#following_req_div");
	var notification = $("#notification_div");
	var block = $("#block_users_div");
	

   	if (!favourite.is(e.target) // if the target of the click isn't the container...
        && favourite.has(e.target).length === 0) // ... nor a descendant of the container
    {
        favourite.hide();
    }
	
	if (!follower.is(e.target) // if the target of the click isn't the container...
        && follower.has(e.target).length === 0) // ... nor a descendant of the container
    {
        follower.hide();
    }
	
	if (!following.is(e.target) // if the target of the click isn't the container...
        && following.has(e.target).length === 0) // ... nor a descendant of the container
    {
        following.hide();
    }
	
	if (!following_req.is(e.target) // if the target of the click isn't the container...
        && following_req.has(e.target).length === 0) // ... nor a descendant of the container
    {
        following_req.hide();
    }
	
	if (!notification.is(e.target) // if the target of the click isn't the container...
        && notification.has(e.target).length === 0) // ... nor a descendant of the container
    {
        notification.hide();
    }
	
	if (!block.is(e.target) // if the target of the click isn't the container...
        && block.has(e.target).length === 0) // ... nor a descendant of the container
    {
        block.hide();
    }
});

	
function follow_user(user_id,follow_id)
{
	var hid_user_id = $('#hid_user_id').val();
	if(user_id != '')
	{
		$.ajax({
			url : 'user_follow.php',
			type : 'POST',
			data : 'user_id=' + user_id + '&follow_id=' + follow_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				if(data != "You have already Followed this user!!")
				{
					new_data = data.split("^");
					
					$("#follow_li").hide().html(new_data[0]).fadeIn(1000);
					$("#following_span").html(new_data[2]);
					$("#follower_span").html(new_data[1]);
				}
				else
				{
					alert(data);
					window.location.href='user.php?id='+follow_id;
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
		window.location.href='login.php?user_id='+hid_user_id;
	}
}


function accept_reject_request(id,val)
{
	//alert(val);
	var hid_user_id = $('#hid_user_id').val();
	
	$.ajax({
			url : 'accept_reject_user.php',
			type : 'POST',
			data : 'id=' + id + '&val=' + val + '&follow_id=' + hid_user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				var data_new = data.split("^");
				
				$("#div_acc_rej"+id).fadeOut(1000);
				$("#follower_span").html(data_new[2]);
				$("#following_span").html(data_new[1]);
				
				location.reload();
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}


function confirm_user_blk(id,blk_status){
	
	var follower_count = $("#follower_span").html();
	var block_count = $("#block_users_span").html();
	
	$.ajax({
			url : 'confirm_block_users.php',
			type : 'POST',
			data : 'id=' + id + '&blk_status=' + blk_status ,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				/*var data_new = data.split("^");
				
				$("#div_acc_rej"+id).fadeOut(1000);
				$("#follower_span").html(data_new[2]);
				$("#following_span").html(data_new[1]);
				
				 location.reload();*/
				 
				 if(data!=''){
					 $('#rem_user_follow'+data).fadeOut(1000); 
				 }
				 $("#block_confirm_user"+id).css("visibility", "hidden").css("opacity", "0");
				 $("#fade1").hide();
				 
				var new_count = parseInt(follower_count) - parseInt(1);
				var new_block_count = parseInt(block_count) + parseInt(1);
    
   				 $("#follower_span").html(new_count);
				 $("#block_users_span").html(block_count);
				 
				 
				 
				 
				 
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}

function open_favourite_div()
{
	$("#block_users_div").hide();
	$("#notification_div").hide();
	$("#following_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").slideDown();
}

function open_notification_div()
{
	$("#block_users_div").hide();
	$("#following_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#notification_div").slideDown();
}

function open_follower_div()
{
	$("#block_users_div").hide();
	$("#notification_div").hide();
	$("#following_div").hide();
	$("#favourite_div").hide();
	$("#follower_div").slideDown();
}

function open_following_div()
{
	$("#block_users_div").hide();
	$("#notification_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#following_div").slideDown();
}

function open_following_req_div()
{
	$("#block_users_div").hide();
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#following_div").hide();
	$("#following_req_div").slideDown();
}

function open_block_users_div()
{
	$("#follower_div").hide();
	$("#favourite_div").hide();
	$("#following_div").hide();
	$("#following_req_div").hide();
	$("#block_users_div").slideDown();
}

function sort_date(user_id)
{
	$("#loader_div").show();
	$("#main_res_div").addClass('load-faad');
	$("#hid_sort_type").val('id');
	$("#hid_count").val('10');
	
	var sort_type = $("#hid_sort").val(); 
	

	$.ajax({
			url : 'sort_data.php',
			type : 'POST',
			data : 'sort_type=' + sort_type + '&user_id=' + user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				$("#main_res_div").html(data);
				
				
				//setTimeout(function(){$("#loader_div").hide(); $("#main_res_div").removeClass('load-faad')}, 5000);
				//$("#loader_div").hide();
				
				$("#loader_div").hide(); 
				$("#main_res_div").removeClass('load-faad');
				
				if(sort_type == "DESC")
				{
					$("#hid_sort").val('ASC');
				}
				if(sort_type == "ASC")
				{
					$("#hid_sort").val('DESC');
				}
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}

function sort_rating(user_id)
{
	$("#loader_div").show();
	$("#main_res_div").addClass('load-faad');
	$("#hid_sort_type").val('score');
	$("#hid_count").val('10');
	
	var sort_type = $("#hid_sort").val(); 
	

	$.ajax({
			url : 'rating_data.php',
			type : 'POST',
			data : 'sort_type=' + sort_type + '&user_id=' + user_id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				
				$("#main_res_div").html(data);
				
				
				//setTimeout(function(){$("#loader_div").hide(); $("#main_res_div").removeClass('load-faad')}, 5000);
				//$("#loader_div").hide();
				
				$("#loader_div").hide();
				$("#main_res_div").removeClass('load-faad');
				
				if(sort_type == "DESC")
				{
					$("#hid_sort").val('ASC');
				}
				if(sort_type == "ASC")
				{
					$("#hid_sort").val('DESC');
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

<script type="text/javascript">
function open_slider_div(id)
{
	
	$("#slider_div"+id).css("visibility", "visible").css("opacity", "100");
	$("#fade1").show();
}

function close_slider_div(id)
{
	
	$("#slider_div"+id).css("visibility", "hidden").css("opacity", "0");
	$("#fade1").hide();
}

function get_confirm(id){
	$("#block_confirm_user"+id).css("visibility", "visible").css("opacity", "100");
	$("#fade1").show();
}

function close_block_confirm_user_div(id){
	$("#block_confirm_user"+id).css("visibility", "hidden").css("opacity", "0");
	$("#fade1").hide();
}
</script>


<script type="text/javascript">

$(function()
{
$('.more').live("click",function()
{
var ID = $(this).attr("id");
var cust_id = $("#cust_id").val();
var hid_count = $("#hid_count").val();
var sort_date_type = $("#hid_sort").val();
var sorting_type = $("#hid_sort_type").val();
//alert(ID);
if(sort_date_type == "DESC")
{
	var sort_type = "ASC";
}
if(sort_date_type == "ASC")
{
	var sort_type = "DESC";
}

//alert(hid_count);
if(ID)
{
$("#more"+ID).html('<img src="images/moreajax.gif" />');

$.ajax({
type: "POST",
url: "ajax_user.php",
data: "lastmsg="+ ID + "&cust_id=" + cust_id + "&new_count=" + hid_count + '&sort_type=' + sort_type + '&sorting_type=' + sorting_type,
cache: false,
success: function(html){
	//alert(html);
var new_hid_count = parseInt(hid_count) + parseInt(5);	
$("#main_res_div").append(html);
$("#more"+ID).remove(); // removing old more button
$("#hid_count").val(new_hid_count);
}
});
}
else
{
$(".morebox").html('The End');// no results
}

return false;
});
});

function remove_user_block(id)
{
	var block_count = $("#block_users_span").html();
	//var hid_user_id = $('#hid_user_id').val();
	
	$.ajax({
			url : 'remove_block_user.php',
			type : 'POST',
			data : 'id=' + id,
			//dataType : 'json',
			beforeSend : function(jqXHR, settings ){
				//alert(url);
			},
			success : function(data, textStatus, jqXHR){
				//alert(data);
				var new_count = parseInt(block_count) - parseInt(1);
				
				$("#block_users_span").html(new_count);
				
				$("#div_block_user"+id).fadeOut(1000);
				
				if(new_count == 0)
				{
					$("#block_users_div").remove();
				}
				
				 //location.reload();
				
			},
			/*complete : function(jqXHR, textStatus){
				alert(3);
			},*/
			error : function(jqXHR, textStatus, errorThrown){
			}
		});
}


</script>
<script type="text/javascript" src="https://foodandmenu.com/js/jquery.fancybox-1.3.4.pack.js"></script>
 <link rel="stylesheet" type="text/css" href="https://foodandmenu.com/css/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
	
	//var $j = jQuery.noConflict();
	
  $(document).ready(function() {
   /*
   *   Examples - images
   */
   
   
   $("a.example_cat").fancybox({
    'titlePosition' : 'inside'
   });

   
  });
 </script>
 
 



<body>


<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery(".slidingDiv").hide();
    jQuery(".show_hide").show();
    jQuery('.show_hide').click(function(){
        jQuery(".slidingDiv").slideToggle();
    });
});
</script>

<script type="text/javascript">
function close_city_div()
{
	document.getElementById('slidingDiv').style.display="none";
}
</script>

<style type="text/css">

.slidingDiv{
	display:none;
}
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<!--<script src="//code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">




<script type="text/javascript">
function validate(){
	if(document.getElementById('city_address').value == ''){
		alert('Please enter city.');
		document.getElementById('city_address').focus();
		return false;
	}
	return true;
}
</script>

<div class="slidingDiv" id="slidingDiv">
<div id="fadenw"></div>
<div id="level_div">
<div class="popup_main">
<div class="popup_form_container">
<div class="close_butt"><a href="#" onClick="close_city_div();"><img src="images/close-butt.png" width="30" height="29" /></a></div>
<div class="popup_bg">
<form name="myfrm_city" method="post" action="" onSubmit="return validate();">
<div class="popup_inner_bg">

<div class="free_membership"><a href="signup.php"><img src="images/free_membership.png" width="125" height="124" /></a></div>

<div class="inner_bg_top" style="padding-top:15px;">
<h1>your city for less</h1>
<p>Get up to 80% off great deals on restaurant in your local city !!!</p>
</div>

<div class="clear"></div>

<div class="popup_divider"><img src="images/popup_divider.png" width="507" height="21" /></div>


<div class="inner_bg_middle">

<p>What city would you like?</p>
<input name="city_address" id="city_address" type="text" class="popup_textfield city_add" autocomplete="off" value="" />


<div class="clear"></div>


</div>

<div class="continue_button">
<input name="submit" type="submit" value="Continue" class="button_pop" /> 
<div class="clear"></div>
</div>

<div class="button_text">
<!--<p>By subscribing, I agree to the terms service and privacy and policy</p>-->
</div>

<div class="inner_bg_bottom">
	<a href="login.php"><img src="images/member_sign_button.png" width="141" height="48" /> </a>
</div>

</div>
</form>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>

</div>

</div>

</div>



<script type="text/javascript">
var suggestions = new Array("houston,tx","austin,tx","dripping springs,tx","round rock,tx","cedar park,tx","hutto,tx","georgetown,tx","kyle,tx","west lake hills,tx","pflugerville,tx","biloxi,ms","college station,tx","hearne,tx ","spicewood,tx","bryan,tx","lakeway,tx","marble falls,tx","del valle,tx","buda ,tx ","sunset valley,tx","san antonio,tx","dallas,tx","duncanville,tx","ingleside,tx","corpus christi,tx","helotes,tx","abilene,tx","addison,tx","san angelo,tx","san angelo�,tx","manchaca,tx","san jose,ca","jacksonville,fl","naples,fl","phoenix,az""houston,tx","austin,tx","dripping springs,tx","round rock,tx","cedar park,tx","hutto,tx","georgetown,tx","kyle,tx","west lake hills,tx","pflugerville,tx","biloxi,ms","college station,tx","hearne,tx ","spicewood,tx","bryan,tx","lakeway,tx","marble falls,tx","del valle,tx","buda ,tx ","sunset valley,tx","san antonio,tx","dallas,tx","duncanville,tx","ingleside,tx","corpus christi,tx","helotes,tx","abilene,tx","addison,tx","san angelo,tx","san angelo�,tx","manchaca,tx","san jose,ca","jacksonville,fl","naples,fl","phoenix,az","77002","78748","78749","78747","78745","78620","78730","78665","78603","78613","78753","78681","78701"," 78729","78727","78746","78664","78758","78731","78752","78741","78705","78634","78704","78702","78759","78750","78703"," 78751","78729","78626","78640","78757"," 78746","78722","78751"," 78737"," 78750","78723"," 78759"," 78703","78738","78717"," 78613","78660","78735","39530","77072","78732","78734","77840"," 77840"," 77845"," 77002"," 77598","77859","77053","78721","78669","78798","78756","77003","77845","77807","77803","77006","77010","77056","77005"," 78745","78744","78728"," 78732 "," 78705"," 78704"," 78752"," 78756"," 78701"," 78758","77030","77042","77057","78739","77011","77027"," 78724"," 78722","78654","78754","78617"," 78753","78757`","78610"," 78640","78726","78725","78736"," 78749"," 78201","78201","78228","75201","78221","78230","78232","78213","75137","78362","78411","78401","75202","78023","78202","78203","78210","78204","78404","78413"," 75201","75206","75205","78402","78412","78418","78405","78410","78415","78205","78245","78215","78212","78214","78217","78240","78250","78209","78251","78223","78254","78264","78227","78253","78219","78216","78207","78224","78252","78237","78249","78208","78260","78211","78226","78258","78248","78233","78247","78231","78278","78220","78225","78222","78052","78218","78255","78256","78229","78257","78259","78266","78244","78261","78238","78234","78163","78235","78025","78152","78243","78242","78263","78239","79606","79607","79602","79601","79603","79605","79698","75001","75244","75248","75240","75204","75234","39532","77808","77802","77801","78155","77843","76903","76901","76905","76904","76909","78652","","95126","32207","34102","85018");
<!-- Declare the array and store the values according to ur usage -->
// var suggestions = new Array("bank", "back", "peter","hindu","huge", "test","bums","cat","kind","fight","argue","append","run","sad","silk","light","little","rate","orange","office","lucky","cable","monitor","narration","early","pick","put","hungry","gain","gift","java","junction","vegtable","fan","north","needle","winter","nation","carry","dance","danger","iteration","facile","yahoo","quick","quee","arrangement","vechicle","urban","xerox","zeebra","xML");
var outp;
var oldins;
var posi = -1;
var words = new Array();
var input;
var key;
function setVisible(visi)
{
  var x = document.getElementById("shadow");
  var t = document.getElementsByName("full_address")[0];
  x.style.position = 'absolute';
  x.style.top = (findPosY(t)+3)+"px";
  x.style.left = (findPosX(t)+2)+"px";
  x.style.visibility = visi;
}
function init()
{
  outp = document.getElementById("output");
  window.setInterval("lookAt()", 100);
  setVisible("hidden");
  document.onkeydown = keygetter; //needed for Opera...
  document.onkeyup = keyHandler;
}
function findPosX(obj)
{
  var curleft = 0;
  if (obj.offsetParent)
  {
    while (obj.offsetParent)
    {
      curleft += obj.offsetLeft;
      obj = obj.offsetParent;
    }
   }
  else if (obj.x)
    curleft += obj.x;
        return curleft;
}
function findPosY(obj)
{
  var curtop = 0;
  if (obj.offsetParent)
  {
    curtop += obj.offsetHeight;
    while (obj.offsetParent)
    {
      curtop += obj.offsetTop;
      obj = obj.offsetParent;
     }
   }
   else if (obj.y)
   {
     curtop += obj.y;
     curtop += obj.height;
   }
   return curtop;
}
function lookAt()
{
   var ins = document.getElementsByName("full_address")[0].value;
   if (oldins == ins)
      return;
   else if (posi > -1);
   else if (ins.length > 0)
   {
     words = getWord(ins);
     if (words.length > 0)
     {
        clearOutput();
        for (var i=0;i < words.length; ++i)
             addWord (words[i]);
        setVisible("visible");
        input = document.getElementsByName("full_address")[0].value;
     }
     else
     {
        setVisible("hidden");
        posi = -1;
     }
   }
   else
   {
    setVisible("hidden");
    posi = -1;
   }
   oldins = ins;
}
function addWord(word)
{
  var sp = document.createElement("div");
  sp.appendChild(document.createTextNode(word));
  sp.onmouseover = mouseHandler;
  sp.onmouseout = mouseHandlerOut;
  sp.onclick = mouseClick;
  outp.appendChild(sp);
}
function clearOutput()
{
  while (outp.hasChildNodes())
  {
    noten=outp.firstChild;
    outp.removeChild(noten);
  }
   posi = -1;
}
function getWord(beginning)
{
  var words = new Array();
  for (var i=0;i < suggestions.length; ++i)
   {
    var j = -1;
    var correct = 1;
    while (correct == 1 && ++j < beginning.length)
    {
		var charExists = (suggestions[i].indexOf(beginning) >= 0) ? true : false;
     //if (suggestions[i].charAt(1) != beginning.charAt(j))
         correct = 0;
    }
    if (charExists == true)
       words[words.length] = suggestions[i];
  }
    return words;
  
}       
function setColor (_posi, _color, _forg)
{
   outp.childNodes[_posi].style.background = _color;
   outp.childNodes[_posi].style.color = _forg;
}
function keygetter(event)
{
  if (!event && window.event) 
      event = window.event;
  if (event)
      key = event.keyCode;
  else
      key = event.which;
}
function keyHandler(event)
{
  if (document.getElementById("shadow").style.visibility == "visible")
  {
     var textfield = document.getElementsByName("full_address")[0];
     if (key == 40)//key down
     { 
        if (words.length > 0 && posi <= words.length-1)
        {
          if (posi >=0)
            setColor(posi, "#fff", "black");
          else 
             input = textfield.value;
             setColor(++posi, "blue", "white");
             textfield.value = outp.childNodes[posi].firstChild.nodeValue;
        }
      }
      else if (key == 38)
      { //Key up
        if (words.length > 0 && posi >= 0)
         {
           if (posi >=1)
           {
              setColor(posi, "#fff", "black");
              setColor(--posi, "blue", "white");
              textfield.value = outp.childNodes[posi].firstChild.nodeValue;
           }
           else
           {
              setColor(posi, "#fff", "black");
              textfield.value = input;
              textfield.focus();
              posi--;
           }
         }
        }
         else if (key == 27)
         { // Esc
            textfield.value = input;
            setVisible("hidden");
            posi = -1;
            oldins = input;
          }
          else if (key == 8) 
          { // Backspace
            posi = -1;
            oldins=-1;
          } 
              }
   }
    var mouseHandler=function()
    {
      for (var i=0; i < words.length; ++i)
        setColor (i, "white", "black");
      this.style.background = "blue";
      this.style.color= "white";
     }
     var mouseHandlerOut=function()
     {
       this.style.background = "white";
       this.style.color= "black";
     }
     var mouseClick=function()
     {
        document.getElementsByName("full_address")[0].value = this.firstChild.nodeValue;
        setVisible("hidden");
        posi = -1;
        oldins = this.firstChild.nodeValue;
     }
</script>
<style type="text/css">

.output
{
        font-family:Arial;
        font-size: 10pt;
        color:black;
        padding-left: 3px;
        padding-top: 3px;
        /*border: 1px solid #c9c9c9;*/
        width: 226px;
        background: #fff;
}
.shadow
{
        width:102px;
        position:relative;
        top: 2px;
        left: 2px;
       /* background: #555;*/
}
.shadow div
{
        position:relative;
        top: -2px;
        left: -2px;
		/*z-index: 2147483647;*/
		z-index: 214;
}
.output div
{
		padding:3px 0 !important;
}
#output
{
		max-height:141px !important;
		overflow:auto;
}
</style><div class="header_section">

<div class="header_top">

<div class="header_container">
<div class="logo_left">
<a href="home.php?city=austin"><img src="images/logo.png" width="173" height="99" /></a>
</div>

<div class="search_right">

<form name="frm_search" id="frm_search" action="search_area.php" method="get">
<div class="search_box">

<div class="left_search">
    <p class="left_search">What are you looking for?<span class="left_search_two">( Restaurant, Cuisine )</span></p>
    <input name="rest_item" id="rest_item" type="text" class="search_textfield" value="" />
</div>


<div class="search_button"><input name="btn_search" id="btn_search" type="submit" value="search" class="button2"/></div>
<p class="city_top">Your City : austin,tx</p>
<div class="change_city">
	<h1>Change City</h1>
    
    <p><a href="#" class="show_hide">Click Here</a></p>

</div>

<div class="clear"></div>

</div>
</form>

</div>

<div class="clear"></div>
</div>

</div>
</div>
<div class="clear"></div>
 


  
<div class="menu_section">

<div class="menu_container">

<div class="left_menu">
<ul>
<li><a href="home.php" >Home</a></li>
<li><a href="contact.php" >Contact Us</a></li>
<li><a href="vendor.php" >vendors</a></li>
<li><a href="http://foodandmenu.com/blog">Blog</a></li>
</ul>


</div>


<div class="right_menu" style="width:auto;">
<div class="login_section" style="width:auto;">

<ul style="padding-left:15px; padding-right:15px;">
<li><span style="cart_text">15</span>
<a href="cart.php" style="float:left;"><img src="images/cart.png" width="20" height="20"  style="margin-top:5px; padding-right:5px;"/></a>
</li>
<li>Welcome , Priya123</li>   
<li>|</li>  
<li><a href="user_profile.php">User profile</a></li>   
<li>|</li>  
<li><a href="logout.php">Logout</a></li>


</ul>
</div>
</div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>


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
			
			jQuery(".various5").fancybox({
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
			
			jQuery(".various7").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
	</script>
<input type="hidden" name="cust_id" id="cust_id" value="205" />

<input type="hidden" name="hid_user_id" id="hid_user_id" value="205">

	<div class="body_section">
	
		<div class="body_container">
			<div class="body_top"> </div>
			<div class="main_body">
			
				<div class="contact_body_cont" style="min-height:600px;">
				
					<div class="user-profile-section">
						
						<div class="user-profile-top">
							<div class="profile-name">
                            
								<h1>Chef's Profile</h1>
							</div>
							<div class="follow-section">
								<ul>
                                	
                                    
									<li>
										 <a href="javascript:void(0);" style="cursor:text;">
											 <img src="images/star-on.png" /> <strong> Reviews</strong> <br />
											 <span>24</span>
										 </a>
									</li>
                                    
                                    									<li>
										 <a href="javascript:void(0);" onClick="open_following_div();">
											<strong>Following</strong> <br />
											 <span id="following_span">2</span>
										 </a>
										 <div id="following_div" style="display:none;">
										 	<img src="images/tool-arrow.png" alt="" />
		                                    <a href='user.php?id=51' style='color:#4E7AD5'>Arturo STEWART</a><a href='user.php?id=455' style='color:#4E7AD5'>Food STEWART</a>	                                    </div> 
									</li>
                                                                        
                                    									<li>
										 <a href="javascript:void(0);" onClick="open_follower_div();">
											<strong>Followers</strong> <br />
											 <span id="follower_span">2</span>
										 </a>
										 
										 <div id="follower_div" style="display:none;">
										 	<img src="images/tool-arrow.png" alt="" />
		                                    <div class='cancel-img-2' style='position:relative;' id='rem_user_follow11'><a href='user.php?id=269' style='color:#4E7AD5; border-bottom:0;'>Nina Lee</a><a class='cross-img' href='javascript:void(0);' onClick='return get_confirm(11)'><img src='images/1417787649_button_cancel.png' style='margin-top: 18px;'></a><div class='clear'></div></div><div class='cancel-img-2' style='position:relative;' id='rem_user_follow29'><a href='user.php?id=455' style='color:#4E7AD5; border-bottom:0;'>Food Lover</a><a class='cross-img' href='javascript:void(0);' onClick='return get_confirm(29)'><img src='images/1417787649_button_cancel.png' style='margin-top: 18px;'></a><div class='clear'></div></div>                                     <div class="clear"></div>
		                                </div> 
                                        
                                        
									</li>
                                                                        
                                    									<li>
										 <a href="javascript:void(0);" onClick="open_favourite_div();">
											<strong>Favorites</strong> <br />
											 <span>5</span>
										 </a>
										 
										 <div id="favourite_div" style="display:none;" class="favo">
										 	<img src="images/tool-arrow.png" alt="" />
		                                    <a href='restaurant.php?id=105059' style='color:#4E7AD5'>Tuk Tuk Thai Café</a>  <a href='restaurant.php?id=105127' style='color:#4E7AD5'>The Original New Orleans Po-Boy and Gumbo Shop</a>  <a href='restaurant.php?id=1194' style='color:#4E7AD5'>Mimis Asian Fusion</a>  <a href='restaurant.php?id=105069' style='color:#4E7AD5'>Bamboo Bistro - South Austin</a>  <a href='restaurant.php?id=77198' style='color:#4E7AD5'>Crawfish Shack & Oyster Bar</a>  		                                </div>    
									</li>
                                    
                                    										<li class="big-text">
										 <a href="javascript:void(0);">
											<strong>Following Request</strong> <br />
											 <span id="following_req_span">0</span>
										 </a>
										 </li>
									
                                    
                                    
                                    
                                    
                                    
                                    
                                    											<li id="follow_li">
												 <a href="javascript:void(0);" onClick="follow_user('84','205');" class="follow-btn"><img src="images/follower.png" align="absmiddle" /> Follow </a>
											</li>
																			</ul>
							</div>
							<div class="clear"> </div>
						</div> <!-- End user-profile-top -->
						<div class="clear"> </div>
                        
                        
                        
                                        
                                        
						
						<div class="user-cont">
							
							<div class="user-cont-left">
								<div class="pro-pic">
                                									<img src="uploaded_images/1396202277IMG_0022.PNG" alt="" width="200" height="180" />
                                    								</div>
								
								<label>
									<h5>Member Since</h5>
									<p>January 2014</p>
								</label>
								
                                								<label>
									<h5>Location</h5>
									<p>Austin, TX</p>
								</label>
                                								
								<!--<label>
									<input type="checkbox" class="regular-checkbox big-checkbox" name="review" id="review" />
									<label for="review"></label>
									
									 Review Votes
								</label>-->
								<div class="clear"> </div>
                                
                                
								
								                                
								<h4>
                                									<strong><a  id="various1" href="#inline205" style="color:#404CA1;" title="">8 likes </a></strong>,  
                                									<strong><a  id="various2" href="#inline_dislike" style="color:#404CA1;" title="">1 dislike</a> </strong>
                                								</h4>
								
								<!--<div class="review-up">
									<img src="images/reload.png" align="absmiddle" /> 1 Review update
								</div>
								<div class="clear"> </div>
								
								<div class="report-ab">
									<img src="images/report-flag.png" align="absmiddle" /> Report Abuse
								</div>-->
								<div class="clear"> </div>
								
								<div style="display: none;">
                                    <div id="inline205" style="height:250px; min-height:450px; overflow:auto; width:615px;">
                                    	<h2 class="rv-pop-title">Liked Review List</h2>
									                                                                                                                <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>04-07-2014</li>    
                                	</ul>
                                          
                                          <p>I love their food but can&#039;t stand how they require you to print out one of the coupons to be able to use it. They don&#039;t have a bar code, serial number, or anything on them that would make it required to have in hand. They could easily write down on a piece of paper that you showed the coupon on your phone  and it would have the same value as you handing one to them. Because of this (which I see as a customer service issue) I give them only 3 stars.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>06-08-2014</li>    
                                	</ul>
                                          
                                          <p>Mimi&#039;s is consistently good.  The General Tso&#039;s Chicken is delicious and the sushi is wonderful too.  The Chicken Noodle Soup is also delicious.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>11-13-2014</li>    
                                	</ul>
                                          
                                          <p>The food was great and fresh. My daughter and I like the salt and pepper calamari and tom yum soup.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>10-26-2014</li>    
                                	</ul>
                                          
                                          <p>Had the Mimi&#039;s Spicy Soft Noodle and it was delicious!</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=160" style="color:#F07A01; text-decoration:none;">Korea House</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>05-19-2014</li>    
                                	</ul>
                                          
                                          <p>Went there with the family. Had the Korean bulgogi, and the snapper soup. All were delicious. Service was so so, but overall a great place to hang out and have true authentic Korean food.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=104705" style="color:#F07A01; text-decoration:none;">Third Base Sports Bar</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>05-02-2014</li>    
                                	</ul>
                                          
                                          <p>Decent place to hang out with friends. Went there for a meeting, got the Mushrooms burger and it was good. Staffs were friendly and the atmosphere was great!!! Lots of TV&#039;s</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=105059" style="color:#F07A01; text-decoration:none;">Tuk Tuk Thai Café</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>06-19-2014</li>    
                                	</ul>
                                          
                                          <p>Ordered the tom yum soup today and it wasn&#039;t bad. The food came out quick and hot. We will come back next time to try new things on the menu.</p>
                                          </div>
                                                                                                                                                    <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=1194" style="color:#F07A01; text-decoration:none;">Mimis Asian Fusion</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                            <li>01-20-2015</li>    
                                	</ul>
                                          
                                          <p>I&#039;ve tried every single restaurant around my area, and the flavor this restaurants achieves daily is amazing. Give them a try, you won&#039;t be disappointed.</p>
                                          </div>
                                                                             
                                    </div>
                                    
                                	</div>
                                    
                                    
                                    <div style="display: none;">
                                    <div id="inline_dislike" style="height:250px; min-height:450px; overflow:auto; width:615px;">
                                    	<h2 class="rv-pop-title">Disliked Review List</h2>
									                                                                                                                <div class="review_top rvdate">
                                        <h1><span><a href="restaurant.php?id=77198" style="color:#F07A01; text-decoration:none;">Crawfish Shack &amp; Oyster Bar</a></span></h1>                                          
                                        <ul>
                                    	                                        <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="16" src="images/star-1.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                                <li><img width="16" height="15" src="images/star-3.png"></li>
                                                                            <li>12-14-2014</li>    
                                	</ul>
                                          
                                          <p>The food is ok, sometimes the crawfish is too salty.</p>
                                          </div>
                                                                             
                                    </div>
                                    
                                	</div>
								
							
							</div> <!-- End user-cont -->
							
							
							
							<div class="user-cont-right">
								<div class="right-top" >
									<h4>
                                    										Recent Reviews <span> 24 Reviews</span>
                                        									</h4>
									<div class="clear"> </div>
									<ul class="sortby">
										<li>Sort by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);" onClick="sort_date('205');">Date</a></li> 
										<li style="color: #999">| &nbsp;</li>
										<li><a href="javascript:void(0);" onClick="sort_rating('205');">Rating</a></li> 
										<!--<li>Filter by</li>
										<li><img src="images/right-small-arrow.png" align="absmiddle" /></li>
										<li><a href="javascript:void(0);"> Location</a></li>
										<li><a href="javascript:void(0);">Category</a></li>-->
									</ul>
									<div class="clear"> </div>
								</div>
								<div class="clear"> </div>
								
								<div class="right-top" id="right-top">
								
								<div id="loader_div" class="sec-load" style="display:none;"><img src="images/loader_gif.gif"></div>
                                
                                <div id="main_res_div" class="">
                                
                                <!-- Start restu-block -->
                                
                                									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        											<img src="uploaded_images/1373657304mongoliagrill.jpeg" align="" width="169" />
                                        										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=116">Mongolian Grill</a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : Chinese</a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=116">12636 Research Blvd, Austin, TX 78759</a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                        											<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																													</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on 04-10-2015                                                </div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													testing												</p>
												<div class="clear"> </div>
                                                
                                                												
												<div class="like-sec">
													                                                    
													<div class="soc_icon">
														 
                                                                                                                
                                                        													</div>
                                                    
												</div>
												
												
											</div> 
											<div class="clear"> </div>
											<div class="user-social-sec-bot">
											
										  <div class="rating_content_two review-likes">
                                          <ul>
															
			                                    <li id="li_like_163">
															                                    <span class="like_text" id="like_count_163">0</span><a href="like" id="do_like_163" class="like" review="163" cid="84"><img src="images/like.png" width="16" height="16" /></a>
															                                    </li>
			                                    <li id="li_dislike_163">
			                                    			                                     <a href="dislike" id="do_dislike_163" class="dislike" review="163" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_163">0</span>
															                                    </li>
			                                    
			                                    <!--<li><a href="#"></a></li>-->
			                                    			                                </ul>
                                          </div>
                                            
                                            <div class="report-ab">
                                            <a href="mailto:?body=testing&subject=10-04-2015  By Chef" target="_blank">Email</a>
                                            
                                                                                         
                                    		                                            
                                            <a href="javascript:void(0);" onClick="FBShareOp('Chef','116','1373657304mongoliagrill.jpeg','testing')">Share with facebook</a>                                            
                                            </div>
                                            
                                                                                        <div class="report-ab">  
                                                <img src="images/report-flag.png" align="absmiddle">
                                                                                                <a href="report_abuse.php?id=116&r_id=163" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                <div class="clear"> </div>
                                            </div>
                                            										
                                        </div>
                                        
										<div class="clear"> </div>
                                        
                                                                               </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        											<img src="uploaded_images/1373598922chinatown-dt.jpg" align="" width="169" />
                                        										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=83">Chinatown Downtown</a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : Chinese</a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=83">107 West 5th street, Austin, TX 78701</a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                        											<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																													</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on 04-10-2015                                                </div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													Testing												</p>
												<div class="clear"> </div>
                                                
                                                												
												<div class="like-sec">
													                                                    
													<div class="soc_icon">
														 
                                                                                                                
                                                        													</div>
                                                    
												</div>
												
												
											</div> 
											<div class="clear"> </div>
											<div class="user-social-sec-bot">
											
										  <div class="rating_content_two review-likes">
                                          <ul>
															
			                                    <li id="li_like_162">
															                                    <span class="like_text" id="like_count_162">0</span><a href="like" id="do_like_162" class="like" review="162" cid="84"><img src="images/like.png" width="16" height="16" /></a>
															                                    </li>
			                                    <li id="li_dislike_162">
			                                    			                                     <a href="dislike" id="do_dislike_162" class="dislike" review="162" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_162">0</span>
															                                    </li>
			                                    
			                                    <!--<li><a href="#"></a></li>-->
			                                    			                                </ul>
                                          </div>
                                            
                                            <div class="report-ab">
                                            <a href="mailto:?body=Testing&subject=10-04-2015  By Chef" target="_blank">Email</a>
                                            
                                                                                         
                                    		                                            
                                            <a href="javascript:void(0);" onClick="FBShareOp('Chef','83','1373598922chinatown-dt.jpg','Testing')">Share with facebook</a>                                            
                                            </div>
                                            
                                                                                        <div class="report-ab">  
                                                <img src="images/report-flag.png" align="absmiddle">
                                                                                                <a href="report_abuse.php?id=83&r_id=162" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                <div class="clear"> </div>
                                            </div>
                                            										
                                        </div>
                                        
										<div class="clear"> </div>
                                        
                                                                               </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        											<img src="uploaded_images/137390499411.png" align="" width="169" />
                                        										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=146">Pacific Star Seafood & Oyster Bar</a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : Seafood</a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=146">13507 N Highway 183, Austin, TX 78750</a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                        											<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																													</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on 04-09-2015                                                </div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													testing												</p>
												<div class="clear"> </div>
                                                
                                                												
												<div class="like-sec">
													                                                    
													<div class="soc_icon">
														 
                                                                                                                
                                                        													</div>
                                                    
												</div>
												
												
											</div> 
											<div class="clear"> </div>
											<div class="user-social-sec-bot">
											
										  <div class="rating_content_two review-likes">
                                          <ul>
															
			                                    <li id="li_like_161">
															                                    <span class="like_text" id="like_count_161">0</span><a href="like" id="do_like_161" class="like" review="161" cid="84"><img src="images/like.png" width="16" height="16" /></a>
															                                    </li>
			                                    <li id="li_dislike_161">
			                                    			                                     <a href="dislike" id="do_dislike_161" class="dislike" review="161" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_161">0</span>
															                                    </li>
			                                    
			                                    <!--<li><a href="#"></a></li>-->
			                                    			                                </ul>
                                          </div>
                                            
                                            <div class="report-ab">
                                            <a href="mailto:?body=testing&subject=09-04-2015  By Chef" target="_blank">Email</a>
                                            
                                                                                         
                                    		                                            
                                            <a href="javascript:void(0);" onClick="FBShareOp('Chef','146','137390499411.png','testing')">Share with facebook</a>                                            
                                            </div>
                                            
                                                                                        <div class="report-ab">  
                                                <img src="images/report-flag.png" align="absmiddle">
                                                                                                <a href="report_abuse.php?id=146&r_id=161" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                <div class="clear"> </div>
                                            </div>
                                            										
                                        </div>
                                        
										<div class="clear"> </div>
                                        
                                                                               </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        											<img src="uploaded_images/1373919006yogart land.jpg" align="" width="169" />
                                        										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=145">Yogurtland</a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : American</a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=145">2525 W Anderson Ln, Austin, TX 78757</a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                        											<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																													</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on 04-09-2015                                                </div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													testing												</p>
												<div class="clear"> </div>
                                                
                                                												
												<div class="like-sec">
													                                                    
													<div class="soc_icon">
														 
                                                                                                                
                                                        													</div>
                                                    
												</div>
												
												
											</div> 
											<div class="clear"> </div>
											<div class="user-social-sec-bot">
											
										  <div class="rating_content_two review-likes">
                                          <ul>
															
			                                    <li id="li_like_160">
															                                    <span class="like_text" id="like_count_160">0</span><a href="like" id="do_like_160" class="like" review="160" cid="84"><img src="images/like.png" width="16" height="16" /></a>
															                                    </li>
			                                    <li id="li_dislike_160">
			                                    			                                     <a href="dislike" id="do_dislike_160" class="dislike" review="160" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_160">0</span>
															                                    </li>
			                                    
			                                    <!--<li><a href="#"></a></li>-->
			                                    			                                </ul>
                                          </div>
                                            
                                            <div class="report-ab">
                                            <a href="mailto:?body=testing&subject=09-04-2015  By Chef" target="_blank">Email</a>
                                            
                                                                                         
                                    		                                            
                                            <a href="javascript:void(0);" onClick="FBShareOp('Chef','145','1373919006yogart land.jpg','testing')">Share with facebook</a>                                            
                                            </div>
                                            
                                                                                        <div class="report-ab">  
                                                <img src="images/report-flag.png" align="absmiddle">
                                                                                                <a href="report_abuse.php?id=145&r_id=160" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                <div class="clear"> </div>
                                            </div>
                                            										
                                        </div>
                                        
										<div class="clear"> </div>
                                        
                                                                               </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                									
									<div class="restu-block">
										
										<div class="restu-block-left">
                                        											<img src="uploaded_images/1373656954chinaexpress.jpg" align="" width="169" />
                                        										</div>
										<div class="restu-block-right">
		                                    <div class="restu-name-sec">
												<h1 class="res_name"><a href="restaurant.php?id=114">China Express</a></h1>
												<div class="clear"> </div>
												<a href="javascript:void(0);" class="small-cat">Categories : Chinese</a>
		                                    </div>
	                                                    
	                                        <div class="location-sec res_add">
												<img src="images/address_pic.png" alt="" />
												<a href="restaurant.php?id=114">1913 E Riverside Dr, Austin, TX 78741</a>
											</div>
                                        </div>      
                                        
										<div class="restu-block-right">
                                        
                                        
                                                    
                                        											<div class="restu-block-top">
												<div class="restu-name-sec">
													
                                                    
													
													<div class="rating_content">
														<ul>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="16" src="images/star-1.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																														<li><img width="16" height="15" src="images/star-3.png"></li>
																													</ul>
														
													</div> 
                                                    
												</div>
												
												
                                                <div class="post_date">
                                                Posted on 03-18-2015                                                </div>
											</div>
											<div class="clear"> </div>
											<div class="restu-block-botm">
												<p>
													Food was okay												</p>
												<div class="clear"> </div>
                                                
                                                												
												<div class="like-sec">
													                                                    
													<div class="soc_icon">
														 
                                                                                                                
                                                        													</div>
                                                    
												</div>
												
												
											</div> 
											<div class="clear"> </div>
											<div class="user-social-sec-bot">
											
										  <div class="rating_content_two review-likes">
                                          <ul>
															
			                                    <li id="li_like_159">
															                                    <span class="like_text" id="like_count_159">0</span><a href="like" id="do_like_159" class="like" review="159" cid="84"><img src="images/like.png" width="16" height="16" /></a>
															                                    </li>
			                                    <li id="li_dislike_159">
			                                    			                                     <a href="dislike" id="do_dislike_159" class="dislike" review="159" cid="84"><img src="images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_159">0</span>
															                                    </li>
			                                    
			                                    <!--<li><a href="#"></a></li>-->
			                                    			                                </ul>
                                          </div>
                                            
                                            <div class="report-ab">
                                            <a href="mailto:?body=Food was okay&subject=18-03-2015  By Chef" target="_blank">Email</a>
                                            
                                                                                         
                                    		                                            
                                            <a href="javascript:void(0);" onClick="FBShareOp('Chef','114','1373656954chinaexpress.jpg','Food was okay')">Share with facebook</a>                                            
                                            </div>
                                            
                                                                                        <div class="report-ab">  
                                                <img src="images/report-flag.png" align="absmiddle">
                                                                                                <a href="report_abuse.php?id=114&r_id=159" style="color:#000000;" onClick="return confirm('Are you sure to Report Abuse this Review?');">Report Abuse</a>
                                                                                                <div class="clear"> </div>
                                            </div>
                                            										
                                        </div>
                                        
										<div class="clear"> </div>
                                        
                                                                               </div>
                                        <div class="clear"> </div>
									</div>
           
                                    
                                                                
                                
                                                                
                                    <div class="morebox" id="more159">
                                    <a class="more" id="159" href="javascript:void(0);" onClick="slider_load();">Load More Reviews</a>
                                    </div>
                                    
                                                                </div>
                                
                                
                                
                                                                
                                
                                
                                
                                										<div id="block_confirm_user11" class="factor_details white_content nw_white_cont12 flex_popup flex_popup-n" style="width:200px; background:#ffffff; visibility:hidden;">
                                        <div class="close close-new" onClick="close_block_confirm_user_div('11');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont yes-no"> 
											<p>Do you want to block this user ?</p>
                                            <a href="javascript:void(0);" onClick="return confirm_user_blk('11','yes');" style="color:#000;">Yes</a>  <a href="javascript:void(0);"  onClick="return confirm_user_blk('11','no');"  style="color:#000;">No</a>
                                           <!-- <br>
        <a href="javascript:void(0);" onClick="close_block_confirm_user_div('11');">Cancel</a>-->
                                            </div>
                                            </div>
										</div> 
																				<div id="block_confirm_user29" class="factor_details white_content nw_white_cont12 flex_popup flex_popup-n" style="width:200px; background:#ffffff; visibility:hidden;">
                                        <div class="close close-new" onClick="close_block_confirm_user_div('29');"><a href = "javascript:void(0);"></a> </div>
                                <div class="l-contnt nw-l-cont yes-no"> 
											<p>Do you want to block this user ?</p>
                                            <a href="javascript:void(0);" onClick="return confirm_user_blk('29','yes');" style="color:#000;">Yes</a>  <a href="javascript:void(0);"  onClick="return confirm_user_blk('29','no');"  style="color:#000;">No</a>
                                           <!-- <br>
        <a href="javascript:void(0);" onClick="close_block_confirm_user_div('29');">Cancel</a>-->
                                            </div>
                                            </div>
										</div> 
										                                
                                <div id="fade1" class="black_overlay"> </div>
                                
									
                                <input type="hidden" name="hid_sort" id="hid_sort" value="ASC">
								<input type="hidden" name="hid_count" id="hid_count" value="10">
                                <input type="hidden" name="hid_count_new" id="hid_count_new" value="24">
                                <input type="hidden" name="hid_sort_type" id="hid_sort_type" value="id">
                                	
                                	
									
								</div>
								
								
							
							</div> <!-- End user-cont -->
							
						</div> <!-- End user-cont -->
						
						<div class="clear"> </div>
					</div> <!-- End user-profile-section -->
					
				
				
				</div>
			
			
			</div>
			<div class="body_footer_bg"> </div>
			<div class="clear"></div>
		</div>
	
	</div>
    
   							 

<div class="clear"></div>
<div class="footer_section">
<div class="footer_container">

<div class="footer_cont_top"></div>

<div class="footer_cont_middle">

<div class="cont_left_one"><a href="home.php"><img src="images/footer-logo.png" width="158" height="80" /></a></div>

<div class="cont_left_two">

<h1>Help Links</h1>

<ul>
<li><a href="contact.php">Contact us</a></li>
<li><a href="about.php">About us</a></li>
<li><a href="faq.php">FAQ</a></li>
<li><a href="contact.php">Add a restaurant</a></li>
</ul>
</div>

<div class="cont_left_two">

<h1>Other Links</h1>

<ul>
<li><a href="terms.php">Terms and Condition</a></li>
<li><a href="privacy.php">Privacy Policy</a></li>
<li><a href="advertisement.php">Advertisement</a></li>
<li><a href="career.php">Career</a></li>
</ul>
</div>


<div class="cont_left_three">

<h1><a href="restaurant_admin_login.php" style="color:#ffffff; text-decoration:none;">Restaurant Owners Login</a></h1>

</div>
<div class="clear"></div>
</div>

<div class="footer_cont_bottom"></div>

</div>

<div class="copyright_section">

<p>© 2015 Restaurant website, All right reserved</p>

<div class="clear"></div>
</div>

</div>
<div class="left_side_icon">
<ul>
<li><a href="https://www.facebook.com/pages/Food-and-Menu/383150028457695" target="_blank"><img src="images/facebook.png" width="37" height="37" /></a></li>
<li><a href="https://twitter.com/foodandmenus" target="_blank"><img src="images/twitter.png" width="37" height="37" /></a></li>
<li><a href="rss" target="_blank"><img src="images/rss.png" width="37" height="37" /></a></li>
<li><a href="www.linkedin.com/pub/michael-nguyen/74/951/692/" target="_blank"><img src="images/linked_in.png" width="37" height="37" /></a></li>
<li><a href="https://plus.google.com/u/1/b/100455298389535660288/100455298389535660288/posts/p/pub" target="_blank"><img src="images/google_plus.png" width="37" height="37" /></a></li>
</ul>
</div>
	
	
</body>
</html>