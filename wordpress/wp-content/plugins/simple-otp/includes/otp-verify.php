<?php

if (!defined('ABSPATH')) {
    exit;
}

function sa_verify_otp(
    $email,
    $otp
)
{
    return OtpModel::verify(
        $email,
        $otp
    );
}