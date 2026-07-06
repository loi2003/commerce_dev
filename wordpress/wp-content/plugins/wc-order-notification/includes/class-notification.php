<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_Order_Notification {

    public function __construct() {
        // Gửi email khi đơn hàng được tạo (new order)
        add_action( 'woocommerce_new_order', array( $this, 'send_order_notification' ), 10, 1 );
        
        // Hoặc gửi khi trạng thái đơn hàng chuyển sang "completed" (thanh toán thành công)
        // add_action( 'woocommerce_order_status_completed', array( $this, 'send_order_notification' ), 10, 1 );
        
        // Nếu muốn gửi cả hai (tránh trùng lặp, bạn có thể dùng 1 hook)
    }

    /**
     * Gửi email xác nhận đơn hàng cho khách hàng
     *
     * @param int $order_id
     */
    public function send_order_notification( $order_id ) {
        $order = wc_get_order( $order_id );
        if ( ! $order ) {
            return;
        }

        // Lấy email và tên khách hàng
        $customer_email = $order->get_billing_email();
        $customer_name  = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        
        if ( empty( $customer_email ) ) {
            return;
        }

        // Lấy danh sách sản phẩm trong đơn hàng
        $items = $order->get_items();
        $items_html = '';
        $subtotal = 0;

        foreach ( $items as $item ) {
            $product_name = $item->get_name();
            $quantity     = $item->get_quantity();
            $item_total   = $item->get_total(); // tổng tiền từng sản phẩm (đã bao gồm thuế nếu có)
            $price        = $item->get_total() / $quantity; // giá mỗi sản phẩm (có thể dùng get_subtotal nếu muốn chưa thuế)

            $items_html .= sprintf(
                '- %s x %d = %s<br>',
                esc_html( $product_name ),
                $quantity,
                wc_price( $item_total )
            );
            $subtotal += $item_total;
        }

        // Tính tổng đơn hàng (bao gồm phí ship, thuế, giảm giá)
        $total = $order->get_total();

        // Nội dung email
        $subject = sprintf( 'Cảm ơn bạn đã đặt hàng tại %s!', get_bloginfo( 'name' ) );

        $message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
                h2 { color: #333; }
                .order-details { background: #f9f9f9; padding: 15px; border-radius: 5px; }
                .total { font-size: 18px; font-weight: bold; color: #e67e22; }
                .footer { margin-top: 20px; font-size: 14px; color: #777; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Xin chào {$customer_name},</h2>
                <p>Cảm ơn bạn đã mua sắm tại <strong>" . get_bloginfo( 'name' ) . "</strong>!</p>
                <p>Đơn hàng của bạn đã được đặt thành công với mã số: <strong>#{$order_id}</strong>.</p>
                
                <h3>Chi tiết đơn hàng:</h3>
                <div class='order-details'>
                    {$items_html}
                    <hr>
                    <p><strong>Tổng cộng:</strong> <span class='total'>" . wc_price( $total ) . "</span></p>
                </div>

                <p>Chúng tôi sẽ xử lý và giao hàng cho bạn trong thời gian sớm nhất.</p>
                <p>Mọi thắc mắc xin vui lòng liên hệ với chúng tôi qua email hỗ trợ.</p>
                <div class='footer'>
                    Trân trọng,<br>
                    Đội ngũ <a href='" . home_url() . "'>" . get_bloginfo( 'name' ) . "</a>
                </div>
            </div>
        </body>
        </html>
        ";

        // Gửi email qua wp_mail
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        wp_mail( $customer_email, $subject, $message, $headers );

        // (Tùy chọn) Ghi log để debug
        // error_log( 'Order notification sent to ' . $customer_email . ' for order #' . $order_id );
    }
}