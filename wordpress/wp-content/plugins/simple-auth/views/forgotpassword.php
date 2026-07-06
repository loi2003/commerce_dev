<?php
// Xử lý forgot password
$forgot_error = '';
$forgot_success = '';

if (isset($_POST['sa_forgot_submit'])) {
    if (function_exists('sa_handle_forgot_password')) {
        $result = sa_handle_forgot_password();
        if ($result === true) {
            $forgot_success = 'Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra và nhập mã.';
            // Chuyển hướng sau 2 giây
            echo '<meta http-equiv="refresh" content="2;url=/sa-otp/">';
        } else {
            $forgot_error = $result;
        }
    } else {
        $forgot_error = 'Hệ thống đang cập nhật, vui lòng thử lại sau.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nông Trại Xanh | Quên mật khẩu</title>
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../assets/css/style-login.css'; ?>">
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../assets/css/style-forgot.css'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="farm-wrapper" id="mainContent">
        <div class="farm-container">
            <div class="farm-hero">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <div class="logo-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h1>Quên<br>Mật Khẩu</h1>
                    <div class="hero-line"></div>
                    <p>Nhập email để<br>khôi phục mật khẩu</p>
                    <div class="hero-features">
                        <span><i class="fas fa-shield-alt"></i> Bảo mật</span>
                        <span><i class="fas fa-envelope"></i> Xác thực OTP</span>
                        <span><i class="fas fa-lock"></i> Đặt lại mật khẩu</span>
                    </div>
                </div>
            </div>
            
            <div class="farm-login">
                <div class="login-card">
                    <div class="login-header">
                        <div class="header-badge">
                            <i class="fas fa-unlock-alt"></i>
                        </div>
                        <h2>Khôi phục mật khẩu</h2>
                        <p>Chúng tôi sẽ gửi mã OTP đến email của bạn</p>
                    </div>
                    
                    <form method="POST" action="" class="login-form">
                        <div class="input-group">
                            <label><i class="fas fa-envelope"></i> Email đăng ký</label>
                            <input type="email" name="email" placeholder="nongdan@nongsan.vn" required autofocus>
                        </div>
                        
                        <div class="info-text">
                            <i class="fas fa-info-circle"></i> Nhập email đã đăng ký tài khoản
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn-back" id="backToLoginBtn">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </button>
                            <button type="submit" name="sa_forgot_submit" class="btn-login">
                                <i class="fas fa-paper-plane"></i> Gửi OTP
                            </button>
                        </div>
                        
                        <?php if ($forgot_error): ?>
                        <div class="message error">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($forgot_error); ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($forgot_success): ?>
                        <div class="success-message">
                            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($forgot_success); ?>
                        </div>
                        <?php endif; ?>
                    </form>
                    
                    <div class="register-prompt">
                        <div class="demo-info">
                            <i class="fas fa-info-circle"></i> Nhập email đã đăng ký để nhận OTP
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="farm-footer">
            <p><i class="fas fa-tree"></i> Nông sản Việt - Tinh hoa từ đất mẹ <i class="fas fa-hand-holding-heart"></i></p>
        </footer>
    </div>

    <script>
        let isTransitioning = false;
        function transitionTo(targetUrl) {
            if (isTransitioning) return;
            isTransitioning = true;
            document.getElementById('mainContent').classList.add('fade-out');
            const transitionLayer = document.createElement('div');
            transitionLayer.className = 'page-transition';
            document.body.appendChild(transitionLayer);
            setTimeout(() => transitionLayer.classList.add('active'), 10);
            setTimeout(() => { window.location.href = targetUrl; }, 400);
        }
        
        document.getElementById('backToLoginBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            transitionTo('/sa-login/');
        });
        
        window.addEventListener('load', function() {
            const mainContent = document.getElementById('mainContent');
            mainContent.classList.add('fade-in');
            setTimeout(() => mainContent.classList.remove('fade-in'), 500);
        });
        
        // Prefetch trang login
        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = '/sa-login/';
        document.head.appendChild(link);
    </script>
</body>
</html>