<?php
if ( ! defined( 'ABSPATH' ) ) exit;
require_once __DIR__ . '/db-audit.php';

class Audit_Log_Main {
    private $db;
    private $logged_events = [];

    public function __construct() {
        $this->db = new AuditLogDB_Audit();
        register_activation_hook( AUDIT_LOG_PLUGIN_FILE, [$this, 'activate'] );
        add_action( 'init', [$this, 'init_hooks'] );
        add_action( 'admin_menu', [$this, 'add_admin_menu'] );
    }

    public function activate() {
        $this->db->create_table();
    }

    public function init_hooks() {
        if ( class_exists( 'WooCommerce' ) ) {
            add_action( 'woocommerce_created_product', [$this, 'log_new_product'], 10, 1 );
            add_action( 'woocommerce_update_product', [$this, 'log_update_product'], 10, 1 );
            add_action( 'woocommerce_delete_product', [$this, 'log_delete_product'], 10, 1 );
            add_action( 'woocommerce_new_order', [$this, 'log_new_order'], 10, 1 );
            add_action( 'woocommerce_order_status_changed', [$this, 'log_order_status_change'], 10, 3 );
            add_action( 'woocommerce_add_to_cart', [$this, 'log_add_to_cart'], 10, 6 );
            add_action( 'woocommerce_before_single_product', [$this, 'log_view_product'], 10, 0 );
        }
        add_action( 'pre_get_posts', [$this, 'log_search'], 10, 1 );
    }

    private function insert_log( $user_id, $action, $object_type, $object_id = null, $details = null ) {
        $key = $user_id . '_' . $action . '_' . $object_type . '_' . $object_id . '_' . md5( $details );
        if ( in_array( $key, $this->logged_events ) ) return;
        $this->logged_events[] = $key;

        $user = $user_id ? get_userdata( $user_id ) : null;
        $user_email = $user ? $user->user_email : '';

        $ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : '';
        $agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '';

        $data = [
            'user_id'     => $user_id,
            'user_email'  => $user_email,
            'action'      => $action,
            'object_type' => $object_type,
            'object_id'   => $object_id,
            'details'     => $details,
            'ip_address'  => $ip,
            'user_agent'  => $agent,
        ];
        $this->db->insert( $data );
    }

    // Log methods
    public function log_new_product( $product_id ) {
        $this->insert_log( get_current_user_id(), 'new_product', 'product', $product_id, "Tạo SP ID {$product_id}" );
    }
    public function log_update_product( $product_id ) {
        $this->insert_log( get_current_user_id(), 'update_product', 'product', $product_id, "Cập nhật SP ID {$product_id}" );
    }
    public function log_delete_product( $product_id ) {
        $this->insert_log( get_current_user_id(), 'delete_product', 'product', $product_id, "Xóa SP ID {$product_id}" );
    }
    public function log_new_order( $order_id ) {
        $this->insert_log( get_current_user_id(), 'new_order', 'order', $order_id, "Tạo đơn hàng #{$order_id}" );
    }
    public function log_order_status_change( $order_id, $old_status, $new_status ) {
        $this->insert_log( get_current_user_id(), 'order_status_change', 'order', $order_id, "Thay đổi trạng thái từ {$old_status} sang {$new_status}" );
    }
    public function log_add_to_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
        $details = "Thêm SP ID {$product_id}, số lượng {$quantity}";
        if ( $variation_id ) $details .= ", biến thể ID {$variation_id}";
        $this->insert_log( get_current_user_id(), 'add_to_cart', 'product', $product_id, $details );
    }
    public function log_view_product() {
        global $product;
        if ( ! $product ) return;
        $this->insert_log( get_current_user_id(), 'view_product', 'product', $product->get_id(), "Xem chi tiết SP ID {$product->get_id()}" );
    }
    public function log_search( $query ) {
        if ( is_admin() || ! $query->is_search() || ! $query->is_main_query() ) return;
        $search_term = $query->get( 's' );
        if ( empty( $search_term ) ) return;
        $this->insert_log( get_current_user_id(), 'search', 'search', 0, "Tìm kiếm từ khóa: " . esc_sql( $search_term ) );
    }

    public function add_admin_menu() {
        add_menu_page(
            'Audit Log',
            'Audit Log',
            'manage_options',
            'audit-log-service',
            [$this, 'render_admin_page'],
            'dashicons-clipboard',
            30
        );
    }

    public function render_admin_page() {
        $filters = [
            'user_email' => isset( $_GET['user_email'] ) ? sanitize_text_field( $_GET['user_email'] ) : '',
            'action'     => isset( $_GET['action'] ) ? sanitize_text_field( $_GET['action'] ) : '',
            'from_date'  => isset( $_GET['from_date'] ) ? sanitize_text_field( $_GET['from_date'] ) : '',
            'to_date'    => isset( $_GET['to_date'] ) ? sanitize_text_field( $_GET['to_date'] ) : '',
        ];

        $page = isset( $_GET['paged'] ) ? max( 1, intval( $_GET['paged'] ) ) : 1;
        $per_page = 20;
        $offset = ( $page - 1 ) * $per_page;

        $logs = $this->db->get_logs( $filters, $per_page, $offset );
        $total = $this->db->count_logs( $filters );
        $total_pages = ceil( $total / $per_page );

        $actions = $this->db->get_distinct_actions();
        $auth_users = $this->db->get_users_from_auth_db();

        include AUDIT_LOG_PLUGIN_DIR . 'views/admin-page-audit.php';
    }
}