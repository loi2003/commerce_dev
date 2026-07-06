<?php

if (!defined('ABSPATH')) exit;

function sa_console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}

function sa_logout_session()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['sa_user']);
    unset($_SESSION['sa_error']);

    session_destroy();
}