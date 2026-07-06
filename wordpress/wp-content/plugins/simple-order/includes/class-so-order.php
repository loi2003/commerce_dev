<?php

class SO_Order
{
    public function __construct()
    {
        add_action(
            'wp_ajax_so_create_order',
            [$this, 'ajax_create_order']
        );

        add_action(
            'wp_ajax_nopriv_so_create_order',
            [$this, 'ajax_create_order']
        );
    }

    public function create_order_from_cart()
    {
        if (empty($_SESSION['sa_user']['wp_user_id'])) {
            return new WP_Error('auth', 'User not logged in');
        }

        $wp_user_id = (int) $_SESSION['sa_user']['wp_user_id'];

        if (!$wp_user_id) {
            return new WP_Error('auth', 'User not logged in');
        }

        $order = wc_create_order([
            'customer_id' => $wp_user_id
        ]);

        foreach (WC()->cart->get_cart() as $item) {
            $order->add_product($item['data'], $item['quantity']);
        }

        $order->calculate_totals();
        WC()->cart->empty_cart();

        return $order->get_id();
    }

    public function ajax_create_order()
    {
        $order_id = $this->create_order_from_cart();

        if (is_wp_error($order_id)) {

        wp_send_json_error([
            'message' => $order_id->get_error_message()
        ]);
        }

        wp_send_json_success([
            'order_id' => $order_id
        ]);
    }   
}
