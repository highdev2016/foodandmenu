// JavaScript Document
	jQuery(document).ready(function() {
		// get current rating
		getRating();
		// get rating function
		function getRating(){
			jQuery.ajax({
				type: "GET",
				url: "update.php",
				data: "do=getrate",
				cache: false,
				async: false,
				success: function(result) {
					// apply star rating to element
					jQuery("#current-rating").css({ width: "" + result + "%" });
				},
				error: function(result) {
					alert("some error occured, please try again later");
				}
			});
		}
		
		// link handler
		jQuery('#ratelinks li a').click(function(e){
			e.preventDefault();
			alert(jQuery(this).data('rate'));
			jQuery('#rate_count').attr('value',jQuery(this).data('rate'));
			//jQuery("#ratelinks").remove();
			/*jQuery.ajax({
				type: "GET",
				url: "update.php",
				data: "rating="+jQuery(this).text()+"&do=rate",
				cache: false,
				async: false,
				success: function(result) {
					// remove #ratelinks element to prevent another rate
					jQuery("#ratelinks").remove();
					// get rating after click
					getRating();
				},
				error: function(result) {
					alert("some error occured, please try again later");
				}
			});*/
			
		});
	});
