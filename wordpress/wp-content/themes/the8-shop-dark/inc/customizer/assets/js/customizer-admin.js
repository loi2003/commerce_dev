/*admin css*/
( function( the8_shop_dark_api ) {

	the8_shop_dark_api.sectionConstructor['the8_shop_dark_upsell'] = the8_shop_dark_api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
