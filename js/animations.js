		$(window).scroll(function() {
                    
                    $('.banner_section').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
			//alert('imagePos: '+imagePos);alert('topOfWindow: '+topOfWindow+500);
				if (imagePos < topOfWindow+500) {
					$(this).addClass("slideDown fixed-top");
				}
				if (imagePos==0) {
                                    $(this).removeClass("slideDown fixed-top");
                                }
			});

			$('.services-content').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("fadeIn");
				}
			});


			$('.section-title').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("fadeIn");
				}
			});


			$('.strategy-content').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("fadeIn");
				}
			});


			$('.strategy-main').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("fadeIn");
				}
			});


			$('.photo-content').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("slideUp");
				}
			});


			$('.wrap-content').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("slideRight");
				}
			});


			$('.wrap-content-info').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+300) {
					$(this).addClass("slideLeft");
				}
			});


			$('.service-serve').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("fadeIn");
				}
			});
			
			$('.header-fix').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
			//alert('imagePos: '+imagePos);alert('topOfWindow: '+topOfWindow+500);
				if (imagePos < topOfWindow+500) {
					$(this).addClass("slideDown fixed-top ");
				}
				if (imagePos==0) {
			$(this).removeClass("slideDown fixed-top ");
		}
			});


			$('.quote-slider').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("fadeIn");
				}
			});
			
				$('.portfolio-sec').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("rollIn");
				}
			});
			
			$('.portfolio-sec2').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+300) {
					$(this).addClass("rollIn2");
				}
			});
			$('.portfolio-sec3').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+250) {
					$(this).addClass("rollIn");
				}
			});
			
			$('.blog-sec3').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("lightSpeedIn");
				}
			});
			
			$('.test-sec3').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("lightSpeedIn2");
				}
			});
			
			$('.work3').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+500) {
					$(this).addClass("zoomIn");
				}
			});
			$('.work-tes').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+600) {
					$(this).addClass("zoomIn");
				}
			});
			
			$('.nav_sec').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+600) {
					$(this).addClass("slideRight");
				}
			});
			
			$('.fade_left').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+600) {
					$(this).addClass("fadeInLeft");
				}
			});
			
			$('.fade_right').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+600) {
					$(this).addClass("fadeInRight");
				}
			});
			
			$('.ani_swing').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+600) {
					$(this).addClass("swing");
				}
			});
			
			$('.wrap-content-info2').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+300) {
					$(this).addClass("slideLeft2");
				}
			});
			
			$('.wrap-content-info3').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+300) {
					$(this).addClass("slideLeft3");
				}
			});
			
			$('.wrap-content-info4').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+300) {
					$(this).addClass("slideLeft4");
				}
			});
			
			$('.wrap-content-info5').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+300) {
					$(this).addClass("slideLeft5");
				}
			});
			
			$('.wrap-content-info6').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
				if (imagePos < topOfWindow+300) {
					$(this).addClass("slideLeft6");
				}
			});
			
			$('.banner-serve').each(function(){
			var imagePos = $(this).offset().top;
			
			var topOfWindow = $(window).scrollTop();
			//alert('imagePos: '+imagePos);alert('topOfWindow: '+topOfWindow+500);
				if (imagePos < topOfWindow+500) {
					$(this).addClass("slideDown fixed-top ");
				}
				if (imagePos==0) {
                                $(this).removeClass("slideDown fixed-top ");
                                }
			});
                        
                        

		//new added-------------------
		
		
		

		});
