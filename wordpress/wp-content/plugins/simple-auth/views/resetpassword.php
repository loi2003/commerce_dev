<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nông Trại Xanh | Đặt Lại Mật Khẩu</title>
    <!-- Font Awesome 6 (free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts: Inter + Playfair Display -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            /* Background nông trại - ruộng bậc thang xanh mướt */
            background: linear-gradient(135deg, rgba(30, 65, 25, 0.82), rgba(20, 50, 15, 0.88)), 
                        url('https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=2070&auto=format');
            background-size: cover;
            background-position: center 30%;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* KHÔNG CÓ pattern ngôi sao hay họa tiết nào */
        .farm-wrapper {
            max-width: 1280px;
            width: 100%;
            margin: 0 auto;
        }

        .farm-container {
            display: flex;
            flex-wrap: wrap;
            background: rgba(255, 254, 247, 0.96);
            backdrop-filter: blur(2px);
            border-radius: 48px;
            overflow: hidden;
            box-shadow: 0 30px 50px -25px rgba(0, 0, 0, 0.4);
        }

        /* ===== PHẦN BÊN TRÁI - HERO NÔNG TRẠI (GIỐNG HỆT FORGOT) ===== */
        .farm-hero {
            flex: 1.2;
            background: linear-gradient(125deg, rgba(43, 110, 47, 0.92), rgba(26, 79, 29, 0.88)), 
                        url('https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=2070&auto=format');
            background-size: cover;
            background-position: center;
            position: relative;
            padding: 3rem 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(30, 55, 25, 0.25);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #ffffff;
        }

        .logo-icon {
            width: 85px;
            height: 85px;
            background: rgba(255, 220, 150, 0.25);
            backdrop-filter: blur(3px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 2.8rem;
            color: #ffdd99;
            border: 2px solid rgba(255, 220, 150, 0.5);
        }

        .hero-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.3rem;
            font-weight: 600;
            line-height: 1.2;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 0.75rem;
        }

        .hero-line {
            width: 70px;
            height: 3px;
            background: #e2b870;
            margin: 1rem auto;
            border-radius: 4px;
        }

        .hero-content p {
            font-size: 1rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .hero-features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
        }

        .hero-features span {
            background: rgba(255, 245, 210, 0.2);
            backdrop-filter: blur(2px);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .hero-features span i {
            font-size: 0.85rem;
            color: #ffdd99;
        }

        /* ===== PHẦN BÊN PHẢI - FORM RESET ===== */
        .farm-login {
            flex: 1;
            background: #ffffff;
            padding: 2.5rem;
            display: flex;
            align-items: center;
        }

        .login-card {
            width: 100%;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .login-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 35px -15px rgba(0, 0, 0, 0.15);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header-badge {
            width: 65px;
            height: 65px;
            background: #f0f7ec;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            color: #3b8230;
        }

        .login-header h2 {
            font-size: 1.8rem;
            color: #2c5e2a;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #8b7a5a;
            font-size: 0.9rem;
        }

        /* Input groups */
        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #5a6e45;
            margin-bottom: 0.5rem;
        }

        .input-group label i {
            width: 24px;
            color: #c4872e;
        }

        .input-group input {
            width: 100%;
            padding: 14px 18px;
            border: 1.5px solid #e2e8d5;
            border-radius: 40px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: #fefdf8;
            outline: none;
        }

        .input-group input:focus {
            border-color: #7aa55a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Password field + toggle */
        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 50px;
        }

        .toggle-eye {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #b6a77a;
            font-size: 1.1rem;
        }

        .toggle-eye:hover {
            color: #c4872e;
        }

        /* Button chính - giữ hiệu ứng shimmer y chang login/forgot */
        .btn-login {
            position: relative;
            overflow: hidden;
            width: 100%;
            background: linear-gradient(95deg, #46833b, #2c6b28);
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
            box-shadow: 0 6px 14px rgba(60, 100, 35, 0.25);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: linear-gradient(115deg, rgba(255, 255, 255, 0) 10%, rgba(255, 255, 255, 0.25) 50%, rgba(255, 255, 255, 0) 90%);
            transform: rotate(25deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) rotate(25deg);
            }
            100% {
                transform: translateX(100%) rotate(25deg);
            }
        }

        .btn-login:hover {
            background: linear-gradient(95deg, #569c49, #378033);
            transform: translateY(-2px);
        }

        /* message */
        .message {
            margin-top: 1.2rem;
            padding: 12px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            text-align: center;
        }

        .message.error {
            background: #fff3eb;
            color: #c06328;
            border-left: 4px solid #e67e22;
        }

        .message.success {
            background: #e2f3db;
            color: #2c7628;
            border-left: 4px solid #4cae3c;
        }

        /* Back to login link (thay thế register-prompt nhưng giữ phong cách) */
        .back-link {
            text-align: center;
            margin-top: 1.8rem;
            padding-top: 1.2rem;
            border-top: 1px solid #ebe5d5;
        }

        .back-link a {
            color: #bc782a;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: #9b5e1f;
            text-decoration: underline;
        }

        .demo-info {
            background: #faf6ea;
            display: inline-block;
            padding: 6px 18px;
            border-radius: 40px;
            font-size: 0.75rem;
            color: #ab7f48;
            margin-top: 12px;
        }

        .farm-footer {
            text-align: center;
            margin-top: 2rem;
            padding: 12px 24px;
            background: rgba(255, 252, 235, 0.9);
            backdrop-filter: blur(4px);
            border-radius: 60px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            font-size: 0.75rem;
            color: #5b7946;
        }

        .farm-footer i {
            margin: 0 6px;
            color: #c4872e;
        }

        /* responsive */
        @media (max-width: 850px) {
            .farm-container {
                flex-direction: column;
            }
            .farm-hero {
                padding: 2rem 1.5rem;
            }
            .farm-login {
                padding: 2rem 1.5rem;
            }
        }

        /* animations */
        .fade-out {
            animation: fadeOut 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-8px); }
        }
        .fade-in {
            animation: fadeIn 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1) forwards;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(12px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .page-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #2b6e2f;
            z-index: 10000;
            transform: scaleY(0);
            transform-origin: center;
            pointer-events: none;
        }
        .page-transition.active {
            animation: pageReveal 0.45s cubic-bezier(0.65, 0, 0.35, 1) forwards;
        }
        @keyframes pageReveal {
            0% { transform: scaleY(0); opacity: 0; }
            30% { transform: scaleY(1); opacity: 1; }
            70% { transform: scaleY(1); opacity: 1; }
            100% { transform: scaleY(0); opacity: 0; }
        }
        .no-click { pointer-events: none; }
    </style>
</head>
<body>
<div class="farm-wrapper" id="mainContent">
    <div class="farm-container">
        <!-- BÊN TRÁI: giống hệt forgot & login design -->
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

        <!-- BÊN PHẢI: FORM ĐẶT LẠI MẬT KHẨU (OTP + Mật khẩu mới + xác nhận) -->
        <div class="farm-login">
            <div class="login-card">
                <div class="login-header">
                    <div class="header-badge">
                        <i class="fas fa-key"></i>
                    </div>
                    <h2>Đặt lại mật khẩu</h2>
                    <p>Nhập mã OTP và mật khẩu mới</p>
                </div>

                <!-- FORM RESET - GIỮ NGUYÊN LOGIC CODE (action post, các input name="otp", "password", "password_confirmation", button name="sa_reset_submit") -->
                <form method="post" action="" class="login-form" id="resetPasswordForm">
                    <div class="input-group">
                        <label><i class="fas fa-shield-alt"></i> Mã OTP</label>
                        <input type="text" name="otp" placeholder="Nhập mã OTP" required autocomplete="off">
                    </div>

                    <div class="input-group">
                        <label><i class="fas fa-lock"></i> Mật khẩu mới</label>
                        <div class="password-field">
                            <input type="password" name="password" id="new_password" placeholder="••••••••" required>
                            <span class="toggle-eye" onclick="toggleNewPassword()">
                                <i class="far fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="input-group">
                        <label><i class="fas fa-check-circle"></i> Xác nhận mật khẩu</label>
                        <div class="password-field">
                            <input type="password" name="password_confirmation" id="confirm_password" placeholder="Xác nhận mật khẩu" required>
                            <span class="toggle-eye" onclick="toggleConfirmPassword()">
                                <i class="far fa-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="sa_reset_submit" class="btn-login">
                            <i class="fas fa-undo-alt"></i> Đổi mật khẩu
                        </button>
                    </div>

                    <!-- Hiển thị thông báo lỗi/thành công từ logic backend (giữ nguyên cấu trúc) -->
                    <?php
                    // Khu vực xử lý reset password - giữ nguyên logic code từ yêu cầu.
                    // Đoạn này sẽ hiển thị message nếu có biến $reset_error hoặc $reset_success từ backend.
                    // Gợi ý: Bạn đã có hàm sa_handle_reset_password() hay xử lý trong file gốc.
                    // Ở đây chúng tôi giữ phần render thông báo động dựa trên các biến có sẵn.
                    if (isset($reset_error) && !empty($reset_error)): ?>
                        <div class="message error">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($reset_error); ?>
                        </div>
                    <?php elseif (isset($reset_success) && $reset_success): ?>
                        <div class="message success">
                            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($reset_success); ?>
                        </div>
                    <?php endif; ?>
                </form>

                <!-- Link quay lại trang đăng nhập (tiện ích) - giống phong cách forgot -->
                <div class="back-link">
                    <a href="#" id="backToLoginBtn">
                        <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
                    </a>
                    <div class="demo-info">
                        <i class="fas fa-info-circle"></i> Nhập OTP hợp lệ để đặt lại mật khẩu
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
    // Toggle cho mật khẩu mới
    function toggleNewPassword() {
        var pwd = document.getElementById("new_password");
        var eye = document.querySelector("#new_password")?.parentElement?.querySelector(".toggle-eye i");
        if (!eye) return;
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

    // Toggle cho xác nhận mật khẩu
    function toggleConfirmPassword() {
        var pwd = document.getElementById("confirm_password");
        var eye = document.getElementById("confirm_password")?.parentElement?.querySelector(".toggle-eye i");
        if (!eye) return;
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

    // Hàm transition mượt (giữ nguyên hiệu ứng từ login/forgot)
    let isTransitioning = false;
    function transitionTo(targetUrl) {
        if (isTransitioning) return;
        isTransitioning = true;
        const mainEl = document.getElementById('mainContent');
        if (mainEl) mainEl.classList.add('fade-out');
        const transitionLayer = document.createElement('div');
        transitionLayer.className = 'page-transition';
        document.body.appendChild(transitionLayer);
        setTimeout(() => transitionLayer.classList.add('active'), 10);
        setTimeout(() => { window.location.href = targetUrl; }, 400);
    }

    // Nút quay lại trang đăng nhập (thay vì /sa-login/ có thể tuỳ chỉnh theo cấu hình site của bạn)
    document.getElementById('backToLoginBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        transitionTo('/sa-login/');   // Đường dẫn trang đăng nhập (có thể sửa theo dự án)
    });

    // Hiệu ứng fade-in khi tải trang
    window.addEventListener('load', function() {
        const mainContent = document.getElementById('mainContent');
        mainContent.classList.add('fade-in');
        setTimeout(() => mainContent.classList.remove('fade-in'), 500);
    });

    // Prefetch trang đăng nhập (tối ưu trải nghiệm)
    const loginPrefetch = document.createElement('link');
    loginPrefetch.rel = 'prefetch';
    loginPrefetch.href = '/sa-login/';
    document.head.appendChild(loginPrefetch);

    // Nếu bạn muốn kiểm tra trùng khớp mật khẩu phía client (không ảnh hưởng logic backend, chỉ cải thiện UX)
    const resetForm = document.getElementById('resetPasswordForm');
    if (resetForm) {
        resetForm.addEventListener('submit', function(event) {
            const newPwd = document.getElementById('new_password');
            const confirmPwd = document.getElementById('confirm_password');
            if (newPwd && confirmPwd && newPwd.value !== confirmPwd.value) {
                // Hiển thị thông báo lỗi nhưng KHÔNG xóa logic gốc, chỉ cảnh báo và ngăn gửi nếu chưa khớp.
                // Để giữ nguyên xử lý backend vẫn là chính, nhưng tránh gửi sai sót.
                let existingMsg = resetForm.querySelector('.client-error');
                if (existingMsg) existingMsg.remove();
                const errDiv = document.createElement('div');
                errDiv.className = 'message error client-error';
                errDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Mật khẩu xác nhận không khớp. Vui lòng kiểm tra lại.';
                resetForm.appendChild(errDiv);
                event.preventDefault();
                setTimeout(() => { if(errDiv) errDiv.remove(); }, 3000);
                return false;
            }
            return true;
        });
    }

    // Xoá thông báo lỗi client cũ khi người dùng sửa các trường (tuỳ chọn)
    const newPwdField = document.getElementById('new_password');
    const confirmPwdField = document.getElementById('confirm_password');
    function removeClientError() {
        const errDiv = resetForm?.querySelector('.client-error');
        if (errDiv) errDiv.remove();
    }
    if (newPwdField) newPwdField.addEventListener('input', removeClientError);
    if (confirmPwdField) confirmPwdField.addEventListener('input', removeClientError);
</script>


</body>
</html>