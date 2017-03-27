<?php
session_start();
if($_COOKIE['resCity'] == ''){
	//echo '<script type="text/javascript">';
	//echo 'window.location=home.php?city='.$_COOKIE['resCity'];
	header("location:index.php");
	exit();
}
if (array_key_exists('btn_search', $_GET)) {
unset($_GET['btn_search']);
foreach($_GET as $key => $val)
{
	$qry_string .=$key.'='.$val.'&'; 
}
$qry_string = substr($qry_string,0,-1);
header("location:search.php?".$qry_string);
}

include ("includes/header.php");
include ("includes/functions.php");
include ("admin/lib/conn.php");
?>

<body onLoad="init();">
<div id="top_div"></div>

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>


<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="main_body_cont">

<?php //include("includes/banner_section.php");?>

<div class="content_container">

<?php include("includes/left_section.php");?>

<?php

$sql = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_customer WHERE id = '".$_SESSION['customer_id']."'"));

$sql_min = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_admin WHERE id = '1'"));



$pre_percentage = ($sql['reward_point']/$sql_min['minimum_reward_point'])*100;

if($pre_percentage > 100)
{
	$percentage = '100';
	$message = "Congratulations!!!! You can now successfully redeem your reward points.";
	$color = "#090";
}
else
{
	$difference = ($sql_min['minimum_reward_point'] - $sql['reward_point']);
	$percentage = $pre_percentage;
	$message = "You need just ".$difference." more points to reach your goal and be able to reedem your points.";
	$color = "#F00";
}

?>


<div class="body_cont_right">


<div class="clear"></div>

<div class="right_dish_content right_user_profile">

<p style="font-size:22px; color:rgb(43, 68, 148); padding:10px 10px 6px 10px; border-bottom:rgb(43, 68, 148) 1px solid; ">User Profile</p>


<div class="right_user_div" align="center" style="width:100%; margin-top:10px;">
<div class="clear"></div>
<span>Your Reward Point is <?php echo $sql['reward_point'];?></span>
<div id="circle">
</div>
<div class="clear"></div>
<span style="color:<?php echo $color;?>"><?php echo $message; ?></span>
<div class="clear"></div>
</div>


<div class="right_user_div">
<h1><a href="edit_profile.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/edit_profile.png" width="161" height="51"></a></h1>
<div><img src="images/shdw_btm.png" width="204" height="14">
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>

<div class="right_user_div">
<h1><a href="customer_order_history.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/order_history.png" width="161" height="51"></a></h1>
<div><img src="images/shdw_btm.png" width="204" height="14">
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>


<div class="clear"></div>
<div class="right_user_div">
<h1><a href="customer_reviews.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/reviews.png" width="161" height="51"></a></h1>
<div><img src="images/shdw_btm.png" width="204" height="14">
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>



<div class="right_user_div">
<h1><a href="gift_certificate_order_history.php" style="color:rgb(235, 111, 0); text-decoration:none;"><img src="images/gift.png" width="161" height="51"></a></h1>
<div><img src="images/shdw_btm.png" width="204" height="14">
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>





<div class="clear"></div>



</div>

<div class="clear"></div>
</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>


<?php include("includes/footer_search.php");?>
<link href="css/circle.css" rel="stylesheet" type="text/css">
<script src="js/progress-circle.js"></script>


<input type="hidden" name="percentage" id="percentage" value="<?php echo $percentage; ?>" />


<script type="text/javascript">

var percent = $("#percentage").val();

$('#circle').progressCircle({
nPercent        : percent,
showPercentText : true,
circleSize      : 100,
thickness       : 2
});
</script>