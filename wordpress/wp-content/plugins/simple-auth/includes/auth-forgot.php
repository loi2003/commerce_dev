<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '/Models/UserModel.php';
require_once plugin_dir_path(__FILE__) . '../../simple-otp/includes/otp-mailer.php';

function sa_handle_forgot_password()
{
    if (!isset($_POST['sa_forgot_submit'])) {
        return;
    }

    $email = sanitize_email(
        $_POST['email'] ?? ''
    );

    $userModel = new UserModel();

    $user = $userModel->findByEmail(
        $email
    );

    if (!$user) {
        wp_die('Email không tồn tại');
    }

    if (!sa_send_otp_email($email)) {
        wp_die('Không thể gửi OTP');
    }

    $_SESSION['sa_reset_email'] = $email;

    wp_redirect(
        home_url('/reset-password')
    );

    exit;
}

add_action(
    'init',
    'sa_handle_forgot_password'
);