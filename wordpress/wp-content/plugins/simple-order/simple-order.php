<?php
/**
 * Plugin Name: Simple Order
 */

defined('ABSPATH') || exit;

// include files
require_once plugin_dir_path(__FILE__) . 'includes/class-so-loader.php';

function so_init_plugin()
{
    new SO_Loader();
}
add_action('plugins_loaded', 'so_init_plugin');
