<?php
session_start();
 include ("admin/lib/conn.php");
 include ("includes/header.php");
 include('includes/functions.php');?>

<body onLoad="init();">

<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php");?>

<div class="body_section">

<div class="container">
<div class="body_top"></div>
<div class="main_body">

<div class="about_body_cont">
<?php $sql_about = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_cms WHERE page_id = 3"));?>
<div class="about_cont_top">
<h1><?php echo stripslashes($sql_about['heading']);?></h1>
<p><img width="410" height="17" src="images/star-bar-black.png"></p>
</div>

<div class="about_cont_bottom">

<div class="about_content_area main_content_area">

    <div class="content_new_section faq_section">
    
    <p><?php echo htmlspecialchars_decode(stripslashes($sql_about['description']));?></p>
    
    </div>

</div>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<?php include("includes/footer_new.php");?>