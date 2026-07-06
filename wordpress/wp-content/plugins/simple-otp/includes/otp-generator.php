<?php

if (!defined('ABSPATH')) {
    exit;
}

function sa_generate_otp()
{
    return str_pad(
        random_int(0, 999999),
        6,
        '0',
        STR_PAD_LEFT
    );
}