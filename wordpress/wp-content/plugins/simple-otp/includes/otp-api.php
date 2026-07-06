<?php

if (!defined('ABSPATH')) {
    exit;
}

function sa_send_otp($email)
{
    return sa_send_otp_email($email);
}

function sa_check_otp($email, $otp)
{
    return sa_verify_otp($email, $otp);
}

function sa_email_verified($email)
{
    return sa_is_verified($email);
}

function sa_destroy_otp()
{
    sa_clear_otp();
}