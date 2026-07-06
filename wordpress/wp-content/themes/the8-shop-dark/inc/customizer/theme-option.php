<?php 
/**
* Theme Options Panel.
*
* @package the8-shop-dark
*/

$default = the8_shop_dark_get_default_theme_options();
global $wp_customize;

// Add Theme Options Panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
		'title'      => esc_html__( 'Theme Options', 'the8-shop-dark' ),
		'priority'   => 2,
		'capability' => 'edit_theme_options',
	)
);
    // Home Page Banner Section
    $wp_customize->add_section('home_banner_section_settings', array(
        'title'      => esc_html__('Home Page Banner Settings', 'the8-shop-dark'),
        'priority'   => 10,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    ));

	$wp_customize->add_setting('__replace_blog_home', array(
	    'default'           => isset($default['__replace_blog_home']) ? $default['__replace_blog_home'] : '',
	    'capability'        => 'edit_theme_options',
	    'sanitize_callback' => 'the8_shop_dark_sanitize_checkbox',
	));

	$wp_customize->add_control('__replace_blog_home', array(
	    'label'       => esc_html__('Use Custom Blog Banner', 'the8-shop-dark'),
	    'description' => __('Enable this option to replace the default blog title and description with a custom banner.', 'the8-shop-dark'),
	    'section'     => 'home_banner_section_settings',
	    'type'        => 'checkbox',
	));


    // === Media (Image/Video) URL ===
    $wp_customize->add_setting('__media_img_url', array(
        'default'           => isset($default['__media_img_url']) ? $default['__media_img_url'] : '',
        'sanitize_callback' => 'esc_url_raw', // Ensures a valid URL
    ));

    $wp_customize->add_control('__media_img_url', array(
        'label'       => esc_html__('Banner Image URL', 'the8-shop-dark'),
        'description' => esc_html__('Enter the URL of an image to display in the home banner.', 'the8-shop-dark'),
        'section'     => 'home_banner_section_settings',
        'type'        => 'text',
    ));
    // === Banner Title ===
    $wp_customize->add_setting('__banner_title', array(
        'default'           => isset($default['__banner_title']) ? $default['__banner_title'] : '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field', // Removes unwanted HTML
    ));

    $wp_customize->add_control('__banner_title', array(
        'label'       => esc_html__('Banner Heading', 'the8-shop-dark'),
        'description' => esc_html__('Enter a title for the home banner. Leave blank to hide it.', 'the8-shop-dark'),
        'section'     => 'home_banner_section_settings',
        'type'        => 'text',
    ));

    // === Banner Description ===
    $wp_customize->add_setting('__banner_desc', array(
        'default'           => isset($default['__banner_desc']) ? $default['__banner_desc'] : '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_textarea_field', // Removes unwanted HTML but allows line breaks
    ));

    $wp_customize->add_control('__banner_desc', array(
        'label'       => esc_html__('Banner Description', 'the8-shop-dark'),
        'description' => esc_html__('Enter a short description for the home banner. Leave blank to hide it.', 'the8-shop-dark'),
        'section'     => 'home_banner_section_settings',
        'type'        => 'textarea',
    ));
// Styling Options.*/

// Styling Options.*/

$wp_customize->add_section( 'styling_section_settings',
	array(
		'title'      => esc_html__( 'Styling Options', 'the8-shop-dark' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Primary Color.
/*$wp_customize->add_setting( '__primary_color',
	array(
	'default'           => $default['__primary_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control( '__primary_color',
	array(
	'label'    	   => esc_html__( 'Primary Color Scheme:', 'the8-shop-dark' ),
	'section'  	   => 'styling_section_settings',
	'description'  => esc_html__( 'The theme comes with unlimited color schemes for your theme\'s styling. upgrade pro for color options & features', 'the8-shop-dark' ),
	'type'     => 'color',
	'priority' => 120,
	)
);

$wp_customize->add_setting( '__secondary_color',
	array(
	'default'           => $default['__secondary_color'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_hex_color',
	)
);
$wp_customize->add_control( '__secondary_color',
	array(
	'label'    	   => esc_html__( 'Secondary Color Scheme:', 'the8-shop-dark' ),
	'section'  	   => 'styling_section_settings',
	'description'  => esc_html__( 'The theme comes with unlimited color schemes for your theme\'s styling. upgrade pro for color options & features', 'the8-shop-dark' ),
	'type'     => 'color',
	'priority' => 120,
	)
);*/
	
// === Blog Display & Layout Settings ===
$wp_customize->add_section('theme_option_section_settings', array(
    'title'      => esc_html__('Blog Display & Layout Settings', 'the8-shop-dark'),
    'priority'   => 100,
    'capability' => 'edit_theme_options',
    'panel'      => 'theme_option_panel',
));

// === Blog Page Layout ===
$wp_customize->add_setting('blog_layout', array(
    'default'           => isset($default['blog_layout']) ? $default['blog_layout'] : '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'the8_shop_dark_sanitize_select',
));

$wp_customize->add_control('blog_layout', array(
    'label'       => esc_html__('Blog Page Layout', 'the8-shop-dark'),
    'description' => esc_html__('Choose a default layout for blog, category, and archive pages.', 'the8-shop-dark'),
    'section'     => 'theme_option_section_settings',
    'choices'     => array(
        'sidebar-content'  => esc_html__('Sidebar on Left, Content on Right', 'the8-shop-dark'),
        'content-sidebar'  => esc_html__('Content on Left, Sidebar on Right', 'the8-shop-dark'),
        'no-sidebar'       => esc_html__('No Sidebar', 'the8-shop-dark'),
    ),
    'type'        => 'select',
));

// === Single Post Page Layout ===
$wp_customize->add_setting('single_post_layout', array(
    'default'           => isset($default['single_post_layout']) ? $default['single_post_layout'] : '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'the8_shop_dark_sanitize_select',
));

$wp_customize->add_control('single_post_layout', array(
    'label'       => esc_html__('Single Post Page Layout', 'the8-shop-dark'),
    'description' => esc_html__('Choose a default layout for individual blog post pages.', 'the8-shop-dark'),
    'section'     => 'theme_option_section_settings',
    'choices'     => array(
        'sidebar-content'  => esc_html__('Sidebar on Left, Content on Right', 'the8-shop-dark'),
        'content-sidebar'  => esc_html__('Content on Left, Sidebar on Right', 'the8-shop-dark'),
        'no-sidebar'       => esc_html__('No Sidebar', 'the8-shop-dark'),
    ),
    'type'        => 'select',
));

// === Archive Page Content Display ===
$wp_customize->add_setting('blog_loop_content_type', array(
    'default'           => isset($default['blog_loop_content_type']) ? $default['blog_loop_content_type'] : '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'the8_shop_dark_sanitize_select',
));

$wp_customize->add_control('blog_loop_content_type', array(
    'label'       => esc_html__('Archive Page Content Display', 'the8-shop-dark'),
    'description' => esc_html__('Select whether to display full content or excerpts on archive pages.', 'the8-shop-dark'),
    'section'     => 'theme_option_section_settings',
    'choices'     => array(
        'excerpt' => esc_html__('Show Excerpt Only', 'the8-shop-dark'),
        'content' => esc_html__('Show Full Content', 'the8-shop-dark'),
    ),
    'type'        => 'select',
));

// === "Read More" Button Customization ===
$wp_customize->add_setting('read_more_text', array(
    'default'           => isset($default['read_more_text']) ? $default['read_more_text'] : '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('read_more_text', array(
    'label'       => esc_html__('Customize "Read More" Button', 'the8-shop-dark'),
    'description' => esc_html__('Enter custom text for the "Read More" button. Leave blank to hide it.', 'the8-shop-dark'),
    'section'     => 'theme_option_section_settings',
    'type'        => 'text',
));

// === Hide Meta Information on Archive Pages ===
$wp_customize->add_setting('blog_meta_hide', array(
    'default'           => isset($default['blog_meta_hide']) ? $default['blog_meta_hide'] : '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'the8_shop_dark_sanitize_checkbox',
));

$wp_customize->add_control('blog_meta_hide', array(
    'label'   => esc_html__('Hide Meta Information on Archive Pages', 'the8-shop-dark'),
    'section' => 'theme_option_section_settings',
    'type'    => 'checkbox',
));

// === Hide Meta Information on Single Blog Posts ===
$wp_customize->add_setting('single_meta_hide', array(
    'default'           => isset($default['single_meta_hide']) ? $default['single_meta_hide'] : '',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'the8_shop_dark_sanitize_checkbox',
));

$wp_customize->add_control('single_meta_hide', array(
    'label'   => esc_html__('Hide Meta Information on Single Blog Posts', 'the8-shop-dark'),
    'section' => 'theme_option_section_settings',
    'type'    => 'checkbox',
));

		
/*Posts management section start */
$wp_customize->add_section( 'page_option_section_settings',
	array(
		'title'      => esc_html__( 'Page Layout Settings', 'the8-shop-dark' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
		
	)
);

	
		/*Home Page Layout*/
		$wp_customize->add_setting( 'page_layout',
			array(
				'default'           => $default['blog_layout'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'the8_shop_dark_sanitize_select',
			)
		);
		$wp_customize->add_control( 'page_layout',
			array(
				'label'    => esc_html__( 'Page Layout', 'the8-shop-dark' ),
				'section'  => 'page_option_section_settings',
				'description' => esc_html__( 'Choose between different layout options to be used as default', 'the8-shop-dark' ),
				'choices'   => array(
					'sidebar-content'  => esc_html__('Sidebar on Left, Content on Right', 'the8-shop-dark'),
					'content-sidebar'  => esc_html__('Content on Left, Sidebar on Right', 'the8-shop-dark'),
					'full-container'       => esc_html__('Full Width (No Sidebar)', 'the8-shop-dark'),
					),
				'type'     => 'select',
				'priority' => 170,
			)
		);

// Footer Settings Section
$wp_customize->add_section( 'footer_section',
	array(
		'title'      => esc_html__( 'Footer Settings', 'the8-shop-dark' ),
		'priority'   => 130,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
		'description' => esc_html__( 'Upgrade to The8 Pro version to unlock 100+ additional settings, Elementor add-ons, and all premium features—including advanced WooCommerce options.', 'the8-shop-dark' ),
	)
);

// Copyright Text Setting
$wp_customize->add_setting( 'copyright_text',
	array(
		'default'           => $default['copyright_text'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'copyright_text',
	array(
		'label'       => esc_html__( 'Copyright Text', 'the8-shop-dark' ),
		'section'     => 'footer_section',
		'description' => esc_html__( 'Customize the footer copyright message.', 'the8-shop-dark' ),
		'type'        => 'textarea',
		'priority'    => 10,
	)
);

// Social options
$business_consulting_options = array(
    'bi-facebook'  => array( 'label' => esc_html__( 'Facebook URL', 'the8-shop-dark' ) ),
    'bi-twitter'   => array( 'label' => esc_html__( 'Twitter URL', 'the8-shop-dark' ) ),
    'bi-pinterest' => array( 'label' => esc_html__( 'Pinterest URL', 'the8-shop-dark' ) ),
    'bi-youtube'   => array( 'label' => esc_html__( 'YouTube URL', 'the8-shop-dark' ) ),
    'bi-instagram' => array( 'label' => esc_html__( 'Instagram URL', 'the8-shop-dark' ) ),
);

// Loop
foreach ( $business_consulting_options as $key => $val ) {

    // Setting
    $wp_customize->add_setting(
        'the8_shop_social[' . $key . ']',
        array(
            'default'           => '',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        )
    );

    // Control
    $wp_customize->add_control(
        'the8_shop_social[' . $key . ']',
        array(
            'label'   => $val['label'],
            'section' => 'footer_section',
            'type'    => 'url',
            'priority'    => 20,
        )
    );
}		