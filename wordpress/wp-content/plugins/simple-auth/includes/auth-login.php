<?php

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'Models/UserModel.php';

function sa_handle_login()
{
    if (!isset($_POST['sa_login_submit'])) {
        return;
    }

    if (!session_id()) {
        session_start();
    }
    error_log('=== LOGIN REQUEST ===');

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    error_log('Email: ' . $email);  

    if (!$email || !$password) {
        $_SESSION['sa_error'] = 'Missing email or password';
        error_log('Session error: ' . print_r($_SESSION['sa_error'], true));
        wp_redirect(home_url('/sa-login'));
        exit;
    }

    $model = new UserModel();

    $user = $model->findByEmail($email);

    if (!$user) {
        $_SESSION['sa_error'] = 'User not found';
        wp_redirect(home_url('/sa-login'));
        exit;
    }

    error_log('User found ID: ' . $user['id']);

    if (file_exists(WP_PLUGIN_DIR . '/login-check-service/includes/class-rate-limiter.php')) {
    require_once WP_PLUGIN_DIR . '/login-check-service/includes/class-rate-limiter.php';
    $rate_limiter = new LoginRateLimiter();
    $blocked_msg = $rate_limiter->is_blocked($email);
    if ($blocked_msg) {
            $_SESSION['sa_error'] = $blocked_msg;
            session_write_close(); // ← THÊM DÒNG NÀY
            wp_redirect(home_url('/sa-login'));
            exit;
        }
    }
        
    if (!password_verify($password, $user['password'])) {
        do_action('sa_login_failed', $email);
        $_SESSION['sa_error'] = 'Wrong password';
        wp_redirect(home_url('/sa-login'));
        exit;   
    }
    


    $_SESSION['sa_user'] = [
        'id' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'wp_user_id' => $user['wp_user_id'],
    ];
    $wp_user_id = (int) ($_SESSION['sa_user']['wp_user_id'] ?? 0);

    /**
     * Login WordPress bằng wp_user_id
     */
    if ($wp_user_id > 0) {

        $wp_user = get_user_by('id', $wp_user_id);

        if (!$wp_user) {
            $_SESSION['sa_error'] = 'Linked WordPress user not found';
            wp_redirect(home_url('/sa-login'));
            exit;
        }

        wp_set_current_user($wp_user_id);
        wp_set_auth_cookie($wp_user_id, true);
        do_action('sa_login_success', $email);
        do_action(
            'wp_login',
            $wp_user->user_login,
            $wp_user
        );
    }
    error_log('LOGIN SUCCESS');
    error_log(print_r($_SESSION['sa_user'], true));
    error_log(print_r(wp_get_current_user()->roles, true));
    if ($user['role'] === 'admin') {
    wp_redirect(home_url('/wp-admin'));
    exit;
    }
    else if ($user['role'] === 'user') {
    wp_redirect(home_url('/'));
    exit;
    }
    else {
        $_SESSION['sa_error'] = 'Invalid user role';
        wp_redirect(home_url('/login'));
        exit;
    }
    //wp_redirect(home_url());
    //exit;
}