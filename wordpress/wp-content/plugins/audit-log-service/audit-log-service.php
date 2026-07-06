<?php
/**
 * Plugin Name: Audit Log Service
 * Plugin URI:  https://example.com/
 * Description: Ghi lại và hiển thị nhật ký hoạt động của người dùng: xem sản phẩm, thêm giỏ, tìm kiếm, đơn hàng, sản phẩm.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  https://example.com/
 * License:     GPL-2.0+
 * Text Domain: audit-log-service
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'AUDIT_LOG_VERSION', '1.0.0' );
define( 'AUDIT_LOG_PLUGIN_FILE', __FILE__ );
define( 'AUDIT_LOG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AUDIT_LOG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once AUDIT_LOG_PLUGIN_DIR . 'includes/main-audit.php';

new Audit_Log_Main();