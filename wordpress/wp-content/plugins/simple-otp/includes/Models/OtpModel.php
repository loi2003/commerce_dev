<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__)
    . '../../../simple-auth/DB/AuthDB.php';

class OtpModel
{
    private static function db()
    {
        return AuthDB::conn();
    }

    public static function create(
        $email,
        $otp
    ) {

        self::deleteByEmail(
            $email
        );

        $db = self::db();

        $stmt = $db->prepare("
            INSERT INTO otp_sessions (
                email,
                otp_code,
                expires_at
            )
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $email,
            $otp,
            date(
                'Y-m-d H:i:s',
                time() + 180
            )
        ]);
    }

    public static function find(
        $email
    ) {

        $db = self::db();

        $stmt = $db->prepare("
            SELECT *
            FROM otp_sessions
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->execute([
            $email
        ]);

        return $stmt->fetch(
            PDO::FETCH_OBJ
        );
    }

    public static function verify(
        $email,
        $otp
    ) {

        $record =
            self::find(
                $email
            );

        if (!$record) {
            return false;
        }

        if (
            strtotime(
                $record->expires_at
            ) < time()
        ) {

            self::deleteByEmail(
                $email
            );

            return false;
        }

        if (
            $record->otp_code != $otp
        ) {
            return false;
        }

        self::deleteByEmail(
            $email
        );

        return true;
    }

    public static function deleteByEmail(
        $email
    ) {

        $db = self::db();

        $stmt = $db->prepare("
            DELETE
            FROM otp_sessions
            WHERE email = ?
        ");

        return $stmt->execute([
            $email
        ]);
    }

    public static function cleanupExpired()
    {

        $db = self::db();

        $stmt = $db->prepare("
            DELETE
            FROM otp_sessions
            WHERE expires_at < NOW()
        ");

        return $stmt->execute();
    }
}
