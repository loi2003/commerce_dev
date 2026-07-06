<?php

class SO_Auth
{
    public static function get_wp_user_id()
    {
        return (int) ($_SESSION['sa_user']['wp_user_id'] ?? 0);
    }

    public static function check()
    {
        return self::get_wp_user_id() > 0;
    }
}