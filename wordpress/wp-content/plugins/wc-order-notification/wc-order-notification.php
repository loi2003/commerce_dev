<?php
/**
 * Plugin Name: WooCommerce Order Notification
 * Plugin URI:  https://example.com/
 * Description: Gửi email xác nhận đơn hàng sau khi khách hàng đặt hàng thành công.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://example.com/
 * License:     GPL-2.0+
 * Text Domain: wc-order-notification
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'WC_ORDER_NOTIFICATION_VERSION', '1.0.0' );
define( 'WC_ORDER_NOTIFICATION_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once WC_ORDER_NOTIFICATION_PLUGIN_DIR . 'includes/admin-notification.php';
require_once WC_ORDER_NOTIFICATION_PLUGIN_DIR . 'includes/class-notification.php';

new WC_Order_Notification();