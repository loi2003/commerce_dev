/* global ajaxurl, futurioNUX */
( function( wp, $ ) {
	'use strict';

	if ( ! wp ) {
		return;
	}

	$( function() {
		// Dismiss notice
		$( document ).on( 'click', '.sf-notice-nux .notice-dismiss', function() {
			
			$.ajax({
				type:     'POST',
				url:      ajaxurl,
				data:     { nonce: the8ShopNUX.nonce, action: 'the8_shop_dismiss_notice' },
				dataType: 'json'
			});
		});
		
		
	});
  
  
})( window.wp, jQuery );