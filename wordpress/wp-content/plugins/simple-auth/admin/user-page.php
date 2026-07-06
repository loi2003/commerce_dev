<?php

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Models/UserModel.php';

function sa_users_page()
{
    $model = new UserModel();

    /*
    |--------------------------------------------------------------------------
    | Update Role
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['sa_update_role']) &&
        current_user_can('manage_options')
    ) {

        $model->updateRole(
            intval($_POST['user_id']),
            sanitize_text_field($_POST['role'])
        );

        echo '<div class="notice notice-success"><p>Role updated.</p></div>';
    }

    /*
    |--------------------------------------------------------------------------
    | Delete User
    |--------------------------------------------------------------------------
    */

    if (
        isset($_POST['sa_delete_user']) &&
        current_user_can('manage_options')
    ) {

        $model->delete(
            intval($_POST['user_id'])
        );

        echo '<div class="notice notice-success"><p>User deleted.</p></div>';
    }

    $users = $model->getAll();

    ?>

    <div class="wrap">

        <h1>Auth Users</h1>

        <table class="wp-list-table widefat striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Age</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($users as $user): ?>

                <tr>

                    <td><?= esc_html($user['id']) ?></td>

                    <td><?= esc_html($user['username']) ?></td>

                    <td><?= esc_html($user['email']) ?></td>

                    <td><?= esc_html($user['phone']) ?></td>

                    <td><?= esc_html($user['age']) ?></td>

                    <td>

                        <form method="post">

                            <input
                                type="hidden"
                                name="user_id"
                                value="<?= esc_attr($user['id']) ?>"
                            >

                            <select name="role">

                                <option
                                    value="user"
                                    <?= selected($user['role'], 'user', false) ?>
                                >
                                    User
                                </option>

                                <option
                                    value="admin"
                                    <?= selected($user['role'], 'admin', false) ?>
                                >
                                    Admin
                                </option>

                            </select>

                            <button
                                class="button button-primary"
                                name="sa_update_role"
                            >
                                Save
                            </button>

                        </form>

                    </td>

                    <td>

                        <form method="post">

                            <input
                                type="hidden"
                                name="user_id"
                                value="<?= esc_attr($user['id']) ?>"
                            >

                            <button
                                class="button button-secondary"
                                name="sa_delete_user"
                                onclick="return confirm('Delete user?')"
                            >
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <?php
}