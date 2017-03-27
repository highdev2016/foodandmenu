
jQuery(function(){
	function resturentLike(){
		this.likeButton = 'like';
		this.likeCount = 'like_count';
		this.dislikeButton = 'dislike';
		this.dislikeCount = 'dislike_count';
		this.likeUrl = 'ajax/review_like.php'
	}
	
	resturentLike.prototype = {
		init : function(){
			var object = this;
			jQuery('.' + this.likeButton).each(function(){
				jQuery(this).bind('click', function(event){
					event.preventDefault();
					object.doLike(jQuery(this).attr('review'), jQuery(this).attr('cid'));
				});
			});
			
			jQuery('.' + this.dislikeButton).each(function(){
				jQuery(this).bind('click', function(event){
					event.preventDefault();
					object.doDisLike(jQuery(this).attr('review'), jQuery(this).attr('cid'));
				});
			});
		},
		
		doLike : function(reviewID, customerID){
			var obj = this;
			jQuery.ajax({
				type : 'POST',
				url  : baseUrl + obj.likeUrl,
				data : {
					'review_id' : reviewID,
					'customer_id' : customerID,
					'type' : 'like',
				},
				dataType : 'json',
				beforeSend : function(){},
				success : function(data){
					//alert(data);
					obj._outPut(data,reviewID,customerID);
					//alert(data);
				}
			});
		},
		
		doDisLike : function(reviewID, customerID){
			var obj = this;
			jQuery.ajax({
				type : 'POST',
				url  : baseUrl + obj.likeUrl,
				data : {
					'review_id' : reviewID,
					'customer_id' : customerID,
					'type' : 'dislike',
				},
				dataType : 'json',
				beforeSend : function(){},
				success : function(data){
					//alert(data);
					obj._outPut(data,reviewID,customerID);
				}
			});
		},
		
		_outPut : function(data, reviewID, customerID){
			var obj = this;
			var likeType = 'disable';
			var dislikeType = 'disable';
			
			likeType = (data.user.is_like_status > 0) ? 'disable' : 'enable';
			dislikeType = (data.user.is_dislike_status > 0) ? 'disable' : 'enable';
			
			jQuery('#li_like_' + reviewID).html(obj._likeDOM(data, reviewID, customerID, likeType));
			jQuery('#li_dislike_' + reviewID).html(obj._dislikeDOM(data, reviewID, customerID, dislikeType));
			
			this.init();
		},
		
		_likeDOM : function(data, reviewID, customerID,  type){
			var DOMString = '';
			switch(type){
				case 'enable' : 
					DOMString = '<span class="like_text" id="like_count_' + reviewID + '">' + data.count_like + '</span><a href="like" id="do_like_' + reviewID + '" class="like" review="' + reviewID + '" cid="' + customerID + '"><img src="' + baseUrl + 'images/like.png" width="16" height="16" />';
				break;
				case 'disable' : 
					DOMString = '<span class="like_text" id="like_count_' + reviewID + '">' + data.count_like + '</span><img src="' + baseUrl + 'images/like_select.png" width="16" height="16" />';
				break;
				default : 
					DOMString = '';
			}
			return DOMString;
		},
		
		_dislikeDOM : function(data, reviewID, customerID, type){
			var DOMString = '';
			switch(type){
				case 'enable' : 
					DOMString = '<a href="dislike" id="do_dislike_' + reviewID + '" class="dislike" review="' + reviewID + '" cid="' + customerID + '"><img src="' + baseUrl + 'images/unlike.png" width="16" height="16" /></a><span class="like_text2" id="dislike_count_' + reviewID + '">' + data.count_dislike + '</span>';
				break;
				case 'disable' : 
					DOMString = '<img src="' + baseUrl + 'images/unlike_select.png" width="16" height="16" /><span class="like_text2" id="dislike_count_' + reviewID + '">' + data.count_dislike + '</span>';
				break;
				default : 
					DOMString = '';
			}
			return DOMString;
		},
		
	}
	
	var revLike = new resturentLike();
	revLike.init();
	
});

