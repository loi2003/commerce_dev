<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '../../DB/AuthDB.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = AuthDB::conn();
    }

    /*
    |--------------------------------------------------------------------------
    | Create User
    |--------------------------------------------------------------------------
    */

    public function create(
        $username,
        $gender,
        $phone,
        $age,
        $email,
        $password,
        $role,
        $wp_user_id = null
    ) {

        $hash = password_hash(
            $password,
            PASSWORD_BCRYPT
        );

        $stmt = $this->db->prepare("
            INSERT INTO users (
                username,
                gender,
                phone,
                age,
                email,
                password,
                role,
                wp_user_id
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $username,
            $gender,
            $phone,
            $age,
            $email,
            $hash,
            $role,
            $wp_user_id
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Find By Email
    |--------------------------------------------------------------------------
    */

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM users
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->execute([
            $email
        ]);

        return $stmt->fetch(
            PDO::FETCH_ASSOC
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Find By Phone
    |--------------------------------------------------------------------------
    */

    public function findByPhone($phone)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM users
            WHERE phone = ?
            LIMIT 1
        ");

        $stmt->execute([
            $phone
        ]);

        return $stmt->fetch(
            PDO::FETCH_ASSOC
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function verifyLogin(
        $email,
        $password
    ) {

        $user =
            $this->findByEmail(
                $email
            );

        if (!$user) {
            return false;
        }

        if (
            !password_verify(
                $password,
                $user['password']
            )
        ) {
            return false;
        }

        return $user;
    }

    public function updatePassword($email, $password) 
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET password = ?
            WHERE email = ?
        ");

        return $stmt->execute([
            $password,
            $email
        ]);
    }
    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT *
            FROM users
            ORDER BY id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM users
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRole($id, $role)
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET role = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $role,
            $id
        ]);
    }

    public function delete($id)
    {
    $user = $this->findById($id);


    if (!empty($user['wp_user_id'])) {

        require_once ABSPATH . 'wp-admin/includes/user.php';

        $result = wp_delete_user(
            (int)$user['wp_user_id']
        );

    }

    $stmt = $this->db->prepare("
        DELETE FROM users
        WHERE id = ?
    ");

    return $stmt->execute([$id]);
    }
}