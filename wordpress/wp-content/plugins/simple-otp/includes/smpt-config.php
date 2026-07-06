<?php

if (!defined('ABSPATH')) exit;

add_action('plugins_loaded', function () {

    add_action('phpmailer_init', function ($phpmailer) {

        error_log('SMTP INIT REAL RUN');

        $phpmailer->isSMTP();
        $phpmailer->Mailer = 'smtp';

        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 587;
        $phpmailer->SMTPSecure = 'tls';

        $phpmailer->Username = 'sasukeholy@gmail.com';
        $phpmailer->Password = PASSKEY;

        $phpmailer->setFrom('sasukeholy@gmail.com', 'Simple OTP');

        $phpmailer->SMTPDebug = 2;
        $phpmailer->Debugoutput = function ($str) {
            error_log('SMTP: ' . $str);
        };

    }, 999); // 🔥 QUAN TRỌNG: priority cao nhất

}, 1);