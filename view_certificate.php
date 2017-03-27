<?php
session_start();
//include("includes/rest_header.php");
include("admin/lib/conn.php");
include("includes/functions.php");
?>

<?php /*?><script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script><?php */?>

<!--<script type="text/javascript">

function printDiv(divName) 
{
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

</script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jQuery.print.js"></script>

<script type="text/javascript">
var $j = jQuery.noConflict();
$j(function() {
    $j(".print_but").click(function() {
    $j("#printdiv").print();
    return (false);
});
});
</script>


<?php

$curr_date = date('Y-m-d');

$sql_html = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_giftcard_html WHERE giftcard_id = '".$_REQUEST['giftcard_id']."'"));


$sql_used_check = mysql_fetch_array(mysql_query("SELECT * FROM restaurant_gift_certificate_no WHERE giftcard_id = '".$_REQUEST['giftcard_id']."'"));
if($sql_used_check['used'] != 1 && $curr_date < $sql_used_check['expiry_date'])
{
	if($_REQUEST['noprint'] == "")
	{
?>
<div style="float:right">
<!--<a href="javascript:void(0);" class="print_but"><img src="images/print1.png"></a>-->
<a class="button_example print_but" href="javascript:void(0);">PRINT</a>
</div>
<div class="clear"></div>
<?php
	}
}
?>
<div id="printdiv" style="margin-top:6px;">
<?php echo htmlspecialchars_decode($sql_html['giftcard_header']); ?>
<?php echo htmlspecialchars_decode($sql_html['giftcard_footer']); ?>
</div>



