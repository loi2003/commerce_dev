<?php

if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'sa_admin_menu');

function sa_admin_menu()
{
    add_menu_page(
        'Simple Auth',
        'Simple Auth',
        'manage_options',
        'simple-auth',
        'sa_users_page',
        'dashicons-admin-users',
        25
    );

    add_submenu_page(
        'simple-auth',
        'Users',
        'Users',
        'manage_options',
        'simple-auth',
        'sa_users_page'
    );
}