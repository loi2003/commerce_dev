<?php
/**
 * Plugin Name: Side Banners for WooCommerce
 * Plugin URI: https://your-website.com
 * Description: Thêm banner quảng cáo 2 bên cho website WooCommerce
 * Version: 1.0.7
 * Author: Your Name
 * Text Domain: side-banners-woo
 * Domain Path: /languages
 * Requires Plugins: woocommerce
 */

// Ngăn chặn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Định nghĩa hằng số
define('SBW_VERSION', '1.0.7');
define('SBW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SBW_PLUGIN_URL', plugin_dir_url(__FILE__));

// ========== LỚP CHÍNH ==========
class SideBannersWooCommerce {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_footer', array($this, 'display_banners'));
        add_action('admin_notices', array($this, 'check_woocommerce'));
    }
    
    public function check_woocommerce() {
        if (!class_exists('WooCommerce')) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><strong>Side Banners for WooCommerce:</strong> Plugin này yêu cầu WooCommerce được cài đặt và kích hoạt.</p>
            </div>
            <?php
        }
    }
    
    public function init() {
        load_plugin_textdomain('side-banners-woo', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'Side Banners',
            'Side Banners',
            'manage_options',
            'side-banners-woo',
            array($this, 'admin_page'),
            'dashicons-format-image',
            30
        );
        
        add_submenu_page(
            'side-banners-woo',
            'Cài đặt Side Banners',
            'Cài đặt',
            'manage_options',
            'side-banners-woo-settings',
            array($this, 'admin_page')
        );
    }
    
    public function register_settings() {
        register_setting('sbw_settings', 'sbw_left_banner_enabled');
        register_setting('sbw_settings', 'sbw_left_banner_image');
        register_setting('sbw_settings', 'sbw_left_banner_link');
        register_setting('sbw_settings', 'sbw_left_banner_width');
        register_setting('sbw_settings', 'sbw_left_banner_height');
        
        register_setting('sbw_settings', 'sbw_right_banner_enabled');
        register_setting('sbw_settings', 'sbw_right_banner_image');
        register_setting('sbw_settings', 'sbw_right_banner_link');
        register_setting('sbw_settings', 'sbw_right_banner_width');
        register_setting('sbw_settings', 'sbw_right_banner_height');
        
        register_setting('sbw_settings', 'sbw_show_on_mobile');
        register_setting('sbw_settings', 'sbw_show_only_shop');
        register_setting('sbw_settings', 'sbw_banner_position');
        register_setting('sbw_settings', 'sbw_close_button');
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1><span class="dashicons dashicons-format-image"></span> Side Banners for WooCommerce</h1>
            <p>Cấu hình banner quảng cáo 2 bên cho website của bạn.</p>
            
            <form method="post" action="options.php" class="sbw-settings-form">
                <?php settings_fields('sbw_settings'); ?>
                
                <div class="sbw-admin-container">
                    <!-- BANNER TRÁI -->
                    <div class="sbw-section">
                        <h2><span class="dashicons dashicons-arrow-left-alt"></span> Banner bên trái</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Kích hoạt</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="sbw_left_banner_enabled" value="1" <?php checked(get_option('sbw_left_banner_enabled', 1)); ?>>
                                        Hiển thị banner trái
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Hình ảnh banner</th>
                                <td>
                                    <input type="url" name="sbw_left_banner_image" value="<?php echo esc_url(get_option('sbw_left_banner_image', '')); ?>" 
                                           class="sbw-image-input regular-text" placeholder="https://example.com/banner-left.jpg">
                                    <button type="button" class="button sbw-upload-image">Chọn ảnh</button>
                                    <p class="description">Khuyến nghị kích thước: 410x700px</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Link banner</th>
                                <td>
                                    <input type="url" name="sbw_left_banner_link" value="<?php echo esc_url(get_option('sbw_left_banner_link', '#')); ?>" 
                                           class="regular-text" placeholder="https://your-link.com">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kích thước</th>
                                <td>
                                    <input type="number" name="sbw_left_banner_width" value="<?php echo esc_attr(get_option('sbw_left_banner_width', 410)); ?>" 
                                           class="small-text" step="1" min="300" max="550"> px
                                    <span style="margin: 0 10px;">x</span>
                                    <input type="number" name="sbw_left_banner_height" value="<?php echo esc_attr(get_option('sbw_left_banner_height', 700)); ?>" 
                                           class="small-text" step="1" min="400" max="900"> px
                                    <p class="description">Chiều rộng: 300-550px | Chiều cao: 400-900px</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- BANNER PHẢI -->
                    <div class="sbw-section">
                        <h2><span class="dashicons dashicons-arrow-right-alt"></span> Banner bên phải</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Kích hoạt</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="sbw_right_banner_enabled" value="1" <?php checked(get_option('sbw_right_banner_enabled', 1)); ?>>
                                        Hiển thị banner phải
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Hình ảnh banner</th>
                                <td>
                                    <input type="url" name="sbw_right_banner_image" value="<?php echo esc_url(get_option('sbw_right_banner_image', '')); ?>" 
                                           class="sbw-image-input regular-text" placeholder="https://example.com/banner-right.jpg">
                                    <button type="button" class="button sbw-upload-image">Chọn ảnh</button>
                                    <p class="description">Khuyến nghị kích thước: 410x700px</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Link banner</th>
                                <td>
                                    <input type="url" name="sbw_right_banner_link" value="<?php echo esc_url(get_option('sbw_right_banner_link', '#')); ?>" 
                                           class="regular-text" placeholder="https://your-link.com">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kích thước</th>
                                <td>
                                    <input type="number" name="sbw_right_banner_width" value="<?php echo esc_attr(get_option('sbw_right_banner_width', 410)); ?>" 
                                           class="small-text" step="1" min="300" max="550"> px
                                    <span style="margin: 0 10px;">x</span>
                                    <input type="number" name="sbw_right_banner_height" value="<?php echo esc_attr(get_option('sbw_right_banner_height', 700)); ?>" 
                                           class="small-text" step="1" min="400" max="900"> px
                                    <p class="description">Chiều rộng: 300-550px | Chiều cao: 400-900px</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- CÀI ĐẶT CHUNG -->
                    <div class="sbw-section">
                        <h2><span class="dashicons dashicons-admin-settings"></span> Cài đặt chung</h2>
                        <table class="form-table">
                            <tr>
                                <th scope="row">Hiển thị trên Mobile</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="sbw_show_on_mobile" value="1" <?php checked(get_option('sbw_show_on_mobile', 0)); ?>>
                                        Hiển thị banner trên thiết bị di động
                                    </label>
                                    <p class="description">Không khuyến khích vì chiếm diện tích màn hình</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Chỉ hiển thị trên Shop</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="sbw_show_only_shop" value="1" <?php checked(get_option('sbw_show_only_shop', 0)); ?>>
                                        Chỉ hiển thị trên trang Shop và sản phẩm
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Vị trí banner</th>
                                <td>
                                    <select name="sbw_banner_position">
                                        <option value="middle" <?php selected(get_option('sbw_banner_position', 'middle'), 'middle'); ?>>Giữa màn hình</option>
                                        <option value="top" <?php selected(get_option('sbw_banner_position', 'middle'), 'top'); ?>>Đầu trang</option>
                                        <option value="bottom" <?php selected(get_option('sbw_banner_position', 'middle'), 'bottom'); ?>>Cuối trang</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Nút đóng banner</th>
                                <td>
                                    <label>
                                        <input type="checkbox" name="sbw_close_button" value="1" <?php checked(get_option('sbw_close_button', 1)); ?>>
                                        Hiển thị nút đóng banner
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php submit_button('Lưu cài đặt', 'primary', 'submit', true); ?>
            </form>
        </div>
        
        <style>
        .sbw-admin-container {
            max-width: 900px;
        }
        .sbw-section {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .sbw-section h2 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        .sbw-section h2 .dashicons {
            font-size: 24px;
            width: 24px;
            height: 24px;
            vertical-align: middle;
        }
        .sbw-image-input {
            width: 70% !important;
        }
        .sbw-settings-form .form-table th {
            width: 150px;
        }
        .sbw-settings-form .description {
            color: #666;
            font-style: italic;
            margin-top: 5px;
        }
        .sbw-settings-form .small-text {
            width: 80px !important;
        }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            $('.sbw-upload-image').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var input = button.siblings('.sbw-image-input');
                
                var mediaUploader = wp.media({
                    title: 'Chọn ảnh banner',
                    button: {
                        text: 'Chọn ảnh'
                    },
                    multiple: false
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    input.val(attachment.url);
                });
                
                mediaUploader.open();
            });
        });
        </script>
        <?php
    }
    
    public function enqueue_scripts() {
        if ($this->should_display_banners()) {
            wp_enqueue_style(
                'sbw-banner-style',
                SBW_PLUGIN_URL . 'assets/banner-style.css',
                array(),
                SBW_VERSION
            );
            
            wp_enqueue_script(
                'sbw-banner-script',
                SBW_PLUGIN_URL . 'assets/banner-script.js',
                array('jquery'),
                SBW_VERSION,
                true
            );
            
            wp_localize_script('sbw-banner-script', 'sbw_data', array(
                'close_button' => get_option('sbw_close_button', 1),
                'left_enabled' => get_option('sbw_left_banner_enabled', 1),
                'right_enabled' => get_option('sbw_right_banner_enabled', 1)
            ));
        }
    }
    
    private function should_display_banners() {
        if (!class_exists('WooCommerce')) {
            return false;
        }
        
        if (!get_option('sbw_show_on_mobile', 0) && wp_is_mobile()) {
            return false;
        }
        
        if (get_option('sbw_show_only_shop', 0)) {
            return is_shop() || is_product_category() || is_product_tag() || is_singular('product');
        }
        
        return true;
    }
    
    public function display_banners() {
        if (!$this->should_display_banners()) {
            return;
        }
        
        $left_enabled = get_option('sbw_left_banner_enabled', 1);
        $right_enabled = get_option('sbw_right_banner_enabled', 1);
        
        $left_image = get_option('sbw_left_banner_image', '');
        $left_link = get_option('sbw_left_banner_link', '#');
        // Kích thước: 410x700px
        $left_width = min(max(get_option('sbw_left_banner_width', 410), 300), 550);
        $left_height = min(max(get_option('sbw_left_banner_height', 700), 400), 900);
        
        $right_image = get_option('sbw_right_banner_image', '');
        $right_link = get_option('sbw_right_banner_link', '#');
        $right_width = min(max(get_option('sbw_right_banner_width', 410), 300), 550);
        $right_height = min(max(get_option('sbw_right_banner_height', 700), 400), 900);
        
        $position = get_option('sbw_banner_position', 'middle');
        $close_button = get_option('sbw_close_button', 1);
        
        $position_class = 'sbw-position-' . $position;
        
        ?>
        <div class="sbw-banners-wrapper <?php echo esc_attr($position_class); ?>">
            
            <!-- Banner trái -->
            <?php if ($left_enabled && !empty($left_image)) : ?>
            <div class="sbw-banner sbw-banner-left" id="sbw-left-banner">
                <div class="sbw-banner-inner">
                    <a href="<?php echo esc_url($left_link); ?>" target="_blank" rel="nofollow">
                        <img src="<?php echo esc_url($left_image); ?>" 
                             alt="Banner quảng cáo trái" 
                             width="<?php echo esc_attr($left_width); ?>" 
                             height="<?php echo esc_attr($left_height); ?>"
                             loading="lazy">
                    </a>
                    <?php if ($close_button) : ?>
                    <button class="sbw-close-btn" data-banner="left" aria-label="Đóng banner trái">×</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Banner phải -->
            <?php if ($right_enabled && !empty($right_image)) : ?>
            <div class="sbw-banner sbw-banner-right" id="sbw-right-banner">
                <div class="sbw-banner-inner">
                    <a href="<?php echo esc_url($right_link); ?>" target="_blank" rel="nofollow">
                        <img src="<?php echo esc_url($right_image); ?>" 
                             alt="Banner quảng cáo phải" 
                             width="<?php echo esc_attr($right_width); ?>" 
                             height="<?php echo esc_attr($right_height); ?>"
                             loading="lazy">
                    </a>
                    <?php if ($close_button) : ?>
                    <button class="sbw-close-btn" data-banner="right" aria-label="Đóng banner phải">×</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
        <?php
    }
}

// ========== KHỞI CHẠY PLUGIN ==========
function init_side_banners_woo() {
    return SideBannersWooCommerce::get_instance();
}
add_action('plugins_loaded', 'init_side_banners_woo');