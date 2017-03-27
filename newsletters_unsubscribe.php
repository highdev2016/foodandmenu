<?php
session_start();
include('admin/lib/conn.php');
//mysql_query("DELETE FROM restaurant_subscriber WHERE id = '".$_REQUEST['id']."'");

mysql_query("UPDATE restaurant_customer SET newsletter_subscription = 0 WHERE id = '".$_REQUEST['id']."' ");

include ("includes/header.php");
include ("includes/functions.php");?>

<body>

<?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?>


<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="main_body_cont">

<div class="content_container">

<?php include("includes/left_section.php");?>

<div class="body_cont_right">


<div class="clear"></div>


<div class="right_dish_content">
<h1 class="new">Unsubscribed From Our Newsletter</h1>
<p class="new1">
You have successfully unsuscribed from our Newsletter Subscription list, as per your request.
</p>




</div>



<div class="clear"></div>

<div class="pagination">

<div align="center">
</div>
</div>

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


<?php include("includes/footer.php");?>