<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
<?php /*?><script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script><?php */?>
<input type="button" id="button" value="View map"   />
<div id="load_map_div" >
<div id="map_loading_img" >
<img src="../images/map_loader.gif" title="loading"  />
</div>
</div>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
 
jQuery("#map_loading_img").hide();
jQuery("#button").click(function () {
 
jQuery("#map_loading_img").show();
jQuery.ajax({
url: 'ajax_map.php',
type: 'POST',
success: function (data) {
 
jQuery("#map_loading_img").hide();
jQuery("#load_map_div").html(data);
 
}
});
});
});
</script>