<?php
class LoginCheckDB {
    private static $pdo = null;

    public static function conn() {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $host = defined('SA_DB_HOST') ? SA_DB_HOST : 'localhost';
        $db   = defined('SA_DB_NAME') ? SA_DB_NAME : 'auth_db';
        $user = defined('SA_DB_USER') ? SA_DB_USER : 'root';
        $pass = defined('SA_DB_PASS') ? SA_DB_PASS : '';

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        self::$pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        return self::$pdo;
    }
}