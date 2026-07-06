;(function($) {
'use strict'
// Dom Ready

	var the8_preloader_init = function(action, element) {
	    if (action === 'show') {
	        $('body').addClass('overlay--enabled');
	    }
	    var runLoader = function() {
	        if ($(element).length) { 
	            $(element).find('.preloader-animation').remove();
	            $(element).find('.loader').addClass('loaded');
	            $('body').removeClass('overlay--enabled');

	            setTimeout(function() {
	                $(element).remove();
	            }, 1000);
	        }
	    };

	    if (document.readyState === 'complete') {
	        runLoader(); // already loaded
	    } else {
	        $(window).one('load', runLoader); // wait for load, run once
	    }
	};

	var back_to_top_scroll = function() {
			
			$('#backToTop').on('click', function() {
				$("html, body").animate({ scrollTop: 0 }, 500);
				return false;
			});
			
			$(window).scroll(function() {
				if ( $(this).scrollTop() > 500 ) {
					
					$('#backToTop').addClass('active');
				} else {
				  
					$('#backToTop').removeClass('active');
				}
				
			});
			
		}; // back_to_top_scroll   
	
	
		//Trap focus inside mobile menu modal
		//Based on https://codepen.io/eskjondal/pen/zKZyyg	
		var trapFocusInsiders = function(elem) {
			
				
			var tabbable = elem.find('select, input, textarea, button, a').filter(':visible');
			
			var firstTabbable = tabbable.first();
			var lastTabbable = tabbable.last();
			/*set focus on first input*/
			firstTabbable.focus();
			
			/*redirect last tab to first input*/
			lastTabbable.on('keydown', function (e) {
			   if ((e.which === 9 && !e.shiftKey)) {
				   e.preventDefault();
				   
				   firstTabbable.focus();
				  
			   }
			});
			
			/*redirect first shift+tab to last input*/
			firstTabbable.on('keydown', function (e) {
				if ((e.which === 9 && e.shiftKey)) {
					e.preventDefault();
					lastTabbable.focus();
				}
			});
			
			/* allow escape key to close insiders div */
			elem.on('keyup', function(e){
			  if (e.keyCode === 27 ) {
				elem.hide();
			  };
			});
			
		};

		var focus_to = function(action,element) {

			$(action).keyup(function (e) {
			    e.preventDefault();
				var code = e.keyCode || e.which;
				if(code == 13) { 
					$(element).focus();
				}
			});		
			
		}
	
	$(function() {
		if( $('#the8_preloader').length ){
			the8_preloader_init('show', '#the8_preloader');
		}
		back_to_top_scroll();
		if( $('.owlGallery,.img-box ul.blocks-gallery-grid').length ){
			$(".owlGallery,.img-box ul.blocks-gallery-grid").owlCarousel({
				stagePadding: 0,
				loop: true,
				autoplay: true,
				autoplayTimeout: 2000,
				margin: 0,
				nav: false,
				dots: false,
				smartSpeed: 1000,
				rtl: ( $("body.rtl").length ) ? true : false, 
				responsive: {
					0: {
						items: 1
					},
					600: {
						items: 1
					},
					1000: {
						items: 1
					}
				}
			});
		}
		if( $('.navsticky').length ){
		  var stickyTop = $('.navsticky').offset().top;
		  $(window).scroll(function() {
		   var windowTop = $(window).scrollTop();
		   if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				if (stickyTop < (windowTop - 50 ) ) {
				  $('.navsticky').addClass('active');
				} else {
				  $('.navsticky').removeClass('active');
		
				}
			}
		  });
		}
		/*=============================================
	    =            Main Menu         =
	    =============================================*/
	   
		$('#navbar .navigation-menu li > a').keyup(function (e) {
			if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				$("#navbar .navigation-menu li").removeClass('focus');
				$(this).parents('li.menu-item-has-children').addClass('focus');
				$("#navbar").addClass('keyfocus');
			}
		});	

		$( "#navbar, #navbar a, body" ).hover(function() {
			$("#navbar").removeClass('keyfocus');
		});
		$('#secondary .widget li a').keyup(function (e) {
			if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				$("#navbar .navigation-menu li").removeClass('focus');
				$(this).parents('li.menu-item-has-children').addClass('focus');
			}
		});	
		$(".responsive-submenu-toggle").on('click', function(e){
			$(this).next('ul').toggleClass('focus-active');
			$(this).toggleClass('icofont-rounded-up');

	    });
  		$(".the8-shop-dark-rd-navbar-toggle").on('click', function(e){
			$('#navbar').toggleClass('active');
			if( $('#aside-nav-wrapper').length ){
				$('#aside-nav-wrapper').toggleClass('active');
			}
			$(this).find('i').toggleClass('bi-arrow-left').toggleClass('bi-toggles');
			trapFocusInsiders( $('#navbar') );
	    });
	    $(".the8-shop-dark-navbar-close").on('click', function(e){
			$('#navbar').removeClass('active');
			if( $('#aside-nav-wrapper').length ){
				$('#aside-nav-wrapper').removeClass('active');
			}
			$(".the8-shop-dark-rd-navbar-toggle").find('i').removeClass('bi-arrow-left').addClass('bi-toggles');
	  		$(".the8-shop-dark-rd-navbar-toggle").focus();

	    });	
	  	
	  	
	  	$(window).on('load resize', function() {
			if ( matchMedia( 'only screen and (max-width: 992px)' ).matches ) {
				var el = document.querySelector('#navbar');
  				SimpleScrollbar.initEl(el);
			}
		});
		
		$('#masthead .header-icon li > a').keyup(function (e) {
			if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				$("#masthead .header-icon li").removeClass('focus');
				$("#navbar .navigation-menu li").removeClass('focus');
				$(this).parents('li').addClass('focus');

			}
		});	
		/*=============================================
	    =            search overlay active            =
	    =============================================*/
	    
	    if( $('.search-modal').length ){

			$(".search-modal").on('click', function(e){
				$('.search-bar-modal').addClass('active');
				$('#search-bar').find('input.search-field').focus();
				trapFocusInsiders( $("#search-bar") );
		    });

			$(".appw-modal-close-button").on('click', function(e){
				$('.search-bar-modal').removeClass('active');
				$(".search-modal").focus();
		    });
		}

		$('#secondary .widget li a').keyup(function (e) {
			if ( matchMedia( 'only screen and (min-width: 992px)' ).matches ) {
				$("#secondary .widget li").removeClass('focus');
				$(this).parents('li').addClass('focus');

			}
		});	
		/* ============== masonry Grid ============= */
		if( jQuery(".masonry_grid").length){
			jQuery('.masonry_grid').masonry({
			  // set itemSelector so .grid-sizer is not used in layout
			  itemSelector: '.grid-item',
			  // use element for option
			  columnWidth: '.grid-sizer',
			  percentPosition: true
			});
		}
		$('#fly-sidebar-toggle, .sidebar-close').on('click', function () {
		    var $sidebar = $('.pine-push-sidebar');
		    var $page    = $('#page');
		    var isOpen   = $sidebar.hasClass('active');

		    $sidebar.toggleClass('active', !isOpen);
		    $page.toggleClass('fly-sidebar', !isOpen);

		    if (!isOpen) {
		        trapFocusInsiders($sidebar);
		    }else{
		    	$("#fly-sidebar-toggle").focus();
		    }
		});
		if( $('.pine-push-sidebar .wrap').length ){
			var el = document.querySelector('.pine-push-sidebar .wrap');
  			SimpleScrollbar.initEl(el);
		}
		if ($('#static_header_banner').length) {
		    $('#static_header_banner').css(
		        'padding-top',
		        $('#masthead.style_1').outerHeight()
		    );
		}

		if ($('#masthead.sticky-mode').length) {
		    var sticky = $('#masthead.sticky-mode');
		    var lastScrollTop = 0; // store previous scroll position
		    var scrollThreshold = 100; // start sticky after 100px

		    $(window).on('scroll resize', function () {
		        var windowTop = $(window).scrollTop();

		        if (matchMedia('only screen and (min-width: 992px)').matches) {

		            if (windowTop > scrollThreshold) {
		                sticky.addClass('sticky');

		                if (windowTop < lastScrollTop) {
		                    // Scrolling UP
		                    sticky.addClass('active');
		                } else {
		                    // Scrolling DOWN
		                    sticky.removeClass('active');
		                }

		            } else {
		                // Scroll less than 100px → remove sticky
		                sticky.removeClass('active sticky');
		            }
		        }

		        lastScrollTop = windowTop; // update last scroll position
		    });
		}
		
		AOS.init({
		  duration: 800,
		  once: true, // Animation happens only once
		  disable: 'mobile' // Disable on mobile devices
		});
		
	});
})(jQuery);