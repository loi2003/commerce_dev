<?php
if (!session_id()) {
    session_start();
}

// 🔥 lấy message từ BE
$error = $_SESSION['sa_error'] ?? null;
$success = $_SESSION['sa_success'] ?? null;

// clear sau khi đọc (tránh lặp lại)
unset($_SESSION['sa_error'], $_SESSION['sa_success']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực OTP - Nông Sản Sạch</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../assets/css/style-otp.css'; ?>">
</head>
<body>
    <div class="otp-wrapper">
        <div class="otp-card">
            <!-- Progress Bar - bước 2/2 -->
            <div class="progress-container">
                <div class="progress-steps">
                    <div class="progress-line" id="progressLine"></div>
                    <div class="step completed" id="step1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Thông tin</div>
                    </div>
                    <div class="step active" id="step2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Xác thực OTP</div>
                    </div>
                </div>
            </div>

            <div class="otp-icon">
                <i class="fas fa-key"></i>
            </div>
            <div class="otp-header">
                <h2>Xác thực OTP</h2>
                <p>Nhập mã xác nhận để hoàn tất đăng ký</p>
            </div>
            
            <div style="text-align: center;">
                <div class="email-hint">
                    <i class="fas fa-envelope"></i> Mã OTP đã được gửi đến email của bạn
                </div>
            </div>

            <!-- Countdown 3 phút (180 giây) -->
            <div class="countdown-container">
                <span class="countdown-label"><i class="fas fa-hourglass-half"></i> Mã OTP hết hạn sau:</span>
                <span class="countdown-timer" id="countdownTimer">03:00</span>
            </div>

            <!-- FORM GỐC - KHÔNG THAY ĐỔI BẤT CỨ THUỘC TÍNH NÀO -->
            <form id="sa-otp-form" method="POST">
                <div>
                    <label><i class="fas fa-lock"></i> Nhập mã OTP</label>
                    <input type="text" name="otp" maxlength="6" required id="otpInput">
                </div>
                <button type="submit" name="sa_otp_submit" id="submitBtn">Xác nhận</button>
            </form>

            <div class="otp-footer">
                <a href="<?php echo home_url('/sa-register/'); ?>">
                    <i class="fas fa-arrow-left"></i> Quay lại đăng ký
                </a>
            </div>

            <!-- Optional: message area nếu có lỗi từ PHP -->
            <?php if (isset($error)): ?>
            <div class="message-area">
                <div class="message error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Countdown 3 phút = 180 giây
        let timeLeft = 180; // 180 giây = 3 phút
        const timerElement = document.getElementById('countdownTimer');
        const otpInput = document.getElementById('otpInput');
        const submitBtn = document.getElementById('submitBtn');

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        function updateCountdown() {
            if (timeLeft <= 0) {
                timerElement.textContent = '00:00';
                timerElement.classList.add('expired');
                // Vô hiệu hóa input và nút submit khi hết hạn
                if (otpInput) {
                    otpInput.disabled = true;
                    otpInput.placeholder = 'Mã OTP đã hết hạn';
                }
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-clock"></i> Mã OTP đã hết hạn';
                }
                return;
            }
            
            timerElement.textContent = formatTime(timeLeft);
            timeLeft--;
            setTimeout(updateCountdown, 1000);
        }

        // Bắt đầu countdown ngay khi trang load
        updateCountdown();

        // Animation nhẹ cho progress bar (đã active sẵn bước 2)
        const progressLine = document.getElementById('progressLine');
        if (progressLine) {
            progressLine.style.width = '100%';
        }
    </script>
</body>
</html>