<?php
// includes/admin-notification.php
if ( ! defined( 'ABSPATH' ) ) exit;

class Admin_Order_Notification {

    public function __construct() {
        add_action( 'woocommerce_new_order', array( $this, 'send_admin_notification' ), 10, 1 );
    }

    public function send_admin_notification( $order_id ) {
        $order = wc_get_order( $order_id );
        if ( ! $order ) return;

        $order_number = $order->get_order_number();
        $order_total  = $order->get_total();
        $currency     = $order->get_currency();
        $order_date   = $order->get_date_created()->date_i18n( 'd/m/Y H:i:s' );

        $customer_name  = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $customer_email = $order->get_billing_email();
        $customer_phone = $order->get_billing_phone();

        // Build items list with raw amounts (no HTML)
        $items_text = '';
        foreach ( $order->get_items() as $item ) {
            $product_name = $item->get_name();
            $quantity     = $item->get_quantity();
            $subtotal     = $item->get_subtotal(); // raw number
            $subtotal_formatted = number_format( $subtotal, 0, ',', '.' ) . ' VND';
            $items_text .= " - {$product_name} x {$quantity} = {$subtotal_formatted}\n";
        }

        $total_formatted = number_format( $order_total, 0, ',', '.' ) . ' VND';

        $subject = sprintf( '[Đơn hàng mới] #%s từ %s', $order_number, $customer_name );

        $message = "Xin chào Admin,\n\n";
        $message .= "Có một đơn hàng mới vừa được tạo:\n\n";
        $message .= "----------------------------------------\n";
        $message .= "Mã đơn hàng: #{$order_number}\n";
        $message .= "Ngày đặt:   {$order_date}\n";
        $message .= "Khách hàng: {$customer_name}\n";
        $message .= "Email:      {$customer_email}\n";
        $message .= "SĐT:        {$customer_phone}\n";
        $message .= "----------------------------------------\n\n";
        $message .= "Chi tiết sản phẩm:\n";
        $message .= $items_text;
        $message .= "\n----------------------------------------\n";
        $message .= "Tổng cộng: {$total_formatted}\n";
        $message .= "----------------------------------------\n\n";
        $message .= "Vui lòng kiểm tra và xử lý đơn hàng.\n";
        $message .= "Cảm ơn bạn!";

        $admin_email = get_option( 'admin_email' );
        $headers = array( 'Content-Type: text/plain; charset=UTF-8' );
        wp_mail( $admin_email, $subject, $message, $headers );
    }
}

new Admin_Order_Notification();