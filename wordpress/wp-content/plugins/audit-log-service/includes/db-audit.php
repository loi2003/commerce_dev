<?php
if ( ! defined( 'ABSPATH' ) ) exit;
require_once __DIR__ . '/auth-db-audit.php';

class AuditLogDB_Audit {
    private $table = 'audit_log';

    public function create_table() {
        try {
            $pdo = AuthDB_Audit::conn();
            $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                user_id BIGINT(20) UNSIGNED NULL DEFAULT NULL,
                user_email VARCHAR(100) NULL DEFAULT NULL,
                action VARCHAR(100) NOT NULL,
                object_type VARCHAR(50) NOT NULL,
                object_id BIGINT(20) UNSIGNED NULL DEFAULT NULL,
                details TEXT NULL,
                ip_address VARCHAR(45) NULL DEFAULT NULL,
                user_agent TEXT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id),
                INDEX idx_user_id (user_id),
                INDEX idx_user_email (user_email),
                INDEX idx_action (action),
                INDEX idx_created_at (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $pdo->exec($sql);
            return true;
        } catch (PDOException $e) {
            error_log('create_table error: ' . $e->getMessage());
            return false;
        }
    }

    public function insert($data) {
        try {
            $pdo = AuthDB_Audit::conn();
            $stmt = $pdo->prepare("INSERT INTO {$this->table} 
                (user_id, user_email, action, object_type, object_id, details, ip_address, user_agent, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            return $stmt->execute([
                $data['user_id'],
                $data['user_email'],
                $data['action'],
                $data['object_type'],
                $data['object_id'],
                $data['details'],
                $data['ip_address'],
                $data['user_agent']
            ]);
        } catch (PDOException $e) {
            error_log('insert error: ' . $e->getMessage());
            return false;
        }
    }

    public function get_logs($filters = [], $limit = 20, $offset = 0) {
        try {
            $pdo = AuthDB_Audit::conn();
            $where = '1=1';
            $params = [];

            if (!empty($filters['user_email'])) {
                $where .= ' AND user_email = ?';
                $params[] = $filters['user_email'];
            }
            if (!empty($filters['action'])) {
                $where .= ' AND action = ?';
                $params[] = $filters['action'];
            }
            if (!empty($filters['from_date'])) {
                $where .= ' AND created_at >= ?';
                $params[] = $filters['from_date'] . ' 00:00:00';
            }
            if (!empty($filters['to_date'])) {
                $where .= ' AND created_at <= ?';
                $params[] = $filters['to_date'] . ' 23:59:59';
            }

            // Ép kiểu int để tránh lỗi SQL
            $limit = (int)$limit;
            $offset = (int)$offset;
            $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log('get_logs error: ' . $e->getMessage());
            return [];
        }
    }

    public function count_logs($filters = []) {
        try {
            $pdo = AuthDB_Audit::conn();
            $where = '1=1';
            $params = [];

            if (!empty($filters['user_email'])) {
                $where .= ' AND user_email = ?';
                $params[] = $filters['user_email'];
            }
            if (!empty($filters['action'])) {
                $where .= ' AND action = ?';
                $params[] = $filters['action'];
            }
            if (!empty($filters['from_date'])) {
                $where .= ' AND created_at >= ?';
                $params[] = $filters['from_date'] . ' 00:00:00';
            }
            if (!empty($filters['to_date'])) {
                $where .= ' AND created_at <= ?';
                $params[] = $filters['to_date'] . ' 23:59:59';
            }

            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE {$where}";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('count_logs error: ' . $e->getMessage());
            return 0;
        }
    }

    public function get_distinct_actions() {
        try {
            $pdo = AuthDB_Audit::conn();
            $stmt = $pdo->query("SELECT DISTINCT action FROM {$this->table} ORDER BY action");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log('get_distinct_actions error: ' . $e->getMessage());
            return [];
        }
    }

    public function get_users_from_auth_db() {
        try {
            $pdo = AuthDB_Audit::conn();
            // Kiểm tra bảng users
            $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
            if ($stmt->rowCount() == 0) {
                // Fallback lấy distinct email từ audit_log
                $stmt = $pdo->query("SELECT DISTINCT user_email AS email, user_id AS id FROM {$this->table} WHERE user_email IS NOT NULL AND user_email != '' ORDER BY user_email");
                $results = $stmt->fetchAll(PDO::FETCH_OBJ);
                $users = [];
                foreach ($results as $row) {
                    $users[$row->email] = $row->email;
                }
                return $users;
            }
            $stmt = $pdo->query("SELECT id, email FROM users ORDER BY email");
            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
            $users = [];
            foreach ($rows as $row) {
                $users[$row->id] = $row->email;
            }
            return $users;
        } catch (PDOException $e) {
            error_log('get_users_from_auth_db error: ' . $e->getMessage());
            return [];
        }
    }
}