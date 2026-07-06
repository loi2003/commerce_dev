<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '/Models/UserModel.php';
require_once plugin_dir_path(__FILE__) . '../../simple-otp/includes/otp-verify.php';

function sa_handle_reset_password()
{
    if (!isset($_POST['sa_reset_submit'])) {
        return;
    }

    $email = $_SESSION['sa_reset_email'] ?? null;

    if (!$email) {
        wp_die('Phiên không hợp lệ');
    }

    $otp = trim($_POST['otp'] ?? '');

    $password = $_POST['password'] ?? '';

    $confirm = $_POST['password_confirmation'] ?? '';

    if (!$password) {
        wp_die('Vui lòng nhập mật khẩu mới');
    }

    if ($password !== $confirm) {
        wp_die('Mật khẩu xác nhận không khớp');
    }

    if (!function_exists('sa_verify_otp')) {
        wp_die('Simple OTP chưa được kích hoạt');
    }

    if (!sa_verify_otp($email, $otp)) {
        wp_die('OTP không hợp lệ hoặc đã hết hạn');
    }

    $userModel = new UserModel();

    $updated = $userModel->updatePassword(
        $email,
        password_hash($password, PASSWORD_BCRYPT)
    );

    if (!$updated) {
        wp_die('Không thể cập nhật mật khẩu');
    }
    if ($updated) {
    do_action('sa_reset_password_success', $email);
    }
    unset($_SESSION['sa_reset_email']);

    wp_redirect(home_url('/sa-login'));
    exit;
}

add_action(
    'init',
    'sa_handle_reset_password'
);