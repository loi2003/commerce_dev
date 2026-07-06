<?php
function sa_logout()
{
    wp_logout();

    // Xử lý session custom
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['sa_user']);
    unset($_SESSION['sa_error']);

    session_destroy();

    // Xóa cookie PHPSESSID
    if (ini_get('session.use_cookies')) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    wp_redirect(home_url('/sa-login'));
    exit;
}
?>