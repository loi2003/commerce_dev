<?php
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '/Models/UserModel.php';
require_once plugin_dir_path(__FILE__) . '../../simple-otp/includes/otp-generator.php';
require_once plugin_dir_path(__FILE__) . '../../simple-otp/includes/otp-mailer.php';
require_once plugin_dir_path(__FILE__) . '../../simple-otp/includes/otp-verify.php';

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/
function sa_handle_register()
{
    if (!isset($_POST['sa_register_submit'])) {
        return;
    }
    
    if (!session_id()) {
        session_start();
    }

    $username = trim($_POST['username'] ?? '');
    $email    = sanitize_email($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = 'user'; // Mặc định role là 'user'

    if (!$username || !$email || !$password) {
        $_SESSION['sa_error'] = 'Please fill in all fields';
        wp_redirect(home_url('/sa-register'));
        exit;
    }

    $userModel = new UserModel();

    // Check email tồn tại
    if ($userModel->findByEmail($email)) {
        $_SESSION['sa_error'] = 'Email already exists';
        wp_redirect(home_url('/sa-register'));
        exit;
    }


    // Gửi OTP
    if (!function_exists('sa_send_otp_email')) {
        $_SESSION['sa_error'] = 'Simple OTP chưa được kích hoạt';
        wp_redirect(home_url('/sa-register'));
        exit;
    }

    $sent = sa_send_otp_email($email);

    if (!$sent) {
        $_SESSION['sa_error'] = 'Cannot send OTP';
        wp_redirect(home_url('/sa-register'));
        exit;
    }

    // Lưu tạm thông tin vào session để xác nhận sau
    $_SESSION['sa_pending_user'] = [
        'username' => $username,
        'email'    => $email,
        'password' => $password,
        'role' => $role,
    ];

    
    // Chuyển sang trang nhập OTP
    wp_redirect(home_url('/sa-otp'));
    exit;
}

add_action('init', 'sa_handle_register');
