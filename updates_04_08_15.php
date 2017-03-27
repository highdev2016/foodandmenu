<?php
session_start();
 include ("includes/header.php");
 include("includes/functions.php");?>

<body>

<?php /*?><?php include ("includes/top_search.php");?>

<?php include ("includes/menu_section.php");?><?php */?>

<?php include ("includes/header_inner_new.php");?>

<div class="body_section">

<div class="body_container">
<div class="body_top"></div>
<div class="main_body">

<div class="about_body_cont">
<?php $sql_about = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_updates WHERE id = '".$_REQUEST['id']."'"));?>
<div class="about_cont_top">
<h1>Updates</h1>
</div>

<div class="about_cont_bottom">

<div class="about_content_area update_detail">


<p><?php echo htmlspecialchars_decode(stripslashes($sql_about['full_desc']));?></p>

</div>

</div>

</div>

</div>
<div class="body_footer_bg"></div>
<div class="clear"></div>
</div>

</div>

<div class="clear"></div>

<?php /*?><?php include("includes/footer.php");?><?php */?>
<?php include("includes/footer_new.php");?>
