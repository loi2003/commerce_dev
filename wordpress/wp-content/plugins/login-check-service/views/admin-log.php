<?php
/**
 * Template cho trang admin log detail
 * Phong cách Nông Trại Xanh
 * 
 * @package Simple_Auth
 */

// Ngăn chặn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Lấy thông tin user từ email
$user = get_user_by('email', $email);
$display_name = $user ? $user->display_name : $email;
$has_logs = !empty($logs);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nông Trại Xanh | Log User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f0eb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .farm-wrapper {
            width: 100%;
            max-width: 1400px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: opacity 0.4s ease, transform 0.4s ease;
            opacity: 0;
            transform: translateY(20px);
        }

        .farm-wrapper.fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        .farm-wrapper.fade-out {
            opacity: 0;
            transform: translateY(-20px);
        }

        .page-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .page-transition.active {
            opacity: 1;
            pointer-events: all;
        }

        .log-container {
            padding: 40px;
        }

        /* Header */
        .log-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0ebe6;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2d8a4e, #1a6b3a);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 8px 20px rgba(45, 138, 78, 0.25);
        }

        .header-title h1 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: #1a2e1a;
            margin-bottom: 5px;
        }

        .header-title .user-email {
            color: #6b7a6b;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .header-title .user-email i {
            color: #2d8a4e;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* ===== BUTTON STYLES MỚI ===== */
        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .btn i {
            font-size: 15px;
            transition: transform 0.3s ease;
        }

        .btn:hover i {
            transform: scale(1.1);
        }

        .btn:active {
            transform: scale(0.95);
        }

        /* Button Back */
        .btn-back {
            background: #f0ebe6;
            color: #4a5a4a;
            border: 1px solid #e0d9d3;
        }

        .btn-back:hover {
            background: #e5dfd9;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
            border-color: #d0c9c3;
        }

        /* Button Export */
        .btn-export {
            background: linear-gradient(135deg, #4a6fa5, #3d5a8c);
            color: white;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 111, 165, 0.35);
            background: linear-gradient(135deg, #3d5a8c, #2d4a7a);
        }

        /* Button Clear */
        .btn-clear-logs {
            background: linear-gradient(135deg, #dc3545, #b02a37);
            color: white;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-clear-logs:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.35);
            background: linear-gradient(135deg, #b02a37, #8f212c);
        }

        /* Button Primary (nếu dùng) */
        .btn-primary {
            background: linear-gradient(135deg, #2d8a4e, #1a6b3a);
            color: white;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 138, 78, 0.35);
            background: linear-gradient(135deg, #1a6b3a, #0e4f2a);
        }

        /* Stats */
        .log-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8f6f3;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #f0ebe6;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }

        .stat-label {
            font-size: 13px;
            color: #8a9a8a;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1a2e1a;
        }

        /* Filters */
        .log-filters {
            background: #f8f6f3;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
            border: 1px solid #f0ebe6;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            font-weight: 500;
            color: #4a5a4a;
            font-size: 14px;
            white-space: nowrap;
        }

        .filter-group select,
        .filter-group input {
            padding: 10px 14px;
            border: 1px solid #e0d9d3;
            border-radius: 10px;
            background: white;
            font-size: 14px;
            width: 100%;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #2d8a4e;
            box-shadow: 0 0 0 3px rgba(45, 138, 78, 0.1);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
        }

        .btn-clear {
            background: white;
            color: #6b7a6b;
            border: 1px solid #e0d9d3;
        }

        .btn-clear:hover {
            background: #f0ebe6;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        }

        /* Table */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid #f0ebe6;
            background: white;
        }

        .log-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .log-table thead {
            background: #f8f6f3;
        }

        .log-table th {
            padding: 16px 16px;
            text-align: left;
            font-weight: 600;
            color: #4a5a4a;
            border-bottom: 2px solid #f0ebe6;
            white-space: nowrap;
        }

        .log-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f5f0eb;
            color: #2a3a2a;
            vertical-align: middle;
        }

        .log-table tbody tr:hover {
            background: #faf8f6;
        }

        .log-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background: #cce5ff;
            color: #004085;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-secondary {
            background: #e9ecef;
            color: #383d41;
        }

        /* No logs */
        .no-logs {
            text-align: center;
            padding: 60px 20px;
        }

        .no-logs i {
            font-size: 48px;
            color: #d0c9c3;
            margin-bottom: 15px;
        }

        .no-logs h3 {
            color: #4a5a4a;
            font-size: 20px;
            margin-bottom: 8px;
        }

        .no-logs p {
            color: #8a9a8a;
        }

        /* Notice */
        .notice {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid;
        }

        .notice-info {
            background: #e7f3ff;
            border-color: #b8d4f0;
            color: #004085;
        }

        .notice-info i {
            color: #007bff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .log-container {
                padding: 20px;
            }

            .log-header {
                flex-direction: column;
                align-items: stretch;
            }

            .header-left {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .header-actions .btn {
                justify-content: center;
                width: 100%;
            }

            .log-filters {
                flex-direction: column;
            }

            .filter-group {
                min-width: 100%;
            }

            .filter-actions {
                width: 100%;
            }

            .filter-actions .btn {
                flex: 1;
                justify-content: center;
            }

            .log-table {
                font-size: 12px;
            }

            .log-table th,
            .log-table td {
                padding: 10px 8px;
            }

            .badge {
                font-size: 10px;
                padding: 3px 10px;
            }
        }

        /* Animation for rows */
        .log-row {
            animation: slideIn 0.3s ease forwards;
            opacity: 0;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .log-row:nth-child(1) { animation-delay: 0.05s; }
        .log-row:nth-child(2) { animation-delay: 0.10s; }
        .log-row:nth-child(3) { animation-delay: 0.15s; }
        .log-row:nth-child(4) { animation-delay: 0.20s; }
        .log-row:nth-child(5) { animation-delay: 0.25s; }
        .log-row:nth-child(6) { animation-delay: 0.30s; }
        .log-row:nth-child(7) { animation-delay: 0.35s; }
        .log-row:nth-child(8) { animation-delay: 0.40s; }
        .log-row:nth-child(9) { animation-delay: 0.45s; }
        .log-row:nth-child(10) { animation-delay: 0.50s; }

        /* Scrollbar */
        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f0ebe6;
            border-radius: 10px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #c5bdb6;
            border-radius: 10px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #b0a89f;
        }

        /* Tooltip */
        .user-agent-tooltip {
            cursor: help;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }
        
        /* Hidden helper */
        .hidden {
            display: none !important;
        }

        /* Notification toast */
        .toast-message {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #1a2e1a;
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 14px;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toast-message.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast-message i {
            font-size: 20px;
        }

        .toast-message.success i { color: #4caf50; }
        .toast-message.error i { color: #f44336; }
    </style>
</head>
<body>
    <div class="page-transition" id="pageTransition"></div>
    
    <div class="farm-wrapper" id="mainContent">
        <div class="log-container">
            <!-- Header -->
            <div class="log-header">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="header-title">
                        <h1>Nhật ký hoạt động</h1>
                        <div class="user-email">
                            <i class="fas fa-user"></i>
                            <span><?php echo esc_html($display_name); ?></span>
                            <span style="color: #d0c9c3;">|</span>
                            <span><?php echo esc_html($email); ?></span>
                        </div>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="<?php echo admin_url('admin.php?page=simple-auth'); ?>" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <?php if ($has_logs) : ?>
                     
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats -->
            <?php if ($has_logs) : 
                $total = count($logs);
                $success = count(array_filter($logs, function($log) { return $log['action'] === 'login_success'; }));
                $failed = count(array_filter($logs, function($log) { return $log['action'] === 'login_failed'; }));
                $latest = !empty($logs) ? date('H:i d/m/Y', strtotime($logs[0]['login_time'])) : '--';
            ?>
            <div class="log-stats">
                <div class="stat-card">
                    <div class="stat-label">
                        <i class="fas fa-list"></i> Tổng số logs
                    </div>
                    <div class="stat-value"><?php echo $total; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">
                        <i class="fas fa-check-circle"></i> Thành công
                    </div>
                    <div class="stat-value" style="color: #28a745;">
                        <?php echo $success; ?>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">
                        <i class="fas fa-times-circle"></i> Thất bại
                    </div>
                    <div class="stat-value" style="color: #dc3545;">
                        <?php echo $failed; ?>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">
                        <i class="fas fa-clock"></i> Gần đây nhất
                    </div>
                    <div class="stat-value" style="font-size: 16px;">
                        <?php echo $latest; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Filters -->
            <?php if ($has_logs) : ?>
            <div class="log-filters" id="filterContainer">
                <div class="filter-group">
                    <label><i class="fas fa-filter"></i> Lọc action:</label>
                    <select id="actionFilter">
                        <option value="">Tất cả</option>
                        <option value="login_success">✅ Đăng nhập thành công</option>
                        <option value="login_failed">❌ Đăng nhập thất bại</option>
                        <option value="logout">🚪 Đăng xuất</option>
                        <option value="register">📝 Đăng ký</option>
                        <option value="password_reset">🔑 Đặt lại mật khẩu</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-search"></i> Tìm kiếm:</label>
                    <input type="text" id="searchInput" placeholder="Tìm theo IP, User Agent...">
                </div>
                <div class="filter-actions">
                    <button class="btn btn-clear" onclick="clearFilters()">
                        <i class="fas fa-undo"></i> Xóa lọc
                    </button>
                </div>
            </div>
            <?php endif; ?>

            <!-- Table -->
            <?php if (!$has_logs) : ?>
                <div class="notice notice-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Không có log nào cho email này.</span>
                </div>
            <?php else : ?>
                <div class="table-wrapper">
                    <table class="log-table" id="logTable">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 180px;">Thời gian</th>
                                <th style="width: 130px;">Action</th>
                                <th style="width: 140px;">IP</th>
                                <th>User Agent</th>
                            </tr>
                        </thead>
                        <tbody id="logBody">
                            <?php foreach ($logs as $index => $log) : ?>
                                <tr class="log-row" data-action="<?php echo esc_attr($log['action']); ?>">
                                    <td><?php echo esc_html($log['id']); ?></td>
                                    <td>
                                        <i class="far fa-calendar-alt" style="color: #8a9a8a; margin-right: 6px;"></i>
                                        <?php echo esc_html($log['login_time']); ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $badge_class = 'badge-secondary';
                                        $icon = 'fa-circle';
                                        switch($log['action']) {
                                            case 'login_success':
                                                $badge_class = 'badge-success';
                                                $icon = 'fa-check-circle';
                                                break;
                                            case 'login_failed':
                                                $badge_class = 'badge-danger';
                                                $icon = 'fa-times-circle';
                                                break;
                                            case 'logout':
                                                $badge_class = 'badge-info';
                                                $icon = 'fa-sign-out-alt';
                                                break;
                                            case 'register':
                                                $badge_class = 'badge-warning';
                                                $icon = 'fa-user-plus';
                                                break;
                                            case 'password_reset':
                                                $badge_class = 'badge-warning';
                                                $icon = 'fa-key';
                                                break;
                                        }
                                        $action_labels = array(
                                            'login_success' => 'Login success',
                                            'login_failed' => 'Login failed',
                                            'logout' => 'Logout',
                                            'register' => 'register',
                                            'password_reset' => 'reset password',
                                        );
                                        ?>
                                        <span class="badge <?php echo $badge_class; ?>">
                                            <i class="fas <?php echo $icon; ?>"></i>
                                            <?php echo isset($action_labels[$log['action']]) ? $action_labels[$log['action']] : esc_html($log['action']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <code style="background: #f8f6f3; padding: 4px 10px; border-radius: 6px; font-size: 12px;">
                                            <?php echo esc_html($log['ip_address']); ?>
                                        </code>
                                    </td>
                                    <td>
                                        <span class="user-agent-tooltip" title="<?php echo esc_attr($log['user_agent']); ?>">
                                            <?php echo esc_html($log['user_agent']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div style="margin-top: 15px; text-align: right; color: #8a9a8a; font-size: 13px;">
                    <span id="logCount">Hiển thị <strong><?php echo count($logs); ?></strong> logs</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-message" id="toastMessage">
        <i class="fas fa-check-circle"></i>
        <span id="toastText">Đã xuất logs thành công!</span>
    </div>

    <script>
    (function() {
        'use strict';

        // ===== DOM READY =====
        function init() {
            // Fade in animation
            const mainContent = document.getElementById('mainContent');
            if (mainContent) {
                setTimeout(function() {
                    mainContent.classList.add('fade-in');
                }, 100);
            }

            // Hide transition layer
            const transition = document.getElementById('pageTransition');
            if (transition) {
                setTimeout(function() {
                    transition.classList.remove('active');
                }, 500);
            }

            // ===== FILTER LOGS =====
            const actionFilter = document.getElementById('actionFilter');
            const searchInput = document.getElementById('searchInput');
            
            if (actionFilter) {
                actionFilter.addEventListener('change', filterLogs);
            }
            
            if (searchInput) {
                searchInput.addEventListener('keyup', filterLogs);
            }
        }

        function filterLogs() {
            const actionFilter = document.getElementById('actionFilter');
            const searchInput = document.getElementById('searchInput');
            
            if (!actionFilter || !searchInput) return;
            
            const action = actionFilter.value;
            const search = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('.log-row');
            let visibleCount = 0;

            rows.forEach(function(row) {
                const rowAction = row.dataset.action;
                const rowText = row.textContent.toLowerCase();
                let show = true;

                if (action && rowAction !== action) show = false;
                if (search && !rowText.includes(search)) show = false;

                if (show) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            const logCount = document.getElementById('logCount');
            if (logCount) {
                logCount.innerHTML = 
                    'Hiển thị <strong>' + visibleCount + '</strong> / <strong>' + rows.length + '</strong> logs';
            }
        }

        // ===== CLEAR FILTERS =====
        window.clearFilters = function() {
            const actionFilter = document.getElementById('actionFilter');
            const searchInput = document.getElementById('searchInput');
            
            if (actionFilter) actionFilter.value = '';
            if (searchInput) searchInput.value = '';
            filterLogs();
        };

        // ===== TOAST NOTIFICATION =====
        function showToast(message, type) {
            const toast = document.getElementById('toastMessage');
            const toastText = document.getElementById('toastText');
            
            if (!toast || !toastText) return;
            
            toast.className = 'toast-message';
            toast.className += ' ' + type;
            
            const icon = toast.querySelector('i');
            if (icon) {
                icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            }
            
            toastText.textContent = message;
            
            // Show toast
            setTimeout(function() {
                toast.classList.add('show');
            }, 100);
            
            // Auto hide after 3s
            setTimeout(function() {
                toast.classList.remove('show');
            }, 3000);
        }

        // ===== EXPORT CSV =====
        window.exportLogs = function() {
            const rows = document.querySelectorAll('.log-row:visible');
            if (rows.length === 0) {
                showToast('Không có log nào để xuất!', 'error');
                return;
            }

            let csv = 'ID,Thời gian,Action,IP,User Agent\n';
            rows.forEach(function(row) {
                const cells = row.querySelectorAll('td');
                if (cells.length >= 5) {
                    const data = [
                        cells[0].textContent.trim(),
                        cells[1].textContent.trim(),
                        cells[2].textContent.trim(),
                        cells[3].textContent.trim(),
                        cells[4].textContent.trim()
                    ];
                    csv += data.join(',') + '\n';
                }
            });

            const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'logs_' + Date.now() + '.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            showToast('Đã xuất ' + rows.length + ' logs thành công!', 'success');
        };

        // ===== CLEAR LOGS =====
        window.clearLogs = function() {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả logs của user này?')) {
                const email = '<?php echo esc_js($email); ?>';
                const nonce = '<?php echo wp_create_nonce('clear_user_logs'); ?>';
                window.location.href = '<?php echo admin_url('admin.php?page=simple-auth&action=clear_user_logs&email='); ?>' + encodeURIComponent(email) + '&_wpnonce=' + nonce;
            }
        };

        // ===== TRANSITION =====
        window.transitionTo = function(url) {
            const transition = document.getElementById('pageTransition');
            if (transition) {
                transition.classList.add('active');
                setTimeout(function() {
                    window.location.href = url;
                }, 300);
            } else {
                window.location.href = url;
            }
        };

        // ===== RUN =====
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }

    })();
    </script>
</body>
</html>