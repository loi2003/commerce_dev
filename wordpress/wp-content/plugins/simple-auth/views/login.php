<?php
// Khởi tạo rate limiter TRƯỚC
$rate_limiter = new LoginRateLimiter();

// Lấy email từ POST
$email = '';
if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = sanitize_email($_POST['email']);
}

// ===== QUAN TRỌNG: Kiểm tra khóa TRƯỚC KHI XỬ LÝ LOGIN =====
$is_locked = false;
$lock_message = '';

// Nếu có submit và có email
if (isset($_POST['sa_login_submit']) && !empty($email)) {
    // Kiểm tra xem email có bị khóa không
    $block_check = $rate_limiter->is_blocked($email);
    
    if ($block_check !== false) {
        // Nếu bị khóa, set session và KHÔNG xử lý đăng nhập
        $_SESSION['sa_error'] = $block_check;
        $_SESSION['sa_locked'] = true;
        $_SESSION['sa_lock_email'] = $email;
        
        // Redirect để tránh resubmit và hiển thị thông báo
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// Kiểm tra session có bị khóa không (sau redirect)
if (isset($_SESSION['sa_locked']) && $_SESSION['sa_locked'] === true) {
    $is_locked = true;
    if (isset($_SESSION['sa_error'])) {
        $lock_message = $_SESSION['sa_error'];
    }
}

// CHỈ xử lý login nếu KHÔNG bị khóa
if (!$is_locked) {
    $login_error = sa_handle_login();
} else {
    $login_error = ''; // Không xử lý login
}

// Lấy URL gốc của site
$site_url = home_url('/');
$register_url = home_url('/sa-register/');
$forgot_url = home_url('/sa-forgot/');

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nông Trại Xanh | Đăng Nhập</title>
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../assets/css/style-login.css'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .btn-register {
            width: 100%;
            background: linear-gradient(95deg, #f0a34b, #e8891a);
            border: none;
            padding: 14px 20px;
            border-radius: 50px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.25s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 6px 14px rgba(232, 137, 26, 0.25);
        }
        
        .btn-register:hover {
            background: linear-gradient(95deg, #f5b15a, #f09a2e);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(232, 137, 26, 0.35);
        }
        
        .btn-register:active {
            transform: translateY(0px);
        }

        /* Style cho thông báo khóa tài khoản */
        .message.locked {
            background: #fff3f3;
            border-left: 4px solid #dc3545;
            padding: 15px 20px;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
            animation: shakeLock 0.5s ease;
        }

        @keyframes shakeLock {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .message.locked i {
            color: #dc3545;
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .message.locked .message-content {
            flex: 1;
            color: #721c24;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .message.locked .message-content strong {
            display: block;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .message.locked .timer {
            color: #dc3545;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .message.error {
            margin-bottom: 15px;
            padding: 12px;
            background: #fff3f3;
            border-left: 4px solid #dc3545;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #721c24;
        }
        
        /* Disable inputs khi bị khóa */
        .login-form.locked input,
        .login-form.locked .btn-login,
        .login-form.locked .btn-register {
            opacity: 0.6;
            pointer-events: none;
            cursor: not-allowed;
        }

        .login-form.locked input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .login-form.locked .checkbox input {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="farm-wrapper" id="mainContent">
        <div class="farm-container">
            <div class="farm-hero">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <div class="logo-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <h1>Nông Sản<br>Sạch</h1>
                    <div class="hero-line"></div>
                    <p>Nông sản tươi ngon -<br>Giao hàng tận nhà</p>
                    <div class="hero-features">
                        <span><i class="fas fa-leaf"></i> Hữu cơ</span>
                        <span><i class="fas fa-tractor"></i> Canh tác bền vững</span>
                        <span><i class="fas fa-apple-alt"></i> Nông sản sạch</span>
                    </div>
                </div>
            </div>
            
            <div class="farm-login">
                <div class="login-card">
                    <div class="login-header">
                        <div class="header-badge">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <h2>Đăng nhập</h2>
                        <p>Vui lòng đăng nhập để mua sắm</p>
                    </div>
                    
                    <form method="POST" action="" class="login-form <?php echo $is_locked ? 'locked' : ''; ?>" id="loginForm">
                        <!-- ===== HIỂN THỊ THÔNG BÁO TỪ SESSION ===== -->
                        <?php if (isset($_SESSION['sa_error'])) : 
                            $error_msg = $_SESSION['sa_error'];
                            
                            // Kiểm tra nếu là thông báo khóa
                            if ($is_locked || strpos($error_msg, 'bị khóa tạm thời') !== false) :
                        ?>
                            <div class="message locked">
                                <i class="fas fa-lock"></i>
                                <div class="message-content">
                                    <strong>🔒 Tài khoản bị khóa tạm thời</strong>
                                    <span><?php echo esc_html($error_msg); ?></span>
                                    <div style="margin-top: 8px;">
                                        <i class="fas fa-clock"></i> Vui lòng đợi hoặc 
                                        <a href="<?php echo $forgot_url; ?>" style="color: #dc3545; font-weight: 600; text-decoration: underline;">đặt lại mật khẩu</a>
                                    </div>
                                    <?php 
                                    // Trích xuất số giây từ thông báo
                                    if (preg_match('/(\d+)\s*giây/', $error_msg, $matches)) {
                                        $seconds = intval($matches[1]);
                                        echo '<div style="margin-top: 10px; font-size: 0.9rem;">';
                                        echo '<i class="fas fa-hourglass-half"></i> Thời gian còn lại: <span id="countdownTimer" style="font-weight: 700; color: #dc3545;">' . $seconds . '</span> giây';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <!-- Thông báo lỗi thông thường -->
                            <div class="message error">
                                <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>
                                <span><?php echo esc_html($_SESSION['sa_error']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php 
                        // Xóa session sau khi hiển thị
                        unset($_SESSION['sa_error']);
                        unset($_SESSION['sa_locked']);
                        unset($_SESSION['sa_lock_email']);
                        ?>
                        <?php endif; ?>
                        <!-- =========================================== -->
                        
                        <div class="input-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" id="emailInput" placeholder="nongdan@nongsan.vn" required 
                                   value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : (isset($_SESSION['sa_lock_email']) ? esc_attr($_SESSION['sa_lock_email']) : ''); ?>"
                                   <?php echo $is_locked ? 'readonly' : ''; ?>>
                        </div>
                        
                        <div class="input-group">
                            <label><i class="fas fa-lock"></i> Mật khẩu</label>
                            <div class="password-field">
                                <input type="password" name="password" id="password" placeholder="••••••••" required
                                       <?php echo $is_locked ? 'readonly' : ''; ?>>
                                <span class="toggle-eye" onclick="togglePassword()">
                                    <i class="far fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-options">
                            <label class="checkbox">
                                <input type="checkbox" name="remember_me" <?php echo $is_locked ? 'disabled' : ''; ?>>
                                <span>Ghi nhớ đăng nhập</span>
                            </label>
                            <a href="#" class="forgot" id="forgotPasswordBtn">Quên mật khẩu?</a>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="sa_login_submit" class="btn-login" <?php echo $is_locked ? 'disabled' : ''; ?>>
                                <i class="fas fa-plug"></i> Đăng nhập
                            </button>
                            <button type="button" class="btn-register" id="flipToRegisterBtn" <?php echo $is_locked ? 'disabled' : ''; ?>>
                                <i class="fas fa-user-plus"></i> Đăng ký
                            </button>
                        </div>
                        
                        <?php if ($login_error && !isset($_SESSION['sa_error']) && !$is_locked): ?>
                        <div class="message error">
                            <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> <?php echo $login_error; ?>
                        </div>
                        <?php endif; ?>
                    </form>
                    
                    <div class="register-prompt">
                        <div class="demo-info">
                            <i class="fas fa-info-circle"></i> Demo: nongdan@nongsan.vn / 123456
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
        // Biến toàn cục từ PHP
        var registerUrl = '<?php echo $register_url; ?>';
        var forgotUrl = '<?php echo $forgot_url; ?>';
        var isLocked = <?php echo $is_locked ? 'true' : 'false'; ?>;

        // Countdown timer nếu bị khóa
        <?php if ($is_locked && isset($lock_message) && preg_match('/(\d+)\s*giây/', $lock_message, $matches)) : ?>
        (function() {
            let seconds = <?php echo intval($matches[1]); ?>;
            const timerElement = document.getElementById('countdownTimer');
            
            if (timerElement) {
                const countdown = setInterval(function() {
                    seconds--;
                    timerElement.textContent = seconds;
                    
                    if (seconds <= 0) {
                        clearInterval(countdown);
                        // Reload page để cập nhật trạng thái
                        location.reload();
                    }
                }, 1000);
            }
        })();
        <?php endif; ?>
        
        function togglePassword() {
            var pwd = document.getElementById("password");
            var eye = document.querySelector(".toggle-eye i");
            if (pwd.type === "password") {
                pwd.type = "text";
                eye.classList.remove("fa-eye-slash");
                eye.classList.add("fa-eye");
            } else {
                pwd.type = "password";
                eye.classList.remove("fa-eye");
                eye.classList.add("fa-eye-slash");
            }
        }
        
        let isTransitioning = false;
        
        function transitionTo(targetUrl) {
            if (isTransitioning) return;
            if (!targetUrl || targetUrl === '#') {
                console.error('Invalid URL:', targetUrl);
                return;
            }
            
            // Nếu đang bị khóa, không cho chuyển trang
            if (isLocked) {
                alert('Tài khoản đang bị khóa, vui lòng đợi hoặc đặt lại mật khẩu.');
                return;
            }
            
            isTransitioning = true;
            
            const mainContent = document.getElementById('mainContent');
            if (mainContent) {
                mainContent.classList.add('fade-out');
            }
            
            const transitionLayer = document.createElement('div');
            transitionLayer.className = 'page-transition';
            document.body.appendChild(transitionLayer);
            
            setTimeout(() => transitionLayer.classList.add('active'), 10);
            
            setTimeout(() => { 
                window.location.href = targetUrl; 
            }, 400);
        }
        
        // Xử lý nút đăng ký
        const registerBtn = document.getElementById('flipToRegisterBtn');
        if (registerBtn) {
            registerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (isLocked) {
                    alert('Tài khoản đang bị khóa. Vui lòng đợi hoặc đặt lại mật khẩu.');
                    return;
                }
                transitionTo(registerUrl);
            });
        }
        
        // Xử lý nút quên mật khẩu
        const forgotBtn = document.getElementById('forgotPasswordBtn');
        if (forgotBtn) {
            forgotBtn.addEventListener('click', function(e) {
                e.preventDefault();
                transitionTo(forgotUrl);
            });
        }
        
        window.addEventListener('load', function() {
            const mainContent = document.getElementById('mainContent');
            if (mainContent) {
                mainContent.classList.add('fade-in');
                setTimeout(() => mainContent.classList.remove('fade-in'), 500);
            }
            
            <?php if ($is_locked) : ?>
            console.log('Tài khoản bị khóa');
            const emailInput = document.getElementById('emailInput');
            if (emailInput) {
                emailInput.style.borderColor = '#dc3545';
                emailInput.style.backgroundColor = '#fff5f5';
            }
            <?php endif; ?>
        });
        
        // Prefetch
        if ('IntersectionObserver' in window) {
            const links = [registerUrl, forgotUrl];
            links.forEach(link => {
                if (link && link !== '#') {
                    const linkTag = document.createElement('link');
                    linkTag.rel = 'prefetch';
                    linkTag.href = link;
                    linkTag.as = 'document';
                    document.head.appendChild(linkTag);
                }
            });
        }
        
        // Xử lý form submit
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                if (this.classList.contains('locked')) {
                    e.preventDefault();
                    alert('Tài khoản đang bị khóa tạm thời. Vui lòng thử lại sau hoặc đặt lại mật khẩu.');
                    return false;
                }
                
                const email = this.querySelector('input[name="email"]').value;
                const password = this.querySelector('input[name="password"]').value;
                
                if (!email || !password) {
                    e.preventDefault();
                    alert('Vui lòng nhập đầy đủ email và mật khẩu');
                    return false;
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    alert('Vui lòng nhập email hợp lệ');
                    return false;
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('emailInput');
            if (emailInput && !emailInput.value && !isLocked) {
                emailInput.focus();
            }
        });
    </script>
</body>

</html>