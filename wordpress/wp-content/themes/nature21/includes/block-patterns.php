<?php
/**
 * Nature21 : Block Patterns
 *
 * @since Nature21 1.0
 */

function nature21_patterns_register_block_patterns() {
	$block_pattern_categories = array(
		'nature21' => array( 'label' => __( 'Nature21', 'nature21' ) ),
		'nature21-other-patterns' => array( 'label' => __( 'Nature21 Theme Other Patterns', 'nature21' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @since Nature21 1.0
	 *
	 */
	$block_pattern_categories = apply_filters( 'nature21_patterns_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties ); // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_pattern_category
		}
	}

	$block_patterns = array(
		'nature21-header',	
		'nature21-hero-banner',
		'nature21-section1',
		'nature21-section2',
		'nature21-section3',
		'nature21-section4',
		'nature21-section5',
		'nature21-footer',	
	);

	/**
	 * Filters the theme block patterns.
	 *
	 * @since Nature21 1.0
	 * 
	 * @param array $block_patterns List of block patterns by name.
	 *
	 */
	$block_patterns = apply_filters( 'nature21_patterns_block_patterns', $block_patterns );

	foreach ( $block_patterns as $block_pattern ) {
		$pattern_file = get_theme_file_path( '/includes/patterns/' . $block_pattern . '.php' );

		register_block_pattern( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_pattern
			'nature21/' . $block_pattern,
			require $pattern_file // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		);
	}
}
add_action( 'init', 'nature21_patterns_register_block_patterns', 9 );
