<?php
/**
 * Plugin Name: Nông Sản Layout Customizer
 * Plugin URI: https://nongsanvuive.com/
 * Description: Tùy chỉnh layout trang chủ - căn chỉnh ảnh và dàn đều bố cục
 * Version: 2.0.0
 * Author: Nông sản vui vẻ
 * Text Domain: nong-san-layout
 */

// Ngăn chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Lớp chính của Plugin Layout
 */
class Nong_San_Layout_Customizer {

    /**
     * Constructor: Khởi tạo các hook
     */
    public function __construct() {
        // Thêm CSS tùy chỉnh cho layout
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_layout_styles' ) );
        
        // Thêm CSS vào admin để tùy chỉnh giao diện backend
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        
        // Thêm các tùy chọn layout vào Customizer
        add_action( 'customize_register', array( $this, 'register_customizer_options' ) );
        
        // Thêm filter để tùy chỉnh HTML của trang chủ
        add_filter( 'storefront_homepage_hero_heading', array( $this, 'customize_hero_section' ) );
        
        // Thêm class vào body để tùy chỉnh layout
        add_filter( 'body_class', array( $this, 'add_layout_body_class' ) );
        
        // Thêm inline styles cho animation và màu trắng
        add_action( 'wp_head', array( $this, 'add_inline_styles' ), 999 );
    }

    /**
     * Enqueue CSS cho frontend
     */
    public function enqueue_layout_styles() {
        // Chỉ thêm CSS nếu file tồn tại
        $css_file = plugin_dir_path( __FILE__ ) . 'assets/layout-style.css';
        if ( file_exists( $css_file ) ) {
            wp_enqueue_style(
                'nong-san-layout-style',
                plugin_dir_url( __FILE__ ) . 'assets/layout-style.css',
                array(),
                '2.0.0'
            );
        }
    }

    /**
     * Enqueue CSS cho admin
     */
    public function enqueue_admin_styles() {
        wp_enqueue_style(
            'nong-san-layout-admin',
            plugin_dir_url( __FILE__ ) . 'assets/admin-style.css',
            array(),
            '2.0.0'
        );
    }

    /**
     * Thêm inline styles - CHỈ GIỮ ANIMATION VÀ MÀU CHỮ TRẮNG
     */
    public function add_inline_styles() {
        // Chỉ áp dụng cho trang chủ
        if ( ! is_front_page() && ! is_home() ) {
            return;
        }
        ?>
        <style>
        /* ============================================================
           ANIMATION - CHỈ GIỮ HIỆU ỨNG XUẤT HIỆN
           ============================================================ */

        /* 1. Keyframes cho animation */
        @keyframes nong-san-fade-up {
            0% {
                opacity: 0;
                transform: translateY(60px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes nong-san-slide-left {
            0% {
                opacity: 0;
                transform: translateX(-80px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes nong-san-slide-right {
            0% {
                opacity: 0;
                transform: translateX(80px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes nong-san-zoom-in {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* 2. Áp dụng animation cho các phần tử chính */
        .wp-block-cover {
            animation: nong-san-fade-up 0.8s ease forwards;
        }

        .wp-block-columns .wp-block-column:first-child {
            animation: nong-san-slide-left 0.8s ease forwards;
        }

        .wp-block-columns .wp-block-column:last-child {
            animation: nong-san-slide-right 0.8s ease forwards;
        }

        /* 3. Animation cho từng column con */
        .wp-block-column.is-layout-flow .wp-block-column {
            animation: nong-san-zoom-in 0.6s ease forwards;
        }

        .wp-block-column.is-layout-flow .wp-block-column:nth-child(1) {
            animation-delay: 0.2s;
        }

        .wp-block-column.is-layout-flow .wp-block-column:nth-child(2) {
            animation-delay: 0.4s;
        }

        .wp-block-column.is-layout-flow .wp-block-column:nth-child(3) {
            animation-delay: 0.6s;
        }

        .wp-block-column.is-layout-flow .wp-block-column:nth-child(4) {
            animation-delay: 0.8s;
        }

        /* 4. Animation cho product collection */
        .wc-block-product {
            animation: nong-san-fade-up 0.6s ease forwards;
            opacity: 0;
        }

        .wc-block-product:nth-child(1) { animation-delay: 0.1s; }
        .wc-block-product:nth-child(2) { animation-delay: 0.2s; }
        .wc-block-product:nth-child(3) { animation-delay: 0.3s; }
        .wc-block-product:nth-child(4) { animation-delay: 0.4s; }
        .wc-block-product:nth-child(5) { animation-delay: 0.5s; }
        .wc-block-product:nth-child(6) { animation-delay: 0.6s; }

        /* 5. Hover effect nhẹ cho sản phẩm */
        .wc-block-product:hover {
            transform: translateY(-5px) !important;
            transition: transform 0.3s ease !important;
        }

        /* 6. Animation cho cover image */
        .wp-block-cover__image-background {
            animation: nong-san-zoom-in 1s ease forwards;
        }

        /* 7. Animation cho buttons */
        .wp-block-button__link {
            animation: nong-san-fade-up 0.8s ease forwards;
            animation-delay: 0.5s;
            opacity: 0;
        }

        /* 8. Animation cho heading */
        .wp-block-heading {
            animation: nong-san-slide-left 0.8s ease forwards;
            opacity: 0;
        }

        .wp-block-heading:nth-child(2) {
            animation-delay: 0.2s;
        }

        /* 9. Animation cho paragraphs */
        .wp-block-paragraph {
            animation: nong-san-fade-up 0.8s ease forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }

        /* ============================================================
           MÀU CHỮ TRẮNG - CHỈ CHO COVER VÀ NỀN TỐI
           ============================================================ */

        /* Chữ trắng trên cover block */
        .wp-block-cover .wp-block-cover__inner-container,
        .wp-block-cover .wp-block-cover__inner-container * {
            color: #ffffff !important;
        }

        /* Chữ trắng trên nền tối */
        .wp-block-cover .wp-block-cover__inner-container h1,
        .wp-block-cover .wp-block-cover__inner-container h2,
        .wp-block-cover .wp-block-cover__inner-container h3,
        .wp-block-cover .wp-block-cover__inner-container h4,
        .wp-block-cover .wp-block-cover__inner-container h5,
        .wp-block-cover .wp-block-cover__inner-container h6,
        .wp-block-cover .wp-block-cover__inner-container p,
        .wp-block-cover .wp-block-cover__inner-container span,
        .wp-block-cover .wp-block-cover__inner-container a,
        .wp-block-cover .wp-block-cover__inner-container .wp-block-button__link {
            color: #ffffff !important;
        }

        /* Chữ trắng trên cover light */
        .wp-block-cover.is-light .wp-block-cover__inner-container * {
            color: #ffffff !important;
        }

        /* Chữ trắng cho button khi ở trong cover */
        .wp-block-cover .wp-block-button .wp-block-button__link {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.2) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        .wp-block-cover .wp-block-button .wp-block-button__link:hover {
            background: rgba(255, 255, 255, 0.3) !important;
            transform: scale(1.05) !important;
        }

        /* Chữ trắng trên footer */
        .site-footer,
        .site-footer * {
            color: #ffffff !important;
        }

        .site-footer a {
            color: #a5d6a7 !important;
        }

        .site-footer a:hover {
            color: #ffffff !important;
        }

        /* ============================================================
           RESPONSIVE - ĐIỀU CHỈNH ANIMATION TRÊN MOBILE
           ============================================================ */

        @media (max-width: 768px) {
            .wp-block-columns .wp-block-column:first-child,
            .wp-block-columns .wp-block-column:last-child {
                animation: nong-san-fade-up 0.6s ease forwards;
            }
            
            .wp-block-column.is-layout-flow .wp-block-column {
                animation-delay: 0.1s !important;
            }
            
            .wp-block-heading {
                animation: nong-san-fade-up 0.6s ease forwards;
            }
            
            .wc-block-product {
                animation-delay: 0.05s !important;
            }
            
            .wc-block-product:nth-child(1) { animation-delay: 0.05s !important; }
            .wc-block-product:nth-child(2) { animation-delay: 0.1s !important; }
            .wc-block-product:nth-child(3) { animation-delay: 0.15s !important; }
            .wc-block-product:nth-child(4) { animation-delay: 0.2s !important; }
            .wc-block-product:nth-child(5) { animation-delay: 0.25s !important; }
            .wc-block-product:nth-child(6) { animation-delay: 0.3s !important; }
        }

        @media (max-width: 480px) {
            .wp-block-cover {
                min-height: 200px !important;
            }
            
            .wp-block-heading {
                font-size: 24px !important;
            }
        }

        /* ============================================================
           ĐIỀU CHỈNH THỜI GIAN ANIMATION KHI SCROLL
           ============================================================ */

        /* Giảm delay khi scroll */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        </style>
        <?php
    }

    /**
     * Lấy CSS động từ các tùy chọn - KHÔNG CÒN SỬ DỤNG
     */
    private function get_dynamic_css() {
        // Trả về chuỗi rỗng để không thêm CSS cũ
        return '';
    }

    /**
     * Đăng ký các tùy chọn trong Customizer
     */
    public function register_customizer_options( $wp_customize ) {
        // Thêm section mới
        $wp_customize->add_section( 'nong_san_layout_section', array(
            'title'    => __( 'Layout Trang Chủ', 'nong-san-layout' ),
            'priority' => 30,
        ) );
        
        // Tùy chọn Full Width
        $wp_customize->add_setting( 'nong_san_full_width', array(
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
        ) );
        
        $wp_customize->add_control( 'nong_san_full_width', array(
            'label'    => __( 'Hiển thị Full Width', 'nong-san-layout' ),
            'section'  => 'nong_san_layout_section',
            'type'     => 'checkbox',
            'description' => 'Bỏ chọn để hiển thị layout có giới hạn width',
        ) );
        
        // Tùy chọn kích thước ảnh
        $wp_customize->add_setting( 'nong_san_image_size', array(
            'default'           => 'medium',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        
        $wp_customize->add_control( 'nong_san_image_size', array(
            'label'    => __( 'Kích thước ảnh', 'nong-san-layout' ),
            'section'  => 'nong_san_layout_section',
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Nhỏ',
                'medium'    => 'Trung bình',
                'large'     => 'Lớn',
                'full'      => 'Full',
            ),
        ) );
        
        // Tùy chọn style layout
        $wp_customize->add_setting( 'nong_san_layout_style', array(
            'default'           => 'grid',
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        
        $wp_customize->add_control( 'nong_san_layout_style', array(
            'label'    => __( 'Style layout', 'nong-san-layout' ),
            'section'  => 'nong_san_layout_section',
            'type'     => 'select',
            'choices'  => array(
                'grid'     => 'Lưới đều',
                'masonry'  => 'Masonry',
                'list'     => 'Danh sách',
            ),
        ) );
        
        // Tùy chọn khoảng cách
        $wp_customize->add_setting( 'nong_san_spacing', array(
            'default'           => '20',
            'sanitize_callback' => 'absint',
        ) );
        
        $wp_customize->add_control( 'nong_san_spacing', array(
            'label'    => __( 'Khoảng cách (px)', 'nong-san-layout' ),
            'section'  => 'nong_san_layout_section',
            'type'     => 'number',
            'input_attrs' => array(
                'min'  => 5,
                'max'  => 50,
                'step' => 1,
            ),
        ) );
    }

    /**
     * Thêm class vào body để tùy chỉnh
     */
    public function add_layout_body_class( $classes ) {
        if ( is_front_page() || is_home() ) {
            $classes[] = 'nong-san-full-layout';
        }
        return $classes;
    }

    /**
     * Tùy chỉnh section hero
     */
    public function customize_hero_section( $heading ) {
        return $heading;
    }
}

// Khởi tạo plugin
new Nong_San_Layout_Customizer();

/**
 * Tạo thư mục assets khi kích hoạt plugin
 */
register_activation_hook( __FILE__, 'nong_san_layout_activate' );
function nong_san_layout_activate() {
    $plugin_dir = plugin_dir_path( __FILE__ );
    
    if ( ! file_exists( $plugin_dir . 'assets' ) ) {
        mkdir( $plugin_dir . 'assets', 0755, true );
    }
    
    // Tạo file CSS mặc định nếu chưa có
    $css_file = $plugin_dir . 'assets/layout-style.css';
    if ( ! file_exists( $css_file ) ) {
        $css_content = '/* Nông Sản Layout Customizer - Styles */';
        file_put_contents( $css_file, $css_content );
    }
}