<?php
/*
Plugin Name: Simple Auth Clean
Version: 1.0
*/

if (!defined('ABSPATH')) exit;

add_action('init', function () {
    if (!session_id()) {
        session_start();
    }
});
/*thêm backend thì thêm vào*/

require_once plugin_dir_path(__FILE__) . 'DB/AuthDB.php';

require_once plugin_dir_path(__FILE__) . 'admin/user-page.php';
require_once plugin_dir_path(__FILE__) . 'admin/menu.php';
require_once plugin_dir_path(__FILE__) . 'includes/auth-register.php';
require_once plugin_dir_path(__FILE__) . 'includes/auth-login.php';
require_once plugin_dir_path(__FILE__) . 'includes/helpers.php';
require_once plugin_dir_path(__FILE__) . 'includes/auth-otp.php';
require_once plugin_dir_path(__FILE__) . 'includes/auth-forgot.php';
require_once plugin_dir_path(__FILE__) . 'includes/auth-otp-forgot.php';
require_once plugin_dir_path(__FILE__) . 'includes/auth-voucher.php';
/**
 * REWRITE ROUTES
 */
/**  thêm pages html**/
add_action('init', function () {

    add_rewrite_rule('^sa-login/?$', 'index.php?sa_page=login', 'top');
    add_rewrite_rule('^sa-register/?$', 'index.php?sa_page=register', 'top');
    add_rewrite_rule('^sa-otp/?$', 'index.php?sa_page=otp', 'top');
    add_rewrite_rule('^sa-forgot/?$', 'index.php?sa_page=forgot', 'top');
    add_rewrite_rule('^reset-password/?$', 'index.php?sa_page=reset_password', 'top');  
});

/**
 * QUERY VAR
 */
add_filter('query_vars', function ($vars) {
    $vars[] = 'sa_page';
    return $vars;
});

/**
 * LOAD VIEW
 */
function sa_template_loader() {

    $page = get_query_var('sa_page');

    if ($page === 'login') {
        include plugin_dir_path(__FILE__) . 'views/login.php';
        exit;
    }

    if ($page === 'register') {
        include plugin_dir_path(__FILE__) . 'views/register.php';
        exit;
    }
    if ($page === 'otp') {
        include plugin_dir_path(__FILE__) . 'views/otp.php';
        exit;
    }
    if ($page === 'forgot') {
        include plugin_dir_path(__FILE__) . 'views/forgotpassword.php';
        exit;
    }
    if ($page === 'reset_password') {
        include plugin_dir_path(__FILE__) . 'views/resetpassword.php';
        exit;
    }
}

add_action('wp_logout', 'sa_logout_session');

add_filter('logout_redirect', function () {
    return home_url('/sa-login/');
});
add_action('wp_head', function () {
    if (is_wc_endpoint_url('edit-account')) {
        echo '<style>
            .woocommerce-EditAccountForm fieldset {
                display:none !important;
            }
        </style>';
    }
});
add_action('wp_ajax_apply_coupon', 'apply_coupon_handler');
add_action('wp_ajax_nopriv_apply_coupon', 'apply_coupon_handler');

function apply_coupon_handler()
{
    if (
        !isset($_POST['nonce']) ||
        !wp_verify_nonce($_POST['nonce'], 'apply_coupon_nonce')
    ) {
        wp_send_json_error([
            'message' => 'Invalid nonce'
        ]);
    }

    $code = sanitize_text_field(
        $_POST['coupon_code'] ?? ''
    );

    if (!$code) {
        wp_send_json_error([
            'message' => 'Coupon rỗng'
        ]);
    }

    if (!WC()->cart) {
        wc_load_cart();
    }

    $result = WC()->cart->apply_coupon($code);

    if ($result) {

        WC()->cart->calculate_totals();

        wp_send_json_success([
            'message' => 'Áp dụng thành công'
        ]);
    }

    wp_send_json_error([
        'message' => 'Coupon không hợp lệ'
    ]);
}

add_action('template_redirect', function () {

    if (!is_page('my-account')) {
        return;
    }

    if (!is_user_logged_in()) {

        wp_redirect(home_url('/sa-login/'));
        exit;

    }

});

add_action('template_redirect', 'sa_template_loader');