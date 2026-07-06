<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!session_id()) {
    session_start();
}


require_once plugin_dir_path(__FILE__) . '/Models/UserModel.php';
require_once plugin_dir_path(__FILE__) . '../../simple-otp/includes/otp-verify.php';

function sa_handle_otp_verify()
{
    if (!isset($_POST['sa_otp_submit'])) {
        return;
    }

    $otp = trim($_POST['otp'] ?? '');
    $pendingUser = $_SESSION['sa_pending_user'] ?? null;

    if (!$pendingUser) {
        $_SESSION['sa_error'] = 'Session expired. Please register again.';
        wp_redirect(home_url('/sa-register'));
        exit;
    }

    if (!function_exists('sa_verify_otp')) {
        $_SESSION['sa_error'] = 'Simple OTP chưa được kích hoạt';
        wp_redirect(home_url('/sa-register'));
        exit;
    }

    if (!sa_verify_otp($pendingUser['email'], $otp)) {
        $_SESSION['sa_error'] = 'OTP không hợp lệ hoặc đã hết hạn';
        wp_redirect(home_url('/sa-register'));
        exit;
    }

    // Tạo user
    $userModel = new UserModel();
    $wp_user_id = wp_create_user(
        $pendingUser['email'],
        $pendingUser['password'],
        $pendingUser['email'],
    );

     if (is_wp_error($wp_user_id)) {
        $_SESSION['sa_error'] = 'Tài khoản đã tồn tại trong WordPress';
        wp_redirect(home_url('/sa-register'));
        exit;
        error_log($wp_user_id->get_error_message());
    }
        $wp_user = new WP_User($wp_user_id);
    $wp_user->set_role('customer');

     $created = $userModel->create(
        $pendingUser['username'],
        NULL,
        NULL,
        NULL,
        $pendingUser['email'],
        $pendingUser['password'],
        $pendingUser['role'],
        $wp_user_id
    );

    unset($_SESSION['sa_pending_user']);

    if (!$created) {
        require_once ABSPATH . 'wp-admin/includes/user.php';
        wp_delete_user($wp_user_id);
        $_SESSION['sa_error'] = 'Không thể tạo tài khoản xin liên hệ 0912345678 để được hỗ trợ';
        wp_redirect(home_url('/sa-register'));
        exit;
    }

    wp_redirect(home_url('/sa-login'));
    exit;
}

add_action('init', 'sa_handle_otp_verify');