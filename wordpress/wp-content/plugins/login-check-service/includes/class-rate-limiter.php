<?php
class LoginRateLimiter {

    private $db;
    private $max_attempts = 5;
    private $block_duration = 100; // 5 phút

    public function __construct() {
        $this->db = LoginCheckDB::conn();
    }

    public function create_table() {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS login_attempts (
                email VARCHAR(100) NOT NULL PRIMARY KEY,
                failed_count INT DEFAULT 1,
                first_attempt_time DATETIME DEFAULT CURRENT_TIMESTAMP,
                blocked_until DATETIME DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $this->db->exec($sql);
        } catch (PDOException $e) {
            error_log('LoginRateLimiter: Lỗi tạo bảng - ' . $e->getMessage());
        }
    }

    /**
     * Kiểm tra xem email có đang bị khóa không
     * Trả về thông báo lỗi nếu bị khóa, hoặc false nếu không
     */
    public function is_blocked($email) {
        if (empty($email)) return false;

        $stmt = $this->db->prepare("SELECT blocked_until FROM login_attempts WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['blocked_until']) {
            $blocked_until = new DateTime($row['blocked_until']);
            $now = new DateTime();
            if ($now < $blocked_until) {
                $remaining = $blocked_until->getTimestamp() - $now->getTimestamp();
                return sprintf(
                    'Tài khoản đang bị khóa tạm thời do nhập sai mật khẩu quá nhiều. Vui lòng thử lại sau %d giây.',
                    $remaining
                );
            } else {
                // Hết thời gian khóa, xóa blocked_until nhưng giữ nguyên failed_count
                $stmt = $this->db->prepare("UPDATE login_attempts SET blocked_until = NULL WHERE email = ?");
                $stmt->execute([$email]);
            }
        }
        return false;
    }

    /**
     * Ghi log thất bại, tăng counter, khóa nếu vượt ngưỡng
     */
    public function log_failed_attempt($email) {
        if (empty($email)) return;

        $now = new DateTime();
        $now_str = $now->format('Y-m-d H:i:s');

        $stmt = $this->db->prepare("SELECT * FROM login_attempts WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Đã có record
            $current_count = $row['failed_count'];
            $blocked_until = $row['blocked_until'];

            // Kiểm tra xem có đang bị khóa không
            $is_blocked = false;
            if ($blocked_until) {
                $blocked_time = new DateTime($blocked_until);
                if ($now < $blocked_time) {
                    $is_blocked = true;
                } else {
                    // Hết khóa, xóa blocked_until
                    $stmt = $this->db->prepare("DELETE FROM login_attempts WHERE email = ?");
                    $stmt->execute([$email]);
                }
            }

            // Nếu không bị khóa và chưa đạt max, tăng counter
            if (!$is_blocked && $current_count < $this->max_attempts) {
                $new_count = $current_count + 1;
                $sql = "UPDATE login_attempts SET failed_count = ? WHERE email = ?";
                $stmt2 = $this->db->prepare($sql);
                $stmt2->execute([$new_count, $email]);
            } else {
                $new_count = $current_count; // giữ nguyên
            }

            // Nếu đạt ngưỡng, khóa
            if ($new_count >= $this->max_attempts) {
                $blocked_until = clone $now;
                $blocked_until->add(new DateInterval('PT' . $this->block_duration . 'S'));
                $blocked_str = $blocked_until->format('Y-m-d H:i:s');
                $sql = "UPDATE login_attempts SET blocked_until = ? WHERE email = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$blocked_str, $email]);
                error_log("LoginRateLimiter: Locked email $email until $blocked_str");
            }
        } else {
            // Chưa có record, insert mới
            $sql = "INSERT INTO login_attempts (email, failed_count, first_attempt_time) VALUES (?, 1, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$email, $now_str]);
        }
    }

    /**
     * Reset số lần thử khi đăng nhập thành công
     */
    public function reset_attempts($user_login, $user) {
        $email = $user->user_email;
        if (empty($email)) return;
        $stmt = $this->db->prepare("DELETE FROM login_attempts WHERE email = ?");
        $stmt->execute([$email]);
    }
}