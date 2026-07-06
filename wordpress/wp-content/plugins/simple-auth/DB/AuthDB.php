<?php

class AuthDB {

    private static $pdo = null;

    public static function conn() {

        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $host = SA_DB_HOST;
        $db   = SA_DB_NAME;
        $user = SA_DB_USER;
        $pass = SA_DB_PASS;

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        self::$pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        return self::$pdo;
    }
}