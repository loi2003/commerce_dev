<?php
/*
Plugin Name: Simple OTP
Version: 1.0
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'Models/OtpModel.php';
require_once plugin_dir_path(__FILE__) . 'includes/otp-generator.php';
require_once plugin_dir_path(__FILE__) . 'includes/smpt-config.php';
require_once plugin_dir_path(__FILE__) . 'includes/otp-mailer.php';
require_once plugin_dir_path(__FILE__) . 'includes/otp-verify.php';