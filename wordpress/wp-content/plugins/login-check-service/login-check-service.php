<?php
/**
 * Plugin Name: Login Check Service
 * Description: Microservice ghi log login/logout, register, reset password, login failed và rate limiting.
 * Version: 1.2
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

if (!defined('SA_DB_HOST')) {
    define('SA_DB_HOST', 'localhost');
    define('SA_DB_NAME', 'auth_db');
    define('SA_DB_USER', 'root');
    define('SA_DB_PASS', '');
}

define('LCS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LCS_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load các class
require_once LCS_PLUGIN_DIR . 'includes/class-db.php';
require_once LCS_PLUGIN_DIR . 'includes/class-login-logger.php';
require_once LCS_PLUGIN_DIR . 'includes/class-rate-limiter.php';
require_once LCS_PLUGIN_DIR . 'includes/class-admin.php';

// Khởi tạo
$logger = new LoginLogger();
$rate_limiter = new LoginRateLimiter();

// Tạo bảng khi kích hoạt
register_activation_hook(__FILE__, array($logger, 'create_table'));
register_activation_hook(__FILE__, array($rate_limiter, 'create_table'));

// === HOOK LOGIN THÀNH CÔNG ===
add_action('wp_login', array($logger, 'log_login'), 10, 2);
add_action('wp_login', array($rate_limiter, 'reset_attempts'), 10, 2);

// === HOOK LOGIN THẤT BẠI (từ auth-login.php) ===
add_action('sa_login_failed', array($rate_limiter, 'log_failed_attempt'), 10, 1);
add_action('sa_login_failed', array($logger, 'log_login_failed'), 10, 1);

// === HOOK LOGOUT ===
add_action('wp_logout', array($logger, 'log_logout'), 999);
add_action('clear_auth_cookie', array($logger, 'log_logout'), 999);

// === HOOK REGISTER ===
add_action('user_register', array($logger, 'log_register'));

// === HOOK RESET PASSWORD (từ auth-otp-forgot.php) ===
add_action('sa_reset_password_success', array($logger, 'log_reset_password_custom'));

// === ADMIN ===
$admin = new LCS_Admin();
add_action('admin_init', array($admin, 'handle_view_log'));
add_action('admin_footer', array($admin, 'add_check_log_buttons'));