<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!session_id()) {
    session_start();
}

// BE error session
$error = $_SESSION['sa_error'] ?? null;
unset($_SESSION['sa_error']);

$currentStep = 1;
if (strpos($_SERVER['REQUEST_URI'], 'sa-otp') !== false) {
    $currentStep = 2;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nông Sản Sạch | Đăng Ký</title>

    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../assets/css/style-register.css'; ?>">
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

        <div class="farm-register">
            <div class="register-card">

                <div class="register-header">
                    <div class="header-badge">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2>Đăng ký</h2>
                    <p>Tạo tài khoản để mua sắm dễ dàng</p>
                </div>

                <!-- ERROR FROM BE -->
                <?php if (!empty($error)): ?>
                    <div class="message-area">
                        <div class="message error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- PROGRESS BAR -->
                <div class="progress-container">
                    <div class="progress-steps">
                        <div class="progress-line" id="progressLine"></div>

                        <div class="step" id="step1">
                            <div class="step-circle">1</div>
                            <div class="step-label">Thông tin</div>
                        </div>

                        <div class="step" id="step2">
                            <div class="step-circle">2</div>
                            <div class="step-label">Xác thực OTP</div>
                        </div>
                    </div>
                </div>

                <!-- STEP 1 -->
                <div id="step1Content" class="step-content <?php echo $currentStep != 1 ? 'hidden' : ''; ?>">

                    <form method="POST" action="<?php echo home_url('/sa-register'); ?>">

                        <div class="input-group">
                            <label><i class="fas fa-user"></i> Họ và tên</label>
                            <input type="text" name="username" required>
                        </div>

                        <div class="input-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" required>
                        </div>

                        <div class="input-group">
                            <label><i class="fas fa-lock"></i> Mật khẩu</label>

                            <div class="password-field">
                                <input type="password" name="password" id="password" required>
                                <span class="toggle-eye" onclick="togglePassword()">
                                    <i class="far fa-eye-slash"></i>
                                </span>
                            </div>

                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                            </div>
                        </div>

                        <!-- IMPORTANT: KHỚP BE -->
                        <input type="hidden" name="sa_register_submit" value="1">

                        <button type="submit" class="btn-register">
                            <i class="fas fa-paper-plane"></i> Tiếp theo - Gửi OTP
                        </button>

                    </form>

                </div>

                <!-- STEP 2 -->
                <div id="step2Content" class="step-content <?php echo $currentStep != 2 ? 'hidden' : ''; ?>">

                    <form method="POST" action="<?php echo home_url('/sa-otp'); ?>">

                        <div class="input-group">
                            <label><i class="fas fa-key"></i> Mã OTP (6 số)</label>

                            <input type="text" name="otp" maxlength="6"
                                   placeholder="Nhập OTP"
                                   required
                                   autocomplete="off"
                                   style="text-align:center;font-size:1.2rem;letter-spacing:5px;">
                        </div>

                        <button type="submit" class="btn-register">
                            <i class="fas fa-check-circle"></i> Xác thực OTP
                        </button>

                        <button type="button" id="backToStep1Btn" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </button>

                    </form>

                </div>

                <!-- LOGIN -->
                <div class="login-prompt">
                    <p>Đã có tài khoản?
                        <a href="<?php echo home_url('/sa-login/'); ?>" id="flipToLoginBtn">
                            Đăng nhập ngay
                        </a>
                    </p>
                </div>

            </div>
        </div>

    </div>

    <footer class="farm-footer">
        <p><i class="fas fa-tree"></i> Nông sản Việt - Tinh hoa từ đất mẹ <i class="fas fa-hand-holding-heart"></i></p>
    </footer>
</div>

<script>
    const step1El = document.getElementById('step1');
    const step2El = document.getElementById('step2');
    const progressLine = document.getElementById('progressLine');

    let currentStep = <?php echo (int)$currentStep; ?>;

    function updateProgress(step) {
        const steps = [step1El, step2El];

        steps.forEach((s, idx) => {
            s.classList.remove('active', 'completed');

            if (idx + 1 < step) {
                s.classList.add('completed');
            } else if (idx + 1 === step) {
                s.classList.add('active');
            }
        });

        progressLine.style.width = (step === 2 ? '100%' : '0%');
    }

    function togglePassword() {
        const pwd = document.getElementById('password');
        const icon = document.querySelector('.toggle-eye i');

        if (!pwd) return;

        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        } else {
            pwd.type = 'password';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        }
    }

    function checkPasswordStrength() {
        const password = document.getElementById('password');
        const fill = document.getElementById('strengthFill');

        if (!password || !fill) return;

        let strength = 0;

        if (password.value.length >= 6) strength = 25;
        if (password.value.length >= 8) strength = 50;
        if (/[A-Z]/.test(password.value)) strength += 25;
        if (/[0-9]/.test(password.value)) strength += 25;

        if (strength > 100) strength = 100;

        fill.style.width = strength + '%';

        if (strength < 30) fill.style.background = '#e74c3c';
        else if (strength < 60) fill.style.background = '#f39c12';
        else fill.style.background = '#27ae60';
    }

    document.getElementById('password')?.addEventListener('input', checkPasswordStrength);

    document.getElementById('backToStep1Btn')?.addEventListener('click', () => {
        window.location.href = '<?php echo home_url('/sa-register'); ?>';
    });

    window.addEventListener('load', () => {
        document.getElementById('mainContent')?.classList.add('fade-in');
        updateProgress(currentStep);
    });
</script>

</body>
</html>